<?php

namespace App\Http\Controllers\ProjetEtude;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\Entreprises;
use App\Models\FormeJuridique;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SelectionOperateurProjetEtudeController extends Controller{
    public function index(){
        $projet_etude_valides = ProjetEtude::where('flag_fiche_agrement',true)
            ->where('flag_soumis_selection_operateur','false')
            ->orWhere('flag_selection_operateur_valider_par_processus','true')->get();
        return view('projetetudes.selection_operateur.index', compact('projet_etude_valides'));
    }

    public function edit($id_projet_etude,$idetape){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $idetape = Crypt::UrldeCrypt($idetape);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if(isset($id_projet_etude)){
            $projet_etude = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();

            if(isset($projet_etude)){
                $user = User::find($projet_etude->id_user);
                $entreprise_mail = $user->email;
                $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);

                $operateur_selecteds = Entreprises::whereNotExists(function ($query) use ($id_projet_etude){
                    $query->select('*')
                        ->from('projet_etude_has_entreprises')
                        ->whereColumn('projet_etude_has_entreprises.id_entreprises','=','entreprises.id_entreprises')
                        ->where('projet_etude_has_entreprises.id_projet_etude',$id_projet_etude);
                })->where('flag_operateur',true)
                    ->where('flag_actif_entreprises',true)

                  ->where('id_secteur_activite_entreprise',$projet_etude->id_secteur_activite)
                  ->get();

                $operateur_selected = "<option value=''> Selectionnez un opérateur </option>";
                foreach ($operateur_selecteds as $operateur) {
                    $operateur_selected .= "<option value='" .$operateur->id_entreprises. "'>" . mb_strtoupper($operateur->raison_social_entreprises) . " </option>";
                }

                $operateur_validers = Entreprises::whereExists(function ($query) use ($id_projet_etude){
                    $query->select('*')
                        ->from('projet_etude_has_entreprises')
                        ->whereColumn('projet_etude_has_entreprises.id_entreprises','=','entreprises.id_entreprises')
                        ->where('projet_etude_has_entreprises.id_projet_etude',$id_projet_etude);
                })->where('flag_operateur',true)->where('flag_actif_entreprises',true)
                    ->where('id_secteur_activite_entreprise',$projet_etude->id_secteur_activite)
                    ->get();


                $operateur_valider = "<option value=''> Selectionnez un opérateur </option>";

                foreach ($operateur_validers as $op) {
                    $operateur_valider .= "<option value='" .$op->id_entreprises. "'>" . mb_strtoupper($op->raison_social_entreprises) . " </option>";
                }

                $pieces_projets = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)->get();

                $pays = Pays::all();
                $pay = "<option value='".$entreprise->pay->id_pays."'> " . $entreprise->pay->indicatif . "</option>";
                foreach ($pays as $comp) {
                    $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }

                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $payss = Pays::all();
                $paysc = "<option value=''> ---Selectionnez un pays--- </option>";
                foreach ($payss as $comp) {
                    $paysc .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }

                $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
                foreach ($secteuractivite_projets as $comp) {
                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }
                $formjuridique = "<option value='".$entreprise->formeJuridique->id_forme_juridique."'> " . $entreprise->formeJuridique->libelle_forme_juridique . "</option>";

                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                }

                return view('projetetudes.selection_operateur.edit', compact('idetape','paysc',
                    'formjuridique','operateur_valider','operateur_selected','pay','secteuractivite_projet','pieces_projets','entreprise','entreprise_mail','projet_etude'));
            }else{

            }
        }else{

        }
    }

    public function update(Request $request,$id_projet_etude){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                if($request->action=="Enregistrer_selection"){
                    $projet_etude_valide->operateurs()->attach($request->operateur);
                    $projet_etude_valide->flag_soumis_selection_operateur = false;
                    $projet_etude_valide->flag_selection_operateur_valider_par_processus = false;
                    $projet_etude_valide->update();
                }

                if($request->action=="Enregistrer_soumettre_selection"){
                    $logo = Menu::get_logo();
                    $operateurs = $projet_etude_valide->operateurs()->get();
                    if(isset($operateurs)){
                        foreach ($operateurs as $operateur){
                            $entreprise = Entreprises::where('id_entreprises',$operateur->id_entreprises)->first();
                            $name = $entreprise->raison_social_entreprises;
                            $user = User::where('id_partenaire',$entreprise->id_entreprises)->first();

                            if (isset($user->email)) {
                                $sujet = "Sélection opérateur";
                                $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                                $messageMail = "<b>Cher, $name  ,</b>
                                    <br><br>Vous avez été retenu pour le projet d'étude intitulé : ".$projet_etude_valide->titre_projet_instruction.".

                                    <br><br>Nous vous prions de bien vouloir vous rendre au siège de FDFP afin de recupérer le dossier d'appel d'offre dudit projet.
                                    <br>

                                    <br><br><br>
                                    -----

                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                                $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $name, $messageMail, $sujet, $titre);
                            }
                        }
                    }

                    $projet_etude_valide->id_processus_selection = 7;
                    $projet_etude_valide->flag_soumis_selection_operateur = true;
                    $projet_etude_valide->date_soumis_selection_operateur = now();
                    $projet_etude_valide->update();
                }
                return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(4).'/edit')->with('success','Succès: Sélection effectuée');
            }else{

            }
        }else{

        }
    }

    public function mark(Request $request,$id_projet_etude){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $logo = Menu::get_logo();

        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                if($request->action=='Enregistrer_selection'){
                    $projet_etude_valide->id_operateur_selection = $request->operateur;
                    $projet_etude_valide->update();
                }

                if($request->action=='Valider_selection'){
                    $projet_etude_valide->flag_validation_selection_operateur = true;
                    $projet_etude_valide->date_validation_selection_operateur = now();
                    $projet_etude_valide->update();

                    $entreprise = Entreprises::where('id_entreprises',$projet_etude_valide->id_operateur_selection)->first();
                    $name = $entreprise->raison_social_entreprises;
                    $user = User::where('id_partenaire',$entreprise->id_entreprises)->first();

                    if (isset($user->email)) {
                        $sujet = "Sélection opérateur";
                        $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                        $messageMail = "<b>Cher, $name  ,</b>
                                    <br><br>Vous avez été retenu pour l'exécution du projet d'étude intitulé : ".$projet_etude_valide->titre_projet_instruction.".
                                    <br>
                                    <br><br><br>
                                    -----

                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                        $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $name, $messageMail, $sujet, $titre);
                    }
                }
                return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(4).'/edit')->with('success','Succès: Sélection effectuée');
            }else{

            }
        }else{

        }
    }

    public function deleteoperateurpe(string $id_projet_etude,string $id_operateur)
    {
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $id_operateur = Crypt::UrldeCrypt($id_operateur);
        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                $projet_etude_valide->operateurs()->detach($id_operateur);
                return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(4).'/edit')->with('success','Succès: Sélection effectuée');
            }else{

            }
        }else{

        }

    }

    public function storeCabinetEtranger(Request $request)
    {

        $request->validate([
            'raison_social_entreprises' => 'required',
            'email_entreprises' => 'required|email',
            'indicatif_entreprises' => 'required',
            'tel_entreprises' => 'required'
        ], [
            'raison_social_entreprises.required' => 'Veuillez ajouter votre raison sociale.',
            'email_entreprises.required' => 'Veuillez ajouter un email.',
            'indicatif_entreprises.required' => 'Veuillez ajouter un indicatif.',
            'tel_entreprises.required' => 'Veuillez ajouter un contact.',
        ]);


        $input = $request->all();

        $id_projet_etude = $input['id_projet_etude'];
        $input['flag_cabinet_etranger'] = true;
        $input['flag_operateur'] = true;
        $input['flag_actif_entreprises'] = true;
        $numfdfp = 'fdfp_CE' . Gencode::randStrGen(4, 5);
        $numfdfp1 = 'fdfpCE' . Gencode::randStrGen(4, 4);
        $input['numero_fdfp_entreprises'] = $numfdfp;
        $input['ncc_entreprises'] = $numfdfp1;

        Entreprises::create($input);
        $data = Entreprises::latest()->first();
        return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(4).'/edit')->with('success','Succès: Nouveau cabinet etranger ajouté avec succès');

    }


}
