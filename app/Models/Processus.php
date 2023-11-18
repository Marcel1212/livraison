<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_processus
 * @property string $lib_processus
 * @property boolean $is_valide
 * @property string $created_at
 * @property string $updated_at
 * @property ContenirAgence[] $contenirAgences
 */
class Processus extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'processus';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_processus';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['lib_processus', 'is_valide', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contenirAgences()
    {
        return $this->hasMany('App\Models\ContenirAgence', 'id_processus', 'id_processus');
    }
}
