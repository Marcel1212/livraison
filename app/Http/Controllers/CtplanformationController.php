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
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\PlanFormationAValiderParUser;
use App\Models\CtPleniere;
use App\Models\Motif;
use App\Helpers\Crypt;
use App\Helpers\Menu;
use App\Helpers\Email;
use App\Helpers\ConseillerParAgence;
use App\Helpers\GenerateCode as Gencode;
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;

class CtplanformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nacodes = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($nacodes);
        if($nacodes === "CONSEILLER"){
            $planformations = PlanFormation::leftJoin('plan_formation_a_valider_par_user', 'plan_formation.id_plan_de_formation', '=', 'plan_formation_a_valider_par_user.id_plan_formation')->
            where([['flag_soumis_ct_plan_formation','=',true],['flag_valide_action_des_plan_formation','=',false],['flag_plan_validation_rejeter_par_comite_en_ligne','=',false]])->get();
            //$planformations = PlanFormation::where([['user_conseiller','=',Auth::user()->id],['flag_soumis_ct_plan_formation','=',true]])->get();
        }else{
            $planformations = PlanFormation::where([['flag_soumis_ct_plan_formation','=',true],['flag_valide_action_des_plan_formation','=',false],['flag_plan_validation_rejeter_par_comite_en_ligne','=',false]])->get();
        }

        //dd($planformations);

        return view('ctplanformation.index',compact('planformations'));
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

        return view('ctplanformation.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
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
        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$id],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();

        $nombreactionvalider = count($actionvalider);
        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);

        return view('ctplanformation.edit', compact('planformation','infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations','nombreaction','nombreactionvalider','nombreactionvaliderparconseiller'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        $NumAgce = Auth::user()->num_agce;
        $conseilleragence = ConseillerParAgence::get_conseiller_par_agence($NumAgce);
        $nombredeconseilleragence = count($conseilleragence);

        if ($request->isMethod('put')) {

            $data = $request->all();

            //dd($data);

            if($data['action'] === 'Traiter_action_formation_valider'){

                $actionplan = ActionFormationPlan::find($id);

                $idplan = $actionplan->id_plan_de_formation;

                $this->validate($request, [
                    'id_motif' => 'required',
                ],[
                    'id_motif.required' => 'Veuillez ajouter le motif.',
                ]);

                $input = $request->all();

                $input = $request->all();

                $input['flag_valide_action_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_action_plan_formation'] = $id;
                $input['id_plan_formation'] = $idplan;

                ActionPlanFormationAValiderParUser::create($input);

                //$nbreactionvalide = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['id_plan_formation','=',$idplan]])->get();

                return redirect('ctplanformation/'.Crypt::UrlCrypt($idplan).'/edit')->with('success', 'Succes : Action de plan de formation Traité ');

            }

            if($data['action'] === 'Traiter_action_formation_valider_plan'){

                //$actionplan = ActionFormationPlan::find($id);

                $idplan = $id;

                $input = $request->all();

                $input = $request->all();

                $input['flag_valide_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_plan_formation'] = $idplan;
                $input['date_valide_plan_formation'] = Carbon::now();

                PlanFormationAValiderParUser::create($input);

                $nbreplanvalide = PlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['flag_valide_plan_formation','=',true]])->get();
                $nbrav = count($nbreplanvalide);
                if($nbrav == $nombredeconseilleragence){
                    $plan = PlanFormation::find($idplan);
                    $plan->update([
                        'id_processus' => 1,
                        'flag_valide_action_des_plan_formation' => true,
                        'flag_plan_validation_valider_par_comite_en_ligne' => true
                    ]);
                }
                return redirect('ctplanformation/'.Crypt::UrlCrypt($idplan).'/edit')->with('success', 'Succes : Les actions ont été validée ');


            }

            if($data['action'] === 'Traiter_action_formation_rejeter'){

                $actionplan = ActionFormationPlan::find($id);

                $idplan = $actionplan->id_plan_de_formation;

                $this->validate($request, [
                    'id_motif' => 'required',
                    'commentaire' => 'required',
                ],[
                    'id_motif.required' => 'Veuillez ajouter le motif.',
                    'commentaire.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();

                $input['flag_valide_action_plan_formation'] = false;
                $input['flag_plan_validation_rejeter_par_comite_en_ligne'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_action_plan_formation'] = $id;
                $input['id_plan_formation'] = $idplan;

                ActionPlanFormationAValiderParUser::create($input);

                $plan = PlanFormation::find($idplan);
                $plan->update([
                    'flag_valide_action_plan_formation' => false,
                    'flag_plan_validation_rejeter_par_comite_en_ligne' => true
                ]);
                /*CtPleniere::create([
                    'id_plan_formation' => $idplan
                ]);*/
                //$nbreactionvalide = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['id_plan_formation','=',$idplan]])->get();

                return redirect('ctplanformation/'.Crypt::UrlCrypt($idplan).'/edit')->with('success', 'Succes : Action de plan de formation Traité ');

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
