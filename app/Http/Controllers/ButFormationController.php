<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
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
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES BUTS DE LA FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('butformation.index', compact('butformations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES BUTS DE LA FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('butformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $butformation = ButFormation::create($request->all());

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$butformation->id_butformation,

            'menu'=>'LISTE DES  BUTS DE LA FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
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
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES  BUTS DE LA FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('butformation.edit', compact('butformation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $butformation = ButFormation::find($id);
        $input = $request->all();

        if(!isset($input['flag_actif_but_formation'])){
            $input['flag_actif_but_formation'] = false;
        }
        $butformation->update($input);
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES  BUTS DE LA FORMATION',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
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
