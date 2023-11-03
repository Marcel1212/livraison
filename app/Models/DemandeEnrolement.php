<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_demande_enrolement
 * @property float $id_localite
 * @property float $id_centre_impot
 * @property float $id_activites
 * @property float $id_statut_operation
 * @property float $id_motif
 * @property float $indicatif_demande_enrolement
 * @property float $id_motif_recevable
 * @property string $ncc_demande_enrolement
 * @property string $raison_sociale_demande_enroleme
 * @property float $tel_demande_enrolement
 * @property string $email_demande_enrolement
 * @property float $numero_cnps_demande_enrolement
 * @property string $rccm_demande_enrolement
 * @property string $piece_dfe_demande_enrolement
 * @property string $piece_rccm_demande_enrolement
 * @property string $piece_attestation_immatriculati
 * @property string $commentaire_demande_enrolement
 * @property float $id_user
 * @property string $date_depot_demande_enrolement
 * @property string $date_traitement_demande_enrolem
 * @property boolean $flag_traitement_demande_enrolem
 * @property string $updated_at
 * @property string $created_at
 * @property boolean $flag_recevablilite_demande_enrolement
 * @property string $date_recevabilite_demande_enrolement
 * @property string $commentaire_recevable_demande_enrolement
 * @property Entreprise[] $entreprises
 * @property Localite $localite
 * @property CentreImpot $centreImpot
 * @property Activite $activite
 * @property StatutOperation $statutOperation
 * @property Motif $motif
 * @property Pay $pay
 * @property Motif $motif1
 */
class DemandeEnrolement extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'demande_enrolement';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_demande_enrolement';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_localite', 'id_centre_impot', 'id_activites', 'id_statut_operation', 'id_motif', 'indicatif_demande_enrolement', 'id_motif_recevable', 'ncc_demande_enrolement', 'raison_sociale_demande_enroleme', 'tel_demande_enrolement', 'email_demande_enrolement', 'numero_cnps_demande_enrolement', 'rccm_demande_enrolement', 'piece_dfe_demande_enrolement', 'piece_rccm_demande_enrolement', 'piece_attestation_immatriculati', 'commentaire_demande_enrolement', 'id_user', 'date_depot_demande_enrolement', 'date_traitement_demande_enrolem', 'flag_traitement_demande_enrolem', 'updated_at', 'created_at', 'flag_recevablilite_demande_enrolement', 'date_recevabilite_demande_enrolement', 'commentaire_recevable_demande_enrolement'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entreprises()
    {
        return $this->hasMany('App\Models\Entreprise', 'id_demande_enrolement', 'id_demande_enrolement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localite()
    {
        return $this->belongsTo('App\Models\Localite', 'id_localite', 'id_localite');
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
    public function activite()
    {
        return $this->belongsTo('App\Models\Activites', 'id_activites', 'id_activites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statutOperation()
    {
        return $this->belongsTo('App\Models\StatutOperation', 'id_statut_operation', 'id_statut_operation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif', 'id_motif');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pay()
    {
        return $this->belongsTo('App\Models\Pays', 'indicatif_demande_enrolement', 'id_pays');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motif1()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif_recevable', 'id_motif');
    }
}
