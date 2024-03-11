<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\FormeJuridique;
use App\Models\Parcours;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CtprojetetudevaliderController extends Controller
{
    public function index(){
        $user =  Auth::user();
        $Idroles = Menu::get_id_profil($user->id);
            $Resultat = null;
        $ResultatEtap = DB::table('vue_processus')
            ->where('id_roles', '=', $Idroles)
            ->get();
        if (isset($ResultatEtap)) {
            $Resultat = [];
            foreach ($ResultatEtap as $key => $r) {
                $Resultat[$key] = DB::table('vue_processus_liste as v')
                    ->Join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                    ->join('projet_etude','p.id_demande','projet_etude.id_projet_etude')
                    ->join('entreprises','projet_etude.id_entreprises','entreprises.id_entreprises')
                    ->join('users','projet_etude.id_charge_etude','users.id')
                    ->where('projet_etude.id_departement',$user->id_departement)
                    ->where([
                        ['v.mini', '=', $r->priorite_combi_proc],
                        ['v.id_processus', '=', $r->id_processus],
                        ['p.id_combi_proc', '=', $r->id_combi_proc],
                        ['v.code', '=', 'PE'],
                        ['p.id_roles', '=', $Idroles]
                    ])
                    ->get();

            }
        }
        return view('projetetudes.comite_technique_a_valider.index',compact('Resultat'));
    }

    public function edit(string $id_projet_etude,string $id_combi_proc)
    {
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $id_combi_proc = Crypt::UrldeCrypt($id_combi_proc);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if(isset($id_projet_etude)){
            $projet_etude = ProjetEtude::find($id_projet_etude);


            $user = User::find($projet_etude->id_user);
            $entreprise_mail = $user->email;
            $infoentreprise = InfosEntreprise::get_infos_entreprise($user->login_users);

            $formjuridique = "<option value='".$infoentreprise->formeJuridique->id_forme_juridique."'> " . $infoentreprise->formeJuridique->libelle_forme_juridique . "</option>";

            foreach ($formjuridiques as $comp) {
                $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
            }


            $pays = Pays::all();
            $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
            foreach ($pays as $comp) {
                $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
            }

            /******************** secteuractivites *********************************/
            $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                ->orderBy('libelle_secteur_activite')
                ->get();
            $secteuractivite = "<option value=''> Selectionnez un secteur activité </option>";
            foreach ($secteuractivites as $comp) {
                $secteuractivite .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
            }

            $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                ->orderBy('libelle_secteur_activite')
                ->get();

            $secteuractivite_projet = "<option value='".$projet_etude->secteurActivite->id_secteur_activite."'> " . $projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
            foreach ($secteuractivite_projets as $comp) {
                $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
            }


        }

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide','v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $projet_etude->id_processus)
            ->where('v.id_demande', '=', $projet_etude->id_projet_etude)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();

        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$projet_etude->id_processus],
            ['id_user','=',$idUser],
            ['id_piece','=',$id_projet_etude],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id_combi_proc]
        ])->get();

        $pieces_projets= PiecesProjetEtude::where('id_projet_etude',$projet_etude->id_projet_etude)->get();

        return view('projetetudes.comite_technique_a_valider.edit', compact(
            'secteuractivite_projet',
            'projet_etude','id_combi_proc',
            'formjuridique',
            'pieces_projets','pay','secteuractivite',
        'infoentreprise','entreprise_mail','ResultProssesList','parcoursexist'));
    }

    public function update(Request $request, $id_projet_etude)
    {
        $id_projet_etude =  Crypt::UrldeCrypt($id_projet_etude);
        if(isset($id_projet_etude)){
            $projet_etude = ProjetEtude::find($id_projet_etude);
            if(isset($projet_etude)) {
                if ($request->isMethod('put')) {
                    $data = $request->all();
                    if ($data['action'] === 'Valider') {
                        $idUser = Auth::user()->id;
                        $idAgceCon = Auth::user()->num_agce;
                        $Idroles = Menu::get_id_profil($idUser);
                        $dateNow = Carbon::now();
                        $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                        $infosprocessus = DB::table('vue_processus')
                            ->where('id_combi_proc', '=', $id_combi_proc)
                            ->first();
                        $idProComb = $infosprocessus->id_combi_proc;
                        $idProcessus = $infosprocessus->id_processus;

                        Parcours::create([
                            'id_processus' => $idProcessus,
                            'id_user' => $idUser,
                            'id_piece' => $id_projet_etude,
                            'id_roles' => $Idroles,
                            'num_agce' => $idAgceCon,
                            'comment_parcours' => $request->input('comment_parcours'),
                            'is_valide' => true,
                            'date_valide' => $dateNow,
                            'id_combi_proc' => $idProComb,
                        ]);

                        $ResultCptVal = DB::table('combinaison_processus as v')
                            ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
                            ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
                            ->where('a.id_demande', '=', $id_projet_etude)
                            ->where('a.id_processus', '=', $idProcessus)
                            ->where('v.id_roles', '=', $Idroles)
                            ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                            ->first();

                        if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
                            $projet_etude->flag_valider_par_processus = true;
                            $projet_etude->date_valider_par_processus = now();
                            $projet_etude->update();
                        }

                        return redirect('ctprojetetudevalider/' . Crypt::UrlCrypt($id_projet_etude) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succès ');
                    }

                    if ($data['action'] === 'Rejeter') {

                        $this->validate($request, [
                            'comment_parcours' => 'required',
                        ], [
                            'comment_parcours.required' => 'Veuillez ajouter un commentaire.',
                        ]);

                        $idUser = Auth::user()->id;
                        $idAgceCon = Auth::user()->num_agce;
                        $Idroles = Menu::get_id_profil($idUser);
                        $dateNow = Carbon::now();
                        $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                        $infosprocessus = DB::table('vue_processus')
                            ->where('id_combi_proc', '=', $id_combi_proc)
                            ->first();
                        $idProComb = $infosprocessus->id_combi_proc;
                        $idProcessus = $infosprocessus->id_processus;

                        Parcours::create([
                            'id_processus' => $idProcessus,
                            'id_user' => $idUser,
                            'id_piece' => $id_projet_etude,
                            'id_roles' => $Idroles,
                            'num_agce' => $idAgceCon,
                            'comment_parcours' => $request->input('comment_parcours'),
                            'is_valide' => false,
                            'date_valide' => $dateNow,
                            'id_combi_proc' => $idProComb,
                        ]);

                        $ResultCptVal = DB::table('combinaison_processus as v')
                            ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
                            ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
                            ->where('a.id_demande', '=', $id_projet_etude)
                            ->where('a.id_processus', '=', $idProcessus)
                            ->where('v.id_roles', '=', $Idroles)
                            ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                            ->first();

                        if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
                            //TRAITEMENT A EFFECTUER APRES REJET

                        }
                        return redirect('ctprojetetudevalider/' . Crypt::UrlCrypt($id_projet_etude) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succès ');
                    }

                }
            }else{

            }
        }
    }
}
