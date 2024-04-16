<?php

namespace App\Http\Controllers;

use App\Models\ActionFormationPlan;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CaracteristiqueTypeFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\DemandeSubstitutionActionPlanFormation;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PlanFormation;
use App\Models\SecteurActivite;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use Illuminate\Http\Request;
use App\Helpers\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
@ini_set('max_execution_time',0);
class TraitementSubstitutionController extends Controller
{
    //
    public function index()
    {
            $actionplanformations = ActionFormationPlan::
            join('demande_substi_action_formation','action_formation_plan.id_action_formation_plan','demande_substi_action_formation.id_action_formation_plan_substi')
            ->join('users','demande_substi_action_formation.id_user','users.id')
            ->where('demande_substi_action_formation.flag_validation_demande_plan_substi',true)
                ->where('demande_substi_action_formation.flag_traiter_demande_plan_substi',false)
                ->where('demande_substi_action_formation.id_user', Auth::user()->id)
            ->get();
        return view('agreement.substitution',compact('actionplanformations'));
    }

    public function edit($id,$etape)
    {
        $id = Crypt::UrldeCrypt($id);
        $id_action = $id;
        $etape = Crypt::UrldeCrypt($etape);
        $actionplanformation = ActionFormationPlan::
        select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*','secteur_activite.id_secteur_activite as id_secteur_activitee','secteur_activite.libelle_secteur_activite')->
        join('demande_substi_action_formation','action_formation_plan.id_action_formation_plan','demande_substi_action_formation.id_action_formation_plan_substi')
            ->join('users','demande_substi_action_formation.id_user','users.id')
            ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
            ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
            ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
            ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
            ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
            ->join('secteur_activite','action_formation_plan.id_secteur_activite','=','secteur_activite.id_secteur_activite')
            ->where('demande_substi_action_formation.flag_validation_demande_plan_substi',true)
            ->where('demande_substi_action_formation.flag_traiter_demande_plan_substi',false)
            ->where('action_formation_plan.id_action_formation_plan',$id)
            ->where('demande_substi_action_formation.id_user', Auth::user()->id)
            ->first();

        $caracteristiques = CaracteristiqueTypeFormation::All();

        $butformations = ButFormation::where([['flag_actif_but_formation','=',true]])->get();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }



        $secteuractivites = SecteurActivite::all();
        $fiche_a_demande_agrement = new FicheADemandeAgrement();
        $beneficiaire_formation = new BeneficiairesFormation();

        $motifs = Motif::where('code_motif','SAF')->get();
        $typeformations = TypeFormation::all();
        $categorieprofessionelles = CategorieProfessionelle::all();
        $structureformations = Entreprises::where('flag_habilitation_entreprise',true)->get();
        $motif_substitutions = Motif::where('code_motif','SAF')->get();

        $payss = Pays::all();
        $paysc = "<option value=''> ---Selectionnez un pays--- </option>";
        foreach ($payss as $comp) {
            $paysc .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $infoentreprise = Entreprises::find(@$actionplanformation->planFormation->id_entreprises);
        $categorieplans = CategoriePlan::where('id_plan_de_formation', @$actionplanformation->planFormation->id_plan_de_formation)->get();
        $demande_substitution = DemandeSubstitutionActionPlanFormation::
        where('id_action_formation_plan_substi',$id_action)
            ->where('id_plan_de_formation_substi',@$actionplanformation->planFormation->id_plan_de_formation)
            ->first();

        $planformation = PlanFormation::where('id_plan_de_formation',$actionplanformation->planFormation->id_plan_de_formation)->first();


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

        $typeformations = TypeFormation::where([['flag_actif_formation','=',true]])->get();
        $typeformation = "<option value=''> Selectionnez le type  de la formation </option>";
        foreach ($typeformations as $comp) {
            $typeformation .= "<option value='" . $comp->id_type_formation  . "'>" . mb_strtoupper($comp->type_formation) ." </option>";
        }

        return view('agreement.editsubstitution', compact('motif_substitutions',
            'caracteristiques',
            'infoentreprise',
            'secteuractivites','actionplanformation',
            'planformation',
            'pay',
            'etape',
            'categorieplans',
            'typeentreprise',
            'butformation','typeformation','categorieprofessionelles',
            'structureformations','motifs','demande_substitution','paysc'
            ));
    }

    public function update(Request $request,$id){
        $id = Crypt::UrldeCrypt($id);
        $id_action = $id;
        $action = ActionFormationPlan::find($id);

        $fiche_a_demande = FicheADemandeAgrement::where('id_action_formation_plan',$id_action)->first();
        $fiche_a_demande->id_type_formation = $request->id_type_formation;
        $fiche_a_demande->id_but_formation = $request->id_but_formation;
        $fiche_a_demande->lieu_formation_fiche_agrement = $request->lieu_formation_fiche_agrement;
        $fiche_a_demande->objectif_pedagogique_fiche_agre = $request->objectif_pedagogique_fiche_agre;
        $fiche_a_demande->update();

        $action->intitule_action_formation_plan = $request->intitule_action_formation_plan;
        $action->structure_etablissement_action_ = $request->structure_etablissement_action_;
        $action->id_entreprise_structure_formation_action = $request->id_entreprise_structure_formation_action;
        $action->id_caracteristique_type_formation = $request->id_caracteristique_type_formation;
        $action->update();

        $substitution = DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan',$id_action)->first();
        $substitution->flag_traiter_demande_plan_substi = true;
        $substitution->date_traiter_demande_plan_substi = now();
        $substitution->update();

        return redirect('traitementsubstitution')->with('success', 'Succes : Traitement effectué avec succès ');
    }
}
