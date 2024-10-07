<?php

namespace App\Http\Controllers\Habilitation;

use App\Http\Controllers\Controller;
use App\Models\Visites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Helpers\Audit;
use App\Helpers\Menu;
use App\Models\Banque;
use App\Models\DemandeIntervention;
use App\Models\DomaineDemandeHabilitation;
use App\Models\DomaineFormation;
use App\Models\Entreprises;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\InterventionHorsCi;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Pays;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeIntervention;
use App\Models\TypeMoyenPermanent;
use App\Models\TypeOrganisationFormation;
use App\Models\DemandeHabilitation;
use Carbon\Carbon;
use App\Models\Motif;
use App\Helpers\SmsPerso;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Email;
use App\Models\Competences;
use App\Models\Experiences;
use App\Models\Formateurs;
use App\Models\FormationsEduc;
use App\Models\LanguesFormateurs;
use App\Models\PrincipaleQualification;
use App\Models\RapportsVisites;
use App\Models\TypeDomaineDemandeHabilitationPublic;

class TraitementDemandeHabilitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $numAgce = Auth::user()->num_agce;
        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        if($codeRoles == 'CHEFSERVICE'){
            $habilitations = DB::table('vue_demande_habilitation_soumis_generale')->where([['id_agence','=',$numAgce]])->get();
        }else{
            $habilitations = DemandeHabilitation::where([['id_charge_habilitation','=',Auth::user()->id]])->get();
        }
        //dd($habilitations);
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'HABILITATION (Traitement)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.traitementdemandehabilitation.index',compact('habilitations'));
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
        $id =  Crypt::UrldeCrypt($id);

        $formateur = Formateurs::find($id);

        $qualification = PrincipaleQualification::where([['id_formateurs','=',$id]])->first();

        $formations = FormationsEduc::where([['id_formateurs','=',$id]])->get();

        $experiences = Experiences::where([['id_formateurs','=',$id]])->orderBy('date_de_debut', 'DESC')->get();

        $competences = Competences::where([['id_formateurs','=',$id]])->get();

        $languesformateurs = LanguesFormateurs::where([['id_formateurs','=',$id]])->get();

        Audit::logSave([

            'action'=>'Voir',

            'code_piece'=>$id,

            'menu'=>'FORMATEUR (CREATION DE FORMATEUR)',

            'etat'=>'Succès',

            'objet'=>'Voir le cv'

        ]);

        return view('habilitation.traitementdemandehabilitation.show', compact('id','formateur','qualification',
                        'formations','experiences','languesformateurs','competences'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        //dd($id);

        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($id);
        $demandehabilitation = DemandeHabilitation::find($id);

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

        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id]])->get();

        $typeinterventions = TypeIntervention::where([['flag_type_intervention','=',true]])->get();
        $typeinterventionsList = "<option value=''> Selectionnez le type d\'intervention </option>";
        foreach ($typeinterventions as $comp) {
            $typeinterventionsList .= "<option value='" . $comp->id_type_intervention  . "'>" . mb_strtoupper($comp->libelle_type_intervention) ." </option>";
        }

        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id]])->get();
        //dd($idetape);

        $organisationFormations = TypeOrganisationFormation::where([['flag_type_organisation_formation','=',true]])->get();
        $organisationFormationsList = "<option value=''> Selectionnez le type d\'organisation </option>";
        foreach ($organisationFormations as $comp) {
            $organisationFormationsList .= "<option value='" . $comp->id_type_organisation_formation  . "'>" . mb_strtoupper($comp->libelle_type_organisation_formation) ." </option>";
        }

        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id]])->get();

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

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        $domainedemandes = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();
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
                                                          ->where([['id_demande_habilitation','=',$id]])
                                                          ->get();


        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id]])->get();
       // dd($codeRoles);
        if($codeRoles == 'CHEFSERVICE'){
            //dd(Auth::user()->id_service);
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            $chargerHabilitationsList =  "<option value=''> Selectionnez le charge d\'habilitation </option>";
            foreach ($chargerHabilitations as $comp) {
                $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
            }

            $NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',Auth::user()->id_service]])->orderBy('nbre_dossier_en_cours','asc')->get();
        }else{
            $chargerHabilitations = [];
            $chargerHabilitationsList = [];
            $NombreDemandeHabilitation = [];
        }

        $motifs = Motif::where([['code_motif','=','HAB']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Traitement de HABILITATION)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);


        return view('habilitation.traitementdemandehabilitation.edit', compact('demandehabilitation','infoentreprise','banque','pay',
                    'id','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
                    'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
                    'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList',
                    'chargerHabilitationsList','NombreDemandeHabilitation','motif','typeDomaineDemandeHabilitationPublicList',
                    'visites','rapportVisite'));
    }



    public function fetchEvents(Request $request)
    {
        // $events = Visites::where([['id_charger_habilitation_visite','=',Auth::user()->id]])->get();
        // $eventsFormatted = [];

        // foreach ($events as $event) {
        //     $eventsFormatted[] = [
        //         'id' => $event->id_visites,
        //         'iddemandehabilitation' => $event->id_demande_habilitation,
        //         'title' => $event->demandeHabilitation->entreprise->sigl_entreprises,
        //         'start' => $event->date_visite,
        //         'end' => $event->heure_visite,
        //         'eventdescriptioneditor' => $event->description_lieu,
        //         'selectlabel' => $event->statut,
        //         'allDay' => true,
        //     ];
        // }

        // return response()->json($eventsFormatted);

            // Récupère tous les événements ou applique un filtre selon le statut
            $query = Visites::where([['id_charger_habilitation_visite','=',Auth::user()->id]]);

            // Applique un filtre de statut si présent
            if ($request->has('statut') && !empty($request->statut)) {
                $query->where('statut', $request->statut);
            }

            $events = $query->get();

            $calendarEvents = [];

            foreach ($events as $event) {
                // Attribuer une couleur en fonction du statut
                $eventColor = $this->getEventColorByStatus($event->statut);
                //dd($eventColor['background']);
                $calendarEvents[] = [
                    'id' => $event->id_visites,
                    'iddemandehabilitation' => $event->id_demande_habilitation,
                    'title' => $event->demandeHabilitation->entreprise->sigl_entreprises,
                    'start' => $event->date_visite,
                    'datevisite' => $event->date_visite,
                    'end' => $event->date_fin_visite,
                    'timestart' => $event->heure_visite,
                    'timeend' => $event->heure_visite_fin,
                    'timeendr' => $event->heure_visite_fin_reel,
                    'eventdescriptioneditor' => $event->description_lieu,
                    'selectlabel' => $event->statut,
                    'backgroundColor' => $eventColor['background'], // Couleur de fond
                    'textColor' => $eventColor['text'] // Couleur du texte
                ];
            }

            return response()->json($calendarEvents);
    }

    public function fetchEventsID(Request $request, $id)
    {


			// Récupérer l'événement spécifique
			$event = Visites::where('id_visites', '=', $id)->first();

			// Vérifier si l'événement existe
			if (!$event) {
				return response()->json(['error' => 'Événement non trouvé'], 404);
			}

            $cryptedDemandeId = Crypt::UrlCrypt($event->id_demande_habilitation);
            $cryptedFixedValue = Crypt::UrlCrypt(9);

            $url = route('traitementdemandehabilitation.edit', [$cryptedDemandeId, $cryptedFixedValue]);


			// Structurer l'événement pour l'API JSON
			$calendarEvent = [
				'id' => $event->id_visites,
				'iddemandehabilitation' => $event->id_demande_habilitation,
				'title' => $event->demandeHabilitation->entreprise->sigl_entreprises,
				'start' => $event->date_visite,
				'datevisite' => $event->date_visite,
				'end' => $event->date_fin_visite,
				'timestart' => $event->heure_visite,
				'timeend' => $event->heure_visite_fin,
				'timeendr' => $event->heure_visite_fin_reel,
				'eventdescriptioneditor' => $event->description_lieu,
				'selectlabel' => $event->statut,
				'url' => $url,
			];

			// Retourner la réponse en JSON
			return response()->json($calendarEvent);
    }

    /**
 * Retourne une couleur pour un statut donné
 */
    private function getEventColorByStatus($status)
    {
        switch ($status) {
            case 'planifier':
                return ['background' => '#0d6efd', 'text' => '#ffffff']; // Bleu
            case 'commencer':
                return ['background' => '#17a2b8', 'text' => '#ffffff']; // Cyan
            case 'terminer':
                return ['background' => '#28a745', 'text' => '#ffffff']; // Vert
            case 'annuler':
                return ['background' => '#dc3545', 'text' => '#ffffff']; // Rouge
            case 'reporter':
                return ['background' => '#ffc107', 'text' => '#000000']; // Jaune
            default:
                return ['background' => '#6c757d', 'text' => '#ffffff']; // Gris par défaut
        }
    }

