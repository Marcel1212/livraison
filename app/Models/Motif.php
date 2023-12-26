<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_motif
 * @property string $libelle_motif
 * @property boolean $flag_actif_motif
 * @property string $created_at
 * @property string $updated_at
 * @property string $code_motif
 * @property string $commentaire_motif
 * @property DemandeEnrolement[] $demandeEnrolements
 */
class Motif extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'motif';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_motif';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_motif', 'flag_actif_motif', 'created_at', 'updated_at', 'code_motif','commentaire_motif'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeEnrolements()
    {
        return $this->hasMany('App\Models\DemandeEnrolement', 'id_motif', 'id_motif');
    }
}
