<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use Illuminate\Http\Request;
use App\Models\Localite;
use App\Models\Departement;
use Illuminate\Support\Facades\DB;


class LocaliteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $localites = Localite::all();
        $localite_departement = DB::table('localite')
        ->join('departement_localite', 'localite.departement_localite_id', '=', 'departement_localite.id_departement_localite')
        ->join('region', 'departement_localite.id_region', '=', 'region.id_region')
        ->join('district', 'region.id_district', '=', 'district.id_district')
        ->select('localite.*', 'departement_localite.*', 'region.*', 'district.*')
        ->get();
        //dd( $localite_departement);
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES LOCALITES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('localite.index', compact('localites','localite_departement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES LOCALITES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('localite.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $localite = Localite::create($request->all());

        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>$localite->id_localite,

            'menu'=>'LISTE DES LOCALITES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('localite.index')
            ->with('success', 'Localite ajouté avec succès.');
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
        $localite = Localite::find($id);
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES LOCALITES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('localite.edit', compact('localite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $localite = Localite::find($id);

        $input = $request->all();

        if(!isset($input['flag_localite'])){
            $input['flag_localite'] = false;
        }

        $localite->update($input);

        Audit::logSave([

            'action'=>'MISE A JOUR',

            'code_piece'=>$id,

            'menu'=>'LISTE DES LOCALITES',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('localite.index')
            ->with('success', 'Localite mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
