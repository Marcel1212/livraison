<?php

namespace App\Http\Controllers;

use App\Helpers\Crypt;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\ActionFormationPlan;
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CaracteristiqueTypeFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Helpers\Email;
use App\Models\DemandeAnnulationPlan;
use App\Models\DemandeSubstitutionActionPlanFormation;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrement;
use App\Models\FicheAgrementButFormation;
use App\Models\Motif;
use App\Models\Parcours;
use App\Models\Pays;
use App\Models\PlanFormation;
use App\Models\SecteurActivite;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
@ini_set('max_execution_time',0);
class TraitementDemandeSubstitutionPlanController extends Controller
{
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
                    ->join('demande_substi_action_formation','p.id_demande','demande_substi_action_formation.id_action_formation_plan_substi')
                    ->join('action_formation_plan','action_formation_plan.id_action_formation_plan','demande_substi_action_formation.id_action_formation_plan_substi')
                    ->join('users','demande_substi_action_formation.id_user','users.id')
                    ->where([
                        ['v.mini', '=', $r->priorite_combi_proc],
                        ['v.id_processus', '=', $r->id_processus],
                        ['v.code', '=', 'SAF'],
                        ['p.id_roles', '=', $id_roles]
                    ])->get();

            }
        }

        return view('traitementdemandesubstitutionplan.index',compact('resultat'));
    }

    public function edit(string $id,string $id2,string $etape)
    {
        $id_action =  \App\Helpers\Crypt::UrldeCrypt($id);
        $id2 =  \App\Helpers\Crypt::UrldeCrypt($id2);
        $etape =  \App\Helpers\Crypt::UrldeCrypt($etape);

        $caracteristiques = CaracteristiqueTypeFormation::All();
        $butformations = ButFormation::all();
        $secteuractivites = SecteurActivite::all();
        $beneficiaire_formation = new BeneficiairesFormation();

        $fiche_a_demande_agrement = FicheADemandeAgrement::where('id_action_formation_plan',$id_action)->first();

        $butformationsficheademandeagrements = FicheAgrementButFormation::where('id_fiche_agrement',
            @$fiche_a_demande_agrement->id_fiche_agrement)->get();

        $motifs = Motif::where('code_motif','SAF')->get();
        $typeformations = TypeFormation::all();
        $categorieprofessionelles = CategorieProfessionelle::all();
        $structureformations = Entreprises::where('flag_habilitation_entreprise',true)->get();
        $motif_substitutions = Motif::where('code_motif','SAF')->get();

        $actionplanformation = ActionFormationPlan::select('action_formation_plan.*','demande_substi_action_formation.*','plan_formation.*','entreprises.*','domaine_formation.*','fiche_a_demande_agrement.*','type_formation.*')->
                  join('demande_substi_action_formation','action_formation_plan.id_action_formation_plan','demande_substi_action_formation.id_action_formation_plan_substi')
                ->join('users','demande_substi_action_formation.id_user','users.id')
                ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                ->join('domaine_formation','domaine_formation.id_domaine_formation','=','domaine_formation.id_domaine_formation')
                ->where('action_formation_plan.id_action_formation_plan',$id_action)
                ->first();

        $infoentreprise = Entreprises::find(@$actionplanformation->id_entreprises);
        $categorieplans = CategoriePlan::where('id_plan_de_formation', @$actionplanformation->id_plan_de_formation)->get();
            $demande_substitution = DemandeSubstitutionActionPlanFormation::
            where('id_action_formation_plan_substi',$id_action)
                ->where('id_plan_de_formation_substi',@$actionplanformation->id_plan_de_formation)
                ->first();

        $planformation = PlanFormation::where('id_plan_de_formation',$actionplanformation->id_plan_de_formation)->first();

        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $typeentreprises = TypeEntreprise::where([['flag_type_entreprise','=',true]])->get();
        $typeentreprise = "<option value='".$planformation->typeEntreprise->id_type_entreprise."'>".$planformation->typeEntreprise->lielle_type_entrepise." </option>";
        foreach ($typeentreprises as $comp) {
            $typeentreprise .= "<option value='" . $comp->id_type_entreprise  . "'>" . mb_strtoupper($comp->lielle_type_entrepise) ." </option>";
        }

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
                'v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $demande_substitution->id_processus)
            ->where('v.id_demande', '=', $demande_substitution->id_action_formation_plan_substi)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();


        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$demande_substitution->id_processus],
            ['id_user','=',$idUser],
            ['id_piece','=',$id_action],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id2]
        ])->get();

        $infosprocessus = DB::table('vue_processus')
            ->where('id_combi_proc', '=', $id2)
            ->first();

        $idProComb = $infosprocessus->id_combi_proc;
        $idProcessus = $infosprocessus->id_processus;

        $ResultCptVal = DB::table('combinaison_processus as v')
            ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
            ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
            ->where('a.id_demande', '=', $id_action)
            ->where('a.id_processus', '=', $idProcessus)
            ->where('v.id_roles', '=', $Idroles)
            ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
            ->first();

        return view('traitementdemandesubstitutionplan.edit', compact('motif_substitutions',
            'caracteristiques',
            'infoentreprise',
            'secteuractivites','ResultProssesList','actionplanformation',
            'planformation',
            'pay',
            'ResultCptVal',
            'etape',
            'categorieplans',
            'butformationsficheademandeagrements',
            'typeentreprise',
            'butformations','typeformations','categorieprofessionelles',
            'structureformations','motifs','demande_substitution',
            'id2','ResultProssesList','parcoursexist'));
    }


    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $logo = Menu::get_logo();

        if(isset($id)){
            $demande_substitution = DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_substi',$id)->first();
            if(isset($demande_substitution)){
                $action_formation = ActionFormationPlan::where('id_action_formation_plan',$demande_substitution->id_action_formation_plan_substi)->first();
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

                Parcours::create(
                    [
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
                    $action = ActionFormationPlan::find($id);
                    $substitution = DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_substi',$id)->first();
                    $fiche_a_demande = FicheADemandeAgrement::where('id_action_formation_plan',$id)->first();


                    $old_intitule_action_formation_plan_substi = $substitution->intitule_action_formation_plan_substi;
                    $old_structure_etablissement_action_substi = $substitution->structure_etablissement_action_substi;
                    $old_id_entreprise_structure_formation_action_substi = $substitution->id_entreprise_structure_formation_action_substi;
                    $old_id_caracteristique_type_formation_substi = $substitution->id_caracteristique_type_formation_substi;
                    $old_id_domaine_formation_substi = $substitution->id_domaine_formation_substi;

                    $old_id_type_formation = $substitution->id_type_formation_substi;
                    $old_id_but_formation = $substitution->id_but_formation_substi;
                    $old_lieu_formation_fiche_agrement = $substitution->lieu_formation_fiche_agrement_substi;
                    $old_objectif_pedagogique_fiche_agre = $substitution->objectif_pedagogique_fiche_agre_substi;


                    $fiche_a_demande->id_type_formation = $substitution->id_type_formation_substi;
                    $fiche_a_demande->lieu_formation_fiche_agrement = $substitution->lieu_formation_fiche_agrement_substi;
                    $fiche_a_demande->objectif_pedagogique_fiche_agre = $substitution->objectif_pedagogique_fiche_agre_substi;
                    $fiche_a_demande->update();

                    $action->intitule_action_formation_plan = $substitution->intitule_action_formation_plan_substi;
                    $action->structure_etablissement_action_ = $substitution->structure_etablissement_action_substi;
                    $action->id_entreprise_structure_formation_action = $substitution->id_entreprise_structure_formation_action_substi;
                    $action->id_caracteristique_type_formation = $substitution->id_caracteristique_type_formation_substi;
                    $action->id_domaine_formation = $substitution->id_domaine_formation;
                    $action->update();

                    $substitution->intitule_action_formation_plan_substi = $old_intitule_action_formation_plan_substi;
                    $substitution->structure_etablissement_action_substi = $old_structure_etablissement_action_substi;
                    $substitution->id_entreprise_structure_formation_action_substi = $old_id_entreprise_structure_formation_action_substi;
                    $substitution->id_caracteristique_type_formation_substi = $old_id_caracteristique_type_formation_substi;
                    $substitution->id_type_formation_substi = $old_id_type_formation;
                    $substitution->id_but_formation_substi = $old_id_but_formation;
                    $substitution->lieu_formation_fiche_agrement_substi = $old_lieu_formation_fiche_agrement;
                    $substitution->objectif_pedagogique_fiche_agre_substi = $old_objectif_pedagogique_fiche_agre;
                    $substitution->id_domaine_formation_substi = $old_id_domaine_formation_substi;
                    $substitution->flag_demande_substitution_action_valider_par_processus = true;
                    $substitution->flag_validation_demande_plan_substi = true;
                    $substitution->date_validation_demande_plan_substi = now();
                    $substitution->update();


                    $planformation = PlanFormation::where('id_plan_de_formation',$action->id_plan_de_formation)->first();
                    $infoentreprise = Entreprises::find(@$planformation->id_entreprises);

                    //Envoi Mail à l'entreprise pour la prise en compte  de la demande de substitution
                    if (isset($planformation->email_professionnel_charge_plan_formation)) {
                        $sujet = "Substitution de d'action de formation sur e-FDFP";
                        $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                        $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                        <br><br>Nous avons examiné votre demande de substitution de l'action

                                        de formation intitulé : ".$action->intitule_action_formation_plan." sur e-FDFP, et
                                        elle a été approuvé avec succès."."
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
                        $messageMailEnvoi = Email::get_envoimailTemplate($planformation->email_professionnel_charge_plan_formation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
                    }
                }else{
                    if (@$ResultCptVal->priorite_combi_proc==1){
                        $substitution = DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_substi',$id)->first();
                        $substitution->intitule_action_formation_plan_substi = $request->intitule_action_formation_plan;
                        $substitution->objectif_pedagogique_fiche_agre_substi = $request->objectif_pedagogique_fiche_agre_val;
                        $substitution->id_but_formation_substi = $request->id_but_formation;
                        $substitution->id_type_formation_substi = $request->id_type_formation;
                        $substitution->id_caracteristique_type_formation_substi = $request->id_caracteristique_type_formation;
                        $substitution->id_entreprise_structure_formation_action_substi = $request->id_entreprise_structure_formation_plan_formation;
                        $entreprise = Entreprises::find($request->id_entreprise_structure_formation_plan_formation);
                        $substitution->structure_etablissement_action_substi =mb_strtoupper($entreprise->raison_social_entreprises);
                        $substitution->lieu_formation_fiche_agrement_substi = $request->lieu_formation_fiche_agrement;
                        $substitution->id_domaine_formation_substi = $request->id_domaine_formation;
                        $substitution->update();
                    }
                }
                return redirect('traitementdemandesubstitutionplan/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Operation validée avec succes ');
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

                Parcours::create(
                    [
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
                    $demande_substitution->flag_rejeter_demande_annulation_plan = true;
                    $demande_substitution->date_validation_demande_annulation_plan = now();
                    $demande_substitution->update();


                }

                //Envoi Mail à l'entreprise pour la prise le rejet de la demande de substitution


                return redirect('traitementdemandesubstitutionplan/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/edit')->with('success', 'Succes : Operation validée avec succes ');
            }

        }
    }
}
