<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\DomaineFormation;
use App\Models\Entreprises;
use App\Models\FormeJuridique;
use App\Models\Parcours;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TraitementSelectionOperateurProjetEtudeController extends Controller
{
    //
    public function index(){
        $id_user=Auth::user()->id;
        $id_roles = Menu::get_id_profil($id_user);
        $resultat_etape = DB::table('vue_processus')
            ->where('id_roles', '=', $id_roles)
            ->get();

        $resultat = null;
        if (isset($resultat_etape)) {
            $resultat = [];
            foreach ($resultat_etape as $key => $r) {
                $resultat[$key] = DB::table('vue_processus_liste as v')
                    ->join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                    ->join('projet_etude','p.id_demande','projet_etude.id_projet_etude')
                    ->join('entreprises','projet_etude.id_entreprises','entreprises.id_entreprises')
                    ->join('users','projet_etude.id_charge_etude','users.id')
                    ->where([
                        ['v.mini', '=', $r->priorite_combi_proc],
                        ['v.id_processus', '=', $r->id_processus],
                        ['v.code', '=', 'SOPE'],
                        ['p.id_combi_proc', '=', $r->id_combi_proc],
                        ['p.id_roles', '=', $id_roles]
                    ])->get();

            }
        }
        return view('projetetudes.traitement_selection_operateur.index', compact('resultat'));
    }

    public function edit(string $id_projet_etude,string $id_combi_proc)
    {
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $id_combi_proc = Crypt::UrldeCrypt($id_combi_proc);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if(isset($id_projet_etude)){
            $projet_etude = ProjetEtude::find($id_projet_etude);

            $user = User::find($projet_etude->id_user);
            $entreprise_mail = $user->email;
            $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);

            $pieces_projets= PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)->get();

            $pays = Pays::all();
            $pay = "<option value='".$entreprise->pay->id_pays."'> " . $entreprise->pay->indicatif . "</option>";
            foreach ($pays as $comp) {
                $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
            }

            $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                ->orderBy('libelle_secteur_activite')
                ->get();

            $formjuridique = "<option value='".$entreprise->formeJuridique->id_forme_juridique."'> " . $entreprise->formeJuridique->libelle_forme_juridique . "</option>";

            foreach ($formjuridiques as $comp) {
                $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
            }

//            $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
//            foreach ($secteuractivite_projets as $comp) {
//                $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
//            }

            $domaine_projets = DomaineFormation::where('flag_domaine_formation', '=', true)
                ->orderBy('libelle_domaine_formation')
                ->get();

            $domaine_projet = "<option value='".$projet_etude->DomaineProjetEtudeInstruction->id_domaine_formation."'> " . $projet_etude->DomaineProjetEtude->libelle_domaine_formation . "</option>";
            foreach ($domaine_projets as $comp) {
                $domaine_projet .= "<option value='" . $comp->id_domaine_formation."'>" . mb_strtoupper($comp->libelle_domaine_formation) . " </option>";
            }
        }

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide','v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $projet_etude->id_processus_selection)
            ->where('v.id_demande', '=', $projet_etude->id_projet_etude)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();

        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$projet_etude->id_processus_selection],
            ['id_user','=',$idUser],
            ['id_piece','=',$id_projet_etude],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id_combi_proc]
        ])->get();

        return view('projetetudes.traitement_selection_operateur.edit', compact(
            'formjuridique',
            'domaine_projet','pay','pieces_projets','projet_etude','id_combi_proc','entreprise','entreprise_mail','ResultProssesList','parcoursexist'));
    }

    public function update(Request $request, $id_projet_etude)
    {
        $id_projet_etude =  Crypt::UrldeCrypt($id_projet_etude);

        if(isset($id_projet_etude)){
            $projet_etude = ProjetEtude::find($id_projet_etude);

            if(isset($projet_etude)) {
                if ($request->isMethod('put')) {
                    $data = $request->all();
                    if ($data['action'] === 'Valider') {
                        $idUser = Auth::user()->id;
                        $idAgceCon = Auth::user()->num_agce;
                        $Idroles = Menu::get_id_profil($idUser);
                        $dateNow = Carbon::now();
                        $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                        $infosprocessus = DB::table('vue_processus')
                            ->where('id_combi_proc', '=', $id_combi_proc)
                            ->first();
                        $idProComb = $infosprocessus->id_combi_proc;
                        $idProcessus = $infosprocessus->id_processus;

                        Parcours::create([
                            'id_processus' => $idProcessus,
                            'id_user' => $idUser,
                            'id_piece' => $id_projet_etude,
                            'id_roles' => $Idroles,
                            'num_agce' => $idAgceCon,
                            'comment_parcours' => $request->input('comment_parcours'),
                            'is_valide' => true,
                            'date_valide' => $dateNow,
                            'id_combi_proc' => $idProComb,
                        ]);

                        $ResultCptVal = DB::table('combinaison_processus as v')
                            ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
                            ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
                            ->where('a.id_demande', '=', $id_projet_etude)
                            ->where('a.id_processus', '=', $idProcessus)
                            ->where('v.id_roles', '=', $Idroles)
                            ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                            ->first();

                        if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
                            $projet_etude->flag_selection_operateur_valider_par_processus = true;
                            $projet_etude->date_selection_operateur_valider_par_processus = now();
                            $projet_etude->flag_validation_selection_operateur = false;
                            $projet_etude->update();

                            $operateurs = $projet_etude->operateurs()->get();
                            if(isset($operateurs)){
                                foreach ($operateurs as $operateur){
                                    $entreprise = Entreprises::where('id_entreprises',$operateur->id_entreprises)->first();
                                    $name = $entreprise->raison_social_entreprises;
                                    $user = User::where('id_partenaire',$entreprise->id_entreprises)->first();

                                    if (isset($user->email)) {
                                        $sujet = "Offre de services";
                                        $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                        $messageMail = "<b>Monsieur le Directeur,</b>
                                    <br><br>Le FDFP envisage de recruter un cabinet de consultants pour la réalisation du projet d'étude intitulé : <b>".$projet_etude->titre_projet_instruction.".</b>
                                    <br>
                                    A cet effet, nous vous invitons à nous faire parvenir <b>une offre technique</b> et <b>une offre financière</b> séparées et en <b>cinq (05) exemplaires</b> chacune, sur la base des termes de référence (TDR) que nous joignons à la présente
                                    Vous voudriez bien nous faire parvenir directement au Secrétariat de la Direction des Etudes, de l’Evaluation, de la Qualité, de la Prospective et de la Communication (D2EQPC)
                                     vos offres au plus tard le".$projet_etude->date_selection_operateur_valider_par_processus->addDays(14);
                                        if(isset($projet_etude->id_user)){
                                            $messageMail .= $projet_etude->chargedetude->name." ".$projet_etude->chargedetude->prenom_users;
                                        }



                                        $messageMail .=", Conseiller chargé d’études (@$projet_etude->chargedetude->tel_users / @$projet_etude->chargedetude->email), Responsable du Projet qui se tient à votre disposition pour toutes informations complémentaires.
                                        Vous souhaitant bonne réception, nous vous prions d’agréer, Monsieur le Directeur, nos salutations distinguées.
                                        <br>
                                        Cliquez sur le lien ci-dessous pour prendre connaissance du TDR
                                        <br>
                                        <br>
                                        <a class=\"o_text-white\" href=\"".asset("pieces_projet/fichier_instruction/". $projet_etude->piece_jointe_instruction)."\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 7px 16px;mso-text-raise: 3px;
                                            font-family: Helvetica, Arial, sans-serif;font-weight: bold;width: 30%;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;mso-padding-alt: 7px 16px;background-color: #e07204;border-radius: 4px;\">Consulter le TDR</a>
                                    <br>
                                    <br>
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";


                                        $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $name, $messageMail, $sujet, $titre);
                                    }

                                    else{
                                        $sujet = "Offre de services";
                                        $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                        $messageMail = "<b>Monsieur le Directeur,</b>
                                    <br><br>Le FDFP envisage de recruter un cabinet de consultants pour la réalisation du projet d'étude intitulé : <b>".$projet_etude->titre_projet_instruction.".</b>
                                    <br>
                                    <br>
                                    A cet effet, nous vous invitons à nous faire parvenir <b>une offre technique</b> et <b>une offre financière</b> séparées et en <b>cinq (05) exemplaires</b> chacune, sur la base des termes de référence (TDR) que nous joignons à la présente.
                                    <br>
                                    <br>

                                    Vous voudriez bien nous faire parvenir directement au Secrétariat de la Direction des Etudes, de l’Evaluation, de la Qualité, de la Prospective et de la Communication (<b>D2EQPC</b>)
                                     vos offres au plus tard le ".date('d/m/Y',strtotime($projet_etude->date_selection_operateur_valider_par_processus->addDays(14)));
                                        if(isset($projet_etude->id_user)){
                                            $messageMail .= ", Conseiller chargé d’études ".$projet_etude->chargedetude->name." ".$projet_etude->chargedetude->prenom_users."(".$projet_etude->chargedetude->tel_users." / ".$projet_etude->chargedetude->email.")";
                                        }


                                        $messageMail .=", Responsable du Projet qui se tient à votre disposition pour toutes informations complémentaires.
                                        <br>
                                        <br>
                                        Vous souhaitant bonne réception, nous vous prions d’agréer, <b>Monsieur le Directeur</b>, nos salutations distinguées.
                                        <br>
                                        Cliquez sur le lien ci-dessous pour prendre connaissance du TDR
                                        <br>
                                        <br>
                                        <a class=\"o_text-white\" href=\"".asset("pieces_projet/fichier_instruction/". $projet_etude->piece_jointe_instruction)."\" style=\"text-decoration: none;outline: none;color: #ffffff;display: block;padding: 7px 16px;mso-text-raise: 3px;
                                            font-family: Helvetica, Arial, sans-serif;font-weight: bold;width: 30%;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;mso-padding-alt: 7px 16px;background-color: #e07204;border-radius: 4px;\">Consulter le TDR</a>
                                    <br>
                                    <br>
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";


                                        $messageMailEnvoi = Email::get_envoimailTemplate($entreprise->email_entreprises, $name, $messageMail, $sujet, $titre);

                                    }
                                }
                            }                        }

                        return redirect('traitementselectionoperateurprojetetude/' . Crypt::UrlCrypt($id_projet_etude) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succes ');
                    }

//                    if ($data['action'] === 'Rejeter') {
//
//                        $this->validate($request, [
//                            'comment_parcours' => 'required',
//                        ], [
//                            'comment_parcours.required' => 'Veuillez ajouter un commentaire.',
//                        ]);
//
//                        $idUser = Auth::user()->id;
//                        $idAgceCon = Auth::user()->num_agce;
//                        $Idroles = Menu::get_id_profil($idUser);
//                        $dateNow = Carbon::now();
//                        $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
//                        $infosprocessus = DB::table('vue_processus')
//                            ->where('id_combi_proc', '=', $id_combi_proc)
//                            ->first();
//                        $idProComb = $infosprocessus->id_combi_proc;
//                        $idProcessus = $infosprocessus->id_processus;
//
//                        Parcours::create([
//                            'id_processus' => $idProcessus,
//                            'id_user' => $idUser,
//                            'id_piece' => $id_projet_etude,
//                            'id_roles' => $Idroles,
//                            'num_agce' => $idAgceCon,
//                            'comment_parcours' => $request->input('comment_parcours'),
//                            'is_valide' => false,
//                            'date_valide' => $dateNow,
//                            'id_combi_proc' => $idProComb,
//                        ]);
//
//                        $ResultCptVal = DB::table('combinaison_processus as v')
//                            ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
//                            ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
//                            ->where('a.id_demande', '=', $id_projet_etude)
//                            ->where('a.id_processus', '=', $idProcessus)
//                            ->where('v.id_roles', '=', $Idroles)
//                            ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
//                            ->first();
//
//                        if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
//                            $demande_annulation->flag_rejeter_demande_annulation_plan = true;
//                            $demande_annulation->commentaire_final_demande_annulation_plan_formation = $request->comment_parcours;
//                            $demande_annulation->date_validation_demande_annulation_plan = now();
//                            $demande_annulation->update();
//
//
//                        }
//
//                        $infoentreprise = Entreprises::find($planformation->id_entreprises);
//                        $logo = Menu::get_logo();
//
//                        //Envoie notification au charger de plan de formation en cas de rejet
//                        if (isset($planformation->email_professionnel_charge_plan_formation)) {
//                            $sujet = "Demande d'annulation du plan de formation (code:" .
//                                @$planformation->code_plan_formation . ") sur e-FDFP";
//
//                            $titre = "Bienvenue sur " . @$logo->mot_cle . "";
//                            $messageMail = "<b>Cher,  " . $infoentreprise->raison_social_entreprises . " ,</b>
//                                    <br><br>Nous avons examiné votre demande d'annulation du plan de formation (code: "
//                                . @$planformation->code_plan_formation .
//                                ") sur e-FDFP, et malheureusement,
//                                     nous ne pouvons l'approuver pour la raison suivante :
//                                     <br>
//                                    <br><b>Commentaire : </b> " . @$demande_annulation->commentaire_final_demande_annulation_plan_formation . "
//                                    <br><br>
//                                    <br><br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
//                                        fournir, n'hésitez pas à nous contacter à [Adresse e-mail du support] pour obtenir de l'aide.
//                                        Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
//                                        soumettre une nouvelle demande lorsque les problèmes seront résolus.
//                                        <br>
//                                        Cordialement,
//                                        <br>
//                                        L'équipe e-FDFP
//                                    <br><br><br>
//                                    -----
//                                    Ceci est un mail automatique, Merci de ne pas y répondre.
//                                    -----
//                                    ";
//                            $messageMailEnvoi = Email::get_envoimailTemplate($planformation->email_professionnel_charge_plan_formation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
//                        }
//
//                        return redirect('traitementselectionoperateurprojetetude/' . Crypt::UrlCrypt($id_projet_etude) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succes ');
//                    }

                }
            }else{

            }
        }
    }
}
