<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_rapports_visites
 * @property float $id_visites
 * @property float $id_demande_habilitation
 * @property string $contenu
 * @property boolean $flag_rapports_visites
 * @property string $date_rapport
 * @property string $created_at
 * @property string $updated_at
 * @property string $etat_locaux_rapport
 * @property string $equipement_rapport
 * @property string $salubrite_rapport
 * @property string $avis_comite_technique
 * @property DemandeHabilitation $demandeHabilitation
 * @property Visites $visites
 */
class RapportsVisites extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_rapports_visites';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_visites', 'id_demande_habilitation', 'contenu', 'flag_rapports_visites', 'date_rapport', 'created_at', 'updated_at', 'etat_locaux_rapport', 'equipement_rapport', 'salubrite_rapport', 'avis_comite_technique'];

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
    public function visites()
    {
        return $this->belongsTo('App\Models\Visites', 'id_visites', 'id_visites');
    }
}
