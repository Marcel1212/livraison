<?php

namespace App\Http\Controllers\PlanFormation;

use App\Models\Entreprises;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GenerateCode as Gencode;
use Illuminate\Http\JsonResponse;

class AjaxController extends Controller
{
    public function ajoutcabinetetrangere(Request $request): JsonResponse
    {

            $request->validate([
                    'raison_social_entreprises' => 'required',
                    'email_entreprises' => 'required|email',
                    'indicatif_entreprises' => 'required',
                    'tel_entreprises' => 'required'
                ], [
                    'raison_social_entreprises.required' => 'Veuillez ajouter votre raison sociale.',
                    'email_entreprises.required' => 'Veuillez ajouter un email.',
                    'indicatif_entreprises.required' => 'Veuillez ajouter un indicatif.',
                    'tel_entreprises.required' => 'Veuillez ajouter un contact.',
                ]);

            $input = $request->all();

            $input['flag_cabinet_etranger'] = true;
            $numfdfp = 'fdfp_CE' . Gencode::randStrGen(4, 5);
            $numfdfp1 = 'fdfpCE' . Gencode::randStrGen(4, 4);
            $input['numero_fdfp_entreprises'] = $numfdfp;
            $input['ncc_entreprises'] = $numfdfp1;

            $data = Entreprises::create($input);

            //$data = Entreprises::latest()->first();

            return response()->json(['success' => 'Cabinet étranger ajouté avec succès','data'=>$data]);
    }
}
