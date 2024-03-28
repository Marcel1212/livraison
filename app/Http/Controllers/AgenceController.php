<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
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
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES ANTENNES',

            'etat'=>'Succès',

            'objet'=>' ADMINISTRATION'

        ]);
        return view('agence.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES ANTENNES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
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

           $agence = Agence::create(
                [
                    'lib_agce' => strtoupper($request->input('lib_agce')),
                    'code_agce' => $request->input('code_agce'),
                    'adresse_agce' => $request->input('adresse_agce'),
                    'tel_agce' => $request->input('tel_agce'),
                    'coordonne_gps_agce' => $request->input('coordonne_gps_agce'),
                    'localisation_agce' => $request->input('localisation_agce'),
                    'flag_agce' =>  $request->input('flag_agce'),
                    'flag_siege_agce' => $request->input('flag_siege_agce'),
                    'longitude_agce' => $request->input('longitude_agce'),
                    'latitude_agce' => $request->input('latitude_agce')
                ]
            );
            Audit::logSave([

                'action'=>'ENREGISTRER',

                'code_piece'=>$agence->num_agce,

                'menu'=>'LISTE DES ANTENNES',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
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
        $localite = "<option value=''> -- Sélectionnez une localité -- </option>";
        foreach ($localites as $comp) {
            $localite .= "<option value='" . $comp->id_localite  . "'>" . $comp->libelle_localite ." </option>";
        }

        $listeagencelocalites = AgenceLocalite::where([['id_agence','=',$id]])->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$agence->num_agce,

            'menu'=>'LISTE DES ANTENNES',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
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
                        'flag_siege_agce' => $request->input('flag_siege_agce'),
                        'longitude_agce' => $request->input('longitude_agce'),
                        'latitude_agce' => $request->input('latitude_agce')
                ]);
                Audit::logSave([

                    'action'=>'MISE A JOUR',

                    'code_piece'=>$agence->num_agce,

                    'menu'=>'LISTE DES ANTENNES',

                    'etat'=>'Succès',

                    'objet'=>'ADMINISTRATION'

                ]);
                return redirect()->route('agence.index')->with('success', 'Mise à jour reussie.');
            }

            if ($data['action'] == 'Lier_agence_localite'){

                $this->validate($request, [
                    'id_localite' => 'required',
                ],[
                    'id_localite.required' => 'Veuillez sélectionner une localité',
                ]);

                $input = $request->all();

                $input['id_agence'] = $id;

                $countlo =  $secteurlierusers = AgenceLocalite::where([['id_agence', '=', $id],['id_localite', '=', $input['id_localite']]])->get();

                if(count($countlo)==0){

                   $agencelocalite= AgenceLocalite::create($input);
                    Audit::logSave([

                        'action'=>'CREER',

                        'code_piece'=>$agencelocalite->id_agence_localite,

                        'menu'=>'LISTE DES ANTENNES(ajout de localité  à une agence)',

                        'etat'=>'Succès',

                        'objet'=>'ADMINISTRATION'

                    ]);
                    return redirect()->route('agence.edit',\App\Helpers\Crypt::UrlCrypt($id))->with('success', 'Succes : Operation reussi. ');
                }else{
                    Audit::logSave([

                        'action'=>'CREER',

                        'code_piece'=>'',

                        'menu'=>'LISTE DES ANTENNES(ajout de localité  à une agence)',

                        'etat'=>'Echec',

                        'objet'=>'ADMINISTRATION'

                    ]);

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
        Audit::logSave([

            'action'=>'SUPPRIMER',

            'code_piece'=>$agencelocalite->id_agence_localite,

            'menu'=>'LISTE DES ANTENNES(suppression de localité  à une agence)',

            'etat'=>'Succes',

            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('agence.edit',\App\Helpers\Crypt::UrlCrypt($idagence))->with('success', 'Succes : Operation reussi. ');
    }

}
