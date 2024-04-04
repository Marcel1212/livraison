<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahierCommissionEvaluationOffre extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cahier_commission_evaluation_offre';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_cahier_commission_evaluation_offre';

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
    protected $fillable = ['id_cahier_commission_evaluation_offre',
        'id_commission_evaluation_offre',
        'id_projet_etude',
        'flag_cahier_commission_evaluation_offre',
        'commentaire_cahier_commission_evaluation_offre',
        'code_cahier_commission_evaluation_offre',
        'created_at', 'updated_at'];

    public function projet_etude()
    {
        return $this->belongsTo(ProjetEtude::class, 'id_projet_etude', 'id_projet_etude');
    }

    public function commission_evaluation()
    {
        return $this->belongsTo(CommissionEvaluationOffre::class, 'id_commission_evaluation_offre', 'id_commission_evaluation_offre');
    }
}
