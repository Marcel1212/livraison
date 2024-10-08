<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_lieu
 * @property string $libelle_type_lieu
 * @property string $code_type_lieu
 * @property boolean $flag_type_lieu
 * @property string $created_at
 * @property string $updated_at
 * @property Experience[] $experiences
 */
class TypeLieu extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_lieu';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_lieu';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_lieu', 'code_type_lieu', 'flag_type_lieu', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experiences()
    {
        return $this->hasMany('App\Models\Experience', 'id_type_lieu', 'id_type_lieu');
    }
}
