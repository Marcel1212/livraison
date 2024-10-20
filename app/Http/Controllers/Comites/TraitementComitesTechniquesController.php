<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
use App\Models\Cahier;
use App\Models\Comite;
use App\Models\DomaineFormation;
use App\Models\FormeJuridique;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\ProjetFormation;
use App\Models\TraitementParCriterePrf;
use App\Models\TraitementParCriterePrfCoord;
use App\Models\TraitementParCritereCommentairePrfCoord;
use Illuminate\Http\Request;
use App\Models\TypeProjetFormation;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Helpers\Crypt;
use App\Helpers\GenerateCode as Gencode;
use Carbon\Carbon;
use App\Helpers\Email;
use App\Helpers\Audit;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Models\ActionFormationPlan;
use App\Models\AvisGlobaleComiteTechnique;
use App\Models\Banque;
use App\Models\BeneficiairesFormation;
use App\Models\PiecesProjetFormation;
use App\Models\ButFormation;
use App\Models\CahierComite;
use App\Models\CaracteristiqueTypeFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\TraitementParCritereCommentairePrf;
use App\Models\ComiteParticipant;
use App\Models\CommentaireNonRecevableDemande;
use App\Models\CritereEvaluation;
use App\Models\DemandeHabilitation;
use App\Models\DemandeIntervention;
use App\Models\DomaineDemandeHabilitation;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrementButFormation;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\InterventionHorsCi;
use App\Models\Motif;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Pays;
use App\Models\PiecesDemandeHabilitation;
use App\Models\PlanFormation;
use App\Models\ProcessusComiteLieComite;
use App\Models\RapportsVisites;
use App\Models\SecteurActivite;
use App\Models\TraitementParCritere;
use App\Models\TraitementParCritereCommentaire;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeDomaineDemandeHabilitationPublic;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use App\Models\TypeIntervention;
use App\Models\TypeMoyenPermanent;
use App\Models\TypeOrganisationFormation;
use App\Models\Visites;
use Illuminate\Http\JsonResponse;

    @ini_set('max_execution_time',0);
class TraitementComitesTechniquesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comites = Comite::Join('categorie_comite','comite.id_categorie_comite','categorie_comite.id_categorie_comite')
                        ->join('processus_comite_lie_comite','comite.id_comite','processus_comite_lie_comite.id_comite')
                        ->join('processus_comite','processus_comite_lie_comite.id_processus_comite','processus_comite.id_processus_comite')
                        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                        ->where('categorie_comite.code_categorie_comite','CT')
                        ->where('id_user_comite_participant',Auth::user()->id)
                        ->where('flag_statut_comite',false)
                        ->get();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TRAITEMENT DES COMITES TECHNIQUES'

        ]);

        return view('comites.traitementcomitetechniques.index', compact('comites'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
       // dd($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comite = Comite::find($id);
       // dd($comite->id_categorie_comite);
       $idcategoriecomite = $comite->id_categorie_comite;

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();
        //dd($idcategoriecomite);

        if($idcategoriecomite == 2){
            $listedemandesss = DB::table('vue_plans_projets_formation_coordination_traiter as vue_plans_projets_formation')
            ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
            ->join('comite','cahier_comite.id_comite','comite.id_comite')
            ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
            ->where([['cahier_comite.id_comite','=',$id],
                    ['comite_participant.id_user_comite_participant','=',Auth::user()->id],
                    ['vue_plans_projets_formation.code_processus','=',$processuscomite->processusComite->code_processus_comite]])
            ->get();
        }else{
            //dd('ici');
            $listedemandesss = DB::table('vue_plans_projets_formation_traiter as vue_plans_projets_formation')
        ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
        ->join('comite','cahier_comite.id_comite','comite.id_comite')
        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
        ->where([['cahier_comite.id_comite','=',$id],
                ['comite_participant.id_user_comite_participant','=',Auth::user()->id],
                ['vue_plans_projets_formation.code_processus','=',$processuscomite->processusComite->code_processus_comite]])
        ->get();
        }
        //dd($listedemandesss);

        // $listedemandesss = DB::table('vue_plans_projets_formation_traiter as vue_plans_projets_formation')
        // ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
        // ->join('comite','cahier_comite.id_comite','comite.id_comite')
        // ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
        // ->where([['cahier_comite.id_comite','=',$id],
        //         ['comite_participant.id_user_comite_participant','=',Auth::user()->id],
        //         ['vue_plans_projets_formation.code_processus','=',$processuscomite->processusComite->code_processus_comite]])
        // ->get();

        //$comiteparticipants = ComiteParticipant::where([['id_comite','=',$id]])->get();

        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
        ->join('users','comite_participant.id_user_comite_participant','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['id_comite','=',$id]])
        ->get();


        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES TECHNIQUES'

        ]);

        return view('comites.traitementcomitetechniques.edit', compact('comite','idetape','id','processuscomite','cahiers','comiteparticipants','listedemandesss'));

    }

    public function editplanformation($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;

        $comite = Comite::find($id);

        //dd($idcomite);
        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $listedemandesss = DB::table('vue_plans_projets_formation_traiter as vue_plans_projets_formation')
        ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
        ->join('comite','cahier_comite.id_comite','comite.id_comite')
        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
        ->where([['cahier_comite.id_comite','=',$id],['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
        ->get();

        //$comiteparticipants = ComiteParticipant::where([['id_comite','=',$id]])->get();

        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
        ->join('users','comite_participant.id_user_comite_participant','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['id_comite','=',$id]])
        ->get();

        $planformation = PlanFormation::find($id1);
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

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id1]])->orderBy('pirorite_action_formation','desc')->get();

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id1]])->get();

        $motifs = Motif::where([['code_motif','=','CTPAF']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','type_formation.*','domaine_formation.*')
                                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                                        ->join('domaine_formation','domaine_formation.id_domaine_formation','=','domaine_formation.id_domaine_formation')
                                        ->where([['action_formation_plan.id_plan_de_formation','=',$id1]])->get();

        $criteres = CritereEvaluation::Join('categorie_comite','critere_evaluation.id_categorie_comite','categorie_comite.id_categorie_comite')
                                    ->join('processus_comite','critere_evaluation.id_processus_comite','processus_comite.id_processus_comite')
                                    ->where([['critere_evaluation.flag_critere_evaluation','=',true],
                                            ['categorie_comite.code_categorie_comite','=','CT'],
                                            ['processus_comite.code_processus_comite','=','PF']])
                                    ->get();

     /******************** secteuractivites *********************************/
        $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                        ->orderBy('libelle_secteur_activite')
                        ->get();


        $typeformationss = TypeFormation::where('flag_actif_formation','=',true)->orderBy('type_formation')->get();

        $butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES TECHNIQUES'

        ]);

        return view('comites.traitementcomitetechniques.editplanformation', compact(
            'comite','idetape','id','id1','processuscomite','cahiers','comiteparticipants','listedemandesss',
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'idcomite','criteres','secteuractivites','typeformationss','butformations'
        ));

    }

    public function edithabilitation($id,$id1,$id2) {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);


        $demandehabilitation = DemandeHabilitation::find($id1);

        $visites = Visites::where([['id_demande_habilitation','=',$demandehabilitation->id_demande_habilitation]])->first();
       // dd($demandehabilitation->visites->statut);
       // dd($visites);

       $rapportVisite = RapportsVisites::where([['id_visites','=',@$visites->id_visites]])->get();
      // $rapportVisitef = RapportsVisites::where([['id_demande_habilitation','=',@$demandehabilitation->id_demande_habilitation]])->first();

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);
       // dd($infoentreprise->pay->id_pays);
        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        //dd($pay);
        $payList = "<option value=''> Selectionnez un pays</option>";
        foreach ($pays as $comp) {
            $payList .= "<option value='" . $comp->id_pays  . "'>" . $comp->libelle_pays ." </option>";
        }

        $typemoyenpermanentes = TypeMoyenPermanent::where([['flag_type_moyen_permanent','=',true]])->get();
        $typemoyenpermanenteList = "<option value=''> Selectionnez la type de moyen </option>";
        foreach ($typemoyenpermanentes as $comp) {
            $typemoyenpermanenteList .= "<option value='" . $comp->id_type_moyen_permanent  . "'>" . mb_strtoupper($comp->libelle_type_moyen_permanent) ." </option>";
        }

        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id1]])->get();

        $typeinterventions = TypeIntervention::where([['flag_type_intervention','=',true]])->get();
        $typeinterventionsList = "<option value=''> Selectionnez le type d\'intervention </option>";
        foreach ($typeinterventions as $comp) {
            $typeinterventionsList .= "<option value='" . $comp->id_type_intervention  . "'>" . mb_strtoupper($comp->libelle_type_intervention) ." </option>";
        }

        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id1]])->get();
        //dd($idetape);

        $organisationFormations = TypeOrganisationFormation::where([['flag_type_organisation_formation','=',true]])->get();
        $organisationFormationsList = "<option value=''> Selectionnez le type d\'organisation </option>";
        foreach ($organisationFormations as $comp) {
            $organisationFormationsList .= "<option value='" . $comp->id_type_organisation_formation  . "'>" . mb_strtoupper($comp->libelle_type_organisation_formation) ." </option>";
        }

        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id1]])->get();

        $typeDomaineDemandeHabilitation = TypeDomaineDemandeHabilitation::where([['flag_type_domaine_demande_habilitation','=',true]])->get();
        $typeDomaineDemandeHabilitationList = "<option value=''> Selectionnez la finalité </option>";
        foreach ($typeDomaineDemandeHabilitation as $comp) {
            $typeDomaineDemandeHabilitationList .= "<option value='" . $comp->id_type_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation) ." </option>";
        }

        $typeDomaineDemandeHabilitationPublic = TypeDomaineDemandeHabilitationPublic::where([['flag_type_type_domaine_demande_habilitation_public','=',true]])->get();
        $typeDomaineDemandeHabilitationPublicList = "<option value=''> Selectionnez le public </option>";
        foreach ($typeDomaineDemandeHabilitationPublic as $comp) {
            $typeDomaineDemandeHabilitationPublicList .= "<option value='" . $comp->id_type_domaine_demande_habilitation_public  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation_public) ." </option>";
        }

        $domaines = DomaineFormation::where([['flag_domaine_formation','=',true]])->get();
        $domainesList = "<option value=''> Selectionnez le domaine de formation </option>";
        foreach ($domaines as $comp) {
            $domainesList .= "<option value='" . $comp->id_domaine_formation  . "'>" . mb_strtoupper($comp->libelle_domaine_formation) ." </option>";
        }

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();

        $domainedemandes = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();
        $domainedemandeList = "<option value=''> Selectionnez la banque </option>";
        foreach ($domainedemandes as $comp) {
            $domainedemandeList .= "<option value='" . $comp->id_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation) .'/'. mb_strtoupper( $comp->domaineFormation->libelle_domaine_formation) ." </option>";
        }

