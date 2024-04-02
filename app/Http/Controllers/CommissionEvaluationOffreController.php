<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Menu;
use App\Models\CahierCommissionEvaluationOffre;
use App\Models\ComiteParticipant;
use App\Models\CommissionEvaluationOffre;
use App\Models\CommissionParticipantEvaluationOffre;
use App\Models\CritereEvaluationOffreTech;
use App\Models\NotationCommissionEvaluationOffreTech;
use App\Models\OffreTechCommissionEvaluationOffre;
use App\Models\ProjetEtude;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GenerateCode as Gencode;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class CommissionEvaluationOffreController extends Controller
{
    //
    public function index()
    {
        $commission_evaluation_offres = CommissionEvaluationOffre::all();
        Audit::logSave([
            'action'=>'INDEX',
            'code_piece'=>'',
            'menu'=>'EVALUATION OFFRE',
            'etat'=>'Succès',
            'objet'=>'COMMISSION'
        ]);
        return view('evaluationoffre.commission.index', compact('commission_evaluation_offres'));
    }

    public function create()
    {
        Audit::logSave([
            'action'=>'CREER',
            'code_piece'=>'',
            'menu'=>'EVALUATION OFFRE',
            'etat'=>'Succès',
            'objet'=>'COMMISSION'
        ]);
        return view('evaluationoffre.commission.create');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'date_debut_commission_evaluation_offre' => 'required|date|after_or_equal:now',
                'commentaire_commission_evaluation_offre' => 'required',
                'numero_commission_evaluation_offre' => 'required',
                'nombre_evaluateur_commission_evaluation_offre' => 'required',
                'pourcentage_offre_tech_commission_evaluation_offre' => 'required'
            ],[
                'date_debut_commission_evaluation_offre.required' => 'Veuillez ajouter une date de debut.',
                'date_debut_commission_evaluation_offre.after_or_equal' => 'La date ne doit pas être inférieure à celle du jour.',
                'commentaire_commission_evaluation_offre.required' => 'Veuillez ajouter un commentaire.',
                'numero_commission_evaluation_offre.required' => 'Veuillez ajouter un numéro de commission.',
                'nombre_evaluateur_commission_evaluation_offre.required' => 'Veuillez ajouter un nombre d\'évaluateur',
                'pourcentage_offre_tech_commission_evaluation_offre.required' => 'Veuillez ajouter un pourcentage pour une offre technique',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_commission_evaluation_offre'] = Auth::user()->id;
            $input['code_commission_evaluation_offre'] = 'CODE'.'-'. Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $commission_evaluation_offre = CommissionEvaluationOffre::create($input);

            $insertedId = $commission_evaluation_offre->id_commission_evaluation_offre;

            Audit::logSave([
                'action'=>'CREATION',
                'code_piece'=>$insertedId,
                'menu'=>'EVALUATION OFFRE',
                'etat'=>'Succès',
                'objet'=>'COMMISSION'
            ]);

            if($request->action=="Enregistrer_Suivant"){
                return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }else{
                return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }
        }
    }

    public function edit($id,$id1)
    {

        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $commissionevaluationoffre = CommissionEvaluationOffre::find($id);
        $critereevaluationoffretechs = CritereEvaluationOffreTech::where('flag_critere_evaluation_offre_tech',true)->get();

        $notation_commission_evaluation_offre_tech = NotationCommissionEvaluationOffreTech::
        Join('commission_evaluation_offre_participant','commission_evaluation_offre_participant.id_user_commission_evaluation_offre_participant',
        'notation_commission_evaluation_offre_tech.id_user_notation_commission_evaluation_offre')
            ->where('notation_commission_evaluation_offre_tech.id_commission_evaluation_offre',$id)
            ->get()
            ->groupby('notation_commission_evaluation_offre_tech.id_user_notation_commission_evaluation_offre')
            ->count();

        $offretechcommissionevals = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)
            ->Join('critere_evaluation_offre_tech','offre_tech_commission_evaluation_offre.id_critere_evaluation_offre_tech','critere_evaluation_offre_tech.id_critere_evaluation_offre_tech')
            ->select('critere_evaluation_offre_tech.*','offre_tech_commission_evaluation_offre.*')
            ->get()
            ->groupby('libelle_critere_evaluation_offre_tech');

        $offretechcommissioneval_tabs = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)->get();


//
//        $personneressources = User::select('users.id as id','users.name as name','users.prenom_users as prenom_users', 'roles.name as profile')
//            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
//            ->join('roles', 'model_has_roles.role_id', 'roles.id')
//            ->where([['flag_demission_users', '=', false],
//                ['flag_admin_users', '=', false],
//                ['roles.code_roles', '=', 'CHARGEETUDE']
//            ])
//            ->get();

