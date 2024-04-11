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
use App\Models\Entreprises;
use App\Models\NotationCommissionEvaluationOffreFin;
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
                'numero_commission_evaluation_offre' => 'required',
                'pourcentage_offre_tech_commission_evaluation_offre' => 'required',
                'note_eliminatoire_offre_tech_commission_evaluation_offre' => 'required|max:100',
                'marge_inf_offre_fin_commission_evaluation_offre' => 'required|max:100',
                'marge_sup_offre_fin_commission_evaluation_offre' => 'required|max:100'
            ],[
                'date_debut_commission_evaluation_offre.required' => 'Veuillez ajouter une date de debut.',
                'date_debut_commission_evaluation_offre.after_or_equal' => 'La date ne doit pas être inférieure à celle du jour.',
                'numero_commission_evaluation_offre.required' => 'Veuillez ajouter un numéro de commission.',
                'pourcentage_offre_tech_commission_evaluation_offre.required' => 'Veuillez ajouter un pourcentage pour une offre technique',
                'note_eliminatoire_offre_tech_commission_evaluation_offre.required' => 'Veuillez ajouter une note éliminatoire pour une offre technique',
                'marge_inf_offre_fin_commission_evaluation_offre.required' => 'Veuillez ajouter une marge inférieur pour l\'offre financière',
                'marge_sup_offre_fin_commission_evaluation_offre.required' => 'Veuillez ajouter une marge supérieur pour l\'offre financière',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_commission_evaluation_offre'] = Auth::user()->id;
            $input['code_commission_evaluation_offre'] = 'CODE'.'-'. Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $commission_evaluation_offre = CommissionEvaluationOffre::create($input);
            $insertedId = CommissionEvaluationOffre::latest()->first()->id_commission_evaluation_offre;

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
        $offretechcommissioneval_sums = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)->sum('note_offre_tech_commission_evaluation_offre');

        $beginvalidebyoneuser = CommissionParticipantEvaluationOffre::where('id_commission_evaluation_offre',$id)
            ->where('flag_statut_valider_commission_evaluation_offre_participant',true)->get();

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

        if(isset($commissioneparticipants)){
            $classement_offre_techs = DB::table('notation_commission_evaluation_offre_tech')
                ->Join('entreprises','entreprises.id_entreprises',
                    'notation_commission_evaluation_offre_tech.id_operateur')
                ->selectRaw('entreprises.raison_social_entreprises as entreprise,
                sum(note_notation_commission_evaluation_offre_tech)/'.$commissioneparticipants->count().' as note
                ')
                ->where('notation_commission_evaluation_offre_tech.id_commission_evaluation_offre',$id)
                ->groupBy('entreprise')
                ->orderBy('note', 'desc')
                ->get();

        }else{
            $classement_offre_techs = [];
        }

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
            'beginvalidebyoneuser',
            'classement_offre_techs',
            'personneressource',
            'offretechcommissioneval_sums',
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
                    'pourcentage_offre_tech_commission_evaluation_offre' => 'required'
                ],[
                    'date_debut_commission_evaluation_offre.required' => 'Veuillez ajouter une date de debut.',
                    'commentaire_commission_evaluation_offre.required' => 'Veuillez ajouter un commentaire.',
                    'numero_commission_evaluation_offre.required' => 'Veuillez ajouter un numéro de commission.',
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

                $somme_exist = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)->get();
                if($somme_exist->sum('note_offre_tech_commission_evaluation_offre')+$input['note_offre_tech_commission_evaluation_offre']>100){
                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('error', 'Echec : la somme des sous-critères ne peut être supérieur à 100');
                }

                $offretechcommissioneval = OffreTechCommissionEvaluationOffre::create($input);
                $insertedId = OffreTechCommissionEvaluationOffre::latest()->first()->id_offre_tech_commission_evaluation_offre;

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
                    $listepersonnes = CommissionParticipantEvaluationOffre::where([['id_commission_evaluation_offre','=',$id]])->get();
                    $commissionevaluationoffre->update([
                        'nombre_evaluateur_commission_evaluation_offre'=>@$listepersonnes->count()
                    ]);

                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Participant ajouté avec succès');

                }else{

                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins une personne pour la commission');
                }
            }
            if ($data['action'] == 'Invitation_personne_ressouce'){
                $listepersonnes = CommissionParticipantEvaluationOffre::where([['id_commission_evaluation_offre','=',$id]])->get();
                if(count($listepersonnes)<1){
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
                                $messageMail.=" au".$commissionevaluationoffre->date_fin_commission_evaluation_offre;
                            }

                            $messageMail.=".<br><br> Vous êtes priés de bien vouloir prendre connaissance des documents suivants <a href=\"".route('traitementcommissionevaluationoffres.edit',['id'=>Crypt::UrlCrypt($id),'id1'=>Crypt::UrlCrypt(1)])."\">Cliquez ici</a> <br/>".

                                "<br><br><br>
                                -----
                                            Ceci est un mail automatique, Merci de ne pas y répondre.
                                -----
                                            ";
                            $messageMailEnvoi = Email::get_envoimailTemplate($email, $nom_prenom, $messageMail, $sujet, $titre);
                        }

                    }
                    return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Invitation envoyée avec succès');
                }
            }
            if ($data['action'] == 'creer_cahier_offre_projets'){
                $input = $request->all();
                $this->validate($request, [
                    'demande' => 'required'
                ],[
                    'demande.required' => 'Veuillez selectionner un projet d\'étude.'
                ]);

                CahierCommissionEvaluationOffre::create([
                    'id_commission_evaluation_offre'=> $id,
                    'id_projet_etude'=> $input['demande'],
                    'flag_cahier'=>true
                ]);

                $projet_etude = ProjetEtude::find($input['demande']);
                $projet_etude->flag_passer_commission_evaluation_offre = true;
                $projet_etude->update();

                return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Projet d\'étude ajouté à la commission avec succès');

            }
            if($data['action'] == 'valider_offre_technique'){
                    $commissionevaluationoffre->update([
                        'flag_valider_offre_tech_commission_evaluation_tech'=> true,
                        'date_valider_offre_tech_commission_evaluation_tech' => Carbon::now()
                    ]);
                return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(5).'/edit')->with('success', 'Succès : Offre technique cloturée avec succès');
            }
        }
    }


    public function updateNotationOffreFin(Request $request, $id, $id1){
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        $commissionevaluationoffre = CommissionEvaluationOffre::find($id);
        if ($request->isMethod('put')) {
            $data = $request->all();
//            if($request->action =="valider_offre_fin"){
//                if(isset($commissioneparticipant)){
//                    $commissioneparticipant->flag_statut_valider_commission_evaluation_offre_participant = true;
//                    $commissioneparticipant->update();
//                    return redirect('traitementcommissionevaluationoffres')->with('success', 'Succès : Validation effectuée avec succès ');
//                }
//            }

            if($request->action =="Enregistrer_offre_Fin"){
                foreach($request->note_operations as $key=>$note_operation){
                    $entreprise = Entreprises::find($key);
                    foreach ($note_operation as $key_sous_critere=>$note_sous_critere) {
                        $notation_montant = new NotationCommissionEvaluationOffreFin();
                        $notation_montant->id_commission_evaluation_offre =$id;
                        $notation_montant->id_user_notation_commission_evaluation_offre =Auth::user()->id;
//                        $notation_montant->montant_notation_commission_evaluation_offre_fin = ;
                        $notation_montant->id_operateur =$key;

                        //Vérification sur le montant entrée
                        $notation_montant_exist = NotationCommissionEvaluationOffreFin::where('id_commission_evaluation_offre',$id)
                            ->where('id_operateur',intval($key))
                            ->where('id_user_notation_commission_evaluation_offre',Auth::user()->id)
                            ->first();

                        if(isset($note_exist)){
                            $notation_montant_exist->montant_notation_commission_evaluation_offre_fin = intval($note_sous_critere[0]);
                            $notation_montant_exist->update();
                        }else{
                            $notation_montant->save();
                        }
                    }
                }
                return redirect('traitementcommissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succès : Enregistrement effectué avec succès ');
            }

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
            return redirect('commissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Sous-critère retiré de la commission avec succès');
        }
    }

    public function showOffreTech($id){
        $id =  Crypt::UrldeCrypt($id);

        $cahier = CahierCommissionEvaluationOffre::where([['id_commission_evaluation_offre','=',$id]])->first();
        $offretechcommissionevals = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)
            ->Join('critere_evaluation_offre_tech','offre_tech_commission_evaluation_offre.id_critere_evaluation_offre_tech','critere_evaluation_offre_tech.id_critere_evaluation_offre_tech')
            ->select('critere_evaluation_offre_tech.*','offre_tech_commission_evaluation_offre.*')
            ->get()
            ->groupby('libelle_critere_evaluation_offre_tech');
        $commissioneparticipants = CommissionParticipantEvaluationOffre::select('commission_evaluation_offre_participant.id_commission_evaluation_offre_participant as id_commission_participant','users.id as id_user_commission_evaluation_offre_participant', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile')
            ->join('users','commission_evaluation_offre_participant.id_user_commission_evaluation_offre_participant','users.id')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where([['id_commission_evaluation_offre','=',$id]])
            ->get();

        return view('evaluationoffre.commission.showoffretech',compact(
            'id',
            'offretechcommissionevals',
            'cahier',
            'commissioneparticipants',
            )
        );
    }
}
