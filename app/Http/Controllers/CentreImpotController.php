<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
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
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES CENTRES D\'IMPOTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('centreimpot.index', compact('centreimpots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES CENTRES D\'IMPOTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('centreimpot.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $centreimpot = CentreImpot::create($request->all());

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$centreimpot->id_centreimpot,

            'menu'=>'LISTE DES CENTRES D\'IMPOTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
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
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES CENTRES D\'IMPOTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
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
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES CENTRES D\'IMPOTS',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
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
