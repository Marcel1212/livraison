<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_entreprises
 * @property float $id_demande_enrolement
 * @property float $id_activite_entreprises
 * @property float $id_localite_entreprises
 * @property float $id_centre_impot
 * @property float $id_pays
 * @property float $id_secteur_activite_entreprise
 * @property float $id_forme_juridique_entreprise
 * @property string $numero_fdfp_entreprises
 * @property string $ncc_entreprises
 * @property string $raison_social_entreprises
 * @property float $tel_entreprises
 * @property float $indicatif_entreprises
 * @property float $numero_cnps_entreprises
 * @property string $rccm_entreprises
 * @property string $email_entreprises
 * @property boolean $flag_actif_entreprises
 * @property boolean $flag_cabinet_etranger
 * @property string $created_at
 * @property string $updated_at
 * @property string $localisation_geographique_entreprise
 * @property string $repere_acces_entreprises
 * @property string $adresse_postal_entreprises
 * @property string $cellulaire_professionnel_entreprises
 * @property string $fax_entreprises
 * @property boolean $flag_habilitation_entreprise
 * @property DemandeEnrolement $demandeEnrolement
 * @property Activites $activite
 * @property CentreImpot $centreImpot
 * @property Localite $localite
 * @property Pays $pay
 * @property FormeJuridique $formeJuridique
 * @property SecteurActivite $secteurActivite
 * @property PlanFormation[] $planFormations
 * @property PlanFormation[] $planFormations1
 * @property ActionFormationPlan[] $actionFormationPlans
 * @property Pieces[] $pieces
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
     * @var array
     */
    protected $fillable = ['id_demande_enrolement', 'id_activite_entreprises', 'id_localite_entreprises', 'id_centre_impot', 'id_pays', 'id_secteur_activite_entreprise', 'id_forme_juridique_entreprise', 'numero_fdfp_entreprises', 'ncc_entreprises', 'raison_social_entreprises', 'tel_entreprises', 'indicatif_entreprises', 'numero_cnps_entreprises', 'rccm_entreprises', 'flag_actif_entreprises', 'created_at', 'updated_at', 'localisation_geographique_entreprise', 'repere_acces_entreprises', 'adresse_postal_entreprises', 'cellulaire_professionnel_entreprises', 'fax_entreprises', 'flag_habilitation_entreprise','email_entreprises','flag_cabinet_etranger'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demandeEnrolement()
    {
        return $this->belongsTo('App\Models\DemandeEnrolement', 'id_demande_enrolement', 'id_demande_enrolement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activite()
    {
        return $this->belongsTo('App\Models\Activites', 'id_activite_entreprises', 'id_activites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centreImpot()
    {
        return $this->belongsTo('App\Models\CentreImpot', 'id_centre_impot', 'id_centre_impot');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localite()
    {
        return $this->belongsTo('App\Models\Localite', 'id_localite_entreprises', 'id_localite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        return $this->belongsTo('App\Models\Pays', 'id_pays', 'id_pays');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formeJuridique()
    {
        return $this->belongsTo('App\Models\FormeJuridique', 'id_forme_juridique_entreprise', 'id_forme_juridique');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteurActivite()
    {
        return $this->belongsTo('App\Models\SecteurActivite', 'id_secteur_activite_entreprise', 'id_secteur_activite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planFormations()
    {
        return $this->hasMany('App\Models\PlanFormation', 'id_entreprises', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planFormations1()
    {
        return $this->hasMany('App\Models\PlanFormation', 'id_entreprise_structure_formation_plan_formation', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionFormationPlans()
    {
        return $this->hasMany('App\Models\ActionFormationPlan', 'id_entreprise_structure_formation_action', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pieces()
    {
        return $this->hasMany('App\Models\Pieces', 'id_entreprises', 'id_entreprises');
    }


}
