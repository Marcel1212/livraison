<?php

namespace App\Http\Controllers\Habilitation;

use App\Http\Controllers\Controller;
use App\Models\Comite;
use App\Models\ComiteRejeter;
use Illuminate\Http\Request;

class TraitementDemandeHabilitationRejeteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habilitations = ComiteRejeter::join('demande_habilitation','comite_rejeter.id_demande','demande_habilitation.id_demande_habilitation')
                                    ->join('users','demande_habilitation.id_charge_habilitation','users.id')
                                    ->where([['code_processus','=','HAB']])
                                    ->get();

       // dd($demandes);

        return view('habilitation.traitementrejetecomite.index', compact('habilitations'));
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
