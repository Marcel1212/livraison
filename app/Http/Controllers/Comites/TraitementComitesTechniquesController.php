<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
use App\Models\Cahier;
use App\Models\Comite;
use App\Models\FormeJuridique;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use Illuminate\Http\Request;
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
use App\Helpers\Menu;
use App\Models\ActionFormationPlan;
use App\Models\ButFormation;
use App\Models\CahierComite;
use App\Models\CaracteristiqueTypeFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\ComiteParticipant;
use App\Models\CritereEvaluation;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PlanFormation;
use App\Models\ProcessusComiteLieComite;
use App\Models\SecteurActivite;
use App\Models\TraitementParCritere;
use App\Models\TraitementParCritereCommentaire;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;

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

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id1]])->get();

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id1]])->get();

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


    public function editprojetetude($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;


//        $comite = Comite::find($id);
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

                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
                foreach ($secteuractivite_projets as $comp) {
                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
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
                        'secteuractivite_projet',
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

        if ($request->isMethod('put')) {

            $data = $request->all();

           // dd($data);

            if($data['action'] === 'Traiter_action_formation_valider_critere'){

                $actionplan = ActionFormationPlan::find($idactionformation);

                $idplan = $actionplan->id_plan_de_formation;

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
                        'id_action_formation_plan' => $idactionformation,
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

                    'code_piece'=>$idactionformation,

                    'menu'=>'COMITES',

                    'etat'=>'Succès',

                    'objet'=>'TENUE DE COMITES TECHNIQUES(traitement par les critéres )'

                ]);

                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/planformation')->with('success', 'Succes : Enregistrement reussi ');

            }

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

                Audit::logSave([

                    'action'=>'MODIFIER',

                    'code_piece'=>$idactionformation,

                    'menu'=>'COMITES',

                    'etat'=>'Succès',

                    'objet'=>'TENUE DE COMITES TECHNIQUES(traitement pour la prise en compte des remarques )'

                ]);

                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/planformation')->with('success', 'Succes : Enregistrement reussi ');

            }

            if($data['action'] === 'Traiter_action_formation_valider'){

                $actionplan = ActionFormationPlan::find($idactionformation);

                $idplan = $actionplan->id_plan_de_formation;

                $input['flag_action_formation_traiter_comite_technique'] = true;
                $actionplan->update($input);

                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($etape).'/edit/planformation')->with('success', 'Succes : Enregistrement reussi ');

            }

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
                $projet_etude->flag_valider_ct_pleniere_projet_etude = true;
                $projet_etude->date_valider_ct_pleniere_projet_etude = now();
                $projet_etude->update();
                return redirect('traitementcomitetechniques/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Le projet d\'étude a été traité');
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
