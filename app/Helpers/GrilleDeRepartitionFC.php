<?php


namespace App\Helpers;

use App\Models\CleDeRepartitionFinancement;
use App\Models\Entreprises;
use App\Models\VariationPourcentageCleRepartitionFin;
use Illuminate\Support\Facades\DB;

class GrilleDeRepartitionFC
{
    public static function get_calcul_financement($montantcotisation)
    {
        $pourcentagenoncalcule = VariationPourcentageCleRepartitionFin::where([['flag_actif_vpcrf','=',true]])->first();
        $pourcentage = $pourcentagenoncalcule->valeur_vpcrf/100;

        $clerepartitions = CleDeRepartitionFinancement::get();
        $resultat=null;
        foreach($clerepartitions as $clerepartition){
            while ($clerepartition->marge_inferieur <= $montantcotisation && $clerepartition->marge_superieur >= $montantcotisation) {
                //echo $clerepartition;
                $resultat = $clerepartition;
                break;
            }
        }

        if($resultat->marge_superieur<=500000){
            if($resultat->signe_montant_fc == "+"){
                $signe = 1;
            }else{
                $signe = -1;
            }

            $montantbudget = ($resultat->coefficient * $montantcotisation) + ($signe * $resultat->montant_fc);

            $montantbudgetfinal1 = $montantbudget + $montantcotisation;

/*             if ($pourcentagenoncalcule->flag_signe_variation == true) {
                $montantbudgetfinalapresapplicationpourcentage = $montantbudgetfinal1 + $montantbudgetfinal1*$pourcentage;
            }else{
                $montantbudgetfinalapresapplicationpourcentage = $montantbudgetfinal1 - $montantbudgetfinal1*$pourcentage;
            } */

            $montantbudgetfinal = $montantbudgetfinal1.'/'.$resultat->id_cle_de_repartition_financement;


        }else{

            $montantbudget = $resultat->montant_fc + ($montantcotisation - $resultat->marge_inferieur)*$resultat->coefficient;

            $montantbudgetfinal1 = $montantbudget + $montantcotisation;


            /* if ($pourcentagenoncalcule->flag_signe_variation == true) {
                $montantbudgetfinalapresapplicationpourcentage = $montantbudgetfinal1 + $montantbudgetfinal1*$pourcentage;
            }else{
                $montantbudgetfinalapresapplicationpourcentage = $montantbudgetfinal1 - $montantbudgetfinal1*$pourcentage;
            } */

            $montantbudgetfinal = $montantbudgetfinal1.'/'.$resultat->id_cle_de_repartition_financement;
        }


        return (isset($montantbudgetfinal) ? $montantbudgetfinal : '');
    }

}
