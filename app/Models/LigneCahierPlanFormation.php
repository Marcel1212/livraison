<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_ligne_cahier_plan_formation
 * @property float $id_cahier_plan_formation
 * @property float $id_plan_formation
 * @property boolean $flag_ligne_cahier_plan_formation
 * @property boolean $flag_statut_soumis_ligne_cahier_plan_formation
 * @property string $created_at
 * @property string $updated_at
 * @property CahierPlanFormation $cahierPlanFormation
 * @property PlanFormation $planFormation
 */
class LigneCahierPlanFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ligne_cahier_plan_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_ligne_cahier_plan_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_cahier_plan_formation', 'id_plan_formation', 'flag_ligne_cahier_plan_formation', 'flag_statut_soumis_ligne_cahier_plan_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cahierPlanFormation()
    {
        return $this->belongsTo('App\Models\CahierPlanFormation', 'id_cahier_plan_formation', 'id_cahier_plan_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planFormation()
    {
        return $this->belongsTo('App\Models\PlanFormation', 'id_plan_formation', 'id_plan_de_formation');
    }
}
