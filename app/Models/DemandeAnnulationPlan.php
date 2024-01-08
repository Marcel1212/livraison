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

}


