<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;
use App\Models\Agence;
use App\Models\Departement;
use App\Models\Direction;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Resultat = Direction::all();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES DIRECTIONS',

            'etat'=>'Succès',

            'objet'=>' ADMINISTRATION'

        ]);
        return view('direction.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES DIRECTIONS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('direction.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'libelle_direction' => 'required',
                //'num_agce' => 'required'
            ]);
            $input = $request->all();
            $input['libelle_direction'] = mb_strtoupper($input['libelle_direction']);
            $dir=Direction::create($input);
            Audit::logSave([

                'action'=>'ENREGISTRER',

                'code_piece'=>$dir->id_direction,

                'menu'=>'LISTE DES DIRECTIONS',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect()->route('direction.index')->with('success', 'Direction ajoutée avec succès.');
        }
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
     * @param \App\Models\Direction $direction
     * @return \Illuminate\Http\Response
     */
    public function edit(Direction $direction)
    {
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$direction->id_direction,

            'menu'=>'LISTE DES DIRECTIONS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);

        $departementss = Departement::where([['id_direction','=',$direction->id_direction]])->orderBy('libelle_departement',)->get();
        //dd($departementss);
        return view('direction.edit', compact('direction','departementss'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Direction $direction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Direction $direction)
    {
        $request->validate([
            'libelle_direction' => 'required',
          //  'num_agce' => 'required'
        ]);
        $input = $request->all();
        //dd($input);
        if(!isset($input['flag_direction'])){
            $input['flag_direction'] = false;
        }
        $input['libelle_direction'] = mb_strtoupper($input['libelle_direction']);
        $direction->update($input);
        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$direction->id_direction,

            'menu'=>'LISTE DES DIRECTIONS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('direction.index')->with('success', 'Direction mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
