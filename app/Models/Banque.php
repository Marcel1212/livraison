<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_banque
 * @property string $libelle_banque
 * @property boolean $flag_banque
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeHabilitation[] $demandeHabilitations
 */
class Banque extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'banque';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_banque';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_banque', 'flag_banque', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeHabilitations()
    {
        return $this->hasMany('App\Models\DemandeHabilitation', 'id_banque', 'id_banque');
    }
}
