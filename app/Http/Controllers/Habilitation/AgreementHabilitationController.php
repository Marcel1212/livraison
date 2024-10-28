<?php

namespace App\Http\Controllers\Habilitation;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\InfosEntreprise;
use App\Http\Controllers\Controller;
use App\Models\AutreDemandeHabilitationFormation;
use App\Models\Banque;
use App\Models\CommentaireNonRecevableDemande;
use App\Models\Competences;
use App\Models\DemandeHabilitation;
use App\Models\DemandeIntervention;
use App\Models\DomaineAutreDemandeHabilitationFormation;
use App\Models\DomaineDemandeHabilitation;
use App\Models\DomaineFormation;
use App\Models\Experiences;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\Formateurs;
use App\Models\FormationsEduc;
use App\Models\InterventionHorsCi;
use App\Models\LanguesFormateurs;
use App\Models\Motif;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Pays;
use App\Models\PiecesDemandeHabilitation;
use App\Models\PrincipaleQualification;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeDomaineDemandeHabilitationPublic;
use App\Models\TypeIntervention;
use App\Models\TypeMoyenPermanent;
use App\Models\TypeOrganisationFormation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgreementHabilitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
        $habilitations = DemandeHabilitation::where([['id_entreprises','=',$infoentrprise->id_entreprises],['flag_agrement_demande_habilitaion','=',true]])->get();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'HABILITATION (AGREEMENT)',

            'etat'=>'Echec',

            'objet'=>'HABILITATION (AGREEMENT)'

        ]);
        return view('habilitation.agreement.index', compact('habilitations'));
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
        $id =  Crypt::UrldeCrypt($id);
        $demandehabilitation = DemandeHabilitation::find($id);
        return view('habilitation.agreement.show', compact('demandehabilitation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, string $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
        $habilitation = DemandeHabilitation::where([['id_entreprises','=',$infoentrprise->id_entreprises],['flag_agrement_demande_habilitaion','=',true]])
            ->where('id_demande_habilitation',$id)->first();
        $autre_demande_habilitation_formations = AutreDemandeHabilitationFormation::where('id_demande_habilitation',@$habilitation->id_demande_habilitation)->get();
        $idetape =  Crypt::UrldeCrypt($id1);

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$habilitation->banque->id_banque."'> ".mb_strtoupper($habilitation->banque->libelle_banque)." </option>";
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

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])
            ->where('flag_agree_domaine_demande_habilitation',true)->get();

        $domainedemandes = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();
        $domainedemandeList = "<option value=''> Selectionnez la banque </option>";
        foreach ($domainedemandes as $comp) {
            $domainedemandeList .= "<option value='" . $comp->id_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation) .'/'. mb_strtoupper( $comp->domaineFormation->libelle_domaine_formation) ." </option>";
        }

        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
            ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
            ->join('type_domaine_demande_habilitation','domaine_demande_habilitation.id_type_domaine_demande_habilitation','type_domaine_demande_habilitation.id_type_domaine_demande_habilitation')
            ->join('type_domaine_demande_habilitation_public','domaine_demande_habilitation.id_type_domaine_demande_habilitation_public','type_domaine_demande_habilitation_public.id_type_domaine_demande_habilitation_public')
            ->join('formateurs','formateur_domaine_demande_habilitation.id_formateurs','formateurs.id_formateurs')
            ->join('pieces_formateur','formateurs.id_formateurs','pieces_formateur.id_formateurs')
            ->where([['id_demande_habilitation','=',$id],['id_types_pieces','=',2]])
            ->get();

        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id]])->get();

        $piecesDemandeHabilitations = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();


        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'Agrément (HABILITATION)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.agreement.edit', compact('habilitation','infoentreprise','banque','pay','idetape',
            'id','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
            'autre_demande_habilitation_formations','piecesDemandeHabilitations',
            'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
            'domaineDemandeHabilitations','domainedemandeList','formateurs','interventionsHorsCis','payList'));
    }



    public function suppressiondomaineformation($id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::whereNotExists(function ($query) use ($id){
            $query->select('*')
                ->from('domaine_autre_demande_habilitation_formation')
                ->where('domaine_autre_demande_habilitation_formation.flag_autre_demande_habilitation_formation',false)
                ->whereColumn('domaine_demande_habilitation.id_domaine_demande_habilitation','=','domaine_autre_demande_habilitation_formation.id_domaine_demande_habilitation');
        })->where('domaine_demande_habilitation.id_demande_habilitation',$id)->get();

        return view('habilitation.agreement.suppressiondomaineformation',compact('motifs','id','domaineDemandeHabilitations'));
    }

    public function suppressiondomaineformationstore(Request $request,$id,$id1)
    {
        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'commentaire_autre_demande_habilitation_formation' => 'required',
                'id_motif_autre_demande_habilitation_formation' => 'required',
            ], [
                'commentaire_autre_demande_habilitation_formation.required' => 'Veuillez ajouter le commentaire de la demande de suppression.',
                'id_motif_autre_demande_habilitation_formation.required' => 'Veuillez ajouter un motif.',
            ]);

            $input = $request->all();
            if ($input['action'] == 'enregistrer') {

                if (count($input['id_domaine_demande_habilitation']) > 0) {

                    if (isset($input['piece_autre_demande_habilitation_formation'])) {
                        $filefront = $input['piece_autre_demande_habilitation_formation'];
                        if ($filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                            || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                            || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG") {
                            $fileName1 = 'piece_autre_demande_habilitation_formation' . '_' . rand(111, 99999) . 'piece_autre_demande_habilitation_formation' . time() . '.' . $filefront->extension();
                            $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                            $input['piece_autre_demande_habilitation_formation'] = $fileName1;
                        }

                    } else {
                        return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/suppressiondomaineformation')->with('error', 'Erreur : Veuillez ajouter une pièce justificatif');
                    }

                    $dateanneeencours = Carbon::now()->format('Y');

                    $data_saving = AutreDemandeHabilitationFormation::create([
                        'code_autre_demande_habilitation_formation'=>'DSD-'.Gencode::randStrGen(4, 5).'-'. $dateanneeencours,
                        'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                        'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                        'piece_autre_demande_habilitation_formation'=> $input['piece_autre_demande_habilitation_formation'],
                        'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                        'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                        'id_demande_habilitation'=> $id,
                        'type_autre_demande'=> 'demande_suppression',
                        'id_user'=> Auth::user()->id
                    ]);
                    if ($data_saving) {
                        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::latest()->first();

                        foreach ($input['id_domaine_demande_habilitation'] as $item) {
                            DomaineAutreDemandeHabilitationFormation::create([
                                    'id_domaine_demande_habilitation' => $item,
                                    'id_autre_demande_habilitation_formation' => $autre_demande_habilitation_formation->id_autre_demande_habilitation_formation,
                                    'flag_autre_demande_habilitation_formation' => false
                                ]
                            );

                        }

                        return redirect('agrementhabilitation/' . Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation) . '/'.Crypt::UrlCrypt($id).'/' . Crypt::UrlCrypt(2) . '/suppressiondomaineformationedit')->with('success', 'Succes : Demande de suppression effectuée avec succès');

                    } else {
                        return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/suppressiondomaineformation')->with('error', 'Erreur : Une erreur s\'est produite');
                    }


                } else {
                    return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/suppressiondomaineformation')->with('error', 'Erreur : Veuillez ajouter les domaines de formations');
                }
            }


        }
    }

    public function suppressiondomaineformationedit($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();
        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();
        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::find($id);
        return view('habilitation.agreement.suppressiondomaineformationedit',compact('motifs',
            'domaineDemandeHabilitations','id','id1','idetape','autre_demande_habilitation_formation'));
    }

    public function suppressiondomaineformationupdate(Request $request,$id,$id1,$id2)
    {

        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        $id2 = Crypt::UrldeCrypt($id2);
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'commentaire_autre_demande_habilitation_formation' => 'required',
                'id_motif_autre_demande_habilitation_formation' => 'required',
            ], [
                'commentaire_autre_demande_habilitation_formation.required' => 'Veuillez ajouter le commentaire de la demande de suppression.',
                'id_motif_autre_demande_habilitation_formation.required' => 'Veuillez ajouter un motif.',
            ]);

            $input = $request->all();

            if ($input['action'] == 'enregistrer') {

                if (count($input['id_domaine_demande_habilitation']) > 0) {

                    if (isset($input['piece_autre_demande_habilitation_formation'])) {
                        $filefront = $input['piece_autre_demande_habilitation_formation'];
                        if ($filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                            || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                            || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG") {
                            $fileName1 = 'piece_autre_demande_habilitation_formation' . '_' . rand(111, 99999) . 'piece_autre_demande_habilitation_formation' . time() . '.' . $filefront->extension();
                            $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                            $input['piece_autre_demande_habilitation_formation'] = $fileName1;
                        }
                        $data_saving = AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                            'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                            'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                            'piece_autre_demande_habilitation_formation'=> $input['piece_autre_demande_habilitation_formation'],
                            'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                            'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                            'id_demande_habilitation'=> $id1,
                            'id_user'=> Auth::user()->id
                        ]);
                    }
                    else {
                        $data_saving = AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                            'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                            'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                            'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                            'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                            'id_demande_habilitation'=> $id1,
                            'id_user'=> Auth::user()->id
                        ]);
                    }

                    if ($data_saving) {

                        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::latest()->first();

                        $deleteDomaineDemandeSuppressions = DomaineAutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->get();
                        foreach ($deleteDomaineDemandeSuppressions as $deleteDomaineDemandeSuppression) {
                            $deleteDomaineDemandeSuppression->delete();
                        }


                        foreach ($input['id_domaine_demande_habilitation'] as $item) {

                            DomaineAutreDemandeHabilitationFormation::create([
                                    'id_domaine_demande_habilitation' => $item,
                                    'id_autre_demande_habilitation_formation' => $autre_demande_habilitation_formation->id_autre_demande_habilitation_formation,
                                    'flag_autre_demande_habilitation_formation' => false
                                ]
                            );

                        }

                        return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/suppressiondomaineformationedit'

                        )->with('success', 'Succes : Demande de suppression modifiée avec succès');

                    } else {
                        return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/suppressiondomaineformationedit')->with('error', 'Erreur : Une erreur s\'est produite');
                    }

                } else {
                    return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/suppressiondomaineformationedit')->with('error', 'Erreur : Une erreur s\'est produite');
                }
            }

            if ($input['action'] == 'soumettre') {

                AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                    'date_soumis_autre_demande_habilitation_formation'=> Carbon::now(),
                    'flag_soumis_autre_demande_habilitation_formation'=> true
                ]);

                return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/' . Crypt::UrlCrypt($id1) .'/'. Crypt::UrlCrypt(2) . '/suppressiondomaineformationedit')->with('success', 'Succes : Demande de suppression effectuée avec succès');
            }
        }
    }

    public function extensiondomaineformation($id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $motifs = Motif::where('code_motif','EDF')->where('flag_actif_motif',true)->get();
        return view('habilitation.agreement.extensiondomaineformation',compact('motifs','id'));
    }


    public function extensiondomaineformationstore(Request $request,$id,$id1)
    {
        $id = Crypt::UrldeCrypt($id);
        $idetape = Crypt::UrldeCrypt($id1);

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'commentaire_autre_demande_habilitation_formation' => 'required',
                'id_motif_autre_demande_habilitation_formation' => 'required',
            ], [
                'commentaire_autre_demande_habilitation_formation.required' => 'Veuillez ajouter le commentaire de la demande.',
                'id_motif_autre_demande_habilitation_formation.required' => 'Veuillez ajouter un motif.',
            ]);

            $input = $request->all();
            if ($input['action'] == 'enregistrer') {
                if (isset($input['piece_autre_demande_habilitation_formation'])) {
                    $filefront = $input['piece_autre_demande_habilitation_formation'];
                    if ($filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                        || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                        || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG") {
                        $fileName1 = 'piece_autre_demande_habilitation_formation' . '_' . rand(111, 99999) . 'piece_autre_demande_habilitation_formation' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                        $input['piece_autre_demande_habilitation_formation'] = $fileName1;
                    }

                } else {
                    return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/extensiondomaineformation')->with('error', 'Erreur : Veuillez ajouter une pièce justificatif');
                }
                $dateanneeencours = Carbon::now()->format('Y');
                AutreDemandeHabilitationFormation::create([
                    'code_autre_demande_habilitation_formation'=>'DED-'.Gencode::randStrGen(4, 5).'-'. $dateanneeencours,
                    'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                    'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                    'piece_autre_demande_habilitation_formation'=> $input['piece_autre_demande_habilitation_formation'],
                    'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                    'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                    'type_autre_demande'=> 'demande_extension',
                    'id_demande_habilitation'=> $id,
                    'id_user'=> Auth::user()->id
                ]);
                $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::latest()->first();
                return redirect('agrementhabilitation/' . Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation) . '/'.Crypt::UrlCrypt($id).'/' . Crypt::UrlCrypt($idetape) . '/extensiondomaineformationedit')->with('success', 'Succes : Demande d\'extension effectuée avec succès');
            }
            return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/extensiondomaineformation')->with('error', 'Erreur : Une erreur s\'est produite');
        }
        return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/extensiondomaineformation')->with('error', 'Erreur : Une erreur s\'est produite');
    }


    public function extensiondomaineformationedit($id,$id1,$id2)
    {

        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $motifs = Motif::where('code_motif','EDF')->where('flag_actif_motif',true)->get();
        $autre_demande_habilitation_formation= AutreDemandeHabilitationFormation::find($id);
        $habilitation = DemandeHabilitation::find($autre_demande_habilitation_formation->id_demande_habilitation);
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

        $typeDomaineDemandeHabilitationPublic = TypeDomaineDemandeHabilitationPublic::where([['flag_type_type_domaine_demande_habilitation_public','=',true]])->get();
        $typeDomaineDemandeHabilitationPublicList = "<option value=''> Selectionnez le public </option>";
        foreach ($typeDomaineDemandeHabilitationPublic as $comp) {
            $typeDomaineDemandeHabilitationPublicList .= "<option value='" . $comp->id_type_domaine_demande_habilitation_public  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation_public) ." </option>";
        }

        $Mesformateurs = Formateurs::where([['id_entreprises','=',Auth::user()->id_partenaire]])->get();
        $MesformateursList = "<option value=''> Selectionnez le domaine de formation </option>";
        foreach ($Mesformateurs as $comp) {
            $MesformateursList .= "<option value='" . $comp->id_formateurs  . "'>" . mb_strtoupper($comp->nom_formateurs) ." ". mb_strtoupper($comp->prenom_formateurs)." </option>";
        }


        $domainedemandes = DomaineDemandeHabilitation::whereNotExists(function ($query) use ($id){
            $query->select('*')
                ->from('formateur_domaine_demande_habilitation')
                ->whereColumn('formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','=','domaine_demande_habilitation.id_domaine_demande_habilitation');
        })
            ->where('id_autre_demande','=',$id)
            ->where('domaine_demande_habilitation.id_demande_habilitation',$id1)
            ->where('flag_agree_domaine_demande_habilitation',false)
            ->where('flag_extension_domaine_demande_habilitation',true)
            ->where('flag_substitution_domaine_demande_habilitation',false)
            ->get();

        $domaine_list_demandes = DomaineDemandeHabilitation::where('id_demande_habilitation','=',$id1)
            ->where('id_autre_demande','=',$id)
            ->get();

        $domainedemandeList = "<option value=''> Selectionnez la banque </option>";
        foreach ($domainedemandes as $comp) {
            $domainedemandeList .= "<option value='" . $comp->id_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation) .' - '.mb_strtoupper($comp->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public).' - '. mb_strtoupper( $comp->domaineFormation->libelle_domaine_formation) ." </option>";
        }

        $commentairenonrecevables = CommentaireNonRecevableDemande::where([['id_demande','=',$id],['code_demande','=','RDE']])->get();


        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
            ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
            ->join('type_domaine_demande_habilitation','domaine_demande_habilitation.id_type_domaine_demande_habilitation','type_domaine_demande_habilitation.id_type_domaine_demande_habilitation')
            ->join('type_domaine_demande_habilitation_public','domaine_demande_habilitation.id_type_domaine_demande_habilitation_public','type_domaine_demande_habilitation_public.id_type_domaine_demande_habilitation_public')
            ->join('formateurs','formateur_domaine_demande_habilitation.id_formateurs','formateurs.id_formateurs')
            ->where('id_demande_habilitation','=',$id1)
            ->where('domaine_demande_habilitation.id_autre_demande','=',$id)
            ->get();

        return view('habilitation.agreement.extensiondomaineformationedit',compact('motifs',
            'id','id1','idetape','autre_demande_habilitation_formation','commentairenonrecevables',
            'typeDomaineDemandeHabilitationList',
            'habilitation',
            'domainesList','typeDomaineDemandeHabilitationPublicList',
            'domainedemandeList','formateurs','domaine_list_demandes',
            'domainedemandes',
            'MesformateursList'
        ));



