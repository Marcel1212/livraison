<?php

namespace App\Http\Controllers;

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
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Helpers\AnneeExercice;


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
            $planformations = PlanFormation::where([['id_entreprises','=',$infoentrprise->id_entreprises]])->get();
            return view('planformation.index',compact('planformations'));
        }else{
            return redirect('/dashboard')->with('Error', 'Erreur : Vous n\'est autoriser a acces a ce menu');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeentreprises = TypeEntreprise::all();
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


        return view('planformation.create', compact('infoentreprise','typeentreprise','pay'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'localisation_geographique_entreprise' => 'required',
                'repere_acces_entreprises' => 'required',
                'adresse_postal_entreprises' => 'required',
                'cellulaire_professionnel_entreprises' => 'required',
                'nom_prenoms_charge_plan_formati' => 'required',
                'fonction_charge_plan_formation' => 'required',
                'email_professionnel_charge_plan_formation' => 'required',
                'nombre_salarie_plan_formation' => 'required',
                'id_type_entreprise' => 'required',
                'tel_entreprises' => 'required',
                'masse_salariale' => 'required'
            ],[
                'localisation_geographique_entreprise.required' => 'Veuillez ajouter votre localisation.',
                'repere_acces_entreprises.required' => 'Veuillez ajouter un repere d\'accès.',
                'adresse_postal_entreprises.required' => 'Veuillez ajouter une adresse postale.',
                'cellulaire_professionnel_entreprises.required' => 'Veuillez ajouter un contact cellulaire.',
                'tel_entreprises.required' => 'Veuillez ajouter un contact telephonique.',
                'nom_prenoms_charge_plan_formati.required' => 'Veuillez ajouter une personne en charge de la formation.',
                'fonction_charge_plan_formation.required' => 'Veuillez ajouter la fonction de la personne en chrage de la formation.',
                'email_professionnel_charge_plan_formation.required' => 'Veuillez ajouter une adresse email.',
                'nombre_salarie_plan_formation.required' => 'Veuillez ajouter le nombre de salarié.',
                'id_type_entreprise.unique' => 'Veuillez selectionnez un type d\'entreprise',
                'masse_salariale.required' => 'Veuillez ajouter la massse salariale.',
            ]);


            $input = $request->all();

            $infoentrprise = Entreprises::where([['ncc_entreprises','=',Auth::user()->login_users]])->first();

            $input['date_creation'] = Carbon::now();
            $input['id_entreprises'] = $infoentrprise->id_entreprises;
            $input['localisation_geographique_entreprise'] = mb_strtoupper($input['localisation_geographique_entreprise']);
            $input['repere_acces_entreprises'] = mb_strtoupper($input['repere_acces_entreprises']);
            $input['adresse_postal_entreprises'] = mb_strtoupper($input['adresse_postal_entreprises']);
            $input['cellulaire_professionnel_entreprises'] = mb_strtoupper($input['cellulaire_professionnel_entreprises']);
            $input['nom_prenoms_charge_plan_formati'] = mb_strtoupper($input['nom_prenoms_charge_plan_formati']);
            $input['fonction_charge_plan_formation'] = mb_strtoupper($input['fonction_charge_plan_formation']);
            $input['part_entreprise'] = $input['masse_salariale'] * 0.006;

            $entreprise = Entreprises::find($infoentrprise->id_entreprises);
            $entreprise->update($input);

            PlanFormation::create($input);

            $insertedId = PlanFormation::latest()->first()->id_plan_de_formation;

            return redirect('planformation/'.Crypt::UrlCrypt($insertedId).'/edit')->with('success', 'Succes : Enregistrement reussi ');

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

        //dd($planformation);
        return view('planformation.show', compact(  'actionplan','ficheagrement', 'beneficiaires','planformation'));
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

        $structureformations = Entreprises::where([['flag_habilitation_entreprise','=',true]])->get();
        $structureformation = "<option value=''> Selectionnez la structrue de formation </option>";
        foreach ($structureformations as $comp) {
            $structureformation .= "<option value='" . $comp->id_entreprises  . "'>" .mb_strtoupper($comp->ncc_entreprises) .' / '.mb_strtoupper($comp->raison_social_entreprises)." </option>";
        }

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id]])->get();

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id]])->get();



        return view('planformation.edit', compact('planformation','infoentreprise','typeentreprise','pay','typeformation','butformation','actionplanformations','categorieprofessionelle','categorieplans','structureformation'));

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
                    'localisation_geographique_entreprise' => 'required',
                    'repere_acces_entreprises' => 'required',
                    'adresse_postal_entreprises' => 'required',
                    'cellulaire_professionnel_entreprises' => 'required',
                    'nom_prenoms_charge_plan_formati' => 'required',
                    'fonction_charge_plan_formation' => 'required',
                    'email_professionnel_charge_plan_formation' => 'required',
                    'nombre_salarie_plan_formation' => 'required',
                    'id_type_entreprise' => 'required',
                    'masse_salariale' => 'required'
                ],[
                    'localisation_geographique_entreprise.required' => 'Veuillez ajouter votre localisation.',
                    'repere_acces_entreprises.required' => 'Veuillez ajouter un repere d\'accès.',
                    'adresse_postal_entreprises.required' => 'Veuillez ajouter une adresse postale.',
                    'cellulaire_professionnel_entreprises.required' => 'Veuillez ajouter un contact cellulaire.',
                    'nom_prenoms_charge_plan_formati.required' => 'Veuillez ajouter une personne en charge de la formation.',
                    'fonction_charge_plan_formation.required' => 'Veuillez ajouter la fonction de la personne en chrage de la formation.',
                    'email_professionnel_charge_plan_formation.required' => 'Veuillez ajouter une adresse email.',
                    'nombre_salarie_plan_formation.required' => 'Veuillez ajouter le nombre de salarié.',
                    'id_type_entreprise.unique' => 'Veuillez selectionnez un type d\'entreprise',
                    'masse_salariale.required' => 'Veuillez ajouter la massse salariale.',
                ]);

                $input = $request->all();

                //$infoentrprise = Entreprises::where([['ncc_entreprises','=',Auth::user()->login_users]])->first();

                $planformation = PlanFormation::find($id);
                $infoentreprise = Entreprises::find($planformation->id_entreprises);


                $input['localisation_geographique_entreprise'] = mb_strtoupper($input['localisation_geographique_entreprise']);
                $input['repere_acces_entreprises'] = mb_strtoupper($input['repere_acces_entreprises']);
                $input['adresse_postal_entreprises'] = mb_strtoupper($input['adresse_postal_entreprises']);
                $input['cellulaire_professionnel_entreprises'] = mb_strtoupper($input['cellulaire_professionnel_entreprises']);
                $input['nom_prenoms_charge_plan_formati'] = mb_strtoupper($input['nom_prenoms_charge_plan_formati']);
                $input['fonction_charge_plan_formation'] = mb_strtoupper($input['fonction_charge_plan_formation']);
                $input['part_entreprise'] = $input['masse_salariale'] * 0.006;

                $infoentreprise->update($input);
                $planformation->update($input);

                return redirect('planformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Enregistrer_categorie_plan'){
                $this->validate($request, [
                    'id_categorie_professionelle' => 'required',
                    'genre_plan' => 'required',
                    'nombre_plan' => 'required',
                ],[
                    'id_categorie_professionelle.required' => 'Veuillez selectionnez la categorieprefessionnelle.',
                    'genre_plan.required' => 'Veuillez selectionnez le genre.',
                    'nombre_plan.unique' => 'Veuillez ajoutez le nombre',
                ]);

                $input = $request->all();

                $input['id_plan_de_formation'] = $id;

                $verficategoriepaln = CategoriePlan::where([['id_plan_de_formation','=',$id],['id_categorie_professionelle','=',$input['id_categorie_professionelle']],['genre_plan','=',$input['genre_plan']]])->get();
//dd($verficategoriepaln);
                if(count($verficategoriepaln)==0){

                    CategoriePlan::create($input);

                    return redirect('planformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Operation reussi. ');

                }else{
                    return redirect('planformation/'.Crypt::UrlCrypt($id).'/edit')->with('error', 'Erreur : Cela a deja ete saisie. ');
                }


            }

            if ($data['action'] == 'Enregistrer_soumettre_plan_formation'){
                $anneexercice = AnneeExercice::get_annee_exercice();
                if(isset($anneexercice->id_periode_exercice)){
                    PlanFormation::where('id_plan_de_formation',$id)->update([
                        'flag_soumis_plan_formation' => true,
                        'id_annee_exercice' => $anneexercice->id_periode_exercice,
                        'date_soumis_plan_formation' => Carbon::now()
                    ]);
                    return redirect()->route('planformation.index')->with('success', 'Plan de formation soumis avec succès.');
                }else{
                    return redirect()->route('planformation.index')->with('error', 'Plan de formation non soumis car l\'annee d\'execrcie n\'est pas encore ouvert.');
                }


            }

            if ($data['action'] == 'Enregistrer_action_formation'){
               // dd($data);
                $this->validate($request, [
                    'intitule_action_formation_plan' => 'required',
                    'id_entreprise_structure_formation_plan_formation' => 'required',
                    'nombre_stagiaire_action_formati' => 'required',
                    'nombre_groupe_action_formation_' => 'required',
                    'nombre_heure_action_formation_p' => 'required',
                    'cout_action_formation_plan' => 'required',
                    'id_type_formation' => 'required',
                    'id_but_formation' => 'required',
                    'date_debut_fiche_agrement' => 'required',
                    'date_fin_fiche_agrement' => 'required',
                    'lieu_formation_fiche_agrement' => 'required',
                    'cout_total_fiche_agrement' => 'required',
                    'objectif_pedagogique_fiche_agre' => 'required',
                    'cadre_fiche_demande_agrement' => 'required',
                    'agent_maitrise_fiche_demande_ag' => 'required',
                    'employe_fiche_demande_agrement' => 'required',
                    'file_beneficiare' => 'required|mimes:xlsx,XLSX|max:5120',
                    'facture_proforma_action_formati' => 'required|mimes:pdf,PDF,png,jpg,jpeg,PNG,JPG,JPEG|max:5120'
                ],[
                    'intitule_action_formation_plan.required' => 'Veuillez ajoutez l\'intitule de l\'action.',
                    'id_entreprise_structure_formation_plan_formation.required' => 'Veuillez ajoutez une structure ou etablissement.',
                    'nombre_stagiaire_action_formati.required' => 'Veuillez ajoutez le nombre de stagiaire.',
                    'nombre_groupe_action_formation_.required' => 'Veuillez ajoutez le nombre de groupe.',
                    'nombre_heure_action_formation_p.required' => 'Veuillez ajoutez le nombre d\'heure.',
                    'cout_action_formation_plan.required' => 'Veuillez ajoutez le cout de la formation.',
                    'id_type_formation.required' => 'Veuillez selectionnez un type de formation.',
                    'id_but_formation.required' => 'Veuillez selectionnez le but de la formation.',
                    'date_debut_fiche_agrement.unique' => 'Veuillez ajoutez la date de debut',
                    'date_fin_fiche_agrement.required' => 'Veuillez ajoutez la date de fin .',
                    'lieu_formation_fiche_agrement.required' => 'Veuillez ajoutez le lieu de formation.',
                    'cout_total_fiche_agrement.required' => 'Veuillez ajoutez le cout total de la fiche d\'agrement.',
                    'objectif_pedagogique_fiche_agre.required' => 'Veuillez ajoutez l\'objectif pedagogique.',
                    'cadre_fiche_demande_agrement.required' => 'Veuillez ajoutez le nombre de cadre.',
                    'agent_maitrise_fiche_demande_ag.required' => 'Veuillez ajoutez le nombre d\'agent de maitrise.',
                    'employe_fiche_demande_agrement.required' => 'Veuillez ajoutez le nombre d\employe .',
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

                $rccentreprisehabilitation = Entreprises::where([['id_entreprises','=',$input['id_entreprise_structure_formation_plan_formation']]])->first();

                $input['id_entreprise_structure_formation_action'] = $input['id_entreprise_structure_formation_plan_formation'];
                $input['intitule_action_formation_plan'] = mb_strtoupper($input['intitule_action_formation_plan']);
                $input['structure_etablissement_action_'] = mb_strtoupper($rccentreprisehabilitation->raison_social_entreprises);
                $input['lieu_formation_fiche_agrement'] = mb_strtoupper($input['lieu_formation_fiche_agrement']);
                $input['objectif_pedagogique_fiche_agre'] = mb_strtoupper($input['objectif_pedagogique_fiche_agre']);
                $input['id_plan_de_formation'] = $id;

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
               // $input['total_beneficiaire_fiche_demand'] = $input['cadre_fiche_demande_agrement'] + $input['agent_maitrise_fiche_demande_ag'] + $input['employe_fiche_demande_agrement'];

                FicheADemandeAgrement::create($input);

                $insertedIdFicheAgrement = FicheADemandeAgrement::latest()->first()->id_fiche_agrement;

                if (isset($data['file_beneficiare'])){

                    $file = $data['file_beneficiare'];

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

               return redirect('planformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Action de plan de formation ajouté ');


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

            return redirect('planformation/'.Crypt::UrlCrypt($idplanformation).'/edit')->with('success', 'Succes : Action de plan de formation supprimer avec succes ');

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

            return redirect('planformation/'.Crypt::UrlCrypt($idplanformation).'/edit')->with('success', 'Succes : Action de plan de formation supprimer avec succes ');

    }

    public function delete($id){

        $idVal = Crypt::UrldeCrypt($id);

        $categorieplan = CategoriePlan::find($idVal);
        $idplanformation = $categorieplan->id_plan_de_formation;
        CategoriePlan::where([['id_categorie_plan','=',$idVal]])->delete();
        return redirect('planformation/'.Crypt::UrlCrypt($idplanformation).'/edit')->with('success', 'Succes : La categorie des traivailleurs à été  supprimer avec succes ');
    }

}
