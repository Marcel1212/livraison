<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_domaine_demande_habilitation
 * @property float $id_type_domaine_demande_habilitation
 * @property float $id_demande_habilitation
 * @property float $id_domaine_formation
 * @property boolean $flag_organisation_formation
 * @property string $created_at
 * @property string $updated_at
 * @property FormateurDomaineDemandeHabilitation[] $formateurDomaineDemandeHabilitations
 * @property DemandeHabilitation $demandeHabilitation
 * @property DomaineFormation $domaineFormation
 * @property TypeDomaineDemandeHabilitation $typeDomaineDemandeHabilitation
 */
class DomaineDemandeHabilitation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'domaine_demande_habilitation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_domaine_demande_habilitation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_domaine_demande_habilitation', 'id_demande_habilitation', 'id_domaine_formation', 'flag_organisation_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formateurDomaineDemandeHabilitations()
    {
        return $this->hasMany('App\Models\FormateurDomaineDemandeHabilitation', 'id_domaine_demande_habilitation', 'id_domaine_demande_habilitation');
    }

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
    public function domaineFormation()
    {
        return $this->belongsTo('App\Models\DomaineFormation', 'id_domaine_formation', 'id_domaine_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeDomaineDemandeHabilitation()
    {
        return $this->belongsTo('App\Models\TypeDomaineDemandeHabilitation', 'id_type_domaine_demande_habilitation', 'id_type_domaine_demande_habilitation');
    }
}
