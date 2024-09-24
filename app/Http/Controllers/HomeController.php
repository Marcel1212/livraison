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
use App\Models\CompositionCapitale;
use App\Models\HistoriqueMotDePasse;
use App\Models\TypeCompositionCapitale;

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

    public function updatepassword(Request $request, $id=null)
    {

        if (isset($id)) {
            $idetape = \App\Helpers\Crypt::UrldeCrypt($id);
        }else{
            $idetape = 1;
        }

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
                        'id_activites.required' => 'Veuillez ajouter votre activité.',
                    ]);

                    $input = $request->all();

                    $input['id_entreprises'] = Auth::user()->id_partenaire;

                    $verfactivite = ActivitesEntreprises::where([['id_entreprises','=',$input['id_entreprises']],['id_activites','=',$input['id_activites']]])->get();

                    if(count($verfactivite)>0){
                        return redirect('/modifiermotdepasse')->with('error', 'Cette Activité existe déjà');
                    }else{
                        ActivitesEntreprises::create($input);
                       // return redirect('/modifiermotdepasse')->with('success', 'Activité ajoutée avec succès');
                        return redirect('modifiermotdepasse/'.Crypt::UrlCrypt(4))->with('success', 'Succes : Enregistrement reussi ');

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
                        'tel_entreprises' => 'required',
                        'nom_prenom_dirigeant' => 'required'
                    ],[
                        'localisation_geographique_entreprise.required' => 'Veuillez ajouter votre localisation.',
                        'repere_acces_entreprises.required' => 'Veuillez ajouter un repere d\'accès.',
                        'adresse_postal_entreprises.required' => 'Veuillez ajouter une adresse postale.',
                        'cellulaire_professionnel_entreprises.required' => 'Veuillez ajouter un contact cellulaire.',
                        'tel_entreprises.required' => 'Veuillez ajouter un contact telephonique.',
                        'cpwd.required' => 'Veuillez ajouter l\' ancien mot de passe.',
                        'npwd.required' => 'Veuillez ajouter le nouveau mot de passe.',
                        'vpwd.required' => 'Veuillez ressaisir le nouveau mot de passe.',
                        'nom_prenom_dirigeant.required' => 'Veuillez ajouter le nom et prenom du dirigeant.',
                    ]);

                    /***** verification du mot de passe */

                    $verifmdp = Crypt::VerifierMotDePasse($data['npwd']);

                    if($verifmdp != "mot de passe correcte"){
                        return redirect('/modifiermotdepasse')->with('error', '.'.$verifmdp.'.');
                    }

                    if (Hash::check($data['cpwd'], $users->password)) {

                        $motpass = $key . '+' . $data['npwd'];
                        $pass = Hash::make($data['npwd']);
                        $histo = HistoriqueMotDePasse::create([
                            'id_utilisateur'=> $users->id,
                            'ancien_mot_de_passe_hash'=> $users->password
                        ]);
                        // mise a jour du mot de passe
                        User::where(['id' => $users->id])->update(['password' => $pass]);
                        $input = $request->all();
                        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
                        $input['localisation_geographique_entreprise'] = mb_strtoupper($input['localisation_geographique_entreprise']);
                        $input['repere_acces_entreprises'] = mb_strtoupper($input['repere_acces_entreprises']);
                        $input['adresse_postal_entreprises'] = mb_strtoupper($input['adresse_postal_entreprises']);
                        $input['nom_prenom_dirigeant'] = mb_strtoupper($input['nom_prenom_dirigeant']);
                        $entreprise = Entreprises::find($infoentreprise->id_entreprises);
                        $entreprise->update($input);
                        return redirect('/modifiermotdepasse')
                            ->with('success', 'Votre mot de passe et information de l\'entreprise a été  modifié avec succes');

                    } else {
                        return redirect('/modifiermotdepasse')
                            ->with('error', 'Veuillez renseigner l\'ancien mot de passe ');
                    }

                }

                if ($data['action'] == 'terminer'){

                    User::where(['id' => $users->id])->update(['flag_mdp' => 1]);
                    return redirect('/modifiermotdepasse')->with('success', 'Vos informations ont été mise a jour avec succes');
                }

                if ($data['action'] == 'compositionCapitale'){
                    $this->validate($request, [
                        'id_type_composition_capitale' => 'required',
                        'montant_composition_capitale' => 'required',
                    ],[
                        'id_type_composition_capitale.required' => 'Veuillez selectionner le type de composition de capitale.',
                        'montant_composition_capitale.required' => 'Veuillez ajouter le montant du capitale.',
                    ]);

                    $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
                    $input = $request->all();
                    $input['id_entreprises'] = $infoentreprise->id_entreprises;

                    CompositionCapitale::create($input);

                    return redirect('modifiermotdepasse/'.Crypt::UrlCrypt(3))->with('success', 'Succes : Enregistrement reussi ');

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

                    $verifmdp = Crypt::VerifierMotDePasse($data['npwd']);

                    if($verifmdp != "mot de passe correcte"){
                        return redirect('/modifiermotdepasse')->with('error', '.'.$verifmdp.'.');
                    }

                    if (Hash::check($data['cpwd'], $users->password)) {

                        $motpass = $key . '+' . $data['npwd'];
                        $pass = Hash::make($data['npwd']);
                        $histo = HistoriqueMotDePasse::create([
                            'id_utilisateur'=> $users->id,
                            'ancien_mot_de_passe_hash'=> $users->password
                        ]);
                        // mise a jour du mot de passe
                        User::where(['id' => $users->id])->update(['password' => $pass, 'flag_mdp' => 1]);

                        return redirect('/dashboard')
                            ->with('success', 'Votre mot de passe a été  modifié avec succes');

                    } else {
                        return redirect('/modifiermotdepasse')
                            ->with('error', 'Veuillez renseigner l\'ancien mot de passe ');
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

                    //dd($request->all());
                    $this->validate($request, [
                        'id_activites' => 'required'
                    ],[
                        'id_activites.required' => 'Veuillez ajouter votre activité.',
                    ]);

                    $input = $request->all();

                    $input['id_entreprises'] = Auth::user()->id_partenaire;

                    $verfactivite = ActivitesEntreprises::where([['id_entreprises','=',$input['id_entreprises']],['id_activites','=',$input['id_activites']]])->get();

                    if(count($verfactivite)>0){
                        return redirect('/modifiermotdepasse')->with('error', 'Cette Activité existe déjà');
                    }else{
                        ActivitesEntreprises::create($input);
                       // return redirect('/modifiermotdepasse')->with('success', 'Activité ajoutée avec succès');
                        return redirect('modifiermotdepasse/'.Crypt::UrlCrypt(4))->with('success', 'Succes : Enregistrement reussi ');

                    }
                }

                if ($data['action'] == 'compositionCapitale'){
                    $this->validate($request, [
                        'id_type_composition_capitale' => 'required',
                        'montant_composition_capitale' => 'required',
                    ],[
                        'id_type_composition_capitale.required' => 'Veuillez selectionner le type de composition de capitale.',
                        'montant_composition_capitale.required' => 'Veuillez ajouter le montant du capitale.',
                    ]);

                    $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
                    $input = $request->all();
                    $input['id_entreprises'] = $infoentreprise->id_entreprises;

                    CompositionCapitale::create($input);

                    return redirect('modifiermotdepasse/'.Crypt::UrlCrypt(3))->with('success', 'Succes : Enregistrement reussi ');

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
                        'tel_entreprises' => 'required',
                        'nom_prenom_dirigeant' => 'required'
                    ],[
                        'localisation_geographique_entreprise.required' => 'Veuillez ajouter votre localisation.',
                        'repere_acces_entreprises.required' => 'Veuillez ajouter un repere d\'accès.',
                        'adresse_postal_entreprises.required' => 'Veuillez ajouter une adresse postale.',
                        'cellulaire_professionnel_entreprises.required' => 'Veuillez ajouter un contact cellulaire.',
                        'tel_entreprises.required' => 'Veuillez ajouter un contact telephonique.',
                        'cpwd.required' => 'Veuillez ajouter l\' ancien mot de passe.',
                        'npwd.required' => 'Veuillez ajouter le nouveau mot de passe.',
                        'vpwd.required' => 'Veuillez ressaisir le nouveau mot de passe.',
                        'nom_prenom_dirigeant.required' => 'Veuillez ajouter le nom et prenom du dirigeant.',
                    ]);

                    $verifmdp = Crypt::VerifierMotDePasse($data['npwd']);

                    if($verifmdp != "mot de passe correcte"){
                        return redirect('/modifiermotdepasse')->with('error', '.'.$verifmdp.'.');
                    }

                    if (Hash::check($data['cpwd'], $users->password)) {

                        $motpass = $key . '+' . $data['npwd'];
                        $pass = Hash::make($data['npwd']);

                        $histo = HistoriqueMotDePasse::create([
                            'id_utilisateur'=> $users->id,
                            'ancien_mot_de_passe_hash'=> $users->password
                        ]);
                        // mise a jour du mot de passe
                        User::where(['id' => $users->id])->update(['password' => $pass]);
                        $input = $request->all();
                        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);
                        $input['localisation_geographique_entreprise'] = mb_strtoupper($input['localisation_geographique_entreprise']);
                        $input['repere_acces_entreprises'] = mb_strtoupper($input['repere_acces_entreprises']);
                        $input['adresse_postal_entreprises'] = mb_strtoupper($input['adresse_postal_entreprises']);
                        $input['nom_prenom_dirigeant'] = mb_strtoupper($input['nom_prenom_dirigeant']);
                        $entreprise = Entreprises::find($infoentreprise->id_entreprises);
                        $entreprise->update($input);
                        return redirect('/dashboard')
                            ->with('success', 'Votre mot de passe et information de l\'entreprise a été  modifié avec succes');

                    } else {
                        return redirect('/modifiermotdepasse')
                            ->with('error', 'Veuillez renseigner l\'ancien mot de passe ');
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

                    $verifmdp = Crypt::VerifierMotDePasse($data['npwd']);
                    //dd($verifmdp);
                    if($verifmdp != "mot de passe correcte"){
                        return redirect('/modifiermotdepasse')->with('error', '.'.$verifmdp.'.');
                    }

                    if (Hash::check($data['cpwd'], $users->password)) {

                        $motpass = $key . '+' . $data['npwd'];
                        $pass = Hash::make($data['npwd']);
                        $histo = HistoriqueMotDePasse::create([
                            'id_utilisateur'=> $users->id,
                            'ancien_mot_de_passe_hash'=> $users->password
                        ]);
                        // mise a jour du mot de passe
                        User::where(['id' => $users->id])->update(['password' => $pass, 'flag_mdp' => 1]);

                        return redirect('/dashboard')
                            ->with('success', 'Votre mot de passe a été  modifié avec succes');

                    } else {
                        return redirect('/modifiermotdepasse')
                            ->with('error', 'Veuillez renseigner l\'ancien mot de passe ');
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
//dd($infoentreprise);
        //if(isset($infoentreprise)){
            $identreprise = @$infoentreprise->id_entreprises;
            $activites = Activites::whereNotExists(function ($query) use ($identreprise){
                $query->select('*')
                    ->from('activites_entreprises')
                    ->whereColumn('activites_entreprises.id_activites','=','activites.id_activites')
                    ->where('activites_entreprises.id_entreprises',$identreprise);
            })->where('flag_activites',true)
            ->get();

            //Activites::where([['flag_activites','=',true]])->get();
            $activite = "<option value=''> -- Sélectionnez une activité -- </option>";
            foreach ($activites as $comp) {
                $activite .= "<option value='" . @$comp->id_activites  . "'>" . @$comp->libelle_activites ." </option>";
            }

            $listeactivites = ActivitesEntreprises::where([['id_entreprises','=',@$infoentreprise->id_entreprises],['flag_activites_entreprises','=',true]])->get();

        /*}else{
            $activites = [];
            $activite = [];
            $listeactivites = [];
        }*/
        $identreprise = @$infoentreprise->id_entreprises;
        $typeCompoCapitMAJ = TypeCompositionCapitale::whereNotExists(function ($query) use ($identreprise){
            $query->select('*')
                ->from('composition_capitale')
                ->whereColumn('composition_capitale.id_type_composition_capitale','=','type_composition_capitale.id_type_composition_capitale')
                ->where('composition_capitale.id_entreprises',$identreprise);
        })->where('flag_type_composition_capitale',true)
        ->get();

      $typeCompoCapitMAJList = "<option value='' > selectionnez un statut</option>";
      foreach ($typeCompoCapitMAJ as $comp) {
          $typeCompoCapitMAJList .= "<option value='" . $comp->id_type_composition_capitale . "'   >" . strtoupper($comp->libelle_type_composition_capitale) . " </option>";
      }

        $listecompocapitales = CompositionCapitale::where([['id_entreprises','=',@$identreprise],['flag_composition_capitale','=',true]])->get();

        return view('profil.updatepassword')->with(compact('tabl', 'naroles','infoentreprise','pay','activite','listeactivites','idetape','typeCompoCapitMAJList','listecompocapitales'));

    }

    public function saveLocation(Request $request)
    {

        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ],[
            'latitude.required' => 'Veuillez ajouter la latitude.',
            'longitude.required' => 'Veuillez ajouter la longitude.',
        ]);

        $infoentreprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);

        $input = $request->all();

        $input['latitude_entreprises'] = $input['latitude'];
        $input['longitude_entreprises'] = $input['longitude'];

        $entreprise = Entreprises::find($infoentreprise->id_entreprises);
        $entreprise->update($input);

        return response()->json(['message' => 'Position enregistrée avec succès!']);
    }
    public function deleteactiviteentreprise($id){
        $idVal = Crypt::UrldeCrypt($id);

        ActivitesEntreprises::where([['id_activites_entreprises','=',$idVal]])->delete();

        //return redirect('/modifiermotdepasse')->with('success', 'Activité supprimée avec succès');
        return redirect('modifiermotdepasse/'.Crypt::UrlCrypt(4))->with('success', 'Succes : Suppression reussi ');
    }

    public function deletecompositioncapitale($id){
        $idVal = Crypt::UrldeCrypt($id);

        CompositionCapitale::where([['id_composition_capitale','=',$idVal]])->delete();

        return redirect('modifiermotdepasse/'.Crypt::UrlCrypt(3))->with('success', 'Succes : Suppression reussi ');

    }
}
