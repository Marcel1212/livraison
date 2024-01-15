<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cahier_plan_formation
 * @property float $id_users_cahier_plan_formation
 * @property string $date_creer_cahier_plan_formation
 * @property string $date_soumis_cahier_plan_formation
 * @property string $commentaire_cahier_plan_formation
 * @property string $code_cahier_plan_formation
 * @property string $code_pieces_cahier_plan_formation
 * @property boolean $flag_cahier_plan_formation
 * @property boolean $flag_statut_cahier_plan_formation
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property LigneCahierPlanFormation[] $ligneCahierPlanFormations
 */
class CahierPlanFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cahier_plan_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cahier_plan_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_users_cahier_plan_formation', 'date_creer_cahier_plan_formation', 'date_soumis_cahier_plan_formation', 'commentaire_cahier_plan_formation', 'code_cahier_plan_formation', 'code_pieces_cahier_plan_formation', 'flag_cahier_plan_formation', 'flag_statut_cahier_plan_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_users_cahier_plan_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ligneCahierPlanFormations()
    {
        return $this->hasMany('App\Models\LigneCahierPlanFormation', 'id_cahier_plan_formation', 'id_cahier_plan_formation');
    }
}
