<?php

namespace App\Http\Controllers\Habilitation;

use App\Helpers\GenerateCode as Gencode;
use App\Http\Controllers\Controller;
use App\Models\DemandeHabilitation;
use App\Models\DemandeSuppressionHabilitation;
use App\Models\DomaineDemandeSuppressionHabilitation;
use App\Models\Motif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Helpers\Audit;
use App\Models\Banque;
use App\Models\DemandeIntervention;
use App\Models\DomaineDemandeHabilitation;
use App\Models\DomaineFormation;
use App\Models\Entreprises;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\InterventionHorsCi;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Pays;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeDomaineDemandeHabilitationPublic;
use App\Models\TypeIntervention;
use App\Models\TypeMoyenPermanent;
use App\Models\TypeOrganisationFormation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DemandeHabilitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
        if(!empty($infoentrprise)){

            $habilitations = DemandeHabilitation::where([['id_entreprises','=',$infoentrprise->id_entreprises]])->get();

            $formejuridique = $infoentrprise->demandeEnrolement->formeJuridique->code_forme_juridique;

            //dd($formejuridique);

            Audit::logSave([

                'action'=>'INDEX',

                'code_piece'=>'',

                'menu'=>'HABILITATION (Soumission)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION'

            ]);

            return view('habilitation.demande.index', compact('habilitations','formejuridique'));

        }else{
            Audit::logSave([

                'action'=>'INDEX',

                'code_piece'=>'',

                'menu'=>'HABILITATION',

                'etat'=>'Echec',

                'objet'=>'HABILITATION'

            ]);
            return redirect('/dashboard')->with('Error', 'Erreur : Vous n\'est autoriser a acces a ce menu');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value=''> Selectionnez la banque </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);

        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'PLAN DE FORMATION (Soumission de plan de formation)',

            'etat'=>'Succès',

            'objet'=>'PLAN DE FORMATION'

        ]);

        return view('habilitation.demande.create', compact('infoentreprise','banque','pay'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'nom_responsable_demande_habilitation' => 'required',
                'fonction_demande_habilitation' => 'required',
                'email_responsable_habilitation' => 'required',
                'contact_responsable_habilitation' => 'required',
                'id_banque' => 'required',
            ],[
                'nom_responsable_demande_habilitation.required' => 'Veuillez ajouter une personne responsable.',
                'fonction_demande_habilitation.required' => 'Veuillez ajouter la fonction de la personne responsable.',
                'email_responsable_habilitation.required' => 'Veuillez ajouter une adresse email.',
                'contact_responsable_habilitation.required' => 'Veuillez ajouter un contact .',
                'id_banque.unique' => 'Veuillez selectionnez une banque ',
            ]);

            $infoentreprise = Entreprises::where([['ncc_entreprises','=',Auth::user()->login_users]])->first();

            $input = $request->all();

            $input['date_creer_demande_habilitation'] = Carbon::now();
            $input['id_entreprises'] = $infoentreprise->id_entreprises;
            $input['nom_responsable_demande_habilitation'] = mb_strtoupper($input['nom_responsable_demande_habilitation']);
            $input['fonction_demande_habilitation'] = mb_strtoupper($input['fonction_demande_habilitation']);
            $input['type_demande'] = 'NOUVELLE DEMANDE';
            $input['type_entreprise'] = 'PR';

            $habilitation = DemandeHabilitation::create($input);

            $insertedId = $habilitation->id_demande_habilitation;

            if ($input['action'] == 'Enregister'){

                Audit::logSave([

                    'action'=>'ENREGISTER',

                    'code_piece'=>'',

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape information entreprise'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }

            if ($input['action'] == 'Enregistrer_suivant'){

                Audit::logSave([

                    'action'=>'ENREGISTER',

                    'code_piece'=>'',

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape information entreprise'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }

        }
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
    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);

        $demandehabilitation = DemandeHabilitation::find($id);
       // dd($demandehabilitation);
        $idetape =  Crypt::UrldeCrypt($id1);

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);

        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $payList = "<option value=''> Selectionnez un pays</option>";
        foreach ($pays as $comp) {
            $payList .= "<option value='" . $comp->id_pays  . "'>" . $comp->libelle_pays ." </option>";
        }

        $typemoyenpermanentes = TypeMoyenPermanent::where([['flag_type_moyen_permanent','=',true]])->get();
        $typemoyenpermanenteList = "<option value=''> Selectionnez la type de moyen </option>";
        foreach ($typemoyenpermanentes as $comp) {
            $typemoyenpermanenteList .= "<option value='" . $comp->id_type_moyen_permanent  . "'>" . mb_strtoupper($comp->libelle_type_moyen_permanent) ." </option>";
        }

        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id]])->get();

        $typeinterventions = TypeIntervention::where([['flag_type_intervention','=',true]])->get();
        $typeinterventionsList = "<option value=''> Selectionnez le type d\'intervention </option>";
        foreach ($typeinterventions as $comp) {
            $typeinterventionsList .= "<option value='" . $comp->id_type_intervention  . "'>" . mb_strtoupper($comp->libelle_type_intervention) ." </option>";
        }

        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id]])->get();
        //dd($idetape);

        $organisationFormations = TypeOrganisationFormation::where([['flag_type_organisation_formation','=',true]])->get();
        $organisationFormationsList = "<option value=''> Selectionnez le type d\'organisation </option>";
        foreach ($organisationFormations as $comp) {
            $organisationFormationsList .= "<option value='" . $comp->id_type_organisation_formation  . "'>" . mb_strtoupper($comp->libelle_type_organisation_formation) ." </option>";
        }

        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id]])->get();

        $typeDomaineDemandeHabilitation = TypeDomaineDemandeHabilitation::where([['flag_type_domaine_demande_habilitation','=',true]])->get();
        $typeDomaineDemandeHabilitationList = "<option value=''> Selectionnez la type de domaine de formation </option>";
        foreach ($typeDomaineDemandeHabilitation as $comp) {
            $typeDomaineDemandeHabilitationList .= "<option value='" . $comp->id_type_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation) ." </option>";
        }

        $domaines = DomaineFormation::where([['flag_domaine_formation','=',true]])->get();
        $domainesList = "<option value=''> Selectionnez le domaine de formation </option>";
        foreach ($domaines as $comp) {
            $domainesList .= "<option value='" . $comp->id_domaine_formation  . "'>" . mb_strtoupper($comp->libelle_domaine_formation) ." </option>";
        }

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        $domainedemandes = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();
        $domainedemandeList = "<option value=''> Selectionnez la banque </option>";
        foreach ($domainedemandes as $comp) {
            $domainedemandeList .= "<option value='" . $comp->id_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation) .'/'. mb_strtoupper( $comp->domaineFormation->libelle_domaine_formation) ." </option>";
        }

        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
                                                          ->where([['id_demande_habilitation','=',$id]])
                                                          ->get();

        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id]])->get();


        $typeDomaineDemandeHabilitationPublic = TypeDomaineDemandeHabilitationPublic::where([['flag_type_type_domaine_demande_habilitation_public','=',true]])->get();
        $typeDomaineDemandeHabilitationPublicList = "<option value=''> Selectionnez le public </option>";
        foreach ($typeDomaineDemandeHabilitationPublic as $comp) {
            $typeDomaineDemandeHabilitationPublicList .= "<option value='" . $comp->id_type_domaine_demande_habilitation_public  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation_public) ." </option>";
        }

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Soumission de HABILITATION)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.demande.edit', compact('demandehabilitation','infoentreprise','banque','pay','idetape',
                    'id','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
                    'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
                    'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList','typeDomaineDemandeHabilitationPublicList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $demandehabilitation = DemandeHabilitation::find($id);

        $infoentreprise = Entreprises::where([['ncc_entreprises','=',Auth::user()->login_users]])->first();

        if ($request->isMethod('put')) {
            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'nom_responsable_demande_habilitation' => 'required',
                    'fonction_demande_habilitation' => 'required',
                    'email_responsable_habilitation' => 'required',
                    'contact_responsable_habilitation' => 'required',
                    'id_banque' => 'required',
                ],[
                    'nom_responsable_demande_habilitation.required' => 'Veuillez ajouter une personne responsable.',
                    'fonction_demande_habilitation.required' => 'Veuillez ajouter la fonction de la personne responsable.',
                    'email_responsable_habilitation.required' => 'Veuillez ajouter une adresse email.',
                    'contact_responsable_habilitation.required' => 'Veuillez ajouter un contact .',
                    'id_banque.unique' => 'Veuillez selectionnez une banque ',
                ]);

                $input = $request->all();

                $input['id_entreprises'] = $infoentreprise->id_entreprises;
                $input['nom_responsable_demande_habilitation'] = mb_strtoupper($input['nom_responsable_demande_habilitation']);
                $input['fonction_demande_habilitation'] = mb_strtoupper($input['fonction_demande_habilitation']);
                $input['type_demande'] = 'NOUVELLE DEMANDE';
                $input['type_entreprise'] = 'PR';

                $demandehabilitation->update($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape information entreprise'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'AjouterMoyenPermanente'){

                $this->validate($request, [
                    'id_type_moyen_permanent' => 'required',
                    'nombre_moyen_permanente' => 'required',
                    'capitale_moyen_permanente' => 'required'
                ],[
                    'id_type_moyen_permanent.required' => 'Veuillez selectionner le type de moyen permanente.',
                    'nombre_moyen_permanente.required' => 'Veuillez ajouter le nombre.',
                    'capitale_moyen_permanente.required' => 'Veuillez ajouter la capacité.'
                ]);

                $input = $request->all();

                $input['id_demande_habilitation'] = $id;

                $moyenP = MoyenPermanente::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape type moeyn permanente'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Moyen permanente ajouter avec success ');

            }


            if ($data['action'] == 'AjouterDemandeIntervention'){

                $this->validate($request, [
                    'id_type_intervention' => 'required'
                ],[
                    'id_type_intervention.required' => 'Veuillez selectionner le type d\'intervention.'
                ]);

                $input = $request->all();

                $tab = $input['id_type_intervention'];

                $input['id_demande_habilitation'] = $id;

                foreach ($tab as $key => $value) {
                    DemandeIntervention::create([
                        'id_demande_habilitation'=> $input['id_demande_habilitation'],
                        'id_type_intervention'=> $value
                    ]);
                }

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape intervention'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Demande intervention ajouter avec success ');

            }

            if ($data['action'] == 'AjouterOrganisationFormation'){

                $this->validate($request, [
                    'id_type_organisation_formation' => 'required'
                ],[
                    'id_type_organisation_formation.required' => 'Veuillez selectionner le type d\'intervention.'
                ]);

                $input = $request->all();

                $tab = $input['id_type_organisation_formation'];

                $input['id_demande_habilitation'] = $id;

                foreach ($tab as $key => $value) {
                    OrganisationFormation::create([
                        'id_demande_habilitation'=> $input['id_demande_habilitation'],
                        'id_type_organisation_formation'=> $value
                    ]);
                }

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape organisation information'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Organisation formation ajouter avec success ');

            }

            if ($data['action'] == 'AjouterDomaineFormation'){

                $this->validate($request, [
                    'id_type_domaine_demande_habilitation' => 'required',
                    'id_domaine_formation' => 'required',
                ],[
                    'id_type_domaine_demande_habilitation.required' => 'Veuillez selectionner le type de domaine.',
                    'id_domaine_formation.required' => 'Veuillez selectionner le domaine de formation.',
                ]);

                $input = $request->all();

                $input['id_demande_habilitation'] = $id;

                DomaineDemandeHabilitation::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape domaine de formation'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Organisation formation ajouter avec success ');

            }

            if ($data['action'] == 'AjouterFormateur'){

                $this->validate($request, [
                    'id_domaine_demande_habilitation' => 'required',
                    'nom_formateur' => 'required',
                    'prenom_formateur' => 'required',
                    'date_debut_formateur' => 'required',
                    'le_formateur' => 'required',
                    'experience_formateur' => 'required',
                ],[
                    'id_domaine_demande_habilitation.required' => 'Veuillez selectionner le doamien de formation.',
                    'nom_formateur.required' => 'Veuillez ajouter le nom du formateur.',
                    'prenom_formateur.required' => 'Veuillez ajouter le prenom du formateur.',
                    'date_debut_formateur.required' => 'Veuillez ajouter la date de debut d\'experience du formateur.',
                    'cv_formateur.required' => 'Veuillez ajouter le CV.',
                    'le_formateur.required' => 'Veuillez ajouter la lettre d\'engagement.',
                    'experience_formateur.required' => 'Veuillez ajouter l\'experience.',
                ]);

                $input = $request->all();


                if (isset($input['cv_formateur'])){

                    $filefront = $input['cv_formateur'];


                    if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                    || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                    || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){

                        $fileName1 = 'cv_formateur'. '_' . rand(111,99999) . '_' . $input['nom_formateur'] .'_'. $input['prenom_formateur'] . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/cv_formateur/'), $fileName1);

                        $input['cv_formateur'] = $fileName1;
                    }

                }

                if (isset($input['le_formateur'])){

                    $filefront = $input['le_formateur'];

                    //dd($filefront->extension());

                    if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                    || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                    || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){

                        $fileName1 = 'le_formateur'. '_' . rand(111,99999) . '_' . $input['nom_formateur'] .'_'. $input['prenom_formateur'] . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/le_formateur/'), $fileName1);

                        $input['le_formateur'] = $fileName1;
                    }

                }

                FormateurDomaineDemandeHabilitation::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape ajouter formateur'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Organisation formation ajouter avec success ');

            }

            if ($data['action'] == 'AjouterDivers'){

                $this->validate($request, [
                    'information_catalogue_demande_habilitation' => 'required',
                    'information_seul_activite_demande_habilitation' => 'required',
                    'materiel_didactique_demande_habilitation' => 'required'
                ],[
                    'information_catalogue_demande_habilitation.required' => 'Veuillez selectionner l\'information catalogue.',
                    'information_seul_activite_demande_habilitation.required' => 'Veuillez selectionner l\'information seul activite.',
                    'materiel_didactique_demande_habilitation.required' => 'Veuillez ajouter le materiel didactique.'
                ]);

                $input = $request->all();


                if (isset($input['dernier_catalogue_demande_habilitation'])){

                    $filefront = $input['dernier_catalogue_demande_habilitation'];

                    //dd($filefront->extension());

                    if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                    || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                    || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){

                        $fileName1 = 'dernier_catalogue_demande_habilitation'. '_' . rand(111,99999) . '_' . 'catalogue'. '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/catalogue/'), $fileName1);

                        $input['dernier_catalogue_demande_habilitation'] = $fileName1;
                    }

                }

                $demandehabilitation->update($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape divers'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Organisation formation ajouter avec success ');

            }

            if ($data['action'] == 'AjouterInterventionsHorsCis'){

                $this->validate($request, [
                    'objet_intervention_hors_ci' => 'required',
                    'annee_intervention_hors_ci' => 'required',
                    'id_pays' => 'required',
                    'quel_financement_intervention_hors_ci' => 'required'
                ],[
                    'objet_intervention_hors_ci.required' => 'Veuillez ajouter l\'objet .',
                    'annee_intervention_hors_ci.required' => 'Veuillez ajouter l\'année intervention.',
                    'id_pays.required' => 'Veuillez selectionner le pays.',
                    'quel_financement_intervention_hors_ci.required' => 'Veuillez ajouter le financement.'
                ]);

                $input = $request->all();

                $input['id_demande_habilitation'] = $id;
                $input['objet_intervention_hors_ci'] = mb_strtoupper($input['objet_intervention_hors_ci']);
                $input['quel_financement_intervention_hors_ci'] = mb_strtoupper($input['quel_financement_intervention_hors_ci']);

                InterventionHorsCi::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape intervention hors du pays'

                ]);

                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Organisation formation ajouter avec success ');

            }

            if ($data['action'] == 'Enregistrer_soumettre_demande_habilitation'){

                DemandeHabilitation::where('id_demande_habilitation',$id)->update([
                    'flag_soumis_demande_habilitation' => true,
                    'date_soumis_demande_habilitation' => Carbon::now()
                ]);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape soumission'

                ]);

               return redirect()->route('demandehabilitation.index')->with('success', 'Demande habilitation soumis avec succès.');

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





    public function edityancho($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);

        $demandeSuppressionHabilitations = DemandeSuppressionHabilitation::where('id_demande_habilitation',$id)
        ->get();

        $demandehabilitation = DemandeHabilitation::find($id);
        // dd($demandehabilitation);
        $idetape =  Crypt::UrldeCrypt($id1);

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);

        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $payList = "<option value=''> Selectionnez un pays</option>";
        foreach ($pays as $comp) {
            $payList .= "<option value='" . $comp->id_pays  . "'>" . $comp->libelle_pays ." </option>";
        }

        $typemoyenpermanentes = TypeMoyenPermanent::where([['flag_type_moyen_permanent','=',true]])->get();
        $typemoyenpermanenteList = "<option value=''> Selectionnez la type de moyen </option>";
        foreach ($typemoyenpermanentes as $comp) {
            $typemoyenpermanenteList .= "<option value='" . $comp->id_type_moyen_permanent  . "'>" . mb_strtoupper($comp->libelle_type_moyen_permanent) ." </option>";
        }

        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id]])->get();

        $typeinterventions = TypeIntervention::where([['flag_type_intervention','=',true]])->get();
        $typeinterventionsList = "<option value=''> Selectionnez le type d\'intervention </option>";
        foreach ($typeinterventions as $comp) {
            $typeinterventionsList .= "<option value='" . $comp->id_type_intervention  . "'>" . mb_strtoupper($comp->libelle_type_intervention) ." </option>";
        }

        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id]])->get();
        //dd($idetape);

        $organisationFormations = TypeOrganisationFormation::where([['flag_type_organisation_formation','=',true]])->get();
        $organisationFormationsList = "<option value=''> Selectionnez le type d\'organisation </option>";
        foreach ($organisationFormations as $comp) {
            $organisationFormationsList .= "<option value='" . $comp->id_type_organisation_formation  . "'>" . mb_strtoupper($comp->libelle_type_organisation_formation) ." </option>";
        }

        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id]])->get();

        $typeDomaineDemandeHabilitation = TypeDomaineDemandeHabilitation::where([['flag_type_domaine_demande_habilitation','=',true]])->get();
        $typeDomaineDemandeHabilitationList = "<option value=''> Selectionnez la type de domaine de formation </option>";
        foreach ($typeDomaineDemandeHabilitation as $comp) {
            $typeDomaineDemandeHabilitationList .= "<option value='" . $comp->id_type_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation) ." </option>";
        }

        $domaines = DomaineFormation::where([['flag_domaine_formation','=',true]])->get();
        $domainesList = "<option value=''> Selectionnez le domaine de formation </option>";
        foreach ($domaines as $comp) {
            $domainesList .= "<option value='" . $comp->id_domaine_formation  . "'>" . mb_strtoupper($comp->libelle_domaine_formation) ." </option>";
        }

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        $domainedemandes = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();
        $domainedemandeList = "<option value=''> Selectionnez la banque </option>";
        foreach ($domainedemandes as $comp) {
            $domainedemandeList .= "<option value='" . $comp->id_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation) .'/'. mb_strtoupper( $comp->domaineFormation->libelle_domaine_formation) ." </option>";
        }

        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
            ->where([['id_demande_habilitation','=',$id]])
            ->get();

        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id]])->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Soumission de HABILITATION)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.demande.edityancho', compact('demandehabilitation','infoentreprise','banque','pay','idetape',
            'id','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
            'demandeSuppressionHabilitations',
            'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
            'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList'));
    }
    public function editdomaine($id, $id1)
    {

        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        $domaineHabilitation = DomaineDemandeHabilitation::find($id);
        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();
        $domaine = "<option value='".@$domaineHabilitation->domaineFormation->id_domaine_formation."'> " . $domaineHabilitation->domaineFormation->libelle_domaine_formation. "</option>";
        $typedomaine = "<option value='".@$domaineHabilitation->typeDomaineDemandeHabilitation->id_type_domaine_demande_habilitation."'> " . $domaineHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation. "</option>";
        $typedomainepublic = "<option value='".@$domaineHabilitation->typeDomaineDemandeHabilitationPublic->id_type_domaine_demande_habilitation_public."'> " . $domaineHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public. "</option>";
        $domaineSuppressionHabilitations = DomaineDemandeSuppressionHabilitation::where('id_domaine_demande_habilitation',$id)->get();
        $domaineSuppressionHabilitationEnCours = DomaineDemandeSuppressionHabilitation::where('id_domaine_demande_habilitation',$id)
            ->where('flag_rejeter_domaine_demande_suppression_habilitation',false)
            ->where('flag_validation_domaine_demande_suppression_habilitation',false)->first();

        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'HABILITATION (Soumission de HABILITATION)',
            'etat'=>'Succès',
            'objet'=>'HABILITATION'
        ]);

        return view('habilitation.demande.editdomaine', compact('domaineHabilitation',
            'domaine','typedomaine','typedomainepublic','motifs', 'idetape',
                        'domaineSuppressionHabilitations',
        'domaineSuppressionHabilitationEnCours'
        ));
    }


    public function deletedomainestore(Request $request,$id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'commentaire_domaine_demande_suppression_habilitation' => 'required',
                'id_motif_domaine_demande_suppression_habilitation' => 'required',
            ],[
                'commentaire_domaine_demande_suppression_habilitation.required' => 'Veuillez ajouter le commentaire de la demande de suppression.',
                'id_motif_domaine_demande_suppression_habilitation.required' => 'Veuillez ajouter un motif.',
            ]);

            $input = $request->all();


            if ($input['action'] == 'soumettre'){
                $input['date_soumis_domaine_demande_suppression_habilitation'] = Carbon::now();
                $input['flag_soumis_domaine_demande_suppression_habilitation'] = true;
                $input['id_domaine_demande_habilitation'] = $id;

                if (isset($input['piece_domaine_demande_suppression_habilitation'])){
                    $filefront = $input['piece_domaine_demande_suppression_habilitation'];
                    if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                        || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                        || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){
                        $fileName1 = 'piece_domaine_demande_suppression_habilitation'. '_' . rand(111,99999) . 'piece_domaine_demande_suppression_habilitation' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                        $input['piece_domaine_demande_suppression_habilitation'] = $fileName1;
                    }

                }else{
                    return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/editdomaine')->with('error', 'Erreur : Veuillez ajouter une pièce justificatif');
                }

                DomaineDemandeSuppressionHabilitation::create($input);
                return redirect('demandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/editdomaine')->with('success', 'Succes : Demande de suppression effectuée avec succès');
            }
        }

