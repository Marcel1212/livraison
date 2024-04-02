<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionEvaluationOffre extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commission_evaluation_offre';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_commission_evaluation_offre';

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
    protected $fillable = ['date_debut_commission_evaluation_offre',
        'date_fin_commission_evaluation_offre',
        'commentaire_commission_evaluation_offre',
        'id_user_commission_evaluation_offre',
        'numero_commission_evaluation_offre',
        'nombre_evaluateur_commission_evaluation_offre',
        'region_commission_evaluation_offre',
        'speculation_commission_evaluation_offre',
        'pourcentage_offre_tech_commission_evaluation_offre',
        'pourcentage_offre_fin_commission_evaluation_offre',
        'code_commission_evaluation_offre',
        'flag_commission_evaluation_offre',
        'flag_statut_commission_evaluation_offre',
        'created_at', 'updated_at'];

}
