<?php

namespace App\Http\Controllers;

use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\ActionFormationPlan;
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\DemandeAnnulationPlan;
use App\Models\Entreprises;
use App\Models\FicheAgrement;
use App\Models\Motif;
use App\Models\Parcours;
use App\Models\Pays;
use App\Models\PlanFormation;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TraitementDemandeAnnulationPlanController extends Controller
{
    //
    public function index()
    {
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
//                    ->join('demande_annulation_plan','p.id_demande','=','demande_annulation_plan.id_demande_annulation_plan')
                    ->leftjoin('demande_annulation_plan', function($join){
                        $join->on('demande_annulation_plan.id_demande_annulation_plan','=','p.id_demande'); // i want to join the users table with either of these columns
                        $join->orOn('demande_annulation_plan.id_action_plan','=','p.id_demande');
                    })
                    ->leftjoin('action_formation_plan','action_formation_plan.id_action_formation_plan','demande_annulation_plan.id_action_plan')
                    ->leftjoin('plan_formation', function($join){
                        $join->on('plan_formation.id_plan_de_formation','=','demande_annulation_plan.id_plan_formation'); // i want to join the users table with either of these columns
                        $join->orOn('plan_formation.id_plan_de_formation','=','action_formation_plan.id_plan_de_formation');
                    })
                    ->leftjoin('entreprises','plan_formation.id_entreprises','entreprises.id_entreprises')
                    ->join('users','demande_annulation_plan.id_user','users.id')
                    ->where([
                        ['v.mini', '=', $r->priorite_combi_proc],
                        ['v.id_processus', '=', $r->id_processus],
                        ['v.code', '=', 'APF'],
                        ['p.id_roles', '=', $id_roles]
                    ])->get();


            }
        }
        return view('traitementdemandeannulationplan.index',compact('resultat'));
    }

    public function edit(string $id,string $id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);
        $infosactionplanformation ="";
        if(isset($id)){
            $demande_annulation = DemandeAnnulationPlan::find($id);
            if(isset($demande_annulation)){
                if(isset($demande_annulation->id_action_plan)){
                    $actionplanformation = ActionFormationPlan::find($demande_annulation->id_action_plan);
                    $planformation = PlanFormation::find($actionplanformation->id_plan_de_formation);

                    $infosactionplanformation = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*')
                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                        ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                        ->where([['action_formation_plan.id_action_formation_plan','=',$actionplanformation->id_action_formation_plan]])->first();
                }

                if(isset($demande_annulation->id_plan_formation)){
                    $planformation = PlanFormation::find($demande_annulation->id_plan_formation);
                }
            }
        }


        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $typeentreprises = TypeEntreprise::all();
        $typeentreprise = "<option value='".$planformation->typeEntreprise->id_type_entreprise."'>".$planformation->typeEntreprise->lielle_type_entrepise." </option>";
        foreach ($typeentreprises as $comp) {
            $typeentreprise .= "<option value='" . $comp->id_type_entreprise  . "'>" . mb_strtoupper($comp->lielle_type_entrepise) ." </option>";
        }


        $pays = Pays::all();
        $pay = "<option value='".@$infoentreprise->pay->id_pays."'> " . @$infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }

        $typeformations = TypeFormation::all();
        $typeformation = "<option value=''> Selectionnez le type  de la formation </option>";
        foreach ($typeformations as $comp) {
            $typeformation .= "<option value='" . $comp->id_type_formation  . "'>" . mb_strtoupper($comp->type_formation) ." </option>";
        }

        $categorieprofessionelles = CategorieProfessionelle::all();
        $categorieprofessionelle = "<option value=''> Selectionnez la categorie </option>";
        foreach ($categorieprofessionelles as $comp) {
            $categorieprofessionelle .= "<option value='" . $comp->id_categorie_professionelle  . "'>" . mb_strtoupper($comp->categorie_profeessionnelle) ." </option>";
        }

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$demande_annulation->id_plan_formation]])->get();

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$demande_annulation->id_plan_formation]])->get();

        $motifs = Motif::where('code_motif','APF')->where('flag_actif_motif',true)->get();
        $action_motifs = Motif::where('code_motif','AAF')->where('flag_actif_motif',true)->get();

        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*')
            ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
            ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
            ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
            ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
            ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
            ->where([['action_formation_plan.id_plan_de_formation','=',$demande_annulation->id_plan_formation]])->get();

        //dd($infosactionplanformations);

        $nombreaction = count($actionplanformations);

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$demande_annulation->id_plan_formation],['flag_valide_action_formation_pl','=',true]])->get();
        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$demande_annulation->id_plan_formation],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();

        $nombreactionvalider = count($actionvalider);
        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
                'v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $demande_annulation->id_processus)
            ->where('v.id_demande', '=', $demande_annulation->id_demande_annulation_plan)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();

        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$demande_annulation->id_processus],
            ['id_user','=',$idUser],
            ['id_piece','=',$id],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id2]
        ])->get();



        return view('traitementdemandeannulationplan.edit', compact('action_motifs','infosactionplanformation','motifs','demande_annulation','planformation','infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations','categorieprofessionelle','categorieplans','infosactionplanformations','nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','id2','ResultProssesList','parcoursexist'));

    }

    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        if(isset($id)){
            $demande_annulation = DemandeAnnulationPlan::find($id);
            if(isset($demande_annulation->id_action_plan)){
                $actionplanformation = ActionFormationPlan::find($demande_annulation->id_action_plan);
                $planformation = PlanFormation::find($actionplanformation->id_plan_de_formation);

                $infosactionplanformation = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*')
                    ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                    ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                    ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                    ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
                    ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                    ->where([['action_formation_plan.id_action_formation_plan','=',$actionplanformation->id_action_formation_plan]])->first();
            }

            if(isset($demande_annulation->id_plan_formation)){
                $planformation = PlanFormation::find($demande_annulation->id_plan_formation);
            }

        }
        if ($request->isMethod('put')) {
            $data = $request->all();
            if($data['action'] === 'Valider'){
                $idUser=Auth::user()->id;
                $idAgceCon=Auth::user()->num_agce;
                $Idroles = Menu::get_id_profil($idUser);
                $dateNow = Carbon::now();
                $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                $infosprocessus = DB::table('vue_processus')
                    ->where('id_combi_proc', '=', $id_combi_proc)
                    ->first();
                $idProComb = $infosprocessus->id_combi_proc;
                $idProcessus = $infosprocessus->id_processus;
                $actionplanformations = ActionFormationPlan::where('id_plan_de_formation',$demande_annulation->id_plan_formation)->get();
                Parcours::create([
                    'id_processus' => $idProcessus,
                    'id_user' => $idUser,
                    'id_piece' => $id,
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
                    ->where('a.id_demande', '=', $id)
                    ->where('a.id_processus', '=', $idProcessus)
                    ->where('v.id_roles', '=', $Idroles)
                    ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                    ->first();

                if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {


                    $demande_annulation->flag_demande_annulation_plan_valider_par_processus = true;
                    $demande_annulation->flag_validation_demande_annulation_plan = true;
                    $demande_annulation->date_validation_demande_annulation_plan = now();
                    $demande_annulation->update();



                    $infoentreprise = Entreprises::find($planformation->id_entreprises);
                    $logo = Menu::get_logo();

                    //Envoie notification au charger de plan de formation en cas de validation
                    if (isset($planformation->email_professionnel_charge_plan_formation)) {

                        if(isset($demande_annulation->id_plan_formation)){
                            foreach ($actionplanformations as $actionplanformation){
                                $actionplanformation_update = ActionFormationPlan::find($actionplanformation->id_action_formation_plan);
                                $actionplanformation_update->flag_annulation_action=true;
                                $actionplanformation_update->update();
                            }
                            $planformation->flag_annulation_plan=true;
                            $planformation->update();

                            $sujet = "Demande d'annulation du plan de formation (code:"  .
                                @$planformation->code_plan_formation.") sur e-FDFP";

                            $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                            $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous sommes ravis de vous informer que votre demande d'annulation du plan de formation (code: "
                                .@$planformation->code_plan_formation.
                                ") sur e-FDFP a été validé avec succès.
                                     <br>
                                     <br>
                                        Cordialement,
                                        <br>
                                        L'équipe e-FDFP
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
//                    $planformation->email_professionnel_charge_plan_formation
                            $messageMailEnvoi = Email::get_envoimailTemplate("ncho.hermann.dorgeles@gmail.com", $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

                        }
                        if(isset($demande_annulation->id_action_plan)){
                            $actionplanformation_update = ActionFormationPlan::find($demande_annulation->id_action_plan);


                            $actionplanformation_update->flag_annulation_action=true;
                            $actionplanformation_update->update();

                            $actionplanformations = ActionFormationPlan::where('id_plan_de_formation',$actionplanformation->id_plan_de_formation)
                                ->where(function($query){
                                    $query->where('flag_annulation_action','<>',true)
                                          ->orwhereNull('flag_annulation_action');
                                })
                                ->get();
                            if($actionplanformations->count()==0){
                                $planformation->flag_annulation_plan=true;
                                $planformation->update();
                            }

                            $sujet = "Demande d'annulation de l'action de formation (intitulé:"  .
                                @$actionplanformation->intitule_action_formation_plan.") sur e-FDFP";

                            $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                            $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous sommes ravis de vous informer que votre demande d'annulation du plan de formation (intitulé: "
                                .@$actionplanformation->intitule_action_formation_plan.
                                ") sur e-FDFP a été validé avec succès.
                                     <br>
                                     <br>
                                        Cordialement,
                                        <br>
                                        L'équipe e-FDFP
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
//                    $planformation->email_professionnel_charge_plan_formation
                            $messageMailEnvoi = Email::get_envoimailTemplate("ncho.hermann.dorgeles@gmail.com", $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

                        }
                    }

                }

                return redirect('traitementdemandeannulationplan/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/edit')->with('success', 'Succes : Operation validée avec succes ');
            }

            if($data['action'] === 'Rejeter'){

                $this->validate($request, [
                    'comment_parcours' => 'required',
                ],[
                    'comment_parcours.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $idUser=Auth::user()->id;
                $idAgceCon=Auth::user()->num_agce;
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
                        'id_piece' => $id,
                        'id_roles' => $Idroles,
                        'num_agce' => $idAgceCon,
                        'comment_parcours' => $request->input('comment_parcours'),
                        'is_valide' => false,
                        'date_valide' => $dateNow,
                        'id_combi_proc' => $idProComb,
                    ]);

                $ResultCptVal = DB::table('combinaison_processus as v')
                    ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
                    ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
                    ->where('a.id_demande', '=', $id)
                    ->where('a.id_processus', '=', $idProcessus)
                    ->where('v.id_roles', '=', $Idroles)
                    ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                    ->first();

                if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
                    $demande_annulation->flag_rejeter_demande_annulation_plan = true;
                    $demande_annulation->commentaire_final_demande_annulation_plan_formation = $request->comment_parcours;
                    $demande_annulation->date_validation_demande_annulation_plan = now();
                    $demande_annulation->update();
                }

                $infoentreprise = Entreprises::find($planformation->id_entreprises);
                $logo = Menu::get_logo();

                //Envoie notification au charger de plan de formation en cas de rejet
                if (isset($planformation->email_professionnel_charge_plan_formation)) {
                    $sujet = "Demande d'annulation du plan de formation (code:"  .
                        @$planformation->code_plan_formation.") sur e-FDFP";

                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous avons examiné votre demande d'annulation du plan de formation (code: "
                                        .@$planformation->code_plan_formation.
                                     ") sur e-FDFP, et malheureusement,
                                     nous ne pouvons l'approuver pour la raison suivante :
                                     <br>
                                    <br><b>Commentaire : </b> ".@$demande_annulation->commentaire_final_demande_annulation_plan_formation."
                                    <br><br>
                                    <br><br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
                                        fournir, n'hésitez pas à nous contacter à [Adresse e-mail du support] pour obtenir de l'aide.
                                        Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
                                        soumettre une nouvelle demande lorsque les problèmes seront résolus.
                                        <br>
                                        Cordialement,
                                        <br>
                                        L'équipe e-FDFP
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($planformation->email_professionnel_charge_plan_formation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
                }

                return redirect('traitementdemandeannulationplan/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/edit')->with('success', 'Succes : Operation validée avec succes ');
            }

        }
    }
}
