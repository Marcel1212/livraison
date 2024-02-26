<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Models\CaracteristiqueMargeDepartement;
use Illuminate\Http\Request;

class CaracteristiqueMargeDepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'marge_inferieur_cmd' => 'required',
                'marge_superieur_cmd' => 'required',
                'id_departement' => 'required',
            ],[
                'marge_inferieur_cmd.required' => 'Veuillez ajouter une marge inferieur.',
                'marge_superieur_cmd.required' => 'Veuillez ajouter une marge superieur .',
                'id_departement.required' => 'Veuillez ajouter le departement.',
            ]);

            $input = $request->all();

            $iddepartement = $input['id_departement'];

            $lignecaracteredepartements = CaracteristiqueMargeDepartement::where([['id_departement','=',$iddepartement]])->get();

            foreach($lignecaracteredepartements as $lignecaracteredepartement){
                $lcmde = CaracteristiqueMargeDepartement::find($lignecaracteredepartement->id_caracteristique_marge_departement);
                $lcmde->update([
                    'flag_cmd' => false
                ]);
            }



            $input['flag_cmd'] = true;

            $lcmde=CaracteristiqueMargeDepartement::create($input);

            Audit::logSave([

                'action'=>'ENREGISTRER',

                'code_piece'=>$lcmde->id_caracteristique_marge_departement,

                'menu'=>'LISTE DES DEPARTEMENTS(enregistrement de la marge lié au département)',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect()->route('departement.edit',$iddepartement)->with('success', 'Succes : Enregistrement reussi');


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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $infoscaracteristique = CaracteristiqueMargeDepartement::find($id);

        $iddepartement = $infoscaracteristique->id_departement;

        CaracteristiqueMargeDepartement::where([['id_caracteristique_marge_departement','=',$id]])->delete();
        Audit::logSave([

            'action'=>'SUPPRIMER',

            'code_piece'=>$infoscaracteristique->id_caracteristique_marge_departement,

            'menu'=>'LISTE DES DEPARTEMENTS(suppression de la marge lié au département)',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);

        return redirect()->route('departement.edit',$iddepartement)->with('success', 'Succes : Enregistrement reussi');

    }
}
