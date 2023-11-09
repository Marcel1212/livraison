<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_entreprises
 * @property float $id_demande_enrolement
 * @property string $numero_fdfp_entreprises
 * @property string $ncc_entreprises
 * @property string $raison_social_entreprises
 * @property float $tel_entreprises
 * @property float $indicatif_entreprises
 * @property float $numero_cnps_entreprises
 * @property string $rccm_entreprises
 * @property boolean $flag_actif_entreprises
 * @property string $created_at
 * @property string $updated_at
 * @property DemandeEnrolement $demandeEnrolement
 * @property Piece[] $pieces
 */
class Entreprises extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entreprises';

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
    protected $fillable = ['id_demande_enrolement', 'numero_fdfp_entreprises', 'ncc_entreprises', 'raison_social_entreprises', 'tel_entreprises', 'indicatif_entreprises', 'numero_cnps_entreprises', 'rccm_entreprises', 'flag_actif_entreprises', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demandeEnrolement()
    {
        return $this->belongsTo('App\Models\DemandeEnrolement', 'id_demande_enrolement', 'id_demande_enrolement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pieces()
    {
        return $this->hasMany('App\Models\Piece', 'id_entreprises', 'id_entreprises');
    }
}
