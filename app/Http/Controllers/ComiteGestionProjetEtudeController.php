<?php

namespace App\Http\Controllers;

use App\Helpers\ConseillerParAgence;
use App\Helpers\Email;
use App\Helpers\Menu;
use App\Models\ComiteGestion;
use App\Models\ComitePleniere;
use App\Models\ComitePleniereParticipant;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Crypt;
use App\Models\ComiteGestionParticipant;
use App\Models\Entreprises;
use App\Models\FicheAgrement;
use App\Models\Motif;
use App\Models\Pays;

class ComiteGestionProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comite_gestions = ComiteGestion::where('code_pieces_comite_gestion','PE')->get();
        return view('comitegestionprojetetude.index', compact('comite_gestions'));
    }


    public function create()
    {
        $projetetudes = ProjetEtude::where([['flag_valider_par_processus','=',true],
            ['flag_projet_etude_valider_cahier','=',true],
            ['flag_projet_etude_valider_cahier_soumis_comite_gestion','=',true],
            ['flag_projet_etude_valider_cahier_soumis_comite_permanente','=',false],
            ['flag_fiche_agrement','=',false]])
            ->get();

        return view('comitegestionprojetetude.create', compact('projetetudes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'date_debut_comite_gestion' => 'required',
                'date_fin_comite_gestion' => 'required',
                'commentaire_comite_gestion' => 'required'
            ],[
                'date_debut_comite_gestion.required' => 'Veuillez ajouter une date de debut.',
                'date_fin_comite_gestion.required' => 'Veuillez ajouter une date de fin.',
                'commentaire_comite_gestion.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_gestion'] = Auth::user()->id;
            $input['code_comite_gestion'] = 'CGPE' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces_comite_gestion'] = 'PE';
            $typecomiteinfos = ConseillerParAgence::get_type_comite_projet_etude();
            $input['id_type_comite_comite_gestion'] = intval($typecomiteinfos->id_type_comite);
            ComiteGestion::create($input);
            $insertedId = ComiteGestion::latest()->first()->id_comite_gestion;

            if($input['action']=="Enregistrer"){
                return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }

            if($input['action']=="Enregistrer_suivant"){
                return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comitegestion = ComiteGestion::find($id);

        $comitegestionparticipant = ComiteGestionParticipant::where([['id_comite_gestion','=',$comitegestion->id_comite_gestion]])->get();

        $ficheagrements = FicheAgrement::Join('projet_etude','fiche_agrement.id_demande','projet_etude.id_projet_etude')
                            ->join('entreprises','projet_etude.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','projet_etude.id_charge_etude','=','users.id')
                            ->where([['id_comite_gestion','=',$comitegestion->id_comite_gestion]])->get();


        $conseillers = ConseillerParAgence::get_comite_gestion_permanente();

        $conseiller = "<option value=''> Sélectionnez une personne ressource </option>";
        foreach ($conseillers as $comp) {
            $conseiller .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }


        $projetetudes = ProjetEtude::where([['flag_projet_etude_valider_cahier_soumis_comite_gestion','=',true],
                                            ['flag_fiche_agrement','=',false]])
                                            ->get();

        return view('comitegestionprojetetude.edit', compact('comitegestion','comitegestionparticipant','ficheagrements','conseiller','projetetudes','idetape'));
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

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'date_debut_comite_gestion' => 'required',
                    'date_fin_comite_gestion' => 'required',
                    'commentaire_comite_gestion' => 'required'
                ],[
                    'date_debut_comite_gestion.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_comite_gestion.required' => 'Veuillez ajouter une date de fin.',
                    'commentaire_comite_gestion.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $input['id_user_comite_gestion'] = Auth::user()->id;
                $comitegestion = ComiteGestion::find($id);
                $comitegestion->update($input);

                return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Enregistrer_conseil_poour_comite'){

                $this->validate($request, [
                    'id_user_comite_gestion_participant' => 'required'
                ],[
                    'id_user_comite_gestion_participant.required' => 'Veuillez selectionnez le conseiller.'
                ]);

                $input = $request->all();
                $input['id_comite_gestion'] = $id;
                $input['flag_comite_gestion_participant'] = true;

                $verifconseillerexist = ComiteGestionParticipant::where([['id_comite_gestion','=',$id],['id_user_comite_gestion_participant','=',$input['id_user_comite_gestion_participant']]])->get();

                if(count($verifconseillerexist) >= 1){
                    return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Erreur : Cette personne existe déjà dans ce comite de gestion. ');
                }

                $comitesave = ComiteGestionParticipant::create($input);
                $usernotifie = User::where('id',$comitesave->id_user_comite_gestion_participant)->first();
                $comiteencours = ComiteGestion::find($id);
                $logo = Menu::get_logo();

                if (isset($usernotifie->email)) {
                    $nom_prenom = $usernotifie->name .' '. $usernotifie->prenom_users;
                    $sujet = "Tenue de comité de gestion";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher, $nom_prenom  ,</b>
                                    <br><br>Vous êtes convié au comité de gestion des projets d'étude qui se déroulera du  ".$comiteencours->date_debut_comite_gestion." au ".$comiteencours->date_fin_comite_gestion.".

                                    <br><br> Vous êtes prié de bien vouloir  prendre connaissance des projets d'étude.
                                    <br>

                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($usernotifie->email, $nom_prenom, $messageMail, $sujet, $titre);
                }
                return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
            }

            if ($data['action'] == 'Traiter_cahier_projet'){

                $comitegestion = ComiteGestion::find($id);
                $comitegestion->update(['flag_statut_comite_gestion'=> true]);

                return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

        }
    }

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $comitegestionParticipant = ComiteGestionParticipant::find($idVal);
        $idcomitegestion = $comitegestionParticipant->id_comite_gestion;
        ComiteGestionParticipant::where([['id_comite_gestion_participant','=',$idVal]])->delete();
        return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($idcomitegestion).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : La personne a été supprimée du comite avec succès ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function editer($id,$id2,$id3)
    {

        $id =  Crypt::UrldeCrypt($id);
        $idcomite = Crypt::UrldeCrypt($id2);
        $id_etape = Crypt::UrldeCrypt($id3);
        if(isset($id)){
            $projet_etude = ProjetEtude::find($id);
            if(isset($projet_etude)){
                $pieces_projets= PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)->get();
                $avant_projet_tdr = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','avant_projet_tdr')->first();
                $courier_demande_fin = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','courier_demande_fin')->first();
                $dossier_intention = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','dossier_intention')->first();
                $lettre_engagement = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','lettre_engagement')->first();
                $offre_technique = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_technique')->first();
                $offre_financiere = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_financiere')->first();

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

                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
                foreach ($secteuractivite_projets as $comp) {
                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }



                return view('comitegestionprojetetude.editer',
                    compact('id_etape','pay','pieces_projets','avant_projet_tdr',
                        'courier_demande_fin',
                        'dossier_intention',
                        'lettre_engagement',
                        'offre_technique',
                        'secteuractivite_projet',
                        'projet_etude',
                        'idcomite',
                        'motifs',
                        'offre_financiere',
                        'secteuractivite'));

            }

        }

    }

    public function agrementupdate(Request $request, $id, $id2, $id3)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);
        $id3 =  Crypt::UrldeCrypt($id3);
       // dd($request->all());
       if ($request->isMethod('put')) {

            $data = $request->all();

        //dd($data);

            if($data['action'] === 'Modifier'){
                $projet_etude = ProjetEtude::find($id);
                $idprojetetude = $projet_etude->id_projet_etude;
                $projet_etude->flag_valider_comite_gestion_projet_etude = true;
                $input = $request->all();
                $projet_etude->update($input);
                return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($idprojetetude).'/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/editer')->with('success', 'Succes : Projet d\'étude Traité ');
            }

            if($data['action'] === 'Traiter_valider_projet'){

                $idprojetetude = $id;

                FicheAgrement::create([
                    'id_demande' => $idprojetetude,
                    'id_comite_gestion' => $id2,
                    'id_user_fiche_agrement' => Auth::user()->id,
                    'flag_fiche_agrement'=> true
                ]);
                    $projet_etude = ProjetEtude::find($idprojetetude);

                $projet_etude->update([
                        'flag_fiche_agrement' => true,
                        'date_fiche_agrement' => Carbon::now()
                    ]);
                //}
                return redirect('comitegestionprojetetude/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/edit')->with('success', 'Succes : Le projet a été validé');


            }

        }

    }
}
