<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_activites
 * @property string $libelle_activites
 * @property boolean $flag_activites
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeEnrolement[] $demandeEnrolements
 */
class Activites extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_activites';

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
    protected $fillable = ['libelle_activites', 'flag_activites', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'id_activites', 'id_activites');
    }
}
