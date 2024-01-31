<?php

namespace App\Http\Controllers;

use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use Illuminate\Http\Request;
use App\Models\Cahier;
use App\Models\ComitePleniere;
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
use Illuminate\Support\Facades\Auth;
use Image;
use File;

class ComitePleniereProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comite_plenieres = ComitePleniere::where('code_pieces','PE')->get();
        return view('comitepleniereprojetetude.index', compact('comite_plenieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comitepleniereprojetetude.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
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
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite_pleniere'] = Auth::user()->id;
            $input['code_comite_pleniere'] = 'CT' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['code_pieces'] = 'PE';
            ComitePleniere::create($input);
            $insertedId = ComitePleniere::latest()->first()->id_comite_pleniere;
            return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($insertedId).'/edit')->with('success', 'Succes : Enregistrement reussi ');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $comitepleniere = ComitePleniere::find($id);
        $comitepleniereparticipant = ComitePleniereParticipant::where('id_comite_pleniere',$comitepleniere->id_comite_pleniere)->get();

        $charger_etudes = \Illuminate\Support\Facades\DB::table('users')
            ->where('id_departement', Auth::user()->id_departement)
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.name', 'users.prenom_users', 'users.id')
            ->where('roles.code_roles', "CHARGEETUDE")
            ->get();

        $charger_etude = "<option value=''> Selectionnez un chargé d'étude </option>";
        foreach ($charger_etudes as $comp) {
            $charger_etude .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }
        if($comitepleniere->flag_statut_comite_pleniere==false){
            $projet_etudes = ProjetEtude::where('flag_soumis_ct_pleniere',true)
                ->where('flag_valider_ct_pleniere_projet_etude',false)
                ->get();

        }else{
            $projet_etudes = ProjetEtude::where('flag_soumis_ct_pleniere',true)
                ->where('flag_valider_ct_pleniere_projet_etude',true)
                ->where('id_comite_pleniere',$id)
                ->get();
        }
            return view('comitepleniereprojetetude.edit', compact('charger_etude','comitepleniere','comitepleniereparticipant','projet_etudes'));

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

                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }
            if ($data['action'] == 'Enregistrer_charger_etude_pour_comite'){

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
                    return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/edit')->with('error', 'Erreur : Cet conseiller existe deja dans cette comite plénière ');
                }

                ComitePleniereParticipant::create($input);

                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
            }
            if ($data['action'] == 'Traiter_comite_pleniere'){
                $this->validate($request, [
                    'projetetude' => 'required',
                ],[
                    'projetetude.required' => 'Veuillez ajouter au moins un projet d\'étude',
                ]);
                foreach ($request->projetetude as $pe){
                    $projetetude = ProjetEtude::find($pe);
                    $projetetude->flag_valider_ct_pleniere_projet_etude = true;
                    $projetetude->id_processus = 8;
                    $projetetude->id_comite_pleniere = $id;
                    $projetetude->date_valider_ct_pleniere_projet_etude = now();
                    $projetetude->update();
                }
                $comitepleniere = ComitePleniere::find($id);
                $comitepleniere->update(['flag_statut_comite_pleniere'=> true]);

                return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
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
        ComitePleniereParticipant::where('id_comite_pleniere_participant',$idVal)->delete();
        return redirect('comitepleniereprojetetude/'.Crypt::UrlCrypt($idcomiteplenier).'/edit')->with('success', 'Succes : Le chargé d\'étude a été rétiré du comite avec succes ');
    }

    public function editer($id,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id_etape =  Crypt::UrldeCrypt($id2);
        if(isset($id)){
            $projet_etude = ProjetEtude::find($id);
            if(isset($projet_etude)){
                $pieces_projets= PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)->get();

                $avant_projet_tdr = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','avant_projet_tdr')->first();
                $courier_demande_fin = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','courier_demande_fin')->first();
                $dossier_intention = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','dossier_intention')->first();
                $lettre_engagement = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','lettre_engagement')->first();
                $offre_technique = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_technique')->first();
                $offre_financiere = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_financiere')->first();

                $infoentreprise = Entreprises::find($projet_etude->id_entreprises)->first();

                $pays = Pays::all();
                $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
                foreach ($pays as $comp) {
                    $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }

                /******************** secteuractivites *********************************/
                $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();
                $secteuractivite = "<option value=''> Selectionnez un secteur activité </option>";
                foreach ($secteuractivites as $comp) {
                    $secteuractivite .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }
                $motif = Motif::where('code_motif','=','PRE')->get();;
                $motifs = "<option value='".$projet_etude->motif->id_motif."'> " . $projet_etude->motif->libelle_motif . "</option>";
                foreach ($motif as $comp) {
                    $motifs .= "<option value='" . $comp->id_motif  . "' >" . $comp->libelle_motif ." </option>";
                }


                return view('comitepleniereprojetetude.editer',
                compact('id_etape','pay','pieces_projets','avant_projet_tdr',
                    'courier_demande_fin',
                    'dossier_intention',
                    'lettre_engagement',
                    'offre_technique',
                    'projet_etude',
                    'motifs',
                    'offre_financiere',
                    'secteuractivite'));

        }

        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function cahierupdate(Request $request, $id, $id2)
    {

        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);

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

                $input['flag_valide_action_plan_formation'] = true;
                $input['id_user_conseil'] = Auth::user()->id;
                $input['id_action_plan_formation'] = $id;
                $input['id_plan_formation'] = $idplan;

                $actionplan->update($input);
                ActionPlanFormationAValiderParUser::create($input);

                //$nbreactionvalide = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$idplan],['id_plan_formation','=',$idplan]])->get();

                return redirect('comitepleniere/'.Crypt::UrlCrypt($idplan).'/'.Crypt::UrlCrypt($id2).'/editer')->with('success', 'Succes : Action de plan de formation Traité ');

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
                return redirect('comitepleniere/'.Crypt::UrlCrypt($id2).'/edit')->with('success', 'Succes : Les actions ont été validée ');


            }

        }

    }
}
