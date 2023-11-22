<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_pieces_projet_formation
 * @property float $id_projet_formation
 * @property string $code_pieces
 * @property string $libelle_pieces
 * @property string $created_at
 * @property string $updated_at
 * @property ProjetFormation $projetFormation
 */
class PiecesProjetFormation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pieces_projet_formation';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_pieces_projet_formation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_projet_formation', 'code_pieces', 'libelle_pieces', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projetFormation()
    {
        return $this->belongsTo('App\Models\ProjetFormation', 'id_projet_formation', 'id_projet_formation');
    }
}
