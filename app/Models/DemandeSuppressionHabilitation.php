<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_demande_suppression_habilitation
 * @property float $id_user
 * @property float $id_chef_service
 * @property float $id_charge_habilitation
 * @property float $id_motif_demande_suppression_habilitation
 * @property string $commentaire_demande_suppression_habilitation
 * @property string $date_soumis_demande_suppression_habilitation
 * @property string $date_validation_demande_suppression_habilitation
 * @property boolean $flag_validation_demande_suppression_habilitation
 * @property string $piece_demande_suppression_habilitation
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $flag_rejeter_demande_suppression_habilitation
 * @property boolean $flag_demande_suppression_habilitation_valider_par_proce
 * @property boolean $flag_soumis_demande_suppression_habilitation
 * @property string $commentaire_final_demande_suppression_habilitation
 * @property string $commentaire_cs
 * @property string $date_soumis_cs_demande_suppression_habilitation
 * @property float $id_processus_demande_suppression_habilitation
 * @property string $date_valider_par_processus_demande_suppression_habilitation
 * @property boolean $flag_soumis_cs
 * @property boolean $flag_enregistrer_demande_suppression_habilitation
 * @property string $date_enregistrer_demande_suppression_habilitation
 * @property float $id_demande_habilitation
 * @property string $code_demande_suppression_habilitation
 * @property string $type_autre_demande
 * @property boolean $flag_recevabilite
 * @property string $commentaire_recevabilite
 * @property string $date_recevabilite
 * @property boolean $flag_instruction
 * @property string $date_instruction
 * @property string $observation_instruction
 * @property string $date_rejeter_demande_suppression_habilitation
 * @property boolean $flag_rejeter_recevabilit_suppression_habilitation
 * @property boolean $flag_passer_cahier
 * @property boolean $flag_valider_cahier
 * @property string $date_passer_cahier
 * @property User $user
 * @property User $user
 * @property User $user
 * @property DomaineDemandeSuppressionHabilitation[] $domaineDemandeSuppressionHabilitations
 */
class DemandeSuppressionHabilitation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'demande_suppression_habilitation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_demande_suppression_habilitation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'id_chef_service', 'id_charge_habilitation', 'id_motif_demande_suppression_habilitation', 'commentaire_demande_suppression_habilitation', 'date_soumis_demande_suppression_habilitation', 'date_validation_demande_suppression_habilitation', 'flag_validation_demande_suppression_habilitation', 'piece_demande_suppression_habilitation', 'created_at', 'updated_at', 'flag_rejeter_demande_suppression_habilitation', 'flag_demande_suppression_habilitation_valider_par_proce', 'flag_soumis_demande_suppression_habilitation', 'commentaire_final_demande_suppression_habilitation', 'commentaire_cs', 'date_soumis_cs_demande_suppression_habilitation', 'id_processus_demande_suppression_habilitation', 'date_valider_par_processus_demande_suppression_habilitation', 'flag_soumis_cs', 'flag_enregistrer_demande_suppression_habilitation', 'date_enregistrer_demande_suppression_habilitation', 'id_demande_habilitation', 'code_demande_suppression_habilitation', 'type_autre_demande', 'flag_recevabilite', 'commentaire_recevabilite', 'date_recevabilite', 'flag_instruction', 'date_instruction', 'observation_instruction', 'date_rejeter_demande_suppression_habilitation', 'flag_rejeter_recevabilit_suppression_habilitation', 'flag_passer_cahier', 'flag_valider_cahier', 'date_passer_cahier'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chefservice()
    {
        return $this->belongsTo('App\Models\User', 'id_chef_service');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chargehabilitation()
    {
        return $this->belongsTo('App\Models\User', 'id_charge_habilitation');
    }


    public function demandeHabilitation()
    {
        return $this->belongsTo('App\Models\DemandeHabilitation', 'id_demande_habilitation');
    }

    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif_demande_suppression_habilitation','id_motif');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domaineDemandeSuppressionHabilitations()
    {
        return $this->hasMany('App\Models\DomaineDemandeSuppressionHabilitation', 'id_demande_suppression_habilitation', 'id_demande_suppression_habilitation');
    }
}