//        $id =  Crypt::UrldeCrypt($id);
//        $idetape =  Crypt::UrldeCrypt($id1);
//
//        $domaineHabilitation = DomaineDemandeHabilitation::find($id);
//        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();
//        $domaine = "<option value='".@$domaineHabilitation->domaineFormation->id_domaine_formation."'> " . $domaineHabilitation->domaineFormation->libelle_domaine_formation. "</option>";
//        $typedomaine = "<option value='".@$domaineHabilitation->typeDomaineDemandeHabilitation->id_type_domaine_demande_habilitation."'> " . $domaineHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation. "</option>";
//        $typedomainepublic = "<option value='".@$domaineHabilitation->typeDomaineDemandeHabilitationPublic->id_type_domaine_demande_habilitation_public."'> " . $domaineHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public. "</option>";


    }


    public function indexyancho()
    {
        $infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
        if(!empty($infoentrprise)){

            $habilitations = DemandeHabilitation::where([['id_entreprises','=',$infoentrprise->id_entreprises]])->get();

            $formejuridique = $infoentrprise->demandeEnrolement->formeJuridique->code_forme_juridique;

            //dd($formejuridique);

            Audit::logSave([

                'action'=>'INDEX',

                'code_piece'=>'',

                'menu'=>'HABILITATION (Soumission)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION'

            ]);

            return view('habilitation.demande.indexyancho', compact('habilitations','formejuridique'));

        }else{
            Audit::logSave([

                'action'=>'INDEX',

                'code_piece'=>'',

                'menu'=>'HABILITATION',

                'etat'=>'Echec',

                'objet'=>'HABILITATION'

            ]);
            return redirect('/dashboard')->with('Error', 'Erreur : Vous n\'est autoriser a acces a ce menu');
        }
    }

    public function suppressiondomaineformation($id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::whereNotExists(function ($query) use ($id){
            $query->select('*')
                ->from('domaine_demande_suppression_habilitation')
                ->where('domaine_demande_suppression_habilitation.flag_demande_suppression_habilitation',false)
            ->whereColumn('domaine_demande_habilitation.id_domaine_demande_habilitation','=','domaine_demande_suppression_habilitation.id_domaine_demande_habilitation');
        })->where('domaine_demande_habilitation.id_demande_habilitation',$id)->get();
        return view('habilitation.demande.suppressiondomaineformation',compact('motifs','id','domaineDemandeHabilitations'));
    }

    public function suppressiondomaineformationedit($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();
        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();
        $demande_suppression = DemandeSuppressionHabilitation::find($id);
        return view('habilitation.demande.suppressiondomaineformationedit',compact('motifs',
            'domaineDemandeHabilitations','id','id1','idetape','demande_suppression'));
//
    }



    public function suppressiondomaineformationstore(Request $request,$id,$id1)
    {
        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'commentaire_demande_suppression_habilitation' => 'required',
                'id_motif_demande_suppression_habilitation' => 'required',
            ], [
                'commentaire_demande_suppression_habilitation.required' => 'Veuillez ajouter le commentaire de la demande de suppression.',
                'id_motif_demande_suppression_habilitation.required' => 'Veuillez ajouter un motif.',
            ]);

            $input = $request->all();
            if ($input['action'] == 'enregistrer') {

                if (count($input['id_domaine_demande_habilitation']) > 0) {

                    if (isset($input['piece_demande_suppression_habilitation'])) {
                        $filefront = $input['piece_demande_suppression_habilitation'];
                        if ($filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                            || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                            || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG") {
                            $fileName1 = 'piece_demande_suppression_habilitation' . '_' . rand(111, 99999) . 'piece_demande_suppression_habilitation' . time() . '.' . $filefront->extension();
                            $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                            $input['piece_demande_suppression_habilitation'] = $fileName1;
                        }

                    } else {
                        return redirect('demandehabilitation/' . Crypt::UrlCrypt($id) . '/suppressiondomaineformation')->with('error', 'Erreur : Veuillez ajouter une pièce justificatif');
                    }

                    $dateanneeencours = Carbon::now()->format('Y');

                    $data_saving = DemandeSuppressionHabilitation::create([
                        'code_demande_suppression_habilitation'=>'DSD-'.Gencode::randStrGen(4, 5).'-'. $dateanneeencours,
                        'id_motif_demande_suppression_habilitation'=> $input['id_motif_demande_suppression_habilitation'],
                        'commentaire_demande_suppression_habilitation'=> $input['commentaire_demande_suppression_habilitation'],
                        'piece_demande_suppression_habilitation'=> $input['piece_demande_suppression_habilitation'],
                        'date_enregistrer_demande_suppression_habilitation'=> Carbon::now(),
                        'flag_enregistrer_demande_suppression_habilitation'=> true,
                        'id_demande_habilitation'=> $id,
                        'id_user'=> Auth::user()->id
                    ]);
                    if ($data_saving) {
                        $demande_suppression_habilitation = DemandeSuppressionHabilitation::latest()->first();

                        foreach ($input['id_domaine_demande_habilitation'] as $item) {
                            DomaineDemandeSuppressionHabilitation::create([
                                    'id_domaine_demande_habilitation' => $item,
                                    'id_demande_suppression_habilitation' => $demande_suppression_habilitation->id_demande_suppression_habilitation,
                                    'flag_demande_suppression_habilitation' => false
                                ]
                            );

                        }

                        return redirect('demandehabilitation/' . Crypt::UrlCrypt($demande_suppression_habilitation->id_demande_suppression_habilitation) . '/'.Crypt::UrlCrypt($id).'/' . Crypt::UrlCrypt(2) . '/suppressiondomaineformationedit')->with('success', 'Succes : Demande de suppression effectuée avec succès');

                    } else {
                        return redirect('demandehabilitation/' . Crypt::UrlCrypt($id) . '/suppressiondomaineformation')->with('error', 'Erreur : Une erreur s\'est produite');
                    }


                } else {
                    return redirect('demandehabilitation/' . Crypt::UrlCrypt($id) . '/suppressiondomaineformation')->with('error', 'Erreur : Veuillez ajouter les domaines de formations');
                }
            }


        }
    }

    public function suppressiondomaineformationupdate(Request $request,$id,$id1,$id2)
    {

        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        $id2 = Crypt::UrldeCrypt($id2);
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'commentaire_demande_suppression_habilitation' => 'required',
                'id_motif_demande_suppression_habilitation' => 'required',
            ], [
                'commentaire_demande_suppression_habilitation.required' => 'Veuillez ajouter le commentaire de la demande de suppression.',
                'id_motif_demande_suppression_habilitation.required' => 'Veuillez ajouter un motif.',
            ]);

            $input = $request->all();

            if ($input['action'] == 'enregistrer') {

                if (count($input['id_domaine_demande_habilitation']) > 0) {

                    if (isset($input['piece_demande_suppression_habilitation'])) {
                        $filefront = $input['piece_demande_suppression_habilitation'];
                        if ($filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                            || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                            || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG") {
                            $fileName1 = 'piece_demande_suppression_habilitation' . '_' . rand(111, 99999) . 'piece_demande_suppression_habilitation' . time() . '.' . $filefront->extension();
                            $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                            $input['piece_demande_suppression_habilitation'] = $fileName1;
                        }
                        $data_saving = DemandeSuppressionHabilitation::where('id_demande_suppression_habilitation',$id)->update([
                            'id_motif_demande_suppression_habilitation'=> $input['id_motif_demande_suppression_habilitation'],
                            'commentaire_demande_suppression_habilitation'=> $input['commentaire_demande_suppression_habilitation'],
                            'piece_demande_suppression_habilitation'=> $input['piece_demande_suppression_habilitation'],
                            'date_enregistrer_demande_suppression_habilitation'=> Carbon::now(),
                            'flag_enregistrer_demande_suppression_habilitation'=> true,
                            'id_demande_habilitation'=> $id1,
                            'id_user'=> Auth::user()->id
                        ]);
                    }
                    else {
                        $data_saving = DemandeSuppressionHabilitation::where('id_demande_suppression_habilitation',$id)->update([
                            'id_motif_demande_suppression_habilitation'=> $input['id_motif_demande_suppression_habilitation'],
                            'commentaire_demande_suppression_habilitation'=> $input['commentaire_demande_suppression_habilitation'],
                            'date_enregistrer_demande_suppression_habilitation'=> Carbon::now(),
                            'flag_enregistrer_demande_suppression_habilitation'=> true,
                            'id_demande_habilitation'=> $id1,
                            'id_user'=> Auth::user()->id
                        ]);
                    }

                    if ($data_saving) {

                        $demande_suppression_habilitation = DemandeSuppressionHabilitation::latest()->first();

                        $deleteDomaineDemandeSuppressions = DomaineDemandeSuppressionHabilitation::where('id_demande_suppression_habilitation',$id)->get();
                        foreach ($deleteDomaineDemandeSuppressions as $deleteDomaineDemandeSuppression) {
                            $deleteDomaineDemandeSuppression->delete();
                        }


                            foreach ($input['id_domaine_demande_habilitation'] as $item) {

                            DomaineDemandeSuppressionHabilitation::create([
                                    'id_domaine_demande_habilitation' => $item,
                                    'id_demande_suppression_habilitation' => $demande_suppression_habilitation->id_demande_suppression_habilitation,
                                    'flag_demande_suppression_habilitation' => false
                                ]
                            );

                        }

                        return redirect('demandehabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/suppressiondomaineformationedit'

                    )->with('success', 'Succes : Demande de suppression modifiée avec succès');

                    } else {
                        return redirect('demandehabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/suppressiondomaineformationedit')->with('error', 'Erreur : Une erreur s\'est produite');
                    }

                } else {
                    return redirect('demandehabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/suppressiondomaineformationedit')->with('error', 'Erreur : Une erreur s\'est produite');
                }
            }

            if ($input['action'] == 'soumettre') {

                DemandeSuppressionHabilitation::where('id_demande_suppression_habilitation',$id)->update([
                    'date_soumis_demande_suppression_habilitation'=> Carbon::now(),
                    'flag_soumis_demande_suppression_habilitation'=> true
                ]);

                return redirect('demandehabilitation/' . Crypt::UrlCrypt($id) . '/' . Crypt::UrlCrypt($id1) .'/'. Crypt::UrlCrypt(2) . '/suppressiondomaineformationedit')->with('success', 'Succes : Demande de suppression effectuée avec succès');
            }
        }
    }

}
