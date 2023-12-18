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
use App\Helpers\InfosEntreprise;
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
        $roles = DB::table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->where([['users.id','=',$user_id]])
                ->first();
            $idroles = $roles->role_id;
        $nomrole = $roles->name ;
        //dd($nomrole);
        // dd($user_id);
        if ($nomrole == 'ENTREPRISE'){
            $demandeenroles = ProjetEtude::where('id_user','=',$user_id)->get();

        }else if ($nomrole == 'CHEF DE DEPARTEMENT') {
            //dd('Autre');
            $demandeenroles = ProjetEtude::where('id_user_affecte','=',$user_id)->get();
        }else if ($nomrole == 'CHEF DE SERVICE') {
            $demandeenroles = ProjetEtude::where('id_chef_serv','=',$user_id)->get();
        }else if ($nomrole == 'CHARGER ETUDE') {
            //dd('Autre');
            $demandeenroles = ProjetEtude::where('id_charge_etude','=',$user_id)->get();
        }
        // dd($demandeenroles);
        //$demandeenroles = ProjetEtude::where('id_user','=',$user_id)->get();
        return view('projetetude.index', compact('demandeenroles','nomrole'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::find(Auth::user()->id);
        $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);
        //dd($user->email);

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

        return view('projetetude.create', compact('activite','centreimpot','localite','pay','entreprise','user'));
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

           // Recuperation de l'entreprise
           $user = User::find(Auth::user()->id);
           $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);
            $id_entreprise = $entreprise->id_entreprises;
            // Enregistrement des données
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
            $input['id_processus'] = 2;
            $input['id_entreprise'] = 2;
            // Creation d'un numero de dossier
            $number = mt_rand(10000,999999);
            $input['code_dossier'] = $id_entreprise;

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
                'code_pieces' => '6',
                'libelle_pieces' => $input['offre_financiere']
            ]);


        }
        return redirect('projetetude/'.Crypt::UrlCrypt($id_projet).'/edit')->with('success', 'Succes : Votre projet d\'etude a été crée ');

            //return redirect()->route('projetetude.index')->with('success', 'Votre demande de projet d\'etude a ete cree avec succes');
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
        // Recuperation des informations de l'entreprise
        $projetetude = ProjetEtude::find($id);
        $enterprise = User::find($projetetude->id_user);
        $enterprise_mail = $enterprise->email;
        $entreprise = InfosEntreprise::get_infos_entreprise($enterprise->login_users);
        //dd($entreprise);
        $user_id = Auth::user()->id;
        //dd($user_id);
        $roles = DB::table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->where([['users.id','=',$user_id]])
                ->first();
            $idroles = $roles->role_id;
        $nomrole = $roles->name ;
        //dd($nomrole);
        $projetetude = ProjetEtude::find($id);
        //dd($projetetude['titre_projet_etude']);
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','1']])->get();
        $piecesetude1 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','2']])->get();
        $piecesetude2 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','3']])->get();
        $piecesetude3 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','4']])->get();
        $piecesetude4 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','5']])->get();
        $piecesetude5 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','6']])->get();
        $piecesetude6 = $piecesetude['0']['libelle_pieces'];
        //dd($piecesetude['0']['libelle_pieces']);
        // Pieces Projet Etudes
        //dd($projetetude->piecesProjetEtudes['0']->libelle_pieces);
        //dd($projetetude->flag_soumis);

        // Recuperation des agent
        //dd($nomrole);
        if($projetetude->flag_soumis == true) {
            if ($nomrole == "CHEF DE DEPARTEMENT"){
                //dd($nomrole);
            $num_agce = Auth::user()->num_agce;
            $num_direction = Auth::user()->id_direction;
            $chefservice = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.name', 'users.prenom_users', 'users.id')
            ->where([['roles.id','=',19],['users.num_agce','=',$num_agce],['users.id_direction','=',$num_direction]])
            ->get();
            //dd($chefservice);
            //$listeuser = User::all();
            $listeuser = $chefservice;
            $listeuserfinal = "<option value=''> Selectionnez un chef de service </option>";
            foreach ($listeuser as $comp) {
                $listeuserfinal .= "<option value='" . $comp->id  . "'>" . $comp->name . " ". $comp->prenom_users   ." </option>";
            }
        } else {
            //dd($nomrole);
            $num_agce = Auth::user()->num_agce;
            $num_direction = Auth::user()->id_direction;
            $chargetude = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.name', 'users.prenom_users', 'users.id')
            ->where([['roles.id','=',22],['users.num_agce','=',$num_agce],['users.id_direction','=',$num_direction]])
            ->get();
            //dd($chargetude);
            //$listeuser = User::all();
            $listeuser = $chargetude;
            $listeuserfinal = "<option value=''> Selectionnez un chargé d'etude </option>";
            foreach ($listeuser as $comp) {
                $listeuserfinal .= "<option value='" . $comp->id  . "'>" . $comp->name . " ". $comp->prenom_users   ." </option>";
            }
        }

        }else{
            $listeuserfinal = "";
        }

        // recuperation chef de service
        if($projetetude->flag_soumis_chef_service == true ){

            $id_cs = $projetetude->id_chef_serv;
            //dd($id_cs);
            $user_cs = User::find($id_cs);
             $user_cs_name = $user_cs->name . ' '.$user_cs->prenom_users;
        }else {
            $user_cs_name = '';
        }

        // recuperation charge d'etude
        if($projetetude->flag_soumis_charge_etude == true ){

            $id_cs = $projetetude->id_charge_etude;
            //dd($id_cs);
            $user_cs = User::find($id_cs);
             $user_ce_name = $user_cs->name . ' '.$user_cs->prenom_users;
        }else {
            $user_ce_name = '';
        }

        // recuperation de l'etat de recevabilite
        $idmot = $projetetude->motif_rec ;
        if($projetetude->flag_valide == true ){

             $etat_dossier = 'Valide';
        }else {
            $etat_dossier = 'Rejete';
        }

        $motif_p = $projetetude->motif_rec ;
        //dd($motif);


        // Recuperation des motif & des statuts de recevabilite
        $motif = Motif::where([['code_motif','=','PRE']])->get();;
        $motifs = "<option value=''> Selectionnez un motif </option>";
        foreach ($motif as $comp) {
            $motifs .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }
        $statut = StatutOperation::where([['code_statut_operation','=','PRE']])->get();;
        $statuts = "<option value=''> Selectionnez un statut </option>";
        foreach ($statut as $comp) {
            $statuts .= "<option value='" . $comp->id_statut_operation  . "'>" . $comp->libelle_statut_operation ." </option>";
        }

        $statutinstall = StatutOperation::where([['code_statut_operation','=','PRI']])->get();;
        $statutinst = "<option value=''> Selectionnez un statut </option>";
        foreach ($statutinstall as $comp) {
            $statutinst .= "<option value='" . $comp->id_statut_operation  . "'>" . $comp->libelle_statut_operation ." </option>";
        }
        //dd($nomrole);

        return view('projetetude.edit', compact('enterprise_mail','entreprise','motifs','nomrole','motif_p','etat_dossier','statuts','statutinst','motifs','user_ce_name','user_cs_name','projetetude','listeuserfinal','piecesetude1','piecesetude2','piecesetude3','piecesetude4' ,'piecesetude5','piecesetude6'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);


        if ($request->isMethod('put')) {

            $data = $request->all();
            //dd($data);
            /// Traitement de l'instruction
            if($data['action'] === 'soumission_instruction'){
                // ID du plan
                //dd($data);
                    // traitement valide
                    if($data['id_statut_instruction'] === '6'){
                        //dd($data);
                        if (isset($data['fichier_instruction'])){

                            $filefront = $data['fichier_instruction'];

                            if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                                $fileName1 = 'fichier_instruction'. '_' . rand(111,99999) . '_' . 'fichier_instruction' . '_' . time() . '.' . $filefront->extension();

                                $filefront->move(public_path('pieces_projet/fichier_instruction/'), $fileName1);

                                $input['fichier_instruction'] = $fileName1;

                            }else{
                                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('error', 'Veuillez changer le type de fichier de l\'instruction');

                            }

                        }

                        $date_soumission = Carbon::now();
                        $projetetude = ProjetEtude::find($id);
                        $projetetude->statut_instruction = true;
                        $projetetude->date_instruction = $date_soumission;
                        $projetetude->commentaires_instruction = $data['commentaires_instruction'];
                        $projetetude->titre_projet_instruction = $data['titre_projet_instruction'];
                        $projetetude->contexte_probleme_instruction = $data['contexte_probleme_instruction'];
                        $projetetude->objectif_general_instruction = $data['objectif_general_instruction'];
                        $projetetude->objectif_specifique_instruction = $data['objectif_specifique_instruction'];
                        $projetetude->resultat_attendus_instruction = $data['resultat_attendu_instruction'];
                        $projetetude->champ_etude_instruction = $data['champ_etude_instruction'];
                        $projetetude->cible_instruction = $data['cible_instruction'];
                        $projetetude->methodologie_instruction = $data['methodologie_instruction'];
                        $projetetude->montant_projet_instruction = $data['montant_projet_instruction'];
                        $projetetude->piece_jointe_instruction =$fileName1;
                        $projetetude->save();
                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Dossier validé effectue avec succes');
                    }

                    // traitement rejet
                    if($data['id_statut_instruction'] === '7'){
                        //dd($data);
                        if (isset($data['fichier_instruction'])){
 // Projet Formation
                            $filefront = $data['fichier_instruction'];

                            if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                                $fileName1 = 'fichier_instruction'. '_' . rand(111,99999) . '_' . 'fichier_instruction' . '_' . time() . '.' . $filefront->extension();

                                $filefront->move(public_path('pieces_projet/fichier_instruction/'), $fileName1);

                                $input['fichier_instruction'] = $fileName1;

                            }else{
                                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('error', 'Veuillez changer le type de fichier de l\'instruction');

                            }

                        }
                        $date_soumission = Carbon::now();
                        $projetetude = ProjetEtude::find($id);
                        $projetetude->statut_instruction = false;
                        $projetetude->date_instruction = $date_soumission;
                        $projetetude->commentaires_instruction = $data['commentaires_instruction'];
                        $projetetude->titre_projet_instruction = $data['titre_projet_instruction'];
                        $projetetude->contexte_probleme_instruction = $data['contexte_probleme_instruction'];
                        $projetetude->objectif_general_instruction = $data['objectif_general_instruction'];
                        $projetetude->objectif_specifique_instruction = $data['objectif_specifique_instruction'];
                        $projetetude->resultat_attendus_instruction = $data['resultat_attendu_instruction'];
                        $projetetude->champ_etude_instruction = $data['champ_etude_instruction'];
                        $projetetude->cible_instruction = $data['cible_instruction'];
                        $projetetude->methodologie_instruction = $data['methodologie_instruction'];
                        $projetetude->montant_projet_instruction = $data['montant_projet_instruction'];
                        $projetetude->piece_jointe_instruction =$fileName1;
                        $projetetude->save();
                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('error', 'Rejet de l\'instruction effectue avec succes');
                    }
          }
            // Traitement de la recevabilite
            if($data['action'] === 'soumission_recevabilite'){
                // ID du plan

               // traitement recavable
               if($data['id_charge_etude'] === '3'){
                //dd($data);
                $date_soumission = Carbon::now();
                $projetetude = ProjetEtude::find($id);
                $projetetude->flag_valide = true;
                $projetetude->flag_rejet = false;
                $projetetude->flag_attente_rec = false;
                $projetetude->date_valide = $date_soumission;
                $projetetude->commentaires_recevabilite = $data['commentaires_chef_service'];
                // Recuperation du motif
                $id_motif = intval($data['motif_rec']);
                $motif = Motif::find($id_motif);
                // Atribution au chef de departement
                // Recuperation de l'id
                // $user_id = Auth::user()->id;
                // $projetetude->id_charge_etude = $user_id;
                $projetetude->motif_rec = $motif->libelle_motif;
                $projetetude->save();
                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Recevabilite effectue avec succes');
               }

               // traitement attente
               if($data['id_charge_etude'] === '4'){
                //dd($data);
                $date_soumission = Carbon::now();
                $projetetude = ProjetEtude::find($id);
                $projetetude->flag_attente_rec = true;
                // $projetetude->flag_rejet = false;
                $projetetude->date_mis_en_attente = $date_soumission;
                $projetetude->commentaires_recevabilite = $data['commentaires_chef_service'];
                // Recuperation du motif
                $id_motif = intval($data['motif_rec']);
                $motif = Motif::find($id_motif);
                // Atribution au chef de departement
                // Recuperation de l'id
                // $user_id = Auth::user()->id;
                // $projetetude->id_charge_etude = $user_id;
                $projetetude->motif_rec = $motif->libelle_motif;
                $projetetude->save();
                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Mise en attente  du projet d\'etude edffectue effectue avec succes');
               }

               // traitement rejet
               if($data['id_charge_etude'] === '5'){
                //dd($data);
                $date_soumission = Carbon::now();
                $projetetude = ProjetEtude::find($id);
                $projetetude->flag_valide = false;
                $projetetude->flag_rejet = true;
                $projetetude->flag_attente_rec = false;
                $projetetude->date_rejet = $date_soumission;
                $projetetude->commentaires_recevabilite = $data['commentaires_chef_service'];
                // Atribution au chef de departement
                // Recuperation de l'id
                // $user_id = Auth::user()->id;
                // $projetetude->id_charge_etude = $user_id;
                // Recuperation du motif
                $id_motif = intval($data['motif_rec']);
                $motif = Motif::find($id_motif);
                // Atribution au chef de departement
                // Recuperation de l'id
                // $user_id = Auth::user()->id;
                // $projetetude->id_charge_etude = $user_id;
                $projetetude->motif_rec = $motif->libelle_motif;
                $projetetude->save();
                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('error', 'Rejet du projet d\'etude edffectue effectue avec succes');
               }
            }
            // Traitement de la soumission du Chef de service
            if($data['action'] === 'soumission_plan_etude_cs'){
                // ID du plan
               // dd($data);
                $date_soumission = Carbon::now();
                $projetetude = ProjetEtude::find($id);
                $projetetude->flag_soumis_charge_etude = true;
                $projetetude->date_trans_charg_etude = $date_soumission;
                $projetetude->commentaires_cs = $data['commentaires_chef_service'];
                // Atribution au chef de departement
                // Recuperation de l'id
                //dd(($data));
                $user_id = intval($data['id_charge_etude']);
                $projetetude->id_charge_etude = $user_id;
                $projetetude->save();
                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Projet attribué au charge d\'etude avec succes');
            }

            // Traitement de la soumission du Chef de Departement
            if($data['action'] === 'soumission_plan_etude_cd'){
                // ID du plan
                $date_soumission = Carbon::now();
                $projetetude = ProjetEtude::find($id);
                $projetetude->flag_soumis_chef_service = true;
                $projetetude->date_trans_chef_s = $date_soumission;
                $projetetude->commentaires_cd = $data['commentaires_chef_dep'];
                // Atribution au chef de departement
                $user_id = intval($data['id_chef_service']);
                $projetetude->id_chef_serv = $user_id;
                $projetetude->save();
                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Projet attribué au chef de service');
            }
            // Traitement de la soumission
            if($data['action'] === 'soumission_plan_formation'){
                // ID du plan
                $date_soumission = Carbon::now();
                $projetetude = ProjetEtude::find($id);
                $projetetude->flag_soumis = true;
                $projetetude->date_soumis = $date_soumission;
                $num_direction = Auth::user()->id_direction;
                // Atribution au chef de departement
                // Recuperation de l'ID du chef de departement
                $num_agce = Auth::user()->num_agce;
                //dd($num_agce);
                $chefdepartement = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('users.name', 'users.prenom_users', 'users.id')
                ->where([['roles.id','=',21],['users.num_agce','=',$num_agce]/*,['users.num_direction','=',$num_direction]*/])
                ->get();
                //dd(intval($chefdepartement[0]->id));
                $projetetude->id_user_affecte = intval($chefdepartement[0]->id);
                // Recuperation de l'id Traitement a faire
                $user_id = Auth::user()->id;
                $projetetude->id_chef_dep = intval($chefdepartement[0]->id);
                $projetetude->save();
                return redirect()->route('projetetude.index')->with('success', 'Projet soumis avec succès.');

            }

            // Traitement de la modification
            if($data['action'] === 'modifier_plan_formation'){
                // ID du plan
                // Modification du fichier l'avant TDR
                if (isset($data['avant_projet_tdr_modif'])){

                    $filefront = $data['avant_projet_tdr_modif'];

                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                        $fileName1 = 'avant_projet_tdr'. '_' . rand(111,99999) . '_' . 'avant_projet_tdr' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces_projet/avant_projet_tdr/'), $fileName1);
                        $pieceprojetetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','1']])->get();
                        $id_piece = $pieceprojetetude[0]['id_pieces_projet_etude'];
                        $piece= PiecesProjetEtude::find($id_piece);
                        $piece->libelle_pieces = $fileName1;
                        $piece->save();
                        //$input['avant_projet_tdr'] = $fileName1;

                    }else{
                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('error', 'l\extension du fichier de l\'avant-projet TDR n\'est pas correcte');
                        //->with('error', 'l\extension du fichier de l\'avant-projet TDR n\'est pas correcte');
                    }

                }

                 // Modification du  Courrier de demande de financement
                 if (isset($data['courier_demande_fin_modif'])){

                    $filefront = $data['courier_demande_fin_modif'];

                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                        $fileName1 = 'courier_demande_fin'. '_' . rand(111,99999) . '_' . 'courier_demande_fin' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces_projet/courier_demande_fin/'), $fileName1);
                        $pieceprojetetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','2']])->get();
                        $id_piece = $pieceprojetetude[0]['id_pieces_projet_etude'];
                        $piece= PiecesProjetEtude::find($id_piece);
                        $piece->libelle_pieces = $fileName1;
                        $piece->save();
                        //$input['avant_projet_tdr'] = $fileName1;

                    }else{
                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')
                        ->with('error', 'l\extension du fichier du courrier de demande de financement n\'est pas correcte');
                    }

                }

                // Modification du dossier intention
                if (isset($data['dossier_intention_modif'])){

                    $filefront = $data['dossier_intention_modif'];

                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                        $fileName1 = 'dossier_intention'. '_' . rand(111,99999) . '_' . 'dossier_intention' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces_projet/dossier_intention/'), $fileName1);
                        $pieceprojetetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','3']])->get();
                        $id_piece = $pieceprojetetude[0]['id_pieces_projet_etude'];
                        $piece= PiecesProjetEtude::find($id_piece);
                        $piece->libelle_pieces = $fileName1;
                        $piece->save();
                        //$input['avant_projet_tdr'] = $fileName1;

                    }else{
                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')
                        ->with('error', 'l\extension du fichier du dossier intention n\'est pas correcte');
                    }

                }


                // Modification de la lettre d'engagement
                if (isset($data['lettre_engagement_modif'])){

                    $filefront = $data['lettre_engagement_modif'];

                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                        $fileName1 = 'lettre_engagement'. '_' . rand(111,99999) . '_' . 'lettre_engagement' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces_projet/lettre_engagement/'), $fileName1);
                        $pieceprojetetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','4']])->get();
                        $id_piece = $pieceprojetetude[0]['id_pieces_projet_etude'];
                        $piece= PiecesProjetEtude::find($id_piece);
                        $piece->libelle_pieces = $fileName1;
                        $piece->save();
                        //$input['avant_projet_tdr'] = $fileName1;

                    }else{
                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')
                        ->with('error', 'l\extension du fichier de la lettre d\'engagement n\'est pas correcte');
                    }

                }

                 // Modification de l'offre technique'
                 if (isset($data['offre_technique_modif'])){

                    $filefront = $data['offre_technique_modif'];

                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                        $fileName1 = 'offre_technique'. '_' . rand(111,99999) . '_' . 'offre_technique' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces_projet/offre_technique/'), $fileName1);
                        $pieceprojetetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','5']])->get();
                        $id_piece = $pieceprojetetude[0]['id_pieces_projet_etude'];
                        $piece= PiecesProjetEtude::find($id_piece);
                        $piece->libelle_pieces = $fileName1;
                        $piece->save();
                        //$input['avant_projet_tdr'] = $fileName1;

                    }else{
                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')
                        ->with('error', 'l\extension du fichier de l\'offre technique n\'est pas correcte');
                    }

                }

                // Modification de l'offre finnaciere'
                if (isset($data['offre_financiere_modif'])){

                    $filefront = $data['offre_financiere_modif'];

                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                        $fileName1 = 'offre_financiere'. '_' . rand(111,99999) . '_' . 'offre_financiere' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces_projet/offre_financiere/'), $fileName1);
                        $pieceprojetetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','6']])->get();
                        $id_piece = $pieceprojetetude[0]['id_pieces_projet_etude'];
                        $piece= PiecesProjetEtude::find($id_piece);
                        $piece->libelle_pieces = $fileName1;
                        $piece->save();
                        //$input['avant_projet_tdr'] = $fileName1;

                    }else{
                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')
                        ->with('error', 'l\extension du fichier de l\'offre technique n\'est pas correcte');
                    }

                }

                $projetetude = ProjetEtude::find($id);
                $projetetude->titre_projet_etude = $data['titre_projet'];
                $projetetude->contexte_probleme_projet_etude = $data['contexte_probleme'];
                $projetetude->objectif_general_projet_etude = $data['objectif_general'];
                $projetetude->objectif_specifique_projet_etud = $data['objectif_specifique'];
                $projetetude->resultat_attendu_projet_etude = $data['resultat_attendu'];
                $projetetude->champ_etude_projet_etude = $data['champ_etude'];
                $projetetude->cible_projet_etude = $data['cible'];
                $projetetude->save();
                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Votre projet d\'etude a été modifié avec succes ');

                //return redirect()->route('projetetude.index')->with('success', 'Projet modifié avec succès.');


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
