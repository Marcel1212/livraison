<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Direction;
use App\Models\Departement;
use App\Models\Service;

class PageSelect extends Model
{
    use HasFactory;


    public static function getDirection(){

        $directions = Direction::orderBy('id_direction','asc')->get();

        return $direction;

    }

    public static function getDepartement($direction=0){
        //dd($direction);
        $departement = Departement::where([['id_direction','=',$direction]])->get();

        return (isset($departement) ? $departement : '');

    }    
    
    public static function getService($departement=0){

        $service = Service::where([['id_departement','=',$departement]])->get();

        return $service;

    }

}
