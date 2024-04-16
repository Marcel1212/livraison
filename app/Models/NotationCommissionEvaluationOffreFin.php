<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotationCommissionEvaluationOffreFin extends Model
{
    use HasFactory;

    protected $table ='notation_commission_evaluation_offre_fin';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_notation_commission_evaluation_offre_fin';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */

    protected $fillable = ['id_notation_commission_evaluation_offre_fin',
        'id_commission_evaluation_offre', 'id_user_notation_commission_evaluation_offre',
        'flag_notation_commission_evaluation_offre_fin', 'montant_notation_commission_evaluation_offre_fin',
        'id_projet_etude', 'id_operateur'];

}
