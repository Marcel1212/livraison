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
}
