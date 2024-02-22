<?php

namespace App\Http\Controllers;


use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Envoisms;
use App\Models\Agence;
use App\Models\Direction;
use App\Models\Departement;
use App\Models\SecteurActivite;
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
use App\Helpers\GenerateCode as Gencode;
use Illuminate\Support\Facades\Validator;
ini_set('max_execution_time', '0');

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
     */
    public function store(Request $request)
    {

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'name' => 'required',
                'login_users' => 'required|unique:users,login_users|min:6',
                'email' => 'required|unique:users,email',
                'roles' => 'required',
                'prenom_users' => 'required',
                'password' => 'required|min:6',
                'num_agce' => 'required'
            ], [
                'name.required' => 'Veuillez ajouter un nom.',
                'login_users.required' => 'Veuillez ajouter un identifiant.',
                'login_users.min' => 'Un identifiant doit avoir un minimum 6 caractères.',
                'login_users.unique' => 'Un identifiant doit être unique, celui-ci existe déjà dans le système.',
                'email.required' => 'Veuillez ajouter un mail.',
                'email.unique' => 'Email doit être unique.',
                'roles.required' => 'Veuillez selectionner un profil.',
                'prenom_users.required' => 'Veuillez ajouter un prénom.',
                'password.required' => 'Veuillez ajouter un mot de passe.',
                'password.min' => 'Le mot de passe doit avoir au moins 6 caractère.',
                'num_agce.required' => 'Veuillez ajouter une antenne.'
            ]);

            $input = $request->all();
            $passwordCli = $input['password'];
            $emailcli = $input['email'];
            $loginusers = $input['login_users'];
            $name = $input['name'] .' '. $input['prenom_users'];
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $exploeprofil = explode("/",$request->input('roles'));
            $valprofile = $exploeprofil[0];
            $valcodeprofile = $exploeprofil[1];
             // $user->assignRole($request->input('roles'));
            $user->assignRole($valprofile);

            $profile = Role::where([['name', '=', $valprofile]])->first();

            $logo = Menu::get_logo();

            if (isset($emailcli)) {
                $sujet = "Activation de compte FDFP";
                $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                $messageMail = "<b>Cher $name ,</b>
                                    <br><br>Nous sommes ravis de vous accueillir sur notre plateforme ! <br> Votre compte a été créé avec
                                        succès, et il est maintenant prêt à être utilisé.
                                    <br><br>
                                    <br><br>Voici un récapitulatif de vos informations de compte :
                                    <br><b>Nom d'utilisateur : </b> $name
                                    <br><b>Adresse e-mail : </b> $emailcli
                                    <br><b>Identifiant : </b> $loginusers
                                    <br><b>Mot de passe : </b> $passwordCli
                                    <br><b>Date de création du compte : : </b> $user->created_at
                                    <br><br>
                                    <br><br>Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :
                                            http://fdfp.ldfgroupe.com/
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";


                $messageMailEnvoi = Email::get_envoimailTemplate($emailcli, $name, $messageMail, $sujet, $titre);
            }

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

        $SecteursActivites = SecteurActivite::where([['flag_actif_secteur_activite', '=', true]])->get();
        $SecteursActivite = "<option value=''> -- Sélectionnez un secteur d'activité -- </option>";
        foreach ($SecteursActivites as $comp) {
            $SecteursActivite .= "<option value='" . $comp->id_secteur_activite  . "'>" . mb_strtoupper($comp->libelle_secteur_activite) ." </option>";
        }

        $nacodes = Menu::get_code_menu_profil($id);
        $secteurlierusers = SecteurActiviteUserConseiller::where([['id_user_conseiller', '=', $id]])->get();
        $directions = Direction::where([['flag_direction', '=', true]])->get();
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

                /*$this->validate($request, [
                    'name' => 'required',
                    'login_users' => 'required|unique:users,login_users|min:6',
                    'email' => 'required|unique:users,email',
                    'roles' => 'required',
                    'prenom_users' => 'required',
                    'password' => 'required|min:6',
                    'num_agce' => 'required'
                ], [
                    'name.required' => 'Veuillez ajouter un nom.',
                    'login_users.required' => 'Veuillez ajouter un identifiant.',
                    'login_users.min' => 'Un identifiant doit avoir un minimum 6 caractères.',
                    'login_users.unique' => 'Un identifiant doit être unique, celui-ci existe déjà dans le système.',
                    'email.required' => 'Veuillez ajouter un mail.',
                    'email.unique' => 'Email doit être unique.',
                    'roles.required' => 'Veuillez selectionner un profil.',
                    'prenom_users.required' => 'Veuillez ajouter un prénom.',
                    'password.required' => 'Veuillez ajouter un mot de passe.',
                    'password.min' => 'Le mot de passe doit avoir au moins 6 caractère.',
                    'num_agce.required' => 'Veuillez ajouter une antenne.'
                ]);*/

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
