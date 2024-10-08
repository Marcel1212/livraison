<?php


namespace App\Helpers;

use App\Models\Experiences;
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

    public static function calculerAnneesExperience($id_formateur) {

        $experience = Experiences::where('id_formateurs', $id_formateur)
                    ->groupBy('id_formateurs')
                    ->selectRaw('MIN(date_de_debut) as date_debut, id_formateurs')
                    ->first();

        // Parse la date de début
        $dateDebut = Carbon::parse($experience->date_debut);

        // Si la date de fin est nulle, utilise la date actuelle
        $dateFin =  Carbon::now();

        // Calcule la différence en années entre les deux dates
        $anneesExperience = $dateDebut->diffInYears($dateFin);

        return $anneesExperience;
    }
}