/*         $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
                                                          ->where([['id_demande_habilitation','=',$id]])
                                                          ->get(); */

                                                          $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
                                                          ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
                                                          ->join('type_domaine_demande_habilitation','domaine_demande_habilitation.id_type_domaine_demande_habilitation','type_domaine_demande_habilitation.id_type_domaine_demande_habilitation')
                                                          ->join('type_domaine_demande_habilitation_public','domaine_demande_habilitation.id_type_domaine_demande_habilitation_public','type_domaine_demande_habilitation_public.id_type_domaine_demande_habilitation_public')
                                                          ->join('formateurs','formateur_domaine_demande_habilitation.id_formateurs','formateurs.id_formateurs')
                                                          ->where([['id_demande_habilitation','=',$id1]])
                                                          ->get();


        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id1]])->get();



        $criteres = CritereEvaluation::Join('categorie_comite','critere_evaluation.id_categorie_comite','categorie_comite.id_categorie_comite')
                                    ->join('processus_comite','critere_evaluation.id_processus_comite','processus_comite.id_processus_comite')
                                    ->where([['critere_evaluation.flag_critere_evaluation','=',true],
                                            ['categorie_comite.code_categorie_comite','=','CT'],
                                            ['processus_comite.code_processus_comite','=','HAB']])
                                    ->get();

        $piecesDemandeHabilitations = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();

        $traitement = TraitementParCritere::Join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
                ->where([['traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','=',Auth::user()->id],['traitement_par_critere.id_demande','=',$id1]])->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES TECHNIQUES (HABILITATION)'

        ]);

        return view('comites.traitementcomitetechniques.edithabilitation', compact('demandehabilitation','infoentreprise','banque','pay',
                    'id','id1','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
                    'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
                    'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList',
                    'typeDomaineDemandeHabilitationPublicList','criteres','traitement',
                    'visites','rapportVisite','piecesDemandeHabilitations'));

        //exit('test45');
    }

    public function edithabilitationupdate(Request $request,$id,$id1,$id2){
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);

        if ($request->isMethod('put')) {

            $data = $request->all();

            //dd($data);
                    // Validation des données
                $criteres = $request->input('id_critere_evaluation');
                foreach ($criteres as $id_critere) {
                    $status = $request->input("flag_traitement_par_critere_commentaire.$id_critere");
                    $commentaire = $request->input("commentaire_critere.$id_critere");

                    if ($status == 'false' && empty($commentaire)) {
                        return back()->withErrors(['commentaire_critere_'.$id_critere => 'Un commentaire est obligatoire pour les critères avec "Pas d\'accord".']);
                    }

                                // Enregistrer le traitement par critère
                    $traitementcritere = TraitementParCritere::create([
                        'id_user_traitement_par_critere' => Auth::user()->id,
                        'id_demande' => $id1,
                        'id_critere_evaluation' => $id_critere,
                        'flag_critere_evaluation' =>  true,
                    ]);

                    // Enregistrer le commentaire associé au traitement par critère
                    $traitementcommentaire = TraitementParCritereCommentaire::create([
                        'id_user_traitement_par_critere_commentaire' => Auth::user()->id,
                        'id_traitement_par_critere' => $traitementcritere->id_traitement_par_critere,
                        'flag_traitement_par_critere_commentaire' => $status,
                        'commentaire_critere' => $commentaire,
                    ]);
                }



                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id1).'/'.Crypt::UrlCrypt($idetape).'/edit/habilitation')->with('success', 'Succes : Votre évaluation pour cette demande a été effectuée ');


        }
    }

    public function comitetechniqueupdatehabilitation(Request $request, $id, $id1, $id2){
        $id =  Crypt::UrldeCrypt($id);
        $iddemande =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] === 'Traiter_action_formation_valider_reponse') {

                $data = $request->all();

                // Valider si le statut est "false" et que le commentaire est nécessaire
                if ($data['flag_traitement_par_critere_commentaire_traiter'] === "false") {
                    $this->validate($request, [
                        'commentaire_reponse' => 'required',
                    ], [
                        'commentaire_reponse.required' => 'Veuillez ajouter un commentaire.',
                    ]);
                }

                // Mise à jour des informations communes
                $infoscriterecommentaire = TraitementParCritereCommentaire::find($data['id_traitement_par_critere_commentaire']);
                $inputIn = [
                    'commentaire_reponse' => $data['commentaire_reponse'],
                    'flag_traitement_par_critere_commentaire_traiter' => $data['flag_traitement_par_critere_commentaire_traiter'],
                    'flag_traite_par_user_conserne' => true
                ];

                // Mettre à jour les informations
                $infoscriterecommentaire->update($inputIn);

                return redirect('traitementcomitetechniques/' . Crypt::UrlCrypt($id) . '/' . Crypt::UrlCrypt($iddemande) . '/' . Crypt::UrlCrypt($idetape) . '/edit/habilitation')
                    ->with('success', 'Succès : Mise à jour réussie');
            }

            // Si aucune option valide n'est sélectionnée
            return redirect('traitementcomitetechniques/' . Crypt::UrlCrypt($id) . '/' . Crypt::UrlCrypt($iddemande) . '/' . Crypt::UrlCrypt($idetape) . '/edit/habilitation')
                ->with('error', 'Erreur : Veuillez sélectionner le Statut pour le traitement des remarques');


        }
    }

    public function commentairetoutuserhabilitation($id)
    {

        $id =  Crypt::UrldeCrypt($id);

        $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','traitement_par_critere_commentaire.created_at as datej','critere_evaluation.*','users.name as name','users.prenom_users as prenom_users','roles.name as profil')
                        ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                        ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                        ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
                        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                        ->join('roles', 'model_has_roles.role_id', 'roles.id')
                        ->where([['flag_demission_users', '=', false],
                                ['flag_admin_users', '=', false],
                                ['roles.id', '!=', 15]])
                        ->where([['traitement_par_critere.id_demande','=',$id]])->get();

        return response()->json(['information'=>$traitement]);

    }

    public function CommentaireComitetechnique($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $iddemande =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $commentaires = $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','traitement_par_critere_commentaire.created_at as datej','critere_evaluation.*','users.name as name','users.prenom_users as prenom_users','roles.name as profil')
        ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
        ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
        ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['flag_demission_users', '=', false],
                ['flag_admin_users', '=', false],
                ['roles.id', '!=', 15]])
        ->where([['traitement_par_critere.id_demande','=',$iddemande]])->get();

        return view('comites.traitementcomitetechniques.commentaire', compact('commentaires','id','iddemande','idetape'));
    }
    public function CommentaireComitetechniqueall($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $iddemande =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $commentaires = $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','traitement_par_critere_commentaire.created_at as datej','critere_evaluation.*','users.name as name','users.prenom_users as prenom_users','roles.name as profil')
        ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
        ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
        ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['flag_demission_users', '=', false],
                ['flag_admin_users', '=', false],
                ['roles.id', '!=', 15]])
        ->where([['traitement_par_critere.id_demande','=',$iddemande]])->get();

        return view('comites.traitementcomitetechniques.commentaireall', compact('commentaires','id','iddemande','idetape'));
    }
    public function showficheanalysehabilitation($id,$id1,$id2) {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);

        $demandehabilitation = DemandeHabilitation::find($id1);

        $visite = Visites::where([['id_demande_habilitation','=',$id1]])->first();

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

        $formateurs = DB::table('vue_formateur_rapport')->where([['id_demande_habilitation','=',$id1]])->get();

        $rapport = RapportsVisites::where([['id_demande_habilitation','=',$id1]])->first();

        $piecesDemandes = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();

        $avis = AvisGlobaleComiteTechnique::where([
            ['id_demande', '=', $id1],
            ['code_processus', '=', 'HAB']
        ])->latest('id_avis_globale_comite_technique')->first();

        return view('comites.traitementcomitetechniques.showficheanalysehabilitation',compact('id','infoentreprise',
                        'demandehabilitation','visite','formateurs','rapport','piecesDemandes','avis'));
    }

    public function editprojetformation($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;
        $comite = Comite::find($id);
        //dd($comite);
        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();
        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $idcategoriecomite = $comite->id_categorie_comite;
        $projetetude = ProjetFormation::find($id1);
        $operateurs_valide = Entreprises::where('flag_operateur',true)->where('flag_actif_entreprises',true)->get();
        $operateur_selected = "<option value='" .$projetetude->operateur_selectionne->id_entreprises. "'>" . mb_strtoupper($projetetude->operateur_selectionne->raison_social_entreprises) . " </option>";
        foreach ($operateurs_valide as $operateur) {
            $operateur_selected .= "<option value='" .$operateur->id_entreprises. "'>" . mb_strtoupper($operateur->raison_social_entreprises) . " </option>";
        }
        //dd($operateur_selected);


        //dd($idcategoriecomite);
        if($idcategoriecomite == 2){
            $listedemandesss = DB::table('vue_plans_projets_formation_coordination_traiter as vue_plans_projets_formation')
            ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
            ->join('comite','cahier_comite.id_comite','comite.id_comite')
            ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
            ->where([['cahier_comite.id_comite','=',$id],['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
            ->get();
        }else{
            $listedemandesss = DB::table('vue_plans_projets_formation_traiter as vue_plans_projets_formation')
        ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
        ->join('comite','cahier_comite.id_comite','comite.id_comite')
        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
        ->where([['cahier_comite.id_comite','=',$id],['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
        ->get();
        }
        //dd($listedemandesss);


        //$comiteparticipants = ComiteParticipant::where([['id_comite','=',$id]])->get();

        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
        ->join('users','comite_participant.id_user_comite_participant','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['id_comite','=',$id]])
        ->get();

        //$planformation = PlanFormation::find($id1);
        $planformation = ProjetFormation::find($id1);
        $typeproj = TypeProjetFormation::find($planformation->id_type_projet_formation);
        //dd($planformation);
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id1],['code_pieces','=','1']])->get();
        $piecesetude1 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id1],['code_pieces','=','2']])->get();
        $piecesetude2 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id1],['code_pieces','=','3']])->get();
        $piecesetude3 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id1],['code_pieces','=','4']])->get();
        $piecesetude4 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id1],['code_pieces','=','5']])->get();
        $piecesetude5 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id1],['code_pieces','=','6']])->get();
        $piecesetude6 = $piecesetude['0']['libelle_pieces'];
        $piecesetude_ins = PiecesProjetFormation::where([['id_projet_formation','=',$id1],['code_pieces','=','7']])->get();
        if($piecesetude_ins->count()> 0){
            $piecesetude7 = $piecesetude_ins['0']['libelle_pieces'];
        }else {
            $piecesetude7 = null ;
        }
        $infoentreprise = Entreprises::find($planformation->id_entreprises);
        $criteres = CritereEvaluation::Join('categorie_comite','critere_evaluation.id_categorie_comite','categorie_comite.id_categorie_comite')
                                    ->join('processus_comite','critere_evaluation.id_processus_comite','processus_comite.id_processus_comite')
                                    ->where([['critere_evaluation.flag_critere_evaluation','=',true],
                                            ['categorie_comite.code_categorie_comite','=','CT'],
                                            ['processus_comite.code_processus_comite','=','PRF']])
                                    ->get();



        Audit::logSave([

            'action'=>'OBSERVER LE PROJET DE FORMATION',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES TECHNIQUES'

        ]);

        return view('comites.traitementcomitetechniques.editprojetformation', compact(
            'comite','idetape','id','id1','processuscomite','cahiers','comiteparticipants','listedemandesss',
            'planformation','infoentreprise', 'piecesetude1', 'piecesetude2','typeproj', 'piecesetude3', 'piecesetude4','piecesetude5','piecesetude6','piecesetude7',
            'idcomite','criteres','idcategoriecomite','operateur_selected'
        ));

    }



    public function editprojetetude($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;

        $comite = Comite::find($id);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if(isset($id1)){
            $projet_etude = ProjetEtude::find($id1);
            if(isset($projet_etude)){
                $pieces_projets= PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)->get();

                $avant_projet_tdr = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','avant_projet_tdr')->first();
                $courier_demande_fin = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','courier_demande_fin')->first();
                $offre_technique = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_technique')->first();
                $offre_financiere = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_financiere')->first();

                $domaine_projets = DomaineFormation::where('flag_domaine_formation', '=', true)
                    ->orderBy('libelle_domaine_formation')
                    ->get();

                $domaine_projet = "<option value='".$projet_etude->DomaineProjetEtude->id_domaine_formation."'> " . $projet_etude->DomaineProjetEtude->libelle_domaine_formation . "</option>";
                foreach ($domaine_projets as $comp) {
                    $domaine_projet .= "<option value='" . $comp->id_domaine_formation."'>" . mb_strtoupper($comp->libelle_domaine_formation) . " </option>";
                }

                $infoentreprise = Entreprises::find($projet_etude->id_entreprises)->first();

                $pays = Pays::all();
                $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
                foreach ($pays as $comp) {
                    $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }

                /******************** secteuractivites *********************************/
                $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();
                $secteuractivite = "<option value=''> Selectionnez un secteur activité </option>";
                foreach ($secteuractivites as $comp) {
                    $secteuractivite .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }
                $motif = Motif::where('code_motif','=','PRE')->get();;
                $motifs = "<option value='".$projet_etude->motif->id_motif."'> " . $projet_etude->motif->libelle_motif . "</option>";
                foreach ($motif as $comp) {
                    $motifs .= "<option value='" . $comp->id_motif  . "' >" . $comp->libelle_motif ." </option>";
                }

                $formjuridique = "<option value='".$infoentreprise->formeJuridique->id_forme_juridique."'> " . $infoentreprise->formeJuridique->libelle_forme_juridique . "</option>";

                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                }


                return view('comites.traitementcomitetechniques.editprojetetude',
                    compact('idetape','pay','pieces_projets','avant_projet_tdr',
                        'courier_demande_fin',
                        'offre_technique',
                        'projet_etude',
                        'idcomite',
                        'comite',
                        'domaine_projets',
                        'motifs',
                        'formjuridique',
                        'offre_financiere',
                        'secteuractivite'));

            }
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function cahierupdate(Request $request, $id, $id2,$id3)
    {
        $idactionformation =  Crypt::UrldeCrypt($id);
        $idcomite =  Crypt::UrldeCrypt($id2);
        $etape =  Crypt::UrldeCrypt($id3);
        $comite = Comite::find($idcomite);
        $idcategorie = $comite->id_categorie_comite;



        if ($request->isMethod('put')) {

            $data = $request->all();

            //dd($data); // Auth::user()->id
            if($data['action'] === 'Traiter_action_formation_valider_critere_prf_valider_cc'){
                //dd(strtotime(now()));

                //$actionplan = ActionFormationPlan::find($idactionformation);
                // Id projet formation
                $idprojetformation = $idactionformation;
                // Recuperation du projet de formation
                $projetformation = ProjetFormation::find($idprojetformation);
                //dd($projetformation);
                $projetformation->flag_coordination = true;
                $projetformation->save();
                //dd($projetformation);

                $idplan = $projetformation->id_projet_formation;




                Audit::logSave([

                    'action'=>'VALIDATION PROJET FORMATION',

                    'code_piece'=>$idactionformation,

                    'menu'=>'COMITES COORDINATION' . '/ ID VALIDATEUR :' . Auth::user()->id,

                    'etat'=>'Succès',

                    'objet'=>'Validation du projet de formation comité de coordination'

                ]);

                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/projetformation')->with('success', 'Succes : Le projet de formation a été validé en comité de coordination ');

            }
           if($data['action'] === 'Traiter_action_formation_valider_critere_prf_valider'){
           //dd($data);

            //$actionplan = ActionFormationPlan::find($idactionformation);
            // Id projet formation
            $idprojetformation = $idactionformation;
            // Recuperation du projet de formation
            $projetformation = ProjetFormation::find($idprojetformation);
            $projetformation->flag_processus_etape = true;
            $projetformation->save();
            // Modification des donnes
            $projetformation = ProjetFormation::find($idprojetformation);
            //dd($data['typeprojetformation']);
            $projetformation->titre_projet_etude = $data['titre_projet'];
            $projetformation->id_operateur = $data['operateur'];
            $projetformation->promoteur = $data['promoteur'];
            $projetformation->beneficiaires_cible = $data['beneficiaire_cible'];
            $projetformation->zone_projet = $data['zone_projey'];
            $projetformation->nom_prenoms = $data['nom_prenoms'];
            //$input['cout_projet_formation'] = $cout_projet_formation;
            $projetformation->fonction = $data['fonction'];
            $projetformation->telephone = $data['telephone'];
            //$projetformation->id_type_projet_formation = $data['typeprojetformation'];
            $projetformation->environnement_contexte = $data['environnement_contexte'];
            //$projetformation->id_domaine_projet_formation = $data['id_domaine'];
            $projetformation->cout_projet_instruction =  $data['cout_projet_instruction'];
            // $projetformation->acteurs = $data['acteurs_projet'];
            // $projetformation->role_p = $data['role_projet'];
            // $projetformation->responsabilite = $data['responsabilite_projet'];
            $projetformation->roles_beneficiaire = $data['roles_beneficiaire'];
            $projetformation->responsabilites_beneficiaires = $data['responsabilites_beneficiaires'];
            $projetformation->roles_promoteur = $data['roles_promoteur'];
            $projetformation->responsabilites_promoteur = $data['responsabilites_promoteur'];
            $projetformation->roles_partenaires = $data['roles_partenaires'];
            $projetformation->responsabilites_partenaires = $data['responsabilites_partenaires'];
            $projetformation->autre_acteur = $data['autre_acteur'];
            $projetformation->roles_autres = $data['roles_autres'];
            $projetformation->responsabilites_autres = $data['responsabilites_autres'];


            $projetformation->problemes = $data['problemes_odf'];
            $projetformation->manifestation_impact_effet = $data['manifestation_impacts_odf'];
            $projetformation->moyens_probables = $data['moyens_problemes_odf'];
            $projetformation->competences = $data['competences_odf'];
            $projetformation->evaluation_contexte = $data['evaluation_competences_odf'];
            $projetformation->source_verification = $data['sources_verification_odf'];
            $projetformation->save();
            //dd($projetformation);

            $idplan = $projetformation->id_projet_formation;




            Audit::logSave([

                'action'=>'VALIDATION PROJET FORMATION AU COMITE TECHNIQUE',

                'code_piece'=>$idactionformation,

                'menu'=>'COMITES',

                'etat'=>'Succès',

                'objet'=>'Validation du projet de formation comité technique'

            ]);

            return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/projetformation')->with('success', 'Succes : Le projet de formation a été validé ');

        }

           // Projet formation

           if($data['action'] === 'Traiter_action_formation_valider_critere_prf'){
            //dd($data);

            //$actionplan = ActionFormationPlan::find($idactionformation);
            // Id projet formation
            $idprojetformation = $idactionformation;
            // Recuperation du projet de formation
            $projetformation = ProjetFormation::find($idprojetformation);

            $idplan = $projetformation->id_projet_formation;

            //dd($data);

            $lignescriterevalides = CritereEvaluation::Join('categorie_comite','critere_evaluation.id_categorie_comite','categorie_comite.id_categorie_comite')
                                    ->join('processus_comite','critere_evaluation.id_processus_comite','processus_comite.id_processus_comite')
                                    ->where([['critere_evaluation.flag_critere_evaluation','=',true],
                                            ['categorie_comite.code_categorie_comite','=','CT'],
                                            ['processus_comite.code_processus_comite','=','PRF']])
                                    ->get();
            //dd($lignescriterevalides);
            if ($idcategorie == 2) {
                //dd('1');
                foreach ($lignescriterevalides as $uneligne) {

                    $id_critere_evaluation = $data["id_critere_evaluation/$uneligne->id_critere_evaluation"];
                    $flag_traitement_par_critere_commentaire = $data["flag_traitement_par_critere_commentaire/$uneligne->id_critere_evaluation"];
                    $commentaire_critere = $data["commentaire_critere/$uneligne->id_critere_evaluation"];

                    $traitementcritere = TraitementParCriterePrfCoord::create([
                        'id_user_traitement_par_critere' => Auth::user()->id,
                        //'id_demande' => $idactionformation,
                        'id_projet_formation' => $idactionformation,
                        'id_critere_evaluation' => $id_critere_evaluation,
                        //'code_traitement' => 'PRF',
                        'flag_critere_evaluation' => true,
                    ]);

                    $traitementcommentaire = TraitementParCritereCommentairePrfCoord::create([
                        'id_user_traitement_par_critere_commentaire' => Auth::user()->id,
                        'id_traitement_par_critere' => $traitementcritere->id_traitement_par_critere,
                        'flag_traitement_par_critere_commentaire' => $flag_traitement_par_critere_commentaire,
                       // 'code_traitement' => 'PRF',
                        'commentaire_critere' => $commentaire_critere,
                    ]);

                }
            }else{
                foreach ($lignescriterevalides as $uneligne) {

                    $id_critere_evaluation = $data["id_critere_evaluation/$uneligne->id_critere_evaluation"];
                    $flag_traitement_par_critere_commentaire = $data["flag_traitement_par_critere_commentaire/$uneligne->id_critere_evaluation"];
                    $commentaire_critere = $data["commentaire_critere/$uneligne->id_critere_evaluation"];

                    $traitementcritere = TraitementParCriterePrf::create([
                        'id_user_traitement_par_critere' => Auth::user()->id,
                        //'id_demande' => $idactionformation,
                        'id_projet_formation' => $idactionformation,
                        'id_critere_evaluation' => $id_critere_evaluation,
                        //'code_traitement' => 'PRF',
                        'flag_critere_evaluation' => true,
                    ]);

                    $traitementcommentaire = TraitementParCritereCommentairePrf::create([
                        'id_user_traitement_par_critere_commentaire' => Auth::user()->id,
                        'id_traitement_par_critere' => $traitementcritere->id_traitement_par_critere,
                        'flag_traitement_par_critere_commentaire' => $flag_traitement_par_critere_commentaire,
                       // 'code_traitement' => 'PRF',
                        'commentaire_critere' => $commentaire_critere,
                    ]);

                }
                //dd('2');
            }
            //dd($idcategorie);

            // foreach ($lignescriterevalides as $uneligne) {

            //     $id_critere_evaluation = $data["id_critere_evaluation/$uneligne->id_critere_evaluation"];
            //     $flag_traitement_par_critere_commentaire = $data["flag_traitement_par_critere_commentaire/$uneligne->id_critere_evaluation"];
            //     $commentaire_critere = $data["commentaire_critere/$uneligne->id_critere_evaluation"];

            //     $traitementcritere = TraitementParCriterePrf::create([
            //         'id_user_traitement_par_critere' => Auth::user()->id,
            //         //'id_demande' => $idactionformation,
            //         'id_projet_formation' => $idactionformation,
            //         'id_critere_evaluation' => $id_critere_evaluation,
            //         //'code_traitement' => 'PRF',
            //         'flag_critere_evaluation' => true,
            //     ]);

            //     $traitementcommentaire = TraitementParCritereCommentairePrf::create([
            //         'id_user_traitement_par_critere_commentaire' => Auth::user()->id,
            //         'id_traitement_par_critere' => $traitementcritere->id_traitement_par_critere,
            //         'flag_traitement_par_critere_commentaire' => $flag_traitement_par_critere_commentaire,
            //        // 'code_traitement' => 'PRF',
            //         'commentaire_critere' => $commentaire_critere,
            //     ]);

            // }
            // Mise a jour du projet de formation
            // $projetformation->flag_comite_pleiniere = true ;
            // $projetformation->save()  ;
            // Mise en commentaire, cette mise a jour sera effectué sur la validation du cahoer.


            Audit::logSave([

                'action'=>'MODIFIER / AJOUT DE COMMENTAIRE SUR UN COMITE TECHNIQUE PRF',

                'code_piece'=>$idactionformation,

                'menu'=>'COMITES',

                'etat'=>'Succès',

                'objet'=>'TENUE DE COMITES TECHNIQUES(traitement par les critéres )'

            ]);

            return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/projetformation')->with('success', 'Succes : Enregistrement reussi ');

        }

           // Plan formation



            if($data['action'] === 'Traiter_action_formation_valider_correction'){

                $actionplan = ActionFormationPlan::find($idactionformation);

                $idplan = $actionplan->id_plan_de_formation;

                $this->validate($request, [
                    'cout_accorde_action_formation' => 'required',
                    'commentaire_comite_technique' => 'required',
                ],[
                    'cout_accorde_action_formation.required' => 'Veuillez ajouter le montant accordé.',
                    'commentaire_comite_technique.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();


                $input['cout_accorde_action_formation'] = str_replace(' ', '', $input['cout_accorde_action_formation']);

                if($input['cout_accorde_action_formation']==0){

                    $this->validate($request, [
                        'motif_non_financement_action_formation' => 'required'
                    ],[
                        'motif_non_financement_action_formation.required' => 'Veuillez selectionnez le motif de non financement.',
                    ]);

                    $input['flag_valide_action_formation_pl'] = true;

                    $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];


                    $actionplanupdate = ActionFormationPlan::find($idactionformation);

                    $nombredejour = $input['nombre_heure_action_formation_p']/8;

                    $input['nombre_jour_action_formation'] = $nombredejour;

                    //$infoscaracteristique = CaracteristiqueTypeFormation::find($actionplanupdate->id_caracteristique_type_formation);

                    $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

                    $input['cout_action_formation_plan'] = $actionplanupdate->cout_action_formation_plan;


                    if($infoscaracteristique->code_ctf == "CGF"){

                        $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_'];

                    }

                    if($infoscaracteristique->code_ctf == "CSF"){

                        $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati'];

                    }

                    if($infoscaracteristique->code_ctf == "CFD"){

                        $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                    }

                    if($infoscaracteristique->code_ctf == "CCEF"){

                        $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;

                    }

                    if($infoscaracteristique->code_ctf == "CSEF"){

                        $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                    }

                    $input['montant_attribuable_fdfp'] = $montantcoutactionattribuable;

                    $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                    if($coutaccordeactionformation > $montantcoutactionattribuable){
                        $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                    }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                        $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                    }else{
                        $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                    }

                    //dd($input['cout_accorde_action_formation'],$input['montant_attribuable_fdfp']);

                    $actionplanupdate->update($input);

                    $infosficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$idactionformation]])->first();
                    $idficheagre = $infosficheagrement->id_fiche_agrement;
                    $infosfchieupdate = FicheADemandeAgrement::find($idficheagre);
                    $infosfchieupdate->update($input);

                }else{

                    $input['flag_valide_action_formation_pl'] = true;

                    $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];

                    $actionplanupdate = ActionFormationPlan::find($idactionformation);

                    $nombredejour = $input['nombre_heure_action_formation_p']/8;

                    $input['nombre_jour_action_formation'] = $nombredejour;

                    //$infoscaracteristique = CaracteristiqueTypeFormation::find($actionplanupdate->id_caracteristique_type_formation);

                    $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

                    $input['cout_action_formation_plan'] = $actionplanupdate->cout_action_formation_plan;


                    if($infoscaracteristique->code_ctf == "CGF"){

                        $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_'];

                    }

                    if($infoscaracteristique->code_ctf == "CSF"){

                        $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati'];

                    }

                    if($infoscaracteristique->code_ctf == "CFD"){

                        $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                    }

                    if($infoscaracteristique->code_ctf == "CCEF"){

                        $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;

                    }

                    if($infoscaracteristique->code_ctf == "CSEF"){

                        $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                    }

                    $input['montant_attribuable_fdfp'] = $montantcoutactionattribuable;

                    $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                    if($coutaccordeactionformation > $montantcoutactionattribuable){
                        $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                    }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                        $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                    }else{
                        $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                    }

                    $actionplanupdate->update($input);

                    $infosficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$idactionformation]])->first();
                    $idficheagre = $infosficheagrement->id_fiche_agrement;
                    $infosfchieupdate = FicheADemandeAgrement::find($idficheagre);
                    $infosfchieupdate->update($input);

                }

                if(isset($input['id_but_formation'])){
                    $tab = $input['id_but_formation'];

                    if(count($tab)>=1){
                        $butagrements = FicheAgrementButFormation::where([['id_fiche_agrement','=',$idficheagre]])->get();

                        foreach ($butagrements as $butagrement) {
                            FicheAgrementButFormation::where([['id_fiche_a_agrement_but_formation','=',$butagrement->id_fiche_a_agrement_but_formation]])->delete();
                        }

                        foreach ($tab as $key => $value) {
                            //dd($value); exit;
                            FicheAgrementButFormation::create([
                                'id_fiche_agrement'=> $idficheagre,
                                'id_but_formation'=> $value,
                                'flag_fiche_a_agrement_but_formation'=>true
                            ]);
                        }
                    }
                }

                Audit::logSave([

                    'action'=>'MODIFIER',

                    'code_piece'=>$idactionformation,

                    'menu'=>'COMITES',

                    'etat'=>'Succès',

                    'objet'=>'TENUE DE COMITES TECHNIQUES(traitement pour la prise en compte des remarques )'

                ]);

                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/planformation')->with('success', 'Succes : Enregistrement reussi ');

            }

