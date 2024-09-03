<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\TypeOrganisationFormation;

class TypeOrganisationFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeorganisationformations = TypeOrganisationFormation::all();
        Audit::logSave([
            'action' => 'INDEX',
            'code_piece' => '',
            'menu' => 'LISTE DES TYPES D\'ORGANISATION DE FORMATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typeorganisationformation.index', compact('typeorganisationformations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([
            'action' => 'CREER',
            'code_piece' => '',
            'menu' => 'LISTE DES TYPES D\'ORGANISATION DE FORMATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typeorganisationformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle_type_organisation_formation' => 'required'
        ],[
            'libelle_type_organisation_formation.required' => 'Veuillez ajouter un libellé'
        ]);

        $type = TypeOrganisationFormation::create($request->all());
        Audit::logSave([
            'action' => 'CREER',
            'code_piece' => $type->id_type_organisation_formation,
            'menu' => 'LISTE DES TYPES D\'ORGANISATION DE FORMATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);

        return redirect()->route('typeorganisationformation.index')->with('success', 'Enregistrement créé avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $type = TypeOrganisationFormation::findOrFail($id);
        Audit::logSave([
            'action' => 'MODIFIER',
            'code_piece' => $id,
            'menu' => 'LISTE DES TYPES D\'ORGANISATION DE FORMATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typeorganisationformation.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $request->validate([
            'libelle_type_organisation_formation' => 'required'
        ],[
            'libelle_type_organisation_formation.required' => 'Veuillez ajouter un libellé'
        ]);

        $input = $request->all();

        if (!isset($input['flag_type_organisation_formation'])) {
            $input['flag_type_organisation_formation'] = false;
        }

        $type = TypeOrganisationFormation::findOrFail($id);
        $type->update($input);

        Audit::logSave([
            'action' => 'MISE A JOUR',
            'code_piece' => $id,
            'menu' => 'LISTE DES TYPES D\'ORGANISATION DE FORMATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);

        return redirect()->route('typeorganisationformation.index')->with('success', 'Enregistrement mis à jour avec succès');
    }
}
