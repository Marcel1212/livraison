<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_secteur_user_consseiller
 * @property float $id_user_conseiller
 * @property float $id_secteur_activite
 * @property boolean $flag_secteur_activite_user_conseiller
 * @property string $updated_at
 * @property string $created_at
 * @property User $user
 * @property SecteurActivite $secteurActivite
 */
class SecteurActiviteUserConseiller extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'secteur_activite_user_conseiller';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_secteur_user_consseiller';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user_conseiller', 'id_secteur_activite', 'flag_secteur_activite_user_conseiller', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user_conseiller');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteurActivite()
    {
        return $this->belongsTo('App\Models\SecteurActivite', 'id_secteur_activite', 'id_secteur_activite');
    }
}
