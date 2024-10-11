<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_competences
 * @property float $id_formateurs
 * @property float $id_experiences
 * @property string $competences_libelle
 * @property boolean $flag_competences
 * @property string $created_at
 * @property string $updated_at
 * @property Experience $experience
 * @property Formateur $formateur
 */
class Competences extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_competences';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_formateurs', 'id_experiences', 'competences_libelle', 'flag_competences', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function experience()
    {
        return $this->belongsTo('App\Models\Experience', 'id_experiences', 'id_experiences');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formateur()
    {
        return $this->belongsTo('App\Models\Formateur', 'id_formateurs', 'id_formateurs');
    }
}
