<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemandeAnnulationSauvegarderRequest;
use App\Http\Requests\DemandeSubstitutionSauvegarderRequest;
use App\Models\ActionFormationPlan;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\DemandeAnnulationPlan;
use App\Models\DemandeSubstitutionActionPlanFormation;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\PlanFormation;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use App\Models\User;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use Rap2hpoutre\FastExcel\FastExcel;

class AgreementProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Menu::get_code_menu_profil(Auth::user()->id);
        $agreements = DB::table('fiche_agrement')
            ->select(['projet_etude.*','entreprises.raison_social_entreprises','entreprises.ncc_entreprises','users.name','users.prenom_users','fiche_agrement.created_at as date_valide_agrreement'])
            ->leftjoin('comite_gestion','fiche_agrement.id_comite_gestion','comite_gestion.id_comite_gestion')
            ->leftjoin('comite_permanente','fiche_agrement.id_comite_permanente','comite_permanente.id_comite_permanente')
            ->join('projet_etude','fiche_agrement.id_demande','projet_etude.id_projet_etude')
            ->join('entreprises','projet_etude.id_entreprises','entreprises.id_entreprises')
            ->join('users','projet_etude.id_charge_etude','users.id')
            ->where('fiche_agrement.code_fiche_agrement','PE')
            ->where('projet_etude.flag_fiche_agrement',true)
            ->orderBy('created_at', 'desc');

        if ($role== 'ENTREPRISE'){
            $agreements = $agreements->where('projet_etude.id_entreprises',Auth::user()->id_partenaire);
        }
        $agreements = $agreements->get();
        return view('projetetudes.agreementprojetetude.index', compact('agreements'));
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
        $role = Menu::get_code_menu_profil(Auth::user()->id);
        $agreement = DB::table('fiche_agrement')
            ->select(['projet_etude.*','operateur.raison_social_entreprises as op_raison_social_entreprises','entreprises.raison_social_entreprises','users.name','users.prenom_users','fiche_agrement.created_at as date_valide_agrreement'])
            ->leftjoin('comite_gestion','fiche_agrement.id_comite_gestion','comite_gestion.id_comite_gestion')
            ->leftjoin('comite_permanente','fiche_agrement.id_comite_permanente','comite_permanente.id_comite_permanente')
            ->join('projet_etude','fiche_agrement.id_demande','projet_etude.id_projet_etude')
            ->join('entreprises','projet_etude.id_entreprises','entreprises.id_entreprises')
            ->leftjoin('entreprises as operateur','projet_etude.id_operateur_selection','operateur.id_entreprises')
            ->join('users','projet_etude.id_charge_etude','users.id')
            ->where('projet_etude.flag_fiche_agrement',true)
            ->where('fiche_agrement.code_fiche_agrement','PE')
            ->where('id_projet_etude', $id);
                if ($role== 'ENTREPRISE'){
                    $agreement = $agreement->where('projet_etude.id_entreprises',Auth::user()->id_partenaire);
                }
        $agreement = $agreement->first();
        return view('projetetudes.agreementprojetetude.show', compact('agreement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_plan_de_formation,$id_etape)
    {
        $pays = Pays::all();
        $motifs = Motif::where('code_motif','APF')->where('flag_actif_motif',true)->get();
        $type_entreprises = TypeEntreprise::all();

        $id_plan_de_formation = Crypt::UrldeCrypt($id_plan_de_formation);
        $id_etape = Crypt::UrldeCrypt($id_etape);


        $actionformations = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')
            ->Join('type_formation','fiche_a_demande_agrement.id_type_formation','type_formation.id_type_formation')
            ->Join('entreprises','action_formation_plan.id_entreprise_structure_formation_action','entreprises.id_entreprises')
            ->where([['action_formation_plan.id_plan_de_formation','=',$id_plan_de_formation]])
            ->get();

        $agreement = DB::table('fiche_agrement')
            ->select(['plan_formation.*', 'fiche_agrement.*', 'fiche_agrement.created_at as date_valide_agrreement'])
            ->leftjoin('comite_gestion', 'fiche_agrement.id_comite_gestion', 'comite_gestion.id_comite_gestion')
            ->leftjoin('comite_permanente', 'fiche_agrement.id_comite_permanente', 'comite_permanente.id_comite_permanente')
            ->join('plan_formation', 'fiche_agrement.id_demande', 'plan_formation.id_plan_de_formation')
            ->where('plan_formation.id_entreprises', Auth::user()->id_partenaire)
            ->where('plan_formation.id_plan_de_formation', $id_plan_de_formation)
            ->first();

        $plan_de_formation = PlanFormation::where('flag_fiche_agrement', true)
            ->where('id_plan_de_formation', $id_plan_de_formation)
            ->first();

        $demande_annulation_plan = DemandeAnnulationPlan::where('id_plan_formation', $id_plan_de_formation)->first();
        $infoentreprise = Entreprises::find($plan_de_formation->id_entreprises);
        $categorieplans = CategoriePlan::where('id_plan_de_formation', $id_plan_de_formation)->get();
        $actionplanformations = ActionFormationPlan::where('id_plan_de_formation', $id_plan_de_formation)->get();


        return view('projetetudes.agreement.edit', compact('agreement','id_etape','actionformations','plan_de_formation','pays','motifs','type_entreprises','demande_annulation_plan','infoentreprise','actionplanformations','categorieplans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    public function cancel(DemandeAnnulationSauvegarderRequest $request,string $id_plan_de_formation,string $id_etape)
    {
        $id_plan_de_formation =  \App\Helpers\Crypt::UrldeCrypt($id_plan_de_formation);
        $id_etape =  \App\Helpers\Crypt::UrldeCrypt($id_etape);
        $plan_formation = PlanFormation::where('id_plan_de_formation',$id_plan_de_formation)->first();
        $demande_annulation_plan = DemandeAnnulationPlan::where('id_plan_formation',$id_plan_de_formation)->first();
        if(isset($request->piece_demande_annulation_plan)){
            $piece_demande_annulation_plan = $request->piece_demande_annulation_plan;
            $extension_file = $piece_demande_annulation_plan->extension();
            $file_name = 'piece_justificatif_demande_annulation_'. '_' . rand(111,99999) . '_' . 'piece_justificatif_demande_annulation_' . '_' . time() . '.' . $extension_file;
            $piece_demande_annulation_plan->move(public_path('pieces/piece_justificatif_demande_annulation/'), $file_name);

        }else{
            $file_name =  $demande_annulation_plan->piece_demande_annulation_plan;
        }
        DemandeAnnulationPlan::updateOrCreate(
            ['id_plan_formation'=>$id_plan_de_formation],
            [
                'id_motif_demande_annulation_plan'=>$request->id_motif_demande_annulation_plan,
                'commentaire_demande_annulation_plan'=>$request->commentaire_demande_annulation_plan,
                'id_processus'=>4,
                'id_user'=>$plan_formation->user_conseiller,
                'piece_demande_annulation_plan'=>$file_name,
            ]
        );

        if($request->action=="Enregistrer_soumettre_demande_annulation"){
            $demande_annulation_plan->flag_soumis_demande_annulation_plan = true;
            $demande_annulation_plan->date_soumis_demande_annulation_plan = now();
            $demande_annulation_plan->update();
        }


        return redirect('agreement/'.Crypt::UrlCrypt($id_plan_de_formation).'/'.Crypt::UrlCrypt($id_etape).'/edit')->with('success', 'Succès : Demande d\'annulation de plan de formation effectuée');
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
                $demande_annulation_plan->id_processus = 5;
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


                return redirect('agreement/'.Crypt::UrlCrypt($id_plan).'/cancel')->with('success', 'Succès : Demande d\'annulation de plan de formation soumis');
            }

        }
//        substitution
    }
}
