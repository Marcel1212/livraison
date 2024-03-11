<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Crypt;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\FormeJuridique;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AffectationProjetEtudeController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $direction = Direction::where('code_profil_direction','D2EQPC')->first();
        $role = Menu::get_menu_profil($user->id);

        if(isset($direction)){
            $role = Menu::get_menu_profil($user->id);
            $departement = Departement::where('id_departement',$user->id_departement)
                ->where('id_direction',$direction->id_direction)
                ->first();

            if($role == "CHEF DE DEPARTEMENT"){
                if(isset($departement)){
                    $projet_etudes = ProjetEtude::where('id_departement',$departement->id_departement)
                        ->where('flag_soumis_chef_depart',false)
                        ->get();

                    return view('projetetudes.affectation.index',compact('projet_etudes','role'));
                }else{
                    return redirect('/dashboard')->with('Error', 'Erreur : Vous n\'êtes pas autorisé à accéder à ce menu');
                }
            }

            if($role=="CHEF DE SERVICE"){
                if(isset($departement)){
                    $service = Service::where('id_departement',$departement->id_departement)
                        ->where('id_service',$user->id_service)
                        ->first();
                    if(isset($service)){
                        $projet_etudes = ProjetEtude::where('id_departement',$departement->id_departement)
                            ->where('flag_soumis_chef_service',false)
                            ->where('id_chef_serv',$user->id)->get();
                        return view('projetetudes.affectation.index',compact('projet_etudes','role'));
                    }else{
                        return redirect('/dashboard')->with('Error', 'Erreur : Vous n\'êtes pas autorisé à accéder à ce menu');
                    }
                }else{
                    return redirect('/dashboard')->with('Error', 'Erreur : Vous n\'êtes pas autorisé à accéder à ce menu');
                }
            }
        }else{
        }
    }

    public function edit($id,$id_etape)
    {
        $id_etape =  Crypt::UrldeCrypt($id_etape);
        $id =  Crypt::UrldeCrypt($id);
        $user = Auth::user();
        $role = Menu::get_menu_profil($user->id);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if($role == "CHEF DE DEPARTEMENT") {
            if (isset($id)) {

                $projet_etude = ProjetEtude::find($id);

                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $secteuractivite_projet = "<option value='".@$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
                foreach ($secteuractivite_projets as $comp) {
                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }



                if (isset($projet_etude)) {
                    $formjuridique = "<option value='".@$projet_etude->entreprise->formeJuridique->id_forme_juridique."'> " . @$projet_etude->entreprise->formeJuridique->libelle_forme_juridique . "</option>";
                    foreach ($formjuridiques as $comp) {
                        $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                    }
                    $chef_services = DB::table('users')
                        ->where('id_departement', $projet_etude->id_departement)
                        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                        ->select('users.name', 'users.prenom_users', 'users.id')
                        ->where('roles.id', 19)
                        ->get();
                    $pieces_projets = PiecesProjetEtude::where('id_projet_etude', $projet_etude->id_projet_etude)
                        ->get();
                    $pays = Pays::all();
                    $pay = "<option value='" . $projet_etude->entreprise->pay->id_pays . "'> " . $projet_etude->entreprise->pay->indicatif . "</option>";
                    foreach ($pays as $comp) {
                        $pay .= "<option value='" . $comp->id_pays . "'>" . $comp->indicatif . " </option>";
                    }
                    return view('projetetudes.affectation.edit', compact('chef_services',
                        'secteuractivite_projet','formjuridique',
                        'pieces_projets', 'id_etape', 'pay', 'role', 'projet_etude'));
                }
            }
        }
        if($role == "CHEF DE SERVICE") {
            if (isset($id)) {
                $projet_etude = ProjetEtude::find($id);
                if (isset($projet_etude)) {
                    $formjuridique = "<option value='".@$projet_etude->entreprise->formeJuridique->id_forme_juridique."'> " . @$projet_etude->entreprise->formeJuridique->libelle_forme_juridique . "</option>";
                    foreach ($formjuridiques as $comp) {
                        $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                    }

                    $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                        ->orderBy('libelle_secteur_activite')
                        ->get();

                    $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
                    foreach ($secteuractivite_projets as $comp) {
                        $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                    }

                    $charger_etudes = DB::table('users')
                        ->where('id_departement', $projet_etude->id_departement)
                        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                        ->select('users.name', 'users.prenom_users', 'users.id')
                        ->where('roles.code_roles', "CHARGEETUDE")
                        ->get();
                    $pieces_projets = PiecesProjetEtude::where('id_projet_etude', $projet_etude->id_projet_etude)
                        ->get();
                    $pays = Pays::all();
                    $pay = "<option value='" . $projet_etude->entreprise->pay->id_pays . "'> " . $projet_etude->entreprise->pay->indicatif . "</option>";
                    foreach ($pays as $comp) {
                        $pay .= "<option value='" . $comp->id_pays . "'>" . $comp->indicatif . " </option>";
                    }
                    return view('projetetudes.affectation.edit',
                        compact('charger_etudes',
                            'pieces_projets',
                            'id_etape',
                            'formjuridique',
                            'pay',
                            'role',
                            'secteuractivite_projet',
                            'projet_etude'));
                }
            }
        }
    }

    public function update(Request $request,$id)
    {
        $id =  Crypt::UrldeCrypt($id);
        if(isset($id)){
            if($request->action=="soumission_projet_etude_cd"){
                $this->validate($request, [
                    'id_chef_serv' => 'required',
                    'commentaires_cd' => 'required',
                ],[
                    'id_chef_serv.required' => 'Veuillez sélectionner un chef de service.',
                    'commentaires_cd.required' => 'Veuillez ajouter un commentaire.',
                ]);
                $projet_etude = ProjetEtude::find($id);
                if(isset($projet_etude)){
                    $projet_etude->id_chef_serv = $request->id_chef_serv;
                    $projet_etude->commentaires_cd = $request->commentaires_cd;
                    $projet_etude->date_soumis_chef_depart = now();
                    $projet_etude->flag_soumis_chef_depart = true;
                    $projet_etude->update();
                    return redirect()->back()->with('Success', 'Succès : Projet attribué au chef de service');
                }else{

                }
            }
            if($request->action=="soumission_projet_etude_cs"){
                $this->validate($request, [
                    'id_charge_etude' => 'required',
                    'commentaires_cs' => 'required',
                ],[
                    'id_charge_etude.required' => 'Veuillez ajouter un chargé d\'étude',
                    'commentaires_cs.required' => 'Veuillez ajouter un commentaire.',
                ]);
                $projet_etude = ProjetEtude::find($id);
                if(isset($projet_etude)){
                    $projet_etude->id_charge_etude = $request->id_charge_etude;
                    $projet_etude->commentaires_cs = $request->commentaires_cs;
                    $projet_etude->date_soumis_chef_service = now();
                    $projet_etude->flag_soumis_chef_service = true;
                    $projet_etude->update();
                    return redirect()->back()->with('Success', 'Succès : Projet attribué au chargé d\'étude');
                }else{

                }
            }
        }else{
        }
    }
}
