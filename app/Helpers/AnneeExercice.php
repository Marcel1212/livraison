<?php


namespace App\Helpers;

use App\Models\PeriodeExercice;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnneeExercice
{
    public static function get_annee_exercice()
    {
        $anneeexercice = PeriodeExercice::where([['flag_actif_periode_exercice','=',true]])->first();

        return (isset($anneeexercice) ? $anneeexercice : 'La période d\'exercice n\'a pas encore demarré');
    }    
    
  

}
