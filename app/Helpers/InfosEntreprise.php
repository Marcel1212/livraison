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

}
