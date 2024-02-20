<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_caracteristique_type_formation
 * @property float $id_type_formation
 * @property string $libelle_ctf
 * @property float $montant_ctf
 * @property boolean $flag_ctf
 * @property string $created_at
 * @property string $updated_at
 * @property string $code_ctf
 * @property float $cout_herbement_formateur_ctf
 * @property ActionFormationPlan[] $actionFormationPlans
 * @property TypeFormation $typeFormation
 */
class CaracteristiqueTypeFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'caracteristique_type_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_caracteristique_type_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_formation', 'libelle_ctf', 'montant_ctf', 'flag_ctf', 'created_at', 'updated_at', 'code_ctf', 'cout_herbement_formateur_ctf'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionFormationPlans()
    {
        return $this->hasMany('App\Models\ActionFormationPlan', 'id_caracteristique_type_formation', 'id_caracteristique_type_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeFormation()
    {
        return $this->belongsTo('App\Models\TypeFormation', 'id_type_formation', 'id_type_formation');
    }
}
