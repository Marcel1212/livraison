<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_formations_educ
 * @property float $id_formateurs
 * @property string $ecole_formation_educ
 * @property string $diplome_formation_educ
 * @property string $domaine_formation_educ
 * @property string $date_de_debut_formations_educ
 * @property string $date_de_fin_formations_educ
 * @property string $resultat_formation_educ
 * @property string $description_formations_educ
 * @property string $activite_asso_formations_educ
 * @property boolean $flag_formations_educ
 * @property string $created_at
 * @property string $updated_at
 * @property Formateur $formateur
 */
class FormationsEduc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'formations_educ';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_formations_educ';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_formateurs', 'ecole_formation_educ', 'diplome_formation_educ', 'domaine_formation_educ', 'date_de_debut_formations_educ', 'date_de_fin_formations_educ', 'resultat_formation_educ', 'description_formations_educ', 'activite_asso_formations_educ', 'flag_formations_educ', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formateur()
    {
        return $this->belongsTo('App\Models\Formateur', 'id_formateurs', 'id_formateurs');
    }
}
