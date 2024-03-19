<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_participant
 * @property float $id_user_comite_participant
 * @property float $id_comite
 * @property boolean $flag_comite_participant
 * @property string $created_at
 * @property string $updated_at
 * @property Comite $comite
 * @property User $user
 */
class ComiteParticipant extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comite_participant';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_comite_participant';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_comite_participant', 'id_comite', 'flag_comite_participant', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comite()
    {
        return $this->belongsTo('App\Models\Comite', 'id_comite', 'id_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_comite_participant');
    }
}
