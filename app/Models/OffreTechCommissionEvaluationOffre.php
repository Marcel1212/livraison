<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreTechCommissionEvaluationOffre extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'offre_tech_commission_evaluation_offre';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_offre_tech_commission_evaluation_offre';

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
        'id_critere_evaluation_offre_tech',
        'note_offre_tech_commission_evaluation_offre',
        'flag_offre_tech_commission_evaluation_offre',
        'created_at', 'updated_at'];

    public function souscritereevaluationoffretech()
    {
        return $this->belongsTo(SousCritereEvaluationOffreTech::class, 'id_sous_critere_evaluation_offre_tech', 'id_sous_critere_evaluation_offre_tech');
    }

    public function critereevaluationoffretech()
    {
        return $this->belongsTo(CritereEvaluationOffreTech::class, 'id_critere_evaluation_offre_tech', 'id_critere_evaluation_offre_tech');
    }

    public function noteEvaluationOffre($id){
        return $this->belongsTo(NotationCommissionEvaluationOffreTech::class,'id_sous_critere_evaluation_offre_tech','id_sous_critere_evaluation_offre_tech')
            ->where('notation_commission_evaluation_offre_tech.id_operateur',$id)->first();
    }


}
