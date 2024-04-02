<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Models\CritereEvaluationOffreTech;
use Illuminate\Http\Request;

class CritereEvaluationOffreTechController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $critereevaluationoffretechs = CritereEvaluationOffreTech::all();
        Audit::logSave([
            'action'=>'INDEX',
            'code_piece'=>'',
            'menu'=>'LISTE DES CRITERES EVALUATION OFFRE TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'

        ]);
        return view('critereevaluationoffretech.index', compact('critereevaluationoffretechs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([
            'action'=>'CREER',
            'code_piece'=>'',
            'menu'=>'LISTE DES CRITERE D\'EVALUATION DES OFFRES TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'
        ]);
        return view('critereevaluationoffretech.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $critereevaluationoffretech = CritereEvaluationOffreTech::create($request->all());

        Audit::logSave([
            'action'=>'CREER',
            'code_piece'=>$critereevaluationoffretech->id_critereevaluationoffretech,
            'menu'=>'LISTE DES CRITERE D\'EVALUATION DES OFFRES TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('critereevaluationoffretech.index')
            ->with('success', 'Critère d\'évaluation des offres techniques ajouté avec succès.');
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
        $critereevaluationoffretech = CritereEvaluationOffreTech::find($id);
        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'LISTE DES CRITERE D\'EVALUATION DES OFFRES TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'
        ]);
        return view('critereevaluationoffretech.edit', compact('critereevaluationoffretech'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $input = $request->all();

        if(!isset($input['flag_critere_evaluation_offre_tech'])){
            $input['flag_critere_evaluation_offre_tech'] = false;
        }
        $critereevaluationoffretech = CritereEvaluationOffreTech::find($id);
        $critereevaluationoffretech->update($input);
        Audit::logSave([
            'action'=>'MISE A JOUR',
            'code_piece'=>$id,
            'menu'=>'LISTE DES TYPES ENTREPRISES(Type entreprise mis à jour avec succès.)',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('critereevaluationoffretech.index')
            ->with('success', 'Critère d\'évaluation des offres techniques mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
