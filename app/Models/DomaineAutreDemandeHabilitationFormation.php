<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_domaine_autre_demande_habilitation_formation
 * @property float $id_domaine_demande_habilitation
 * @property float $id_autre_demande_habilitation_formation
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $flag_autre_demande_habilitation_formation
 * @property AutreDemandeHabilitationFormation $autreDemandeHabilitationFormation
 * @property DomaineDemandeHabilitation $domaineDemandeHabilitation
 */
class DomaineAutreDemandeHabilitationFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'domaine_autre_demande_habilitation_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_domaine_autre_demande_habilitation_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_domaine_demande_habilitation', 'id_autre_demande_habilitation_formation', 'created_at', 'updated_at', 'flag_autre_demande_habilitation_formation'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function autreDemandeHabilitationFormation()
    {
        return $this->belongsTo('App\Models\AutreDemandeHabilitationFormation', 'id_autre_demande_habilitation_formation', 'id_autre_demande_habilitation_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domaineDemandeHabilitation()
    {
        return $this->belongsTo('App\Models\DomaineDemandeHabilitation', 'id_domaine_demande_habilitation', 'id_domaine_demande_habilitation');
    }
}
