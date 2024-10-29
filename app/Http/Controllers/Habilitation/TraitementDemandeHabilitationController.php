<?php

namespace App\Http\Controllers\Habilitation;

use App\Http\Controllers\Controller;
use App\Models\Visites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Parcours;
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
use App\Models\CommentaireNonRecevableDemande;
use App\Models\Competences;
use App\Models\Experiences;
use App\Models\Formateurs;
use App\Models\FormationsEduc;
use App\Models\LanguesFormateurs;
use App\Models\PiecesDemandeHabilitation;
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
        //dd(Auth::user()->id); exit();

        if($codeRoles == 'CHEFSERVICE'){
            $habilitations = DB::table('vue_demande_habilitation_soumis_generale')->where([['id_agence','=',$numAgce]])->get();
            //dd($habilitations); exit();
        }else if ($codeRoles == 'CHARGEHABIL'){
            // Charger d'habilitation apres validation du chef de service
            $habilitations = DB::table('vue_demande_habilitation_soumis_generale_publique')->where([['id_agence','=',$numAgce],['id_charge_habilitation','=',Auth::user()->id]])->get(); // CHARGEHABIL
            //dd($habilitations); exit();
        }
        else{
            $habilitations = DemandeHabilitation::where([['id_charge_habilitation','=',Auth::user()->id],['flag_soumis_comite_technique','=',false]])->get();
        }
        //dd($habilitations);
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'HABILITATION (Traitement)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.traitementdemandehabilitation.index',compact('habilitations','codeRoles'));
    }


    public function indexvalidation()
    {
        // Index de validation des habilitations
        $numAgce = Auth::user()->num_agce;
        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($codeRoles); exit();

        $idUser=Auth::user()->id;
        $Idroles = Menu::get_id_profil($idUser);
        //dd($Idroles); exit();
        $Resultat = null;
        $ResultatEtap = DB::table('vue_processus')
            ->where([
                ['id_roles', '=', $Idroles],
                ['id_processus', '=', 14] // 11 Local
            ])
            ->get();
           // dd($ResultatEtap);
        if (isset($ResultatEtap)) {
            $Resultat = [];
            foreach ($ResultatEtap as $key => $r) {
                    $Resultat[$key] = DB::table('vue_processus_liste as v')
                        ->Join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                        ->join('vue_demande_habilitation_soumis_generale_publique','p.id_demande','vue_demande_habilitation_soumis_generale_publique.id_demande_habilitation')
                        ->join('entreprises','vue_demande_habilitation_soumis_generale_publique.id_entreprises','entreprises.id_entreprises')
                        ->join('users','vue_demande_habilitation_soumis_generale_publique.id_charge_habilitation','users.id')
                        ->where([
                            ['v.mini', '=', $r->priorite_combi_proc],
                            ['v.id_processus', '=', $r->id_processus],
                             ['v.code', '=', 'HPUB'],
                            ['p.id_roles', '=', $Idroles]
                        ])
                        ->get();
            }
        //dd($Resultat);
        }
        //$habilitations = $Resultat;

        // if($codeRoles == 'CHEFSERVICE'){
        //     $habilitations = DB::table('vue_demande_habilitation_soumis_generale_publique')->where([['id_agence','=',$numAgce],['flag_reception_demande_habilitation','=',true]])->get();
        //     //dd($habilitations); exit();
        // }else if ($codeRoles == 'CHARGEHABIL'){
        //     // Charger d'habilitation apres validation du chef de service
        //     $habilitations = DB::table('vue_demande_habilitation_soumis_generale_publique')->where([['id_agence','=',$numAgce]])->get(); // CHARGEHABIL
        //     //dd($habilitations); exit();
        // }else if ($codeRoles == 'CHEFDEPART'){
        //     // Chef de departement
        //     $habilitations = DB::table('vue_demande_habilitation_soumis_generale_publique')->where([['id_agence','=',$numAgce],['flag_reception_demande_habilitation','=',true],['flag_reception_chef_departement','=',true],['flag_reception_directerur','=',null]])->get();
        //     //dd($habilitations); exit();
        // }else if ($codeRoles == 'DR'){
        //     // Directeur
        //     $habilitations = DB::table('vue_demande_habilitation_soumis_generale_publique')->where([['id_agence','=',$numAgce],['flag_reception_demande_habilitation','=',true],['flag_reception_chef_departement','=',true],['flag_reception_directerur','=',true],['flag_reception_secretaiaire','=',null]])->get();
        //     //dd($habilitations); exit();
        // }else if ($codeRoles == 'SG'){
        //     // Directeur
        //     $habilitations = DB::table('vue_demande_habilitation_soumis_generale_publique')->where([['id_agence','=',$numAgce],['flag_reception_demande_habilitation','=',true],['flag_reception_chef_departement','=',true],['flag_reception_directerur','=',true],['flag_reception_secretaiaire','=',true]])->get();
        //     //dd($habilitations); exit();
        // }
        // else{
        //     $habilitations = DemandeHabilitation::where([['id_charge_habilitation','=',Auth::user()->id]])->get();
        // }
        // Audit::logSave([

        //     'action'=>'INDEX',

        //     'code_piece'=>'',

        //     'menu'=>'HABILITATION (Traitement)',

        //     'etat'=>'Succès',

        //     'objet'=>'HABILITATION'

        // ]);

        return view('habilitation.traitementdemandehabilitation.validation',compact('Resultat','codeRoles'));
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
    public function show( Request $request, $id)
    {
        //

        $id =  Crypt::UrldeCrypt($id);
        $demandehabilitation = DemandeHabilitation::find($id);

        // Domaine d'interventions
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        // Recuperation de l'entreprise
        $entreprise = Entreprises::find($demandehabilitation->id_entreprises);
       //dd($entreprise); exit();
        return view('habilitation.traitementdemandehabilitation.show', compact('demandehabilitation','id','entreprise','domaineDemandeHabilitations'));
    }

    public function showagrement( Request $request, $id)
    {
        //

        $id =  Crypt::UrldeCrypt($id);
        $demandehabilitation = DemandeHabilitation::find($id);

        // Domaine d'interventions
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        // Recuperation de l'entreprise
        $entreprise = Entreprises::find($demandehabilitation->id_entreprises);
       //dd($entreprise); exit();
        return view('habilitation.traitementdemandehabilitation.showagrement', compact('demandehabilitation','id','entreprise','domaineDemandeHabilitations'));
    }

    public function shownotetechnique( Request $request, $id)
    {
        //

        $id =  Crypt::UrldeCrypt($id);
        $demandehabilitation = DemandeHabilitation::find($id);

        // Domaine d'interventions
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        // Recuperation de l'entreprise
        $entreprise = Entreprises::find($demandehabilitation->id_entreprises);
       //dd($entreprise); exit();
        return view('habilitation.traitementdemandehabilitation.shownotetechnique', compact('demandehabilitation','id','entreprise','domaineDemandeHabilitations'));
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
                                    ->join('pieces_formateur','formateurs.id_formateurs','pieces_formateur.id_formateurs')
                                    ->where([['id_demande_habilitation','=',$id],['id_types_pieces','=',2]])
                                    ->get();


        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id]])->get();

        $commentairenonrecevables = CommentaireNonRecevableDemande::where([['id_demande','=',$id],['code_demande','=','HAB']])->get();

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

        $piecesDemandeHabilitations = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

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
                    'visites','rapportVisite','commentairenonrecevables','piecesDemandeHabilitations'));
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
                            // if (isset($demandehabilitation->contact_responsable_habilitation)) {
                            //     $content = "Cher ".$infoentreprise->sigl_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE LE RENDEZ-VOUS POUR LA VISITE DE VOTRE LOCAUX EST: ".@$dateEtHeureDebut.". CORDIALEMENT, L EQUIPE E-FDFP";
                            //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                            // }

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
        -    $heureFin = $request->endfin;

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

            if ($visitef->statut == 'planifier') {
                $MsgStat = 'la planification';
            }
            if ($visitef->statut == 'commencer') {
                $MsgStat = 'le debut';
            }
            if ($visitef->statut == 'terminer') {
                $MsgStat = 'la fin';
            }
            if ($visitef->statut == 'annuler') {
                $MsgStat = 'l\'annulation';
            }
            if ($visitef->statut == 'reporter') {
                $MsgStat = 'le report';
            }

            if (isset($demandehabilitation->email_responsable_habilitation)) {
                $sujet = "Demande de prise de rendez-vous pour la demande habilitation sur e-FDFP";
                $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                $messageMail = "<b>Cher,  ".$infoentreprise->sigl_entreprises." ,</b>
                                <br><br>Nous avons le plaisir de vous notifie ".$MsgStat." de prise de rendez-vous pour la visite de votre locaux :

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
                            // if (isset($demandehabilitation->contact_responsable_habilitation)) {
                            //     $content = "Cher ".$infoentreprise->sigl_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE LE RENDEZ-VOUS POUR LA VISITE DE VOTRE LOCAUX EST: ".@$dateEtHeureDebut.". CORDIALEMENT, L EQUIPE E-FDFP";
                            //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                            // }

            return response()->json(['status' => 'Événement modifié avec succès'], 200);
        }

        return response()->json(['status' => 'Méthode non autorisée'], 405);
    }



    public function editpuvalidation($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        //$idetape =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id1);
        //dd($idetape); exit();
        $id_num_comb = $idetape ;


        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($codeRoles);
        $demandehabilitation = DemandeHabilitation::find($id);
        $entreprise = Entreprises::find($demandehabilitation->id_entreprises);
        //dd($$demandehabilitation->flag_soumis_charge_habilitation); exit();
        if($demandehabilitation->flag_reception_demande_habilitation == true && $codeRoles == 'CHARGEHABIL'){
            $idetape = 9;
        } else if ($demandehabilitation->flag_reception_demande_habilitation == true && $codeRoles != 'CHARGEHABIL'){
            $idetape = 10;
        }

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);
        //dd($infoentreprise->pay->id_pays);
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
        $typeDomaineDemandeHabilitationList = "<option value=''> Selectionnez la type de domaine de formation </option>";
        foreach ($typeDomaineDemandeHabilitation as $comp) {
            $typeDomaineDemandeHabilitationList .= "<option value='" . $comp->id_type_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation) ." </option>";
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

        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
                                                          ->where([['id_demande_habilitation','=',$id]])
                                                          ->get();

        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id]])->get();
        //dd($codeRoles);
        if($codeRoles == 'CHEFSERVICE' && $demandehabilitation->flag_soumis_charge_habilitation == false ){
           // dd(Auth::user()->id_service);
           //$chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
           $id_service = 13; // Habilitation
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=', $id_service]])->get();
            $chargerHabilitationsList =  "<option value=''> Selectionnez le charge d\'habilitation </option>";
            foreach ($chargerHabilitations as $comp) {
                $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
            }

            //$NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            $NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',$id_service]])->get();
        }else{
            $id_charge =  $demandehabilitation->id_charge_habilitation;
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id','=',$id_charge]])->get();
            $chargerHabilitations = $chargerHabilitations[0];
            //dd($chargerHabilitations->prenom_users); exit();
            //$chargerHabilitations = [];
            $chargerHabilitationsList = [];
            $NombreDemandeHabilitation = [];
        }

        $motifs = Motif::where([['code_motif','=','HAB']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }
        $role = Menu::get_code_menu_profil(Auth::user()->id);
        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$demandehabilitation->id_processus],
            ['id_user','=',$idUser],
            ['id_piece','=',$id],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
           // ['id_combi_proc','=',$id2]
        ])->get();
        //dd($parcoursexist); exit();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Traitement de HABILITATION)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);


        return view('habilitation.traitementdemandehabilitation.editpu', compact('demandehabilitation','infoentreprise','banque','pay',
                    'id','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions', 'id_num_comb',
                    'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
                    'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList',
                    'chargerHabilitationsList','NombreDemandeHabilitation','motif','role','entreprise','chargerHabilitations','parcoursexist'));
    }

    public function editpu($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        //$idetape =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id1);
        //dd($idetape); exit();
        $id_num_comb = $idetape ;


        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($codeRoles);
        $demandehabilitation = DemandeHabilitation::find($id);
        $entreprise = Entreprises::find($demandehabilitation->id_entreprises);
        //dd($$demandehabilitation->flag_soumis_charge_habilitation); exit();
        if($demandehabilitation->flag_reception_demande_habilitation == true && $codeRoles == 'CHARGEHABIL'){
            $idetape = 9;
        } else if ($demandehabilitation->flag_reception_demande_habilitation == true && $codeRoles != 'CHARGEHABIL'){
            $idetape = 10;
        }

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);
        //dd($infoentreprise->pay->id_pays);
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
        $typeDomaineDemandeHabilitationList = "<option value=''> Selectionnez la type de domaine de formation </option>";
        foreach ($typeDomaineDemandeHabilitation as $comp) {
            $typeDomaineDemandeHabilitationList .= "<option value='" . $comp->id_type_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation) ." </option>";
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

        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
                                                          ->where([['id_demande_habilitation','=',$id]])
                                                          ->get();

        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id]])->get();
        //dd($codeRoles);
        if($codeRoles == 'CHEFSERVICE' && $demandehabilitation->flag_soumis_charge_habilitation == false ){
           // dd(Auth::user()->id_service);
           //$chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
           $id_service = 13; // Habilitation
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=', $id_service]])->get();
            $chargerHabilitationsList =  "<option value=''> Selectionnez le charge d\'habilitation </option>";
            foreach ($chargerHabilitations as $comp) {
                $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
            }

            //$NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            $NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',$id_service]])->get();
        }else{
            $id_charge =  $demandehabilitation->id_charge_habilitation;
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id','=',$id_charge]])->get();
            $chargerHabilitations = $chargerHabilitations[0];
            //dd($chargerHabilitations->prenom_users); exit();
            //$chargerHabilitations = [];
            $chargerHabilitationsList = [];
            $NombreDemandeHabilitation = [];
        }

        $motifs = Motif::where([['code_motif','=','HAB']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }
        $role = Menu::get_code_menu_profil(Auth::user()->id);
        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$demandehabilitation->id_processus],
            ['id_user','=',$idUser],
            ['id_piece','=',$id],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
           // ['id_combi_proc','=',$id2]
        ])->get();
        //dd($parcoursexist); exit();


        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
        ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
            'v.comment_parcours', 'v.id_processus')
        ->where('v.id_processus', '=', $demandehabilitation->id_processus)
        ->where('v.id_demande', '=', $demandehabilitation->id_demande_habilitation)
        ->orderBy('v.priorite_combi_proc', 'ASC')
        ->get();
        //dd($ResultProssesList); exit();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Traitement de HABILITATION)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);


        return view('habilitation.traitementdemandehabilitation.editpu', compact('demandehabilitation','infoentreprise','banque','pay',
                    'id','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions', 'id_num_comb',
                    'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
                    'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList',
                    'chargerHabilitationsList','NombreDemandeHabilitation','motif','role','entreprise','chargerHabilitations','parcoursexist','ResultProssesList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id , $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $etape =  Crypt::UrldeCrypt($id1);

        $logo = Menu::get_logo();


        if($data['action'] === 'Valider'){
            dd('Validation'); exit();

            $idUser=Auth::user()->id;
            $idAgceCon=Auth::user()->num_agce;
            $Idroles = Menu::get_id_profil($idUser);
            $dateNow = Carbon::now();
            $id_combi_proc = $request->input('id_combi_proc');
            //dd($id_combi_proc) ; exit();
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

                    $dem = DemandeHabilitation::find($id);
                    $dem->update([
                        'flag_agrement_demande_habilitaion' => true
                    ]);

                    $demandehabilitation = DemandeHabilitation::find($id);
          //  $demandehabilitation->update($input);

            $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            //Envoi SMS Validé
            // if (isset($demandehabilitation->contact_responsable_habilitation)) {
            //     $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE DEAMNDE D'HABILITATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
            //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            // }

            //Envoi email
             if (isset($demandehabilitation->email_responsable_habilitation)) {
                $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
                $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                <br><br>Nous sommes ravis de vous informer que votre demande d'habilitation a ete agree.
                                <br><br>Nous apprécions votre intérêt pour notre services.<br>
                                <br><br>Connectez vous sur votre compte afin de pouvoir voir votre agrement.<br>
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

                    'menu'=>'HABILITATION PUBLIQUE (Validation par le processus : VALIDER  )',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION'

                ]);

                return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(10).'/editpu')->with('success', 'Succes : Dossier valider avec succès. ');


        }
    }


        if ($request->isMethod('put')) {
            dd('Put Validation'); exit();

            $data = $request->all();
           //dd($data) ; exit(); //86

           if ($data['action'] == 'GenererAgrement'){

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['flag_agrement_demande_habilitaion'] = true;
            //$input['date_valide_demande_habilitation'] = $dateanneeencours;

            $demandehabilitation = DemandeHabilitation::find($id);
            $demandehabilitation->update($input);

            $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            //Envoi SMS Validé
            // if (isset($demandehabilitation->contact_responsable_habilitation)) {
            //     $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE DEAMNDE D'HABILITATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
            //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            // }

            //Envoi email
            //  if (isset($demandehabilitation->email_responsable_habilitation)) {
            //     $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
            //     $titre = "Bienvenue sur ".@$logo->mot_cle ."";
            //     $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
            //                     <br><br>Nous sommes ravis de vous informer que votre demande d'habilitation a ete agréé.
            //                     <br><br>Nous apprécions votre intérêt pour notre services.<br>
            //                     Cordialement,
            //                     L'équipe e-FDFP
            //                     <br><br><br>
            //                     -----
            //                     Ceci est un mail automatique, Merci de ne pas y répondre.
            //                     -----
            //                     ";
            //     $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            // }


            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'HABILITATION Generation de l\'agrement (Instruction: Recevabilité effectué avec succès.)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION Generation de l\'agrement'

            ]);

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Agremment generer avec succès. ');

        }


        if ($data['action'] == 'AttributionSecretaire'){

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['flag_reception_secretaiaire'] = true;

            $demandehabilitation = DemandeHabilitation::find($id);
            $demandehabilitation->update($input);

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'HABILITATION Affectation au secretaire (Instruction: Recevabilité effectué avec succès.)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION Affectation au secretaire'

            ]);

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Dossier imputer au secretaire avec succès. ');

        }



        if ($data['action'] == 'AttributionDirecteur'){

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['flag_reception_directerur'] = true;

            $demandehabilitation = DemandeHabilitation::find($id);
            $demandehabilitation->update($input);

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'HABILITATION Affectation au directeur (Instruction: Recevabilité effectué avec succès.)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION Affectation au directeur'

            ]);

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Dossier imputer au directeur avec succès. ');

        }


        if ($data['action'] == 'AttributionChefDepartement'){

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['flag_reception_chef_departement'] = true;

            $demandehabilitation = DemandeHabilitation::find($id);
            $demandehabilitation->update($input);

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'HABILITATION Affectation au chef de departement (Instruction: Recevabilité effectué avec succès.)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION Affectation au chef de departement'

            ]);

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Dossier imputer au chef de departement avec succès. ');

        }

        if ($data['action'] == 'ValideLettre'){

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['flag_lettre_enregistrement'] = true;

            $demandehabilitation = DemandeHabilitation::find($id);
            $demandehabilitation->update($input);

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'HABILITATION VALIDATION LETTRE ENGAGEMENT (Instruction: Recevabilité effectué avec succès.)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION VALIDATION LETTRE ENGAGEMENT'

            ]);

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Lettre d\'engagement enregistre avec succès. ');

        }

        if ($data['action'] == 'ValideNote'){

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['flag_note_technique'] = true;

            $demandehabilitation = DemandeHabilitation::find($id);
            $demandehabilitation->update($input);

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'HABILITATION VALIDATION NOTE TECHNIQUE (Instruction: Recevabilité effectué avec succès.)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION VALIDATION NOTE TECHNIQUE'

            ]);

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Note technique validé avec succès. ');

        }

        if ($data['action'] == 'Recevable_PUV'){

            $input = $request->all();
            //dd($input); exit();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['flag_lettre_enregistrement'] = true;
            $input['flag_reception_demande_habilitation'] = true;
            $input['flag_note_technique'] = true;
            $input['code_demande_habilitation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
            //$input['date_reception_demande_habilitation'] = Carbon::now();
            $input['date_valide_demande_habilitation'] = Carbon::now();

            $demandehabilitation = DemandeHabilitation::find($id);
            $demandehabilitation->update($input);

            $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            //Envoi SMS Validé
            // if (isset($demandehabilitation->contact_responsable_habilitation)) {
            //     $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE DEAMNDE D'HABILITATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
            //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            // }

            //Envoi email
             if (isset($demandehabilitation->email_responsable_habilitation)) {
                $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
                $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                <br><br>Nous sommes ravis de vous informer que votre demande d'habilitation est jugé recevable.
                                <br><br>Nous apprécions votre intérêt pour notre services.<br>
                                <br><br>Le traitement est en cours.<br>
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

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(8).'/editpu')->with('success', 'Succes : Recevabilité effectué avec succès. ');

        }


        if($data['action'] === 'NonRecevable_PUV'){

            $this->validate($request, [
                'commentaire_recevabilite' => 'required'
            ],[
                'commentaire_recevabilite.required' => 'Veuillez renseigner un commentaire de non recevabilité.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['flag_reception_demande_habilitation'] = true;
            $input['flag_rejet_demande_habilitation'] = true;
            $input['commentaire_recevabilite'] = $data['commentaire_recevabilite'];
            $input['code_demande_habilitation'] = substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
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


                                <br><b>Commentaire : </b> ".@$demandehabilitation->commentaire_recevabilite."
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
                $content = "Cher ".$infoentreprise->raison_social_entreprises."<br>, Nous avons examiné votre demande d'activation de compte sur Nom de la plateforme, et
                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :".@$demandehabilitation->commentaire_recevabilite."
                    <br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
                    fournir, n'hésitez pas à nous contacter à mailsupport... pour obtenir de l'aide.
                    Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
                    soumettre une nouvelle demande lorsque les problèmes seront résolus.<br>
                    Cordialement,
                    L'équipe e-FDFP";
                SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            }

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'HABILITATION (Instruction: La non-recevabilité a été effectué avec succès.) ',

                'etat'=>'Succès',

                'objet'=>'HABILITATION PUBLIQUE'

            ]);

            return redirect()->route('traitementdemandehabilitation.index')->with('success', 'Recevabilité effectué avec succès: REJETER');

        }


        if ($data['action'] == 'FaireAttribution'){

            $demandehabilitation = DemandeHabilitation::find($id);
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

            $demandehabilitation = DemandeHabilitation::find($id);
            $input = $request->all();
            $input['date_soumis_comite_technique'] = Carbon::now();
            $input['flag_soumis_comite_technique'] = true;

            $demandehabilitation->update($input);

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

        }

        if ($data['action'] == 'FaireAttributionPU'){

            $demandehabilitation = DemandeHabilitation::find($id);
            $input = $request->all();
            //dd($input); exit();

            $input['date_transmi_charge_habilitation'] = Carbon::now();
            $input['flag_soumis_charge_habilitation'] = true;
            $input['commentaire_cs'] = $input['commentaire_cs'];
            $input['id_charge_habilitation'] = $input['id_charge_habilitation'];
            $input['id_chef_service'] = Auth::user()->id;

            $demandehabilitation->update($input);

            return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(8).'/editpu')->with('success', 'Succes : Information mise a jour , demande affecté au chargé d\'habillitation. ');

        }

        if($data['action'] === 'Valider'){

                $idUser=Auth::user()->id;
                $idAgceCon=Auth::user()->num_agce;
                $Idroles = Menu::get_id_profil($idUser);
                $dateNow = Carbon::now();
                $id_combi_proc = $request->input('id_combi_proc');
                //dd($id_combi_proc) ; exit();
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

                        $dem = DemandeHabilitation::find($id);
                        $dem->update([
                            'flag_agrement_demande_habilitaion' => true
                        ]);

                        $demandehabilitation = DemandeHabilitation::find($id);
              //  $demandehabilitation->update($input);

                $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

                //Envoi SMS Validé
                // if (isset($demandehabilitation->contact_responsable_habilitation)) {
                //     $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE DEAMNDE D'HABILITATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
                //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                // }

                //Envoi email
                 if (isset($demandehabilitation->email_responsable_habilitation)) {
                    $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous sommes ravis de vous informer que votre demande d'habilitation a ete agree.
                                    <br><br>Nous apprécions votre intérêt pour notre services.<br>
                                    <br><br>Connectez vous sur votre compte afin de pouvoir voir votre agrement.<br>
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

                        'menu'=>'HABILITATION PUBLIQUE (Validation par le processus : VALIDER  )',

                        'etat'=>'Succès',

                        'objet'=>'HABILITATION'

                    ]);

                    return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(10).'/editpu')->with('success', 'Succes : Dossier valider avec succès. ');


            }
        }

            // if ($data['action'] == 'GenererAgrement'){

            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_agrement_demande_habilitaion'] = true;
            //     //$input['date_valide_demande_habilitation'] = $dateanneeencours;

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            //     //Envoi SMS Validé
            //     // if (isset($demandehabilitation->contact_responsable_habilitation)) {
            //     //     $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE DEAMNDE D'HABILITATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
            //     //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            //     // }

            //     //Envoi email
            //     //  if (isset($demandehabilitation->email_responsable_habilitation)) {
            //     //     $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
            //     //     $titre = "Bienvenue sur ".@$logo->mot_cle ."";
            //     //     $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
            //     //                     <br><br>Nous sommes ravis de vous informer que votre demande d'habilitation a ete agréé.
            //     //                     <br><br>Nous apprécions votre intérêt pour notre services.<br>
            //     //                     Cordialement,
            //     //                     L'équipe e-FDFP
            //     //                     <br><br><br>
            //     //                     -----
            //     //                     Ceci est un mail automatique, Merci de ne pas y répondre.
            //     //                     -----
            //     //                     ";
            //     //     $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            //     // }


            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION Generation de l\'agrement (Instruction: Recevabilité effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION Generation de l\'agrement'

            //     ]);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Agremment generer avec succès. ');

            // }


            // if ($data['action'] == 'AttributionSecretaire'){

            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_reception_secretaiaire'] = true;

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION Affectation au secretaire (Instruction: Recevabilité effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION Affectation au secretaire'

            //     ]);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Dossier imputer au secretaire avec succès. ');

            // }



            // if ($data['action'] == 'AttributionDirecteur'){

            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_reception_directerur'] = true;

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION Affectation au directeur (Instruction: Recevabilité effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION Affectation au directeur'

            //     ]);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Dossier imputer au directeur avec succès. ');

            // }


            // if ($data['action'] == 'AttributionChefDepartement'){

            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_reception_chef_departement'] = true;

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION Affectation au chef de departement (Instruction: Recevabilité effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION Affectation au chef de departement'

            //     ]);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Dossier imputer au chef de departement avec succès. ');

            // }

            // if ($data['action'] == 'ValideLettre'){

            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_lettre_enregistrement'] = true;

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION VALIDATION LETTRE ENGAGEMENT (Instruction: Recevabilité effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION VALIDATION LETTRE ENGAGEMENT'

            //     ]);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Lettre d\'engagement enregistre avec succès. ');

            // }

            // if ($data['action'] == 'ValideNote'){

            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_note_technique'] = true;

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION VALIDATION NOTE TECHNIQUE (Instruction: Recevabilité effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION VALIDATION NOTE TECHNIQUE'

            //     ]);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(9).'/editpu')->with('success', 'Succes : Note technique validé avec succès. ');

            // }

            // if ($data['action'] == 'Recevable_PUV'){

            //     $input = $request->all();
            //     //dd($input); exit();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_lettre_enregistrement'] = true;
            //     $input['flag_reception_demande_habilitation'] = true;
            //     $input['flag_note_technique'] = true;
            //     $input['code_demande_habilitation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
            //     //$input['date_reception_demande_habilitation'] = Carbon::now();
            //     $input['date_valide_demande_habilitation'] = Carbon::now();

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            //     //Envoi SMS Validé
            //     // if (isset($demandehabilitation->contact_responsable_habilitation)) {
            //     //     $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE DEAMNDE D'HABILITATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
            //     //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            //     // }

            //     //Envoi email
            //      if (isset($demandehabilitation->email_responsable_habilitation)) {
            //         $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
            //         $titre = "Bienvenue sur ".@$logo->mot_cle ."";
            //         $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
            //                         <br><br>Nous sommes ravis de vous informer que votre demande d'habilitation est jugé recevable.
            //                         <br><br>Nous apprécions votre intérêt pour notre services.<br>
            //                         <br><br>Le traitement est en cours.<br>
            //                         Cordialement,
            //                         L'équipe e-FDFP
            //                         <br><br><br>
            //                         -----
            //                         Ceci est un mail automatique, Merci de ne pas y répondre.
            //                         -----
            //                         ";
            //         $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            //     }


            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION (Instruction: Recevabilité effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION'

            //     ]);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(8).'/editpu')->with('success', 'Succes : Recevabilité effectué avec succès. ');

            // }


            // if($data['action'] === 'NonRecevable_PUV'){

            //     $this->validate($request, [
            //         'commentaire_recevabilite' => 'required'
            //     ],[
            //         'commentaire_recevabilite.required' => 'Veuillez renseigner un commentaire de non recevabilité.',
            //     ]);

            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_reception_demande_habilitation'] = true;
            //     $input['flag_rejet_demande_habilitation'] = true;
            //     $input['commentaire_recevabilite'] = $data['commentaire_recevabilite'];
            //     $input['code_demande_habilitation'] = substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
            //     $input['date_reception_demande_habilitation'] = Carbon::now();
            //     $input['date_rejet_demande_habilitation'] = Carbon::now();

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            //     if (isset($demandehabilitation->email_responsable_habilitation)) {
            //         $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
            //         $titre = "Bienvenue sur ".@$logo->mot_cle ."";
            //         $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
            //                         <br><br>Nous avons examiné votre demande habilitation sur e-FDFP, et
            //                         malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :


            //                         <br><b>Commentaire : </b> ".@$demandehabilitation->commentaire_recevabilite."
            //                         <br><br>
            //                         <br><br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
            //                             fournir, n'hésitez pas à nous contacter à [Adresse e-mail du support] pour obtenir de l'aide.
            //                             Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
            //                             soumettre une nouvelle demande lorsque les problèmes seront résolus.
            //                             Cordialement,
            //                             L'équipe e-FDFP
            //                         <br><br><br>
            //                         -----
            //                         Ceci est un mail automatique, Merci de ne pas y répondre.
            //                         -----
            //                         ";
            //         $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            //     }

            //     //Envoi SMS Rejeté
            //     if (isset($demandehabilitation->contact_responsable_habilitation)) {
            //         $content = "Cher ".$infoentreprise->raison_social_entreprises."<br>, Nous avons examiné votre demande d'activation de compte sur Nom de la plateforme, et
            //             malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :".@$demandehabilitation->commentaire_recevabilite."
            //             <br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
            //             fournir, n'hésitez pas à nous contacter à mailsupport... pour obtenir de l'aide.
            //             Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
            //             soumettre une nouvelle demande lorsque les problèmes seront résolus.<br>
            //             Cordialement,
            //             L'équipe e-FDFP";
            //         SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            //     }

            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION (Instruction: La non-recevabilité a été effectué avec succès.) ',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION PUBLIQUE'

            //     ]);

            //     return redirect()->route('traitementdemandehabilitation.index')->with('success', 'Recevabilité effectué avec succès: REJETER');

            // }


            // if ($data['action'] == 'FaireAttribution'){

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $this->validate($request, [
            //         'id_charge_habilitation' => 'required'
            //     ],[
            //         'id_charge_habilitation.required' => 'Veuillez selectionnez un charge d\'habilitation.'
            //     ]);

            //     $input = $request->all();

            //     $input['date_transmi_charge_habilitation'] = Carbon::now();
            //     $input['flag_soumis_charge_habilitation'] = true;
            //     $input['id_chef_service'] = Auth::user()->id;

            //     $demandehabilitation->update($input);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            // }

            // if($data['action'] === 'Soumission_demande_ct'){

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $input = $request->all();
            //     $input['date_soumis_comite_technique'] = Carbon::now();
            //     $input['flag_soumis_comite_technique'] = true;

            //     $demandehabilitation->update($input);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            // }

            // if ($data['action'] == 'FaireAttributionPU'){

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $input = $request->all();
            //     //dd($input); exit();

            //     $input['date_transmi_charge_habilitation'] = Carbon::now();
            //     $input['flag_soumis_charge_habilitation'] = true;
            //     $input['commentaire_cs'] = $input['commentaire_cs'];
            //     $input['id_charge_habilitation'] = $input['id_charge_habilitation'];
            //     $input['id_chef_service'] = Auth::user()->id;

            //     $demandehabilitation->update($input);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(8).'/editpu')->with('success', 'Succes : Information mise a jour , demande affecté au chargé d\'habillitation. ');

            // }

            // if($data['action'] === 'Recevable'){


            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $input['flag_reception_demande_habilitation'] = true;
            //     if(!isset($demandehabilitation->code_demande_habilitation)){
            //         $input['code_demande_habilitation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
            //     }
            //     $input['date_reception_demande_habilitation'] = Carbon::now();

            //     //$demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            //     //Envoi SMS Validé
            //     // if (isset($demandehabilitation->contact_responsable_habilitation)) {
            //     //     $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE PLAN DE FORMATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
            //     //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            //     // }

            //     //Envoi email
            //      if (isset($demandehabilitation->email_responsable_habilitation)) {
            //         $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
            //         $titre = "Bienvenue sur ".@$logo->mot_cle ."";
            //         $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
            //                         <br><br>Nous sommes ravis de vous informer que votre demande d'habilitation est jugé recevable.
            //                         <br><br>Nous apprécions votre intérêt pour notre services.<br>
            //                         Cordialement,
            //                         L'équipe e-FDFP
            //                         <br><br><br>
            //                         -----
            //                         Ceci est un mail automatique, Merci de ne pas y répondre.
            //                         -----
            //                         ";
            //         $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            //     }


            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION (Instruction: Recevabilité effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION'

            //     ]);

            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Recevabilité effectué avec succès. ');

            // }

            // if($data['action'] === 'NonRecevable'){

            //     $this->validate($request, [
            //         'id_motif_recevable' => 'required',
            //         'commentaire_recevabilite' => 'required',
            //     ],[
            //         'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
            //         'commentaire_recevabilite.required' => 'Veuillez ajouter le commentaire de la non recevaibilité.',
            //     ]);

            //     $input = $request->all();
            //     $dateanneeencours = Carbon::now()->format('Y');
            //     $input['flag_reception_demande_habilitation'] = false;
            //     $input['flag_rejet_demande_habilitation'] = true;
            //     $input['flag_soumis_demande_habilitation'] = false;
            //     if(!isset($demandehabilitation->code_demande_habilitation)){
            //         $input['code_demande_habilitation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
            //     }
            //     $input['date_reception_demande_habilitation'] = Carbon::now();
            //     $input['date_rejet_demande_habilitation'] = Carbon::now();

            //     $commentaire = CommentaireNonRecevableDemande::create([
            //         'commentaire_commentaire_non_recevable_demande' => $input['commentaire_recevabilite'],
            //         'id_demande' => $id,
            //         'id_motif_recevable' => $input['id_motif_recevable'],
            //         'code_demande' => 'HAB'
            //     ]);

            //     $demandehabilitation = DemandeHabilitation::find($id);
            //     $demandehabilitation->update($input);

            //     $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            //     if (isset($demandehabilitation->email_responsable_habilitation)) {
            //         $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
            //         $titre = "Bienvenue sur ".@$logo->mot_cle ."";
            //         $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
            //                         <br><br>Nous avons examiné votre demande habilitation sur e-FDFP, et
            //                         malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

            //                         <br><b>Motif de rejet  : </b> ".@$demandehabilitation->motif->libelle_motif."
            //                         <br><b>Commentaire : </b> ".@$demandehabilitation->commentaire_recevabilite."
            //                         <br><br>
            //                         <br><br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
            //                             fournir, n'hésitez pas à contactez votre chargé habilitation : ".@$demandehabilitation->userchargerhabilitation->email." pour obtenir de l'aide.
            //                             Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
            //                             soumettre la demande lorsque les problèmes seront résolus.
            //                             Cordialement,
            //                             L'équipe e-FDFP
            //                         <br><br><br>
            //                         -----
            //                         Ceci est un mail automatique, Merci de ne pas y répondre.
            //                         -----
            //                         ";
            //         $messageMailEnvoi = Email::get_envoimailTemplate($demandehabilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            //     }

            //     //Envoi SMS Rejeté
            //     // if (isset($demandehabilitation->contact_responsable_habilitation)) {
            //     //     $content = "Cher ".$infoentreprise->sigl_entreprises.", Nous avons examiné votre demande  et malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :".@$demandehabilitation->motif->libelle_motif." Veuillez mettre a jour le dossier .
            //     //         Cordialement,
            //     //         L'équipe e-FDFP";
            //     //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
            //     // }

            //     Audit::logSave([

            //         'action'=>'MISE A JOUR',

            //         'code_piece'=>$id,

            //         'menu'=>'HABILITATION (Instruction: La non-recevabilité a été effectué avec succès.)',

            //         'etat'=>'Succès',

            //         'objet'=>'HABILITATION'

            //     ]);

            //     return redirect()->route('traitementdemandehabilitation.index')->with('success', 'Recevabilité effectué avec succès.');

            // }


            // if($data['action'] === 'Rapport'){
            //     $request->validate([
            //         'etat_locaux_rapport' => 'required',
            //         'equipement_rapport' => 'required',
            //         'salubrite_rapport' => 'required',
            //         'flag_materiel_pedagogique' => 'required',
            //         'flag_salle_formation' => 'required',
            //     ], [
            //         'etat_locaux_rapport.required' => 'Veuillez ajouter un commentaire pour les locaux.',
            //         'equipement_rapport.required' => 'Veuillez ajouter un commentaire pour les equipement.',
            //         'flag_materiel_pedagogique.required' => 'Veuillez ajouter le status des materiels pedagogiques.',
            //         'flag_salle_formation.required' => 'Veuillez ajouter le status des salles de formation.',
            //         'salubrite_rapport.required' => 'Veuillez ajouter un commentaire pour la salubrite / securité.',
            //     ]);

            //                 // Vérification si une visite existe déjà
            //     $visite = Visites::where([['id_demande_habilitation','=',$id]])->first();

            //     $input = $request->all();
            //     $input['id_visites'] = $visite->id_visites;
            //     $input['id_demande_habilitation'] = $id;


            //     $verifierapport = RapportsVisites::where([['id_demande_habilitation','=',$id],['id_visites','=',$visite->id_visites]])->first();

            //     if(isset($verifierapport)){
            //         $rapp = RapportsVisites::find($verifierapport->id_rapports_visites);
            //         $rapp->update([
            //             'etat_locaux_rapport' => $input['etat_locaux_rapport'],
            //             'equipement_rapport' => $input['equipement_rapport'],
            //             'salubrite_rapport' => $input['salubrite_rapport'],
            //             'contenu' => $input['contenu'],
            //             'flag_materiel_pedagogique' => $input['flag_materiel_pedagogique'],
            //             'flag_salle_formation' => $input['flag_salle_formation'],
            //         ]);
            //     }else{
            //         $rap = RapportsVisites::create($input);
            //     }



            //     return redirect('traitementdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($etape).'/edit')->with('success', 'Succes : Rapport effectué avec succès. ');


            // }

        }
    }
}


    public function destroy(string $id)
    {
        //
    }




    public function indexyancho()
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

        return view('habilitation.traitementdemandehabilitation.indexyancho',compact('habilitations'));
    }


    public function rapport($id)  {

        $id =  Crypt::UrldeCrypt($id);

        $demandehabilitation = DemandeHabilitation::find($id);

        $visite = Visites::where([['id_demande_habilitation','=',$id]])->first();

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

        $formateurs = DB::table('vue_formateur_rapport')->where([['id_demande_habilitation','=',$id]])->get();

        $rapport = RapportsVisites::where([['id_demande_habilitation','=',$id]])->first();

        $piecesDemandes = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        return view('habilitation.traitementdemandehabilitation.rapport',compact('id','infoentreprise',
                        'demandehabilitation','visite','formateurs','rapport','piecesDemandes'));
    }
}
