<?php

namespace App\Http\Controllers;

use App\Models\TypeCotisation;
use Illuminate\Http\Request;
use App\Helpers\Audit;
use Auth;

class TypeCotisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typecotisations = TypeCotisation::all();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DE COTISATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typecotisations.index', compact('typecotisations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DE COTISATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typecotisations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['id_user'] = Auth::user()->id;
        $typecotisation = TypeCotisation::create($input);

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$typecotisation->id_type_cotisation,

            'menu'=>'LISTE DES TYPES DE COTISATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('typecotisations.index')
        ->with('success', 'Type de cotisation ajouté avec succès.');
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
    public function edit(string $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typecotisation = TypeCotisation::find($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DE COTISATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typecotisations.edit', compact('typecotisation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typecotisation = TypeCotisation::find($id);
        $input = $request->all();

        if(!isset($input['flag_type_cotisation'])){
            $input['flag_type_cotisation'] = false;
        }
        $input['id_user'] = Auth::user()->id;
        $typecotisation->update($input);
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DE COTISATION',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('typecotisations.index')
            ->with('success', 'Type de cotisation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