//        $id =  Crypt::UrldeCrypt($id);
//        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();
//        $idetape =  Crypt::UrldeCrypt($id1);
//        $idetape =  Crypt::UrldeCrypt($id2);
//

//
//        $domaineDemandeHabilitations = DomaineDemandeHabilitation::whereNotExists(function ($query) use ($id){
//            $query->select('*')
//                ->from('domaine_autre_demande_habilitation_formation')
//                ->where('domaine_autre_demande_habilitation_formation.flag_autre_demande_habilitation_formation',false)
//                ->whereColumn('domaine_demande_habilitation.id_domaine_demande_habilitation','=','domaine_autre_demande_habilitation_formation.id_domaine_demande_habilitation');
//        })->where('domaine_demande_habilitation.id_demande_habilitation',$id)->get();
//        return view('habilitation.demande.extensiondomaineformationedit',compact('motifs','id',
//            'typeDomaineDemandeHabilitationList',
//            'domainesList','typeDomaineDemandeHabilitationPublicList',
//            'domainedemandeList',
//            'MesformateursList',
//            'idetape',
//            'domaineDemandeHabilitations'));
    }


    public function extensiondomaineformationupdate(Request $request,$id,$id1,$id2)
    {

        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        $id2 = Crypt::UrldeCrypt($id2);
        if ($request->isMethod('post')) {
            $input = $request->all();

            if ($input['action'] == 'enregistrer_info_demande') {
                $this->validate($request, [
                    'commentaire_autre_demande_habilitation_formation' => 'required',
                    'id_motif_autre_demande_habilitation_formation' => 'required',
                ], [
                    'commentaire_autre_demande_habilitation_formation.required' => 'Veuillez ajouter le commentaire de la demande d\'extension.',
                    'id_motif_autre_demande_habilitation_formation.required' => 'Veuillez ajouter un motif.',
                ]);

                if (isset($input['piece_autre_demande_habilitation_formation'])) {
                    $filefront = $input['piece_autre_demande_habilitation_formation'];
                    if ($filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                        || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                        || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG") {
                        $fileName1 = 'piece_autre_demande_habilitation_formation' . '_' . rand(111, 99999) . 'piece_autre_demande_habilitation_formation' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                        $input['piece_autre_demande_habilitation_formation'] = $fileName1;
                    }
                    AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                        'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                        'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                        'piece_autre_demande_habilitation_formation'=> $input['piece_autre_demande_habilitation_formation'],
                        'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                        'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                        'id_demande_habilitation'=> $id1,
                        'type_autre_demande'=> 'demande_extension',
                        'id_user'=> Auth::user()->id
                    ]);
                }
                else {
                    AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                        'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                        'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                        'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                        'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                        'id_demande_habilitation'=> $id1,
                        'type_autre_demande'=> 'demande_extension',
                        'id_user'=> Auth::user()->id
                    ]);
                }
                return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/extensiondomaineformationedit')->with('success', 'Succes : Demande d\'extension modifiée avec succès');
            }

            if ($input['action'] == 'enregistrer_domaine_demande') {
                $this->validate($request, [
                    'id_type_domaine_demande_habilitation' => 'required',
                    'id_type_domaine_demande_habilitation_public'=>'required',
                    'id_domaine_formation' => 'required',
                ],[
                    'id_type_domaine_demande_habilitation.required' => 'Veuillez selectionner la finalité.',
                    'id_type_domaine_demande_habilitation_public.required' => 'Veuillez selectionner le public.',
                    'id_domaine_formation.required' => 'Veuillez selectionner le domaine de formation.',
                ]);

                $domaine_exist = DomaineDemandeHabilitation::where('id_type_domaine_demande_habilitation',$request->id_type_domaine_demande_habilitation)
                    ->where('id_type_domaine_demande_habilitation_public',$request->id_type_domaine_demande_habilitation_public)
                    ->where(function ($query) {
                        $query->where('flag_extension_domaine_demande_habilitation', true)
                            ->orwhere('flag_agree_domaine_demande_habilitation',false);
                    })->where('flag_substitution_domaine_demande_habilitation',false)
                    ->where('id_domaine_formation',$request->id_domaine_formation)->first();
                if(isset($domaine_exist)){
                    return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(2) . '/extensiondomaineformationedit')->with('error', 'Erreur : Ce domaine de formation existe déjà');
                }

                $input = $request->all();
                $input['id_demande_habilitation'] = $id1;
                $input['flag_extension_domaine_demande_habilitation'] = true;
                $input['flag_agree_domaine_demande_habilitation'] = false;
                $input['id_autre_demande'] = $id;
                DomaineDemandeHabilitation::create($input);

                return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(2) . '/extensiondomaineformationedit')->with('success', 'Succes : Domaine de formation enregistrer avec succès');
            }

            if ($input['action'] == 'AjouterFormateur'){

                $this->validate($request, [
                    'id_domaine_demande_habilitation' => 'required',
                    'id_formateurs' => 'required',
                ],[
                    'id_domaine_demande_habilitation.required' => 'Veuillez selectionner le domaine de formation.',
                    'id_formateurs.required' => 'Veuillez selectionner un formateur.',
                ]);

                $input = $request->all();

                FormateurDomaineDemandeHabilitation::create($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'Habilitation (Soumission de l\'habilitation)',

                    'etat'=>'Succès',

                    'objet'=>'HABILITATION etape ajouter formateur'

                ]);
                return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(3) . '/extensiondomaineformationedit')->with('success', 'Succes : Domaine de formation enregistrer avec succès');

            }

            if ($input['action'] == 'soumettreDemandeExtension') {

                AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                    'date_soumis_autre_demande_habilitation_formation'=> Carbon::now(),
                    'flag_soumis_autre_demande_habilitation_formation'=> true
                ]);

                return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/' . Crypt::UrlCrypt($id1) .'/'. Crypt::UrlCrypt(3) . '/extensiondomaineformationedit')->with('success', 'Succes : Demande d\'extension effectuée avec succès');
            }
        }
    }


    public function deletedomaineDemandeExtension($id,$id1,$id2){

        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        $id2 = Crypt::UrldeCrypt($id2);

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::find($id2);
        $domaineDemandeHabilitations->delete();

        return redirect('agrementhabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id1).'/'.Crypt::UrlCrypt(2).'/extensiondomaineformationedit')->with('success', 'Succes : Information mise a jour  ');

    }

    public function deleteformateursDemandeExtension($id,$id1,$id2){

        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        $id2 = Crypt::UrldeCrypt($id2);

        $formateurs = FormateurDomaineDemandeHabilitation::find($id2);
        $formateurs->delete();
        return redirect('agrementhabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id1).'/'.Crypt::UrlCrypt(3).'/extensiondomaineformationedit')->with('success', 'Succes : Information mise a jour  ');

    }


    public function substitutiondomaineformation($id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])
            ->where('flag_agree_domaine_demande_habilitation',true)->get();
        $motifs = Motif::where('code_motif','SUDF')->where('flag_actif_motif',true)->get();
        return view('habilitation.agreement.substitutiondomaineformation',compact('motifs','domaineDemandeHabilitations','id'));
    }

    public function substitutiondomaineformationstore(Request $request,$id,$id1)
    {
        $id = Crypt::UrldeCrypt($id);
        $idetape = Crypt::UrldeCrypt($id1);

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'commentaire_autre_demande_habilitation_formation' => 'required',
                'id_motif_autre_demande_habilitation_formation' => 'required',
            ], [
                'commentaire_autre_demande_habilitation_formation.required' => 'Veuillez ajouter le commentaire de la demande.',
                'id_motif_autre_demande_habilitation_formation.required' => 'Veuillez ajouter un motif.',
            ]);

            $input = $request->all();
            if ($input['action'] == 'enregistrer') {
                if (isset($input['piece_autre_demande_habilitation_formation'])) {
                    $filefront = $input['piece_autre_demande_habilitation_formation'];
                    if ($filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                        || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                        || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG") {
                        $fileName1 = 'piece_autre_demande_habilitation_formation' . '_' . rand(111, 99999) . 'piece_autre_demande_habilitation_formation' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                        $input['piece_autre_demande_habilitation_formation'] = $fileName1;
                    }

                } else {
                    return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/substitutiondomaineformation')->with('error', 'Erreur : Veuillez ajouter une pièce justificatif');
                }
                $dateanneeencours = Carbon::now()->format('Y');
                $data_saving = AutreDemandeHabilitationFormation::create([
                    'code_autre_demande_habilitation_formation'=>'SUDF-'.Gencode::randStrGen(4, 5).'-'. $dateanneeencours,
                    'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                    'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                    'piece_autre_demande_habilitation_formation'=> $input['piece_autre_demande_habilitation_formation'],
                    'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                    'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                    'type_autre_demande'=> 'demande_substitution',
                    'id_demande_habilitation'=> $id,
                    'id_user'=> Auth::user()->id
                ]);
                if ($data_saving) {
                    $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::latest()->first();
                    foreach ($input['id_domaine_demande_habilitation'] as $item) {
                        DomaineAutreDemandeHabilitationFormation::create([
                                'id_domaine_demande_habilitation' => $item,
                                'id_autre_demande_habilitation_formation' => $autre_demande_habilitation_formation->id_autre_demande_habilitation_formation,
                                'flag_autre_demande_habilitation_formation' => false
                            ]
                        );
                    }
                    return redirect('agrementhabilitation/' . Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation) . '/'.Crypt::UrlCrypt($id).'/' . Crypt::UrlCrypt($idetape) . '/substitutiondomaineformationedit')->with('success', 'Succes : Demande de substitution effectuée avec succès');

                } else {
                    return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/substitutiondomaineformation')->with('error', 'Erreur : Une erreur s\'est produite');
                }
            }
            return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/substitutiondomaineformation')->with('error', 'Erreur : Une erreur s\'est produite');
        }
        return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/substitutiondomaineformation')->with('error', 'Erreur : Une erreur s\'est produite');
    }


    public function substitutiondomaineformationedit($id,$id1,$id2)
    {

        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $motifs = Motif::where('code_motif','SUDF')->where('flag_actif_motif',true)->get();
        $autre_demande_habilitation_formation= AutreDemandeHabilitationFormation::find($id);
        $habilitation = DemandeHabilitation::find($autre_demande_habilitation_formation->id_demande_habilitation);
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

        $typeDomaineDemandeHabilitationPublic = TypeDomaineDemandeHabilitationPublic::where([['flag_type_type_domaine_demande_habilitation_public','=',true]])->get();
        $typeDomaineDemandeHabilitationPublicList = "<option value=''> Selectionnez le public </option>";
        foreach ($typeDomaineDemandeHabilitationPublic as $comp) {
            $typeDomaineDemandeHabilitationPublicList .= "<option value='" . $comp->id_type_domaine_demande_habilitation_public  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation_public) ." </option>";
        }

        $Mesformateurs = Formateurs::where([['id_entreprises','=',Auth::user()->id_partenaire]])->get();
        $MesformateursList = "<option value=''> Selectionnez le domaine de formation </option>";
        foreach ($Mesformateurs as $comp) {
            $MesformateursList .= "<option value='" . $comp->id_formateurs  . "'>" . mb_strtoupper($comp->nom_formateurs) ." ". mb_strtoupper($comp->prenom_formateurs)." </option>";
        }

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();


        $domainedemandes = DomaineDemandeHabilitation::whereNotExists(function ($query) use ($id){
            $query->select('*')
                ->from('formateur_domaine_demande_habilitation')
                ->whereColumn('formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','=','domaine_demande_habilitation.id_domaine_demande_habilitation');
        })
            ->where('id_autre_demande','=',$id)
            ->where('domaine_demande_habilitation.id_demande_habilitation',$id1)
            ->where('flag_agree_domaine_demande_habilitation',false)
            ->where('flag_substitution_domaine_demande_habilitation',true)
            ->where('flag_extension_domaine_demande_habilitation',false)->get();

        $domaine_list_demandes = DomaineDemandeHabilitation::where('id_demande_habilitation','=',$id1)
            ->where('id_autre_demande','=',$id)
            ->get();

        $domainedemandeList = "<option value=''> Selectionnez la banque </option>";
        foreach ($domainedemandes as $comp) {
            $domainedemandeList .= "<option value='" . $comp->id_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation) .' - '.mb_strtoupper($comp->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public).' - '. mb_strtoupper( $comp->domaineFormation->libelle_domaine_formation) ." </option>";
        }

        $commentairenonrecevables = CommentaireNonRecevableDemande::where([['id_demande','=',$id],['code_demande','=','RDE']])->get();


        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
            ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
            ->join('type_domaine_demande_habilitation','domaine_demande_habilitation.id_type_domaine_demande_habilitation','type_domaine_demande_habilitation.id_type_domaine_demande_habilitation')
            ->join('type_domaine_demande_habilitation_public','domaine_demande_habilitation.id_type_domaine_demande_habilitation_public','type_domaine_demande_habilitation_public.id_type_domaine_demande_habilitation_public')
            ->join('formateurs','formateur_domaine_demande_habilitation.id_formateurs','formateurs.id_formateurs')
            ->where('id_demande_habilitation','=',$id1)
            ->where('domaine_demande_habilitation.id_autre_demande','=',$id)
            ->get();

        return view('habilitation.agreement.substitutiondomaineformationedit',compact('motifs',
            'id','id1','idetape','autre_demande_habilitation_formation','commentairenonrecevables',
            'typeDomaineDemandeHabilitationList','domaineDemandeHabilitations',
            'habilitation',
            'domainesList','typeDomaineDemandeHabilitationPublicList',
            'domainedemandeList','formateurs','domaine_list_demandes',
            'domainedemandes',
            'MesformateursList'
        ));

    }


    public function substitutiondomaineformationupdate(Request $request,$id,$id1,$id2)
    {

        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        $id2 = Crypt::UrldeCrypt($id2);
        if ($request->isMethod('post')) {
            $input = $request->all();
            if ($input['action'] == 'enregistrer_info_demande') {

                if (count($input['id_domaine_demande_habilitation']) > 0) {

                    if (isset($input['piece_autre_demande_habilitation_formation'])) {
                        $filefront = $input['piece_autre_demande_habilitation_formation'];
                        if ($filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "png"
                            || $filefront->extension() == "jpg" || $filefront->extension() == "jpeg" || $filefront->extension() == "PNG"
                            || $filefront->extension() == "JPG" || $filefront->extension() == "JPEG") {
                            $fileName1 = 'piece_autre_demande_habilitation_formation' . '_' . rand(111, 99999) . 'piece_autre_demande_habilitation_formation' . time() . '.' . $filefront->extension();
                            $filefront->move(public_path('pieces/demande_suppression_domaine/'), $fileName1);
                            $input['piece_autre_demande_habilitation_formation'] = $fileName1;
                        }
                        $data_saving = AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                            'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                            'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                            'piece_autre_demande_habilitation_formation'=> $input['piece_autre_demande_habilitation_formation'],
                            'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                            'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                            'id_demande_habilitation'=> $id1,
                            'id_user'=> Auth::user()->id
                        ]);
                    }
                    else {
                        $data_saving = AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                            'id_motif_autre_demande_habilitation_formation'=> $input['id_motif_autre_demande_habilitation_formation'],
                            'commentaire_autre_demande_habilitation_formation'=> $input['commentaire_autre_demande_habilitation_formation'],
                            'date_enregistrer_autre_demande_habilitation_formation'=> Carbon::now(),
                            'flag_enregistrer_autre_demande_habilitation_formation'=> true,
                            'id_demande_habilitation'=> $id1,
                            'id_user'=> Auth::user()->id
                        ]);
                    }

                    if ($data_saving) {

                        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::latest()->first();

                        $deleteDomaineDemandeSuppressions = DomaineAutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->get();
                        foreach ($deleteDomaineDemandeSuppressions as $deleteDomaineDemandeSuppression) {
                            $deleteDomaineDemandeSuppression->delete();
                        }


                        foreach ($input['id_domaine_demande_habilitation'] as $item) {

                            DomaineAutreDemandeHabilitationFormation::create([
                                    'id_domaine_demande_habilitation' => $item,
                                    'id_autre_demande_habilitation_formation' => $autre_demande_habilitation_formation->id_autre_demande_habilitation_formation,
                                    'flag_autre_demande_habilitation_formation' => false
                                ]
                            );

                        }

                        return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/substitutiondomaineformationedit'

                        )->with('success', 'Succes : Demande de substitution modifiée avec succès');

                    } else {
                        return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/substitutiondomaineformationedit')->with('error', 'Erreur : Une erreur s\'est produite');
                    }

                } else {
                    return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(1) . '/substitutiondomaineformationedit')->with('error', 'Erreur : Une erreur s\'est produite');
                }
            }

            if ($input['action'] == 'enregistrer_domaine_demande') {
                $this->validate($request, [
                    'id_type_domaine_demande_habilitation' => 'required',
                    'id_type_domaine_demande_habilitation_public'=>'required',
                    'id_domaine_formation' => 'required',
                ],[
                    'id_type_domaine_demande_habilitation.required' => 'Veuillez selectionner la finalité.',
                    'id_type_domaine_demande_habilitation_public.required' => 'Veuillez selectionner le public.',
                    'id_domaine_formation.required' => 'Veuillez selectionner le domaine de formation.',
                ]);

                $domaine_exist = DomaineDemandeHabilitation::where('id_type_domaine_demande_habilitation',$request->id_type_domaine_demande_habilitation)
                    ->where('id_type_domaine_demande_habilitation_public',$request->id_type_domaine_demande_habilitation_public)
                    ->where(function ($query) {
                        $query->where('flag_substitution_domaine_demande_habilitation',true)
                        ->orwhere('flag_agree_domaine_demande_habilitation',false);
                    })->where('flag_extension_domaine_demande_habilitation', false)
                    ->where('id_domaine_formation',$request->id_domaine_formation)->first();
                if(isset($domaine_exist)){
                    return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(2) . '/substitutiondomaineformationedit')->with('error', 'Erreur : Ce domaine de formation existe déjà');
                }

                $input = $request->all();
                $input['id_demande_habilitation'] = $id1;
                $input['flag_extension_domaine_demande_habilitation'] = false;
                $input['flag_substitution_domaine_demande_habilitation'] = true;
                $input['flag_agree_domaine_demande_habilitation'] = false;
                $input['id_autre_demande'] = $id;
                DomaineDemandeHabilitation::create($input);

                return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(2) . '/substitutiondomaineformationedit')->with('success', 'Succes : Domaine de formation enregistrer avec succès');
            }

            if ($input['action'] == 'AjouterFormateur'){

                $this->validate($request, [
                    'id_domaine_demande_habilitation' => 'required',
                    'id_formateurs' => 'required',
                ],[
                    'id_domaine_demande_habilitation.required' => 'Veuillez selectionner le domaine de formation.',
                    'id_formateurs.required' => 'Veuillez selectionner un formateur.',
                ]);

                $input = $request->all();

                FormateurDomaineDemandeHabilitation::create($input);

                Audit::logSave([
                    'action'=>'MISE A JOUR',
                    'code_piece'=>$id,
                    'menu'=>'Habilitation (Soumission de l\'habilitation)',
                    'etat'=>'Succès',
                    'objet'=>'HABILITATION etape ajouter formateur'
                ]);

                return redirect('agrementhabilitation/'. Crypt::UrlCrypt($id).'/'. Crypt::UrlCrypt($id1).'/' . Crypt::UrlCrypt(3) . '/extensiondomaineformationedit')->with('success', 'Succes : Domaine de formation enregistrer avec succès');
            }

            if ($input['action'] == 'soumettreDemandeExtension') {

                AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                    'date_soumis_autre_demande_habilitation_formation'=> Carbon::now(),
                    'flag_soumis_autre_demande_habilitation_formation'=> true
                ]);
                return redirect('agrementhabilitation/' . Crypt::UrlCrypt($id) . '/' . Crypt::UrlCrypt($id1) .'/'. Crypt::UrlCrypt(3) . '/substitutiondomaineformationedit')->with('success', 'Succes : Demande de substitution effectuée avec succès');
            }
        }
    }

    public function deletedomaineDemandeSubstitution($id,$id1,$id2){

        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        $id2 = Crypt::UrldeCrypt($id2);

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::find($id2);
        $domaineDemandeHabilitations->delete();

        return redirect('agrementhabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id1).'/'.Crypt::UrlCrypt(2).'/substituiondomaineformationedit')->with('success', 'Succes : Information mise a jour  ');

    }

    public function deleteformateursDemandeSubstitution($id,$id1,$id2){

        $id = Crypt::UrldeCrypt($id);
        $id1 = Crypt::UrldeCrypt($id1);
        $id2 = Crypt::UrldeCrypt($id2);

        $formateurs = FormateurDomaineDemandeHabilitation::find($id2);
        $formateurs->delete();
        return redirect('agrementhabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id1).'/'.Crypt::UrlCrypt(3).'/substituiondomaineformationedit')->with('success', 'Succes : Information mise a jour  ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function showformateur(string $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        $formateur = Formateurs::find($id);

        $qualification = PrincipaleQualification::where([['id_formateurs','=',$id]])->first();

        $formations = FormationsEduc::where([['id_formateurs','=',$id]])->get();

        $experiences = Experiences::where([['id_formateurs','=',$id]])->orderBy('date_de_debut', 'DESC')->get();

        $competences = Competences::where([['id_formateurs','=',$id]])->get();

        $languesformateurs = LanguesFormateurs::where([['id_formateurs','=',$id]])->get();

        Audit::logSave([
            'action'=>'Voir',
            'code_piece'=>$id,
            'menu'=>'FORMATEUR (CREATION DE FORMATEUR)',
            'etat'=>'Succès',
            'objet'=>'Voir le cv'
        ]);

        return view('habilitation.agreement.showformateur', compact('id','formateur','qualification',
            'formations','experiences','languesformateurs','competences'));
    }


}
