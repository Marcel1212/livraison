<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cotisation
 * @property float $id_entreprise
 * @property float $id_type_cotisation
 * @property float $montant
 * @property string $date_paiement
 * @property float $mois_cotisation
 * @property float $annee_cotisation
 * @property boolean $flag_cotisation
 * @property string $created_at
 * @property string $updated_at
 * @property float $id_agent
 * @property string $commentaire_coti
 * @property Entreprise $entreprise
 * @property TypeCotisation $typeCotisation
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
    protected $fillable = ['id_entreprise', 'id_type_cotisation', 'montant', 'date_paiement', 'mois_cotisation', 'annee_cotisation', 'flag_cotisation', 'created_at', 'updated_at', 'id_agent', 'commentaire_coti'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprise', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeCotisation()
    {
        return $this->belongsTo('App\Models\TypeCotisation', 'id_type_cotisation', 'id_type_cotisation');
    }
}
