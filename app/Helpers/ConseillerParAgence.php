<?php


namespace App\Helpers;

use App\Models\PeriodeExercice;
use App\Models\TypeComite;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConseillerParAgence
{
    public static function get_conseiller_par_agence($num_agce,$departe)
    {
        $conseiller_agence = DB::table('users')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->select('users.*', 'model_has_roles.*', 'roles.*')
                            ->where([['roles.code_roles','=','CONSEILLER'],['users.num_agce','=',$num_agce],['users.id_departement','=',$departe]])
                            ->get();

        return (isset($conseiller_agence) ? $conseiller_agence : '');
    }

    public static function get_conseiller_par_departement($num_agce, $num_departement)
    {
        $conseiller_agence = DB::table('users')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->select('users.*', 'roles.name as roles')
                            ->where([['roles.id','=',20],['users.num_agce','=',$num_agce],['users.id_departement','=',$num_departement]])
                            ->get();

        return (isset($conseiller_agence) ? $conseiller_agence : '');
    }

    public static function get_comite_gestion_permanente()
    {
        $conseiller_agence = DB::table('users')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->select('users.*', 'roles.name as roles')
                            ->where([['roles.code_roles','=','DIRECTEUR']])
                            ->Orwhere([['roles.code_roles','=','SG']])
                            ->Orwhere([['roles.code_roles','=','COMTEGESTION']])
                            ->get();

        return (isset($conseiller_agence) ? $conseiller_agence : '');
    }

    public static function get_type_comite_plan_formation()
    {
        $typecomite = TypeComite::where([['libelle_type_comite','=','Comitedegestion'],['code_type_comite','=','PF']])
                            ->first();

        return (isset($typecomite) ? $typecomite : '');
    }

    // Projet d'etude
    public static function get_type_comite_projet_etude()
    {
        $typecomite = TypeComite::where([['libelle_type_comite','=','Comitedegestion'],['code_type_comite','=','PE']])
                            ->first();

        return (isset($typecomite) ? $typecomite : '');
    }

    public static function get_type_comite_per_plan_formation()
    {
        $typecomite = TypeComite::where([['libelle_type_comite','=','Comitepermant'],['code_type_comite','=','PF']])
                            ->first();

        return (isset($typecomite) ? $typecomite : '');
    }




}
