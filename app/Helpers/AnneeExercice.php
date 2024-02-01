<?php


namespace App\Helpers;

use App\Models\PeriodeExercice;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnneeExercice
{
    public static function get_annee_exercice()
    {
        $datesys = Carbon::now()->format("Y-m-d");
        //dd($datesys);
        $anneeexercice = PeriodeExercice::where([['flag_actif_periode_exercice','=',true],['date_fin_periode_exercice','>',$datesys]])->first();

        return (isset($anneeexercice) ? $anneeexercice : 'La période d\'exercice de l\'année en cours n\'a pas encore demarré');
    }



}
