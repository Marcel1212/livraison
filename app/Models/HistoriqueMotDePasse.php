<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_historique
 * @property float $id_utilisateur
 * @property string $ancien_mot_de_passe_hash
 * @property string $date_changement
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class HistoriqueMotDePasse extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'historique_mot_de_passe';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_historique';

    /**
     * @var array
     */
    protected $fillable = ['id_utilisateur', 'ancien_mot_de_passe_hash', 'date_changement', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_utilisateur');
    }
}
