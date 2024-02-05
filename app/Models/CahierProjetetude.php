<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahierProjetetude extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cahier_projet_etude';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_cahier_projet_etude';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    /**
     * @var array
     */
    protected $fillable = ['id_users_cahier_projet_etude', 'date_creer_cahier_projet_etude', 'date_soumis_cahier_projet_etude', 'commentaire_cahier_projet_etude', 'code_cahier_projet_etude', 'code_pieces_cahier_projet_etude', 'flag_cahier_projet_etude', 'flag_statut_cahier_projet_etude', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_users_cahier_projet_etude');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ligneCahierProjetEtudes()
    {
        return $this->hasMany('App\Models\LigneCahierProjetEtude', 'id_cahier_projet_etude', 'id_cahier_projet_etude');
    }
}
