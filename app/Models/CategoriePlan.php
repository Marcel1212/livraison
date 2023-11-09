<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_categorie_plan
 * @property float $id_categorie_professionelle
 * @property float $id_plan_de_formation
 * @property string $genre_plan
 * @property float $nombre_plan
 * @property string $created_at
 * @property string $updated_at
 * @property CategorieProfessionelle $categorieProfessionelle
 * @property PlanFormation $planFormation
 */
class CategoriePlan extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categorie_plan';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_categorie_plan';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_categorie_professionelle', 'id_plan_de_formation', 'genre_plan', 'nombre_plan', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorieProfessionelle()
    {
        return $this->belongsTo('App\Models\CategorieProfessionelle', 'id_categorie_professionelle', 'id_categorie_professionelle');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planFormation()
    {
        return $this->belongsTo('App\Models\PlanFormation', 'id_plan_de_formation', 'id_plan_de_formation');
    }
}
