<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cont_agce
 * @property float $num_agce
 * @property float $id_processus
 * @property boolean $is_valide
 * @property string $created_at
 * @property string $updated_at
 * @property Agence $agence
 * @property Processu $processu
 * @property CombinaisonProcessu[] $combinaisonProcessuses
 */
class ContenirAgence extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'contenir_agence';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cont_agce';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['num_agce', 'id_processus', 'is_valide', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agence()
    {
        return $this->belongsTo('App\Models\Agence', 'num_agce', 'num_agce');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processu()
    {
        return $this->belongsTo('App\Models\Processu', 'id_processus', 'id_processus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function combinaisonProcessuses()
    {
        return $this->hasMany('App\Models\CombinaisonProcessu', 'id_cont_agce', 'id_cont_agce');
    }
}
