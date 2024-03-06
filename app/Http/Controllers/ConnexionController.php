<?php

namespace App\Http\Controllers;
use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Envoisms;
use App\Helpers\Menu;
use App\Helpers\Notification;
use App\Models\User;
use Auth;
use App\Rules\Recaptcha;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;


class ConnexionController extends Controller
{

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function login(Request $request)
    {

        $logo = Menu::get_logo();
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',

//                'g-recaptcha-response' => ['required', new ReCaptcha]

            ], [
                'username.required' => 'Veuillez saisir votreidentifiant.',
                'password.required' => 'Veuillez saisir le mot de passe.',
//                'g-recaptcha-response.required' => 'Veuillez saisir le captcha.',
            ]);

            $data = $request->input();
            if (Auth::attempt(['login_users' => $data['username'], 'password' => $data['password']])) {
                // echo "succes";die;
                $dbinfo = DB::table('users')->where([['login_users', '=', $data['username']]])->first();
                $flag = $dbinfo->flag_mdp;
                if ($flag == true) {
                    Session::put('userSession', $data['username']);

                    Audit::logSave([

                        'action'=>'CONNEXION',

                        'menu'=>'CONNEXION',

                        'etat'=>'Succès',

                    ]);

                } else {
                    Audit::logSave([

                        'action'=>'CONNEXION',

                        'menu'=>'CONNEXION',

                        'etat'=>'Succès',

                    ]);
                    return redirect('/modifiermotdepasse')->with('success', 'Info:  Veuillez modifier votre mot de passe à la première connexion');

                }
                Audit::logSave([

                    'action'=>'CONNEXION',

                    'menu'=>'CONNEXION',

                    'etat'=>'Succès',

                ]);
                return redirect('/dashboard')->with('success', 'Bonjour ' . Auth::user()->name . ' ' . Auth::user()->prenom_users . ',  Bienvenue sur le portail de '. @$logo->mot_cle);
            } else {
                Audit::logSave([

                    'action'=>'CONNEXION',

                    'menu'=>'CONNEXION',

                    'etat'=>'Echec',

                ]);
                return redirect('/connexion')->with('error', 'Identifiant ou mot de passe  incorrect');
            }
        }
        return view('connexion.login');
    }

    public function dashboard()
    {
        if (!Session::has('userSession')) {
            return redirect('/connexion')->with('error', 'Veuillez vous identifié');
        }
        $idutil = Auth::user()->id;
        $idutilClient = Auth::user()->id_partenaire;
        $naroles = Menu::get_menu_profil($idutil);
        $nacodes = Menu::get_code_menu_profil($idutil);
        $date = date('d/m/Y'); // var_dump($date); exit();
        /******************AFFICHIER LES GRAPHES****************************/
        $dataUser = DB::table('users as v')->select(DB::raw("count(v.id) as nb_user"))->first();

        return view('dashboard.dashboard')->with(
            compact('naroles', 'idutilClient', 'nacodes', 'dataUser')
        );
    }
}
