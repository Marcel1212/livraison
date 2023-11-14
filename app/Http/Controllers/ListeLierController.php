<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSelect;

class ListeLierController extends Controller
{
    public function getDepartements($direction=0)
    {

         $departements = PageSelect::getDepartement($direction);
        //dd($departements);
         return $departements;

    }   
    
    public function getServices($departement=0)
    {

        return $services = PageSelect::getService($departement);

    }
}
