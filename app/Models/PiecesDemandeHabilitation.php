<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_pieces_demande_habilitation
 * @property float $id_demande_habilitation
 * @property float $id_types_pieces
 * @property string $pieces_demande_habilitation
 * @property boolean $flag_pieces_demande_habilitation
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeHabilitation $demandeHabilitation
 * @property TypesPieces $typesPiece
 */
class PiecesDemandeHabilitation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pieces_demande_habilitation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pieces_demande_habilitation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_demande_habilitation', 'id_types_pieces', 'pieces_demande_habilitation', 'flag_pieces_demande_habilitation', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demandeHabilitation()
    {
        return $this->belongsTo('App\Models\DemandeHabilitation', 'id_demande_habilitation', 'id_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typesPiece()
    {
        return $this->belongsTo('App\Models\TypesPieces', 'id_types_pieces', 'id_types_pieces');
    }
}
