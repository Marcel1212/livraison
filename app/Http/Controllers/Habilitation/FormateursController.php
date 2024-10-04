<?php

namespace App\Http\Controllers\Habilitation;

use App\Http\Controllers\Controller;
use App\Models\Formateurs;
use App\Models\Pays;
use App\Models\TypesPieces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Crypt;
use App\Helpers\Audit;
use App\Helpers\GenerateCode as Gencode;
use App\Models\Aptitude;
use App\Models\Competences;
use App\Models\Experiences;
use App\Models\FormationsEduc;
use App\Models\Langues;
use App\Models\LanguesFormateurs;
use App\Models\Mention;
use App\Models\PiecesFormateur;
use App\Models\PrincipaleQualification;
use App\Models\TypeEmploie;
use App\Models\TypeLieu;

class FormateursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formateurs = Formateurs::where([['id_entreprises','=',Auth::user()->id_partenaire]])->get();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'FORMATEUR (CREATION DE FORMATEUR)',

            'etat'=>'Succès',

            'objet'=>'FORMATEUR'

        ]);

        return view('habilitation.formateurs.index', compact('formateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pays = Pays::all();
        $pay = "<option value=''> Veuillez selectionnez la nationalité</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->nationalite_pays ." </option>";
        }

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'FORMATEUR (CREATION DE FORMATEUR)',

            'etat'=>'Succès',

            'objet'=>'FORMATEUR'

        ]);

        return view('habilitation.formateurs.create' , compact('pay'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'nom_formateurs' => 'required',
                'prenom_formateurs' => 'required',
                'contact_formateurs' => 'required',
                'email_formateurs' => 'required|email',
                'fonction_formateurs' => 'required',
                'date_de_naissance' => 'required|date|before:today',
                'date_de_recrutement' => 'required|date|before:today',
                'id_pays' => 'required',
            ], [
                'nom_formateurs.required' => 'Veuillez ajouter le nom du formateur.',
                'prenom_formateurs.required' => 'Veuillez ajouter le prénom du formateur.',
                'contact_formateurs.required' => 'Veuillez ajouter le contact du formateur.',
                'email_formateurs.required' => 'Veuillez ajouter l\'email du formateur.',
                'email_formateurs.email' => 'Veuillez ajouter un email du formateur valide.',
                'fonction_formateurs.required' => 'Veuillez ajouter la fonction du formateur.',
                'date_de_naissance.required' => 'Veuillez ajouter la date de naissance du formateur.',
                'date_de_naissance.date' => 'Veuillez ajouter une date de naissance valide.',
                'date_de_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
                'date_de_recrutement.required' => 'Veuillez ajouter la date de recrutement du formateur.',
                'date_de_recrutement.date' => 'Veuillez ajouter une date de recrutement valide.',
                'date_de_recrutement.before' => 'La date de recrutement doit être antérieure à aujourd\'hui.',
                'id_pays.required' => 'Veuillez ajouter la nationalité du formateur.',
            ]);

            $input = $request->all();

            $input['id_entreprises'] = Auth::user()->id_partenaire;
            $input['numero_matricule_fdfp'] = 'MF' . Gencode::randStrGen(4, 5);

            $formateur = Formateurs::create($input);

            $idformateur = $formateur->id_formateurs;

            if ($input['action'] == 'Enregister'){

                Audit::logSave([

                    'action'=>'ENREGISTER',

                    'code_piece'=>'',

                    'menu'=>'FORMATEUR (CREATION DE FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($idformateur).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }

            if ($input['action'] == 'Enregistrer_suivant'){

                Audit::logSave([

                    'action'=>'ENREGISTER',

                    'code_piece'=>'',

                    'menu'=>'FORMATEUR (CREATION DE FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($idformateur).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }



        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id , $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $formateur = Formateurs::find($id);

        $qualification = PrincipaleQualification::where([['id_formateurs','=',$id]])->first();

        $formations = FormationsEduc::where([['id_formateurs','=',$id]])->get();

        $experiences = Experiences::where([['id_formateurs','=',$id]])->get();

        $competences = Competences::where([['id_formateurs','=',$id]])->get();

        $languesformateurs = LanguesFormateurs::where([['id_formateurs','=',$id]])->get();

        $piecesFormateurs = PiecesFormateur::where([['id_formateurs','=',$id]])->get();

        $piecesFormateursVerifi = PiecesFormateur::join('types_pieces', 'pieces_formateur.id_types_pieces', '=', 'types_pieces.id_types_pieces')
                                    ->where('id_formateurs', '=', $id)
                                    ->whereIn('code_types_pieces', ['CV', 'LE'])
                                    ->get();

        //dd($piecesFormateursVerifi);


        $pays = Pays::all();
        $pay = "<option value='".$formateur->pay->id_pays."'> ".$formateur->pay->nationalite_pays."</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->nationalite_pays ." </option>";
        }

        $typeEms = TypeEmploie::where([['flag_type_emploie','=',true]])->get();
        $typeEmplois = "<option value=''> Selectionnez le type emplois </option>";
        foreach ($typeEms as $comp) {
            $typeEmplois .= "<option value='" . $comp->id_type_emploie  . "'>" . $comp->libelle_type_emploie ." </option>";
        }

        $typeLie =  TypeLieu::where([['flag_type_lieu','=',true]])->get();
        $typeLieu = "<option value=''> Selectionnez le type emplois </option>";
        foreach ($typeLie as $comp) {
            $typeLieu .= "<option value='" . $comp->id_type_lieu  . "'>" . $comp->libelle_type_lieu ." </option>";
        }

        $aptitudes =  Aptitude::where([['flag_aptitude','=',true]])->get();
        $aptitudeListe = "<option value=''> Selectionnez l'aptitude </option>";
        foreach ($aptitudes as $comp) {
            $aptitudeListe .= "<option value='" . $comp->id_aptitude  . "'>" . $comp->libelle_aptitude ." </option>";
        }

        $mentions =  Mention::where([['flag_mention','=',true]])->get();
        $mentionsListe = "<option value=''> Selectionnez la mention </option>";
        foreach ($mentions as $comp) {
            $mentionsListe .= "<option value='" . $comp->id_mention  . "'>" . $comp->libelle_mention ." </option>";
        }

        $Langues =  Langues::where([['flag_langues','=',true]])->get();
        $LanguesListe = "<option value=''> Selectionnez la mention </option>";
        foreach ($Langues as $comp) {
            $LanguesListe .= "<option value='" . $comp->id_langues  . "'>" . $comp->libelle_langues ." </option>";
        }

        $TypesPieces =  TypesPieces::where([['flag_types_pieces','=',true]])->get();
        $TypesPiecesListe = "<option value=''> Selectionnez la mention </option>";
        foreach ($TypesPieces as $comp) {
            $TypesPiecesListe .= "<option value='" . $comp->id_types_pieces  . "'>" . $comp->libelle_types_pieces ." </option>";
        }

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'FORMATEUR (CREATION DE FORMATEUR)',

            'etat'=>'Succès',

            'objet'=>'FORMATEUR'

        ]);

        return view('habilitation.formateurs.edit' , compact('pay','formateur','idetape','id','qualification','formations',
            'experiences', 'typeEmplois','typeLieu','competences','aptitudeListe','mentionsListe','LanguesListe','languesformateurs','TypesPiecesListe',
            'piecesFormateurs','piecesFormateursVerifi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id , $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        $formateur = Formateurs::find($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'nom_formateurs' => 'required',
                    'prenom_formateurs' => 'required',
                    'contact_formateurs' => 'required',
                    'email_formateurs' => 'required|email',
                    'fonction_formateurs' => 'required',
                    'date_de_naissance' => 'required|date|before:today',
                    'date_de_recrutement' => 'required|date|before:today',
                    'id_pays' => 'required',
                ], [
                    'nom_formateurs.required' => 'Veuillez ajouter le nom du formateur.',
                    'prenom_formateurs.required' => 'Veuillez ajouter le prénom du formateur.',
                    'contact_formateurs.required' => 'Veuillez ajouter le contact du formateur.',
                    'email_formateurs.required' => 'Veuillez ajouter l\'email du formateur.',
                    'email_formateurs.email' => 'Veuillez ajouter un email du formateur valide.',
                    'fonction_formateurs.required' => 'Veuillez ajouter la fonction du formateur.',
                    'date_de_naissance.required' => 'Veuillez ajouter la date de naissance du formateur.',
                    'date_de_naissance.date' => 'Veuillez ajouter une date de naissance valide.',
                    'date_de_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
                    'date_de_recrutement.required' => 'Veuillez ajouter la date de recrutement du formateur.',
                    'date_de_recrutement.date' => 'Veuillez ajouter une date de recrutement valide.',
                    'date_de_recrutement.before' => 'La date de recrutement doit être antérieure à aujourd\'hui.',
                    'id_pays.required' => 'Veuillez ajouter la nationalité du formateur.',
                ]);

                $input = $request->all();

                $formateur->update($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR Mise a jour FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'AjouterQualification'){
                $this->validate($request, [
                    'principale_qualification_libelle' => 'required',
                ], [
                    'principale_qualification_libelle.required' => 'Veuillez ajouter la principale qualification.',
                ]);

                $input = $request->all();

                $input['id_formateurs'] = $id;

                $qualifica = PrincipaleQualification::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR ajout qualification FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'MiseAJourQualification'){
                $this->validate($request, [
                    'principale_qualification_libelle' => 'required',
                ], [
                    'principale_qualification_libelle.required' => 'Veuillez ajouter la principale qualification.',
                ]);

                $input = $request->all();

                $qualificat = PrincipaleQualification::where([['id_formateurs','=',$id]])->first();

                $qualifica = PrincipaleQualification::find($qualificat->id_principale_qualification);

                $qualifica->update($request->all());

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR Mise a jour qualification FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'AjouterFormationEduc'){

                $this->validate($request, [
                    'ecole_formation_educ' => 'required',
                    'diplome_formation_educ' => 'required',
                    'domaine_formation_educ' => 'required',
                    'resultat_formation_educ' => 'required',
                    'description_formations_educ' => 'required',
                    'date_de_debut_formations_educ' => 'required|date|before:today',
                    'date_de_fin_formations_educ' => 'required|date|before:today',
                ], [
                    'ecole_formation_educ.required' => 'Veuillez ajouter un etablissemnt.',
                    'diplome_formation_educ.required' => 'Veuillez ajouter le diplome obtenu.',
                    'domaine_formation_educ.required' => 'Veuillez ajouter le domaine lié a la formation.',
                    'resultat_formation_educ.required' => 'Veuillez ajouter le resultat obtenu.',
                    'description_formations_educ.required' => 'Veuillez ajouter une description de la formation.',
                    'date_de_debut_formations_educ.required' => 'Veuillez ajouter la date de debut de la formation.',
                    'date_de_debut_formations_educ.date' => 'Veuillez ajouter une date de debut valide.',
                    'date_de_debut_formations_educ.before' => 'La date de debut doit être antérieure à aujourd\'hui.',
                    'date_de_fin_formations_educ.required' => 'Veuillez ajouter la date de fin de la formation.',
                    'date_de_fin_formations_educ.date' => 'Veuillez ajouter une date de fin valide.',
                    'date_de_fin_formations_educ.before' => 'La date de fin doit être antérieure à aujourd\'hui.',
                ]);

                $input = $request->all();

                $input['id_formateurs'] = $id;

                $formations = FormationsEduc::create($input);


                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR ajouter formation/education FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'AjouterExperience'){

                $this->validate($request, [
                    'intitule_de_poste' => 'required',
                    'id_type_emploie' => 'required',
                    'id_type_lieu' => 'required',
                    'nom_entreprise' => 'required',
                    'lieu_entreprise' => 'required',
                    'description_experience' => 'required',
                    'date_de_debut' => 'required|date|before:today',
                ], [
                    'intitule_de_poste.required' => 'Veuillez ajouter un intitulé de poste.',
                    'id_type_emploie.required' => 'Veuillez ajouter le type emploie.',
                    'id_type_lieu.required' => 'Veuillez ajouter le type lieu.',
                    'nom_entreprise.required' => 'Veuillez ajouter le nom entreprise.',
                    'lieu_entreprise.required' => 'Veuillez ajouter un lieu entreprise.',
                    'description_experience.required' => 'Veuillez ajouter un lieu entreprise.',
                    'date_de_debut.required' => 'Veuillez ajouter la date de debut de experience.',
                    'date_de_debut.date' => 'Veuillez ajouter une date de experience valide.',
                    'date_de_debut.before' => 'La date de debut doit être antérieure à aujourd\'hui.',
                ]);

                $input = $request->all();

                $input['id_formateurs'] = $id;

                $experience = Experiences::create($input);


                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR ajouter experience FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'AjouterCompetences'){
                $this->validate($request, [
                    'competences_libelle' => 'required',
                ], [
                    'competences_libelle.required' => 'Veuillez ajouter une compétence.',
                ]);

                $input = $request->all();

                $input['id_formateurs'] = $id;

                $competence = Competences::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR ajouter competence FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'AjouterLangues'){
                $this->validate($request, [
                    'id_langues' => 'required',
                    'id_aptitude' => 'required',
                    'id_mention' => 'required',
                ], [
                    'id_langues.required' => 'Veuillez ajouter une langue.',
                    'id_aptitude.required' => 'Veuillez ajouter une aptitude.',
                    'id_mention.required' => 'Veuillez ajouter une mention.',
                ]);

                $input = $request->all();

                $input['id_formateurs'] = $id;

                $langueFourmateur = LanguesFormateurs::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR ajouter langue FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'AjouterPieces'){
                $this->validate($request, [
                    'id_types_pieces' => 'required',
                ], [
                    'id_types_pieces.required' => 'Veuillez ajouter le type de la piéce.',
                ]);

                $input = $request->all();

                $input['id_formateurs'] = $id;

                $TypeP = TypesPieces::find($input['id_types_pieces']);



                if (isset($input['pieces_formateur'])){

                    $filefront = $input['pieces_formateur'];


                    if($filefront->extension() == "PDF"  || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                    || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                    || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG"){

                        $fileName1 = 'PF_'.$TypeP->code_types_pieces. '_' . rand(111,99999) . '_' . $formateur->nom_formateurs .'_'. $formateur->prenom_formateurs . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces/pieces_formateur/'.$formateur->entreprise->ncc_entreprises.'_'.$formateur->nom_formateurs.'_'.$formateur->prenom_formateurs.'/'), $fileName1);

                        $input['pieces_formateur'] = $fileName1;
                    }

                }

                $piecesformateur = PiecesFormateur::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR ajouter piece FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Terminer'){



                $formateurValide = $formateur->update([
                    'flag_attestation_formateurs' => true
                ]);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'FORMATEUR (Mise a jour FORMATEUR)',

                    'etat'=>'Succès',

                    'objet'=>'FORMATEUR valide FORMATEUR'

                ]);

                return redirect('formateurs/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

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
}
