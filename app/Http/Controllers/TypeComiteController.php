<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeComite;

class TypeComiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typecomites = TypeComite::all();
        return view('typecomites.index', compact('typecomites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typecomites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $typeverifie = TypeComite::where([['libelle_type_comite','=', $request->libelle_type_comite],['code_type_comite','=', $request->code_type_comite]])->get();

        if(count($typeverifie) == 0){
            TypeComite::create($request->all());
        }else{
            return redirect()->route('typecomites.create')->with('error', 'Erreur : Cette combinaison existe déjà. ');
        }

        return redirect()->route('typecomites.index')->with('success', 'Type de comité ajouté avec succès.');
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
    public function edit(string $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typecomite = TypeComite::find($id);
        return view('typecomites.edit', compact('typecomite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typecomite = TypeComite::find($id);
        $typecomite->update($request->all());

        return redirect()->route('typecomites.index')->with('success', 'Type de comité mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
