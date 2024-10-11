<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_nombre_annee_experience
 * @property string $libelle_nombre_annee_experience
 * @property boolean $flag_nombre_annee_experience
 * @property string $created_at
 * @property string $updated_at
 */
class NombreAnneeExperience extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'nombre_annee_experience';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_nombre_annee_experience';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_nombre_annee_experience', 'flag_nombre_annee_experience', 'created_at', 'updated_at'];
}
