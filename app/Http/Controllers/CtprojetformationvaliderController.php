<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Menu;
use App\Models\Activites;
use App\Models\CentreImpot;
use App\Models\Localite;
use App\Models\Pays;
use App\Models\Service;
use App\Models\Departement;
use App\Models\DemandeEnrolement;
use App\Models\Entreprises;
use App\Models\PlanFormation;
use App\Models\ProjetFormation;
use App\Models\PiecesProjetFormation;
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

class CtprojetformationvaliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUser=Auth::user()->id;
        $Idroles = Menu::get_id_profil($idUser);
       // dd($Idroles);

        $Resultat = null;
        $ResultatEtap = DB::table('vue_processus')
            ->where('id_roles', '=', $Idroles)
            ->get();
        //dd($ResultatEtap);
        if (isset($ResultatEtap)) {
            $Resultat = [];
            foreach ($ResultatEtap as $key => $r) {
               // dd($r->id_processus);
                    $Resultat[$key] = DB::table('vue_processus_liste as v')
                        ->Join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                        ->join('projet_formation','p.id_demande','projet_formation.id_projet_formation')
                        ->join('entreprises','projet_formation.id_entreprises','entreprises.id_entreprises')
                        ->join('users','projet_formation.id_user','users.id')
                        ->where([
                            ['v.mini', '=', $r->priorite_combi_proc],
                           ['v.id_processus', '=', $r->id_processus],
                             ['v.code', '=', 'PRF'],
                           ['p.id_roles', '=', $Idroles]
                        ])
                        ->get();
            }
        //dd($Resultat);
        }



        return view('ctprojetformationvalider.index',compact('Resultat'));

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

        return view('ctprojetformationvalider.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
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

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$id],['flag_valide_action_formation_pl','=',true]])->get();
        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$id],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();

        $nombreactionvalider = count($actionvalider);
        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

        $montantactionplanformation = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformation += $actionplanformation->cout_action_formation_plan;
        }

        $montantactionplanformationacc = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformationacc += $actionplanformation->cout_accorde_action_formation;
        }

        return view('ctprojetformationvalider.edit', compact('planformation','infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations','nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','historiquesplanformations','montantactionplanformation','montantactionplanformationacc'));

    }

    public function editer($id, $id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);
       // dd($id);
        $planformation = ProjetFormation::find($id);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $user_id = Auth::user()->id;
        $roles = DB::table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->where([['users.id','=',$user_id]])
                ->first();
            $idroles = $roles->role_id;
        $nomrole = $roles->name ;
        //dd($id);
        $projetetude = ProjetFormation::find($id);
        //dd($projetetude);
        $entreprise_info = Entreprises::find($projetetude->id_entreprises);
        //dd($entreprise->raison_social_entreprises);

        //dd($projetetude['titre_projet_etude']);
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','1']])->get();
        //dd($piecesetude);
        $piecesetude1 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','2']])->get();
        $piecesetude2 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','3']])->get();
        $piecesetude3 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','4']])->get();
        $piecesetude4 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','5']])->get();
        $piecesetude5 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','6']])->get();
        $piecesetude6 = $piecesetude['0']['libelle_pieces'];
        $piecesetude_ins = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','7']])->get();
        //dd($piecesetude_ins->count());
        if($piecesetude_ins->count()> 0){
            $piecesetude7 = $piecesetude_ins['0']['libelle_pieces'];
        }else {
            $piecesetude7 = null ;
        }

        $id_dep = $projetetude->id_departement;
        $departement = Departement::find($id_dep);
        $departement_name = $departement->libelle_departement;

        $id_serv = $projetetude->id_service;
        $service = Service::find($id_serv);
        $service_name = $service->libelle_service;

        $id_serv = $projetetude->id_conseiller_formation;
        $conseiller = User::find($id_serv);
        $conseiller_name = $conseiller->name . " " . $conseiller->prenom_users ;



        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
        ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
            'v.comment_parcours', 'v.id_processus')
        ->where('v.id_processus', '=', $planformation->id_processus)
        ->where('v.id_demande', '=', $planformation->id_projet_formation)
        ->orderBy('v.priorite_combi_proc', 'ASC')
        ->get();
        //dd($ResultProssesList);

            $idUser=Auth::user()->id;
            $idAgceCon=Auth::user()->num_agce;
            $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$planformation->id_processus],['id_user','=',$idUser],['id_piece','=',$planformation->id_projet_formation],['id_roles','=',$Idroles],['num_agce','=',$idAgceCon],['id_combi_proc','=',$id2]
            ])->get();

        //dd($ResultProssesList);

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();



        return view('ctprojetformationvalider.edit', compact('conseiller_name','service_name','departement_name','projetetude','planformation','infoentreprise','id2','ResultProssesList','parcoursexist','piecesetude1','piecesetude2','piecesetude3','piecesetude4' ,'piecesetude5','piecesetude6','piecesetude7'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        if ($request->isMethod('put')) {

            $data = $request->all();
            //dd($data);

            if($data['action'] === 'Valider'){

                $idUser=Auth::user()->id;
                $idAgceCon=Auth::user()->num_agce;
                $Idroles = Menu::get_id_profil($idUser);
                $dateNow = Carbon::now();
                $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                //dd($id_combi_proc);
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

                        $plan = ProjetFormation::find($id);
                        $plan->update([
                            'flag_processus_etape' => true
                        ]);

                    }


                    return redirect('ctprojetformationvalider/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/editer')->with('success', 'Succes : Operation validée avec succes ');


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


                    return redirect('ctprojetformationvalider/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/editer')->with('success', 'Succes : Operation validée avec succes ');


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
