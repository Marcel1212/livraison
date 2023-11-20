<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_plan_de_formation
 * @property float $id_type_entreprise
 * @property float $id_entreprises
 * @property float $id_motif_recevable
 * @property float $id_annee_exercice
 * @property float $id_entreprise_structure_formation_plan_formation
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
 * @property ActionFormationPlan[] $actionFormationPlans
 * @property TypeEntreprise $typeEntreprise
 * @property Entreprise $entreprise
 * @property Motif $motif
 * @property PeriodeExercice $periodeExercice
 * @property EntrepriseHabilitation $entreprisehabilitation
 * @property UserConseilPlanFormation $userconseilplanformation
 * @property CategoriePlan[] $categoriePlans
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
    protected $fillable = ['id_type_entreprise', 'id_entreprises', 'id_motif_recevable', 'id_annee_exercice', 'id_entreprise_structure_formation_plan_formation', 'nom_prenoms_charge_plan_formati', 'fonction_charge_plan_formation', 'nombre_salarie_plan_formation', 'masse_salariale', 'part_entreprise', 'cout_total', 'date_creation', 'id_user', 'flag_soumis_plan_formation', 'flag_valide_plan_formation', 'flag_rejeter_plan_formation', 'user_conseiller', 'conde_entreprise_plan_formation', 'code_plan_formation', 'created_at', 'updated_at', 'flag_recevablite_plan_formation', 'date_recevabilite_plan_formatio', 'date_soumis_plan_formation', 'date_valide_plan_formation', 'date_rejet_paln_formation', 'email_professionnel_charge_plan_formation', 'commentaire_recevable_plan_formation', 'flag_soumis_ct_plan_formation', 'date_soumis_ct_plan_formation'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionFormationPlans()
    {
        return $this->hasMany('App\Models\ActionFormationPlan', 'id_plan_de_formation', 'id_plan_de_formation');
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
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprises', 'id_entreprises');
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
    public function periodeExercice()
    {
        return $this->belongsTo('App\Models\PeriodeExercice', 'id_annee_exercice', 'id_periode_exercice');
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
    public function userconseilplanformation()
    {
        return $this->belongsTo('App\Models\User', 'user_conseiller', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriePlans()
    {
        return $this->hasMany('App\Models\CategoriePlan', 'id_plan_de_formation', 'id_plan_de_formation');
    }
}
