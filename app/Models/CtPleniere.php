<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_ct_pleniere
 * @property float $id_plan_formation
 * @property string $updated_at
 * @property string $created_at
 * @property PlanFormation $planFormation
 */
class CtPleniere extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ct_pleniere';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_ct_pleniere';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_plan_formation', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planFormation()
    {
        return $this->belongsTo('App\Models\PlanFormation', 'id_plan_formation', 'id_plan_de_formation');
    }
}
