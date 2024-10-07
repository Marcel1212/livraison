<?php

namespace App\Http\Controllers\Habilitation;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Models\Banque;
use App\Models\DemandeHabilitation;
use App\Models\DemandeIntervention;
use App\Models\DemandeSuppressionHabilitation;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\DomaineDemandeHabilitation;
use App\Models\DomaineDemandeSuppressionHabilitation;
use App\Models\DomaineFormation;
use App\Models\Entreprises;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\InterventionHorsCi;
use App\Models\Motif;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Parcours;
use App\Models\Pays;
use App\Models\TypeDomaineDemandeHabilitation;
use App\Models\TypeDomaineDemandeHabilitationPublic;
use App\Models\TypeIntervention;
use App\Models\TypeMoyenPermanent;
use App\Models\TypeOrganisationFormation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TraitementSuppressionDomaineHabilitationController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        $id_roles = Menu::get_id_profil(Auth::user()->id);
        $resultat_etape = DB::table('vue_processus')
            ->where('id_roles', '=', $id_roles)
            ->get();
        $demandesuppressiondomaines = DemandeSuppressionHabilitation::
//                Join('domaine_demande_suppression_habilitation',
//                    'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                    'demande_suppression_habilitation.id_demande_suppression_habilitation')->

//                join('domaine_demande_habilitation',
//                    'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                    'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')->
        join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
            'demande_suppression_habilitation.id_demande_habilitation')
            ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
            ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
            ->join('agence','agence.num_agce','agence_localite.id_agence')
            ->where('demande_suppression_habilitation.flag_soumis_demande_suppression_habilitation','=',true)

            ->join('localite','agence_localite.id_localite','localite.id_localite')
