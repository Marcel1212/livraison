<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_fiche_a_agrement_but_formation
 * @property float $id_fiche_agrement
 * @property float $id_but_formation
 * @property boolean $flag_fiche_a_agrement_but_formation
 * @property string $created_at
 * @property string $updated_at
 * @property ButFormation $butFormation
 * @property FicheADemandeAgrement $ficheADemandeAgrement
 */
class FicheAgrementButFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fiche_a_agrement_but_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_fiche_a_agrement_but_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_fiche_agrement', 'id_but_formation', 'flag_fiche_a_agrement_but_formation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function butFormation()
    {
        return $this->belongsTo('App\Models\ButFormation', 'id_but_formation', 'id_but_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ficheADemandeAgrement()
    {
        return $this->belongsTo('App\Models\FicheADemandeAgrement', 'id_fiche_agrement', 'id_fiche_agrement');
    }
}
