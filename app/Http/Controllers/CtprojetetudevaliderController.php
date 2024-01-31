<?php

namespace App\Http\Controllers;

use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Models\Entreprises;
use App\Models\Parcours;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
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
                    ->join('users','projet_etude.id_user','users.id')
                    ->where('projet_etude.id_departement',$user->id_departement)
                    ->where([
                        ['v.mini', '=', $r->priorite_combi_proc],
                        ['v.id_processus', '=', $r->id_processus],
                        ['v.code', '=', 'PE'],
                        ['p.id_roles', '=', $Idroles]
                    ])
                    ->get();
            }
        }
        return view('ctprojetetudevalider.index',compact('Resultat'));
    }

    public function edit(string $id_projet_etude,string $id_combi_proc)
    {
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $id_combi_proc = Crypt::UrldeCrypt($id_combi_proc);

        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::find($id_projet_etude);

            $operateurs = Entreprises::where('flag_operateur',true)->where('flag_actif_entreprises',true)
//                    ->where('id_secteur_activite',$projet_etude_valide->id_secteur_activite)
                ->get();

            $user = User::find($projet_etude_valide->id_user);
            $entreprise_mail = $user->email;
            $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','1')->first();
            $piecesetude1 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','2')->first();
            $piecesetude2 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','3')->first();
            $piecesetude3 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','4')->first();
            $piecesetude4 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','5')->first();
            $piecesetude5 = $piecesetude->libelle_pieces;

            $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                ->where('code_pieces','6')->first();
            $piecesetude6 = $piecesetude->libelle_pieces;
        }

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide','v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $projet_etude_valide->id_processus_selection)
            ->where('v.id_demande', '=', $projet_etude_valide->id_projet_etude)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();

        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$projet_etude_valide->id_processus_selection],
            ['id_user','=',$idUser],
            ['id_piece','=',$id_projet_etude],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id_combi_proc]
        ])->get();

        return view('ctprojetetudevalider.edit', compact('projet_etude_valide','id_combi_proc','piecesetude1','piecesetude2','piecesetude3','piecesetude4','piecesetude5','piecesetude6','entreprise','entreprise_mail','operateurs','ResultProssesList','parcoursexist'));
    }

    public function update(Request $request, $id_projet_etude)
    {
        $id_projet_etude =  Crypt::UrldeCrypt($id_projet_etude);

        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::find($id_projet_etude);

            if(isset($projet_etude_valide)) {
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
                            //TRAITEMENT A EFFECTUER APRES VALIDATION

                        }

                        return redirect('ctprojetetudevalider/' . Crypt::UrlCrypt($id_projet_etude) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succes ');
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
                        return redirect('ctprojetetudevalider/' . Crypt::UrlCrypt($id_projet_etude) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succes ');
                    }

                }
            }else{

            }
        }
    }
}
