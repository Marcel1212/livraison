<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_domaine_formation
 * @property string $libelle_domaine_formation
 * @property string $code_domaine_formation
 * @property boolean $flag_domaine_formation
 * @property string $created_at
 * @property string $updated_at
 * @property DomaineFormationCabinet[] $domaineFormationCabinets
 * @property ActionFormationPlan[] $actionFormationPlans
 */
class DomaineFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'domaine_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_domaine_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_domaine_formation', 'code_domaine_formation', 'flag_domaine_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domaineFormationCabinets()
    {
        return $this->hasMany('App\Models\DomaineFormationCabinet', 'id_domaine_formation', 'id_domaine_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionFormationPlans()
    {
        return $this->hasMany('App\Models\ActionFormationPlan', 'id_domaine_formation', 'id_domaine_formation');
    }
}
