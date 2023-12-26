<?php

namespace App\Http\Controllers;

use App\Models\PartEntreprise;
use Illuminate\Http\Request;

class PartEntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parts = PartEntreprise::all();

        return view("partentreprise.index", compact("parts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("partentreprise.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'valeur_part_entreprise' => 'required'
            ],[
                'valeur_part_entreprise.required' => 'Veuillez ajouter une valeur.'
            ]);

            $partvals = PartEntreprise::get();

            foreach ($partvals as $part) {

                PartEntreprise::where([['id_part_entreprise','=',$part->id_part_entreprise]])->update([
                    'flag_actif_part_entreprise' => false
                ]);
            }

            PartEntreprise::create($request->all());

            return redirect()->route('partentreprise.index')->with('success', 'Succes : Enregistrement réussi.');
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
        $part = PartEntreprise::find($id);
        return view("partentreprise.edit", compact("part"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('put')) {
            $this->validate($request, [
                'valeur_part_entreprise' => 'required'
            ],[
                'valeur_part_entreprise.required' => 'Veuillez ajouter une valeur.'
            ]);

            $id =  \App\Helpers\Crypt::UrldeCrypt($id);
            $part = PartEntreprise::find($id);
            $input = $request->all();
            if(!isset($input['flag_actif_part_entreprise'])){
                $input['flag_actif_part_entreprise'] = false;
            }

            $partvals = PartEntreprise::get();

            foreach ($partvals as $part) {

                PartEntreprise::where([['id_part_entreprise','=',$part->id_part_entreprise]])->update([
                    'flag_actif_part_entreprise' => false
                ]);
            }

            $part->update($input);

            return redirect()->route('partentreprise.index')->with('success', 'Succes : mis à jour avec succès.');
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
