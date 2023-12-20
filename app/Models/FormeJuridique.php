<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_forme_juridique
 * @property string $libelle_forme_juridique
 * @property boolean $flag_actif_forme_juridique
 * @property string $created_at
 * @property string $updated_at
 * @property string $code_forme_juridique
 * @property string $commentaire_forme_juridique
 * @property DemandeEnrolement[] $demandeEnrolements
 */
class FormeJuridique extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forme_juridique';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_forme_juridique';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_forme_juridique', 'flag_actif_forme_juridique', 'created_at', 'updated_at', 'code_forme_juridique', 'commentaire_forme_juridique'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'id_forme_juridique', 'id_forme_juridique');
    }
}
