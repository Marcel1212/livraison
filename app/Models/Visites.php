<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_visites
 * @property float $id_demande_habilitation
 * @property float $id_charger_habilitation_visite
 * @property string $date_visite
 * @property string $heure_visite
 * @property string $description_lieu
 * @property boolean $flag_visites
 * @property string $statut
 * @property string $created_at
 * @property string $updated_at
 * @property string $date_fin_visite
 * @property string $heure_visite_fin
 * @property string $heure_visite_fin_reel
 * @property MotifReportAnnulation[] $motifReportAnnulations
 * @property DemandeHabilitation $demandeHabilitation
 * @property User $userchargerhabilitationvisite
 * @property RapportsVisite[] $rapportsVisites
 */
class Visites extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_visites';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_demande_habilitation', 'id_charger_habilitation_visite', 'date_visite', 'heure_visite', 'description_lieu', 'flag_visites', 'statut', 'created_at', 'updated_at', 'date_fin_visite', 'heure_visite_fin', 'heure_visite_fin_reel'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function motifReportAnnulations()
    {
        return $this->hasMany('App\Models\MotifReportAnnulation', 'id_visites', 'id_visites');
    }

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
    public function userchargerhabilitationvisite()
    {
        return $this->belongsTo('App\Models\User', 'id_charger_habilitation_visite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rapportsVisites()
    {
        return $this->hasMany('App\Models\RapportsVisite', 'id_visites', 'id_visites');
    }
}
