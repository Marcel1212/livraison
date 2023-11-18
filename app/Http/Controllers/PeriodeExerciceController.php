<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeExercice;
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;

class PeriodeExerciceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodeexercices = PeriodeExercice::all(); 
        return view('periodeexercice.index', compact('periodeexercices'));        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('periodeexercice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
                $this->validate($request, [
                    'date_debut_periode_exercice' => 'required',
                    'date_fin_periode_exercice' => 'required'
                ],[
                    'date_debut_periode_exercice.required' => 'Veuillez ajouter une date de debut.',
                    'date_fin_periode_exercice.required' => 'Veuillez ajouter une date de fin.',
                ]);

                $data = $request->all();

                $dateanneedebut = $data['date_debut_periode_exercice'];
                $dateanneefin = $data['date_fin_periode_exercice'];
                $dateencours = Carbon::now()->format('Y');

                $date1 = Carbon::parse($dateanneedebut)->format('Y');
                //$date1 = Carbon::createFromFormat('m/d/Y', $dateanneedebut)->format('Y');
                $date2 = Carbon::parse($dateanneefin)->format('Y');
                //$date2 = Carbon::createFromFormat('m/d/Y', $dateanneefin)->format('Y');
                $input = $request->all();
                if($date1 != $dateencours){
                    return redirect()->route('periodeexercice.create')->with('error', 'L\'année de la date de debut de la periode d\'est differente de l\'année en cours !'); 
                }
                if($date2 != $dateencours){
                    return redirect()->route('periodeexercice.create')->with('error', 'L\'année de la date de fin de la periode d\'est differente de l\'année en cours !');                    
                }
                if($date1 == $dateencours and $date2 == $dateencours){
                    $input['annee'] = $date2;
                }

                $verfi = PeriodeExercice::where([['annee','=',$input['annee']]])->get();

                if(count($verfi)>=1){
                    return redirect()->route('periodeexercice.create')->with('error', 'Vous avez une  période d\'excercice en cours; Veuillez effectuer une prolongation. ');
                }
                
                $input['id_user'] = Auth::user()->id;
                $input['flag_actif_periode_exercice'] = true;

                PeriodeExercice::create($input);

                $insertedId = PeriodeExercice::latest()->first()->id_periode_exercice;

                $resultatnonflags = PeriodeExercice::where([['id_periode_exercice','!=',$insertedId]])->get();

                foreach($resultatnonflags as $resultatnonflag){
                    PeriodeExercice::where('id_periode_exercice',$resultatnonflag->id_periode_exercice)->update([
                        'flag_actif_periode_exercice' => false
                    ]);                    
                }

                return redirect()->route('periodeexercice.index')->with('success', 'Periode exercice ajouté avec succès.');
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
        $periodeexercice = PeriodeExercice::find($id);
        return view('periodeexercice.edit', compact('periodeexercice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);

        if ($request->isMethod('put')) {

            $this->validate($request, [
                'date_prolongation_periode_exercice' => 'required',
                'motif_prolongation_periode_exercice' => 'required'
            ],[
                'date_prolongation_periode_exercice.required' => 'Veuillez ajouter une date de prolongation.',
                'motif_prolongation_periode_exercice.required' => 'Veuillez ajouter le motif de prolongation.',
            ]);

            
            $periodeexercice = PeriodeExercice::find($id);
            $periodeexercice->update($request->all());

            return redirect()->route('periodeexercice.index')
                ->with('success', 'Période exercice mis à jour avec succès.');
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
