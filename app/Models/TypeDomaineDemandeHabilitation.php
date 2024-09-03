<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_domaine_demande_habilitation
 * @property string $libelle_type_domaine_demande_habilitation
 * @property string $code_type_domaine_demande_habilitation
 * @property boolean $flag_type_domaine_demande_habilitation
 * @property string $created_at
 * @property string $updated_at
 * @property DomaineDemandeHabilitation[] $domaineDemandeHabilitations
 */
class TypeDomaineDemandeHabilitation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_domaine_demande_habilitation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_domaine_demande_habilitation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_type_domaine_demande_habilitation', 'code_type_domaine_demande_habilitation', 'flag_type_domaine_demande_habilitation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domaineDemandeHabilitations()
    {
        return $this->hasMany('App\Models\DomaineDemandeHabilitation', 'id_type_domaine_demande_habilitation', 'id_type_domaine_demande_habilitation');
    }
}
