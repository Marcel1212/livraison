<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_moyen_permanente
 * @property float $id_type_moyen_permanent
 * @property float $id_demande_habilitation
 * @property float $nombre_moyen_permanente
 * @property float $capitale_moyen_permanente
 * @property boolean $flag_composition_capitale
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeHabilitation $demandeHabilitation
 * @property TypeMoyenPermanent $typeMoyenPermanent
 */
class MoyenPermanente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'moyen_permanente';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_moyen_permanente';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_moyen_permanent', 'id_demande_habilitation', 'nombre_moyen_permanente', 'capitale_moyen_permanente', 'flag_composition_capitale', 'created_at', 'updated_at'];

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
    public function typeMoyenPermanent()
    {
        return $this->belongsTo('App\Models\TypeMoyenPermanent', 'id_type_moyen_permanent', 'id_type_moyen_permanent');
    }
}
