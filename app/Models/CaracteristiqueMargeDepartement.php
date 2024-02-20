<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_caracteristique_marge_departement
 * @property float $id_departement
 * @property float $marge_inferieur_cmd
 * @property float $marge_superieur_cmd
 * @property boolean $flag_cmd
 * @property string $created_at
 * @property string $updated_at
 * @property Departement $departement
 */
class CaracteristiqueMargeDepartement extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'caracteristique_marge_departement';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_caracteristique_marge_departement';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_departement', 'marge_inferieur_cmd', 'marge_superieur_cmd', 'flag_cmd', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departement()
    {
        return $this->belongsTo('App\Models\Departement', 'id_departement', 'id_departement');
    }
}
