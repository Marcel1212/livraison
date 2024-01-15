<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateCode as Gencode;
use App\Models\CahierPlanFormation;
use App\Models\LigneCahierPlanFormation;
use App\Models\PlanFormation;
use App\Helpers\Crypt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use App\Models\ComitePermanenteParticipant;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Helpers\ConseillerParAgence;
use App\Models\ActionFormationPlan;

class CahierplanformationController extends Controller
{
    public function index(){

        $cahiers = CahierPlanFormation::all();

        return view("cahierplanformation.index", compact("cahiers"));
    }

    public function create(){

        return view("cahierplanformation.create");

    }

    public function store(Request $request){

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'code_pieces_cahier_plan_formation' => 'required',
            ],[
                'code_pieces_cahier_plan_formation.required' => 'Veuillez sélectionner le type entreprise.',
            ]);

            $input = $request->all();
            $input['id_users_cahier_plan_formation'] = Auth::user()->id;
            $input['date_creer_cahier_plan_formation'] = Carbon::now();
            $input[''] = $input['code_pieces_cahier_plan_formation']. '-' . Gencode::randStrGen(4, 5) .'_'. Carbon::now()->format('Y');
            $cahier =  CahierPlanFormation::create($input);

            return redirect('cahierplanformation/'.Crypt::UrlCrypt($cahier->id_cahier_plan_formation).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');

        }
    }


    public function edit($id, $id1){

        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);


        $cahier = CahierPlanFormation::find($id);

        $cahierplansformations = LigneCahierPlanFormation::join('plan_formation','ligne_cahier_plan_formation.id_plan_formation','plan_formation.id_plan_de_formation')
                            ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','plan_formation.user_conseiller','=','users.id')
                            ->where([['ligne_cahier_plan_formation.id_cahier_plan_formation','=',$cahier->id_cahier_plan_formation]])->get();

        $planformations = PlanFormation::where([['flag_plan_formation_valider_par_processus','=',true],['flag_plan_formation_valider_cahier','=',false]])->get();

        //dd($planformations);


        return view('cahierplanformation.edit', compact('cahier','id','idetape','planformations','cahierplansformations'));
    }

    public function editer($id,$id2,$id3)
    {
        $id = Crypt::UrldeCrypt($id);
        $idcomite = Crypt::UrldeCrypt($id2);
        $idetape = Crypt::UrldeCrypt($id3);
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

        $motifs = Motif::where([['code_motif','=','CTPAF']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*','secteur_activite.id_secteur_activite as id_secteur_activitee','secteur_activite.libelle_secteur_activite')
                                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                                        ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
                                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                                        ->join('secteur_activite','action_formation_plan.id_secteur_activite','=','secteur_activite.id_secteur_activite')
                                        ->where([['action_formation_plan.id_plan_de_formation','=',$id]])->get();

        //dd($infosactionplanformations);

        $nombreaction = count($actionplanformations);

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$id],['flag_valide_action_formation_pl_comite_permanente','=',true]])->get();
        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$id],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();

        $nombreactionvalider = count($actionvalider);
        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);
        //dd($nombreactionvalider);

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

        $montantactionplanformation = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformation += $actionplanformation->cout_action_formation_plan;
        }

        $montantactionplanformationacc = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformationacc += $actionplanformation->cout_accorde_action_formation;
        }


        return view('cahierplanformation.editer', compact(
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','idcomite','id','idetape','idcomite','montantactionplanformation','montantactionplanformationacc'
        ));

    }

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

        return view('comitepermanente.show', compact('actionplan','ficheagrement', 'beneficiaires','planformation'));
    }

    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'code_pieces_cahier_plan_formation' => 'required',
                ],[
                    'code_pieces_cahier_plan_formation.required' => 'Veuillez sélectionner le type entreprise.',
                ]);


                $input = $request->all();
                $input['id_users_cahier_plan_formation'] = Auth::user()->id;
                //$input['date_creer_cahier_plan_formation'] = Carbon::now();
                $input['code_cahier_plan_formation'] = $input['code_pieces_cahier_plan_formation']. '-' . Gencode::randStrGen(4, 5) .'_'. Carbon::now()->format('Y');
                $comitegestion = CahierPlanFormation::find($id);
                $comitegestion->update($input);

                return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Traiter_cahier_plan'){



                $input = $request->all();
                //dd($input);exit;

                $verifnombre = count($input['planformation']);

                //dd($verifnombre);exit;

                if($verifnombre < 1){

                    return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins un plan de formation. ');

                }

                $tab = $input['planformation'];

                foreach ($tab as $key => $value) {

                    //dd($value); exit;

                    LigneCahierPlanFormation::create([
                        'id_cahier_plan_formation'=> $id,
                        'id_plan_formation'=> $value
                    ]);

                    PlanFormation::where('id_plan_de_formation', $value)->update([
                        'flag_plan_formation_valider_cahier'=> true
                    ]);

                }


                return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


            }

            if ($data['action'] == 'Traiter_cahier_plan_soumis'){

                $comitegestion = CahierPlanFormation::find($id);
                $lignecahierplanformation = LigneCahierPlanFormation::where([['id_cahier_plan_formation','=',$id]])->get();

                foreach ($lignecahierplanformation as $key => $value) {

                    PlanFormation::where('id_plan_de_formation', $value->id_plan_formation)->update([
                        'flag_plan_formation_valider_cahier_soumis_comite_permanente'=> true
                    ]);
                }

                $comitegestion->update(['flag_statut_cahier_plan_formation'=> true,'date_soumis_cahier_plan_formation'=>Carbon::now()]);

                return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

        }
    }

    public function etat($id){

    }
}
