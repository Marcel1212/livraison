<?php


namespace App\Helpers;

use App\Models\Entreprises;
use App\Models\PartEntreprise;
use Illuminate\Support\Facades\DB;

class PartEntreprisesHelper
{
    public static function get_part_entreprise()
    {
        $partentreprise = PartEntreprise::where([['flag_actif_part_entreprise','=',true]])->first();
        return (isset($partentreprise) ? $partentreprise : '');

    }

}
