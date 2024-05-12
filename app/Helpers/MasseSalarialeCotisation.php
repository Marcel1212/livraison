<?php


namespace App\Helpers;

use App\Models\Cotisation;
use App\Models\PartEntreprise;
use App\Models\VariationPourcentageCleRepartitionFin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MasseSalarialeCotisation
{
    public static function get_calcul_moyen_masse_salariale($entreprise)
    {
/*         $pourcentagenoncalcule = VariationPourcentageCleRepartitionFin::where([['flag_actif_part_entreprise','=',true]])->first();
        $pourcentage = $pourcentagenoncalcule->valeur_vpcrf/100; */
        $part = PartEntreprise::where([['flag_actif_part_entreprise','=',true]])->first();
        $cotisationtapefdfp = 0.004;
        $date = Carbon::now();
        $dateannee = $date->format('Y');
        $lignecotisations = Cotisation::where([['id_entreprise','=',$entreprise],['annee_cotisation','=',$dateannee]])->get();

        $nombredelignecotisation = count($lignecotisations);
        $montanttotallignecotisation=0;
        foreach($lignecotisations as $lignecotisation){
            $montanttotallignecotisation += $lignecotisation->montant;
        }
        $montanttotalcotisation = $montanttotallignecotisation;

        if($nombredelignecotisation>0){

            $moyencotisation = $montanttotalcotisation/$nombredelignecotisation;

            $montantcotisationprevisionnel = ($moyencotisation/$cotisationtapefdfp)*12;

        }else{
            $montantcotisationprevisionnel = 0;
        }



        return (isset($montantcotisationprevisionnel) ? $montantcotisationprevisionnel : '');
    }

}
