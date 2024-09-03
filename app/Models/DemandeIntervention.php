<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_demande_intervention
 * @property float $id_type_intervention
 * @property float $id_demande_habilitation
 * @property boolean $flag_demande_intervention
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeHabilitation $demandeHabilitation
 * @property TypeIntervention $typeIntervention
 */
class DemandeIntervention extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'demande_intervention';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_demande_intervention';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_intervention', 'id_demande_habilitation', 'flag_demande_intervention', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demandeHabilitation()
    {
        return $this->belongsTo('App\Models\DemandeHabilitation', 'id_demande_habilitation', 'id_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeIntervention()
    {
        return $this->belongsTo('App\Models\TypeIntervention', 'id_type_intervention', 'id_type_intervention');
    }
}
