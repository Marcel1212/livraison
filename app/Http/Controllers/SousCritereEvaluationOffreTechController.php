<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Models\CritereEvaluationOffreTech;
use App\Models\souscritereevaluationoffretech;
use Illuminate\Http\Request;
use Psy\Util\Json;

class SousCritereEvaluationOffreTechController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $souscritereevaluationoffretechs = SousCritereEvaluationOffreTech::all();
        Audit::logSave([
            'action'=>'INDEX',
            'code_piece'=>'',
            'menu'=>'LISTE DES SOUS CRITERES EVALUATION OFFRE TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'
        ]);
        return view('souscritereevaluationoffretech.index', compact('souscritereevaluationoffretechs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $critereevaluationoffretechs = CritereEvaluationOffreTech::where('flag_critere_evaluation_offre_tech',true)->get();
        Audit::logSave([
            'action'=>'CREER',
            'code_piece'=>'',
            'menu'=>'LISTE DES SOUS CRITERES D\'EVALUATION DES OFFRES TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'
        ]);
        return view('souscritereevaluationoffretech.create',compact('critereevaluationoffretechs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $souscritereevaluationoffretech = SousCritereEvaluationOffreTech::create($request->all());

        Audit::logSave([
            'action'=>'CREER',
            'code_piece'=>$souscritereevaluationoffretech->id_souscritereevaluationoffretech,
            'menu'=>'LISTE DES SOUS CRITERE D\'EVALUATION DES OFFRES TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'
        ]);
        return redirect()->route('souscritereevaluationoffretech.index')
            ->with('success', 'Sous Critère d\'évaluation des offres techniques ajouté avec succès.');
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
        $souscritereevaluationoffretech = SousCritereEvaluationOffreTech::find($id);
        $critereevaluationoffretechs = CritereEvaluationOffreTech::where('flag_critere_evaluation_offre_tech',true)->get();
        Audit::logSave([
            'action'=>'MODIFIER',
            'code_piece'=>$id,
            'menu'=>'LISTE DES SOUS CRITERE D\'EVALUATION DES OFFRES TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'
        ]);
        return view('souscritereevaluationoffretech.edit', compact('souscritereevaluationoffretech',
        'critereevaluationoffretechs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);
        $input = $request->all();

        if(!isset($input['flag_sous_critere_evaluation_offre_tech'])){
            $input['flag_sous_critere_evaluation_offre_tech'] = false;
        }
        $souscritereevaluationoffretech = SousCritereEvaluationOffreTech::find($id);
        $souscritereevaluationoffretech->update($input);
        Audit::logSave([
            'action'=>'MISE A JOUR',
            'code_piece'=>$id,
            'menu'=>'LISTE DES SOUS CRITERE D\'EVALUATION DES OFFRES TECHNIQUE',
            'etat'=>'Succès',
            'objet'=>'ADMINISTRATION'

        ]);
        return redirect()->route('souscritereevaluationoffretech.index')
            ->with('success', 'Sous-critère d\'évaluation des offres techniques mis à jour avec succès.');
    }

    public function jsonSousCritereCritere(string $id)
    {
        if(isset($id)){
            $critere_evaluation_offre_tech = CritereEvaluationOffreTech::find($id);
            if(isset($critere_evaluation_offre_tech)){
                $souscriteres = $critere_evaluation_offre_tech->souscritereevaluationoffretechs;
                $data= [];
                foreach ($souscriteres as $souscritere) {
                    $data[] = array("id"=>$souscritere->id_sous_critere_evaluation_offre_tech,"text"=>$souscritere->libelle_sous_critere_evaluation_offre_tech);  ;
                }
                return response()->json($data);
            }
            return null;
        }else{
            return null;
        }

    }



}
