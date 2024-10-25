<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_processus_autre_demande
 * @property string $code_processus_autre_demande
 * @property string $libelle_processus_autre_demande
 * @property boolean $flag_processus_autre_demande
 * @property string $created_at
 * @property string $updated_at
 */
class ProcessusAutreDemande extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_processus_autre_demande';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['code_processus_autre_demande', 'libelle_processus_autre_demande', 'flag_processus_autre_demande', 'created_at', 'updated_at'];
}
