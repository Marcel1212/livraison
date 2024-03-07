<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\InfosEntreprise;
use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Entreprises;
use App\Models\FormeJuridique;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\User;
use DB;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class ProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Récupérer l'utilisateur connecté
        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);

        if(isset($infoentreprise)){
            //Récupérer les projets d'études soumis par une entreprise
            $projet_etudes = ProjetEtude::where([['id_entreprises','=',$infoentreprise->id_entreprises]])->get();

            Audit::logSave([
                'action'=>'VISITE',
                'code_piece'=>'',
                'menu'=>'DEMANDES PROJET ETUDE',
                'etat'=>'Succès',
                'objet'=>'PROJET ETUDE'
            ]);

            return view('projetetudes.demande.index',compact('projet_etudes'));
        }else{
            return redirect('/dashboard')->with('Error', 'Erreur : Vous n\'est autoriser a acces a ce menu');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pays = Pays::where('flag_actif_pays',true)->get();
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);

        $formjuridique = "<option value='".$infoentreprise->formeJuridique->id_forme_juridique."'> " . $infoentreprise->formeJuridique->libelle_forme_juridique . "</option>";

        foreach ($formjuridiques as $comp) {
            $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
        }

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

        /******************** secteuractivites *********************************/
        $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
            ->orderBy('libelle_secteur_activite')
            ->get();
        $secteuractivite_projet = "<option value=''> Selectionnez un secteur activité </option>";
        foreach ($secteuractivite_projets as $comp) {
            $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
        }

        Audit::logSave([
            'action'=>'VISITE',
            'code_piece'=>'',
            'menu'=>'CREATION DEMANDES PROJET ETUDE',
            'etat'=>'Succès',
            'objet'=>'PROJET ETUDE'
        ]);

        return view('projetetudes.demande.create', compact('formjuridique','infoentreprise','secteuractivite_projet','pay','secteuractivites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'titre_projet' => 'required',
                'contexte_probleme' => 'required',
                'objectif_general' => 'required',
                'objectif_specifique' => 'required',
                'resultat_attendu' => 'required',
                'champ_etude' => 'required',
                'cible' => 'required',
                'id_secteur_activite' => 'required',

            ],[
                'titre_projet.required' => 'Veuillez ajouter un titre de projet',
                'contexte_probleme.required' => 'Veuillez ajouter un context ou problemes constaté',
                'objectif_general.required' => 'Veuillez ajouter un objectif general',
                'objectif_specifique.required' => 'Veuillez ajouter un objectif specifiques',
                'resultat_attendu.required' => 'Veuillez ajouter un resultat attendu',
                'champ_etude.required' => 'Veuillez ajouter un champ d&quot;etude',
                'cible.required' => 'Veuillez ajouter une cible',
                'id_secteur_activite.required' => 'Veuillez ajouter un secteur d\'activité',

            ]);
            $user = User::find(Auth::user()->id);
            $user_id = Auth::user()->id;
            $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);
            $id_entreprise = $entreprise->id_entreprises;
            $projet_etude = new ProjetEtude();
            $projet_etude->code_projet_etude = 'PE-' . Gencode::randStrGen(4, 5);
            $projet_etude->titre_projet_etude = $request->titre_projet;
            $projet_etude->contexte_probleme_projet_etude = $request->contexte_probleme;
            $projet_etude->objectif_general_projet_etude = $request->objectif_general;
            $projet_etude->objectif_specifique_projet_etud = $request->objectif_specifique;
            $projet_etude->resultat_attendu_projet_etude = $request->resultat_attendu;
            $projet_etude->champ_etude_projet_etude = $request->champ_etude;
            $projet_etude->cible_projet_etude = $request->cible;
            $projet_etude->id_secteur_activite = $request->id_secteur_activite;
            $projet_etude->flag_soumis = false;
            $projet_etude->flag_valide = false;
            $projet_etude->flag_rejet = false;
            $projet_etude->flag_validation_selection_operateur = false;
            $projet_etude->flag_soumis_chef_service = false;
            $projet_etude->flag_valider_ct_pleniere_projet_etude=false;
            $projet_etude->flag_soumis_ct_pleniere = false;
            $projet_etude->flag_soumis_chef_depart = false;
            $projet_etude->flag_recevablite_projet_etude = false;
            $projet_etude->flag_attente_rec = false;
            $projet_etude->flag_rejet = false;
            $projet_etude->id_user = $user_id;
            $projet_etude->id_entreprises = $id_entreprise;
            $projet_etude->code_dossier = $id_entreprise;
            $projet_etude->save();
            $insertedId = ProjetEtude::latest()->first()->id_projet_etude;
            if ($request->action== 'Enregister'){
                Audit::logSave([
                    'action'=>'CREATION',
                    'code_piece'=>$insertedId,
                    'menu'=>'CREATION DEMANDES PROJET ETUDE',
                    'etat'=>'Succès',
                    'objet'=>'PROJET ETUDE'
                ]);
                return redirect('projetetude/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }

            if ($request->action == 'Enregistrer_suivant'){
                return redirect('projetetude/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Enregistrement reussi ');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$id_etape)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id_etape =  Crypt::UrldeCrypt($id_etape);
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

                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
                foreach ($secteuractivite_projets as $comp) {
                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }

                Audit::logSave([
                    'action'=>'VISITE',
                    'code_piece'=>$projet_etude->id_projet_etude,
                    'menu'=>'MODIFICATION DEMANDES PROJET ETUDE',
                    'etat'=>'Succès',
                    'objet'=>'PROJET ETUDE'
                ]);

                return view('projetetudes.demande.edit', compact('id_etape',
                    'avant_projet_tdr',
                    'courier_demande_fin',
                    'dossier_intention',
                    'lettre_engagement',
                    'offre_technique',
                    'offre_financiere',
                    'secteuractivite',
                    'secteuractivite_projet',
                    'pieces_projets',
                    'projet_etude',
                    'infoentreprise',
                    'pay'));
            }
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id,$id_etape)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id_etape =  Crypt::UrldeCrypt($id_etape);

        if ($request->isMethod('put')) {
            $projet_etude = ProjetEtude::find($id);
            $piece_etude = new PiecesProjetEtude();
            if ($request->action == 'Modifier'){

                $this->validate($request, [
                    'titre_projet' => 'required',
                    'contexte_probleme' => 'required',
                    'objectif_general' => 'required',
                    'objectif_specifique' => 'required',
                    'resultat_attendu' => 'required',
                    'champ_etude' => 'required',
                    'cible' => 'required',
                    'id_secteur_activite' => 'required',
                ],[
                    'titre_projet.required' => 'Veuillez ajouter un titre de projet',
                    'contexte_probleme.required' => 'Veuillez ajouter un context ou problemes constaté',
                    'objectif_general.required' => 'Veuillez ajouter un objectif general',
                    'objectif_specifique.required' => 'Veuillez ajouter un objectif specifiques',
                    'resultat_attendu.required' => 'Veuillez ajouter un resultat attendu',
                    'champ_etude.required' => 'Veuillez ajouter un champ d&quot;etude',
                    'cible.required' => 'Veuillez ajouter une cible',
                    'id_secteur_activite.required' => 'Veuillez ajouter un secteur d\'activité',
                ]);

                $user = User::find(Auth::user()->id);
                $user_id = Auth::user()->id;
                $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);
                $projet_etude = ProjetEtude::find($id);
                $projet_etude->titre_projet_etude = $request->titre_projet;
                $projet_etude->contexte_probleme_projet_etude = $request->contexte_probleme;
                $projet_etude->objectif_general_projet_etude = $request->objectif_general;
                $projet_etude->objectif_specifique_projet_etud = $request->objectif_specifique;
                $projet_etude->resultat_attendu_projet_etude = $request->resultat_attendu;
                $projet_etude->champ_etude_projet_etude = $request->champ_etude;
                $projet_etude->cible_projet_etude = $request->cible;
                $projet_etude->id_secteur_activite = $request->id_secteur_activite;

                $projet_etude->update();

                Audit::logSave([
                    'action'=>'MODIFICATION',
                    'code_piece'=>$projet_etude->id_projet_etude,
                    'menu'=>'MODIFICATION PROJET ETUDE',
                    'etat'=>'Succès',
                    'objet'=>'PROJET ETUDE'
                ]);

                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
            }
            if ($request->action == 'Modifier_suivant'){

                $this->validate($request, [
                    'titre_projet' => 'required',
                    'contexte_probleme' => 'required',
                    'objectif_general' => 'required',
                    'objectif_specifique' => 'required',
                    'resultat_attendu' => 'required',
                    'champ_etude' => 'required',
                    'cible' => 'required',
                    'id_secteur_activite' => 'required',
                ],[
                    'titre_projet.required' => 'Veuillez ajouter un titre de projet',
                    'contexte_probleme.required' => 'Veuillez ajouter un context ou problemes constaté',
                    'objectif_general.required' => 'Veuillez ajouter un objectif general',
                    'objectif_specifique.required' => 'Veuillez ajouter un objectif specifiques',
                    'resultat_attendu.required' => 'Veuillez ajouter un resultat attendu',
                    'champ_etude.required' => 'Veuillez ajouter un champ d&quot;etude',
                    'cible.required' => 'Veuillez ajouter une cible',
                    'id_secteur_activite.required' => 'Veuillez ajouter un secteur d\'activité',
                ]);

                $user = User::find(Auth::user()->id);
                $user_id = Auth::user()->id;
                $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);
                $projet_etude = ProjetEtude::find($id);
                $projet_etude->titre_projet_etude = $request->titre_projet;
                $projet_etude->contexte_probleme_projet_etude = $request->contexte_probleme;
                $projet_etude->objectif_general_projet_etude = $request->objectif_general;
                $projet_etude->objectif_specifique_projet_etud = $request->objectif_specifique;
                $projet_etude->resultat_attendu_projet_etude = $request->resultat_attendu;
                $projet_etude->champ_etude_projet_etude = $request->champ_etude;
                $projet_etude->cible_projet_etude = $request->cible;
                $projet_etude->id_secteur_activite = $request->id_secteur_activite;
                $projet_etude->update();

                Audit::logSave([
                    'action'=>'MODIFICATION',
                    'code_piece'=>$projet_etude->id_projet_etude,
                    'menu'=>'MODIFICATION PROJET ETUDE',
                    'etat'=>'Succès',
                    'objet'=>'PROJET ETUDE'
                ]);

                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Information mise a jour reussi ');
            }

            if($request->action=='Enregistrer_fichier'){
                $this->validate($request, [
                    'type_pieces' => 'required',
                    'pieces' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120'
                ],[
                    'type_pieces' => 'Veuillez sélectionner un type de pièce',
                    'pieces.required' => 'Veuillez ajouter une pièce',
                ]);

                if($request->type_pieces=='avant_projet_tdr'){
                    $avant_projet_tdr = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                        ->where('code_pieces','avant_projet_tdr')->first();
                    if(isset($avant_projet_tdr)) {
                        return redirect()->back()->with('error', 'Impossible d\'enregistrer le même type de fichier 2 fois');
                    }
                    if(isset($request->pieces)){
                        $filefront = $request->pieces;
                        $filename = 'avant_projet_tdr'. '_' . rand(111,99999) . '_' . 'avant_projet_tdr' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces_projet/avant_projet_tdr/'), $filename);
                        $piece_etude->libelle_pieces = $filename;
                        $piece_etude->id_projet_etude = $projet_etude->id_projet_etude;
                        $piece_etude->code_pieces ='avant_projet_tdr' ;
                        $piece_etude->save();

                        $insertedId = PiecesProjetEtude::latest()->first()->id_pieces_projet_etude;

                        Audit::logSave([
                            'action'=>'CREATION',
                            'code_piece'=>$insertedId,
                            'menu'=>'CREATION PIECE PROJET ETUDE',
                            'etat'=>'Succès',
                            'objet'=>'PIECE PROJET ETUDE'
                        ]);

                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Enregistrement du fichier reussi ');

                    }
                }

                if($request->type_pieces=='courier_demande_fin'){
                    $courier_demande_fin = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                        ->where('code_pieces','courier_demande_fin')->first();
                    if(isset($courier_demande_fin)) {
                        return redirect()->back()->with('error', 'Impossible d\'enregistrer le même type de fichier 2 fois');
                    }
                    if(isset($request->pieces)){
                        $filefront = $request->pieces;
                        $filename = 'courier_demande_fin'. '_' . rand(111,99999) . '_' . 'courier_demande_fin' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces_projet/courier_demande_fin/'), $filename);
                        $piece_etude->libelle_pieces = $filename;
                        $piece_etude->id_projet_etude = $projet_etude->id_projet_etude;
                        $piece_etude->code_pieces ='courier_demande_fin' ;
                        $piece_etude->save();

                        $insertedId = PiecesProjetEtude::latest()->first()->id_pieces_projet_etude;


                        Audit::logSave([
                            'action'=>'CREATION',
                            'code_piece'=>$insertedId,
                            'menu'=>'CREATION PIECE PROJET ETUDE',
                            'etat'=>'Succès',
                            'objet'=>'PIECE PROJET ETUDE'
                        ]);

                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Enregistrement du fichier reussi ');

                    }
                }

                if($request->type_pieces=='dossier_intention'){
                    $dossier_intention = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                        ->where('code_pieces','dossier_intention')->first();
                    if(isset($dossier_intention)) {
                        return redirect()->back()->with('error', 'Impossible d\'enregistrer le même type de fichier 2 fois');
                    }
                    if(isset($request->pieces)){
                        $filefront = $request->pieces;
                        $filename = 'dossier_intention'. '_' . rand(111,99999) . '_' . 'dossier_intention' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces_projet/dossier_intention/'), $filename);
                        $piece_etude->libelle_pieces = $filename;
                        $piece_etude->id_projet_etude = $projet_etude->id_projet_etude;
                        $piece_etude->code_pieces ='dossier_intention' ;
                        $piece_etude->save();

                        $insertedId = PiecesProjetEtude::latest()->first()->id_pieces_projet_etude;

                        Audit::logSave([
                            'action'=>'CREATION',
                            'code_piece'=>$insertedId,
                            'menu'=>'CREATION PIECE PROJET ETUDE',
                            'etat'=>'Succès',
                            'objet'=>'PIECE PROJET ETUDE'
                        ]);

                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Enregistrement du fichier reussi ');

                    }
                }

                if($request->type_pieces=='lettre_engagement'){
                    $lettre_engagement = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                        ->where('code_pieces','lettre_engagement')->first();
                    if(isset($lettre_engagement)) {
                        return redirect()->back()->with('error', 'Impossible d\'enregistrer le même type de fichier 2 fois');
                    }
                    if(isset($request->pieces)){
                        $filefront = $request->pieces;
                        $filename = 'lettre_engagement'. '_' . rand(111,99999) . '_' . 'lettre_engagement' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces_projet/lettre_engagement/'), $filename);
                        $piece_etude->libelle_pieces = $filename;
                        $piece_etude->id_projet_etude = $projet_etude->id_projet_etude;
                        $piece_etude->code_pieces ='lettre_engagement' ;
                        $piece_etude->save();

                        $insertedId = PiecesProjetEtude::latest()->first()->id_pieces_projet_etude;

                        Audit::logSave([
                            'action'=>'CREATION',
                            'code_piece'=>$insertedId,
                            'menu'=>'CREATION PIECE PROJET ETUDE',
                            'etat'=>'Succès',
                            'objet'=>'PIECE PROJET ETUDE'
                        ]);

                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Enregistrement du fichier reussi ');

                    }
                }

                if($request->type_pieces=='offre_technique'){
                    $offre_technique = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                        ->where('code_pieces','offre_technique')->first();
                    if(isset($offre_technique)) {
                        return redirect()->back()->with('error', 'Impossible d\'enregistrer le même type de fichier 2 fois');
                    }
                    if(isset($request->pieces)){
                        $filefront = $request->pieces;
                        $filename = 'offre_technique'. '_' . rand(111,99999) . '_' . 'offre_technique' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces_projet/offre_technique/'), $filename);
                        $piece_etude->libelle_pieces = $filename;
                        $piece_etude->id_projet_etude = $projet_etude->id_projet_etude;
                        $piece_etude->code_pieces ='offre_technique' ;
                        $piece_etude->save();

                        $insertedId = PiecesProjetEtude::latest()->first()->id_pieces_projet_etude;

                        Audit::logSave([
                            'action'=>'CREATION',
                            'code_piece'=>$insertedId,
                            'menu'=>'CREATION PIECE PROJET ETUDE',
                            'etat'=>'Succès',
                            'objet'=>'PIECE PROJET ETUDE'
                        ]);

                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Enregistrement du fichier reussi ');

                    }
                }

                if($request->type_pieces=='offre_financiere'){
                    $offre_financiere = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                        ->where('code_pieces','offre_financiere')->first();
                    if(isset($offre_financiere)) {
                        return redirect()->back()->with('error', 'Impossible d\'enregistrer le même type de fichier 2 fois');
                    }
                    if(isset($request->pieces)){
                        $filefront = $request->pieces;
                        $filename = 'offre_financiere'. '_' . rand(111,99999) . '_' . 'offre_financiere' . '_' . time() . '.' . $filefront->extension();
                        $filefront->move(public_path('pieces_projet/offre_financiere/'), $filename);
                        $piece_etude->libelle_pieces = $filename;
                        $piece_etude->id_projet_etude = $projet_etude->id_projet_etude;
                        $piece_etude->code_pieces ='offre_financiere' ;
                        $piece_etude->save();

                        $insertedId = PiecesProjetEtude::latest()->first()->id_pieces_projet_etude;

                        Audit::logSave([
                            'action'=>'CREATION',
                            'code_piece'=>$insertedId,
                            'menu'=>'CREATION PIECE PROJET ETUDE',
                            'etat'=>'Succès',
                            'objet'=>'PIECE PROJET ETUDE'
                        ]);

                        return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Enregistrement du fichier reussi ');

                    }
                }

            }

            if($request->action=='Enregistrer_soumettre_projet_etude'){
                $projet_etude->flag_soumis = true;
                $projet_etude->date_soumis = now();

                $direction = Direction::where('code_profil_direction','D2EQPC')->first();
                if(isset($direction)){
                    $departement = Departement::where('code_profil_departement','DESPP')->where('id_direction',$direction->id_direction)->first();
                    $projet_etude->id_departement = $departement->id_departement;
                }
                $projet_etude->update();

                $insertedId = PiecesProjetEtude::latest()->first()->id_pieces_projet_etude;

                Audit::logSave([
                    'action'=>'MODIFICATION',
                    'code_piece'=>$insertedId,
                    'menu'=>'MODIFICATION DEMANDES PROJET ETUDE',
                    'etat'=>'Succès',
                    'objet'=>'PROJET ETUDE'
                ]);

                return redirect('projetetude')->with('success', 'Succes : Projet soumis avec succès ');
            }
        }
    }

    public function deletefpe(string $id,string $id_piece_projet)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id_piece_projet =  Crypt::UrldeCrypt($id_piece_projet);

        if(isset($id_piece_projet)){
            $piece_projet = PiecesProjetEtude::find($id_piece_projet);
            if(isset($piece_projet)){
                $piece_projet->delete();

                $insertedId = PiecesProjetEtude::latest()->first()->id_pieces_projet_etude;

                Audit::logSave([
                    'action'=>'SUPRESSION',
                    'code_piece'=>$insertedId,
                    'menu'=>'SUPPRESSION PIECE PROJET ETUDE',
                    'etat'=>'Succès',
                    'objet'=>'PIECE PROJET ETUDE'
                ]);

                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(3).'/edit')->with('success', 'Succes : Suppression de la pièce réussie ');
            }else{

            }

        }else{

        }
    }
}
