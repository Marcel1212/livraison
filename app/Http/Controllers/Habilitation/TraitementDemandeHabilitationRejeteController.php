<?php

namespace App\Http\Controllers\Habilitation;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Http\Controllers\Controller;
use App\Models\AvisGlobaleComiteTechnique;
use App\Models\Banque;
use App\Models\Comite;
use App\Models\ComiteRejeter;
use App\Models\CommentaireNonRecevableDemande;
use App\Models\Competences;
use App\Models\DemandeHabilitation;
use App\Models\DemandeIntervention;
use App\Models\DomaineDemandeHabilitation;
use App\Models\DomaineFormation;
use App\Models\Entreprises;
use App\Models\Experiences;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\Formateurs;
use App\Models\FormationsEduc;
use App\Models\InterventionHorsCi;
use App\Models\LanguesFormateurs;
use App\Models\Motif;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Pays;
use App\Models\PiecesDemandeHabilitation;
use App\Models\PrincipaleQualification;
use App\Models\RapportsVisites;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeDomaineDemandeHabilitationPublic;
use App\Models\TypeIntervention;
use App\Models\TypeMoyenPermanent;
use App\Models\TypeOrganisationFormation;
use App\Models\Visites;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Menu;
use App\Helpers\SmsPerso;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Email;

class TraitementDemandeHabilitationRejeteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habilitations = ComiteRejeter::join('demande_habilitation','comite_rejeter.id_demande','demande_habilitation.id_demande_habilitation')
                                    ->join('users','demande_habilitation.id_charge_habilitation','users.id')
                                    ->where([['code_processus','=','HAB'],['flag_traite_comite_rejet','=',false]])
                                    ->get();

       // dd($demandes);
       Audit::logSave([

        'action'=>'INDEX',

        'code_piece'=>'',

        'menu'=>'HABILITATION (Traitement de HABILITATION REJET AU COMITE)',

        'etat'=>'Succès',

        'objet'=>'HABILITATION'

    ]);

        return view('habilitation.traitementrejetecomite.index', compact('habilitations'));
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

            'menu'=>'HABILITATION (Rejet du comite technique : Voir le cv)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.traitementrejetecomite.show', compact('id','formateur','qualification',
                        'formations','experiences','languesformateurs','competences'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idcomiterejet =  Crypt::UrldeCrypt($id1);
        $idetape =  9;


        $demandehabilitation = DemandeHabilitation::find($id);

        $comiterejet = ComiteRejeter::find($idcomiterejet);

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

        $commentairenonrecevables = CommentaireNonRecevableDemande::where([['id_demande','=',$id],['code_demande','=','HAB']])->get();



        $motifs = Motif::where([['code_motif','=','HAB']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $piecesDemandeHabilitations = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        $avisgobales = AvisGlobaleComiteTechnique::where([['id_demande','=',$id],['code_processus','=','HAB']])->get();


        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Traitement de HABILITATION REJET AU COMITE)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);


        return view('habilitation.traitementrejetecomite.edit', compact('demandehabilitation','infoentreprise','banque','pay',
                    'id','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
                    'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
                    'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList',
                    'motif','typeDomaineDemandeHabilitationPublicList','avisgobales',
                    'visites','rapportVisite','commentairenonrecevables','piecesDemandeHabilitations','comiterejet'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);

        $logo = Menu::get_logo();

        $demandehabilitation = DemandeHabilitation::find($id);

        $comiterejeter = ComiteRejeter::find($id1);

        if ($request->isMethod('put')) {
            $input = $request->all();

            $this->validate($request, [
                'commentaire_de_rejet' => 'required',
            ], [
                'commentaire_de_rejet.required' => 'Veuillez ajouter un commentaire.'
            ]);

            $input['flag_reception_demande_habilitation'] = false;
            $input['flag_rejet_demande_habilitation'] = true;
            $input['flag_soumis_demande_habilitation'] = false;

            $input['date_reception_demande_habilitation'] = Carbon::now();
            $input['date_rejet_demande_habilitation'] = Carbon::now();

            $avis = AvisGlobaleComiteTechnique::where([['id_demande','=',$id],['id_comite','=',$comiterejeter->id_comite],['code_processus','=','HAB']])->first();

            $comiterejeter->update([
                'flag_traite_comite_rejet' => true,
                'commentaire_de_rejet' => $input['commentaire_de_rejet'],
                'commentaire_rejeter' => $avis->commentaire_agct,
                'date_traite_comite_rejet' => Carbon::now(),
            ]);

            $commentaire = CommentaireNonRecevableDemande::create([
                'commentaire_commentaire_non_recevable_demande' => $input['commentaire_de_rejet'],
                'id_demande' => $id,
                'id_motif_recevable' => $avis->id_motif,
                'code_demande' => 'HAB'
            ]);

            $demandehabilitation->update($input);

            $infoentreprise = Entreprises::find($demandehabilitation->id_entreprises);

            $demCommentaire = $input['commentaire_de_rejet'];

                if (isset($demandehabilitation->email_responsable_habilitation)) {
                    $sujet = "Rejet de la demande habilitation sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous avons examiné votre demande habilitation sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :
                                    <br><b>Commentaire : </b> ".@$demCommentaire."
                                    <br><br>
                                    <br><br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
                                        fournir, n'hésitez pas à contactez votre chargé habilitation : ".@$demandehabilitation->userchargerhabilitation->email." pour obtenir de l'aide.
                                        Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
                                        soumettre la demande lorsque les problèmes seront résolus.
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
                // if (isset($demandehabilitation->contact_responsable_habilitation)) {
                //     $content = "Cher ".$infoentreprise->sigl_entreprises.", Nous avons examiné votre demande  et malheureusement, nous ne pouvons pas l'approuver. Veuillez mettre a jour le dossier .
                //         Cordialement,
                //         L'équipe e-FDFP";
                //     SmsPerso::sendSMS($demandehabilitation->contact_responsable_habilitation,$content);
                // }

                return redirect()->route('traitementhabilitationrejete.index')->with('success', 'Demande traité avec succès.');


        }


    }

    public function ficheanalyse($id) {

        $id =  Crypt::UrldeCrypt($id);

        $demandehabilitation = DemandeHabilitation::find($id);

        $visite = Visites::where([['id_demande_habilitation','=',$id]])->first();

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

        $formateurs = DB::table('vue_formateur_rapport')->where([['id_demande_habilitation','=',$id]])->get();

        $rapport = RapportsVisites::where([['id_demande_habilitation','=',$id]])->first();

        $piecesDemandes = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        $avis = AvisGlobaleComiteTechnique::where([
                                        ['id_demande', '=', $id],
                                        ['code_processus', '=', 'HAB']
                                    ])->latest('id_avis_globale_comite_technique')->first();


        return view('habilitation.traitementrejetecomite.rapport',compact('id','infoentreprise',
                        'demandehabilitation','visite','formateurs','rapport','piecesDemandes','avis'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
