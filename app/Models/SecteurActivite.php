<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_secteur_activite
 * @property string $libelle_secteur_activite
 * @property boolean $flag_actif_secteur_activite
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeEnrolement[] $demandeEnrolements
 * @property Activites[] $activites
 */
class SecteurActivite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'secteur_activite';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_secteur_activite';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_secteur_activite', 'flag_actif_secteur_activite', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'id_secteur_activite', 'id_secteur_activite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activites()
    {
        return $this->hasMany('App\Models\Activites', 'id_secteur_activite', 'id_secteur_activite');
    }
}
