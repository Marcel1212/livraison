<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_nombre_domaine_habilitation
 * @property string $libelle_nombre_domaine_habilitation
 * @property boolean $flag_nombre_domaine_habilitation
 * @property string $created_at
 * @property string $updated_at
 */
class NombreDomaineHabilitation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'nombre_domaine_habilitation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_nombre_domaine_habilitation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_nombre_domaine_habilitation', 'flag_nombre_domaine_habilitation', 'created_at', 'updated_at'];
}
