<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CentreImpot; 

class CentreImpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centreimpots = CentreImpot::all(); 
        return view('centreimpot.index', compact('centreimpots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('centreimpot.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CentreImpot::create($request->all());

        return redirect()->route('centreimpot.index')
            ->with('success', 'Centre impot ajouté avec succès.');

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
        $centreimpot = CentreImpot::find($id);
        return view('centreimpot.edit', compact('centreimpot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $centreimpot = CentreImpot::find($id);
        $centreimpot->update($request->all());

        return redirect()->route('centreimpot.index')
            ->with('success', 'Centre impot mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
