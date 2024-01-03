<?php

namespace App\Http\Controllers;

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
use App\Models\PlanFormation;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
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
        $pays = Pays::all();
        $motifs = Motif::where('code_motif','APF')->where('flag_actif_motif',true)->get();
        $type_entreprises = TypeEntreprise::all();

        $id = Crypt::UrldeCrypt($id);
        $actionformations = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')
                                                ->Join('type_formation','fiche_a_demande_agrement.id_type_formation','type_formation.id_type_formation')
                                                ->Join('entreprises','action_formation_plan.id_entreprise_structure_formation_action','entreprises.id_entreprises')
                                                ->where([['action_formation_plan.id_plan_de_formation','=',$id]])
                                                ->get();
        if(isset($id)) {
            $agreement = DB::table('fiche_agrement')
                ->select(['plan_formation.*', 'fiche_agrement.*', 'fiche_agrement.created_at as date_valide_agrreement'])
                ->leftjoin('comite_gestion', 'fiche_agrement.id_comite_gestion', 'comite_gestion.id_comite_gestion')
                ->leftjoin('comite_permanente', 'fiche_agrement.id_comite_permanente', 'comite_permanente.id_comite_permanente')
                ->join('plan_formation', 'fiche_agrement.id_demande', 'plan_formation.id_plan_de_formation')
                ->where('plan_formation.id_entreprises', Auth::user()->id_partenaire)
                ->where('plan_formation.id_plan_de_formation', $id)
                ->first();

            $plan_de_formation = DB::table('plan_formation')->where('flag_fiche_agrement', true)
                ->where('plan_formation.id_entreprises', Auth::user()->id_partenaire)
                ->where('id_plan_de_formation', $agreement->id_plan_de_formation)
                ->first();

            $demande_annulation_plan = DemandeAnnulationPlan::where('id_plan_formation', $agreement->id_plan_de_formation)->first();
            $infoentreprise = Entreprises::find($plan_de_formation->id_entreprises);
            $categorieplans = CategoriePlan::where('id_plan_de_formation', $plan_de_formation->id_plan_de_formation)->get();
            $actionplanformations = ActionFormationPlan::where('id_plan_de_formation', $plan_de_formation->id_plan_de_formation)->get();

        }

        return view('agreement.edit', compact('agreement','actionformations','plan_de_formation','pays','motifs','type_entreprises','demande_annulation_plan','infoentreprise','actionplanformations','categorieplans'));
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
//        substitution
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

    public function substitutionsStore(DemandeSubstitutionSauvegarderRequest $request,string $id_plan, string $id_action)
    {
        $id_action =  \App\Helpers\Crypt::UrldeCrypt($id_action);
        $id_plan =  \App\Helpers\Crypt::UrldeCrypt($id_plan);
        if(isset($id_action)){
            $actionplanformation = ActionFormationPlan::where('id_action_formation_plan',$id_action)->first();
            $demande_substitution_one = DemandeSubstitutionActionPlanFormation::
            where('id_action_formation_plan_a_substi',$id_action)
                ->where('id_plan_de_formation',$id_plan)
                ->first();

            if(isset($actionplanformation)){
                $rccentreprisehabilitation = Entreprises::where('id_entreprises',$request->structure_etablissement_plan_substi)->first();
                $demande_substitution = new DemandeSubstitutionActionPlanFormation();
                $demande_substitution->id_plan_de_formation = $id_plan;

                $demande_substitution->intitule_action_formation_plan_substi = $request->intitule_action_formation_plan_substi;
                $demande_substitution->structure_etablissement_plan_substi = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);
                $demande_substitution->id_action_formation_plan_a_substi = $actionplanformation->id_action_formation_plan;
                $demande_substitution->id_motif_demande_plan_substi = $request->id_motif_demande_plan_substi;
                $demande_substitution->commentaire_demande_plan_substi = $request->commentaire_demande_plan_substi;
                $demande_substitution->nombre_stagiaire_action_formati_plan_substi = $request->nombre_stagiaire_action_formati_plan_substi;
                $demande_substitution->nombre_groupe_action_formation_plan_substi = $request->nombre_groupe_action_formation_plan_substi;
                $demande_substitution->nombre_heure_action_formation_plan_substi = $request->nombre_heure_action_formation_plan_substi;
                $demande_substitution->cout_action_formation_plan_substi = $request->cout_action_formation_plan_substi;
                $demande_substitution->id_processus = 4;


                if(isset($request->piece_demande_plan_substi)){
                     $filefront = $request->piece_demande_plan_substi;
                     $filename_one = 'piece_demande_plan_substi'. '_' . rand(111,99999) . '_' . 'piece_demande_plan_substi' . '_' . time() . '.' . $filefront->extension();
                     $filefront->move(public_path('pieces/piece_demande_substi/'), $filename_one);
                     $demande_substitution->piece_demande_plan_substi = $filename_one;
                }

                if(isset($request->facture_proforma_action_plan_substi)){
                    $filefront = $request->facture_proforma_action_plan_substi;
                    $filename = 'facture_proforma_action_formati'. '_' . rand(111,99999) . '_' . 'facture_proforma_action_formati' . '_' . time() . '.' . $filefront->extension();
                    $filefront->move(public_path('pieces/facture_proforma_action_formation/'), $filename);
                    $demande_substitution->facture_proforma_action_plan_substi = $filename;
                }

                $plan_formation = PlanFormation::where('id_plan_de_formation',$id_plan)->first();

                if(isset($plan_formation)){
                    $demande_substitution->id_user = $plan_formation->user_conseiller;
                }

                $demande_substitution->save();

                $demande_substitution = DemandeSubstitutionActionPlanFormation::latest()->first();
                $fiche_a_demande_agrement = new FicheADemandeAgrement();
                $fiche_a_demande_agrement->lieu_formation_fiche_agrement = mb_strtoupper($request->lieu_formation_fiche_agrement);
                $fiche_a_demande_agrement->objectif_pedagogique_fiche_agre = mb_strtoupper($request->objectif_pedagogique_fiche_agre);
                $fiche_a_demande_agrement->id_action_formation_plan_substi = $demande_substitution->id_action_formation_plan_substi;
                $fiche_a_demande_agrement->date_debut_fiche_agrement =$request->date_debut_fiche_agrement;
                $fiche_a_demande_agrement->date_fin_fiche_agrement = $request->date_fin_fiche_agrement;
                $fiche_a_demande_agrement->id_type_formation = $request->id_type_formation;
                $fiche_a_demande_agrement->id_but_formation = $request->id_but_formation;
                $fiche_a_demande_agrement->cadre_fiche_demande_agrement = $request->cadre_fiche_demande_agrement;
                $fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag = $request->agent_maitrise_fiche_demande_ag;
                $fiche_a_demande_agrement->employe_fiche_demande_agrement = $request->employe_fiche_demande_agrement;

                $fiche_a_demande_agrement->save();

                if (isset($request->file_beneficiare)){
                    $file = $request->file_beneficiare;
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

                        $beneficiaire_formation = new BeneficiairesFormation();
                        $beneficiaire_formation->id_fiche_agrement = $request->id_fiche_agrement;
                        $beneficiaire_formation->nom_prenoms = $nom_prenom;
                        $beneficiaire_formation->genre = $genre;
                        $beneficiaire_formation->annee_naissance = $date;
                        $beneficiaire_formation->nationalite = $nationalite;
                        $beneficiaire_formation->fonction = $fonction;
                        $beneficiaire_formation->categorie = $categorie;
                        $beneficiaire_formation->annee_embauche = $anneeembauche;
                        $beneficiaire_formation->matricule_cnps = $matricule_cnps;
                        $beneficiaire_formation->save();
                    }

                    $nbrebeneficiaires = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->get();
                    $nbrebene = count($nbrebeneficiaires);

                    $fiche = FicheADemandeAgrement::find($fiche_a_demande_agrement->id_fiche_agrement);
                    $fiche->total_beneficiaire_fiche_demand = $nbrebene;
                    $fiche->update();
                }

                if (isset($request->file_beneficiare)){

                    $filefront = $request->file_beneficiare;
                    $filename_other = 'file_beneficiare'. '_' . rand(111,99999) . '_' . 'file_beneficiare' . '_' . time() . '.' . $filefront->extension();
                    $filefront->move(public_path('pieces/fichier_beneficiaire_lie_aux_action_plan_formation/'), $filename_other);

                    $fiche = FicheADemandeAgrement::find($fiche_a_demande_agrement->id_fiche_agrement);
                    $fiche->file_beneficiare_fiche_agrement = $filename_other;
                    $fiche->update();
                }
                return redirect('agreement/'.Crypt::UrlCrypt($id_plan).'/'.Crypt::UrlCrypt($id_action).'/substitution')->with('success', 'Succes : Demande de substitution d\'action de plan de formation effectué ');
            }
        }
    }

    public function substitutionsUpdate(DemandeSubstitutionSauvegarderRequest $request,string $id_plan,$id_action)
    {
        $id_action =  \App\Helpers\Crypt::UrldeCrypt($id_action);
        $id_plan =  \App\Helpers\Crypt::UrldeCrypt($id_plan);
        if(isset($id_action)){
            $actionplanformation = ActionFormationPlan::where('id_action_formation_plan',$id_action)->first();
            $demande_substitution = DemandeSubstitutionActionPlanFormation::
            where('id_action_formation_plan_a_substi',$id_action)
                ->where('id_plan_de_formation',$id_plan)
                ->first();
            if(isset($demande_substitution)){

                $rccentreprisehabilitation = Entreprises::where('id_entreprises',$request->structure_etablissement_plan_substi)->first();
                $demande_substitution->id_plan_de_formation = $id_plan;
                $demande_substitution->intitule_action_formation_plan_substi = $request->intitule_action_formation_plan_substi;
                $demande_substitution->structure_etablissement_plan_substi = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);
                $demande_substitution->id_action_formation_plan_a_substi = $actionplanformation->id_action_formation_plan;
                $demande_substitution->id_motif_demande_plan_substi = $request->id_motif_demande_plan_substi;
                $demande_substitution->commentaire_demande_plan_substi = $request->commentaire_demande_plan_substi;
                $demande_substitution->nombre_stagiaire_action_formati_plan_substi = $request->nombre_stagiaire_action_formati_plan_substi;
                $demande_substitution->nombre_groupe_action_formation_plan_substi = $request->nombre_groupe_action_formation_plan_substi;
                $demande_substitution->nombre_heure_action_formation_plan_substi = $request->nombre_heure_action_formation_plan_substi;
                $demande_substitution->cout_action_formation_plan_substi = $request->cout_action_formation_plan_substi;
                $demande_substitution->id_processus = 4;

                if (isset($request->piece_demande_plan_substi)){
                    $filefront = $request->piece_demande_plan_substi;
                    $filename_one = 'facture_piece_demande_plan_substi'. '_' . rand(111,99999) . '_' . 'facture_piece_demande_plan_substi' . '_' . time() . '.' . $filefront->extension();
                    $filefront->move(public_path('pieces/piece_demande_substi/'), $filename_one);
                    $demande_substitution->piece_demande_plan_substi = $filename_one;
                }

                if (isset($request->facture_proforma_action_plan_substi)){
                    $filefront = $request->facture_proforma_action_plan_substi;
                    $filename = 'facture_proforma_action_formati'. '_' . rand(111,99999) . '_' . 'facture_proforma_action_formati' . '_' . time() . '.' . $filefront->extension();
                    $filefront->move(public_path('pieces/facture_proforma_action_formation/'), $filename);
                    $demande_substitution->facture_proforma_action_plan_substi = $filename;
                }

                $plan_formation = PlanFormation::where('id_plan_de_formation',$id_plan)->first();

                if(isset($plan_formation)){
                    $demande_substitution->id_user = $plan_formation->user_conseiller;
                }

                $demande_substitution->update();

                $fiche_a_demande_agrement = FicheADemandeAgrement::where('id_action_formation_plan_substi',$demande_substitution->id_action_formation_plan_substi)->first();

                $fiche_a_demande_agrement->lieu_formation_fiche_agrement = mb_strtoupper($request->lieu_formation_fiche_agrement);
                $fiche_a_demande_agrement->objectif_pedagogique_fiche_agre = mb_strtoupper($request->objectif_pedagogique_fiche_agre);
                $fiche_a_demande_agrement->id_action_formation_plan_substi = $demande_substitution->id_action_formation_plan_substi;
                $fiche_a_demande_agrement->date_debut_fiche_agrement =$request->date_debut_fiche_agrement;
                $fiche_a_demande_agrement->date_fin_fiche_agrement = $request->date_fin_fiche_agrement;
                $fiche_a_demande_agrement->id_type_formation = $request->id_type_formation;
                $fiche_a_demande_agrement->id_but_formation = $request->id_but_formation;
                $fiche_a_demande_agrement->cadre_fiche_demande_agrement = $request->cadre_fiche_demande_agrement;
                $fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag = $request->agent_maitrise_fiche_demande_ag;
                $fiche_a_demande_agrement->employe_fiche_demande_agrement = $request->employe_fiche_demande_agrement;

                $fiche_a_demande_agrement->update();

                if (isset($request->file_beneficiare)){
                    $file = $request->file_beneficiare;
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

                        $beneficiaire_formation = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->first();
                        $beneficiaire_formation->nom_prenoms = $nom_prenom;
                        $beneficiaire_formation->genre = $genre;
                        $beneficiaire_formation->annee_naissance = $date;
                        $beneficiaire_formation->nationalite = $nationalite;
                        $beneficiaire_formation->fonction = $fonction;
                        $beneficiaire_formation->categorie = $categorie;
                        $beneficiaire_formation->annee_embauche = $anneeembauche;
                        $beneficiaire_formation->matricule_cnps = $matricule_cnps;
                        $beneficiaire_formation->update();
                    }

                    $nbrebeneficiaires = BeneficiairesFormation::where('id_fiche_agrement',$fiche_a_demande_agrement->id_fiche_agrement)->get();
                    $nbrebene = count($nbrebeneficiaires);

                    $fiche = FicheADemandeAgrement::find($fiche_a_demande_agrement->id_fiche_agrement);
                    $fiche->total_beneficiaire_fiche_demand = $nbrebene;
                    $fiche->update();
                }

                if (isset($request->file_beneficiare)){
                    $filefront = $request->file_beneficiare;
                    $filename_other = 'file_beneficiare'. '_' . rand(111,99999) . '_' . 'file_beneficiare' . '_' . time() . '.' . $filefront->extension();
                    $filefront->move(public_path('pieces/fichier_beneficiaire_lie_aux_action_plan_formation/'), $filename_other);

                    $fiche = FicheADemandeAgrement::find($fiche_a_demande_agrement->id_fiche_agrement);
                    $fiche->file_beneficiare_fiche_agrement = $filename_other;
                    $fiche->update();
                }

                if($request->action=="Enregistrer_soumettre_plan_formation"){
                    $demande_substitution->flag_soumis_demande_substitution_action_plan = true;
                    $demande_substitution->date_soumis_demande_substitution_action_plan = now();
                }
                $demande_substitution->update();

                return redirect('agreement/'.Crypt::UrlCrypt($id_plan).'/'.Crypt::UrlCrypt($id_action).'/substitution')->with('success', 'Succes : Demande de substitution d\'action de plan de formation effectué ');
            }

        }
//        substitution
    }
}
