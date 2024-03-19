<?php

namespace App\Http\Controllers\Comites;

use App\Http\Controllers\Controller;
use App\Models\Comite;
use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\ProcessusComite;
use App\Models\TypeComite;
use App\Helpers\Menu;
use App\Helpers\Email;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\ConseillerParAgence;
use Image;
use File;
use Auth;
use Hash;
use DB;
use App\Helpers\Crypt;
use App\Helpers\DemandePlanProjets;
use App\Models\CahierComite;
use App\Models\ProcessusComiteLieComite;
use Carbon\Carbon;

class ComitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comites = Comite::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES'

        ]);
        return view('comites.comite.index', compact('comites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $typecomites = TypeComite::where([['flag_actif_type_comite','=',true]])->orderBy('libelle_type_comite')->get();
        $typecomitesListe = "<option value=''> Selectionnez le type de comité </option>";
        foreach ($typecomites as $comp) {
            $typecomitesListe .= "<option value='" . $comp->id_type_comite.'/'. $comp->libelle_type_comite . "'>" . mb_strtoupper($comp->libelle_type_comite) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
        $processuscomitesListe = "<option value=''> Selectionnez le/les processus </option>";
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

        //dd($typecomitesListe);
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'COMITES',

            'etat'=>'Succès',

            'objet'=>'COMITES'

        ]);
        return view('comites.comite.create', compact('typecomitesListe','processuscomitesListe','processuscomitesListe'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'id_type_comite' => 'required',
                'id_processus_comite' => 'required',
                'date_debut_comite' => 'required|date|after_or_equal:now',
                'commentaire_comite' => 'required'
            ],[
                'id_type_comite.required' => 'Veuillez selectionne le comite.',
                'id_processus_comite.after_or_equal' => 'Veuillez selection le/les processus.',
                'date_debut_comite.required' => 'Veuillez ajouter une date de debut.',
                'date_debut_comite.after_or_equal' => 'La date ne doit pas être inférieure à celle du jour.',
                'commentaire_comite.required' => 'Veuillez ajouter un commentaire.',
            ]);

            $input = $request->all();
            $dateanneeencours = Carbon::now()->format('Y');
            $input['id_user_comite'] = Auth::user()->id;
            $explodetypecomite = explode("/",$request->input('id_type_comite'));

            $id_type_comite = $explodetypecomite[0];
            $libelle_type_comite = $explodetypecomite[1];
            //dd($libelle_type_comite);
            if($libelle_type_comite != 'Commission permanente'){

                $nombre = count($request->input('id_processus_comite'));

                if($nombre >=2){
                    return redirect('comites/create')->with('error', 'Erreur : Pour ce type de comite <<'.$libelle_type_comite.'>>, vous ne pouvez pas prendre plus d\'un processus');
                }

            }
            //dd($libelle_type_comite);
            $explodelibelletypecomite = explode(" ",$libelle_type_comite);
            //dd($explodelibelletypecomite);
            $explodelibelletypecomitevalue1 = $explodelibelletypecomite[0];
            $explodelibelletypecomitevalue2 = $explodelibelletypecomite[1];
            $input['code_comite'] = substr($explodelibelletypecomitevalue1,0,1).''.substr($explodelibelletypecomitevalue2,0,1).'-'. Gencode::randStrGen(4, 5) .'-'. $dateanneeencours;
            $input['id_type_comite'] = $id_type_comite;

            //dd($input);

            $comite = Comite::create($input);

            foreach($request->input('id_processus_comite') as $processus){

                $infosprocessus = ProcessusComite::find($processus);

                $processuscomite = ProcessusComiteLieComite::create([
                    'id_comite' => $comite->id_comite,
                    'id_processus_comite' => $processus,
                    'code_pieces' => $infosprocessus->code_processus_comite,
                ]);

            }

            $insertedId = $comite->id_comite;

            Audit::logSave([

                'action'=>'CREATION',

                'code_piece'=>$insertedId,

                'menu'=>'COMITES',

                'etat'=>'Succès',

                'objet'=>'COMITES'

            ]);

            return redirect('comites/'.Crypt::UrlCrypt($insertedId).'/'.Crypt::UrlCrypt(1).'/edit')->with('success', 'Succes : Enregistrement reussi ');

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

        $comite = Comite::find($id);

        $processuscomite = ProcessusComiteLieComite::where([['id_comite','=',$id]])->get();

        //$demandes  = DemandePlanProjets::plans_projets_formations_etudes(Auth::user()->num_agce,$processuscomite);

        //dd($demandes);

        //$querydemande = CahierComite::whereNotExists(function ($query) use ($id){
        $querydemande = DB::table('vue_plans_projets_formation')->whereNotExists(function ($query) use ($id){
            $query->select('*')
            ->from('cahier_comite')
            ->whereColumn('cahier_comite.id_demande','=','vue_plans_projets_formation.id_demande')
            ->where('cahier_comite.id_comite',$id);
             })->where('vue_plans_projets_formation.agence', Auth::user()->num_agce);
        foreach ($processuscomite as  $cd) {
            $querydemande->orWhere('vue_plans_projets_formation.code_processus',$cd->code_pieces);
        }
        $demandes = $querydemande->get();

        $cahiers = CahierComite::where([['id_comite','=',$id]])->get();


        return view('comites.comite.edit', compact('comite','idetape','id','processuscomite','demandes','cahiers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $comitep = Comite::find($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $this->validate($request, [
                    'commentaire_comite' => 'required',
                    'date_debut_comite' => 'required|date|after_or_equal:now',

                ],[
                    'commentaire_comite.required' => 'Veuillez ajouter un commentaire.',
                    'date_debut_comite.required' => 'Veuillez ajouter une date de debut.',
                    'date_debut_comite.after_or_equal' => 'La date ne doit pas être inférieure à celle du jour.',
                ]);

                $input = $request->all();

                //dd($input);

                $comite = Comite::find($id);
                $comite->update($input);


                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$id,

                    'menu'=>'COMITES',

                    'etat'=>'Succès',

                    'objet'=>'COMITES'

                ]);

                return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

            }

            if ($data['action'] == 'creer_cahier_plans_projets'){

                $input = $request->all();

                if(isset($input['demande'])){

                    $verifnombre = count($input['demande']);

                    //dd($verifnombre);exit;

                    if($verifnombre < 1){

                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'COMITES (Cahier du '.@$comitep->typeComite->libelle_type_comite.' : Vous devez sélectionner au moins un plan/projet pour le comite.)',

                            'etat'=>'Echec',

                            'objet'=>'COMITES'

                            ]);

                            return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un plan/projet pour le comite ');

                    }

                    $tab = $input['demande'];

                    foreach ($tab as $key => $value) {

                        //dd($value); exit;
                        CahierComite::create([
                            'id_comite'=> $id,
                            'id_demande'=> $value,
                            'flag_cahier'=>true
                        ]);
                    }

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'COMITES (Cahier de '.@$comitep->typeComite->libelle_type_comite.' )',

                        'etat'=>'Succès',

                        'objet'=>'COMITES'

                        ]);

                        return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('success', 'Succes : Information mise a jour reussi ');

                }else{

                        Audit::logSave([

                            'action'=>'MISE A JOUR',

                            'code_piece'=>$id,

                            'menu'=>'COMITES (Cahier de '.@$comitep->typeComite->libelle_type_comite.' : Vous devez sélectionner au moins un plan/projet pour le comite.)',

                            'etat'=>'Echec',

                            'objet'=>'COMITES'

                            ]);

                        return redirect('comites/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($idetape).'/edit')->with('error', 'Echec : Vous devez sélectionner au moins un plan/projet pour le comite ');



                }


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
