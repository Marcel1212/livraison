<?php

namespace App\Http\Controllers;


use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Envoisms;
use App\Models\Agence;
use App\Models\Direction;
use App\Models\Departement;
use App\Models\Service;
use App\Models\Activites;
use App\Models\User;
use App\Helpers\Menu;
use App\Models\SecteurActiviteUserConseiller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = User::with('agence:num_agce,lib_agce')
                ->where([['flag_demission_users', '=', false], ['flag_admin_users', '=', false]])
                ->get();
       //dd($data);
        return view('users.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roless = Role::where([['id', '!=', 15]])->get();
        //$roles = Role::where([['id', '!=', 15]])->get()->pluck('name', 'name');
        $roles = "<option value=''> -- Sélectionner --</option>";
        foreach ($roless as $comp) {
            $roles .= "<option  value='" . $comp->name .'/'. $comp->code_fonction ."'   > " . ucfirst($comp->name) . " </option>";
        }
        //dd($roles);
        $Entite = Agence::where([['flag_agce', '=', true]])->get();
        foreach ($Entite as $comp) {
            $Entite .= "<option  value='" . $comp->num_agce . "'   > " . $comp->lib_agce . " </option>";
        }



        $directions = Direction::all();
        /*$direction = "<option value=''> Selectionnez une direction </option>";
        foreach ($directions as $comp) {
            $direction .= "<option value='" . $comp->id_direction  . "'>" . $comp->libelle_direction ." </option>";
        }*/
        return view('users.create', compact('roles', 'Entite','directions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $key = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $idutil = Auth::user()->id;
        /*$this->validate($request, [
            'name' => 'required',
            'login_users' => 'required|login_users|unique:users,login_users',
            'email' => 'email|unique:users,email',
            'cel_users' => 'required'
        ]);*/
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $exploeprofil = explode("/",$request->input('roles'));
        $valprofile = $exploeprofil[0];
        $valcodeprofile = $exploeprofil[1];
       // $user->assignRole($request->input('roles'));
        $user->assignRole($valprofile);

        $profile = Role::where([['name', '=', $valprofile]])->first();
        if(isset($profile)){
            if($profile->code_roles == "CONSEILLER"){
                return redirect()->route('users.edit',\App\Helpers\Crypt::UrlCrypt($user->id))->with('success', 'Succes : Enregistrement reussi');
            }else{
                return redirect()->route('users.index')->with('success', 'Succes : Enregistrement reussi');
            }
        }else{
            return redirect()->route('users.index')->with('success', 'Succes : Enregistrement reussi');
        }

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);

        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->first();
        //$userRole = $user->roles->pluck('name', 'name')->all();
        $Entite = Agence::where([['flag_agce', '=', true]])->get();
        foreach ($Entite as $comp) {
            if ($user->num_agce == $comp->num_agce) {$val = 'selected="selected"'; } else { $val = '';}
            $Entite .= "<option  value='" . $comp->num_agce . "' $val  > " . $comp->lib_agce . " </option>";
        }

        $Roless = Role::get();

        //dd($userRole);
        foreach ($Roless as $comp) {
            if ($userRole == $comp->name) {$val = 'selected="selected"'; } else { $val = '';}
            $Roless .= "<option  value='" . $comp->name .'/'. $comp->code_fonction ."' $val  > " . $comp->name . " </option>";
        }

        $SecteursActivites = Activites::all();
        $SecteursActivite = "<option value=''> Selectionnez le secteur d'activite </option>";
        foreach ($SecteursActivites as $comp) {
            $SecteursActivite .= "<option value='" . $comp->id_activites  . "'>" . mb_strtoupper($comp->libelle_activites) ." </option>";
        }

        $nacodes = 0;//Menu::get_code_menu_profil($id);

        $secteurlierusers = SecteurActiviteUserConseiller::where([['id_user_conseiller', '=', $id]])->get();

        $directions = Direction::all();
        return view('users.edit', compact('user', 'roles', 'userRole', 'Entite','Roless','directions','SecteursActivite','secteurlierusers','nacodes'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*$validatedData = $request->validate([
            'name' => 'required',
            'email' => 'email|unique:users,email,' . $id,
            'login_users' => 'required|login_users|unique:users,login_users,' . $id,
            'roles' => 'required'
        ]);*/
        $id =  \App\Helpers\Crypt::UrldeCrypt($id);


        if ($request->isMethod('put')) {
            $data = $request->all();

            if ($data['action'] == 'Modifier'){

                $validatedData = $request->validate([
                    'name' => 'required',
                    'roles' => 'required'
                ]);

                $user = User::find($id);
                $input = $request->all();
                if (!empty($input['password'])) {
                    $input['password'] = Hash::make($input['password']);
                } else {
                    $input = Arr::except($input, ['password']);
                }
                $user->update($input);
                DB::table('model_has_roles')->where('model_id', $id)->delete();
                $exploeprofil = explode("/",$request->input('roles'));
                //dd($exploeprofil);
                $valprofile = $exploeprofil[0];
                $valcodeprofile = $exploeprofil[1];
                //$user->assignRole($request->input('roles'));
                $user->assignRole($valprofile);
                return redirect()->route('users.index')->with('success', 'Succes : Enregistrement reussi');

            }

            if ($data['action'] == 'Lier_secteur_Conseiller'){
                $this->validate($request, [
                    'id_secteur_activite' => 'required',
                ],[
                    'id_secteur_activite.required' => 'Veuillez selectionnez le secteur d\'activité.',
                ]);

                $input = $request->all();

                $input['id_user_conseiller'] = $id;

                $countst =  $secteurlierusers = SecteurActiviteUserConseiller::where([['id_user_conseiller', '=', $id],['id_secteur_activite', '=', $input['id_secteur_activite']]])->get();
                if(count($countst)==0){
                    SecteurActiviteUserConseiller::create($input);

                    return redirect()->route('users.edit',\App\Helpers\Crypt::UrlCrypt($id))->with('success', 'Succes : Operation reussi. ');
                }else{
                    return redirect()->route('users.edit',\App\Helpers\Crypt::UrlCrypt($id))->with('error', 'Erreur : Seteur deja attribuer. ');
                }

            }

        }


    }

    public function delete($id){

        $id =  \App\Helpers\Crypt::UrldeCrypt($id);

        $SecteurActiviteUserConseiller = SecteurActiviteUserConseiller::find($id);
        $iduserconseiller = $SecteurActiviteUserConseiller->id_user_conseiller;
        SecteurActiviteUserConseiller::where([['id_secteur_user_consseiller','=',$id]])->delete();

        return redirect()->route('users.edit',\App\Helpers\Crypt::UrlCrypt($iduserconseiller))->with('success', 'Succes : Operation reussi. ');
    }


}
