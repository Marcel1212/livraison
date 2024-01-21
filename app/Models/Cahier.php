<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cahier
 * @property float $id_comite_pleniere
 * @property float $id_user_cahier
 * @property float $id_demande
 * @property boolean $flag_cahier
 * @property string $commentaire_cahier
 * @property string $created_at
 * @property string $updated_at
 * @property ComitePleniere $comitePleniere
 * @property User $user
 */
class Cahier extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cahier';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_cahier';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_comite_pleniere', 'id_user_cahier', 'id_demande', 'flag_cahier', 'id_motif', 'commentaire_cahier', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comitePleniere()
    {
        return $this->belongsTo('App\Models\ComitePleniere', 'id_comite_pleniere', 'id_comite_pleniere');
    }

    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif', 'id_motif');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_cahier');
    }
}
