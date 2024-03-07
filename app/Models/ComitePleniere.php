<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_pleniere
 * @property float $id_user_comite_pleniere
 * @property string $date_debut_comite_pleniere
 * @property string $date_fin_comite_pleniere
 * @property string $commentaire_comite_pleniere
 * @property string $code_comite_pleniere
 * @property string $code_pieces
 * @property boolean $flag_comite_pleniere
 * @property boolean $flag_statut_comite_pleniere
 * @property string $created_at
 * @property string $updated_at
 * @property ComitePleniereParticipant[] $comitePleniereParticipants
 * @property Cahier[] $cahiers
 * @property User $user
 */
class ComitePleniere extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comite_pleniere';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_comite_pleniere';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_comite_pleniere', 'date_debut_comite_pleniere', 'lien_ct', 'intitule_comite', 'date_fin_comite_pleniere', 'commentaire_comite_pleniere', 'code_comite_pleniere', 'code_pieces', 'flag_comite_pleniere', 'flag_statut_comite_pleniere', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comitePleniereParticipants()
    {
        return $this->hasMany('App\Models\ComitePleniereParticipant', 'id_comite_pleniere', 'id_comite_pleniere');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cahiers()
    {
        return $this->hasMany('App\Models\Cahier', 'id_comite_pleniere', 'id_comite_pleniere');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_comite_pleniere');
    }
}
