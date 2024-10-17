<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_demande_habilitation
 * @property float $id_banque
 * @property float $id_entreprises
 * @property float $id_charge_habilitation
 * @property float $id_chef_service
 * @property float $id_motif_recevable
 * @property float $id_processus
 * @property string $nom_responsable_demande_habilitation
 * @property string $fonction_demande_habilitation
 * @property string $maison_mere_demande_habilitation
 * @property string $agence_domiciliation_demande_habilitation
 * @property string $type_entreprise
 * @property boolean $flag_demande_habilitation
 * @property string $date_creer_demande_habilitation
 * @property boolean $flag_creer_demande_habilitation
 * @property string $date_soumis_demande_habilitation
 * @property boolean $flag_soumis_demande_habilitation
 * @property string $date_reception_demande_habilitation
 * @property boolean $flag_reception_demande_habilitation
 * @property string $date_rejet_demande_habilitation
 * @property boolean $flag_rejet_demande_habilitation
 * @property string $date_valide_demande_habilitation
 * @property boolean $flag_valide_demande_habilitation
 * @property boolean $flag_soumis_comite_technique
 * @property string $materiel_didactique_demande_habilitation
 * @property boolean $information_catalogue_demande_habilitation
 * @property string $dernier_catalogue_demande_habilitation
 * @property string $reference_ci_demande_habilitation
 * @property boolean $information_seul_activite_demande_habilitation
 * @property string $autre_activite_demande_habilitation
 * @property string $created_at
 * @property string $updated_at
 * @property string $code_demande_habilitation
 * @property boolean $flag_agrement_demande_habilitaion
 * @property boolean $flag_valider_comite_technique
 * @property boolean $flag_passer_comite_technique
 * @property boolean $flag_traiter_commission_permanente
 * @property string $date_agrement_demande_habilitation
 * @property string $date_flag_valider_comite_technique
 * @property string $date_flag_passer_comite_technique
 * @property string $date_soumis_comite_technique
 * @property string $date_debut_validite
 * @property string $date_fin_validite
 * @property string $email_responsable_habilitation
 * @property string $contact_responsable_habilitation
 * @property string $type_demande
 * @property string $commantaire_cs
 * @property string $date_transmi_charge_habilitation
 * @property string $date_passe_cahier_cp_cg
 * @property string $date_traiter_commission_permanente
 * @property boolean $flag_soumis_charge_habilitation
 * @property string $commentaire_recevabilite
 * @property string $titre_propriete_contrat_bail
 * @property string $autorisation_ouverture_ecole
 * @property string $releve_identite_bancaire
 * @property boolean $flag_ecole_autre_entreprise
 * @property boolean $flag_demande_habilitation_valider_par_processus
 * @property boolean $flag_demande_habilitation_valider_cahier
 * @property boolean $flag_passer_cahier_cp_cg
 * @property OrganisationFormation[] $organisationFormations
 * @property DemandeIntervention[] $demandeInterventions
 * @property Visites[] $visites
 * @property Motif $motif
 * @property User $userchefservice
 * @property User $userchargerhabilitation
 * @property Banque $banque
 * @property Entreprises $entreprise
 * @property MoyenPermanente[] $moyenPermanentes
 * @property InterventionHorsCi[] $interventionHorsCis
 * @property DomaineDemandeHabilitation[] $domaineDemandeHabilitations
 */
class DemandeHabilitation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'demande_habilitation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_demande_habilitation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_banque', 'id_entreprises', 'id_charge_habilitation', 'id_chef_service', 'id_motif_recevable','id_processus',
                            'nom_responsable_demande_habilitation', 'fonction_demande_habilitation', 'maison_mere_demande_habilitation',
                            'agence_domiciliation_demande_habilitation', 'type_entreprise', 'flag_demande_habilitation', 'date_creer_demande_habilitation',
                            'flag_creer_demande_habilitation', 'date_soumis_demande_habilitation', 'flag_soumis_demande_habilitation',
                            'date_reception_demande_habilitation', 'flag_reception_demande_habilitation', 'date_rejet_demande_habilitation',
                            'flag_rejet_demande_habilitation', 'date_valide_demande_habilitation', 'flag_valide_demande_habilitation',
                            'materiel_didactique_demande_habilitation', 'information_catalogue_demande_habilitation',
                            'dernier_catalogue_demande_habilitation', 'reference_ci_demande_habilitation', 'information_seul_activite_demande_habilitation',
                            'autre_activite_demande_habilitation', 'created_at', 'updated_at', 'code_demande_habilitation',
                            'flag_agrement_demande_habilitaion', 'date_agrement_demande_habilitation', 'email_responsable_habilitation',
                            'contact_responsable_habilitation', 'type_demande', 'commantaire_cs', 'date_transmi_charge_habilitation',
                            'flag_soumis_charge_habilitation', 'commentaire_recevabilite', 'titre_propriete_contrat_bail', 'autorisation_ouverture_ecole',
                            'flag_ecole_autre_entreprise','flag_soumis_comite_technique','date_soumis_comite_technique','date_flag_passer_comite_technique',
                            'flag_passer_comite_technique','flag_valider_comite_technique','date_flag_valider_comite_technique','releve_identite_bancaire',
                            'flag_demande_habilitation_valider_par_processus','flag_demande_habilitation_valider_cahier','flag_passer_cahier_cp_cg',
                            'date_passe_cahier_cp_cg','flag_traiter_commission_permanente','date_traiter_commission_permanente','date_fin_validite',
                            'date_debut_validite'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisationFormations()
    {
        return $this->hasMany('App\Models\OrganisationFormation', 'id_demande_habilitation', 'id_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandeInterventions()
    {
        return $this->hasMany('App\Models\DemandeIntervention', 'id_demande_habilitation', 'id_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visites()
    {
        return $this->hasMany('App\Models\Visites', 'id_demande_habilitation', 'id_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif_recevable', 'id_motif');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userchefservice()
    {
        return $this->belongsTo('App\Models\User', 'id_chef_service');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userchargerhabilitation()
    {
        return $this->belongsTo('App\Models\User', 'id_charge_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banque()
    {
        return $this->belongsTo('App\Models\Banque', 'id_banque', 'id_banque');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprises', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moyenPermanentes()
    {
        return $this->hasMany('App\Models\MoyenPermanente', 'id_demande_habilitation', 'id_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function interventionHorsCis()
    {
        return $this->hasMany('App\Models\InterventionHorsCi', 'id_demande_habilitation', 'id_demande_habilitation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domaineDemandeHabilitations()
    {
        return $this->hasMany('App\Models\DomaineDemandeHabilitation', 'id_demande_habilitation', 'id_demande_habilitation');
    }
}
