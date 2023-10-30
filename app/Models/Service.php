<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_service
 * @property float $id_departement
 * @property string $libelle_service
 * @property boolean $flag_service
 * @property string $created_at
 * @property string $updated_at
 * @property Departement $departement
 */
class Service extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'service';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_service';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_departement', 'libelle_service', 'flag_service', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departement()
    {
        return $this->belongsTo('App\Models\Departement', 'id_departement', 'id_departement');
    }
}
