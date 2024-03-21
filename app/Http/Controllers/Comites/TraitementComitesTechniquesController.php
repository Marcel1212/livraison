<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
use App\Models\Comite;
use Illuminate\Http\Request;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Helpers\Crypt;
use App\Helpers\GenerateCode as Gencode;
use Carbon\Carbon;
use App\Helpers\Email;
use App\Helpers\Audit;
use App\Helpers\Menu;
use App\Models\CahierComite;
use App\Models\ComiteParticipant;
use App\Models\ProcessusComiteLieComite;

class TraitementComitesTechniquesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comites = Comite::Join('categorie_comite','comite.id_categorie_comite','categorie_comite.id_categorie_comite')
                        ->join('processus_comite_lie_comite','comite.id_comite','processus_comite_lie_comite.id_comite')
                        ->join('processus_comite','processus_comite_lie_comite.id_processus_comite','processus_comite.id_processus_comite')
                        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                        ->where('categorie_comite.code_categorie_comite','CT')
                        ->where('id_user_comite_participant',Auth::user()->id)
                        ->where('flag_statut_comite',false)
                        ->get();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TRAITEMENT DES COMITES TECHNIQUES'

        ]);

        return view('comites.traitementcomitetechniques.index', compact('comites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comite = Comite::find($id);

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $listedemandesss = DB::table('vue_plans_projets_formation')
        ->join('cahier_comite','vue_plans_projets_formation.id_demande','cahier_comite.id_demande')
        ->join('comite','cahier_comite.id_comite','comite.id_comite')
        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
        ->where([['cahier_comite.id_comite','=',$id],['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
        ->get();

        $comiteparticipants = ComiteParticipant::where([['id_comite','=',$id]])->get();


        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES TECHNIQUES'

        ]);

        return view('comites.traitementcomitetechniques.edit', compact('comite','idetape','id','processuscomite','cahiers','comiteparticipants','listedemandesss'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
