<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Crypt
{

    public static function UrlCrypt($identifiant)
    {
        if ($identifiant != '') {
            $elt = '';
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $elt = $randomString . base64_encode($identifiant);

            return $elt;

        } else return "";
    }

    public static function UrldeCrypt($identifiant)
    {
        if ($identifiant != '') {
            $eltdecrypt = substr($identifiant, 4);
            return base64_decode($eltdecrypt);
        } else return "";
    }


    public static function MotDePasse()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $pass = $randomString;
        return $pass;
    }

    public static function VerifierMotDePasse($motDePasse)
    {
            // Vérifier la longueur du mot de passe
            if (strlen($motDePasse) < 8) {
                return "Le mot de passe doit contenir au moins 8 caractères.";
            }

            // Vérifier la présence de chiffres
            if (!preg_match("/[0-9]/", $motDePasse)) {
                return "Le mot de passe doit contenir au moins un chiffre.";
            }

            // Vérifier la présence de lettres majuscules et minuscules
            if (!preg_match("/[a-z]/", $motDePasse) || !preg_match("/[A-Z]/", $motDePasse)) {
                return "Le mot de passe doit contenir des lettres majuscules et minuscules.";
            }

            // Vérifier la présence de caractères spéciaux
            if (!preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $motDePasse)) {
                return "Le mot de passe doit contenir au moins un caractère spécial.";
            }

            // Si toutes les vérifications passent, le mot de passe est valide
            return "mot de passe correcte";
    }
}
