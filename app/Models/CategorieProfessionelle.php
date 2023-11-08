<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_categorie_professionelle
 * @property string $categorie_profeessionnelle
 * @property boolean $flag_categorie_professionnelle
 * @property string $created_at
 * @property string $updated_at
 * @property CategoriePlan[] $categoriePlans
 */
class CategorieProfessionelle extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categorie_professionelle';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_categorie_professionelle';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['categorie_profeessionnelle', 'flag_categorie_professionnelle', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriePlans()
    {
        return $this->hasMany('App\Models\CategoriePlan', 'id_categorie_professionelle', 'id_categorie_professionelle');
    }
}
