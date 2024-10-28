<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $id_cahier_autre_demande_habilitations
 * @property float $id_users_cahier_autre_demande_habilitations
 * @property float $id_processus_autre_demande
 * @property string $date_creer_cahier_autre_demande_habilitations
 * @property string $date_soumis_cahier_autre_demande_habilitations
 * @property string $commentaire_cahier_autre_demande_habilitations
 * @property string $code_cahier_autre_demande_habilitations
 * @property string $code_pieces_cahier_autre_demande_habilitations
 * @property boolean $flag_cahier_autre_demande_habilitations
 * @property boolean $flag_statut_cahier_autre_demande_habilitations
 * @property string $created_at
 * @property string $updated_at
 * @property string $code_commission_permante_autre_demande_gestion
 * @property boolean $flag_traitement_cahier_autre_demande_habilitations
 * @property string $date_traitement_cahier_autre_demande_habilitations
 * @property boolean $flag_traitement_valide_flag_cahier_autre_demande_habilitations
 * @property string $date_traitement_valide_flag_cahier_autre_demande_habilitations
 * @property boolean $flag_traitement_effectuer_commission
 * @property string $date_traitement_effectuer_commission
 * @property ProcessusAutreDemande $processusAutreDemande
 * @property User $user
 */
class CahierAutreDemandeHabilitation extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_cahier_autre_demande_habilitations';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_users_cahier_autre_demande_habilitations','id_processus_cahier_autre_demande_habilitations', 'id_processus_autre_demande','type_entreprise', 'date_creer_cahier_autre_demande_habilitations', 'date_soumis_cahier_autre_demande_habilitations', 'commentaire_cahier_autre_demande_habilitations', 'code_cahier_autre_demande_habilitations', 'code_pieces_cahier_autre_demande_habilitations', 'flag_cahier_autre_demande_habilitations', 'flag_statut_cahier_autre_demande_habilitations', 'created_at', 'updated_at', 'code_commission_permante_autre_demande_gestion', 'flag_traitement_cahier_autre_demande_habilitations', 'date_traitement_cahier_autre_demande_habilitations', 'flag_traitement_valide_flag_cahier_autre_demande_habilitations', 'date_traitement_valide_flag_cahier_autre_demande_habilitations', 'flag_traitement_effectuer_commission', 'date_traitement_effectuer_commission'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function processusAutreDemande()
    {
        return $this->belongsTo('App\Models\ProcessusAutreDemande', 'id_processus_autre_demande', 'id_processus_autre_demande');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_users_cahier_autre_demande_habilitations');
    }
}
