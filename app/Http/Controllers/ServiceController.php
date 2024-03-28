<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
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
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES SERVICES',

            'etat'=>'Succès',

            'objet'=>' ADMINISTRATION'

        ]);
        return view('service.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Departement::where([['flag_departement','=',true]])->get();
        $departement = "<option value=''> Selectionnez un departement </option>";
        foreach ($departements as $comp) {
            $departement .= "<option value='" . $comp->id_departement  . "'>" . $comp->libelle_departement ." </option>";
        }
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES SERVICES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
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

            $serv = Service::create($input);

            Audit::logSave([

                'action'=>'ENREGISTRER',

                'code_piece'=>$serv->id_service,

                'menu'=>'LISTE DES SERVICES',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
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
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $departements = Departement::where([['flag_departement','=',true]])->get();
        $departement = "<option value='".@$service->departement->id_departement."'> ".@$service->departement->libelle_departement." </option>";
        foreach ($departements as $comp) {
            $departement .= "<option value='" . $comp->id_departement  . "'>" . $comp->libelle_departement ." </option>";
        }
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$service->id_service,

            'menu'=>'LISTE DES SERVICES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
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

        if(!isset($input['flag_service'])){
            $input['flag_service'] = false;
        }

        $input['libelle_service'] = mb_strtoupper($input['libelle_service']);

        $service->update($input);

        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$service->id_service,

            'menu'=>'LISTE DES SERVICES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATIVE'

        ]);
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
