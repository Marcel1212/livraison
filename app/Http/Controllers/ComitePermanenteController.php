<?php

namespace App\Http\Controllers;

use App\Models\ComitePermanente;
use App\Models\DemandeSubstitutionActionPlanFormation;
use Illuminate\Http\Request;
use App\Helpers\ConseillerParAgence;
use Carbon\Carbon;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Models\User;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Crypt;
use App\Models\ActionFormationPlan;
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\ComiteGestionParticipant;
use App\Models\ComitePermanenteParticipant;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PlanFormation;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use App\Helpers\Menu;
use App\Helpers\Email;

class ComitePermanenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Resultat = ComitePermanente::all();
        return view('comitepermanente.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typecomiteinfos = ConseillerParAgence::get_type_comite_per_plan_formation();
        $planformations = PlanFormation::where([['flag_plan_formation_valider_par_processus','=',true],
                                                ['flag_plan_formation_valider_cahier','=',true],
                                                ['flag_plan_formation_valider_cahier_soumis_comite_permanente','=',true],
                                                ['flag_fiche_agrement','=',false],
                                                ['cout_total_accorder_plan_formation','>=',$typecomiteinfos->valeur_min_type_comite],
                                                ['cout_total_accorder_plan_formation','<=',$typecomiteinfos->valeur_max_type_comite]])
                                            ->get();

        return view('comitepermanente.create', compact('planformations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'date_debut_comite_permanente' => 'required',
                'date_fin_comite_permanente' => 'required',
                'commentaire_comite_permanente' => 'required'
            ],[
                'date_debut_comite_permanente.required' => 'Veuillez ajouter une date de debut.',
                'date_fin_comite_permanente.required' => 'Veuillez ajouter une date de fin.',
                'commentaire_comite_permanente.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_permanente'] = Auth::user()->id;
            $input['code_comite_permanente'] = 'CP' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces_comite_permanente'] = 'PF';
            $typecomiteinfos = ConseillerParAgence::get_type_comite_per_plan_formation();

            $input['id_type_comite_comite_permanente'] = $typecomiteinfos->id_type_comite;

            ComitePermanente::create($input);

            $insertedId = ComitePermanente::latest()->first()->id_comite_permanente;

            return redirect('comitepermanente/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');

        }
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

        return view('comitepermanente.show', compact('actionplan','ficheagrement', 'beneficiaires','planformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comitegestion = ComitePermanente::find($id);

        $comitegestionparticipant = ComitePermanenteParticipant::where([['id_comite_permanente','=',$comitegestion->id_comite_permanente]])->get();

        $ficheagrements = FicheAgrement::Join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
                            ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','plan_formation.user_conseiller','=','users.id')
                            ->where([['fiche_agrement.id_comite_permanente','=',$comitegestion->id_comite_permanente]])->get();

        $conseillers = ConseillerParAgence::get_comite_gestion_permanente();
//dd($conseillers);
        $conseiller = "<option value=''> Sélectionnez une personne ressource </option>";
        foreach ($conseillers as $comp) {
            $conseiller .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }

        $typecomiteinfos = ConseillerParAgence::get_type_comite_per_plan_formation();

        $planformations = PlanFormation::where([['flag_plan_formation_valider_par_processus','=',true],
                                                ['flag_plan_formation_valider_cahier','=',true],
                                                ['flag_plan_formation_valider_cahier_soumis_comite_permanente','=',true],
                                                ['flag_fiche_agrement','=',false],
                                                ['cout_total_accorder_plan_formation','>=',$typecomiteinfos->valeur_min_type_comite],
                                                ['cout_total_accorder_plan_formation','<=',$typecomiteinfos->valeur_max_type_comite]])
                                            ->get();

        return view('comitepermanente.edit', compact('comitegestion','comitegestionparticipant','ficheagrements','conseiller','planformations','idetape'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'date_debut_comite_permanente' => 'required',
                    'date_fin_comite_permanente' => 'required',
                    'commentaire_comite_permanente' => 'required'
                ],[
                    'date_debut_comite_permanente.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_comite_permanente.required' => 'Veuillez ajouter une date de fin.',
                    'commentaire_comite_permanente.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $input['id_user_comite_permanente'] = Auth::user()->id;
                $comitegestion = ComitePermanente::find($id);
                $comitegestion->update($input);

                return redirect('comitepermanente/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Enregistrer_conseil_poour_comite'){

                $this->validate($request, [
                    'id_user_comite_permanente_participant' => 'required'
                ],[
                    'id_user_comite_permanente_participant.required' => 'Veuillez selectionnez le conseiller.'
                ]);

                $input = $request->all();
                $input['id_comite_permanente'] = $id;
                $input['flag_comite_gestion_participant'] = true;

                $verifconseillerexist = ComitePermanenteParticipant::where([['id_comite_permanente','=',$id],['id_user_comite_permanente_participant','=',$input['id_user_comite_permanente_participant']]])->get();

                if(count($verifconseillerexist) >= 1){

                    return redirect('comitepermanente/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Erreur : Cette personne existe déjà dans ce comite de gestion. ');

                }

                $comitesave  = ComitePermanenteParticipant::create($input);


                $usernotifie = User::where([['id','=',$comitesave->id_user_comite_permanente_participant]])->first();

                $comiteencours = ComitePermanente::find($id);

                $logo = Menu::get_logo();

                if (isset($usernotifie->email)) {
                    $nom_prenom = $usernotifie->name .' '. $usernotifie->prenom_users;
                    $sujet = "Tenue de comission de permanante";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher, $nom_prenom  ,</b>
                                    <br><br>Vous êtes convié a la commission permanente des plans de formation qui se déroulera du  ".$comiteencours->date_debut_comite_permanente." au ".$comiteencours->date_fin_comite_permanente.".

                                    <br><br> Vous êtes prié de bien vouloir  prendre connaissance des plans de formation.
                                    <br>

                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";


                    $messageMailEnvoi = Email::get_envoimailTemplate($usernotifie->email, $nom_prenom, $messageMail, $sujet, $titre);
                }

                //return redirect('comitepleniere/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
                return redirect('comitepermanente/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


            }

            if ($data['action'] == 'Traiter_cahier_plan'){


                $comitegestion = ComitePermanente::find($id);
                $comitegestion->update(['flag_statut_comite_permanente'=> true]);


                return redirect('comitepermanente/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


            }

        }
    }

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $comitegestionParticipant = ComitePermanenteParticipant::find($idVal);
        $idcomitegestion = $comitegestionParticipant->id_comite_permanente;
        ComitePermanenteParticipant::where([['id_comite_permanente_participant','=',$idVal]])->delete();
        return redirect('comitepermanente/'.Crypt::UrlCrypt($idcomitegestion).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : La personne a été supprimée du comite avec succès ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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


        return view('comitepermanente.editer', compact(
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','idcomite','id','idetape','idcomite','montantactionplanformation','montantactionplanformationacc'
        ));

    }

    public function agrementupdate(Request $request, $id, $id2, $id3)
    {

        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);
        $id3 =  Crypt::UrldeCrypt($id3);

       // dd($request->all());
       if ($request->isMethod('post')) {

            $data = $request->all();

        //dd($data);

            if($data['action'] === 'Traiter_action_formation_valider'){

                $actionplan = ActionFormationPlan::find($id);
                $actionplan_old = DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_substi',$id)->first();
                if(isset($actionplan_old)){
                    $old_action = ActionFormationPlan::find($actionplan_old->id_action_formation_plan_a_substi);
                    $old_action->flag_substitution = true;
                    $old_action->update();
                }

                $idplan = $actionplan->id_plan_de_formation;

                $this->validate($request, [
                    'id_motif' => 'required',
                ],[
                    'id_motif.required' => 'Veuillez ajouter le motif.',
                ]);

                $input = $request->all();

                $input = $request->all();

                if($input['cout_accorde_action_formation'] > $actionplan->cout_accorde_action_formation ){

                    return redirect('comitepermanente/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/editer')->with('error', 'Erreur : le Montant accordé est superiéur au montant ');

                }

                $input['flag_valide_action_formation_pl_comite_permanente'] = true;
                $input['flag_valide_action_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_action_plan_formation'] = $id;
                $input['id_plan_formation'] = $idplan;

                $actionplan->update($input);
                ActionPlanFormationAValiderParUser::create($input);

                //$nbreactionvalide = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['id_plan_formation','=',$idplan]])->get();

                return redirect('comitepermanente/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/editer')->with('success', 'Succes : Action de plan de formation Traité ');

            }

            if($data['action'] === 'Traiter_action_formation_valider_plan'){
                $idplan = $id;

                $plan = PlanFormation::find($idplan);

                $actionformationvals = ActionFormationPlan::where([['id_plan_de_formation','=',$idplan]])
                    ->orWhere('id_plan_de_formation',$plan->id_plan_formation_supplementaire)
                    ->where(function ($query) {
                        $query->where('flag_annulation_action', false)
                            ->orwhereNull('flag_annulation_action');
                    })->get();

                $plan_old = PlanFormation::find($plan->id_plan_formation_supplementaire);
                if(isset($plan_old)){
                    $plan_old->flag_plan_sup = true;
                    $plan_old->update();
                }

                $input = $request->all();

                $input = $request->all();

                /*$input['flag_valide_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_plan_formation'] = $idplan;
                $input['date_valide_plan_formation'] = Carbon::now();

                PlanFormationAValiderParUser::create($input);*/

                FicheAgrement::create([
                    'id_demande' => $idplan,
                    'id_comite_permanente' => $id2,
                    'id_user_fiche_agrement' => Auth::user()->id,
                    'flag_fiche_agrement'=> true
                ]);
                //$nbreplanvalide = PlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['flag_valide_plan_formation','=',true]])->get();
                //$nbrav = count($nbreplanvalide);
                //if($nbrav == $nombredeconseilleragence){


                    $montantcouttotal = 0;

                    foreach($actionformationvals as $actionformationval){
                        $montantcouttotal += $actionformationval->cout_accorde_action_formation;
                    }


                    $plan->update([
                        'flag_fiche_agrement' => true,
                        'cout_total_accorder_plan_formation' => $montantcouttotal,
                        'date_fiche_agrement' => Carbon::now()
                    ]);
                //}
                return redirect('comitepermanente/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/edit')->with('success', 'Succes : Les actions ont été validée ');


            }

        }

    }

}
