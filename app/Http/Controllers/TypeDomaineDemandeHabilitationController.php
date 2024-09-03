<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\TypeDomaineDemandeHabilitation;

class TypeDomaineDemandeHabilitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typedomainedemandehabilitations = TypeDomaineDemandeHabilitation::all();
        Audit::logSave([
            'action' => 'INDEX',
            'code_piece' => '',
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typedomainedemandehabilitation.index', compact('typedomainedemandehabilitations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([
            'action' => 'CREER',
            'code_piece' => '',
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typedomainedemandehabilitation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'libelle_type_domaine_demande_habilitation' => 'required'
        ],[
            'libelle_type_domaine_demande_habilitation.required' => 'Veuillez ajouter un libelle'
        ]);

        //dd($request->all());

        $type = TypeDomaineDemandeHabilitation::create($request->all());
        Audit::logSave([
            'action' => 'CREER',
            'code_piece' => $type->id_type_domaine_demande_habilitation,
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);

        return redirect()->route('typedomainedemandehabilitation.index')->with('success', 'Enregistrement créé avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $type = TypeDomaineDemandeHabilitation::findOrFail($id);
        Audit::logSave([
            'action' => 'MODIFIER',
            'code_piece' => $id,
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typedomainedemandehabilitation.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $request->validate([
            'libelle_type_domaine_demande_habilitation' => 'required'
        ],[
            'libelle_type_domaine_demande_habilitation.required' => 'Veuillez ajouter un libelle'
        ]);

        $input = $request->all();

        if (!isset($input['flag_type_domaine_demande_habilitation'])) {
            $input['flag_type_domaine_demande_habilitation'] = false;
        }

        $type = TypeDomaineDemandeHabilitation::findOrFail($id);
        $type->update($input);

        Audit::logSave([
            'action' => 'MISE A JOUR',
            'code_piece' => $id,
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION',
            'etat' => 'Succes',
            'objet' => 'ADMINISTRATION'
        ]);

        return redirect()->route('typedomainedemandehabilitation.index')->with('success', 'Enregistrement mis à jour avec succès');
    }
}
