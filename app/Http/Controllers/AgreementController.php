<?php

namespace App\Http\Controllers;

use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Http\Requests\DemandeAnnulationSauvegarderRequest;
use App\Http\Requests\DemandeSubstitutionSauvegarderRequest;
use App\Models\ActionFormationPlan;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CaracteristiqueTypeFormation;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use File;
use Hash;
use Carbon\Carbon;
use App\Helpers\Crypt;
use Rap2hpoutre\FastExcel\FastExcel;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Menu::get_code_menu_profil(Auth::user()->id);
        $agreements = DB::table('fiche_agrement')
            ->select(['plan_formation.*','demande_annulation_plan.*','entreprises.raison_social_entreprises','users.name','users.prenom_users','fiche_agrement.created_at as date_valide_agrreement'])
            ->leftjoin('comite_gestion','fiche_agrement.id_comite_gestion','comite_gestion.id_comite_gestion')
            ->leftjoin('comite_permanente','fiche_agrement.id_comite_permanente','comite_permanente.id_comite_permanente')
            ->leftjoin('demande_annulation_plan','demande_annulation_plan.id_plan_formation','fiche_agrement.id_demande')
            ->join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
            ->join('entreprises','plan_formation.id_entreprises','entreprises.id_entreprises')
            ->join('users','plan_formation.user_conseiller','users.id')
            ->where('plan_formation.flag_plan_sup',false);


