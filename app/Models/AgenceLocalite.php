<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_agence_localite
 * @property float $id_agence
 * @property float $id_localite
 * @property boolean $flag_agence_localite
 * @property string $updated_at
 * @property string $created_at
 * @property Agence $agence
 * @property Localite $localite
 */
class AgenceLocalite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'agence_localite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_agence_localite';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_agence', 'id_localite', 'flag_agence_localite', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agence()
    {
        return $this->belongsTo('App\Models\Agence', 'id_agence', 'num_agce');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localite()
    {
        return $this->belongsTo('App\Models\Localite', 'id_localite', 'id_localite');
    }
}
