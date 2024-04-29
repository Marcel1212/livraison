<?php


namespace App\Helpers;

use App\Models\PeriodeExercice;
use App\Models\TraitementParCritere;
use App\Models\TraitementParCriterePrf;
use App\Models\TraitementParCriterePrfCoord;
use App\Models\TypeComite;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListeTraitementCritereParUser
{
    public static function get_traitement_crietere_par_user($iduser,$idaction)
    {
        $traitement = TraitementParCritere::where([['traitement_par_critere.id_user_traitement_par_critere','=',$iduser],['traitement_par_critere.id_action_formation_plan','=',$idaction]])->get();

        if (count($traitement)>=1) {
            $res = '<span class="badge bg-success">Traité</span>';
        }else{
            $res = '<span class="badge bg-warning">Non traité</span>';
        }

        return (isset($res) ? $res : '<span class="badge bg-warning">Non traiter</span>');
    }


    public static function get_traitement_crietere_tout_commentaire_user($idaction)
    {
        $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','traitement_par_critere_commentaire.created_at as datej','critere_evaluation.*','users.name as name','users.prenom_users as prenom_users','roles.name as profil')
                            ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
                            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', 'roles.id')
                            ->where([['flag_demission_users', '=', false],
                                    ['flag_admin_users', '=', false],
                                    ['roles.id', '!=', 15]])
                            ->where([['traitement_par_critere.id_action_formation_plan','=',$idaction]])->get();



        return (isset($traitement) ? $traitement : '');
    }

    public static function get_traitement_crietere_tout_commentaire_user_statut_total($idaction)
    {
        $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','critere_evaluation.*')
                            ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->where([['traitement_par_critere.id_action_formation_plan','=',$idaction]])->get();

        return (isset($traitement) ? $traitement : '');
    }

    public static function get_traitement_crietere_tout_commentaire_user_statut_echec($idaction)
    {
        $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','critere_evaluation.*')
                            ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->where([['traitement_par_critere.id_action_formation_plan','=',$idaction],
                            ['traitement_par_critere_commentaire.flag_traitement_par_critere_commentaire','=',false]
                            ])->get();

        return (isset($traitement) ? $traitement : '');
    }
    public static function get_traitement_crietere_tout_commentaire_user_statut_success($idaction)
    {
        $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','critere_evaluation.*')
                            ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->where([['traitement_par_critere.id_action_formation_plan','=',$idaction],
                            ['traitement_par_critere_commentaire.flag_traitement_par_critere_commentaire','=',true]])->get();

        return (isset($traitement) ? $traitement : '');
    }

    public static function get_traitement_crietere_tout_commentaire_user_statut_echec_traiter($idaction)
    {
        $traitement = TraitementParCritere::select('traitement_par_critere_commentaire.*','critere_evaluation.*')
                            ->join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->where([['traitement_par_critere.id_action_formation_plan','=',$idaction],
                            ['traitement_par_critere_commentaire.flag_traitement_par_critere_commentaire','=',false],
                            ['traitement_par_critere_commentaire.flag_traite_par_user_conserne','=',true]])->get();

        return (isset($traitement) ? $traitement : '');
    }
    // Projet Formatioon
    public static function get_traitement_crietere_tout_commentaire_user_prf($idaction)
    {
        $traitement = TraitementParCriterePrf::select('traitement_par_critere_commentaire_prf.*','critere_evaluation.*','users.*','roles.name as profil')
                            ->join('traitement_par_critere_commentaire_prf','traitement_par_critere_prf.id_traitement_par_critere','traitement_par_critere_commentaire_prf.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere_prf.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->join('users','traitement_par_critere_commentaire_prf.id_user_traitement_par_critere_commentaire','users.id')
                            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', 'roles.id')
                            ->where([['flag_demission_users', '=', false],
                                    ['flag_admin_users', '=', false],
                                    ['roles.id', '!=', 15]])
                            ->where([['traitement_par_critere_prf.id_projet_formation','=',$idaction]])->get();


        //dd($traitement);
        return (isset($traitement) ? $traitement : '');
    }

    public static function get_traitement_crietere_tout_commentaire_user_prf_coord($idaction)
    {
        $traitement = TraitementParCriterePrfCoord::select('traitement_par_critere_commentaire_prf_coord.*','critere_evaluation.*','users.*','roles.name as profil')
                            ->join('traitement_par_critere_commentaire_prf_coord','traitement_par_critere_prf_coord.id_traitement_par_critere','traitement_par_critere_commentaire_prf_coord.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere_prf_coord.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->join('users','traitement_par_critere_commentaire_prf_coord.id_user_traitement_par_critere_commentaire','users.id')
                            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                            ->join('roles', 'model_has_roles.role_id', 'roles.id')
                            ->where([['flag_demission_users', '=', false],
                                    ['flag_admin_users', '=', false],
                                    ['roles.id', '!=', 15]])
                            ->where([['traitement_par_critere_prf_coord.id_projet_formation','=',$idaction]])->get();


        //dd($traitement);
        return (isset($traitement) ? $traitement : '');
    }

    // Projet formation ( count commentaires )
    public static function get_traitement_crietere_par_commentaire_user_prf($iduser,$idaction)
    {
        $traitement = TraitementParCriterePrf::Join('traitement_par_critere_commentaire_prf','traitement_par_critere_prf.id_traitement_par_critere','traitement_par_critere_commentaire_prf.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere_prf.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->join('users','traitement_par_critere_commentaire_prf.id_user_traitement_par_critere_commentaire','users.id')
                            ->where([['traitement_par_critere_commentaire_prf.id_user_traitement_par_critere_commentaire','=',$iduser],['traitement_par_critere_prf.id_projet_formation','=',$idaction]])->get();



        return (isset($traitement) ? $traitement : '');
    }
    public static function get_traitement_crietere_par_commentaire_user_prf_coord($iduser,$idaction)
    {
        $traitement = TraitementParCriterePrfCoord::Join('traitement_par_critere_commentaire_prf_coord','traitement_par_critere_prf_coord.id_traitement_par_critere','traitement_par_critere_commentaire_prf_coord.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere_prf_coord.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->join('users','traitement_par_critere_commentaire_prf_coord.id_user_traitement_par_critere_commentaire','users.id')
                            ->where([['traitement_par_critere_commentaire_prf_coord.id_user_traitement_par_critere_commentaire','=',$iduser],['traitement_par_critere_prf_coord.id_projet_formation','=',$idaction]])->get();



        return (isset($traitement) ? $traitement : '');
    }



    public static function get_traitement_crietere_par_commentaire_user($iduser,$idaction)
    {
        $traitement = TraitementParCritere::Join('traitement_par_critere_commentaire','traitement_par_critere.id_traitement_par_critere','traitement_par_critere_commentaire.id_traitement_par_critere')
                            ->join('critere_evaluation','traitement_par_critere.id_critere_evaluation','critere_evaluation.id_critere_evaluation')
                            ->join('users','traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','users.id')
                            ->where([['traitement_par_critere_commentaire.id_user_traitement_par_critere_commentaire','=',$iduser],['traitement_par_critere.id_action_formation_plan','=',$idaction]])->get();



        return (isset($traitement) ? $traitement : '');
    }

}