//            ->where(function ($query) use ($id_plan_de_formation,$plan_de_formation) {
//                $query->where('id_plan_de_formation', $id_plan_de_formation)
//                    ->orWhere('id_plan_de_formation', $plan_de_formation->id_plan_formation_supplementaire);
//            })->get();
//            ->whereNotNull('plan_formation.id_plan_formation_supplementaire');
        if ($role== 'ENTREPRISE'){
            $agreements = $agreements->where('plan_formation.id_entreprises',Auth::user()->id_partenaire);
        }
        $agreements = $agreements->get();

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
    public function show($id_plan_de_formation)
    {
        $id_plan_de_formation = Crypt::UrldeCrypt($id_plan_de_formation);
        $plan_de_formation = PlanFormation::where('flag_fiche_agrement', true)
            ->where('id_plan_de_formation', $id_plan_de_formation)
            ->first();

        $actionformations = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')
            ->Join('type_formation','fiche_a_demande_agrement.id_type_formation','type_formation.id_type_formation')
//            ->Join('entreprises','action_formation_plan.id_entreprise_structure_formation_action','entreprises.id_entreprises')
            ->where(function ($query) use ($id_plan_de_formation,$plan_de_formation) {
                $query->where('id_plan_de_formation', $id_plan_de_formation)
                      ->orWhere('id_plan_de_formation', $plan_de_formation->id_plan_formation_supplementaire);
            })->get();

        return view('agreement.show', compact('actionformations','plan_de_formation'));
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


        $actionplanformations = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')
            ->Join('type_formation','fiche_a_demande_agrement.id_type_formation','type_formation.id_type_formation')
            ->Join('entreprises','action_formation_plan.id_entreprise_structure_formation_action','entreprises.id_entreprises')
            ->where(function ($query) use ($id_plan_de_formation,$plan_de_formation) {
                $query->where('id_plan_de_formation', $id_plan_de_formation)
                    ->orWhere('id_plan_de_formation', $plan_de_formation->id_plan_formation_supplementaire);
            })->get();

        $demande_annulation_plan = DemandeAnnulationPlan::where('id_plan_formation', $id_plan_de_formation)->first();
        $infoentreprise = Entreprises::find($plan_de_formation->id_entreprises);
        $categorieplans = CategoriePlan::where('id_plan_de_formation', $id_plan_de_formation)->get();

        $demande_annulation_exist =false;

        foreach ($actionplanformations as $actionplanformation) {
            $demande_annulation_action = DemandeAnnulationPlan::where('id_action_plan', $actionplanformation->id_action_formation_plan)
                ->whereNull('flag_demande_annulation_plan_valider_par_processus')->first();
            if(isset($demande_annulation_action)){
                $demande_annulation_exist = true;
            }
        }
        return view('agreement.edit', compact('agreement','demande_annulation_exist','id_etape','plan_de_formation','pays','motifs','type_entreprises','demande_annulation_plan','infoentreprise','actionplanformations','categorieplans'));

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
                'flag_soumis_demande_annulation_plan'=>false,
                'flag_validation_demande_annulation_plan'=>false,
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

    public function editaction(string $id_plan_de_formation, string $id_action,string $id_etape)
    {
        $caracteristiques = CaracteristiqueTypeFormation::All();

        $motif_annulations = Motif::where('code_motif','AAF')->where('flag_actif_motif',true)->get();
        $butformations = ButFormation::all();
        $fiche_a_demande_agrement = new FicheADemandeAgrement();
        $beneficiaire_formation = new BeneficiairesFormation();
        $motif_substitutions = Motif::where('code_motif','SAF')->get();
        $typeformations = TypeFormation::all();
        $categorieprofessionelles = CategorieProfessionelle::all();
        $structureformations = Entreprises::where('flag_habilitation_entreprise',true)->get();
        $secteuractivites = SecteurActivite::all();
        $pays = Pays::all();
        $id_plan_de_formation = Crypt::UrldeCrypt($id_plan_de_formation);
        $id_etape = Crypt::UrldeCrypt($id_etape);
        $id_action = Crypt::UrldeCrypt($id_action);

        $demande_annulation_plan = DemandeAnnulationPlan::where('id_plan_formation', $id_plan_de_formation)->first();

        $demande_substitution = DemandeSubstitutionActionPlanFormation::
        where('id_action_formation_plan_a_substi',$id_action)
            ->first();
        if(isset($demande_substitution)){
            $fiche_a_demande_agrement = FicheADemandeAgrement::where('id_action_formation_plan_substi',$demande_substitution->id_action_formation_plan_substi)->first();
            $beneficiaire_formation = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->first();
        }
        $infosactionplanformation = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*')
            ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
            ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
            ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
            ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
            ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
            ->where([['action_formation_plan.id_action_formation_plan','=',$id_action]])->first();
        $demande_annulation_action = DemandeAnnulationPlan::where('id_action_plan', $id_action)->first();
        return view('agreement.editaction', compact('fiche_a_demande_agrement',
            'demande_annulation_plan','beneficiaire_formation','caracteristiques','demande_substitution','motif_substitutions','pays','secteuractivites','fiche_a_demande_agrement','typeformations','beneficiaire_formation','categorieprofessionelles','structureformations','butformations','id_etape','infosactionplanformation','motif_annulations','demande_annulation_action'));
    }

    public function editactionCancel(DemandeAnnulationSauvegarderRequest $request, string $id_plan_de_formation, string $id_action,string $id_etape)
    {
            $id_plan_de_formation =  \App\Helpers\Crypt::UrldeCrypt($id_plan_de_formation);
            $id_action =  \App\Helpers\Crypt::UrldeCrypt($id_action);
            $id_etape =  \App\Helpers\Crypt::UrldeCrypt($id_etape);
            $plan_formation = PlanFormation::where('id_plan_de_formation',$id_plan_de_formation)->first();
            $demande_annulation_action = DemandeAnnulationPlan::where('id_action_plan',$id_action)->first();

        if(isset($request->piece_demande_annulation_plan)){
                $piece_demande_annulation_plan = $request->piece_demande_annulation_plan;
                $extension_file = $piece_demande_annulation_plan->extension();
                $file_name = 'piece_justificatif_demande_annulation_'. '_' . rand(111,99999) . '_' . 'piece_justificatif_demande_annulation_' . '_' . time() . '.' . $extension_file;
                $piece_demande_annulation_plan->move(public_path('pieces/piece_justificatif_demande_annulation/'), $file_name);

            }else{
                $file_name =  $demande_annulation_action->piece_demande_annulation_plan;
            }
            DemandeAnnulationPlan::updateOrCreate(
                ['id_action_plan'=>$id_action],
                [
                    'id_motif_demande_annulation_plan'=>$request->id_motif_demande_annulation_plan,
                    'commentaire_demande_annulation_plan'=>$request->commentaire_demande_annulation_plan,
                    'id_processus'=>4,
                    'id_user'=>$plan_formation->user_conseiller,
                    'piece_demande_annulation_plan'=>$file_name,
                ]
            );

            if($request->action=="Enregistrer_soumettre_demande_annulation"){
                $demande_annulation_action->flag_soumis_demande_annulation_plan = true;
                $demande_annulation_action->date_soumis_demande_annulation_plan = now();
                $demande_annulation_action->update();
            }
            return redirect('agreement/'.Crypt::UrlCrypt($id_plan_de_formation).'/'.Crypt::UrlCrypt($id_action).'/'.Crypt::UrlCrypt($id_etape).'/editaction')->with('success', 'Succès : Demande d\'annulation effectuée');
    }

    public function substitution(string $id_plan, string $id_action)
    {
        $id_plan =  \App\Helpers\Crypt::UrldeCrypt($id_plan);
        $id_action =  \App\Helpers\Crypt::UrldeCrypt($id_action);
        $planformation = PlanFormation::find($id_plan);
        $butformations = ButFormation::all();
        $fiche_a_demande_agrement = new FicheADemandeAgrement();
        $beneficiaire_formation = new BeneficiairesFormation();
        $motifs = Motif::where('code_motif','SAF')->get();
        $typeformations = TypeFormation::all();
        $categorieprofessionelles = CategorieProfessionelle::all();
        $structureformations = Entreprises::where('flag_habilitation_entreprise',true)->get();
        $actionplanformations = ActionFormationPlan::where('id_plan_de_formation',$id_plan)->get();
        if(isset($id_action)){
            $actionplanformation = ActionFormationPlan::where('id_action_formation_plan',$id_action)->first();
            $demande_substitution = DemandeSubstitutionActionPlanFormation::
            where('id_action_formation_plan_a_substi',$id_action)
//                ->where('id_plan_de_formation',$id_plan)
                ->first();

            if(isset($demande_substitution)){
                $fiche_a_demande_agrement = FicheADemandeAgrement::where('id_action_formation_plan_substi',$demande_substitution->id_action_formation_plan_substi)->first();
                $beneficiaire_formation = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->first();
            }



            if(isset($actionplanformation)){
                return view('agreement.substitution',compact('beneficiaire_formation','demande_substitution','fiche_a_demande_agrement','motifs','actionplanformation','actionplanformations','structureformations','categorieprofessionelles','typeformations','butformations'));
            }
        }
    }

    public function substitutionsStore(Request $request,string $id_plan, string $id_action)
    {
        $id_action =  \App\Helpers\Crypt::UrldeCrypt($id_action);
        $id_plan =  \App\Helpers\Crypt::UrldeCrypt($id_plan);
        $actionplanformation = ActionFormationPlan::where('id_action_formation_plan',$id_action)->first();
//            $demande_substitution_one = DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_a_substi',$id_action)
//                ->where('id_plan_de_formation',$id_plan)
//                ->first();
//
//            if(isset($actionplanformation)){
//                $rccentreprisehabilitation = Entreprises::where('id_entreprises',$request->structure_etablissement_plan_substi)->first();
//                $demande_substitution = new DemandeSubstitutionActionPlanFormation();
//                $demande_substitution->id_plan_de_formation = $id_plan;
//                $demande_substitution->intitule_action_formation_plan_substi = $request->intitule_action_formation_plan_substi;
//                $demande_substitution->nombre_stagiaire_action_formati_plan_substi = $request->nombre_stagiaire_action_formati_plan_substi;
//                $demande_substitution->nombre_heure_action_formation_plan_substi = $request->nombre_heure_action_formation_plan_substi;
//                $demande_substitution->structure_etablissement_plan_substi = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);
//
//                $demande_substitution->id_entreprise_structure_formation_plan_substi = $request->structure_etablissement_plan_substi;
//
//                $demande_substitution->id_secteur_activite = $request->id_secteur_activite;
//                $demande_substitution->nombre_groupe_action_formation_plan_substi = $request->nombre_groupe_action_formation_plan_substi;
//                $demande_substitution->cout_action_formation_plan_substi = $actionplanformation->cout_action_formation_plan;
//                $demande_substitution->id_action_formation_plan_a_substi = $actionplanformation->id_action_formation_plan;
//                $nombre_stagiaire_action_formati_substitu = $request->agent_maitrise_fiche_demande_ag + $request->employe_fiche_demande_agrement + $request->cadre_fiche_demande_agrement;
//                $demande_substitution->id_motif_demande_plan_substi = $request->id_motif_demande_plan_substi;
//                $demande_substitution->commentaire_demande_plan_substi = $request->commentaire_demande_plan_substi;
//                $demande_substitution->id_processus = 5;
//
//                if (isset($request->file_beneficiare)){
//                    $file = $request->file_beneficiare;
//                    $collections = (new FastExcel)->import($file);
//                    if (count($collections)>$nombre_stagiaire_action_formati_substitu){
//                        return redirect()->back()->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est supérieur au nombre saisi ']);
//                    }
//                    if (count($collections)<$nombre_stagiaire_action_formati_substitu){
//                        return redirect()->back()->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est inférieur au nombre saisi ']);
//                    }
//                }
//
//                if(isset($request->piece_demande_plan_substi)){
//                    $filefront = $request->piece_demande_plan_substi;
//                    $filename_one = 'piece_demande_plan_substi'. '_' . rand(111,99999) . '_' . 'piece_demande_plan_substi' . '_' . time() . '.' . $filefront->extension();
//                    $filefront->move(public_path('pieces/piece_demande_substi/'), $filename_one);
//                    $demande_substitution->piece_demande_plan_substi = $filename_one;
//                }
//
//                if(isset($request->facture_proforma_action_plan_substi)){
//                    $filefront = $request->facture_proforma_action_plan_substi;
//                    $filename = 'facture_proforma_action_formati'. '_' . rand(111,99999) . '_' . 'facture_proforma_action_formati' . '_' . time() . '.' . $filefront->extension();
//                    $filefront->move(public_path('pieces/facture_proforma_action_formation/'), $filename);
//                    $demande_substitution->facture_proforma_action_plan_substi = $filename;
//                }
//
//                $plan_formation = PlanFormation::where('id_plan_de_formation',$id_plan)->first();
//
//                if(isset($plan_formation)){
//                    $demande_substitution->id_user = $plan_formation->user_conseiller;
//                }
//
//                $demande_substitution->save();
//
//                $demande_substitution = DemandeSubstitutionActionPlanFormation::latest()->first();
//
//                $fiche_a_demande_agrement = new FicheADemandeAgrement();
//                $fiche_a_demande_agrement->lieu_formation_fiche_agrement = mb_strtoupper($request->lieu_formation_fiche_agrement);
//                $fiche_a_demande_agrement->objectif_pedagogique_fiche_agre = mb_strtoupper($request->objectif_pedagogique_fiche_agre);
//                $fiche_a_demande_agrement->id_action_formation_plan_substi = $demande_substitution->id_action_formation_plan_substi;
//                $fiche_a_demande_agrement->date_debut_fiche_agrement =$request->date_debut_fiche_agrement;
//                $fiche_a_demande_agrement->date_fin_fiche_agrement = $request->date_fin_fiche_agrement;
//                $fiche_a_demande_agrement->id_type_formation = $request->id_type_formation;
//                $fiche_a_demande_agrement->id_but_formation = $request->id_but_formation;
//                $fiche_a_demande_agrement->cadre_fiche_demande_agrement = $request->cadre_fiche_demande_agrement;
//                $fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag = $request->agent_maitrise_fiche_demande_ag;
//                $fiche_a_demande_agrement->employe_fiche_demande_agrement = $request->employe_fiche_demande_agrement;
//
//                $fiche_a_demande_agrement->save();
//                $insertedIdFicheAgrement = FicheADemandeAgrement::latest()->first()->id_fiche_agrement;
//
//                if (isset($request->file_beneficiare)){
//                    $file = $request->file_beneficiare;
//                    $collections = (new FastExcel)->import($file);
//                    foreach($collections as $collection){
//
//                        if(isset($collection['NOM ET PRENON'])){
//                            $nom_prenom = $collection['NOM ET PRENON'];
//                        }else{
//                            $nom_prenom = null;
//                        }
//                        if(isset($collection['GENRE'])){
//                            $genre = $collection['GENRE'];
//                        }else{
//                            $genre = null;
//                        }
//                        if(isset($collection['DATE'])){
//                            $date = $collection['DATE'];
//                        }else{
//                            $date = null;
//                        }
//                        if(isset($collection['NATIONALITE'])){
//                            $nationalite = $collection['NATIONALITE'];
//                        }else{
//                            $nationalite = null;
//                        }
//                        if(isset($collection['FONCTION'])){
//                            $fonction = $collection['FONCTION'];
//                        }else{
//                            $fonction = null;
//                        }
//                        if(isset($collection['CATEGORIE'])){
//                            $categorie = $collection['CATEGORIE'];
//                        }else{
//                            $categorie = null;
//                        }
//                        if(isset($collection['ANNEE EMBAUCHE'])){
//                            $anneeembauche = $collection['ANNEE EMBAUCHE'];
//                        }else{
//                            $anneeembauche = null;
//                        }
//                        if(isset($collection['MATRICULE CNPS'])){
//                            $matricule_cnps = $collection['MATRICULE CNPS'];
//                        }else{
//                            $matricule_cnps = null;
//                        }
//
//                        $beneficiaire_formation = new BeneficiairesFormation();
//                        $beneficiaire_formation->id_fiche_agrement = $insertedIdFicheAgrement;
//                        $beneficiaire_formation->nom_prenoms = $nom_prenom;
//                        $beneficiaire_formation->genre = $genre;
//                        $beneficiaire_formation->annee_naissance = $date;
//                        $beneficiaire_formation->nationalite = $nationalite;
//                        $beneficiaire_formation->fonction = $fonction;
//                        $beneficiaire_formation->categorie = $categorie;
//                        $beneficiaire_formation->annee_embauche = $anneeembauche;
//                        $beneficiaire_formation->matricule_cnps = $matricule_cnps;
//                        $beneficiaire_formation->save();
//                    }
//
//                    $nbrebeneficiaires = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->get();
//                    $nbrebene = count($nbrebeneficiaires);
//
//                    $fiche = FicheADemandeAgrement::find($fiche_a_demande_agrement->id_fiche_agrement);
//                    $fiche->total_beneficiaire_fiche_demand = $nbrebene;
//                    $fiche->update();
//                }
//
//                if (isset($request->file_beneficiare)){
//
//                    $filefront = $request->file_beneficiare;
//                    $filename_other = 'file_beneficiare'. '_' . rand(111,99999) . '_' . 'file_beneficiare' . '_' . time() . '.' . $filefront->extension();
//                    $filefront->move(public_path('pieces/fichier_beneficiaire_lie_aux_action_plan_formation/'), $filename_other);
//
//                    $fiche = FicheADemandeAgrement::find($fiche_a_demande_agrement->id_fiche_agrement);
//                    $fiche->file_beneficiare_fiche_agrement = $filename_other;
//                    $fiche->update();
//                }
//                return redirect('agreement/'.Crypt::UrlCrypt($id_plan).'/'.Crypt::UrlCrypt($id_action).'/'.Crypt::UrlCrypt(2).'/editaction')->with('success', 'Succes : Demande de substitution d\'action de plan de formation effectué ');
//            }
//        }

        $this->validate($request, [
            'intitule_action_formation_plan_substi' => 'required',
            'id_entreprise_structure_formation_plan_formation_substi' => 'required',
            'id_caracteristique_type_formation_substi' => 'required',
            'nombre_groupe_action_formation_substi' => 'required',
            'nombre_heure_action_formation_p_substi' => 'required',
            'cout_action_formation_plan_substi' => 'required',
            'id_type_formation' => 'required',
            'id_but_formation' => 'required',
            'date_debut_fiche_agrement' => 'required',
            'date_fin_fiche_agrement' => 'required',
            'lieu_formation_fiche_agrement' => 'required',
            'objectif_pedagogique_fiche_agre' => 'required',
            'cadre_fiche_demande_agrement' => 'required',
            'agent_maitrise_fiche_demande_ag' => 'required',
            'employe_fiche_demande_agrement' => 'required',
            'id_secteur_activite_substi' => 'required',
            'file_beneficiare_substi' => 'required|mimes:xlsx,XLSX|max:5120',
            'facture_proforma_action_formati_substi' => 'required|mimes:pdf,PDF,png,jpg,jpeg,PNG,JPG,JPEG|max:5120',

            'id_motif_demande_plan_substi' => 'required',
            'piece_demande_plan_substi' => 'required|mimes:pdf,PDF,png,jpg,jpeg,PNG,JPG,JPEG|max:5120',
            'commentaire_demande_plan_substi' => 'required',
        ],[
            'intitule_action_formation_plan_substi.required' => 'Veuillez ajoutez l\'intitule de l\'action.',
            'id_caracteristique_type_formation_substi.required' => 'Veuillez sélectionner une caractéristique.',
            'id_entreprise_structure_formation_plan_formation_substi.required' => 'Veuillez ajoutez une structure ou etablissement.',
            'nombre_groupe_action_formation_substi.required' => 'Veuillez ajoutez le nombre de groupe.',
            'nombre_heure_action_formation_p_substi.required' => 'Veuillez ajoutez le nombre d\'heure.',
            'cout_action_formation_plan_substi.required' => 'Veuillez ajoutez le cout de la formation.',
            'id_type_formation.required' => 'Veuillez selectionnez un type de formation.',
            'id_but_formation.required' => 'Veuillez selectionnez le but de la formation.',
            'date_debut_fiche_agrement.required' => 'Veuillez ajoutez la date de debut',
            'date_fin_fiche_agrement.required' => 'Veuillez ajoutez la date de fin .',
            'lieu_formation_fiche_agrement.required' => 'Veuillez ajoutez le lieu de formation.',
            'objectif_pedagogique_fiche_agre.required' => 'Veuillez ajoutez l\'objectif pedagogique.',
            'cadre_fiche_demande_agrement.required' => 'Veuillez ajoutez le nombre de cadre.',
            'agent_maitrise_fiche_demande_ag.required' => 'Veuillez ajoutez le nombre d\'agent de maitrise.',
            'employe_fiche_demande_agrement.required' => 'Veuillez ajoutez le nombre d\employe .',
            'id_secteur_activite_substi.required' => 'Veuillez selectionner un secteur activité.',
            'file_beneficiare_substi.required' => 'Veuillez ajouter le fichier excel contenant la liste des beneficiaires.',
            'facture_proforma_action_formati_substi.required' => 'Veuillez ajouter la massse salariale.',
            'file_beneficiare_substi.mimes' => 'Les formats requises pour le fichier excel contenant la liste des beneficiaires est: xlsx,XLSX.',
            'file_beneficiare_substi.max'=> 'la taille maximale doit etre 5 MegaOctets.',
            'facture_proforma_action_formati_substi.mimes' => 'Les formats requises pour la proformat est: PDF,PNG,JPG,JPEG.',
            'facture_proforma_action_formati_substi.max'=> 'la taille maximale doit etre 5 MegaOctets.',

            'piece_demande_plan_substi.mimes' => 'Les formats requises pour la proformat est: PDF,PNG,JPG,JPEG.',
            'piece_demande_plan_substi.max'=> 'la taille maximale doit etre 5 MegaOctets.',
            'id_motif_demande_plan_substi.unique' => 'Veuillez ajoutez le motif de la demande',
            'commentaire_demande_plan_substi.unique' => 'Veuillez ajoutez le commentaire de la demande',
        ]);

        $data = $request->all();

        $input = $request->all();
        $rccentreprisehabilitation = Entreprises::where([['id_entreprises','=',$input['id_entreprise_structure_formation_plan_formation_substi']]])->first();
        $input['id_entreprise_structure_formation_action_substi'] = $input['id_entreprise_structure_formation_plan_formation_substi'];
        $input['nombre_stagiaire_action_formati_substi'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];
        $input['intitule_action_formation_plan_substi'] = mb_strtoupper($input['intitule_action_formation_plan_substi']);
        $input['structure_etablissement_action_substi'] = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);
        $input['lieu_formation_fiche_agrement'] = mb_strtoupper($input['lieu_formation_fiche_agrement']);
        $input['objectif_pedagogique_fiche_agre'] = mb_strtoupper($input['objectif_pedagogique_fiche_agre']);
        $input['id_plan_de_formation'] = $id_plan;
        $input['id_action_formation_plan_a_substi'] = $actionplanformation->id_action_formation_plan;

        if (isset($data['file_beneficiare_substi'])){
            $file = $data['file_beneficiare_substi'];
            $collections = (new FastExcel)->import($file);
            if (count($collections)>$input['nombre_stagiaire_action_formati_substi']){
                return redirect()->back()->withErrors(['error' => 'Erreur :Le nombre de bénéficiaires de l\'action de formation est supérieur au nombre saisi ']);
            }

            if(isset($actionplanformation)){
                $rccentreprisehabilitation = Entreprises::where('id_entreprises',$request->structure_etablissement_plan_substi)->first();
                $demande_substitution = new DemandeSubstitutionActionPlanFormation();
                $demande_substitution->id_plan_de_formation = $id_plan;
                $demande_substitution->intitule_action_formation_plan_substi = $request->intitule_action_formation_plan_substi;
                $demande_substitution->nombre_stagiaire_action_formati_plan_substi = $request->nombre_stagiaire_action_formati_plan_substi;
                $demande_substitution->nombre_heure_action_formation_plan_substi = $request->nombre_heure_action_formation_plan_substi;
                $demande_substitution->structure_etablissement_plan_substi = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);

                $demande_substitution->id_entreprise_structure_formation_plan_substi = $request->structure_etablissement_plan_substi;

                $demande_substitution->id_secteur_activite = $request->id_secteur_activite;
                $demande_substitution->nombre_groupe_action_formation_plan_substi = $request->nombre_groupe_action_formation_plan_substi;
                $demande_substitution->cout_action_formation_plan_substi = $actionplanformation->cout_action_formation_plan;
                $demande_substitution->id_action_formation_plan_a_substi = $actionplanformation->id_action_formation_plan;
                $nombre_stagiaire_action_formati_substitu = $request->agent_maitrise_fiche_demande_ag + $request->employe_fiche_demande_agrement + $request->cadre_fiche_demande_agrement;
                $demande_substitution->id_motif_demande_plan_substi = $request->id_motif_demande_plan_substi;
                $demande_substitution->commentaire_demande_plan_substi = $request->commentaire_demande_plan_substi;
                $demande_substitution->id_processus = 5;

                if (isset($request->file_beneficiare)){
                    $file = $request->file_beneficiare;
                    $collections = (new FastExcel)->import($file);
                    if (count($collections)>$nombre_stagiaire_action_formati_substitu){
                        return redirect()->back()->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est supérieur au nombre saisi ']);
                    }
                    if (count($collections)<$nombre_stagiaire_action_formati_substitu){
                        return redirect()->back()->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est inférieur au nombre saisi ']);
                    }
                }

        if($input['cout_action_formation_plan_substi']>$actionplanformation->cout_action_formation_plan){
            return redirect()->back()->withErrors(['error' => 'Erreur :  Le coût de cette formation est plus élevé que le coût de la formation que vous souhaitez substituer ']);
        }

        $nombredejour = $input['nombre_heure_action_formation_p_substi']/8;

        $input['nombre_jour_action_formation_substi'] = $nombredejour;

        $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation_substi']);

        if($infoscaracteristique->code_ctf == "CGF"){
            $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_substi'];
        }
        if($infoscaracteristique->code_ctf == "CSF"){
            $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati_substi'];
        }
        if($infoscaracteristique->code_ctf == "CFD"){
            $montantcoutactionattribuable = $input['cout_action_formation_plan_substi'];
        }
        if($infoscaracteristique->code_ctf == "CCEF"){
            $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_substi'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;
        }
        if($infoscaracteristique->code_ctf == "CSEF"){
            $montantcoutactionattribuable = $input['cout_action_formation_plan_substi'];
        }

        $input['montant_attribuable_fdfp_substi'] = $montantcoutactionattribuable;

        if (isset($data['facture_proforma_action_formati_substi'])){
            $filefront = $data['facture_proforma_action_formati_substi'];
            if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){
                $fileName1 = 'facture_proforma_action_formati'. '_' . rand(111,99999) . '_' . 'facture_proforma_action_formati' . '_' . time() . '.' . $filefront->extension();
                $filefront->move(public_path('pieces/facture_proforma_action_formation/'), $fileName1);
                $input['facture_proforma_action_formati_substi'] = $fileName1;
            }
        }

        if (isset($data['piece_demande_plan_substi'])){
            $filefront = $data['piece_demande_plan_substi'];
            if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){
                $fileName1 = 'piece_demande_substi'. '_' . rand(111,99999) . '_' . 'piece_demande_substi' . '_' . time() . '.' . $filefront->extension();
                $filefront->move(public_path('pieces/piece_demande_substi/'), $fileName1);
                $input['piece_demande_plan_substi'] = $fileName1;
            }
        }

        $input['id_action_formation_plan_a_substi'] = $id_action;
        $input['id_processus'] = 5;

        $plan_formation = PlanFormation::where('id_plan_de_formation',$id_plan)->first();
        if(isset($plan_formation)){
            $input['id_user'] = $plan_formation->user_conseiller;
        }

        DemandeSubstitutionActionPlanFormation::create($input);

        $demande_substitution = DemandeSubstitutionActionPlanFormation::latest()->first();
        $input['id_action_formation_plan_substi'] = $demande_substitution->id_action_formation_plan_substi;
        $input['cout_total_fiche_agrement'] = $input['cout_action_formation_plan_substi'];

        FicheADemandeAgrement::create($input);

        $insertedIdFicheAgrement = FicheADemandeAgrement::latest()->first()->id_fiche_agrement;

        if (isset($data['file_beneficiare_substi'])){

            $file = $data['file_beneficiare_substi'];

            $collections = (new FastExcel)->import($file);

            foreach($collections as $collection){

                if(isset($collection['NOM ET PRENON'])){
                    $nom_prenom = $collection['NOM ET PRENON'];
                }else{
                    $nom_prenom = null;
                }
                if(isset($collection['GENRE'])){
                    $genre = $collection['GENRE'];
                }else{
                    $genre = null;
                }
                if(isset($collection['DATE'])){
                    $date = $collection['DATE'];
                }else{
                    $date = null;
                }
                if(isset($collection['NATIONALITE'])){
                    $nationalite = $collection['NATIONALITE'];
                }else{
                    $nationalite = null;
                }
                if(isset($collection['FONCTION'])){
                    $fonction = $collection['FONCTION'];
                }else{
                    $fonction = null;
                }
                if(isset($collection['CATEGORIE'])){
                    $categorie = $collection['CATEGORIE'];
                }else{
                    $categorie = null;
                }
                if(isset($collection['ANNEE EMBAUCHE'])){
                    $anneeembauche = $collection['ANNEE EMBAUCHE'];
                }else{
                    $anneeembauche = null;
                }
                if(isset($collection['MATRICULE CNPS'])){
                    $matricule_cnps = $collection['MATRICULE CNPS'];
                }else{
                    $matricule_cnps = null;
                }
                BeneficiairesFormation::create([
                    'id_fiche_agrement' => $insertedIdFicheAgrement,
                    'nom_prenoms' => $nom_prenom,
                    'genre' =>$genre,
                    'annee_naissance' => $date,
                    'nationalite' => $nationalite,
                    'fonction' => $fonction,
                    'categorie' => $categorie,
                    'annee_embauche' => $anneeembauche,
                    'matricule_cnps' => $matricule_cnps
                ]);
            }
            $nbrebeneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$insertedIdFicheAgrement]])->get();
            $nbrebene = count($nbrebeneficiaires);
            $fiche = FicheADemandeAgrement::find($insertedIdFicheAgrement);
            $fiche->update([
                'total_beneficiaire_fiche_demand' =>$nbrebene
            ]);
        }

        if (isset($data['file_beneficiare_substi'])){
            $filefront = $data['file_beneficiare_substi'];
            if($filefront->extension() == "xlsx"  || $filefront->extension() == "XLSX"){
                $fileName1 = 'file_beneficiare'. '_' . rand(111,99999) . '_' . 'file_beneficiare' . '_' . time() . '.' . $filefront->extension();
                $filefront->move(public_path('pieces/fichier_beneficiaire_lie_aux_action_plan_formation/'), $fileName1);
                FicheADemandeAgrement::where('id_fiche_agrement',$insertedIdFicheAgrement)->update([
                    'file_beneficiare_fiche_agrement' => $fileName1
                ]);
            }
        }

        return redirect('agreement/'.Crypt::UrlCrypt($id_plan).'/'.Crypt::UrlCrypt($id_action).'/'.Crypt::UrlCrypt(2).'/editaction')->with('success', 'Succes : Demande de substitution ajouté avec succès');

    }

    public function substitutionsUpdate(Request $request,string $id_plan,$id_action)
    {
        unset($request['_token']);
        unset($request['_method']);

        $id_action =  \App\Helpers\Crypt::UrldeCrypt($id_action);
        $id_plan =  \App\Helpers\Crypt::UrldeCrypt($id_plan);
        if(isset($id_action)){
            $actionplanformation = ActionFormationPlan::where('id_action_formation_plan',$id_action)->first();
            $demande_substitution = DemandeSubstitutionActionPlanFormation::
            where('id_action_formation_plan_a_substi',$id_action)
                ->where('id_plan_de_formation',$id_plan)
                ->first();

            if(isset($demande_substitution)) {
                $this->validate($request, [
                    'intitule_action_formation_plan_substi' => 'required',
                    'id_entreprise_structure_formation_plan_formation_substi' => 'required',
                    'id_caracteristique_type_formation_substi' => 'required',
                    'nombre_groupe_action_formation_substi' => 'required',
                    'nombre_heure_action_formation_p_substi' => 'required',
                    'cout_action_formation_plan_substi' => 'required',
                    'id_type_formation' => 'required',
                    'id_but_formation' => 'required',
                    'date_debut_fiche_agrement' => 'required',
                    'date_fin_fiche_agrement' => 'required',
                    'lieu_formation_fiche_agrement' => 'required',
                    'objectif_pedagogique_fiche_agre' => 'required',
                    'cadre_fiche_demande_agrement' => 'required',
                    'agent_maitrise_fiche_demande_ag' => 'required',
                    'employe_fiche_demande_agrement' => 'required',
                    'id_secteur_activite_substi' => 'required',

                    'id_motif_demande_plan_substi' => 'required',
                    'commentaire_demande_plan_substi' => 'required',
                ],[
                    'intitule_action_formation_plan_substi.required' => 'Veuillez ajoutez l\'intitule de l\'action.',
                    'id_caracteristique_type_formation_substi.required' => 'Veuillez sélectionner une caractéristique.',
                    'id_entreprise_structure_formation_plan_formation_substi.required' => 'Veuillez ajoutez une structure ou etablissement.',
                    'nombre_groupe_action_formation_substi.required' => 'Veuillez ajoutez le nombre de groupe.',
                    'nombre_heure_action_formation_p_substi.required' => 'Veuillez ajoutez le nombre d\'heure.',
                    'cout_action_formation_plan_substi.required' => 'Veuillez ajoutez le cout de la formation.',
                    'id_type_formation.required' => 'Veuillez selectionnez un type de formation.',
                    'id_but_formation.required' => 'Veuillez selectionnez le but de la formation.',
                    'date_debut_fiche_agrement.required' => 'Veuillez ajoutez la date de debut',
                    'date_fin_fiche_agrement.required' => 'Veuillez ajoutez la date de fin .',
                    'lieu_formation_fiche_agrement.required' => 'Veuillez ajoutez le lieu de formation.',
                    'objectif_pedagogique_fiche_agre.required' => 'Veuillez ajoutez l\'objectif pedagogique.',
                    'cadre_fiche_demande_agrement.required' => 'Veuillez ajoutez le nombre de cadre.',
                    'agent_maitrise_fiche_demande_ag.required' => 'Veuillez ajoutez le nombre d\'agent de maitrise.',
                    'employe_fiche_demande_agrement.required' => 'Veuillez ajoutez le nombre d\employe .',
                    'id_secteur_activite_substi.required' => 'Veuillez selectionner un secteur activité.',
                    'file_beneficiare_substi.required' => 'Veuillez ajoutez le fichier excel contenant la liste des beneficiaires.',
                    'facture_proforma_action_formati_substi.required' => 'Veuillez ajoutez la massse salariale.',
                    'file_beneficiare_substi.mimes' => 'Les formats requises pour le fichier excel contenant la liste des beneficiaires est: xlsx,XLSX.',
                    'file_beneficiare_substi.max'=> 'la taille maximale doit etre 5 MegaOctets.',
                    'facture_proforma_action_formati_substi.mimes' => 'Les formats requises pour la proformat est: PDF,PNG,JPG,JPEG.',
                    'facture_proforma_action_formati_substi.max'=> 'la taille maximale doit etre 5 MegaOctets.',

                    'piece_demande_plan_substi.mimes' => 'Les formats requises pour la proformat est: PDF,PNG,JPG,JPEG.',
                    'piece_demande_plan_substi.max'=> 'la taille maximale doit etre 5 MegaOctets.',
                    'id_motif_demande_plan_substi.unique' => 'Veuillez ajoutez le motif de la demande',
                    'commentaire_demande_plan_substi.unique' => 'Veuillez ajoutez le commentaire de la demande',
                ]);

                $data = $request->all();

                $input = $request->all();
                $rccentreprisehabilitation = Entreprises::where([['id_entreprises','=',$input['id_entreprise_structure_formation_plan_formation_substi']]])->first();
                $input['id_entreprise_structure_formation_action_substi'] = $input['id_entreprise_structure_formation_plan_formation_substi'];
                $input['nombre_stagiaire_action_formati_substi'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];
                $input['intitule_action_formation_plan_substi'] = mb_strtoupper($input['intitule_action_formation_plan_substi']);
                $input['structure_etablissement_action_substi'] = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);
                $input['lieu_formation_fiche_agrement'] = mb_strtoupper($input['lieu_formation_fiche_agrement']);
                $input['objectif_pedagogique_fiche_agre'] = mb_strtoupper($input['objectif_pedagogique_fiche_agre']);
//                $input['id_plan_de_formation'] = $id_plan;
//                $input['id_action_formation_plan_a_substi'] = $actionplanformation->id_action_formation_plan;

                if (isset($data['file_beneficiare_substi'])){
                    $file = $data['file_beneficiare_substi'];
                    $collections = (new FastExcel)->import($file);
                    if (count($collections)>$input['nombre_stagiaire_action_formati_substi']){
                        return redirect()->back()->withErrors(['error' => 'Erreur :Le nombre de bénéficiaires de l\'action de formation est supérieur au nombre saisi ']);
                    }

                    if (count($collections)<$input['nombre_stagiaire_action_formati_substi']){
                        return redirect()->back()->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est inférieur au nombre saisi ']);
                    }
                }else{
                    //compter le nombre de personne précedemment enregistré
                }

                if($input['cout_action_formation_plan_substi']>$actionplanformation->cout_action_formation_plan){
                    return redirect()->back()->withErrors(['error' => 'Erreur :  Le coût de cette formation est plus élevé que le cout de la formation que vous souhaitez substituer ']);
                }

                $nombredejour = $input['nombre_heure_action_formation_p_substi']/8;

                $input['nombre_jour_action_formation_substi'] = $nombredejour;

                $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation_substi']);

                if($infoscaracteristique->code_ctf == "CGF"){
                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_substi'];
                }
                if($infoscaracteristique->code_ctf == "CSF"){
                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati_substi'];
                }
                if($infoscaracteristique->code_ctf == "CFD"){
                    $montantcoutactionattribuable = $input['cout_action_formation_plan_substi'];
                }
                if($infoscaracteristique->code_ctf == "CCEF"){
                    $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_substi'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;
                }
                if($infoscaracteristique->code_ctf == "CSEF"){
                    $montantcoutactionattribuable = $input['cout_action_formation_plan_substi'];
                }

                $input['montant_attribuable_fdfp_substi'] = $montantcoutactionattribuable;

                if (isset($data['facture_proforma_action_formati_substi'])){
                    $filefront = $data['facture_proforma_action_formati_substi'];
                    if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                        || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                        || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){
                        $fileName1 = 'facture_proforma_action_formati'. '_' . rand(111,99999) . '_' . 'facture_proforma_action_formati' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces/facture_proforma_action_formation/'), $fileName1);
                        $input['facture_proforma_action_formati_substi'] = $fileName1;
                        DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_a_substi',$id_action)
                            ->where('id_plan_de_formation',$id_plan)
                            ->update([
                                'facture_proforma_action_formati_substi' => $input['facture_proforma_action_formati_substi'],
                            ]);
                    }
                }

                if (isset($data['piece_demande_plan_substi'])){
                    $filefront = $data['piece_demande_plan_substi'];
                    if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                        || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                        || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){
                        $fileName1 = 'piece_demande_substi'. '_' . rand(111,99999) . '_' . 'piece_demande_substi' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces/piece_demande_substi/'), $fileName1);
                        $input['piece_demande_plan_substi'] = $fileName1;
                        DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_a_substi',$id_action)
                            ->where('id_plan_de_formation',$id_plan)
                            ->update([
                                'piece_demande_plan_substi' => $input['piece_demande_plan_substi'],
                            ]);
                    }
                }
                DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_a_substi',$id_action)
                    ->where('id_plan_de_formation',$id_plan)
                    ->update([
                        'intitule_action_formation_plan_substi' => $input['intitule_action_formation_plan_substi'],
                        'nombre_groupe_action_formation_substi' => $input['nombre_groupe_action_formation_substi'],
                        'nombre_heure_action_formation_p_substi' => $input['nombre_heure_action_formation_p_substi'],
                        'cout_action_formation_plan_substi' => $input['cout_action_formation_plan_substi'],
                        'id_caracteristique_type_formation_substi' => $input['id_caracteristique_type_formation_substi'],
                        'nombre_jour_action_formation_substi' => $input['nombre_jour_action_formation_substi'],
                        'nombre_stagiaire_action_formati_substi' => $input['nombre_stagiaire_action_formati_substi'],
                        'id_entreprise_structure_formation_action_substi' => $input['id_entreprise_structure_formation_action_substi'],
                        'montant_attribuable_fdfp_substi' => $input['montant_attribuable_fdfp_substi'],
                        'structure_etablissement_action_substi' => $input['structure_etablissement_action_substi'],
                        'commentaire_demande_plan_substi' => $input['commentaire_demande_plan_substi'],
                        'id_motif_demande_plan_substi' => $input['id_motif_demande_plan_substi'],
                        'id_secteur_activite_substi' => $input['id_secteur_activite_substi'],
                    ]);


                $demande_substitution = DemandeSubstitutionActionPlanFormation::latest()->first();
                $input['cout_total_fiche_agrement'] = $input['cout_action_formation_plan_substi'];

                FicheADemandeAgrement::where('id_action_formation_plan_substi',$demande_substitution->id_action_formation_plan_substi)
                ->update([
                    'id_type_formation' => $input['id_type_formation'],
                    'id_but_formation' => $input['id_but_formation'],
                    'date_debut_fiche_agrement' => $input['date_debut_fiche_agrement'],
                    'date_fin_fiche_agrement' => $input['date_fin_fiche_agrement'],
                    'lieu_formation_fiche_agrement' => $input['lieu_formation_fiche_agrement'],
                    'cout_total_fiche_agrement' => $input['cout_total_fiche_agrement'],
                    'objectif_pedagogique_fiche_agre' => $input['objectif_pedagogique_fiche_agre'],
                    'cadre_fiche_demande_agrement' => $input['cadre_fiche_demande_agrement'],
                    'agent_maitrise_fiche_demande_ag' => $input['agent_maitrise_fiche_demande_ag'],
                    'employe_fiche_demande_agrement' => $input['employe_fiche_demande_agrement'],
                ]);

                $insertedIdFicheAgrement = FicheADemandeAgrement::latest()->first()->id_fiche_agrement;

                if (isset($data['file_beneficiare_substi'])){

                    $file = $data['file_beneficiare_substi'];

                    $collections = (new FastExcel)->import($file);

                    foreach($collections as $collection){

                        if(isset($collection['NOM ET PRENON'])){
                            $nom_prenom = $collection['NOM ET PRENON'];
                        }else{
                            $nom_prenom = null;
                        }
                        if(isset($collection['GENRE'])){
                            $genre = $collection['GENRE'];
                        }else{
                            $genre = null;
                        }
                        if(isset($collection['DATE'])){
                            $date = $collection['DATE'];
                        }else{
                            $date = null;
                        }
                        if(isset($collection['NATIONALITE'])){
                            $nationalite = $collection['NATIONALITE'];
                        }else{
                            $nationalite = null;
                        }
                        if(isset($collection['FONCTION'])){
                            $fonction = $collection['FONCTION'];
                        }else{
                            $fonction = null;
                        }
                        if(isset($collection['CATEGORIE'])){
                            $categorie = $collection['CATEGORIE'];
                        }else{
                            $categorie = null;
                        }
                        if(isset($collection['ANNEE EMBAUCHE'])){
                            $anneeembauche = $collection['ANNEE EMBAUCHE'];
                        }else{
                            $anneeembauche = null;
                        }
                        if(isset($collection['MATRICULE CNPS'])){
                            $matricule_cnps = $collection['MATRICULE CNPS'];
                        }else{
                            $matricule_cnps = null;
                        }
                        BeneficiairesFormation::where('id_fiche_agrement',$insertedIdFicheAgrement)->update([
                            'nom_prenoms' => $nom_prenom,
                            'genre' =>$genre,
                            'annee_naissance' => $date,
                            'nationalite' => $nationalite,
                            'fonction' => $fonction,
                            'categorie' => $categorie,
                            'annee_embauche' => $anneeembauche,
                            'matricule_cnps' => $matricule_cnps
                        ]);
                    }
                    $nbrebeneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$insertedIdFicheAgrement]])->get();
                    $nbrebene = count($nbrebeneficiaires);
                    $fiche = FicheADemandeAgrement::find($insertedIdFicheAgrement);
                    $fiche->update([
                        'total_beneficiaire_fiche_demand' =>$nbrebene
                    ]);
                }

                if (isset($data['file_beneficiare_substi'])){
                    $filefront = $data['file_beneficiare_substi'];
                    if($filefront->extension() == "xlsx"  || $filefront->extension() == "XLSX"){
                        $fileName1 = 'file_beneficiare'. '_' . rand(111,99999) . '_' . 'file_beneficiare' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces/fichier_beneficiaire_lie_aux_action_plan_formation/'), $fileName1);
                        FicheADemandeAgrement::where('id_fiche_agrement',$insertedIdFicheAgrement)->update([
                            'file_beneficiare_fiche_agrement' => $fileName1
                        ]);
                    }
                }


                if($request->action=="Enregistrer_soumettre_demande_substitution"){
                    DemandeSubstitutionActionPlanFormation::where('id_action_formation_plan_a_substi',$id_action)
                        ->where('id_plan_de_formation',$id_plan)
                        ->update([
                            'flag_soumis_demande_substitution_action_plan' => true,
                            'date_soumis_demande_substitution_action_plan' => now()]);
                    return redirect('agreement/'.Crypt::UrlCrypt($id_plan).'/'.Crypt::UrlCrypt($id_action).'/'.Crypt::UrlCrypt(2).'/editaction')->with('success', 'Succes : Demande de substitution d\'action de plan de formation soumis avec succès ');

                }

                return redirect('agreement/'.Crypt::UrlCrypt($id_plan).'/'.Crypt::UrlCrypt($id_action).'/'.Crypt::UrlCrypt(2).'/editaction')->with('success', 'Succes : Demande de substitution d\'action de plan de formation modifié ');


