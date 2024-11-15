<?php

namespace App\Http\Controllers;
use App\Helpers\Audit;
use App\Models\Activites;
use Illuminate\Http\Request;
use App\Models\SecteurActivite;
use DB;
use Hash;
use Auth;
use Session;
use Image;
use File;

class SecteurActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secteuractivites = SecteurActivite::get();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES SECTEURS D\'ACTIVITES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('secteuractivite.index',compact('secteuractivites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES SECTEURS D\'ACTIVITES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('secteuractivite.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'libelle_secteur_activite' => 'required'
            ],[
                'libelle_secteur_activite.required' => 'Veuillez ajouter un libelle.'
            ]);

            $secteuractivite = SecteurActivite::create($request->all());
            Audit::logSave([

                'action'=>'ENREGISTRER',

                'code_piece'=>$secteuractivite->id_secteur_activite,

                'menu'=>'LISTE DES SECTEURS D\'ACTIVITES',

                'etat'=>'Succes',

                'objet'=>'ADMINISTRATION'

            ]);

            return redirect()->route('secteuractivite.index')->with('success', 'Succes : Enregistrement réussi.');
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
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $secteuractivite = SecteurActivite::find($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES SECTEURS D\'ACTIVITES',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('secteuractivite.edit', compact('secteuractivite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->validate($request, [
                'libelle_secteur_activite' => 'required'
            ],[
                'libelle_secteur_activite.required' => 'Veuillez ajouter un libelle.'
            ]);

            $id =  \App\Helpers\Crypt::UrldeCrypt($id);
            $secteuractivite = SecteurActivite::find($id);
            $input = $request->all();
            if(!isset($input['flag_actif_secteur_activite'])){
                $input['flag_actif_secteur_activite'] = false;
            }

            $secteuractivite->update($input);

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'LISTE DES SECTEURS D\'ACTIVITES',

                'etat'=>'Succes',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect()->route('secteuractivite.index')->with('success', 'Succes : mis à jour avec succès.');
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
