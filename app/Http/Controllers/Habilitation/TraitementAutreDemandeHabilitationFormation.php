<?php

namespace App\Http\Controllers\Habilitation;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Helpers\SmsPerso;
use App\Http\Controllers\Controller;
use App\Models\Banque;
use App\Models\CommentaireNonRecevableDemande;
use App\Models\Competences;
use App\Models\DemandeHabilitation;
use App\Models\DemandeIntervention;
use App\Models\AutreDemandeHabilitationFormation;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\DomaineDemandeHabilitation;
use App\Models\DomaineAutreDemandeHabilitationFormation;
use App\Models\DomaineFormation;
use App\Models\DomaineFormationCabinet;
use App\Models\Entreprises;
use App\Models\Experiences;
use App\Models\FormateurDomaineDemandeHabilitation;
use App\Models\Formateurs;
use App\Models\FormationsEduc;
use App\Models\InterventionHorsCi;
use App\Models\LanguesFormateurs;
use App\Models\Motif;
use App\Models\MoyenPermanente;
use App\Models\OrganisationFormation;
use App\Models\Parcours;
use App\Models\Pays;
use App\Models\PrincipaleQualification;
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

class TraitementAutreDemandeHabilitationFormation extends Controller
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
        if($codeRoles == 'CHARGEHABIL'){
            $autre_demande_habilitation_formations = AutreDemandeHabilitationFormation::
            join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                'autre_demande_habilitation_formation.id_demande_habilitation')
                ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
                ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
                ->join('agence','agence.num_agce','agence_localite.id_agence')
                ->join('localite','agence_localite.id_localite','localite.id_localite')
                ->where('autre_demande_habilitation_formation.id_charge_habilitation',Auth::user()->id)
                ->where('type_autre_demande','demande_extension')
                ->where('autre_demande_habilitation_formation.flag_instruction',false)
                ->where('autre_demande_habilitation_formation.flag_soumis_autre_demande_habilitation_formation','=',true)
                ->get();
        }else{
            $autre_demande_habilitation_formations = AutreDemandeHabilitationFormation::
            join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                'autre_demande_habilitation_formation.id_demande_habilitation')
                ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
                ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
                ->join('agence','agence.num_agce','agence_localite.id_agence')
                ->where('autre_demande_habilitation_formation.flag_soumis_autre_demande_habilitation_formation','=',true)
                ->join('localite','agence_localite.id_localite','localite.id_localite')
                ->where('id_agence','=',@$user->num_agce)
                ->whereNull('autre_demande_habilitation_formation.id_chef_service')->get();
        }



        $resultat = null;
            if (isset($resultat_etape)) {
                $resultat = [];
                foreach ($resultat_etape as $key => $r) {
                    if($codeRoles == 'CHARGEHABIL'){
                        $resultat[$key] = DB::table('vue_processus_liste as v')
                            ->join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')
                            ->Join('autre_demande_habilitation_formation',
                                'p.id_demande',
                                'autre_demande_habilitation_formation.id_autre_demande_habilitation_formation')
                            ->join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                                'autre_demande_habilitation_formation.id_demande_habilitation')
                            ->join('entreprises', 'entreprises.id_entreprises', 'demande_habilitation.id_entreprises')
                            ->join('agence_localite', 'entreprises.id_localite_entreprises', 'agence_localite.id_localite')
                            ->join('agence', 'agence.num_agce', 'agence_localite.id_agence')
                            ->join('localite', 'agence_localite.id_localite', 'localite.id_localite')
                            ->join('users', 'autre_demande_habilitation_formation.id_charge_habilitation', 'users.id')
                            ->where('autre_demande_habilitation_formation.id_charge_habilitation', $user->id)
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

                            ->Join('autre_demande_habilitation_formation',
                                'p.id_demande',
                                'autre_demande_habilitation_formation.id_autre_demande_habilitation_formation')
                            ->join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                                'autre_demande_habilitation_formation.id_demande_habilitation')
                            ->join('entreprises', 'entreprises.id_entreprises', 'demande_habilitation.id_entreprises')
                            ->join('agence_localite', 'entreprises.id_localite_entreprises', 'agence_localite.id_localite')
                            ->join('agence', 'agence.num_agce', 'agence_localite.id_agence')
                            ->join('localite', 'agence_localite.id_localite', 'localite.id_localite')
                            ->join('users', 'autre_demande_habilitation_formation.id_charge_habilitation', 'users.id')
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
                return view('habilitation.traitementautredemandehabilitation.index',compact('resultat','autre_demande_habilitation_formations'));
            }
    }

    public function affectation()
    {
        $user = Auth::user();
        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        $id_roles = Menu::get_id_profil(Auth::user()->id);
        $autre_demande_habilitation_formation = [];

        $resultat_etape = DB::table('vue_processus')
            ->where('id_roles', '=', $id_roles)
            ->get();
        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::
        join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
            'autre_demande_habilitation_formation.id_demande_habilitation')
            ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
            ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
            ->join('agence','agence.num_agce','agence_localite.id_agence')
            ->join('localite','agence_localite.id_localite','localite.id_localite')
            ->where('id_agence','=',@$user->num_agce)
            ->whereNull('autre_demande_habilitation_formation.id_chef_service')->get();
        $resultat = null;
        if (isset($resultat_etape)) {
            $resultat = [];
            foreach ($resultat_etape as $key => $r) {
                $resultat[$key] = DB::table('vue_processus_liste as v')
                    ->join('vue_processus_min_encours as p', 'p.id_demande', '=', 'v.id_demande')

                    ->Join('autre_demande_habilitation_formation',
                        'p.id_demande',
                        'autre_demande_habilitation_formation.id_autre_demande_habilitation_formation')
                    ->join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                        'autre_demande_habilitation_formation.id_demande_habilitation')
                    ->join('entreprises', 'entreprises.id_entreprises', 'demande_habilitation.id_entreprises')
                    ->join('agence_localite', 'entreprises.id_localite_entreprises', 'agence_localite.id_localite')
                    ->join('agence', 'agence.num_agce', 'agence_localite.id_agence')
                    ->join('localite', 'agence_localite.id_localite', 'localite.id_localite')
                    ->join('users', 'autre_demande_habilitation_formation.id_charge_habilitation', 'users.id')
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
                $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::
                join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                    'autre_demande_habilitation_formation.id_demande_habilitation')
                    ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
                    ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
                    ->join('agence','agence.num_agce','agence_localite.id_agence')
                    ->join('localite','agence_localite.id_localite','localite.id_localite')
                    ->where('id_agence','=',@$user->num_agce)
                    ->where('autre_demande_habilitation_formation.flag_soumis_autre_demande_habilitation_formation','=',true)
                    ->whereNull('autre_demande_habilitation_formation.id_chef_service')->get();
            return view('habilitation.traitementautredemandehabilitation.affectation',compact('resultat','autre_demande_habilitation_formation'));
        }else{
            return view('habilitation.traitementautredemandehabilitation.affectation',compact('autre_demande_habilitation_formation'));
        }

    }

    public function editaffectation($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::find($id);
        $habilitation = DemandeHabilitation::find($autre_demande_habilitation_formation->id_demande_habilitation);
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$autre_demande_habilitation_formation->id_demande_habilitation]])->get();

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$habilitation->banque->id_banque."'> ".mb_strtoupper($habilitation->banque->libelle_banque)." </option>";

        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($habilitation->entreprise->ncc_entreprises);

        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }

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
           if(isset($autre_demande_habilitation_formation->chargehabilitation->id)){
               $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";

           }else{
               $chargerHabilitationsList = "<option value=''> Selectionnez le domaine de formation </option>";
               foreach ($chargerHabilitations as $comp) {
                   $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
               }
           }


            $NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',Auth::user()->id_service]])->orderBy('nbre_dossier_en_cours','asc')->get();

        }else{
            $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";
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
        return view('habilitation.traitementautredemandehabilitation.editaffectation', compact('habilitation','infoentreprise','banque','pay',
            'id','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
            'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
            'autre_demande_habilitation_formation',
            'payList','chargerHabilitationsList',
            'domaineDemandeHabilitations',
            'NombreDemandeHabilitation',
            'motif','motifs','typeDomaineDemandeHabilitationPublicList'));
    }

    public function editaffectationExtension($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::find($id);
        $habilitation = DemandeHabilitation::find(@$autre_demande_habilitation_formation->id_demande_habilitation);

        $infoentreprise = InfosEntreprise::get_infos_entreprise($habilitation->entreprise->ncc_entreprises);

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$habilitation->banque->id_banque."'> ".mb_strtoupper($habilitation->banque->libelle_banque)." </option>";

        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }


        if($codeRoles == 'CHEFSERVICE' && $autre_demande_habilitation_formation->flag_soumis_cs==false){
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            $chargerHabilitationsList =  "<option value=''> Selectionnez le charge d\'habilitation </option>";
            foreach ($chargerHabilitations as $comp) {
                $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
            }

        }else{
            $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";
        }
        if($codeRoles == 'CHEFSERVICE'){
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            if(isset($autre_demande_habilitation_formation->chargehabilitation->id)){
                $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";

            }else{
                $chargerHabilitationsList = "<option value=''> Selectionnez le domaine de formation </option>";
                foreach ($chargerHabilitations as $comp) {
                    $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
                }
            }
            $NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',Auth::user()->id_service]])->orderBy('nbre_dossier_en_cours','asc')->get();
        }else{
            $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";
            $NombreDemandeHabilitation = [];
        }

            $motif = "<option value='".@$autre_demande_habilitation_formation->motif->id_motif."'> " . $autre_demande_habilitation_formation->motif->libelle_motif. "</option>";


                $domaine_list_demandes = DomaineDemandeHabilitation::
                where('id_demande_habilitation','=',$autre_demande_habilitation_formation->id_demande_habilitation)
                    ->where('id_autre_demande','=',$id)
                    ->where('flag_agree_domaine_demande_habilitation',false)
                    ->where('flag_extension_domaine_demande_habilitation',true)->get();


        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
            ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
            ->join('type_domaine_demande_habilitation','domaine_demande_habilitation.id_type_domaine_demande_habilitation','type_domaine_demande_habilitation.id_type_domaine_demande_habilitation')
            ->join('type_domaine_demande_habilitation_public','domaine_demande_habilitation.id_type_domaine_demande_habilitation_public','type_domaine_demande_habilitation_public.id_type_domaine_demande_habilitation_public')
            ->join('formateurs','formateur_domaine_demande_habilitation.id_formateurs','formateurs.id_formateurs')
            ->where('id_demande_habilitation','=',$autre_demande_habilitation_formation->id_demande_habilitation)
            ->where('domaine_demande_habilitation.id_autre_demande','=',$id)
            ->get();

        return view('habilitation.traitementautredemandehabilitation.editaffectationextension', compact('habilitation','infoentreprise',
            'banque','autre_demande_habilitation_formation',
            'pay','motif',
            'id','idetape',
        'domaine_list_demandes',
        'formateurs','chargerHabilitationsList','NombreDemandeHabilitation'
        ));
    }




    public function show($id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $formateur = Formateurs::find($id);
        $qualification = PrincipaleQualification::where([['id_formateurs','=',$id]])->first();

        $formations = FormationsEduc::where([['id_formateurs','=',$id]])->get();
        $experiences = Experiences::where([['id_formateurs','=',$id]])->orderBy('date_de_debut', 'DESC')->get();
        $competences = Competences::where([['id_formateurs','=',$id]])->get();
        $languesformateurs = LanguesFormateurs::where([['id_formateurs','=',$id]])->get();
        return view('habilitation.traitementautredemandehabilitation.show', compact('id','formateur','qualification',
            'formations','experiences','languesformateurs','competences'));
    }

    public function edit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        $id_combi_proc = Crypt::UrldeCrypt($id1);

        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::find($id);
        $habilitation = DemandeHabilitation::find($autre_demande_habilitation_formation->id_demande_habilitation);
        $domaineDemandeHabilitations = DomaineDemandeHabilitation::where([['id_demande_habilitation','=',$autre_demande_habilitation_formation->id_demande_habilitation]])->get();

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$habilitation->banque->id_banque."'> ".mb_strtoupper($habilitation->banque->libelle_banque)." </option>";

        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $infoentreprise = InfosEntreprise::get_infos_entreprise($habilitation->entreprise->ncc_entreprises);

        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }
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


        if($codeRoles == 'CHEFSERVICE' && $autre_demande_habilitation_formation->flag_soumis_cs==false){
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            $chargerHabilitationsList =  "<option value=''> Selectionnez le charge d\'habilitation </option>";
            foreach ($chargerHabilitations as $comp) {
                $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
            }

        }else{
            $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";

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
            ->where('v.id_processus', '=', $autre_demande_habilitation_formation->id_processus_autre_demande_habilitation_formation)
            ->where('v.id_demande', '=', $autre_demande_habilitation_formation->id_autre_demande_habilitation_formation)
            ->orderBy('v.priorite_combi_proc', 'ASC')
            ->get();


        $idUser=Auth::user()->id;
        $idAgceCon=Auth::user()->num_agce;
        $Idroles = Menu::get_id_profil($idUser);

        $parcoursexist=Parcours::where([
            ['id_processus','=',$autre_demande_habilitation_formation->id_processus_autre_demande_habilitation_formation],
            ['id_user','=',$idUser],
            ['id_piece','=',$autre_demande_habilitation_formation->id_autre_demande_habilitation_formation],
            ['id_roles','=',$Idroles],
            ['num_agce','=',$idAgceCon],
            ['id_combi_proc','=',$id_combi_proc]
        ])->get();

        return view('habilitation.traitementautredemandehabilitation.edit', compact('habilitation','infoentreprise','banque','pay',
            'id','idetape','typemoyenpermanenteList','moyenpermanentes','typeinterventionsList','interventions',
            'organisationFormationsList','organisations','domainesList','typeDomaineDemandeHabilitationList',
            'autre_demande_habilitation_formation',
            'payList','chargerHabilitationsList','parcoursexist','id_combi_proc','ResultProssesList',
            'motif','motifs','typeDomaineDemandeHabilitationPublicList','domaineDemandeHabilitations'));
    }

    public function updateaffectation(Request $request,$id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $input = $request->all();


        if($input['action']=="imputer"){
            AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                'id_processus_autre_demande_habilitation_formation' => 12,
                'id_charge_habilitation' => $input['id_charge_habilitation'],
                'commentaire_cs' => $input['commentaire_cs'],
                'date_soumis_cs_autre_demande_habilitation_formation' => Carbon::now(),
                'id_chef_service' => Auth::user()->id,
                'flag_soumis_cs' => true
            ]);
            return redirect('traitementautredemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(2).'/editaffectation')->with('success', 'Succes : Demande de suppression imputé avec succès');
        }
    }

    public function updateaffectationExtension(Request $request,$id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $input = $request->all();

        if($input['action']=="imputer"){
            AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                'id_charge_habilitation' => $input['id_charge_habilitation'],
                'commentaire_cs' => $input['commentaire_cs'],
                'date_soumis_cs_autre_demande_habilitation_formation' => Carbon::now(),
                'id_chef_service' => Auth::user()->id,
                'flag_soumis_cs' => true
            ]);
            return redirect('traitementautredemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(5).'/editaffectationExtension')->with('success', 'Succes : Demande imputé avec succès');
        }
    }

    public function update(Request $request,$id)
    {
        $id_autre_demande_habilitation_formation =  Crypt::UrldeCrypt($id);

        if(isset($id_autre_demande_habilitation_formation)){
            $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::
            Join('domaine_autre_demande_habilitation_formation',
                'domaine_autre_demande_habilitation_formation.id_autre_demande_habilitation_formation',
                'autre_demande_habilitation_formation.id_autre_demande_habilitation_formation')->

            join('domaine_demande_habilitation',
                'domaine_demande_habilitation.id_domaine_demande_habilitation',
                'domaine_autre_demande_habilitation_formation.id_domaine_demande_habilitation')->
            join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
                'domaine_demande_habilitation.id_demande_habilitation')
                ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
                ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
                ->join('agence','agence.num_agce','agence_localite.id_agence')
                ->join('localite','agence_localite.id_localite','localite.id_localite')
                ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
                ->where('autre_demande_habilitation_formation.id_autre_demande_habilitation_formation','=',@$id_autre_demande_habilitation_formation)
                ->first();

            if(isset($autre_demande_habilitation_formation)) {
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
                            'id_piece' => $id_autre_demande_habilitation_formation,
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
                            ->where('a.id_demande', '=', $id_autre_demande_habilitation_formation)
                            ->where('a.id_processus', '=', $idProcessus)
                            ->where('v.id_roles', '=', $Idroles)
                            ->groupBy('a.priorite_max', 'v.priorite_combi_proc')
                            ->first();

                        if (@$ResultCptVal->priorite_max == @$ResultCptVal->priorite_combi_proc and $ResultCptVal != null) {
                            $autre_demande_habilitation_formation_data = AutreDemandeHabilitationFormation::find($id_autre_demande_habilitation_formation);
                            $autre_demande_habilitation_formation_data->flag_autre_demande_habilitation_formation_valider_par_proce = true;
                            $autre_demande_habilitation_formation_data->flag_validation_autre_demande_habilitation_formation = true;
                            $autre_demande_habilitation_formation_data->date_valider_par_processus_autre_demande_habilitation_formation = now();
                            $autre_demande_habilitation_formation_data->commentaire_final_autre_demande_habilitation_formation = $request->input('comment_parcours');
                            $autre_demande_habilitation_formation_data->update();

                            $name = $autre_demande_habilitation_formation->raison_social_entreprises;
                            $logo = Menu::get_logo();

                            $domaine_lib = '';

                            if(isset($autre_demande_habilitation_formation->domaineAutreDemandeHabilitationFormations)){
                                foreach ($autre_demande_habilitation_formation_data->domaineAutreDemandeHabilitationFormations as $domaineAutreDemandeHabilitationFormation){
                                    $domaine_demande_domaine_supression = DomaineAutreDemandeHabilitationFormation::where('id_domaine_demande_habilitation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
                                        ->first();
                                    $domaine_demande_domaine_supression->flag_autre_demande_habilitation_formation = false;
                                    $domaine_demande_domaine_supression->update();

                                    $domaine_demande_domaine = DomaineDemandeHabilitation::where('id_domaine_demande_habilitation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
                                        ->first();
                                    $domaine_demande_domaine->flag_agree_domaine_demande_habilitation = false;
                                    $domaine_demande_domaine->update();

                                    $domaine_formation = DomaineFormationCabinet::where('id_domaine_formation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
                                        ->where('id_entreprises',$autre_demande_habilitation_formation->id_entreprises)->first();
                                    $domaine_formation->delete();

                                    $domaine_lib .= $domaine_demande_domaine->domaineFormation->libelle_domaine_formation.',';

                                }
                            }

                            $user = User::where('id_partenaire',$autre_demande_habilitation_formation->id_entreprises)->first();
                                    if (isset($user->email)) {
                                        $sujet = "Demande validé";
                                        $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                        $messageMail = "<b>Monsieur le Directeur,</b>
                                    <br><br> Nous sommes ravis de vous informer que votre demande a été validé  avec succès
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
                            return redirect('traitementautredemandehabilitation')->with('success', 'Succes : Operation validée avec succes ');

                        }
                        return redirect('traitementautredemandehabilitation/' . Crypt::UrlCrypt($id_autre_demande_habilitation_formation) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succes ');

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
                            'id_piece' => $id_autre_demande_habilitation_formation,
                            'id_roles' => $Idroles,
                            'num_agce' => $idAgceCon,
                            'comment_parcours' => $request->input('comment_parcours'),
                            'is_valide' => true,
                            'date_valide' => $dateNow,
                            'id_combi_proc' => $idProComb,
                        ]);

                            $autre_demande_habilitation_formation_data = DomaineAutreDemandeHabilitationFormation::find($id_autre_demande_habilitation_formation);
                            $autre_demande_habilitation_formation_data->flag_autre_demande_habilitation_formation_valider_par_proce = true;
                            $autre_demande_habilitation_formation_data->flag_rejeter_autre_demande_habilitation_formation = true;
                            $autre_demande_habilitation_formation_data->flag_validation_autre_demande_habilitation_formation = false;
                            $autre_demande_habilitation_formation_data->date_valider_par_processus_autre_demande_habilitation_formation = now();
                            $autre_demande_habilitation_formation_data->commentaire_final_autre_demande_habilitation_formation = $request->input('comment_parcours');
                            $autre_demande_habilitation_formation_data->update();

                            $name = $autre_demande_habilitation_formation->raison_social_entreprises;
                            $logo = Menu::get_logo();

                        $domaine_lib = '';

                        if(isset($autre_demande_habilitation_formation_data->domaineAutreDemandeHabilitationFormations)){
                            foreach ($autre_demande_habilitation_formation_data->domaineAutreDemandeHabilitationFormations as $domaineAutreDemandeHabilitationFormation){

                                $domaine_demande_domaine_supression = DomaineAutreDemandeHabilitationFormation::where('id_domaine_demande_habilitation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
                                    ->first();
                                $domaine_demande_domaine_supression->flag_autre_demande_habilitation_formation = true;
                                $domaine_demande_domaine_supression->update();


                                $domaine_demande_domaine = DomaineDemandeHabilitation::where('id_domaine_demande_habilitation',$domaineAutreDemandeHabilitationFormation->id_domaine_demande_habilitation)
                                    ->first();
                                $domaine_demande_domaine->flag_agree_domaine_demande_habilitation = true;
                                $domaine_demande_domaine->update();

                                $domaine_lib .= $domaine_demande_domaine->domaineFormation->libelle_domaine_formation.',';

                            }
                        }
//
//

                            $user = User::where('id_partenaire',$autre_demande_habilitation_formation->id_entreprises)->first();
                            if (isset($user->email)) {
                                $sujet = "Demande de suppression domaine de formation habilité";
                                $titre = "Bienvenue sur " . @$logo->mot_cle . "";

                                $messageMail = "<b>Monsieur le Directeur,</b>
                                    <br><br> Nous sommes ravis de vous informer que votre demande suppression du domaine de formation
                                     intitulé : <b>".@$autre_demande_habilitation_formation->libelle_domaine_formation.".</b> a été rejété pour la raison suivant<br>
                                     ".@$autre_demande_habilitation_formation->commentaire_final_autre_demande_habilitation_formation."
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

                        return redirect('traitementautredemandehabilitation/' . Crypt::UrlCrypt($id_autre_demande_habilitation_formation) . '/' . Crypt::UrlCrypt($id_combi_proc) . '/edit')->with('success', 'Succes : Operation validée avec succes ');

                    }

                }
            }
        }
    }


    public function extensiondomaineformation()
    {
        $user = Auth::user();

//        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::
//        join('demande_habilitation', 'demande_habilitation.id_demande_habilitation',
//            'autre_demande_habilitation_formation.id_demande_habilitation')
//            ->join('entreprises','entreprises.id_entreprises','demande_habilitation.id_entreprises')
//            ->join('agence_localite','entreprises.id_localite_entreprises','agence_localite.id_localite')
//            ->join('agence','agence.num_agce','agence_localite.id_agence')
//            ->where('autre_demande_habilitation_formation.flag_soumis_autre_demande_habilitation_formation','=',true)
//            ->join('localite','agence_localite.id_localite','localite.id_localite')
//            ->where('id_agence','=',@$user->num_agce)
//            ->where('autre_demande_habilitation_formation.type_autre_demande','=','demande_extension')
//            ->where('autre_demande_habilitation_formation.id_charge_habilitation',$user->id)
//            ->where('autre_demande_habilitation_formation.flag_instruction',false)
//            ->get();
//
//        dd($autre_demande_habilitation_formation);

            return view('habilitation.traitementautredemandehabilitation.traitementautredemandehabilitation',compact('autre_demande_habilitation_formation'));
    }

    public function extensiondomaineEdit($id, $id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);

        $codeRoles = Menu::get_code_menu_profil(Auth::user()->id);
        $autre_demande_habilitation_formation = AutreDemandeHabilitationFormation::
        where('id_autre_demande_habilitation_formation',$id)
        ->where('flag_instruction',false)->first();
        $habilitation = DemandeHabilitation::where('id_demande_habilitation',$autre_demande_habilitation_formation->id_demande_habilitation)->first();
        $infoentreprise = InfosEntreprise::get_infos_entreprise($habilitation->entreprise->ncc_entreprises);

        $banques = Banque::where([['flag_banque','=',true]])->get();
        $banque = "<option value='".$habilitation->banque->id_banque."'> ".mb_strtoupper($habilitation->banque->libelle_banque)." </option>";

        foreach ($banques as $comp) {
            $banque .= "<option value='" . $comp->id_banque  . "'>" . mb_strtoupper($comp->libelle_banque) ." </option>";
        }

        $pays = Pays::all();
        $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
        foreach ($pays as $comp) {
            $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
        }


        if($codeRoles == 'CHEFSERVICE' && $autre_demande_habilitation_formation->flag_soumis_cs==false){
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            $chargerHabilitationsList =  "<option value=''> Selectionnez le charge d\'habilitation </option>";
            foreach ($chargerHabilitations as $comp) {
                $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
            }

        }else{
            $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";
        }
        if($codeRoles == 'CHEFSERVICE'){
            $chargerHabilitations = DB::table('vue_users_chargehabilitation')->where([['id_service','=',Auth::user()->id_service]])->get();
            if(isset($demande_extension->chargehabilitation->id)){
                $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";

            }else{
                $chargerHabilitationsList = "<option value=''> Selectionnez le domaine de formation </option>";
                foreach ($chargerHabilitations as $comp) {
                    $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
                }
            }
            $NombreDemandeHabilitation = DB::table('vue_nombre_traitement_demande_habilitation')->where([['id_service','=',Auth::user()->id_service]])->orderBy('nbre_dossier_en_cours','asc')->get();
        }else{
            $chargerHabilitationsList = "<option value='".$autre_demande_habilitation_formation->chargehabilitation->id."'> " . @$autre_demande_habilitation_formation->chargehabilitation->name.' '. mb_strtoupper(@$autre_demande_habilitation_formation->chargehabilitation->prenom_users) . "</option>";
            $NombreDemandeHabilitation = [];
        }

        $motif = "<option value='".@$autre_demande_habilitation_formation->motif->id_motif."'> " . $autre_demande_habilitation_formation->motif->libelle_motif. "</option>";

        $motifs = Motif::where([['code_motif','=','RDE']])->get();
        $motif_recevabilite = "<option value=''> Selectionnez un motif </option>";
        foreach ($motifs as $comp) {
            $motif_recevabilite .= "<option value='" . $comp->id_motif  . "'>" . $comp->libelle_motif ." </option>";
        }

        $commentairenonrecevables = CommentaireNonRecevableDemande::where([['id_demande','=',$id],['code_demande','=','RDE']])->get();


        $domaine_list_demandes = DomaineDemandeHabilitation::
        where('id_demande_habilitation','=',$autre_demande_habilitation_formation->id_demande_habilitation)
            ->where('id_autre_demande','=',$id)
            ->where('flag_agree_domaine_demande_habilitation',false)
            ->where('flag_extension_domaine_demande_habilitation',true)->get();

        $formateurs = FormateurDomaineDemandeHabilitation::Join('domaine_demande_habilitation','formateur_domaine_demande_habilitation.id_domaine_demande_habilitation','domaine_demande_habilitation.id_domaine_demande_habilitation')
            ->join('domaine_formation','domaine_demande_habilitation.id_domaine_formation','domaine_formation.id_domaine_formation')
            ->join('type_domaine_demande_habilitation','domaine_demande_habilitation.id_type_domaine_demande_habilitation','type_domaine_demande_habilitation.id_type_domaine_demande_habilitation')
            ->join('type_domaine_demande_habilitation_public','domaine_demande_habilitation.id_type_domaine_demande_habilitation_public','type_domaine_demande_habilitation_public.id_type_domaine_demande_habilitation_public')
            ->join('formateurs','formateur_domaine_demande_habilitation.id_formateurs','formateurs.id_formateurs')
            ->where('id_demande_habilitation','=',$autre_demande_habilitation_formation->id_demande_habilitation)
            ->where('domaine_demande_habilitation.id_autre_demande','=',$id)
            ->get();

        return view('habilitation.traitementautredemandehabilitation.extensiondomaineEdit', compact('habilitation','infoentreprise',
            'banque','autre_demande_habilitation_formation',
            'pay','motif','commentairenonrecevables',
            'id','idetape','motif_recevabilite',
            'domaine_list_demandes',
            'formateurs','chargerHabilitationsList','NombreDemandeHabilitation'
        ));
    }

    public function updateExtension(Request $request,$id)
    {
        $id =  Crypt::UrldeCrypt($id);
        $input = $request->all();

        if($input['action']=="Recevable"){
            AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                'commentaire_recevabilite' => $input['commentaire_recevabilite'],
                'flag_recevabilite' => true,
                'date_recevabilite' => Carbon::now()
            ]);
            return redirect('traitementautredemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(5).'/editExtension')->with('success', 'Succes : Recevabilité effectuée avec succès');
        }

//        if(['action']==""){
//
//            return redirect('traitementautredemandehabilitation/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(5).'/edit')->with('success', 'Succes : Recevabilité effectuée avec succès');
//        }

        if($input['action'] === 'NonRecevable'){

            $this->validate($request, [
                'id_motif_recevable' => 'required',
                'commentaire_recevabilite' => 'required',
            ],[
                'id_motif_recevable.required' => 'Veuillez selectionner le motif de recevabilité.',
                'commentaire_recevabilite.required' => 'Veuillez ajouter le commentaire de la non recevaibilité.',
            ]);

            $input = $request->all();

            $commentaire = CommentaireNonRecevableDemande::create([
                'commentaire_commentaire_non_recevable_demande' => $input['commentaire_recevabilite'],
                'id_demande' => $id,
                'id_motif_recevable' => $input['id_motif_recevable'],
                'code_demande' => 'RDE'
            ]);


            AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                'commentaire_recevabilite' => $input['commentaire_recevabilite'],
                'flag_recevabilite' => false,
                'flag_rejeter_recevabilit_suppression_habilitation'=>true,
                'flag_soumis_autre_demande_habilitation_formation'=>false,
                'date_rejeter_autre_demande_habilitation_formation' => Carbon::now()
            ]);

            $demande  = AutreDemandeHabilitationFormation::find($id);

            $habilitation = DemandeHabilitation::find($demande->id_demande_habilitation);

            $infoentreprise = Entreprises::find($habilitation->id_entreprises);
            $logo = Menu::get_logo();

            if (isset($habilitation->email_responsable_habilitation)) {
                $sujet = "Recevabilité de la demande habilitation sur e-FDFP";
                $titre = "Bienvenue sur ".@$logo->mot_cle ."";
                $messageMail = "<b>Cher,  ".$infoentreprise->raison_social_entreprises." ,</b>

                                    <br><br>Nous avons examiné votre demande d'extension de domaine sur e-FDFP, et
                                    malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :

                                    <br><b>Motif de rejet  : </b> ".@$habilitation->motif->libelle_motif."
                                    <br><b>Commentaire : </b> ".@$habilitation->commentaire_recevabilite."
                                    <br><br>
                                    <br><br>Si vous estimez que cela est une erreur ou si vous avez des informations supplémentaires à
                                        fournir, n'hésitez pas à contactez votre chargé habilitation : ".@$habilitation->userchargerhabilitation->email." pour obtenir de l'aide.
                                        Nous apprécions votre intérêt pour notre service et espérons que vous envisagerez de
                                        soumettre la demande lorsque les problèmes seront résolus.
                                        Cordialement,
                                        L'équipe e-FDFP
                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                $messageMailEnvoi = Email::get_envoimailTemplate($habilitation->email_responsable_habilitation, $infoentreprise->raison_social_entreprises, $messageMail, $sujet, $titre);

            }

            //Envoi SMS Rejeté
            if (isset($habilitation->contact_responsable_habilitation)) {
                $content = "Cher ".$infoentreprise->sigl_entreprises.", Nous avons examiné votre demande  et malheureusement, nous ne pouvons pas l'approuver pour la raison suivante :".@$habilitation->motif->libelle_motif." Veuillez mettre a jour le dossier .
                        Cordialement,
                        L'équipe e-FDFP";
                SmsPerso::sendSMS($habilitation->contact_responsable_habilitation,$content);
            }

            Audit::logSave([

                'action'=>'MISE A JOUR',

                'code_piece'=>$id,

                'menu'=>'HABILITATION (Instruction: La non-recevabilité a été effectué avec succès.)',

                'etat'=>'Succès',

                'objet'=>'HABILITATION'

            ]);

            return redirect()->route('traitementautredemandehabilitation.index')->with('success', 'Recevabilité effectué avec succès.');

        }

        if($input['action']=="instruction"){
            AutreDemandeHabilitationFormation::where('id_autre_demande_habilitation_formation',$id)->update([
                'observation_instruction' => $input['observation_instruction'],
                'flag_instruction' => true,
                'date_instruction' => Carbon::now()
            ]);
            return redirect('traitementautredemandehabilitation')->with('success', 'Succes : Instruction effectuée avec succès');
        }
    }

}
