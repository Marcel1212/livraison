<?php

namespace App\Http\Controllers;

use App\Helpers\Menu;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

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


            // dd($data);

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


        return view('profil.updatepassword')->with(compact('tabl', 'naroles'));

    }
}
