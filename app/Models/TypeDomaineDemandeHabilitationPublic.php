<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_domaine_demande_habilitation_public
 * @property string $libelle_type_domaine_demande_habilitation_public
 * @property string $code_type_type_domaine_demande_habilitation_public
 * @property boolean $flag_type_type_domaine_demande_habilitation_public
 * @property string $created_at
 * @property string $updated_at
 * @property DomaineDemandeHabilitation[] $domaineDemandeHabilitations
 */
class TypeDomaineDemandeHabilitationPublic extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_domaine_demande_habilitation_public';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_domaine_demande_habilitation_public';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_domaine_demande_habilitation_public', 'code_type_type_domaine_demande_habilitation_public', 'flag_type_type_domaine_demande_habilitation_public', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domaineDemandeHabilitations()
    {
        return $this->hasMany('App\Models\DomaineDemandeHabilitation', 'id_type_domaine_demande_habilitation_public', 'id_type_domaine_demande_habilitation_public');
    }
}
