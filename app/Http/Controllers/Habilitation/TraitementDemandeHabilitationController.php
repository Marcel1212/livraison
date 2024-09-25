<?php

namespace App\Http\Controllers\Habilitation;

use App\Http\Controllers\Controller;
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($id);
        $demandehabilitation = DemandeHabilitation::find($id);

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

        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
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
                    'chargerHabilitationsList','NombreDemandeHabilitation','motif','typeDomaineDemandeHabilitationPublicList'));
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

            if($data['action'] === 'Recevable'){


                $input = $request->all();
                $dateanneeencours = Carbon::now()->format('Y');
                $input['flag_reception_demande_habilitation'] = true;
                $input['code_demande_habilitation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                $input['date_reception_demande_habilitation'] = Carbon::now();

                $demandehabilitation = DemandeHabilitation::find($id);
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
                $input['flag_reception_demande_habilitation'] = true;
                $input['flag_rejet_demande_habilitation'] = true;
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
                    $content = "Cher ".$infoentreprise->raison_social_entreprises."<br>, Nous avons examiné votre demande d'activation de compte sur Nom de la plateforme, et
                        malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :".@$demandehabilitation->motif->libelle_motif."
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

                    'menu'=>'HABILITATION (Instruction: La non-recevabilité a été effectué avec succès.)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION'

                ]);

                return redirect()->route('traitementdemandehabilitation.index')->with('success', 'Recevabilité effectué avec succès.');

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
