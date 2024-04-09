<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionParticipantEvaluationOffre extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commission_evaluation_offre_participant';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_commission_evaluation_offre_participant';

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
    protected $fillable = ['id_commission_evaluation_offre_participant', 'id_commission_evaluation_offre',
        'id_user_commission_evaluation_offre_participant',
        'flag_commission_evaluation_offre_participant',
        'created_at', 'updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user_commission_evaluation_offre_participant');
    }

}
