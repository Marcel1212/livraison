<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAnnulationPlan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'demande_annulation_plan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_demande_annulation_plan';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'float';

    protected $fillable = ['id_plan_formation', 'id_motif_demande_annulation_plan', 'commentaire_demande_annulation_plan','id_processus','id_user','piece_demande_annulation_plan', 'updated_at', 'created_at'];


}


