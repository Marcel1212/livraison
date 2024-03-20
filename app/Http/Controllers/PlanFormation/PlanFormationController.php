<?php

namespace App\Http\Controllers\PlanFormation;

use App\Helpers\Audit;
use Illuminate\Http\Request;
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
use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Helpers\MoyenCotisation;
use App\Helpers\MasseSalarialeCotisation;
use App\Helpers\GrilleDeRepartitionFC;
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Helpers\AnneeExercice;
use App\Helpers\PartEntreprisesHelper;
use App\Models\CaracteristiqueTypeFormation;
use App\Models\SecteurActivite;
use App\Http\Controllers\Controller;

class PlanFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //if()
        //$infoentrprise = Entreprises::where([['ncc_entreprises','=',Auth::user()->login_users]])->first();
        $infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
        if(!empty($infoentrprise)){
            $planformations = PlanFormation::where([['id_entreprises','=',$infoentrprise->id_entreprises]])->orderByDesc('id_plan_de_formation')->get();
            Audit::logSave([

                'action'=>'INDEX',

                'code_piece'=>'',

                'menu'=>'PLAN DE FORMATION',

                'etat'=>'Succès',

                'objet'=>'PLAN DE FORMATION'

            ]);
            return view('planformations.planformation.index',compact('planformations'));
        }else{
            Audit::logSave([

                'action'=>'INDEX',

                'code_piece'=>'',

                'menu'=>'PLAN DE FORMATION',

                'etat'=>'Echec',

                'objet'=>'PLAN DE FORMATION'

            ]);
            return redirect('/dashboard')->with('Error', 'Erreur : Vous n\'est autoriser a acces a ce menu');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeentreprises = TypeEntreprise::where([['flag_type_entreprise','=',true]])->get();
        $typeentreprise = "<option value=''> Selectionnez le type d'entreprise </option>";
        foreach ($typeentreprises as $comp) {
            $typeentreprise .= "<option value='" . $comp->id_type_entreprise  . "'>" . mb_strtoupper($comp->lielle_type_entrepise) ." </option>";
        }

        $infoentreprise = Entreprises::where([['ncc_entreprises','=',Auth::user()->login_users]])->first();

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

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'PLAN DE FORMATION (Soumission de plan de formation)',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        return view('planformations.planformation.create', compact('infoentreprise','typeentreprise','pay','secteuractivites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'nom_prenoms_charge_plan_formati' => 'required',
                'fonction_charge_plan_formation' => 'required',
                'email_professionnel_charge_plan_formation' => 'required',
                //'nombre_salarie_plan_formation' => 'required',
                'id_type_entreprise' => 'required',
                'masse_salariale' => 'required',
                //'id_secteur_activite' => 'required',
            ],[
                'nom_prenoms_charge_plan_formati.required' => 'Veuillez ajouter une personne en charge de la formation.',
                'fonction_charge_plan_formation.required' => 'Veuillez ajouter la fonction de la personne en chrage de la formation.',
                'email_professionnel_charge_plan_formation.required' => 'Veuillez ajouter une adresse email.',
                //'nombre_salarie_plan_formation.required' => 'Veuillez ajouter le nombre de salarié.',
                'id_type_entreprise.unique' => 'Veuillez selectionnez un type d\'entreprise',
                'masse_salariale.required' => 'Veuillez ajouter la massse salariale.',
                //'id_secteur_activite.required' => 'Veuillez selectionner un secteur activité.',
            ]);

            $infoentrprise = Entreprises::where([['ncc_entreprises','=',Auth::user()->login_users]])->first();

           // $mttprevisionnelcotisation = MoyenCotisation::get_calcul_moyen_cotisation($infoentrprise->id_entreprises);

            $mttprevisionnelMassesalariale = MasseSalarialeCotisation::get_calcul_moyen_masse_salariale($infoentrprise->id_entreprises);

            $verfi_cotisation = MoyenCotisation::get_verif_cotisation($infoentrprise->id_entreprises);

            if($verfi_cotisation==0){
                Audit::logSave([

                    'action'=>'CREER',

                    'code_piece'=>'',

                    'menu'=>'PLAN DE FORMATION (Soumission de plan de formation: Plan de formation non soumis car nous n\etes pas a jour dans les cotisations )',

                    'etat'=>'Echec',

                    'objet'=>'PLAN DE FORMATION'

                ]);
                return redirect()->route('planformation.index')->with('error', 'Plan de formation non soumis car nous n\etes pas a jour dans les cotisations.');
            }

            $input = $request->all();

            $input['date_creation'] = Carbon::now();
            $input['id_entreprises'] = $infoentrprise->id_entreprises;
            $input['nom_prenoms_charge_plan_formati'] = mb_strtoupper($input['nom_prenoms_charge_plan_formati']);
            $input['fonction_charge_plan_formation'] = mb_strtoupper($input['fonction_charge_plan_formation']);
            $part = PartEntreprisesHelper::get_part_entreprise();
            $input['id_part_entreprise'] = $part->id_part_entreprise;
            $input['part_entreprise'] = $input['masse_salariale'] * $part->valeur_part_entreprise;
            $entreprise = Entreprises::find($infoentrprise->id_entreprises);
            $entreprise->update($input);

            $partEntreprise = $input['masse_salariale'] * $part->valeur_part_entreprise;

            $buget = GrilleDeRepartitionFC::get_calcul_financement($partEntreprise);
            //dd($buget);
            $bugetseparer = explode("/",$buget);
            //dd($bugetseparer);
            $input['id_cle_de_repartition_financement'] = $bugetseparer[1];
            $input['montant_financement_budget'] = round($bugetseparer[0]);
            $input['masse_salariale_previsionel'] = $mttprevisionnelMassesalariale;
            $input['part_entreprise_previsionnel'] = $mttprevisionnelMassesalariale * $part->valeur_part_entreprise;

            PlanFormation::create($input);

            $insertedId = PlanFormation::latest()->first()->id_plan_de_formation;

            if ($input['action'] == 'Enregister'){

                Audit::logSave([

                    'action'=>'ENREGISTER',

                    'code_piece'=>'',

                    'menu'=>'PLAN DE FORMATION (Soumission de plan de formation)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

                return redirect('planformation/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }

            if ($input['action'] == 'Enregistrer_suivant'){

                Audit::logSave([

                    'action'=>'ENREGISTER',

                    'code_piece'=>'',

                    'menu'=>'PLAN DE FORMATION (Soumission de plan de formation)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

                return redirect('planformation/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }
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

        if ($idVal != null) {
            $actionplan = ActionFormationPlan::find($idVal);
            $ficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->first();
            $beneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();
            $planformation = PlanFormation::where([['id_plan_de_formation','=',$actionplan->id_plan_de_formation]])->first();
        }

        Audit::logSave([

            'action'=>'CONSULTER',

            'code_piece'=>'',

            'menu'=>'PLAN DE FORMATION (Soumission de plan de formation)',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        //dd($planformation);
        return view('planformations.planformation.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $id1)
    {

        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
//dd($id);
        $planformation = PlanFormation::find($id);
        $infoentreprise = Entreprises::find($planformation->id_entreprises);

        $typeentreprises = TypeEntreprise::where([['flag_type_entreprise','=',true]])->get();
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
        $butformations = ButFormation::where([['flag_actif_but_formation','=',true]])->get();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }

        $typeformations = TypeFormation::where([['flag_actif_formation','=',true]])->get();
        $typeformation = "<option value=''> Selectionnez le type  de la formation </option>";
        foreach ($typeformations as $comp) {
            $typeformation .= "<option value='" . $comp->id_type_formation  . "'>" . mb_strtoupper($comp->type_formation) ." </option>";
        }

        $categorieprofessionelles = CategorieProfessionelle::all();
        $categorieprofessionelle = "<option value=''> Selectionnez la categorie </option>";
        foreach ($categorieprofessionelles as $comp) {
            $categorieprofessionelle .= "<option value='" . $comp->id_categorie_professionelle  . "'>" . mb_strtoupper($comp->categorie_profeessionnelle) ." </option>";
        }

        $structureformations = Entreprises::where([['flag_habilitation_entreprise','=',true]])->get();
        $structureformation = "<option value=''> Selectionnez la structrue de formation </option>";
        foreach ($structureformations as $comp) {
            $structureformation .= "<option value='" . $comp->id_entreprises  . "'>" .mb_strtoupper($comp->ncc_entreprises) .' / '.mb_strtoupper($comp->raison_social_entreprises)." </option>";
        }

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

        $montantactionplanformation = 0;

        foreach ($actionplanformations as $actionplanformation){
            $montantactionplanformation += $actionplanformation->cout_action_formation_plan;
        }

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id]])->get();

        /******************** secteuractivites *********************************/
        $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
            ->orderBy('libelle_secteur_activite')
            ->get();

            Audit::logSave([

                'action'=>'MODIFIER',

                'code_piece'=>$id,

                'menu'=>'PLAN DE FORMATION (Soumission de plan de formation)',

                'etat'=>'Succès',

                'objet'=>'PLAN DE FORMATION'

            ]);

        return view('planformations.planformation.edit', compact('planformation','infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations','categorieprofessionelle','categorieplans','structureformation','idetape','secteuractivites','paysc','montantactionplanformation'));

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
                    'nom_prenoms_charge_plan_formati' => 'required',
                    'fonction_charge_plan_formation' => 'required',
                    'email_professionnel_charge_plan_formation' => 'required',
                    //'nombre_salarie_plan_formation' => 'required',
                    'id_type_entreprise' => 'required',
                    'masse_salariale' => 'required',
                    //'id_secteur_activite' => 'required',
                ],[
                    'nom_prenoms_charge_plan_formati.required' => 'Veuillez ajouter une personne en charge de la formation.',
                    'fonction_charge_plan_formation.required' => 'Veuillez ajouter la fonction de la personne en chrage de la formation.',
                    'email_professionnel_charge_plan_formation.required' => 'Veuillez ajouter une adresse email.',
                    //'nombre_salarie_plan_formation.required' => 'Veuillez ajouter le nombre de salarié.',
                    'id_type_entreprise.unique' => 'Veuillez selectionnez un type d\'entreprise',
                    'masse_salariale.required' => 'Veuillez ajouter la massse salariale.',
                    //'id_secteur_activite.required' => 'Veuillez selectionner un secteur activité.',
                ]);

                $input = $request->all();

                //$infoentrprise = Entreprises::where([['ncc_entreprises','=',Auth::user()->login_users]])->first();

                $planformation = PlanFormation::find($id);
                $infoentreprise = Entreprises::find($planformation->id_entreprises);


                //$input['localisation_geographique_entreprise'] = mb_strtoupper($input['localisation_geographique_entreprise']);
                //$input['repere_acces_entreprises'] = mb_strtoupper($input['repere_acces_entreprises']);
                //$input['adresse_postal_entreprises'] = mb_strtoupper($input['adresse_postal_entreprises']);
                //$input['cellulaire_professionnel_entreprises'] = mb_strtoupper($input['cellulaire_professionnel_entreprises']);
                $input['nom_prenoms_charge_plan_formati'] = mb_strtoupper($input['nom_prenoms_charge_plan_formati']);
                $input['fonction_charge_plan_formation'] = mb_strtoupper($input['fonction_charge_plan_formation']);
                $part = PartEntreprisesHelper::get_part_entreprise();
                $input['id_part_entreprise'] = $part->id_part_entreprise;
                $input['part_entreprise'] = $input['masse_salariale'] * $part->valeur_part_entreprise;
                //$input['part_entreprise'] = $input['masse_salariale'] * 0.006;
                $partEntreprise = $input['masse_salariale'] * $part->valeur_part_entreprise;

                $buget = GrilleDeRepartitionFC::get_calcul_financement($partEntreprise);
                //dd($buget);
                $bugetseparer = explode("/",$buget);
                //dd($bugetseparer);
                $input['id_cle_de_repartition_financement'] = $bugetseparer[1];
                $input['montant_financement_budget'] = round($bugetseparer[0]);

                $infoentreprise->update($input);
                $planformation->update($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'PLAN DE FORMATION (Soumission de plan de formation)',

                    'etat'=>'Succès',

                    'objet'=>'PLAN DE FORMATION'

                ]);

                return redirect('planformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Enregistrer_categorie_plan'){
                $this->validate($request, [
                    'id_categorie_professionelle' => 'required',
                    'genre_plan' => 'required',
                    'nombre_plan' => 'required',
                ],[
                    'id_categorie_professionelle.required' => 'Veuillez selectionnez la categorieprefessionnelle.',
                    'genre_plan.required' => 'Veuillez selectionnez le genre.',
                    'nombre_plan.required' => 'Veuillez ajoutez le nombre',
                ]);

                $input = $request->all();

                $input['id_plan_de_formation'] = $id;

                $verficategoriepaln = CategoriePlan::where([['id_plan_de_formation','=',$id],['id_categorie_professionelle','=',$input['id_categorie_professionelle']],['genre_plan','=',$input['genre_plan']]])->get();
//dd($verficategoriepaln);
                if(count($verficategoriepaln)==0){

                    CategoriePlan::create($input);

                    $listecategorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id]])->get();

                    $nombretotalsalarie = 0;

                    foreach($listecategorieplans as $listecategorieplan){
                        $nombretotalsalarie += $listecategorieplan->nombre_plan;
                    }

                    PlanFormation::where('id_plan_de_formation',$id)->update([
                        'nombre_salarie_plan_formation' => $nombretotalsalarie
                    ]);

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'PLAN DE FORMATION (Soumission de plan de formation)',

                        'etat'=>'Succès',

                        'objet'=>'PLAN DE FORMATION'

                    ]);

                    return redirect('planformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Operation reussi. ');

                }else{

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : La ligne du nombre de salarie a deja ete saisie.)',

                        'etat'=>'Echec',

                        'objet'=>'PLAN DE FORMATION'

                    ]);

                    return redirect('planformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('error', 'Erreur : Cela a deja ete saisie. ');
                }


            }

            if ($data['action'] == 'Enregistrer_soumettre_plan_formation'){
                $anneexercice = AnneeExercice::get_annee_exercice();
                if(isset($anneexercice->id_periode_exercice)){

                    $actionformationvals = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

                    $montantcouttotal = 0;

                    foreach($actionformationvals as $actionformationval){
                        $montantcouttotal += $actionformationval->cout_action_formation_plan;
                    }

                    PlanFormation::where('id_plan_de_formation',$id)->update([
                        'flag_soumis_plan_formation' => true,
                        'cout_total_demande_plan_formation' => $montantcouttotal,
                        'id_annee_exercice' => $anneexercice->id_periode_exercice,
                        'date_soumis_plan_formation' => Carbon::now()
                    ]);

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : Plan de formation soumis avec succès.)',

                        'etat'=>'Succès',

                        'objet'=>'PLAN DE FORMATION'

                    ]);

                    return redirect()->route('planformation.index')->with('success', 'Plan de formation soumis avec succès.');
                }else{

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : Plan de formation non soumis car l\'annee d\'execrcie n\'est pas encore ouver)',

                        'etat'=>'Echec',

                        'objet'=>'PLAN DE FORMATION'

                    ]);

                    return redirect()->route('planformation.index')->with('error', 'Plan de formation non soumis car l\'annee d\'execrcie n\'est pas encore ouvert.');
                }


            }

            if ($data['action'] == 'Enregistrer_action_formation'){
                dd($data);
                $this->validate($request, [
                    'intitule_action_formation_plan' => 'required',
                    'id_entreprise_structure_formation_plan_formation' => 'required',
                    'id_caracteristique_type_formation' => 'required',
                    //'nombre_stagiaire_action_formati' => 'required',
                    'nombre_groupe_action_formation_' => 'required',
                    'nombre_heure_action_formation_p' => 'required',
                    'cout_action_formation_plan' => 'required',
                    'id_type_formation' => 'required',
                    'id_but_formation' => 'required',
                    //'date_debut_fiche_agrement' => 'required|date|after_or_equal:now',
                    //'date_fin_fiche_agrement' => 'required|date|after:date_debut_fiche_agrement',
                    'lieu_formation_fiche_agrement' => 'required',
                    //'cout_total_fiche_agrement' => 'required',
                    'objectif_pedagogique_fiche_agre' => 'required',
                    'cadre_fiche_demande_agrement' => 'required',
                    'agent_maitrise_fiche_demande_ag' => 'required',
                    'employe_fiche_demande_agrement' => 'required',
                    'id_secteur_activite' => 'required',
                    'file_beneficiare' => 'required|mimes:xlsx,XLSX|max:5120',
                    'facture_proforma_action_formati' => 'required|mimes:pdf,PDF,png,jpg,jpeg,PNG,JPG,JPEG|max:5120'
                ],[
                    'intitule_action_formation_plan.required' => 'Veuillez ajoutez l\'intitule de l\'action.',
                    'id_caracteristique_type_formation.required' => 'Veuillez sélectionner une caractéristique.',
                    'id_entreprise_structure_formation_plan_formation.required' => 'Veuillez ajoutez une structure ou etablissement.',
                    //'nombre_stagiaire_action_formati.required' => 'Veuillez ajoutez le nombre de stagiaire.',
                    'nombre_groupe_action_formation_.required' => 'Veuillez ajoutez le nombre de groupe.',
                    'nombre_heure_action_formation_p.required' => 'Veuillez ajoutez le nombre d\'heure.',
                    'cout_action_formation_plan.required' => 'Veuillez ajoutez le cout de la formation.',
                    'id_type_formation.required' => 'Veuillez selectionnez un type de formation.',
                    'id_but_formation.required' => 'Veuillez selectionnez le but de la formation.',
                    //'date_debut_fiche_agrement.required' => 'Veuillez ajoutez la date de debut',
                    //'date_debut_fiche_agrement.date' => 'Cela doit etre une date valide',
                    //'date_debut_fiche_agrement.after_or_equal' => 'Vous ne pouvez pas choisir une date inférieure à celle du jour.',
                    //'date_fin_fiche_agrement.required' => 'Veuillez ajoutez la date de fin .',
                    //'date_fin_fiche_agrement.date' => 'Cela doit etre une date valide',
                    //'date_fin_fiche_agrement.after' => 'Vous ne pouvez pas choisir une date inférieure a la date de debut',
                    'lieu_formation_fiche_agrement.required' => 'Veuillez ajoutez le lieu de formation.',
                    //'cout_total_fiche_agrement.required' => 'Veuillez ajoutez le cout total de la fiche d\'agrement.',
                    'objectif_pedagogique_fiche_agre.required' => 'Veuillez ajoutez l\'objectif pedagogique.',
                    'cadre_fiche_demande_agrement.required' => 'Veuillez ajoutez le nombre de cadre.',
                    'agent_maitrise_fiche_demande_ag.required' => 'Veuillez ajoutez le nombre d\'agent de maitrise.',
                    'employe_fiche_demande_agrement.required' => 'Veuillez ajoutez le nombre d\employe .',
                    'id_secteur_activite.required' => 'Veuillez selectionner un secteur activité.',
                    'file_beneficiare.required' => 'Veuillez ajoutez le fichier excel contenant la liste des beneficiaires.',
                    'facture_proforma_action_formati.required' => 'Veuillez ajoutez la massse salariale.',
                    'file_beneficiare.mimes' => 'Les formats requises pour le fichier excel contenant la liste des beneficiaires est: xlsx,XLSX.',
                    'file_beneficiare.max'=> 'la taille maximale doit etre 5 MegaOctets.',
                    'facture_proforma_action_formati.mimes' => 'Les formats requises pour la proformat est: PDF,PNG,JPG,JPEG.',
                    'facture_proforma_action_formati.max'=> 'la taille maximale doit etre 5 MegaOctets.',
                ]);

                $data = $request->all();

                $input = $request->all();

                //dd($input);

                $nombreactionplan = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

                $rccentreprisehabilitation = Entreprises::where([['id_entreprises','=',$input['id_entreprise_structure_formation_plan_formation']]])->first();

                $input['id_entreprise_structure_formation_action'] = $input['id_entreprise_structure_formation_plan_formation'];
                $input['nombre_stagiaire_action_formati'] = $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'] + $input['cadre_fiche_demande_agrement'];
                $input['intitule_action_formation_plan'] = mb_strtoupper($input['intitule_action_formation_plan']);
                $input['structure_etablissement_action_'] = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);
                $input['lieu_formation_fiche_agrement'] = mb_strtoupper($input['lieu_formation_fiche_agrement']);
                $input['objectif_pedagogique_fiche_agre'] = mb_strtoupper($input['objectif_pedagogique_fiche_agre']);
                $input['id_plan_de_formation'] = $id;
                $input['pirorite_action_formation'] = count($nombreactionplan)+1;

                $input['cout_action_formation_plan'] = str_replace(' ', '', $input['cout_action_formation_plan']);

                if (isset($data['file_beneficiare'])){

                    $file = $data['file_beneficiare'];

                    $collections = (new FastExcel)->import($file);

                    //dd(count($collections));

                    if (count($collections)>$input['nombre_stagiaire_action_formati']){

                        //return redirect('planformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Succes : Le nombre de bénéficiaires de l\'action de formation est supérieur au nombre saisi ');
                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : Le nombre de bénéficiaires de l\'action de formation est supérieur au nombre saisi.)',

                            'etat'=>'Echec',

                            'objet'=>'PLAN DE FORMATION'

                        ]);
                        return redirect()->route('planformation.edit', [Crypt::UrlCrypt($id),Crypt::UrlCrypt($idetape)])->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est supérieur au nombre saisi ']);
                    }

                    if (count($collections)<$input['nombre_stagiaire_action_formati']){

                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : Le nombre de bénéficiaires de l\'action de formation est inférieur au nombre saisi.)',

                            'etat'=>'Echec',

                            'objet'=>'PLAN DE FORMATION'

                        ]);
                        //return redirect('planformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Succes : Le nombre de bénéficiaires de l\'action de formation est inférieur au nombre saisi ');
                        return redirect()->route('planformation.edit', [Crypt::UrlCrypt($id),Crypt::UrlCrypt($idetape)])->withErrors(['error' => 'Erreur : Le nombre de bénéficiaires de l\'action de formation est inférieur au nombre saisi ']);
                    }
                }

                $planformationbg = PlanFormation::find($id);

                $actionplanformationbgs = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

                $montantactionplanformationbg = 0;

                foreach ($actionplanformationbgs as $actionplanformation){
                    $montantactionplanformationbg += $actionplanformation->cout_action_formation_plan;
                }

                $budgetrestant = $planformationbg->montant_financement_budget - $montantactionplanformationbg;

                if($input['cout_action_formation_plan']>$budgetrestant){

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : Le coût de cette formation est plus élevé que le budget restant.)',

                        'etat'=>'Echec',

                        'objet'=>'PLAN DE FORMATION'

                    ]);

                    return redirect()->route('planformation.edit', [Crypt::UrlCrypt($id),Crypt::UrlCrypt($idetape)])->withErrors(['error' => 'Erreur : Le coût de cette formation est plus élevé que le budget restant. ']);

                }

                $nombredejour = $input['nombre_heure_action_formation_p']/8;

                $input['nombre_jour_action_formation'] = $nombredejour;

                $infoscaracteristique = CaracteristiqueTypeFormation::find($input['id_caracteristique_type_formation']);

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

                if (isset($data['facture_proforma_action_formati'])){

                    $filefront = $data['facture_proforma_action_formati'];

                    //dd($filefront->extension());

                    if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                    || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                    || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){

                        $fileName1 = 'facture_proforma_action_formati'. '_' . rand(111,99999) . '_' . 'facture_proforma_action_formati' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/facture_proforma_action_formation/'), $fileName1);

                        $input['facture_proforma_action_formati'] = $fileName1;
                    }

                }

                ActionFormationPlan::create($input);

                $insertedIdActionPlanFormation = ActionFormationPlan::latest()->first()->id_action_formation_plan;

                $input['id_action_formation_plan'] = $insertedIdActionPlanFormation;
                $input['cout_total_fiche_agrement'] = $input['cout_action_formation_plan'];

                FicheADemandeAgrement::create($input);

                $insertedIdFicheAgrement = FicheADemandeAgrement::latest()->first()->id_fiche_agrement;

                if (isset($data['file_beneficiare'])){

                    $file = $data['file_beneficiare'];

                    //dd($file);

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

               if (isset($data['file_beneficiare'])){

                    $filefront = $data['file_beneficiare'];

                    if($filefront->extension() == "xlsx"  || $filefront->extension() == "XLSX"){

                        $fileName1 = 'file_beneficiare'. '_' . rand(111,99999) . '_' . 'file_beneficiare' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/fichier_beneficiaire_lie_aux_action_plan_formation/'), $fileName1);

                        $input['file_beneficiare_fiche_agrement'] = $fileName1;

                        FicheADemandeAgrement::where('id_fiche_agrement',$insertedIdFicheAgrement)->update([
                            'file_beneficiare_fiche_agrement' => $fileName1
                        ]);
                    }
               }

               Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : Action de plan de formation ajouté.)',

                'etat'=>'Succès',

                'objet'=>'PLAN DE FORMATION'

            ]);

               return redirect('planformation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Action de plan de formation ajouté ');


            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $idVal = Crypt::UrldeCrypt($id);
