<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;
use App\Models\TypeComite;

class TypeComiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typecomites = TypeComite::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DE COMITES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typecomites.index', compact('typecomites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DE COMITES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typecomites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $typeverifie = TypeComite::where([['libelle_type_comite','=', $request->libelle_type_comite],['code_type_comite','=', $request->code_type_comite]])->get();
        $input = $request->all();
        if(count($typeverifie) == 0){
            $input['valeur_min_type_comite'] = str_replace(' ', '', $request->valeur_min_type_comite);
            $input['valeur_max_type_comite'] = str_replace(' ', '', $request->valeur_max_type_comite);

           $typecomite = TypeComite::create($input);

           Audit::logSave([
            'action'=>'CREER',
            'code_piece'=>$typecomite->id_type_comite,
            'menu'=>'LISTE DES TYPES DE COMITES(Type de comité ajouté avec succès)',
            'etat'=>'Succes',
            'objet'=>'ADMINISTRATION'
        ]);
        return redirect()->route('typecomites.index')->with('success', 'Type de comité ajouté avec succès.');

    }else{
            Audit::logSave([
                'action'=>'CREER',
                'code_piece'=>'',
                'menu'=>'LISTE DES TYPES DE COMITES(Erreur : Cette combinaison existe déjà.)',
                'etat'=>'Echec',
                'objet'=>'ADMINISTRATION'
            ]);
            return redirect()->route('typecomites.create')->with('error', 'Erreur : Cette combinaison existe déjà. ');
        }

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
        $typecomite = TypeComite::find($id);
        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'LISTE DES TYPES DE COMITES',
            'etat'=>'Succes',
            'objet'=>'ADMINISTRATION'
        ]);
        return view('typecomites.edit', compact('typecomite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typecomite = TypeComite::find($id);
        $input = $request->all();

        if(!isset($input['flag_actif_type_comite'])){
            $input['flag_actif_type_comite'] = false;
        }

        $typecomite->update($input);
        Audit::logSave([
            'action'=>'MISE A JOUR',
            'code_piece'=>$id,
            'menu'=>'LISTE DES TYPES DE COMITES(Type de comité mis à jour avec succès)',
            'etat'=>'Succes',
            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('typecomites.index')->with('success', 'Type de comité mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
