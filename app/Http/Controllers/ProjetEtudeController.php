<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activites;
use App\Models\CentreImpot;
use App\Models\Localite;
use App\Models\Pays;
use App\Models\Motif;
use App\Models\StatutOperation;
use App\Models\DemandeEnrolement;
use App\Models\Entreprises;
use App\Models\Pieces;
use App\Models\ProjetEtude;
use App\Models\PiecesProjetEtude;
use Carbon\Carbon;
use App\Helpers\Menu;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use Spatie\Permission\Models\Role;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;

class ProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        // dd($user_id);
        $demandeenroles = ProjetEtude::where('id_user','=',$user_id)->get();
        return view('projetetude.index', compact('demandeenroles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $activites = Activites::all();
        $activite = "<option value=''> Selectionnez une activité </option>";
        foreach ($activites as $comp) {
            $activite .= "<option value='" . $comp->id_activites  . "'>" . $comp->libelle_activites ." </option>";
        }

        $centreimpots = CentreImpot::all();
        $centreimpot = "<option value=''> Selectionnez un centre impot </option>";
        foreach ($centreimpots as $comp) {
            $centreimpot .= "<option value='" . $comp->id_centre_impot  . "'>" . $comp->libelle_centre_impot ." </option>";
        }

        $localites = Localite::all();
        $localite = "<option value=''> Selectionnez une localite </option>";
        foreach ($localites as $comp) {
            $localite .= "<option value='" . $comp->id_localite  . "'>" . $comp->libelle_localite ." </option>";
        }

        $pays = Pays::all();
        $pay = "<option value='202'> 225 </option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        return view('projetetude.create', compact('activite','centreimpot','localite','pay'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'titre_projet' => 'required',
                'contexte_probleme' => 'required',
                'objectif_general' => 'required',
                'objectif_specifique' => 'required',
                'resultat_attendu' => 'required',
                'champ_etude' => 'required',
                'cible' => 'required',
                'avant_projet_tdr' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'courier_demande_fin' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'dossier_intention' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'lettre_engagement' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'offre_technique' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'offre_financiere' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
            ],[
                'titre_projet.required' => 'Veuillez ajouter un titre de projet',
                'contexte_probleme.required' => 'Veuillez ajouter un context ou problemes constaté',
                'objectif_general.required' => 'Veuillez ajouter un objectif general',
                'objectif_specifique.required' => 'Veuillez ajouter un objectif specifiques',
                'resultat_attendu.required' => 'Veuillez ajouter un resultat attendu',
                'champ_etude.required' => 'Veuillez ajouter un champ d&quot;etude',
                'cible.required' => 'Veuillez ajouter une cible',
                'avant_projet_tdr.required' => 'Veuillez ajouter un avant-projet TDR',
                'courier_demande_fin.required' => 'Veuillez ajouter un courrier de demande de financemen',
                'dossier_intention.required' => 'Veuillez ajouter un dossier d’intention',
                'lettre_engagement.required' => 'Veuillez ajouter une lettre d’engagement',
                'offre_technique.required' => 'Veuillez ajouter une offre technique',
                'offre_financiere.required' => 'Veuillez ajouter une offre financière',
            ]);
            $user_id = Auth::user()->id;
            $data = $request->all();
            //echo($data);
            // exit();

            $input = $request->all();

            if (isset($data['avant_projet_tdr'])){

                $filefront = $data['avant_projet_tdr'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'avant_projet_tdr'. '_' . rand(111,99999) . '_' . 'avant_projet_tdr' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/avant_projet_tdr/'), $fileName1);

                    $input['avant_projet_tdr'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier de l\'avant-projet TDR n\'est pas correcte');
                }

            }


            if (isset($data['courier_demande_fin'])){

                $filefront = $data['courier_demande_fin'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'courier_demande_fin'. '_' . rand(111,99999) . '_' . 'courier_demande_fin' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/courier_demande_fin/'), $fileName1);

                    $input['courier_demande_fin'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier du  courrier de demande n\'est pas correcte');
                }

            }

            if (isset($data['dossier_intention'])){

                $filefront = $data['dossier_intention'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'dossier_intention'. '_' . rand(111,99999) . '_' . 'dossier_intention' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/dossier_intention/'), $fileName1);

                    $input['dossier_intention'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier du dossier de l\'intention n\'est pas correcte');
                }

            }

            if (isset($data['lettre_engagement'])){

                $filefront = $data['lettre_engagement'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'lettre_engagement'. '_' . rand(111,99999) . '_' . 'lettre_engagement' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/lettre_engagement/'), $fileName1);

                    $input['lettre_engagement'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier de la lettre d\'engagement n\'est pas correcte');
                }

            }

            if (isset($data['offre_technique'])){

                $filefront = $data['offre_technique'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'offre_technique'. '_' . rand(111,99999) . '_' . 'offre_technique' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/offre_technique/'), $fileName1);

                    $input['offre_technique'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier de l\'offre technique n\'est pas correcte');
                }

            }

            if (isset($data['offre_financiere'])){

                $filefront = $data['offre_financiere'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'offre_financiere'. '_' . rand(111,99999) . '_' . 'offre_financiere' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/offre_financiere/'), $fileName1);

                    $input['offre_financiere'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier de l\'offre financiere n\'est pas correcte');
                }

            }

            $input['date_soumis'] = Carbon::now();
            $input['flag_soumis'] = false;
            $input['flag_valide'] = false;
            $input['flag_rejet'] = false;
            $input['id_user'] = $user_id;
            $input['titre_projet_etude'] = ucfirst($input['titre_projet']);
            $input['contexte_probleme_projet_etude'] = ucfirst($input['contexte_probleme']);
            $input['objectif_general_projet_etude'] = ucfirst($input['objectif_general']);
            $input['objectif_specifique_projet_etud'] = ucfirst($input['objectif_specifique']);
            $input['resultat_attendu_projet_etude'] = ucfirst($input['resultat_attendu']);
            $input['champ_etude_projet_etude'] = ucfirst($input['champ_etude']);
            $input['cible_projet_etude'] = ucfirst($input['cible']);

            ProjetEtude::create($input);
            $id_projet = ProjetEtude::latest()->first()->id_projet_etude;
            //dd($id_projet);

            // Enregistrement du chemin de pieces projets

            // Avant projet TDR
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '1',
                'libelle_pieces' => $input['avant_projet_tdr']
            ]);
            // Courrier de demande de financement
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '2',
                'libelle_pieces' => $input['courier_demande_fin']
            ]);
            // Dossier d’intention
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '3',
                'libelle_pieces' => $input['dossier_intention']
            ]);
            // Lettre d’engagement
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '4',
                'libelle_pieces' => $input['lettre_engagement']
            ]);
            // Offre technique
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '5',
                'libelle_pieces' => $input['offre_technique']
            ]);
             // Offre financiere
             PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '5',
                'libelle_pieces' => $input['offre_financiere']
            ]);


        }

        return redirect()->route('projetetude.index')
            ->with('success', 'Votre demande de projet d\'etude a ete effectue avec succes');
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
    public function edit($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        //dd($id);
        $projetetude = ProjetEtude::find($id);
        //dd($projetetude['titre_projet_etude']);
        //dd($projetetude->piecesProjetEtudes['0']->libelle_pieces);

        $statutoperations = StatutOperation::all();
        $statutoperation = "<option value=''> Selectionnez le statut </option>";
        foreach ($statutoperations as $comp) {
            $statutoperation .= "<option value='" . $comp->id_statut_operation  . "'>" . $comp->libelle_statut_operation ." </option>";
        }

        $motifs = Motif::all();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        return view('projetetude.edit', compact('projetetude','statutoperation','motif'));
    }

    public function projetetudesoumettre($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        dd($id);
        $projetetude = ProjetEtude::find($id);
        //dd($projetetude['titre_projet_etude']);
        //dd($projetetude->piecesProjetEtudes['0']->libelle_pieces);

        $statutoperations = StatutOperation::all();
        $statutoperation = "<option value=''> Selectionnez le statut </option>";
        foreach ($statutoperations as $comp) {
            $statutoperation .= "<option value='" . $comp->id_statut_operation  . "'>" . $comp->libelle_statut_operation ." </option>";
        }

        $motifs = Motif::all();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        return view('projetetude.edit', compact('projetetude','statutoperation','motif'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $demandeenrole = DemandeEnrolement::find($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if($data['action'] === 'Rejeter'){
                $this->validate($request, [
                    'id_motif' => 'required',
                    'commentaire_demande_enrolement' => 'required'
                ],[
                    'id_motif.required' => 'Veuillez selectionner le motif rejet.',
                    'commentaire_demande_enrolement.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();

                $input['id_user'] = Auth::user()->id;
                $input['flag_traitement_demande_enrolem'] = 1;
                $input['date_traitement_demande_enrolem'] = Carbon::now();

                $demandeenrole->update($input);

                $demandeenrole1 = DemandeEnrolement::find($id);

                if (isset($demandeenrole1->email_demande_enrolement)) {
                    $sujet = "Rejet pour la demande enrolement sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  $demandeenrole1->raison_sociale_demande_enroleme ,</b>
                                    <br><br>Nous avons examiné votre demande d'activation de compte sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

                                    <br><b>Motif de rejet  : </b> @$demandeenrole1->motif->libelle_motif
                                    <br><b>Commentaire : </b> @$demandeenrole1->commentaire_demande_enrolement
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


                    $messageMailEnvoi = Email::get_envoimailTemplate($demandeenrole1->email_demande_enrolement, $demandeenrole1->raison_sociale_demande_enroleme, $messageMail, $sujet, $titre);
                }

                return redirect()->route('enrolement.index')->with('success', 'Traitement effectué avec succès.');
            }

            if($data['action'] === 'Recevable'){
                $this->validate($request, [
                    'id_motif_recevable' => 'required'
                ],[
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);

                $input = $request->all();

                $input['id_user'] = Auth::user()->id;
                $input['flag_recevablilite_demande_enrolement'] = true;
                $input['date_recevabilite_demande_enrolement'] = Carbon::now();

                $demandeenrole->update($input);

                $demandeenrole1 = DemandeEnrolement::find($id);



                return redirect()->route('enrolement.index')->with('success', 'Recevabilité effectué avec succès.');
            }

            if($data['action'] === 'NonRecevable'){
                $this->validate($request, [
                    'id_motif_recevable' => 'required'
                ],[
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);

                $input = $request->all();

                $input['id_user'] = Auth::user()->id;
                $input['flag_recevablilite_demande_enrolement'] = false;
                $input['date_recevabilite_demande_enrolement'] = Carbon::now();

                $demandeenrole->update($input);

                $demandeenrole1 = DemandeEnrolement::find($id);

                if (isset($demandeenrole1->email_demande_enrolement)) {
                    $sujet = "Recevabilité de demande enrolement sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  $demandeenrole1->raison_sociale_demande_enroleme ,</b>
                                    <br><br>Nous avons examiné votre demande d'enrolement sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

                                    <br><b>Motif de rejet  : </b> @$demandeenrole1->motif1->libelle_motif
                                    <br><b>Commentaire : </b> @$demandeenrole1->commentaire_recevable_demande_enrolement
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


                    $messageMailEnvoi = Email::get_envoimailTemplate($demandeenrole1->email_demande_enrolement, $demandeenrole1->raison_sociale_demande_enroleme, $messageMail, $sujet, $titre);
                }

                return redirect()->route('enrolement.index')->with('success', 'Recevabilité effectué avec succès.');
            }

            if($data['action'] === 'Valider'){

                $this->validate($request, [
                    'id_motif' => 'required'
                ],[
                    'id_motif.required' => 'Veuillez selectionner le motif de validation.',
                ]);

                $input = $request->all();

                $input['id_user'] = Auth::user()->id;
                $input['flag_traitement_demande_enrolem'] = 1;
                $input['date_traitement_demande_enrolem'] = Carbon::now();

                $demandeenrole->update($input);

                $demandeenrole1 = DemandeEnrolement::find($id);

                $numfdfp = 'fdfp' . Gencode::randStrGen(4, 5);

                Entreprises::create([
                    'id_demande_enrolement' => $demandeenrole1->id_demande_enrolement,
                    'numero_fdfp_entreprises' => $numfdfp,
                    'ncc_entreprises' => $demandeenrole1->ncc_demande_enrolement,
                    'raison_social_entreprises' => $demandeenrole1->raison_sociale_demande_enroleme,
                    'tel_entreprises' => $demandeenrole1->tel_demande_enrolement,
                    'indicatif_entreprises' => $demandeenrole1->indicatif_demande_enrolement,
                    'numero_cnps_entreprises' => $demandeenrole1->numero_cnps_demande_enrolement,
                    'rccm_entreprises' => $demandeenrole1->rccm_demande_enrolement,
                    'flag_actif_entreprises' => true
                ]);

                $insertedId = Entreprises::latest()->first()->id_entreprises;
                $entreprise = Entreprises::latest()->first();

                if(isset($demandeenrole1->piece_dfe_demande_enrolement)){
                    Pieces::create([
                        'id_entreprises' => $insertedId,
                        'libelle_pieces' => $demandeenrole1->piece_dfe_demande_enrolement,
                        'code_pieces' => 'dfe',
                    ]);
                }

                if(isset($demandeenrole1->piece_rccm_demande_enrolement)){
                    Pieces::create([
                        'id_entreprises' => $insertedId,
                        'libelle_pieces' => $demandeenrole1->piece_rccm_demande_enrolement,
                        'code_pieces' => 'rccm',
                    ]);
                }

                if(isset($demandeenrole1->piece_attestation_immatriculati)){
                    Pieces::create([
                        'id_entreprises' => $insertedId,
                        'libelle_pieces' => $demandeenrole1->piece_attestation_immatriculati,
                        'code_pieces' => 'attest_immat',
                    ]);
                }

                $roles = Role::where([['code_roles', '=', 'ENTREPRISE']])->first();

                $name = $entreprise->raison_social_entreprises;
                $prenom_users = $entreprise->rccm_entreprises;
                $emailcli = $demandeenrole1->email_demande_enrolement;
                $id_partenaire = $entreprise->id_entreprises;
                $cel_users = $entreprise->tel_entreprises;
                $indicatif_tel_users = $entreprise->indicatif_entreprises;
                $ncc_entreprises = $entreprise->ncc_entreprises;

                $role = $roles->name;

                $clientrech = DB::table('users')->where([['email', '=', $emailcli]])->get();

                if (count($clientrech) > 0) {
                    return redirect()->route('enrolement.index')
                        ->with('danger', 'Echec : Le compte de entreprise ' . $name . ' ' . $prenom_users . ' a déjà été créé !');
                }

                $clientrechnum = DB::table('users')->where([['cel_users', '=', $cel_users]])->get();

                if (count($clientrechnum) > 0) {
                    return redirect()->route('enrolement.index')
                        ->with('danger', 'Echec : Le compte de entreprise ' . $name . ' ' . $prenom_users . ' a déjà été créé !');
                }

                $passwordCli = Crypt::MotDePasse(); // '123456789';
                $password = Hash::make($passwordCli);

                $user = new User();
                $user->name = $name;
                $user->prenom_users = $prenom_users;
                $user->email = $emailcli;
                $user->id_partenaire = $id_partenaire;
                $user->password = $password;
                $user->cel_users = $cel_users;
                $user->login_users = $ncc_entreprises;
                $user->indicatif_tel_users = $indicatif_tel_users;

                $user->assignRole($role);
                $user->save();

                $logo = Menu::get_logo();

                if (isset($emailcli)) {
                    $sujet = "Activation de compte FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher $name ,</b>
                                    <br><br>Nous sommes ravis de vous accueillir sur notre plateforme ! <br> Votre compte a été créé avec
                                        succès, et il est maintenant prêt à être utilisé.
                                    <br><br>
                                    <br><br>Voici un récapitulatif de vos informations de compte :
                                    <br><b>Nom d'utilisateur : </b> $name
                                    <br><b>Adresse e-mail : </b> $emailcli
                                    <br><b>Mot de passe : </b> $passwordCli
                                    <br><b>Date de création du compte : : </b> $entreprise->created_at
                                    <br><br>
                                    <br><br>Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :
                                            www.e-fdfp.ci
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";


                    $messageMailEnvoi = Email::get_envoimailTemplate($emailcli, $name, $messageMail, $sujet, $titre);
                }


                return redirect()->route('enrolement.index')->with('success', 'Traitement effectué avec succès.');

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
