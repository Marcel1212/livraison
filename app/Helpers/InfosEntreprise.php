<?php


namespace App\Helpers;

use App\Models\Entreprises;
use Illuminate\Support\Facades\DB;

class InfosEntreprise
{
    public static function get_infos_entreprise($ncc)
    {
        $infoentrprise = Entreprises::where([['ncc_entreprises','=',$ncc]])->first();
        return (isset($infoentrprise) ? $infoentrprise : '');
    }

    public static function get_nombre_demande_en_cours_traitement($id)
    {
        $nbrdmenc = DB::table('vue_nombre_demande_en_cours_traitement')->where([['id_entreprises','=',$id]])->get();
        return (isset($nbrdmenc) ? $nbrdmenc : '');
    }

    public static function get_nombre_demande_traiter($id)
    {
        $nbrdmenc = DB::table('vue_nombre_demande_traiter')->where([['id_entreprises','=',$id]])->get();
        return (isset($nbrdmenc) ? $nbrdmenc : '');
    }

}
