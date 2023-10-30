<?php

namespace App\Http\Controllers;

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
        return view('statutoperations.index', compact('statutoperations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('statutoperations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        StatutOperation::create($request->all());

        return redirect()->route('statutoperations.index')
            ->with('success', 'Statut Operation ajouté avec succès.');
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
        return view('statutoperations.edit', compact('statutoperation'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $statutoperation = StatutOperation::find($id);
        $statutoperation->update($request->all());

        return redirect()->route('statutoperations.index')
            ->with('success', 'Statut Operation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
