<?php

use App\Helpers\Menu;

$logo = Menu::get_logo();
$infosa = Menu::get_info_acceuil();
$couleur = Menu::get_info_couleur();
$reseaux = Menu::get_info_reseaux();
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php if(isset($logo->mot_cle)){?>
    <title><?php echo @$logo->mot_cle; ?> </title>
    <?php } ?>
    <meta name="author" content="BARNOIN">
    <meta name="description" content="FDFP">
    <meta name="keywords" content="FDFP">
    <meta name="robots" content="INDEX">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <?php if(isset($logo->logo_logo)){?>
    <link rel="<?php echo @$logo->mot_cle; ?>" type="image/x-icon" href="{{ asset('/frontend/logo/' . @$logo->logo_logo) }}" />
    <?php } ?>
    <!--==============================
 Google Fonts
 ============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Jost:wght@300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700&display=swap"
        rel="stylesheet">


    <!--==============================
 All CSS File
 ============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assetsfront/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{ asset('assetsfront/css/fontawesome.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('assetsfront/css/magnific-popup.min.css') }}">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="{{ asset('assetsfront/css/slick.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('assetsfront/css/nice-select.min.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assetsfront/css/style.css') }}">

</head>

<body>


    <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->



    <!--********************************
   Code Start From Here
 ******************************** -->




    <!--==============================
     Preloader
  ==============================-->
    <div class="preloader ">
        <button class="th-btn style8 preloaderCls">LOS LIVRAISON</button>
        <div class="preloader-inner">
            <span class="loader"></span>
        </div>
    </div>
    <!--==============================
    Sidemenu
============================== -->

    <div class="popup-search-box d-none d-lg-block">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        {{-- <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form> --}}
    </div>
    <!--==============================
    Mobile Menu
  ============================== -->
    <div class="th-menu-wrapper">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="{{ route('/') }}"><img src="{{ asset('assetsfront/img/logo.png') }}" alt="FDFP"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li>
                        <a href="{{ route('livraison') }}" class="th-btn style3">Effectuer une livraison</a>
                    </li>
                    <li>
                        <?php if (Auth::check()) {?>
                        <a href="{{ route('dashboard') }}">Mon espace</a>
                        <?php } else {?>
                        <a href="{{ route('connexion') }}">Se connecter</a>
                        <?php }?>

                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
 Header Area
