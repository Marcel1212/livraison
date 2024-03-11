<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\ConseillerParAgence;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\ComitePermanente;
use App\Models\ComitePermanenteParticipant;
use App\Models\Entreprises;
use App\Models\FicheAgrement;
use App\Models\FormeJuridique;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use File;
use Hash;
use Illuminate\Http\Request;
use Image;

class ComitePermanenteProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comite_permanentes = ComitePermanente::where('code_pieces_comite_permanente','PE')->get();
        return view('projetetudes.commission_permanente.index', compact('comite_permanentes'));
    }


    public function create()
    {
        $projetetudes = ProjetEtude::where([['flag_valider_par_processus','=',true],
            ['flag_projet_etude_valider_cahier','=',true],
            ['flag_projet_etude_valider_cahier_soumis_comite_permanente','=',false],
            ['flag_projet_etude_valider_cahier_soumis_comite_permanente','=',true],
            ['flag_fiche_agrement','=',false]])
            ->get();

        return view('projetetudes.commission_permanente.create', compact('projetetudes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'date_debut_comite_permanente' => 'required',
                'date_fin_comite_permanente' => 'required',
                'commentaire_comite_permanente' => 'required'
            ],[
                'date_debut_comite_permanente.required' => 'Veuillez ajouter une date de debut.',
                'date_fin_comite_permanente.required' => 'Veuillez ajouter une date de fin.',
                'commentaire_comite_permanente.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_permanente'] = Auth::user()->id;
            $input['code_comite_permanente'] = 'CP' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces_comite_permanente'] = 'PE';
            $typecomiteinfos = ConseillerParAgence::get_type_comite_projet_etude();
            $input['id_type_comite_comite_permanente'] = intval($typecomiteinfos->id_type_comite);
            ComitePermanente::create($input);
            $insertedId = ComitePermanente::latest()->first()->id_comite_permanente;

            if($input['action']=="Enregistrer"){
                return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Enregistrement réussi ');
            }

            if($input['action']=="Enregistrer_suivant"){
                return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Enregistrement réussi ');
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

        $comitepermanente = ComitePermanente::find($id);

        $comitepermanenteparticipant = ComitePermanenteParticipant::where([['id_comite_permanente','=',$comitepermanente->id_comite_permanente]])->get();

        $ficheagrements = FicheAgrement::Join('projet_etude','fiche_agrement.id_demande','projet_etude.id_projet_etude')
                            ->join('entreprises','projet_etude.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','projet_etude.id_charge_etude','=','users.id')
                            ->where([['id_comite_permanente','=',$comitepermanente->id_comite_permanente]])->get();


        $conseillers = ConseillerParAgence::get_comite_gestion_permanente();

        $conseiller = "<option value=''> Sélectionnez une personne ressource </option>";
        foreach ($conseillers as $comp) {
            $conseiller .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }


        $projetetudes = ProjetEtude::where([['flag_projet_etude_valider_cahier_soumis_comite_permanente','=',true],
                                            ['flag_fiche_agrement','=',false]])
                                            ->get();

        return view('projetetudes.commission_permanente.edit', compact('comitepermanente','comitepermanenteparticipant','ficheagrements','conseiller','projetetudes','idetape'));
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
                    'date_debut_comite_permanente' => 'required',
                    'date_fin_comite_permanente' => 'required',
                    'commentaire_comite_permanente' => 'required'
                ],[
                    'date_debut_comite_permanente.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_comite_permanente.required' => 'Veuillez ajouter une date de fin.',
                    'commentaire_comite_permanente.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $input['id_user_comite_permanente'] = Auth::user()->id;
                $comitepermanente = ComitePermanente::find($id);
                $comitepermanente->update($input);


                return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Information mise à jour ');

            }

            if ($data['action'] == 'Enregistrer_conseil_poour_comite'){

                $this->validate($request, [
                    'id_user_comite_permanente_participant' => 'required'
                ],[
                    'id_user_comite_permanente_participant.required' => 'Veuillez selectionnez le conseiller.'
                ]);

                $input = $request->all();
                $input['id_comite_permanente'] = $id;
                $input['flag_comite_permanente_participant'] = true;

                $verifconseillerexist = ComitePermanenteParticipant::where([['id_comite_permanente','=',$id],['id_user_comite_permanente_participant','=',$input['id_user_comite_permanente_participant']]])->get();

                if(count($verifconseillerexist) >= 1){

                    return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Erreur : Cette personne existe déjà dans ce comite de permanente. ');

                }

                $comitesave = ComitePermanenteParticipant::create($input);
                $usernotifie = User::where('id',$comitesave->id_user_comite_permanente_participant)->first();
                $comiteencours = ComitePermanente::find($id);
                $logo = Menu::get_logo();

                if (isset($usernotifie->email)) {
                    $nom_prenom = $usernotifie->name .' '. $usernotifie->prenom_users;
                    $sujet = "Tenue de comité de permanent";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>Cher, $nom_prenom  ,</b>
                                    <br><br>Vous êtes conviés à la commission permanente des projets d'étude qui se déroulera du  ".$comiteencours->date_debut_comite_gestion." au ".$comiteencours->date_fin_comite_gestion.".

                                    <br><br> Vous êtes priés de bien vouloir  prendre connaissance des projets d'étude.
                                    <br>

                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($usernotifie->email, $nom_prenom, $messageMail, $sujet, $titre);
                }
                return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Information mise à jour');
            }

            if ($data['action'] == 'Traiter_cahier_projet'){

                $comitepermanente = ComitePermanente::find($id);
                $comitepermanente->update(['flag_statut_comite_permanente'=> true]);

                return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succès : Information mise à jour');

            }

        }
    }

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $comitepermanenteParticipant = ComitePermanenteParticipant::find($idVal);
        $idcomitepermanente = $comitepermanenteParticipant->id_comite_permanente;
        ComitePermanenteParticipant::where([['id_comite_permanente_participant','=',$idVal]])->delete();
        return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($idcomitepermanente).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : La personne a été supprimée du comite avec succès ');
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

                $infoentreprise = Entreprises::find($projet_etude->id_entreprises)->first();

                $pays = Pays::all();
                $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
                foreach ($pays as $comp) {
                    $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }


                $formjuridique = "<option value='".$infoentreprise->formeJuridique->id_forme_juridique."'> " . $infoentreprise->formeJuridique->libelle_forme_juridique . "</option>";

                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
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


                return view('projetetudes.commission_permanente.editer',
                    compact('id_etape','pay','pieces_projets','avant_projet_tdr',
                        'courier_demande_fin',
                        'offre_technique',
                        'formjuridique',
                        'projet_etude',
                        'idcomite',
                        'secteuractivite_projet',
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
                $projet_etude->flag_valider_comite_permanente_projet_etude = true;
                $projet_etude->montant_projet_instruction = str_replace(' ', '', $request->montant_projet_instruction);
                $projet_etude->update();
                return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($idprojetetude).'/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/editer')->with('success', 'Succès : Projet d\'étude Traité ');
            }

            if($data['action'] === 'Traiter_valider_projet'){

                $idprojetetude = $id;

                FicheAgrement::create([
                    'id_demande' => $idprojetetude,
                    'id_comite_permanente' => $id2,
                    'code_fiche_agrement' => 'PE',
                    'id_user_fiche_agrement' => Auth::user()->id,
                    'flag_fiche_agrement'=> true
                ]);

                $projet_etude = ProjetEtude::find($idprojetetude);
                $projet_etude->update([
                        'flag_fiche_agrement' => true,
                        'date_fiche_agrement' => now()
                    ]);
                //}
                return redirect('comitepermanenteprojetetude/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/edit')->with('success', 'Succès : Le projet a été validé');


            }

        }

    }
}
