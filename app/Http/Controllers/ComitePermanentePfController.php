<?php

namespace App\Http\Controllers;

use App\Models\ComitePermanente;
use App\Models\ProjetFormation;
use Illuminate\Http\Request;
use App\Helpers\ConseillerParAgence;
use Carbon\Carbon;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Models\User;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Crypt;
use App\Models\ActionFormationPlan;
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\ComiteGestionParticipant;
use App\Models\ComitePermanenteParticipant;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PlanFormation;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;

class ComitePermanentePfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Resultat = ComitePermanente::where('code_pieces_comite_permanente','=', 'PRF')->get();
        return view('comitepermanentepf.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typecomiteinfos = ConseillerParAgence::get_type_comite_per_projet_formation();
        //dd($typecomiteinfos);
        $planformations = ProjetFormation::where([
                                                 ['flag_statut_instruction','=',true],
                                                // ['flag_plan_formation_valider_par_processus','=',true],
                                                // ['flag_plan_formation_valider_cahier','=',true],
                                                ['cout_projet_formation','>=',$typecomiteinfos->valeur_min_type_comite],
                                                ['cout_projet_formation','<=',$typecomiteinfos->valeur_max_type_comite],
                                                ['flag_fiche_agrement','=',null],
                                                ['flag_processus_etape','=',true]])
                                            ->get();
            //dd($planformations);
        return view('comitepermanentepf.create', compact('planformations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'date_debut_comite_permanente' => 'required',
                'date_fin_comite_permanente' => 'required',
                'commentaire_comite_permanente' => 'required'
            ],[
                'date_debut_comite_permanente.required' => 'Veuillez ajouter une date de debut.',
                'date_fin_comite_permanente.required' => 'Veuillez ajouter une date de fin.',
                'commentaire_comite_permanente.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_permanente'] = Auth::user()->id;
            $input['code_comite_permanente'] = 'CP_PRF' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces_comite_permanente'] = 'PRF';
            $typecomiteinfos = ConseillerParAgence::get_type_comite_per_projet_formation();

            $input['id_type_comite_comite_permanente'] = $typecomiteinfos->id_type_comite;

            ComitePermanente::create($input);

            $insertedId = ComitePermanente::latest()->first()->id_comite_permanente;

            return redirect('comitepermanentepf/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');

        }
    }

    /**
     * Display the specified resource.
     */
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

        return view('comitepermanentepf.show', compact('actionplan','ficheagrement', 'beneficiaires','planformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        //dd($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        //dd($idetape);

        $comitegestion = ComitePermanente::find($id);
        //dd($comitegestion);

        $motifs = Motif::all();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $comitegestionparticipant = ComitePermanenteParticipant::where([['id_comite_permanente','=',$comitegestion->id_comite_permanente]])->get();
        //dd(count($comitegestionparticipant));

        $ficheagrements = FicheAgrement::Join('projet_formation','fiche_agrement.id_demande','projet_formation.id_projet_formation')
                            ->join('entreprises','projet_formation.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','projet_formation.id_conseiller_formation','=','users.id')
                            ->where([['fiche_agrement.id_comite_permanente','=',$comitegestion->id_comite_permanente]])->get();
        //dd(count($ficheagrements));

        $conseillers = ConseillerParAgence::get_comite_gestion_permanente();
        //dd($conseillers);
        $conseiller = "<option value=''> Sélectionnez une personne ressource </option>";
        foreach ($conseillers as $comp) {
            $conseiller .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }

        $typecomiteinfos = ConseillerParAgence::get_type_comite_per_projet_formation();

        //dd($infosactionplanformation);

        $planformations = ProjetFormation::where([['flag_comite_pleiniere','=',true],
                                                ['flag_fiche_agrement','=',null],
                                                ['flag_processus_etape','=',true],
                                                ['cout_projet_formation','>=',$typecomiteinfos->valeur_min_type_comite],
                                                ['cout_projet_formation','<=',$typecomiteinfos->valeur_max_type_comite]])->get();
        //dd($planformations);
        //dd($comitegestion->flag_comite_permanente );

        return view('comitepermanentepf.edit', compact('motif','comitegestion','comitegestionparticipant','ficheagrements','conseiller','planformations','idetape'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        if ($request->isMethod('put')) {

            $data = $request->all();
           //dd($data);

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'date_debut_comite_permanente' => 'required',
                    'date_fin_comite_permanente' => 'required',
                    'commentaire_comite_permanente' => 'required'
                ],[
                    'date_debut_comite_permanente.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_comite_permanente.required' => 'Veuillez ajouter une date de fin.',
                    'commentaire_comite_permanente.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $input['id_user_comite_permanente'] = Auth::user()->id;
                $comitegestion = ComitePermanente::find($id);
                $comitegestion->update($input);

                return redirect('comitepermanentepf/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Enregistrer_conseil_poour_comite'){

                $this->validate($request, [
                    'id_user_comite_permanente_participant' => 'required'
                ],[
                    'id_user_comite_permanente_participant.required' => 'Veuillez selectionnez le conseiller.'
                ]);

                $input = $request->all();
                $input['id_comite_permanente'] = $id;
                $input['flag_comite_gestion_participant'] = true;

                $verifconseillerexist = ComitePermanenteParticipant::where([['id_comite_permanente','=',$id],['id_user_comite_permanente_participant','=',$input['id_user_comite_permanente_participant']]])->get();

                if(count($verifconseillerexist) >= 1){

                    return redirect('comitepermanentepf/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Erreur : Cette personne existe déjà dans ce comite de gestion. ');

                }

                ComitePermanenteParticipant::create($input);

                //return redirect('comitepleniere/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
                return redirect('comitepermanentepf/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


            }

            if ($data['action'] == 'Traiter_cahier_plan'){
                //dd('ief ');


                $comitegestion = ComitePermanente::find($id);
                $comitegestion->update(['flag_statut_comite_permanente'=> true]);


                return redirect('comitepermanentepf/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes :Commission permanente validée  ');


            }

            if($data['action'] === 'Traiter_action_proj_formation_valider'){

                //$actionplan = ActionFormationPlan::find($id);
                dd( $data );

                $idplan = $id;
                $id2 = $idetape ;

                $input = $request->all();

                $input = $request->all();

                /*$input['flag_valide_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_plan_formation'] = $idplan;
                $input['date_valide_plan_formation'] = Carbon::now();

                PlanFormationAValiderParUser::create($input);*/

                FicheAgrement::create([
                    'id_demande' => $id,
                    'id_comite_permanente' => $idetape,
                    'id_user_fiche_agrement' => Auth::user()->id,
                    'flag_fiche_agrement'=> true
                ]);
                //$nbreplanvalide = PlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['flag_valide_plan_formation','=',true]])->get();
                //$nbrav = count($nbreplanvalide);
                //if($nbrav == $nombredeconseilleragence){
                    // $plan = PlanFormation::find($idplan);

                    // $actionformationvals = ActionFormationPlan::where([['id_plan_de_formation','=',$idplan]])->get();

                    // $montantcouttotal = 0;

                    // foreach($actionformationvals as $actionformationval){
                    //     $montantcouttotal += $actionformationval->cout_accorde_action_formation;
                    // }


                    // $plan->update([
                    //     'flag_fiche_agrement' => true,
                    //     'cout_total_accorder_plan_formation' => $montantcouttotal,
                    //     'date_fiche_agrement' => Carbon::now()
                    // ]);
                //}
                return redirect('comitepermanentepf/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Les actions ont été validée ');


            }

        }
    }

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $comitegestionParticipant = ComitePermanenteParticipant::find($idVal);
        $idcomitegestion = $comitegestionParticipant->id_comite_permanente;
        ComitePermanenteParticipant::where([['id_comite_permanente_participant','=',$idVal]])->delete();
        return redirect('comitepermanentepf/'.Crypt::UrlCrypt($idcomitegestion).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : La personne a été supprimée du comite avec succès ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function editer($id,$id2,$id3)
    {
        $id = Crypt::UrldeCrypt($id);
        $idcomite = Crypt::UrldeCrypt($id2);
        $idetape = Crypt::UrldeCrypt($id3);
        dd($id);
        $planformation = PlanFormation::find($id);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $typeentreprises = TypeEntreprise::all();
        $typeentreprise = "<option value='".$planformation->typeEntreprise->id_type_entreprise."'>".$planformation->typeEntreprise->lielle_type_entrepise." </option>";
        foreach ($typeentreprises as $comp) {
            $typeentreprise .= "<option value='" . $comp->id_type_entreprise  . "'>" . mb_strtoupper($comp->lielle_type_entrepise) ." </option>";
        }


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

        $motifs = Motif::where([['code_motif','=','CTPAF']])->get();
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

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$id],['flag_valide_action_formation_pl_comite_permanente','=',true]])->get();
        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$id],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();

        $nombreactionvalider = count($actionvalider);
        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);
        //dd($nombreactionvalider);
        return view('comitepermanentepf.editer', compact(
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','idcomite','id','idetape','idcomite'
        ));

    }

    public function agrementupdate(Request $request, $id, $id2) // , $id3
    {

        $id =  Crypt::UrldeCrypt($id); // ID Projet formation
        $id2 =  Crypt::UrldeCrypt($id2); // ID Comite Permanente

        // Mise a jour des projet de formations pour agrement

       if ($request->isMethod('post')) {

            $data = $request->all();



            if($data['action'] === 'Traiter_action_proj_formation_valider'){


               //dd( $data );

               // Recherche de la fiche d'agrement .
               $fiche = FicheAgrement::where([['id_demande','=',$id],['code_fiche_agrement','=','PRF']])->get();
               //dd(count($fiche));

               if (count($fiche)>=1){
                return redirect('comitepermanentepf/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt(1).'/edit')->with('error', 'Erreur : Projet de formation déjà dans la liste des agréments');

               }else {

                $idplan = $id;

                $input = $request->all();

                $input = $request->all();

                /*$input['flag_valide_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_plan_formation'] = $idplan;
                $input['date_valide_plan_formation'] = Carbon::now();

                PlanFormationAValiderParUser::create($input);*/

                FicheAgrement::create([
                    'id_demande' => $id,
                    'id_comite_permanente' => $id2,
                    'id_user_fiche_agrement' => Auth::user()->id,
                    'flag_fiche_agrement'=> true,
                    'commentaire_fiche_agrement' => $data['commentaire'],
                    'code_fiche_agrement' => 'PRF'
                ]);

                $plan = ProjetFormation::find($id);
                $plan->update([
                    'flag_fiche_agrement' => true,

                ]);
                //$nbreplanvalide = PlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['flag_valide_plan_formation','=',true]])->get();
                //$nbrav = count($nbreplanvalide);
                //if($nbrav == $nombredeconseilleragence){
                    // $plan = PlanFormation::find($idplan);

                    // $actionformationvals = ActionFormationPlan::where([['id_plan_de_formation','=',$idplan]])->get();

                    // $montantcouttotal = 0;

                    // foreach($actionformationvals as $actionformationval){
                    //     $montantcouttotal += $actionformationval->cout_accorde_action_formation;
                    // }


                    // $plan->update([
                    //     'flag_fiche_agrement' => true,
                    //     'cout_total_accorder_plan_formation' => $montantcouttotal,
                    //     'date_fiche_agrement' => Carbon::now()
                    // ]);
                //}
                return redirect('comitepermanentepf/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Les actions ont été validée ');

               }


            }

        }

    }

}