//                    ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
            ->where('id_agence','=',@$user->num_agce)
            ->whereNull('demande_suppression_habilitation.id_chef_service')->get();

        $resultat = null;
            if (isset($resultat_etape)) {
                $resultat = [];
                foreach ($resultat_etape as $key => $r) {

                    if($codeRoles == 'CHARGEHABIL'){
                        $resultat[$key] = DB::table('vue_processus_liste as v')
                            ->join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')

//                Join('domaine_demande_suppression_habilitation',
//                    'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                    'demande_suppression_habilitation.id_demande_suppression_habilitation')->

//                join('domaine_demande_habilitation',
//                    'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                    'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')->
//                                    join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
//                                        'demande_suppression_habilitation.id_demande_habilitation')
//                                        ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
//                                        ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
//                                        ->join('agence','agence.num_agce','agence_localite.id_agence')
//                                        ->join('localite','agence_localite.id_localite','localite.id_localite')
////                    ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
//                                        ->where('id_agence','=',@$user->num_agce)
//                                        ->whereNull('demande_suppression_habilitation.id_chef_service')->get();

                            ->Join('demande_suppression_habilitation',
                                'p.id_demande',
                                'demande_suppression_habilitation.id_demande_suppression_habilitation')
//                    ->Join('domaine_demande_suppression_habilitation',
//                        'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                        'demande_suppression_habilitation.id_demande_suppression_habilitation')->
//
//                    join('domaine_demande_habilitation',
//                        'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                        'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')
                            ->join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                                'demande_suppression_habilitation.id_demande_habilitation')
                            ->join('entreprises', 'entreprises.id_entreprises', 'demande_habilitation.id_entreprises')
                            ->join('agence_localite', 'entreprises.id_localite_entreprises', 'agence_localite.id_localite')
                            ->join('agence', 'agence.num_agce', 'agence_localite.id_agence')
                            ->join('localite', 'agence_localite.id_localite', 'localite.id_localite')
//                    ->join('domaine_formation', 'domaine_demande_habilitation.id_domaine_formation', 'domaine_formation.id_domaine_formation')
                            ->join('users', 'demande_suppression_habilitation.id_charge_habilitation', 'users.id')
                            ->where('demande_suppression_habilitation.id_charge_habilitation', $user->id)
                            ->where([
                                ['v.mini', '=', $r->priorite_combi_proc],
                                ['v.id_processus', '=', $r->id_processus],
                                ['v.code', '=', 'SDF'],
                                ['p.id_combi_proc', '=', $r->id_combi_proc],
                                ['p.id_roles', '=', $id_roles]
                            ])
                            ->get();
                    }else{
                        $resultat[$key] = DB::table('vue_processus_liste as v')
                            ->join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')

//                Join('domaine_demande_suppression_habilitation',
//                    'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                    'demande_suppression_habilitation.id_demande_suppression_habilitation')->

//                join('domaine_demande_habilitation',
//                    'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                    'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')->
//                                    join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
//                                        'demande_suppression_habilitation.id_demande_habilitation')
//                                        ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
//                                        ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
//                                        ->join('agence','agence.num_agce','agence_localite.id_agence')
//                                        ->join('localite','agence_localite.id_localite','localite.id_localite')
////                    ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
//                                        ->where('id_agence','=',@$user->num_agce)
//                                        ->whereNull('demande_suppression_habilitation.id_chef_service')->get();

                            ->Join('demande_suppression_habilitation',
                                'p.id_demande',
                                'demande_suppression_habilitation.id_demande_suppression_habilitation')
//                    ->Join('domaine_demande_suppression_habilitation',
//                        'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                        'demande_suppression_habilitation.id_demande_suppression_habilitation')->
//
//                    join('domaine_demande_habilitation',
//                        'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                        'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')
                            ->join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                                'demande_suppression_habilitation.id_demande_habilitation')
                            ->join('entreprises', 'entreprises.id_entreprises', 'demande_habilitation.id_entreprises')
                            ->join('agence_localite', 'entreprises.id_localite_entreprises', 'agence_localite.id_localite')
                            ->join('agence', 'agence.num_agce', 'agence_localite.id_agence')
                            ->join('localite', 'agence_localite.id_localite', 'localite.id_localite')
//                    ->join('domaine_formation', 'domaine_demande_habilitation.id_domaine_formation', 'domaine_formation.id_domaine_formation')
                            ->join('users', 'demande_suppression_habilitation.id_charge_habilitation', 'users.id')
                            ->where([
                                ['v.mini', '=', $r->priorite_combi_proc],
                                ['v.id_processus', '=', $r->id_processus],
                                ['v.code', '=', 'SDF'],
                                ['p.id_combi_proc', '=', $r->id_combi_proc],
                                ['p.id_roles', '=', $id_roles]
                            ])
                            ->get();
                    }



                }


                return view('habilitation.traitementsuppressiondomaine.index',compact('resultat','demandesuppressiondomaines'));


//            }
            //Appelé le workfklow de validation ici
//            $habilitations = DemandeHabilitation::where([['id_charge_habilitation','=',Auth::user()->id]])->get();
            }

//        //Log A revoir
//        Audit::logSave([
//            'action'=>'INDEX',
//            'code_piece'=>'',
//            'menu'=>'HABILITATION (Traitement)',
//            'etat'=>'Succès',
//            'objet'=>'HABILITATION'
//        ]);
//
//        return view('habilitation.traitementsuppressiondomaine.index',compact('demandesuppressiondomaines'));
    }

    public function affectation()
    {
        $user = Auth::user();
        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        $id_roles = Menu::get_id_profil(Auth::user()->id);
        $demandesuppressiondomaines = [];

        $resultat_etape = DB::table('vue_processus')
            ->where('id_roles', '=', $id_roles)
            ->get();
        $demandesuppressiondomaines = DemandeSuppressionHabilitation::
//                Join('domaine_demande_suppression_habilitation',
//                    'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                    'demande_suppression_habilitation.id_demande_suppression_habilitation')->

//                join('domaine_demande_habilitation',
//                    'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                    'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')->
        join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
            'demande_suppression_habilitation.id_demande_habilitation')
            ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
            ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
            ->join('agence','agence.num_agce','agence_localite.id_agence')
            ->join('localite','agence_localite.id_localite','localite.id_localite')
