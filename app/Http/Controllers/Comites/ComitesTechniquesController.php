<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
use App\Models\DomaineFormation;
use App\Models\FormeJuridique;
use App\Models\PiecesProjetEtude;
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
use App\Helpers\InfosEntreprise;
use App\Models\CahierComite;
use App\Models\CategorieComite;
use App\Models\Comite;
use App\Models\ComiteParticipant;
use App\Models\Direction;
use App\Models\ProcessusComite;
use App\Models\ProcessusComiteLieComite;
use App\Models\User;
use App\Helpers\Menu;
use App\Models\ActionFormationPlan;
use App\Models\Banque;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\ComiteRejeter;
use App\Models\CritereEvaluation;
use App\Models\DemandeHabilitation;
use App\Models\DemandeIntervention;
use App\Models\DomaineDemandeHabilitation;
use App\Models\Entreprises;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\InterventionHorsCi;
use App\Models\Motif;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Pays;
use App\Models\PiecesDemandeHabilitation;
use App\Models\PlanFormation;
use App\Models\ProjetEtude;
use App\Models\ProjetFormation;
use App\Models\RapportsVisites;
use App\Models\SecteurActivite;
use App\Models\TraitementParCritere;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeDomaineDemandeHabilitationPublic;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use App\Models\TypeIntervention;
use App\Models\TypeMoyenPermanent;
use App\Models\TypeOrganisationFormation;
use App\Models\Visites;
use Hamcrest\Arrays\IsArray;

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
                        ->where('comite.id_user_comite',Auth::user()->id)
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

        $directions = Direction::where([['flag_direction','=',true],['id_direction','=',Auth::user()->id_direction]])->get();

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
            //dd($input);
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
        //dd($comite->id_categorie_comite);
        // Coordination ID = 2
        $idcategoriecomite = $comite->id_categorie_comite;

        $directionselection = Direction::where('id_direction',$comite->departement->id_direction)->first();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();
        //dd($processuscomite->processusComite->code_processus_comite);

        //dd($processuscomite->processusComite());
        if ($idcategoriecomite == 2){
            $demandes = DB::table('vue_plans_projets_formation_coordination')->whereNotExists(function ($query) use ($id){
                $query->select('*')
                ->from('cahier_comite')
                ->whereColumn('cahier_comite.id_demande','=','vue_plans_projets_formation_coordination.id_demande')
                ->where('cahier_comite.id_comite',$id);
                 })->join('caracteristique_marge_departement','vue_plans_projets_formation_coordination.departement','caracteristique_marge_departement.id_departement')
                 ->where([
                 ['caracteristique_marge_departement.flag_cmd','=',true],
                 ['vue_plans_projets_formation_coordination.code_processus','=',$processuscomite->processusComite->code_processus_comite],
                 ['vue_plans_projets_formation_coordination.departement','=', $comite->id_departement],
                 ])
                // ->where('caracteristique_marge_departement.flag_cmd',true)
                // ->where('vue_plans_projets_formation.departement', Auth::user()->id_departement)
                 //->Where('vue_plans_projets_formation.code_processus',$processuscomite->processusComite->code_processus_comite)
                 ->get();
        }else{
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
        }

        //dd($demandes);
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


        $directions = Direction::where([['flag_direction','=',true],['id_direction','=',Auth::user()->id_direction]])->get();

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

        if ($idcategoriecomite == 2){ // Coordination
            $listedemandesss = DB::table('vue_plans_projets_formation_coordination_traiter as vue_plans_projets_formation')
            ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
            ->where([['cahier_comite.id_comite','=',$id],
                    ['vue_plans_projets_formation.code_processus','=',$processuscomite->processusComite->code_processus_comite]])
            ->get();
        }else{
        $listedemandesss = DB::table('vue_plans_projets_formation_traiter as vue_plans_projets_formation')
                                    ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
                                    ->where([['cahier_comite.id_comite','=',$id],
                                            ['vue_plans_projets_formation.code_processus','=',$processuscomite->processusComite->code_processus_comite]])
                                    ->get();
        }


        //dd($listedemandesss);
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
        //dd($comitep);
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
                //dd($data);
                //dd($comitep->id_categorie_comite);
                $idcategoriecomite = $comitep->id_categorie_comite ; // 2 pour la coordination

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

                        if($codeprocessus =='HAB'){

                            $plan = DemandeHabilitation::find($iddemande);
                            $plan->update([
                                'flag_passer_comite_technique' => true,
                                'date_flag_passer_comite_technique' => Carbon::now()
                            ]);

                        }

                        if($codeprocessus =='PE'){

                            if(@$comitep->categorieComite->type_code_categorie_comite=='CT'){
                                $projet_etude = ProjetEtude::find($iddemande);
                                $projet_etude->flag_passer_comite_technique = true;
                                $projet_etude->update();
                            }

                            if(@$comitep->categorieComite->type_code_categorie_comite=='CC'){
                                if($codeprocessus =='PE'){
                                    $projet_etude = ProjetEtude::find($iddemande);
                                    $projet_etude->flag_passer_comite_technique_cc = true;
                                    $projet_etude->update();
                                }
                            }
                        }

                        if($codeprocessus =='PRF'){

                            // Recuperation du Projet de formation
                            //dd($idcategoriecomite);
                            $projetformation = ProjetFormation::find($iddemande);
                            if($idcategoriecomite == '2'){
                                $projetformation->flag_passer_comite_coordination = true;
                            }else{
                                $projetformation->flag_passer_comite_technique = true;
                            }

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

                    foreach($listepersonnes as $personne){
                        $logo = Menu::get_logo();

                        $email = $personne->user->email;
                        $nom = $personne->user->name;
                        $prenom = $personne->user->prenom_users;

                        if(isset($comitep->date_fin_comite)){
                            $datefin = 'jusqu\'au '. date('d/m/Y',strtotime(@$comitep->date_fin_comite));
                        }else{
                            $datefin = ' ';
                        }
                        if($comitep->categorieComite->type_code_categorie_comite=="CT"){
                            if (isset($email)) {
                                $nom_prenom = $nom .' '. $prenom;
                                $sujet = "Tenue de ".$comitep->categorieComite->libelle_categorie_comite."";
                                $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                $messageMail = "<b>Cher(e) $nom_prenom  ,</b>
                                            <br><br>Vous êtes convié au comité technique  qui se déroulera  à partir du ".date('d/m/Y',strtotime(@$comitep->date_debut_comite))." ".$datefin. ".
                                           Vous êtes prié de bien vouloir prendre connaissance des documents en cliquant sur le lien suivant : <br><br>
                                            <a class=\"o_text-white\" href=\"".route('traitementcomitetechniques.edit',['id'=>Crypt::UrlCrypt($id),'id1'=>Crypt::UrlCrypt(1)])."\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 7px 16px;mso-text-raise: 3px;
                                            font-family: Helvetica, Arial, sans-serif;font-weight: bold;width: 30%;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;mso-padding-alt: 7px 16px;background-color: #e07204;border-radius: 4px;\">Consulter les documents</a>"
                                    ."<br><br><br>
                                            -----
                                            Ceci est un mail automatique, Merci de ne pas y répondre.
                                            -----
                                            ";

                                $messageMailEnvoi = Email::get_envoimailTemplate($email, $nom_prenom, $messageMail, $sujet, $titre);
                            }
                        }

                        if($comitep->categorieComite->type_code_categorie_comite=="CC"){
                            if (isset($email)) {
                                $nom_prenom = $nom .' '. $prenom;
                                $sujet = "Tenue de ".$comitep->categorieComite->libelle_categorie_comite."";
                                $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                $messageMail = "<b>Cher(e) $nom_prenom  ,</b>
                                            <br><br>Vous êtes convié au comité de coordination  qui se déroulera  à partir du ".date('d/m/Y',strtotime(@$comitep->date_debut_comite))." ".$datefin. ".
                                           Vous êtes prié de bien vouloir prendre connaissance des documents en cliquant sur le lien suivant : <br><br>
                                            <a class=\"o_text-white\" href=\"".route('traitementcomitetechniques.edit',['id'=>Crypt::UrlCrypt($id),'id1'=>Crypt::UrlCrypt(1)])."\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 7px 16px;mso-text-raise: 3px;
                                            font-family: Helvetica, Arial, sans-serif;font-weight: bold;width: 30%;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;mso-padding-alt: 7px 16px;background-color: #e07204;border-radius: 4px;\">Consulter les documents</a>"
                                    ."<br><br><br>
                                            -----
                                            Ceci est un mail automatique, Merci de ne pas y répondre.
                                            -----
                                            ";
                                $messageMailEnvoi = Email::get_envoimailTemplate($email, $nom_prenom, $messageMail, $sujet, $titre);
                            }
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

                $input = $request->all();

                //dd($input);

                $idcategoriecomite = $comitep->id_categorie_comite ; // 2 pour la coordination

                if (isset($input['demandect'])) {

                    $verifnombre = count($input['demandect']);
                    if($verifnombre < 1){

                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'COMITES (Cahier du '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins un plan/projet afin de validé le comite  '.@$processuscomite->processusComite->libelle_processus_comite.'.)',

                            'etat'=>'Echec',

                            'objet'=>'COMITES TECHNIQUES'

                            ]);

                            return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un plan/projet pour validé le comité '.@$processuscomite->processusComite->libelle_processus_comite.'. ');

                    }

                    $tab = $input['demandect'];

                    // Récupération des demandes liées au comité
                    $listedemandesss = DB::table('vue_plans_projets_formation_traiter')
                        ->join('cahier_comite', 'vue_plans_projets_formation_traiter.id_demande', '=', 'cahier_comite.id_demande')
                        ->where('cahier_comite.id_comite', $id)
                        ->get()
                        ->pluck('id_demande')
                        ->toArray();
                   // dd($listedemandesss);
                    // Initialisation des deux listes
                    $elementsSelectionnes = [];
                    $elementsNonSelectionnes = [];

                    // Créer une liste associant les id_demande et code_processus depuis $tab
                    $demandesSelectionnees = array_map(function($value) {
                        $recuperationvaleur = explode('/', $value); // Extraire l'ID de la demande et le code_processus
                        return [
                            'id_demande' => $recuperationvaleur[0],
                            'code_processus' => $recuperationvaleur[1]
                        ];
                    }, $tab);

                    // Comparaison avec la liste des demandes récupérées
                    // foreach ($listedemandesss as $iddemande) {
                    //     if (in_array($iddemande, $demandesSelectionnees)) {
                    //         // Ajouter à la liste des éléments sélectionnés
                    //         $elementsSelectionnes[] = $iddemande;
                    //     } else {
                    //         // Ajouter à la liste des éléments non sélectionnés
                    //         $elementsNonSelectionnes[] = $iddemande;
                    //     }
                    // }

                    // Comparaison avec la liste des demandes récupérées
                    // foreach ($listedemandesss as $iddemande) {
                    //     if (in_array($iddemande, $demandesSelectionnees)) {
                    //         // Ajouter à la liste des éléments sélectionnés
                    //         $elementsSelectionnes[] = $iddemande;
                    //     } else {
                    //         // Ajouter à la liste des éléments non sélectionnés
                    //         $elementsNonSelectionnes[] = $iddemande;
                    //     }


                        // Vérification si la demande fait partie de la liste
                        // if (in_array($iddemande, $listedemandesss)) {

                        //     // Traitement pour le processus 'PF' (Plan de formation)
                        //     if ($codeprocessus === 'PF') {
                        //         $plan = PlanFormation::find($iddemande);
                        //         $plan->update([
                        //             'id_processus' => 1,
                        //             'flag_valide_action_des_plan_formation' => true,
                        //             'flag_valider_comite_technique' => true,
                        //             'flag_plan_formation_valider_par_comite_pleniere' => true,
                        //         ]);
                        //     }

                        //     if ($codeprocessus === 'HAB') {
                        //         $demh = DemandeHabilitation::find($iddemande);
                        //         $demh->update([
                        //             'id_processus' => 7,
                        //             'flag_valider_comite_technique' => true,
                        //             'date_flag_valider_comite_technique' => now(),
                        //         ]);
                        //     }

                        //     // Traitement pour le processus 'PE' (Projet d'étude)
                        //     if ($codeprocessus === 'PE') {
                        //         $projet_etude = ProjetEtude::find($iddemande);

                        //         if ($comitep->categorieComite->type_code_categorie_comite === 'CT') {
                        //             $projet_etude->flag_valider_ct_pleniere_projet_etude = true;
                        //             $projet_etude->date_valider_ct_pleniere_projet_etude = now();
                        //         } elseif ($comitep->categorieComite->type_code_categorie_comite === 'CC') {
                        //             $projet_etude->flag_valider_cc_projet_etude = true;
                        //             $projet_etude->date_valider_cc_projet_etude = now();
                        //         }

                        //         $projet_etude->update();
                        //     }

                        //     // Traitement pour le processus 'PRF' (Projet de formation)
                        //     if ($codeprocessus === 'PRF') {
                        //         $projetformation = ProjetFormation::find($iddemande);

                        //         if ($comitep->id_categorie_comite == 2) {
                        //             $projetformation->flag_valider_cc_projet_formation = true;
                        //         } else {
                        //             $projetformation->flag_comite_pleiniere = true;
                        //             $projetformation->code_comite_pleiniere = $comitep->code_comite;
                        //             $projetformation->id_processus = 10; // Processus 10
                        //             $projetformation->id_comite_pleiniere = $id;
                        //         }

                        //         $projetformation->update();
                        //     }

                        // } else {

                        //     // Cas où la demande n'est pas dans la liste
                        //     if ($codeprocessus === 'PF') {
                        //         $plan = PlanFormation::find($iddemande);
                        //         $plan->update([
                        //             'flag_soumis_ct_plan_formation' => false,
                        //             'flag_passer_comite_technique' => false,
                        //         ]);
                        //     }

                        //     if ($codeprocessus === 'HAB') {
                        //         $demh = DemandeHabilitation::find($iddemande);
                        //         $demh->update([
                        //             'flag_passer_comite_technique' => false,
                        //             'flag_soumis_comite_technique' => false,
                        //         ]);
                        //     }

                        //     if ($codeprocessus === 'PE') {
                        //         $projet_etude = ProjetEtude::find($iddemande);

                        //         if ($comitep->categorieComite->type_code_categorie_comite === 'CT' || $comitep->categorieComite->type_code_categorie_comite === 'CC') {
                        //             $projet_etude->flag_soumis_ct_pleniere = false;
                        //             $projet_etude->flag_passer_comite_technique = false;
                        //         }

                        //         $projet_etude->update();
                        //     }

                        //     if ($codeprocessus === 'PRF') {
                        //         $projetformation = ProjetFormation::find($iddemande);
                        //         if ($comitep->categorieComite->type_code_categorie_comite === 'CT' || $comitep->categorieComite->type_code_categorie_comite === 'CC') {
                        //             $projetformation->update([
                        //                 'flag_statut_instruction' => false,
                        //                 'flag_passer_comite_technique' => false,
                        //             ]);
                        //         }
                        //     }

                        //     // Enregistrement de la demande rejetée
                        //     ComiteRejeter::create([
                        //         'id_demande' => $iddemande,
                        //         'id_comite' => $comitep->id_comite,
                        //         'code_processus' => $codeprocessus,
                        //     ]);
                        // }
                    //}

                    foreach ($listedemandesss as $iddemande) {
                        // Rechercher si la demande est dans les demandes sélectionnées
                        $found = false;
                        foreach ($demandesSelectionnees as $demande) {
                            if ($demande['id_demande'] == $iddemande) {
                                // Si trouvé, ajouter à la liste des éléments sélectionnés avec le code_processus
                                $elementsSelectionnes[] = [
                                    'id_demande' => $iddemande,
                                    'code_processus' => $demande['code_processus']
                                ];
                                $found = true;
                                break;
                            }
                        }

                        // Si non trouvé, ajouter à la liste des éléments non sélectionnés
                        if (!$found) {
                            // Comme le code_processus n'existe pas dans $tab pour les éléments non sélectionnés, tu peux lui attribuer une valeur par défaut si nécessaire
                            $elementsNonSelectionnes[] = [
                                'id_demande' => $iddemande,
                                'code_processus' => @$comitep->processusComiteLieComites[0]->code_pieces
                            ];
                        }
                    }

                    dd($elementsSelectionnes,$elementsNonSelectionnes, $comitep->processusComiteLieComites[0]->code_pieces);
                    // Mise à jour du statut du comité
                    // $comitep->update([
                    //     'flag_statut_comite' => true,
                    //     'date_fin_comite' => Carbon::now(),
                    // ]);


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

                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins un plan/projet pour le comité '.@$processuscomite->processusComite->libelle_processus_comite.'.)',

                        'etat'=>'Echec',

                        'objet'=>'COMITES TECHNIQUES'

                        ]);

                    return redirect('comitetechniques/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un plan/projet pour le comité '.@$processuscomite->processusComite->libelle_processus_comite.'. ');

            }

            }
        }
    }

     public function edithabilitation($id,$id1,$id2)  {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;

        $demandehabilitation = DemandeHabilitation::find($id1);

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

        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id1]])->get();

        $typeinterventions = TypeIntervention::where([['flag_type_intervention','=',true]])->get();
        $typeinterventionsList = "<option value=''> Selectionnez le type d\'intervention </option>";
        foreach ($typeinterventions as $comp) {
            $typeinterventionsList .= "<option value='" . $comp->id_type_intervention  . "'>" . mb_strtoupper($comp->libelle_type_intervention) ." </option>";
        }

        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id1]])->get();
        //dd($idetape);

        $organisationFormations = TypeOrganisationFormation::where([['flag_type_organisation_formation','=',true]])->get();
        $organisationFormationsList = "<option value=''> Selectionnez le type d\'organisation </option>";
        foreach ($organisationFormations as $comp) {
            $organisationFormationsList .= "<option value='" . $comp->id_type_organisation_formation  . "'>" . mb_strtoupper($comp->libelle_type_organisation_formation) ." </option>";
        }

        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id1]])->get();

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

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();

        $domainedemandes = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();
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
                                                          ->where([['id_demande_habilitation','=',$id1]])
                                                          ->get();


        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id1]])->get();



        $criteres = CritereEvaluation::Join('categorie_comite','critere_evaluation.id_categorie_comite','categorie_comite.id_categorie_comite')
                                    ->join('processus_comite','critere_evaluation.id_processus_comite','processus_comite.id_processus_comite')
                                    ->where([['critere_evaluation.flag_critere_evaluation','=',true],
                                            ['categorie_comite.code_categorie_comite','=','CT'],
                                            ['processus_comite.code_processus_comite','=','HAB']])
                                    ->get();

        $piecesDemandeHabilitations = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();

        $traitement = TraitementParCritere::Join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
                ->where([['traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','=',Auth::user()->id],['traitement_par_critere.id_demande','=',$id1]])->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES TECHNIQUES (HABILITATION)'

        ]);

        return view('comites.comitetechniques.edithabilitation', compact('demandehabilitation','infoentreprise','banque','pay',
                    'id','id1','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
                    'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
                    'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList',
                    'typeDomaineDemandeHabilitationPublicList','criteres','traitement',
                    'visites','rapportVisite','piecesDemandeHabilitations'));
    }

    public function showficheanalysehabilitation($id,$id1,$id2) {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);

        $demandehabilitation = DemandeHabilitation::find($id1);

        $visite = Visites::where([['id_demande_habilitation','=',$id1]])->first();

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

        $formateurs = DB::table('vue_formateur_rapport')->where([['id_demande_habilitation','=',$id1]])->get();

        $rapport = RapportsVisites::where([['id_demande_habilitation','=',$id1]])->first();

        $piecesDemandes = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();

        return view('comites.comitetechniques.showficheanalysehabilitation',compact('id','infoentreprise',
                        'demandehabilitation','visite','formateurs','rapport','piecesDemandes'));
    }

    public function editplanformation($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;

        $comite = Comite::find($id);

        //dd($idcomite);
        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $listedemandesss = DB::table('vue_plans_projets_formation_traiter as vue_plans_projets_formation')
        ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
        ->join('comite','cahier_comite.id_comite','comite.id_comite')
        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
        ->where([['cahier_comite.id_comite','=',$id],['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
        ->get();

        //$comiteparticipants = ComiteParticipant::where([['id_comite','=',$id]])->get();

        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
        ->join('users','comite_participant.id_user_comite_participant','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['id_comite','=',$id]])
        ->get();

        $planformation = PlanFormation::find($id1);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $typeentreprises = TypeEntreprise::all();
        $typeentreprise = "<option value='".$planformation->typeEntreprise->id_type_entreprise."'>".$planformation->typeEntreprise->lielle_type_entrepise." </option>";
        foreach ($typeentreprises as $comp) {
            $typeentreprise .= "<option value='" . $comp->id_type_entreprise  . "'>" . mb_strtoupper($comp->lielle_type_entrepise) ." </option>";
        }


        $pays = Pays::all();
        $pay = "<option value='".@$infoentreprise->pay->id_pays."'> " . @$infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }

        $typeformations = TypeFormation::all();
        $typeformation = "<option value=''> Selectionnez le type  de la formation </option>";
        foreach ($typeformations as $comp) {
            $typeformation .= "<option value='" . $comp->id_type_formation  . "'>" . mb_strtoupper($comp->type_formation) ." </option>";
        }

        $categorieprofessionelles = CategorieProfessionelle::all();
        $categorieprofessionelle = "<option value=''> Selectionnez la categorie </option>";
        foreach ($categorieprofessionelles as $comp) {
            $categorieprofessionelle .= "<option value='" . $comp->id_categorie_professionelle  . "'>" . mb_strtoupper($comp->categorie_profeessionnelle) ." </option>";
        }

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id1]])->get();

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id1]])->get();

        $motifs = Motif::where([['code_motif','=','CTPAF']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','type_formation.*','domaine_formation.*')
                                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                                        ->join('domaine_formation','domaine_formation.id_domaine_formation','=','domaine_formation.id_domaine_formation')
                                        ->where([['action_formation_plan.id_plan_de_formation','=',$id1]])->get();

        $criteres = CritereEvaluation::Join('categorie_comite','critere_evaluation.id_categorie_comite','categorie_comite.id_categorie_comite')
                                    ->join('processus_comite','critere_evaluation.id_processus_comite','processus_comite.id_processus_comite')
                                    ->where([['critere_evaluation.flag_critere_evaluation','=',true],
                                            ['categorie_comite.code_categorie_comite','=','CT'],
                                            ['processus_comite.code_processus_comite','=','PF']])
                                    ->get();

     /******************** secteuractivites *********************************/
        $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                        ->orderBy('libelle_secteur_activite')
                        ->get();


        $typeformationss = TypeFormation::where('flag_actif_formation','=',true)->orderBy('type_formation')->get();

        $butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES TECHNIQUES'

        ]);

        return view('comites.comitetechniques.editplanformation', compact(
            'comite','idetape','id','id1','processuscomite','cahiers','comiteparticipants','listedemandesss',
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'idcomite','criteres','secteuractivites','typeformationss','butformations'
        ));

    }

    public function editprojetetude($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;

        $comite = Comite::find($id);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if(isset($id1)){
            $projet_etude = ProjetEtude::find($id1);
            if(isset($projet_etude)){
                $pieces_projets= PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)->get();

                $avant_projet_tdr = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','avant_projet_tdr')->first();
                $courier_demande_fin = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','courier_demande_fin')->first();
                $offre_technique = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_technique')->first();
                $offre_financiere = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_financiere')->first();

                $domaine_projets = DomaineFormation::where('flag_domaine_formation', '=', true)
                    ->orderBy('libelle_domaine_formation')
                    ->get();

                $domaine_projet = "<option value='".$projet_etude->DomaineProjetEtude->id_domaine_formation."'> " . $projet_etude->DomaineProjetEtude->libelle_domaine_formation . "</option>";
                foreach ($domaine_projets as $comp) {
                    $domaine_projet .= "<option value='" . $comp->id_domaine_formation."'>" . mb_strtoupper($comp->libelle_domaine_formation) . " </option>";
                }

                $infoentreprise = Entreprises::find($projet_etude->id_entreprises)->first();

                $pays = Pays::all();
                $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
                foreach ($pays as $comp) {
                    $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }

                /******************** secteuractivites *********************************/
                $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();
                $secteuractivite = "<option value=''> Selectionnez un secteur activité </option>";
                foreach ($secteuractivites as $comp) {
                    $secteuractivite .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }
                $motif = Motif::where('code_motif','=','PRE')->get();;
                $motifs = "<option value='".$projet_etude->motif->id_motif."'> " . $projet_etude->motif->libelle_motif . "</option>";
                foreach ($motif as $comp) {
                    $motifs .= "<option value='" . $comp->id_motif  . "' >" . $comp->libelle_motif ." </option>";
                }

                $formjuridique = "<option value='".$infoentreprise->formeJuridique->id_forme_juridique."'> " . $infoentreprise->formeJuridique->libelle_forme_juridique . "</option>";

                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                }


                return view('comites.comitetechniques.editprojetetude',
                    compact('idetape','pay','pieces_projets','avant_projet_tdr',
                        'courier_demande_fin',
                        'offre_technique',
                        'projet_etude',
                        'idcomite',
                        'comite',
                        'domaine_projets',
                        'motifs',
                        'formjuridique',
                        'offre_financiere',
                        'secteuractivite'));

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
