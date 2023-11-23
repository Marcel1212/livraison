<?php


namespace App\Helpers;

use App\Models\PeriodeExercice;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConseillerParAgence
{
    public static function get_conseiller_par_agence($num_agce)
    {
        $conseiller_agence = DB::table('users')
                            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->select('users.*', 'model_has_roles.*', 'roles.*')
                            ->where([['roles.id','=',20],['users.num_agce','=',$num_agce]])
                            ->get();

        return (isset($conseiller_agence) ? $conseiller_agence : '');
    }    
    
  

}