//                    ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
            ->where('id_agence','=',@$user->num_agce)
            ->whereNull('demande_suppression_habilitation.id_chef_service')->get();
        $resultat = null;
        if (isset($resultat_etape)) {
            $resultat = [];
            foreach ($resultat_etape as $key => $r) {
                $resultat[$key] = DB::table('vue_processus_liste as v')
                    ->join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')

//                Join('domaine_demande_suppression_habilitation',
//                    'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                    'demande_suppression_habilitation.id_demande_suppression_habilitation')->

//                join('domaine_demande_habilitation',
//                    'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                    'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')->
//                                    join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
//                                        'demande_suppression_habilitation.id_demande_habilitation')
//                                        ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
//                                        ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
//                                        ->join('agence','agence.num_agce','agence_localite.id_agence')
//                                        ->join('localite','agence_localite.id_localite','localite.id_localite')
////                    ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
//                                        ->where('id_agence','=',@$user->num_agce)
//                                        ->whereNull('demande_suppression_habilitation.id_chef_service')->get();

                    ->Join('demande_suppression_habilitation',
                        'p.id_demande',
                        'demande_suppression_habilitation.id_demande_suppression_habilitation')
//                    ->Join('domaine_demande_suppression_habilitation',
//                        'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                        'demande_suppression_habilitation.id_demande_suppression_habilitation')->
//
//                    join('domaine_demande_habilitation',
//                        'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                        'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')
                    ->join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                        'demande_suppression_habilitation.id_demande_habilitation')
                    ->join('entreprises', 'entreprises.id_entreprises', 'demande_habilitation.id_entreprises')
                    ->join('agence_localite', 'entreprises.id_localite_entreprises', 'agence_localite.id_localite')
                    ->join('agence', 'agence.num_agce', 'agence_localite.id_agence')
                    ->join('localite', 'agence_localite.id_localite', 'localite.id_localite')
//                    ->join('domaine_formation', 'domaine_demande_habilitation.id_domaine_formation', 'domaine_formation.id_domaine_formation')
                    ->join('users', 'demande_suppression_habilitation.id_charge_habilitation', 'users.id')
                    ->where([
                        ['v.mini', '=', $r->priorite_combi_proc],
                        ['v.id_processus', '=', $r->id_processus],
                        ['v.code', '=', 'SDF'],
                        ['p.id_combi_proc', '=', $r->id_combi_proc],
                        ['p.id_roles', '=', $id_roles]
                    ])
                    ->get();

            }
        }
            if($codeRoles == 'CHEFSERVICE'){
                $demandesuppressiondomaines = DemandeSuppressionHabilitation::
//                Join('domaine_demande_suppression_habilitation',
//                    'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
//                    'demande_suppression_habilitation.id_demande_suppression_habilitation')->

//                join('domaine_demande_habilitation',
//                    'domaine_demande_habilitation.id_domaine_demande_habilitation',
//                    'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')->
                join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                    'demande_suppression_habilitation.id_demande_habilitation')
                    ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
                    ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
                    ->join('agence','agence.num_agce','agence_localite.id_agence')
                    ->join('localite','agence_localite.id_localite','localite.id_localite')
