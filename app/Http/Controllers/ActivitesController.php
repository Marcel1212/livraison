<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activites;

class ActivitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activites = Activites::all();
        return view('activites.index', compact('activites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Activites::create($request->all());

        return redirect()->route('activites.index')
            ->with('success', 'Activites ajouté avec succès.');
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
        $activite = Activites::find($id);
        return view('activites.edit', compact('activite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $activite = Activites::find($id);
        $activite->update($request->all());

        return redirect()->route('activites.index')->with('success', 'Activites mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
