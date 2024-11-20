<?php

use App\Helpers\Menu;

$logo = Menu::get_logo();
$reseaux = Menu::get_info_reseaux();
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
                                            Demande de service de livraison
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
                                                    Renseigner les informations et les détails de la livraison
                                                </h5>
                                                <form method="POST"
                                                    action="{{ route('traitementlivraisonprix.storelivraison') }}"
                                                    enctype="multipart/form-data" id="livraisonForm">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-8 mx-auto">
                                                                <!-- 1. Delivery Address -->
                                                                <h5 class="my-4"> <strong>1. Expediteur</strong>
                                                                </h5>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="form-label" for="fullname">Nom
                                                                            et prenoms <span
                                                                                style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" id="nom_exp"
                                                                            name="nom_exp" class="form-control"
                                                                            required="required"
                                                                            placeholder="Dechou Moise">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label"
                                                                            for="numero">Contact <span
                                                                                style="color:red;">*</span></label>
                                                                        <input type="number" id="numero_exp"
                                                                            name="numero_exp" class="form-control"
                                                                            required="required"
                                                                            placeholder="0102032216">
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <label class="form-label"
                                                                            for="state">Commune <span
                                                                                style="color:red;">*</span></label>
                                                                        <div class="position-relative"><select
                                                                                id="id_commune_exp"
                                                                                name="id_commune_exp"
                                                                                required="required"
                                                                                class="select2 select2-size-sm form-select">

                                                                                <?php echo $localite;
                                                                                ?>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label"
                                                                            for="address">Details du lieu </label>
                                                                        <textarea name="details_exp" class="form-control" id="details_exp" rows="3"
                                                                            placeholder="Ex: Rue M3 , Cocody Danga, Chez SAMER Riviera 2"></textarea>
                                                                    </div>

                                                                </div>
                                                                <hr>
                                                                <br>
                                                                <!-- 2. Delivery Type -->
                                                                <h5 class="my-4"><strong>2. Destinataire</strong>
                                                                </h5>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="form-label" for="fullname">Nom
                                                                            et prenoms <span
                                                                                style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" id="nom_dest"
                                                                            name="nom_dest" class="form-control"
                                                                            required="required"
                                                                            placeholder="Bedah Henri">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label"
                                                                            for="numero">Contact <span
                                                                                style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="number" id="numero_dest"
                                                                            class="form-control" required="required"
                                                                            name="numero_dest"
                                                                            placeholder="0102032216">
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <label class="form-label"
                                                                            for="state">Commune <span
                                                                                style="color:red;">*</span>
                                                                        </label>
                                                                        <select id="id_commune_dest"
                                                                            name="id_commune_dest" required="required"
                                                                            class="select2 select2-size-sm form-select">

                                                                            <?php echo $localite;
                                                                            ?>

                                                                        </select>

                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label"
                                                                            for="address">Details du lieu </label>
                                                                        <textarea name="details_dest" class="form-control" id="details_dest" rows="3"
                                                                            placeholder="Ex: Rue M3 , Cocody Danga, Chez SAMER Riviera 2"></textarea>
                                                                    </div>

                                                                </div>
                                                                <hr>

                                                                <!-- 4. Payment Method -->

                                                                <h5 class="my-4"> <strong>3. Date de
                                                                        livraison</strong></h5>
                                                                <div class="row g-3">
                                                                    <div class="mb-3">

                                                                        <div class="form-check form-check-inline">

                                                                            <label class="form-label"
                                                                                for="date_debut_fiche_agrement">Veuillez
                                                                                renseignez la date de la
                                                                                livraison<strong
                                                                                    style="color:red;">*</strong></label>
                                                                            <input type="date" id="date_livraison"
                                                                                required="required"
                                                                                name="date_livraison"
                                                                                class="form-control form-control-sm" />
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <h5 class="my-4"> <strong>4. Methode de
                                                                        paiement</strong></h5>
                                                                <div class="row g-3">
                                                                    <div class="mb-3">

                                                                        <div class="form-check form-check-inline">
                                                                            <input name="collapsible-payment"
                                                                                class="form-check-input form-check-input-payment"
                                                                                type="radio" value="cash"
                                                                                checked="checked"
                                                                                id="collapsible-payment-cash">
                                                                            <label
                                                                                class="form-check-label d-flex gap-1"
                                                                                for="collapsible-payment-cash">
                                                                                Paiement a la livraison
                                                                                <i class="ti ti-help text-muted ti-xs"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    aria-label="Payez dès réception du colis"
                                                                                    data-bs-original-title="Payez dès réception du colis"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <br />
                                                    <div class="row">
                                                        <div class="col-sm-12 col-4 text-end mt-0">
                                                            <button class="btn    btn-outline-warning" type="submit"
                                                                name="submit">Suivant</button>
                                                        </div>
                                                    </div>
                                                </form>
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

    {{-- <footer class="landing-footer bg-body footer-text mt-4">
        <div class="footer-top">
            <div class="container">
                <div class="row gx-0 gy-4 g-md-5">
                    <div class="col-lg-7">
                        <a href="{{ route('/') }}" class="app-brand-link mb-4">
                            <span class="app-brand-logo demo">
                                <img src="{{ asset('/frontend/logo/logo-blanc.png') }}" />
                                <!--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1735.63 920.98">
                        <g id="Calque_2" data-name="Calque 2">
                            <g id="Calque_1-2" data-name="Calque 1">
                                <rect width="1735.63" height="920.98" fill="none"></rect>
                                <path d="M652,301.3c-8.22,3-16.38,6.16-24.68,8.91A129.13,129.13,0,0,1,609.53,315c-6,1.09-8.57-2.5-5.65-8A118.2,118.2,0,0,1,614,291q21.84-28.86,44.13-57.38c7.2-9.19,17-14.69,28.07-18.14,53.47-16.62,107.88-19.42,163-10.93,17.64,2.72,34.9,7.1,50.18,17.06,22.7,14.8,35.27,35,34.76,62.81-.51,28.13-9.7,53.35-23.51,77.41-18.77,32.69-43.47,60.46-70.57,86.26-34,32.37-70.67,61.37-110.7,85.91-44.72,27.42-91.6,50.35-142.13,65.08-17.42,5.08-35.14,9-53.46,9.18-10.08.08-17.43-4.26-22.65-12.86-5.43-8.94-11.52-17.49-16.74-26.54-7.11-12.31-7.59-25.24-.41-37.6,10.76-18.53,21.24-37.33,33.42-54.92,27.87-40.21,56.61-79.81,85.18-119.53,12.73-17.71,25.89-35.1,38.85-52.64.47-.63.87-1.29,1.3-1.94ZM628.24,492.15c1.68.13,2.37.38,2.93.21,9.87-3,20-5.36,29.51-9.1,22.49-8.8,42.62-21.82,61.81-36.34,34.46-26.07,62.17-57.75,79.37-97.71a55.5,55.5,0,0,0,4.42-23.7c-.91-19.32-14.59-33.13-35.06-37.3-21.28-4.34-42.62-4.92-64-.6l-6.53,1.3,0,1.29c6,1.06,12,1.65,17.84,3.31a219.37,219.37,0,0,1,26.83,9.1c8.24,3.56,9.65,8.7,6,16.55a45.67,45.67,0,0,1-4.19,7.36c-6.92,9.57-14,19-21,28.58q-40,55.47-80,111C640.26,474.45,634.57,483,628.24,492.15Z" fill="#fff"></path>
                                <path d="M238,494.68c-4.49-.39-8.48-.4-12.33-1.13-8.12-1.52-10-5-6.17-12.29,5.92-11.16,11.93-22.35,18.9-32.87,9.56-14.4,20.11-28.15,30.13-42.25,9.1-12.82,21.47-18.86,37.13-18.81,2.14,0,5.13-1.2,6.29-2.86,15.11-21.52,30-43.22,44.86-64.9.83-1.2,1.41-2.56,2.55-4.68H337c-5,0-9.93.29-14.85-.13-3.94-.34-5.1-3.15-3.2-6.49,5.07-9,9.68-18.31,15.74-26.56,12.5-17,25.59-33.62,38.88-50,10.78-13.29,26.14-17.9,42.29-18.23q76.94-1.59,153.9-1.67c18.76,0,37.59,1.7,56.26,3.8,12.26,1.37,13.88,4.68,7.35,15.33-8.49,13.87-18.31,26.94-27.87,40.13-4.29,5.92-9.51,11.15-14,16.94-10.42,13.53-24.12,18.64-41,18.41-22-.3-43.95.74-65.93,1.2L418.2,309a6.9,6.9,0,0,0-4.54,1.49c5.25,2.11,10.56,4.09,15.74,6.36,5.48,2.39,11,4.79,16.21,7.68,7.15,4,8.31,9.45,3.9,16.25-7.85,12.11-15.73,24.19-24.07,37,2.58-.12,4.61-.17,6.64-.31,22.59-1.53,45.17-3.14,67.77-4.55a125.22,125.22,0,0,1,14,.31c10.56.51,14.59,6.72,9.56,16.12a323.3,323.3,0,0,1-19.3,32c-9,13-19.18,25.15-28.59,37.86-8.69,11.74-20.74,15.91-34.67,16.7-24.77,1.4-49.53,3.15-74.31,4.43-8.93.47-14.61,4.35-19.24,12.12-26.18,43.89-53.24,87.24-83,128.83a161.18,161.18,0,0,1-16.4,18.76A39.07,39.07,0,0,1,219.09,652c-16.87,0-33.57-1.52-49.9-6a38.48,38.48,0,0,1-5.62-2c-8.54-3.85-11.46-10.4-7-18.59C162.77,614,169.77,603,176.7,592.06q30.13-47.7,60.48-95.26A14.58,14.58,0,0,0,238,494.68Z" fill="#fff"></path>
                                <path d="M1319.42,396.71c-7.88,8.93-16,17.67-23.62,26.84q-38.74,46.69-77.21,93.64c-1,1.16-1.94,2.29-2.93,3.42-9.19,10.46-19.53,17.67-34.58,18-16.66.36-33.24,2.11-49.67-1.88a47,47,0,0,1-8.5-2.89c-5.1-2.33-6.56-6.24-3.55-11,3.28-5.17,7.22-10,11-14.79,42.45-54.17,87.64-106,133.92-156.88,9.59-10.55,19-21.28,29.15-32.7a20.88,20.88,0,0,0-3.93,0c-12,2.94-23.88,6-35.84,8.9a36.94,36.94,0,0,1-7.9,1c-6.24.11-9-3.52-6-9a150,150,0,0,1,14-21.19c17.38-21.8,36.47-42.15,63.57-51.41a226.67,226.67,0,0,1,49.54-11c26.12-2.69,52.47-3.8,78.74-4.09a197.68,197.68,0,0,1,64.94,9.74c10.15,3.38,19.84,7.84,27.77,15.32,12.8,12.08,14.84,27,10.75,43.21-4.88,19.31-17,34.1-31.16,47.32-29.88,27.9-64.52,48.63-101.31,65.91-28.7,13.49-58.48,23.95-89.64,30.15a102.44,102.44,0,0,1-16.88,1.61c-7.85.25-9.51-2.18-7.39-9.72a120,120,0,0,1,15.76-34.86c.64-1,1.25-1.92,1.88-2.88Zm26-26.31a8.78,8.78,0,0,0,2.28.35c24.46-5.28,47.8-13.58,68.34-28.06,6.16-4.35,11.17-10.91,15.35-17.33,5.48-8.43,2.64-15.39-6.72-19a62.84,62.84,0,0,0-12.46-3.48c-17.27-2.8-34.54-1.16-51.78.57-6.67.66-13.29,1.78-19.94,2.69l-.09,1.5c3.76.89,7.54,1.71,11.27,2.69,8.81,2.32,17.92,3.92,26.29,7.31,8.12,3.29,9.12,7.71,3.51,14.35-8.15,9.63-17.24,18.47-25.93,27.65C1352.34,363.08,1349.11,366.54,1345.47,370.4Z" fill="#fff"></path>
                                <path d="M919.32,443.67c-4.9-.6-9-.84-13.06-1.67-5.62-1.16-7-4.06-3.91-9,4-6.49,8-13.09,12.91-18.94,10.86-13.05,22.13-25.75,33.45-38.4,8.33-9.31,18.81-14.24,31.49-13.31,5.29.38,8.51-2,11.73-5.84,11.09-13.28,22.52-26.27,33.78-39.41,2.55-3,4.9-6.1,7.35-9.16l-.48-1.49c-6.39,0-12.77,0-19.16,0-4.8-.05-9.61-.09-14.4-.41-3.42-.24-4.42-2.4-2.58-5.19,3.77-5.67,7.26-11.66,11.84-16.63q19.11-20.72,39.09-40.62c11.32-11.23,26.07-13.37,41.16-13.38,28.48,0,57-.28,85.46.58,33.11,1,66.19,3,99.28,4.78a55.24,55.24,0,0,1,11.26,2.14c5.6,1.51,6.77,3.47,3.46,8.08a280.13,280.13,0,0,1-19.65,24.47c-6.91,7.64-14.68,14.5-22,21.79-10.06,10.06-22.41,12.59-36.17,12.37-33.47-.54-67-.51-100.45-.68a209.38,209.38,0,0,0-26.1,1c1.06.51,2.08,1.11,3.16,1.52,8.23,3.16,16.57,6.06,24.68,9.5,7.77,3.28,8.69,7.42,3.43,14.09-7,8.81-14.07,17.49-21.85,27.12,2.59,0,4.31.06,6,0,18.13-.77,36.26-1.72,54.39-2.27,7.47-.23,15,.26,22.45.67,8.62.48,11.79,5.68,6.9,12.65-7.54,10.72-15.74,21-24.22,31-6.44,7.61-13.81,14.44-20.68,21.69s-15.56,10.83-25.37,11.27c-24,1.08-47.94,1.84-71.9,2.8-4.13.17-8.68-.24-12.26,1.37s-6.37,5-8.84,8.22c-14.21,18.25-27.91,36.9-42.4,54.93-13,16.2-26.69,31.91-40.37,47.58-12.68,14.53-28.77,20.34-48,17.51-11-1.63-22.07-2.92-33.08-4.56a30,30,0,0,1-7.59-2.43c-7.89-3.47-9.78-8.43-4.81-15.36,8.71-12.16,18-23.93,27.19-35.73,15.56-19.93,31.27-39.76,46.9-59.64A35.74,35.74,0,0,0,919.32,443.67Z" fill="#fff"></path>
                                <path d="M1389.4,627.32c-25.62,0-54.27-.33-82.92.07-47.81.67-95.63,1.25-143.41,2.9-46.59,1.6-93.17,4-139.7,7q-60.82,3.82-121.51,9.67-70.59,6.72-141,15.11c-30.23,3.55-60.39,7.93-90.46,12.68-40.78,6.44-81.59,12.83-122.11,20.64-42.63,8.22-85,17.86-127.37,27.31-52.17,11.64-103.66,25.92-154.47,42.46-35.26,11.48-70.08,24.36-105.09,36.61l-6.94,2.43-.5-1.13c11.58-6,23-12.27,34.74-18a1274.81,1274.81,0,0,1,124.45-53q64-23.47,129.6-41.82c57.24-16.1,115.06-29.77,173.54-40.29C660,642.07,704,635.47,748,629.54c35-4.71,70.09-8.29,105.26-11,41.32-3.2,82.74-5.7,124.16-7.1,43.45-1.48,87-2.22,130.42-1.58,44.79.65,89.56,3,134.3,5.27,30.93,1.58,61.82,4.06,92.69,6.57C1354.06,623.25,1373.23,625.62,1389.4,627.32Z" fill="#ec6904"></path>
                            </g>
                        </g>
                    </svg>-->
                            </span>
                        </a>
                        <p class="footer-text footer-logo-description mb-4">
                            Fonds de Dévéloppement de Formation Professionnelle.
                        </p>

                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <h6 class="footer-title mb-4">Besoin<span class="badge rounded bg-primary ms-2">d'aide?</span>
                        </h6>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <a href="#" target="_blank" class="footer-link">Consulter les questions
                                    fréquentes</a>
                            </li>
                            <li class="mb-3">
                                <a href="#" target="_blank" class="footer-link">Contacter l'assistance</a>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="footer-bottom py-3">
            <div
                class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
                <div class="mb-2 mb-md-0">
                    <span class="footer-text">©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                    </span>
                    <a href="#" target="_blank" class="fw-medium text-white footer-link">FDFP</a>
                    <span class="footer-text">Tous droits réservés</span>
                </div>
                <div>
                    @foreach ($reseaux as $reseau)
                        <a href="{{ $reseau->mot_cle }}" class="footer-link me-3" target="_blank">
                            <img src="{{ asset('/frontend/logo/' . @$reseau->logo_logo) }}"
                                alt="{{ $reseau->titre_logo }}" />
                        </a>
                    @endforeach
                    <a href="www.barnoininformatique.ci" class="footer-link me-3" target="_blank">Designed by Barnoin
                        Informatique</a>
                </div>
            </div>
        </div>
    </footer> --}}


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


    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/jquery-sticky/jquery-sticky.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select1/select1.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select3/select3.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/forms-file-upload.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/js/pages-enrolements.js') }}"></script>

    <script>
        var selectBox = $("#id_forme_juridique");
        let selectedValue = selectBox.val();
        changeFuncFormeJuridique(selectedValue);

        //Afficher les champs requis ou non en fontion du type de forme juridique
        function changeFuncFormeJuridique(code_forme_juridique_array) {
            const myArray = code_forme_juridique_array.split("/");
            let code_forme_juridique = myArray[0];
            if (code_forme_juridique === 'PR') {
                displayPufield();
            } else if (code_forme_juridique === 'PU') {
                hiddenPufield();
            } else {
                displayPufield();
            }
        }

        function hiddenPufield() {
            $("#rccm_demande_enrolement").prop("disabled", true);
            $("#piece_attestation_immatriculati").prop("disabled", true);
            $("#numero_cnps_demande_enrolement").prop("disabled", true);
            $("#piece_rccm_demande_enrolement").prop("disabled", true);

            $("#rccm_demande_enrolement_div").hide();
            $("#numero_cnps_demande_enrolement_div").hide();
            $("#piece_rccm_demande_enrolement_div").hide();
            $("#piece_attestation_immatriculati_div").hide();
        }

        function displayPufield() {
            $("#rccm_demande_enrolement").prop("disabled", false);
            $("#piece_attestation_immatriculati").prop("disabled", false);
            $("#numero_cnps_demande_enrolement").prop("disabled", false);
            $("#piece_rccm_demande_enrolement").prop("disabled", false);

            $("#rccm_demande_enrolement_div").show();
            $("#numero_cnps_demande_enrolement_div").show();
            $("#piece_rccm_demande_enrolement_div").show();
            $("#piece_attestation_immatriculati_div").show();
        }


        //Select2 localité entreprise
        $("#id_localite").select2().val({{ old('id_localite') }});

        //Select2 centre impot
        $("#id_centre_impot").select2().val({{ old('id_centre_impot') }});

        //Select2 secteur d'activité
        $("#id_secteur_activite").select2().val({{ old('id_secteur_activite') }});
    </script>

    <script>
        $(function() {

            $('#id_secteur_activite').on('change', function(e) {
                var id = e.target.value;
                telUpdate1(id);
            });

            function telUpdate1(id) {
                $.get('/secteuractivilitelistes/' + id, function(data) {
                    $('#id_activites').empty();
                    $.each(data, function(index, tels) {
                        $('#id_activites').append($('<option>', {
                            value: tels.id_activites,
                            text: tels.libelle_activites,
                        }));
                    });
                });
            }
        });
    </script>

    <script>
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'reload-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>


</body>

</html>
