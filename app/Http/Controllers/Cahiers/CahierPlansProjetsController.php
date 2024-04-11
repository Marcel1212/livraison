<?php

namespace App\Http\Controllers\Cahiers;

use App\Http\Controllers\Controller;
use App\Models\LigneCahierPlansProjets;
use Illuminate\Http\Request;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Models\CahierPlansProjets;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\PlanFormation;
use App\Models\ProcessusComite;
use App\Models\ProjetEtude;
use App\Models\ProjetFormation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Helpers\EtatCahierPlanDeFormation;
use App\Models\CategorieComite;

class CahierPlansProjetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cahiers = CahierPlansProjets::all();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'CAHIERS (Cahier de plan et/ou projets )',

            'etat'=>'Succès',

            'objet'=>'CAHIERS'

        ]);

        return view("cahiers.cahier.index", compact("cahiers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Direction::join('departement','direction.id_direction','departement.id_direction')->where([
            ['direction.id_direction','=','4'],['departement.flag_departement','=',true]
            ])->get();

        $departementsListe = "<option value=''> Selectionnez le/les processus </option>";
        foreach ($departements as $comp) {
            $departementsListe .= "<option value='" . $comp->id_departement . "'>" . mb_strtoupper($comp->libelle_departement) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
        $processuscomitesListe = "<option value=''> Selectionnez le/les processus </option>";
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

        $categoriecomites = CategorieComite::where([['flag_actif_categorie_comite','=',true],['code_categorie_comite','=','CP']])->orderBy('libelle_categorie_comite')->get();
        $categoriecomitesListe = "<option value=''> Selectionnez le type de comité </option>";
        foreach ($categoriecomites as $comp) {
            $categoriecomitesListe .= "<option value='" . $comp->id_categorie_comite. "'>" . mb_strtoupper($comp->libelle_categorie_comite) . " </option>";
        }
            Audit::logSave([
                'action'=>'CREER',
                'code_piece'=>'',
                'menu'=>'CAHIERS (Cahier de plan et/ou projets )',
                'etat'=>'Succès',
                'objet'=>'CAHIERS'
            ]);

        return view("cahiers.cahier.create",compact('departementsListe','processuscomitesListe','categoriecomitesListe'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'id_processus_comite' => 'required',
                'commentaire_cahier_plans_projets' => 'required'
            ],[
                'id_processus_comite.required' => 'Veuillez selection le/les processus.',
                'commentaire_cahier_plans_projets.after_or_equal' => 'Veuillez ajouter un commentaire .'
            ]);


            $input = $request->all();
            $processus = ProcessusComite::find($input['id_processus_comite']);

            if (isset($input['id_departement'])) {
                $departement = Departement::find($input['id_departement']);
                $input['code_cahier_plans_projets'] = $departement->code_profil_departement.'-'. Gencode::randStrGen(4, 5).'-'.Carbon::now()->format('Y');
                $input['id_categorie_comite'] = 3;
                $catcomite = CategorieComite::find(3);
            }else{
                $input['code_cahier_plans_projets'] = $processus->code_processus_comite.'-'. Gencode::randStrGen(4, 5).'-'.Carbon::now()->format('Y');
                $input['id_categorie_comite'] = $input['id_categorie_comite'];
                $catcomite = CategorieComite::find($input['id_categorie_comite']);
            }

            $input['id_users_cahier_plans_projets'] = Auth::user()->id;
            $input['date_creer_cahier_plans_projets'] = Carbon::now();
            $input['code_pieces_cahier_plans_projets'] = $processus->code_processus_comite;
            $input['code_commission_permante_comite_gestion'] = $catcomite->type_code_categorie_comite;

            $cahier = CahierPlansProjets::create($input);

            $insertedId = $cahier->id_cahier_plans_projets;

            Audit::logSave([

                'action'=>'CREATION',

                'code_piece'=>$insertedId,

                'menu'=>'CAHIERS (Cahier de plan et/ou projets )',

                'etat'=>'Succès',

                'objet'=>'CAHIERS'

            ]);

            return redirect('cahierplansprojets/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');

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
    public function edit($id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $cahier = CahierPlansProjets::find($id);

        $departements = Direction::join('departement','direction.id_direction','departement.id_direction')->where([
            ['direction.id_direction','=','4'],['departement.flag_departement','=',true]
            ])->get();
        $departementsListe = "<option value='".@$cahier->departement->id_departement."'>".@$cahier->departement->libelle_departement."</option>";
        foreach ($departements as $comp) {
            $departementsListe .= "<option value='" . $comp->id_departement . "'>" . mb_strtoupper($comp->libelle_departement) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
        $processuscomitesListe = "<option value='".$cahier->processusComite->id_processus_comite."'> ".$cahier->processusComite->libelle_processus_comite." </option>";
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

        $categoriecomites = CategorieComite::where([['flag_actif_categorie_comite','=',true],['code_categorie_comite','=','CP']])->orderBy('libelle_categorie_comite')->get();
        $categoriecomitesListe = "<option value='".@$cahier->categorieComite->id_categorie_comite."'> ".@$cahier->categorieComite->libelle_categorie_comite." </option>";
        foreach ($categoriecomites as $comp) {
            $categoriecomitesListe .= "<option value='" . $comp->id_categorie_comite. "'>" . mb_strtoupper($comp->libelle_categorie_comite) . " </option>";
        }

        if(isset($cahier->id_departement)){
            $demandes = DB::table('vue_plans_projets_dispobinle_pour_cahier')->whereNotExists(function ($query) use ($id){
                $query->select('*')
                ->from('ligne_cahier_plans_projets')
                ->whereColumn('ligne_cahier_plans_projets.id_demande','=','vue_plans_projets_dispobinle_pour_cahier.id_demande')
                ->where('ligne_cahier_plans_projets.id_cahier_plans_projets',$id);
                 })->join('caracteristique_marge_departement','vue_plans_projets_dispobinle_pour_cahier.departement','caracteristique_marge_departement.id_departement')
                 ->where([
                 ['caracteristique_marge_departement.flag_cmd','=',true],
                 ['vue_plans_projets_dispobinle_pour_cahier.code_processus','=',$cahier->processusComite->code_processus_comite],
                 ['vue_plans_projets_dispobinle_pour_cahier.departement','=', $cahier->id_departement],
                 ])
                 ->get();
        }else{

            if ($cahier->code_commission_permante_comite_gestion == 'COP') {
                $valeur1 = 0;
                $valeur2 = 65000000;
            }else{
                $valeur1 = 65000001;
                $valeur2 = 3000000000000000000;
            }

            $demandes = DB::table('vue_plans_projets_dispobinle_pour_cahier')->whereNotExists(function ($query) use ($id){
                $query->select('*')
                ->from('ligne_cahier_plans_projets')
                ->whereColumn('ligne_cahier_plans_projets.id_demande','=','vue_plans_projets_dispobinle_pour_cahier.id_demande')
                ->where('ligne_cahier_plans_projets.id_cahier_plans_projets',$id);
                 })->join('caracteristique_marge_departement','vue_plans_projets_dispobinle_pour_cahier.departement','caracteristique_marge_departement.id_departement')
                 ->where([
                 ['caracteristique_marge_departement.flag_cmd','=',true],
                 ['vue_plans_projets_dispobinle_pour_cahier.code_processus','=',$cahier->processusComite->code_processus_comite],
                 ])
                 ->whereBetween('montant_total', [$valeur1, $valeur2])
                 ->get();
        }


        $cahierplansprojets = DB::table('vue_plans_projets_dispobinle_pour_cahier_traiter as vppdpct')
                                ->join('ligne_cahier_plans_projets','vppdpct.id_demande','ligne_cahier_plans_projets.id_demande')
                                ->join('cahier_plans_projets','ligne_cahier_plans_projets.id_cahier_plans_projets','cahier_plans_projets.id_cahier_plans_projets')
                                ->where('cahier_plans_projets.id_cahier_plans_projets',$id)
                                ->where('vppdpct.code_processus','=',$cahier->processusComite->code_processus_comite)
                                ->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id.'/ etape('.$idetape.')',

            'menu'=>'CAHIERS (Cahier de plan et/ou projets )',

            'etat'=>'Succès',

            'objet'=>'CAHIERS'

        ]);

        return view("cahiers.cahier.edit",compact('departementsListe','processuscomitesListe','id','idetape','cahier','demandes','cahierplansprojets','categoriecomitesListe'));
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
                    'id_processus_comite' => 'required',
                    'commentaire_cahier_plans_projets' => 'required'
                ],[
                    'id_processus_comite.required' => 'Veuillez selection le/les processus.',
                    'commentaire_cahier_plans_projets.after_or_equal' => 'Veuillez ajouter un commentaire .'
                ]);


                $input = $request->all();
                $processus = ProcessusComite::find($input['id_processus_comite']);

                if (isset($input['id_departement'])) {
                    $departement = Departement::find($input['id_departement']);
                    $input['code_cahier_plans_projets'] = $departement->code_profil_departement.'-'. Gencode::randStrGen(4, 5).'-'.Carbon::now()->format('Y');
                    $input['id_categorie_comite'] = 3;
                    $catcomite = CategorieComite::find(3);
                }else{
                    $input['code_cahier_plans_projets'] = $processus->code_processus_comite.'-'. Gencode::randStrGen(4, 5).'-'.Carbon::now()->format('Y');
                    $input['id_categorie_comite'] = $input['id_categorie_comite'];
                    $catcomite = CategorieComite::find($input['id_categorie_comite']);
                }

                $input['id_users_cahier_plans_projets'] = Auth::user()->id;
                $input['date_creer_cahier_plans_projets'] = Carbon::now();
                $input['code_pieces_cahier_plans_projets'] = $processus->code_processus_comite;
                $input['code_commission_permante_comite_gestion'] = $catcomite->type_code_categorie_comite;

                $cahier = CahierPlansProjets::find($id);
                $cahier->update($input);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'CAHIERS (Cahier de plan et/ou projets )',

                    'etat'=>'Succès',

                    'objet'=>'CAHIERS'

                    ]);

                return redirect('cahierplansprojets/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'Ajouter_cahier_plans_projets'){

                $cahier = CahierPlansProjets::find($id);

                $input = $request->all();
                //dd($input);exit;

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

                        return redirect('cahierplansprojets/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins un plan/projet. ');

                    }

                    $tab = $input['demande'];

                    foreach ($tab as $key => $value) {

                        //dd($value); exit;
                        $recuperationvaleur = explode('/',$value);
                        //dd($recuperationvaleur); exit;
                        $iddemande = $recuperationvaleur[0];
                        $codeprocessus = $recuperationvaleur[1];

                        LigneCahierPlansProjets::create([
                            'id_cahier_plans_projets'=> $id,
                            'id_demande'=> $iddemande,
                            'code_pieces_ligne_cahier_plans_projets' => $codeprocessus
                        ]);

                        if($codeprocessus == 'PF'){
                            $plan = PlanFormation::find($iddemande);
                            $plan->update([
                                'flag_plan_formation_valider_cahier'=> true,
                                'flag_passer_cahier_cp_cg' => true,
                                'date_passe_cahier_cp_cg' => Carbon::now()
                            ]);

                        }

                        if($codeprocessus == 'PE'){

                            $projet_etude = ProjetEtude::find($iddemande);
                            $projet_etude->flag_projet_etude_valider_cahier = true;
                            $projet_etude->flag_passer_cahier_cp_cg = true;
                            $projet_etude->date_passe_cahier_cp_cg = Carbon::now();
                            $projet_etude->update();
                        }

                        if($codeprocessus == 'PRF'){

                            $projetformation = ProjetFormation::find($iddemande);
                            $projetformation->flag_passer_cahier_cp_cg = true;
                            $projetformation->date_passe_cahier_cp_cg = Carbon::now();
                            $projetformation->update();
                        }

                    }

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'CAHIERS (Cahier de '.@$cahier->code_cahier_plans_projets.' pour le '.@$cahier->processusComite->libelle_processus_comite.' )',

                        'etat'=>'Succès',

                        'objet'=>'CAHIERS'

                        ]);

                    return redirect('cahierplansprojets/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');


                }else{

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'CAHIERS (Cahier de plan et/ou projets : Vous devez sélectionner au moins un plan/projet.)',

                        'etat'=>'Echec',

                        'objet'=>'CAHIERS'

                    ]);

                    return redirect('cahierplansprojets/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Erreur : Vous devez sélectionner au moins un plan/projet. ');


                }

            }


            if ($data['action'] == 'Traiter_cahier_plan_projet_soumis'){
                $cahier = CahierPlansProjets::find($id);

                $lignecahiers = LigneCahierPlansProjets::where([['id_cahier_plans_projets','=',$id]])->get();

                foreach ($lignecahiers as $lignecahier) {
                   $li = LigneCahierPlansProjets::find($lignecahier->id_ligne_cahier_plans_projets);
                    $li->update([
                        'flag_statut_soumis_ligne_cahier_plans_projets' => true
                    ]);
                }

                $cahier->update([
                    'flag_statut_cahier_plans_projets' => true,
                    'date_soumis_cahier_plans_projets' => Carbon::now()
                ]);

                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'CAHIERS (Cahier de plan et/ou projets )',

                    'etat'=>'Succès',

                    'objet'=>'CAHIERS'

                    ]);

                return redirect('cahierplansprojets/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

        }
    }


    public function etatpf($id){

        $id =  Crypt::UrldeCrypt($id);

        $cahier = CahierPlansProjets::find($id);

       $etatsecteuractivite =  EtatCahierPlanDeFormation::get_liste_etat_secteur_activite_cahier_plan_f($id);

       //dd($etatsecteuractivite);

       $etatactionplan = EtatCahierPlanDeFormation::get_liste_etat_action_cahier_plan_f($id);

       $etatplanf = EtatCahierPlanDeFormation::get_liste_etat_plan_cahier_plan_f($id);

       $etatbutformation = EtatCahierPlanDeFormation::get_liste_etat_but_formation_cahier_plan_f($id);

       $etattypeformation = EtatCahierPlanDeFormation::get_liste_etat_type_formation_cahier_plan_f($id);

       //dd($etatsecteuractivite);
       Audit::logSave([

        'action'=>'CONSULTER',

        'code_piece'=>$id,

        'menu'=>'CAHIERS (CAHIERS)',

        'etat'=>'Succès',

        'objet'=>'CAHIERS'

        ]);

        return view('cahiers.cahier.etatpf',compact('cahier','etatsecteuractivite','etatactionplan','etatplanf','etatbutformation','etattypeformation'));
    }

    public function etatpe($id){

        $id =  Crypt::UrldeCrypt($id);

        $cahier = CahierPlansProjets::find($id);



       Audit::logSave([

        'action'=>'CONSULTER',

        'code_piece'=>$id,

        'menu'=>'CAHIERS (CAHIERS)',

        'etat'=>'Succès',

        'objet'=>'CAHIERS'

        ]);

        return view('cahiers.cahier.etatpe',compact('cahier'));
    }

    public function etatprf($id){

        $id =  Crypt::UrldeCrypt($id);

        $cahier = CahierPlansProjets::find($id);



       //dd($etatsecteuractivite);
       Audit::logSave([

        'action'=>'CONSULTER',

        'code_piece'=>$id,

        'menu'=>'CAHIERS (CAHIERS)',

        'etat'=>'Succès',

        'objet'=>'CAHIERS'

        ]);

        return view('cahiers.cahier.etatprf',compact('cahier'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
