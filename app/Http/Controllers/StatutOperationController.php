<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;
use App\Models\StatutOperation;

class StatutOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statutoperations = StatutOperation::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES STATUTS OPERATIONS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('statutoperations.index', compact('statutoperations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES STATUTS OPERATIONS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('statutoperations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $statutoperation = StatutOperation::create($request->all());

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$statutoperation->id_statutoperation,

            'menu'=>'LISTE DES STATUTS OPERATIONS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('statutoperations.index')->with('success', 'Statut Operation ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $statutoperation = StatutOperation::find($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES STATUTS OPERATIONS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('statutoperations.edit', compact('statutoperation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $statutoperation = StatutOperation::find($id);
        $input = $request->all();

        if(!isset($input['flag_statut_operation'])){
            $input['flag_statut_operation'] = false;
        }
        $statutoperation->update($input);
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES STATUTS OPERATIONS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('statutoperations.index')->with('success', 'Statut Operation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