/*             if($data['action'] === 'Traiter_action_formation_valider'){

                $actionplan = ActionFormationPlan::find($idactionformation);

                $idplan = $actionplan->id_plan_de_formation;

                $input['flag_action_formation_traiter_comite_technique'] = true;
                $actionplan->update($input);

                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/planformation')->with('success', 'Succes : Enregistrement reussi ');

            } */

            if($data['action'] === 'Traiter_action_formation_valider_reponse'){

                $actionplan = ActionFormationPlan::find($idactionformation);

                $idplan = $actionplan->id_plan_de_formation;

                $data = $request->all();
//dd($data['flag_traitement_par_critere_commentaire_traiter']);
                if($data['flag_traitement_par_critere_commentaire_traiter'] == "false"){
                    //dd($data);
                    $this->validate($request, [
                        'commentaire_reponse' => 'required',
                    ],[
                        'commentaire_reponse.required' => 'Veuillez ajouter un commentaire.',
                    ]);



                    $infoscriterecommentaire = TraitementParCritereCommentaire::find($data['id_traitement_par_critere_commentaire']);

                    $inputIn['commentaire_reponse'] = $data['commentaire_reponse'];
                    $inputIn['flag_traitement_par_critere_commentaire_traiter'] = $data['flag_traitement_par_critere_commentaire_traiter'];
                    $inputIn['flag_traite_par_user_conserne'] = true;
                    $infoscriterecommentaire->update($inputIn);

                    return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/planformation')->with('success', 'Succes : Mise à jour reussi ');


                }elseif($data['flag_traitement_par_critere_commentaire_traiter'] == "true"){

                    $infoscriterecommentaire = TraitementParCritereCommentaire::find($data['id_traitement_par_critere_commentaire']);

                    $inputIn['commentaire_reponse'] = $data['commentaire_reponse'];
                    $inputIn['flag_traitement_par_critere_commentaire_traiter'] = $data['flag_traitement_par_critere_commentaire_traiter'];
                    $inputIn['flag_traite_par_user_conserne'] = true;
                    $infoscriterecommentaire->update($inputIn);

                    return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/planformation')->with('success', 'Succes : Mise à jour reussi ');


                }else{
                    return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/planformation')->with('error', 'Erreur : Veuillez selectionnez le Statut pour le traitement des remarques ');

                }


            }



        }
    }


    public function cahierupdateprojetetude(Request $request, $id, $id1, $id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id1;

        if ($request->isMethod('put')) {
            $projet_etude = ProjetEtude::find($id);

            if($request->action === 'Modifier'){
                $projet_etude->titre_projet_instruction = $request->titre_projet_instruction;
                $projet_etude->contexte_probleme_instruction = $request->contexte_probleme_instruction;
                $projet_etude->objectif_general_instruction = $request->objectif_general_instruction;
                $projet_etude->objectif_specifique_instruction = $request->objectif_specifique_instruction;
                $projet_etude->resultat_attendus_instruction = $request->resultat_attendu_instruction;
                $projet_etude->champ_etude_instruction = $request->champ_etude_instruction;
                $projet_etude->cible_instruction = $request->cible_instruction;
                $projet_etude->id_domaine_projet_instruction = $request->id_domaine_projet_instruction;
                $projet_etude->methodologie_instruction = $request->methodologie_instruction;
                $projet_etude->montant_projet_instruction = str_replace(' ', '', $request->montant_projet_instruction);
                if (isset($request->fichier_instruction)){
                    $filefront = $request->fichier_instruction;
                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){
                        $fileName1 = 'fichier_instruction'. '_' . rand(111,99999) . '_' . 'fichier_instruction' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces_projet/fichier_instruction/'), $fileName1);
                        $projet_etude->piece_jointe_instruction = $fileName1;
                    }else{
                        return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit/projetetude')->with('error', 'Veuillez changer le type de fichier de l\'instruction');
                    }
                }
                $projet_etude->update();
                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit/projetetude')->with('success', 'Succès : Projet d\'étude modifié avec succès ');
            }

            if($request->action === 'Traiter_valider_projet'){
                $comite = Comite::find($idcomite);
                if(@$comite->categorieComite->type_code_categorie_comite=='CT'){
                    $projet_etude->flag_valider_ct_pleniere_projet_etude = true;
                    $projet_etude->date_valider_ct_pleniere_projet_etude = now();
                    $projet_etude->update();
                    return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Le projet d\'étude a été traité');
                }

                if(@$comite->categorieComite->type_code_categorie_comite=='CC'){
                    $projet_etude->flag_valider_cc_projet_etude = true;
                    $projet_etude->date_valider_cc_projet_etude = now();
                    $projet_etude->update();
                    return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Le projet d\'étude a été traité');
                }
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

    public function informationaction($id, $id1)
    {

        $id =  Crypt::UrldeCrypt($id);

        $iduser = $id1;

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','domaine_formation.*','type_formation.*','caracteristique_type_formation.*')
        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
        ->join('caracteristique_type_formation','action_formation_plan.id_caracteristique_type_formation','=','caracteristique_type_formation.id_caracteristique_type_formation')
        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
        ->join('domaine_formation','action_formation_plan.id_domaine_formation','=','domaine_formation.id_domaine_formation')
        ->where([['action_formation_plan.id_action_formation_plan','=',$id]])
        ->first();

        //dd($infosactionplanformations);
        /*$butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }*/

        $butformations = FicheAgrementButFormation::where([['id_fiche_agrement','=',$infosactionplanformations->id_fiche_agrement]])->get();

        $traitement = TraitementParCritere::Join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
        ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
        ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
        ->where([['traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','=',$iduser],['traitement_par_critere.id_action_formation_plan','=',$id]])->get();

        $criteres = CritereEvaluation::Join('categorie_comite','critere_evaluation.id_categorie_comite','categorie_comite.id_categorie_comite')
                                    ->join('processus_comite','critere_evaluation.id_processus_comite','processus_comite.id_processus_comite')
                                    ->where([['critere_evaluation.flag_critere_evaluation','=',true],
                                            ['categorie_comite.code_categorie_comite','=','CT'],
                                            ['processus_comite.code_processus_comite','=','PF']])
                                    ->get();

        return response()->json(['information'=>$infosactionplanformations, 'butformations'=>$butformations , 'traitement'=>$traitement, 'criteres'=>$criteres]);

    }

    public function commentairetoutuser($id)
    {

        $id =  Crypt::UrldeCrypt($id);

        $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','traitement_par_critere_commentaire.created_at as datej','critere_evaluation.*','users.name as name','users.prenom_users as prenom_users','roles.name as profil')
                        ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                        ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                        ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
                        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                        ->join('roles', 'model_has_roles.role_id', 'roles.id')
                        ->where([['flag_demission_users', '=', false],
                                ['flag_admin_users', '=', false],
                                ['roles.id', '!=', 15]])
                        ->where([['traitement_par_critere.id_action_formation_plan','=',$id]])->get();

        return response()->json(['information'=>$traitement]);

    }

    public function traitementactionformation(Request $request, $id): JsonResponse
    {

        $id =  Crypt::UrldeCrypt($id);
        $actionplan = ActionFormationPlan::find($id);

        $idplan = $actionplan->id_plan_de_formation;

        $data = $request->all();
        //dd($data);

        $lignescriterevalides = CritereEvaluation::Join('categorie_comite','critere_evaluation.id_categorie_comite','categorie_comite.id_categorie_comite')
                                ->join('processus_comite','critere_evaluation.id_processus_comite','processus_comite.id_processus_comite')
                                ->where([['critere_evaluation.flag_critere_evaluation','=',true],
                                        ['categorie_comite.code_categorie_comite','=','CT'],
                                        ['processus_comite.code_processus_comite','=','PF']])
                                ->get();

        foreach ($lignescriterevalides as $uneligne) {

            $id_critere_evaluation = $data["id_critere_evaluation/$uneligne->id_critere_evaluation"];
            $flag_traitement_par_critere_commentaire = $data["flag_traitement_par_critere_commentaire/$uneligne->id_critere_evaluation"];
            $commentaire_critere = $data["commentaire_critere/$uneligne->id_critere_evaluation"];

            $traitementcritere = TraitementParCritere::create([
                'id_user_traitement_par_critere' => Auth::user()->id,
                'id_demande' => $idplan,
                'id_action_formation_plan' => $id,
                'id_critere_evaluation' => $id_critere_evaluation,
                'flag_critere_evaluation' => true,
            ]);

            $traitementcommentaire = TraitementParCritereCommentaire::create([
                'id_user_traitement_par_critere_commentaire' => Auth::user()->id,
                'id_traitement_par_critere' => $traitementcritere->id_traitement_par_critere,
                'flag_traitement_par_critere_commentaire' => $flag_traitement_par_critere_commentaire,
                'commentaire_critere' => $commentaire_critere,
            ]);

        }


        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES TECHNIQUES(traitement par les critéres )'

        ]);

        return response()->json(['success' => 'mise a jour effectué']);
    }

    public function traitementactionformationcorriger(Request $request, $id): JsonResponse
    {

        $id =  Crypt::UrldeCrypt($id);
        $actionplan = ActionFormationPlan::find($id);

        $idplan = $actionplan->id_plan_de_formation;

        $data = $request->all();
        //dd($data);die();

        if(isset($data['is_valide'])){

            $actionplan = ActionFormationPlan::find($id);

            $idplan = $actionplan->id_plan_de_formation;

            $input['flag_action_formation_traiter_comite_technique'] = true;
            $actionplan->update($input);

            Audit::logSave([

                'action'=>'MODIFIER',

                'code_piece'=>$id,

                'menu'=>'COMITES',

                'etat'=>'Succès',

                'objet'=>'TENUE DE COMITES TECHNIQUES(traitement par les critéres )'

            ]);

            return response()->json(['success' => 'mise a jour effectué']);

        }else{

            $actionplan = ActionFormationPlan::find($id);

            $idplan = $actionplan->id_plan_de_formation;

            $this->validate($request, [
                'cout_accorde_action_formation' => 'required',
                'commentaire_comite_technique' => 'required',
            ],[
                'cout_accorde_action_formation.required' => 'Veuillez ajouter le montant accordé.',
                'commentaire_comite_technique.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();


            $input['cout_accorde_action_formation'] = str_replace(' ', '', $input['cout_accorde_action_formation']);

            if($input['cout_accorde_action_formation']==0){

                $this->validate($request, [
                    'motif_non_financement_action_formation' => 'required'
                ],[
                    'motif_non_financement_action_formation.required' => 'Veuillez selectionnez le motif de non financement.',
                ]);

                $input['flag_valide_action_formation_pl'] = true;

                $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];


                $actionplanupdate = ActionFormationPlan::find($id);

                $nombredejour = $input['nombre_heure_action_formation_p']/8;

                $input['nombre_jour_action_formation'] = $nombredejour;

                //$infoscaracteristique = CaracteristiqueTypeFormation::find($actionplanupdate->id_caracteristique_type_formation);

                $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

                $input['cout_action_formation_plan'] = $actionplanupdate->cout_action_formation_plan;


                if($infoscaracteristique->code_ctf == "CGF"){

                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_'];

                }

                if($infoscaracteristique->code_ctf == "CSF"){

                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati'];

                }

                if($infoscaracteristique->code_ctf == "CFD"){

                    $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                }

                if($infoscaracteristique->code_ctf == "CCEF"){

                    $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;

                }

                if($infoscaracteristique->code_ctf == "CSEF"){

                    $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                }

                $input['montant_attribuable_fdfp'] = $montantcoutactionattribuable;

                $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                if($coutaccordeactionformation > $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }else{
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }

                //dd($input['cout_accorde_action_formation'],$input['montant_attribuable_fdfp']);

                $actionplanupdate->update($input);

                $infosficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$id]])->first();
                $idficheagre = $infosficheagrement->id_fiche_agrement;
                $infosfchieupdate = FicheADemandeAgrement::find($idficheagre);
                $infosfchieupdate->update($input);

            }else{

                $input['flag_valide_action_formation_pl'] = true;

                $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];

                $actionplanupdate = ActionFormationPlan::find($id);

                $nombredejour = $input['nombre_heure_action_formation_p']/8;

                $input['nombre_jour_action_formation'] = $nombredejour;

                //$infoscaracteristique = CaracteristiqueTypeFormation::find($actionplanupdate->id_caracteristique_type_formation);

                $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

                $input['cout_action_formation_plan'] = $actionplanupdate->cout_action_formation_plan;


                if($infoscaracteristique->code_ctf == "CGF"){

                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_'];

                }

                if($infoscaracteristique->code_ctf == "CSF"){

                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati'];

                }

                if($infoscaracteristique->code_ctf == "CFD"){

                    $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                }

                if($infoscaracteristique->code_ctf == "CCEF"){

                    $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;

                }

                if($infoscaracteristique->code_ctf == "CSEF"){

                    $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                }

                $input['montant_attribuable_fdfp'] = $montantcoutactionattribuable;

                $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                if($coutaccordeactionformation > $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }else{
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }

                $actionplanupdate->update($input);

                $infosficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$id]])->first();
                $idficheagre = $infosficheagrement->id_fiche_agrement;
                $infosfchieupdate = FicheADemandeAgrement::find($idficheagre);
                $infosfchieupdate->update($input);

            }

            if(isset($input['id_but_formation'])){
                $tab = $input['id_but_formation'];

                if(count($tab)>=1){
                    $butagrements = FicheAgrementButFormation::where([['id_fiche_agrement','=',$idficheagre]])->get();

                    foreach ($butagrements as $butagrement) {
                        FicheAgrementButFormation::where([['id_fiche_a_agrement_but_formation','=',$butagrement->id_fiche_a_agrement_but_formation]])->delete();
                    }

                    foreach ($tab as $key => $value) {
                        //dd($value); exit;
                        FicheAgrementButFormation::create([
                            'id_fiche_agrement'=> $idficheagre,
                            'id_but_formation'=> $value,
                            'flag_fiche_a_agrement_but_formation'=>true
                        ]);
                    }
                }
            }


            Audit::logSave([

                'action'=>'MODIFIER',

                'code_piece'=>$id,

                'menu'=>'COMITES',

                'etat'=>'Succès',

                'objet'=>'TENUE DE COMITES TECHNIQUES(traitement par les critéres )'

            ]);

            return response()->json(['success' => 'mise a jour effectué']);

        }

    }
}
