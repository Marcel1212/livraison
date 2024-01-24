<?php

namespace App\Http\Controllers;

use App\Helpers\ConseillerParAgence;
use App\Models\ComiteGestion;
use App\Models\ProjetEtude;
use Illuminate\Http\Request;
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
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PlanFormation;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;

class ComiteGestionPeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$Resultat = ComiteGestion::all();
        $Resultat = ComiteGestion::where('code_pieces_comite_gestion','=', 'PE')->get();
        return view('comitegestionpe.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typecomiteinfos = ConseillerParAgence::get_type_comite_per_plan_formation();
        $planformations = ProjetEtude::where([['statut_instruction','=',true],
                                                ['flag_fiche_agrement','=',false]])
                                            ->get();
        return view('comitegestionpe.create', compact('planformations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'date_debut_comite_gestion' => 'required',
                'date_fin_comite_gestion' => 'required',
                'commentaire_comite_gestion' => 'required'
            ],[
                'date_debut_comite_gestion.required' => 'Veuillez ajouter une date de debut.',
                'date_fin_comite_gestion.required' => 'Veuillez ajouter une date de fin.',
                'commentaire_comite_gestion.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_gestion'] = Auth::user()->id;
            $input['code_comite_gestion'] = 'CGPE' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces_comite_gestion'] = 'PE';
            $typecomiteinfos = ConseillerParAgence::get_type_comite_projet_etude();
            //dd($typecomiteinfos);
            $input['id_type_comite_comite_gestion'] = intval($typecomiteinfos->id_type_comite);

            ComiteGestion::create($input);

            $insertedId = ComiteGestion::latest()->first()->id_comite_gestion;

            return redirect('comitegestionpe/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');

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

        return view('comitepleniere.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        //dd($idetape);

        $comitegestion = ComiteGestion::find($id);

        $comitegestionparticipant = ComiteGestionParticipant::where([['id_comite_gestion','=',$comitegestion->id_comite_gestion]])->get();

        $ficheagrements = FicheAgrement::Join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
                            ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','plan_formation.user_conseiller','=','users.id')
                            ->where([['id_comite_gestion','=',$comitegestion->id_comite_gestion]])->get();

        $conseillers = ConseillerParAgence::get_comite_gestion_permanente();
//dd($conseillers);
        $conseiller = "<option value=''> Sélectionnez une personne ressource </option>";
        foreach ($conseillers as $comp) {
            $conseiller .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }

        $typecomiteinfos = ConseillerParAgence::get_type_comite_plan_formation();

        $planformations = ProjetEtude::where([['statut_instruction','=',true],
                                            ['flag_fiche_agrement','=',false]])
                                            ->get();

        return view('comitegestionpe.edit', compact('comitegestion','comitegestionparticipant','ficheagrements','conseiller','planformations','idetape'));
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

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'date_debut_comite_gestion' => 'required',
                    'date_fin_comite_gestion' => 'required',
                    'commentaire_comite_gestion' => 'required'
                ],[
                    'date_debut_comite_gestion.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_comite_gestion.required' => 'Veuillez ajouter une date de fin.',
                    'commentaire_comite_gestion.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                $input['id_user_comite_gestion'] = Auth::user()->id;
                $comitegestion = ComiteGestion::find($id);
                $comitegestion->update($input);

                return redirect('comitegestionpe/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Enregistrer_conseil_poour_comite'){

                $this->validate($request, [
                    'id_user_comite_gestion_participant' => 'required'
                ],[
                    'id_user_comite_gestion_participant.required' => 'Veuillez selectionnez le conseiller.'
                ]);

                $input = $request->all();
                $input['id_comite_gestion'] = $id;
                $input['flag_comite_gestion_participant'] = true;

                $verifconseillerexist = ComiteGestionParticipant::where([['id_comite_gestion','=',$id],['id_user_comite_gestion_participant','=',$input['id_user_comite_gestion_participant']]])->get();

                if(count($verifconseillerexist) >= 1){

                    return redirect('comitegestionpe/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Erreur : Cette personne existe déjà dans ce comite de gestion. ');

                }

                ComiteGestionParticipant::create($input);

                //return redirect('comitepleniere/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
                return redirect('comitegestionpe/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


            }

            if ($data['action'] == 'Traiter_cahier_plan'){


                $comitegestion = ComiteGestion::find($id);
                $comitegestion->update(['flag_statut_comite_gestion'=> true]);


                return redirect('comitegestionpe/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


            }

        }
    }

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $comitegestionParticipant = ComiteGestionParticipant::find($idVal);
        $idcomitegestion = $comitegestionParticipant->id_comite_gestion;
        ComiteGestionParticipant::where([['id_comite_gestion_participant','=',$idVal]])->delete();
        return redirect('comitegestion/'.Crypt::UrlCrypt($idcomitegestion).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : La personne a été supprimée du comite avec succès ');
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
        //dd($id);
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

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$id],['flag_valide_action_formation_pl_comite_gestion','=',true]])->get();
        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$id],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();

        $nombreactionvalider = count($actionvalider);
        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);
        //dd($nombreactionvalider);
        return view('comitegestion.editer', compact(
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','idcomite','id','idetape','idcomite'
        ));

    }

    public function agrementupdate(Request $request, $id, $id2, $id3)
    {

        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);
        $id3 =  Crypt::UrldeCrypt($id3);

       // dd($request->all());
       if ($request->isMethod('post')) {

            $data = $request->all();

        //dd($data);

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

                $input['flag_valide_action_formation_pl_comite_gestion'] = true;
                $input['flag_valide_action_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_action_plan_formation'] = $id;
                $input['id_plan_formation'] = $idplan;

                $actionplan->update($input);
                ActionPlanFormationAValiderParUser::create($input);

                //$nbreactionvalide = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['id_plan_formation','=',$idplan]])->get();

                return redirect('comitegestion/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/editer')->with('success', 'Succes : Action de plan de formation Traité ');

            }

            if($data['action'] === 'Traiter_action_formation_valider_plan'){

                //$actionplan = ActionFormationPlan::find($id);

                $idplan = $id;

                $input = $request->all();

                $input = $request->all();

                /*$input['flag_valide_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_plan_formation'] = $idplan;
                $input['date_valide_plan_formation'] = Carbon::now();

                PlanFormationAValiderParUser::create($input);*/

                FicheAgrement::create([
                    'id_demande' => $idplan,
                    'id_comite_gestion' => $id2,
                    'id_user_fiche_agrement' => Auth::user()->id,
                    'flag_fiche_agrement'=> true
                ]);
                //$nbreplanvalide = PlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['flag_valide_plan_formation','=',true]])->get();
                //$nbrav = count($nbreplanvalide);
                //if($nbrav == $nombredeconseilleragence){
                    $plan = PlanFormation::find($idplan);

                    $actionformationvals = ActionFormationPlan::where([['id_plan_de_formation','=',$idplan]])->get();

                    $montantcouttotal = 0;

                    foreach($actionformationvals as $actionformationval){
                        $montantcouttotal += $actionformationval->cout_accorde_action_formation;
                    }

                    $plan->update([
                        'flag_fiche_agrement' => true,
                        'cout_total_accorder_plan_formation' => $montantcouttotal,
                        'date_fiche_agrement' => Carbon::now()
                    ]);
                //}
                return redirect('comitegestion/'.Crypt::UrlCrypt($id2).'/'.Crypt::UrlCrypt($id3).'/edit')->with('success', 'Succes : Les actions ont été validée ');


            }

        }

    }
}
