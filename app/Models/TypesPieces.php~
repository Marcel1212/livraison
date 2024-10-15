<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_types_pieces
 * @property string $libelle_types_pieces
 * @property string $code_types_pieces
 * @property boolean $flag_types_pieces
 * @property string $created_at
 * @property string $updated_at
 * @property PiecesFormateur[] $piecesFormateurs
 */
class TypesPieces extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_types_pieces';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['libelle_types_pieces', 'code_types_pieces', 'flag_types_pieces', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function piecesFormateurs()
    {
        return $this->hasMany('App\Models\PiecesFormateur', 'id_types_pieces', 'id_types_pieces');
    }
}
