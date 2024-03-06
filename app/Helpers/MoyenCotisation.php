<?php


namespace App\Helpers;

use App\Models\Cotisation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MoyenCotisation
{
    public static function get_calcul_moyen_cotisation($entreprise)
    {
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

            $montantcotisationprevisionnel = $moyencotisation*12;

        }else{
            $montantcotisationprevisionnel = 0;
        }



        return (isset($montantcotisationprevisionnel) ? $montantcotisationprevisionnel : '');
    }

    public static function get_verif_cotisation($entreprise)
    {
        $date = Carbon::now();
        $dateannee = $date->format('Y');
        $lignecotisations = Cotisation::where([['id_entreprise','=',$entreprise],['annee_cotisation','=',$dateannee]])->get();

        $nombredelignecotisation = count($lignecotisations);
        /*$montanttotallignecotisation=0;
        foreach($lignecotisations as $lignecotisation){
            $montanttotallignecotisation += $lignecotisation->montant;
        }
        $montanttotalcotisation = $montanttotallignecotisation;

        if($nombredelignecotisation>0){

            $moyencotisation = $montanttotalcotisation/$nombredelignecotisation;

            $montantcotisationprevisionnel = $moyencotisation*12;

        }else{
            $montantcotisationprevisionnel = 0;
        }*/



        return (isset($nombredelignecotisation) ? $nombredelignecotisation : '');
    }
}
