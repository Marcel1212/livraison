<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeCompositionCapitale;
use App\Helpers\Audit;

class TypeCompositionCapitaleController extends Controller
{
    // Afficher la liste des enregistrements
    public function index()
    {
        $typeCompositions = TypeCompositionCapitale::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DE COMPOSITION DU CAPITALE',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typecompositioncapitale.index', compact('typeCompositions'));
    }



    // Afficher le formulaire pour créer un nouvel enregistrement
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES TYPES DE COMPOSITION DU CAPITALE',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typecompositioncapitale.create');
    }

    // Enregistrer un nouvel enregistrement dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'libelle_type_composition_capitale' => 'required'
        ],[
            'libelle_type_composition_capitale.required' => 'Veuillez ajouter un libelle'
        ]);

/*         TypeCompositionCapitale::create([
            'libelle_type_composition_capitale' => $request->libelle_type_composition_capitale,
            //'flag_type_composition_capitale' => $request->flag_type_composition_capitale ?? true
            'flag_type_composition_capitale' => $request->flag_type_composition_capitale ?? true
        ]); */

       $type =  TypeCompositionCapitale::create($request->all());
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$type->id_type_composition_capitale,

            'menu'=>'LISTE DES TYPES DE COMPOSITION DU CAPITALE',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);

        return redirect()->route('typecompositioncapitale.index')->with('success', 'Enregistrement créé avec succès');
    }

    // Afficher le formulaire pour modifier un enregistrement spécifique
    public function edit($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typeComposition = TypeCompositionCapitale::findOrFail($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DE COMPOSITION DU CAPITALE',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('typecompositioncapitale.edit', compact('typeComposition'));
    }

    // Mettre à jour un enregistrement spécifique dans la base de données
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $request->validate([
            'libelle_type_composition_capitale' => 'required'
        ],[
            'libelle_type_composition_capitale.required' => 'Veuillez ajouter un libelle'
        ]);

        $input = $request->all();

        if(!isset($input['flag_type_composition_capitale'])){
            $input['flag_type_composition_capitale'] = false;
        }

        $typeComposition = TypeCompositionCapitale::findOrFail($id);
        $typeComposition->update($input);
/*         $typeComposition->update([
            'libelle_type_composition_capitale' => $request->libelle_type_composition_capitale,
            'flag_type_composition_capitale' => $request->flag_type_composition_capitale ?? true,
            'updated_at' => now(),
        ]); */
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DE COMPOSITION DU CAPITALE',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);

        return redirect()->route('typecompositioncapitale.index')->with('success', 'Enregistrement mis à jour avec succès');
    }

    // Supprimer un enregistrement spécifique de la base de données
    public function destroy($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $typeComposition = TypeCompositionCapitale::findOrFail($id);
        $typeComposition->delete();

        Audit::logSave([

            'action'=>'SUPPRESSION',

            'code_piece'=>$id,

            'menu'=>'LISTE DES TYPES DE COMPOSITION DU CAPITALE',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);

        return redirect()->route('typecompositioncapitale.index')->with('success', 'Enregistrement supprimé avec succès');
    }
}
