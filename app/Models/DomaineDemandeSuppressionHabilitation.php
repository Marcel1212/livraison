<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_domaine_demande_suppression_habilitation
 * @property float $id_domaine_demande_habilitation
 * @property float $id_demande_suppression_habilitation
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeSuppressionHabilitation $demandeSuppressionHabilitation
 * @property DomaineDemandeHabilitation $domaineDemandeHabilitation
 */
class DomaineDemandeSuppressionHabilitation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'domaine_demande_suppression_habilitation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_domaine_demande_suppression_habilitation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_domaine_demande_habilitation','flag_demande_suppression_habilitation','id_demande_suppression_habilitation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demandeSuppressionHabilitation()
    {
        return $this->belongsTo('App\Models\DemandeSuppressionHabilitation', 'id_demande_suppression_habilitation', 'id_demande_suppression_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domaineDemandeHabilitation()
    {
        return $this->belongsTo('App\Models\DomaineDemandeHabilitation', 'id_domaine_demande_habilitation', 'id_domaine_demande_habilitation');
    }
}
