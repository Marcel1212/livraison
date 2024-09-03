<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\TypeMoyenPermanent;

class TypeMoyenPermanentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typemoyenpermanents = TypeMoyenPermanent::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DES MOYENS PERMANENTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typemoyenpermanent.index', compact('typemoyenpermanents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DES MOYENS PERMANENTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typemoyenpermanent.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle_type_moyen_permanent' => 'required'
        ],[
            'libelle_type_moyen_permanent.required' => 'Veuillez ajouter un libelle'
        ]);


       $type =  TypeMoyenPermanent::create($request->all());
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$type->id_type_moyen_permanent,

            'menu'=>'LISTE DES TYPES DES MOYENS PERMANENTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);

        return redirect()->route('typemoyenpermanent.index')->with('success', 'Enregistrement créé avec succès');
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
        $type = TypeMoyenPermanent::findOrFail($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DES MOYENS PERMANENTS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typemoyenpermanent.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $request->validate([
            'libelle_type_moyen_permanent' => 'required'
        ],[
            'libelle_type_moyen_permanent.required' => 'Veuillez ajouter un libelle'
        ]);

        $input = $request->all();

        if(!isset($input['flag_type_moyen_permanent'])){
            $input['flag_type_moyen_permanent'] = false;
        }

        $type = TypeMoyenPermanent::findOrFail($id);
        $type->update($input);

        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DES MOYENS PERMANENTS',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);

        return redirect()->route('typemoyenpermanent.index')->with('success', 'Enregistrement mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
