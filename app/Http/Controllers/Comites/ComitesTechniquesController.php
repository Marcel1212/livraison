<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
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
use App\Models\CahierComite;
use App\Models\CategorieComite;
use App\Models\Comite;
use App\Models\ComiteParticipant;
use App\Models\Direction;
use App\Models\ProcessusComite;
use App\Models\ProcessusComiteLieComite;
use App\Models\User;
use App\Helpers\Menu;
use App\Models\PlanFormation;
use App\Models\ProjetEtude;
use App\Models\ProjetFormation;

class ComitesTechniquesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comites = Comite::Join('categorie_comite','comite.id_categorie_comite','categorie_comite.id_categorie_comite')
                        ->join('processus_comite_lie_comite','comite.id_comite','processus_comite_lie_comite.id_comite')
                        ->join('processus_comite','processus_comite_lie_comite.id_processus_comite','processus_comite.id_processus_comite')
                        ->where('categorie_comite.code_categorie_comite','CT')
                        ->get();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES TECHNIQUES'

        ]);
        return view('comites.comitetechniques.index', compact('comites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $typecomites = CategorieComite::where([['flag_actif_categorie_comite','=',true],['code_categorie_comite','=','CT']])->orderBy('libelle_categorie_comite')->get();
        $typecomitesListe = "<option value=''> Selectionnez le type de comité </option>";
        foreach ($typecomites as $comp) {
            $typecomitesListe .= "<option value='" . $comp->id_categorie_comite. "'>" . mb_strtoupper($comp->libelle_categorie_comite) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
        $processuscomitesListe = "<option value=''> Selectionnez le/les processus </option>";
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

        $directions = Direction::where([['flag_direction','=',true]])->get();

        //dd($typecomitesListe);
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES TECHNIQUES'

        ]);
        return view('comites.comitetechniques.create', compact('typecomitesListe','processuscomitesListe','directions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'id_categorie_comite' => 'required',
                'id_processus_comite' => 'required',
                'date_debut_comite' => 'required|date|after_or_equal:now',
                'commentaire_comite' => 'required',
                'id_direction' => 'required',
                'id_departement' => 'required'
            ],[
                'id_categorie_comite.required' => 'Veuillez selectionne le comite.',
                'id_processus_comite.after_or_equal' => 'Veuillez selection le/les processus.',
                'date_debut_comite.required' => 'Veuillez ajouter une date de debut.',
                'date_debut_comite.after_or_equal' => 'La date ne doit pas être inférieure à celle du jour.',
                'commentaire_comite.required' => 'Veuillez ajouter un commentaire.',
                'id_direction.required' => 'Veuillez sélectionner la direction.',
                'id_departement.required' => 'Veuillez sélectionner le département.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite'] = Auth::user()->id;
            $infostypecomite = CategorieComite::find($input['id_categorie_comite']);
            $input['code_comite'] = $infostypecomite->code_categorie_comite.'-'. Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;

            $comite = Comite::create($input);

            $infosprocessus = ProcessusComite::find($input['id_processus_comite']);

            $processus = ProcessusComiteLieComite::create([
                'id_comite' => $comite->id_comite,
                'id_processus_comite' => $infosprocessus->id_processus_comite,
                'code_pieces' => $infosprocessus->code_processus_comite,
            ]);

            $insertedId = $comite->id_comite;

            Audit::logSave([

                'action'=>'CREATION',

                'code_piece'=>$insertedId,

                'menu'=>'COMITES',

                'etat'=>'Succès',

                'objet'=>'COMITES TECHNIQUES'

            ]);

            return redirect('comitetechniques/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');

        }
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
    public function edit($id,$id1)
    {

        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comite = Comite::find($id);
        //dd($comite);

        $directionselection = Direction::where('id_direction',$comite->departement->id_direction)->first();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        //dd($processuscomite->processusComite());

        $demandes = DB::table('vue_plans_projets_formation')->whereNotExists(function ($query) use ($id){
            $query->select('*')
            ->from('cahier_comite')
            ->whereColumn('cahier_comite.id_demande','=','vue_plans_projets_formation.id_demande')
            ->where('cahier_comite.id_comite',$id);
             })->join('caracteristique_marge_departement','vue_plans_projets_formation.departement','caracteristique_marge_departement.id_departement')
             ->where([
             ['caracteristique_marge_departement.flag_cmd','=',true],
             ['vue_plans_projets_formation.code_processus','=',$processuscomite->processusComite->code_processus_comite],
             ['vue_plans_projets_formation.departement','=', $comite->id_departement],
             ])
            // ->where('caracteristique_marge_departement.flag_cmd',true)
            // ->where('vue_plans_projets_formation.departement', Auth::user()->id_departement)
             //->Where('vue_plans_projets_formation.code_processus',$processuscomite->processusComite->code_processus_comite)
             ->get();

        //$querydemande->orWhere('vue_plans_projets_formation.code_processus',$processuscomite->processusComite->code_processus_comite);

        //$demandes = $querydemande;

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        //dd($cahiers);

        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
                                                ->join('users','comite_participant.id_user_comite_participant','users.id')
                                                ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                                                ->join('roles', 'model_has_roles.role_id', 'roles.id')
                                                ->where([['id_comite','=',$id]])
                                                ->get();
         //ComiteParticipant::where([['id_comite','=',$id]])->get();

        $personneressources = 	User::select('users.id as id','users.name as name','users.prenom_users as prenom_users', 'roles.name as profile')
                                ->whereNotExists(function ($query) use ($id){
                                    $query->select('*')
                                        ->from('comite_participant')
                                        ->whereColumn('comite_participant.id_user_comite_participant','=','users.id')
                                        ->where('comite_participant.id_comite','=',$id);
                                })->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                                ->join('roles', 'model_has_roles.role_id', 'roles.id')
                                ->where([['flag_demission_users', '=', false],
                                    ['flag_admin_users', '=', false],
                                    ['roles.id', '!=', 15],
                                ])->get();
            /*User::with('agence:num_agce,lib_agce')
                            ->select('users.id as id','users.name as name','users.prenom_users as prenom_users', 'roles.name as profile')
                            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', 'roles.id')
                            ->where([['flag_demission_users', '=', false],
                                    ['flag_admin_users', '=', false],
                                    ['roles.id', '!=', 15]])
                            ->get();*/

                            //dd($personneressources);
        $personneressource = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($personneressources as $comp) {
            $personneressource .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) . ' ( '.mb_strtoupper($comp->profile).' ) '." </option>";
        }


        $directions = Direction::where([['flag_direction','=',true]])->get();

        $typecomites = CategorieComite::where([['flag_actif_categorie_comite','=',true],['code_categorie_comite','=','CT']])->orderBy('libelle_categorie_comite')->get();
        $typecomitesListe = "<option value='".$comite->categorieComite->id_categorie_comite."'> ".$comite->categorieComite->libelle_categorie_comite." </option>";
        foreach ($typecomites as $comp) {
            $typecomitesListe .= "<option value='" . $comp->id_categorie_comite. "'>" . mb_strtoupper($comp->libelle_categorie_comite) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
        $processuscomitesListe = "<option value='".$processuscomite->processusComite->id_processus_comite."'> ".$processuscomite->processusComite->libelle_processus_comite." </option>";
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

        $listedemandesss = DB::table('vue_plans_projets_formation_traiter as vue_plans_projets_formation')
                            ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
                            ->where([['cahier_comite.id_comite','=',$id],
                                    ['vue_plans_projets_formation.code_processus','=',$processuscomite->processusComite->code_processus_comite]])
                            ->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES TECHNIQUES'

        ]);

        return view('comites.comitetechniques.edit', compact('comite','idetape','id','processuscomite','demandes','cahiers','directions','directionselection','processuscomitesListe','typecomitesListe','comiteparticipants','personneressource','listedemandesss'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comitep = Comite::find($id);
        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'id_categorie_comite' => 'required',
                    'id_processus_comite' => 'required',
                    'date_debut_comite' => 'required|date|after_or_equal:now',
                    'commentaire_comite' => 'required',
                    'id_direction' => 'required',
                    'id_departement' => 'required'
                ],[
                    'id_categorie_comite.required' => 'Veuillez selectionne le comite.',
                    'id_processus_comite.after_or_equal' => 'Veuillez selection le/les processus.',
                    'date_debut_comite.required' => 'Veuillez ajouter une date de debut.',
                    'date_debut_comite.after_or_equal' => 'La date ne doit pas être inférieure à celle du jour.',
                    'commentaire_comite.required' => 'Veuillez ajouter un commentaire.',
                    'id_direction.required' => 'Veuillez sélectionner la direction.',
                    'id_departement.required' => 'Veuillez sélectionner le département.',
                ]);

                $input = $request->all();

                $comite = Comite::find($id);

                $procesuslie = ProcessusComiteLieComite::where('id_comite',$id)->first();

                $processusliecomite = ProcessusComiteLieComite::find($procesuslie->id_processus_comite_lie_comite);
                $comite->update($input);
                $processusliecomite->update($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'COMITES',

                    'etat'=>'Succès',

                    'objet'=>'COMITES TECHNIQUES'

                ]);

                return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succés : Information mise à jour  ');

            }

            if ($data['action'] == 'creer_cahier_plans_projets'){

                $input = $request->all();

                if(isset($input['demande'])){

                    $verifnombre = count($input['demande']);

                    //dd($verifnombre);exit;

                    if($verifnombre < 1){

                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'COMITES (Cahier du '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins un plan/projet pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',

                            'etat'=>'Echec',

                            'objet'=>'COMITES TECHNIQUES'

                            ]);

                            return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un plan/projet pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'. ');

                    }

                    $tab = $input['demande'];

                    foreach ($tab as $key => $value) {

                        //dd($value); exit;
                        $recuperationvaleur = explode('/',$value);
                        //dd($recuperationvaleur); exit;
                        $iddemande = $recuperationvaleur[0];
                        $codeprocessus = $recuperationvaleur[1];

                        //dd($iddemande); exit;
                        //dd($codeprocessus); exit;
                        CahierComite::create([
                            'id_comite'=> $id,
                            'id_demande'=> $iddemande,
                            'flag_cahier'=>true,
                            'code_demande'=>$codeprocessus
                        ]);

                        if($codeprocessus =='PF'){

                            $plan = PlanFormation::find($iddemande);
                            $plan->update([
                                'flag_passer_comite_technique' => true
                            ]);

                        }

                        if($codeprocessus =='PE'){

                            $projet_etude = ProjetEtude::find($iddemande);
                            $projet_etude->flag_passer_comite_technique = true;
                            $projet_etude->update();

                        }

                        if($codeprocessus =='PRF'){

                            // Recuperation du Projet de formation
                            $projetformation = ProjetFormation::find($iddemande);
                            $projetformation->flag_passer_comite_technique = true;
                            $projetformation->update();

                        }


                    }

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' pour le '.@$processuscomite->processusComite->libelle_processus_comite.' )',

                        'etat'=>'Succès',

                        'objet'=>'COMITES TECHNIQUES'

                        ]);

                        return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succés : Information mise à jour  ');

                }else{

                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins un plan/projet pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',

                            'etat'=>'Echec',

                            'objet'=>'COMITES TECHNIQUES'

                            ]);

                        return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un plan/projet pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'. ');



                }


            }

            if ($data['action'] == 'Enregistrer_persone_ressource_pour_comite'){

                $this->validate($request, [
                    'id_user_comite_participant' => 'required'
                ],[
                    'id_user_comite_participant.required' => 'Veuillez selectionnez le/les personne(s) ressource(s).'
                ]);

                $input = $request->all();
                //$input['id_comite'] = $id;
                //$input['flag_comite_participant'] = true;

                if(isset($input['id_user_comite_participant'])){

                    $verifnombre = count($input['id_user_comite_participant']);

                    if($verifnombre < 1){

                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'COMITES (Cahier du '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins une personne le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',

                            'etat'=>'Echec',

                            'objet'=>'COMITES TECHNIQUES'

                            ]);

                            return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins une personne pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.');

                    }

                    $tab = $input['id_user_comite_participant'];

                    foreach ($tab as $key => $value) {

                        //dd($value); exit;
                        ComiteParticipant::create([
                            'id_comite'=> $id,
                            'id_user_comite_participant'=> $value,
                            'flag_comite_participant'=>true
                        ]);
                    }

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' )',

                        'etat'=>'Succès',

                        'objet'=>'COMITES TECHNIQUES'

                        ]);

                    return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succés : Information mise à jour  ');

                }else{

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins une personne pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',

                        'etat'=>'Echec',

                        'objet'=>'COMITES TECHNIQUES'
                        ]);

                    return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins une personne pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.');


                }

            }

            if ($data['action'] == 'Invitation_personne_ressouce'){

                $listepersonnes = ComiteParticipant::where([['id_comite','=',$id]])->get();
                //dd($listepersonnes);
                if(count($listepersonnes)<1){
                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous ne pouvez pas envoyer les invitations car il n\' y a pas de personne ressousce pour  CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',

                        'etat'=>'Echec',

                        'objet'=>'COMITES TECHNIQUES'

                        ]);

                    return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous ne pouvez pas envoyer les invitations car il n\' y a pas de personne ressousce pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.');

                }else{

                    $listedemandesss = DB::table('vue_plans_projets_formation_traiter as vue_plans_projets_formation')
                    ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
                    ->where([['cahier_comite.id_comite','=',$id]])
                    ->get();

//                    $affichedemande = [];
//
//                    foreach ($listedemandesss as $listedemandess) {
//                       $affichedemande = '<strong>Code</strong>:'.$listedemandess->code.';  <strong>raison sociale</strong>:'.$listedemandess->raison_sociale.'; <strong>cout accordée</strong>:'.number_format($listedemandess->montant_total, 0, ',', ' ').'.';
//                    }

                    foreach($listepersonnes as $personne){


                       // dd("".route('traitementcomitetechniques.edit',['id'=>Crypt::UrlCrypt($id),'id1'=>Crypt::UrlCrypt(1)]));
                        $logo = Menu::get_logo();

                        $email = $personne->user->email;
                        $nom = $personne->user->name;
                        $prenom = $personne->user->prenom_users;

                        if(isset($comitep->date_fin_comite)){
                            $datefin = 'jusqu\'au '. $comitep->date_fin_comite;
                        }else{
                            $datefin = ' ';
                        }

                        if (isset($email)) {
                            $nom_prenom = $nom .' '. $prenom;
                            $sujet = "Tenue de ".$comitep->categorieComite->libelle_categorie_comite."";
                            $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                            $messageMail = "<b>Cher(e) $nom_prenom  ,</b>
                                            <br><br>Vous êtes conviés au comité technique  qui se déroulera  à partir du ".$comitep->date_debut_comite." ".$datefin. ".
                                            <br><br> Vous êtes priés de bien vouloir prendre connaissance des documents suivants <a href=\"".route('traitementcomitetechniques.edit',['id'=>Crypt::UrlCrypt($id),'id1'=>Crypt::UrlCrypt(1)])."\">Cliquez ici</a>"
                                ."<br><br><br>
                                            -----
                                            Ceci est un mail automatique, Merci de ne pas y répondre.
                                            -----
                                            ";

                            $messageMailEnvoi = Email::get_envoimailTemplate($email, $nom_prenom, $messageMail, $sujet, $titre);
                        }

                    }

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' envoi des invitations )',

                        'etat'=>'Succès',

                        'objet'=>'COMITES TECHNIQUES'

                        ]);


                    return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succés : Information mise à jour  ');


                }

                //return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'valider_comite_technique'){

                $listedemandesss = DB::table('vue_plans_projets_formation_traiter')
                ->join('cahier_comite','vue_plans_projets_formation_traiter.id_demande','cahier_comite.id_demande')
                ->where([['cahier_comite.id_comite','=',$id]])
                ->get();

                foreach ($listedemandesss as $demande) {

                    if($demande->code_processus =='PF'){

                        $plan = PlanFormation::find($demande->id_demande);
                        $plan->update([
                            'id_processus' => 1,
                            'flag_valide_action_des_plan_formation' => true,
                            'flag_plan_formation_valider_par_comite_pleniere' => true
                        ]);

                    }

                    if($demande->code_processus =='PE'){

                        $projet_etude = ProjetEtude::find($demande->id_demande);
                        $projet_etude->flag_valider_ct_pleniere_projet_etude = true;
                        $projet_etude->date_valider_ct_pleniere_projet_etude = now();
                        $projet_etude->id_processus = 8;
                        $projet_etude->update();

                    }

                    if($demande->code_demande =='PRF'){

                        // Recuperation du Projet de formation
                        $projetformation = ProjetFormation::find($demande->id_demande);
                        //dd($data);
                        // Modification du projet de formation -- flag et ajout du code
                        $projetformation->flag_comite_pleiniere = true;
                        $projetformation->code_comite_pleiniere = $comitep->code_comite ;
                        $projetformation->id_processus = 10 ; // Processus 10
                        $projetformation->id_comite_pleiniere = $id ;
                        $projetformation->update();

                    }

                }

                $majcomite = $comitep->update([
                    'flag_statut_comite' => true,
                    'date_fin_comite' => Carbon::now()
                ]);


                return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succés : Information mise à jour  ');

            }

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

    }

        /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $id =  Crypt::UrldeCrypt($id);

        $comitepartipante = ComiteParticipant::find($id);

        $comite = $comitepartipante->id_comite;

        ComiteParticipant::where([['id_comite_participant','=',$id]])->delete();

        Audit::logSave([

            'action'=>'SUPPRIMER',

            'code_piece'=>$comitepartipante->id_comite_participant,

            'menu'=>'COMITES (Suppression des personne ressources a un comité)',

            'etat'=>'Succès',

            'objet'=>'COMITES TECHNIQUES'

        ]);

        return redirect('comitetechniques/'.Crypt::UrlCrypt($comite).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


    }
}
