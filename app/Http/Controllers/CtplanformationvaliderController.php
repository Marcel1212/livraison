<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Menu;
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
use App\Models\Parcours;
use App\Models\PlanFormationAValiderParUser;
use App\Models\CtPleniere;
use App\Models\Motif;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\ConseillerParAgence;
use App\Helpers\GenerateCode as Gencode;
use App\Models\FicheAgrement;
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;

class CtplanformationvaliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUser=Auth::user()->id;
        $Idroles = Menu::get_id_profil($idUser);
        $Resultat = null;
        $ResultatEtap = DB::table('vue_processus')
            ->where('id_roles', '=', $Idroles)
            ->get();
           // dd($ResultatEtap);
        if (isset($ResultatEtap)) {
            $Resultat = [];
            foreach ($ResultatEtap as $key => $r) {
                    $Resultat[$key] = DB::table('vue_processus_liste as v')
                        ->Join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                        ->join('plan_formation','p.id_demande','plan_formation.id_plan_de_formation')
                        ->join('entreprises','plan_formation.id_entreprises','entreprises.id_entreprises')
                        ->join('users','plan_formation.id_user','users.id')
                        ->where([
                            ['v.mini', '=', $r->priorite_combi_proc],
                            ['v.id_processus', '=', $r->id_processus],
                             ['v.code', '=', 'PF'],
                            ['p.id_roles', '=', $Idroles]
                        ])
                        ->get();
            }
       // dd($Resultat);
        }



        return view('ctplanformationvalider.index',compact('Resultat'));

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

        return view('ctplanformationvalider.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id =  Crypt::UrldeCrypt($id);
//dd($id);
        $planformation = PlanFormation::find($id);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $historiquesplanformations = FicheAgrement::Join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
        ->join('action_formation_plan','plan_formation.id_plan_de_formation','action_formation_plan.id_plan_de_formation')
        ->where([['plan_formation.id_entreprises','=',$planformation->id_entreprises]])->get();
//dd($historiquesplanformations);

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



        return view('ctplanformationvalider.edit', compact('planformation','infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations','nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','historiquesplanformations'));

    }

    public function editer($id, $id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);
//dd($id);
        $planformation = PlanFormation::find($id);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $historiquesplanformations = FicheAgrement::Join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
        ->join('action_formation_plan','plan_formation.id_plan_de_formation','action_formation_plan.id_plan_de_formation')
        ->where([['plan_formation.id_entreprises','=',$planformation->id_entreprises]])->get();
//dd($historiquesplanformations);

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

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
        ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
            'v.comment_parcours', 'v.id_processus')
        ->where('v.id_processus', '=', $planformation->id_processus)
        ->where('v.id_demande', '=', $planformation->id_plan_de_formation)
        ->orderBy('v.priorite_combi_proc', 'ASC')
        ->get();

            $idUser=Auth::user()->id;
            $idAgceCon=Auth::user()->num_agce;
            $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$planformation->id_processus],['id_user','=',$idUser],['id_piece','=',$planformation->id_plan_de_formation],['id_roles','=',$Idroles],['num_agce','=',$idAgceCon],['id_combi_proc','=',$id2]
            ])->get();

        //dd($ResultProssesList);

        return view('ctplanformationvalider.edit', compact('planformation','infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations','nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','id2','ResultProssesList','parcoursexist','historiquesplanformations'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if($data['action'] === 'Valider'){

                $idUser=Auth::user()->id;
                $idAgceCon=Auth::user()->num_agce;
                $Idroles = Menu::get_id_profil($idUser);
                $dateNow = Carbon::now();
                $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                $infosprocessus = DB::table('vue_processus')
                                    ->where('id_combi_proc', '=', $id_combi_proc)
                                    ->first();
                $idProComb = $infosprocessus->id_combi_proc;
                $idProcessus = $infosprocessus->id_processus;

                Parcours::create(
                    [
                        'id_processus' => $idProcessus,
                        'id_user' => $idUser,
                        'id_piece' => $id,
                        'id_roles' => $Idroles,
                        'num_agce' => $idAgceCon,
                        'comment_parcours' => $request->input('comment_parcours'),
                        'is_valide' => true,
                        'date_valide' => $dateNow,
                        'id_combi_proc' => $idProComb,
                    ]);

                    $ResultCptVal = DB::table('combinaison_processus as v')
                                        ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
                                        ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
                                        ->where('a.id_demande', '=', $id)
                                        ->where('a.id_processus', '=', $idProcessus)
                                        ->where('v.id_roles', '=', $Idroles)
                                        ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                                        ->first();

                    if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {

                        $plan = PlanFormation::find($id);
                        $plan->update([
                            'flag_plan_formation_valider_par_processus' => true
                        ]);

                    }


                    return redirect('ctplanformationvalider/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/editer')->with('success', 'Succes : Operation validée avec succes ');


            }

            if($data['action'] === 'Rejeter'){

                $this->validate($request, [
                    'comment_parcours' => 'required',
                ],[
                    'comment_parcours.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $idUser=Auth::user()->id;
                $idAgceCon=Auth::user()->num_agce;
                $Idroles = Menu::get_id_profil($idUser);
                $dateNow = Carbon::now();
                $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                $infosprocessus = DB::table('vue_processus')
                                    ->where('id_combi_proc', '=', $id_combi_proc)
                                    ->first();
                $idProComb = $infosprocessus->id_combi_proc;
                $idProcessus = $infosprocessus->id_processus;

                Parcours::create(
                    [
                        'id_processus' => $idProcessus,
                        'id_user' => $idUser,
                        'id_piece' => $id,
                        'id_roles' => $Idroles,
                        'num_agce' => $idAgceCon,
                        'comment_parcours' => $request->input('comment_parcours'),
                        'is_valide' => false,
                        'date_valide' => $dateNow,
                        'id_combi_proc' => $idProComb,
                    ]);


                    return redirect('ctplanformationvalider/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/editer')->with('success', 'Succes : Operation validée avec succes ');


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
