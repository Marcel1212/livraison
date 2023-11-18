<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activites;
use App\Models\CentreImpot;
use App\Models\Localite;
use App\Models\Pays;
use App\Models\DemandeEnrolement;
use App\Models\Entreprises;
use App\Models\PlanFormation;
use App\Models\ActionFormationPlan;
use App\Models\FicheADemandeAgrement;
use App\Models\BeneficiairesFormation;
use App\Models\TypeEntreprise;
use App\Models\ButFormation;
use App\Models\CategorieProfessionelle;
use App\Models\CategoriePlan;
use App\Models\TypeFormation;
use App\Models\Motif; 
use App\Helpers\Crypt;
use App\Helpers\Menu;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;
use Rap2hpoutre\FastExcel\FastExcel;

class TratementPlanFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planformations = PlanFormation::all();
        return view('traitementplanformation.index',compact('planformations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $idVal = Crypt::UrldeCrypt($id);
        $actionplan = null;
        $ficheagrement = null;
        $beneficiaires = null;
        $planformation = null;

        if ($idVal != null) {
            $actionplan = ActionFormationPlan::find($idVal);
            $ficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->first();
            $beneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();
            $planformation = PlanFormation::where([['id_plan_de_formation','=',$actionplan->id_plan_de_formation]])->first();
        } 
             
        return view('traitementplanformation.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $id =  Crypt::UrldeCrypt($id);
//dd($id);
        $planformation = PlanFormation::find($id);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $typeentreprises = TypeEntreprise::all();
        $typeentreprise = "<option value='".$planformation->typeEntreprise->id_type_entreprise."'>".$planformation->typeEntreprise->lielle_type_entrepise." </option>";
        foreach ($typeentreprises as $comp) {
            $typeentreprise .= "<option value='" . $comp->id_type_entreprise  . "'>" . mb_strtoupper($comp->lielle_type_entrepise) ." </option>";
        }


        $pays = Pays::all();
        $pay = "<option value='".@$infoentreprise->pay->id_pays."'> " . @$infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        } 
        
        $butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }        
        
        $typeformations = TypeFormation::all();
        $typeformation = "<option value=''> Selectionnez le type  de la formation </option>";
        foreach ($typeformations as $comp) {
            $typeformation .= "<option value='" . $comp->id_type_formation  . "'>" . mb_strtoupper($comp->type_formation) ." </option>";
        }        
        
        $categorieprofessionelles = CategorieProfessionelle::all();
        $categorieprofessionelle = "<option value=''> Selectionnez la categorie </option>";
        foreach ($categorieprofessionelles as $comp) {
            $categorieprofessionelle .= "<option value='" . $comp->id_categorie_professionelle  . "'>" . mb_strtoupper($comp->categorie_profeessionnelle) ." </option>";
        }

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id]])->get();

        $motifs = Motif::all();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*')
                                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                                        ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
                                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                                        ->where([['action_formation_plan.id_plan_de_formation','=',$id]])->get();

        //dd($infosactionplanformations);

        $nombreaction = count($actionplanformations);

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$id],['flag_valide_action_formation_pl','=',true]])->get();

        $nombreactionvalider = count($actionvalider);

        return view('traitementplanformation.edit', compact('planformation','infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations','nombreaction','nombreactionvalider'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        if ($request->isMethod('put')) {
            $data = $request->all();

            if($data['action'] === 'Recevable'){
                $this->validate($request, [
                    'id_motif_recevable' => 'required'
                ],[
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);
                
                $input = $request->all();
                $dateanneeencours = Carbon::now()->format('Y');
                $input['id_user'] = Auth::user()->id;
                $input['user_conseiller'] = Auth::user()->id;
                $input['flag_recevablite_plan_formation'] = true;
                $input['conde_entreprise_plan_formation'] = 'fdfpentre' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
                $input['code_plan_formation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                $input['date_recevabilite_plan_formatio'] = Carbon::now();

                $planformation = PlanFormation::find($id);
                $planformation->update($input); 
                
                return redirect()->route('traitementplanformation.index')->with('success', 'Recevabilité effectué avec succès.');
            }

            if($data['action'] === 'NonRecevable'){

                $this->validate($request, [
                    'id_motif_recevable' => 'required'
                ],[
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);
                
                $input = $request->all();
                $dateanneeencours = Carbon::now()->format('Y');
                $input['id_user'] = Auth::user()->id;
                $input['user_conseiller'] = Auth::user()->id;
                $input['flag_recevablite_plan_formation'] = true;
                $input['flag_rejeter_plan_formation'] = true;
                $input['conde_entreprise_plan_formation'] = 'fdfpentre' . Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                $input['code_plan_formation'] = substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                $input['date_recevabilite_plan_formatio'] = Carbon::now();
                $input['date_rejet_paln_formation'] = Carbon::now();

                $planformation = PlanFormation::find($id);
                $planformation->update($input);

                $planformation1 = PlanFormation::find($id);

                $infoentreprise = Entreprises::find($planformation1->id_entreprises);

                if (isset($planformation1->email_professionnel_charge_plan_formation)) {
                    $sujet = "Recevabilité du plan de formation sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  $infoentreprise->raison_social_entreprises ,</b>
                                    <br><br>Nous avons examiné votre paln de formation sur e-FDFP, et 
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :
                                    
                                    <br><b>Motif de rejet  : </b> @$planformation1->motif->libelle_motif
                                    <br><b>Commentaire : </b> @$planformation1->commentaire_recevable_plan_formation
                                    <br><br>
                                    <br><br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à 
                                        fournir, n'hésitez pas à nous contacter à [Adresse e-mail du support] pour obtenir de l'aide.
                                        Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de 
                                        soumettre une nouvelle demande lorsque les problèmes seront résolus.
                                        Cordialement,
                                        L'équipe e-FDFP
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($planformation1->planformation1, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
                }
                
                return redirect()->route('traitementplanformation.index')->with('success', 'Recevabilité effectué avec succès.');

            }
            
            if($data['action'] === 'Traiter_action_formation'){

                $actionplan = ActionFormationPlan::find($id);

                $idplan = $actionplan->id_plan_de_formation;

                //dd($idplan);

                $this->validate($request, [
                    'cout_accorde_action_formation' => 'required',
                    'commentaire_action_formation' => 'required',
                ],[
                    'cout_accorde_action_formation.required' => 'Veuillez ajouter le montant accordé.',
                    'commentaire_action_formation.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();

                if($input['cout_accorde_action_formation']==0){

                    $this->validate($request, [
                        'motif_non_financement_action_formation' => 'required'
                    ],[
                        'motif_non_financement_action_formation.required' => 'Veuillez selectionnez le motif de non financement.',
                    ]);

                    $input['flag_valide_action_formation_pl'] = true;

                    $actionplanupdate = ActionFormationPlan::find($id);
                    $actionplanupdate->update($input);

                }else{

                    $input['flag_valide_action_formation_pl'] = true;

                    $actionplanupdate = ActionFormationPlan::find($id);
                    $actionplanupdate->update($input);

                }

                return redirect('traitementplanformation/'.Crypt::UrlCrypt($idplan).'/edit')->with('success', 'Succes : Action de plan de formation Traité ');
            }   

            if($data['action'] === 'Soumission_ct_plan_formation'){

                PlanFormation::where('id_plan_de_formation',$id)->update([
                    'flag_soumis_ct_plan_formation' => true,
                    'date_soumis_ct_plan_formation' => Carbon::now()
                ]);
                
                return redirect()->route('traitementplanformation.index')->with('success', 'Succes : Plan de formation soumis ');

            }

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
