<?php


namespace App\Helpers;

use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\PlanFormationAValiderParUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NombreActionValiderParLeConseiller
{
    public static function get_conseiller_valide_action_plan($id_action, $id_user)
    {
        $conseiller_action = ActionPlanFormationAValiderParUser::where([['id_action_plan_formation','=',$id_action],['id_user_conseil','=',$id_user]])->get();

        return (isset($conseiller_action) ? $conseiller_action : '');
    }     
    
    public static function get_conseiller_valider_plan($id_plan, $id_user)
    {
        $conseiller_plan = PlanFormationAValiderParUser::where([['id_plan_formation','=',$id_plan],['id_user_conseil','=',$id_user]])->get();

        return (isset($conseiller_plan) ? $conseiller_plan : '');
    }    
    
  

}
