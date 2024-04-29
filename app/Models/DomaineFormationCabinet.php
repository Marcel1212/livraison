<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_domaine_formation_cabinet
 * @property float $id_domaine_formation
 * @property float $id_entreprises
 * @property boolean $flag_domaine_formation_cabinet
 * @property string $created_at
 * @property string $updated_at
 * @property DomaineFormation $domaineFormation
 * @property Entreprise $entreprise
 */
class DomaineFormationCabinet extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'domaine_formation_cabinet';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_domaine_formation_cabinet';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_domaine_formation', 'id_entreprises', 'flag_domaine_formation_cabinet', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domaineFormation()
    {
        return $this->belongsTo('App\Models\DomaineFormation', 'id_domaine_formation', 'id_domaine_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprise', 'id_entreprises', 'id_entreprises');
    }
}
