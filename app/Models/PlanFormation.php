<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_plan_de_formation
 * @property float $id_type_entreprise
 * @property float $id_entreprises
 * @property float $id_cle_de_repartition_financement
 * @property float $id_motif_recevable
 * @property float $id_annee_exercice
 * @property float $id_entreprise_structure_formation_plan_formation
 * @property float $id_processus
 * @property float $id_agence
 * @property float $id_part_entreprise
 * @property string $nom_prenoms_charge_plan_formati
 * @property string $fonction_charge_plan_formation
 * @property float $nombre_salarie_plan_formation
 * @property float $masse_salariale
 * @property float $part_entreprise
 * @property float $cout_total
 * @property string $date_creation
 * @property float $id_user
 * @property boolean $flag_soumis_plan_formation
 * @property boolean $flag_valide_plan_formation
 * @property boolean $flag_rejeter_plan_formation
 * @property float $user_conseiller
 * @property string $conde_entreprise_plan_formation
 * @property string $code_plan_formation
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $flag_recevablite_plan_formation
 * @property string $date_recevabilite_plan_formatio
 * @property string $date_soumis_plan_formation
 * @property string $date_valide_plan_formation
 * @property string $date_rejet_paln_formation
 * @property string $email_professionnel_charge_plan_formation
 * @property string $commentaire_recevable_plan_formation
 * @property boolean $flag_soumis_ct_plan_formation
 * @property string $date_soumis_ct_plan_formation
 * @property string $date_fiche_agrement
 * @property boolean $flag_valide_action_des_plan_formation
 * @property boolean $flag_plan_formation_valider_par_processus
 * @property boolean $flag_plan_validation_valider_par_comite_en_ligne
 * @property boolean $flag_plan_validation_rejeter_par_comite_en_ligne
 * @property boolean $flag_plan_formation_valider_par_comite_pleniere
 * @property float $cout_total_demande_plan_formation
 * @property float $cout_total_accorder_plan_formation
 * @property float $montant_financement_budget
 * @property boolean $flag_fiche_agrement
 * @property boolean $flag_plan_formation_valider_cahier
 * @property boolean $flag_plan_formation_valider_cahier_soumis_comite_permanente
 * @property string $date_fiche_agreement
 * @property float $id_secteur_activite
 * @property CtPleniere[] $ctPlenieres
 * @property ActionFormationPlan[] $actionFormationPlans
 * @property PlanFormationAValiderParUser[] $planFormationAValiderParUsers
 * @property CategoriePlan[] $categoriePlans
 * @property PeriodeExercice $periodeExercice
 * @property TypeEntreprise $typeEntreprise
 * @property Motif $motif
 * @property Agence $agence
 * @property Entreprises $entreprise
 * @property EntrepriseHabilitation $entreprisehabilitation
 * @property PartEntreprise $partEntreprise
 * @property Processus $processus
 * @property UserConseilPlanFormation $userconseilplanformation
 * @property SecteurActivite $secteurActivite
 * @property CleDeRepartitionFinancement $cleDeRepartitionFinancement
 */
class PlanFormation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plan_formation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_plan_de_formation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_entreprise', 'id_entreprises', 'id_motif_recevable', 'id_annee_exercice', 'id_entreprise_structure_formation_plan_formation', 'id_processus', 'id_agence', 'id_part_entreprise', 'nom_prenoms_charge_plan_formati', 'fonction_charge_plan_formation', 'nombre_salarie_plan_formation', 'masse_salariale', 'part_entreprise', 'cout_total', 'date_creation', 'id_user', 'flag_soumis_plan_formation', 'flag_valide_plan_formation', 'flag_rejeter_plan_formation', 'user_conseiller', 'conde_entreprise_plan_formation', 'code_plan_formation', 'created_at', 'updated_at', 'flag_recevablite_plan_formation', 'date_recevabilite_plan_formatio', 'date_soumis_plan_formation', 'date_valide_plan_formation', 'date_rejet_paln_formation', 'email_professionnel_charge_plan_formation', 'commentaire_recevable_plan_formation', 'flag_soumis_ct_plan_formation', 'date_soumis_ct_plan_formation', 'flag_valide_action_des_plan_formation', 'flag_plan_formation_valider_par_processus', 'flag_plan_validation_valider_par_comite_en_ligne', 'flag_plan_validation_rejeter_par_comite_en_ligne', 'flag_plan_formation_valider_par_comite_pleniere', 'cout_total_demande_plan_formation', 'cout_total_accorder_plan_formation', 'flag_fiche_agrement', 'date_fiche_agreement', 'id_secteur_activite','date_fiche_agrement','flag_plan_formation_valider_cahier','flag_plan_formation_valider_cahier_soumis_comite_permanente','montant_financement_budget','id_cle_de_repartition_financement'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ctPlenieres()
    {
        return $this->hasMany('App\Models\CtPleniere', 'id_plan_formation', 'id_plan_de_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionFormationPlans()
    {
        return $this->hasMany('App\Models\ActionFormationPlan', 'id_plan_de_formation', 'id_plan_de_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planFormationAValiderParUsers()
    {
        return $this->hasMany('App\Models\PlanFormationAValiderParUser', 'id_plan_formation', 'id_plan_de_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriePlans()
    {
        return $this->hasMany('App\Models\CategoriePlan', 'id_plan_de_formation', 'id_plan_de_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function periodeExercice()
    {
        return $this->belongsTo('App\Models\PeriodeExercice', 'id_annee_exercice', 'id_periode_exercice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeEntreprise()
    {
        return $this->belongsTo('App\Models\TypeEntreprise', 'id_type_entreprise', 'id_type_entreprise');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif_recevable', 'id_motif');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agence()
    {
        return $this->belongsTo('App\Models\Agence', 'id_agence', 'num_agce');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprises', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprisehabilitation()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprise_structure_formation_plan_formation', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partEntreprise()
    {
        return $this->belongsTo('App\Models\PartEntreprise', 'id_part_entreprise', 'id_part_entreprise');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processus()
    {
        return $this->belongsTo('App\Models\Processus', 'id_processus', 'id_processus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userconseilplanformation()
    {
        return $this->belongsTo('App\Models\User', 'user_conseiller', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteurActivite()
    {
        return $this->belongsTo('App\Models\SecteurActivite', 'id_secteur_activite', 'id_secteur_activite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cleDeRepartitionFinancement()
    {
        return $this->belongsTo('App\Models\CleDeRepartitionFinancement', 'id_cle_de_repartition_financement', 'id_cle_de_repartition_financement');
    }
}
