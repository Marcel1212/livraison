<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cle_de_repartition_financement
 * @property float $id_periode_exercice
 * @property float $marge_inferieur
 * @property float $marge_superieur
 * @property float $montant_fc
 * @property float $coefficient
 * @property string $signe_montant_fc
 * @property boolean $flag_cle_de_repartition_financement
 * @property string $observation
 * @property string $created_at
 * @property string $updated_at
 * @property PlanFormation[] $planFormations
 * @property PeriodeExercice $periodeExercice
 */
class CleDeRepartitionFinancement extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cle_de_repartition_financement';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cle_de_repartition_financement';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_periode_exercice', 'marge_inferieur', 'marge_superieur', 'montant_fc', 'coefficient', 'signe_montant_fc', 'flag_cle_de_repartition_financement', 'observation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planFormations()
    {
        return $this->hasMany('App\Models\PlanFormation', 'id_cle_de_repartition_financement', 'id_cle_de_repartition_financement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function periodeExercice()
    {
        return $this->belongsTo('App\Models\PeriodeExercice', 'id_periode_exercice', 'id_periode_exercice');
    }
}
