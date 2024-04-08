<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
use App\Models\Comite;
use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\ProcessusComite;
use App\Models\TypeComite;
use App\Helpers\Menu;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\ConseillerParAgence;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Helpers\Crypt;
use App\Helpers\DemandePlanProjets;
use App\Models\CahierComite;
use App\Models\CahierPlansProjets;
use App\Models\CategorieComite;
use App\Models\ComiteParticipant;
use App\Models\FicheAgrement;
use App\Models\PlanFormation;
use App\Models\ProcessusComiteLieComite;
use App\Models\ProjetEtude;
use App\Models\ProjetFormation;
use Carbon\Carbon;
use App\Models\User;

class ComitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comites = Comite::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES'

        ]);
        return view('comites.comite.index', compact('comites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $typecomites = CategorieComite::where([['flag_actif_categorie_comite','=',true],['code_categorie_comite','=','CP']])->orderBy('libelle_categorie_comite')->get();
        $typecomitesListe = "<option value=''> Selectionnez le type de comité </option>";
        foreach ($typecomites as $comp) {
            $typecomitesListe .= "<option value='" . $comp->id_categorie_comite. "'>" . mb_strtoupper($comp->libelle_categorie_comite) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
        $processuscomitesListe = "<option value=''> Selectionnez le/les processus </option>";
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

        //dd($typecomitesListe);
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES'

        ]);
        return view('comites.comite.create', compact('typecomitesListe','processuscomitesListe','processuscomitesListe'));
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
                'commentaire_comite' => 'required'
            ],[
                'id_categorie_comite.required' => 'Veuillez selectionne le comite.',
                'id_processus_comite.after_or_equal' => 'Veuillez selection le/les processus.',
                'date_debut_comite.required' => 'Veuillez ajouter une date de debut.',
                'date_debut_comite.after_or_equal' => 'La date ne doit pas être inférieure à celle du jour.',
                'commentaire_comite.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite'] = Auth::user()->id;
            $infostypecomite = CategorieComite::find($input['id_categorie_comite']);
            $input['code_comite'] = $infostypecomite->code_categorie_comite.'-'. Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;

            //dd($input);

            $comite = Comite::create($input);

            foreach($request->input('id_processus_comite') as $processus){

                $infosprocessus = ProcessusComite::find($processus);

                $processuscomite = ProcessusComiteLieComite::create([
                    'id_comite' => $comite->id_comite,
                    'id_processus_comite' => $processus,
                    'code_pieces' => $infosprocessus->code_processus_comite,
                ]);

            }

            $insertedId = $comite->id_comite;

            Audit::logSave([

                'action'=>'CREATION',

                'code_piece'=>$insertedId,

                'menu'=>'COMITES',

                'etat'=>'Succès',

                'objet'=>'COMITES'

            ]);

            return redirect('comites/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');

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

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->get();

        //$demandes  = DemandePlanProjets::plans_projets_formations_etudes(Auth::user()->num_agce,$processuscomite);

        //dd($processuscomite);

        //$querydemande = CahierComite::whereNotExists(function ($query) use ($id){
        $querydemande = DB::table('cahier_plans_projets')->whereNotExists(function ($query) use ($id){
            $query->select('*')
            ->from('cahier_comite')
            ->whereColumn('cahier_comite.id_demande','=','cahier_plans_projets.id_cahier_plans_projets')
            ->where('cahier_comite.id_comite',$id);
             })
            ->where([
                ['cahier_plans_projets.code_commission_permante_comite_gestion','=', $comite->categorieComite->type_code_categorie_comite],
                ['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',false]
            ])
            ->where(function ($query) use ($processuscomite,$comite) {
                foreach ($processuscomite as  $cd) {
                    $query->orWhere('cahier_plans_projets.code_pieces_cahier_plans_projets',$cd->code_pieces);
                }
            })->get();

        $demandes = $querydemande->get();

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $typecomites = CategorieComite::where([['flag_actif_categorie_comite','=',true],['code_categorie_comite','=','CP']])->orderBy('libelle_categorie_comite')->get();
        $typecomitesListe = "<option value='".$comite->categorieComite->id_categorie_comite."'> ".$comite->categorieComite->libelle_categorie_comite." </option>";
        foreach ($typecomites as $comp) {
            $typecomitesListe .= "<option value='" . $comp->id_categorie_comite. "'>" . mb_strtoupper($comp->libelle_categorie_comite) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
       // foreach ($processuscomite as $processuscomitef) {
            $processuscomitesListe = "<option value=''>  </option>";
        //}
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

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

        $personneressource = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($personneressources as $comp) {
        $personneressource .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) . ' ( '.mb_strtoupper($comp->profile).' ) '." </option>";
        }



        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
                                                ->join('users','comite_participant.id_user_comite_participant','users.id')
                                                ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                                                ->join('roles', 'model_has_roles.role_id', 'roles.id')
                                                ->where([['id_comite','=',$id]])
                                                ->get();


        $listedemandesss = DB::table('cahier_plans_projets')
                                ->join('cahier_comite','cahier_plans_projets.id_cahier_plans_projets','cahier_comite.id_demande')
                                ->where([['cahier_comite.id_comite','=',$id],['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',true]])
                                ->get();


        return view('comites.comite.edit', compact('comite','idetape','id','processuscomite','demandes','cahiers',
                                                    'typecomitesListe','processuscomitesListe','listedemandesss',
                                                    'comiteparticipants','personneressource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comitep = Comite::find($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'id_categorie_comite' => 'required',
                    'id_processus_comite' => 'required',
                    'date_debut_comite' => 'required|date|after_or_equal:now',
                    'commentaire_comite' => 'required'
                ],[
                    'id_categorie_comite.required' => 'Veuillez selectionne le comite.',
                    'id_processus_comite.after_or_equal' => 'Veuillez selection le/les processus.',
                    'date_debut_comite.required' => 'Veuillez ajouter une date de debut.',
                    'date_debut_comite.after_or_equal' => 'La date ne doit pas être inférieure à celle du jour.',
                    'commentaire_comite.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $dateanneeencours = Carbon::now()->format('Y');
                $input['id_user_comite'] = Auth::user()->id;
                $infostypecomite = CategorieComite::find($input['id_categorie_comite']);
                $input['code_comite'] = $infostypecomite->code_categorie_comite.'-'. Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;


                //dd($input);

                $comite = Comite::find($id);
                $comite->update($input);

                $processuscomites = ProcessusComiteLieComite::where([['id_comite','=',$id]])->get();

                foreach ($processuscomites as $processuscomite) {
                    ProcessusComiteLieComite::where([['id_processus_comite_lie_comite','=',$processuscomite->id_processus_comite_lie_comite]])->delete();
                }

                foreach($request->input('id_processus_comite') as $processus){

                    $infosprocessus = ProcessusComite::find($processus);

                    $processuscomite = ProcessusComiteLieComite::create([
                        'id_comite' => $comite->id_comite,
                        'id_processus_comite' => $processus,
                        'code_pieces' => $infosprocessus->code_processus_comite,
                    ]);

                }
                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'COMITES',

                    'etat'=>'Succès',

                    'objet'=>'COMITES'

                ]);

                return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

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

                            'menu'=>'COMITES (Cahier du '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins un cahier.)',

                            'etat'=>'Echec',

                            'objet'=>'COMITES'

                            ]);

                            return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un cahier. ');

                    }

                    $tab = $input['demande'];

                    foreach ($tab as $key => $value) {

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

                        $cahiermaj = CahierPlansProjets::find($iddemande);
                        $cahiermaj->update([
                            'flag_traitement_cahier_plans_projets' => true,
                            'date_traitement_cahier_plans_projets' => Carbon::now()
                        ]);

                    }

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' )',

                        'etat'=>'Succès',

                        'objet'=>'COMITES'

                        ]);

                        return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

                }else{

                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins un cahier.)',

                            'etat'=>'Echec',

                            'objet'=>'COMITES'

                            ]);

                        return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un cahier. ');



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

                            'objet'=>'COMITES '

                            ]);

                            return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins une personne pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.');

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

                        'objet'=>'COMITES '

                        ]);

                    return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

                }else{

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins une personne pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',

                        'etat'=>'Echec',

                        'objet'=>'COMITES '
                        ]);

                    return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins une personne pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.');


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

                        'objet'=>'COMITES '

                        ]);

                    return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous ne pouvez pas envoyer les invitations car il n\' y a pas de personne ressousce pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.');

                }else{



                    foreach($listepersonnes as $personne){

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
                                            <br><br>Vous êtes conviés au ".$comitep->categorieComite->libelle_categorie_comite."  qui se déroulera  à partir du ".$comitep->date_debut_comite." ".$datefin. ".
                                            <br><br> Vous êtes priés de bien vouloir prendre connaissance des documents suivants <a href=\"".route('traitementcomite.edit',['id'=>Crypt::UrlCrypt($id),'id1'=>Crypt::UrlCrypt(1)])."\">Cliquez ici</a>"
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

                        'objet'=>'COMITES '

                        ]);

                    return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

                }

                //return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'valider_comite_technique'){

                $listedemandesss = DB::table('cahier_plans_projets')
                ->join('cahier_comite','cahier_plans_projets.id_cahier_plans_projets','cahier_comite.id_demande')
                ->where([['cahier_comite.id_comite','=',$id],['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',true]])
                ->get();

                foreach ($listedemandesss as $demande) {

                    $infoscahiers = CahierPlansProjets::Join('ligne_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets','ligne_cahier_plans_projets.id_cahier_plans_projets')->where([['cahier_plans_projets.id_cahier_plans_projets','=',$demande->id_cahier_plans_projets]])->get();

                    foreach ($infoscahiers as $infoscahier) {

                        if($infoscahier->code_pieces_ligne_cahier_plans_projets =='PF'){

                            $plan = PlanFormation::find($infoscahier->id_demande);
                            FicheAgrement::create([
                                'id_demande' => $plan->id_plan_de_formation,
                                'id_comite_permanente' => $id,
                                'id_user_fiche_agrement' => Auth::user()->id,
                                'flag_fiche_agrement'=> true,
                                'code_fiche_agrement'=> $infoscahier->code_pieces_ligne_cahier_plans_projets
                            ]);


                            $plan->update([
                                'flag_fiche_agrement' => true,
                                'date_fiche_agrement' => Carbon::now()
                            ]);

                        }

                        if($infoscahier->code_pieces_ligne_cahier_plans_projets =='PE'){

                            $projet_etude = ProjetEtude::find($infoscahier->id_demande);

                            if($infoscahier->code_commission_permante_comite_gestion == 'COP'){
                                FicheAgrement::create([
                                    'id_demande' => $projet_etude->id_projet_etude,
                                    'id_comite_permanente' => $id,
                                    'id_user_fiche_agrement' => Auth::user()->id,
                                    'flag_fiche_agrement'=> true,
                                    'code_fiche_agrement'=> $infoscahier->code_pieces_ligne_cahier_plans_projets
                                ]);
                            }

                            if($infoscahier->code_commission_permante_comite_gestion == 'COG'){
                                FicheAgrement::create([
                                    'id_demande' => $projet_etude->id_projet_etude,
                                    'id_comite_gestion' => $id,
                                    'id_user_fiche_agrement' => Auth::user()->id,
                                    'flag_fiche_agrement'=> true,
                                    'code_fiche_agrement'=> $infoscahier->code_pieces_ligne_cahier_plans_projets
                                ]);
                            }



                            $projet_etude->flag_fiche_agrement = true;
                            $projet_etude->date_fiche_agrement = now();
                            $projet_etude->update();

                        }

                        if($infoscahier->code_pieces_ligne_cahier_plans_projets =='PRF'){

                            // Recuperation du Projet de formation
                            $projetformation = ProjetFormation::find($infoscahier->id_demande);


                            if($infoscahier->code_commission_permante_comite_gestion == 'COP'){
                                FicheAgrement::create([
                                    'id_demande' => $projetformation->id_projet_formation,
                                    'id_comite_permanente' => $id,
                                    'id_user_fiche_agrement' => Auth::user()->id,
                                    'flag_fiche_agrement'=> true,
                                    'code_fiche_agrement'=> $infoscahier->code_pieces_ligne_cahier_plans_projets
                                ]);
                            }

                            if($infoscahier->code_commission_permante_comite_gestion == 'COG'){
                                FicheAgrement::create([
                                    'id_demande' => $projetformation->id_projet_formation,
                                    'id_comite_gestion' => $id,
                                    'id_user_fiche_agrement' => Auth::user()->id,
                                    'flag_fiche_agrement'=> true,
                                    'code_fiche_agrement'=> $infoscahier->code_pieces_ligne_cahier_plans_projets
                                ]);
                            }

                            // Modification du projet de formation -- flag et ajout du code
                            $projetformation->flag_comite_pleiniere = true;
                            $projetformation->code_comite_pleiniere = $comitep->code_comite ;
                            $projetformation->update();

                        }

                        $majcahierplanprojet = CahierPlansProjets::find($infoscahier->id_cahier_plans_projets);

                        $majcahierplanprojet->update([
                            'flag_traitement_valide_flag_cahier_plans_projets' => true,
                            'date_traitement_valide_flag_cahier_plans_projets' => Carbon::now()
                        ]);


                    }

                }

                $majcomite = $comitep->update([
                    'flag_statut_comite' => true,
                    'date_fin_comite' => Carbon::now()
                ]);


                return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }


        }
    }

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

            'objet'=>'COMITES '

        ]);

        return redirect('comites/'.Crypt::UrlCrypt($comite).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
