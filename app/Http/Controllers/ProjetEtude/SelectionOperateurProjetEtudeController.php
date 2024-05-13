<?php

namespace App\Http\Controllers\ProjetEtude;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\DomaineFormation;
use App\Models\DomaineFormationCabinet;
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
        $pays = Pays::where('flag_actif_pays',true)->get();

        if(isset($id_projet_etude)){
            $projet_etude = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();

            if(isset($projet_etude)){
                $user = User::find($projet_etude->id_user);
                $entreprise_mail = $user->email;
                $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);
//
//
//                $operateur_selected = "<option value=''> Selectionnez un opérateur </option>";
//                foreach ($operateur_selecteds as $operateur) {
//                    $operateur_selected .= "<option value='" .$operateur->id_entreprises. "'>" . mb_strtoupper($operateur->raison_social_entreprises) . " </option>";
//                }

                $operateur_validers = Entreprises::whereExists(function ($query) use ($id_projet_etude){
                    $query->select('*')
                        ->from('projet_etude_has_entreprises')
                        ->whereColumn('projet_etude_has_entreprises.id_entreprises','=','entreprises.id_entreprises')
                        ->where('projet_etude_has_entreprises.id_projet_etude',$id_projet_etude);
                })->leftjoin('domaine_formation_cabinet','domaine_formation_cabinet.id_entreprises','entreprises.id_entreprises')
                    ->where('flag_operateur',true)->where('flag_actif_entreprises',true)
                    ->where('domaine_formation_cabinet.id_domaine_formation',$projet_etude->id_domaine_projet_instruction)
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

                $secteur_activites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $payss = Pays::all();
                $paysc = "<option value=''> ---Selectionnez un pays--- </option>";
                foreach ($payss as $comp) {
                    $paysc .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }

                $domaine_projets = DomaineFormation::where('flag_domaine_formation', '=', true)
                    ->orderBy('libelle_domaine_formation')
                    ->get();

                $domaine_projet = "<option value='".$projet_etude->DomaineProjetEtudeInstruction->id_domaine_formation."'> " . $projet_etude->DomaineProjetEtudeInstruction->libelle_domaine_formation . "</option>";
                foreach ($domaine_projets as $comp) {
                    $domaine_projet .= "<option value='" . $comp->id_domaine_formation."'>" . mb_strtoupper($comp->libelle_domaine_formation) . " </option>";
                }

                $formjuridique = "<option value='".$entreprise->formeJuridique->id_forme_juridique."'> " . $entreprise->formeJuridique->libelle_forme_juridique . "</option>";

                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                }

                return view('projetetudes.selection_operateur.edit', compact('idetape','paysc',
                    'formjuridique','operateur_valider',
//                    'operateur_selected',
                    'pay',
                    'domaine_projet',
                    'secteur_activites',
                    'pays',
                    'domaine_projets',
                    'pieces_projets','entreprise','entreprise_mail','projet_etude'));
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

                    $operateurs = $projet_etude_valide->operateurs()->get();

                    $logo = Menu::get_logo();

                    if(isset($operateurs)){
                        foreach ($operateurs as $operateur){
                            $entreprise = Entreprises::where('id_entreprises',$projet_etude_valide->id_operateur_selection)->first();
                            $name = $entreprise->raison_social_entreprises;
                            $user = User::where('id_partenaire',$entreprise->id_entreprises)->first();
                            if($projet_etude_valide->id_operateur_selection==$operateur->id_entreprises){
                                if (isset($operateur->email_entreprises)) {
                                    $sujet = $projet_etude_valide->titre_projet_instruction;
                                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                                    $messageMail = "<b>Monsieur le Directeur,</b>
                                    <br><br>J’ai l’honneur de vous informer que <b>votre offre a été retenue</b> à l’issue de l’appel d’offres restreint réalisé par le Fonds de Développement de la Formation Professionnelle (FDFP) relatif au projet  <b> «".$projet_etude_valide->titre_projet_instruction."»</b>.
                                    <br><br>Cependant, nous souhaiterions ouvrir une négociation avec vous relativement au coût global du projet que vous proposé.<br>
                                    <br><br>Merci de nous faire part de votre décision dans un délai de huit (8) jours, soit au plus tard avant le". @$projet_etude_valide->date_validation_selection_operateur->addDays(8)." <br><br><br>
                                    <br><br>
                                    Veuillez agréer, <b>Monsieur le Directeur</b>, l’expression de nos salutations distinguées.
                                    <br>
                                    <br>
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----";
                                    $messageMailEnvoi = Email::get_envoimailTemplate($operateur->email_entreprises, $name, $messageMail, $sujet, $titre);

                                }
                                }else{
                                if (isset($operateur->email_entreprises)) {
                                    $sujet = $projet_etude_valide->titre_projet_instruction;
                                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                                    $messageMail = "<b>Monsieur le Directeur,</b>
                                        <br><br>Je vous remercie de votre récente candidature à la suite de l’appel d’offres restreints lancé pour le projet susmentionné en objet. <br><br>
                                        J’ai néanmoins le regret de vous informer que <b>votre offre n’a pas été retenue </b>par la Commission d’Ouverture et de Jugement des Offres (COJO) du FDFP lors de son assise du 25 Avril 2024.<br><br>
                                        La Direction des Etudes, de l’Evaluation, de la Qualité, la Prospective et de la Communication (D2EQPC) se tient à votre disposition pour toutes les informations relatives à l’analyse de votre offre, et pour toutes autres préoccupations éventuelles.<br><br>
                                        En espérant que vous continuerez à participer aux appels d'offres restreints que nous lancerons, je vous prie d’agréer, <b>Monsieur le Directeur</b>, l’expression de mes sentiments distingués.
                                        <br>
                                        <br>
                                        <br>
                                        -----
                                        Ceci est un mail automatique, Merci de ne pas y répondre.
                                        -----";
                                    $messageMailEnvoi = Email::get_envoimailTemplate($operateur->email_entreprises, $name, $messageMail, $sujet, $titre);
                                }
                            }
                        }
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
            'tel_entreprises' => 'required',
            'id_secteur_activite'=>'required',
        ], [
            'raison_social_entreprises.required' => 'Veuillez ajouter votre raison sociale.',
            'email_entreprises.required' => 'Veuillez ajouter un email.',
            'indicatif_entreprises.required' => 'Veuillez ajouter un indicatif.',
            'tel_entreprises.required' => 'Veuillez ajouter un contact.',
            'id_secteur_activite'=>'Veuillez ajouter un secteur d\'activité',
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

        $entreprise = Entreprises::create($input);

        $projet_etude = ProjetEtude::find($id_projet_etude);

        $domaine_formation_cabinet = new DomaineFormationCabinet();
        $domaine_formation_cabinet->id_domaine_formation = $projet_etude->id_domaine_projet_instruction;
        $domaine_formation_cabinet->id_entreprises = $entreprise->id_entreprises;
        $domaine_formation_cabinet->flag_domaine_formation_cabinet = true;
        $domaine_formation_cabinet->save();

        return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(4).'/edit')->with('success','Succès: Nouveau cabinet etranger ajouté avec succès');

    }



    public function cabinetintra($id)
    {
        $id = Crypt::UrldeCrypt($id);
        $projet_etude = ProjetEtude::find($id);
        $operateur_selecteds = Entreprises::whereNotExists(function ($query) use ($projet_etude){
            $query->select('*')
                ->from('projet_etude_has_entreprises')
                ->whereColumn('projet_etude_has_entreprises.id_entreprises','=','entreprises.id_entreprises')
                ->where('projet_etude_has_entreprises.id_projet_etude',$projet_etude->id_projet_etude);
        })->leftjoin('domaine_formation_cabinet','domaine_formation_cabinet.id_entreprises','entreprises.id_entreprises')
            ->where('flag_operateur',true)
            ->where('flag_actif_entreprises',true)
            ->where('flag_cabinet_etranger',false)
            ->where('domaine_formation_cabinet.id_domaine_formation',$projet_etude->id_domaine_projet_instruction)
            ->get();
        return $operateur_selecteds;
    }

    public function cabinetetranger($id)
    {
        $id = Crypt::UrldeCrypt($id);
        $projet_etude = ProjetEtude::find($id);
        $operateur_selecteds = Entreprises::whereNotExists(function ($query) use ($projet_etude){
            $query->select('*')
                ->from('projet_etude_has_entreprises')
                ->whereColumn('projet_etude_has_entreprises.id_entreprises','=','entreprises.id_entreprises')
                ->where('projet_etude_has_entreprises.id_projet_etude',$projet_etude->id_projet_etude);
        })->leftjoin('domaine_formation_cabinet','domaine_formation_cabinet.id_entreprises','entreprises.id_entreprises')
            ->where('flag_operateur',true)
            ->where('flag_actif_entreprises',true)
            ->where('flag_cabinet_etranger',true)
            ->where('domaine_formation_cabinet.id_domaine_formation',$projet_etude->id_domaine_projet_instruction)
            ->get();
        return $operateur_selecteds;
    }


}
