<?php

use App\Helpers\Menu;

$logo = Menu::get_logo();
$infosa = Menu::get_info_acceuil();
$couleur = Menu::get_info_couleur();
?>

<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="fr" data-layout="semi-dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Application de gestion de plaque d'immatruculation.">
    <meta name="keywords" content="e-gestplaq, 2ge">
    <meta name="author" content="Barnoin Informatique">
    <?php if(isset($logo->mot_cle)){?>
    <title><?php echo @$logo->mot_cle;?></title>
    <?php } ?>
    <?php if(isset($logo->logo_logo)){?>
        <link rel="<?php echo @$logo->mot_cle;?>" type="image/x-icon" href="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}"/>
    <?php } ?>
    <!--<title>Authentification - e-gesplaq - Application de gestion de plaque d'immatruculation</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click"
      data-menu="vertical-menu-modern" data-col="blank-page" style='background-color:#<?php echo @$couleur->mot_cle; ?>'>
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Brand logo--><a align="center" class="brand-logo" href="#">
                        <!-- <img height="100" src="/app-assets/images/logo/logo.png">
                         <h2 class="brand-text text-warning ms-1">Rapide auto groupe</h2>-->
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                            <img class="img-fluid" src="{{ asset('/frontend/logo/'. @$infosa->logo_logo)}}" alt="Register V2">
                            <!--<img class="img-fluid" src="/app-assets/images/pages/register-v2.svg" alt="Register V2">-->
                        </div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Login-->
                    <div class="d-flex col-lg-3 align-items-center auth-bg px-3 p-lg-1">
                        <div class="card-body">
                            <a href="{{route('enrolement.create')}}" class="btn btn-primary w-100" tabindex="4">Enrolement</a>
                            <a href="#" class="brand-logo  ">
                                <div align="center"><a class="" href="#">
                                    <!--<img src="/app-assets/images/logo/logo.png">-->
                                    <?php if(isset($logo->logo_logo)){?>
                                        <img alt="Logo" src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}" height="40" style="margin:5px; padding: 5px"/>
                                    <?php } ?>
                                        </a></div>
                                <h2 class="brand-text text-primary ms-1"></h2>
                            </a>
                            <p class="card-text mb-2 text-center">Votre application de digitalisation de produits et services metiers. </p>
                            <form class="auth-login-form mt-2" action="{{ url('connexion') }}" method="POST">
                                {{ csrf_field() }}
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            <b>Echec: </b> {{ $message }}
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="mb-1">
                                    <label class="form-label" for="login-email">Mon identifiant </label>
                                    <input autocomplete="off" class="form-control" id="login-email" type="text"
                                           name="username" required
                                           placeholder="Identifiant" aria-describedby="login-email" autofocus=""
                                           tabindex="1"/>
                                </div>
                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="login-password">Mon mot de passe </label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input autocomplete="off" class="form-control form-control-merge"
                                               required="required"
                                               id="login-password"
                                               type="password" name="password" placeholder="············"
                                               aria-describedby="login-password" tabindex="2"/><span
                                            class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info w-100" tabindex="4">Je me connecte</button>
                                
                            </form>
                            <p class="text-center mt-2">
                                <span>&nbsp;</span>
                            </p>
                            <div class="divider my-2">
                                <div class="divider-text">&copy; Tous droits réservés - <?php echo @$logo->titre_logo;?>
                                    - <?php echo date('Y'); ?></div>
                            </div>
                            <div class="auth-footer-btn d-flex justify-content-center">
                                <!--<img height="30" src="/app-assets/images/logo/logo2GE.png">-->
                            </div>
                        </div>
                    </div>
                    <!-- /Login-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
<!-- BEGIN: Vendor JS-->
<script src="/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="/app-assets/js/core/app-menu.js"></script>
<script src="/app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<script src="/app-assets/js/scripts/pages/auth-login.js"></script>
<!-- END: Page JS-->
<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
</body>
<!-- END: Body-->
</html>
