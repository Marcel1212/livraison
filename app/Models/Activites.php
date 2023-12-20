<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_activites
 * @property float $id_secteur_activite
 * @property string $libelle_activites
 * @property boolean $flag_activites
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeEnrolement[] $demandeEnrolements
 * @property SecteurActiviteUserConseiller[] $secteurActiviteUserConseillers
 * @property Entreprises[] $entreprises
 * @property SecteurActivite $secteurActivite
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
     * @var array
     */
    protected $fillable = ['id_secteur_activite', 'libelle_activites', 'flag_activites', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'id_activites', 'id_activites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function secteurActiviteUserConseillers()
    {
        return $this->hasMany('App\Models\SecteurActiviteUserConseiller', 'id_secteur_activite', 'id_activites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entreprises()
    {
        return $this->hasMany('App\Models\Entreprises', 'id_activite_entreprises', 'id_activites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteurActivite()
    {
        return $this->belongsTo('App\Models\SecteurActivite', 'id_secteur_activite', 'id_secteur_activite');
    }
}
