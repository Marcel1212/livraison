<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_pays
 * @property string $libelle_pays
 * @property string $nationalite_pays
 * @property bool $flag_actif_pays
 * @property string $updated_at
 * @property string $created_at
 * @property string $indicatif
 * @property DemandeEnrolement[] $demandeEnrolements
 */
class Pays extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pays';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_pays', 'flag_actif_pays', 'nationalite_pays', 'updated_at', 'created_at', 'indicatif'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'indicatif_demande_enrolement', 'id_pays');
    }
}
