<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_organisation_formation
 * @property string $libelle_type_organisation_formation
 * @property boolean $flag_type_organisation_formation
 * @property string $created_at
 * @property string $updated_at
 * @property OrganisationFormation[] $organisationFormations
 */
class TypeOrganisationFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_organisation_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_organisation_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_organisation_formation', 'flag_type_organisation_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisationFormations()
    {
        return $this->hasMany('App\Models\OrganisationFormation', 'id_type_organisation_formation', 'id_type_organisation_formation');
    }
}
