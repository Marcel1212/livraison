<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_gestion_participant
 * @property float $id_user_comite_gestion_participant
 * @property float $id_comite_gestion
 * @property boolean $flag_comite_gestion_participant
 * @property string $created_at
 * @property string $updated_at
 * @property ComiteGestion $comiteGestion
 * @property User $user
 */
class ComiteGestionParticipant extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comite_gestion_participant';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_comite_gestion_participant';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_comite_gestion_participant', 'id_comite_gestion', 'flag_comite_gestion_participant', 'created_at', 'updated_at'];

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
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_comite_gestion_participant');
    }
}
