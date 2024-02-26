<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;
use App\Models\FormeJuridique;

class FormeJuridiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formejuridiques = FormeJuridique::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES FORMES JURIDIQUES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('formejuridique.index', compact('formejuridiques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES FORMES JURIDIQUES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('formejuridique.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formejuridique = FormeJuridique::create($request->all());
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$formejuridique->id_formejuridique,

            'menu'=>'LISTE DES FORMES JURIDIQUES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('formejuridique.index')->with('success', 'Forme juridique ajoutée avec succès.');
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
        $formejuridique = FormeJuridique::find($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES FORMES JURIDIQUES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('formejuridique.edit', compact('formejuridique'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $formejuridique = FormeJuridique::find($id);
        $formejuridique->update($request->all());
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES FORMES JURIDIQUES(forme juridique mise à jour avec succès.)',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('formejuridique.index')->with('success', 'forme juridiquen mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
