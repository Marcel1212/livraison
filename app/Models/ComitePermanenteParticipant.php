<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_permanente_participant
 * @property float $id_user_comite_permanente_participant
 * @property float $id_comite_permanente
 * @property boolean $flag_comite_permanente_participant
 * @property string $created_at
 * @property string $updated_at
 * @property ComitePermanente $comitePermanente
 * @property User $user
 */
class ComitePermanenteParticipant extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comite_permanente_participant';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_comite_permanente_participant';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_comite_permanente_participant', 'id_comite_permanente', 'flag_comite_permanente_participant', 'created_at', 'updated_at'];

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
        return $this->belongsTo('App\Models\User', 'id_user_comite_permanente_participant');
    }
}
