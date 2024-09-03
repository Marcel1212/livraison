<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_intervention
 * @property string $libelle_type_intervention
 * @property boolean $flag_type_intervention
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeIntervention[] $demandeInterventions
 */
class TypeIntervention extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_intervention';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_intervention';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_intervention', 'flag_type_intervention', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeInterventions()
    {
        return $this->hasMany('App\Models\DemandeIntervention', 'id_type_intervention', 'id_type_intervention');
    }
}
