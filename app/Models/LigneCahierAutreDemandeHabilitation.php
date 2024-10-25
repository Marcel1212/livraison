<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_ligne_cahier_autre_demande_habilitations
 * @property float $id_cahier_autre_demande_habilitations
 * @property float $id_demande
 * @property string $code_pieces_ligne_cahier_autre_demande_habilitations
 * @property boolean $flag_ligne_cahier_autre_demande_habilitations
 * @property boolean $flag_statut_soumis_ligne_cahier_autre_demande_habilitations
 * @property string $created_at
 * @property string $updated_at
 * @property CahierAutreDemandeHabilitation $cahierAutreDemandeHabilitation
 */
class LigneCahierAutreDemandeHabilitation extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ligne_cahier_autre_demande_habilitations';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_cahier_autre_demande_habilitations', 'id_demande', 'code_pieces_ligne_cahier_autre_demande_habilitations', 'flag_ligne_cahier_autre_demande_habilitations', 'flag_statut_soumis_ligne_cahier_autre_demande_habilitations', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cahierAutreDemandeHabilitation()
    {
        return $this->belongsTo('App\Models\CahierAutreDemandeHabilitation', 'id_cahier_autre_demande_habilitations', 'id_cahier_autre_demande_habilitations');
    }
}
