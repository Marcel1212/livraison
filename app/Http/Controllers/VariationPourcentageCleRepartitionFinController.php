<?php

namespace App\Http\Controllers;

use App\Models\VariationPourcentageCleRepartitionFin;
use Illuminate\Http\Request;
use App\Helpers\Audit;
use Auth;

class VariationPourcentageCleRepartitionFinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variations = VariationPourcentageCleRepartitionFin::all();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES VARIATIONS POURCENTAGE CLE REPARTITION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('variations.index', compact('variations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES VARIATIONS POURCENTAGE CLE REPARTITION',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view("variations.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'valeur_vpcrf' => 'required',
                'flag_signe_variation' => 'required'
            ],[
                'valeur_vpcrf.required' => 'Veuillez ajouter une valeur.',
                'flag_signe_variation.required' => 'Veuillez selectionnez le signe de la variation.'
            ]);

            $variatis = VariationPourcentageCleRepartitionFin::get();

            foreach ($variatis as $var) {

                VariationPourcentageCleRepartitionFin::where([['id_vpcrf','=',$var->id_vpcrf]])->update([
                    'flag_actif_vpcrf' => false
                ]);
            }

            $input = $request->all();

            //if(!isset($input['flag_actif_vpcrf'])){
                $input['flag_actif_vpcrf'] = true;
                $input['id_user'] = Auth::user()->id;
            //}

            $varf = VariationPourcentageCleRepartitionFin::create($input);
            Audit::logSave([

                'action'=>'ENREGISTRER',

                'code_piece'=>$varf->id_vpcrf,

                'menu'=>'LISTE DES VARIATIONS POURCENTAGE CLE REPARTITION',

                'etat'=>'Succes',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect()->route('variations.index')->with('success', 'Succes : Enregistrement réussi.');
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
