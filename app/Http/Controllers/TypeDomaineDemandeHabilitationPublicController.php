<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Audit;
use App\Models\TypeDomaineDemandeHabilitationPublic;

class TypeDomaineDemandeHabilitationPublicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typedomainedemandehabilitations = TypeDomaineDemandeHabilitationPublic::all();
        Audit::logSave([
            'action' => 'INDEX',
            'code_piece' => '',
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION PUBLIC',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typedomainedemandehabilitationpublic.index', compact('typedomainedemandehabilitations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([
            'action' => 'CREER',
            'code_piece' => '',
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION PUBLIC',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typedomainedemandehabilitationpublic.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'libelle_type_domaine_demande_habilitation_public' => 'required'
        ],[
            'libelle_type_domaine_demande_habilitation_public.required' => 'Veuillez ajouter un libelle'
        ]);

        //dd($request->all());

        $type = TypeDomaineDemandeHabilitationPublic::create($request->all());
        Audit::logSave([
            'action' => 'CREER',
            'code_piece' => $type->id_type_domaine_demande_habilitation,
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION PUBLIC',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);

        return redirect()->route('typeddhpublic.index')->with('success', 'Enregistrement créé avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $type = TypeDomaineDemandeHabilitationPublic::findOrFail($id);
        Audit::logSave([
            'action' => 'MODIFIER',
            'code_piece' => $id,
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION PUBLIC',
            'etat' => 'Succès',
            'objet' => 'ADMINISTRATION'
        ]);
        return view('typedomainedemandehabilitationpublic.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $request->validate([
            'libelle_type_domaine_demande_habilitation_public' => 'required'
        ],[
            'libelle_type_domaine_demande_habilitation_public.required' => 'Veuillez ajouter un libelle'
        ]);

        $input = $request->all();

        if (!isset($input['flag_type_type_domaine_demande_habilitation_public'])) {
            $input['flag_type_type_domaine_demande_habilitation_public'] = false;
        }

        $type = TypeDomaineDemandeHabilitationPublic::findOrFail($id);
        $type->update($input);

        Audit::logSave([
            'action' => 'MISE A JOUR',
            'code_piece' => $id,
            'menu' => 'LISTE DES TYPES DOMAINES DEMANDE HABILITATION PUBLIC',
            'etat' => 'Succes',
            'objet' => 'ADMINISTRATION'
        ]);

        return redirect()->route('typeddhpublic.index')->with('success', 'Enregistrement mis à jour avec succès');
    }
}
