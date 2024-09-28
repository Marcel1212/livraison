<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_formateur_domaine_demande_habilitation
 * @property float $id_domaine_demande_habilitation
 * @property string $nom_formateur
 * @property string $prenom_formateur
 * @property string $date_debut_formateur
 * @property string $date_fin_formateur
 * @property string $experience_formateur
 * @property string $cv_formateur
 * @property string $le_formateur
 * @property string $annee_experience
 * @property boolean $flag_formateur_domaine_demande_habilitation
 * @property string $created_at
 * @property string $updated_at
 * @property DomaineDemandeHabilitation $domaineDemandeHabilitation
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
    protected $fillable = ['id_domaine_demande_habilitation', 'nom_formateur', 'prenom_formateur', 'date_debut_formateur', 'date_fin_formateur', 'experience_formateur', 'cv_formateur', 'le_formateur', 'flag_formateur_domaine_demande_habilitation','annee_experience', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domaineDemandeHabilitation()
    {
        return $this->belongsTo('App\Models\DomaineDemandeHabilitation', 'id_domaine_demande_habilitation', 'id_domaine_demande_habilitation');
    }
}
