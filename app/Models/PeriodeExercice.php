<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_periode_exercice
 * @property float $id_user
 * @property string $date_debut_periode_exercice
 * @property string $date_fin_periode_exercice
 * @property string $date_prolongation_periode_exercice
 * @property string $motif_prolongation_periode_exercice
 * @property string $commentaire_periode_exercice
 * @property boolean $flag_actif_periode_exercice
 * @property string $created_at
 * @property string $updated_at
 * @property float $annee
 * @property PlanFormation[] $planFormations
 * @property User $user
 */
class PeriodeExercice extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'periode_exercice';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_periode_exercice';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'date_debut_periode_exercice', 'date_fin_periode_exercice', 'date_prolongation_periode_exercice', 'motif_prolongation_periode_exercice', 'commentaire_periode_exercice', 'flag_actif_periode_exercice', 'created_at', 'updated_at', 'annee'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planFormations()
    {
        return $this->hasMany('App\Models\PlanFormation', 'id_annee_exercice', 'id_periode_exercice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
