<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_composition_capitale
 * @property float $id_type_composition_capitale
 * @property float $id_entreprises
 * @property float $montant_composition_capitale
 * @property boolean $flag_composition_capitale
 * @property string $created_at
 * @property string $updated_at
 * @property Entreprise $entreprise
 * @property TypeCompositionCapitale $typeCompositionCapitale
 */
class CompositionCapitale extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'composition_capitale';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_composition_capitale';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_type_composition_capitale', 'id_entreprises', 'flag_composition_capitale', 'created_at', 'updated_at','montant_composition_capitale'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprise', 'id_entreprises', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeCompositionCapitale()
    {
        return $this->belongsTo('App\Models\TypeCompositionCapitale', 'id_type_composition_capitale', 'id_type_composition_capitale');
    }
}
