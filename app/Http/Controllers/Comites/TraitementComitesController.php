<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
use App\Models\Comite;
use App\Helpers\Audit;
use App\Models\DomaineFormation;
use App\Models\FormeJuridique;
use App\Models\PiecesProjetEtude;
use App\Models\ProcessusComite;
use App\Models\TypeComite;
use App\Helpers\InfosEntreprise;
use App\Models\Departement;
use App\Models\Service;
use App\Models\StatutOperation;
use App\Models\ListeDomaineProjetFormation;
use App\Helpers\Menu;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\ConseillerParAgence;
use App\Models\PiecesProjetFormation;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Helpers\Crypt;
use App\Helpers\DemandePlanProjets;
use App\Models\ActionFormationPlan;
use App\Models\AvisGlobaleComiteTechnique;
use App\Models\Banque;
use App\Models\ButFormation;
use App\Models\CahierComite;
use App\Models\CahierPlansProjets;
use App\Models\CategorieComite;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\ComiteParticipant;
use App\Models\CommentaireNonRecevableDemande;
use App\Models\Competences;
use App\Models\DemandeHabilitation;
use App\Models\DemandeIntervention;
use App\Models\DomaineDemandeHabilitation;
use App\Models\Entreprises;
use App\Models\Experiences;
use App\Models\FicheAgrement;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\Formateurs;
use App\Models\FormationsEduc;
use App\Models\InterventionHorsCi;
use App\Models\LanguesFormateurs;
use App\Models\LigneCahierPlansProjets;
use App\Models\Motif;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Pays;
use App\Models\PiecesDemandeHabilitation;
use App\Models\PlanFormation;
use App\Models\PrincipaleQualification;
use App\Models\ProcessusComiteLieComite;
use App\Models\ProjetEtude;
use App\Models\ProjetFormation;
use App\Models\RapportsVisites;
use App\Models\SecteurActivite;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Visites;
use Illuminate\Http\Request;

class TraitementComitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comites = Comite::Join('categorie_comite','comite.id_categorie_comite','categorie_comite.id_categorie_comite')
                        ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                        ->where('categorie_comite.code_categorie_comite','CP')
                        ->where('id_user_comite_participant',Auth::user()->id)
                        ->where('flag_statut_comite',false)
                        ->get();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TRAITEMENT DES COMITES '

        ]);

        return view('comites.traitementcomite.index', compact('comites'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
         $idetape =  Crypt::UrldeCrypt($id1);
         $comite = Comite::find($id);
         //dd($id);

         $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

         $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->get();

         $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
                ->join('users','comite_participant.id_user_comite_participant','users.id')
                ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', 'roles.id')
                ->where([['id_comite','=',$id]])
                ->get();


        $listedemandesss = DB::table('cahier_plans_projets')
                ->join('cahier_comite','cahier_plans_projets.id_cahier_plans_projets','cahier_comite.id_demande')
                ->join('comite','cahier_comite.id_comite','comite.id_comite')
                ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                ->where([['cahier_comite.id_comite','=',$id],
                ['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',true],
                ['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
                ->get();

                Audit::logSave([

                    'action'=>'MODIFIER',

                    'code_piece'=>$id,

                    'menu'=>'COMITES',

                    'etat'=>'Succès',

                    'objet'=>'COMITES TECHNIQUES'

                ]);

                return view('comites.traitementcomite.edit', compact('comite','idetape','id','processuscomite','cahiers','comiteparticipants','listedemandesss'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function updater(Request $request, $id, $id1, $id2, $id3)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        //$id2 =  Crypt::UrldeCrypt($id2);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcahier =  Crypt::UrldeCrypt($id3);
        $idcomite =  $id;
        //dd($data);

        if($request->isMethod('put')){

            $data = $request->all();
            //dd($data);


            if($data['action'] === 'Valider_les_actions_des_plans_de_formations'){
                $planformation = PlanFormation::find($id1);

                $planformation->update([
                    'flag_traiter_commission_permanente' => true,
                    'date_traiter_commission_permanente' => Carbon::now()
                ]);

                $listeplansformation = LigneCahierPlansProjets::join('plan_formation','ligne_cahier_plans_projets.id_demande','plan_formation.id_plan_de_formation')
                    ->where([
                        'id_cahier_plans_projets' => $idcahier,
                        'code_pieces_ligne_cahier_plans_projets' => 'PF'
                    ])->get();

                $listeplansformationtraiter = LigneCahierPlansProjets::join('plan_formation','ligne_cahier_plans_projets.id_demande','plan_formation.id_plan_de_formation')
                    ->where([
                        'id_cahier_plans_projets' => $idcahier,
                        'code_pieces_ligne_cahier_plans_projets' => 'PF',
                        'flag_traiter_commission_permanente' => true
                    ])->get();

                //dd(count($listeplansformationtraiter));

                if(count($listeplansformation) == count($listeplansformationtraiter)){
                    $majcahier = CahierPlansProjets::find($idcahier);
                    $majcahier->update([
                        'flag_traitement_effectuer_commission' => true,
                        'date_traitement_effectuer_commission' => Carbon::now()
                    ]);
                }

                return redirect('traitementcomite/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idcahier).'/'.Crypt::UrlCrypt(1).'/edit/planformation')->with('success', 'Succes : Mise a jour reussi ');
            }

            if($data['action'] === 'Valider_demande_habilitations'){

                $demhabilitation = DemandeHabilitation::find($id1);

                $demhabilitation->update([
                    'flag_traiter_commission_permanente' => true,
                    'date_traiter_commission_permanente' => Carbon::now()
                ]);

                $listedemhabilitation = LigneCahierPlansProjets::join('demande_habilitation','ligne_cahier_plans_projets.id_demande','demande_habilitation.id_demande_habilitation')
                    ->where([
                        'id_cahier_plans_projets' => $idcahier,
                        'code_pieces_ligne_cahier_plans_projets' => 'HAB'
                    ])->get();

                $listedemhabilitationtraiter = LigneCahierPlansProjets::join('demande_habilitation','ligne_cahier_plans_projets.id_demande','demande_habilitation.id_demande_habilitation')
                    ->where([
                        'id_cahier_plans_projets' => $idcahier,
                        'code_pieces_ligne_cahier_plans_projets' => 'HAB',
                        'flag_traiter_commission_permanente' => true
                    ])->get();

                //dd(count($listeplansformationtraiter));

                if(count($listedemhabilitation) == count($listedemhabilitationtraiter)){
                    $majcahier = CahierPlansProjets::find($idcahier);
                    $majcahier->update([
                        'flag_traitement_effectuer_commission' => true,
                        'date_traitement_effectuer_commission' => Carbon::now()
                    ]);
                }

                return redirect('traitementcomite/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idcahier).'/'.Crypt::UrlCrypt(1).'/edit/habilitation')->with('success', 'Succes : Mise a jour reussi ');

            }
            if($data['action'] === 'Traiter_valider_projet'){
                $projet_etude = ProjetEtude::find($id1);
                $cahier = CahierPlansProjets::find($idcahier);

                if($cahier->code_commission_permante_comite_gestion=='COP'){
                    $projet_etude->update([
                        'flag_valider_comite_permanente_projet_etude' => true,
                        'date_valider_comite_permanente_projet_etude' => Carbon::now()
                    ]);

                    $listeplansprojetetudetraiter = LigneCahierPlansProjets::join('projet_etude','ligne_cahier_plans_projets.id_demande','projet_etude.id_projet_etude')
                        ->where([
                            'id_cahier_plans_projets' => $idcahier,
                            'code_pieces_ligne_cahier_plans_projets' => 'PE',
                            'flag_valider_comite_permanente_projet_etude' => true
                        ])->get();
                }

                if($cahier->code_commission_permante_comite_gestion=='COG'){
                    $projet_etude->update([
                        'flag_valider_comite_gestion_projet_etude' => true,
                        'date_valider_comite_gestion_projet_etude' => Carbon::now()
                    ]);

                    $listeplansprojetetudetraiter = LigneCahierPlansProjets::join('projet_etude','ligne_cahier_plans_projets.id_demande','projet_etude.id_projet_etude')
                        ->where([
                            'id_cahier_plans_projets' => $idcahier,
                            'code_pieces_ligne_cahier_plans_projets' => 'PE',
                            'flag_valider_comite_gestion_projet_etude' => true
                        ])->get();
                }

                $listeprojetetude = LigneCahierPlansProjets::join('projet_etude','ligne_cahier_plans_projets.id_demande','projet_etude.id_projet_etude')
                    ->where([
                        'id_cahier_plans_projets' => $idcahier,
                        'code_pieces_ligne_cahier_plans_projets' => 'PE'
                    ])->get();

                if(count($listeprojetetude) == count($listeplansprojetetudetraiter)){
                    $majcahier = CahierPlansProjets::find($idcahier);
                    $majcahier->update([
                        'flag_traitement_effectuer_commission' => true,
                        'date_traitement_effectuer_commission' => Carbon::now()
                    ]);
                }

                return redirect('traitementcomite/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idcahier).'/'.Crypt::UrlCrypt(1).'/edit/projetetude')->with('success', 'Succes : Mise a jour reussi ');
            }

            if($data['action'] === 'Traiter_valider_projet_formation'){
                $projet_etude = ProjetFormation::find($id1);
                $idcahier =  Crypt::UrldeCrypt($id2);
                $cahier = CahierPlansProjets::find($idcahier);
                //dd($idcomite);

                if($cahier->code_commission_permante_comite_gestion=='COP'){
                    $projet_etude->update([
                        'flag_traiter_commission_permanente' => true,
                        'type_comite' => 'COP',
                        'flag_fiche_agrement' => true,
                        'date_valider_comite_permanente_projet_formation' => Carbon::now()
                    ]);

                    $listeplansprojetetudetraiter = LigneCahierPlansProjets::join('projet_etude','ligne_cahier_plans_projets.id_demande','projet_etude.id_projet_etude')
                        ->where([
                            'id_cahier_plans_projets' => $idcahier,
                            'code_pieces_ligne_cahier_plans_projets' => 'PRF',
                            'flag_valider_comite_permanente_projet_etude' => true
                        ])->get();
                }

                if($cahier->code_commission_permante_comite_gestion=='COG'){
                    $projet_etude->update([
                        'flag_traiter_commission_permanente' => true,
                        'type_comite' => 'COG',
                        'flag_fiche_agrement' => true,
                        'date_valider_comite_gestion_projet_formation' => Carbon::now()
                    ]);

                    $listeplansprojetetudetraiter = LigneCahierPlansProjets::join('projet_etude','ligne_cahier_plans_projets.id_demande','projet_etude.id_projet_etude')
                        ->where([
                            'id_cahier_plans_projets' => $idcahier,
                            'code_pieces_ligne_cahier_plans_projets' => 'PRF',
                            'flag_valider_comite_gestion_projet_etude' => true
                        ])->get();
                }

                $listeprojetetude = LigneCahierPlansProjets::join('projet_etude','ligne_cahier_plans_projets.id_demande','projet_etude.id_projet_etude')
                    ->where([
                        'id_cahier_plans_projets' => $idcahier,
                        'code_pieces_ligne_cahier_plans_projets' => 'PRF'
                    ])->get();

                if(count($listeprojetetude) == count($listeplansprojetetudetraiter)){
                    $majcahier = CahierPlansProjets::find($idcahier);
                    $majcahier->update([
                        'flag_traitement_effectuer_commission' => true,
                        'date_traitement_effectuer_commission' => Carbon::now()
                    ]);
                }

                return redirect('traitementcomite/'.Crypt::UrlCrypt($idcomite).'/'.Crypt::UrlCrypt($idcahier).'/'.Crypt::UrlCrypt(1).'/edit/projeformation')->with('success', 'Succes : Projet de formation validé , la fiche d\'agreement est disponible. ');
            }

        }

    }


    public function editplanformation($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;

        $comite = Comite::find($id);

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $listedemandesss = DB::table('cahier_plans_projets')->select('entreprises.raison_social_entreprises','users.name','users.prenom_users','plan_formation.code_plan_formation',
                'plan_formation.date_soumis_plan_formation','plan_formation.date_soumis_ct_plan_formation','date_soumis_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets',
                'plan_formation.cout_total_accorder_plan_formation','plan_formation.flag_traiter_commission_permanente','plan_formation.id_plan_de_formation as id_demande')
                ->join('cahier_comite','cahier_plans_projets.id_cahier_plans_projets','cahier_comite.id_demande')
                ->join('comite','cahier_comite.id_comite','comite.id_comite')
                ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                ->join('ligne_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets','ligne_cahier_plans_projets.id_cahier_plans_projets')
                ->join('plan_formation','ligne_cahier_plans_projets.id_demande','plan_formation.id_plan_de_formation')
                ->join('entreprises','plan_formation.id_entreprises','entreprises.id_entreprises')
                ->join('users','plan_formation.user_conseiller','users.id')
                ->where([['cahier_comite.id_comite','=',$id],
                ['cahier_comite.id_demande','=',$id1],
                ['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',true],
                ['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
                ->get();

        //$comiteparticipants = ComiteParticipant::where([['id_comite','=',$id]])->get();

        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
        ->join('users','comite_participant.id_user_comite_participant','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['id_comite','=',$id]])
        ->get();

        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'COMITES',
            'etat'=>'Succès',
            'objet'=>'TENUE DE COMITES '
        ]);

        return view('comites.traitementcomite.editplanformation', compact(
            'comite','idetape','id','id1','processuscomite','cahiers','comiteparticipants','listedemandesss'
        ));

    }

    public function edithabilitation($id,$id1,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;

        $comite = Comite::find($id);

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $listedemandesss = DB::table('cahier_plans_projets')->select('entreprises.raison_social_entreprises','users.name',
                                    'users.prenom_users','demande_habilitation.code_demande_habilitation','demande_habilitation.date_soumis_demande_habilitation',
                                    'demande_habilitation.date_soumis_comite_technique','date_soumis_cahier_plans_projets',
                                    'cahier_plans_projets.id_cahier_plans_projets','demande_habilitation.flag_traiter_commission_permanente',
                                    'demande_habilitation.id_demande_habilitation as id_demande')
                                    ->join('cahier_comite','cahier_plans_projets.id_cahier_plans_projets','cahier_comite.id_demande')
                                    ->join('comite','cahier_comite.id_comite','comite.id_comite')
                                    ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                                    ->join('ligne_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets','ligne_cahier_plans_projets.id_cahier_plans_projets')
                                    ->join('demande_habilitation','ligne_cahier_plans_projets.id_demande','demande_habilitation.id_demande_habilitation')
                                    ->join('entreprises','demande_habilitation.id_entreprises','entreprises.id_entreprises')
                                    ->join('users','demande_habilitation.id_charge_habilitation','users.id')
                                    ->where([['cahier_comite.id_comite','=',$id],
                                    ['cahier_comite.id_demande','=',$id1],
                                    ['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',true],
                                    ['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
                                    ->get();
        //dd($listedemandesss);
        //$comiteparticipants = ComiteParticipant::where([['id_comite','=',$id]])->get();

        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
        ->join('users','comite_participant.id_user_comite_participant','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['id_comite','=',$id]])
        ->get();

        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'COMITES',
            'etat'=>'Succès',
            'objet'=>'TENUE DE COMITES '
        ]);

        return view('comites.traitementcomite.edithabilitation', compact(
            'comite','idetape','id','id1','processuscomite','cahiers','comiteparticipants','listedemandesss'
        ));

    }




    public function editerplanformation($id,$id1,$id2,$id3)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcahier =  Crypt::UrldeCrypt($id3);
        $idcomite =  $id;

        $comite = Comite::find($id);

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $cahiersplanprojet = CahierPlansProjets::find($idcahier);

        $planformation = PlanFormation::find($id1);
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

        $actionplanformations = ActionFormationPlan::where([['id_plan_de_formation','=',$id1]])->get();

        $categorieplans = CategoriePlan::where([['id_plan_de_formation','=',$id1]])->get();

        $motifs = Motif::where([['code_motif','=','CTPAF']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $infosactionplanformations = ActionFormationPlan::select('action_formation_plan.*','plan_formation.*','entreprises.*','fiche_a_demande_agrement.*','domaine_formation.*','type_formation.*')
                                        ->join('plan_formation','action_formation_plan.id_plan_de_formation','=','plan_formation.id_plan_de_formation')
                                        ->join('fiche_a_demande_agrement','action_formation_plan.id_action_formation_plan','=','fiche_a_demande_agrement.id_action_formation_plan')
                                        ->join('entreprises','plan_formation.id_entreprises','=','entreprises.id_entreprises')
                                        ->join('type_formation','fiche_a_demande_agrement.id_type_formation','=','type_formation.id_type_formation')
                                        ->join('domaine_formation','action_formation_plan.id_domaine_formation','=','domaine_formation.id_domaine_formation')
                                        ->where([['action_formation_plan.id_plan_de_formation','=',$id1]])->get();



     /******************** secteuractivites *********************************/
        $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                        ->orderBy('libelle_secteur_activite')
                        ->get();


        $typeformationss = TypeFormation::where('flag_actif_formation','=',true)->orderBy('type_formation')->get();

        $butformations = ButFormation::all();
        $butformation = "<option value=''> Selectionnez le but de la formation </option>";
        foreach ($butformations as $comp) {
            $butformation .= "<option value='" . $comp->id_but_formation  . "'>" . mb_strtoupper($comp->but_formation) ." </option>";
        }

        $planformationuser = PlanFormation::Join('users','plan_formation.user_conseiller','users.id')->where([['id_plan_de_formation','=',$id1]])->first();


        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES '

        ]);

        return view('comites.traitementcomite.editerplanformation', compact(
            'comite','idetape','id','id1','processuscomite','cahiers',
            'planformation','infoentreprise','typeentreprise','pay','typeformation','butformation',
            'actionplanformations','categorieprofessionelle','categorieplans','motif','infosactionplanformations',
            'idcomite','secteuractivites','typeformationss','butformations','idcahier','planformationuser','cahiersplanprojet'
        ));

    }

    public function editerhabilitation($id,$id1,$id2,$id3)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcahier =  Crypt::UrldeCrypt($id3);
        $idcomite =  $id;

        $comite = Comite::find($id);

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $cahiersplanprojet = CahierPlansProjets::find($idcahier);

        $demandehabilitation = DemandeHabilitation::find($id1);

        $visites = Visites::where([['id_demande_habilitation','=',$demandehabilitation->id_demande_habilitation]])->first();
       // dd($demandehabilitation->visites->statut);
       // dd($visites);

       $rapportVisite = RapportsVisites::where([['id_visites','=',@$visites->id_visites]])->get();
      // $rapportVisitef = RapportsVisites::where([['id_demande_habilitation','=',@$demandehabilitation->id_demande_habilitation]])->first();

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);
       // dd($infoentreprise->pay->id_pays);
        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        //dd($pay);
        $payList = "<option value=''> Selectionnez un pays</option>";
        foreach ($pays as $comp) {
            $payList .= "<option value='" . $comp->id_pays  . "'>" . $comp->libelle_pays ." </option>";
        }



        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id1]])->get();



        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id1]])->get();
        //dd($idetape);



        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id1]])->get();







        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();





        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
                                                          ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
                                                          ->join('type_domaine_demande_habilitation','domaine_demande_habilitation.id_type_domaine_demande_habilitation','type_domaine_demande_habilitation.id_type_domaine_demande_habilitation')
                                                          ->join('type_domaine_demande_habilitation_public','domaine_demande_habilitation.id_type_domaine_demande_habilitation_public','type_domaine_demande_habilitation_public.id_type_domaine_demande_habilitation_public')
                                                          ->join('formateurs','formateur_domaine_demande_habilitation.id_formateurs','formateurs.id_formateurs')
                                                          ->where([['id_demande_habilitation','=',$id1]])
                                                          ->get();


        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id1]])->get();

        $commentairenonrecevables = CommentaireNonRecevableDemande::where([['id_demande','=',$id1],['code_demande','=','HAB']])->get();

        $piecesDemandeHabilitations = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();

        $avisgobales = AvisGlobaleComiteTechnique::where([['id_demande','=',$id1],['code_processus','=','HAB']])->get();


        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
        ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
            'v.comment_parcours', 'v.id_processus')
        ->where('v.id_processus', '=', $demandehabilitation->id_processus)
        ->where('v.id_demande', '=', $demandehabilitation->id_demande_habilitation)
        ->orderBy('v.priorite_combi_proc', 'ASC')
        ->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES '

        ]);

        return view('comites.traitementcomite.editerhabilitation', compact(
            'comite','idetape','id','id1','processuscomite','cahiers',
            'idcomite','cahiersplanprojet','piecesDemandeHabilitations','interventionsHorsCis',
            'formateurs','avisgobales','commentairenonrecevables','domaineDemandeHabilitations',
            'organisations','interventions','moyenpermanentes','banque','rapportVisite','visites',
            'demandehabilitation','pay','ResultProssesList','idcahier'
        ));

    }

    public function showficheanalysehabilitation($id,$id1,$id2) {
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);

        $demandehabilitation = DemandeHabilitation::find($id1);

        $visite = Visites::where([['id_demande_habilitation','=',$id1]])->first();

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

        $formateurs = DB::table('vue_formateur_rapport')->where([['id_demande_habilitation','=',$id1]])->get();

        $rapport = RapportsVisites::where([['id_demande_habilitation','=',$id1]])->first();

        $piecesDemandes = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id1]])->get();

        $avis = AvisGlobaleComiteTechnique::where([
            ['id_demande', '=', $id1],
            ['code_processus', '=', 'HAB']
        ])->latest('id_avis_globale_comite_technique')->first();

        //dd($avis->statutOperation->libelle_statut_operation);

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'TENUE DE COMITES (HABILITATION : CONSULTER LA FICHE ANALYSTE)'

        ]);

        return view('comites.traitementcomite.showficheanalysehabilitation',compact('id','infoentreprise',
                        'demandehabilitation','visite','formateurs','rapport','piecesDemandes','avis'));
    }

    public function cvformateur($id)
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

            'menu'=>'COMITE  (VOIR LE CV DU FORMATEUR)',

            'etat'=>'Succès',

            'objet'=>'Voir le cv'

        ]);

        return view('comites.traitementcomite.cvformateur', compact('id','formateur','qualification',
                        'formations','experiences','languesformateurs','competences'));
    }
    public function editprojetformation($id,$id1,$id2)
    {
//dd('testrejetformation');
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;
        //dd($idetape);

        $comite = Comite::find($id);

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $listedemandesss = DB::table('cahier_plans_projets')->select('entreprises.raison_social_entreprises','users.name','users.prenom_users','projet_formation.code_projet_formation',
                'projet_formation.date_soumis','projet_formation.date_instructions','date_soumis_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets',
                'projet_formation.cout_projet_instruction','projet_formation.flag_traiter_commission_permanente','projet_formation.id_projet_formation as id_demande')
                ->join('cahier_comite','cahier_plans_projets.id_cahier_plans_projets','cahier_comite.id_demande')
                ->join('comite','cahier_comite.id_comite','comite.id_comite')
                ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
                ->join('ligne_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets','ligne_cahier_plans_projets.id_cahier_plans_projets')
                ->join('projet_formation','ligne_cahier_plans_projets.id_demande','projet_formation.id_projet_formation')
                ->join('entreprises','projet_formation.id_entreprises','entreprises.id_entreprises')
                ->join('users','projet_formation.id_conseiller_formation','users.id')
                ->where([['cahier_comite.id_comite','=',$id],
                ['cahier_comite.id_demande','=',$id1],
                ['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',true],
                ['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
                ->get();
        //dd($listedemandesss);
        //$comiteparticipants = ComiteParticipant::where([['id_comite','=',$id]])->get();

        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
        ->join('users','comite_participant.id_user_comite_participant','users.id')
        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', 'roles.id')
        ->where([['id_comite','=',$id]])
        ->get();
        //dd($comiteparticipants);

        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'COMITES',
            'etat'=>'Succès',
            'objet'=>'TENUE DE COMITES '
        ]);

        return view('comites.traitementcomite.editprojetformation', compact(
            'comite','idetape','id','id1','processuscomite','cahiers','comiteparticipants','listedemandesss'
        ));

    }


    public function editerprojetformation($id,$id1,$id2,$id3)
    {
        $idcomite=  Crypt::UrldeCrypt($id);
        $id = Crypt::UrldeCrypt($id1);
        $idetape = Crypt::UrldeCrypt($id2);
        $idcahier =  Crypt::UrldeCrypt($id3);

        $comite = Comite::find($idcomite);
        //dd('id_projet_formation . ' .$id) ;

        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();
        $cahiersplanprojet = CahierPlansProjets::find($idcahier);
        //dd($cahiersplanprojet);

        if(isset($id)){


            $user_id = Auth::user()->id;
        $roles = DB::table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->where([['users.id','=',$user_id]])
                ->first();
            $idroles = $roles->role_id;
        $nomrole = $roles->name ;
        //dd($id);
        $projetetude = ProjetFormation::find($id);
        $entreprise_info = Entreprises::find($projetetude->id_entreprises);
        //dd($entreprise->raison_social_entreprises);
        // Domaine Formation
        $domaineformationselect = ListeDomaineProjetFormation::Select('liste_domaine_projet_formation.id_liste_domaine_projet_formation as id_liste_domain_select',
         'domaine_projet_formation.libelle as libelle_domaine')
        ->join('projet_formation','liste_domaine_projet_formation.id_projet_formation','projet_formation.id_projet_formation')
        ->join('domaine_projet_formation', 'liste_domaine_projet_formation.id_domaine_formation', 'domaine_projet_formation.id_domaine_projet_formation')
        ->where([['liste_domaine_projet_formation.id_projet_formation','=',$id]])
        ->get();

       // dd($projetetude);
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','1']])->get();
        $piecesetude1 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','2']])->get();
        $piecesetude2 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','3']])->get();
        $piecesetude3 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','4']])->get();
        $piecesetude4 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','5']])->get();
        $piecesetude5 = $piecesetude['0']['libelle_pieces'];
        $piecesetude = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','6']])->get();
        $piecesetude6 = $piecesetude['0']['libelle_pieces'];
        $piecesetude_ins = PiecesProjetFormation::where([['id_projet_formation','=',$id],['code_pieces','=','7']])->get();
        if($piecesetude_ins->count()> 0){
            $piecesetude7 = $piecesetude_ins['0']['libelle_pieces'];
        }else {
            $piecesetude7 = null ;
        }
        // $piecesetude7 = $piecesetude_ins['0']['libelle_pieces'];
        // dd($piecesetude7);
        // Pieces Projet Etudes
        //dd($projetetude->piecesProjetEtudes['0']->libelle_pieces);
        //dd($projetetude->flag_soumis);
        // Infos entrerprises
        $user = User::find(Auth::user()->id);
        if($nomrole == "ENTREPRISE"){
            $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);
        }else{
            $entreprise = InfosEntreprise::get_infos_entreprise($projetetude->entreprise->ncc_entreprises);
        }
        // dd($nomrole);
        // $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);
        // dd($projetetude->entreprise->ncc_entreprises);
        //dd($entreprise);
        if($projetetude->flag_soumis == true) {
            // Liste des agences
            $listeuser = User::all();
            $listeuserfinal = "<option value=''> Selectionnez un agent </option>";
            foreach ($listeuser as $comp) {
                $listeuserfinal .= "<option value='" . $comp->id  . "'>" . $comp->name . " ". $comp->prenom_users   ." </option>";
            }

        }else{
            $listeuserfinal = "";
        }
        if($projetetude->flag_soumis == true) {
            // Liste des departements
            $listeuser = Departement::all();
            $listedepartment = "<option value=''> Selectionnez un departement </option>";
            foreach ($listeuser as $comp) {
                $listedepartment .= "<option value='" . $comp->id_departement  . "'>" . $comp->libelle_departement ." </option>";
            }

        }else{
            $listedepartment = "";
        }
        // Liste des service
        if($projetetude->flag_soumis == true) {
           // Liste des services
            //$listeuser = Service::all();
            // Selection du departement
            $id_departement = $projetetude->id_departement;
            //dd($id_departement);
            $listeuser = Service::where('id_departement','=', $id_departement)->get();
            //dd($listeuser);
            $listeservice = "<option value=''> Selectionnez un service </option>";
            foreach ($listeuser as $comp) {
                $listeservice .= "<option value='" . $comp->id_service  . "'>" . $comp->libelle_service ." </option>";
            }

        }else{
            $listeservice = "";
        }
        // recuperation chef de service
        if($projetetude->flag_soumis_chef_service == true ){

            $id_cs = $projetetude->id_chef_serv;
            $user_cs = User::find($id_cs);
             $user_cs_name = $user_cs->name . ' '.$user_cs->prenom_users;
        }else {
            $user_cs_name = '';
        }

         // recuperation du departement
         if($projetetude->flag_affect_departement == true ){

            $id_dep = $projetetude->id_departement;
            //dd($id_cs);
            $departement = Departement::find($id_dep);
            $departement_name = $departement->libelle_departement;
            // $user_cs_name = $user_cs->name . ' '.$user_cs->prenom_users;
        }else {
            $departement_name = '';
        }

         // recuperation du service
         if($projetetude->flag_affect_service == true ){

            $id_serv = $projetetude->id_service;
            //dd($id_cs);
            $service = Service::find($id_serv);
            $service_name = $service->libelle_service;
            // $user_cs_name = $user_cs->name . ' '.$user_cs->prenom_users;
        }else {
            $service_name = '';
        }

         // recuperation du conseiller
         if($projetetude->flag_affect_conseiller_formation == true ){

            $id_serv = $projetetude->id_conseiller_formation;
            //dd($id_cs);
            $conseiller = User::find($id_serv);
           // dd($conseiller);
            $conseiller_name = $conseiller->name . " " . $conseiller->prenom_users ;
            // $user_cs_name = $user_cs->name . ' '.$user_cs->prenom_users;
        }else {
            $conseiller_name = '';
        }


        // recuperation charge d'etude
        if($projetetude->flag_soumis_charge_etude == true ){

            $id_cs = $projetetude->id_charge_etude;
            //dd($id_cs);
            $user_cs = User::find($id_cs);
             $user_ce_name = $user_cs->name . ' '.$user_cs->prenom_users;
        }else {
            $user_ce_name = '';
        }

        // Recuperation des conseillers

        // Note : Recuperer les conseillers en fonction de l'agence de l'entreprise

        // $num_agce = Auth::user()->num_agce;
        $num_agce = $projetetude->num_agce;

        $num_direction = Auth::user()->id_direction;
        $chargetude = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->select('users.name', 'users.prenom_users', 'users.id')
        ->where([['roles.id','=',20],['users.num_agce','=',$num_agce]])
        ->get();
        //dd($chargetude);
        //$listeuser = User::all();
        $listeuser = $chargetude;
        $listeuserfinal = "<option value=''> Selectionnez un conseiller en formation </option>";
        foreach ($listeuser as $comp) {
            $listeuserfinal .= "<option value='" . $comp->id  . "'>" . $comp->name . " ". $comp->prenom_users   ." </option>";
        }

        // recuperation de l'etat de recevabilite
        $idmot = $projetetude->motif_rec ;
        if($projetetude->flag_valide == true ){

             $etat_dossier = 'Valide';
        }else {
            $etat_dossier = 'Rejete';
        }

        $motif_p = $projetetude->motif_rec ;
        //dd($motif);


        // Recuperation des motif & des statuts de recevabilite
        $motif = Motif::where([['code_motif','=','PRE']])->get();;
        $motifs = "<option value=''> Selectionnez un motif </option>";
        foreach ($motif as $comp) {
            $motifs .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }
        $statut = StatutOperation::where([['code_statut_operation','=','PRE']])->get();;
        $statuts = "<option value=''> Selectionnez un statut </option>";
        foreach ($statut as $comp) {
            $statuts .= "<option value='" . $comp->id_statut_operation  . "'>" . $comp->libelle_statut_operation ." </option>";
        }
        //dd($motifs);

        return view('comites.traitementcomite.editerprojetformation',
        compact('conseiller_name','service_name','listeservice','departement_name','listedepartment','entreprise_info',
        'user','nomrole','entreprise','motifs','motif_p','etat_dossier','statuts','motifs','user_ce_name','user_cs_name','projetetude',
        'cahiersplanprojet','comite','formjuridiques',
        'listeuserfinal','piecesetude1','piecesetude2','piecesetude3','piecesetude4' ,'piecesetude5','piecesetude6','piecesetude7','domaineformationselect'));


            }


    }


    public function editprojetetude($id,$id1,$id2){
        $id =  Crypt::UrldeCrypt($id);
        $id1 =  Crypt::UrldeCrypt($id1);
        $idetape =  Crypt::UrldeCrypt($id2);
        $idcomite =  $id;
        $comite = Comite::find($id);

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();
        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->first();

        $listedemandesss = DB::table('cahier_plans_projets')
            ->select('entreprises.raison_social_entreprises','users.name','users.prenom_users','projet_etude.code_projet_etude',
               'projet_etude.flag_valider_comite_permanente_projet_etude','projet_etude.flag_valider_comite_gestion_projet_etude',
                'projet_etude.date_soumis','projet_etude.date_instruction','date_soumis_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets',
            'projet_etude.montant_projet_instruction','projet_etude.id_projet_etude as id_demande')
            ->join('cahier_comite','cahier_plans_projets.id_cahier_plans_projets','cahier_comite.id_demande')
            ->join('comite','cahier_comite.id_comite','comite.id_comite')
            ->join('comite_participant','comite.id_comite','comite_participant.id_comite')
            ->join('ligne_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets','ligne_cahier_plans_projets.id_cahier_plans_projets')
            ->join('projet_etude','ligne_cahier_plans_projets.id_demande','id_projet_etude')
            ->join('entreprises','projet_etude.id_entreprises','entreprises.id_entreprises')
            ->join('users','projet_etude.id_charge_etude','users.id')
            ->where([['cahier_comite.id_comite','=',$id],
                ['cahier_comite.id_demande','=',$id1],
                ['cahier_plans_projets.flag_traitement_cahier_plans_projets','=',true],
                ['comite_participant.id_user_comite_participant','=',Auth::user()->id]])
            ->get();


        $comiteparticipants = ComiteParticipant::Select('comite_participant.id_comite as id_comite', 'users.name as name','users.prenom_users as prenom_users','roles.name as profile','comite_participant.id_comite_participant as id_comite_participant')
            ->join('users','comite_participant.id_user_comite_participant','users.id')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where([['id_comite','=',$id]])
            ->get();

        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'COMITES',
            'etat'=>'Succès',
            'objet'=>'TENUE DE COMITES '
        ]);

        return view('comites.traitementcomite.editprojetetude', compact(
            'comite','idetape','id','id1','processuscomite','cahiers','comiteparticipants','listedemandesss'
        ));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function editerprojetetude($id,$id1,$id2,$id3)
    {
        $idcomite=  Crypt::UrldeCrypt($id);
        $id = Crypt::UrldeCrypt($id1);
        $idetape = Crypt::UrldeCrypt($id2);
        $idcahier =  Crypt::UrldeCrypt($id3);
        $comite = Comite::find($idcomite);


        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();
        $cahiersplanprojet = CahierPlansProjets::find($idcahier);

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


                $formjuridique = "<option value='".$infoentreprise->formeJuridique->id_forme_juridique."'> " . $infoentreprise->formeJuridique->libelle_forme_juridique . "</option>";

                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                }

                $domaine_projets = DomaineFormation::where('flag_domaine_formation', '=', true)
                    ->orderBy('libelle_domaine_formation')
                    ->get();

                $domaine_projet = "<option value='".$projet_etude->DomaineProjetEtude->id_domaine_formation."'> " . $projet_etude->DomaineProjetEtude->libelle_domaine_formation . "</option>";
                foreach ($domaine_projets as $comp) {
                    $domaine_projet .= "<option value='" . $comp->id_domaine_formation."'>" . mb_strtoupper($comp->libelle_domaine_formation) . " </option>";
                }

                $motif = Motif::where('code_motif','=','PRE')->get();;
                $motifs = "<option value='".$projet_etude->motif->id_motif."'> " . $projet_etude->motif->libelle_motif . "</option>";
                foreach ($motif as $comp) {
                    $motifs .= "<option value='" . $comp->id_motif  . "' >" . $comp->libelle_motif ." </option>";
                }

