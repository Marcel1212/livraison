<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cotisation
 * @property float $id_entreprise
 * @property float $montant
 * @property string $date_paiement
 * @property float $mois_cotisation
 * @property float $annee_cotisation
 * @property boolean $flag_cotisation
 * @property string $created_at
 * @property string $updated_at
 * @property Entreprise $entreprise
 */
class Cotisation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cotisation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cotisation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_entreprise', 'montant', 'date_paiement', 'mois_cotisation', 'annee_cotisation', 'flag_cotisation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprise', 'id_entreprise', 'id_entreprises');
    }
}
