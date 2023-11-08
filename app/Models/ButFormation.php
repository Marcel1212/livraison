<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_but_formation
 * @property string $but_formation
 * @property boolean $flag_actif_but_formation
 * @property string $created_at
 * @property string $updated_at
 * @property FicheADemandeAgrement[] $ficheADemandeAgrements
 */
class ButFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'but_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_but_formation';

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
    protected $fillable = ['but_formation', 'flag_actif_but_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficheADemandeAgrements()
    {
        return $this->hasMany('App\Models\FicheADemandeAgrement', 'id_but_formation', 'id_but_formation');
    }
}
