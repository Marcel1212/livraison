<?php

namespace App\Helpers;

use App\Helpers\Menu;
use Mailjet\Resources;
use PhpParser\Node\Expr\Array_;
use vendor\mailjet\src;

use Illuminate\Support\Facades\Mail;

class Email
{

    public static function get_envoimailTemplate($email, $nom, $messages, $sujet, $titre)
    {
        $data = [
            'nom' => $nom,
            'messages' => $messages,
            'sujet' => $sujet,
            'titre' => $titre,
        ];
        Mail::to($email)->send(new \App\Mail\SendMail($data));
    }
}
