<?php


namespace App\Helpers;

use App\Models\Experiences;
use App\Models\NombreAnneeExperience;
use Carbon\Carbon;
use DB;

class Fonction
{
    public static function calculerDureeExperience($date_de_debut, $date_de_fin = null) {
            // Date de début
            $dateDebut = Carbon::parse($date_de_debut);

            // Si date de fin est présente, sinon on prend la date actuelle
            $dateFin = $date_de_fin ? Carbon::parse($date_de_fin) : Carbon::now();

            // Calcul de la différence en années, mois, jours, etc.
            $duree = $dateDebut->diff($dateFin);

        return $duree;
    }

    // public static function calculerAnneesExperience($id_formateur) {

    //     $experience = Experiences::where('id_formateurs', $id_formateur)
    //                 ->groupBy('id_formateurs')
    //                 ->selectRaw('MIN(date_de_debut) as date_debut, id_formateurs')
    //                 ->first();

    //     // Parse la date de début
    //     $dateDebut = Carbon::parse($experience->date_debut);

    //     // Si la date de fin est nulle, utilise la date actuelle
    //     $dateFin =  Carbon::now();

    //     // Calcule la différence en années entre les deux dates
    //     //$anneesExperience = $dateDebut->diffInYears($dateFin);
    //     $duree = $dateDebut->diff($dateFin);

    //     if($duree->y > 0 and $duree->m > 0){
    //         $anneesExperience = $duree->y + "ans" + $duree->m + "mois";
    //     }elseif ($duree->y > 0) {
    //         $anneesExperience = $duree->y + "ans";
    //     }elseif ($duree->m > 0) {
    //         $anneesExperience = $duree->m + "mois";
    //     }else{
    //         $anneesExperience =0;
    //     }

    //     return $anneesExperience;
    // }

    public static function calculerAnneesExperience($id_formateur) {
        // Récupération de la date de début d'expérience
        $experience = Experiences::where('id_formateurs', $id_formateur)
                    ->groupBy('id_formateurs')
                    ->selectRaw('MIN(date_de_debut) as date_debut, id_formateurs')
                    ->first();

        // Vérification si la date de début existe
        if (!$experience || !$experience->date_debut) {
            return '0 ans';
        }

        // Calcul de la différence de date
        $dateDebut = Carbon::parse($experience->date_debut);
        $dateFin = Carbon::now();
        $duree = $dateDebut->diff($dateFin);

        // Construction de la chaîne en fonction de la durée
        if ($duree->y > 0 && $duree->m > 0) {
            $anneesExperience = $duree->y . ' ans ' . $duree->m . ' mois';
        } elseif ($duree->y > 0) {
            $anneesExperience = $duree->y . ' ans';
        } elseif ($duree->m > 0) {
            $anneesExperience = $duree->m . ' mois';
        } else {
            $anneesExperience = 'moins d\'un mois';
        }

        return $anneesExperience;
    }


    public static function calculerAnneesExperience5ans($id_formateur) {

        $experience = Experiences::join('type_emploie','experiences.id_type_emploie','type_emploie.id_type_emploie')
                    ->where([['id_formateurs', $id_formateur],['type_emploie.code_type_emploie','!=','Stage']])
                    ->groupBy('id_formateurs')
                    ->selectRaw('MIN(date_de_debut) as date_debut, id_formateurs')
                    ->first();

                    // Experiences::where('id_formateurs', $id_formateur)
                    // ->join('type_emploie','experiences.id_type_emploie','type_emploie.id_type_emploie')
                    // ->groupBy('id_formateurs')
                    // ->selectRaw('MIN(date_de_debut) as date_debut, id_formateurs')
                    // ->where([])
                    // ->first();
        // Parse la date de début
        $dateDebut = Carbon::parse(@$experience->date_debut);

        // Si la date de fin est nulle, utilise la date actuelle
        $dateFin =  Carbon::now();

        // Calcule la différence en années entre les deux dates
        $anneesExperience = $dateDebut->diffInYears($dateFin);

        $nombreexper = NombreAnneeExperience::where([['flag_nombre_annee_experience','=',true]])->first();

        $nbre = $nombreexper->libelle_nombre_annee_experience;

        if ($anneesExperience < $nbre ) {
            $reponse = 120;
        }else {
            $reponse = 300;
        }

        return $reponse;
    }

    public static function listedesformateurayant5ansExp($id_entreprise) {
        $experiences = DB::table('experiences as e')
            ->selectRaw('MIN(e.date_de_debut) as date_debut, e.id_formateurs, f.nom_formateurs, f.prenom_formateurs, f.fonction_formateurs, f.id_entreprises')
            ->join('type_emploie as te', 'e.id_type_emploie', '=', 'te.id_type_emploie')
            ->join('formateurs as f', 'f.id_formateurs', '=', 'e.id_formateurs')
            ->where([['te.code_type_emploie', '!=', 'Stage'], ['f.id_entreprises', '=', $id_entreprise]])
            ->groupBy('e.id_formateurs', 'f.nom_formateurs', 'f.prenom_formateurs', 'f.fonction_formateurs', 'f.id_entreprises')
            ->get();

        $nombreexper = NombreAnneeExperience::where('flag_nombre_annee_experience', true)->first();
        $nbre = $nombreexper->libelle_nombre_annee_experience;

        $reponse = [];
        foreach ($experiences as $experience) {
            if (!is_null($experience->date_debut)) {
                $dateDebut = Carbon::parse($experience->date_debut);
                $dateFin = Carbon::now();
                $anneesExperience = $dateDebut->diffInYears($dateFin);

                if ($anneesExperience >= $nbre) {
                    $reponse[] = $experience; // Ajout dans le tableau des réponses
                }
            }
        }

        return $reponse; // Retourne toutes les réponses
    }

}
