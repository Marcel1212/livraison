<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_projet_formation_instruction
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
 * @property ProjetFormation_[] $ProjetFormation_
 * @property ProjetFormation $ProjetFormation
 *
 */
class ProjetFormationInstruction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projet_formation_instruction';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_projet_formation_instruction';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_entreprises','id_projet_formation', 'titre_projet_etude', 'promoteur', 'operateur', 'beneficiaires_cible', 'zone_projet', 'date_depot_demande', 'nom_prenoms', 'fonction', 'telephone', 'environnement_contexte', 'acteurs', 'role_p', 'responsabilite', 'problemes', 'manifestation_impact_effet', 'moyens_probables', 'competences', 'evaluation_contexte', 'source_verification', 'updated_at', 'created_at', 'id_user', 'flag_soumis', 'flag_valide', 'flag_rejet', 'date_soumis', 'date_valide', 'date_rejet','id_entreprises','id_processus','commentaire_directeur','date_trans_chef_service','flag_affect_departement','id_departement','id_chef_departement','flag_affect_service','commentaire_departement','date_trans_service','id_chef_service','id_service','flag_affect_conseiller_formation','commentaire_chef_service','date_trans_conseiller_formation','id_conseiller_formation','flag_recevabilite','date_recevabilite','flag_statut_instruction','commpetences_instruction','date_instructions','titre_projet_instruction','cout_projet_instruction','commentaires_recevabilite','roles_beneficiaire','responsabilites_beneficiaires','roles_promoteur','responsabilites_promoteur','roles_partenaires','responsabilites_partenaires','autre_acteur','roles_autres','responsabilites_autres','flag_comite_pleiniere','code_comite_pleiniere','id_comite_pleiniere','code_projet_formation','id_processus','flag_fiche_agrement','num_agce','id_directeur','flag_processus_etape'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ProjetFormation_()
    {
        return $this->hasMany('App\Models\ProjetFormation', 'id_projet_formation', 'id_projet_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ProjetFormation()
    {
        return $this->belongsTo('App\Models\ProjetFormation', 'id_projet_formation', 'id_projet_formation');
    }


}
