<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_comite_rejeter
 * @property float $id_comite
 * @property float $id_demande
 * @property string $code_processus
 * @property string $commentaire_rejeter
 * @property string $commentaire_de_rejet
 * @property boolean $flag_comite_rejeter
 * @property boolean $flag_traite_comite_rejet
 * @property string $created_at
 * @property string $updated_at
 * @property string $date_traite_comite_rejet
 * @property Comite $comite
 */
class ComiteRejeter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comite_rejeter';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_comite_rejeter';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_comite', 'id_demande', 'code_processus', 'commentaire_rejeter', 'flag_comite_rejeter', 'created_at', 'updated_at','flag_traite_comite_rejet','date_traite_comite_rejet','commentaire_de_rejet'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comite()
    {
        return $this->belongsTo('App\Models\Comite', 'id_comite', 'id_comite');
    }
}
