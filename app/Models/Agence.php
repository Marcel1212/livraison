<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $num_agce
 * @property string $lib_agce
 * @property boolean $flag_agce
 * @property string $code_agce
 * @property boolean $flag_siege_agce
 * @property string $tel_agce
 * @property string $adresse_agce
 * @property string $created_at
 * @property string $updated_at
 * @property string $coordonne_gps_agce
 * @property string $localisation_agce
 * @property Direction[] $directions
 */
class Agence extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'agence';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'num_agce';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['lib_agce', 'flag_agce', 'code_agce', 'flag_siege_agce', 'tel_agce', 'adresse_agce', 'created_at', 'updated_at', 'coordonne_gps_agce', 'localisation_agce'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function directions()
    {
        return $this->hasMany('App\Models\Direction', 'num_agce', 'num_agce');
    }
}
