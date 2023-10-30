<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_localite
 * @property string $libelle_localite
 * @property boolean $flag_localite
 * @property DemandeEnrolement[] $demandeEnrolements
 */
class Localite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'localite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_localite';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['libelle_localite', 'flag_localite'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'id_localite', 'id_localite');
    }
}
