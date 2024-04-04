<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
use App\Models\Comite;
use App\Helpers\Audit;
use App\Models\ProcessusComite;
use App\Models\TypeComite;
use App\Helpers\Menu;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\ConseillerParAgence;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Helpers\Crypt;
use App\Helpers\DemandePlanProjets;
use App\Models\CahierComite;
use App\Models\CahierPlansProjets;
use App\Models\CategorieComite;
use App\Models\ComiteParticipant;
use App\Models\FicheAgrement;
use App\Models\PlanFormation;
use App\Models\ProcessusComiteLieComite;
use App\Models\ProjetEtude;
use App\Models\ProjetFormation;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class TraitementComitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comites = Comite::Join('categorie_comite','comite.id_categorie_comite','categorie_comite.id_categorie_comite')
                        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                        ->where('categorie_comite.code_categorie_comite','CP')
                        ->where('id_user_comite_participant',Auth::user()->id)
                        ->where('flag_statut_comite',false)
                        ->get();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TRAITEMENT DES COMITES '

        ]);

        return view('comites.traitementcomite.index', compact('comites'));
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
        // dd($id);
         $idetape =  Crypt::UrldeCrypt($id1);

         $comite = Comite::find($id);

         $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

         $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->get();

         $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
                ->join('users','comite_participant.id_user_comite_participant','users.id')
                ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', 'roles.id')
                ->where([['id_comite','=',$id]])
                ->get();


        $listedemandesss = DB::table('cahier_plans_projets')
                ->join('cahier_comite','cahier_plans_projets.id_cahier_plans_projets','cahier_comite.id_demande')
                ->join('comite','cahier_comite.id_comite','comite.id_comite')
                ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                ->where([['cahier_comite.id_comite','=',$id],
                ['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',true],
                ['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
                ->get();

                Audit::logSave([

                    'action'=>'MODIFIER',

                    'code_piece'=>$id,

                    'menu'=>'COMITES',

                    'etat'=>'Succès',

                    'objet'=>'COMITES TECHNIQUES'

                ]);

                return view('comites.traitementcomite.edit', compact('comite','idetape','id','processuscomite','cahiers','comiteparticipants','listedemandesss'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
