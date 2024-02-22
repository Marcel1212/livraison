<?php

namespace App\Http\Controllers;

use App\Helpers\AnneeExercice;
use App\Helpers\Crypt;
use App\Models\CleDeRepartitionFinancement;
use Illuminate\Http\Request;

class CleDeRepartitionFinancementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cles = CleDeRepartitionFinancement::get();

        return view('cle.index',compact('cles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cle.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'marge_inferieur' => 'required',
                'marge_superieur' => 'required',
                'montant_fc' => 'required',
                'coefficient' => 'required',
                'signe_montant_fc' => 'required'
            ],[
                'marge_inferieur.required' => 'Veuillez ajouter une marge inferieur.',
                'marge_superieur.required' => 'Veuillez ajouter une marge superieur.',
                'montant_fc.required' => 'Veuillez ajouter le montant fc.',
                'coefficient.required' => 'Veuillez ajouter le coefficient.',
                'signe_montant_fc.required' => 'Veuillez ajouter le signe.',
            ]);


            $anneexercice  = AnneeExercice::get_annee_exercice();

            if(!isset($anneexercice->id_periode_exercice)){
                return redirect()->route('cle.create')->with('error', 'Erreur : L\'année d\'exercice n\' a pas encore démarré');
            }

            $input = $request->all();

            $input['id_periode_exercice'] = $anneexercice->id_periode_exercice;

            CleDeRepartitionFinancement::create($input);

            return redirect()->route('clederepartitionfinancement.index')->with('success', 'Succes : Enregistrement reussi');

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
    public function edit($id)
    {
        $id = Crypt::UrldeCrypt($id);
        $cle = CleDeRepartitionFinancement::find($id);

        return view('cle.edit', compact('cle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::UrldeCrypt($id);
        if ($request->isMethod('put')) {
            $this->validate($request, [
                'marge_inferieur' => 'required',
                'marge_superieur' => 'required',
                'montant_fc' => 'required',
                'coefficient' => 'required',
                'signe_montant_fc' => 'required'
            ],[
                'marge_inferieur.required' => 'Veuillez ajouter une marge inferieur.',
                'marge_superieur.required' => 'Veuillez ajouter une marge superieur.',
                'montant_fc.required' => 'Veuillez ajouter le montant fc.',
                'coefficient.required' => 'Veuillez ajouter le coefficient.',
                'signe_montant_fc.required' => 'Veuillez ajouter le signe.',
            ]);

            $input = $request->all();

            $cle = CleDeRepartitionFinancement::find($id);

            $cle->update($input);

            return redirect()->route('clederepartitionfinancement.index')->with('success', 'Succes : Enregistrement reussi');
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
