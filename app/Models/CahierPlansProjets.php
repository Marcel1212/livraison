<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cahier_plans_projets
 * @property float $id_users_cahier_plans_projets
 * @property float $id_departement
 * @property float $id_processus_comite
 * @property string $date_creer_cahier_plans_projets
 * @property string $date_soumis_cahier_plans_projets
 * @property string $commentaire_cahier_plans_projets
 * @property string $code_cahier_plans_projets
 * @property string $code_pieces_cahier_plans_projets
 * @property boolean $flag_cahier_plans_projets
 * @property boolean $flag_statut_cahier_plans_projets
 * @property string $created_at
 * @property string $updated_at
 * @property Departement $departement
 * @property ProcessusComite $processusComite
 * @property User $user
 * @property LigneCahierPlansProjet[] $ligneCahierPlansProjets
 */
class CahierPlansProjets extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cahier_plans_projets';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_users_cahier_plans_projets', 'id_departement', 'id_processus_comite', 'date_creer_cahier_plans_projets', 'date_soumis_cahier_plans_projets', 'commentaire_cahier_plans_projets', 'code_cahier_plans_projets', 'code_pieces_cahier_plans_projets', 'flag_cahier_plans_projets', 'flag_statut_cahier_plans_projets', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departement()
    {
        return $this->belongsTo('App\Models\Departement', 'id_departement', 'id_departement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processusComite()
    {
        return $this->belongsTo('App\Models\ProcessusComite', 'id_processus_comite', 'id_processus_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_users_cahier_plans_projets');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ligneCahierPlansProjets()
    {
        return $this->hasMany('App\Models\LigneCahierPlansProjet', 'id_cahier_plans_projets', 'id_cahier_plans_projets');
    }
}
