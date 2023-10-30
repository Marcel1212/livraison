<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Resultat = Service::all();
        return view('service.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Departement::all();
        $departement = "<option value=''> Selectionnez un departement </option>";
        foreach ($departements as $comp) {
            $departement .= "<option value='" . $comp->id_departement  . "'>" . $comp->libelle_departement ." </option>";
        } 
        return view('service.create', compact('departement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'libelle_service' => 'required'
            ]);

            $input = $request->all();

            $input['libelle_service'] = mb_strtoupper($input['libelle_service']); 

            Service::create($input);

            return redirect()->route('service.index')->with('success', 'Service ajouté avec succès.');
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
     * 
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $departements = Departement::all();
        $departement = "<option value='".@$service->departement->id_departement."'> ".@$service->departement->libelle_departement." </option>";
        foreach ($departements as $comp) {
            $departement .= "<option value='" . $comp->id_departement  . "'>" . $comp->libelle_departement ." </option>";
        } 
        return view('service.edit', compact('service','departement'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'libelle_service' => 'required'
        ]);

        $input = $request->all();

        $input['libelle_service'] = mb_strtoupper($input['libelle_service']); 

        $service->update($input);      

        return redirect()->route('service.index')->with('success', 'Service mise a jour avec succès.');        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
