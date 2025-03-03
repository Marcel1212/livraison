<?php

namespace App\Http\Controllers;

use App\Helpers\InfosEntreprise;
use App\Models\Cotisation;
use App\Models\Entreprises;
use App\Models\TypeCotisation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CotisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
        if(!empty($infoentrprise)){
            $cotisations = Cotisation::where([['id_entreprise','=',$infoentrprise->id_entreprises]])->get();
            return view('cotisation.index',compact('cotisations'));
        }else{
            $cotisations = Cotisation::all();
            return view('cotisation.index',compact('cotisations'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $date = Carbon::now();
        $dateannee = $date->format('Y');

        $entreprises = Entreprises::where([['flag_actif_entreprises','=',true]])->get();
        $entreprise = "<option value=''> Selectionnez une entreprise </option>";
        foreach ($entreprises as $comp) {
            $entreprise .= "<option value='" . $comp->id_entreprises . "'>" . $comp->ncc_entreprises . "/" . $comp->raison_social_entreprises ." </option>";
        }

        $typeCotisations = TypeCotisation::where([['flag_type_cotisation','=',true]])->get();
        $typeCotisation = "<option value=''> Selectionnez le type de cotisation </option>";
        foreach ($typeCotisations as $comp) {
            $typeCotisation .= "<option value='" . $comp->id_type_cotisation . "'>" . $comp->libelle_type_cotisation . " </option>";
        }

        return view('cotisation.create', compact('dateannee','entreprise','typeCotisation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {


            $this->validate($request, [
                'montant' => 'required',
                'mois_cotisation' => 'required',
                'annee_cotisation' => 'required',
                'id_entreprise' => 'required',
                'id_type_cotisation' => 'required',
            ],[
                'montant.required' => 'Veuillez ajouter un montant.',
                'mois_cotisation.required' => 'Veuillez ajouter le mois de cotisation.',
                'annee_cotisation.required' => 'Veuillez ajouter l\'année de cotisation.',
                'id_entreprise.required' => 'Veuillez selectionnez l\'entreprise.',
                'id_type_cotisation.required' => 'Veuillez ajouter le type de cotisation.',
            ]);

            //dd($request->all());
            //$res = explode("-",$request->input('mois_cotisation'));
            //dd($res);
            //$annee = $res[0];
            //$mois = $res[1];
            //dd($annee);
           // dd($mois);

            $input = $request->all();
            $input['id_agent'] = Auth::user()->id;
            $infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);

            $verifis = Cotisation::where([['annee_cotisation','=',$input['annee_cotisation']],['mois_cotisation','=',$input['mois_cotisation']],['id_entreprise','=',$input['id_entreprise']]])->get();

            if(count($verifis)>=1){
                return redirect()->route('cotisation.create')->with('error', 'Erreur : Cette ligne de cotisation existe deja');
            }

            //$input['mois_cotisation'] = $mois;

            //$input['annee_cotisation'] = $annee;

            //$input['id_entreprise'] = $infoentrprise->id_entreprises;

            $input['date_paiement'] = Carbon::now();

            $input['flag_cotisation'] = true;

            Cotisation::create($input);

            return redirect()->route('cotisation.index')->with('success', 'Succes : Enregistrement reussi');

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
