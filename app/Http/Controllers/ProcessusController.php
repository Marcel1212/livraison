<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\GenerateCode as Gencode;
use App\Models\CombinaisonProcessus;
use App\Models\ContenirAgence;
use App\Models\Demande;
use App\Models\LigneDemande;
use App\Models\Patient;
use App\Models\Facture;
use App\Models\LigneFactureActe;
use App\Models\LigneFactMedicament;
use App\Models\Processus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProcessusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Resultat = DB::table('processus')->get();
        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'LISTE DES PROCESSUS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('processus.index', compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $ResPatient = null;
        $ResPro = null;
        $ResRole = DB::table('roles')
            ->where('code_roles', '!=', 'ADMIN')
            ->where('code_roles', '!=', 'ENTREPRISE')
            ->orderBy('name', 'ASC')->get();

        if ($request->isMethod('post')) {
            /********************** Creation du processus ********************/
            if ($request->input('BtnEnregistrer') == "BtnEnregistrer") {
                $request->validate([
                    'lib_processus' => 'required',
                ]);
                $processus = Processus::create([
                    'lib_processus' => $request->input(['lib_processus']),
                    'is_valide' => $request->has('is_valide')
                ]);
                $insertedId = \App\Helpers\Crypt::UrlCrypt(Processus::latest()->first()->id_processus);

                foreach ($request->IdRole as $key => $value) {
                    if (isset($request->is_valide_agce_role[$key])) {
                        $isV1 = $request->is_valide_agce_role[$key];
                    } else {
                        $isV1 = false;
                    }
                    CombinaisonProcessus::create([
                        'id_processus' => \App\Helpers\Crypt::UrldeCrypt($insertedId),
                       // 'id_cont_agce' => $insertedIdCa,
                        'id_roles' => $value,
                        'priorite_combi_proc' => $request->priorite[$key],
                        'is_valide' => $isV1
                    ]);
                }
            }

            Audit::logSave([

                'action'=>'CREER',

                'code_piece'=>$insertedId,

                'menu'=>'LISTE DES PROCESSUS',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect('processus/edit/' . $insertedId)->with('success', 'Succes : Enregistrement reussi');
        }
        Audit::logSave([

            'action'=>'CREER',

            'code_piece'=>'',

            'menu'=>'LISTE DES PROCESSUS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('processus.create', compact('ResPatient', 'ResPro',  'ResRole'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = null, $id2 = null)
    {
        $idVal = Crypt::UrldeCrypt($id);
        $ResPatient = null;
        $ResPro = null;
        if ($idVal != null) {
            $ResPro = DB::table('processus')
                ->where('id_processus', '=', $idVal)
                ->first();
        }

        if ($request->isMethod('post')) {

            /********************** Creation du processus ********************/
            $IdProc = $request->input(['IdProc']);
            if ($request->input('BtnEnregistrer') == "BtnEnregistrer") {
                $request->validate([
                    'lib_processus' => 'required',
                ]);
              //  dd($request);
                Processus::where('id_processus', '=', $IdProc)->update([
                    'lib_processus' => strtoupper($request->input(['lib_processus'])),
                    'is_valide' => $request->has('is_valide')
                ]);

                foreach ($request->IdRole as $key => $value) {
                    if (isset($request->is_valide_agce_role[$key])) {
                        $isV1 = $request->is_valide_agce_role[$key];
                    } else {
                        $isV1 = false;
                    }
                    CombinaisonProcessus::where('id_combi_proc', '=', $value)->update([
                        'priorite_combi_proc' => $request->priorite[$key],
                        'is_valide' => $isV1
                    ]);
                }
            }
            Audit::logSave([

                'action'=>'MODIFIER',

                'code_piece'=>$id,

                'menu'=>'LISTE DES PROCESSUS',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect('processus/edit/' . \App\Helpers\Crypt::UrlCrypt($IdProc))->with('success', 'Succes : Enregistrement reussi');
        }
        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'LISTE DES PROCESSUS',

            'etat'=>'Succès',

            'objet'=>'ADMINISTRATION'

        ]);
        return view('processus.edit', compact('ResPatient', 'ResPro'));
    }

}
