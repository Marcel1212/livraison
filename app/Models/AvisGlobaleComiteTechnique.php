<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_avis_globale_comite_technique
 * @property float $id_user_traitement
 * @property float $id_comite
 * @property float $id_statut_operation
 * @property float $id_motif
 * @property float $id_categorie_comite
 * @property float $id_demande
 * @property string $code_processus
 * @property string $commentaire_agct
 * @property boolean $flag_avis_globale_comite_technique
 * @property string $created_at
 * @property string $updated_at
 * @property CategorieComite $categorieComite
 * @property Comite $comite
 * @property Motif $motif
 * @property StatutOperation $statutOperation
 * @property User $user
 */
class AvisGlobaleComiteTechnique extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'avis_globale_comite_technique';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_avis_globale_comite_technique';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_traitement', 'id_comite', 'id_statut_operation', 'id_motif', 'id_categorie_comite', 'id_demande', 'code_processus', 'commentaire_agct', 'flag_avis_globale_comite_technique', 'created_at', 'updated_at'];

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
    public function comite()
    {
        return $this->belongsTo('App\Models\Comite', 'id_comite', 'id_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif', 'id_motif');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statutOperation()
    {
        return $this->belongsTo('App\Models\StatutOperation', 'id_statut_operation', 'id_statut_operation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_traitement');
    }
}
