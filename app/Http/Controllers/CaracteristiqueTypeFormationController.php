<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Models\CaracteristiqueTypeFormation;
use App\Models\TypeFormation;
use Illuminate\Http\Request;
use App\Helpers\Crypt;

class CaracteristiqueTypeFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caracteristiques = CaracteristiqueTypeFormation::get();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES CARACTERISTIQUES DE TYPE DE FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('caracteristiquetypeformation.index', compact('caracteristiques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeformations = TypeFormation::where([['flag_actif_formation','=','true']])->get();
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES CARACTERISTIQUES DE TYPE DE FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('caracteristiquetypeformation.create', compact('typeformations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'id_type_formation' => 'required',
                'libelle_ctf' => 'required',
                'code_ctf' => 'required',
            ],[
                'id_type_formation.required' => 'Veuillez ajouter un type de formation.',
                'libelle_ctf.required' => 'Veuillez ajouter un libelle .',
                'code_ctf.required' => 'Veuillez ajouter le code.',
            ]);


            $caracteristiquetypeformation = CaracteristiqueTypeFormation::create($request->all());
            Audit::logSave([

                'action'=>'CREER',

                'code_piece'=>$caracteristiquetypeformation->id_caracteristiquetypeformation,

                'menu'=>'LISTE DES CARACTERISTIQUES DE TYPE DE FORMATION',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect()->route('caracteristiquetypeformation.index')->with('success', 'Succes : Enregistrement reussi');
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
        $id = Crypt::UrldeCrypt($id);
        $caracteristique = CaracteristiqueTypeFormation::find($id);
        $typeformations = TypeFormation::where([['flag_actif_formation','=','true']])->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES CARACTERISTIQUES DE TYPE DE FORMATION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('caracteristiquetypeformation.edit',compact('caracteristique','typeformations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = Crypt::UrldeCrypt($id);
        if ($request->isMethod('put')) {

            $this->validate($request, [
                'id_type_formation' => 'required',
                'libelle_ctf' => 'required',
                'code_ctf' => 'required',
            ],[
                'id_type_formation.required' => 'Veuillez ajouter un type de formation.',
                'libelle_ctf.required' => 'Veuillez ajouter un libelle .',
                'code_ctf.required' => 'Veuillez ajouter le code.',
            ]);

            $caracteristique = CaracteristiqueTypeFormation::find($id);

            $input = $request->all();

            if(!isset($input['flag_ctf'])){
                $input['flag_ctf'] = false;
            }

            $caracteristique->update($input);
            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'LISTE DES CARACTERISTIQUES DE TYPE DE FORMATION',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect()->route('caracteristiquetypeformation.index')->with('success', 'Succes : Enregistrement reussi');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
