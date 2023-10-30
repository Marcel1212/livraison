<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_centre_impot
 * @property string $libelle_centre_impot
 * @property boolean $flag_centre_impot
 * @property DemandeEnrolement[] $demandeEnrolements
 */
class CentreImpot extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'centre_impot';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_centre_impot';

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
    protected $fillable = ['libelle_centre_impot', 'flag_centre_impot'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'id_centre_impot', 'id_centre_impot');
    }
}
