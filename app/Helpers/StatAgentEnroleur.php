<?php


namespace App\Helpers;

use App\Models\DemandeEnrolement;
use Illuminate\Support\Facades\DB;

class StatAgentEnroleur
{
    public static function get_infos_enrolement_non_tratier()
    {
        $enroler = DemandeEnrolement::where([['flag_traitement_demande_enrolem','=',false],['flag_recevablilite_demande_enrolement','=',false]])->get();
        return (isset($enroler) ? $enroler : '');
    }    
    
    public static function get_infos_enrolement_valider()
    {
        $enroler = DemandeEnrolement::where([['flag_traitement_demande_enrolem','=',true],['flag_recevablilite_demande_enrolement','=',true],['flag_valider_demande_enrolement','=',true],['flag_rejeter_demande_enrolement','=',false]])->get();
        return (isset($enroler) ? $enroler : '');
    }   
    
    public static function get_infos_enrolement_rejeter()
    {
        $enroler = DemandeEnrolement::where([['flag_traitement_demande_enrolem','=',true],['flag_valider_demande_enrolement','=',false],['flag_rejeter_demande_enrolement','=',true]])->get();
        return (isset($enroler) ? $enroler : '');
    }


    

}
