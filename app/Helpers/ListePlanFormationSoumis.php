<?php


namespace App\Helpers;

use App\Models\PlanFormation;
use App\Models\SecteurActiviteUserConseiller;
use Illuminate\Support\Facades\DB;

class ListePlanFormationSoumis
{
    public static function get_liste_plan_formation_soumis($idUser,$numAgce)
    {
        //$infossecteur = SecteurActiviteUserConseiller::where([['id_user_conseiller','=',$idUser],['id_secteur_activite','=',$idsecteuractivite]])->first();
        //$planformations = DB::table('vue_planfomation_soumis_conseiller')->where([['id_user_conseiller','=',$idUser]])->get();
        //$planformations = DB::table('vue_plan_formation_soumis_au_conseiller')->where([['id_user_conseiller','=',$idUser],['num_agce','=',$numAgce]])->get();
        $planformations = DB::table('vue_plan_formation_soumis_au_conseiller')->where([['id_user_conseiller','=',$idUser],['id_agence','=',$numAgce]])->get();
        //dd($planformations);
        return (isset($planformations) ? $planformations : '');
    }

    public static function get_plan_en_traitement($idUser){
        $planformations = PlanFormation::where([['user_conseiller','=',$idUser],['flag_soumis_plan_formation','=',true],['flag_recevablite_plan_formation','=',true],['flag_soumis_ct_plan_formation','=',false]])->get();
        return (isset($planformations) ? $planformations : '');
    }

    public static function get_plan_en_soumis_ct($idUser){
        $planformations = PlanFormation::where([['user_conseiller','=',$idUser],['flag_soumis_plan_formation','=',true],['flag_recevablite_plan_formation','=',true],['flag_soumis_ct_plan_formation','=',true]])->get();
        return (isset($planformations) ? $planformations : '');
    }



}
