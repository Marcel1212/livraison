<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeSubstitutionActionPlanFormation extends Model
{
    use HasFactory;
    protected $table ="demande_substi_action_formation";
    protected $primaryKey = 'id_substi_action_formation_plan';

}
