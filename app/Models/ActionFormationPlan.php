<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_action_formation_plan
 * @property float $id_plan_de_formation
 * @property float $id_entreprise_structure_formation_action
 * @property float $motif_non_financement_action_formation
 * @property string $intitule_action_formation_plan
 * @property string $structure_etablissement_action_
 * @property float $nombre_stagiaire_action_formati
 * @property float $nombre_groupe_action_formation_
 * @property float $nombre_heure_action_formation_p
 * @property float $cout_action_formation_plan
 * @property boolean $flag_valide_action_formation_pl
 * @property string $created_at
 * @property string $updated_at
 * @property string $numero_action_formation_plan
 * @property string $facture_proforma_action_formati
 * @property float $cout_accorde_action_formation
 * @property string $commentaire_action_formation
 * @property FicheADemandeAgrement[] $ficheADemandeAgrements
 * @property PlanFormation $planFormation
 * @property EntrepriseHabilitation $entreprisehabilitation
 * @property Motif $motif
 */
class ActionFormationPlan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_formation_plan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_action_formation_plan';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_plan_de_formation', 'motif_non_financement_action_formation', 'intitule_action_formation_plan', 'structure_etablissement_action_', 'nombre_stagiaire_action_formati', 'nombre_groupe_action_formation_', 'nombre_heure_action_formation_p', 'cout_action_formation_plan', 'flag_valide_action_formation_pl', 'created_at', 'updated_at', 'numero_action_formation_plan', 'facture_proforma_action_formati', 'cout_accorde_action_formation', 'commentaire_action_formation','id_entreprise_structure_formation_action'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficheADemandeAgrements()
    {
        return $this->hasMany('App\Models\FicheADemandeAgrement', 'id_action_formation_plan', 'id_action_formation_plan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planFormation()
    {
        return $this->belongsTo('App\Models\PlanFormation', 'id_plan_de_formation', 'id_plan_de_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprisehabilitation()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprise_structure_formation_action', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'motif_non_financement_action_formation', 'id_motif');
    }
}
