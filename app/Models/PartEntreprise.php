<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_part_entreprise
 * @property string $libelle_part_entreprise
 * @property float $valeur_part_entreprise
 * @property boolean $flag_actif_part_entreprise
 * @property string $created_at
 * @property string $updated_at
 * @property PlanFormation[] $planFormations
 */
class PartEntreprise extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'part_entreprise';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_part_entreprise';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_part_entreprise', 'valeur_part_entreprise', 'flag_actif_part_entreprise', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planFormations()
    {
        return $this->hasMany('App\Models\PlanFormation', 'id_part_entreprise', 'id_part_entreprise');
    }
}
