<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Crypt;
use App\Helpers\GenerateCode as Gencode;
use App\Http\Controllers\Controller;
use App\Models\ActionFormationPlan;
use App\Models\ActionprojetetudeAValiderParUser;
use App\Models\BeneficiairesFormation;
use App\Models\CahierProjetetude;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FormeJuridique;
use App\Models\LigneCahierProjetEtude;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\TypeComite;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CahierprojetetudeController extends Controller
{
    public function index(){

        $cahiers = CahierProjetetude::all();

        return view("projetetudes.cahier.index", compact("cahiers"));
    }

    public function create(){

        return view("projetetudes.cahier.create");

    }

    public function store(Request $request){

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'code_pieces_cahier_projet_etude' => 'required',
            ],[
                'code_pieces_cahier_projet_etude.required' => 'Veuillez sélectionner le type entreprise.',
            ]);

            $input = $request->all();
            $input['id_users_cahier_projet_etude'] = Auth::user()->id;
            $input['date_creer_cahier_projet_etude'] = Carbon::now();
            $input['code_cahier_projet_etude'] = $input['code_pieces_cahier_projet_etude']. '-' . Gencode::randStrGen(4, 5) .'-'. Carbon::now()->format('Y');
            $cahier =  CahierProjetetude::create($input);
            if($request->action=="Enregistrer"){
                return redirect('cahierprojetetude/'.Crypt::UrlCrypt($cahier->id_cahier_projet_etude).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succès : Enregistrement réussi ');
            }

            if($request->action=="Enregistrer_suivant"){
                return redirect('cahierprojetetude/'.Crypt::UrlCrypt($cahier->id_cahier_projet_etude).'/'.Crypt::UrlCrypt(2).'/edit')->with('success', 'Succès : Enregistrement réussi ');
            }

        }
    }


    public function edit($id, $id1){
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $cahier = CahierProjetetude::find($id);
        $cahierprojetetudes = LigneCahierProjetEtude::join('projet_etude','ligne_cahier_projet_etude.id_projet_etude','projet_etude.id_projet_etude')
                            ->join('entreprises','projet_etude.id_entreprises','=','entreprises.id_entreprises')
                            ->join('users','projet_etude.id_charge_etude','=','users.id')
                            ->where([['ligne_cahier_projet_etude.id_cahier_projet_etude','=',$cahier->id_cahier_projet_etude]])->get();

        $projetetudes = ProjetEtude::where([['flag_valider_par_processus','=',true],['flag_projet_etude_valider_cahier','=',false]])->get();

        return view('projetetudes.cahier.edit', compact('cahier','id','idetape','projetetudes','cahierprojetetudes'));
    }

    public function editer($id,$id2,$id3)
    {

        $id =  Crypt::UrldeCrypt($id);
        $id_cahier_projet_etude = Crypt::UrldeCrypt($id2);
        $id_etape = Crypt::UrldeCrypt($id3);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if(isset($id)){
            $projet_etude = ProjetEtude::find($id);
            if(isset($projet_etude)){
                $pieces_projets= PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)->get();

                $avant_projet_tdr = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','avant_projet_tdr')->first();
                $courier_demande_fin = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','courier_demande_fin')->first();

                $offre_technique = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_technique')->first();
                $offre_financiere = PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)
                    ->where('code_pieces','offre_financiere')->first();

                $infoentreprise = Entreprises::find($projet_etude->id_entreprises)->first();

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

                $motif = Motif::where('code_motif','=','PRE')->get();;
                $motifs = "<option value='".$projet_etude->motif->id_motif."'> " . $projet_etude->motif->libelle_motif . "</option>";
                foreach ($motif as $comp) {
                    $motifs .= "<option value='" . $comp->id_motif  . "' >" . $comp->libelle_motif ." </option>";
                }

                $formjuridique = "<option value='".$infoentreprise->formeJuridique->id_forme_juridique."'> " . $infoentreprise->formeJuridique->libelle_forme_juridique . "</option>";

                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                }


                return view('projetetudes.cahier.editer',
                    compact('id_etape','pay','pieces_projets','avant_projet_tdr',
                        'courier_demande_fin',
                        'offre_technique',
                        'projet_etude',
                        'id_cahier_projet_etude',
                        'secteuractivite_projet',
                        'motifs',
                        'formjuridique',
                        'offre_financiere',
                        'secteuractivite'));

            }

        }
    }

    public function show($id)
    {
        $idVal = Crypt::UrldeCrypt($id);
        $actionplan = null;
        $ficheagrement = null;
        $beneficiaires = null;
        $projetetude = null;

        if ($idVal != null) {
            $actionplan = ActionFormationPlan::find($idVal);
            $ficheagrement = FicheADemandeAgrement::where([['id_action_formation_plan','=',$actionplan->id_action_formation_plan]])->first();
            $beneficiaires = BeneficiairesFormation::where([['id_fiche_agrement','=',$ficheagrement->id_fiche_agrement]])->get();
            $projetetude = projetetude::where([['id_projet_etude','=',$actionplan->id_projet_etude]])->first();
        }

        return view('projetetudes.cahier.show', compact('actionplan','ficheagrement', 'beneficiaires','projetetude'));
    }

    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'code_pieces_cahier_projet_etude' => 'required',
                ],[
                    'code_pieces_cahier_projet_etude.required' => 'Veuillez sélectionner le type entreprise.',
                ]);


                $input = $request->all();
                $input['id_users_cahier_projet_etude'] = Auth::user()->id;
                $input['code_cahier_projet_etude'] = $input['code_pieces_cahier_projet_etude']. '-' . Gencode::randStrGen(4, 5) .'_'. Carbon::now()->format('Y');
                $comitegestion = CahierProjetetude::find($id);
                $comitegestion->update($input);

                return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succès : Information mise à jour ');

            }

            if ($data['action'] == 'Traiter_cahier_projet'){

                $input = $request->all();
                if(isset($input['projetetude'])){
                    $verifnombre = count($input['projetetude']);
                    if($verifnombre < 1){

                        return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins un projet d\'étude. ');

                    }

                    $tab = $input['projetetude'];

                    foreach ($tab as $key => $value) {
                        LigneCahierProjetEtude::create([
                            'id_cahier_projet_etude'=> $id,
                            'id_projet_etude'=> $value
                        ]);
                        projetetude::where('id_projet_etude', $value)->update([
                            'flag_projet_etude_valider_cahier'=> true
                        ]);

                    }

                    return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succès : Information mise à jour avec succès ');
                }else{
                    return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins un projet d\'étude. ');
                }

            }

            if ($data['action'] == 'Traiter_cahier_projet_soumis'){

                $comite = CahierProjetetude::find($id);
                $lignecahierprojetetude = LigneCahierProjetEtude::where([['id_cahier_projet_etude','=',$id]])->get();

                foreach ($lignecahierprojetetude as $key => $value) {
                    $projet_etude = projetetude::find($value->id_projet_etude);
                    $type_comite_gestion = TypeComite::where('libelle_type_comite',"Comitedegestion")
                        ->where('code_type_comite','PE')->first();
                    $type_comite_permanent =  TypeComite::where('libelle_type_comite',"Comitepermant")
                        ->where('code_type_comite','PE')->first();

                    if(isset($type_comite_gestion)){
                        if($type_comite_gestion->valeur_min_type_comite < $projet_etude->montant_projet_instruction &&
                            $type_comite_gestion->valeur_max_type_comite >= $projet_etude->montant_projet_instruction){
                            $projet_etude->flag_projet_etude_valider_cahier_soumis_comite_gestion = true;
                            $projet_etude->flag_projet_etude_valider_cahier_soumis_comite_permanente = false;
                            $projet_etude->update();
                        }
                    }

                    if(isset($type_comite_permanent)){
                        if($type_comite_permanent->valeur_min_type_comite < $projet_etude->montant_projet_instruction &&
                            $type_comite_permanent->valeur_max_type_comite >= $projet_etude->montant_projet_instruction){
                            $projet_etude->flag_projet_etude_valider_cahier_soumis_comite_gestion = false;
                            $projet_etude->flag_projet_etude_valider_cahier_soumis_comite_permanente = true;
                            $projet_etude->update();
                        }
                    }

                }

                $comite->update(['flag_statut_cahier_projet_etude'=> true,'date_soumis_cahier_projet_etude'=>Carbon::now()]);

                return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succès : Information mise à jour');

            }

        }
    }
//
//    public function etat($id){
//
//        $id =  Crypt::UrldeCrypt($id);
//
//        $cahier = CahierProjetetude::find($id);
//
//       $etatsecteuractivite =  EtatCahierPlanDeFormation::get_liste_etat_secteur_activite_cahier_plan_f($id);
//
//       $etatactionplan = EtatCahierPlanDeFormation::get_liste_etat_action_cahier_plan_f($id);
//
//       $etatplanf = EtatCahierPlanDeFormation::get_liste_etat_plan_cahier_plan_f($id);
//
//       $etatbutformation = EtatCahierPlanDeFormation::get_liste_etat_but_formation_cahier_plan_f($id);
//
//       $etattypeformation = EtatCahierPlanDeFormation::get_liste_etat_type_formation_cahier_plan_f($id);
//
//       //dd($etatsecteuractivite);
//
//        return view('cahierprojetetude.etat',compact('cahier','etatsecteuractivite','etatactionplan','etatplanf','etatbutformation','etattypeformation'));
//    }
}
