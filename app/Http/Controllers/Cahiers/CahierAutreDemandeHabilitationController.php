<?php

namespace App\Http\Controllers\Cahiers;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Http\Controllers\Controller;
use App\Models\Banque;
use App\Models\CahierAutreDemandeHabilitation;
use App\Models\CommentaireNonRecevableDemande;
use App\Models\AutreDemandeHabilitationFormation;
use App\Models\Competences;
use App\Models\DemandeHabilitation;
use App\Models\Direction;
use App\Models\DomaineDemandeHabilitation;
use App\Models\DomaineFormation;
use App\Models\Entreprises;
use App\Models\Experiences;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\Formateurs;
use App\Models\FormationsEduc;
use App\Models\LanguesFormateurs;
use App\Models\LigneCahierAutreDemandeHabilitation;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PrincipaleQualification;
use App\Models\ProcessusAutreDemande;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeDomaineDemandeHabilitationPublic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GenerateCode as Gencode;
use Illuminate\Support\Facades\DB;

class CahierAutreDemandeHabilitationController extends Controller
{
    //
    public function index()
    {
        $cahiers = CahierAutreDemandeHabilitation::all();

        Audit::logSave([
            'action'=>'INDEX',
            'code_piece'=>'',
            'menu'=>'CAHIERS (Cahier des demandes extension et sub substitution )',
            'etat'=>'Succès',
            'objet'=>'CAHIERS'
        ]);


        return view("cahiers.cahier_autre_demande_habilitation.index", compact("cahiers"));
    }

