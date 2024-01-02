<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandeAnnulationSauvegarderRequest;
use App\Models\ActionFormationPlan;
use App\Models\CategoriePlan;
use App\Models\DemandeAnnulationPlan;
use App\Models\Entreprises;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PlanFormation;
use App\Models\TypeEntreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use File;
use Hash;
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
                            ->select(['plan_formation.*','fiche_agrement.*','demande_annulation_plan.*','fiche_agrement.created_at as date_valide_agrreement'])
                            ->leftjoin('comite_gestion','fiche_agrement.id_comite_gestion','comite_gestion.id_comite_gestion')
                            ->leftjoin('comite_permanente','fiche_agrement.id_comite_permanente','comite_permanente.id_comite_permanente')
                            ->leftjoin('demande_annulation_plan','demande_annulation_plan.id_plan_formation','fiche_agrement.id_demande')
                            ->join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
                            ->where('plan_formation.id_entreprises',Auth::user()->id_partenaire)
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
    public function show(string $id)
    {
        //
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

    public function cancel(string $id){
        $pays = Pays::all();
        $motifs = Motif::where('code_motif','APF')->where('flag_actif_motif',true)->get();
        $type_entreprises = TypeEntreprise::all();
        if(isset($id)){
            $id =  \App\Helpers\Crypt::UrldeCrypt($id);
            $agreement = DB::table('fiche_agrement')
                ->select(['plan_formation.*','fiche_agrement.*','fiche_agrement.created_at as date_valide_agrreement'])
                ->leftjoin('comite_gestion','fiche_agrement.id_comite_gestion','comite_gestion.id_comite_gestion')
                ->leftjoin('comite_permanente','fiche_agrement.id_comite_permanente','comite_permanente.id_comite_permanente')
                ->join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
                ->where('plan_formation.id_entreprises',Auth::user()->id_partenaire)
                ->where('plan_formation.id_plan_de_formation',$id)
                ->first();

            if(isset($agreement)){
                $plan_de_formation = DB::table('plan_formation')->where('flag_fiche_agrement',true)
                    ->where('plan_formation.id_entreprises',Auth::user()->id_partenaire)
                    ->where('id_plan_de_formation',$agreement->id_plan_de_formation)
                    ->first();

                $demande_annulation_plan = DemandeAnnulationPlan::where('id_plan_formation',$agreement->id_plan_de_formation)->first();
                $infoentreprise = Entreprises::find($plan_de_formation->id_entreprises);
                $categorieplans = CategoriePlan::where('id_plan_de_formation',$plan_de_formation->id_plan_de_formation)->get();
                $actionplanformations = ActionFormationPlan::where('id_plan_de_formation',$plan_de_formation->id_plan_de_formation)->get();
                return view('agreement.cancel',compact('motifs','actionplanformations','demande_annulation_plan','plan_de_formation','infoentreprise','type_entreprises','pays','categorieplans'));
            }
        }
    }

    public function cancelStore(DemandeAnnulationSauvegarderRequest $request,string $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $demande_annulation_plan = DemandeAnnulationPlan::where('id_plan_formation',$id)->get();

        if($demande_annulation_plan->count()>0){
            return redirect('agreement/'.Crypt::UrlCrypt($id).'/cancel')->with('Error', 'Erreur : Vous ne pouvez effectuer plus de deux demande d\'annulation pour ce plan de formation');
        }

        $plan_formation = PlanFormation::where('id_plan_de_formation',$id)->first();


        $demande_annulation_plan = new DemandeAnnulationPlan();
        $demande_annulation_plan->id_motif_demande_annulation_plan = $request->id_motif_demande_annulation_plan;
        $demande_annulation_plan->commentaire_demande_annulation_plan = $request->commentaire_demande_annulation_plan;
        $demande_annulation_plan->id_processus = 4;
        $demande_annulation_plan->id_plan_formation = $id;

        if(isset($plan_formation)){
            $demande_annulation_plan->id_user = $plan_formation->user_conseiller;
        }

        if(isset($request->piece_demande_annulation_plan)){
            $piece_demande_annulation_plan = $request->piece_demande_annulation_plan;
            $extension_file = $piece_demande_annulation_plan->extension();
            $file_name = 'piece_justificatif_demande_annulation_'. '_' . rand(111,99999) . '_' . 'piece_justificatif_demande_annulation_' . '_' . time() . '.' . $extension_file;
            $piece_demande_annulation_plan->move(public_path('pieces/piece_justificatif_demande_annulation/'), $file_name);
            $demande_annulation_plan->piece_demande_annulation_plan = $file_name;
        }
        $demande_annulation_plan->save();
        return redirect('agreement/'.Crypt::UrlCrypt($id).'/cancel')->with('success', 'Succès : Demande d\'annulation de plan de formation effectuée');
    }

    public function cancelUpdate(DemandeAnnulationSauvegarderRequest $request,string $id_demande,$id_plan)
    {
        if(isset($id_demande)){
            $id_demande =  \App\Helpers\Crypt::UrldeCrypt($id_demande);
            $id_plan =  \App\Helpers\Crypt::UrldeCrypt($id_plan);
            $demande_annulation_plan = DemandeAnnulationPlan::where('id_demande_annulation_plan',$id_demande)->first();
            if(isset($demande_annulation_plan)){
                $plan_formation = PlanFormation::where('id_plan_de_formation',$id_plan)->first();
                $demande_annulation_plan->id_motif_demande_annulation_plan = $request->id_motif_demande_annulation_plan;
                $demande_annulation_plan->commentaire_demande_annulation_plan = $request->commentaire_demande_annulation_plan;
                $demande_annulation_plan->id_processus = 4;
                $demande_annulation_plan->id_plan_formation = $id_plan;
                if(isset($plan_formation)){
                    $demande_annulation_plan->id_user = $plan_formation->user_conseiller;
                }

                if(isset($request->piece_demande_annulation_plan)){
                    $piece_demande_annulation_plan = $request->piece_demande_annulation_plan;
                    $extension_file = $piece_demande_annulation_plan->extension();
                    $file_name = 'piece_justificatif_demande_annulation_'. '_' . rand(111,99999) . '_' . 'piece_justificatif_demande_annulation_' . '_' . time() . '.' . $extension_file;
                    $piece_demande_annulation_plan->move(public_path('pieces/piece_justificatif_demande_annulation/'), $file_name);
                    $demande_annulation_plan->piece_demande_annulation_plan = $file_name;
                }

                if($request->action=="Enregistrer_soumettre_plan_formation"){
                    $demande_annulation_plan->flag_soumis_demande_annulation_plan = true;
                    $demande_annulation_plan->date_soumis_demande_annulation_plan = now();
                }
                $demande_annulation_plan->update();
                return redirect('agreement/'.Crypt::UrlCrypt($id_plan).'/cancel')->with('success', 'Succès : Demande d\'annulation de plan de formation soumis');
            }

        }
    }
}
