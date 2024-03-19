<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DemandePlanProjets
{
    public static function plans_projets_formations_etudes($num_agce, $code)
    {
        /*$damandes = DB::table('vue_plans_projets_formation')
                            //foreach($code as $co){
                                ->Orwhere([['','','']])
                           // }
                            ->get();*/

        $query =   DB::table('vue_plans_projets_formation')->where('agence', $num_agce);
        foreach ($code as  $cd) {
            $query->orWhere('code_processus',$cd->code_pieces);
        }
        $damandes = $query->get();


        return (isset($damandes) ? $damandes : '');
    }

    public static function infos_plans_projets_formations_etudes($id_demande)
    {

        $damandes =   DB::table('vue_plans_projets_formation')->where('id_demande', $id_demande)->first();

        return (isset($damandes) ? $damandes : '');
    }


}
