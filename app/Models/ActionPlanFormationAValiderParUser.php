<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_action_plan_formation_valider_par_user
 * @property float $id_user_conseil
 * @property float $id_action_plan_formation
 * @property float $id_plan_formation
 * @property boolean $flag_valide_action_plan_formation
 * @property float $id_motif
 * @property string $commentaire
 * @property string $updated_at
 * @property string $created_at
 * @property ActionFormationPlan $actionFormationPlan
 * @property User $user
 */
class ActionPlanFormationAValiderParUser extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'action_plan_formation_a_valider_par_user';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_action_plan_formation_valider_par_user';

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
    protected $fillable = ['id_user_conseil', 'id_action_plan_formation', 'id_plan_formation', 'flag_valide_action_plan_formation', 'id_motif', 'commentaire', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actionFormationPlan()
    {
        return $this->belongsTo('App\Models\ActionFormationPlan', 'id_action_plan_formation', 'id_action_formation_plan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_conseil','id');
    }
}