/*     public function storeviste(Request $request,$id)
    {
       // dd($request);
       if ($request->isMethod('put')) {
            $this->validate($request, [
                'iddemandehabilitation' => 'required',
                'start' => 'required',
                'selectlabel' => 'required',
                'end' => 'required',
                'eventdescriptioneditor' => 'required',
            ],[
                'iddemandehabilitation.required' => 'Veuillez ajouter une demande.',
                'start.required' => 'Veuillez ajouter une date de debut.',
                'selectlabel.required' => 'Veuillez ajouter un statut.',
                'end.required' => 'Veuillez ajouter une heure.',
                'eventdescriptioneditor.required' => 'Veuillez ajouter une description.',
            ]);

            $visite = Visites::find($request->input('iddemandehabilitation'));

            if (isset($visite)) {
                return response()->json(['status' => 'Cette demande a deja un rendez-vous, Vous pouvez modifier le rendez-vous'],400);
            }

            $visite = new Visites();
            $visite->id_demande_habilitation = $request->input('iddemandehabilitation');
            $visite->date_visite = $request->input('start');
            $visite->date_fin_visite = $request->input('start');
            $visite->statut = $request->input('selectlabel');
            $visite->heure_visite = $request->input('end');
            $visite->description_lieu = $request->input('eventdescriptioneditor');
            $visite->save();
        }

        return response()->json(['status' => 'Evenement ajouter avec success'], 200);
    } */

    public function rapportvisite(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            // Validation des données
            $request->validate([
                'etat_locaux_rapport' => 'required',
                'equipement_rapport' => 'required',
                'salubrite_rapport' => 'required',
                'avis_comite_technique' => 'required',
                //'id_demande_habilitation' => 'required',
            ], [
                'etat_locaux_rapport.required' => 'Veuillez ajouter un commentaire pour les locaux.',
                'equipement_rapport.required' => 'Veuillez ajouter un commentaire pour les equipement.',
                'salubrite_rapport.required' => 'Veuillez ajouter un commentaire pour la salubrite / securité.',
                'avis_comite_technique.required' => 'Veuillez ajouter un avis pour le comite technique.',
                //'id_demande_habilitation.required' => 'La demande est requise.',
            ]);

          //  dd($request->all());
            //dd($id);

            // Vérification si une visite existe déjà
            $visite = Visites::where([['id_demande_habilitation','=',$id]])->first();

            $input = $request->all();
            $input['id_visites'] = $visite->id_visites;

            $rap = RapportsVisites::create($input);

            return response()->json(['status' => 'Rapport ajouté avec succès'], 200);
        }

        return response()->json(['status' => 'Méthode non autorisée'], 405);
    }

    public function storevisite(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            // Validation des données
            $request->validate([
                //'iddemandehabilitation' => 'required',
                'start' => 'required|date',
                'selectlabel' => 'required',
                'end' => 'required',
                'endfin' => 'required',
                'eventdescriptioneditor' => 'required',
            ], [
                //'iddemandehabilitation.required' => 'Veuillez ajouter une demande.',
                'start.required' => 'Veuillez ajouter une date de début.',
                'selectlabel.required' => 'Veuillez ajouter un statut.',
                'end.required' => 'Veuillez ajouter une heure de debut provisoire.',
                'endfin.required' => 'Veuillez ajouter une heure de fin provisoire.',
                'eventdescriptioneditor.required' => 'Veuillez ajouter une description.',
            ]);

           // dd($id);

            // Vérification si une visite existe déjà
            $visiteExists = Visites::where('id_demande_habilitation', $id)->exists();

            if ($visiteExists) {
                return response()->json([
                    'errors' => 'Cette demande a déjà un rendez-vous, vous pouvez modifier le rendez-vous.'
                ], 400);
            }

            $dateDebut = $request->start;
            $dateFin = $request->start;

            $heureDebut = $request->end;
            $heureFin = $request->endfin;

            if (strpos($heureDebut, ':') === strrpos($heureDebut, ':')) {
                // Format sans secondes
                $dateEtHeureDebut = Carbon::createFromFormat('Y-m-d H:i', $dateDebut . ' ' . $heureDebut);
            } else {
                // Format avec secondes
                $dateEtHeureDebut = Carbon::createFromFormat('Y-m-d H:i:s', $dateDebut . ' ' . $heureDebut);
            }

            if (strpos($heureFin, ':') === strrpos($heureFin, ':')) {
                // Format sans secondes
                $dateEtHeureFin = Carbon::createFromFormat('Y-m-d H:i', $dateFin . ' ' . $heureFin);
            } else {
                // Format avec secondes
                $dateEtHeureFin = Carbon::createFromFormat('Y-m-d H:i:s', $dateFin . ' ' . $heureFin);
            }

            // Création d'une nouvelle visite
            $visite = Visites::create([
                'id_demande_habilitation' => $id,
                'date_visite' => $dateEtHeureDebut,
                'date_fin_visite' => $dateEtHeureFin,
                'statut' => $request->selectlabel,
                'heure_visite' => $request->end,
                'heure_visite_fin' => $request->endfin,
                'description_lieu' => $request->eventdescriptioneditor,
                'id_charger_habilitation_visite' => Auth::user()->id,
            ]);

            $logo = Menu::get_logo();
            $demandehabilitation = DemandeHabilitation::find($id);
            $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);
            if (isset($demandehabilitation->email_responsable_habilitation)) {
                $sujet = "Demande de prise de rendez-vous pour la demande habilitation sur e-FDFP";
                $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                $messageMail = "<b>Cher,  ".$infoentreprise->sigl_entreprises." ,</b>
                                <br><br>Nous avons le plaisir de vous notifie la demande de prise de rendez-vous pour la visite de votre locaux :

                                <br><b>Date de prise de rendez-vous  : </b> ".@$dateEtHeureDebut."
                                <br><b>Heure : </b> ".@$request->end."
                                <br><br>
                                <br><br>Pour plus d'information veuillez contactez votre charger habilitation par mail au : ".$visite->userchargerhabilitationvisite->email.".
                                    Cordialement,
                                    L'équipe e-FDFP
                                <br><br><br>
                                -----
                                Ceci est un mail automatique, Merci de ne pas y répondre.
                                -----
                                ";
                $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            }

                            //Envoi SMS Validé
                            if (isset($demandehabilitation->contact_responsable_habilitation)) {
                                $content = "Cher ".$infoentreprise->sigl_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE LE RENDEZ-VOUS POUR LA VISITE DE VOTRE LOCAUX EST: ".@$dateEtHeureDebut.". CORDIALEMENT, L EQUIPE E-FDFP";
                                SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                            }

            return response()->json(['status' => 'Événement ajouté avec succès'], 200);
        }

        return response()->json(['status' => 'Méthode non autorisée'], 405);
    }


    public function updatevisite(Request $request, $id)
    {
        //dd($id);
        if ($request->isMethod('post')) {
            // Validation des données
            $request->validate([
               // 'iddemandehabilitation' => 'required',
                'start' => 'required|date',
                'selectlabel' => 'required',
                'end' => 'required',
                'endfin' => 'required',
                'endfinR' => 'required',
                'eventdescriptioneditor' => 'required',
            ], [
                //'iddemandehabilitation.required' => 'Veuillez ajouter une demande.',
                'start.required' => 'Veuillez ajouter une date de début.',
                'selectlabel.required' => 'Veuillez ajouter un statut.',
                'end.required' => 'Veuillez ajouter une heure de debut provisoire.',
                'endfin.required' => 'Veuillez ajouter une heure de fin provisoire.',
                'endfinR.required' => 'Veuillez ajouter une heure de fin reel.',
                'eventdescriptioneditor.required' => 'Veuillez ajouter une description.',
            ]);

           // dd($id);

            $visitef = Visites::find($id);
           // $dv = Carbon::createFromFormat('Y-m-d H:i:s', $request->start . ' ' . $request->end);
            //dd($dv);

            $dateDebut = $request->start;
            $dateFin = $request->start;

            $heureDebut = $request->end;
            $heureFin = $request->endfin;

            if (strpos($heureDebut, ':') === strrpos($heureDebut, ':')) {
                // Format sans secondes
                $dateEtHeureDebut = Carbon::createFromFormat('Y-m-d H:i', $dateDebut . ' ' . $heureDebut);
            } else {
                // Format avec secondes
                $dateEtHeureDebut = Carbon::createFromFormat('Y-m-d H:i:s', $dateDebut . ' ' . $heureDebut);
            }

            if (strpos($heureFin, ':') === strrpos($heureFin, ':')) {
                // Format sans secondes
                $dateEtHeureFin = Carbon::createFromFormat('Y-m-d H:i', $dateFin . ' ' . $heureFin);
            } else {
                // Format avec secondes
                $dateEtHeureFin = Carbon::createFromFormat('Y-m-d H:i:s', $dateFin . ' ' . $heureFin);
            }
            //dd($request->all());
            $visite = $visitef->update([
                //'id_demande_habilitation' => $request->iddemandehabilitation,
                'date_visite' => $dateEtHeureDebut,
                'date_fin_visite' => $dateEtHeureFin,//Carbon::parse($request->start)->endOfDay(),
                'statut' => $request->selectlabel,
                'heure_visite' => $request->end,
                'heure_visite_fin' => $request->endfin,
                'heure_visite_fin_reel' => $request->endfinR,
                'description_lieu' => $request->eventdescriptioneditor,
                'id_charger_habilitation_visite' => Auth::user()->id,
            ]);

            $logo = Menu::get_logo();
            $demandehabilitation = DemandeHabilitation::find($visitef->id_demande_habilitation);
            $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);
            if (isset($demandehabilitation->email_responsable_habilitation)) {
                $sujet = "Demande de prise de rendez-vous pour la demande habilitation sur e-FDFP";
                $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                $messageMail = "<b>Cher,  ".$infoentreprise->sigl_entreprises." ,</b>
                                <br><br>Nous avons le plaisir de vous notifie la demande de prise de rendez-vous pour la visite de votre locaux :

                                <br><b>Date de prise de rendez-vous  : </b> ".@$dateEtHeureDebut."
                                <br><b>Heure : </b> ".@$request->end."
                                <br><br>
                                <br><br>Pour plus d'information veuillez contactez votre charger habilitation par mail au : ".$visitef->userchargerhabilitationvisite->email.".
                                    Cordialement,
                                    L'équipe e-FDFP
                                <br><br><br>
                                -----
                                Ceci est un mail automatique, Merci de ne pas y répondre.
                                -----
                                ";
                $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            }

                            //Envoi SMS Validé
                            if (isset($demandehabilitation->contact_responsable_habilitation)) {
                                $content = "Cher ".$infoentreprise->sigl_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE LE RENDEZ-VOUS POUR LA VISITE DE VOTRE LOCAUX EST: ".@$dateEtHeureDebut.". CORDIALEMENT, L EQUIPE E-FDFP";
                                SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                            }

            return response()->json(['status' => 'Événement modifié avec succès'], 200);
        }

        return response()->json(['status' => 'Méthode non autorisée'], 405);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id , $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $etape =  Crypt::UrldeCrypt($id1);

        $logo = Menu::get_logo();

        $demandehabilitation = DemandeHabilitation::find($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'FaireAttribution'){

                $this->validate($request, [
                    'id_charge_habilitation' => 'required'
                ],[
                    'id_charge_habilitation.required' => 'Veuillez selectionnez un charge d\'habilitation.'
                ]);

                $input = $request->all();

                $input['date_transmi_charge_habilitation'] = Carbon::now();
                $input['flag_soumis_charge_habilitation'] = true;
                $input['id_chef_service'] = Auth::user()->id;

                $demandehabilitation->update($input);

                return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if($data['action'] === 'Soumission_demande_ct'){

                $input = $request->all();
                $input['date_soumis_comite_technique'] = Carbon::now();
                $input['flag_soumis_comite_technique'] = true;

                $demandehabilitation->update($input);

                return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if($data['action'] === 'Recevable'){


                $input = $request->all();
                $dateanneeencours = Carbon::now()->format('Y');
                $input['flag_reception_demande_habilitation'] = true;
                if(!isset($demandehabilitation->code_demande_habilitation)){
                    $input['code_demande_habilitation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                }
                $input['date_reception_demande_habilitation'] = Carbon::now();

                //$demandehabilitation = DemandeHabilitation::find($id);
                $demandehabilitation->update($input);

                $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

                //Envoi SMS Validé
                if (isset($demandehabilitation->contact_responsable_habilitation)) {
                    $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE PLAN DE FORMATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
                    SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                }

                //Envoi email
                 if (isset($demandehabilitation->email_responsable_habilitation)) {
                    $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous sommes ravis de vous informer que votre demande d'habilitation est jugé recevable.
                                    <br><br>Nous apprécions votre intérêt pour notre services.<br>
                                    Cordialement,
                                    L'équipe e-FDFP
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

                }


                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'HABILITATION (Instruction: Recevabilité effectué avec succès.)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION'

                ]);

                return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Recevabilité effectué avec succès. ');

            }

            if($data['action'] === 'NonRecevable'){

                $this->validate($request, [
                    'id_motif_recevable' => 'required'
                ],[
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);

                $input = $request->all();
                $dateanneeencours = Carbon::now()->format('Y');
                $input['flag_reception_demande_habilitation'] = false;
                $input['flag_rejet_demande_habilitation'] = true;
                $input['flag_soumis_demande_habilitation'] = false;
                if(!isset($demandehabilitation->code_demande_habilitation)){
                    $input['code_demande_habilitation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                }
                $input['date_reception_demande_habilitation'] = Carbon::now();
                $input['date_rejet_demande_habilitation'] = Carbon::now();

                $demandehabilitation = DemandeHabilitation::find($id);
                $demandehabilitation->update($input);

                $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

                if (isset($demandehabilitation->email_responsable_habilitation)) {
                    $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous avons examiné votre demande habilitation sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

                                    <br><b>Motif de rejet  : </b> ".@$demandehabilitation->motif->libelle_motif."
                                    <br><b>Commentaire : </b> ".@$demandehabilitation->commentaire_recevable_plan_formation."
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
                    $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

                }

                //Envoi SMS Rejeté
                if (isset($demandehabilitation->contact_responsable_habilitation)) {
                    $content = "Cher ".$infoentreprise->sigl_entreprises.", Nous avons examiné votre demande  et malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :".@$demandehabilitation->motif->libelle_motif." Veuillez mettre a jour le dossier .
                        Cordialement,
                        L'équipe e-FDFP";
                    SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                }

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'HABILITATION (Instruction: La non-recevabilité a été effectué avec succès.)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION'

                ]);

                return redirect()->route('traitementdemandehabilitation.index')->with('success', 'Recevabilité effectué avec succès.');

            }


            if($data['action'] === 'Rapport'){
                $request->validate([
                    'etat_locaux_rapport' => 'required',
                    'equipement_rapport' => 'required',
                    'salubrite_rapport' => 'required',
                ], [
                    'etat_locaux_rapport.required' => 'Veuillez ajouter un commentaire pour les locaux.',
                    'equipement_rapport.required' => 'Veuillez ajouter un commentaire pour les equipement.',
                    'salubrite_rapport.required' => 'Veuillez ajouter un commentaire pour la salubrite / securité.',
                ]);

                            // Vérification si une visite existe déjà
                $visite = Visites::where([['id_demande_habilitation','=',$id]])->first();

                $input = $request->all();
                $input['id_visites'] = $visite->id_visites;
                $input['id_demande_habilitation'] = $id;


                $verifierapport = RapportsVisites::where([['id_demande_habilitation','=',$id],['id_visites','=',$visite->id_visites]])->first();

                if(isset($verifierapport)){
                    $rapp = RapportsVisites::find($verifierapport->id_rapports_visites);
                    $rapp->update([
                        'etat_locaux_rapport' => $input['etat_locaux_rapport'],
                        'equipement_rapport' => $input['equipement_rapport'],
                        'salubrite_rapport' => $input['salubrite_rapport'],
                        'contenu' => $input['contenu']
                    ]);
                }else{
                    $rap = RapportsVisites::create($input);
                }



                return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Rapport effectué avec succès. ');


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


    public function rapport($id)  {

        $id =  Crypt::UrldeCrypt($id);

        $demandehabilitation = DemandeHabilitation::find($id);

        $visite = Visites::where([['id_demande_habilitation','=',$id]])->first();

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

        $formateurs = DB::table('vue_formateur_rapport')->where([['id_demande_habilitation','=',$id]])->get();

        $rapport = RapportsVisites::where([['id_demande_habilitation','=',$id]])->first();

        return view('habilitation.traitementdemandehabilitation.rapport',compact('id','infoentreprise',
                        'demandehabilitation','visite','formateurs','rapport'));
    }
}
