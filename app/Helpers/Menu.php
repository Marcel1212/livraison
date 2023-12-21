<?php
namespace App\Helpers;

use App\Models\Logo;
use Illuminate\Support\Facades\DB;

class Menu
{
    public static function get_menu($idutil)
    {

        $roles = DB::table('users')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where([['users.id', '=', $idutil]])
            ->first();
        $idroles = $roles->role_id;

        $resulat = DB::table('role_has_sousmenus')
            ->join('sousmenu', 'role_has_sousmenus.sousmenus_id_sousmenu', 'sousmenu.id_sousmenu')
            ->join('roles', 'role_has_sousmenus.role_id', 'roles.id')
            ->join('menu', 'sousmenu.menu_id_menu', 'menu.id_menu')
            ->where([['roles.id', '=', $idroles], ['menu.is_valide', '=', true], ['sousmenu.is_valide', '=', true]])
            ->orderBy('menu.priorite_menu', 'ASC')
            ->orderBy('sousmenu.priorite_sousmenu', 'ASC')
            ->get();
        $tabl = [];
        foreach ($resulat as $ligne) {
            $tabl[$ligne->id_menu][] = $ligne;
        }
        return (isset($tabl) ? $tabl : '');
    }

    public static function get_id_profil($idutil)
    {
        $roles = DB::table('users')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where([['users.id', '=', $idutil]])
            ->first();
        $idroles = $roles->role_id;
        return (isset($idroles) ? $idroles : '');
    }


    public static function get_menu_profil($idutil)
    {
        $roles = DB::table('users')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where([['users.id', '=', $idutil]])
            ->first();
        $naroles = $roles->name;
        return (isset($naroles) ? $naroles : '');
    }

    public static function get_code_menu_profil($idutil)
    {

        $roles = DB::table('users')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where([['users.id', '=', $idutil]])
            ->first();
        $coderoles = $roles->code_roles;
        return (isset($coderoles) ? $coderoles : '');
    }

    public static function get_logo()
    {
        $logof = Logo::where([['flag_logo', '=', true], ['valeur', '=', 'LOGO']])->first();
        return (isset($logof) ? $logof : '');
    }


    public static function get_info_acceuil()
    {
        $logof = Logo::where([['flag_logo', '=', true], ['valeur', '=', 'IMAGE ACCEUIL']])->first();
        return (isset($logof) ? $logof : '');
    }

    public static function get_info_couleur()
    {
        $logof = Logo::where([['flag_logo', '=', true], ['valeur', '=', 'COULEUR MENU HAUT']])->first();
        return (isset($logof) ? $logof : '');
    }

    public static function get_info_image_dashboard()
    {
        $logof = Logo::where([['flag_logo', '=', true], ['valeur', '=', 'IMAGE DASHBORD']])->first();
        return (isset($logof) ? $logof : '');
    }

    public static function get_info_reseaux()
    {
        $logof = Logo::where([['flag_logo', '=', true], ['valeur', '=', 'RESEAUX SOCIAUX']])->get();
        return (isset($logof) ? $logof : '');
    }

}
