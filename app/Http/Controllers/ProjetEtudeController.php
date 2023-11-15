<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activites;
use App\Models\CentreImpot;
use App\Models\Localite;
use App\Models\Pays;
use App\Models\Motif;
use App\Models\StatutOperation;
use App\Models\DemandeEnrolement;
use App\Models\Entreprises;
use App\Models\Pieces;
use App\Models\ProjetEtude;
use App\Models\PiecesProjetEtude;
use Carbon\Carbon;
use App\Helpers\Menu;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use Spatie\Permission\Models\Role;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;

class ProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        // dd($user_id);
        $demandeenroles = ProjetEtude::where('id_user','=',$user_id)->get();
        return view('projetetude.index', compact('demandeenroles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $activites = Activites::all();
        $activite = "<option value=''> Selectionnez une activité </option>";
        foreach ($activites as $comp) {
            $activite .= "<option value='" . $comp->id_activites  . "'>" . $comp->libelle_activites ." </option>";
        }

        $centreimpots = CentreImpot::all();
        $centreimpot = "<option value=''> Selectionnez un centre impot </option>";
        foreach ($centreimpots as $comp) {
            $centreimpot .= "<option value='" . $comp->id_centre_impot  . "'>" . $comp->libelle_centre_impot ." </option>";
        }

        $localites = Localite::all();
        $localite = "<option value=''> Selectionnez une localite </option>";
        foreach ($localites as $comp) {
            $localite .= "<option value='" . $comp->id_localite  . "'>" . $comp->libelle_localite ." </option>";
        }

        $pays = Pays::all();
        $pay = "<option value='202'> 225 </option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        return view('projetetude.create', compact('activite','centreimpot','localite','pay'));
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
                'avant_projet_tdr' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'courier_demande_fin' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'dossier_intention' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'lettre_engagement' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'offre_technique' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
                'offre_financiere' => 'required|mimes:png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF|max:5120',
            ],[
                'titre_projet.required' => 'Veuillez ajouter un titre de projet',
                'contexte_probleme.required' => 'Veuillez ajouter un context ou problemes constaté',
                'objectif_general.required' => 'Veuillez ajouter un objectif general',
                'objectif_specifique.required' => 'Veuillez ajouter un objectif specifiques',
                'resultat_attendu.required' => 'Veuillez ajouter un resultat attendu',
                'champ_etude.required' => 'Veuillez ajouter un champ d&quot;etude',
                'cible.required' => 'Veuillez ajouter une cible',
                'avant_projet_tdr.required' => 'Veuillez ajouter un avant-projet TDR',
                'courier_demande_fin.required' => 'Veuillez ajouter un courrier de demande de financemen',
                'dossier_intention.required' => 'Veuillez ajouter un dossier d’intention',
                'lettre_engagement.required' => 'Veuillez ajouter une lettre d’engagement',
                'offre_technique.required' => 'Veuillez ajouter une offre technique',
                'offre_financiere.required' => 'Veuillez ajouter une offre financière',
            ]);
            $user_id = Auth::user()->id;
            $data = $request->all();
            //echo($data);
            // exit();

            $input = $request->all();

            if (isset($data['avant_projet_tdr'])){

                $filefront = $data['avant_projet_tdr'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'avant_projet_tdr'. '_' . rand(111,99999) . '_' . 'avant_projet_tdr' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/avant_projet_tdr/'), $fileName1);

                    $input['avant_projet_tdr'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier de l\'avant-projet TDR n\'est pas correcte');
                }

            }


            if (isset($data['courier_demande_fin'])){

                $filefront = $data['courier_demande_fin'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'courier_demande_fin'. '_' . rand(111,99999) . '_' . 'courier_demande_fin' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/courier_demande_fin/'), $fileName1);

                    $input['courier_demande_fin'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier du  courrier de demande n\'est pas correcte');
                }

            }

            if (isset($data['dossier_intention'])){

                $filefront = $data['dossier_intention'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'dossier_intention'. '_' . rand(111,99999) . '_' . 'dossier_intention' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/dossier_intention/'), $fileName1);

                    $input['dossier_intention'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier du dossier de l\'intention n\'est pas correcte');
                }

            }

            if (isset($data['lettre_engagement'])){

                $filefront = $data['lettre_engagement'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'lettre_engagement'. '_' . rand(111,99999) . '_' . 'lettre_engagement' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/lettre_engagement/'), $fileName1);

                    $input['lettre_engagement'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier de la lettre d\'engagement n\'est pas correcte');
                }

            }

            if (isset($data['offre_technique'])){

                $filefront = $data['offre_technique'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'offre_technique'. '_' . rand(111,99999) . '_' . 'offre_technique' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/offre_technique/'), $fileName1);

                    $input['offre_technique'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier de l\'offre technique n\'est pas correcte');
                }

            }

            if (isset($data['offre_financiere'])){

                $filefront = $data['offre_financiere'];

                if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                    $fileName1 = 'offre_financiere'. '_' . rand(111,99999) . '_' . 'offre_financiere' . '_' . time() . '.' . $filefront->extension();

                    $filefront->move(public_path('pieces_projet/offre_financiere/'), $fileName1);

                    $input['offre_financiere'] = $fileName1;

                }else{
                    return redirect()->route('projetetude.create')
                    ->with('error', 'l\extension du fichier de l\'offre financiere n\'est pas correcte');
                }

            }

           // $input['id_entreprises'] = Carbon::now();
            $input['flag_soumis'] = false;
            $input['flag_valide'] = false;
            $input['flag_rejet'] = false;
            $input['id_user'] = $user_id;
            $input['titre_projet_etude'] = ucfirst($input['titre_projet']);
            $input['contexte_probleme_projet_etude'] = ucfirst($input['contexte_probleme']);
            $input['objectif_general_projet_etude'] = ucfirst($input['objectif_general']);
            $input['objectif_specifique_projet_etud'] = ucfirst($input['objectif_specifique']);
            $input['resultat_attendu_projet_etude'] = ucfirst($input['resultat_attendu']);
            $input['champ_etude_projet_etude'] = ucfirst($input['champ_etude']);
            $input['cible_projet_etude'] = ucfirst($input['cible']);

            ProjetEtude::create($input);
            $id_projet = ProjetEtude::latest()->first()->id_projet_etude;
            //dd($id_projet);

            // Enregistrement du chemin de pieces projets

            // Avant projet TDR
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '1',
                'libelle_pieces' => $input['avant_projet_tdr']
            ]);
            // Courrier de demande de financement
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '2',
                'libelle_pieces' => $input['courier_demande_fin']
            ]);
            // Dossier d’intention
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '3',
                'libelle_pieces' => $input['dossier_intention']
            ]);
            // Lettre d’engagement
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '4',
                'libelle_pieces' => $input['lettre_engagement']
            ]);
            // Offre technique
            PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '5',
                'libelle_pieces' => $input['offre_technique']
            ]);
             // Offre financiere
             PiecesProjetEtude::create([
                'id_projet_etude' => $id_projet,
                'code_pieces' => '6',
                'libelle_pieces' => $input['offre_financiere']
            ]);


        }
        return redirect('projetetude/'.Crypt::UrlCrypt($id_projet).'/edit')->with('success', 'Succes : Votre projet d\'etude a été crée ');

            //return redirect()->route('projetetude.index')->with('success', 'Votre demande de projet d\'etude a ete cree avec succes');
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
    public function edit($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        //dd($id);
        $projetetude = ProjetEtude::find($id);
        //dd($projetetude['titre_projet_etude']);
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','1']])->get();
        $piecesetude1 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','2']])->get();
        $piecesetude2 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','3']])->get();
        $piecesetude3 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','4']])->get();
        $piecesetude4 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','5']])->get();
        $piecesetude5 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','6']])->get();
        $piecesetude6 = $piecesetude['0']['libelle_pieces'];
        //dd($piecesetude['0']['libelle_pieces']);
        // Pieces Projet Etudes
        //dd($projetetude->piecesProjetEtudes['0']->libelle_pieces);

        $statutoperations = StatutOperation::all();
        $statutoperation = "<option value=''> Selectionnez le statut </option>";
        foreach ($statutoperations as $comp) {
            $statutoperation .= "<option value='" . $comp->id_statut_operation  . "'>" . $comp->libelle_statut_operation ." </option>";
        }

        $motifs = Motif::all();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        return view('projetetude.edit', compact('projetetude','statutoperation','motif','piecesetude1','piecesetude2','piecesetude3','piecesetude4' ,'piecesetude5','piecesetude6'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);


        if ($request->isMethod('put')) {

            $data = $request->all();
            dd($data);
            // Traitement de la soumission
            if($data['action'] === 'soumission_plan_formation'){
                // ID du plan
                $date_soumission = Carbon::now();
                $projetetude = ProjetEtude::find($id);
                $projetetude->flag_soumis = true;
                $projetetude->date_soumis = $date_soumission;
                $projetetude->save();
                return redirect()->route('projetetude.index')->with('success', 'Projet soumis avec succès.');

            }

            // Traitement de la modification
            if($data['action'] === 'modifier_plan_formation'){
                // ID du plan
                // Modification du fichier l'avant TDR
                if (isset($data['avant_projet_tdr_modif'])){

                    $filefront = $data['avant_projet_tdr_modif'];

                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                        $fileName1 = 'avant_projet_tdr'. '_' . rand(111,99999) . '_' . 'avant_projet_tdr' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces_projet/avant_projet_tdr/'), $fileName1);
                        $pieceprojetetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','1']])->get();
                        $id_piece = $pieceprojetetude[0]['id_pieces_projet_etude'];
                        $piece= PiecesProjetEtude::find($id_piece);
                        $piece->libelle_pieces = $fileName1;
                        $piece->save();
                        //$input['avant_projet_tdr'] = $fileName1;

                    }else{
                        return redirect()->route('projetetude.create')
                        ->with('error', 'l\extension du fichier de l\'avant-projet TDR n\'est pas correcte');
                    }

                }

                 // Modification du  Courrier de demande de financement
                 if (isset($data['avant_projet_tdr_modif'])){

                    $filefront = $data['avant_projet_tdr_modif'];

                    if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                        $fileName1 = 'avant_projet_tdr'. '_' . rand(111,99999) . '_' . 'avant_projet_tdr' . '_' . time() . '.' . $filefront->extension();

                        $filefront->move(public_path('pieces_projet/avant_projet_tdr/'), $fileName1);
                        $pieceprojetetude = PiecesProjetEtude::where([['id_projet_etude','=',$id],['code_pieces','=','1']])->get();
                        $id_piece = $pieceprojetetude[0]['id_pieces_projet_etude'];
                        $piece= PiecesProjetEtude::find($id_piece);
                        $piece->libelle_pieces = $fileName1;
                        $piece->save();
                        //$input['avant_projet_tdr'] = $fileName1;

                    }else{
                        return redirect()->route('projetetude.create')
                        ->with('error', 'l\extension du fichier de l\'avant-projet TDR n\'est pas correcte');
                    }

                }

                // if (isset($data['courier_demande_fin_modif'])){
                //     $filefront = $data['courier_demande_fin_modif'];

                //     if($filefront->extension() == "png" || $filefront->extension() == "PNG" || $filefront->extension() == "PDF" || $filefront->extension() == "pdf" || $filefront->extension() == "JPG" || $filefront->extension() == "jpg" || $filefront->extension() == "JPEG" || $filefront->extension() == "jpeg"){

                //         $fileName1 = 'avant_projet_tdr'. '_' . rand(111,99999) . '_' . 'avant_projet_tdr' . '_' . time() . '.' . $filefront->extension();

                //         $filefront->move(public_path('pieces_projet/avant_projet_tdr/'), $fileName1);

                //         $input['avant_projet_tdr'] = $fileName1;

                //     }else{
                //         return redirect()->route('projetetude.create')
                //         ->with('error', 'l\extension du fichier de l\'avant-projet TDR n\'est pas correcte');
                //     }

                // }

                $projetetude = ProjetEtude::find($id);
                $projetetude->titre_projet_etude = $data['titre_projet'];
                $projetetude->contexte_probleme_projet_etude = $data['contexte_probleme'];
                $projetetude->objectif_general_projet_etude = $data['objectif_general'];
                $projetetude->objectif_specifique_projet_etud = $data['objectif_specifique'];
                $projetetude->resultat_attendu_projet_etude = $data['resultat_attendu'];
                $projetetude->champ_etude_projet_etude = $data['champ_etude'];
                $projetetude->cible_projet_etude = $data['cible'];
                $projetetude->save();
                return redirect('projetetude/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Votre projet d\'etude a été modifié avec succes ');

                //return redirect()->route('projetetude.index')->with('success', 'Projet modifié avec succès.');


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