    public function create()
    {
        $processusautre_demandes = ProcessusAutreDemande::where([['flag_processus_autre_demande','=',true]])->orderBy('libelle_processus_autre_demande')->get();
        $processusautre_demandesListe = "<option value=''> Selectionnez le/les processus </option>";
        foreach ($processusautre_demandes as $comp) {
            $processusautre_demandesListe .= "<option value='" . $comp->id_processus_autre_demande . "'>" . mb_strtoupper($comp->libelle_processus_autre_demande) . " </option>";
        }

        Audit::logSave([
            'action'=>'CREER',
            'code_piece'=>'',
            'menu'=>'CAHIERS (Cahier des demandes extension et sub substitution )',
            'etat'=>'Succès',
            'objet'=>'CAHIERS'
        ]);

        return view("cahiers.cahier_autre_demande_habilitation.create",compact('processusautre_demandesListe'));
    }


    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'id_processus_autre_demande' => 'required',
                'commentaire_cahier_autre_demande_habilitations' => 'required'
            ],[
                'id_processus_autre_demande.required' => 'Veuillez selection la demande.',
                'commentaire_cahier_autre_demande_habilitations.after_or_equal' => 'Veuillez ajouter un commentaire .'
            ]);


            $input = $request->all();
            $processus = ProcessusAutreDemande::find($input['id_processus_autre_demande']);
            $input['code_cahier_autre_demande_habilitations'] = $processus->code_processus_autre_demande.'-'. Gencode::randStrGen(4, 5).'-'.Carbon::now()->format('Y');

            $input['id_users_cahier_autre_demande_habilitations'] = Auth::user()->id;
            $input['date_creer_cahier_autre_demande_habilitations'] = Carbon::now();
            $input['code_pieces_cahier_autre_demande_habilitations'] = $processus->code_processus_autre_demande;
            $input['id_processus_autre_demande'] = $processus->latest()->first()->id_processus_autre_demande;

            $cahier = CahierAutreDemandeHabilitation::create($input);

            $insertedId = $cahier->latest()->first()->id_cahier_autre_demande_habilitations;

            Audit::logSave([
                'action'=>'CREATION',
                'code_piece'=>$insertedId,
                'menu'=>'CAHIERS (Cahier des demandes extension et sub substitution )',
                'etat'=>'Succès',
                'objet'=>'CAHIERS'
            ]);

            return redirect('cahierautredemandehabilitations/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');

        }
    }


    public function edit($id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $cahier = CahierAutreDemandeHabilitation::find($id);

        $processusautre_demandes = ProcessusAutreDemande::where([['flag_processus_autre_demande','=',true]])->orderBy('libelle_processus_autre_demande')->get();
        $processusAutreDemandesListe = "<option value='".$cahier->processusAutreDemande->id_processus_autre_demande."'> ".$cahier->processusAutreDemande->libelle_processus_autre_demande." </option>";
        foreach ($processusautre_demandes as $comp) {
            $processusAutreDemandesListe .= "<option value='" . $comp->id_processus_autre_demande . "'>" . mb_strtoupper($comp->libelle_processus_autre_demande) . " </option>";
        }


            $demandes = DB::table('vue_autre_demande_habilitation_disponible_pour_cahier')->whereNotExists(function ($query) use ($id){
                $query->select('*')
                    ->from('ligne_cahier_autre_demande_habilitations')
                    ->whereColumn('ligne_cahier_autre_demande_habilitations.id_demande','=','vue_autre_demande_habilitation_disponible_pour_cahier.id_demande')
                    ->where('ligne_cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations',$id);
            })
                ->where('vue_autre_demande_habilitation_disponible_pour_cahier.code_processus','=',$cahier->processusAutreDemande->code_processus_autre_demande)

                ->get();


        $cahierautredemandehabilitations = DB::table('vue_autre_demande_habilitation_disponible_pour_cahier_traiter as vppdpct')
            ->join('ligne_cahier_autre_demande_habilitations','vppdpct.id_demande','ligne_cahier_autre_demande_habilitations.id_demande')
            ->join('cahier_autre_demande_habilitations','ligne_cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations','cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations')
            ->where('cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations',$id)
            ->where('vppdpct.code_processus','=',$cahier->processusAutreDemande->code_processus_autre_demande)
            ->get();

        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id.'/ etape('.$idetape.')',
            'menu'=>'CAHIERS (Cahier de plan et/ou projets )',
            'etat'=>'Succès',
            'objet'=>'CAHIERS'
        ]);

        return view("cahiers.cahier_autre_demande_habilitation.edit",compact('processusAutreDemandesListe','cahierautredemandehabilitations','id','idetape','cahier','demandes'));
    }


    public function notetechnique($id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $cahier = CahierAutreDemandeHabilitation::find($id);

        if(isset($cahier->id_processus_cahier_autre_demande_habilitations)){
            $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
                ->select('v.name as name','users.name as nom','users.prenom_users as prenom_users', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide','v.comment_parcours', 'v.id_processus')
                ->leftjoin('users','users.id','v.id_user')
                ->where('v.id_processus', '=', $cahier->id_processus_cahier_autre_demande_habilitations)
                ->where('v.id_demande', '=', $cahier->id_cahier_autre_demande_habilitations)
                ->orderBy('v.priorite_combi_proc', 'ASC')
                ->get();

        }else{
            $ResultProssesList = [];
        }


//
//        dd($cahier);
//        Auth::user()->direction->libelle_direction;
//
//
//        $departement = Direction::join('departement','direction.id_direction','departement.id_direction')->where([
//            ['direction.id_direction','=','1'],['departement.flag_departement','=',true]
//        ])->first();

        $cahierautredemandehabilitations = DB::table('vue_autre_demande_habilitation_disponible_pour_cahier_traiter as vppdpct')
            ->join('ligne_cahier_autre_demande_habilitations','vppdpct.id_demande','ligne_cahier_autre_demande_habilitations.id_demande')
            ->join('cahier_autre_demande_habilitations','ligne_cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations','cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations')
            ->join('autre_demande_habilitation_formation','autre_demande_habilitation_formation.id_autre_demande_habilitation_formation','ligne_cahier_autre_demande_habilitations.id_demande')
            ->join('users','autre_demande_habilitation_formation.id_chef_service','users.id')
            ->join('direction','users.id_direction','direction.id_direction')
            ->join('departement','users.id_departement','departement.id_departement')
            ->where('cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations',$id)
            ->where('vppdpct.code_processus','=',$cahier->processusAutreDemande->code_processus_autre_demande)
            ->get();
        return view("cahiers.cahier_autre_demande_habilitation.notetechnique",compact('cahier','ResultProssesList','cahierautredemandehabilitations','id'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'id_processus_autre_demande' => 'required',
                    'commentaire_cahier_autre_demande_habilitations' => 'required'
                ],[
                    'id_processus_autre_demande.required' => 'Veuillez selection la demande.',
                    'commentaire_cahier_autre_demande_habilitations.after_or_equal' => 'Veuillez ajouter un commentaire .'
                ]);

                $input = $request->all();
                $processus = ProcessusAutreDemande::find($input['id_processus_autre_demande']);
                $input['code_cahier_autre_demande_habilitations'] = $processus->code_processus_autre_demande.'-'. Gencode::randStrGen(4, 5).'-'.Carbon::now()->format('Y');

                $input['id_users_cahier_autre_demande_habilitations'] = Auth::user()->id;
                $input['date_creer_cahier_autre_demande_habilitations'] = Carbon::now();
                $input['code_pieces_cahier_autre_demande_habilitations'] = $processus->code_processus_autre_demande;
                $input['id_processus_autre_demande'] = $processus->latest()->first()->id_processus_autre_demande;

                $cahier = CahierAutreDemandeHabilitation::find($id);
                $cahier->update($input);

                $insertedId = $cahier->latest()->first()->id_cahier_autre_demande_habilitations;

                Audit::logSave([
                   'action'=>'MISE A JOUR',
                    'code_piece'=>$insertedId,
                    'menu'=>'CAHIERS (Cahier des demandes extension et sub substitution )',
                    'etat'=>'Succès',
                    'objet'=>'CAHIERS'
                ]);
                return redirect('cahierautredemandehabilitations/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
            }

            if ($data['action'] == 'Ajouter_cahier_autre_demande_habilitation'){
                $cahier = CahierAutreDemandeHabilitation::find($id);
                $input = $request->all();

                if(isset($input['demande'])){

                    $verifnombre = count($input['demande']);

                    if($verifnombre < 1){
                        Audit::logSave([
                            'action'=>'MISE A JOUR',
                            'code_piece'=>$id,
                            'menu'=>'CAHIERS (Cahier de plan et/ou projets : Vous devez sélectionner au moins un plan/projet.)',
                            'etat'=>'Echec',
                            'objet'=>'CAHIERS'
                        ]);

                        return redirect('cahierautredemandehabilitations/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins une demande. ');
                    }

                    $tab = $input['demande'];

                    foreach ($tab as $key => $value) {

                        LigneCahierAutreDemandeHabilitation::create([
                            'id_cahier_autre_demande_habilitations'=> $id,
                            'id_demande'=> $value,
                        ]);

                        $demande = AutreDemandeHabilitationFormation::find($value);
                        $demande->flag_passer_cahier = true;
                        $demande->date_passer_cahier = Carbon::now();
                        $demande->update();
                    }

                    Audit::logSave([
                        'action'=>'MISE A JOUR',
                        'code_piece'=>$id,
                        'menu'=>'CAHIERS (Cahier de '.@$cahier->code_cahier_autre_demande_habilitations.' pour le '.@$cahier->processusComite->libelle_processus_comite.' )',
                        'etat'=>'Succès',
                        'objet'=>'CAHIERS'
                    ]);
                    return redirect('cahierautredemandehabilitations/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
                }else{

                    Audit::logSave([
                        'action'=>'MISE A JOUR',
                        'code_piece'=>$id,
                        'menu'=>'CAHIERS (Cahier de plan et/ou projets : Vous devez sélectionner au moins un plan/projet.)',
                        'etat'=>'Echec',
                        'objet'=>'CAHIERS'
                    ]);

                    return redirect('cahierautredemandehabilitations/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins une demande. ');
                }

            }


            if ($data['action'] == 'Traiter_cahier_autre_demande_habilitation'){
                $cahier = CahierAutreDemandeHabilitation::find($id);

                $lignecahiers = LigneCahierAutreDemandeHabilitation::where([['id_cahier_autre_demande_habilitations','=',$id]])->get();

                foreach ($lignecahiers as $lignecahier) {
                    $li = LigneCahierAutreDemandeHabilitation::find($lignecahier->id_ligne_cahier_autre_demande_habilitations);
                    $li->update([
                        'flag_statut_soumis_ligne_cahier_autre_demande_habilitations' => true
                    ]);

                    $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$li->id_demande)->first();
                    $autre_demande_habilitation_formation->update();
                }

                $cahier->update([
                    'id_processus_cahier_autre_demande_habilitations' => 13,
                    'flag_statut_cahier_autre_demande_habilitations' => true,
                    'date_soumis_cahier_autre_demande_habilitations' => Carbon::now()
                ]);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'CAHIERS (Cahier de plan et/ou projets )',

                    'etat'=>'Succès',

                    'objet'=>'CAHIERS'

                ]);

                return redirect('cahierautredemandehabilitations/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Note technique générée et soumis pour validation ');

            }

        }
    }



    public function show($id,$id1)
    {

        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        $motifs = Motif::where('code_motif','EDF')->where('flag_actif_motif',true)->get();
        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::find($id);
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
            ->where('domaine_demande_habilitation.id_demande_habilitation',$autre_demande_habilitation_formation->id_demande_habilitation)
            ->where('flag_agree_domaine_demande_habilitation',false)
            ->where('flag_extension_domaine_demande_habilitation',true)->get();

        $domaine_list_demandes = DomaineDemandeHabilitation::where('id_demande_habilitation','=',$autre_demande_habilitation_formation->id_demande_habilitation)
            ->where('id_autre_demande','=',$id)
            ->where('flag_agree_domaine_demande_habilitation',false)
            ->where('flag_extension_domaine_demande_habilitation',true)->get();


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
            ->where('id_demande_habilitation','=',$autre_demande_habilitation_formation->id_demande_habilitation)
            ->where('domaine_demande_habilitation.id_autre_demande','=',$id)
            ->get();

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$habilitation->banque->id_banque."'> ".mb_strtoupper($habilitation->banque->libelle_banque)." </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }


        $infoentreprise = Entreprises::find($habilitation->id_entreprises);
        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $payList = "<option value=''> Selectionnez un pays</option>";
        foreach ($pays as $comp) {
            $payList .= "<option value='" . $comp->id_pays  . "'>" . $comp->libelle_pays ." </option>";
        }


        return view('cahiers.cahier_autre_demande_habilitation.show',compact('motifs',
            'id','idetape','autre_demande_habilitation_formation','commentairenonrecevables',
            'typeDomaineDemandeHabilitationList',
            'domainesList','typeDomaineDemandeHabilitationPublicList',
            'domainedemandeList','formateurs','domaine_list_demandes',
            'domainedemandes','habilitation',
            'pay','banque',
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

        return view('cahiers.cahier_autre_demande_habilitation.showformateur', compact('id','formateur','qualification',
            'formations','experiences','languesformateurs','competences'));
    }

}