//dd($idVal);
            $actionplan = ActionFormationPlan::find($idVal);
            $idplanformation = $actionplan->id_plan_de_formation;
            $ficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->first();
            $beneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();

            foreach($beneficiaires as $beneficiaire){
                BeneficiairesFormation::where([['id_beneficiaire_formation','=',$beneficiaire->id_beneficiaire_formation]])->delete();
            }

            FicheADemandeAgrement::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->delete();
            ActionFormationPlan::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->delete();

            Audit::logSave([

                'action'=>'SUPPRIMER',

                'code_piece'=>$idplanformation,

                'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : Action de plan de formation supprimer avec succesé.)',

                'etat'=>'Succès',

                'objet'=>'PLAN DE FORMATION'

            ]);

            return redirect('planformation/'.Crypt::UrlCrypt($idplanformation).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Action de plan de formation supprimer avec succes ');

    }

    public function deleteapf($id)
    {
        $idVal = Crypt::UrldeCrypt($id);
//dd($idVal);
            $actionplan = ActionFormationPlan::find($idVal);
            $idplanformation = $actionplan->id_plan_de_formation;
            $ficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->first();
            $beneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();

            foreach($beneficiaires as $beneficiaire){
                BeneficiairesFormation::where([['id_beneficiaire_formation','=',$beneficiaire->id_beneficiaire_formation]])->delete();
            }

            FicheADemandeAgrement::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->delete();
            ActionFormationPlan::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->delete();

            Audit::logSave([

                'action'=>'SUPPRIMER',

                'code_piece'=>$idplanformation,

                'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : Action de plan de formation supprimer avec succes.)',

                'etat'=>'Succès',

                'objet'=>'PLAN DE FORMATION'

            ]);

            return redirect('planformation/'.Crypt::UrlCrypt($idplanformation).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Action de plan de formation supprimer avec succes ');

    }

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $categorieplan = CategoriePlan::find($idVal);
        $idplanformation = $categorieplan->id_plan_de_formation;
        CategoriePlan::where([['id_categorie_plan','=',$idVal]])->delete();

        $listecategorieplans = CategoriePlan::where([['id_plan_de_formation','=',$idplanformation]])->get();

        $nombretotalsalarie = 0;

        foreach($listecategorieplans as $listecategorieplan){
            $nombretotalsalarie += $listecategorieplan->nombre_plan;
        }

        PlanFormation::where('id_plan_de_formation',$idplanformation)->update([
            'nombre_salarie_plan_formation' => $nombretotalsalarie
        ]);

        Audit::logSave([

            'action'=>'SUPPRIMER',

            'code_piece'=>$idplanformation,

            'menu'=>'PLAN DE FORMATION (Soumission de plan de formation : La categorie des traivailleurs à été  supprimer avec succes.)',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        return redirect('planformation/'.Crypt::UrlCrypt($idplanformation).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : La categorie des traivailleurs à été  supprimer avec succes ');
    }

}
