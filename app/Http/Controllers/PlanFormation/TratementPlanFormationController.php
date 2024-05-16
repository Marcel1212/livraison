<?php

namespace App\Http\Controllers\PlanFormation;

use App\Helpers\SmsPerso;
use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\Activites;
use App\Models\CentreImpot;
use App\Models\Localite;
use App\Models\Pays;
use App\Models\DemandeEnrolement;
use App\Models\Entreprises;
use App\Models\PlanFormation;
use App\Models\ActionFormationPlan;
use App\Models\FicheADemandeAgrement;
use App\Models\BeneficiairesFormation;
use App\Models\TypeEntreprise;
use App\Models\ButFormation;
use App\Models\CategorieProfessionelle;
use App\Models\CategoriePlan;
use App\Models\TypeFormation;
use App\Models\Motif;
use App\Helpers\Crypt;
use App\Helpers\Menu;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Models\CaracteristiqueTypeFormation;
use App\Models\FicheAgrement;
use App\Models\SecteurActivite;
use App\Helpers\ListePlanFormationSoumis;
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Controllers\Controller;
use App\Models\FicheAgrementButFormation;
use Illuminate\Http\JsonResponse;


class TratementPlanFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nacodes = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($nacodes);
        if($nacodes === "CONSEILLER"){
            $planformations = PlanFormation::where([['user_conseiller','=',Auth::user()->id],['flag_soumis_ct_plan_formation','=',false]])->get();

        }else{
            $planformations = PlanFormation::all();
        }

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'PLAN DE FORMATION (Instruction )',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        return view('planformations.traitementplanformation.index',compact('planformations'));
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
        $idVal = Crypt::UrldeCrypt($id);
        $actionplan = null;
        $ficheagrement = null;
        $beneficiaires = null;
        $planformation = null;
        $butformations = null;

        if ($idVal != null) {
            $actionplan = ActionFormationPlan::find($idVal);
            $ficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->first();
            $beneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();
            $planformation = PlanFormation::where([['id_plan_de_formation','=',$actionplan->id_plan_de_formation]])->first();
            $butformations = FicheAgrementButFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();

        }

        Audit::logSave([

            'action'=>'CONSULTER',

            'code_piece'=>'',

            'menu'=>'PLAN DE FORMATION (Instruction)',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        return view('planformations.traitementplanformation.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation','butformations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $id =  Crypt::UrldeCrypt($id);
//dd($id);
        $planformation = PlanFormation::find($id);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $historiquesplanformations = FicheAgrement::Join('plan_formation','fiche_agrement.id_demande','plan_formation.id_plan_de_formation')
                                                    ->join('action_formation_plan','plan_formation.id_plan_de_formation','action_formation_plan.id_plan_de_formation')
                                                    ->where([['plan_formation.id_entreprises','=',$planformation->id_entreprises]])->get();
//dd($historiquesplanformations);
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

        $payss = Pays::all();
        $paysc = "<option value=''> ---Selectionnez un pays--- </option>";
        foreach ($payss as $comp) {
            $paysc .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
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

//        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();
/*         $actionplanformations = ActionFormationPlan::where('id_plan_de_formation',$id)
            ->where(function ($query) {
                $query->where('flag_annulation_action', false)
                    ->orwhereNull('flag_annulation_action');
            })->get(); */

            $actionplanformations = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')
                ->where('id_plan_de_formation',$id)
            ->where(function ($query) {
                $query->where('flag_annulation_action', false)
                    ->orwhereNull('flag_annulation_action');
            })->get();

            //dd($actionplanformations);

        $categorieplans = CategoriePlan::where(function ($query) use ($id,$planformation) {
            $query->where('id_plan_de_formation', $id)
                ->orwhere('id_plan_de_formation', @$planformation->id_plan_formation_supplementaire);
            })->get();

        $motifs = Motif::where([['code_motif','=','PAF']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','domaine_formation.*','type_formation.*')
                                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                                        //->join('but_formation','fiche_a_demande_agrement.id_but_formation','=','but_formation.id_but_formation')
                                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                                        ->join('domaine_formation','domaine_formation.id_domaine_formation','=','domaine_formation.id_domaine_formation')
                                        ->where([['action_formation_plan.id_plan_de_formation','=',$id]])
                                        ->get();
        //$butformations = FicheAgrementButFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();

        $infosactionplanformationsficheagrements = ActionFormationPlan::select('action_formation_plan.*','fiche_a_demande_agrement.*')
            ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
            ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
            ->where([['action_formation_plan.id_plan_de_formation','=',$id]])
            ->get();

/*         $beneficiairesaction = ActionFormationPlan::select('action_formation_plan.*','fiche_a_demande_agrement.*')
                ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                ->join('beneficiaires_formation','fiche_a_demande_agrement.id_fiche_agrement','=','beneficiaires_formation.id_fiche_agrement')
                ->where([['action_formation_plan.id_plan_de_formation','=',$id]])->get(); */

            //BeneficiairesFormation::where([['id_fiche_agrement','=',$idficheagrement]])->get();

       // dd($infosactionplanformationsficheagrements);

        $nombreaction = count($actionplanformations);

        $actionvalider = ActionFormationPlan::where([['id_plan_de_formation','=',$id],['flag_valide_action_formation_pl','=',true]])->get();

        $nombreactionvalider = count($actionvalider);

        $actionplanformations = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')->where([['action_formation_plan.id_plan_de_formation','=',$id]])->orderBy('action_formation_plan.id_action_formation_plan','asc')->get();

        $montantactionplanformation = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')->where([['action_formation_plan.id_plan_de_formation','=',$id]])->orderBy('action_formation_plan.id_action_formation_plan','asc')->sum('cout_action_formation_plan');
        $montantactionplanformationacc = ActionFormationPlan::Join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','fiche_a_demande_agrement.id_action_formation_plan')->where([['action_formation_plan.id_plan_de_formation','=',$id]])->orderBy('action_formation_plan.id_action_formation_plan','asc')->sum('cout_accorde_action_formation');

        $infoscaracteristique = CaracteristiqueTypeFormation::where([['flag_ctf','=',true]])->get();
/*         $montantactionplanformation = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformation += $actionplanformation->cout_action_formation_plan;
        }

        $montantactionplanformationacc = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformationacc += $actionplanformation->cout_accorde_action_formation;
        } */

                /******************** secteuractivites *********************************/
                $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                ->orderBy('libelle_secteur_activite')
                ->get();

                $typeformationss = TypeFormation::where('flag_actif_formation','=',true)->orderBy('type_formation')->get();

                Audit::logSave([

                    'action'=>'MODIFIER',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Instruction)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

        return view('planformations.traitementplanformation.edit', compact('planformation',
            'infoscaracteristique',
            'infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations',
                            'categorieprofessionelle','categorieplans','motif','infosactionplanformations','infosactionplanformationsficheagrements',
                            'nombreaction','nombreactionvalider','historiquesplanformations','montantactionplanformation',
                            'montantactionplanformationacc','secteuractivites','butformations','typeformationss','paysc','infoscaracteristique'));

    }

    public function informationaction($id)
    {

        $id =  Crypt::UrldeCrypt($id);

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','domaine_formation.*','type_formation.*','caracteristique_type_formation.*')
        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
        ->join('caracteristique_type_formation','action_formation_plan.id_caracteristique_type_formation','=','caracteristique_type_formation.id_caracteristique_type_formation')
        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
        ->join('domaine_formation','action_formation_plan.id_domaine_formation','=','domaine_formation.id_domaine_formation')
        ->where([['action_formation_plan.id_action_formation_plan','=',$id]])
        ->first();

        //dd($infosactionplanformations);
        /*$butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }*/

        $butformations = FicheAgrementButFormation::where([['id_fiche_agrement','=',$infosactionplanformations->id_fiche_agrement]])->get();

        return response()->json(['information'=>$infosactionplanformations, 'butformations'=>$butformations]);

    }

    public function informationbeneficiaireformation($id)
    {

        $id =  Crypt::UrldeCrypt($id);

        $infosactionplanformations =  BeneficiairesFormation::where([['id_fiche_agrement','=',$id]])->get();

        return response()->json(['information'=>$infosactionplanformations]);

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        $logo = Menu::get_logo();

        if ($request->isMethod('put')) {
            $data = $request->all();
            //dd($data);

            if($data['action'] === 'CommentairePlanFormation'){

                $input1 = $request->all();
///dd($input1);
                $input['commentaire_plan_formation'] = $input1['commentaire_plan_formation'];
                $input['date_commentaire_plan_formation'] = Carbon::now();

                $planformation = PlanFormation::find($id);
                $planformation->update($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Instruction: Commentaire effectué avec succès.)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);
                return redirect('traitementplanformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Commentaire effectué avec succès. ');

            }

            if($data['action'] === 'Recevable'){
                /*$this->validate($request, [
                    'id_motif_recevable' => 'required'
                ],[
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);*/

                $input = $request->all();
                $dateanneeencours = Carbon::now()->format('Y');
                $input['id_user'] = Auth::user()->id;
                $input['user_conseiller'] = Auth::user()->id;
                $input['id_agence'] = Auth::user()->num_agce;
                $input['flag_recevablite_plan_formation'] = true;
                $input['conde_entreprise_plan_formation'] = 'fdfpentre' . Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
                $input['code_plan_formation'] =  substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                $input['date_recevabilite_plan_formatio'] = Carbon::now();

                $planformation = PlanFormation::find($id);
                $planformation->update($input);
                $planformation1 = PlanFormation::find($id);

                $infoentreprise = Entreprises::find($planformation1->id_entreprises);
                //dd($planformation1->contact_professionnel_charge_plan_formation);
                //Envoi SMS Validé
                if (isset($planformation1->contact_professionnel_charge_plan_formation)) {
                    $content = "Cher ".$infoentreprise->raison_social_entreprises.", NOUS SOMMES RAVIS DE VOUS INFORMER QUE VOTRE PLAN DE FORMATION EST JUGEE RECEVABLE. NOUS APPRECIONS VOTRE INTERET POUR NOS SERVICES. CORDIALEMENT, L EQUIPE E-FDFP";
                    SmsPerso::sendSMS($planformation1->contact_professionnel_charge_plan_formation,$content);
                }

                //Envoi email
                 if (isset($planformation1->email_professionnel_charge_plan_formation)) {
                    $sujet = "Recevabilité du plan de formation sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous sommes ravis de vous informer que votre plan de formation est jugé recevable.
                                    <br><br>Nous apprécions votre intérêt pour notre services.<br>
                                    Cordialement,
                                    L'équipe e-FDFP
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($planformation1->email_professionnel_charge_plan_formation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

                    //$messageMailEnvoi = Email::get_envoimailTemplate($planformation1->planformation1, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
                }


                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Instruction: Recevabilité effectué avec succès.)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

                return redirect('traitementplanformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Recevabilité effectué avec succès. ');


                //return redirect()->route('traitementplanformation.index')->with('success', 'Recevabilité effectué avec succès.');
            }

            if($data['action'] === 'NonRecevable'){

                $this->validate($request, [
                    'id_motif_recevable' => 'required'
                ],[
                    'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                ]);

                $input = $request->all();
                $dateanneeencours = Carbon::now()->format('Y');
                $input['id_user'] = Auth::user()->id;
                $input['user_conseiller'] = Auth::user()->id;
                $input['id_agence'] = Auth::user()->num_agce;
                $input['flag_recevablite_plan_formation'] = true;
                $input['flag_rejeter_plan_formation'] = true;
                $input['conde_entreprise_plan_formation'] = 'fdfpentre' . Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                $input['code_plan_formation'] = substr(Auth::user()->name,0,1).''.substr(Auth::user()->prenom_users,0,1).'-'. Gencode::randStrGen(4, 5).'-'. $dateanneeencours;
                $input['date_recevabilite_plan_formatio'] = Carbon::now();
                $input['date_rejet_paln_formation'] = Carbon::now();

                $planformation = PlanFormation::find($id);
                $planformation->update($input);

                $planformation1 = PlanFormation::find($id);

                $infoentreprise = Entreprises::find($planformation1->id_entreprises);

                if (isset($planformation1->email_professionnel_charge_plan_formation)) {
                    $sujet = "Recevabilité du plan de formation sur e-FDFP";
                    $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                    $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>
                                    <br><br>Nous avons examiné votre plan de formation sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

                                    <br><b>Motif de rejet  : </b> ".@$planformation1->motif->libelle_motif."
                                    <br><b>Commentaire : </b> ".@$planformation1->commentaire_recevable_plan_formation."
                                    <br><br>
                                    <br><br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
                                        fournir, n'hésitez pas à nous contacter à [Adresse e-mail du support] pour obtenir de l'aide.
                                        Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
                                        soumettre une nouvelle demande lorsque les problèmes seront résolus.
                                        Cordialement,
                                        L'équipe e-FDFP
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($planformation1->email_professionnel_charge_plan_formation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

                    //$messageMailEnvoi = Email::get_envoimailTemplate($planformation1->planformation1, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);
                }

                //Envoi SMS Rejeté
                if (isset($planformation1->contact_professionnel_charge_plan_formation)) {
                    $content = "Cher ".$infoentreprise->raison_social_entreprises."<br>, Nous avons examiné votre demande d'activation de compte sur Nom de la plateforme, et
                        malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :".@$planformation1->motif->libelle_motif."
                        <br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
                        fournir, n'hésitez pas à nous contacter à mailsupport... pour obtenir de l'aide.
                        Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
                        soumettre une nouvelle demande lorsque les problèmes seront résolus.<br>
                        Cordialement,
                        L'équipe e-FDFP";
                    SmsPerso::sendSMS($planformation1->contact_professionnel_charge_plan_formation,$content);
                }
//
                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Instruction: La non-recevabilité a été effectué avec succès.)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

                return redirect()->route('traitementplanformation.index')->with('success', 'Recevabilité effectué avec succès.');

            }

 /*            if($data['action'] === 'Traiter_action_formation'){

                dd($request);
                $actionplan = ActionFormationPlan::find($id);

                $idplan = $actionplan->id_plan_de_formation;

                //dd($idplan);

                $infosplanformation = PlanFormation::find($idplan);

                $part_entreprise = $infosplanformation->part_entreprise;
                $montant_financement_budget = $infosplanformation->montant_financement_budget;
                $utilisationfinancecompletaire = $montant_financement_budget-$part_entreprise;

                //----------------recuperation de la somme du montant du champ utilisation direct

                $utilisationdirectslignes = ActionFormationPlan::where([['id_plan_de_formation','=',$idplan]])->get();

                $montantutilisationdirects = 0;

                foreach ($utilisationdirectslignes as $actionplanformation){
                    $montantutilisationdirects += $actionplanformation->utilisation_direct_action_formation;
                }

                $montantutilisationdirect = $montantutilisationdirects;


                $this->validate($request, [
                    'cout_accorde_action_formation' => 'required',
                    'commentaire_action_formation' => 'required',
                ],[
                    'cout_accorde_action_formation.required' => 'Veuillez ajouter le montant accordé.',
                    'commentaire_action_formation.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $input = $request->all();
                //dd($input['cout_action_formation_plan']);
                //$planformationupadteinfos = PlanFormation::find($idplan);

                //$planformationupadteinfos->update($input);

                $input['cout_accorde_action_formation'] = str_replace(' ', '', $input['cout_accorde_action_formation']);

                if($input['cout_accorde_action_formation']==0){

                    $this->validate($request, [
                        'motif_non_financement_action_formation' => 'required'
                    ],[
                        'motif_non_financement_action_formation.required' => 'Veuillez selectionnez le motif de non financement.',
                    ]);

                    $input['flag_valide_action_formation_pl'] = true;

                    $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];


                    $actionplanupdate = ActionFormationPlan::find($id);

                    $nombredejour = $input['nombre_heure_action_formation_p']/8;

                    $input['nombre_jour_action_formation'] = $nombredejour;

                    //$infoscaracteristique = CaracteristiqueTypeFormation::find($actionplanupdate->id_caracteristique_type_formation);

                    $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

                    $input['cout_action_formation_plan'] = $actionplanupdate->cout_action_formation_plan;


                    if($infoscaracteristique->code_ctf == "CGF"){

                        $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_'];

                    }

                    if($infoscaracteristique->code_ctf == "CSF"){

                        $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati'];

                    }

                    if($infoscaracteristique->code_ctf == "CFD"){

                        $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                    }

                    if($infoscaracteristique->code_ctf == "CCEF"){

                        $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;

                    }

                    if($infoscaracteristique->code_ctf == "CSEF"){

                        $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                    }

                    $input['montant_attribuable_fdfp'] = $montantcoutactionattribuable;

                    $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                    if($coutaccordeactionformation > $montantcoutactionattribuable){
                        $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                    }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                        $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                    }else{
                        $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                    }

                    //dd($input['cout_accorde_action_formation'],$input['montant_attribuable_fdfp']);

                                    //--------mise des conditions

                if($montantutilisationdirect == $part_entreprise){
                    $input['utilisation_direct_action_formation'] = 0;
                    $input['finan_complemantaire_action_formation'] = $input['cout_accorde_action_formation'];
                }

                if ($montantutilisationdirect < $part_entreprise) {

                    $montantutilisationdirectrestcalcul =  $part_entreprise - $montantutilisationdirect;

                    if ($montantutilisationdirectrestcalcul < $input['cout_accorde_action_formation']) {

                        $montantutilisationdirectrest = $input['cout_accorde_action_formation'] - $montantutilisationdirectrestcalcul;

                        $input['utilisation_direct_action_formation'] = $montantutilisationdirectrestcalcul;
                        $input['finan_complemantaire_action_formation'] = $montantutilisationdirectrest;
                    }

                    if ($montantutilisationdirectrestcalcul == $input['cout_accorde_action_formation']) {

                        $montantutilisationdirectrest = $montantutilisationdirectrestcalcul/2;

                        $input['utilisation_direct_action_formation'] = $montantutilisationdirectrest;
                        $input['finan_complemantaire_action_formation'] = $montantutilisationdirectrest;
                    }

                    if ($montantutilisationdirectrestcalcul > $input['cout_accorde_action_formation']) {

                        //$montantutilisationdirectrest = $montantutilisationdirectrestcalcul/2;

                        $input['utilisation_direct_action_formation'] = $input['cout_accorde_action_formation'];
                        $input['finan_complemantaire_action_formation'] = 0;
                    }
                }

                    $input['flag_action_formation_plan_traite_instruction'] = true;
                    $input['date_action_formation_plan_traite_instruction'] = Carbon::now();

                    $actionplanupdate->update($input);

                    $infosficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$id]])->first();
                    $idficheagre = $infosficheagrement->id_fiche_agrement;
                    $infosfchieupdate = FicheADemandeAgrement::find($idficheagre);
                    $infosfchieupdate->update($input);

                }else{

                    $input['flag_valide_action_formation_pl'] = true;

                    $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];

                    $actionplanupdate = ActionFormationPlan::find($id);

                    $nombredejour = $input['nombre_heure_action_formation_p']/8;

                    $input['nombre_jour_action_formation'] = $nombredejour;

                    //$infoscaracteristique = CaracteristiqueTypeFormation::find($actionplanupdate->id_caracteristique_type_formation);

                    $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

                    $input['cout_action_formation_plan'] = $actionplanupdate->cout_action_formation_plan;


                    if($infoscaracteristique->code_ctf == "CGF"){

                        $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_'];

                    }

                    if($infoscaracteristique->code_ctf == "CSF"){

                        $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati'];

                    }

                    if($infoscaracteristique->code_ctf == "CFD"){

                        $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                    }

                    if($infoscaracteristique->code_ctf == "CCEF"){

                        $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;

                    }

                    if($infoscaracteristique->code_ctf == "CSEF"){

                        $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                    }

                    $input['montant_attribuable_fdfp'] = $montantcoutactionattribuable;

                    $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                    if($coutaccordeactionformation > $montantcoutactionattribuable){
                        $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                    }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                        $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                    }else{
                        $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                    }

                                    //--------mise des conditions

                if($montantutilisationdirect == $part_entreprise){
                    $input['utilisation_direct_action_formation'] = 0;
                    $input['finan_complemantaire_action_formation'] = $input['cout_accorde_action_formation'];
                }

                if ($montantutilisationdirect < $part_entreprise) {

                    $montantutilisationdirectrestcalcul =  $part_entreprise - $montantutilisationdirect;

                    if ($montantutilisationdirectrestcalcul < $input['cout_accorde_action_formation']) {

                        $montantutilisationdirectrest = $input['cout_accorde_action_formation'] - $montantutilisationdirectrestcalcul;

                        $input['utilisation_direct_action_formation'] = $montantutilisationdirectrestcalcul;
                        $input['finan_complemantaire_action_formation'] = $montantutilisationdirectrest;
                    }

                    if ($montantutilisationdirectrestcalcul == $input['cout_accorde_action_formation']) {

                        $montantutilisationdirectrest = $montantutilisationdirectrestcalcul/2;

                        $input['utilisation_direct_action_formation'] = $montantutilisationdirectrest;
                        $input['finan_complemantaire_action_formation'] = $montantutilisationdirectrest;
                    }

                    if ($montantutilisationdirectrestcalcul > $input['cout_accorde_action_formation']) {

                        //$montantutilisationdirectrest = $montantutilisationdirectrestcalcul/2;

                        $input['utilisation_direct_action_formation'] = $input['cout_accorde_action_formation'];
                        $input['finan_complemantaire_action_formation'] = 0;
                    }
                }

                    $input['flag_action_formation_plan_traite_instruction'] = true;
                    $input['date_action_formation_plan_traite_instruction'] = Carbon::now();

                    $actionplanupdate->update($input);

                    $infosficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$id]])->first();
                    $idficheagre = $infosficheagrement->id_fiche_agrement;
                    $infosfchieupdate = FicheADemandeAgrement::find($idficheagre);
                    $infosfchieupdate->update($input);


                    if(isset($input['id_but_formation'])){
                        $tab = $input['id_but_formation'];

                        if(count($tab)>=1){
                            $butagrements = FicheAgrementButFormation::where([['id_fiche_agrement','=',$idficheagre]])->get();

                            foreach ($butagrements as $butagrement) {
                                FicheAgrementButFormation::where([['id_fiche_a_agrement_but_formation','=',$butagrement->id_fiche_a_agrement_but_formation]])->delete();
                            }

                            foreach ($tab as $key => $value) {
                                //dd($value); exit;
                                FicheAgrementButFormation::create([
                                    'id_fiche_agrement'=> $idficheagre,
                                    'id_but_formation'=> $value,
                                    'flag_fiche_a_agrement_but_formation'=>true
                                ]);
                            }
                        }
                    }


                }

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Instruction: Action de plan de formation Traité.)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

                return redirect('traitementplanformation/'.Crypt::UrlCrypt($idplan).'/edit')->with('success', 'Succes : Action de plan de formation Traité ');
            } */

            if($data['action'] === 'Soumission_ct_plan_formation'){

                $actionformationvals = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

                $montantcouttotal = 0;

                foreach($actionformationvals as $actionformationval){
                    $montantcouttotal += $actionformationval->cout_accorde_action_formation;
                }

                PlanFormation::where('id_plan_de_formation',$id)->update([
                    'flag_soumis_ct_plan_formation' => true,
                    'cout_total_accorder_plan_formation' => $montantcouttotal,
                    'date_soumis_ct_plan_formation' => Carbon::now()
                ]);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Instruction: Plan de formation soumis au comite technique en ligne.)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

                return redirect()->route('traitementplanformation.index')->with('success', 'Succes : Plan de formation soumis ');

            }

            if($data['action'] === 'Traiter_action_formation_beneficiaire'){

                $ficheA = FicheADemandeAgrement::find($id);

                $idactionplanf = $ficheA->id_action_formation_plan;

                $actionplan = ActionFormationPlan::find($idactionplanf);

                $idplan = $actionplan->id_plan_de_formation;

                $data = $request->all();

               // dd($data);

                    $beneficiaires = ListePlanFormationSoumis::get_liste_beneficiare($id);

                    foreach ($beneficiaires as $beneficiaire) {

                        $id_beneficiaire_formation =  $data["id_beneficiaire_formation/$beneficiaire->id_beneficiaire_formation"];
                        $nom_prenoms =  $data["nom_prenoms/$beneficiaire->id_beneficiaire_formation"];
                        $genre =  $data["genre/$beneficiaire->id_beneficiaire_formation"];
                        $annee_naissance =  $data["annee_naissance/$beneficiaire->id_beneficiaire_formation"];
                        $nationalite =  $data["nationalite/$beneficiaire->id_beneficiaire_formation"];
                        $fonction =  $data["fonction/$beneficiaire->id_beneficiaire_formation"];
                        $categorie =  $data["categorie/$beneficiaire->id_beneficiaire_formation"];
                        $annee_embauche =  $data["annee_embauche/$beneficiaire->id_beneficiaire_formation"];
                        $matricule_cnps =  $data["matricule_cnps/$beneficiaire->id_beneficiaire_formation"];

                        $Majbeneficiaire = BeneficiairesFormation::find($id_beneficiaire_formation);

                        $inputMAJ['nom_prenoms'] = $nom_prenoms;
                        $inputMAJ['genre'] = $genre;
                        $inputMAJ['annee_naissance'] = $annee_naissance;
                        $inputMAJ['nationalite'] = $nationalite;
                        $inputMAJ['fonction'] = $fonction;
                        $inputMAJ['categorie'] = $categorie;
                        $inputMAJ['annee_embauche'] = $annee_embauche;
                        $inputMAJ['matricule_cnps'] = $matricule_cnps;

                        //dd($Majbeneficiaire,$inputMAJ);

                        $Majbeneficiaire->update($inputMAJ);

                    }


                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Instruction: Liste des beneficiaires mise a jour.)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

                return redirect('traitementplanformation/'.Crypt::UrlCrypt($idplan).'/edit')->with('success', 'Succes : Liste des beneficiaires mise a jour ');

            }

        }
    }


    public function traitementactionformation(Request $request, $id): JsonResponse
    {

       // if($data['action'] === 'Traiter_action_formation'){
             $id =  Crypt::UrldeCrypt($id);
           // dd($request->all());

            $actionplan = ActionFormationPlan::find($id);

            $idplan = $actionplan->id_plan_de_formation;

            //dd($idplan);

            $infosplanformation = PlanFormation::find($idplan);

            $part_entreprise = $infosplanformation->part_entreprise;
            $montant_financement_budget = $infosplanformation->montant_financement_budget;
            $utilisationfinancecompletaire = $montant_financement_budget-$part_entreprise;

            //----------------recuperation de la somme du montant du champ utilisation direct

            $utilisationdirectslignes = ActionFormationPlan::where([['id_plan_de_formation','=',$idplan]])->get();

            $montantutilisationdirects = 0;

            foreach ($utilisationdirectslignes as $actionplanformation){
                $montantutilisationdirects += $actionplanformation->utilisation_direct_action_formation;
            }

            $montantutilisationdirect = $montantutilisationdirects;


            $this->validate($request, [
                'cout_accorde_action_formation' => 'required',
                //'commentaire_action_formation' => 'required',
            ],[
                'cout_accorde_action_formation.required' => 'Veuillez ajouter le montant accordé.',
                //'commentaire_action_formation.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            //dd($input['cout_action_formation_plan']);
            //$planformationupadteinfos = PlanFormation::find($idplan);

            //$planformationupadteinfos->update($input);

            $input['cout_accorde_action_formation'] = str_replace(' ', '', $input['cout_accorde_action_formation']);

            if($input['cout_accorde_action_formation']==0){

                $this->validate($request, [
                    'motif_non_financement_action_formation' => 'required'
                ],[
                    'motif_non_financement_action_formation.required' => 'Veuillez selectionnez le motif de non financement.',
                ]);

                $input['flag_valide_action_formation_pl'] = true;

                $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];


                $actionplanupdate = ActionFormationPlan::find($id);

                $nombredejour = $input['nombre_heure_action_formation_p']/8;

                $input['nombre_jour_action_formation'] = $nombredejour;

                //$infoscaracteristique = CaracteristiqueTypeFormation::find($actionplanupdate->id_caracteristique_type_formation);

                $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

                $input['cout_action_formation_plan'] = $actionplanupdate->cout_action_formation_plan;


                if($infoscaracteristique->code_ctf == "CGF"){

                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_'];

                }

                if($infoscaracteristique->code_ctf == "CSF"){

                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati'];

                }

                if($infoscaracteristique->code_ctf == "CFD"){

                    $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                }

                if($infoscaracteristique->code_ctf == "CCEF"){

                    $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;

                }

                if($infoscaracteristique->code_ctf == "CSEF"){

                    $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                }

                $input['montant_attribuable_fdfp'] = $montantcoutactionattribuable;

                $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                if($coutaccordeactionformation > $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }else{
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }

                //dd($input['cout_accorde_action_formation'],$input['montant_attribuable_fdfp']);

                                //--------mise des conditions

            if($montantutilisationdirect == $part_entreprise){
                $input['utilisation_direct_action_formation'] = 0;
                $input['finan_complemantaire_action_formation'] = $input['cout_accorde_action_formation'];
            }

            if ($montantutilisationdirect < $part_entreprise) {

                $montantutilisationdirectrestcalcul =  $part_entreprise - $montantutilisationdirect;

                if ($montantutilisationdirectrestcalcul < $input['cout_accorde_action_formation']) {

                    $montantutilisationdirectrest = $input['cout_accorde_action_formation'] - $montantutilisationdirectrestcalcul;

                    $input['utilisation_direct_action_formation'] = $montantutilisationdirectrestcalcul;
                    $input['finan_complemantaire_action_formation'] = $montantutilisationdirectrest;
                }

                if ($montantutilisationdirectrestcalcul == $input['cout_accorde_action_formation']) {

                    $montantutilisationdirectrest = $montantutilisationdirectrestcalcul/2;

                    $input['utilisation_direct_action_formation'] = $montantutilisationdirectrest;
                    $input['finan_complemantaire_action_formation'] = $montantutilisationdirectrest;
                }

                if ($montantutilisationdirectrestcalcul > $input['cout_accorde_action_formation']) {

                    //$montantutilisationdirectrest = $montantutilisationdirectrestcalcul/2;

                    $input['utilisation_direct_action_formation'] = $input['cout_accorde_action_formation'];
                    $input['finan_complemantaire_action_formation'] = 0;
                }
            }

                $input['flag_action_formation_plan_traite_instruction'] = true;
                $input['date_action_formation_plan_traite_instruction'] = Carbon::now();

                $actionplanupdate->update($input);

                $infosficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$id]])->first();
                $idficheagre = $infosficheagrement->id_fiche_agrement;
                $infosfchieupdate = FicheADemandeAgrement::find($idficheagre);
                $infosfchieupdate->update($input);

            }else{

                $input['flag_valide_action_formation_pl'] = true;

                $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];

                $actionplanupdate = ActionFormationPlan::find($id);

                $nombredejour = $input['nombre_heure_action_formation_p']/8;

                $input['nombre_jour_action_formation'] = $nombredejour;

                //$infoscaracteristique = CaracteristiqueTypeFormation::find($actionplanupdate->id_caracteristique_type_formation);

                $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

                $input['cout_action_formation_plan'] = $actionplanupdate->cout_action_formation_plan;


                if($infoscaracteristique->code_ctf == "CGF"){

                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_groupe_action_formation_'];

                }

                if($infoscaracteristique->code_ctf == "CSF"){

                    $montantcoutactionattribuable = $infoscaracteristique->montant_ctf*$nombredejour*$input['nombre_stagiaire_action_formati'];

                }

                if($infoscaracteristique->code_ctf == "CFD"){

                    $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                }

                if($infoscaracteristique->code_ctf == "CCEF"){

                    $montantcoutactionattribuable = ($infoscaracteristique->montant_ctf*$input['nombre_groupe_action_formation_'] + $infoscaracteristique->cout_herbement_formateur_ctf)*$nombredejour;

                }

                if($infoscaracteristique->code_ctf == "CSEF"){

                    $montantcoutactionattribuable = $input['cout_action_formation_plan'];

                }

                $input['montant_attribuable_fdfp'] = $montantcoutactionattribuable;

                $coutaccordeactionformation = $input['cout_accorde_action_formation'];

                if($coutaccordeactionformation > $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $montantcoutactionattribuable;
                }elseif ($coutaccordeactionformation < $montantcoutactionattribuable){
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }else{
                    $input['cout_accorde_action_formation'] = $coutaccordeactionformation;
                }

                                //--------mise des conditions

            if($montantutilisationdirect == $part_entreprise){
                $input['utilisation_direct_action_formation'] = 0;
                $input['finan_complemantaire_action_formation'] = $input['cout_accorde_action_formation'];
            }

            if ($montantutilisationdirect < $part_entreprise) {

                $montantutilisationdirectrestcalcul =  $part_entreprise - $montantutilisationdirect;

                if ($montantutilisationdirectrestcalcul < $input['cout_accorde_action_formation']) {

                    $montantutilisationdirectrest = $input['cout_accorde_action_formation'] - $montantutilisationdirectrestcalcul;

                    $input['utilisation_direct_action_formation'] = $montantutilisationdirectrestcalcul;
                    $input['finan_complemantaire_action_formation'] = $montantutilisationdirectrest;
                }

                if ($montantutilisationdirectrestcalcul == $input['cout_accorde_action_formation']) {

                    $montantutilisationdirectrest = $montantutilisationdirectrestcalcul/2;

                    $input['utilisation_direct_action_formation'] = $montantutilisationdirectrest;
                    $input['finan_complemantaire_action_formation'] = $montantutilisationdirectrest;
                }

                if ($montantutilisationdirectrestcalcul > $input['cout_accorde_action_formation']) {

                    //$montantutilisationdirectrest = $montantutilisationdirectrestcalcul/2;

                    $input['utilisation_direct_action_formation'] = $input['cout_accorde_action_formation'];
                    $input['finan_complemantaire_action_formation'] = 0;
                }
            }

                $input['flag_action_formation_plan_traite_instruction'] = true;
                $input['date_action_formation_plan_traite_instruction'] = Carbon::now();

                $actionplanupdate->update($input);

                $infosficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$id]])->first();
                $idficheagre = $infosficheagrement->id_fiche_agrement;
                $infosfchieupdate = FicheADemandeAgrement::find($idficheagre);
                $infosfchieupdate->update($input);


                if(isset($input['id_but_formation'])){
                    $tab = $input['id_but_formation'];

                    if(count($tab)>=1){
                        $butagrements = FicheAgrementButFormation::where([['id_fiche_agrement','=',$idficheagre]])->get();

                        foreach ($butagrements as $butagrement) {
                            FicheAgrementButFormation::where([['id_fiche_a_agrement_but_formation','=',$butagrement->id_fiche_a_agrement_but_formation]])->delete();
                        }

                        foreach ($tab as $key => $value) {
                            //dd($value); exit;
                            FicheAgrementButFormation::create([
                                'id_fiche_agrement'=> $idficheagre,
                                'id_but_formation'=> $value,
                                'flag_fiche_a_agrement_but_formation'=>true
                            ]);
                        }
                    }
                }


            }

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'PLAN DE FORMATION (Instruction: Action de plan de formation Traité.)',

                'etat'=>'Succès',

                'objet'=>'PLAN DE FORMATION'

            ]);

            //return redirect('traitementplanformation/'.Crypt::UrlCrypt($idplan).'/edit')->with('success', 'Succes : Action de plan de formation Traité ');
        //}

        return response()->json(['success' => 'mise a jour effectué']);
    }

    public function traitementactionformationbenefiaire(Request $request, $id): JsonResponse
    {

        //if($data['action'] === 'Traiter_action_formation_beneficiaire'){

            $id =  Crypt::UrldeCrypt($id);

            $ficheA = FicheADemandeAgrement::find($id);

            $idactionplanf = $ficheA->id_action_formation_plan;

            $actionplan = ActionFormationPlan::find($idactionplanf);

            $idplan = $actionplan->id_plan_de_formation;

            $data = $request->all();

            //dd($data);


                $beneficiaires = ListePlanFormationSoumis::get_liste_beneficiare($id);

                foreach ($beneficiaires as $beneficiaire) {

                    $id_beneficiaire_formation =  $data["id_beneficiaire_formation/$beneficiaire->id_beneficiaire_formation"];
                    $nom_prenoms =  $data["nom_prenoms/$beneficiaire->id_beneficiaire_formation"];
                    $genre =  $data["genre/$beneficiaire->id_beneficiaire_formation"];
                    $annee_naissance =  $data["annee_naissance/$beneficiaire->id_beneficiaire_formation"];
                    $nationalite =  $data["nationalite/$beneficiaire->id_beneficiaire_formation"];
                    $fonction =  $data["fonction/$beneficiaire->id_beneficiaire_formation"];
                    $categorie =  $data["categorie/$beneficiaire->id_beneficiaire_formation"];
                    $annee_embauche =  $data["annee_embauche/$beneficiaire->id_beneficiaire_formation"];
                    $matricule_cnps =  $data["matricule_cnps/$beneficiaire->id_beneficiaire_formation"];

                    $Majbeneficiaire = BeneficiairesFormation::find($id_beneficiaire_formation);

                    $inputMAJ['nom_prenoms'] = $nom_prenoms;
                    $inputMAJ['genre'] = $genre;
                    $inputMAJ['annee_naissance'] = $annee_naissance;
                    $inputMAJ['nationalite'] = $nationalite;
                    $inputMAJ['fonction'] = $fonction;
                    $inputMAJ['categorie'] = $categorie;
                    $inputMAJ['annee_embauche'] = $annee_embauche;
                    $inputMAJ['matricule_cnps'] = $matricule_cnps;

                    //dd($Majbeneficiaire,$inputMAJ);

                    $Majbeneficiaire->update($inputMAJ);

                }


            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'PLAN DE FORMATION (Instruction: Liste des beneficiaires mise a jour.)',

                'etat'=>'Succès',

                'objet'=>'PLAN DE FORMATION'

            ]);

           // return redirect('traitementplanformation/'.Crypt::UrlCrypt($idplan).'/edit')->with('success', 'Succes : Liste des beneficiaires mise a jour ');

        //}

        return response()->json(['success' => 'mise a jour effectué']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
