<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_fiche_agrement
 * @property float $id_type_formation
 * @property float $id_action_formation_plan
 * @property string $date_debut_fiche_agrement
 * @property string $date_fin_fiche_agrement
 * @property string $lieu_formation_fiche_agrement
 * @property float $cout_total_fiche_agrement
 * @property string $objectif_pedagogique_fiche_agre
 * @property string $file_beneficiare_fiche_agrement
 * @property boolean $flag_valide_fiche_agrement
 * @property string $created_at
 * @property string $updated_at
 * @property float $cadre_fiche_demande_agrement
 * @property float $agent_maitrise_fiche_demande_ag
 * @property float $employe_fiche_demande_agrement
 * @property float $total_beneficiaire_fiche_demand
 * @property BeneficiairesFormation[] $beneficiairesFormations
 * @property TypeFormation $typeFormation
 * @property ButFormation $butFormation
 * @property ActionFormationPlan $actionFormationPlan
 */
class FicheADemandeAgrement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fiche_a_demande_agrement';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_fiche_agrement';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_formation', 'id_action_formation_plan_substi', 'id_action_formation_plan', 'date_debut_fiche_agrement', 'date_fin_fiche_agrement', 'lieu_formation_fiche_agrement', 'cout_total_fiche_agrement', 'objectif_pedagogique_fiche_agre', 'flag_valide_fiche_agrement', 'created_at', 'updated_at', 'cadre_fiche_demande_agrement', 'agent_maitrise_fiche_demande_ag', 'employe_fiche_demande_agrement', 'total_beneficiaire_fiche_demand','file_beneficiare_fiche_agrement'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beneficiairesFormations()
    {
        return $this->hasMany('App\Models\BeneficiairesFormation', 'id_fiche_agrement', 'id_fiche_agrement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeFormation()
    {
        return $this->belongsTo('App\Models\TypeFormation', 'id_type_formation', 'id_type_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
/*     public function butFormation()
    {
        return $this->belongsTo('App\Models\ButFormation', 'id_but_formation', 'id_but_formation');
    } */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actionFormationPlan()
    {
        return $this->belongsTo('App\Models\ActionFormationPlan', 'id_action_formation_plan', 'id_action_formation_plan');
    }

    //protected $dates = ['date_debut_fiche_agrement', 'date_fin_fiche_agrement'];
    protected $casts = [
        'date_debut_fiche_agrement' => 'datetime',
        'date_fin_fiche_agrement' => 'datetime'
    ];
}
