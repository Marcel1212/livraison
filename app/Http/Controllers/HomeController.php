<?php

namespace App\Http\Controllers;

use App\Helpers\Menu;
use App\Models\User;
use App\Models\Entreprises;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Helpers\InfosEntreprise;
use App\Models\Activites;
use App\Models\ActivitesEntreprises;
use App\Models\Pays;
use App\Helpers\Crypt;

//use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //   dd($tabl);
        return view('home');
    }


    public function deconnexion()
    {

        Auth::logout();
        return redirect('/connexion')->with('success', 'Deconnexion reussie');

    }

    public function reclamation(Request $request)
    {

        $idutil = Auth::user()->id;
        // dd($idutil);

        if ($request->isMethod('post')) {

            $data = $request->all();
        }
    }

    public function profil(Request $request)
    {

        $idutil = Auth::user()->id;
        $naroles = Menu::get_menu_profil($idutil);
        // dd($idutil);

        if ($request->isMethod('post')) {

            $data = $request->all();

            // dd($data);die();


            if (isset($request->profile_avatar)) {
                $fileName = 'photoprofile' . '_' . time() . '.' . $request->profile_avatar->extension();
                $request->profile_avatar->move(public_path('photoprofile'), $fileName);

                User::where([['id', '=', $idutil]])->update(['name' => $data['name'], 'cel_users' => $data['cel_users'], 'prenom_users' => $data['prenom_users'], 'photo_profil' => $fileName]);

                return redirect('/profil')->with('success', 'Succes : Enregistrement reussi');
            } else {
                User::where([['id', '=', $idutil]])->update(['name' => $data['name'], 'cel_users' => $data['cel_users'], 'prenom_users' => $data['prenom_users']]);

                return redirect('/profil')->with('success', 'Succes : Enregistrement reussi');
            }


        }


        $users = DB::table('users')->where([['id', '=', $idutil]])->first();

        // dd($users);

        return view('profil.profil')->with(compact('naroles'));
    }

    public function updatepassword(Request $request)
    {

        $idutil = Auth::user()->id;

        $key = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';


        if ($request->isMethod('post')) {

            $data = $request->input();

            $users = DB::table('users')->where([['id', '=', $idutil]])->first();


             //dd($data);

            if($users->flag_mdp != true){

                if ($data['action'] == 'profil_entreprise_activite'){

                    //dd($request->all());
                    $this->validate($request, [
                        'id_activites' => 'required'
                    ],[
                        'id_activites.required' => 'Veuillez ajouter votre localisation.',
                    ]);

                    $input = $request->all();

                    $input['id_entreprises'] = Auth::user()->id_partenaire;

                    $verfactivite = ActivitesEntreprises::where([['id_entreprises','=',$input['id_entreprises']],['id_activites','=',$input['id_activites']]])->get();

                    if(count($verfactivite)>0){
                        return redirect('/modifiermotdepasse')->with('error', 'Cette Activité existe déjà');
                    }else{
                        ActivitesEntreprises::create($input);
                        return redirect('/modifiermotdepasse')->with('success', 'Activité ajoutée avec succès');
                    }
                }

                if ($data['action'] == 'profil_entreprise'){

                    $this->validate($request, [
                        'localisation_geographique_entreprise' => 'required',
                        'repere_acces_entreprises' => 'required',
                        'adresse_postal_entreprises' => 'required',
                        'cellulaire_professionnel_entreprises' => 'required',
                        'cpwd' => 'required',
                        'npwd' => 'required',
                        'vpwd' => 'required',
                        'tel_entreprises' => 'required'
                    ],[
                        'localisation_geographique_entreprise.required' => 'Veuillez ajouter votre localisation.',
                        'repere_acces_entreprises.required' => 'Veuillez ajouter un repere d\'accès.',
                        'adresse_postal_entreprises.required' => 'Veuillez ajouter une adresse postale.',
                        'cellulaire_professionnel_entreprises.required' => 'Veuillez ajouter un contact cellulaire.',
                        'tel_entreprises.required' => 'Veuillez ajouter un contact telephonique.',
                        'cpwd.required' => 'Veuillez ajouter l\' ancien mot de passe.',
                        'npwd.required' => 'Veuillez ajouter le nouveau mot de passe.',
                        'vpwd.required' => 'Veuillez ressaisir le nouveau mot de passe.',
                    ]);

                    if (Hash::check($data['cpwd'], $users->password)) {

                        $motpass = $key . '+' . $data['npwd'];
                        $pass = Hash::make($data['npwd']);

                        User::where(['id' => $users->id])->update(['password' => $pass, 'flag_mdp' => 1]);
                        $input = $request->all();
                        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
                        $input['localisation_geographique_entreprise'] = mb_strtoupper($input['localisation_geographique_entreprise']);
                        $input['repere_acces_entreprises'] = mb_strtoupper($input['repere_acces_entreprises']);
                        $input['adresse_postal_entreprises'] = mb_strtoupper($input['adresse_postal_entreprises']);
                        $entreprise = Entreprises::find($infoentreprise->id_entreprises);
                        $entreprise->update($input);
                        return redirect('/dashboard')
                            ->with('success', 'Votre mot de passe et information de l\'entreprise a été  modifié avec succes');

                    } else {
                        return redirect('/modifiermotdepasse')
                            ->with('errors', 'Veuillez renseigner l\'ancien mot de passe ');
                    }

                }

                if ($data['action'] == 'autre_profil'){

                    $this->validate($request, [
                        'cpwd' => 'required',
                        'npwd' => 'required',
                        'vpwd' => 'required'
                    ],[
                        'cpwd.required' => 'Veuillez ajouter l\' ancien mot de passe.',
                        'npwd.required' => 'Veuillez ajouter le nouveau mot de passe.',
                        'vpwd.required' => 'Veuillez ressaisir le nouveau mot de passe.',
                    ]);

                    if (Hash::check($data['cpwd'], $users->password)) {

                        $motpass = $key . '+' . $data['npwd'];
                        $pass = Hash::make($data['npwd']);

                        User::where(['id' => $users->id])->update(['password' => $pass, 'flag_mdp' => 1]);

                        return redirect('/dashboard')
                            ->with('success', 'Votre mot de passe a été  modifié avec succes');

                    } else {
                        return redirect('/modifiermotdepasse')
                            ->with('errors', 'Veuillez renseigner l\'ancien mot de passe ');
                    }
                }

            }else{
                /*if (Hash::check($data['cpwd'], $users->password)) {

                    $motpass = $key . '+' . $data['npwd'];
                    $pass = Hash::make($data['npwd']);

                    User::where(['id' => $users->id])->update(['password' => $pass, 'flag_mdp' => 1]);

                    return redirect('/dashboard')
                        ->with('success', 'Votre mot de passe a été  modifié avec succes');

                } else {
                    return redirect('/modifiermotdepasse')
                        ->with('errors', 'Veuillez renseigner l\'ancien mot de passe ');
                }*/

                if ($data['action'] == 'profil_entreprise_activite'){

                   // dd($request->all());
                    $this->validate($request, [
                        'id_activites' => 'required'
                    ],[
                        'id_activites.required' => 'Veuillez ajouter votre localisation.',
                    ]);

                    $input = $request->all();

                    $input['id_entreprises'] = Auth::user()->id_partenaire;

                    $verfactivite = ActivitesEntreprises::where([['id_entreprises','=',$input['id_entreprises']],['id_activites','=',$input['id_activites']]])->get();

                    if(count($verfactivite)>0){
                        return redirect('/modifiermotdepasse')->with('error', 'Cette Activité existe déjà');
                    }else{
                        ActivitesEntreprises::create($input);
                        return redirect('/modifiermotdepasse')->with('success', 'Activité ajoutée avec succès');
                    }

                }

                if ($data['action'] == 'profil_entreprise'){

                    $this->validate($request, [
                        'localisation_geographique_entreprise' => 'required',
                        'repere_acces_entreprises' => 'required',
                        'adresse_postal_entreprises' => 'required',
                        'cellulaire_professionnel_entreprises' => 'required',
                        'cpwd' => 'required',
                        'npwd' => 'required',
                        'vpwd' => 'required',
                        'tel_entreprises' => 'required'
                    ],[
                        'localisation_geographique_entreprise.required' => 'Veuillez ajouter votre localisation.',
                        'repere_acces_entreprises.required' => 'Veuillez ajouter un repere d\'accès.',
                        'adresse_postal_entreprises.required' => 'Veuillez ajouter une adresse postale.',
                        'cellulaire_professionnel_entreprises.required' => 'Veuillez ajouter un contact cellulaire.',
                        'tel_entreprises.required' => 'Veuillez ajouter un contact telephonique.',
                        'cpwd.required' => 'Veuillez ajouter l\' ancien mot de passe.',
                        'npwd.required' => 'Veuillez ajouter le nouveau mot de passe.',
                        'vpwd.required' => 'Veuillez ressaisir le nouveau mot de passe.',
                    ]);

                    if (Hash::check($data['cpwd'], $users->password)) {

                        $motpass = $key . '+' . $data['npwd'];
                        $pass = Hash::make($data['npwd']);

                        User::where(['id' => $users->id])->update(['password' => $pass, 'flag_mdp' => 1]);
                        $input = $request->all();
                        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
                        $input['localisation_geographique_entreprise'] = mb_strtoupper($input['localisation_geographique_entreprise']);
                        $input['repere_acces_entreprises'] = mb_strtoupper($input['repere_acces_entreprises']);
                        $input['adresse_postal_entreprises'] = mb_strtoupper($input['adresse_postal_entreprises']);
                        $entreprise = Entreprises::find($infoentreprise->id_entreprises);
                        $entreprise->update($input);
                        return redirect('/dashboard')
                            ->with('success', 'Votre mot de passe et information de l\'entreprise a été  modifié avec succes');

                    } else {
                        return redirect('/modifiermotdepasse')
                            ->with('errors', 'Veuillez renseigner l\'ancien mot de passe ');
                    }

                }

                if ($data['action'] == 'autre_profil'){

                    $this->validate($request, [
                        'cpwd' => 'required',
                        'npwd' => 'required',
                        'vpwd' => 'required'
                    ],[
                        'cpwd.required' => 'Veuillez ajouter l\' ancien mot de passe.',
                        'npwd.required' => 'Veuillez ajouter le nouveau mot de passe.',
                        'vpwd.required' => 'Veuillez ressaisir le nouveau mot de passe.',
                    ]);

                    if (Hash::check($data['cpwd'], $users->password)) {

                        $motpass = $key . '+' . $data['npwd'];
                        $pass = Hash::make($data['npwd']);

                        User::where(['id' => $users->id])->update(['password' => $pass, 'flag_mdp' => 1]);

                        return redirect('/dashboard')
                            ->with('success', 'Votre mot de passe a été  modifié avec succes');

                    } else {
                        return redirect('/modifiermotdepasse')
                            ->with('errors', 'Veuillez renseigner l\'ancien mot de passe ');
                    }
                }

            }


        }


        $idutil = Auth::user()->id;
        // dd($idutil);

        $roles = DB::table('users')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where([['users.id', '=', $idutil]])
            ->first();
        $idroles = $roles->role_id;
        //dd($idroles);

        $naroles = $roles->name;

        $resulat = DB::table('role_has_sousmenus')
            ->join('sousmenu', 'role_has_sousmenus.sousmenus_id_sousmenu', 'sousmenu.id_sousmenu')
            ->join('roles', 'role_has_sousmenus.role_id', 'roles.id')
            ->join('menu', 'sousmenu.menu_id_menu', 'menu.id_menu')
            ->where([['roles.id', '=', $idroles]])
            ->get();
        //  DB::table('menu')->join('sousmenu','menu.id_menu','sousmenu.menu_id_menu')->get();

        //  dd($resulat);

        $tabl = [];

        foreach ($resulat as $ligne) {

            $tabl[$ligne->id_menu][] = $ligne;
        }


        $users = DB::table('users')->where([['id', '=', $idutil]])->first();

        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
        //dd($infoentreprise);
        $pays = Pays::all();
        $pay = "<option value='".@$infoentreprise->pay->id_pays."'> " . @$infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        $activites = Activites::where([['id_secteur_activite','=',$infoentreprise->id_secteur_activite_entreprise],['flag_activites','=',true]])->get();
        $activite = "<option value=''> -- Sélectionnez une activité -- </option>";
        foreach ($activites as $comp) {
            $activite .= "<option value='" . $comp->id_activites  . "'>" . $comp->libelle_activites ." </option>";
        }

        $listeactivites = ActivitesEntreprises::where([['id_entreprises','=',$infoentreprise->id_entreprises],['flag_activites_entreprises','=',true]])->get();
        return view('profil.updatepassword')->with(compact('tabl', 'naroles','infoentreprise','pay','activite','listeactivites'));

    }

    public function deleteactiviteentreprise($id){
        $idVal = Crypt::UrldeCrypt($id);

        ActivitesEntreprises::where([['id_activites_entreprises','=',$idVal]])->delete();

        return redirect('/modifiermotdepasse')->with('success', 'Activité supprimée avec succès');
    }
}
