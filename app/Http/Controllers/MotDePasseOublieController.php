<?php

namespace App\Http\Controllers;

use App\Helpers\Crypt;
use App\Helpers\Email;
use App\Helpers\Menu;
use App\Http\Requests\MotDePasseOubieRequest;
use App\Models\Entreprises;
use App\Models\MotDePasseOublie;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MotDePasseOublieController extends Controller
{
    //
    public function index()
    {
        return view('motdepasseoublie.index');
    }

    public function verify(MotDePasseOubieRequest $request)
    {
        $now = Carbon::now();
                $mot_de_passe_trouv = MotDePasseOublie::where('email_mot_de_passe_oublie',$request->email_mot_de_passe_oublie)
                    ->where('flag_expired_mot_de_passe_oublie',false)->first();
                if(isset($mot_de_passe_trouv)){
//                    if($now->isAfter($mot_de_passe_trouv->date_expired_mot_de_passe_oublie)!=true){
//                        return redirect('/modifiermotdepasse')->with('success', 'Info:  Vous pouvez réessayer dans '.CarbonInterval::seconds(Carbon::parse($mot_de_passe_trouv->date_expired_mot_de_passe_oublie)->diffInSeconds($now))->cascade()->forHumans());
//                    }
                    $mot_de_passe_trouv->flag_expired_mot_de_passe_oublie = true;
                    $mot_de_passe_trouv->update();
                }
                $mot_de_passe = new MotDePasseOublie();
                $mot_de_passe->email_mot_de_passe_oublie = $request->email_mot_de_passe_oublie;
                $mot_de_passe->code_mot_de_passe_oublie = $this->generateOtp();
                $mot_de_passe->tel_mot_de_passe_oublie = $now->addMinute(5);
                $mot_de_passe->save();
                $logo = Menu::get_logo();
                $user = User::where('email',$request->email_mot_de_passe_oublie)->first();

                $sujet = "Code de réinitialisation - FDFP";
                    $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                    $messageMail = "<b>CODE DE REINITIALISATION</b>
                                    <br><br>Veuillez utiliser le code ci-dessous pour la réinitialisation de votre mot de passe
                                    <br><br><br>
                                    <h1>$mot_de_passe->code_mot_de_passe_oublie</h1>
                                    <br><br>Ce code exipre dans 5 minutes

                                    <br><br><br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    Dans le cas où vous n'avez tentez de réinitialiser votre mot de passe veuillez ignorer ce mail
                                    -----
                                    ";
                    $messageMailEnvoi = Email::get_envoimailTemplate($user->email, $user->name, $messageMail, $sujet, $titre);
            return redirect('motdepasseoublie/'.Crypt::UrlCrypt($request->email_mot_de_passe_oublie).'/otp');
    }
    public function otp($email){
        $email =  Crypt::UrldeCrypt($email);
        if(isset($email)){
            $mot_de_passe_oublie = MotDePasseOublie::where('email_mot_de_passe_oublie','=',$email)->where('flag_expired_mot_de_passe_oublie',false)->first();
            if(isset($mot_de_passe_oublie)){
                return view('motdepasseoublie.otp',compact('email'));
            }
            return redirect()->route('motdepasseoublie')->with('error', 'Erreur : Veuillez saisir un email correct. ');
        }
        return redirect()->route('motdepasseoublie')->with('error', 'Erreur : Veuillez saisir un email correct. ');
    }

    public function verifyOtpUpdatePassword(Request $request,$email){
        $email =  Crypt::UrldeCrypt($email);
        if(isset($email)){
            $mot_de_passe_oublie = MotDePasseOublie::where('email_mot_de_passe_oublie',$email)
                ->where('code_mot_de_passe_oublie',$request->otp)
                ->where('flag_expired_mot_de_passe_oublie',false)->first();
            if(isset($mot_de_passe_oublie)){
                $passwordCli = Crypt::MotDePasse(); // '123456789';
                $password = Hash::make($passwordCli);
                $user = User::where('email',$mot_de_passe_oublie->email_mot_de_passe_oublie)->first();
                if(isset($user)){
                    $logo = Menu::get_logo();
                    $emailcli = $user->email;

                    if (isset($user->email)) {
                        if(isset($user->id_partenaire)){
                            $entreprise = Entreprises::where('id_entreprises',$user->id_partenaire)->first();
                            $name = $entreprise->raison_social_entreprises;
                            $ncc_entreprises = $entreprise->ncc_entreprises;

                            $sujet = "Activation de compte FDFP";
                            $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                            $messageMail = "<b>Cher $name ,</b>
                                    <br><br>Nous sommes ravis de vous accueillir sur notre plateforme ! <br> Votre compte a été créé avec
                                        succès, et il est maintenant prêt à être utilisé.
                                    <br><br>
                                    <br><br>Voici un récapitulatif de vos informations de compte :
                                    <br><b>Nom d'utilisateur : </b> $name
                                    <br><b>Adresse e-mail : </b> $emailcli
                                    <br><b>Identifiant : </b> $ncc_entreprises
                                    <br><b>Mot de passe : </b> $passwordCli
                                    <br><br>
                                    <br><br>Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :
                                            www.e-fdfp.ci
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                        }else{
                            $name = $user->name .' '. $user->prenom_users;
                            $sujet = "Réinitialisation du mot de passe du compte FDFP";
                            $titre = "Bienvenue sur " . @$logo->mot_cle . "";
                            $messageMail = "Nous sommes ravis de vous accueillir sur notre plateforme ! <br> Le mot de passe de votre compte a été réinitialisé avec
                                        succès, et il est maintenant prêt à être utilisé.
                                    <br><br>
                                    <br><br>Voici un récapitulatif de vos informations de compte :
                                    <br><b>Nom d'utilisateur : </b> $name
                                    <br><b>Adresse e-mail : </b> $emailcli
                                    <br><b>Identifiant : </b> $emailcli
                                    <br><b>Mot de passe : </b> $passwordCli
                                    <br><br>Pour finaliser la réinitialisation de  votre compte, veuillez cliquer sur le lien ci-dessous :
                                            http://fdfp.ldfgroupe.com/
                                    <br>
                                    -----
                                    Ceci est un mail automatique, Merci de ne pas y répondre.
                                    -----
                                    ";
                        }
                        $messageMailEnvoi = Email::get_envoimailTemplate($emailcli, $name, $messageMail, $sujet, $titre);
                        $user->password = $password;
                        $user->flag_mdp = null;
                        $user->update();

                        $mot_de_passe_oublie->flag_expired_mot_de_passe_oublie=true;
                        $mot_de_passe_oublie->update();
                    }
                    return redirect()->route('connexion')->with('success', 'Mot de passe réinitialiser avec succès veuillez consulter votre boite mail pour vos nouveaux accès. ');

                }
            }else{
                return redirect('motdepasseoublie/'.Crypt::UrlCrypt($email).'/otp')->with('error', ' OTP saisi est incorrect.');
            }
        }

    }

    public function generateOtp(){
        do{
            $this->code_mot_de_passe_oublie = rand(123456,999999);
        }while(MotDePasseOublie::where('code_mot_de_passe_oublie',$this->code_mot_de_passe_oublie)->first()!=null);
        return $this->code_mot_de_passe_oublie;
    }
}
