<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_experiences
 * @property float $id_formateurs
 * @property float $id_type_emploie
 * @property float $id_type_lieu
 * @property string $intitule_de_poste
 * @property string $nom_entreprise
 * @property string $lieu_entreprise
 * @property boolean $flag_occuppe_poste_actuel
 * @property string $date_de_debut
 * @property string $date_de_fin
 * @property string $description_experience
 * @property boolean $flag_experiences
 * @property string $created_at
 * @property string $updated_at
 * @property Competence[] $competences
 * @property PiecesExperience[] $piecesExperiences
 * @property Formateur $formateur
 * @property TypeEmploie $typeEmploie
 * @property TypeLieu $typeLieu
 */
class Experiences extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_experiences';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_formateurs', 'id_type_emploie', 'id_type_lieu', 'intitule_de_poste', 'nom_entreprise', 'lieu_entreprise', 'flag_occuppe_poste_actuel', 'date_de_debut', 'date_de_fin', 'description_experience', 'flag_experiences', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function competences()
    {
        return $this->hasMany('App\Models\Competence', 'id_experiences', 'id_experiences');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function piecesExperiences()
    {
        return $this->hasMany('App\Models\PiecesExperience', 'id_experiences', 'id_experiences');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formateur()
    {
        return $this->belongsTo('App\Models\Formateur', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeEmploie()
    {
        return $this->belongsTo('App\Models\TypeEmploie', 'id_type_emploie', 'id_type_emploie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeLieu()
    {
        return $this->belongsTo('App\Models\TypeLieu', 'id_type_lieu', 'id_type_lieu');
    }
}
