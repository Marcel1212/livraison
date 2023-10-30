<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_departement
 * @property float $id_direction
 * @property string $libelle_departement
 * @property boolean $flag_departement
 * @property string $created_at
 * @property string $updated_at
 * @property Direction $direction
 * @property Service[] $services
 */
class Departement extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'departement';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_departement';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_direction', 'libelle_departement', 'flag_departement', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function direction()
    {
        return $this->belongsTo('App\Models\Direction', 'id_direction', 'id_direction');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany('App\Models\Service', 'id_departement', 'id_departement');
    }
}
