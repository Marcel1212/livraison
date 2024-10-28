<?php

namespace App\Http\Controllers\Cahiers;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\AutreDemandeHabilitationFormation;
use App\Models\Banque;
use App\Models\CahierAutreDemandeHabilitation;
use App\Models\CommentaireNonRecevableDemande;
use App\Models\DemandeHabilitation;
use App\Models\DemandeSuppressionHabilitation;
use App\Models\Direction;
use App\Models\DomaineAutreDemandeHabilitationFormation;
use App\Models\DomaineDemandeHabilitation;
use App\Models\DomaineDemandeSuppressionHabilitation;
use App\Models\DomaineFormation;
use App\Models\DomaineFormationCabinet;
use App\Models\Entreprises;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\Formateurs;
use App\Models\LigneCahierAutreDemandeHabilitation;
use App\Models\Motif;
use App\Models\Parcours;
use App\Models\Pays;
use App\Models\ProcessusAutreDemande;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeDomaineDemandeHabilitationPublic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GenerateCode as Gencode;
use Illuminate\Support\Facades\DB;

class TraitementCahierAutreDemandeHabilitationController extends Controller
{
    //
    public function index()
    {
        $cahiers = CahierAutreDemandeHabilitation::all();
        $user = Auth::user();
        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        $id_roles = Menu::get_id_profil(Auth::user()->id);

        $resultat_etape = DB::table('vue_processus')
            ->where('id_roles', '=', $id_roles)
            ->get();

        $resultat = null;
        if (isset($resultat_etape)) {
            $resultat = [];
            foreach ($resultat_etape as $key => $r) {
                $resultat[$key] = DB::table('vue_processus_liste as v')
                    ->join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                    ->Join('cahier_autre_demande_habilitations',
                        'p.id_demande',
                        'cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations')
                    ->where([
                        ['v.mini', '=', $r->priorite_combi_proc],
                        ['v.id_processus', '=', $r->id_processus],
                        ['v.code', '=', 'DED'],
                        ['p.id_combi_proc', '=', $r->id_combi_proc],
                        ['p.id_roles', '=', $id_roles]
                    ])
                    ->get();

            }
        }



        Audit::logSave([
            'action'=>'INDEX',
            'code_piece'=>'',
            'menu'=>'CAHIERS (Cahier des demandes extension et sub substitution )',
            'etat'=>'Succès',
            'objet'=>'CAHIERS'
        ]);

        return view("cahiers.traitement_cahier_autre_demande_habilitation.index", compact("resultat"));
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
        $idetape =  3;
        $id_combi_proc = Crypt::UrldeCrypt($id1);
        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);

        $cahier = CahierAutreDemandeHabilitation::find($id);

        $processusautre_demandes = ProcessusAutreDemande::where([['flag_processus_autre_demande','=',true]])->orderBy('libelle_processus_autre_demande')->get();

