<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotationCommissionEvaluationOffreTech extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notation_commission_evaluation_offre_tech';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_notation_commission_evaluation_offre_tech';

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
    protected $fillable = ['id_offre_tech_commission_evaluation_offre', 'id_commission_evaluation_offre',
        'id_sous_critere_evaluation_offre_tech',
        'id_user_notation_commission_evaluation_offre',
        'flag_notation_commission_evaluation_offre_tech',
        'flag_valider_notation_commission_evaluation_offre_tech',
        'note_notation_commission_evaluation_offre_tech',
        'id_projet_etude',
        'id_operateur',
        'created_at', 'updated_at'];


//    public function souscritereevaluationoffretech()
//    {
//        return $this->belongsTo(SousCritereEvaluationOffreTech::class, 'id_sous_critere_evaluation_offre_tech', 'id_sous_critere_evaluation_offre_tech');
//    }
//
//    public function critereevaluationoffretech()
//    {
//        return $this->belongsTo(CritereEvaluationOffreTech::class, 'id_critere_evaluation_offre_tech', 'id_critere_evaluation_offre_tech');
//    }


}