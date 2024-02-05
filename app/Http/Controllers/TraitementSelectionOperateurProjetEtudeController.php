<?php

namespace App\Http\Controllers;

use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Models\Entreprises;
use App\Models\Parcours;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
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
                    ->join('users','projet_etude.id_charge_etude','users.id')
                    ->where([
                        ['v.mini', '=', $r->priorite_combi_proc],
                        ['v.id_processus', '=', $r->id_processus],
                        ['v.code', '=', 'SOPE'],
                        ['p.id_roles', '=', $id_roles]
                    ])->get();
            }
        }
        return view('traitementselectionoperateurprojetetude.index', compact('resultat'));
    }

    public function edit(string $id_projet_etude,string $id_combi_proc)
    {
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $id_combi_proc = Crypt::UrldeCrypt($id_combi_proc);

        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::find($id_projet_etude);

            $operateurs = Entreprises::where('flag_operateur',true)->where('flag_actif_entreprises',true)
//                    ->where('id_secteur_activite',$projet_etude_valide->id_secteur_activite)
                ->get();

            $user = User::find($projet_etude_valide->id_user);
            $entreprise_mail = $user->email;
            $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','1')->first();
            $piecesetude1 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','2')->first();
            $piecesetude2 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','3')->first();
            $piecesetude3 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','4')->first();
            $piecesetude4 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','5')->first();
            $piecesetude5 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','6')->first();
            $piecesetude6 = $piecesetude->libelle_pieces;
        }

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide','v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $projet_etude_valide->id_processus_selection)
            ->where('v.id_demande', '=', $projet_etude_valide->id_projet_etude)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();

        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$projet_etude_valide->id_processus_selection],
            ['id_user','=',$idUser],
            ['id_piece','=',$id_projet_etude],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id_combi_proc]
        ])->get();

        return view('traitementselectionoperateurprojetetude.edit', compact('projet_etude_valide','id_combi_proc','piecesetude1','piecesetude2','piecesetude3','piecesetude4','piecesetude5','piecesetude6','entreprise','entreprise_mail','operateurs','ResultProssesList','parcoursexist'));
    }

    public function update(Request $request, $id_projet_etude)
    {
        $id_projet_etude =  Crypt::UrldeCrypt($id_projet_etude);

        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::find($id_projet_etude);

            if(isset($projet_etude_valide)) {
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

                            $projet_etude_valide->flag_selection_operateur_valider_par_processus = true;
                            $projet_etude_valide->flag_validation_selection_operateur = true;
                            $projet_etude_valide->date_validation_selection_operateur = now();
                            $projet_etude_valide->update();


//                            $infoentreprise = Entreprises::find($projet_etude_valide->id_entreprises);
00//
//                            //Envoie notification au charger de plan de formation en cas de validation
//                            if (isset($planformation->email_professionnel_charge_plan_formation)) {
//                                $sujet = "Demande d'annulation du plan de formation (code:" .
//                                    @$planformation->code_plan_formation . ") sur e-FDFP";
//
//                                $titre = "Bienvenue sur " . @$logo->mot_cle . "";
//                                $messageMail = "<b>Cher,  " . $infoentreprise->raison_social_entreprises . " ,</b>
//                                        <br><br>Nous sommes ravis de vous informer que votre demande d'annulation du plan de formation (code: "
//                                    . @$planformation->code_plan_formation .
//                                    ") sur e-FDFP a été validé avec succès.
//                                         <br>
//                                         <br>
//                                            Cordialement,
//                                            <br>
//                                            L'équipe e-FDFP
//                                        <br><br><br>
//                                        -----
//                                        Ceci est un mail automatique, Merci de ne pas y répondre.
//                                        -----
//                                        ";
//    //                    $planformation->email_professionnel_charge_plan_formation
//                                $messageMailEnvoi = Email::get_envoimailTemplate("ncho.hermann.dorgeles@gmail.com", $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
//                            }
                        }

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
