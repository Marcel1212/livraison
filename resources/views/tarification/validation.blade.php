<?php

use App\Helpers\Menu;

$logo = Menu::get_logo();
$reseaux = Menu::get_info_reseaux();
$lien = 'traitementlivraisonprix';
?>

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <?php if (isset($logo->mot_cle)){ ?>
    <title><?php echo @$logo->mot_cle; ?> | Service de livraison</title>
    <?php } ?>

    <meta name="description" content="" />

    <!-- Favicon -->
    <?php if (isset($logo->logo_logo)){ ?>
    <link rel="<?php echo @$logo->mot_cle; ?>" type="image/x-icon" href="{{ asset('/frontend/logo/' . @$logo->logo_logo) }}" />
    <?php } ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/form-validation.css') }}" />

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


    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select1/select1.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select3/select3.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/forms/wizard/bs-stepper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/forms/form-wizard.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-faq.css') }}" />


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/form-wizard-numbered.js') }}"></script>
    <script src="{{ asset('assets/js/form-wizard-validation.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>


    <!--<script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>-->
    <script src='https://www.google.com/recaptcha/api.js'></script>


</head>

<body>
    <!-- Layout wrapper -->
    <div class="bgui-container">
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->

                <!-- / Menu -->

                <!-- Layout container -->
                <div class="layout-page bt-ls-x0">
                    <!-- Navbar -->

                    <nav class="layout-navbar shadow-none bt-ls-xl0 py-0">
                        <div class="container">
                            <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-4">
                                <!-- Menu logo wrapper: Start -->
                                <div class="navbar-brand app-brand demo d-flex">
                                    <!-- Mobile menu toggle: Start-->

                                    <!-- Mobile menu toggle: End-->
                                    <a href="{{ route('/') }}" class="app-brand-link">
                                        <span class="app-brand-logo demo">
                                            <img src="{{ asset('/frontend/logo/' . @$logo->logo_logo) }}"
                                                width="90" />
                                        </span>

                                    </a>
                                </div>
                                <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                                    <ul class="navbar-nav me-auto">
                                    </ul>
                                </div>
                                <div class="landing-menu-overlay d-lg-none"></div>
                                <!-- Menu wrapper: End -->
                                <!-- Toolbar: Start -->
                                <ul class="navbar-nav flex-row align-items-center ms-auto">

                                </ul>
                                <!-- Toolbar: End -->
                            </div>
                        </div>
                    </nav>
                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    {{-- <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div
                                class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                                <h3 class="text-center"></h3>
                            </div>
                            <p class="text-center mb-0 px-3"></p>
                        </div>
                    </div> --}}

                    <div class="container-xxl flex-grow-1 container-p-y">


                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="alert-body align-middle">
                                    <h4> {!! $message !!} </h4>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <div
                                        class="card-header bg-label-los d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                                        <h3 class="card-title mb-sm-0 me-2">
                                            Confirmation
                                        </h3>
                                        <div class="action-btns">
                                            <button class="btn btn-gray me-3"> <a
                                                    href="{{ route('/') }}">Retour</a>
                                            </button>
                                        </div>


                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-10 mx-auto">
                                                <!-- 1. Delivery Address -->
                                                <h5 class="my-4">


                                                    {{-- <div class="spinner-grow text-warning" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div> --}}

                                                    <div class="sk-swing sk-warning">
                                                        <div class="sk-swing-dot"></div>
                                                        <div class="sk-swing-dot"></div>
                                                    </div>

                                                    <div align="center">
                                                        <strong>Livraison validé
                                                        </strong>
                                                    </div>
                                                </h5>

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-8 mx-auto">
                                                            <div class="card invoice-preview-card">
                                                                <div class="card-body">


                                                                    <hr class="my-3 mx-n4">



                                                                    <div class="row p-sm-4 p-0">
                                                                        <div class="card-body text-center">
                                                                            <h2>
                                                                                <i
                                                                                    class="ti ti-shopping-cart text-success display-6"></i>
                                                                            </h2>
                                                                            <h4>Livraison en cours de traitement</h4>
                                                                            <div class="spinner-border text-success"
                                                                                role="status">
                                                                                <span
                                                                                    class="visually-hidden">Loading...</span>
                                                                            </div>
                                                                            <br>
                                                                            <br>
                                                                            <h3>Code de livraison:</h3>
                                                                            <h5> <strong>{{ $livraison->code_livraison }}
                                                                                </strong></h5>
                                                                        </div>
                                                                        <br>
                                                                        <br>
                                                                        <div align="center">
                                                                            <h6><strong>Note: </strong>Un livreur vous
                                                                                contactera </h6>
                                                                        </div>
                                                                    </div>











                                                                    {{-- <div class="row p-0 p-sm-4">

                                                                            <div
                                                                                class="col-md-6 d-flex justify-content-end">
                                                                                <div class="invoice-calculations">

                                                                                    <div
                                                                                        class="d-flex justify-content-between">
                                                                                        <span class="w-px-100">
                                                                                            <strong>PRIX:</strong></span>
                                                                                        <span>
                                                                                            <strong>
                                                                                                <i>{{ $tarif->prix }}</i></strong>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}




                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <br />
                                                <div class="row">
                                                    <div class="col-sm-12 col-4 text-end mt-0" align="center">
                                                        <button class="btn  btn-outline-warning " align="center"> <a
                                                                href="{{ route('/') }}">Retour</a>
                                                        </button>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /Sticky Actions -->
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->

                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>

                </div>
                <!-- Content wrapper -->


            </div>
            <!-- / Layout page -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <footer class="footer-wrapper pt-45 footer-layout1"
        data-bg-src="{{ asset('assetsfront/img/bg/footer-bg.png') }}">

        <div class="footer-wrap  " data-bg-src="{{ asset('assetsfront/img/bg/jiji.png') }}">
            <div class="widget-area">

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




    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>


</body>

</html>
