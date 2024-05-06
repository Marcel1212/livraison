<?php

namespace App\Http\Controllers\ProjetEtude;

use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Helpers\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemandeAnnulationSauvegarderRequest;
use App\Http\Requests\DemandeSubstitutionSauvegarderRequest;
use App\Models\ActionFormationPlan;
use App\Models\BeneficiairesFormation;
use App\Models\ButFormation;
use App\Models\CategoriePlan;
use App\Models\CategorieProfessionelle;
use App\Models\DemandeAnnulationPlan;
use App\Models\DemandeSubstitutionActionPlanFormation;
use App\Models\Entreprises;
use App\Models\FicheADemandeAgrement;
use App\Models\Motif;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\PlanFormation;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\TypeEntreprise;
use App\Models\TypeFormation;
use App\Models\User;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
use Rap2hpoutre\FastExcel\FastExcel;

class AgreementProjetEtudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Menu::get_code_menu_profil(Auth::user()->id);
        $agreements = DB::table('fiche_agrement')
            ->select(['projet_etude.*','entreprises.raison_social_entreprises','entreprises.ncc_entreprises','users.name','users.prenom_users','fiche_agrement.created_at as date_valide_agrreement'])
            ->leftjoin('comite_gestion','fiche_agrement.id_comite_gestion','comite_gestion.id_comite_gestion')
            ->leftjoin('comite_permanente','fiche_agrement.id_comite_permanente','comite_permanente.id_comite_permanente')
            ->join('projet_etude','fiche_agrement.id_demande','projet_etude.id_projet_etude')
            ->join('entreprises','projet_etude.id_entreprises','entreprises.id_entreprises')
            ->join('users','projet_etude.id_charge_etude','users.id')
            ->where('fiche_agrement.code_fiche_agrement','PE')
            ->where('projet_etude.flag_fiche_agrement',true)
            ->orderBy('created_at', 'desc');

        if ($role== 'ENTREPRISE'){
            $agreements = $agreements->where('projet_etude.id_entreprises',Auth::user()->id_partenaire);
        }
        $agreements = $agreements->get();
        return view('projetetudes.agreementprojetetude.index', compact('agreements'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::UrldeCrypt($id);
        $role = Menu::get_code_menu_profil(Auth::user()->id);
        $agreement = DB::table('fiche_agrement')
            ->select(['projet_etude.*','operateur.raison_social_entreprises as op_raison_social_entreprises','entreprises.raison_social_entreprises','users.name','users.prenom_users','fiche_agrement.created_at as date_valide_agrreement'])
            ->leftjoin('comite_gestion','fiche_agrement.id_comite_gestion','comite_gestion.id_comite_gestion')
            ->leftjoin('comite_permanente','fiche_agrement.id_comite_permanente','comite_permanente.id_comite_permanente')
            ->join('projet_etude','fiche_agrement.id_demande','projet_etude.id_projet_etude')
            ->join('entreprises','projet_etude.id_entreprises','entreprises.id_entreprises')
            ->leftjoin('entreprises as operateur','projet_etude.id_operateur_selection','operateur.id_entreprises')
            ->join('users','projet_etude.id_charge_etude','users.id')
            ->where('projet_etude.flag_fiche_agrement',true)
            ->where('fiche_agrement.code_fiche_agrement','PE')
            ->where('projet_etude.id_projet_etude', $id);
                if ($role== 'ENTREPRISE'){
                    $agreement = $agreement->where('projet_etude.id_entreprises',Auth::user()->id_partenaire);
                }


        $agreement = $agreement->first();


        $projet_etude = ProjetEtude::where('id_projet_etude', $id)
            ->first();
        $infosentreprise = Entreprises::find($projet_etude->id_entreprises);

        return view('projetetudes.agreementprojetetude.show', compact('agreement','infosentreprise'));
    }


}
