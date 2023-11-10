<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeEntreprise;

class TypeEntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeentreprises = TypeEntreprise::all(); 
        return view('typeentreprise.index', compact('typeentreprises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typeentreprise.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TypeEntreprise::create($request->all());

        return redirect()->route('typeentreprise.index')
            ->with('success', 'Type entreprise ajouté avec succès.');
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
        $typeentreprise = TypeEntreprise::find($id);
        return view('typeentreprise.edit', compact('typeentreprise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typeentreprise = TypeEntreprise::find($id);
        $typeentreprise->update($request->all());

        return redirect()->route('typeentreprise.index')
            ->with('success', 'Type entreprise mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
