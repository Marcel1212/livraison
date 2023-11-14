<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Localite;
use App\Models\AgenceLocalite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $Resultat = Agence::all();
        return view('agence.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agence.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'lib_agce' => 'required'
        ]);
        if ($request->isMethod('post')) {
            /*$flag_agce=0;$flag_siege_agce=0;
            if ($request->input('flag_agce')=='on') { $flag_agce=1;}
            if ($request->input('flag_siege_agce')=='on') { $flag_siege_agce=1;}*/
            Agence::create(
                [
                    'lib_agce' => strtoupper($request->input('lib_agce')),
                    'code_agce' => $request->input('code_agce'),
                    'adresse_agce' => $request->input('adresse_agce'),
                    'tel_agce' => $request->input('tel_agce'),
                    'coordonne_gps_agce' => $request->input('coordonne_gps_agce'),
                    'localisation_agce' => $request->input('localisation_agce'),
                    'flag_agce' =>  $request->input('flag_agce'),
                    'flag_siege_agce' => $request->input('flag_siege_agce')
                ]
            );
            return redirect()->route('agence.index')->with('success', 'Enregistrement reussi.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Agence $agence
     * @return \Illuminate\Http\Response
     */
   // public function edit(Agence $agence)
    public function edit($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
//dd($id);
        $agence = Agence::find($id);

        $localites = Localite::all();
        //dd($localites);
        $localite = "<option value=''> Selectionnez une localite </option>";
        foreach ($localites as $comp) {
            $localite .= "<option value='" . $comp->id_localite  . "'>" . $comp->libelle_localite ." </option>";
        }
        
        $listeagencelocalites = AgenceLocalite::where([['id_agence','=',$id]])->get();

        return view('agence.edit', compact('agence','localite','listeagencelocalites'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Agence $agence
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, Agence $agence)
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);

        if ($request->isMethod('put')) {

                $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $request->validate([
                    'lib_agce' => 'required'
                ]);
                /*$flag_agce=0;$flag_siege_agce=0;$autonom_agce=0;
                if ($request->input('flag_agce')=='on') { $flag_agce=1;}
                if ($request->input('flag_siege_agce')=='on') { $flag_siege_agce=1;}
                if ($request->input('autonom_agce')=='on') { $autonom_agce=1;}*/
                // dd($flag_agce);
                $agence = Agence::find($id);
                $agence->update(
                    [
                        'lib_agce' => strtoupper($request->input('lib_agce')),
                        'code_agce' => $request->input('code_agce'),
                        'adresse_agce' => $request->input('adresse_agce'),
                        'tel_agce' => $request->input('tel_agce'),
                        'coordonne_gps_agce' => $request->input('coordonne_gps_agce'),
                        'localisation_agce' => $request->input('localisation_agce'),
                        'flag_agce' =>  $request->input('flag_agce'),
                        'flag_siege_agce' => $request->input('flag_siege_agce')
                ]);
                return redirect()->route('agence.index')->with('success', 'Mise à jour reussie.');
            }

            if ($data['action'] == 'Lier_agence_localite'){
                
                $this->validate($request, [
                    'id_localite' => 'required',
                ],[
                    'id_localite.required' => 'Veuillez selectionnez la localite.',
                ]);

                $input = $request->all();

                $input['id_agence'] = $id;

                $countlo =  $secteurlierusers = AgenceLocalite::where([['id_agence', '=', $id],['id_localite', '=', $input['id_localite']]])->get();

                if(count($countlo)==0){

                    AgenceLocalite::create($input);

                    return redirect()->route('agence.edit',\App\Helpers\Crypt::UrlCrypt($id))->with('success', 'Succes : Operation reussi. ');
                }else{
                    return redirect()->route('agence.edit',\App\Helpers\Crypt::UrlCrypt($id))->with('error', 'Erreur : Localite deja attribuer. ');
                }
            }
        }
    }

    public function delete($id){

        $id =  \App\Helpers\Crypt::UrldeCrypt($id);

        $agencelocalite = AgenceLocalite::find($id);
        $idagence = $agencelocalite->id_agence;
        AgenceLocalite::where([['id_agence_localite','=',$id]])->delete();

        return redirect()->route('agence.edit',\App\Helpers\Crypt::UrlCrypt($idagence))->with('success', 'Succes : Operation reussi. ');
    }

}
