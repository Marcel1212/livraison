<?php

namespace App\Http\Controllers;

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
        return view('formejuridique.index', compact('formejuridiques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('formejuridique.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        FormeJuridique::create($request->all());

        return redirect()->route('formejuridique.index')->with('success', 'Forme juridique ajouté avec succès.');
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

        return redirect()->route('formejuridique.index')->with('success', 'forme juridiquen mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
