<?php


namespace App\Helpers;

use App\Models\BeneficiairesFormation;
use App\Models\DemandeHabilitation;
use App\Models\FicheAgrementButFormation;
use App\Models\PlanFormation;
use App\Models\Livraison;
use App\Models\SecteurActiviteUserConseiller;
use Illuminate\Support\Facades\DB;

class ListeDemandeHabilitationSoumis
{
    public static function get_liste_demande_habilitation_soumis($numAgce)
    {
        $demandehabilitations = DB::table('vue_demande_habilitation_soumis')->where([['id_agence','=',$numAgce]])->get();

        return (isset($demandehabilitations) ? $demandehabilitations : '');
    }
    //

    public static function get_livraisons()
    {
        //$demandehabilitations = DB::table('livraison')->where([['flag_valide','=',true],['flag_a_traite','=',false]])->get();
        $demandehabilitations = Livraison::where([['flag_valide','=',true],['flag_a_traite','=',false]])->get();

        return (isset($demandehabilitations) ? $demandehabilitations : '');
    }

    public static function get_livraisons_livreur($idlivreur)
    {
        //$demandehabilitations = DB::table('livraison')->where([['flag_valide','=',true],['flag_a_traite','=',false]])->get();
        $demandehabilitations = Livraison::where([['id_livreur','=',$idlivreur],['flag_livre','=',false],['flag_echec','=',false]])->get();

        return (isset($demandehabilitations) ? $demandehabilitations : '');
    }

    public static function get_liste_demande_habilitation_soumis_charge_habilitation($IdUser)
    {
        $demandehabilitations = DemandeHabilitation::where([['id_charge_habilitation','=',$IdUser],['flag_reception_demande_habilitation','=',false]])->get();

        return (isset($demandehabilitations) ? $demandehabilitations : '');
    }
    public static function get_liste_demande_habilitation_soumis_nouvelle_demande($numAgce)
    {
        $demandehabilitations = DB::table('vue_demande_habilitation_soumis')->where([['id_agence','=',$numAgce],['type_demande','=','NOUVELLE DEMANDE']])->get();

        return (isset($demandehabilitations) ? $demandehabilitations : '');
    }

    public static function get_liste_demande_habilitation_soumis_nouvelle_demande_charger_H($IdUser)
    {
        $demandehabilitations = DemandeHabilitation::where([['id_charge_habilitation','=',$IdUser],['type_demande','=','NOUVELLE DEMANDE'],['flag_reception_demande_habilitation','=',false],['flag_soumis_charge_habilitation','=',true]])->get();

        return (isset($demandehabilitations) ? $demandehabilitations : '');
    }

    public static function get_vue_nombre_de_domaine_sollicite_formateur($IdDemande)
    {
        $demandehabilitations = DB::table('vue_nombre_de_domaine_sollicite_formateur')->where([['id_demande_habilitation','=',$IdDemande]])->get();

        return (isset($demandehabilitations) ? $demandehabilitations : '');
    }

    public static function get_vue_nombre_de_domaine_sollicite($IdDemande)
    {
        $demandehabilitations = DB::table('vue_nombre_de_domaine_sollicite')->where([['id_demande_habilitation','=',$IdDemande]])->get();

        return (isset($demandehabilitations) ? $demandehabilitations : '');
    }

}
