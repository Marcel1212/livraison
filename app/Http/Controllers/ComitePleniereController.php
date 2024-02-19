<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cahier;
use App\Models\ComitePleniere;
use App\Models\ComitePleniereParticipant;
use Hash;
use DB;
use App\Models\User;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Crypt;
use App\Helpers\ConseillerParAgence;
use App\Models\PlanFormation;
use App\Models\Entreprises;
use App\Models\ActionFormationPlan;
use App\Models\FicheADemandeAgrement;
use App\Models\BeneficiairesFormation;
use App\Models\TypeEntreprise;
use App\Models\ButFormation;
use App\Models\CategorieProfessionelle;
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\PlanFormationAValiderParUser;
use App\Models\CategoriePlan;
use App\Models\TypeFormation;
use App\Models\Motif;
use App\Helpers\Email;
use App\Models\Pays;
use App\Helpers\Menu;
use Carbon\Carbon;
use Image;
use File;
use Auth;

class ComitePleniereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$Resultat = ComitePleniere::all();
        $Resultat =  $demandeenroles = ComitePleniere::where('code_pieces','=', 'PF')->get();
        return view('comitepleniere.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $planformations = PlanFormation::where([['flag_soumis_ct_plan_formation','=',true],['flag_valide_action_des_plan_formation','=',false],['flag_plan_validation_rejeter_par_comite_en_ligne','=',true]])->get();

        return view('comitepleniere.create', compact('planformations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'date_debut_comite_pleniere' => 'required',
                'date_fin_comite_pleniere' => 'required',
                'commentaire_comite_pleniere' => 'required'
            ],[
                'date_debut_comite_pleniere.required' => 'Veuillez ajouter une date de debut.',
                'date_fin_comite_pleniere.required' => 'Veuillez ajouter une date de fin.',
                'commentaire_comite_pleniere.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_pleniere'] = Auth::user()->id;
            $input['code_comite_pleniere'] = 'CT' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces'] = 'PF';

            ComitePleniere::create($input);

            $insertedId = ComitePleniere::latest()->first()->id_comite_pleniere;

            return redirect('ctplanformationpleniere/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');

        }
    }

    /**
     * Display the specified resource.
     */
    /*public function show(string $id)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comitepleniere = ComitePleniere::find($id);

        $comitepleniereparticipant = ComitePleniereParticipant::where([['id_comite_pleniere','=',$comitepleniere->id_comite_pleniere]])->get();

        $cahiers = Cahier::Join('plan_formation','cahier.id_demande','plan_formation.id_plan_de_formation')
                            ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','plan_formation.user_conseiller','=','users.id')
                            ->where([['id_comite_pleniere','=',$comitepleniere->id_comite_pleniere]])->get();

        $conseillers = ConseillerParAgence::get_conseiller_par_departement(Auth::user()->num_agce,Auth::user()->id_departement);
//dd($conseillers);
        $conseiller = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($conseillers as $comp) {
            $conseiller .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }

        $planformations = PlanFormation::where([['flag_soumis_ct_plan_formation','=',true],['flag_valide_action_des_plan_formation','=',false],['flag_plan_validation_rejeter_par_comite_en_ligne','=',true]])->get();

        return view('comitepleniere.edit', compact('comitepleniere','comitepleniereparticipant','cahiers','conseiller','planformations','idetape'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {

        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

       // dd($request->all());

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'date_debut_comite_pleniere' => 'required',
                    'date_fin_comite_pleniere' => 'required',
                    'commentaire_comite_pleniere' => 'required'
                ],[
                    'date_debut_comite_pleniere.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_comite_pleniere.required' => 'Veuillez ajouter une date de fin.',
                    'commentaire_comite_pleniere.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $input['id_user_comite_pleniere'] = Auth::user()->id;
                $comitepleniere = ComitePleniere::find($id);
                $comitepleniere->update($input);

                return redirect('ctplanformationpleniere/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Enregistrer_conseil_poour_comite'){

                $this->validate($request, [
                    'id_user_comite_pleniere_participant' => 'required'
                ],[
                    'id_user_comite_pleniere_participant.required' => 'Veuillez selectionnez le conseiller.'
                ]);

                $input = $request->all();
                $input['id_comite_pleniere'] = $id;
                $input['flag_comite_pleniere_participant'] = true;

                $verifconseillerexist = ComitePleniereParticipant::where([['id_comite_pleniere','=',$id],['id_user_comite_pleniere_participant','=',$input['id_user_comite_pleniere_participant']]])->get();

                if(count($verifconseillerexist) >= 1){

                    return redirect('ctplanformationpleniere/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Erreur : Cet conseiller existe deja dans cette comite plénière ');

                }

               $comitesave =  ComitePleniereParticipant::create($input);

                $usernotifie = User::where([['id','=',$comitesave->id_user_comite_pleniere_participant]])->first();

                $comiteencours = ComitePleniere::find($id);

                $logo = Menu::get_logo();

                if (isset($usernotifie->email)) {
                    $nom_prenom = $usernotifie->name .' '. $usernotifie->prenom_users;
                    $sujet = "Tenue de comite plénière";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher, $nom_prenom  ,</b>
                                    <br><br>Vous êtes convié au comite technique des plans de formation qui se déroulera du  ".$comiteencours->date_debut_comite_pleniere." au ".$comiteencours->date_fin_comite_pleniere.".

                                    <br><br> Vous êtes prié de bien vouloir  prendre connaissance des plans de formations.
                                    <br>

                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";


                    $messageMailEnvoi = Email::get_envoimailTemplate($usernotifie->email, $nom_prenom, $messageMail, $sujet, $titre);
                }

                return redirect('ctplanformationpleniere/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


            }

            if ($data['action'] == 'Traiter_cahier_plan'){


                $comitepleniere = ComitePleniere::find($id);
                $comitepleniere->update(['flag_statut_comite_pleniere'=> true]);


                return redirect('ctplanformationpleniere/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


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

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $comitepleniereParticipant = ComitePleniereParticipant::find($idVal);
        $idcomiteplenier = $comitepleniereParticipant->id_comite_pleniere;
        ComitePleniereParticipant::where([['id_comite_pleniere_participant','=',$idVal]])->delete();
        return redirect('ctplanformationpleniere/'.Crypt::UrlCrypt($idcomiteplenier).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Le conseiller à été du comite avec succes  supprimer avec succes ');
    }

    public function cahier($id,$id2){

        /*$idplan = Crypt::UrldeCrypt($id);
        $idcomite = Crypt::UrldeCrypt($id2);

        Cahier::create([
            'id_demande' => $idplan,
            'id_comite_pleniere' => $idplan,
        ]);*/

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

        return view('comitepleniere.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
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
        //dd($nombreactionvalider);
        return view('comitepleniere.editer', compact(
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','idcomite','id','idetape'
        ));

    }
    /**
     * Update the specified resource in storage.
     */
    public function cahierupdate(Request $request, $id, $id2, $id3)
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

                $montantcoutactionattribuable = $actionplan->montant_attribuable_fdfp;

                $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                if($coutaccordeactionformation > $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }else{
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }

                $actionplan->update($input);
                ActionPlanFormationAValiderParUser::create($input);

                //$nbreactionvalide = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['id_plan_formation','=',$idplan]])->get();

                return redirect('ctplanformationpleniere/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/editer')->with('success', 'Succes : Action de plan de formation Traité ');

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
                Cahier::create([
                    'id_demande' => $idplan,
                    'id_comite_pleniere' => $id2,
                    'id_user_cahier' => Auth::user()->id,
                    'flag_cahier'=> true
                ]);
                //$nbreplanvalide = PlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['flag_valide_plan_formation','=',true]])->get();
                //$nbrav = count($nbreplanvalide);
                //if($nbrav == $nombredeconseilleragence){
                    $plan = PlanFormation::find($idplan);
                    $plan->update([
                        'id_processus' => 1,
                        'flag_valide_action_des_plan_formation' => true,
                        'flag_plan_formation_valider_par_comite_pleniere' => true
                    ]);
                //}
                return redirect('ctplanformationpleniere/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/edit')->with('success', 'Succes : Les actions ont été validée ');


            }

        }

    }
}
