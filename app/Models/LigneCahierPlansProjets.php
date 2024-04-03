<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_ligne_cahier_plans_projets
 * @property float $id_cahier_plans_projets
 * @property float $id_demande
 * @property string $code_pieces_ligne_cahier_plans_projets
 * @property boolean $flag_ligne_cahier_plans_projets
 * @property boolean $flag_statut_soumis_ligne_cahier_plans_projets
 * @property string $created_at
 * @property string $updated_at
 * @property CahierPlansProjet $cahierPlansProjet
 */
class LigneCahierPlansProjets extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_ligne_cahier_plans_projets';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_cahier_plans_projets', 'id_demande', 'code_pieces_ligne_cahier_plans_projets', 'flag_ligne_cahier_plans_projets', 'flag_statut_soumis_ligne_cahier_plans_projets', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cahierPlansProjet()
    {
        return $this->belongsTo('App\Models\CahierPlansProjet', 'id_cahier_plans_projets', 'id_cahier_plans_projets');
    }
}
