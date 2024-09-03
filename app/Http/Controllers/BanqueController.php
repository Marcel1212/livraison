<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\Banque;

class BanqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banques = Banque::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES BANQUES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('banque.index', compact('banques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES BANQUES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('banque.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle_banque' => 'required'
        ],[
            'libelle_banque.required' => 'Veuillez ajouter un libelle'
        ]);


       $banque =  Banque::create($request->all());
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$banque->id_banque,

            'menu'=>'LISTE DES BANQUES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);

        return redirect()->route('banque.index')->with('success', 'Enregistrement créé avec succès');
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
    public function edit( $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $banque = Banque::findOrFail($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES BANQUES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('banque.edit', compact('banque'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $request->validate([
            'libelle_banque' => 'required'
        ],[
            'libelle_banque.required' => 'Veuillez ajouter un libelle'
        ]);

        $input = $request->all();

        if(!isset($input['flag_banque'])){
            $input['flag_banque'] = false;
        }

        $banque = Banque::findOrFail($id);
        $banque->update($input);

        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES BANQUES',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);

        return redirect()->route('banque.index')->with('success', 'Enregistrement mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
