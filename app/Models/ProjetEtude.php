<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property float $id_projet_etude
 * @property float $id_entreprises
 * @property string $titre_projet_etude
 * @property string $contexte_probleme_projet_etude
 * @property string $objectif_general_projet_etude
 * @property string $objectif_specifique_projet_etud
 * @property string $resultat_attendu_projet_etude
 * @property string $cible_projet_etude
 * @property string $updated_at
 * @property string $created_at
 * @property float $id_user
 * @property float $id_user_affecte
 * @property boolean $flag_soumis
 * @property boolean $flag_valide
 * @property boolean $flag_rejet
 * @property string $date_soumis
 * @property string $date_valide
 * @property string $date_rejet
 * @property boolean $statut_instruction
 * @property string $commentaires_instruction
 * @property string $titre_projet_instruction
 * @property string $contexte_probleme_instruction
 * @property string $objectif_general_instruction
 * @property string $objectif_specifique_instruction
 * @property string $resultat_attendus_instruction
 * @property string $champ_etude_instruction
 * @property string $cible_instruction
 * @property string $methodologie_instruction
 * @property string $piece_jointe_instruction
 * @property string $date_instruction
 * @property Entreprise $entreprise
 * @property PiecesProjetEtude[] $piecesProjetEtudes
 */
class ProjetEtude extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projet_etude';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_projet_etude';
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var array
     */
    protected $fillable = ['id_entreprises','flag_passer_comite_technique ','montant_projet','date_fiche_agrement', 'titre_projet_etude', 'contexte_probleme_projet_etude', 'objectif_general_projet_etude', 'objectif_specifique_projet_etud', 'resultat_attendu_projet_etude', 'champ_etude_projet_etude', 'cible_projet_etude', 'updated_at', 'created_at', 'id_user', 'id_user_affecte', 'flag_soumis', 'flag_valide', 'flag_rejet', 'date_soumis', 'date_valide', 'date_rejet', 'statut_instruction', 'commentaires_instruction', 'titre_projet_instruction', 'contexte_probleme_instruction', 'objectif_general_instruction', 'objectif_specifique_instruction', 'resultat_attendus_instruction', 'champ_etude_instruction', 'cible_instruction', 'methodologie_instruction', 'piece_jointe_instruction', 'date_instruction', 'id_chef_dep', 'commentaires_cd','date_trans_chef_s','flag_soumis_chef_service','id_chef_serv','flag_soumis_charge_etude','commentaires_cs','date_trans_charg_etude','id_charge_etude','commentaires_recevabilite','flag_attente_rec','date_mis_en_attente','motif_rec','id_processus','code_dossier', 'montant_projet_instruction','num_agce','code_projet_etude','flag_fiche_agrement'];
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
    public function piecesProjetEtudes()
    {
        return $this->hasMany('App\Models\PiecesProjetEtude', 'id_projet_etude', 'id_projet_etude');
    }

    public function motif()
    {
        return $this->belongsTo(Motif::class, 'id_motif_recevable', 'id_motif');
    }

    public function chargedetude()
    {
        return $this->belongsTo(User::class, 'id_charge_etude', 'id');
    }


      /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agence()
    {
        return $this->belongsTo('App\Models\Agence', 'num_agce', 'num_agce');
    }

    public function SecteurActivite()
    {
        return $this->belongsTo('App\Models\SecteurActivite', 'id_secteur_activite', 'id_secteur_activite');
    }

    public function operateur()
    {
        return $this->belongsTo(Entreprises::class, 'id_operateur_selection', 'id_entreprises');
    }

    public function operateurs():BelongsToMany{
        return $this->belongsToMany(Entreprises::class, 'projet_etude_has_entreprises','id_projet_etude','id_entreprises');
    }


}
