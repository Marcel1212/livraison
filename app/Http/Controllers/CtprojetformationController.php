<?php

namespace App\Http\Controllers;

use App\Models\ProjetFormation;
use Illuminate\Http\Request;
use App\Models\Cahier;
use App\Models\ComitePleniere;
use App\Models\ComitePleniereProjetFormation;
use App\Models\ComitePleniereParticipant;
use Hash;
use DB;
use App\Models\User;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Crypt;
use App\Helpers\ConseillerParAgence;
use App\Models\PlanFormation;
use App\Models\Entreprises;
use App\Models\ActionFormationPlan;
use App\Models\FicheADemandeAgrement;
use App\Models\BeneficiairesFormation;
use App\Models\TypeEntreprise;
use App\Models\ButFormation;
use App\Models\CategorieProfessionelle;
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\PlanFormationAValiderParUser;
use App\Models\CategoriePlan;
use App\Models\TypeFormation;
use App\Models\Motif;
use App\Models\Pays;
use Carbon\Carbon;
use Image;
use File;
use Auth;

class CtprojetformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$Resultat = ComitePleniereProjetFormation::all();
        $Resultat =  $demandeenroles = ComitePleniere::where('code_pieces','=', 'PRF')->get();
        return view('ctprojetformation.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ctprojetformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
           //dd($request->all());

            // $this->validate($request, [
            //     'date_debut_comite_pleniere_pf' => 'required',
            //     'date_fin_comite_pleniere_pf' => 'required',
            //     'commentaire_comite_pleniere_pf' => 'required'
            // ],[
            //     'date_debut_comite_pleniere_pf.required' => 'Veuillez ajouter une date de debut.',
            //     'date_fin_comite_pleniere_pf.required' => 'Veuillez ajouter une date de fin.',
            //     'commentaire_comite_pleniere_pf.required' => 'Veuillez ajouter un commentaire.',
            // ]);

            // $input = $request->all();
            // $dateanneeencours = Carbon::now()->format('Y');
            // $input['id_user_comite_pleniere_pf'] = Auth::user()->id;
            // $input['code_comite_pleniere_pf'] = 'CTPRF' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            // $input['code_pieces_pf'] = 'PRF';

            // ComitePleniereProjetFormation::create($input);

            // $insertedId = ComitePleniereProjetFormation::latest()->first()->id_comite_pleniere_pf;

            $this->validate($request, [
                'date_debut_comite_pleniere' => 'required',
                //'date_fin_comite_pleniere' => 'required',
                'commentaire_comite_pleniere' => 'required'
            ],[
                'date_debut_comite_pleniere.required' => 'Veuillez ajouter une date de debut.',
                //'date_fin_comite_pleniere.required' => 'Veuillez ajouter une date de fin.',
                'commentaire_comite_pleniere.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_pleniere'] = Auth::user()->id;
            $input['code_comite_pleniere'] = 'CTPRF' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces'] = 'PRF';

            ComitePleniere::create($input);

            $insertedId = ComitePleniere::latest()->first()->id_comite_pleniere;

            return redirect('ctprojetformation/'.Crypt::UrlCrypt($insertedId).'/edit')->with('success', 'Succes : Enregistrement reussi ');

        }
    }

    /**
     * Display the specified resource.
     */
    /*public function show(string $id)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id =  Crypt::UrldeCrypt($id);

        $comitepleniere = ComitePleniere::find($id);


        $comitepleniereparticipant = ComitePleniereParticipant::where([['id_comite_pleniere','=',$comitepleniere->id_comite_pleniere]])->get();

        $cahiers = Cahier::Join('projet_formation','cahier.id_demande','projet_formation.id_projet_formation')
                            ->join('entreprises','projet_formation.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','projet_formation.id_conseiller_formation','=','users.id')
                            ->where([['id_comite_pleniere','=',$comitepleniere->id_comite_pleniere]])->get();
        //dd($cahiers);
        $conseillers = ConseillerParAgence::get_conseiller_par_departement(Auth::user()->num_agce,Auth::user()->id_departement);

        $motifs = Motif::all();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }
//dd($conseillers);
        $conseiller = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($conseillers as $comp) {
            $conseiller .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }

        $planformations = ProjetFormation::where([['flag_soumis','=',true],['flag_affect_conseiller_formation','=',true],['flag_statut_instruction','=',true],['flag_comite_pleiniere','=',null]])->get();
        //dd($planformations->entreprise);
        //$planformations = PlanFormation::where([['flag_soumis_ct_plan_formation','=',true],['flag_valide_action_des_plan_formation','=',false],['flag_plan_validation_rejeter_par_comite_en_ligne','=',true]])->get();

        return view('ctprojetformation.edit', compact('comitepleniere','comitepleniereparticipant','cahiers','conseiller','planformations','motif'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $id =  Crypt::UrldeCrypt($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'date_debut_comite_pleniere' => 'required',
                    'date_fin_comite_pleniere' => 'required',
                    'commentaire_comite_pleniere' => 'required'
                ],[
                    'date_debut_comite_pleniere.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_comite_pleniere.required' => 'Veuillez ajouter une date de fin.',
                    'commentaire_comite_pleniere.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $input['id_user_comite_pleniere'] = Auth::user()->id;
                $comitepleniere = ComitePleniere::find($id);
                $comitepleniere->update($input);

                return redirect('ctprojetformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Enregistrer_conseil_poour_comite'){

                $this->validate($request, [
                    'id_user_comite_pleniere_participant' => 'required'
                ],[
                    'id_user_comite_pleniere_participant.required' => 'Veuillez selectionnez le conseiller.'
                ]);

                $input = $request->all();
                $input['id_comite_pleniere'] = $id;
                $input['flag_comite_pleniere_participant'] = true;

                $verifconseillerexist = ComitePleniereParticipant::where([['id_comite_pleniere','=',$id],['id_user_comite_pleniere_participant','=',$input['id_user_comite_pleniere_participant']]])->get();

                if(count($verifconseillerexist) >= 1){

                    return redirect('ctprojetformation/'.Crypt::UrlCrypt($id).'/edit')->with('error', 'Erreur : Cet conseiller existe deja dans cette comite plénière ');

                }

                ComitePleniereParticipant::create($input);

                return redirect('ctprojetformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


            }

            if ($data['action'] == 'Traiter_cahier_plan'){


                $comitepleniere = ComitePleniere::find($id);
                $comitepleniere->update(['flag_statut_comite_pleniere'=> true]);


                return redirect('ctprojetformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Le cahier a ete validé ');


            }

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $comitepleniereParticipant = ComitePleniereParticipant::find($idVal);
        $idcomiteplenier = $comitepleniereParticipant->id_comite_pleniere;
        ComitePleniereParticipant::where([['id_comite_pleniere_participant','=',$idVal]])->delete();
        return redirect('ctprojetformation/'.Crypt::UrlCrypt($idcomiteplenier).'/edit')->with('success', 'Succes : Le conseiller à été du comite avec succes  supprimer avec succes ');
    }

    public function cahier($id,$id2){

        /*$idplan = Crypt::UrldeCrypt($id);
        $idcomite = Crypt::UrldeCrypt($id2);

        Cahier::create([
            'id_demande' => $idplan,
            'id_comite_pleniere' => $idplan,
        ]);*/

    }

    public function show($id)
    {
        $idVal = Crypt::UrldeCrypt($id);
        $actionplan = null;
        $ficheagrement = null;
        $beneficiaires = null;
        $planformation = null;

        if ($idVal != null) {
            $actionplan = ActionFormationPlan::find($idVal);
            $ficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->first();
            $beneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();
            $planformation = PlanFormation::where([['id_plan_de_formation','=',$actionplan->id_plan_de_formation]])->first();
        }

        return view('ctprojetformation.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
    }


    public function editer($id,$id2)
    {
        $id = Crypt::UrldeCrypt($id);
        $idcomite = Crypt::UrldeCrypt($id2);
        //dd($id);
        //$planformation = PlanFormation::find($id);
        $planformation = ProjetFormation::find($id);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $typeentreprises = TypeEntreprise::all();
        // $typeentreprise = "<option value='".$planformation->typeEntreprise->id_type_entreprise."'>".$planformation->typeEntreprise->lielle_type_entrepise." </option>";
        // foreach ($typeentreprises as $comp) {
        //     $typeentreprise .= "<option value='" . $comp->id_type_entreprise  . "'>" . mb_strtoupper($comp->lielle_type_entrepise) ." </option>";
        // }


        $pays = Pays::all();
        $pay = "<option value='".@$infoentreprise->pay->id_pays."'> " . @$infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }

        $typeformations = TypeFormation::all();
        $typeformation = "<option value=''> Selectionnez le type  de la formation </option>";
        foreach ($typeformations as $comp) {
            $typeformation .= "<option value='" . $comp->id_type_formation  . "'>" . mb_strtoupper($comp->type_formation) ." </option>";
        }

        $categorieprofessionelles = CategorieProfessionelle::all();
        $categorieprofessionelle = "<option value=''> Selectionnez la categorie </option>";
        foreach ($categorieprofessionelles as $comp) {
            $categorieprofessionelle .= "<option value='" . $comp->id_categorie_professionelle  . "'>" . mb_strtoupper($comp->categorie_profeessionnelle) ." </option>";
        }

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id]])->get();

        $motifs = Motif::all();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*')
                                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                                        ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
                                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                                        ->where([['action_formation_plan.id_plan_de_formation','=',$id]])->get();

        //dd($infosactionplanformations);

        $nombreaction = count($actionplanformations);

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$id],['flag_valide_action_formation_pl','=',true]])->get();
        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$id],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();

        $nombreactionvalider = count($actionvalider);
        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);
        //dd($nombreactionvalider);
        return view('ctprojetformation.editer', compact(
            'planformation','infoentreprise','pay','typeformation','butformation', //'typeentreprise',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','idcomite','id'
        ));

    }
    /**
     * Update the specified resource in storage.
     */
    public function cahierupdate(Request $request, $id, $id2)
    {

        $id =  Crypt::UrldeCrypt($id); // id_projet_formation
        $id2 =  Crypt::UrldeCrypt($id2); // id_comite_pleiniere


       if ($request->isMethod('post')) {

            $data = $request->all();

        //dd($data); // Traiter_action_proj_formation_valider

        if($data['action'] === 'Traiter_action_proj_formation_valider'){

            //dd($id2);
            // Recuperation des informations du comite
            $comite = ComitePleniere::find($id2);
            //$comite = ComitePleniere::where(['id_comite_pleniere','=',$id2])->get();
            //dd($comite);
            //dd($data);
            $codepleiniere = $comite->code_comite_pleniere;
           // dd($codepleiniere);

            // Recuperation du Projet de formation
            $projetformation = ProjetFormation::find($id);
            //dd($data);
            // Modification du projet de formation -- flag et ajout du code
            $projetformation->flag_comite_pleiniere = true;
            $projetformation->code_comite_pleiniere = $codepleiniere ;
            $projetformation->id_processus = 6 ;
            $projetformation->id_comite_pleiniere = $id2 ;
            $projetformation->save();



            // Modification du comite  -- Ajout dans le cahier

            $this->validate($request, [
                'id_motif' => 'required',
            ],[
                'id_motif.required' => 'Veuillez ajouter le motif.',
            ]);
            $idplan = 2;

            $input = $request->all();

            $input = $request->all();

            Cahier::create([
                'id_demande' => $id,
                'id_comite_pleniere' => $id2,
                'id_user_cahier' => Auth::user()->id,
                'commentaire_cahier' => $data['commentaire'],
                'id_motif' => $data['id_motif'],
                'flag_cahier'=> true
            ]);

            return redirect('ctprojetformation/'.Crypt::UrlCrypt($id2).'/edit')->with('success', 'Succes : Projet de formation ajouté au cahier du comité ');

        }

        if($data['action'] === 'Traiter_action_proj_formation_rejeter'){
            dd($data);

            $actionplan = ActionFormationPlan::find($id);

            $idplan = $actionplan->id_plan_de_formation;

            $this->validate($request, [
                'id_motif' => 'required',
            ],[
                'id_motif.required' => 'Veuillez ajouter le motif.',
            ]);

            $input = $request->all();

            $input = $request->all();

            $input['flag_valide_action_plan_formation'] = true;
            $input['id_user_conseil'] = Auth::user()->id;
            $input['id_action_plan_formation'] = $id;
            $input['id_plan_formation'] = $idplan;

            $actionplan->update($input);
            ActionPlanFormationAValiderParUser::create($input);

            //$nbreactionvalide = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['id_plan_formation','=',$idplan]])->get();

            return redirect('ctprojetformation/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($id2).'/editer')->with('error', 'Succes : Projet de formation rejeter du comité ');

        }

            if($data['action'] === 'Traiter_action_formation_valider'){

                $actionplan = ActionFormationPlan::find($id);

                $idplan = $actionplan->id_plan_de_formation;

                $this->validate($request, [
                    'id_motif' => 'required',
                ],[
                    'id_motif.required' => 'Veuillez ajouter le motif.',
                ]);

                $input = $request->all();

                $input = $request->all();

                $input['flag_valide_action_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_action_plan_formation'] = $id;
                $input['id_plan_formation'] = $idplan;

                $actionplan->update($input);
                ActionPlanFormationAValiderParUser::create($input);

                //$nbreactionvalide = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['id_plan_formation','=',$idplan]])->get();

                return redirect('ctprojetformatiob/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($id2).'/editer')->with('success', 'Succes : Action de plan de formation Traité ');

            }

            if($data['action'] === 'Traiter_action_formation_valider_plan'){

                //$actionplan = ActionFormationPlan::find($id);

                $idplan = $id;

                $input = $request->all();

                $input = $request->all();

                $input['flag_valide_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_plan_formation'] = $idplan;
                $input['date_valide_plan_formation'] = Carbon::now();

                PlanFormationAValiderParUser::create($input);
                Cahier::create([
                    'id_demande' => $idplan,
                    'id_comite_pleniere' => $id2,
                    'id_user_cahier' => Auth::user()->id,
                    'flag_cahier'=> true
                ]);
                //$nbreplanvalide = PlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['flag_valide_plan_formation','=',true]])->get();
                //$nbrav = count($nbreplanvalide);
                //if($nbrav == $nombredeconseilleragence){
                    $plan = PlanFormation::find($idplan);
                    $plan->update([
                        'id_processus' => 1,
                        'flag_valide_action_des_plan_formation' => true,
                        'flag_plan_formation_valider_par_comite_pleniere' => true
                    ]);
                //}
                return redirect('ctprojetformation/'.Crypt::UrlCrypt($id2).'/edit')->with('success', 'Succes : Les actions ont été validée ');


            }

        }

    }
}
