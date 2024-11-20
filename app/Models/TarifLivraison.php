<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_tarif_livraison
 * @property float $id_commune_exp
 * @property float $id_commune_dest
 *  @property float $prix
 * @property string $libelle_commune_exp
 * @property string $libelle_commune_dest
 * @property boolean $flag_valide
 * @property string $created_at
 * @property string $updated_at
 * @property Localite $localite
 * @property Localite $localite
 */
class TarifLivraison extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tarif_livraison';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tarif_livraison';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_commune_exp', 'id_commune_dest', 'libelle_commune_exp', 'libelle_commune_dest', 'prix', 'flag_valide', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localite()
    {
        return $this->belongsTo('App\Models\Localite', 'id_commune_dest', 'id_localite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localitedest()
    {
        return $this->belongsTo('App\Models\Localite', 'id_commune_exp', 'id_localite');
    }
}
