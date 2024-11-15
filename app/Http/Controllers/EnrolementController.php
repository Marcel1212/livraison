<?php

namespace App\Http\Controllers;

use App\Helpers\SmsPerso;
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
use App\Models\FormeJuridique;
use App\Models\SecteurActivite;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Rules\Recaptcha;
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
        //dd('ici'); exit();
        $demandeenroles = DemandeEnrolement::where([['flag_valider_demande_enrolement', '=', false], ['flag_rejeter_demande_enrolement', '=', false]])->get();
        return view('enrolement.index', compact('demandeenroles'));
    }

    public function fini()
    {
           return view('enrolement.fini');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //dd('ici'); exit();
        //Secteur d'activité
        // $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
        //                                    ->orderBy('libelle_secteur_activite')
        //                                    ->get();

        // //Centre des impots
        // $centreimpots = CentreImpot::where('flag_centre_impot', '=', true)
        //                            ->orderBy('libelle_centre_impot')
        //                            ->get();

        //Localités
        $localites = Localite::where('departement_localite_id', '=', 1)
                             ->orderBy('libelle_localite')
                             ->get();
        $localite = "<option value=''> Selectionnez une commune </option>";
        foreach ($localites as $comp) {
            $localite .= "<option value='" . $comp->id_localite  . "'>" . $comp->libelle_localite ." </option>";
        }
                             //dd($localite); exit();
        //Forme juridiques
        // $formejuridiques = FormeJuridique::where('flag_actif_forme_juridique', '=', true)
        //                                  ->orderBy('libelle_forme_juridique')
        //                                  ->get();
        //Pays
        // $pays = Pays::where('flag_actif_pays', '=', true)
        //             ->get();

        return view('enrolement.create', compact(  'localites', 'localite' ));
    }


    public function getsecteuractivilitelistes($secteur = 0)
    {
        $services = Activites::where([['id_secteur_activite', '=', $secteur], ['flag_activites', '=', true]])->get();
        return $services;

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $logo = Menu::get_logo();

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'id_forme_juridique' => 'required',
            ], [
                'id_forme_juridique.required' => 'Veuillez sélectionner une forme juridique.'
            ]);

            $exploeformejuri = explode("/", $request->input('id_forme_juridique'));
            $valcodeformejuri = $exploeformejuri[0];
            $validformejuri = $exploeformejuri[1];
            if ($valcodeformejuri == 'PR') {
                $data = $request->all();

                $this->validate($request, [
                    'raison_sociale_demande_enroleme' => 'required',
                    'sigl_demande_enrolement' => 'required',
                    'email_demande_enrolement' =>['required','email', 'unique:users,email',
                            Rule::unique('demande_enrolement')->where(function($query) use ($data) {
                                $query->where('email_demande_enrolement',$data['email_demande_enrolement'])
                                    ->where('flag_valider_demande_enrolement',true);
                            })
                        ],
                    'indicatif_demande_enrolement' => 'required',
                    'tel_demande_enrolement' => ['required', 'unique:users,tel_users',
                        Rule::unique('demande_enrolement')->where(function($query) use ($data) {
                            $query->where('tel_demande_enrolement',$data['tel_demande_enrolement'])
                                ->where('flag_valider_demande_enrolement',true);
                        })
                    ],
                    'id_localite' => 'required',
                    'id_centre_impot' => 'required',
                    'id_secteur_activite' => 'required',
                    'ncc_demande_enrolement' =>['required', 'min:6', 'max:9', 'unique:users,login_users',
                            Rule::unique('demande_enrolement')->where(function($query) use ($data) {
                                $query->where('ncc_demande_enrolement',$data['ncc_demande_enrolement'])
                                ->where('flag_valider_demande_enrolement',true);
                            })
                    ], 'rccm_demande_enrolement' => ['required',
                        Rule::unique('demande_enrolement')->where(function($query) use ($data) {
                            $query->where('rccm_demande_enrolement',$data['rccm_demande_enrolement'])
                                ->where('flag_valider_demande_enrolement',true);
                        })
                    ],'numero_cnps_demande_enrolement' => ['required',
                        Rule::unique('demande_enrolement')->where(function($query) use ($data) {
                            $query->where('numero_cnps_demande_enrolement',$data['numero_cnps_demande_enrolement'])
                                ->where('flag_valider_demande_enrolement',true);
                        })
                    ],

                    'piece_dfe_demande_enrolement' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                    'piece_rccm_demande_enrolement' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                    'piece_attestation_immatriculati' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                    //'g-recaptcha-response' => ['required', new ReCaptcha]
                ], [
                    'raison_sociale_demande_enroleme.required' => 'Veuillez ajouter votre raison sociale.',
                    'sigl_demande_enrolement.required' => 'Veuillez ajouter votre sigle.',
                    'email_demande_enrolement.required' => 'Veuillez ajouter un email.',
                    'email_demande_enrolement.unique' => 'Cet email est déjà utilisé dans le système. Veuillez contacter l\'administrateur.',
                    'indicatif_demande_enrolement.required' => 'Veuillez ajouter un indicatif.',
                    'tel_demande_enrolement.required' => 'Veuillez ajouter un contact.',
                    'tel_demande_enrolement.unique' => 'Ce contact est déjà utilisé dans le système. Veuillez contacter l\'administrateur.',
                    'id_localite.required' => 'Veuillez sélectionner une localité.',
                    'id_centre_impot.required' => 'Veuillez sélectionner un centre impot.',
                    'id_secteur_activite.required' => 'Veuillez sélectionner un secteur activité.',
                    'ncc_demande_enrolement.required' => 'Veuillez ajouter un numéro de compte contribuable (NCC)',
                    'ncc_demande_enrolement.min' => 'Le numéro de compte contribuable (NCC) doit avoir au moins 6 caractères',
                    'ncc_demande_enrolement.max' => 'Le numéro de compte contribuable (NCC) doit avoir au plus 9 caractères',
                    'ncc_demande_enrolement.unique' => 'Cet numéro compte contribuable (NCC) est déjà utilisé dans le système. Veuillez contacter l\'administrateur.',
                    'rccm_demande_enrolement.required' => 'Veuillez ajouter un RCCM.',
                    'numero_cnps_demande_enrolement.required' => 'Veuillez ajouter un numéro cnps.',
                    'piece_dfe_demande_enrolement.required' => 'Veuillez ajouter une piéce DFE.',
                    'piece_dfe_demande_enrolement.uploaded' => 'Veuillez ajouter une piéce DFE.',
                    'piece_rccm_demande_enrolement.required' => 'Veuillez ajouter une pièce attestation RCCM.',
                    'piece_rccm_demande_enrolement.uploaded' => 'Veuillez ajouter une pièce attestation RCCM.',
                    'piece_attestation_immatriculati.required' => 'Veuillez ajouter une pièce attestation immatriculation.',
                    'piece_attestation_immatriculati.uploaded' => 'Veuillez ajouter une pièce attestation immatriculation.',
                    'piece_attestation_immatriculati.mimes' => 'Les formats requis pour la pièce de l\'attestation immatriculation est: png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF.',
                    'piece_attestation_immatriculati.max' => 'la taille maximale doit être 5 MegaOctets.',
                    'piece_dfe_demande_enrolement.mimes' => 'Les formats requis pour la pièce de la DFE sont: png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF.',
                    'piece_dfe_demande_enrolement.max' => 'la taille maximale doit être 5 MegaOctets.',
                    'piece_rccm_demande_enrolement.mimes' => 'Les formats requis pour la pièce de la RCCM sont: png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF.',
                    'piece_rccm_demande_enrolement.max' => 'la taille maximale doit être de 5 MegaOctets.',
                   // 'g-recaptcha-response.required' => 'Veuillez saisir le vérificateur de securité .',
                ]);


//                $verfiencc = DemandeEnrolement::where([['ncc_demande_enrolement', '=', $data['ncc_demande_enrolement']], ['flag_valider_demande_enrolement', '=', true]])->get();
//
//                if (count($verfiencc) >= 1) {
//                    return redirect()->route('enrolements')->with('error', 'Ce numéro NCC est déjà utilisé dans le système. Veuillez contactez l\'administrateur.');
//                }

//                $verfienccrcm = DemandeEnrolement::where([['rccm_demande_enrolement', '=', $data['rccm_demande_enrolement']], ['flag_valider_demande_enrolement', '=', true]])->get();
//
//                if (count($verfienccrcm) >= 1) {
//                    return redirect()->route('enrolements')->with('error', 'Ce numéro RCCM est déjà utilisé dans le système. Veuillez contactez l\'administrateur.');
//                }

//                $verfienccCNPS = DemandeEnrolement::where([['numero_cnps_demande_enrolement', '=', $data['numero_cnps_demande_enrolement']], ['flag_valider_demande_enrolement', '=', true]])->get();
//
//                if (count($verfienccCNPS) >= 1) {
//                    return redirect()->route('enrolements')->with('error', 'Ce numéro CNPS est déjà utilisé dans le système. Veuillez contactez l\'administrateur.');
//                }
//
//                $verfienccNumerotel = DemandeEnrolement::where([['tel_demande_enrolement', '=', $data['tel_demande_enrolement']], ['flag_valider_demande_enrolement', '=', true]])->get();
//
//                if (count($verfienccNumerotel) >= 1) {
//                    return redirect()->route('enrolements')->with('error', 'Ce contact est déjà utilisé dans le système. Veuillez contactez l\'administrateur.');
//                }
//
//                $verfienccEmail = DemandeEnrolement::where([['email_demande_enrolement', '=', $data['email_demande_enrolement']], ['flag_valider_demande_enrolement', '=', true]])->get();
//
//                if (count($verfienccEmail) >= 1) {
//                    return redirect()->route('enrolements')->with('error', 'Cet mail est déjà utilisé dans le système. Veuillez contactez l\'administrateur.');
//                }

                $input = $request->all();

                if (isset($data['piece_dfe_demande_enrolement'])) {

                    $filefront = $data['piece_dfe_demande_enrolement'];

                    //dd($filefront->extension());

                    if ($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg") {

                        $fileName1 = 'piece_dfe_demande_enrolement' . '_' . rand(111, 99999) . '_' . 'piece_dfe_demande_enrolement' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/piece_dfe_demande_enrolement/'), $fileName1);

                        $input['piece_dfe_demande_enrolement'] = $fileName1;
                    } else {
                        return redirect()->route('enrolements')
                            ->with('error', 'l\extension du fichier de la DFE n\'est pas correcte');
                    }

                }

                if (isset($data['piece_rccm_demande_enrolement'])) {

                    $filefront = $data['piece_rccm_demande_enrolement'];

                    if ($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg") {

                        $fileName1 = 'piece_rccm_demande_enrolement' . '_' . rand(111, 99999) . '_' . 'piece_rccm_demande_enrolement' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/piece_rccm_demande_enrolement/'), $fileName1);

                        $input['piece_rccm_demande_enrolement'] = $fileName1;

                    } else {
                        return redirect()->route('enrolements')
                            ->with('error', 'l\extension du fichier de la RCCM n\'est pas correcte');
                    }

                }

                if (isset($data['piece_attestation_immatriculati'])) {

                    $filefront = $data['piece_attestation_immatriculati'];

                    if ($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg") {

                        $fileName1 = 'piece_attestation_immatriculati' . '_' . rand(111, 99999) . '_' . 'piece_attestation_immatriculati' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/piece_attestation_immatriculati/'), $fileName1);

                        $input['piece_attestation_immatriculati'] = $fileName1;

                    } else {
                        return redirect()->route('enrolements')
                            ->with('error', 'l\extension du fichier de l\attestation immatriculation n\'est pas correcte');
                    }

                }

                $input['date_depot_demande_enrolement'] = Carbon::now();
                $input['ncc_demande_enrolement'] = mb_strtoupper($input['ncc_demande_enrolement']);
                $input['raison_sociale_demande_enroleme'] = mb_strtoupper($input['raison_sociale_demande_enroleme']);
                $input['sigl_demande_enrolement'] = mb_strtoupper($input['sigl_demande_enrolement']);
                if (isset($input['numero_cnps_demande_enrolement'])) {
                    $input['numero_cnps_demande_enrolement'] = mb_strtoupper($input['numero_cnps_demande_enrolement']);
                }
                if (isset($input['rccm_demande_enrolement'])) {
                    $input['rccm_demande_enrolement'] = mb_strtoupper($input['rccm_demande_enrolement']);
                }
                $input['id_forme_juridique'] = $validformejuri;

                 /***********************  debut de traitemente du profil collecte de taxe automatique*************/

                 /*$input['id_user'] = 161;
                 $input['flag_traitement_demande_enrolem'] = true;
                 $input['flag_valider_demande_enrolement'] = true;
                 $input['date_traitement_demande_enrolem'] = Carbon::now();*/

                 /*********************** fin debut de traitemente du profil collecte de taxe automatique*************/


                DemandeEnrolement::create($input);

                $insertedDemandeenreolementId = DemandeEnrolement::latest()->first()->id_demande_enrolement;

                $rais = $input['sigl_demande_enrolement'];
                if (isset($input['email_demande_enrolement'])) {
                    $sujet = "Enrolement FDFP";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
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

                // if($input['tel_demande_enrolement']){
                //     $content = "CHER(e) ".$rais.",\nVOTRE DEMANDE ENROLEMENT A ETE EFFECTUEE AVEC SUCCES.LE TRAITEMENT DE VOTRE DEMANDE EFFECTUERA DANS UN DELAI DE 48h !";
                //     SmsPerso::sendSMS($input['tel_demande_enrolement'],$content);
                // }

                /*************** second partie  de traitemente du profil collecte de taxe automatique*********/

                /*$demandeenrole1 = DemandeEnrolement::find($insertedDemandeenreolementId);

                $numfdfp = 'fdfp' . Gencode::randStrGen(4, 5);

                Entreprises::create([
                    'id_demande_enrolement' => $demandeenrole1->id_demande_enrolement,
                    'numero_fdfp_entreprises' => $numfdfp,
                    'ncc_entreprises' => $demandeenrole1->ncc_demande_enrolement,
                    'raison_social_entreprises' => $demandeenrole1->raison_sociale_demande_enroleme,
                    'tel_entreprises' => $demandeenrole1->tel_demande_enrolement,
                    'indicatif_entreprises' => $demandeenrole1->indicatif_demande_enrolement,
                    'numero_cnps_entreprises' => $demandeenrole1->numero_cnps_demande_enrolement,
                    'id_localite_entreprises' => $demandeenrole1->id_localite,
                    'id_centre_impot' => $demandeenrole1->id_centre_impot,
                    'id_activite_entreprises' => $demandeenrole1->id_activites,
                    'id_secteur_activite_entreprise' => $demandeenrole1->id_secteur_activite,
                    'id_forme_juridique_entreprise' => $demandeenrole1->id_forme_juridique,
                    'id_pays' => $demandeenrole1->indicatif_demande_enrolement,
                    'flag_actif_entreprises' => true
                ]);

                $insertedId = Entreprises::latest()->first()->id_entreprises;
                $entreprise = Entreprises::latest()->first();

                if (isset($demandeenrole1->piece_dfe_demande_enrolement)) {
                    Pieces::create([
                        'id_entreprises' => $insertedId,
                        'libelle_pieces' => $demandeenrole1->piece_dfe_demande_enrolement,
                        'code_pieces' => 'dfe',
                    ]);
                }

                if (isset($demandeenrole1->piece_rccm_demande_enrolement)) {
                    Pieces::create([
                        'id_entreprises' => $insertedId,
                        'libelle_pieces' => $demandeenrole1->piece_rccm_demande_enrolement,
                        'code_pieces' => 'rccm',
                    ]);
                }

                if (isset($demandeenrole1->piece_attestation_immatriculati)) {
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
                    return redirect()->route('enrolements')
                        ->with('danger', 'Echec : Cet mail est déja utilisé par une entreprise !');
                }

                $clientrechnum = DB::table('users')->where([['cel_users', '=', $cel_users]])->get();

                if (count($clientrechnum) > 0) {
                    return redirect()->route('enrolements')
                        ->with('danger', 'Echec : Cet numero est déja utilisé par une entreprise !');
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
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher $name ,</b>
                                    <br><br>Nous sommes ravis de vous accueillir sur notre plateforme ! <br> Votre compte a été créé avec
                                        succès, et il est maintenant prêt à être utilisé.
                                    <br><br>
                                    <br><br>Voici un récapitulatif de vos informations de compte :
                                    <br><b>Nom d'utilisateur : </b> $name
                                    <br><b>Adresse e-mail : </b> $emailcli
                                    <br><b>Identifiant : </b> $ncc_entreprises
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
                }*/

                /*********************** fin second partie de traitemente du profil collecte de taxe automatique*************/
            }

            if ($valcodeformejuri == 'PU') {
                $data = $request->all();
                $this->validate($request, [
                    'raison_sociale_demande_enroleme' => 'required',
                    'sigl_demande_enrolement' => 'required',
                    'email_demande_enrolement' =>['required','email', 'unique:users,email',
                        Rule::unique('demande_enrolement')->where(function($query) use ($data) {
                            $query->where('email_demande_enrolement',$data['email_demande_enrolement'])
                                ->where('flag_valider_demande_enrolement',true);
                        })
                    ],
                    'indicatif_demande_enrolement' => 'required',
                    'tel_demande_enrolement' => ['required', 'unique:users,tel_users',
                        Rule::unique('demande_enrolement')->where(function($query) use ($data) {
                            $query->where('tel_demande_enrolement',$data['tel_demande_enrolement'])
                                ->where('flag_valider_demande_enrolement',true);
                        })
                    ],
                    'id_localite' => 'required',
                    'id_centre_impot' => 'required',
                    //'id_activites' => 'required',
                    'id_secteur_activite' => 'required',
                    'ncc_demande_enrolement' =>['required', 'min:6', 'max:9', 'unique:users,login_users',
                        Rule::unique('demande_enrolement')->where(function($query) use ($data) {
                            $query->where('ncc_demande_enrolement',$data['ncc_demande_enrolement'])
                                ->where('flag_valider_demande_enrolement',true);
                        })
                    ],
                    'piece_dfe_demande_enrolement' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                  //  'g-recaptcha-response' => ['required', new Recaptcha],
                ], [
                    'raison_sociale_demande_enroleme.required' => 'Veuillez ajouter votre raison sociale',
                    'sigl_demande_enrolement.required' => 'Veuillez ajouter votre sigle',
                    'email_demande_enrolement.required' => 'Veuillez ajouter un email',
                    'email_demande_enrolement.unique' => 'Cet email est déjà utilisé dans le système. Veuillez contacter l\'administrateur',
                    'indicatif_demande_enrolement.required' => 'Veuillez ajouter un indicatif',
                    'tel_demande_enrolement.required' => 'Veuillez ajouter un contact',
                    'tel_demande_enrolement.unique' => 'Cet contact est déjà utilisé dans le système. Veuillez contacter l\'administrateur',
                    'id_localite.required' => 'Veuillez sélectionner une localité',
                    'id_centre_impot.required' => 'Veuillez sélectionner un centre d\'impôt',
                    'id_secteur_activite.required' => 'Veuillez sélectionner un secteur d\'activité',
                    'ncc_demande_enrolement.required' => 'Veuillez ajouter un numéro de compte contribuable (NCC)',
                    'ncc_demande_enrolement.min' => 'Le numéro de compte contribuable (NCC) doit avoir au moins 6 caractères',
                    'ncc_demande_enrolement.max' => 'Le numéro de compte contribuable (NCC) doit avoir au plus 9 caractères',
                    'ncc_demande_enrolement.unique' => 'Ce numéro de compte contribuable (NCC) est déjà utilisé dans le système. Veuillez contactez l\'administrateur',
                    'piece_dfe_demande_enrolement.required' => 'Veuillez ajouter une piéce DFE',
                    'piece_dfe_demande_enrolement.uploaded' => 'Veuillez ajouter une piéce DFE',
                    'piece_dfe_demande_enrolement.mimes' => 'Les formats requis pour la pièce de la DFE est: png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF',
                    'piece_dfe_demande_enrolement.max' => 'la taille maximale doit être de 5 MégaOctets',
                  //  'g-recaptcha-response.required' => 'Veuillez saisir le vérificateur de securité'
                ]);


                $input = $request->all();

                if (isset($data['piece_dfe_demande_enrolement'])) {

                    $filefront = $data['piece_dfe_demande_enrolement'];

                    //dd($filefront->extension());

                    if ($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg") {

                        $fileName1 = 'piece_dfe_demande_enrolement' . '_' . rand(111, 99999) . '_' . 'piece_dfe_demande_enrolement' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/piece_dfe_demande_enrolement/'), $fileName1);

                        $input['piece_dfe_demande_enrolement'] = $fileName1;
                    } else {
                        return redirect()->route('enrolements')
                            ->with('error', 'l\'extension du fichier de la DFE n\'est pas correcte');
                    }

                }

                $input['date_depot_demande_enrolement'] = Carbon::now();
                $input['ncc_demande_enrolement'] = mb_strtoupper($input['ncc_demande_enrolement']);
                $input['raison_sociale_demande_enroleme'] = mb_strtoupper($input['raison_sociale_demande_enroleme']);
                $input['sigl_demande_enrolement'] = mb_strtoupper($input['sigl_demande_enrolement']);
                if (isset($input['numero_cnps_demande_enrolement'])) {
                    $input['numero_cnps_demande_enrolement'] = mb_strtoupper($input['numero_cnps_demande_enrolement']);
                }
                if (isset($input['rccm_demande_enrolement'])) {
                    $input['rccm_demande_enrolement'] = mb_strtoupper($input['rccm_demande_enrolement']);
                }
                $input['id_forme_juridique'] = $validformejuri;

                /***********************  debut de traitemente du profil collecte de taxe automatique*************/

                /*$input['id_user'] = 161;
                $input['flag_traitement_demande_enrolem'] = true;
                $input['flag_valider_demande_enrolement'] = true;
                $input['date_traitement_demande_enrolem'] = Carbon::now();*/

                /*********************** fin debut de traitemente du profil collecte de taxe automatique*************/

                DemandeEnrolement::create($input);

                $insertedDemandeenreolementId = DemandeEnrolement::latest()->first()->id_demande_enrolement;

                $rais = $input['sigl_demande_enrolement'];
                if (isset($input['email_demande_enrolement'])) {
                    $sujet = "Enrolement FDFP";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher(e),  $rais ,</b>
                                    <br><br>Votre demande d'enrôlement a été effectuée avec succès. Le traitement de votre demande s'effectuera dans un délai de 48h!
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                     // $messageMailEnvoi = Email::get_envoimailTemplate($input['email_demande_enrolement'], $rais, $messageMail, $sujet, $titre);
                }

                //Envoyer notification via SMS
                if($input['tel_demande_enrolement']){
                    $content = "CHER(e) ".$rais.",\nVOTRE DEMANDE ENROLEMENT A ETE EFFECTUEE AVEC SUCCES.LE TRAITEMENT DE VOTRE DEMANDE EFFECTUERA DANS UN DELAI DE 48h !";
                    //SmsPerso::sendSMS($input['tel_demande_enrolement'],$content);
                }

            }
        }

        return redirect()->route('enrolements')
            ->with('success', '<strong>Félicitations <br>Votre demande d\'enrôlement a été effectuée avec succès.<br>Le traitement de votre demande s\'effectuera dans un délai de 48h !</strong>');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $demandeenrole = DemandeEnrolement::find($id);

        $statutoperations = StatutOperation::all();
        $statutoperation = "<option value=''> Selectionnez le statut </option>";
        foreach ($statutoperations as $comp) {
            $statutoperation .= "<option value='" . $comp->id_statut_operation . "'>" . $comp->libelle_statut_operation . " </option>";
        }

        $motifs = Motif::where([['code_motif', '=', 'DEN']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif . "'>" . $comp->libelle_motif . " </option>";
        }

        return view('enrolement.edit', compact('demandeenrole', 'statutoperation', 'motif'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $demandeenrole = DemandeEnrolement::find($id);
        $logo = Menu::get_logo();

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] === 'Rejeter') {
                $this->validate($request, [
                    'id_motif' => 'required',
                    'commentaire_demande_enrolement' => 'required'
                ], [
                    'id_motif.required' => 'Veuillez selectionner le motif rejet.',
                    'commentaire_demande_enrolement.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();

                $input['id_user'] = Auth::user()->id;
                $input['flag_traitement_demande_enrolem'] = true;
                $input['flag_rejeter_demande_enrolement'] = true;
                $input['date_traitement_demande_enrolem'] = Carbon::now();

                $demandeenrole->update($input);

                $demandeenrole1 = DemandeEnrolement::find($id);

                if (isset($demandeenrole1->email_demande_enrolement)) {
                    $sujet = "Rejet pour la demande enrolement sur e-FDFP";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher,  $demandeenrole1->sigl_demande_enrolement ,</b>
                                    <br><br>Nous avons examiné votre demande d'activation de compte sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

                                    <br><b>Motif de rejet  : </b> " . @$demandeenrole1->motif->libelle_motif . "
                                    <br><b>Commentaire : </b> " . @$demandeenrole1->motif->commentaire_motif . "
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

                //Envoi SMS Rejeté
                // if (isset($demandeenrole1->tel_demande_enrolement)) {
                //     $content = "Cher ".$demandeenrole1->sigl_demande_enrolement."<br>, Nous avons examiné votre demande d'activation de compte sur Nom de la plateforme, et
                //         malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :".$demandeenrole1->motif->libelle_motif."
                //         <br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
                //         fournir, n'hésitez pas à nous contacter à mailsupport... pour obtenir de l'aide.
                //         Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
                //         soumettre une nouvelle demande lorsque les problèmes seront résolus.<br>
                //         Cordialement,
                //         L'équipe e-FDFP";
                //     SmsPerso::sendSMS($demandeenrole1->tel_demande_enrolement,$content);
                // }

                return redirect()->route('enrolement.index')->with('success', 'Traitement effectué avec succès.');
            }

            if ($data['action'] === 'Recevable') {
                $this->validate($request, [
                    'id_motif_recevable' => 'required'
                ], [
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);

                $input = $request->all();

                $input['id_user'] = Auth::user()->id;
                $input['flag_recevablilite_demande_enrolement'] = true;
                //$input['flag_traitement_demande_enrolem'] = true;
                $input['date_recevabilite_demande_enrolement'] = Carbon::now();

                $demandeenrole->update($input);

                $demandeenrole1 = DemandeEnrolement::find($id);

                //Envoi SMS recevable
                // if (isset($demandeenrole1->tel_demande_enrolement)) {
                //     $content = "CHER(E) ".$demandeenrole1->sigl_demande_enrolement.",\n NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE DEMANDE D ENROLEMENT EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES.\n\nCORDIALEMENT, L EQUIPE E-FDFP";
                //     SmsPerso::sendSMS($demandeenrole1->tel_demande_enrolement,$content);
                // }
                if (isset($demandeenrole1->email_demande_enrolement)) {
                        $sujet = "Recevabilité de demande votre d'enrôlement sur e-FDFP";
                        $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                        $messageMail = "<b>Cher(e) $demandeenrole1->sigl_demande_enrolement ,</b>
                                    <br><br>Nous sommes ravis de vous informer que votre demande d'enrôlement est jugée recevable. Nous apprécions votre intérêt pour nos services.<br><br> Cordialement l'équipe E-FDFP.
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                        $messageMailEnvoi = Email::get_envoimailTemplate($demandeenrole1->email_demande_enrolement, $demandeenrole1->raison_sociale_demande_enroleme, $messageMail, $sujet, $titre);
                }


                    return redirect('enrolement/' . Crypt::UrlCrypt($id) . '/edit')->with('success', 'Succes : Information mise a jour reussi ');

                // return redirect()->route('enrolement.index')->with('success', 'Recevabilité effectué avec succès.');
            }

            if ($data['action'] === 'NonRecevable') {
                $this->validate($request, [
                    'id_motif_recevable' => 'required'
                ], [
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);

                $input = $request->all();

                $input['id_user'] = Auth::user()->id;
                $input['flag_recevablilite_demande_enrolement'] = false;
                $input['flag_traitement_demande_enrolem'] = true;
                $input['flag_rejeter_demande_enrolement'] = true;
                $input['date_recevabilite_demande_enrolement'] = Carbon::now();

                $demandeenrole->update($input);

                $demandeenrole1 = DemandeEnrolement::find($id);
                $logo = Menu::get_logo();
                if (isset($demandeenrole1->email_demande_enrolement)) {
                    $sujet = "Recevabilité de demande enrolement sur e-FDFP";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher,  $demandeenrole1->sigl_demande_enrolement ,</b>
                                    <br><br>Nous avons examiné votre demande d'enrolement sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

                                    <br><b>Motif de rejet  : </b> " . @$demandeenrole1->motif1->libelle_motif . "
                                    <br><b>Commentaire : </b> " . @$demandeenrole1->motif1->commentaire_motif . "
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

                //Envoi SMS Rejeté
//                 if (isset($demandeenrole1->tel_demande_enrolement)) {

// //                  $content = " ".$demandeenrole1->raison_sociale_demande_enroleme.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE DEMANDE D ENROLEMENT EST JUGE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES.\n\nCORDIALEMENT, L EQUIPE E-FDFP";


//                     $content = "CHER(E) ".$demandeenrole1->sigl_demande_enrolement.",\n NOUS AVONS EXAMINE VOTRE DEMANDE D ACTIVATION DE COMPTE SUR".route('/').", ET
//                         MALHEUREUSEMENT, NOUS NE POUVONS PAS L APPROUVER POUR LA RAISON SUIVANTE:".$demandeenrole1->motif1->libelle_motif."
//                         \nSI VOUS ESTIMEZ QUE CELA EST UNE ERREUR OU SI VOUS AVEZ DES INFORMATIONS SUPPLEMENTAIRES A FOURIR, N HESITEZ PAS A NOUS CONTACTER POUR OBTENIR DE L AIDE.\n
//                         NOUS APPRECIONS VOTRE INTERET POUR NOTRE SERVICE ET ESPERONS QUE VOUS ENVISAGEREZ DE SOUMETTRE UNE NOUVELLE DEMANDE LORSQUE LES PROBLEMES SONT RESOLUS.\n
//                         CORDIALEMENT\n,
//                         L'EQUIPE E-FDFP";
//                     SmsPerso::sendSMS($demandeenrole1->tel_demande_enrolement,$content);
//                 }

                return redirect()->route('enrolement.index')->with('success', 'Recevabilité effectué avec succès.');
            }

            if ($data['action'] === 'Valider') {

                $this->validate($request, [
                    'id_motif' => 'required'
                ], [
                    'id_motif.required' => 'Veuillez selectionner le motif de validation.',
                ]);

                $input = $request->all();

                $input['id_user'] = Auth::user()->id;
                $input['flag_traitement_demande_enrolem'] = true;
                $input['flag_valider_demande_enrolement'] = true;
                $input['date_traitement_demande_enrolem'] = Carbon::now();

                $demandeenrole->update($input);

                $demandeenrole1 = DemandeEnrolement::find($id);

                $numfdfp = 'fdfp' . Gencode::randStrGen(4, 5);

                $entreprise = Entreprises::create([
                    'id_demande_enrolement' => $demandeenrole1->id_demande_enrolement,
                    'numero_fdfp_entreprises' => $numfdfp,
                    'ncc_entreprises' => $demandeenrole1->ncc_demande_enrolement,
                    'rccm_entreprises' => $demandeenrole1->rccm_demande_enrolement,
                    'email_entreprises' => $demandeenrole1->email_demande_enrolement,
                    'raison_social_entreprises' => $demandeenrole1->raison_sociale_demande_enroleme,
                    'tel_entreprises' => $demandeenrole1->tel_demande_enrolement,
                    'indicatif_entreprises' => $demandeenrole1->indicatif_demande_enrolement,
                    'numero_cnps_entreprises' => $demandeenrole1->numero_cnps_demande_enrolement,
                    'id_localite_entreprises' => $demandeenrole1->id_localite,
                    'id_centre_impot' => $demandeenrole1->id_centre_impot,
                    'id_activite_entreprises' => $demandeenrole1->id_activites,
                    'id_secteur_activite_entreprise' => $demandeenrole1->id_secteur_activite,
                    'id_forme_juridique_entreprise' => $demandeenrole1->id_forme_juridique,
                    'id_pays' => $demandeenrole1->indicatif_demande_enrolement,
                    'sigl_entreprises' => $demandeenrole1->sigl_demande_enrolement,
                    'flag_actif_entreprises' => true
                ]);

                $insertedId = $entreprise->id_entreprises;
                //$entreprise = Entreprises::latest()->first();

                if (isset($demandeenrole1->piece_dfe_demande_enrolement)) {
                    Pieces::create([
                        'id_entreprises' => $insertedId,
                        'libelle_pieces' => $demandeenrole1->piece_dfe_demande_enrolement,
                        'code_pieces' => 'dfe',
                    ]);
                }

                if (isset($demandeenrole1->piece_rccm_demande_enrolement)) {
                    Pieces::create([
                        'id_entreprises' => $insertedId,
                        'libelle_pieces' => $demandeenrole1->piece_rccm_demande_enrolement,
                        'code_pieces' => 'rccm',
                    ]);
                }

                if (isset($demandeenrole1->piece_attestation_immatriculati)) {
                    Pieces::create([
                        'id_entreprises' => $insertedId,
                        'libelle_pieces' => $demandeenrole1->piece_attestation_immatriculati,
                        'code_pieces' => 'attest_immat',
                    ]);
                }

                $roles = Role::where([['code_roles', '=', 'ENTREPRISE']])->first();

                $name = $entreprise->sigl_entreprises;
                $prenom_users = $entreprise->raison_social_entreprises;
                $emailcli = $demandeenrole1->email_demande_enrolement;
                $id_partenaire = $entreprise->id_entreprises;
                $cel_users = $entreprise->tel_entreprises;
                $indicatif_tel_users = $entreprise->indicatif_entreprises;
                $ncc_entreprises = $entreprise->ncc_entreprises;

                $role = $roles->name;

                $clientrech = DB::table('users')->where([['email', '=', $emailcli]])->get();

                if (count($clientrech) > 0) {
                    return redirect()->route('enrolement.index')
                        ->with('danger', 'Echec : Cet mail est déja utilisé par une entreprise !');
                }

                $clientrechnum = DB::table('users')->where([['cel_users', '=', $cel_users]])->get();

                if (count($clientrechnum) > 0) {
                    return redirect()->route('enrolement.index')
                        ->with('danger', 'Echec : Cet numero est déja utilisé par une entreprise !');
                }

                $passwordCli = '123456789'; //Crypt::MotDePasse(); //
               // dd($passwordCli);
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
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher $name ,</b>
                                    <br><br>Nous sommes ravis de vous accueillir sur notre plateforme ! <br> Votre compte a été créé avec
                                        succès, et il est maintenant prêt à être utilisé.
                                    <br><br>
                                    <br><br>Voici un récapitulatif de vos informations de compte :
                                    <br><b>Nom d'utilisateur : </b> $name
                                    <br><b>Adresse e-mail : </b> $emailcli
                                    <br><b>Identifiant : </b> $ncc_entreprises
                                    <br><b>Mot de passe : </b> $passwordCli
                                    <br><b>Date de création du compte : : </b> $entreprise->created_at
                                    <br><br>
                                    <br><br>Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :
                                            ".route('/')."
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";


                  //  $messageMailEnvoi = Email::get_envoimailTemplate($emailcli, $name, $messageMail, $sujet, $titre);
                }

                //Envoi SMS Validé
                if (isset($cel_users)) {
                    $content = "CHER ".$name." ,\nNOUS SOMMES RAVIS DE VOUS ACCUEILLIR SUR NOTRE PLATEFORME . VOICI UN RECAPITULATIF DE VOS INFORMATIONS DE COMPTE : IDENTIFIANT : ".$ncc_entreprises."\nMOT DE PASSE : ".$passwordCli."\nDATE DE CREATION DU COMPTE : ".$entreprise->created_at."\nPOUR ACTIVER VOTRE COMPTE, VEUILLEZ CLIQUER SUR LE LIEN CI-DESSOUS : ".route('/');
                   // SmsPerso::sendSMS($demandeenrole1->tel_demande_enrolement,$content);
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
