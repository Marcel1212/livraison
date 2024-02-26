<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;
use App\Models\Motif;

class MotifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motifs = Motif::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES MOTIFS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('motifs.index', compact('motifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES MOTIFS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('motifs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $motif = Motif::create($request->all());

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$motif->id_motif,

            'menu'=>'LISTE DES MOTIFS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('motifs.index')
            ->with('success', 'Motif ajouté avec succès.');
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
        $motif = Motif::find($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES MOTIFS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('motifs.edit', compact('motif'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $motif = Motif::find($id);
        $motif->update($request->all());
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES MOTIFS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('motifs.index')
            ->with('success', 'Motif mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
