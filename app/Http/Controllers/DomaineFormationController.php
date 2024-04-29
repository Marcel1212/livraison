<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Models\DomaineFormation;
use Illuminate\Http\Request;
use App\Helpers\Crypt;
use App\Models\DomaineFormationCabinet;
use App\Models\Entreprises;

class DomaineFormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domaines = DomaineFormation::all();

        return view('domaineformation.index', compact('domaines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('domaineformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'libelle_domaine_formation' => 'required',
                'code_domaine_formation' => 'required',
            ],[
                'libelle_domaine_formation.required' => 'Veuillez ajouter un libelle',
                'code_domaine_formation.required' => 'Veuillez ajouté le code',
            ]);
            $input = $request->all();
            $input['libelle_domaine_formation'] = mb_strtoupper($input['libelle_domaine_formation']);

            $domainef = DomaineFormation::create($input);

            Audit::logSave([

                'action'=>'ENREGISTRER',

                'code_piece'=>$domainef->id_domaine_formation,

                'menu'=>'LISTE DES DOMAINES DE FORMATIONS',

                'etat'=>'Succès',

                'objet'=>'ADMINISTRATION'

            ]);
            return redirect('domaineformation/'.Crypt::UrlCrypt($domainef->id_domaine_formation).'/edit')->with('success', 'Succes : Enregistrement reussi ');

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
        $id =  Crypt::UrldeCrypt($id);

        $domaine = DomaineFormation::find($id);

        $domaineformationentreprises = DomaineFormationCabinet::where([['id_domaine_formation','=',$id]])->get();

        //$cabinets = Entreprises::where([['flag_habilitation_entreprise','=',true]])->get();

        $cabinets = Entreprises::select('*')->whereNotExists(function ($query) use ($id){
                            $query->select('*')
                                ->from('domaine_formation_cabinet')
                                ->whereColumn('domaine_formation_cabinet.id_entreprises','=','entreprises.id_entreprises')
                                ->where('domaine_formation_cabinet.id_domaine_formation','=',$id);
                        })->where([['flag_habilitation_entreprise', '=', true]
                    ])->get();

        /* User::select('users.id as id','users.name as name','users.prenom_users as prenom_users', 'roles.name as profile')
                ->whereNotExists(function ($query) use ($id){
                    $query->select('*')
                        ->from('comite_participant')
                        ->whereColumn('comite_participant.id_user_comite_participant','=','users.id')
                        ->where('comite_participant.id_comite','=',$id);
                })->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', 'roles.id')
                ->where([['flag_demission_users', '=', false],
                    ['flag_admin_users', '=', false],
                    ['roles.id', '!=', 15],
                ])->get(); */

        return view('domaineformation.edit', compact('domaine','domaineformationentreprises','cabinets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if ($data['action'] == 'Modifier'){
                $request->validate([
                    'libelle_domaine_formation' => 'required',
                    'code_domaine_formation' => 'required',
                ],[
                    'libelle_domaine_formation.required' => 'Veuillez ajouter un libelle',
                    'code_domaine_formation.required' => 'Veuillez ajouté le code',
                ]);
                $input = $request->all();
                $input['libelle_domaine_formation'] = mb_strtoupper($input['libelle_domaine_formation']);

                $domaineform = DomaineFormation::find($id);

                $domaineform->update($input);

                return redirect('domaineformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Mise a jour reussi ');

            }

            if ($data['action'] == 'AjouterCabinet'){

                $request->validate([
                    'id_entreprises' => 'required',
                ],[
                    'id_entreprises.required' => 'Veuillez selectionner un cabinet',
                ]);

                $input = $request->all();

               // dd($id);

                $input['id_domaine_formation'] = $id;
                $input['flag_domaine_formation_cabinet'] = true;

                $domaineformationcabinet = DomaineFormationCabinet::create($input);

                return redirect('domaineformation/'.Crypt::UrlCrypt($id).'/edit')->with('success', 'Succes : Ajout de cabinet reussi ');

            }

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
