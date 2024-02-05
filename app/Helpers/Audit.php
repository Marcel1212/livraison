<?php


namespace App\Helpers;

use App\Models\PeriodeExercice;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Audit
{
   public static function logSave(array $data)
   {
       $val="";
       $array = [];
       if(isset($data['action'])){
           $val = $data["action"];
       }
       if(isset($data['code_piece'])){
           $array = ["code_piece"=>$data['code_piece']];
       }

       if(isset($data['menu'])){
           $array["menu"] = $data['menu'];
       }

       if(isset($data['etat'])){
           $array["etat"] = $data['etat'];
       }

       if(isset($data['objet'])){
           $array["objet"] = $data['objet'];
       }

       Log::channel('audit')->info($val, $array);
   }
}
