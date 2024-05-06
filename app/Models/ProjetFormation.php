<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_projet_formation
 * @property float $id_entreprises
 * @property string $titre_projet_etude
 * @property string $promoteur
 * @property string $operateur
 * @property string $beneficiaires_cible
 * @property string $zone_projet
 * @property string $date_depot_demande
 * @property string $nom_prenoms
 * @property string $fonction
 * @property string $telephone
 * @property string $environnement_contexte
 * @property string $acteurs
 * @property string $role_p
 * @property string $responsabilite
 * @property string $problemes
 * @property string $manifestation_impact_effet
 * @property string $moyens_probables
 * @property string $competences
 * @property string $evaluation_contexte
 * @property string $source_verification
 * @property string $updated_at
 * @property string $created_at
 * @property float $id_user
 * @property boolean $flag_soumis
 * @property boolean $flag_valide
 * @property boolean $flag_rejet
 * @property string $date_soumis
 * @property string $date_valide
 * @property string $date_rejet
 * @property PiecesProjetFormation[] $piecesProjetFormations
 * @property Entreprise $entreprise
 * @property Operateur $operateur
 * @property DomaineProjetFormation $domaineFormation
 */
class ProjetFormation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projet_formation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_projet_formation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_entreprises', 'titre_projet_etude', 'id_operateur' , 'promoteur','id_domaine_projet_formation','flag_passer_comite_coordination','flag_passer_cahier_cp_cg','id_type_projet_formation', 'flag_valider_cc_projet_formation', 'date_valider_cc_projet_formation', 'flag_passer_comite_technique', 'operateur', 'beneficiaires_cible', 'zone_projet', 'date_depot_demande', 'nom_prenoms', 'fonction', 'telephone', 'environnement_contexte', 'acteurs', 'role_p', 'responsabilite', 'problemes', 'manifestation_impact_effet', 'moyens_probables', 'competences', 'evaluation_contexte', 'source_verification', 'updated_at', 'created_at', 'id_user', 'flag_soumis', 'flag_valide', 'flag_rejet', 'date_soumis', 'date_valide', 'date_rejet','id_entreprises','id_processus','commentaire_directeur','date_trans_chef_service','flag_affect_departement','id_departement','id_chef_departement','flag_affect_service','commentaire_departement','date_trans_service','id_chef_service','id_service','flag_affect_conseiller_formation','commentaire_chef_service','date_trans_conseiller_formation','id_conseiller_formation','flag_recevabilite','date_recevabilite','flag_statut_instruction','commpetences_instruction','date_instructions','titre_projet_instruction','cout_projet_instruction','commentaires_recevabilite','roles_beneficiaire','responsabilites_beneficiaires','roles_promoteur','responsabilites_promoteur','roles_partenaires','responsabilites_partenaires','autre_acteur','roles_autres','responsabilites_autres','flag_coordination','flag_comite_pleiniere','code_comite_pleiniere','id_comite_pleiniere', 'type_comite','code_projet_formation','date_valider_comite_gestion_projet_formation','id_processus','date_valider_comite_permanente_projet_formation','flag_fiche_agrement','cout_projet_formation','num_agce','id_directeur','flag_processus_etape','flag_traiter_commission_permanente'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function piecesProjetFormations()
    {
        return $this->hasMany('App\Models\PiecesProjetFormation', 'id_projet_formation', 'id_projet_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_entreprises', 'id_entreprises');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operateur_selectionne()
    {
        return $this->belongsTo('App\Models\Entreprises', 'id_operateur', 'id_entreprises');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agence()
    {
        return $this->belongsTo('App\Models\Agence', 'num_agce', 'num_agce');
    }
         /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domaineFormation()
    {
        return $this->belongsTo('App\Models\DomaineProjetFormation', 'id_domaine_projet_formation', 'id_domaine_projet_formation');
    }
}
