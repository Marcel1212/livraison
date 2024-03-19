<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cahier_comite
 * @property float $id_comite
 * @property float $id_demande
 * @property boolean $flag_cahier
 * @property string $commentaire_cahier
 * @property string $created_at
 * @property string $updated_at
 * @property string $code_demande
 * @property Comite $comite
 */
class CahierComite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cahier_comite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cahier_comite';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_comite', 'id_demande', 'flag_cahier', 'commentaire_cahier', 'created_at', 'updated_at', 'code_demande'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comite()
    {
        return $this->belongsTo('App\Models\Comite', 'id_comite', 'id_comite');
    }
}
