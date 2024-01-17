<?php

namespace App\Helpers;

use App\Helpers\Menu;
use Mailjet\Resources;
use vendor\mailjet\src;

use Illuminate\Support\Facades\Mail;

class Email
{

    public static function get_envoimailTemplate($email, $nom, $messages, $sujet, $titre)
    {

    $logo = Menu::get_logo();
        $mj = new \Mailjet\Client('7dc4af46283edf2041789a900b84e944', 'edba2b424ea9dc18e325802f0e5ff93a', true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "traoremohamed2g@gmail.com",
                        'Name' => @$logo->mot_cle
                    ],
                    'To' => [
                        [
                            'Email' => $email,
                            'Name' => $nom
                        ]
                    ],
                    'Variables' => [
                        "titre" => $titre,
                        "message" => $messages,
                    ],
                    'TemplateID' => 4485492,
                    'TemplateLanguage' => true,
                    'Subject' => $sujet,

                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
//        $response->success() && var_dump($response->getData());
//        $response->success() && var_dump($response->getData());
        return $response;
    }
}
