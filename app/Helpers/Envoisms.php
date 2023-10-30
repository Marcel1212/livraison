<?php


namespace App\Helpers;

class Envoisms
{

    public static function get_envoisms($contact, $message)
    {

        $guzzleClient = new \GuzzleHttp\Client([
            "curl" => [CURLOPT_SSL_VERIFYPEER => false],
            'base_uri' => 'https://mmg3.symtel.biz:8443',
        ]);
        $response = $guzzleClient->get('AMMG/SymtelMMG', [
            'query' => [
                'username' => 'ldf2017',
                'password' => 'Gl7102@!',
                'from' => 'VictoireIMO',
                'to' => $contact,
                'dlrmask' => 31,
                'text' => '' . $message . '',
            ]
        ]);
        $response = json_decode($response->getBody()->getContents(), true);

        return (isset($response) ? $response : '');
    }

    public static function get_envoismsCom($contact, $message)
    {

        $guzzleClient = new \GuzzleHttp\Client([
            "curl" => [CURLOPT_SSL_VERIFYPEER => false],
            'base_uri' => 'https://mmg3.symtel.biz:8443',
        ]);
        $response = $guzzleClient->get('AMMG/SymtelMMG', [
            'query' => [
                'username' => 'ldf2017',
                'password' => 'Gl7102@!',
                'from' => 'VictoireIMO',
                'to' => $contact,
                'dlrmask' => 31,
                'text' => '' . $message . '',
            ]
        ]);
        $response = json_decode($response->getBody()->getContents(), true);

        return (isset($response) ? $response : '');
    }


}
