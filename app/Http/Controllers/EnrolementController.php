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

class EnrolementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandeenroles = DemandeEnrolement::where([['flag_traitement_demande_enrolem','=',null],['flag_recevablilite_demande_enrolement','=',null]])
                                            ->orWhere([['flag_traitement_demande_enrolem','=',false],['flag_recevablilite_demande_enrolement','=',null]])
                                            ->get();
        return view('enrolement.index', compact('demandeenroles'));       
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
        
        return view('enrolement.create', compact('activite','centreimpot','localite','pay'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'raison_sociale_demande_enroleme' => 'required',
                'email_demande_enrolement' => 'required|unique:demande_enrolement,email_demande_enrolement',
                'indicatif_demande_enrolement' => 'required',
                'tel_demande_enrolement' => 'required',
                'id_localite' => 'required',
                'id_centre_impot' => 'required',
                'id_activites' => 'required',
                'ncc_demande_enrolement' => 'required|unique:demande_enrolement,ncc_demande_enrolement',
                'rccm_demande_enrolement' => 'required',
                'numero_cnps_demande_enrolement' => 'required',
                'piece_dfe_demande_enrolement' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'piece_rccm_demande_enrolement' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'piece_attestation_immatriculati' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'captcha' => 'required|captcha'
            ],[
                'raison_sociale_demande_enroleme.required' => 'Veuillez ajouter votre raison sociale.',
                'email_demande_enrolement.required' => 'Veuillez ajouter un email.',
                'indicatif_demande_enrolement.required' => 'Veuillez ajouter un indicatif.',
                'tel_demande_enrolement.required' => 'Veuillez ajouter un contact.',
                'id_localite.required' => 'Veuillez selectionnez une localite.',
                'id_centre_impot.required' => 'Veuillez selectionner un centre impot.',
                'id_activites.required' => 'Veuillez selectionner une activité.',
                'ncc_demande_enrolement.required' => 'Veuillez ajouter un NCC.',
                'rccm_demande_enrolement.required' => 'Veuillez ajouter un RCCM.',
                'numero_cnps_demande_enrolement.required' => 'Veuillez ajouter un numero cnps.',
                'piece_dfe_demande_enrolement.required' => 'Veuillez ajouter une piéce DFE.',
                'piece_rccm_demande_enrolement.required' => 'Veuillez ajouter une piéce attestation RCCM.',
                'piece_attestation_immatriculati.required' => 'Veuillez ajouter une piéce attestation immatricualtion.',
                'captcha.required' => 'Veuillez saisir le captcha.',
            ]);

            $data = $request->all();

            $input = $request->all();

            if (isset($data['piece_dfe_demande_enrolement'])){

                $filefront = $data['piece_dfe_demande_enrolement'];

                //dd($filefront->extension());

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){
                 
                    $fileName1 = 'piece_dfe_demande_enrolement'. '_' . rand(111,99999) . '_' . 'piece_dfe_demande_enrolement' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces/piece_dfe_demande_enrolement/'), $fileName1);
    
                    $input['piece_dfe_demande_enrolement'] = $fileName1;
                }else{
                    return redirect()->route('enrolements')
                    ->with('error', 'l\extension du fichier de la DFE n\'est pas correcte'); 
                }

            }            
            
            if (isset($data['piece_rccm_demande_enrolement'])){

                $filefront = $data['piece_rccm_demande_enrolement'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){
                 
                    $fileName1 = 'piece_rccm_demande_enrolement'. '_' . rand(111,99999) . '_' . 'piece_rccm_demande_enrolement' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces/piece_rccm_demande_enrolement/'), $fileName1);
    
                    $input['piece_rccm_demande_enrolement'] = $fileName1;

                }else{
                    return redirect()->route('enrolements')
                    ->with('error', 'l\extension du fichier de la RCCM n\'est pas correcte'); 
                }                

            }            
            
            if (isset($data['piece_attestation_immatriculati'])){

                $filefront = $data['piece_attestation_immatriculati'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){
                 
                    $fileName1 = 'piece_attestation_immatriculati'. '_' . rand(111,99999) . '_' . 'piece_attestation_immatriculati' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces/piece_attestation_immatriculati/'), $fileName1);
    
                    $input['piece_attestation_immatriculati'] = $fileName1;

                }else{
                    return redirect()->route('enrolements')
                    ->with('error', 'l\extension du fichier de l\attestation immatriculation n\'est pas correcte'); 
                }                

            }

            $input['date_depot_demande_enrolement'] = Carbon::now();
            $input['ncc_demande_enrolement'] = mb_strtoupper($input['ncc_demande_enrolement']);
            $input['raison_sociale_demande_enroleme'] = mb_strtoupper($input['raison_sociale_demande_enroleme']);
            $input['numero_cnps_demande_enrolement'] = mb_strtoupper($input['numero_cnps_demande_enrolement']);
            $input['rccm_demande_enrolement'] = mb_strtoupper($input['rccm_demande_enrolement']);

            DemandeEnrolement::create($input);

            $rais = $input['raison_sociale_demande_enroleme'];
            if (isset($input['email_demande_enrolement'])) {
                $sujet = "Enrolement FDFP";
                $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                $messageMail = "<b>Cher,  $rais ,</b>
                                <br><br>Votre demande d\'activation de compte sur le portail www.e-fdfp.ci a bien été prise en compte. Vous recevrez vos paramètres d’accès par email ou 
                                SMS dans 48h ouvrées
                                
                                <br><br><br>
                                
                                <br><br><br>
                                -----
                                Ceci est un mail automatique, Merci de ne pas y répondre.
                                -----
                                ";
    
    
                $messageMailEnvoi = Email::get_envoimailTemplate($input['email_demande_enrolement'], $rais, $messageMail, $sujet, $titre);
            }

        }

        return redirect()->route('enrolements')
            ->with('success', 'Votre demande d\'enrolement a ete effectuer avec succes');        
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
        $demandeenrole = DemandeEnrolement::find($id);

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

        return view('enrolement.edit', compact('demandeenrole','statutoperation','motif'));
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
