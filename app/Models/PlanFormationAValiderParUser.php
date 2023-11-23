<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_plan_formation_valide_user
 * @property float $id_user_conseil
 * @property float $id_plan_formation
 * @property boolean $flag_valide_plan_formation
 * @property string $date_valide_plan_formation
 * @property string $updated_at
 * @property string $created_at
 * @property User $user
 * @property PlanFormation $planFormation
 */
class PlanFormationAValiderParUser extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'plan_formation_a_valider_par_user';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_plan_formation_valide_user';

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
    protected $fillable = ['id_user_conseil', 'id_plan_formation', 'flag_valide_plan_formation', 'date_valide_plan_formation', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_conseil','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planFormation()
    {
        return $this->belongsTo('App\Models\PlanFormation', 'id_plan_formation', 'id_plan_de_formation');
    }
}
