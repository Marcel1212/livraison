<?php

namespace App\Http\Controllers;

use App\Models\ActionFormationPlan;
use Illuminate\Http\Request;
use Image;
use File;
use Auth;
use Hash;
use DB;
use Carbon\Carbon;
use App\Helpers\Crypt;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agreements = DB::table('fiche_agrement')
                            ->select(['plan_formation.*','entreprises.raison_social_entreprises','users.name','users.prenom_users','fiche_agrement.created_at as date_valide_agrreement'])
                            ->leftjoin('comite_gestion','fiche_agrement.id_comite_gestion','comite_gestion.id_comite_gestion')
                            ->leftjoin('comite_permanente','fiche_agrement.id_comite_permanente','comite_permanente.id_comite_permanente')
                            ->join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
                            ->join('entreprises','plan_formation.id_entreprises','entreprises.id_entreprises')
                            ->join('users','plan_formation.user_conseiller','users.id')
                            ->get();


        return view('agreement.index', compact('agreements'));
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
    public function show($id)
    {
        $id = Crypt::UrldeCrypt($id);
        $actionformations = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')
        ->Join('type_formation','fiche_a_demande_agrement.id_type_formation','type_formation.id_type_formation')
        ->Join('entreprises','action_formation_plan.id_entreprise_structure_formation_action','entreprises.id_entreprises')
        ->where([['action_formation_plan.id_plan_de_formation','=',$id]])
        ->get();

        return view('agreement.show', compact('actionformations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::UrldeCrypt($id);
        $actionformations = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')
                                                ->Join('type_formation','fiche_a_demande_agrement.id_type_formation','type_formation.id_type_formation')
                                                ->Join('entreprises','action_formation_plan.id_entreprise_structure_formation_action','entreprises.id_entreprises')
                                                ->where([['action_formation_plan.id_plan_de_formation','=',$id]])
                                                ->get();
          //dd($id);

        return view('agreement.edit', compact('actionformations'));
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
