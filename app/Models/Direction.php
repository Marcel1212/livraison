<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_direction
 * @property float $num_agce
 * @property string $libelle_direction
 * @property boolean $flag_direction
 * @property string $created_at
 * @property string $updated_at
 * @property Departement[] $departements
 */
class Direction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'direction';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_direction';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = [ 'libelle_direction', 'flag_direction', 'created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departements()
    {
        return $this->hasMany('App\Models\Departement', 'id_direction', 'id_direction');
    }
}
