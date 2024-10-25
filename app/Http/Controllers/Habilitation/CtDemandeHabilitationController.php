<?php

namespace App\Http\Controllers\Habilitation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Menu;
use App\Helpers\Audit;
use Carbon\Carbon;
use Hash;
use DB;
use App\Models\User;
use Image;
use File;
use Auth;
use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Models\AvisGlobaleComiteTechnique;
use App\Models\Banque;
use App\Models\CommentaireNonRecevableDemande;
use App\Models\Competences;
use App\Models\DemandeHabilitation;
use App\Models\DemandeIntervention;
use App\Models\DomaineDemandeHabilitation;
use App\Models\Experiences;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\Formateurs;
use App\Models\FormationsEduc;
use App\Models\InterventionHorsCi;
use App\Models\LanguesFormateurs;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Parcours;
use App\Models\Pays;
use App\Models\PiecesDemandeHabilitation;
use App\Models\PrincipaleQualification;
use App\Models\RapportsVisites;
use App\Models\TypeIntervention;
use App\Models\TypeMoyenPermanent;
use App\Models\TypeOrganisationFormation;
use App\Models\Visites;

class CtDemandeHabilitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUser=Auth::user()->id;
        $Idroles = Menu::get_id_profil($idUser);
        $Resultat = null;
        $ResultatEtap = DB::table('vue_processus')
            ->where('id_roles', '=', $Idroles)
            ->get();
           // dd($ResultatEtap);
        if (isset($ResultatEtap)) {
            $Resultat = [];
            foreach ($ResultatEtap as $key => $r) {
                    $Resultat[$key] = DB::table('vue_processus_liste as v')
                        ->Join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                        ->join('demande_habilitation','p.id_demande','demande_habilitation.id_demande_habilitation')
                        ->join('entreprises','demande_habilitation.id_entreprises','entreprises.id_entreprises')
                        ->join('users','demande_habilitation.id_charge_habilitation','users.id')
                        ->where([
                            ['v.mini', '=', $r->priorite_combi_proc],
                            ['v.id_processus', '=', $r->id_processus],
                             ['v.code', '=', 'HAB'],
                            ['p.id_roles', '=', $Idroles]
                        ])
                        ->get();
            }
        //dd($Resultat);
        }

        Audit::logSave([

            'action'=>'INDEX',

            'code_piece'=>'',

            'menu'=>'HABILITATION (Validation par le processus )',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.cthabilitationvalider.index',compact('Resultat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id =  Crypt::UrldeCrypt($id);

        $formateur = Formateurs::find($id);

        $qualification = PrincipaleQualification::where([['id_formateurs','=',$id]])->first();

        $formations = FormationsEduc::where([['id_formateurs','=',$id]])->get();

        $experiences = Experiences::where([['id_formateurs','=',$id]])->orderBy('date_de_debut', 'DESC')->get();

        $competences = Competences::where([['id_formateurs','=',$id]])->get();

        $languesformateurs = LanguesFormateurs::where([['id_formateurs','=',$id]])->get();

        Audit::logSave([

            'action'=>'Voir',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Validation par le processus : Voir le cv)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.cthabilitationvalider.show', compact('id','formateur','qualification',
                        'formations','experiences','languesformateurs','competences'));
    }

    public function ficheanalyse($id) {

        $id =  Crypt::UrldeCrypt($id);

        $demandehabilitation = DemandeHabilitation::find($id);

        $visite = Visites::where([['id_demande_habilitation','=',$id]])->first();

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

        $formateurs = DB::table('vue_formateur_rapport')->where([['id_demande_habilitation','=',$id]])->get();

        $rapport = RapportsVisites::where([['id_demande_habilitation','=',$id]])->first();

        $piecesDemandes = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        $avis = AvisGlobaleComiteTechnique::where([
                                        ['id_demande', '=', $id],
                                        ['code_processus', '=', 'HAB']
                                    ])->latest('id_avis_globale_comite_technique')->first();


        return view('habilitation.cthabilitationvalider.rapport',compact('id','infoentreprise',
                        'demandehabilitation','visite','formateurs','rapport','piecesDemandes','avis'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$id2)
    {
        $id =  Crypt::UrldeCrypt($id);
        $id2 =  Crypt::UrldeCrypt($id2);
        //dd($id);

        $codeRoles = Menu::get_code_menu_profil(idutil: Auth::user()->id);
        //dd($id);
        $demandehabilitation = DemandeHabilitation::find($id);

        $visites = Visites::where([['id_demande_habilitation','=',$demandehabilitation->id_demande_habilitation]])->first();
       // dd($demandehabilitation->visites->statut);
       // dd($visites);

       $rapportVisite = RapportsVisites::where([['id_visites','=',@$visites->id_visites]])->get();
      // $rapportVisitef = RapportsVisites::where([['id_demande_habilitation','=',@$demandehabilitation->id_demande_habilitation]])->first();

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";
        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);
       // dd($infoentreprise->pay->id_pays);
        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

        //dd($pay);
        $payList = "<option value=''> Selectionnez un pays</option>";
        foreach ($pays as $comp) {
            $payList .= "<option value='" . $comp->id_pays  . "'>" . $comp->libelle_pays ." </option>";
        }



        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id]])->get();



        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id]])->get();
        //dd($idetape);



        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id]])->get();







        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();





        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
                                                          ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
                                                          ->join('type_domaine_demande_habilitation','domaine_demande_habilitation.id_type_domaine_demande_habilitation','type_domaine_demande_habilitation.id_type_domaine_demande_habilitation')
                                                          ->join('type_domaine_demande_habilitation_public','domaine_demande_habilitation.id_type_domaine_demande_habilitation_public','type_domaine_demande_habilitation_public.id_type_domaine_demande_habilitation_public')
                                                          ->join('formateurs','formateur_domaine_demande_habilitation.id_formateurs','formateurs.id_formateurs')
                                                          ->where([['id_demande_habilitation','=',$id]])
                                                          ->get();


        $interventionsHorsCis = InterventionHorsCi::where([['id_demande_habilitation','=',$id]])->get();

        $commentairenonrecevables = CommentaireNonRecevableDemande::where([['id_demande','=',$id],['code_demande','=','HAB']])->get();

        $piecesDemandeHabilitations = PiecesDemandeHabilitation::where([['id_demande_habilitation','=',$id]])->get();

        $avisgobales = AvisGlobaleComiteTechnique::where([['id_demande','=',$id],['code_processus','=','HAB']])->get();

        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
        ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide',
            'v.comment_parcours', 'v.id_processus','v.id_demande')
        ->where('v.id_processus', '=', $demandehabilitation->id_processus)
        ->where('v.id_demande', '=', $demandehabilitation->id_demande_habilitation)
        ->orderBy('v.priorite_combi_proc', 'ASC')
        ->get();
        //dd($ResultProssesList);
            $idUser=Auth::user()->id;
            $idAgceCon=Auth::user()->num_agce;
            $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$demandehabilitation->id_processus],['id_user','=',$idUser],['id_piece','=',$demandehabilitation->id_demande_habilitation],['id_roles','=',$Idroles],['num_agce','=',$idAgceCon],['id_combi_proc','=',$id2]
            ])->get();


        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Validation par le processus )',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);

        return view('habilitation.cthabilitationvalider.edit', compact('demandehabilitation','infoentreprise','banque','pay',
        'id','moyenpermanentes','interventions','id2','organisations',
        'domaineDemandeHabilitations','formateurs','interventionsHorsCis','payList',
        'visites','rapportVisite','commentairenonrecevables','piecesDemandeHabilitations',
        'avisgobales','ResultProssesList','parcoursexist'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id =  Crypt::UrldeCrypt($id);

        if ($request->isMethod('put')) {

            $data = $request->all();

            if($data['action'] === 'Valider'){

                $idUser=Auth::user()->id;
                $idAgceCon=Auth::user()->num_agce;
                $Idroles = Menu::get_id_profil($idUser);
                $dateNow = Carbon::now();
                $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                $infosprocessus = DB::table('vue_processus')
                                    ->where('id_combi_proc', '=', $id_combi_proc)
                                    ->first();
                $idProComb = $infosprocessus->id_combi_proc;
                $idProcessus = $infosprocessus->id_processus;

                Parcours::create(
                    [
                        'id_processus' => $idProcessus,
                        'id_user' => $idUser,
                        'id_piece' => $id,
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
                                        ->where('a.id_demande', '=', $id)
                                        ->where('a.id_processus', '=', $idProcessus)
                                        ->where('v.id_roles', '=', $Idroles)
                                        ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                                        ->first();

                    if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {

                        $dem = DemandeHabilitation::find($id);
                        $dem->update([
                            'flag_demande_habilitation_valider_par_processus' => true
                        ]);

                    }

                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'HABILITATION (Validation par le processus : VALIDER )',

                        'etat'=>'Succès',

                        'objet'=>'HABILITATION'

                    ]);

                    return redirect('ctdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/edit')->with('success', 'Succes : Operation validée avec succes ');


            }

            if($data['action'] === 'Rejeter'){

                $this->validate($request, [
                    'comment_parcours' => 'required',
                ],[
                    'comment_parcours.required' => 'Veuillez ajouter un commentaire.',
                ]);

                $idUser=Auth::user()->id;
                $idAgceCon=Auth::user()->num_agce;
                $Idroles = Menu::get_id_profil($idUser);
                $dateNow = Carbon::now();
                $id_combi_proc = Crypt::UrldeCrypt($request->input('id_combi_proc'));
                $infosprocessus = DB::table('vue_processus')
                                    ->where('id_combi_proc', '=', $id_combi_proc)
                                    ->first();
                $idProComb = $infosprocessus->id_combi_proc;
                $idProcessus = $infosprocessus->id_processus;

                Parcours::create(
                    [
                        'id_processus' => $idProcessus,
                        'id_user' => $idUser,
                        'id_piece' => $id,
                        'id_roles' => $Idroles,
                        'num_agce' => $idAgceCon,
                        'comment_parcours' => $request->input('comment_parcours'),
                        'is_valide' => false,
                        'date_valide' => $dateNow,
                        'id_combi_proc' => $idProComb,
                    ]);


                    Audit::logSave([

                        'action'=>'MISE A JOUR',

                        'code_piece'=>$id,

                        'menu'=>'HABILITATION (Validation par le processus : REJETER )',

                        'etat'=>'Succès',

                        'objet'=>'HABILITATION'

                    ]);

                    return redirect('ctdemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt($id_combi_proc).'/editer')->with('success', 'Succes : Operation validée avec succes ');


            }

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
