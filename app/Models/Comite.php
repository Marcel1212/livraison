<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite
 * @property float $id_user_comite
 * @property float $id_departement
 * @property float $id_categorie_comite
 * @property float $id_periode_exercice
 * @property string $date_debut_comite
 * @property string $date_fin_comite
 * @property string $commentaire_comite
 * @property string $code_comite
 * @property string $code_pieces
 * @property boolean $flag_comite
 * @property boolean $flag_statut_comite
 * @property string $created_at
 * @property string $updated_at
 * @property string $objet_comite
 * @property CategorieComite $categorieComite
 * @property Departement $departement
 * @property User $user
 * @property CahierComite[] $cahierComites
 * @property ProcessusComiteLieComite[] $processusComiteLieComites
 * @property ComiteParticipant[] $comiteParticipants
 */
class Comite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comite';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_comite';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_comite', 'id_departement', 'id_categorie_comite', 'date_debut_comite', 'date_fin_comite', 'commentaire_comite', 'code_comite', 'code_pieces', 'flag_comite', 'flag_statut_comite', 'created_at', 'updated_at', 'objet_comite','id_periode_exercice'];

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
    public function departement()
    {
        return $this->belongsTo('App\Models\Departement', 'id_departement', 'id_departement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cahierComites()
    {
        return $this->hasMany('App\Models\CahierComite', 'id_comite', 'id_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processusComiteLieComites()
    {
        return $this->hasMany('App\Models\ProcessusComiteLieComite', 'id_comite', 'id_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comiteParticipants()
    {
        return $this->hasMany('App\Models\ComiteParticipant', 'id_comite', 'id_comite');
    }
}
