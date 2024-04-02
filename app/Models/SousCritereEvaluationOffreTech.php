<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousCritereEvaluationOffreTech extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sous_critere_evaluation_offre_tech';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_sous_critere_evaluation_offre_tech';

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
    protected $fillable = ['libelle_sous_critere_evaluation_offre_tech', 'flag_sous_critere_evaluation_offre_tech','id_critere_evaluation_offre_tech', 'created_at', 'updated_at'];


    public function critereevaluationoffretech()
    {
        return $this->belongsTo(CritereEvaluationOffreTech::class, 'id_critere_evaluation_offre_tech', 'id_critere_evaluation_offre_tech');
    }


}
