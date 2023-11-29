<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_pleniere_participant
 * @property float $id_user_comite_pleniere_participant
 * @property float $id_comite_pleniere
 * @property boolean $flag_comite_pleniere_participant
 * @property string $created_at
 * @property string $updated_at
 * @property ComitePleniere $comitePleniere
 * @property User $user
 */
class ComitePleniereParticipant extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comite_pleniere_participant';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_comite_pleniere_participant';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_comite_pleniere_participant', 'id_comite_pleniere', 'flag_comite_pleniere_participant', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comitePleniere()
    {
        return $this->belongsTo('App\Models\ComitePleniere', 'id_comite_pleniere', 'id_comite_pleniere');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_comite_pleniere_participant');
    }
}
