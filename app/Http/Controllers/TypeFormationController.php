<?php

namespace App\Http\Controllers;

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
        return view('typeformation.index', compact('typeformations')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typeformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TypeFormation::create($request->all());

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
        return view('typeformation.edit', compact('typeformation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typeformation = TypeFormation::find($id);
        $typeformation->update($request->all());

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
