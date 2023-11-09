<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_pieces_projet_etude
 * @property float $id_projet_etude
 * @property string $code_pieces
 * @property string $libelle_pieces
 * @property string $created_at
 * @property string $updated_at
 * @property ProjetEtude $projetEtude
 */
class PiecesProjetEtude extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pieces_projet_etude';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_pieces_projet_etude';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_projet_etude', 'code_pieces', 'libelle_pieces', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projetEtude()
    {
        return $this->belongsTo('App\Models\ProjetEtude', 'id_projet_etude', 'id_projet_etude');
    }
}
