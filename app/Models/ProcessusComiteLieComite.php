<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_processus_comite_lie_comite
 * @property float $id_comite
 * @property float $id_processus_comite
 * @property string $code_pieces
 * @property boolean $flag_processus_comite_lie_comite
 * @property string $created_at
 * @property string $updated_at
 * @property Comite $comite
 * @property ProcessusComite $processusComite
 */
class ProcessusComiteLieComite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'processus_comite_lie_comite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_processus_comite_lie_comite';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_comite', 'id_processus_comite', 'code_pieces', 'flag_processus_comite_lie_comite', 'created_at', 'updated_at'];

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
    public function processusComite()
    {
        return $this->belongsTo('App\Models\ProcessusComite', 'id_processus_comite', 'id_processus_comite');
    }
}
