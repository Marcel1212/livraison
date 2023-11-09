<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ButFormation;

class ButFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $butformations = ButFormation::all(); 
        return view('butformation.index', compact('butformations')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('butformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ButFormation::create($request->all());

        return redirect()->route('butformation.index')
        ->with('success', 'But de formation ajouté avec succès.');
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
        $butformation = ButFormation::find($id);
        return view('butformation.edit', compact('butformation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $butformation = ButFormation::find($id);
        $butformation->update($request->all());

        return redirect()->route('butformation.index')
            ->with('success', 'But de formation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
