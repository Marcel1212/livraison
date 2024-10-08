<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_emploie
 * @property string $libelle_type_emploie
 * @property string $code_type_emploie
 * @property boolean $flag_type_emploie
 * @property string $created_at
 * @property string $updated_at
 * @property Experience[] $experiences
 */
class TypeEmploie extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_emploie';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_emploie';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_emploie', 'code_type_emploie', 'flag_type_emploie', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experiences()
    {
        return $this->hasMany('App\Models\Experience', 'id_type_emploie', 'id_type_emploie');
    }
}
