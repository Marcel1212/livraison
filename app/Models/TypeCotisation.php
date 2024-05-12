<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_cotisation
 * @property float $id_user
 * @property string $libelle_type_cotisation
 * @property boolean $flag_type_cotisation
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Cotisation[] $cotisations
 */
class TypeCotisation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_cotisation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_cotisation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'libelle_type_cotisation', 'flag_type_cotisation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cotisations()
    {
        return $this->hasMany('App\Models\Cotisation', 'id_type_cotisation', 'id_type_cotisation');
    }
}
