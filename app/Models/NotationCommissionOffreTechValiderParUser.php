<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotationCommissionOffreTechValiderParUser extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notation_commission_offre_tech_valider_par_user';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_notation_commission_offre_tech_valider_par_user';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_notation_commission_evaluation_offre', 'id_cahier_commission_evaluation_offre',
        'flag_notation_commission_offre_tech_valider_par_user',
        'created_at', 'updated_at'];
}
