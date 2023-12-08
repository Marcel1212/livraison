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
    protected $fillable = ['id_entreprises', 'titre_projet_etude', 'promoteur', 'operateur', 'beneficiaires_cible', 'zone_projet', 'date_depot_demande', 'nom_prenoms', 'fonction', 'telephone', 'environnement_contexte', 'acteurs', 'role_p', 'responsabilite', 'problemes', 'manifestation_impact_effet', 'moyens_probables', 'competences', 'evaluation_contexte', 'source_verification', 'updated_at', 'created_at', 'id_user', 'flag_soumis', 'flag_valide', 'flag_rejet', 'date_soumis', 'date_valide', 'date_rejet','id_entreprises'];

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
        return $this->belongsTo('App\Models\Entreprise', 'id_entreprises', 'id_entreprises');
    }
}
