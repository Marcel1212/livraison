<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_intervention_hors_ci
 * @property float $id_demande_habilitation
 * @property float $id_pays
 * @property string $objet_intervention_hors_ci
 * @property string $annee_intervention_hors_ci
 * @property string $quel_financement_intervention_hors_ci
 * @property boolean $flag_intervention_hors_ci
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeHabilitation $demandeHabilitation
 * @property Pays $pay
 */
class InterventionHorsCi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'intervention_hors_ci';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_intervention_hors_ci';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_demande_habilitation', 'id_pays', 'objet_intervention_hors_ci', 'annee_intervention_hors_ci', 'quel_financement_intervention_hors_ci', 'flag_intervention_hors_ci', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demandeHabilitation()
    {
        return $this->belongsTo('App\Models\DemandeHabilitation', 'id_demande_habilitation', 'id_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        return $this->belongsTo('App\Models\Pays', 'id_pays', 'id_pays');
    }
}