//                    ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
                    ->where('id_agence','=',@$user->num_agce)
                    ->where('demande_suppression_habilitation.flag_soumis_demande_suppression_habilitation','=',true)
                    ->whereNull('demande_suppression_habilitation.id_chef_service')->get();



            return view('habilitation.traitementsuppressiondomaine.affectation',compact('resultat','demandesuppressiondomaines'));
        }else{
            return view('habilitation.traitementsuppressiondomaine.affectation',compact('demandesuppressiondomaines'));
        }

    }

    public function editaffectation($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($id);
        $domainedemandesuppression = DemandeSuppressionHabilitation::find($id);
        $demandehabilitation = @$domainedemandesuppression->domaineDemandeSuppressionHabilitation->domaineDemandeHabilitation->demandeHabilitation;
        $domaineH = @$domainedemandesuppression->domaineDemandeSuppressionHabilitation->domaineDemandeHabilitation;

        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$domainedemandesuppression->id_demande_habilitation]])->get();

        $domaine = "<option value='".@$domaineH->domaineFormation->id_domaine_formation."'> " . $domaineH->domaineFormation->libelle_domaine_formation. "</option>";
        $typedomaine = "<option value='".@$domaineH->typeDomaineDemandeHabilitation->id_type_domaine_demande_habilitation."'> " . $domaineH->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation. "</option>";
        $typedomainepublic = "<option value='".@$domaineH->typeDomaineDemandeHabilitationPublic->id_type_domaine_demande_habilitation_public."'> " . $domaineH->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public. "</option>";



        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";

        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

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

        $typemoyenpermanentes = TypeMoyenPermanent::where([['flag_type_moyen_permanent','=',true]])->get();
        $typemoyenpermanenteList = "<option value=''> Selectionnez la type de moyen </option>";
        foreach ($typemoyenpermanentes as $comp) {
            $typemoyenpermanenteList .= "<option value='" . $comp->id_type_moyen_permanent  . "'>" . mb_strtoupper($comp->libelle_type_moyen_permanent) ." </option>";
        }

        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id]])->get();

        $typeinterventions = TypeIntervention::where([['flag_type_intervention','=',true]])->get();
        $typeinterventionsList = "<option value=''> Selectionnez le type d\'intervention </option>";
        foreach ($typeinterventions as $comp) {
            $typeinterventionsList .= "<option value='" . $comp->id_type_intervention  . "'>" . mb_strtoupper($comp->libelle_type_intervention) ." </option>";
        }

        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id]])->get();
        //dd($idetape);

        $organisationFormations = TypeOrganisationFormation::where([['flag_type_organisation_formation','=',true]])->get();
        $organisationFormationsList = "<option value=''> Selectionnez le type d\'organisation </option>";
        foreach ($organisationFormations as $comp) {
            $organisationFormationsList .= "<option value='" . $comp->id_type_organisation_formation  . "'>" . mb_strtoupper($comp->libelle_type_organisation_formation) ." </option>";
        }

        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id]])->get();

        $typeDomaineDemandeHabilitation = TypeDomaineDemandeHabilitation::where([['flag_type_domaine_demande_habilitation','=',true]])->get();
        $typeDomaineDemandeHabilitationList = "<option value=''> Selectionnez la finalité </option>";
        foreach ($typeDomaineDemandeHabilitation as $comp) {
            $typeDomaineDemandeHabilitationList .= "<option value='" . $comp->id_type_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation) ." </option>";
        }

        $typeDomaineDemandeHabilitationPublic = TypeDomaineDemandeHabilitationPublic::where([['flag_type_type_domaine_demande_habilitation_public','=',true]])->get();
        $typeDomaineDemandeHabilitationPublicList = "<option value=''> Selectionnez le public </option>";
        foreach ($typeDomaineDemandeHabilitationPublic as $comp) {
            $typeDomaineDemandeHabilitationPublicList .= "<option value='" . $comp->id_type_domaine_demande_habilitation_public  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation_public) ." </option>";
        }

        $domaines = DomaineFormation::where([['flag_domaine_formation','=',true]])->get();
        $domainesList = "<option value=''> Selectionnez le domaine de formation </option>";
        foreach ($domaines as $comp) {
            $domainesList .= "<option value='" . $comp->id_domaine_formation  . "'>" . mb_strtoupper($comp->libelle_domaine_formation) ." </option>";
        }


        if($codeRoles == 'CHEFSERVICE'){
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
           if(isset($domainedemandesuppression->chargehabilitation->id)){
               $chargerHabilitationsList = "<option value='".$domainedemandesuppression->chargehabilitation->id."'> " . @$domainedemandesuppression->chargehabilitation->name.' '. mb_strtoupper(@$domainedemandesuppression->chargehabilitation->prenom_users) . "</option>";

           }else{
               $chargerHabilitationsList = "<option value=''> Selectionnez le domaine de formation </option>";
               foreach ($chargerHabilitations as $comp) {
                   $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
               }
           }


            $NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',Auth::user()->id_service]])->orderBy('nbre_dossier_en_cours','asc')->get();

        }else{
            $chargerHabilitationsList = "<option value='".$domainedemandesuppression->chargehabilitation->id."'> " . @$domainedemandesuppression->chargehabilitation->name.' '. mb_strtoupper(@$domainedemandesuppression->chargehabilitation->prenom_users) . "</option>";
            $NombreDemandeHabilitation = [];
            }

        $motifs = Motif::where([['code_motif','=','HAB']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }
        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Traitement de HABILITATION)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);
        return view('habilitation.traitementsuppressiondomaine.editaffectation', compact('demandehabilitation','infoentreprise','banque','pay',
            'id','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
            'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
            'domaine','typedomaine','typedomainepublic','domaineH','domainedemandesuppression',
            'payList','chargerHabilitationsList',
            'domaineDemandeHabilitations','NombreDemandeHabilitation',
            'motif','motifs','typeDomaineDemandeHabilitationPublicList'));
    }

    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        $id_combi_proc = Crypt::UrldeCrypt($id1);

        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        //dd($id);
        $domainedemandesuppression = DemandeSuppressionHabilitation::find($id);
        $demandehabilitation = @$domainedemandesuppression->domaineDemandeSuppressionHabilitation->domaineDemandeHabilitation->demandeHabilitation;
        $domaineH = @$domainedemandesuppression->domaineDemandeSuppressionHabilitation->domaineDemandeHabilitation;

        $domaine = "<option value='".@$domaineH->domaineFormation->id_domaine_formation."'> " . $domaineH->domaineFormation->libelle_domaine_formation. "</option>";
        $typedomaine = "<option value='".@$domaineH->typeDomaineDemandeHabilitation->id_type_domaine_demande_habilitation."'> " . $domaineH->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation. "</option>";
        $typedomainepublic = "<option value='".@$domaineH->typeDomaineDemandeHabilitationPublic->id_type_domaine_demande_habilitation_public."'> " . $domaineH->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public. "</option>";
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$domainedemandesuppression->id_demande_habilitation]])->get();



        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$demandehabilitation->banque->id_banque."'> ".mb_strtoupper($demandehabilitation->banque->libelle_banque)." </option>";

        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($demandehabilitation->entreprise->ncc_entreprises);

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

        $typemoyenpermanentes = TypeMoyenPermanent::where([['flag_type_moyen_permanent','=',true]])->get();
        $typemoyenpermanenteList = "<option value=''> Selectionnez la type de moyen </option>";
        foreach ($typemoyenpermanentes as $comp) {
            $typemoyenpermanenteList .= "<option value='" . $comp->id_type_moyen_permanent  . "'>" . mb_strtoupper($comp->libelle_type_moyen_permanent) ." </option>";
        }

        $moyenpermanentes = MoyenPermanente::where([['id_demande_habilitation','=',$id]])->get();

        $typeinterventions = TypeIntervention::where([['flag_type_intervention','=',true]])->get();
        $typeinterventionsList = "<option value=''> Selectionnez le type d\'intervention </option>";
        foreach ($typeinterventions as $comp) {
            $typeinterventionsList .= "<option value='" . $comp->id_type_intervention  . "'>" . mb_strtoupper($comp->libelle_type_intervention) ." </option>";
        }

        $interventions = DemandeIntervention::where([['id_demande_habilitation','=',$id]])->get();
        //dd($idetape);

        $organisationFormations = TypeOrganisationFormation::where([['flag_type_organisation_formation','=',true]])->get();
        $organisationFormationsList = "<option value=''> Selectionnez le type d\'organisation </option>";
        foreach ($organisationFormations as $comp) {
            $organisationFormationsList .= "<option value='" . $comp->id_type_organisation_formation  . "'>" . mb_strtoupper($comp->libelle_type_organisation_formation) ." </option>";
        }

        $organisations = OrganisationFormation::where([['id_demande_habilitation','=',$id]])->get();

        $typeDomaineDemandeHabilitation = TypeDomaineDemandeHabilitation::where([['flag_type_domaine_demande_habilitation','=',true]])->get();
        $typeDomaineDemandeHabilitationList = "<option value=''> Selectionnez la finalité </option>";
        foreach ($typeDomaineDemandeHabilitation as $comp) {
            $typeDomaineDemandeHabilitationList .= "<option value='" . $comp->id_type_domaine_demande_habilitation  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation) ." </option>";
        }

        $typeDomaineDemandeHabilitationPublic = TypeDomaineDemandeHabilitationPublic::where([['flag_type_type_domaine_demande_habilitation_public','=',true]])->get();
        $typeDomaineDemandeHabilitationPublicList = "<option value=''> Selectionnez le public </option>";
        foreach ($typeDomaineDemandeHabilitationPublic as $comp) {
            $typeDomaineDemandeHabilitationPublicList .= "<option value='" . $comp->id_type_domaine_demande_habilitation_public  . "'>" . mb_strtoupper($comp->libelle_type_domaine_demande_habilitation_public) ." </option>";
        }

        $domaines = DomaineFormation::where([['flag_domaine_formation','=',true]])->get();
        $domainesList = "<option value=''> Selectionnez le domaine de formation </option>";
        foreach ($domaines as $comp) {
            $domainesList .= "<option value='" . $comp->id_domaine_formation  . "'>" . mb_strtoupper($comp->libelle_domaine_formation) ." </option>";
        }


        if($codeRoles == 'CHEFSERVICE' && $domainedemandesuppression->flag_soumis_cs==false){
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            $chargerHabilitationsList =  "<option value=''> Selectionnez le charge d\'habilitation </option>";
            foreach ($chargerHabilitations as $comp) {
                $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
            }

        }else{
            $chargerHabilitationsList = "<option value='".$domainedemandesuppression->chargehabilitation->id."'> " . @$domainedemandesuppression->chargehabilitation->name.' '. mb_strtoupper(@$domainedemandesuppression->chargehabilitation->prenom_users) . "</option>";

        }

        $motifs = Motif::where([['code_motif','=','HAB']])->get();
        $motif = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }
        $motifs = Motif::where('code_motif','SDF')->where('flag_actif_motif',true)->get();

        Audit::logSave([

            'action'=>'MODIFIER',

            'code_piece'=>$id,

            'menu'=>'HABILITATION (Traitement de HABILITATION)',

            'etat'=>'Succès',

            'objet'=>'HABILITATION'

        ]);
        $ResultProssesList = DB::table('vue_processus_validation_affichage as v')
            ->select('v.name', 'v.priorite_combi_proc', 'v.is_valide', 'v.date_valide','v.comment_parcours', 'v.id_processus')
            ->where('v.id_processus', '=', $domainedemandesuppression->id_processus_demande_suppression_habilitation)
            ->where('v.id_demande', '=', $domainedemandesuppression->id_demande_suppression_habilitation)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();

        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$domainedemandesuppression->id_processus_demande_suppression_habilitation],
            ['id_user','=',$idUser],
            ['id_piece','=',$domainedemandesuppression->id_demande_suppression_habilitation],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id_combi_proc]
        ])->get();

        return view('habilitation.traitementsuppressiondomaine.edit', compact('demandehabilitation','infoentreprise','banque','pay',
            'id','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
            'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
            'domaine','typedomaine','typedomainepublic','domaineH','domainedemandesuppression',
            'payList','chargerHabilitationsList','parcoursexist','id_combi_proc','ResultProssesList',
            'motif','motifs','typeDomaineDemandeHabilitationPublicList','domaineDemandeHabilitations'));
    }

    public function updateaffectation(Request $request,$id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $input = $request->all();


        if($input['action']=="imputer"){
            DemandeSuppressionHabilitation::where('id_demande_suppression_habilitation',$id)->update([
                'id_processus_demande_suppression_habilitation' => 8,
                'id_charge_habilitation' => $input['id_charge_habilitation'],
                'commentaire_cs' => $input['commentaire_cs'],
                'date_soumis_cs_demande_suppression_habilitation' => Carbon::now(),
                'id_chef_service' => Auth::user()->id,
                'flag_soumis_cs' => true
            ]);
            return redirect('traitementsuppressiondomaine/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/editaffectation')->with('success', 'Succes : Demande de suppression imputé avec succès');
        }



    }

    public function update(Request $request,$id)
    {
        $id_demande_suppression =  Crypt::UrldeCrypt($id);

        if(isset($id_demande_suppression)){
            $domaine_suppression = DemandeSuppressionHabilitation::
            Join('domaine_demande_suppression_habilitation',
                'domaine_demande_suppression_habilitation.id_demande_suppression_habilitation',
                'demande_suppression_habilitation.id_demande_suppression_habilitation')->

            join('domaine_demande_habilitation',
                'domaine_demande_habilitation.id_domaine_demande_habilitation',
                'domaine_demande_suppression_habilitation.id_domaine_demande_habilitation')->
            join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                'domaine_demande_habilitation.id_demande_habilitation')
                ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
                ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
                ->join('agence','agence.num_agce','agence_localite.id_agence')
                ->join('localite','agence_localite.id_localite','localite.id_localite')
                ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
                ->where('demande_suppression_habilitation.id_demande_suppression_habilitation','=',@$id_demande_suppression)
                ->first();

            if(isset($domaine_suppression)) {
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
                            'id_piece' => $id_demande_suppression,
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
                            ->where('a.id_demande', '=', $id_demande_suppression)
                            ->where('a.id_processus', '=', $idProcessus)
                            ->where('v.id_roles', '=', $Idroles)
                            ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                            ->first();

                        if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
                            $domaine_suppression_data = DemandeSuppressionHabilitation::find($id_demande_suppression);
                            $domaine_suppression_data->flag_demande_suppression_habilitation_valider_par_proce = true;
                            $domaine_suppression_data->flag_validation_demande_suppression_habilitation = true;
                            $domaine_suppression_data->date_valider_par_processus_demande_suppression_habilitation = now();
                            $domaine_suppression_data->commentaire_final_demande_suppression_habilitation = $request->input('comment_parcours');
                            $domaine_suppression_data->update();

                            $name = $domaine_suppression->raison_social_entreprises;
                            $logo = Menu::get_logo();

                            $domaine_lib = '';

                            if(isset($domaine_suppression_data->domaineDemandeSuppressionHabilitations)){
                                foreach ($domaine_suppression_data->domaineDemandeSuppressionHabilitations as $domaineDemandeSuppressionHabilitation){

                                    $domaine_demande_domaine_supression = DomaineDemandeSuppressionHabilitation::where('id_domaine_demande_habilitation',$domaineDemandeSuppressionHabilitation->id_domaine_demande_habilitation)
                                        ->first();
                                    $domaine_demande_domaine_supression->flag_demande_suppression_habilitation = false;
                                    $domaine_demande_domaine_supression->update();


                                    $domaine_demande_domaine = DomaineDemandeHabilitation::where('id_domaine_demande_habilitation',$domaineDemandeSuppressionHabilitation->id_domaine_demande_habilitation)
                                        ->first();
                                    $domaine_demande_domaine->flag_agree_domaine_demande_habilitation = false;
                                    $domaine_demande_domaine->update();

                                    $domaine_lib .= $domaine_demande_domaine->domaineFormation->libelle_domaine_formation.',';

                                }
                            }


                            $user = User::where('id_partenaire',$domaine_suppression->id_entreprises)->first();
                                    if (isset($user->email)) {
                                        $sujet = "Demande de suppression domaine de formation habilité";
                                        $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                        $messageMail = "<b>Monsieur le Directeur,</b>
                                    <br><br> Nous sommes ravis de vous informer que votre demande de suppression du domaine de formation
                                     intitulé : <b>".@$domaine_lib.".</b> a été validé avec succès
                                    <br>
                                    Nous apprécions votre intérêt pour notre services.
                                    Cordialement, L'équipe e-FDFP
                                    <br>
                                    <br>
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";

                                        $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $name, $messageMail, $sujet, $titre);
                                    }

                        }
                        return redirect('traitementsuppressiondomaine/' . Crypt::UrlCrypt($id_demande_suppression) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succes ');

                    }
                    if ($data['action'] === 'Rejeter') {
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
                            'id_piece' => $id_demande_suppression,
                            'id_roles' => $Idroles,
                            'num_agce' => $idAgceCon,
                            'comment_parcours' => $request->input('comment_parcours'),
                            'is_valide' => true,
                            'date_valide' => $dateNow,
                            'id_combi_proc' => $idProComb,
                        ]);

                            $domaine_suppression_data = DomaineDemandeSuppressionHabilitation::find($id_demande_suppression);
                            $domaine_suppression_data->flag_demande_suppression_habilitation_valider_par_proce = true;
                            $domaine_suppression_data->flag_rejeter_demande_suppression_habilitation = true;
                            $domaine_suppression_data->flag_validation_demande_suppression_habilitation = false;
                            $domaine_suppression_data->date_valider_par_processus_demande_suppression_habilitation = now();
                            $domaine_suppression_data->commentaire_final_demande_suppression_habilitation = $request->input('comment_parcours');
                            $domaine_suppression_data->update();

                            $name = $domaine_suppression->raison_social_entreprises;
                            $logo = Menu::get_logo();

                        $domaine_lib = '';

                        if(isset($domaine_suppression_data->domaineDemandeSuppressionHabilitations)){
                            foreach ($domaine_suppression_data->domaineDemandeSuppressionHabilitations as $domaineDemandeSuppressionHabilitation){

                                $domaine_demande_domaine_supression = DomaineDemandeSuppressionHabilitation::where('id_domaine_demande_habilitation',$domaineDemandeSuppressionHabilitation->id_domaine_demande_habilitation)
                                    ->first();
                                $domaine_demande_domaine_supression->flag_demande_suppression_habilitation = true;
                                $domaine_demande_domaine_supression->update();


                                $domaine_demande_domaine = DomaineDemandeHabilitation::where('id_domaine_demande_habilitation',$domaineDemandeSuppressionHabilitation->id_domaine_demande_habilitation)
                                    ->first();
                                $domaine_demande_domaine->flag_agree_domaine_demande_habilitation = true;
                                $domaine_demande_domaine->update();

                                $domaine_lib .= $domaine_demande_domaine->domaineFormation->libelle_domaine_formation.',';

                            }
                        }
//
//

                            $user = User::where('id_partenaire',$domaine_suppression->id_entreprises)->first();
                            if (isset($user->email)) {
                                $sujet = "Demande de suppression domaine de formation habilité";
                                $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                $messageMail = "<b>Monsieur le Directeur,</b>
                                    <br><br> Nous sommes ravis de vous informer que votre demande suppression du domaine de formation
                                     intitulé : <b>".@$domaine_suppression->libelle_domaine_formation.".</b> a été rejété pour la raison suivant<br>
                                     ".@$domaine_suppression->commentaire_final_demande_suppression_habilitation."
                                    <br>
                                    Nous apprécions votre intérêt pour notre services.
                                    Cordialement, L'équipe e-FDFP
                                    <br>
                                    <br>
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";

                                $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $name, $messageMail, $sujet, $titre);
                            }

                        return redirect('traitementsuppressiondomaine/' . Crypt::UrlCrypt($id_demande_suppression) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succes ');

                    }

                }
            }
        }
    }
}
