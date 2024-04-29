<?php


namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class EtatCahierPlanDeFormation
{
    public static function get_liste_etat_secteur_activite_cahier_plan_f($numAgce)
    {
         $planformations = DB::table("ligne_cahier_plans_projets as lcpf")
                            ->join("plan_formation as pf","lcpf.id_demande","=","pf.id_plan_de_formation")
                            ->join("action_formation_plan as afp","pf.id_plan_de_formation","=","afp.id_plan_de_formation")
                            ->join("domaine_formation as sa","afp.id_domaine_formation","=","sa.id_domaine_formation")
                            ->selectRaw("count(sa.id_domaine_formation) as nombre,  sa.libelle_domaine_formation as secteur_activite")
                            ->where("lcpf.id_cahier_plans_projets", $numAgce)
                            ->groupBy("sa.id_domaine_formation","sa.libelle_domaine_formation")
                            ->get();

        return (isset($planformations) ? $planformations : '');
    }

    public static function get_liste_etat_action_cahier_plan_f($numAgce)
    {
         $planformations = DB::table("ligne_cahier_plans_projets as lcpf")
                            ->join("plan_formation as pf","lcpf.id_demande","=","pf.id_plan_de_formation")
                            ->join("action_formation_plan as afp","pf.id_plan_de_formation","=","afp.id_plan_de_formation")
                            //->selectRaw("count(afp.id_action_formation_plan) as nombre_action_formation")
                            ->where("lcpf.id_cahier_plans_projets", $numAgce)
                            ->get();

        return (isset($planformations) ? $planformations : '');
    }

    public static function get_liste_etat_plan_cahier_plan_f($numAgce)
    {
         $planformations = DB::table("ligne_cahier_plans_projets as lcpf")
                            ->join("plan_formation as pf","lcpf.id_demande","=","pf.id_plan_de_formation")
                            //->selectRaw("count(pf.id_plan_de_formation) as nombre_plan_formation")
                            ->where("lcpf.id_cahier_plans_projets", $numAgce)
                            ->get();

        return (isset($planformations) ? $planformations : '');
    }

    public static function get_liste_etat_but_formation_cahier_plan_f($numAgce)
    {
         $planformations = DB::table("ligne_cahier_plans_projets as lcpf")
                            ->join("plan_formation as pf","lcpf.id_demande","=","pf.id_plan_de_formation")
                            ->join("action_formation_plan as afp","pf.id_plan_de_formation","=","afp.id_plan_de_formation")
                            ->join("fiche_a_demande_agrement as fada","afp.id_action_formation_plan","=","fada.id_action_formation_plan")
                            ->join("fiche_a_agrement_but_formation as fagbf","fada.id_fiche_agrement","=","fagbf.id_fiche_agrement")
                            ->join("but_formation as bf","fagbf.id_but_formation","=","bf.id_but_formation")
                            ->selectRaw("count(bf.id_but_formation) as nombre , bf.but_formation")
                            ->where("lcpf.id_cahier_plans_projets", $numAgce)
                            ->groupBy("bf.id_but_formation","bf.but_formation")
                            ->get();

        return (isset($planformations) ? $planformations : '');
    }

    public static function get_liste_etat_type_formation_cahier_plan_f($numAgce)
    {
         $planformations = DB::table("ligne_cahier_plans_projets as lcpf")
                            ->join("plan_formation as pf","lcpf.id_demande","=","pf.id_plan_de_formation")
                            ->join("action_formation_plan as afp","pf.id_plan_de_formation","=","afp.id_plan_de_formation")
                            ->join("fiche_a_demande_agrement as fada","afp.id_action_formation_plan","=","fada.id_action_formation_plan")
                            ->join("type_formation as tf","fada.id_type_formation","=","tf.id_type_formation")
                            ->selectRaw("count(tf.id_type_formation) as nombre , tf.type_formation")
                            ->where("lcpf.id_cahier_plans_projets", $numAgce)
                            ->groupBy("tf.id_type_formation","tf.type_formation")
                            ->get();

        return (isset($planformations) ? $planformations : '');
    }

}
