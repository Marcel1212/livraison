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
use App\Models\DemandeAnnulationPlan;
use App\Models\DemandeSubstitutionActionPlanFormation;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrement;
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
//                    ->join('entreprises','plan_formation.id_entreprises','entreprises.id_entreprises')
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
        $fiche_a_demande_agrement = new FicheADemandeAgrement();
        $beneficiaire_formation = new BeneficiairesFormation();

        $motifs = Motif::where('code_motif','SAF')->get();
        $typeformations = TypeFormation::all();
        $categorieprofessionelles = CategorieProfessionelle::all();
        $structureformations = Entreprises::where('flag_habilitation_entreprise',true)->get();
        $motif_substitutions = Motif::where('code_motif','SAF')->get();

        $actionplanformation = ActionFormationPlan::where('id_action_formation_plan',$id_action)->first();

        $infoentreprise = Entreprises::find(@$actionplanformation->planFormation->id_entreprises);
        $categorieplans = CategoriePlan::where('id_plan_de_formation', @$actionplanformation->planFormation->id_plan_de_formation)->get();
            $demande_substitution = DemandeSubstitutionActionPlanFormation::
            where('id_action_formation_plan_substi',$id_action)
                ->where('id_plan_de_formation_substi',@$actionplanformation->planFormation->id_plan_de_formation)
                ->first();

        $planformation = PlanFormation::where('id_plan_de_formation',$actionplanformation->planFormation->id_plan_de_formation)->first();

//        if(isset($id_action)){
//            $actionplanformation = ActionFormationPlan::where('id_action_formation_plan',$id_action)->first();

//
//            if(isset($demande_substitution)){
//                $fiche_a_demande_agrement = FicheADemandeAgrement::where('id_action_formation_plan_substi',$demande_substitution->id_action_formation_plan_substi)->first();
//                $beneficiaire_formation = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->first();
//            }
//
//            if(isset($actionplanformation)){
//                return view('agreement.substitution',compact('beneficiaire_formation','demande_substitution','fiche_a_demande_agrement','motifs','actionplanformation','actionplanformations','structureformations','categorieprofessionelles','typeformations','butformations'));
//            }
//        }


//        <a href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($action_formation->),

//        if(isset($id)){
//            $demande_substitution = DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_substi',$id)->first();
//            if(isset($demande_substitution)){
//                $action_formation = ActionFormationPlan::where('id_action_formation_plan',$demande_substitution->id_action_formation_plan_a_substi)->first();
////                $fiche_a_demande_agrement_acien = FicheADemandeAgrement::where('id_action_formation_plan',$action_formation->id_action_formation_plan)->first();
////                $fiche_a_demande_agrement = FicheADemandeAgrement::where('id_action_formation_plan_substi',$demande_substitution->id_action_formation_plan_substi)->first();
////                $beneficiaire_formation = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->first();
//            }
//        }

//        if(isset($demande_substitution)){
//            }


//
//        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$demande_annulation->id_plan_formation],['flag_valide_action_formation_pl','=',true]])->get();
//        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$demande_annulation->id_plan_formation],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();
//
//        $nombreactionvalider = count($actionvalider);
//        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);
        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $type_entreprises = TypeEntreprise::where([['flag_type_entreprise','=',true]])->get();
        $typeentreprise = "<option value=''> Selectionnez le type d'entreprise </option>";
        foreach ($type_entreprises as $comp) {
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

        return view('traitementdemandesubstitutionplan.edit', compact('motif_substitutions',
            'caracteristiques',
            'infoentreprise',
            'secteuractivites','ResultProssesList','actionplanformation',
            'planformation',
            'pay',
            'etape',
            'categorieplans',
            'typeentreprise',
            'butformations','typeformations','categorieprofessionelles',
            'structureformations','motifs','demande_substitution',
            'id2','ResultProssesList','parcoursexist'));
    }


    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        if(isset($id)){
            $demande_substitution = DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_substi',$id)->first();
            if(isset($demande_substitution)){
                $action_formation = ActionFormationPlan::where('id_action_formation_plan',$demande_substitution->id_action_formation_plan_substi)->first();
//                $fiche_a_demande_agrement = FicheADemandeAgrement::where('id_action_formation_plan_substi',$demande_substitution->id_action_formation_plan_substi)->first();
//                $beneficiaire_formation = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->first();
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
                    $demande_substitution->flag_demande_substitution_action_valider_par_processus = true;
                    $demande_substitution->flag_validation_demande_plan_substi = true;
                    $demande_substitution->date_validation_demande_plan_substi = now();
                    $demande_substitution->update();
                }
                return redirect('traitementdemandesubstitutionplan/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/edit')->with('success', 'Succes : Operation validée avec succes ');
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

                return redirect('traitementdemandesubstitutionplan/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/edit')->with('success', 'Succes : Operation validée avec succes ');
            }

        }
    }
}
