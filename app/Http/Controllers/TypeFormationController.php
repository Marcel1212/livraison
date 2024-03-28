<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;
use App\Models\TypeFormation;

class TypeFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeformations = TypeFormation::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DE FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typeformation.index', compact('typeformations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DE FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typeformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $typeformation = TypeFormation::create($request->all());

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$typeformation->id_typeformation,

            'menu'=>'LISTE DES TYPES DE FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('typeformation.index')
        ->with('success', 'Type de formation ajouté avec succès.');
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
        $typeformation = TypeFormation::find($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DE FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typeformation.edit', compact('typeformation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typeformation = TypeFormation::find($id);
        $input = $request->all();

        if(!isset($input['flag_actif_formation'])){
            $input['flag_actif_formation'] = false;
        }
        $typeformation->update($input);
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DE FORMATION',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('typeformation.index')
            ->with('success', 'Type de formation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
