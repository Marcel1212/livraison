<?php

namespace App\Http\Controllers;

use App\Models\Entreprises;
use Illuminate\Http\Request;
use App\Models\PageSelect;
use Auth;

class ListeLierController extends Controller
{
    public function getEntrepriseinterneplan()
    {

        $idpart = Auth::user()->id_partenaire;

         $entreprise = Entreprises::where([['id_entreprises','=',$idpart]])->get();
        //dd($departements);
         return $entreprise;

    }

    public function getEntreprisecabinetformation()
    {

         $entreprise = Entreprises::where([['flag_habilitation_entreprise','=',true]])->get();

         return $entreprise;

    }

    public function getEntreprisecabinetetrangerformation()
    {

         $entreprise = Entreprises::where([['flag_cabinet_etranger','=',true]])->get();

         return $entreprise;

    }

    public function getEntreprisecabinetetrangerformationmax()
    {

         $entreprise = Entreprises::where([['flag_cabinet_etranger','=',true]])->orderBy('id_entreprises','desc')->get();

         return $entreprise;

    }

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
