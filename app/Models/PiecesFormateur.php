<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_pieces_formateur
 * @property float $id_formateurs
 * @property float $id_types_pieces
 * @property string $pieces_formateur
 * @property boolean $flag_pieces_formateur
 * @property string $created_at
 * @property string $updated_at
 * @property Formateurs $formateur
 * @property TypesPieces $typesPiece
 */
class PiecesFormateur extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pieces_formateur';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pieces_formateur';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_formateurs', 'id_types_pieces', 'pieces_formateur', 'flag_pieces_formateur', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formateur()
    {
        return $this->belongsTo('App\Models\Formateurs', 'id_formateurs', 'id_formateurs');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typesPiece()
    {
        return $this->belongsTo('App\Models\TypesPieces', 'id_types_pieces', 'id_types_pieces');
    }
}
