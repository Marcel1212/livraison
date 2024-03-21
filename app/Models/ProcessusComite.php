<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_processus_comite
 * @property string $code_processus_comite
 * @property string $libelle_processus_comite
 * @property boolean $flag_processus_comite
 * @property string $created_at
 * @property string $updated_at
 * @property ProcessusComiteLieComite[] $processusComiteLieComites
 */
class ProcessusComite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'processus_comite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_processus_comite';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['code_processus_comite', 'libelle_processus_comite', 'flag_processus_comite', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processusComiteLieComites()
    {
        return $this->hasMany('App\Models\ProcessusComiteLieComite', 'id_processus_comite', 'id_processus_comite');
    }
}
