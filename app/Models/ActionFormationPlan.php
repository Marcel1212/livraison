<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_action_formation_plan
 * @property float $id_plan_de_formation
 * @property float $id_entreprise_structure_formation_action
 * @property float $id_caracteristique_type_formation
 * @property float $id_domaine_formation
 * @property float $motif_non_financement_action_formation
 * @property string $intitule_action_formation_plan
 * @property string $structure_etablissement_action_
 * @property float $nombre_stagiaire_action_formati
 * @property float $nombre_groupe_action_formation_
 * @property float $nombre_heure_action_formation_p
 * @property float $cout_action_formation_plan
 * @property boolean $flag_valide_action_formation_pl
 * @property boolean $flag_valide_action_formation_pl_comite_gestion
 * @property boolean $flag_valide_action_formation_pl_comite_permanente
 * @property boolean $flag_action_formation_traiter_comite_technique
 * @property boolean $flag_action_formation_plan_traite_instruction
 * @property string $created_at
 * @property string $updated_at
 * @property string $date_action_formation_plan_traite_instruction
 * @property string $numero_action_formation_plan
 * @property string $facture_proforma_action_formati
 * @property float $cout_accorde_action_formation
 * @property float $montant_attribuable_fdfp
 * @property float $nombre_jour_action_formation
 * @property float $utilisation_direct_action_formation
 * @property float $finan_complemantaire_action_formation
 * @property float $pirorite_action_formation
 * @property string $commentaire_action_formation
 * @property string $commentaire_comite_technique
 * @property float $id_secteur_activite
 * @property FicheADemandeAgrement[] $ficheADemandeAgrements
 * @property PlanFormation $planFormation
 * @property EntrepriseHabilitation $entreprisehabilitation
 * @property DomaineFormation $domaineFormation
 * @property Motif $motif
 * @property SecteurActivite $secteurActivite
 * @property CaracteristiqueTypeFormation $caracteristiqueTypeFormation
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
    protected $fillable = ['id_plan_de_formation', 'motif_non_financement_action_formation', 'intitule_action_formation_plan', 'structure_etablissement_action_', 'nombre_stagiaire_action_formati', 'nombre_groupe_action_formation_', 'nombre_heure_action_formation_p', 'cout_action_formation_plan', 'flag_valide_action_formation_pl', 'created_at', 'updated_at', 'numero_action_formation_plan', 'facture_proforma_action_formati', 'cout_accorde_action_formation', 'commentaire_action_formation','id_entreprise_structure_formation_action','flag_valide_action_formation_pl_comite_gestion','flag_valide_action_formation_pl_comite_permanente','id_secteur_activite','id_caracteristique_type_formation','nombre_jour_action_formation','montant_attribuable_fdfp','pirorite_action_formation','flag_action_formation_traiter_comite_technique','commentaire_comite_technique','flag_action_formation_plan_traite_instruction','date_action_formation_plan_traite_instruction','utilisation_direct_action_formation','finan_complemantaire_action_formation','id_domaine_formation'];

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
    public function domaineFormation()
    {
        return $this->belongsTo('App\Models\DomaineFormation', 'id_domaine_formation', 'id_domaine_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'motif_non_financement_action_formation', 'id_motif');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteurActivite()
    {
        return $this->belongsTo('App\Models\SecteurActivite', 'id_secteur_activite', 'id_secteur_activite');
    }
//id_motif_demande_annulation_action_plan
    public function demandeAnnulation()
    {
        return $this->belongsTo(DemandeAnnulationPlan::class,'id_action_formation_plan','id_action_plan');
    }

    public function demandeSubstitution()
    {
        return $this->belongsTo(DemandeSubstitutionActionPlanFormation::class,'id_action_formation_plan','id_action_formation_plan_substi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function caracteristiqueTypeFormation()
    {
        return $this->belongsTo('App\Models\CaracteristiqueTypeFormation', 'id_caracteristique_type_formation', 'id_caracteristique_type_formation');
    }
}
