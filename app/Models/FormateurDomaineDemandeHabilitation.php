<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_formateur_domaine_demande_habilitation
 * @property float $id_domaine_demande_habilitation
 * @property float $id_formateurs
 * @property boolean $flag_formateur_domaine_demande_habilitation
 * @property string $created_at
 * @property string $updated_at
 * @property string $annee_experience
 * @property DomaineDemandeHabilitation $domaineDemandeHabilitation
 * @property Formateurs $formateur
 */
class FormateurDomaineDemandeHabilitation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formateur_domaine_demande_habilitation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_formateur_domaine_demande_habilitation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_domaine_demande_habilitation', 'id_formateurs', 'flag_formateur_domaine_demande_habilitation', 'created_at', 'updated_at', 'annee_experience'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domaineDemandeHabilitation()
    {
        return $this->belongsTo('App\Models\DomaineDemandeHabilitation', 'id_domaine_demande_habilitation', 'id_domaine_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formateur()
    {
        return $this->belongsTo('App\Models\Formateurs', 'id_formateurs', 'id_formateurs');
    }
}
