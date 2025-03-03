<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_critere_evaluation
 * @property float $id_categorie_comite
 * @property float $id_processus_comite
 * @property string $code_critere_evaluation
 * @property string $libelle_critere_evaluation
 * @property boolean $flag_critere_evaluation
 * @property string $created_at
 * @property string $updated_at
 * @property CategorieComite $categorieComite
 * @property ProcessusComite $processusComite
 * @property TraitementParCritere[] $traitementParCriteres
 */
class CritereEvaluation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'critere_evaluation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_critere_evaluation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_categorie_comite', 'id_processus_comite', 'code_critere_evaluation', 'libelle_critere_evaluation', 'flag_critere_evaluation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorieComite()
    {
        return $this->belongsTo('App\Models\CategorieComite', 'id_categorie_comite', 'id_categorie_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processusComite()
    {
        return $this->belongsTo('App\Models\ProcessusComite', 'id_processus_comite', 'id_processus_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function traitementParCriteres()
    {
        return $this->hasMany('App\Models\TraitementParCritere', 'id_critere_evaluation', 'id_critere_evaluation');
    }
}