//                $rccentreprisehabilitation = Entreprises::where('id_entreprises',$request->structure_etablissement_plan_substi)->first();
//                $demande_substitution->id_plan_de_formation = $id_plan;
//                $demande_substitution->intitule_action_formation_plan_substi = $request->intitule_action_formation_plan_substi;
//                $demande_substitution->id_entreprise_structure_formation_plan_substi = $request->structure_etablissement_plan_substi;
//                $demande_substitution->structure_etablissement_plan_substi = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);
//                $demande_substitution->id_action_formation_plan_a_substi = $actionplanformation->id_action_formation_plan;
//                $demande_substitution->id_motif_demande_plan_substi = $request->id_motif_demande_plan_substi;
//                $demande_substitution->commentaire_demande_plan_substi = $request->commentaire_demande_plan_substi;
//                $demande_substitution->nombre_stagiaire_action_formati_plan_substi = $request->nombre_stagiaire_action_formati_plan_substi;
//                $demande_substitution->nombre_groupe_action_formation_plan_substi = $request->nombre_groupe_action_formation_plan_substi;
//                $demande_substitution->nombre_heure_action_formation_plan_substi = $request->nombre_heure_action_formation_plan_substi;
//                $demande_substitution->cout_action_formation_plan_substi = $actionplanformation->cout_action_formation_plan;
//                $demande_substitution->id_processus = 5;
//                $demande_substitution->id_secteur_activite =$request->id_secteur_activite;
//                $nombre_stagiaire_action_formati_substitu = $request->agent_maitrise_fiche_demande_ag + $request->employe_fiche_demande_agrement + $request->cadre_fiche_demande_agrement;
//
//                if (isset($request->file_beneficiare)){
//                    $file = $request->file_beneficiare;
//                    $collections = (new FastExcel)->import($file);
//                    if (count($collections)>$nombre_stagiaire_action_formati_substitu){
//                        return redirect()->back()->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est supérieur au nombre saisi ']);
//                    }
//                    if (count($collections)<$nombre_stagiaire_action_formati_substitu){
//                        return redirect()->back()->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est inférieur au nombre saisi ']);
//                    }
//                }
//
//                if (isset($request->piece_demande_plan_substi)){
//                    $filefront = $request->piece_demande_plan_substi;
//                    $filename_one = 'facture_piece_demande_plan_substi'. '_' . rand(111,99999) . '_' . 'facture_piece_demande_plan_substi' . '_' . time() . '.' . $filefront->extension();
//                    $filefront->move(public_path('pieces/piece_demande_substi/'), $filename_one);
//                    $demande_substitution->piece_demande_plan_substi = $filename_one;
//                }
//
//                if (isset($request->facture_proforma_action_plan_substi)){
//                    $filefront = $request->facture_proforma_action_plan_substi;
//                    $filename = 'facture_proforma_action_formati'. '_' . rand(111,99999) . '_' . 'facture_proforma_action_formati' . '_' . time() . '.' . $filefront->extension();
//                    $filefront->move(public_path('pieces/facture_proforma_action_formation/'), $filename);
//                    $demande_substitution->facture_proforma_action_plan_substi = $filename;
//                }
//
//                $plan_formation = PlanFormation::where('id_plan_de_formation',$id_plan)->first();
//
//                if(isset($plan_formation)){
//                    $demande_substitution->id_user = $plan_formation->user_conseiller;
//                }
//                $demande_substitution->update();
//
//                $fiche_a_demande_agrement = FicheADemandeAgrement::where('id_action_formation_plan_substi',$demande_substitution->id_action_formation_plan_substi)->first();
//
//                $fiche_a_demande_agrement->lieu_formation_fiche_agrement = mb_strtoupper($request->lieu_formation_fiche_agrement);
//                $fiche_a_demande_agrement->objectif_pedagogique_fiche_agre = mb_strtoupper($request->objectif_pedagogique_fiche_agre);
//                $fiche_a_demande_agrement->id_action_formation_plan_substi = $demande_substitution->id_action_formation_plan_substi;
//                $fiche_a_demande_agrement->date_debut_fiche_agrement =$request->date_debut_fiche_agrement;
//                $fiche_a_demande_agrement->date_fin_fiche_agrement = $request->date_fin_fiche_agrement;
//                $fiche_a_demande_agrement->id_type_formation = $request->id_type_formation;
//                $fiche_a_demande_agrement->id_but_formation = $request->id_but_formation;
//                $fiche_a_demande_agrement->cadre_fiche_demande_agrement = $request->cadre_fiche_demande_agrement;
//                $fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag = $request->agent_maitrise_fiche_demande_ag;
//                $fiche_a_demande_agrement->employe_fiche_demande_agrement = $request->employe_fiche_demande_agrement;
//
//                $fiche_a_demande_agrement->update();
//
//                $insertedIdFicheAgrement = FicheADemandeAgrement::latest()->first()->id_fiche_agrement;
//
//                if (isset($request->file_beneficiare)){
//                    $file = $request->file_beneficiare;
//                    $collections = (new FastExcel)->import($file);
//                    foreach($collections as $collection){
//
//                        if(isset($collection['NOM ET PRENON'])){
//                            $nom_prenom = $collection['NOM ET PRENON'];
//                        }else{
//                            $nom_prenom = null;
//                        }
//                        if(isset($collection['GENRE'])){
//                            $genre = $collection['GENRE'];
//                        }else{
//                            $genre = null;
//                        }
//                        if(isset($collection['DATE'])){
//                            $date = $collection['DATE'];
//                        }else{
//                            $date = null;
//                        }
//                        if(isset($collection['NATIONALITE'])){
//                            $nationalite = $collection['NATIONALITE'];
//                        }else{
//                            $nationalite = null;
//                        }
//                        if(isset($collection['FONCTION'])){
//                            $fonction = $collection['FONCTION'];
//                        }else{
//                            $fonction = null;
//                        }
//                        if(isset($collection['CATEGORIE'])){
//                            $categorie = $collection['CATEGORIE'];
//                        }else{
//                            $categorie = null;
//                        }
//                        if(isset($collection['ANNEE EMBAUCHE'])){
//                            $anneeembauche = $collection['ANNEE EMBAUCHE'];
//                        }else{
//                            $anneeembauche = null;
//                        }
//                        if(isset($collection['MATRICULE CNPS'])){
//                            $matricule_cnps = $collection['MATRICULE CNPS'];
//                        }else{
//                            $matricule_cnps = null;
//                        }
//
//                        $beneficiaire_formation = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->first();
//                        $beneficiaire_formation->nom_prenoms = $nom_prenom;
//                        $beneficiaire_formation->genre = $genre;
//                        $beneficiaire_formation->annee_naissance = $date;
//                        $beneficiaire_formation->nationalite = $nationalite;
//                        $beneficiaire_formation->fonction = $fonction;
//                        $beneficiaire_formation->categorie = $categorie;
//                        $beneficiaire_formation->annee_embauche = $anneeembauche;
//                        $beneficiaire_formation->matricule_cnps = $matricule_cnps;
//                        $beneficiaire_formation->update();
//                    }
//
//                    $nbrebeneficiaires = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->get();
//                    $nbrebene = count($nbrebeneficiaires);
//
//                    $fiche = FicheADemandeAgrement::find($fiche_a_demande_agrement->id_fiche_agrement);
//                    $fiche->total_beneficiaire_fiche_demand = $nbrebene;
//                    $fiche->update();
//                }
//
//                if (isset($request->file_beneficiare)){
//                    $filefront = $request->file_beneficiare;
//                    $filename_other = 'file_beneficiare'. '_' . rand(111,99999) . '_' . 'file_beneficiare' . '_' . time() . '.' . $filefront->extension();
//                    $filefront->move(public_path('pieces/fichier_beneficiaire_lie_aux_action_plan_formation/'), $filename_other);
//
//                    $fiche = FicheADemandeAgrement::find($fiche_a_demande_agrement->id_fiche_agrement);
//                    $fiche->file_beneficiare_fiche_agrement = $filename_other;
//                    $fiche->update();
//                }
//

//                $demande_substitution->update();
//            }

        }
        }
    }

}
