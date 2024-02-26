<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
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
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES CLES DE REPARTITION FINANCEMENT',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('cle.index',compact('cles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES CLES DE REPARTITION FINANCEMENT',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
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
                Audit::logSave([

                    'action'=>'CREER',

                    'code_piece'=>$anneexercice->id_periode_exercice,

                    'menu'=>'LISTE DES CLES DE REPARTITION FINANCEMENT',

                    'etat'=>'Echec',

                    'objet'=>'ADMINISTRATION'

                ]);
                return redirect()->route('cle.create')->with('error', 'Erreur : L\'année d\'exercice n\' a pas encore démarré');
            }

            $input = $request->all();

            $input['id_periode_exercice'] = $anneexercice->id_periode_exercice;

            $clederepartitionfinancement = CleDeRepartitionFinancement::create($input);
            Audit::logSave([

                'action'=>'CREER',

                'code_piece'=>$clederepartitionfinancement->id_clederepartitionfinancement,

                'menu'=>'LISTE DES CLES DE REPARTITION FINANCEMENT',

                'etat'=>'Succes',

                'objet'=>'ADMINISTRATION'

            ]);
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
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES CLES DE REPARTITION FINANCEMENT',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
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
            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'LISTE DES CLES DE REPARTITION FINANCEMENT',

                'etat'=>'Succes',

                'objet'=>'ADMINISTRATION'

            ]);
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
