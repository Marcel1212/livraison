<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activites;
use App\Models\SecteurActivite;

class ActivitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activites = Activites::all();
        return view('activites.index', compact('activites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)->orderBy('libelle_secteur_activite',)->get();
        $secteuractivite = "<option value=''> Selectionnez un secteur activité </option>";
        foreach ($secteuractivites as $comp) {
            $secteuractivite .= "<option value='" . $comp->id_secteur_activite  . "'>" . mb_strtoupper($comp->libelle_secteur_activite) ." </option>";
        }
        return view('activites.create', compact('secteuractivite'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'libelle_activites' => 'required',
                'id_secteur_activite' => 'required'
            ],[
                'libelle_activites.required' => 'Veuillez ajouter un libelle.',
                'id_secteur_activite.required' => 'Veuillez sélectionner un secteur activité.'
            ]);

            Activites::create($request->all());

            return redirect()->route('activites.index')
                ->with('success', 'Activités ajoutées avec succès.');
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
     */
    public function edit($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $activite = Activites::find($id);

        $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)->orderBy('libelle_secteur_activite',)->get();
        $secteuractivite = "<option value='".@$activite->secteurActivite->id_secteur_activite."'> " . mb_strtoupper(@$activite->secteurActivite->libelle_secteur_activite) . " </option>";
        foreach ($secteuractivites as $comp) {
            $secteuractivite .= "<option value='" . $comp->id_secteur_activite  . "'>" . mb_strtoupper($comp->libelle_secteur_activite) ." </option>";
        }
        return view('activites.edit', compact('activite','secteuractivite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('put')) {

            $this->validate($request, [
                'libelle_activites' => 'required',
                'id_secteur_activite' => 'required'
            ],[
                'libelle_activites.required' => 'Veuillez ajouter un libelle.',
                'id_secteur_activite.required' => 'Veuillez sélectionner un secteur activité.'
            ]);

            $id =  \App\Helpers\Crypt::UrldeCrypt($id);
            $activite = Activites::find($id);
            $input = $request->all();
            if(!isset($input['flag_activites'])){
                $input['flag_activites'] = false;
            }

            $activite->update($input);

            return redirect()->route('activites.index')->with('success', 'Activités mises à jour avec succès.');
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
