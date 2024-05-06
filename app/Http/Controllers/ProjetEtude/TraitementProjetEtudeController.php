<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\DomaineFormation;
use App\Models\Entreprises;
use App\Models\FormeJuridique;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\StatutOperation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TraitementProjetEtudeController extends Controller
{
    //
    public function index()
    {
        $role_code = Menu::get_code_menu_profil(Auth::user()->id);
        if($role_code === "CHARGEETUDE"){
            $projet_etudes = ProjetEtude::where('id_charge_etude','=',Auth::user()->id)
                                ->where('flag_soumis','=',true)
                                ->where('flag_soumis_ct_pleniere','=',false)->get();
        }else{
            $projet_etudes = ProjetEtude::all();
        }
        return view('projetetudes.traitement.index',compact('projet_etudes'));
    }

    public function edit($id,$id_etape)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id_etape =  Crypt::UrldeCrypt($id_etape);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();
        if(isset($id)){
            $projet_etude = ProjetEtude::find($id);
            if(isset($projet_etude)){
                $formjuridique = "<option value='".@$projet_etude->entreprise->formeJuridique->id_forme_juridique."'> " . @$projet_etude->entreprise->formeJuridique->libelle_forme_juridique . "</option>";
                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                }
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
                $motif = Motif::where('code_motif','=','PRE')->get();;

                if(isset($projet_etude->motif)){
                    $motifs = "<option value='".$projet_etude->motif->id_motif."'> " . $projet_etude->motif->libelle_motif . "</option>";
                }else{
                    $motifs = "<option value=''> Selectionnez un motif </option>";
                }
                foreach ($motif as $comp) {
                    $motifs .= "<option value='" . $comp->id_motif  . "' >" . $comp->libelle_motif ." </option>";
                }

                $statutinstruction = StatutOperation::where([['code_statut_operation','=','PRI']])->get();;
                $statutinst = "<option value=''> Selectionnez un statut </option>";
                foreach ($statutinstruction as $comp) {
                    $statutinst .= "<option value='" . $comp->id_statut_operation  . "'>" . $comp->libelle_statut_operation ." </option>";
                }

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

                $domaine_projets = DomaineFormation::where('flag_domaine_formation', '=', true)
                    ->orderBy('libelle_domaine_formation')
                    ->get();

                $domaine_projet = "<option value='".$projet_etude->DomaineProjetEtude->id_domaine_formation."'> " . $projet_etude->DomaineProjetEtude->libelle_domaine_formation . "</option>";
                foreach ($domaine_projets as $comp) {
                    $domaine_projet .= "<option value='" . $comp->id_domaine_formation."'>" . mb_strtoupper($comp->libelle_domaine_formation) . " </option>";
                }

                return view('projetetudes.traitement.edit', compact(
                    'domaine_projets',
                    'formjuridique',

                'statutinst','motifs','id_etape','avant_projet_tdr','courier_demande_fin','offre_technique','offre_financiere','pieces_projets','projet_etude','infoentreprise','pay','secteuractivites'));
            }
        }
    }

    public function update(Request $request, $id)
    {

        $id =  Crypt::UrldeCrypt($id);
        if(isset($id)){
            if ($request->isMethod('put')) {
                $projet_etude = ProjetEtude::find($id);
                if($request->action === 'Recevable'){
                    $this->validate($request, [
                        'id_motif_recevable' => 'required'
                    ],[
                        'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                    ]);
                    if(isset($projet_etude)){
                        $projet_etude->id_motif_recevable = $request->id_motif_recevable;
                        $projet_etude->commentaires_recevabilite = $request->commentaires_recevabilite;
                        $projet_etude->date_recevabilite_projet_etude = now();
                        $projet_etude->flag_recevablite_projet_etude = true;
                        $projet_etude->num_agce = Auth::user()->num_agce;
                        $projet_etude->update();

                        $entreprise  = Entreprises::find($projet_etude->id_entreprises);
                        $user = User::where('login_users','=',$entreprise->ncc_entreprises)->first();
                        $logo = Menu::get_logo();

                        if (isset($user->email)) {
                            $sujet = "Recevabilité du projet d'étude sur e-FDFP";
                            $titre = "Bienvenue sur ".@$logo->mot_cle;
                            $messageMail = "<b>Cher,  ".$entreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous avons examiné votre projet d'étude sur e-FDFP, et il a été
                                   approuvé avec succès.

                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                            $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $entreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
                        }else{}

                        return redirect('traitementprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succès : Information mise à jour');
                    }
                }

//                if($request->action === 'MettreEnAttente'){
//                    if(isset($projet_etude)){
//                        $projet_etude->flag_attente_rec = true;
//                        $projet_etude->id_motif_recevable = $request->id_motif_recevable;
//                        $projet_etude->date_mis_en_attente = now();
//                        $projet_etude->commentaires_recevabilite = $request->commentaires_recevabilite;
//                        $projet_etude->num_agce = Auth::user()->num_agce;
//                        $projet_etude->update();
//
//                        $entreprise  = Entreprises::find($projet_etude->id_entreprises);
//                        $user = User::where('login_users','=',$entreprise->ncc_entreprises)->first();
//                        $logo = Menu::get_logo();
//
//                        if (isset($user->email)) {
//                            $sujet = "Recevabilité du projet d'étude sur e-FDFP";
//                            $titre = "Bienvenue sur ".@$logo->mot_cle;
//                            $messageMail = "<b>Cher,  ".$entreprise->raison_social_entreprises." ,</b>
//                                    <br><br>Nous avons examiné votre projet d'étude sur e-FDFP, et il a été
//                                   mis en attente nous vous prions de bien vouloir patienter.
//                                    <br><br><br>
//                                    -----
//                                    Ceci est un mail automatique, Merci de ne pas y répondre.
//                                    -----
//                                    ";
//                            $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $entreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
//
//                        }else{
//
//                        }
//                        return redirect()->route('traitementprojetetude.index')->with('success', 'Projet d\'étude mis en attente avec succès.');
//
//                    }
//                }

                if($request->action === 'NonRecevable'){
                    $this->validate($request, [
                        'id_motif_recevable' => 'required',
                        'commentaires_recevabilite' => 'required'
                    ],[
                        'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                        'commentaires_recevabilite.required' => 'Veuillez ajouter un commentaire de recevabilité.',
                    ]);

                    if(isset($projet_etude)){
                        $projet_etude->commentaires_recevabilite = $request->commentaires_recevabilite;
                        $projet_etude->date_recevabilite_projet_etude = now();
                        $projet_etude->flag_recevablite_projet_etude = true;
                        $projet_etude->date_rejet = now();
                        $projet_etude->flag_rejet = true;
                        $projet_etude->num_agce = Auth::user()->num_agce;
                        $projet_etude->update();

                        $entreprise  = Entreprises::find($projet_etude->id_entreprises);
                        $user = User::where('login_users','=',$entreprise->ncc_entreprises)->first();
                        $logo = Menu::get_logo();

                        if (isset($user->email)) {
                            $sujet = "Recevabilité du projet d'étude sur e-FDFP";
                            $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                            $messageMail = "<b>Cher,  ".$entreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous avons examiné votre projet d'étude sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

                                    <br><b>Motif de rejet  : </b> ".@$projet_etude->motif->libelle_motif."
                                    <br><b>Commentaire : </b> ".@$projet_etude->commentaires_recevabilite."
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                            $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $entreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

                        }else{}

                        return redirect()->route('traitementprojetetude.index')->with('success', 'Recevabilité effectué avec succès.');

                    }
                }
                if($request->action === 'EnregistrerInstruction') {
                    if (isset($projet_etude)) {
                        $this->validate($request, [
                            'titre_projet_instruction' => 'required',
                            'contexte_probleme_instruction' => 'required',
                            'objectif_general_instruction' => 'required',
                            'objectif_specifique_instruction' => 'required',
                            'resultat_attendu_instruction' => 'required',
                            'champ_etude_instruction' => 'required',
                            'cible_instruction' => 'required',
                            'methodologie_instruction' => 'required',
                            'lieu_realisation_projet_instruction' => 'required',
                            'date_previsionnelle_demarrage_projet_instruction' => 'required',
                            'montant_projet_instruction' => 'required',
                            'id_domaine_projet_instruction' => 'required|exists:domaine_formation,id_domaine_formation',
                        ],
                            [
                            'titre_projet_instruction.required' => 'veuillez ajouter un titre',
                            'contexte_probleme_instruction.required' => 'veuillez ajouter le contexte ou problème constaté',
                            'objectif_general_instruction.required' => 'veuillez ajouter l\'objectif Général',
                            'objectif_specifique_instruction.required' => 'veuillez ajouter les objectifs spécifiques',
                            'resultat_attendu_instruction.required' => 'veuillez ajouter les résultats attendus',
                            'champ_etude_instruction.required' => 'veuillez ajouter le champ de l\'étude',
                            'cible_instruction.required' => 'veuillez ajouter la cible',
                            'methodologie_instruction.required' => 'veuillez ajouter la méthodologie',
                            'lieu_realisation_projet_instruction.required' => 'veuillez ajouter le lieu de réaliastion du projet',
                            'date_previsionnelle_demarrage_projet_instruction.required' => 'veuillez ajouter la date prévisionnelle de démarrage du projet',
                            'montant_projet_instruction.required' => 'veuillez ajouter le montant à accorder',
                            'id_domaine_projet_instruction.required' => 'veuillez ajouter le domaine de projet',
                        ]);

                        $projet_etude->flag_enregistrer = true;
                        $projet_etude->date_enregistrer = now();
                        $projet_etude->commentaires_instruction = $request->commentaires_instruction;
                        $projet_etude->titre_projet_instruction = $request->titre_projet_instruction;
                        $projet_etude->contexte_probleme_instruction = $request->contexte_probleme_instruction;
                        $projet_etude->objectif_general_instruction = $request->objectif_general_instruction;
                        $projet_etude->objectif_specifique_instruction = $request->objectif_specifique_instruction;
                        $projet_etude->resultat_attendus_instruction = $request->resultat_attendu_instruction;
                        $projet_etude->champ_etude_instruction = $request->champ_etude_instruction;
                        $projet_etude->cible_instruction = $request->cible_instruction;
                        $projet_etude->commentaires_instruction = $request->commentaires_instruction;
                        $projet_etude->methodologie_instruction = $request->methodologie_instruction;
                        $projet_etude->lieu_realisation_projet_instruction = $request->lieu_realisation_projet_instruction;
                        $projet_etude->date_previsionnelle_demarrage_projet_instruction = $request->date_previsionnelle_demarrage_projet_instruction;
                        $projet_etude->montant_projet_instruction =str_replace(' ', '', $request->montant_projet_instruction);
                        $projet_etude->id_domaine_projet_instruction = $request->id_domaine_projet_instruction;

                        if (isset($request->fichier_instruction)){
                            $filefront = $request->fichier_instruction;
                            if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){
                                $fileName1 = 'fichier_instruction'. '_' . rand(111,99999) . '_' . 'fichier_instruction' . '_' . time() . '.' . $filefront->extension();
                                $filefront->move(public_path('pieces_projet/fichier_instruction/'), $fileName1);
                                $projet_etude->piece_jointe_instruction = $fileName1;
                            }else{
                                return redirect('traitementprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('error', 'Veuillez changer le type de fichier de l\'instruction');
                            }
                        }
                        $projet_etude->update();
                        return redirect('traitementprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Projet d\'étude enregistrer avec succès');
                    }
                }

                if($request->action === 'SoumettreCT'){
                    if(isset($projet_etude)){
                        $this->validate($request, [
                            'titre_projet_instruction' => 'required',
                            'contexte_probleme_instruction' => 'required',
                            'objectif_general_instruction' => 'required',
                            'objectif_specifique_instruction' => 'required',
                            'resultat_attendu_instruction' => 'required',
                            'champ_etude_instruction' => 'required',
                            'cible_instruction' => 'required',
                            'methodologie_instruction' => 'required',
                            'lieu_realisation_projet_instruction' => 'required',
                            'date_previsionnelle_demarrage_projet_instruction' => 'required',
                            'montant_projet_instruction' => 'required',
                            'id_domaine_projet_instruction' => 'required|exists:domaine_formation,id_domaine_formation',
                        ],
                            [
                                'titre_projet_instruction.required' => 'veuillez ajouter un titre',
                                'contexte_probleme_instruction.required' => 'veuillez ajouter le contexte ou problème constaté',
                                'objectif_general_instruction.required' => 'veuillez ajouter l\'objectif Général',
                                'objectif_specifique_instruction.required' => 'veuillez ajouter les objectifs spécifiques',
                                'resultat_attendu_instruction.required' => 'veuillez ajouter les résultats attendus',
                                'champ_etude_instruction.required' => 'veuillez ajouter le champ de l\'étude',
                                'cible_instruction.required' => 'veuillez ajouter la cible',
                                'methodologie_instruction.required' => 'veuillez ajouter la méthodologie',
                                'lieu_realisation_projet_instruction.required' => 'veuillez ajouter le lieu de réaliastion du projet',
                                'date_previsionnelle_demarrage_projet_instruction.required' => 'veuillez ajouter la date prévisionnelle de démarrage du projet',
                                'montant_projet_instruction.required' => 'veuillez ajouter le montant à accorder',
                                'id_domaine_projet_instruction.required' => 'veuillez ajouter le domaine de projet',
                            ]);

                        $projet_etude->statut_instruction = true;
                        $projet_etude->flag_soumis_ct_pleniere = true;
                        $projet_etude->date_instruction = now();
                        $projet_etude->commentaires_instruction = $request->commentaires_instruction;
                        $projet_etude->titre_projet_instruction = $request->titre_projet_instruction;
                        $projet_etude->contexte_probleme_instruction = $request->contexte_probleme_instruction;
                        $projet_etude->objectif_general_instruction = $request->objectif_general_instruction;
                        $projet_etude->objectif_specifique_instruction = $request->objectif_specifique_instruction;
                        $projet_etude->resultat_attendus_instruction = $request->resultat_attendu_instruction;
                        $projet_etude->champ_etude_instruction = $request->champ_etude_instruction;
                        $projet_etude->cible_instruction = $request->cible_instruction;
                        $projet_etude->methodologie_instruction = $request->methodologie_instruction;
                        $projet_etude->lieu_realisation_projet_instruction = $request->lieu_realisation_projet_instruction;
                        $projet_etude->date_previsionnelle_demarrage_projet_instruction = $request->date_previsionnelle_demarrage_projet_instruction;
                        $projet_etude->montant_projet_instruction =str_replace(' ', '', $request->montant_projet_instruction);
                        $projet_etude->id_domaine_projet_instruction = $request->id_domaine_projet_instruction;

                        if (isset($request->fichier_instruction)){
                            $filefront = $request->fichier_instruction;
                            if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){
                                $fileName1 = 'fichier_instruction'. '_' . rand(111,99999) . '_' . 'fichier_instruction' . '_' . time() . '.' . $filefront->extension();
                                $filefront->move(public_path('pieces_projet/fichier_instruction/'), $fileName1);
                                $projet_etude->piece_jointe_instruction = $fileName1;
                            }else{
                                return redirect('projetetudes.traitement/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('error', 'Veuillez changer le type de fichier de l\'instruction');
                            }
                        }
                        $projet_etude->update();

                        $entreprise  = Entreprises::find($projet_etude->id_entreprises);
                        $user = User::where('login_users','=',$entreprise->ncc_entreprises)->first();
                        $logo = Menu::get_logo();

                        if (isset($user->email)) {
                            $sujet = "Instruction du projet d'étude sur e-FDFP";
                            $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                            $messageMail = "<b>Cher,  ".$entreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous avons examiné votre dossier du projet d'étude sur e-FDFP, et
                                    il a été validé avec succès.
                                    <br><br>
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                            $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $entreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
                        }else{}

                        return redirect()->route('traitementprojetetude.index')->with('success', 'Projet d\'étude soumis avec succès.');
                    }
                }

                if($request->action === 'RejetInstruction'){
                    if(isset($projet_etude)){
                        $this->validate($request, [
                            'titre_projet_instruction' => 'required',
                            'contexte_probleme_instruction' => 'required',
                            'objectif_general_instruction' => 'required',
                            'objectif_specifique_instruction' => 'required',
                            'resultat_attendu_instruction' => 'required',
                            'champ_etude_instruction' => 'required',
                            'cible_instruction' => 'required',
                            'methodologie_instruction' => 'required',
                            'lieu_realisation_projet_instruction' => 'required',
                            'date_previsionnelle_demarrage_projet_instruction' => 'required',
                            'montant_projet_instruction' => 'required',
                            'commentaires_instruction' => 'required',
                            'id_domaine_projet_instruction' => 'required|exists:domaine_formation,id_domaine_formation|mimes:PNG,png,PDF,pdf,JPG,jpg,jpeg,JPEG'
                        ],
                            [
                                'titre_projet_instruction.required' => 'veuillez ajouter un titre',
                                'contexte_probleme_instruction.required' => 'veuillez ajouter le contexte ou problème constaté',
                                'objectif_general_instruction.required' => 'veuillez ajouter l\'objectif Général',
                                'objectif_specifique_instruction.required' => 'veuillez ajouter les objectifs spécifiques',
                                'resultat_attendu_instruction.required' => 'veuillez ajouter les résultats attendus',
                                'champ_etude_instruction.required' => 'veuillez ajouter le champ de l\'étude',
                                'cible_instruction.required' => 'veuillez ajouter la cible',
                                'methodologie_instruction.required' => 'veuillez ajouter la méthodologie',
                                'lieu_realisation_projet_instruction.required' => 'veuillez ajouter le lieu de réaliastion du projet',
                                'date_previsionnelle_demarrage_projet_instruction.required' => 'veuillez ajouter la date prévisionnelle de démarrage du projet',
                                'montant_projet_instruction.required' => 'veuillez ajouter le montant à accorder',
                                'id_domaine_projet_instruction.required' => 'veuillez ajouter le domaine de projet',
                                'commentaires_instruction.required' => 'veuillez ajoiuter le commentaire',

                            ]);

                        if (isset($request->fichier_instruction)){
                            $filefront = $request->fichier_instruction;
                            $fileName1 = 'fichier_instruction'. '_' . rand(111,99999) . '_' . 'fichier_instruction' . '_' . time() . '.' . $filefront->extension();
                            $filefront->move(public_path('pieces_projet/fichier_instruction/'), $fileName1);
                            $projet_etude->piece_jointe_instruction = $fileName1;
                        }
                        $projet_etude->statut_instruction = false;
                        $projet_etude->flag_soumis_ct_pleniere = false;
                        $projet_etude->date_instruction = now();
                        $projet_etude->commentaires_instruction = $request->commentaires_instruction;
                        $projet_etude->titre_projet_instruction = $request->titre_projet_instruction;
                        $projet_etude->contexte_probleme_instruction = $request->contexte_probleme_instruction;
                        $projet_etude->objectif_general_instruction = $request->objectif_general_instruction;
                        $projet_etude->objectif_specifique_instruction = $request->objectif_specifique_instruction;
                        $projet_etude->resultat_attendus_instruction = $request->resultat_attendu_instruction;
                        $projet_etude->champ_etude_instruction = $request->champ_etude_instruction;
                        $projet_etude->cible_instruction = $request->cible_instruction;
                        $projet_etude->methodologie_instruction = $request->methodologie_instruction;
                        $projet_etude->montant_projet_instruction =str_replace(' ', '', $request->montant_projet_instruction);

                        $projet_etude->update();

                        $entreprise  = Entreprises::find($projet_etude->id_entreprises);
                        $user = User::where('login_users','=',$entreprise->ncc_entreprises)->first();
                        $logo = Menu::get_logo();

                        if (isset($user->email)) {
                            $sujet = "Instruction du projet d'étude sur e-FDFP";
                            $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                            $messageMail = "<b>Cher,  ".$entreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous avons examiné votre paln de formation sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :
                                    <br><b>Commentaire : </b> ".@$projet_etude->commentaire_recevable_plan_formation."
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
                            $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $entreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
                        }else{}

                        return redirect()->route('projetetudes.traitement.index')->with('success', 'Rejet de l\'instruction effectue avec succès.');
                    }
                }
            }
        }
    }

    public function editPieceSelect($id){
        if(isset($id)){
            $piece_edit= PiecesProjetEtude::where('id_pieces_projet_etude',$id)->first();
            if(isset($piece_edit)){
                if($piece_edit->code_pieces=='avant_projet_tdr'){
                    $type_piece = "Avant-projet TDR";
                }

                if($piece_edit->code_pieces=='courier_demande_fin'){
                    $type_piece = "Courrier de demande de financement";
                }

                if($piece_edit->code_pieces=='offre_technique'){
                    $type_piece = "Offre technique";
                }

                if($piece_edit->code_pieces=='offre_financiere'){
                    $type_piece = "Offre financière";
                }

                if($piece_edit->code_pieces=='autres_piece'){
                    $type_piece = $piece_edit->intitule_piece;
                }
                return response()->json(['id_pieces_projet_etude'=>$piece_edit->id_pieces_projet_etude,'type_piece'=>$type_piece,'commentaire_piece'=>$piece_edit->commentaire_piece]);
            }
        }
    }

    public function addPieceCommentaire(Request $request){
        $id = $request->id_pieces_projet_etude;
        if(isset($id)){
            $piece_edit= PiecesProjetEtude::where('id_pieces_projet_etude',$id)->first();
            if(isset($piece_edit)){
                $piece_edit->commentaire_piece = $request->commentaire_piece;
                $piece_edit->update();
                $id_projet_etude = $piece_edit->id_projet_etude;
                return redirect('traitementprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Commentaire ajouté à la pièce avec succès');
            }
        }
    }



}
