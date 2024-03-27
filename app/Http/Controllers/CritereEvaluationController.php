<?php

namespace App\Http\Controllers;

use App\Models\CritereEvaluation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\Audit;
use App\Models\CategorieComite;
use App\Helpers\Crypt;
use App\Models\ProcessusComite;
use Image;
use File;
use Auth;
use Hash;
use DB;

class CritereEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criteres = CritereEvaluation::all();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'CRITERE EVALUTION',

            'etat'=>'Succès',

            'objet'=>'CRITERE EVALUTION'

        ]);

        return view('critereevaluation.index',compact('criteres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $typecomites = CategorieComite::where([['flag_actif_categorie_comite','=',true]])->orderBy('libelle_categorie_comite')->get();
        $typecomitesListe = "<option value=''> Selectionnez le type de comité </option>";
        foreach ($typecomites as $comp) {
            $typecomitesListe .= "<option value='" . $comp->id_categorie_comite. "'>" . mb_strtoupper($comp->libelle_categorie_comite) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
        $processuscomitesListe = "<option value=''> Selectionnez le processus </option>";
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'CRITERE EVALUTION',

            'etat'=>'Succès',

            'objet'=>'CRITERE EVALUTION'

        ]);

        return view('critereevaluation.create',compact('typecomitesListe','processuscomitesListe'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'id_processus_comite' => 'required',
                'id_categorie_comite' => 'required',
                'libelle_critere_evaluation' => 'required',
            ],[
                'id_processus_comite.required' => 'Veuillez selectionner un processus.',
                'id_categorie_comite.required' => 'Veuillez selectionner une categorie comité .',
                'libelle_critere_evaluation.required' => 'Veuillez ajouter le departement.',
            ]);

            $input = $request->all();

            $critere = CritereEvaluation::create($input);

            $insertedId=$critere->id_critere_evaluation;

            Audit::logSave([

                'action'=>'CREATION',

                'code_piece'=>$insertedId,

                'menu'=>'CRITERE EVALUTION',

                'etat'=>'Succès',

                'objet'=>'CRITERE EVALUTION'

            ]);

             return redirect()->route('critereevaluation.index')->with('success', 'Succes : Enregistrement reussi');

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
    public function edit($id)
    {

        $id =  Crypt::UrldeCrypt($id);

        $critere = CritereEvaluation::find($id);

        $typecomites = CategorieComite::where([['flag_actif_categorie_comite','=',true]])->orderBy('libelle_categorie_comite')->get();
        $typecomitesListe = "<option value='".$critere->id_categorie_comite."'> ".mb_strtoupper($critere->categorieComite->libelle_categorie_comite)." </option>";
        foreach ($typecomites as $comp) {
            $typecomitesListe .= "<option value='" . $comp->id_categorie_comite. "'>" . mb_strtoupper($comp->libelle_categorie_comite) . " </option>";
        }

        $processuscomites = ProcessusComite::where([['flag_processus_comite','=',true]])->orderBy('libelle_processus_comite')->get();
        $processuscomitesListe = "<option value='".$critere->id_processus_comite."'> ".mb_strtoupper($critere->processusComite->libelle_processus_comite)." </option>";
        foreach ($processuscomites as $comp) {
            $processuscomitesListe .= "<option value='" . $comp->id_processus_comite . "'>" . mb_strtoupper($comp->libelle_processus_comite) . " </option>";
        }

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'CRITERE EVALUTION',

            'etat'=>'Succès',

            'objet'=>'CRITERE EVALUTION'

        ]);

        return view('critereevaluation.edit',compact('critere','typecomitesListe','processuscomitesListe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        //$critere = CritereEvaluation::find($id);

        if ($request->isMethod('put')) {

            $this->validate($request, [
                'id_processus_comite' => 'required',
                'id_categorie_comite' => 'required',
                'libelle_critere_evaluation' => 'required',
            ],[
                'id_processus_comite.required' => 'Veuillez selectionner un processus.',
                'id_categorie_comite.required' => 'Veuillez selectionner une categorie comité .',
                'libelle_critere_evaluation.required' => 'Veuillez ajouter le departement.',
            ]);

            $input = $request->all();

            $critere = CritereEvaluation::find($id);

            $critere->update($input);

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'CRITERE EVALUTION',

                'etat'=>'Succès',

                'objet'=>'CRITERE EVALUTION'

            ]);

            return redirect()->route('critereevaluation.index')->with('success', 'Succes : Information mise a jour reussi');

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
