<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_moyen_permanent
 * @property string $libelle_type_moyen_permanent
 * @property boolean $flag_type_moyen_permanent
 * @property string $created_at
 * @property string $updated_at
 * @property MoyenPermanente[] $moyenPermanentes
 */
class TypeMoyenPermanent extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_moyen_permanent';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_moyen_permanent';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_moyen_permanent', 'flag_type_moyen_permanent', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moyenPermanentes()
    {
        return $this->hasMany('App\Models\MoyenPermanente', 'id_type_moyen_permanent', 'id_type_moyen_permanent');
    }
}
