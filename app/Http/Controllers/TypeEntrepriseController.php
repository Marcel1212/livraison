<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;
use App\Models\TypeEntreprise;

class TypeEntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeentreprises = TypeEntreprise::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES ENTREPRISES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typeentreprise.index', compact('typeentreprises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES ENTREPRISES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typeentreprise.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $typeentreprise = TypeEntreprise::create($request->all());

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$typeentreprise->id_typeentreprise,

            'menu'=>'LISTE DES TYPES ENTREPRISES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('typeentreprise.index')
            ->with('success', 'Type entreprise ajouté avec succès.');
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
        $typeentreprise = TypeEntreprise::find($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES ENTREPRISES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typeentreprise.edit', compact('typeentreprise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $input = $request->all();

        if(!isset($input['flag_type_entreprise'])){
            $input['flag_type_entreprise'] = false;
        }
        $typeentreprise = TypeEntreprise::find($id);
        $typeentreprise->update($input);
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES ENTREPRISES(Type entreprise mis à jour avec succès.)',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('typeentreprise.index')
            ->with('success', 'Type entreprise mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
