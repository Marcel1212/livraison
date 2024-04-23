<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_traitement_par_critere
 * @property float $id_user_traitement_par_critere
 * @property float $id_projet_formation
 * @property float $id_critere_evaluation
 * @property float $id_demande
 * @property boolean $flag_critere_evaluation
 * @property string $created_at
 * @property string $updated_at
 * @property TraitementParCritereCommentaire[] $traitementParCritereCommentaires
 * @property ActionFormationPlan $actionFormationPlan
 * @property CritereEvaluation $critereEvaluation
 * @property User $user
 */
class TraitementParCriterePrfCoord extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'traitement_par_critere_prf_coord';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_traitement_par_critere';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_traitement_par_critere', 'id_projet_formation', 'id_critere_evaluation', 'id_demande', 'flag_critere_evaluation','code_traitement', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function traitementParCritereCommentaires()
    {
        return $this->hasMany('App\Models\TraitementParCritereCommentaire', 'id_traitement_par_critere', 'id_traitement_par_critere');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ProjetFormation()
    {
        return $this->belongsTo('App\Models\ProjetFormation', 'id_action_formation_plan', 'id_action_formation_plan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function critereEvaluation()
    {
        return $this->belongsTo('App\Models\CritereEvaluation', 'id_critere_evaluation', 'id_critere_evaluation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_traitement_par_critere');
    }
}