==============================-->
    <header class="th-header header-layout1">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-links">
                            <ul>

                                <i class="ti ti-truck text-body ti-sm"></i>
                                <li class="d-none d-xl-inline-block"><i class="ti ti-truck text-body ti-sm"></i>
                                    <i class="ti ti-truck text-body ti-sm"></i> LOS
                                    LIVRAISON</a>
                                </li>
                                <li><i class="far fa-clock"></i>Ouvert 24H/24 / 07:30 - 16:30</li>
                                <li><i class="far fa-phone"></i><a href="tel:+11156456825">Appellez</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-links header-right">
                            <ul>
                                {{-- <li>
                                    <div class="header-social">
                                        <span class="social-title">Suivez-nous sur:</span>
                                        @foreach ($reseaux as $reseau)
                                            <a href="{{ $reseau->mot_cle }}" target="_blank"><i
                                                    class="{{ $reseau->titre_logo }}"></i></a>
                                            <!--<a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>-->
                                        @endforeach
                                        <!--<a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                        <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                                        <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>-->
                                    </div>
                                </li> --}}
                                <!--<li class="d-none d-lg-inline-block">
                                    <i class="far fa-user"></i><a href="contact.html">Login / Register</a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="{{ route('/') }}"><img src="{{ asset('assetsfront/img/los.png') }}"
                                        alt="Edura"></a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">
                                    <nav class="main-menu d-none d-lg-inline-block">
                                    </nav>
                                    <!--<button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>-->
                                    <div class="header-button d-lg-none">
                                        <a href="{{ route('livraison') }}" class="th-btn style4">Effectuer une
                                            livraison<i class="fas fa-arrow-right ms-1"></i></a>
                                        <?php if (Auth::check()) {?>
                                        <a href="{{ route('dashboard') }}" class="">Mon espace<i
                                                class="fas fa-arrow-right ms-1"></i></a>
                                        <?php } else {?>
                                        <a href="{{ route('connexion') }}" class="">Se connecter<i
                                                class="fas fa-arrow-right ms-1"></i></a>
                                        <?php }?>

                                    </div>
                                </div>
                                <div class="col-auto d-none d-xl-block">
                                    <div class="header-button">
                                        <a href="{{ route('livraison') }}" class="th-btn style4">Effectuer une
                                            livraison<i class="fas fa-arrow-right ms-1"></i></a>
                                        <?php if (Auth::check()) {?>
                                        <a href="{{ route('dashboard') }}" class="th-btn ml-25">Mon espace<i
                                                class="fas fa-arrow-right ms-1"></i></a>
                                        <?php } else {?>
                                        <a href="{{ route('connexion') }}" class="th-btn ml-25">Se connecter<i
                                                class="fas fa-arrow-right ms-1"></i></a>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--==============================
Hero Area
==============================-->
    <div class="th-hero-wrapper hero-1" id="hero">
        <div class="hero-slider-1 th-carousel" data-fade="true" data-slide-show="1" data-md-slide-show="1"
            data-dots="true">


            <div class="th-hero-slide">
                <div class="th-hero-bg" data-overlay="title" data-opacity="8"
                    data-bg-src="{{ asset('assetsfront/img/hero/hero_bg_1_1.jpg') }}"></div>
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-6">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s"><span>LOS
                                        LIVRAISON</span></span>
                                <h1 class="hero-title text-white" data-ani="slideinleft" data-ani-delay="0.4s">
                                    Un personel qualifié et outillé <span class="text-theme">a votre service.</span>
                                </h1>
                                <p class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">L'experience fait
                                    la difference</p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('livraison') }}" class="th-btn style3">Effectuer une
                                        livraison<i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-lg-end text-center">
                            <div class="hero-img1">
                                <img src="{{ asset('assetsfront/img/hero/hero_thumb_1_1.jpg') }}" alt="hero">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-shape shape1">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_1.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape2">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_2.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape3"></div>

                <div class="hero-shape shape4 shape-mockup jump-reverse" data-right="3%" data-bottom="7%">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_3.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape5 shape-mockup jump-reverse" data-left="0" data-bottom="0">
                    <img src="{{ asset('assetsfront/img/hero/shape_1_4.png') }}" alt="shape">
                </div>
            </div>

            <div class="th-hero-slide">
                <div class="th-hero-bg" data-overlay="title" data-opacity="8"
                    data-bg-src="{{ asset('assetsfront/img/hero/hero_bg_1_2.jpg') }}"></div>
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-6">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft"
                                    data-ani-delay="0.1s"><span>Qualite optimale</span></span>
                                <h1 class="hero-title text-white" data-ani="slideinleft" data-ani-delay="0.4s">
                                    Prix etudiés et fixe <span class="text-theme">pour faire plus d'economie.</span>
                                </h1>
                                <p class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s"> La satisfaction de
                                    notre clientele, une priorite
                                </p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('livraison') }}" class="th-btn style3">Effectuer une
                                        livraison<i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-lg-end text-center">
                            <div class="hero-img1">
                                <img src="{{ asset('assetsfront/img/hero/hero_thumb_1_1.jpg') }}" alt="hero">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-shape shape1">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_1.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape2">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_2.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape3"></div>

                <div class="hero-shape shape4 shape-mockup jump-reverse" data-right="3%" data-bottom="7%">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_3.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape5 shape-mockup jump-reverse" data-left="0" data-bottom="0">
                    <img src="{{ asset('assetsfront/img/hero/shape_1_4.png') }}" alt="shape">
                </div>
            </div>

            <div class="th-hero-slide">
                <div class="th-hero-bg" data-overlay="title" data-opacity="8"
                    data-bg-src="{{ asset('assetsfront/img/hero/hero_bg_1_3.jpg') }}"></div>
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-6">
                            <div class="hero-style1">
                                <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s"><span>LOS
                                        LIVRAISON</span></span>
                                <h1 class="hero-title text-white" data-ani="slideinleft" data-ani-delay="0.4s">
                                    Le meilleur service de livraison <span class="text-theme">en Cote d'Ivoire.</span>
                                </h1>
                                <p class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">Faites nous
                                    confiance</p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="{{ route('livraison') }}" class="th-btn style3">Effectuer une
                                        livraison<i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-lg-end text-center">
                            <div class="hero-img1">
                                {{-- <img src="{{ asset('assetsfront/img/hero/livraison.webp') }}" alt="hero"> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-shape shape1">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_1.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape2">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_2.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape3"></div>

                <div class="hero-shape shape4 shape-mockup jump-reverse" data-right="3%" data-bottom="7%">
                    {{-- <img src="{{ asset('assetsfront/img/hero/shape_1_3.png') }}" alt="shape"> --}}
                </div>
                <div class="hero-shape shape5 shape-mockup jump-reverse" data-left="0" data-bottom="0">
                    <img src="{{ asset('assetsfront/img/hero/shape_1_4.png') }}" alt="shape">
                </div>
            </div>



        </div>
    </div>


    <footer class="footer-wrapper pt-45 footer-layout1"
        data-bg-src="{{ asset('assetsfront/img/bg/footer-bg.png') }}">

        <div class="footer-wrap  " data-bg-src="{{ asset('assetsfront/img/bg/jiji.png') }}">
            <div class="widget-area">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-xxl-3 col-xl-3">
                            <div class="widget footer-widget">
                                <div class="th-widget-about">

                                    <div class="widget widget_nav_menu footer-widget">
                                        <h3 class="widget_title">Nos services</h3>
                                        <div class="menu-all-pages-container">
                                            <ul class="menu">
                                                <li><a href="#">Livraison a domicile</a></li>
                                                <li><a href="#">Reception de colis</a></li>
                                                <li><a href="#">Livraison programmée</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- <div class="th-social">
                                        <h6 class="title text-white">SUIVEZ-NOUS SUR:</h6>
                                        @foreach ($reseaux as $reseau)
                                            <a href="{{ $reseau->mot_cle }}" target="_blank"><i
                                                    class="{{ $reseau->titre_logo }}"></i></a>
                                            <!--<a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>-->
                                        @endforeach
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xxl-3 col-xl-3">
                            <div class="widget newsletter-widget footer-widget">
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title">Besoin d'aide ?</h3>
                                <div class="menu-all-pages-container">
                                    <ul class="menu">
                                        <li><a href="#">Contacter l'assistance</a></li>
                                        <li><a href="#">Conditions générales</a></li>
                                        <li><a href="#">Donnez un avis</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-xl-auto">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title">Ressources</h3>
                                <div class="menu-all-pages-container">
                                    <ul class="menu">
                                        <li><a href="#">Support</a></li>
                                        <li><a href="#">Guides vidéos</a></li>
                                        <li><a href="#">Documentations</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright-wrap">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <p class="copyright-text">Copyright © <?php echo Date('Y'); ?> <a
                                    href="{{ route('/') }}">LOS Livraison</a> Tous droits réservés.</p>
                        </div>
                        <div class="col-md-6 text-end d-none d-md-block">
                            <div class="footer-links">
                                <ul>
                                    <li><a href="www.kouassimarcel.online">Designed by ITVerse Informatique</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--********************************
   Code End  Here
 ******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>

    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <script src="{{ asset('assetsfront/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <!-- Slick Slider -->
    <script src="{{ asset('assetsfront/js/slick.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assetsfront/js/bootstrap.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('assetsfront/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Counter Up -->
    <script src="{{ asset('assetsfront/js/jquery.counterup.min.js') }}"></script>
    <!-- Circle Progress -->
    <script src="{{ asset('assetsfront/js/circle-progress.js') }}"></script>
    <!-- Range Slider -->
    <script src="{{ asset('assetsfront/js/jquery-ui.min.js') }}"></script>
    <!-- Isotope Filter -->
    <script src="{{ asset('assetsfront/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assetsfront/js/isotope.pkgd.min.js') }}"></script>
    <!-- Tilt JS -->
    <script src="{{ asset('assetsfront/js/tilt.jquery.min.js') }}"></script>
    <!-- Tweenmax JS -->
    <script src="{{ asset('assetsfront/js/tweenmax.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('assetsfront/js/nice-select.min.js') }}"></script>

    <!-- Main Js File -->
    <script src="{{ asset('assetsfront/js/main.js') }}"></script>

</body>

</html>