//                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
//                    ->orderBy('libelle_secteur_activite')
//                    ->get();
//
//                $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
//                foreach ($secteuractivite_projets as $comp) {
//                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
//                }


                $domaine_projets = DomaineFormation::where('flag_domaine_formation', '=', true)
                    ->orderBy('libelle_domaine_formation')
                    ->get();

                $domaine_projet = "<option value='".$projet_etude->DomaineProjetEtude->id_domaine_formation."'> " . $projet_etude->DomaineProjetEtude->libelle_domaine_formation . "</option>";
                foreach ($domaine_projets as $comp) {
                    $domaine_projet .= "<option value='" . $comp->id_domaine_formation."'>" . mb_strtoupper($comp->libelle_domaine_formation) . " </option>";
                }


                return view('comites.traitementcomite.editerprojetetude', compact(
                    'courier_demande_fin',
                    'offre_technique',
                    'formjuridique',
                    'projet_etude','pieces_projets','avant_projet_tdr',
                    'idcomite',
                    'domaine_projet',
                    'motifs',
                    'idetape',
                    'idcahier',
                    'cahiersplanprojet',
                    'pay',
                    'domaine_projets',
                    'comite',
                    'cahiersplanprojet',
                    'offre_financiere'
                ));

            }

        }
    }
}
