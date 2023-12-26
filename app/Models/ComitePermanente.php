<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_permanente
 * @property float $id_type_comite_comite_permanente
 * @property float $id_user_comite_permanente
 * @property string $date_debut_comite_permanente
 * @property string $date_fin_comite_permanente
 * @property string $commentaire_comite_permanente
 * @property string $code_comite_permanente
 * @property string $code_pieces_comite_permanente
 * @property boolean $flag_comite_permanente
 * @property boolean $flag_statut_comite_permanente
 * @property string $created_at
 * @property string $updated_at
 * @property FicheAgrement[] $ficheAgrements
 * @property ComitePermanenteParticipant[] $comitePermanenteParticipants
 * @property TypeComite $typeComite
 * @property User $user
 */
class ComitePermanente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'comite_permanente';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_comite_permanente';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_comite_comite_permanente', 'id_user_comite_permanente', 'date_debut_comite_permanente', 'date_fin_comite_permanente', 'commentaire_comite_permanente', 'code_comite_permanente', 'code_pieces_comite_permanente', 'flag_comite_permanente', 'flag_statut_comite_permanente', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficheAgrements()
    {
        return $this->hasMany('App\Models\FicheAgrement', 'id_comite_permanente', 'id_comite_permanente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comitePermanenteParticipants()
    {
        return $this->hasMany('App\Models\ComitePermanenteParticipant', 'id_comite_permanente', 'id_comite_permanente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeComite()
    {
        return $this->belongsTo('App\Models\TypeComite', 'id_type_comite_comite_permanente', 'id_type_comite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_comite_permanente');
    }
}