//        $operateur_selecteds = Entreprises::whereNotExists(function ($query) use ($id_projet_etude){
//            $query->select('*')
//                ->from('projet_etude_has_entreprises')
//                ->whereColumn('projet_etude_has_entreprises.id_entreprises','=','entreprises.id_entreprises')
//                ->where('projet_etude_has_entreprises.id_projet_etude',$id_projet_etude);
//        })->where('flag_operateur',true)
//            ->where('flag_actif_entreprises',true)
//
//            ->where('id_secteur_activite_entreprise',$projet_etude->id_secteur_activite)
//            ->get();

        $personneressources = User::select('users.id as id','users.name as name','users.prenom_users as prenom_users', 'roles.name as profile')
        ->whereNotExists(function ($query) use ($id){
            $query->select('*')
                ->from('commission_evaluation_offre_participant')
                ->whereColumn('commission_evaluation_offre_participant.id_user_commission_evaluation_offre_participant','=','users.id')
                ->where('commission_evaluation_offre_participant.id_commission_evaluation_offre','=',$id);
        })->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['flag_demission_users', '=', false],
            ['flag_admin_users', '=', false],
            ['roles.code_roles', '=', 'CHARGEETUDE']
        ])->get();

        $personneressource = "<option value=''> Selectionnez le but de la formation </option>";

        foreach ($personneressources as $comp) {
            $personneressource .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) . ' ( '.mb_strtoupper($comp->profile).' ) '." </option>";
        }


        $projet_etudes = ProjetEtude::whereNotExists(function ($query) use ($id){
            $query->select('*')
                ->from('cahier_commission_evaluation_offre')
                ->whereColumn('cahier_commission_evaluation_offre.id_projet_etude','=','projet_etude.id_projet_etude')
                ->where('cahier_commission_evaluation_offre.id_commission_evaluation_offre',$id);
        })->where('flag_fiche_agrement',true)
            ->where('flag_selection_operateur_valider_par_processus',true)
            ->get();

        $cahier = CahierCommissionEvaluationOffre::where([['id_commission_evaluation_offre','=',$id]])->first();

        $commissioneparticipants = CommissionParticipantEvaluationOffre::select('commission_evaluation_offre_participant.id_commission_evaluation_offre_participant as id_commission_participant', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile')
            ->join('users','commission_evaluation_offre_participant.id_user_commission_evaluation_offre_participant','users.id')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where([['id_commission_evaluation_offre','=',$id]])
            ->get();

        $listedemandes = ProjetEtude::whereExists(function ($query) use ($id){
            $query->select('*')
                ->from('cahier_commission_evaluation_offre')
                ->whereColumn('cahier_commission_evaluation_offre.id_projet_etude','=','projet_etude.id_projet_etude')
                ->where('cahier_commission_evaluation_offre.id_commission_evaluation_offre',$id);
        })->where('flag_fiche_agrement',true)->where('flag_selection_operateur_valider_par_processus',true)->get();

        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'EVALUATION OFFRE',
            'etat'=>'Succès',
            'objet'=>'COMMISSION'
        ]);

        return view('evaluationoffre.commission.edit',compact(
                'id',
            'critereevaluationoffretechs',
            'offretechcommissionevals',
            'projet_etudes',
            'cahier',
            'commissioneparticipants',
            'listedemandes',
            'personneressource',
            'notation_commission_evaluation_offre_tech',
            'offretechcommissioneval_tabs',
            'commissionevaluationoffre','idetape'));
    }


    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $commissionevaluationoffre = CommissionEvaluationOffre::find($id);

        if ($request->isMethod('put')) {
            $data = $request->all();
            if ($data['action'] == 'Modifier' || $data['action'] == 'Modifier_Suivant'){
                $this->validate($request, [
                    'date_debut_commission_evaluation_offre' => 'required|date',
                    'commentaire_commission_evaluation_offre' => 'required',
                    'numero_commission_evaluation_offre' => 'required',
                    'nombre_evaluateur_commission_evaluation_offre' => 'required',
                    'pourcentage_offre_tech_commission_evaluation_offre' => 'required'
                ],[
                    'date_debut_commission_evaluation_offre.required' => 'Veuillez ajouter une date de debut.',
                    'commentaire_commission_evaluation_offre.required' => 'Veuillez ajouter un commentaire.',
                    'numero_commission_evaluation_offre.required' => 'Veuillez ajouter un numéro de commission.',
                    'nombre_evaluateur_commission_evaluation_offre.required' => 'Veuillez ajouter un nombre d\'évaluateur',
                    'pourcentage_offre_tech_commission_evaluation_offre.required' => 'Veuillez ajouter un pourcentage pour une offre technique',
                ]);

                $input = $request->all();
                $commissionevaluationoffre->update($input);

                Audit::logSave([
                    'action'=>'MISE A JOUR',
                    'code_piece'=>$id,
                    'menu'=>'EVALUATION OFFRE',
                    'etat'=>'Succès',
                    'objet'=>'COMMISSION'
                ]);

                if($data['action'] == 'Modifier_Suivant' ){
                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Information mise à jour ');
                }else{
                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Information mise à jour ');
                }


            }
            if ($data['action'] == 'Enregistrer_Offre_Tech'){

                $this->validate($request, [
                    'id_sous_critere_evaluation_offre_tech' => 'required',
                    'id_critere_evaluation_offre_tech' => 'required',
                    'note_offre_tech_commission_evaluation_offre' => 'required',
                ],[
                    'id_critere_evaluation_offre_tech.required' => 'Veuillez ajouter une critère.',
                    'id_sous_critere_evaluation_offre_tech.required' => 'Veuillez ajouter une sous-critère.',
                    'note_offre_tech_commission_evaluation_offre.required' => 'Veuillez ajouter une note.',
                ]);

                $input = $request->all();

                $input['id_commission_evaluation_offre'] = $id;
                $offretechcommissioneval = OffreTechCommissionEvaluationOffre::create($input);

                $insertedId = $offretechcommissioneval->id_offre_tech_commission_evaluation_offre;

                Audit::logSave([
                    'action'=>'CREATION',
                    'code_piece'=>$insertedId,
                    'menu'=>'EVALUATION OFFRE',
                    'etat'=>'Succès',
                    'objet'=>'OFFRE TECHNIQUE'
                ]);

                return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succès : Sous-critère ajouté avec succès');
            }
            if ($data['action'] == 'Enregistrer_personne_ressource_pour_commission'){

                $this->validate($request, [
                    'id_user_commission_evaluation_offre_participant' => 'required'
                ],[
                    'id_user_commission_evaluation_offre_participant.required' => 'Veuillez selectionnez le/les personne(s) ressource(s).'
                ]);

                $input = $request->all();
                if(isset($input['id_user_commission_evaluation_offre_participant'])){

                    $verifnombre = count($input['id_user_commission_evaluation_offre_participant']);

                    if($verifnombre < 1){
//                        Audit::logSave([
//                            'action'=>'MISE A JOUR',
//                            'code_piece'=>$id,
//                            'menu'=>'COMITES (Cahier du '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins une personne le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',
//                            'etat'=>'Echec',
//                            'objet'=>'COMITES TECHNIQUES'
//                        ]);
                        return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins une personne pour la commisison ');
                    }

                    $tab = $input['id_user_commission_evaluation_offre_participant'];

                    foreach ($tab as $key => $value) {
                        CommissionParticipantEvaluationOffre::create([
                            'id_commission_evaluation_offre'=> $id,
                            'id_user_commission_evaluation_offre_participant'=> $value,
                            'flag_commission_evaluation_offre_participant'=>true
                        ]);
                    }

//                    Audit::logSave([
//                        'action'=>'MISE A JOUR',
//                        'code_piece'=>$id,
//                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' )',
//                        'etat'=>'Succès',
//                        'objet'=>'COMITES TECHNIQUES'
//                    ]);

                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Participant ajouté avec succès');

                }else{
//                    Audit::logSave([
//
//                        'action'=>'MISE A JOUR',
//
//                        'code_piece'=>$id,
//
//                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous devez sélectionner au moins une personne pour le CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',
//
//                        'etat'=>'Echec',
//
//                        'objet'=>'COMITES TECHNIQUES'
//                    ]);

                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins une personne pour la commission');
                }
            }
            if ($data['action'] == 'Invitation_personne_ressouce'){
                $listepersonnes = CommissionParticipantEvaluationOffre::where([['id_commission_evaluation_offre','=',$id]])->get();
                if(count($listepersonnes)<1){
//                    Audit::logSave([
//                        'action'=>'MISE A JOUR',
//                        'code_piece'=>$id,
//                        'menu'=>'COMITES (Cahier de '.@$comitep->categorieComite->libelle_categorie_comite.' : Vous ne pouvez pas envoyer les invitations car il n\' y a pas de personne ressousce pour  CT '.@$processuscomite->processusComite->libelle_processus_comite.'.)',
//                        'etat'=>'Echec',
//                        'objet'=>'COMITES TECHNIQUES'
//                    ]);
                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous ne pouvez pas envoyer les invitations car il n\' y a pas de personne ressource à la commission.');
                }else{
                    foreach($listepersonnes as $personne){
                        $logo = Menu::get_logo();
                        $email = $personne->user->email;
                        $nom = $personne->user->name;
                        $prenom = $personne->user->prenom_users;

                        if (isset($email)) {
                            $nom_prenom = $nom .' '. $prenom;
                            $sujet = "Tenue de commission d'évaluation ";
                            $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                            $messageMail = "<b>Cher(e) $nom_prenom  ,</b>
                                            <br><br>Vous êtes conviés à la commission d'évaluation qui se déroulera  à partir du ".$commissionevaluationoffre->date_debut_commission_evaluation_offre;

                            if(isset($commissionevaluationoffre->date_fin_commission_evaluation_offre)){
                                $messageMail.=" au".$commissionevaluationoffre->date_fin_commission_evaluation_offre." <br><br> Vous êtes priés de bien vouloir prendre connaissance des documents suivants via le lien ci-dessous : <br/>".
                                route('traitementcomitetechniques.edit',['id'=>Crypt::UrlCrypt($id),'id1'=>Crypt::UrlCrypt(1)])
                                ."<br><br><br>
                                -----
                                            Ceci est un mail automatique, Merci de ne pas y répondre.
                                -----
                                            ";
                            }
                            $messageMailEnvoi = Email::get_envoimailTemplate($email, $nom_prenom, $messageMail, $sujet, $titre);
                        }

                    }
                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Invitation envoyée avec succès');
                }
            }
            if ($data['action'] == 'creer_cahier_offre_projets'){
                $input = $request->all();
                if(isset($input['demande'])){
                    $verifnombre = count($input['demande']);
                    if($verifnombre < 1 && $verifnombre > 2 ){
//                        Audit::logSave([
//                            'action'=>'MISE A JOUR',
//                            'code_piece'=>$id,
//                            'menu'=>'COMITES (Cahier du '.@$comitep->typeComite->libelle_type_comite.' : Vous devez sélectionner au moins un plan/projet pour le comite.)',
//                            'etat'=>'Echec',
//                            'objet'=>'COMITES'
//                        ]);
                        return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Echec : Vous devez sélectionner projet d\'étude pour la commission d\'évaluation');
                    }
                    $tab = $input['demande'];
                    foreach ($tab as $key => $value) {
                        CahierCommissionEvaluationOffre::create([
                            'id_commission_evaluation_offre'=> $id,
                            'id_projet_etude'=> $value,
                            'flag_cahier'=>true
                        ]);

                        $projet_etude = ProjetEtude::find($value);
                        $projet_etude->flag_passer_commission_evaluation_offre = true;
                        $projet_etude->update();
                    }

//                    Audit::logSave([
//                        'action'=>'MISE A JOUR',
//                        'code_piece'=>$id,
//                        'menu'=>'COMITES (Cahier de '.@$comitep->typeComite->libelle_type_comite.' )',
//                        'etat'=>'Succès',
//                        'objet'=>'COMITES'
//
//                    ]);
                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Projet d\'étude ajouté à la commission avec succès');

                }
