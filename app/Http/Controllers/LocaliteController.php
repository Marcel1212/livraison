<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Localite;

class LocaliteController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $localites = Localite::all();
        return view('localite.index', compact('localites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('localite.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Localite::create($request->all());

        return redirect()->route('localite.index')
            ->with('success', 'Localite ajouté avec succès.');
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
        $localite = Localite::find($id);
        return view('localite.edit', compact('localite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $localite = Localite::find($id);
        $localite->update($request->all());

        return redirect()->route('localite.index')
            ->with('success', 'Localite mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