            $demandes = DB::table('vue_autre_demande_habilitation_disponible_pour_cahier')->whereNotExists(function ($query) use ($id){
                $query->select('*')
                    ->from('ligne_cahier_autre_demande_habilitations')
                    ->whereColumn('ligne_cahier_autre_demande_habilitations.id_demande','=','vue_autre_demande_habilitation_disponible_pour_cahier.id_demande')
                    ->where('ligne_cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations',$id);
            })
                ->where('vue_autre_demande_habilitation_disponible_pour_cahier.code_processus','=',$cahier->processusAutreDemande->code_processus_autre_demande)
                ->where('vue_autre_demande_habilitation_disponible_pour_cahier.code_forme_juridique','=',$cahier->type_entreprise)

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

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide','v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $cahier->id_processus_cahier_autre_demande_habilitations)
            ->where('v.id_demande', '=', $cahier->id_cahier_autre_demande_habilitations)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();


        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$cahier->id_processus_cahier_autre_demande_habilitations],
            ['id_user','=',$idUser],
            ['id_piece','=',$cahier->id_cahier_autre_demande_habilitations],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id_combi_proc]
        ])->get();

        return view("cahiers.traitement_cahier_autre_demande_habilitation.edit",compact('ResultProssesList','id_combi_proc','parcoursexist','processusautre_demandes','cahierautredemandehabilitations','id','idetape','cahier','demandes'));
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

        $cahierautredemandehabilitations = DB::table('vue_autre_demande_habilitation_disponible_pour_cahier_traiter as vppdpct')
            ->join('ligne_cahier_autre_demande_habilitations','vppdpct.id_demande','ligne_cahier_autre_demande_habilitations.id_demande')
            ->join('cahier_autre_demande_habilitations','ligne_cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations','cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations')
            ->join('autre_demande_habilitation_formation','autre_demande_habilitation_formation.id_autre_demande_habilitation_formation','ligne_cahier_autre_demande_habilitations.id_demande')
            ->join('demande_habilitation','autre_demande_habilitation_formation.id_demande_habilitation','demande_habilitation.id_demande_habilitation')
            ->join('users','autre_demande_habilitation_formation.id_chef_service','users.id')
            ->join('direction','users.id_direction','direction.id_direction')
            ->join('departement','users.id_departement','departement.id_departement')
            ->where('cahier_autre_demande_habilitations.id_cahier_autre_demande_habilitations',$id)
            ->where('vppdpct.code_processus','=',$cahier->processusAutreDemande->code_processus_autre_demande)
            ->get();

        return view("cahiers.traitement_cahier_autre_demande_habilitation.notetechnique",compact('cahier','ResultProssesList','cahierautredemandehabilitations','id'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id_cahier =  Crypt::UrldeCrypt($id);

        if(isset($id_cahier)){
            $cahier = CahierAutreDemandeHabilitation::find($id_cahier);

            if(isset($cahier)) {
                if ($request->isMethod('put')) {
                    $data = $request->all();
                    if ($data['action'] === 'Valider') {
                        $idUser = Auth::user()->id;
                        $idAgceCon = Auth::user()->num_agce;
                        $Idroles = Menu::get_id_profil($idUser);
                        $dateNow = Carbon::now();
                        $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                        $infosprocessus = DB::table('vue_processus')
                            ->where('id_combi_proc', '=', $id_combi_proc)
                            ->first();
                        $idProComb = $infosprocessus->id_combi_proc;
                        $idProcessus = $infosprocessus->id_processus;

                        Parcours::create([
                            'id_processus' => $idProcessus,
                            'id_user' => $idUser,
                            'id_piece' => $id_cahier,
                            'id_roles' => $Idroles,
                            'num_agce' => $idAgceCon,
                            'comment_parcours' => $request->input('comment_parcours'),
                            'is_valide' => true,
                            'date_valide' => $dateNow,
                            'id_combi_proc' => $idProComb,
                        ]);

                        $ResultCptVal = DB::table('combinaison_processus as v')
                            ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
                            ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
                            ->where('a.id_demande', '=', $id_cahier)
                            ->where('a.id_processus', '=', $idProcessus)
                            ->where('v.id_roles', '=', $Idroles)
                            ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                            ->first();

                        if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
                            if($cahier->code_pieces_cahier_autre_demande_habilitations=='DED'){
                                $cahier = CahierAutreDemandeHabilitation::find($id_cahier);
                                $lignes = LigneCahierAutreDemandeHabilitation::where(
                                    'id_cahier_autre_demande_habilitations',$cahier->id_cahier_autre_demande_habilitations,
                                )->get();

                                foreach ($lignes as $ligne){
                                    $demande =  AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$ligne->id_demande)->first();
                                    $demande->flag_autre_demande_habilitation_formation_valider_par_proce = true;
                                    $demande->flag_validation_autre_demande_habilitation_formation = true;
                                    $demande->date_valider_par_processus_autre_demande_habilitation_formation = now();
                                    $demande->commentaire_final_autre_demande_habilitation_formation = $request->input('comment_parcours');
                                    $demande->flag_rejeter_autre_demande_habilitation_formation = false;
                                    $demande->update();

                                    $domaine_demande_habilitation = DomaineDemandeHabilitation::where('id_autre_demande',$demande->id_autre_demande_habilitation_formation)
                                        ->first();
                                    $domaine_demande_habilitation->flag_agree_domaine_demande_habilitation = true;
                                    $domaine_demande_habilitation->flag_extension_domaine_demande_habilitation = true;
                                    $domaine_demande_habilitation->update();


                                    $habilitation = DemandeHabilitation::where('id_demande_habilitation',$demande->id_demande_habilitation)->first();
                                    $logo = Menu::get_logo();
                                    $entreprise = Entreprises::where('id_entreprises',$habilitation->id_entreprises)->first();
                                    $name = $entreprise->raison_social_entreprises;


                                    $formation_cabinet = new DomaineFormationCabinet();
                                    $formation_cabinet->id_entreprises = $entreprise->id_entreprises;
                                    $formation_cabinet->id_domaine_formation = $domaine_demande_habilitation->id_domaine_formation;
                                    $formation_cabinet->save();



                                    if (isset($user->email)) {
                                        $sujet = "Demande de suppression domaine de formation habilité";
                                        $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                        $messageMail = "<b>Monsieur le Directeur,</b>
                                            <br><br> Nous sommes ravis de vous informer que votre demande  a été validé avec succès.<br>
                                            Nous vous prions de bien vous connecter sur le portail.
                                            <br>
                                            Nous apprécions votre intérêt pour notre services.
                                            Cordialement, L'équipe e-FDFP
                                            <br>
                                            <br>
                                            <br>
                                            -----
                                            Ceci est un mail automatique, Merci de ne pas y répondre.
                                            -----
                                            ";
                                        $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $name, $messageMail, $sujet, $titre);
                                    }
                                }
                                $cahier->flag_traitement_cahier_autre_demande_habilitations = true;
                                $cahier->date_traitement_valide_flag_cahier_autre_demande_habilitations = Carbon::now();
                                $cahier->update();
                            }
                            elseif($cahier->code_pieces_cahier_autre_demande_habilitations=='DSD'){
                                $cahier = CahierAutreDemandeHabilitation::find($id_cahier);
                                $lignes = LigneCahierAutreDemandeHabilitation::where(
                                    'id_cahier_autre_demande_habilitations',$cahier->id_cahier_autre_demande_habilitations,
                                )->get();

                                foreach ($lignes as $ligne){
                                    $demande =  AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$ligne->id_demande)->first();
                                    $demande->flag_autre_demande_habilitation_formation_valider_par_proce = true;
                                    $demande->flag_validation_autre_demande_habilitation_formation = true;
                                    $demande->date_valider_par_processus_autre_demande_habilitation_formation = now();
                                    $demande->commentaire_final_autre_demande_habilitation_formation = $request->input('comment_parcours');
                                    $demande->flag_rejeter_autre_demande_habilitation_formation = false;
                                    $demande->update();

                                    $domaine_demande_habilitation = DomaineDemandeHabilitation::where('id_autre_demande',$demande->id_autre_demande_habilitation_formation)
                                        ->first();
                                    $domaine_demande_habilitation->flag_agree_domaine_demande_habilitation = true;
                                    $domaine_demande_habilitation->flag_substitution_domaine_demande_habilitation = true;
                                    $domaine_demande_habilitation->update();


                                    $habilitation = DemandeHabilitation::where('id_demande_habilitation',$demande->id_demande_habilitation)->first();
                                    $logo = Menu::get_logo();
                                    $entreprise = Entreprises::where('id_entreprises',$habilitation->id_entreprises)->first();
                                    $name = $entreprise->raison_social_entreprises;


                                    $formation_cabinet = new DomaineFormationCabinet();
                                    $formation_cabinet->id_entreprises = $entreprise->id_entreprises;
                                    $formation_cabinet->id_domaine_formation = $domaine_demande_habilitation->id_domaine_formation;
                                    $formation_cabinet->save();

                                    if(isset($autre_demande_habilitation_formation->domaineAutreDemandeHabilitationFormations)){
                                        foreach ($demande->domaineAutreDemandeHabilitationFormations as $domaineAutreDemandeHabilitationFormation){
                                            $domaine_demande_domaine_supression = DomaineAutreDemandeHabilitationFormation::where('id_domaine_demande_habilitation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
                                                ->first();
                                            $domaine_demande_domaine_supression->flag_autre_demande_habilitation_formation = false;
                                            $domaine_demande_domaine_supression->update();

                                            $domaine_demande_domaine = DomaineDemandeHabilitation::where('id_domaine_demande_habilitation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
                                                ->first();
                                            $domaine_demande_domaine->flag_agree_domaine_demande_habilitation = false;
                                            $domaine_demande_domaine->update();

                                            $habilitation = DemandeHabilitation::find($domaine_demande_domaine->id_demande_habilitation);

                                            $domaine_formation = DomaineFormationCabinet::where('id_domaine_formation',$domaine_demande_domaine->id_domaine_formation)
                                                ->where('id_entreprises',$habilitation->id_entreprises)->first();
                                            $domaine_formation->delete();

                                            $domaine_lib .= $domaine_demande_domaine->domaineFormation->libelle_domaine_formation.',';
                                        }
                                    }

                                    if (isset($entreprise->email)) {
                                        $sujet = "Demande de substitution de domaine de formation habilité";
                                        $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                        $messageMail = "<b>Monsieur le Directeur,</b>
                                            <br><br> Nous sommes ravis de vous informer que votre demande de substitution a été validé avec succès.<br>
                                            Nous vous prions de bien vous connecter sur le portail.
                                            <br>
                                            Nous apprécions votre intérêt pour notre services.
                                            Cordialement, L'équipe e-FDFP
                                            <br>
                                            <br>
                                            <br>
                                            -----
                                            Ceci est un mail automatique, Merci de ne pas y répondre.
                                            -----
                                            ";
                                        $messageMailEnvoi = Email::get_envoimailTemplate($entreprise->email, $name, $messageMail, $sujet, $titre);
                                    }
                                }
                                $cahier->flag_traitement_cahier_autre_demande_habilitations = true;
                                $cahier->date_traitement_valide_flag_cahier_autre_demande_habilitations = Carbon::now();
                                $cahier->update();


//                                $autre_demande_habilitation_formation_data = AutreDemandeHabilitationFormation::find($id_autre_demande_habilitation_formation);
//                                $autre_demande_habilitation_formation_data->flag_autre_demande_habilitation_formation_valider_par_proce = true;
//                                $autre_demande_habilitation_formation_data->flag_validation_autre_demande_habilitation_formation = true;
//                                $autre_demande_habilitation_formation_data->date_valider_par_processus_autre_demande_habilitation_formation = now();
//                                $autre_demande_habilitation_formation_data->commentaire_final_autre_demande_habilitation_formation = $request->input('comment_parcours');
//                                $autre_demande_habilitation_formation_data->update();
//
//                                $name = $autre_demande_habilitation_formation->raison_social_entreprises;
//                                $logo = Menu::get_logo();
//
//                                $domaine_lib = '';
//
//                                if(isset($autre_demande_habilitation_formation->domaineAutreDemandeHabilitationFormations)){
//                                    foreach ($autre_demande_habilitation_formation_data->domaineAutreDemandeHabilitationFormations as $domaineAutreDemandeHabilitationFormation){
//                                        $domaine_demande_domaine_supression = DomaineAutreDemandeHabilitationFormation::where('id_domaine_demande_habilitation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
//                                            ->first();
//                                        $domaine_demande_domaine_supression->flag_autre_demande_habilitation_formation = false;
//                                        $domaine_demande_domaine_supression->update();
//
//                                        $domaine_demande_domaine = DomaineDemandeHabilitation::where('id_domaine_demande_habilitation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
//                                            ->first();
//                                        $domaine_demande_domaine->flag_agree_domaine_demande_habilitation = false;
//                                        $domaine_demande_domaine->update();
//
//                                        $habilitation = DemandeHabilitation::find($domaine_demande_domaine->id_demande_habilitation);
//
//                                        $domaine_formation = DomaineFormationCabinet::where('id_domaine_formation',$domaine_demande_domaine->id_domaine_formation)
//                                            ->where('id_entreprises',$habilitation->id_entreprises)->first();
//                                        $domaine_formation->delete();
//
//                                        $domaine_lib .= $domaine_demande_domaine->domaineFormation->libelle_domaine_formation.',';
//
//                                    }
//                                }
                            }

                        }

                            return redirect('traitementcahierautredemandehabilitations/' . Crypt::UrlCrypt($id_cahier) . '/' . Crypt::UrlCrypt($id_combi_proc) .'/'.Crypt::UrlCrypt(3). '/edit')->with('success', 'Succes : Operation validée avec succes ');
                        }

                    if ($data['action'] === 'Rejeter') {
                        $idUser = Auth::user()->id;
                        $idAgceCon = Auth::user()->num_agce;
                        $Idroles = Menu::get_id_profil($idUser);
                        $dateNow = Carbon::now();
                        $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                        $infosprocessus = DB::table('vue_processus')
                            ->where('id_combi_proc', '=', $id_combi_proc)
                            ->first();
                        $idProComb = $infosprocessus->id_combi_proc;
                        $idProcessus = $infosprocessus->id_processus;

                        Parcours::create([
                            'id_processus' => $idProcessus,
                            'id_user' => $idUser,
                            'id_piece' => $id_cahier,
                            'id_roles' => $Idroles,
                            'num_agce' => $idAgceCon,
                            'comment_parcours' => $request->input('comment_parcours'),
                            'is_valide' => true,
                            'date_valide' => $dateNow,
                            'id_combi_proc' => $idProComb,
                        ]);
                        $cahier = CahierAutreDemandeHabilitation::find($id_cahier);
                        $lignes = LigneCahierAutreDemandeHabilitation::where(
                            'id_cahier_autre_demande_habilitations',$cahier->id_cahier_autre_demande_habilitations,
                        )->get();

                        foreach ($lignes as $ligne){
                            $demande =  AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$ligne->id_demande)->first();
                            $demande->flag_autre_demande_habilitation_formation_valider_par_proce = true;
                            $demande->flag_validation_autre_demande_habilitation_formation = false;
                            $demande->date_valider_par_processus_autre_demande_habilitation_formation = now();
                            $demande->commentaire_final_autre_demande_habilitation_formation = $request->input('comment_parcours');
                            $demande->flag_rejeter_autre_demande_habilitation_formation = true;
                            $demande->update();

                            $domaine_demande_habilitation = DomaineDemandeHabilitation::where('id_autre_demande',$demande->id_autre_demande_habilitation_formation)
                                ->first();
                            $domaine_demande_habilitation->flag_agree_domaine_demande_habilitation = false;
                            $domaine_demande_habilitation->flag_extension_domaine_demande_habilitation = false;
                            $domaine_demande_habilitation->update();


                            $habilitation = DemandeHabilitation::where('id_demande_habilitation',$demande->id_demande_habilitation)->first();
                            $logo = Menu::get_logo();
                            $entreprise = Entreprises::where('id_entreprises',$habilitation->id_entreprises)->first();
                            $name = $entreprise->raison_social_entreprises;

                            if (isset($entreprise->email)) {
                                $sujet = "Demande de suppression domaine de formation habilité";
                                $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                $messageMail = "<b>Monsieur le Directeur,</b>
                                            <br><br> Nous désolé de vous informer que votre demande  a été rejété.<br>
                                            Nous vous prions de bien vous connecter sur le portail.
                                            <br>
                                            Nous apprécions votre intérêt pour notre services.
                                            Cordialement, L'équipe e-FDFP
                                            <br>
                                            <br>
                                            <br>
                                            -----
                                            Ceci est un mail automatique, Merci de ne pas y répondre.
                                            -----
                                            ";
                                $messageMailEnvoi = Email::get_envoimailTemplate($entreprise->email, $name, $messageMail, $sujet, $titre);
                            }
                        }
                        $cahier->flag_traitement_cahier_autre_demande_habilitations = true;
                        $cahier->date_traitement_valide_flag_cahier_autre_demande_habilitations = Carbon::now();
                        $cahier->update();
                    }

                    return redirect('traitementcahierautredemandehabilitations/' . Crypt::UrlCrypt($id_cahier) . '/' . Crypt::UrlCrypt($id_combi_proc) .'/'.Crypt::UrlCrypt(3). '/edit')->with('success', 'Succes : Operation validée avec succes ');

                }
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
        $infoentreprise = Entreprises::find($habilitation->id_entreprises);

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


        return view('cahiers.traitement_cahier_autre_demande_habilitation.show',compact('motifs',
            'id','idetape','autre_demande_habilitation_formation','commentairenonrecevables',
            'typeDomaineDemandeHabilitationList',
            'domainesList','typeDomaineDemandeHabilitationPublicList',
            'domainedemandeList','formateurs','domaine_list_demandes',
            'domainedemandes','habilitation',
            'pay','banque','infoentreprise',
            'MesformateursList'
        ));

    }



}
