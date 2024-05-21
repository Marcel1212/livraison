<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_vpcrf
 * @property float $id_user
 * @property float $valeur_vpcrf
 * @property string $commentaire_vpcrf
 * @property boolean $flag_actif_vpcrf
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $flag_signe_variation
 * @property User $user
 */
class VariationPourcentageCleRepartitionFin extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'variation_pourcentage_cle_repartition_fin';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_vpcrf';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'valeur_vpcrf', 'commentaire_vpcrf', 'flag_actif_vpcrf', 'created_at', 'updated_at', 'flag_signe_variation'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
