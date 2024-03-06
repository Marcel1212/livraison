<?php

namespace App\Http\Controllers\PlanFormation;

use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Audit;
use App\Models\CahierPlanFormation;
use App\Models\LigneCahierPlanFormation;
use App\Models\PlanFormation;
use App\Helpers\Crypt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use App\Models\ComitePermanenteParticipant;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\ActionPlanFormationAValiderParUser;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Helpers\ConseillerParAgence;
use App\Helpers\EtatCahierPlanDeFormation;
use App\Models\ActionFormationPlan;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\User;
Use DB;
use App\Http\Controllers\Controller;

class CahierplanformationController extends Controller
{
    public function index(){

        $cahiers = CahierPlanFormation::all();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        return view("planformations.cahierplanformation.index", compact("cahiers"));
    }

    public function create(){

        $departements = Direction::join('departement','direction.id_direction','departement.id_direction')->where([
            ['direction.id_direction','=','4'],['departement.flag_departement','=',true]
            ])->get();

            Audit::logSave([
                'action'=>'CREER',
                'code_piece'=>'',
                'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',
                'etat'=>'Succès',
                'objet'=>'PLAN DE FORMATION'
            ]);

        return view("planformations.cahierplanformation.create",compact('departements'));

    }

    public function store(Request $request){

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'id_departement' => 'required',
                'id_agence' => 'required',
            ],[
                'id_departement.required' => 'Veuillez sélectionner un departement.',
                'id_agence' => 'veuillez sélectionner une agence',
            ]);


            $input = $request->all();
            $departement = Departement::find($input['id_departement']);
            $input['id_users_cahier_plan_formation'] = Auth::user()->id;
            $input['date_creer_cahier_plan_formation'] = Carbon::now();
            $input['code_cahier_plan_formation'] = $departement->code_profil_departement.'-'. Gencode::randStrGen(4, 5).'-'.Carbon::now()->format('Y');
            $cahier =  CahierPlanFormation::create($input);

            Audit::logSave([

                'action'=>'CREATION',

                'code_piece'=>'',

                'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

                'etat'=>'Succès',

                'objet'=>'PLAN DE FORMATION'

            ]);


            return redirect('cahierplanformation/'.Crypt::UrlCrypt($cahier->id_cahier_plan_formation).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');

        }
    }


    public function edit($id, $id1){

        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $departements = Direction::join('departement','direction.id_direction','departement.id_direction')->where([
            ['direction.id_direction','=','4'],['departement.flag_departement','=',true]
            ])->get();


        $cahier = CahierPlanFormation::find($id);

        $cahierplansformations = LigneCahierPlanFormation::join('plan_formation','ligne_cahier_plan_formation.id_plan_formation','plan_formation.id_plan_de_formation')
                            ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','plan_formation.user_conseiller','=','users.id')
                            ->where([['ligne_cahier_plan_formation.id_cahier_plan_formation','=',$cahier->id_cahier_plan_formation]])->get();


        $planformations = PlanFormation::Join('users','plan_formation.user_conseiller','users.id')->where([
            ['flag_plan_formation_valider_par_processus','=',true],
            ['flag_plan_formation_valider_cahier','=',false],
            ['users.id_departement','=',$cahier->id_departement],
            ['users.num_agce','=',$cahier->id_agence]
            ])->get();

        //dd($planformations);

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);


        return view('planformations.cahierplanformation.edit', compact('cahier','id','idetape','planformations','cahierplansformations','departements'));
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

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','but_formation.*','type_formation.*','secteur_activite.id_secteur_activite as id_secteur_activitee','secteur_activite.libelle_secteur_activite')
                                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                                        ->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
                                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                                        ->join('secteur_activite','action_formation_plan.id_secteur_activite','=','secteur_activite.id_secteur_activite')
                                        ->where([['action_formation_plan.id_plan_de_formation','=',$id]])->get();

        //dd($infosactionplanformations);

        $nombreaction = count($actionplanformations);

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$id],['flag_valide_action_formation_pl_comite_permanente','=',true]])->get();
        $actionvaliderparconseiller = ActionPlanFormationAValiderParUser::where([['id_plan_formation','=',$id],['id_user_conseil','=',Auth::user()->id],['flag_valide_action_plan_formation','=',true]])->get();

        $nombreactionvalider = count($actionvalider);
        $nombreactionvaliderparconseiller = count($actionvaliderparconseiller);
        //dd($nombreactionvalider);

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

        $montantactionplanformation = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformation += $actionplanformation->cout_action_formation_plan;
        }

        $montantactionplanformationacc = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformationacc += $actionplanformation->cout_accorde_action_formation;
        }

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id.'/'.$idcomite,

            'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        return view('planformations.cahierplanformation.editer', compact(
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'nombreaction','nombreactionvalider','nombreactionvaliderparconseiller','idcomite','id','idetape','idcomite','montantactionplanformation','montantactionplanformationacc'
        ));

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

        Audit::logSave([

            'action'=>'CONSULTER',

            'code_piece'=>$id,

            'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        return view('planformations.cahierplanformation.show', compact('actionplan','ficheagrement', 'beneficiaires','planformation'));
    }

    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'id_departement' => 'required',
                    'id_agence' => 'required',
                ],[
                    'id_departement.required' => 'Veuillez sélectionner un departement.',
                    'id_agence' => 'veuillez sélectionner une agence',
                ]);


                $input = $request->all();
                $departement = Departement::find($input['id_departement']);
                $input['id_users_cahier_plan_formation'] = Auth::user()->id;
                //$input['date_creer_cahier_plan_formation'] = Carbon::now();
                $input['code_cahier_plan_formation'] = $departement->code_profil_departement.'-'. Gencode::randStrGen(4, 5).'-'.Carbon::now()->format('Y');
                $comitegestion = CahierPlanFormation::find($id);
                $comitegestion->update($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                    ]);

                return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Traiter_cahier_plan'){



                $input = $request->all();
                //dd($input);exit;
                if(isset($input['planformation'])){

                $verifnombre = count($input['planformation']);

                //dd($verifnombre);exit;

                if($verifnombre < 1){

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'PLAN DE FORMATION (Cahier de plan de formation : Vous devez sélectionner au moins un plan de formation.)',

                        'etat'=>'Echec',

                        'objet'=>'PLAN DE FORMATION'

                        ]);

                    return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins un plan de formation. ');

                }

                $tab = $input['planformation'];

                foreach ($tab as $key => $value) {

                    //dd($value); exit;

                    LigneCahierPlanFormation::create([
                        'id_cahier_plan_formation'=> $id,
                        'id_plan_formation'=> $value
                    ]);

                    PlanFormation::where('id_plan_de_formation', $value)->update([
                        'flag_plan_formation_valider_cahier'=> true
                    ]);

                }

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                    ]);

                return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }else{

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'PLAN DE FORMATION (Cahier de plan de formation : Vous devez sélectionner au moins un plan de formation.)',

                        'etat'=>'Echec',

                        'objet'=>'PLAN DE FORMATION'

                        ]);

                    return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins un plan de formation. ');

                }

            }

            if ($data['action'] == 'Traiter_cahier_plan_soumis'){

                $comitegestion = CahierPlanFormation::find($id);
                $lignecahierplanformation = LigneCahierPlanFormation::where([['id_cahier_plan_formation','=',$id]])->get();

                foreach ($lignecahierplanformation as $key => $value) {

                    PlanFormation::where('id_plan_de_formation', $value->id_plan_formation)->update([
                        'flag_plan_formation_valider_cahier_soumis_comite_permanente'=> true
                    ]);
                }

                $comitegestion->update(['flag_statut_cahier_plan_formation'=> true,'date_soumis_cahier_plan_formation'=>Carbon::now()]);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                    ]);

                return redirect('cahierplanformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

        }
    }

    public function etat($id){

        $id =  Crypt::UrldeCrypt($id);

        $cahier = CahierPlanFormation::find($id);

       $etatsecteuractivite =  EtatCahierPlanDeFormation::get_liste_etat_secteur_activite_cahier_plan_f($id);

       //dd($etatsecteuractivite);

       $etatactionplan = EtatCahierPlanDeFormation::get_liste_etat_action_cahier_plan_f($id);

       $etatplanf = EtatCahierPlanDeFormation::get_liste_etat_plan_cahier_plan_f($id);

       $etatbutformation = EtatCahierPlanDeFormation::get_liste_etat_but_formation_cahier_plan_f($id);

       $etattypeformation = EtatCahierPlanDeFormation::get_liste_etat_type_formation_cahier_plan_f($id);

       //dd($etatsecteuractivite);
       Audit::logSave([

        'action'=>'CONSULTER',

        'code_piece'=>$id,

        'menu'=>'PLAN DE FORMATION (Cahier de plan de formation )',

        'etat'=>'Succès',

        'objet'=>'PLAN DE FORMATION'

        ]);

        return view('planformations.cahierplanformation.etat',compact('cahier','etatsecteuractivite','etatactionplan','etatplanf','etatbutformation','etattypeformation'));
    }
}
