<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_comite
 * @property string $libelle_type_comite
 * @property boolean $flag_actif_type_comite
 * @property float $valeur_min_type_comite
 * @property float $valeur_max_type_comite
 * @property string $created_at
 * @property string $updated_at
 */
class TypeComite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_comite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_comite';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_comite', 'flag_actif_type_comite', 'valeur_min_type_comite', 'valeur_max_type_comite', 'created_at', 'updated_at'];
}
