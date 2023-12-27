<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_activites_entreprises
 * @property float $id_entreprises
 * @property float $id_activites
 * @property boolean $flag_activites_entreprises
 * @property string $created_at
 * @property string $updated_at
 * @property Activites $activite
 * @property Entreprises $entreprise
 */
class ActivitesEntreprises extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_activites_entreprises';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_entreprises', 'id_activites', 'flag_activites_entreprises', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activite()
    {
        return $this->belongsTo('App\Models\Activites', 'id_activites', 'id_activites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprises', 'id_entreprises');
    }
}
