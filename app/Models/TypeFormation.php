<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_type_formation
 * @property string $type_formation
 * @property boolean $flag_actif_formation
 * @property string $created_at
 * @property string $updated_at
 * @property FicheADemandeAgrement[] $ficheADemandeAgrements
 */
class TypeFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'type_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_type_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['type_formation', 'flag_actif_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficheADemandeAgrements()
    {
        return $this->hasMany('App\Models\FicheADemandeAgrement', 'id_type_formation', 'id_type_formation');
    }
}
