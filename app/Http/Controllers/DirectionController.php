<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agence;
use App\Models\Direction;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Resultat = Direction::all();
        return view('direction.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agences = Agence::all();
        $agence = "<option value=''> Selectionnez une agence </option>";
        foreach ($agences as $comp) {
            $agence .= "<option value='" . $comp->num_agce  . "'>" . $comp->lib_agce ." </option>";
        } 
        return view('direction.create', compact('agence'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'libelle_direction' => 'required',
                'num_agce' => 'required'
            ]);

            $input = $request->all();

            $input['libelle_direction'] = mb_strtoupper($input['libelle_direction']); 

            Direction::create($input);

            return redirect()->route('direction.index')->with('success', 'Direction ajouté avec succès.');
        }
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
     * @param \App\Models\Direction $direction
     * @return \Illuminate\Http\Response
     */
    public function edit(Direction $direction)
    {
        $agences = Agence::all();
        $agence = "<option value='".$direction->agence->num_agce."'> ".$direction->agence->lib_agce." </option>";
        foreach ($agences as $comp) {
            $agence .= "<option value='" . $comp->num_agce  . "'>" . $comp->lib_agce ." </option>";
        } 
        return view('direction.edit', compact('direction','agence'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Direction $direction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Direction $direction)
    {
        $request->validate([
            'libelle_direction' => 'required',
            'num_agce' => 'required'
        ]);

        $input = $request->all();

        $input['libelle_direction'] = mb_strtoupper($input['libelle_direction']); 

        $direction->update($input);

        return redirect()->route('direction.index')->with('success', 'Direction mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
