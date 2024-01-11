<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_pleniere_pf
 * @property float $id_user_comite_pleniere_pf
 * @property string $date_debut_comite_pleniere_pf
 * @property string $date_fin_comite_pleniere_pf
 * @property string $commentaire_comite_pleniere_pf
 * @property string $code_comite_pleniere_pf
 * @property string $code_pieces_pf
 * @property boolean $flag_comite_pleniere_pf
 * @property boolean $flag_statut_comite_pleniere_pf
 * @property string $created_at
 * @property string $updated_at
 * @property ComitePleniereParticipant[] $comitePleniereParticipants
 * @property Cahier[] $cahiers
 * @property User $user
 */
class ComitePleniereProjetFormation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comite_pleniere_projet_formation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_comite_pleniere_pf';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_comite_pleniere_pf','id_user_comite_pleniere_pf', 'date_debut_comite_pleniere_pf', 'date_fin_comite_pleniere_pf', 'commentaire_comite_pleniere_pf', 'code_comite_pleniere_pf', 'code_pieces_pf', 'flag_comite_pleniere_pf', 'flag_statut_comite_pleniere_pf', 'created_at', 'updated_at'];

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
