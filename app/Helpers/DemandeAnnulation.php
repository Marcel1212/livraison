<?php


namespace App\Helpers;

use App\Models\DemandeAnnulationPlan;

class DemandeAnnulation
{
    public static function get_demande_annulation_en_traitement(){
        $demande_annulation = DemandeAnnulationPlan::where('flag_demande_annulation_plan_valider_par_processus','<>',true)->get();
        return (isset($demande_annulation) ? $demande_annulation : '');
    }

}
