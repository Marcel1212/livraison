<?php

namespace App\Http\Controllers\Habilitation;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Http\Controllers\Controller;
use App\Models\DemandeHabilitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgreementHabilitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
        $habilitations = DemandeHabilitation::where([['id_entreprises','=',$infoentrprise->id_entreprises],['flag_agrement_demande_habilitaion','=',true]])->get();

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'HABILITATION (AGREEMENT)',

            'etat'=>'Echec',

            'objet'=>'HABILITATION (AGREEMENT)'

        ]);
        return view('habilitation.agreement.index', compact('habilitations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $id =  Crypt::UrldeCrypt($id);

        $demandehabilitation = DemandeHabilitation::find($id);


        return view('habilitation.agreement.show', compact('demandehabilitation'));
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
