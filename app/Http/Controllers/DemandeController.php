<?php

namespace App\Http\Controllers;

use App\Helpers\Crypt;
use App\Helpers\GenerateCode as Gencode;
use App\Helpers\Menu;
use App\Models\Demande;
use App\Models\LigneDemande;
use App\Models\Parcours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Airtable;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUser = Auth::user()->id;
        $IdCode = Menu::get_code_menu_profil($idUser);
        if ($IdCode == "DO" or $IdCode == "DAF" or $IdCode == "ADMIN") {
            $Resultat = DB::table('demande as d')
                ->select('d.num_demande', 'd.id_demande', 'd.uuid_demande', 'd.mtt_total_demande',
                    'd.created_at', 'd.is_solde', 'd.is_soumis', 'd.is_valide', 'd.date_valide', 'a.lib_agce', 'p.lib_prod')
                ->Join('agence as a', 'a.num_agce', '=', 'd.num_agce')
                ->Join('produit as p', 'p.id_prod', '=', 'd.id_prod')
                ->where([['d.is_rejet_1', '=', false], ['d.is_rejet_2', '=', false]])
                ->get();
        } else {
            $Resultat = DB::table('demande as d')
                ->select('d.num_demande', 'd.id_demande', 'd.uuid_demande', 'd.mtt_total_demande',
                    'd.created_at', 'd.is_solde', 'd.is_soumis', 'd.is_valide', 'd.date_valide', 'a.lib_agce', 'p.lib_prod')
                ->Join('agence as a', 'a.num_agce', '=', 'd.num_agce')
                ->Join('produit as p', 'p.id_prod', '=', 'd.id_prod')
                ->where([['d.is_rejet_1', '=', false], ['d.is_rejet_2', '=', false], ['d.num_agce', '=', Auth::user()->num_agce]])
                ->get();
        }
        return view('demande.index', compact('Resultat'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function demandencours()
    {
        $idAgceCon = Auth::user()->num_agce;
        $idUser = Auth::user()->id;
        $Idroles = Menu::get_id_profil($idUser);
        $IdCode = Menu::get_code_menu_profil($idUser);
        $Resultat = null;
        $ResultatEtap = DB::table('vue_processus')
            ->where('id_roles', '=', $Idroles)
            ->get();
        if (isset($ResultatEtap)) {
            $Resultat = [];
            foreach ($ResultatEtap as $key => $r) {
                if ($IdCode == "DO") {
                    $Resultat = DB::table('vue_processus_liste_dir_operation as v')->get();
                } elseif ($IdCode == "DAF") {
                    $Resultat = DB::table('vue_processus_liste_daf as v')->get();
                } else {
                    // dd((int)($r->priorite_combi_proc));
                    $Resultat[$key] = DB::table('vue_processus_liste as v')
                        ->Join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                        ->where([
                            ['v.mini', '=', $r->priorite_combi_proc],
                            ['v.id_processus', '=', $r->id_processus],
                            // ['v.id_demande_existe', '=', null],
                            ['p.id_roles', '=', $Idroles]
                        ])
                        ->get();
                }
            }
//dd($Resultat);
        }

        return view('demande.demandencours', compact('Resultat', 'IdCode'));
    }


    public function demanderejetes()
    {
        $idAgceCon = Auth::user()->num_agce;
        $idUser = Auth::user()->id;
        $IdCode = Menu::get_code_menu_profil($idUser);
        $Idroles = Menu::get_id_profil($idUser);

        if ($IdCode == "DO" or $IdCode == "DAF" or $IdCode == "RA") {
            $Resultat = DB::table('demande as d')
                ->select('d.num_demande', 'd.id_demande', 'd.uuid_demande', 'd.mtt_total_demande',
                    'd.created_at', 'd.is_solde', 'd.is_soumis', 'd.is_valide', 'd.date_valide', 'cp.id_combi_proc',
                    'd.is_rejet_1', 'd.date_rejet_1', 'a.lib_agce', 'p.lib_prod')
                ->Join('combinaison_processus as cp', 'cp.id_processus', '=', 'd.id_processus')
                ->Join('agence as a', 'a.num_agce', '=', 'd.num_agce')
                ->Join('produit as p', 'p.id_prod', '=', 'd.id_prod')
                ->where([['cp.id_roles', '=', $Idroles], ['d.is_rejet_1', '=', true], ['d.is_rejet_2', '=', false]])
                ->orderBy('lib_prod',)->get();
        } else {
            $Resultat = DB::table('demande as d')
                ->select('d.num_demande', 'd.id_demande', 'd.uuid_demande', 'd.mtt_total_demande',
                    'd.created_at', 'd.is_solde', 'd.is_soumis', 'd.is_valide', 'd.date_valide', 'a.lib_agce',
                    'd.is_rejet_1', 'd.date_rejet_1', 'd.is_rejet_2', 'd.date_rejet_2', 'p.lib_prod')
                ->Join('agence as a', 'a.num_agce', '=', 'd.num_agce')
                ->Join('produit as p', 'p.id_prod', '=', 'd.id_prod')
                ->where([['d.is_rejet_1', '=', true], ['d.is_rejet_2', '=', true], ['d.num_agce', '=', $idAgceCon]])
                ->get();
        }
        return view('demande.demanderejetes', compact('Resultat', 'IdCode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function newFacture(Request $request, $id = null)
    {
        $idAgceCon = Auth::user()->num_agce;
        $idUser = Auth::user()->id;
        $ProfilConnecte = Menu::get_menu_profil($idUser);
        $idVal = Crypt::UrldeCrypt($id);


        if ($request->isMethod('post') and $request->input('newFacture') == 'newFacture') {
            $ResultModeLdemList = DB::table('ligne_model_demande_agence as l')
                ->select('l.id_cv', 'l.qte_lmda', 'l.pu_lmda', 'l.num_mda', 'm.id_processus', 'l.num_lmda', 'l.is_valide')
                ->Join('model_demande_agence as m', 'm.num_mda', '=', 'l.num_mda')
                ->where('m.id_prod', '=', $request->input('id_prod'))
                ->where('m.num_agce', '=', $idAgceCon)
                ->where('l.is_valide', '=', true)
                ->get();
            $codeDem = 'D' . date('Y') . '-' . Gencode::randStrGen(4, 8);
            Demande::create(
                [
                    'user_id' => $idUser,
                    'num_agce' => $idAgceCon,
                    'num_demande' => $codeDem,
                    'id_prod' => $request->input('id_prod'),
                    'id_processus' => $ResultModeLdemList[0]->id_processus,
                    'mtt_total_demande' => 0,
                    'is_soumis' => false,
                    'is_valide' => false,
                    'is_rejet_1' => false,
                    'is_rejet_2' => false
                ]);
            $insertedId = \App\Helpers\Crypt::UrlCrypt(Demande::latest()->first()->uuid_demande);
            $insertedIdD = \App\Helpers\Crypt::UrldeCrypt($insertedId);
            $ResultDEm = DB::table('demande')->where('uuid_demande', '=', $insertedIdD)->first();


            $totalDem = 0;
            foreach ($ResultModeLdemList as $value1) {
                LigneDemande::create([
                    'id_cv' => $value1->id_cv,
                    'id_demande' => $ResultDEm->id_demande,
                    'montant_ldem' => trim($value1->pu_lmda),
                    'qte_ldem' => trim($value1->qte_lmda)
                ]);
                $totalDem += $value1->qte_lmda * $value1->pu_lmda;
            }

            Demande::where('id_demande', '=', $ResultDEm->id_demande)->update(
                [
                    'mtt_total_demande' => $totalDem
                ]
            );


        }
        if ($request->isMethod('post') and $request->input('SoumettreDem') == 'SoumettreDem') {

            $uUidDem = Crypt::UrldeCrypt($request->input('UuidDem'));
            $idProcessus = Crypt::UrldeCrypt($request->input('id_processus'));
            $idDem = Crypt::UrldeCrypt($request->input('idDem'));
            Demande::where('uuid_demande', '=', $uUidDem)->update(
                [
                    'is_rejet_1' => false,
                    'is_rejet_2' => false,
                    'is_soumis' => true,
                    'date_soumis' => new \DateTime()
                ]
            );
            $insertedId = \App\Helpers\Crypt::UrlCrypt($uUidDem);

            $et = Airtable::table('afrecodemandes')->Create(
                [
                    'num_demande' => $idDem,
                    'statut' => 'soumis',
                    'profil_demandeur' => $ProfilConnecte,

                ]
            );

        }
        if ($request->isMethod('post') and $request->input('ValiderDem') == 'ValiderDem') {
            $idProcessus = Crypt::UrldeCrypt($request->input('id_processus'));
            $idDem = Crypt::UrldeCrypt($request->input('idDem'));
            $idProComb = Crypt::UrldeCrypt($request->input('idProComb'));
            $Idroles = Menu::get_id_profil($idUser);

            $ResultCptVal = DB::table('combinaison_processus as v')
                ->select(DB::raw('max(v.priorite_combi_proc) as priorite_combi_proc'), 'a.priorite_max')
                ->Join('vue_processus_max as a', 'a.id_processus', '=', 'v.id_processus')
                ->where('a.id_demande', '=', $idDem)
                ->where('a.id_processus', '=', $idProcessus)
                ->where('v.id_roles', '=', $Idroles)
                ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                ->first();
            //   dd($idDem,$idProcessus,$Idroles,'/'.$ResultCptVal);
            $dateNow = new \DateTime();
            Parcours::create(
                [
                    'id_processus' => $idProcessus,
                    'id_user' => $idUser,
                    'id_piece' => $idDem,
                    'id_roles' => $Idroles,
                    'num_agce' => $idAgceCon,
                    'comment_parcours' => $request->input('Comment'),
                    'is_valide' => true,
                    'is_rejet_1' => false,
                    'is_rejet_2' => false,
                    'date_valide' => $dateNow,
                    'id_combi_proc' => $idProComb,
                ]);
            Demande::where('id_demande', '=', $idDem)->update(
                [
                    'is_rejet_1' => false,
                    'is_rejet_2' => false,
                ]
            );
            if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
                //  dd($ResultCptVal);
                Demande::where('id_demande', '=', $idDem)->update(
                    [
                        'is_valide' => true,
                        'is_rejet_1' => false,
                        'is_rejet_2' => false,
                        'user_id_valide' => $idUser,
                        'date_valide' => $dateNow
                    ]
                );
            }
            Airtable::table('afrecodemandes')->Create(
                [
                    'num_demande' => $idDem,
                    'statut' => 'validé',
                    'profil_demandeur' => $ProfilConnecte
                ]
            );
            return redirect('demandencours');
        }
        if ($request->isMethod('post') and $request->input('RejeterDem') == 'RejeterDem') {
            $idProcessus = Crypt::UrldeCrypt($request->input('id_processus'));
            $idDem = Crypt::UrldeCrypt($request->input('idDem'));
            $idProComb = Crypt::UrldeCrypt($request->input('idProComb'));
            $uUidDem = Crypt::UrldeCrypt($request->input('UuidDem'));
            // dd($idDem);
            $Idroles = Menu::get_id_profil($idUser);
            Parcours::create(
                [
                    'id_processus' => $idProcessus,
                    'id_user' => $idUser,
                    'id_piece' => $idDem,
                    'id_roles' => $Idroles,
                    'num_agce' => $idAgceCon,
                    'comment_parcours' => $request->input('Comment'),
                    'is_valide' => false,
                    'date_valide' => new \DateTime(),
                    'id_combi_proc' => $idProComb,
                ]);

            $IdCode = Menu::get_code_menu_profil($idUser);
            if ($IdCode == "DO" or $IdCode == "DAF") {
                $ResDem = DB::table('demande as d')
                    ->select('d.is_rejet_1', 'd.uuid_demande')
                    ->where('uuid_demande', '=', $uUidDem)
                    ->first();
                if ($ResDem->is_rejet_1 == false) {
                    Demande::where('uuid_demande', '=', $uUidDem)->update(
                        [
                            //'is_soumis' => false,
                            'is_rejet_1' => true,
                            'date_rejet_1' => new \DateTime(),
                            'is_rejet_2' => true,
                            'date_rejet_2' => new \DateTime()
                        ]
                    );
                } else {
                    Demande::where('uuid_demande', '=', $uUidDem)->update(
                        [
                            //'is_soumis' => false,
                            'is_rejet_2' => true,
                            'date_rejet_2' => new \DateTime()
                        ]
                    );
                }
            } else {
                Demande::where('uuid_demande', '=', $uUidDem)->update(
                    [
                        'is_rejet_1' => true,
                        'date_rejet_1' => new \DateTime()
                    ]
                );
            }
            Airtable::table('afrecodemandes')->Create(
                [
                    'num_demande' => $idDem,
                    'statut' => 'rejeté',
                    'profil_demandeur' => $ProfilConnecte
                ]
            );
            return redirect('demandencours');
        }

        return redirect('demandes/create/' . $insertedId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id = null, $id2 = null)
    {
        $idUser = Auth::user()->id;
        $idVal = Crypt::UrldeCrypt($id);
        $idValDel = Crypt::UrldeCrypt($id2);
        $idAgceCon = Auth::user()->num_agce;
        $ResAgence = DB::table('agence')->where('num_agce', '=', $idAgceCon)->first();
        $ResPatient = null;
        $ResDem = null;
        $ResultActe = null;
        $coutList = null;
        $ResultLdemList = null;
        $ResultLdemListFixe = null;
        $ResultLdemListVariable = null;
        $nbLineTotal = null;
        $nbLineValide = null;
        $ResultProssesList = null;
        /*activity()
            ->useLog(Auth::user()->name . ' ' . Auth::user()->prenom_users)
            ->withProperties(['customProperty' => 'customValue'])
            ->log('Look, I logged something');*/
        $Produi = DB::table('produit as l')
            ->Join('model_demande_agence as m', 'm.id_prod', '=', 'l.id_prod')
            ->where('l.is_valide', '=', true)
            ->where('m.num_agce', '=', $idAgceCon)
            ->orderBy('lib_prod',)->get();
        $ProduiList = "<option value='' > -- Sélectionner --</option>";
        foreach ($Produi as $comp) {
            $ProduiList .= "<option value='" . $comp->id_prod . "'  >" . $comp->lib_prod . " </option>";
        }


        if ($idVal != null) {
            if (($idValDel != null)) {
                LigneDemande::where('num_ldem', $idValDel)->delete();
                return redirect('demandes/create/' . \App\Helpers\Crypt::UrlCrypt($idVal))->with('success', 'Succes : Suppression réussie ');
            }
            $ResDem = DB::table('demande as d')
                ->select('d.id_demande', 'd.uuid_demande', 'd.user_id', 'd.num_demande', 'd.mtt_total_demande', 'd.is_solde'
                    , 'd.created_at', 'd.num_agce', 'd.date_soumis', 'd.is_soumis', 'p.lib_prod', 'p.id_prod', 'pr.lib_processus', 'pr.id_processus')
                ->Join('produit as p', 'p.id_prod', '=', 'd.id_prod')
                ->Join('processus as pr', 'pr.id_processus', '=', 'd.id_processus')
                ->where('uuid_demande', '=', $idVal)
                ->first();

            $ResAgence = DB::table('agence')->where('num_agce', '=', $ResDem->num_agce)->first();

            $ResultLdemList = DB::table('ligne_demande as l')
                ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                    'l.is_valide', 'm.code_cv')
                ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
                ->where('id_demande', '=', $ResDem->id_demande)
                ->orderBy('m.code_cv', 'ASC')
                ->orderBy('m.lib_cv', 'ASC')
                ->get();
            $ResultLdemListFixe = DB::table('ligne_demande as l')
                ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                    'l.is_valide', 'm.code_cv')
                ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
                ->where('id_demande', '=', $ResDem->id_demande)
                ->where('code_cv', '=', 'FIX')
                ->orderBy('m.code_cv', 'ASC')
                ->orderBy('m.lib_cv', 'ASC')
                ->get();

            $ResultLdemListVariable = DB::table('ligne_demande as l')
                ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                    'l.is_valide', 'm.code_cv')
                ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
                ->where('id_demande', '=', $ResDem->id_demande)
                ->where('code_cv', '=', 'VAR')
                ->orderBy('m.code_cv', 'ASC')
                ->orderBy('m.lib_cv', 'ASC')
                ->get();
            $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
                ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
                    'v.comment_parcours', 'v.id_processus')
                ->where('v.id_processus', '=', $ResDem->id_processus)
                ->where('v.id_demande', '=', $ResDem->id_demande)
                ->orderBy('v.priorite_combi_proc', 'ASC')
                ->get();
//dd($ResultProssesList);
            $nbLineTotal = count($ResultLdemList);
            $nbLineValide = LigneDemande::where([['id_demande', $ResDem->id_demande], ['is_valide', true]])->select('num_ldem')->get()->count();

            $value = 0;
            foreach ($ResultLdemList as $comp11) {
                $value .= ',' . $comp11->id_cv;
            }
            $myArray = explode(',', $value);
            $cout = DB::table('cout_variable')
                ->where('is_valide', '=', true)
                ->whereNotIn('id_cv', $myArray)
                ->orderBy('lib_cv')->get();
            $coutList = "<option value='' > -- Sélectionner --</option>";
            $var = "";
            foreach ($cout as $comp) {
                if ($comp->code_cv === 'FIX') {
                    $var = "Coût fixe";
                }
                if ($comp->code_cv === 'VAR') {
                    $var = "Coût variable";
                }
                $coutList .= "<option value='" . $comp->id_cv . "'  >" . strtoupper($comp->lib_cv) . " | <strong>" . $var . " </strong></option>";
            }
        }

        if ($request->isMethod('post')) {
            /********************** Recherche de  la facture ********************/
            if ($request->input('RechercherFacture') == "RechercherFacture") {
                $request->validate([
                    'dem_invoice' => 'required',
                ]);
                $codeFact = trim($request->input('dem_invoice'));
                $Result = DB::table('demande')
                    ->where('num_demande', '=', $codeFact)
                    ->first();
                if (isset($Result)) {
                    return redirect('demandes/create/' . \App\Helpers\Crypt::UrlCrypt($Result->uuid_demande));
                } else {
                    return redirect('demandes/create')->with('echec', 'Echec : Cette demande n\'existe pas!');
                }
            }

            return redirect('/demandes/create/' . Crypt::UrlCrypt($ResDem > uuid_facture))->with('success', 'Succes : Enregistrement reussi ');
        }
        return view('demande.create', compact('ResPatient', 'ProduiList', 'ResDem', 'ResAgence', 'nbLineTotal', 'nbLineValide',
            'ResultActe', 'ResultLdemListFixe', 'ResultLdemListVariable', 'coutList', 'ResultProssesList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function valide(Request $request, $id = null, $id2 = null)
    {
        $idUser = Auth::user()->id;
        $idVal = Crypt::UrldeCrypt($id);
        $idProComb = Crypt::UrldeCrypt($id2);
        $idAgceCon = Auth::user()->num_agce;
        $ResPatient = null;
        $ResDem = null;
        $ResultActe = null;
        $coutList = null;
        $ResultLdemList = null;
        $ResultLdemListFixe = null;
        $ResultLdemListVariable = null;
        $nbLineTotal = null;
        $nbLineValide = null;
        $ResultProssesList = null;
        if ($idVal != null) {

            $ResDem = DB::table('demande as d')
                ->select('d.id_demande', 'd.uuid_demande', 'd.user_id', 'd.num_demande', 'd.mtt_total_demande', 'd.is_solde', 'd.date_valide'
                    , 'd.created_at', 'd.num_agce', 'd.date_soumis', 'd.is_soumis', 'p.lib_prod', 'p.id_prod', 'pr.lib_processus', 'pr.id_processus')
                ->Join('produit as p', 'p.id_prod', '=', 'd.id_prod')
                ->Join('processus as pr', 'pr.id_processus', '=', 'd.id_processus')
                ->where('uuid_demande', '=', $idVal)
                ->first();

            $ResAgence = DB::table('agence')->where('num_agce', '=', $ResDem->num_agce)->first();

            $ResultLdemList = DB::table('ligne_demande as l')
                ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                    'l.is_valide', 'm.code_cv')
                ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
                ->where('id_demande', '=', $ResDem->id_demande)
                ->orderBy('m.lib_cv', 'ASC')
                ->get();
            $ResultLdemListFixe = DB::table('ligne_demande as l')
                ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                    'l.is_valide', 'm.code_cv')
                ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
                ->where('id_demande', '=', $ResDem->id_demande)
                ->where('code_cv', '=', 'FIX')
                ->orderBy('m.code_cv', 'ASC')
                ->orderBy('m.lib_cv', 'ASC')
                ->get();

            $ResultLdemListVariable = DB::table('ligne_demande as l')
                ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                    'l.is_valide', 'm.code_cv')
                ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
                ->where('id_demande', '=', $ResDem->id_demande)
                ->where('code_cv', '=', 'VAR')
                ->orderBy('m.code_cv', 'ASC')
                ->orderBy('m.lib_cv', 'ASC')
                ->get();
            $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
                ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
                    'v.comment_parcours', 'v.id_processus')
                ->where('v.id_processus', '=', $ResDem->id_processus)
                ->where('v.id_demande', '=', $ResDem->id_demande)
                ->orderBy('v.priorite_combi_proc', 'ASC')
                ->get();
            $nbLineTotal = count($ResultLdemList);
            $nbLineValide = LigneDemande::where([['id_demande', $ResDem->id_demande], ['is_valide', true]])->select('num_ldem')->get()->count();
        }

        return view('demande.valide', compact('ResPatient', 'ResDem', 'ResAgence', 'nbLineTotal', 'nbLineValide',
            'ResultActe', 'ResultLdemList', 'ResultLdemListVariable', 'ResultLdemListFixe', 'coutList', 'ResultProssesList', 'idProComb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        if ($request->isMethod('post')) {
            $id_dem = $request->input('demande');
            $ResDem = DB::table('demande')
                ->where('id_demande', '=', $id_dem)
                ->first();
            /*--------------------creation de ligne de demande -------------------------------*/
            if ($request->input('Create_line_demande') == "Create_line_demande") {

                $request->validate([
                    'group_a.*.cout' => 'required',
                    'group_a.*.qte_acte' => 'required',
                    'group_a.*.pu_acte' => 'required',
                ], [
                        'group_a.*.cout.required' => 'Le coût est réquis.',
                        'group_a.*.qte_acte.required' => 'La quantité est réquise.',
                        'group_a.*.pu_acte.required' => 'Le prix est réquis.'
                    ]
                );

                $totalDem = 0;
                if ($ResDem->mtt_total_demande != null)
                    $totalDem = $ResDem->mtt_total_demande;
                foreach ($request->group_a as $key => $value) {
                    LigneDemande::create([
                        'id_cv' => $value['cout'],
                        'id_demande' => $id_dem,
                        'id_user' => Auth::user()->id,
                        'description_ldem' => $value['description'],
                        'montant_ldem' => trim($value['pu_acte']),
                        'qte_ldem' => trim($value['qte_acte']),
                        'montant_total_ldem' => trim($value['qte_acte'] * $value['pu_acte'])
                    ]);
                    $totalDem += $value['qte_acte'] * $value['pu_acte'];
                }

                Demande::where('id_demande', '=', $id_dem)->update(
                    [
                        'mtt_total_demande' => $totalDem
                    ]
                );
                return back()->with('success', 'Enregistrement reussi.');
            }

            /*--------------------Modifier de ligne de demande -------------------------------*/
            if ($request->input('Modifier_ligne') == "Modifier_ligne") {

                $id_dem = $request->input('demande');
                $totalDem = 0;
                if ($ResDem->is_valide == true)
                    $totalDem = $ResDem->mtt_total_demande;

                $nbLine = $request->input('nbLine');
                $nbLine1 = $request->input('nbLine1');
                if ($nbLine > 0) {
                    for ($i = 1; $i <= $nbLine; $i++) {
                        $idLigne = Crypt::UrldeCrypt($request->input('idLigne' . $i));
                        if (($idLigne != null)) {
                            $qte_ldem = trim($request->input('qte_ldem' . $i));
                            $description_ldem = trim($request->input('description_ldem' . $i));
                            $montant_ldem = trim($request->input('montant_ldem' . $i));
                            $is_valide = $request->has('is_valide' . $i);
                            LigneDemande::where('num_ldem', '=', $idLigne)->update([
                                'montant_ldem' => $montant_ldem,
                                'qte_ldem' => $qte_ldem,
                                'description_ldem' => $description_ldem,
                                'is_valide' => $is_valide,
                                'id_user' => Auth::user()->id,
                                'montant_total_ldem' => $qte_ldem * $montant_ldem
                            ]);
                            if ($is_valide == true)
                                $totalDem += $qte_ldem * $montant_ldem;
                        }
                    }
                }
                if ($nbLine1 > 0) {
                    for ($i = 1; $i <= $nbLine1; $i++) {
                        $idLigne1 = Crypt::UrldeCrypt($request->input('idLigne1' . $i));
                        if (($idLigne != null)) {
                            $qte_ldem = trim($request->input('qte_ldem1' . $i));
                            $description_ldem = trim($request->input('description_ldem1' . $i));
                            $montant_ldem = trim($request->input('montant_ldem1' . $i));
                            $is_valide = $request->has('is_valide1' . $i);
                            LigneDemande::where('num_ldem', '=', $idLigne1)->update([
                                'montant_ldem' => $montant_ldem,
                                'qte_ldem' => $qte_ldem,
                                'description_ldem' => $description_ldem,
                                'is_valide' => $is_valide,
                                'id_user' => Auth::user()->id,
                                'montant_total_ldem' => $qte_ldem * $montant_ldem
                            ]);
                            if ($is_valide == true)
                                $totalDem += $qte_ldem * $montant_ldem;
                        }
                    }
                }

                Demande::where('id_demande', '=', $id_dem)->update(
                    [
                        'mtt_total_demande' => $totalDem
                    ]
                );
                return back()->with('success', 'Enregistrement reussi.');
            }
        }
    }

    public function recudemande($id = null)
    {
        $idVal = Crypt::UrldeCrypt($id);
        $idAgceCon = Auth::user()->num_agce;

        $ResDem = DB::table('demande')
            ->where('uuid_demande', '=', $idVal)
            ->first();
        //dd($ResDem);
        $ResultLdemListFixe = DB::table('ligne_demande as l')
            ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                'l.is_valide', 'm.code_cv')
            ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
            ->where('id_demande', '=', $ResDem->id_demande)
            ->where('code_cv', '=', 'FIX')
            ->orderBy('m.code_cv', 'ASC')
            ->orderBy('m.lib_cv', 'ASC')
            ->get();

        $ResultLdemListVariable = DB::table('ligne_demande as l')
            ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                'l.is_valide', 'm.code_cv')
            ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
            ->where('id_demande', '=', $ResDem->id_demande)
            ->where('code_cv', '=', 'VAR')
            ->orderBy('m.code_cv', 'ASC')
            ->orderBy('m.lib_cv', 'ASC')
            ->get();

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
                'v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $ResDem->id_processus)
            ->where('v.id_demande', '=', $ResDem->id_demande)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();
        $ResAgence = DB::table('agence')->where('num_agce', '=', $ResDem->num_agce)->first();
        $mtt_total_fact = null;

        return view('demande.recudemande', compact('ResDem', 'ResultProssesList', 'ResultLdemListVariable', 'ResultLdemListFixe', 'mtt_total_fact', 'ResAgence'));
    }

    public function recudemandexls($id = null)
    {
        $idVal = Crypt::UrldeCrypt($id);
        $idAgceCon = Auth::user()->num_agce;

        $ResDem = DB::table('demande')
            ->where('uuid_demande', '=', $idVal)
            ->first();
        //dd($ResDem);
        $ResultLdemListFixe = DB::table('ligne_demande as l')
            ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                'l.is_valide', 'm.code_cv')
            ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
            ->where('id_demande', '=', $ResDem->id_demande)
            ->where('code_cv', '=', 'FIX')
            ->orderBy('m.code_cv', 'ASC')
            ->orderBy('m.lib_cv', 'ASC')
            ->get();

        $ResultLdemListVariable = DB::table('ligne_demande as l')
            ->select('m.id_cv', 'm.lib_cv', 'l.description_ldem', 'l.montant_ldem', 'l.qte_ldem', 'l.num_ldem',
                'l.is_valide', 'm.code_cv')
            ->Join('cout_variable as m', 'm.id_cv', '=', 'l.id_cv')
            ->where('id_demande', '=', $ResDem->id_demande)
            ->where('code_cv', '=', 'VAR')
            ->orderBy('m.code_cv', 'ASC')
            ->orderBy('m.lib_cv', 'ASC')
            ->get();

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
                'v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $ResDem->id_processus)
            ->where('v.id_demande', '=', $ResDem->id_demande)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();
        $ResAgence = DB::table('agence')->where('num_agce', '=', $ResDem->num_agce)->first();
        $mtt_total_fact = null;

        return view('demande.recudemandexls', compact('ResDem', 'ResultProssesList', 'ResultLdemListVariable', 'ResultLdemListFixe', 'mtt_total_fact', 'ResAgence'));
    }


}
