<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCahierProjetEtude extends Model{

    /**
     * @property float $id_ligne_cahier_projet_etude
     * @property float $id_cahier_projet_etude
     * @property float $id_projet_etude
     * @property boolean $flag_ligne_cahier_projet_etude
     * @property boolean $flag_statut_soumis_ligne_cahier_projet_etude
     * @property string $created_at
     * @property string $updated_at
     * @property CahierprojetEtude $cahierprojetEtude
     * @property projetEtude $projetEtude
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ligne_cahier_projet_etude';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ligne_cahier_projet_etude';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_cahier_projet_etude', 'id_projet_etude', 'flag_ligne_cahier_projet_etude', 'flag_statut_soumis_ligne_cahier_projet_etude', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cahierprojetEtude()
    {
        return $this->belongsTo('App\Models\CahierProjetEtude', 'id_cahier_projet_etude', 'id_cahier_projet_etude');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projetEtude()
    {
        return $this->belongsTo('App\Models\ProjetEtude', 'id_projet_etude', 'id_projet_etude');
    }
}