//else{
//
//                    Audit::logSave([
//
//                        'action'=>'MISE A JOUR',
//
//                        'code_piece'=>$id,
//
//                        'menu'=>'COMITES (Cahier de '.@$comitep->typeComite->libelle_type_comite.' : Vous devez sélectionner au moins un plan/projet pour le comite.)',
//
//                        'etat'=>'Echec',
//
//                        'objet'=>'COMITES'
//
//                    ]);
//
//                    return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un plan/projet pour le comite ');
//
//
//
//                }
//
//
            }
//

        }
    }


    public function deletePersonne($id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $commissionpartipant = CommissionParticipantEvaluationOffre::find($id);
        $commission = $commissionpartipant->id_commission_evaluation_offre;
        CommissionParticipantEvaluationOffre::where([['id_commission_evaluation_offre_participant','=',$id]])->delete();

        Audit::logSave([
            'action'=>'SUPPRIMER',
            'code_piece'=>$commissionpartipant->id_commission_evaluation_offre_participant,
            'menu'=>'EVALUATION OFFRE (Suppression des personne ressources à une commission)',
            'etat'=>'Succès',
            'objet'=>'COMMISSION'
        ]);
        return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($commission).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Personne rétirée de la commission avec succès');
    }

    public function deleteSousCritere($id,$id1){
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $offretechcomeval = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)
            ->where('id_sous_critere_evaluation_offre_tech',$id1)->first();
        if(isset($offretechcomeval)){
            $offretechcomeval->delete();
            return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Sous-critère retiré de la commission avec succès');
        }
    }

}
