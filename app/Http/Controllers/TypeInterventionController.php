<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\TypeIntervention;

class TypeInterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeinterventions = TypeIntervention::all();
        Audit::logSave([
            'action' => 'INDEX',
            'code_piece' => '',
            'menu' => 'LISTE DES TYPES D\'INTERVENTIONS',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typeintervention.index', compact('typeinterventions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([
            'action' => 'CREER',
            'code_piece' => '',
            'menu' => 'LISTE DES TYPES D\'INTERVENTIONS',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typeintervention.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle_type_intervention' => 'required'
        ],[
            'libelle_type_intervention.required' => 'Veuillez ajouter un libellé'
        ]);

        $type = TypeIntervention::create($request->all());
        Audit::logSave([
            'action' => 'CREER',
            'code_piece' => $type->id_type_intervention,
            'menu' => 'LISTE DES TYPES D\'INTERVENTIONS',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);

        return redirect()->route('typeintervention.index')->with('success', 'Enregistrement créé avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $type = TypeIntervention::findOrFail($id);
        Audit::logSave([
            'action' => 'MODIFIER',
            'code_piece' => $id,
            'menu' => 'LISTE DES TYPES D\'INTERVENTIONS',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typeintervention.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $request->validate([
            'libelle_type_intervention' => 'required'
        ],[
            'libelle_type_intervention.required' => 'Veuillez ajouter un libellé'
        ]);

        $input = $request->all();

        if (!isset($input['flag_type_intervention'])) {
            $input['flag_type_intervention'] = false;
        }

        $type = TypeIntervention::findOrFail($id);
        $type->update($input);

        Audit::logSave([
            'action' => 'MISE A JOUR',
            'code_piece' => $id,
            'menu' => 'LISTE DES TYPES D\'INTERVENTIONS',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);

        return redirect()->route('typeintervention.index')->with('success', 'Enregistrement mis à jour avec succès');
    }
}
