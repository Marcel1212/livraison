<?php

namespace App\Http\Controllers;

use App\Models\CaracteristiqueTypeFormation;
use App\Models\Direction;
use App\Models\Entreprises;
use Illuminate\Http\Request;
use App\Models\PageSelect;
use App\Models\PlanFormation;
use Auth;
use Illuminate\Support\Facades\DB;

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

    public function getCaracteristiqueTypeFormation($typeformation=0)
    {

         $caracteristiques = CaracteristiqueTypeFormation::where([['id_type_formation','=',$typeformation],['flag_ctf','=','true']])->get();

         return $caracteristiques;
    }

    public function getDepartement()
    {

         $departements = Direction::join('departement','direction.id_direction','departement.id_direction')->where([
            ['direction.id_direction','=','4'],['departement.flag_departement','=',true]
            ])->get();

         return $departements;
    }

    public function getAgenceDepartement($iddepartement=0)
    {

         $AgenceDepartements =   PlanFormation::join('users','plan_formation.user_conseiller','users.id')
                                            ->join('agence','users.num_agce','agence.num_agce')
                                            ->select('agence.num_agce','agence.lib_agce','users.id_departement')
                                            ->where([
                                            ['plan_formation.flag_plan_formation_valider_par_processus','=',true],
                                            ['plan_formation.flag_plan_formation_valider_cahier','=',true],
                                            ['users.id_departement','=',$iddepartement]
                                            ])->groupBy('agence.num_agce','users.id_departement')->get()
                                            ;

         return $AgenceDepartements;
    }
}
