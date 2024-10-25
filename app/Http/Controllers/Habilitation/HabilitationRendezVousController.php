<?php

namespace App\Http\Controllers\Habilitation;

use App\Http\Controllers\Controller;
use App\Models\Visites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Crypt;
use App\Helpers\Audit;
use App\Models\DemandeHabilitation;
use Carbon\Carbon;
use App\Helpers\Email;
use App\Helpers\SmsPerso;
use App\Helpers\Menu;
use App\Models\Entreprises;

class HabilitationRendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('habilitation.rendezvous.index');
    }

    public function fetchEvents(Request $request)
    {
        $query = Visites::where([['id_charger_habilitation_visite','=',Auth::user()->id]]);

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
                                // if (isset($demandehabilitation->contact_responsable_habilitation)) {
                                //     $content = "Cher ".$infoentreprise->sigl_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE LE RENDEZ-VOUS POUR LA VISITE DE VOTRE LOCAUX EST: ".@$dateEtHeureDebut.". CORDIALEMENT, L EQUIPE E-FDFP";
                                //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                                // }

                return response()->json(['status' => 'Événement modifié avec succès'], 200);
            }

            return response()->json(['status' => 'Méthode non autorisée'], 405);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
