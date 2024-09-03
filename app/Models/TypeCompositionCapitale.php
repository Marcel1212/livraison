<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_composition_capitale
 * @property string $libelle_type_composition_capitale
 * @property boolean $flag_type_composition_capitale
 * @property string $created_at
 * @property string $updated_at
 * @property CompositionCapitale[] $compositionCapitales
 */
class TypeCompositionCapitale extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_composition_capitale';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_composition_capitale';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_composition_capitale', 'flag_type_composition_capitale', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function compositionCapitales()
    {
        return $this->hasMany('App\Models\CompositionCapitale', 'id_type_composition_capitale', 'id_type_composition_capitale');
    }
}
