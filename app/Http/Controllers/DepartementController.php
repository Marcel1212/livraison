<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Models\CaracteristiqueMargeDepartement;
use App\Models\CaracteristiqueTypeFormation;
use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Service;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Resultat = Departement::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES DEPARTEMENTS',

            'etat'=>'Succès',

            'objet'=>' ADMINISTRATION'

        ]);
        return view('departement.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $directions = Direction::where([['flag_direction','=',true]])->get();
        $direction = "<option value=''> Selectionnez une direction </option>";
        foreach ($directions as $comp) {
            $direction .= "<option value='" . $comp->id_direction  . "'>" . $comp->libelle_direction ." </option>";
        }
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES DEPARTEMENTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('departement.create', compact('direction'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'libelle_departement' => 'required'
            ]);

            $input = $request->all();

            $input['libelle_departement'] = mb_strtoupper($input['libelle_departement']);

            $dep = Departement::create($input);

            Audit::logSave([

                'action'=>'ENREGISTRER',

                'code_piece'=>$dep->id_departement,

                'menu'=>'LISTE DES DEPARTEMENTS',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect()->route('departement.index')->with('success', 'Departement ajouté avec succès.');
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
     * @param \App\Models\Departement $departement
     * @return \Illuminate\Http\Response
     */
    public function edit(Departement $departement)
    {
        $directions = Direction::where([['flag_direction','=',true]])->get();
        $direction = "<option value='".@$departement->direction->id_direction."'> ".@$departement->direction->libelle_direction." </option>";
        foreach ($directions as $comp) {
            $direction .= "<option value='" . $comp->id_direction  . "'>" . $comp->libelle_direction ." </option>";
        }

        $carateristiquedepartements = CaracteristiqueMargeDepartement::where([['id_departement','=',$departement->id_departement]])->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$departement->id_departement,

            'menu'=>'LISTE DES DEPARTEMENTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);

        $services = Service::where([['id_departement','=',$departement->id_departement]])->orderBy('libelle_service',)->get();

        return view('departement.edit', compact('departement','direction','carateristiquedepartements','services'));
    }

    /**
     * Update the specified resource in storage.
     *
     *  @param \Illuminate\Http\Request $request
     * @param \App\Models\Departement $departement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'libelle_departement' => 'required'
        ]);

        $input = $request->all();

        if(!isset($input['flag_departement'])){
            $input['flag_departement'] = false;
        }

        $input['libelle_departement'] = mb_strtoupper($input['libelle_departement']);

        $departement->update($input);

        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$departement->id_departement,

            'menu'=>'LISTE DES DEPARTEMENTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('departement.index')->with('success', 'Departement mise a jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
