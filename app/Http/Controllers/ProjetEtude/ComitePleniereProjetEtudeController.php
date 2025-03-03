<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\Cahier;
use App\Models\ComitePleniere;
use App\Models\ComitePleniereParticipant;
use App\Models\Entreprises;
use App\Models\FormeJuridique;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\User;
use Carbon\Carbon;
use DB;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class ComitePleniereProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comite_plenieres = ComitePleniere::where('code_pieces','PE')->get();
        return view('projetetudes.comite_technique.index', compact('comite_plenieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projetetudes.comite_technique.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'date_debut_comite_pleniere' => 'required',
                'date_fin_comite_pleniere' => 'required',
                'commentaire_comite_pleniere' => 'required'
            ],[
                'date_debut_comite_pleniere.required' => 'Veuillez ajouter une date de debut.',
                'date_fin_comite_pleniere.required' => 'Veuillez ajouter une date de fin.',
                'commentaire_comite_pleniere.required' => 'Veuillez ajouter un commentaire.',
            ]);
            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_pleniere'] = Auth::user()->id;
            $input['code_comite_pleniere'] = 'CT' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces'] = 'PE';
            ComitePleniere::create($input);
            $insertedId = ComitePleniere::latest()->first()->id_comite_pleniere;
            if($request->action=="Enregistrer"){
                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Enregistrement réussi ');
            }
            if($request->action=="Enregistrer_suivant"){
                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Enregistrement réussi ');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape = Crypt::UrldeCrypt($id1);
        $comitepleniere = ComitePleniere::find($id);
        $comitepleniereparticipant = ComitePleniereParticipant::where('id_comite_pleniere',$comitepleniere->id_comite_pleniere)->get();

        $charger_etudes = \Illuminate\Support\Facades\DB::table('users')
            ->where('id_departement', Auth::user()->id_departement)
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.name', 'users.prenom_users', 'users.id','roles.name as role')
            ->get();

        $charger_etude = "<option value=''> Selectionnez un chargé d'étude </option>";
        foreach ($charger_etudes as $comp) {
            $charger_etude .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users).' ['.mb_strtoupper($comp->role).'] '." </option>";
        }
        $cahiers = Cahier::Join('projet_etude','cahier.id_demande','projet_etude.id_projet_etude')
            ->join('entreprises','projet_etude.id_entreprises','=','entreprises.id_entreprises')
            ->join('users','projet_etude.id_charge_etude','=','users.id')
            ->where([['id_comite_pleniere','=',$comitepleniere->id_comite_pleniere]])->get();
        $projet_etudes = ProjetEtude::where('flag_soumis_ct_pleniere',true)
            ->where('flag_valider_ct_pleniere_projet_etude',false)
            ->get();

        return view('projetetudes.comite_technique.edit', compact('projet_etudes','charger_etude','idetape','comitepleniere','comitepleniereparticipant','cahiers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        if ($request->isMethod('put')) {
            $data = $request->all();
            if ($data['action'] == 'Modifier' || $data['action'] == 'Suivant'){

                $this->validate($request, [
                    'date_debut_comite_pleniere' => 'required',
                    'date_fin_comite_pleniere' => 'required',
                    'commentaire_comite_pleniere' => 'required'
                ],[
                    'date_debut_comite_pleniere.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_comite_pleniere.required' => 'Veuillez ajouter une date de fin.',
                    'commentaire_comite_pleniere.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $input['id_user_comite_pleniere'] = Auth::user()->id;
                $comitepleniere = ComitePleniere::find($id);
                $comitepleniere->update($input);
                if($data['action'] == 'Modifier'){
                    return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Information mise a jour réussi ');
                }
                if($data['action'] == 'Suivant'){
                    return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Information mise a jour réussi ');
                }
            }
            if ($data['action'] == 'Enregistrer_charger_etude_pour_comite'){

                $this->validate($request, [
                    'id_user_comite_pleniere_participant' => 'required'
                ],[
                    'id_user_comite_pleniere_participant.required' => 'Veuillez selectionnez le conseiller.'
                ]);

                $input = $request->all();
                $input['id_comite_pleniere'] = $id;
                $input['flag_comite_pleniere_participant'] = true;

                $verifconseillerexist = ComitePleniereParticipant::where([['id_comite_pleniere','=',$id],['id_user_comite_pleniere_participant','=',$input['id_user_comite_pleniere_participant']]])->get();

                if(count($verifconseillerexist) >= 1){
                    return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Erreur : Cet conseiller existe deja dans cette comite plénière ');
                }

                $comitesave = ComitePleniereParticipant::create($input);

                $usernotifie = User::where('id',$comitesave->id_user_comite_pleniere_participant)->first();

                $comiteencours = ComitePleniere::find($id);

                $logo = Menu::get_logo();

                if (isset($usernotifie->email)) {
                    $nom_prenom = $usernotifie->name .' '. $usernotifie->prenom_users;
                    $sujet = "Tenue de comite plénière";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher, $nom_prenom  ,</b>
                                    <br><br>Vous êtes conviés au comité technique des projets d'étude qui se déroulera du  ".$comiteencours->date_debut_comite_pleniere." au ".$comiteencours->date_fin_comite_pleniere.".

                                    <br><br> Vous êtes priés de bien vouloir  prendre connaissance des projets d'étude.
                                    <br>

                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($usernotifie->email, $nom_prenom, $messageMail, $sujet, $titre);
                }



                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Information mise à jour');
            }

            if ($data['action'] == 'Traiter_cahier_projet'){
                $comitepleniere = ComitePleniere::find($id);
                $comitepleniere->update(['flag_statut_comite_pleniere'=> true]);
                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succès : Information mise à jour');
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

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);
        $comitepleniereParticipant = ComitePleniereParticipant::find($idVal);
        $idcomiteplenier = $comitepleniereParticipant->id_comite_pleniere;
        ComitePleniereParticipant::where('id_comite_pleniere_participant',$idVal)->delete();
        return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($idcomiteplenier).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Le chargé d\'étude a été rétiré du comite avec succes ');
    }

    public function editer($id,$id2,$id3)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idcomite = Crypt::UrldeCrypt($id2);
        $id_etape = Crypt::UrldeCrypt($id3);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if(isset($id)){
            $projet_etude = ProjetEtude::find($id);
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

                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
                foreach ($secteuractivite_projets as $comp) {
                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
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


                return view('projetetudes.comite_technique.editer',
                compact('id_etape','pay','pieces_projets','avant_projet_tdr',
                    'courier_demande_fin',
                    'offre_technique',
                    'projet_etude',
                    'idcomite',
                    'secteuractivite_projet',
                    'motifs',
                    'formjuridique',
                    'offre_financiere',
                    'secteuractivite'));

        }

        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function cahierupdate(Request $request, $id, $id2, $id3)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);
        $id3 =  Crypt::UrldeCrypt($id3);

        if ($request->isMethod('put')) {
            $projet_etude = ProjetEtude::find($id);

            if($request->action === 'Modifier'){

                $projet_etude->titre_projet_instruction = $request->titre_projet_instruction;
                $projet_etude->contexte_probleme_instruction = $request->contexte_probleme_instruction;
                $projet_etude->objectif_general_instruction = $request->objectif_general_instruction;
                $projet_etude->objectif_specifique_instruction = $request->objectif_specifique_instruction;
                $projet_etude->resultat_attendus_instruction = $request->resultat_attendu_instruction;
                $projet_etude->champ_etude_instruction = $request->champ_etude_instruction;
                $projet_etude->cible_instruction = $request->cible_instruction;
                $projet_etude->methodologie_instruction = $request->methodologie_instruction;
                $projet_etude->montant_projet_instruction = str_replace(' ', '', $request->montant_projet_instruction);
                if (isset($request->fichier_instruction)){
                    $filefront = $request->fichier_instruction;
                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){
                        $fileName1 = 'fichier_instruction'. '_' . rand(111,99999) . '_' . 'fichier_instruction' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces_projet/fichier_instruction/'), $fileName1);
                        $projet_etude->piece_jointe_instruction = $fileName1;
                    }else{
                        return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('error', 'Veuillez changer le type de fichier de l\'instruction');
                    }
                }
                $projet_etude->update();
                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt(4).'/editer')->with('success', 'Succès : Projet d\'étude modifié avec succès ');

            }

            if($request->action === 'Traiter_valider_projet'){

                $projet_etude->flag_valider_ct_pleniere_projet_etude = true;
                $projet_etude->date_valider_ct_pleniere_projet_etude = now();
                $projet_etude->id_processus = 8;

                Cahier::create([
                    'id_demande' => $id,
                    'id_comite_pleniere' => $id2,
                    'id_user_cahier' => Auth::user()->id,
                    'flag_cahier'=> true
                ]);

                $projet_etude->id_processus = 8;
                $projet_etude->update();

                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/edit')->with('success', 'Succès : Le projet d\'étude a été validé');
            }
        }
    }
}
