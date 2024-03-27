<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_traitement_par_critere_commentaire
 * @property float $id_user_traitement_par_critere_commentaire
 * @property float $id_traitement_par_critere
 * @property boolean $flag_traitement_par_critere_commentaire
 * @property boolean $flag_traitement_par_critere_commentaire_traiter
 * @property boolean $flag_traite_par_user_conserne
 * @property string $commentaire_critere
 * @property string $commentaire_reponse
 * @property string $created_at
 * @property string $updated_at
 * @property TraitementParCritere $traitementParCritere
 * @property User $user
 */
class TraitementParCritereCommentaire extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'traitement_par_critere_commentaire';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_traitement_par_critere_commentaire';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_traitement_par_critere_commentaire', 'id_traitement_par_critere', 'flag_traitement_par_critere_commentaire', 'flag_traitement_par_critere_commentaire_traiter', 'commentaire_critere', 'commentaire_reponse', 'created_at', 'updated_at','flag_traite_par_user_conserne'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function traitementParCritere()
    {
        return $this->belongsTo('App\Models\TraitementParCritere', 'id_traitement_par_critere', 'id_traitement_par_critere');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_traitement_par_critere_commentaire');
    }
}
