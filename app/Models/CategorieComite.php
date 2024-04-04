<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_categorie_comite
 * @property string $libelle_categorie_comite
 * @property boolean $flag_actif_categorie_comite
 * @property string $code_categorie_comite
 * @property string $type_code_categorie_comite
 * @property string $created_at
 * @property string $updated_at
 * @property Comite[] $comites
 */
class CategorieComite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categorie_comite';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_categorie_comite';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_categorie_comite', 'flag_actif_categorie_comite', 'code_categorie_comite', 'created_at', 'updated_at','type_code_categorie_comite'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comites()
    {
        return $this->hasMany('App\Models\Comite', 'id_categorie_comite', 'id_categorie_comite');
    }
}
