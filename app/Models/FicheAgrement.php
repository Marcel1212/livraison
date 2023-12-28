<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_fiche_agrement
 * @property float $id_comite_gestion
 * @property float $id_comite_permanente
 * @property float $id_user_fiche_agrement
 * @property float $id_demande
 * @property boolean $flag_fiche_agrement
 * @property string $commentaire_fiche_agrement
 * @property string $created_at
 * @property string $updated_at
 * @property ComiteGestion $comiteGestion
 * @property ComitePermanente $comitePermanente
 * @property User $user
 */
class FicheAgrement extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fiche_agrement';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_fiche_agrement';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_comite_gestion', 'id_comite_permanente', 'id_user_fiche_agrement', 'id_demande', 'flag_fiche_agrement', 'commentaire_fiche_agrement', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comiteGestion()
    {
        return $this->belongsTo('App\Models\ComiteGestion', 'id_comite_gestion', 'id_comite_gestion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comitePermanente()
    {
        return $this->belongsTo('App\Models\ComitePermanente', 'id_comite_permanente', 'id_comite_permanente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_fiche_agrement');
    }
}
