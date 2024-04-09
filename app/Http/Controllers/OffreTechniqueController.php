<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;

class OffreTechniqueController extends Controller
{
    //
    public function index()
    {
//        $offretechniques = Comite::Join('categorie_comite','comite.id_categorie_comite','categorie_comite.id_categorie_comite')
//            ->join('processus_comite_lie_comite','comite.id_comite','processus_comite_lie_comite.id_comite')
//            ->join('processus_comite','processus_comite_lie_comite.id_processus_comite','processus_comite.id_processus_comite')
//            ->where('categorie_comite.code_categorie_comite','CT')
//            ->get();
        $offretechniques = "";

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES TECHNIQUES'

        ]);
        return view('offre.offretechniques.index', compact('offretechniques'));
    }

    public function create()
    {

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES TECHNIQUES'

        ]);
        return view('offre.offretechniques.create');
    }
}
