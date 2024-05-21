<?php

namespace App\Helpers;

class SmsPerso
{
    public static function sendSMS($tel,$content)
    {
        $client = new \GuzzleHttp\Client();
        $url = "https://www.symtel.biz/fr/index.php?mod=cgibin&page=2";
        $user = "dao.adama@vbs.ci";
        $code = "0a8fedfe2b9417cb679763c948489a0b";
        $title = 'FDFP';
        $phone = '+225'.$tel;
        try {
            $request = $client->request('POST',$url,
                [
                    'form_params' => [
                        'user'=>$user,
                        'code'=>$code,
                        'title'=>$title,
                        'phone'=>$phone,
                        'content'=>$content
                    ]
                ]
            );
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public static function sendSMSBarnoin($tel,$content)
    {
        $client = new \GuzzleHttp\Client();
        $url = "https://www.symtel.biz/fr/index.php?mod=cgibin&page=2";
        $user = "GS8473";
        $code = "3d25d9d1aa862e2d8e57bdabfbda7901";
        $title = 'FDFP';
        $phone = '+225'.$tel;
        try {
            $request = $client->request('POST',$url,
                [
                    'form_params' => [
                        'user'=>$user,
                        'code'=>$code,
                        'title'=>$title,
                        'phone'=>$phone,
                        'content'=>$content
                    ]
                ]
            );
            Audit::logSave([
                'action'=>'ENVOI OTP',
                'code_piece'=>'',
                'menu'=>'TENTATIVE D\'ENVOI OTP REPONSE API'.$response = $request->getBody()->getContents(),
                'etat'=>'Info',
                'objet'=>'REINITIALISATION MOT DE PASSE'

            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }

}
