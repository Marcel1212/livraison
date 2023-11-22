<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Crypt;
use Hash;
use Auth;
use Session;

class ParametreController extends Controller
{

    /*public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:role-index');

    }*/
    public function parametresysteme()
    {

        $logos = DB::table('logo')->get();

        return view('logos.index', compact('logos'));
    }

    public function creerparametresysteme(Request $request)
    {

        $idutil = Auth::user()->id;

        if ($request->isMethod('post')) {

            $data = $request->all();

            //dd($data);die();

            $logo = new Logo;

            /*$nombre =DB::table('logo')->where([['flag_logo','=',1]])->get();

            $nbre = count($nombre);*/

            if ($data['valeur'] == 'LOGO') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'LOGO']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'EMAIL') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'EMAIL']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'CONTACT') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'CONTACT']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'RESEAUX SOCIAUX') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'RESEAUX SOCIAUX']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'ESPACE CLIENT') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'ESPACE CLIENT']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }


            if ($data['valeur'] == 'OUVRIR COMPTE') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'OUVRIR COMPTE']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'IMAGE ACCEUIL') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'IMAGE ACCEUIL']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'IMAGE DASHBORD') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'IMAGE DASHBORD']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'SITEVITRINE') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'SITEVITRINE']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'COULEUR MENU HAUT') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'COULEUR MENU HAUT']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            if ($data['valeur'] == 'NEWSLETTER') {
                $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'NEWSLETTER']])->get();

                $nbre1 = count($nombre1);

                if ($nbre1 == 1) {
                    $logo->flag_logo = 0;
                } else {
                    $logo->flag_logo = 1;
                }
            }

            /*if ($nbre == 1){
                $logo->flag_logo = 0;
            }else{
                $logo->flag_logo = 1;
            }*/

            $logo->titre_logo = $data['titre_logo'];

            $logo->id_user = $idutil;

            $logo->valeur = $data['valeur'];

            $logo->mot_cle = $data['mot_cle'];

            if (isset($data['logo_logo'])) {

                $filefront = $data['logo_logo'];

                $fileName1 = 'logo_logo' . '_' . rand(111, 99999) . '_' . 'logo_logo' . '_' . time() . '.' . $filefront->extension();

                $filefront->move(public_path('frontend/logo/'), $fileName1);

                $logo->logo_logo = $fileName1;

            }


            $logo->save();

            return redirect('/parametresysteme')->with('success', 'enregistrement effectué');

        }

        return view('logos.creer');
    }

    public function modifierparametresysteme(Request $request, $id = null)
    {


        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $idutil = Auth::user()->id;

        $logo = DB::table('logo')->where([['id_logo', '=', $id]])->first();

        if ($request->isMethod('post')) {

            $data = $request->all();

            //dd($data);die();

            if (isset($data['logo_logo'])) {

                $filefront = $data['logo_logo'];

                $fileName1 = 'logo_logo' . '_' . rand(111, 99999) . '_' . 'logo_logo' . '_' . time() . '.' . $filefront->extension();

                $filefront->move(public_path('frontend/logo/'), $fileName1);

                Logo::where([['id_logo', '=', $id]])->update([
                    'titre_logo' => $data['titre_logo'], 'id_user' => $idutil,
                    'valeur' => $data['valeur'], 'mot_cle' => $data['mot_cle'],
                    'logo_logo' => $fileName1
                ]);

            } else {

                Logo::where([['id_logo', '=', $id]])->update([
                    'titre_logo' => $data['titre_logo'], 'id_user' => $idutil,
                    'valeur' => $data['valeur'], 'mot_cle' => $data['mot_cle']
                ]);

            }

            return redirect('/parametresysteme')->with('success', 'modification effectué');
        }

        return view('logos.modifier', compact('logo', 'id'));
    }

    public function activelogo($id = null, $id1 = null)
    {

        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $id1 = \App\Helpers\Crypt::UrldeCrypt($id1);

        //dd($id)

        if ($id1 == 'LOGO') {
            $nombre1 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'LOGO']])->get();

            $nbre1 = count($nombre1);

            if ($nbre1 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }
        }

        if ($id1 == 'EMAIL') {
            $nombre2 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'EMAIL']])->get();

            $nbre2 = count($nombre2);

            if ($nbre2 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }
        }

        if ($id1 == 'CONTACT') {
            $nombre3 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'CONTACT']])->get();

            $nbre3 = count($nombre3);

            if ($nbre3 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }
        }

        if ($id1 == 'RESEAUX SOCIAUX') {

            $nombre4 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'RESEAUX SOCIAUX']])->get();


            Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

            return redirect('/logo')->with('success', 'modification effectué');

        }


        if ($id1 == 'ESPACE CLIENT') {

            $nombre5 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'ESPACE CLIENT']])->get();

            $nbre5 = count($nombre5);

            if ($nbre5 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'IMAGE ACCEUIL') {

            $nombre5 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'IMAGE ACCEUIL']])->get();

            $nbre5 = count($nombre5);

            if ($nbre5 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'SITEVITRINE') {

            $nombre5 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'SITEVITRINE']])->get();

            $nbre5 = count($nombre5);

            if ($nbre5 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'COULEUR MENU HAUT') {

            $nombre5 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'COULEUR MENU HAUT']])->get();

            $nbre5 = count($nombre5);

            if ($nbre5 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'OUVRIR COMPTE') {

            $nombre6 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'OUVRIR COMPTE']])->get();

            $nbre6 = count($nombre6);

            if ($nbre6 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'NEWSLETTER') {

            $nombre7 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'NEWSLETTER']])->get();

            $nbre7 = count($nombre7);

            if ($nbre7 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'LOCALISATION') {

            $nombre7 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'LOCALISATION']])->get();

            $nbre7 = count($nombre7);

            if ($nbre7 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'CONTACT INFO') {

            $nombre7 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'CONTACT INFO']])->get();

            $nbre7 = count($nombre7);

            if ($nbre7 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'HEURE OUVERTURE') {

            $nombre7 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'HEURE OUVERTURE']])->get();

            $nbre7 = count($nombre7);

            if ($nbre7 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'MAP LATITUDE') {

            $nombre7 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'MAP LATITUDE']])->get();

            $nbre7 = count($nombre7);

            if ($nbre7 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }

        if ($id1 == 'MAP LONGUEUR') {

            $nombre7 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'MAP LATITUDE']])->get();

            $nbre7 = count($nombre7);

            if ($nbre7 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas activer plus d un parametre de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 1]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        }
        //exit('tes');


    }

    public function desactivelogo($id = null, $id1 = null)
    {
        $id = \App\Helpers\Crypt::UrldeCrypt($id);
        $id1 = \App\Helpers\Crypt::UrldeCrypt($id1);

        if ($id1 == 'COULEUR MENU HAUT') {

            $nombre5 = DB::table('logo')->where([['flag_logo', '=', 1], ['valeur', '=', 'COULEUR MENU HAUT']])->get();

            $nbre5 = count($nombre5);

            if ($nbre5 == 1) {
                return redirect('/logo')->with('errors', 'Vous ne pouvez pas desactivé tout les parametres de ce type');
            } else {
                Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 0]);

                return redirect('/logo')->with('success', 'modification effectué');
            }

        } else {

            Logo::where([['id_logo', '=', $id]])->update(['flag_logo' => 0]);

        }


        return redirect('/logo')->with('success', 'modification effectué');
    }
}
