<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_gestion
 * @property float $id_type_comite_comite_gestion
 * @property float $id_user_comite_gestion
 * @property string $date_debut_comite_gestion
 * @property string $date_fin_comite_gestion
 * @property string $commentaire_comite_gestion
 * @property string $code_comite_gestion
 * @property string $code_pieces_comite_gestion
 * @property boolean $flag_comite_gestion
 * @property boolean $flag_statut_comite_gestion
 * @property string $created_at
 * @property string $updated_at
 * @property FicheAgrement[] $ficheAgrements
 * @property ComiteGestionParticipant[] $comiteGestionParticipants
 * @property TypeComite $typeComite
 * @property User $user
 */
class ComiteGestion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comite_gestion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_comite_gestion';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_comite_comite_gestion', 'id_user_comite_gestion', 'date_debut_comite_gestion', 'date_fin_comite_gestion', 'commentaire_comite_gestion', 'code_comite_gestion', 'code_pieces_comite_gestion', 'flag_comite_gestion', 'flag_statut_comite_gestion', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficheAgrements()
    {
        return $this->hasMany('App\Models\FicheAgrement', 'id_comite_gestion', 'id_comite_gestion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comiteGestionParticipants()
    {
        return $this->hasMany('App\Models\ComiteGestionParticipant', 'id_comite_gestion', 'id_comite_gestion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeComite()
    {
        return $this->belongsTo('App\Models\TypeComite', 'id_type_comite_comite_gestion', 'id_type_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_comite_gestion');
    }
}
