<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_autre_demande_habilitation_formation
 * @property float $id_user
 * @property float $id_chef_service
 * @property float $id_charge_habilitation
 * @property float $id_motif_autre_demande_habilitation_formation
 * @property string $commentaire_autre_demande_habilitation_formation
 * @property string $date_soumis_autre_demande_habilitation_formation
 * @property string $date_validation_autre_demande_habilitation_formation
 * @property boolean $flag_validation_autre_demande_habilitation_formation
 * @property string $piece_autre_demande_habilitation_formation
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $flag_rejeter_autre_demande_habilitation_formation
 * @property boolean $flag_autre_demande_habilitation_formation_valider_par_proce
 * @property boolean $flag_soumis_autre_demande_habilitation_formation
 * @property string $commentaire_final_autre_demande_habilitation_formation
 * @property string $commentaire_cs
 * @property string $date_soumis_cs_autre_demande_habilitation_formation
 * @property float $id_processus_autre_demande_habilitation_formation
 * @property string $date_valider_par_processus_autre_demande_habilitation_formation
 * @property boolean $flag_soumis_cs
 * @property boolean $flag_enregistrer_autre_demande_habilitation_formation
 * @property string $date_enregistrer_autre_demande_habilitation_formation
 * @property float $id_demande_habilitation
 * @property string $code_autre_demande_habilitation_formation
 * @property string $type_autre_demande
 * @property boolean $flag_recevabilite
 * @property string $commentaire_recevabilite
 * @property string $date_recevabilite
 * @property boolean $flag_instruction
 * @property string $date_instruction
 * @property string $observation_instruction
 * @property string $date_rejeter_autre_demande_habilitation_formation
 * @property boolean $flag_rejeter_recevabilit_suppression_habilitation
 * @property boolean $flag_passer_cahier
 * @property boolean $flag_valider_cahier
 * @property string $date_passer_cahier
 * @property DomaineAutreDemandeHabilitationFormation[] $domaineAutreDemandeHabilitationFormations
 * @property User $user
 * @property User $chefservicehabilitation
 * @property User $chefdepartementhabilitation
 */
class AutreDemandeHabilitationFormation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'autre_demande_habilitation_formation';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_autre_demande_habilitation_formation';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'id_chef_service', 'id_charge_habilitation', 'id_motif_autre_demande_habilitation_formation', 'commentaire_autre_demande_habilitation_formation', 'date_soumis_autre_demande_habilitation_formation', 'date_validation_autre_demande_habilitation_formation', 'flag_validation_autre_demande_habilitation_formation', 'piece_autre_demande_habilitation_formation', 'created_at', 'updated_at', 'flag_rejeter_autre_demande_habilitation_formation', 'flag_autre_demande_habilitation_formation_valider_par_proce', 'flag_soumis_autre_demande_habilitation_formation', 'commentaire_final_autre_demande_habilitation_formation', 'commentaire_cs', 'date_soumis_cs_autre_demande_habilitation_formation', 'id_processus_autre_demande_habilitation_formation', 'date_valider_par_processus_autre_demande_habilitation_formation', 'flag_soumis_cs', 'flag_enregistrer_autre_demande_habilitation_formation', 'date_enregistrer_autre_demande_habilitation_formation', 'id_demande_habilitation', 'code_autre_demande_habilitation_formation', 'type_autre_demande', 'flag_recevabilite', 'commentaire_recevabilite', 'date_recevabilite', 'flag_instruction', 'date_instruction', 'observation_instruction', 'date_rejeter_autre_demande_habilitation_formation', 'flag_rejeter_recevabilit_suppression_habilitation', 'flag_passer_cahier', 'flag_valider_cahier', 'date_passer_cahier'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domaineAutreDemandeHabilitationFormations()
    {
        return $this->hasMany('App\Models\DomaineAutreDemandeHabilitationFormation', 'id_autre_demande_habilitation_formation', 'id_autre_demande_habilitation_formation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function motif()
    {
        return $this->belongsTo('App\Models\Motif', 'id_motif_autre_demande_habilitation_formation','id_motif');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chefservicehabilition()
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
}
