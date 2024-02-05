<?php

namespace App\Http\Controllers;

use App\Helpers\GenerateCode as Gencode;
use App\Models\Cahierprojetetude;
use App\Models\LigneCahierprojetetude;
use App\Models\PiecesProjetEtude;
use App\Models\projetetude;
use App\Helpers\Crypt;
use App\Models\SecteurActivite;
use App\Models\TypeComite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use App\Models\ComitePermanenteParticipant;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\FicheAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\ActionprojetetudeAValiderParUser;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Helpers\ConseillerParAgence;
use App\Helpers\EtatCahierPlanDeFormation;
use App\Models\ActionFormationPlan;
use App\Models\User;
Use DB;

class CahierprojetetudeController extends Controller
{
    public function index(){

        $cahiers = CahierProjetetude::all();

        return view("cahierprojetetude.index", compact("cahiers"));
    }

    public function create(){

        return view("cahierprojetetude.create");

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

            return redirect('cahierprojetetude/'.Crypt::UrlCrypt($cahier->id_cahier_projet_etude).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');

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



        return view('cahierprojetetude.edit', compact('cahier','id','idetape','projetetudes','cahierprojetetudes'));
    }

    public function editer($id,$id2,$id3)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idcomite = Crypt::UrldeCrypt($id2);
        $id_etape = Crypt::UrldeCrypt($id3);
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
                $motif = Motif::where('code_motif','=','PRE')->get();;
                $motifs = "<option value='".$projet_etude->motif->id_motif."'> " . $projet_etude->motif->libelle_motif . "</option>";
                foreach ($motif as $comp) {
                    $motifs .= "<option value='" . $comp->id_motif  . "' >" . $comp->libelle_motif ." </option>";
                }


                return view('cahierprojetetude.editer',
                    compact('id_etape','pay','pieces_projets','avant_projet_tdr',
                        'courier_demande_fin',
                        'dossier_intention',
                        'lettre_engagement',
                        'offre_technique',
                        'projet_etude',
                        'idcomite',
                        'motifs',
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

        return view('cahierprojetetude.show', compact('actionplan','ficheagrement', 'beneficiaires','projetetude'));
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
                $comitegestion = Cahierprojetetude::find($id);
                $comitegestion->update($input);

                return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Traiter_cahier_projet'){

                $input = $request->all();
                $verifnombre = count($input['projetetude']);
                if($verifnombre < 1){

                    return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins un projet d\'étude. ');

                }

                $tab = $input['projetetude'];

                foreach ($tab as $key => $value) {
                    LigneCahierprojetetude::create([
                        'id_cahier_projet_etude'=> $id,
                        'id_projet_etude'=> $value
                    ]);
                    projetetude::where('id_projet_etude', $value)->update([
                        'flag_projet_etude_valider_cahier'=> true
                    ]);

                }

                return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Traiter_cahier_projet_soumis'){

                $comite = Cahierprojetetude::find($id);
                $lignecahierprojetetude = LigneCahierprojetetude::where([['id_cahier_projet_etude','=',$id]])->get();

                foreach ($lignecahierprojetetude as $key => $value) {
                    $projet_etude = projetetude::find($value->id_projet_etude);
                    $type_comite_gestion = TypeComite::where('libelle_type_comite',"Comitedegestion")
                        ->where('code_type_comite','PE')->first();
                    $type_comite_permanent =  TypeComite::where('libelle_type_comite',"Comitepermant")
                        ->where('code_type_comite','PE')->first();

                    if(isset($type_comite_gestion)){
                        if($type_comite_gestion->valeur_min_type_comite < $projet_etude->montant_projet_instruction &&
                            $type_comite_gestion->valeur_min_type_comite >= $projet_etude->montant_projet_instruction){
                            $projet_etude->flag_projet_etude_valider_cahier_soumis_comite_gestion = true;
                            $projet_etude->flag_projet_etude_valider_cahier_soumis_comite_permanente = false;
                            $projet_etude->update();
                        }
                    }

                    if(isset($type_comite_permanent)){
                        if($type_comite_permanent->valeur_min_type_comite < $projet_etude->montant_projet_instruction &&
                            $type_comite_permanent->valeur_min_type_comite >= $projet_etude->montant_projet_instruction){
                            $projet_etude->flag_projet_etude_valider_cahier_soumis_comite_gestion = false;
                            $projet_etude->flag_projet_etude_valider_cahier_soumis_comite_permanente = true;
                            $projet_etude->update();
                        }
                    }

                }

                $comite->update(['flag_statut_cahier_projet_etude'=> true,'date_soumis_cahier_projet_etude'=>Carbon::now()]);

                return redirect('cahierprojetetude/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

        }
    }

    public function etat($id){

        $id =  Crypt::UrldeCrypt($id);

        $cahier = Cahierprojetetude::find($id);

       $etatsecteuractivite =  EtatCahierPlanDeFormation::get_liste_etat_secteur_activite_cahier_plan_f($id);

       $etatactionplan = EtatCahierPlanDeFormation::get_liste_etat_action_cahier_plan_f($id);

       $etatplanf = EtatCahierPlanDeFormation::get_liste_etat_plan_cahier_plan_f($id);

       $etatbutformation = EtatCahierPlanDeFormation::get_liste_etat_but_formation_cahier_plan_f($id);

       $etattypeformation = EtatCahierPlanDeFormation::get_liste_etat_type_formation_cahier_plan_f($id);

       //dd($etatsecteuractivite);

        return view('cahierprojetetude.etat',compact('cahier','etatsecteuractivite','etatactionplan','etatplanf','etatbutformation','etattypeformation'));
    }
}
