<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_pieces
 * @property float $id_entreprises
 * @property string $code_pieces
 * @property string $libelle_pieces
 * @property string $created_at
 * @property string $updated_at
 * @property Entreprise $entreprise
 */
class Pieces extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_pieces';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_entreprises', 'code_pieces', 'libelle_pieces', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprise', 'id_entreprises', 'id_entreprises');
    }
}
