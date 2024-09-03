<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_organisation_formation
 * @property float $id_type_organisation_formation
 * @property float $id_demande_habilitation
 * @property boolean $flag_organisation_formation
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeHabilitation $demandeHabilitation
 * @property TypeOrganisationFormation $typeOrganisationFormation
 */
class OrganisationFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'organisation_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_organisation_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_organisation_formation', 'id_demande_habilitation', 'flag_organisation_formation', 'created_at', 'updated_at'];

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
    public function typeOrganisationFormation()
    {
        return $this->belongsTo('App\Models\TypeOrganisationFormation', 'id_type_organisation_formation', 'id_type_organisation_formation');
    }
}
