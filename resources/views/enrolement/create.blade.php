<?php
use App\Helpers\Menu;
$logo = Menu::get_logo();
$reseaux = Menu::get_info_reseaux();
?>

<!DOCTYPE html>

<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('assets/')}}"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <?php if(isset($logo->mot_cle)){?>
        <title><?php echo @$logo->mot_cle;?> | demande d'enrolement</title>
    <?php } ?>

    <meta name="description" content="" />

    <!-- Favicon -->
    <?php if(isset($logo->logo_logo)){?>
        <link rel="<?php echo @$logo->mot_cle;?>" type="image/x-icon" href="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}"/>
    <?php } ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/front-page.css')}}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select1/select1.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select3/select3.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-faq.css')}}" />

      <link rel="stylesheet" href="{{asset('assetsfront/css/style.css')}}">


      <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>
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
                                    <button
                                        class="navbar-toggler border-0 px-0 me-2"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#navbarSupportedContent"
                                        aria-controls="navbarSupportedContent"
                                        aria-expanded="false"
                                        aria-label="Toggle navigation">
                                        <i class="ti ti-menu-2 ti-sm align-middle"></i>
                                    </button>
                                    <!-- Mobile menu toggle: End-->
                                    <a href="{{route('/')}}" class="app-brand-link">
              <span class="app-brand-logo demo">
              <img src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}" width="90"/>
                  <!--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1723.46 914.53">
                    <g id="Calque_2" data-name="Calque 2">
                        <g id="Calque_1-2" data-name="Calque 1">
                            <rect width="1723.46" height="914.53" fill="none"/>
                            <path d="M647.4,299.18c-8.16,3-16.26,6.12-24.5,8.86a129.17,129.17,0,0,1-17.64,4.78c-6,1.08-8.51-2.48-5.61-7.95A116.12,116.12,0,0,1,609.7,289q21.69-28.65,43.82-57c7.15-9.13,16.85-14.59,27.87-18,53.09-16.51,107.12-19.28,161.83-10.86,17.52,2.7,34.65,7.06,49.83,17,22.54,14.69,35,34.72,34.52,62.37-.51,27.93-9.63,53-23.35,76.86-18.64,32.47-43.17,60-70.07,85.66C800.4,477.12,764,505.92,724.22,530.29c-44.4,27.22-91,50-141.13,64.62-17.3,5.05-34.89,9-53.09,9.12-10,.08-17.31-4.24-22.49-12.77-5.39-8.88-11.44-17.37-16.63-26.35-7.06-12.23-7.53-25.07-.4-37.35,10.69-18.4,21.09-37.06,33.19-54.52,27.67-39.93,56.21-79.26,84.58-118.71,12.64-17.57,25.71-34.85,38.58-52.26.46-.62.86-1.29,1.29-1.93ZM623.84,488.7c1.66.14,2.35.38,2.91.21,9.79-2.94,19.81-5.32,29.31-9,22.33-8.73,42.31-21.66,61.36-36.08,34.23-25.89,61.74-57.34,78.82-97a55.09,55.09,0,0,0,4.39-23.54c-.9-19.18-14.48-32.9-34.81-37-21.13-4.31-42.32-4.88-63.55-.59l-6.48,1.29,0,1.27c5.91,1.06,12,1.65,17.71,3.29a218.71,218.71,0,0,1,26.65,9c8.18,3.53,9.58,8.64,5.91,16.44a45.76,45.76,0,0,1-4.17,7.3c-6.87,9.51-13.95,18.87-20.81,28.38q-39.75,55.08-79.4,110.24C635.77,471.12,630.12,479.6,623.84,488.7Z"
                                  fill="#0066b1"/>
                            <path d="M236.34,491.21c-4.47-.38-8.43-.4-12.25-1.12-8.06-1.51-10-4.93-6.13-12.2,5.88-11.09,11.85-22.2,18.77-32.64,9.49-14.31,20-27.95,29.92-42,9-12.73,21.32-18.72,36.87-18.68,2.12,0,5.09-1.19,6.25-2.83,15-21.37,29.75-42.93,44.54-64.45.82-1.19,1.4-2.55,2.54-4.65H334.68c-4.92,0-9.86.28-14.75-.14-3.91-.34-5.06-3.12-3.18-6.44,5-8.9,9.62-18.18,15.64-26.38,12.41-16.9,25.4-33.38,38.61-49.67,10.69-13.2,25.95-17.78,42-18.11q76.39-1.56,152.82-1.65c18.63,0,37.33,1.68,55.87,3.77,12.17,1.36,13.77,4.65,7.3,15.23-8.44,13.77-18.19,26.75-27.68,39.84C597,275,591.86,280.2,587.42,286c-10.34,13.43-23.94,18.5-40.72,18.28-21.81-.3-43.64.73-65.46,1.18l-66,1.39a6.77,6.77,0,0,0-4.5,1.48c5.21,2.09,10.48,4,15.62,6.31,5.44,2.38,10.92,4.75,16.1,7.63,7.1,3.95,8.25,9.38,3.87,16.13-7.79,12-15.62,24-23.91,36.77,2.57-.12,4.59-.17,6.6-.31,22.43-1.51,44.86-3.11,67.3-4.51a125.9,125.9,0,0,1,13.86.3c10.49.51,14.48,6.68,9.49,16a318,318,0,0,1-19.17,31.79c-9,12.88-19,25-28.39,37.59-8.62,11.66-20.59,15.8-34.42,16.58-24.6,1.39-49.18,3.13-73.79,4.41-8.87.46-14.51,4.32-19.11,12-26,43.58-52.86,86.63-82.4,127.93a159.8,159.8,0,0,1-16.29,18.63,38.78,38.78,0,0,1-28.57,11.81c-16.76,0-33.34-1.5-49.56-6a39.54,39.54,0,0,1-5.58-2c-8.47-3.82-11.38-10.33-6.94-18.46,6.15-11.29,13.11-22.15,20-33q29.92-47.35,60.06-94.59A17.87,17.87,0,0,0,236.34,491.21Z"
                                  fill="#0066b1"/>
                            <path d="M1310.18,393.93c-7.83,8.87-15.9,17.55-23.46,26.65q-38.48,46.38-76.67,93-1.42,1.73-2.91,3.4c-9.13,10.39-19.39,17.54-34.34,17.87-16.54.36-33,2.1-49.32-1.86a47.16,47.16,0,0,1-8.44-2.87c-5.06-2.31-6.51-6.2-3.53-10.9,3.27-5.14,7.18-9.89,10.94-14.69,42.15-53.79,87-105.25,133-155.79,9.52-10.47,18.85-21.13,29-32.46a20.68,20.68,0,0,0-3.91,0c-11.86,2.92-23.7,5.95-35.58,8.83a36.4,36.4,0,0,1-7.85,1c-6.19.11-8.92-3.5-5.92-8.95a150.22,150.22,0,0,1,13.87-21c17.26-21.64,36.22-41.85,63.13-51a224.63,224.63,0,0,1,49.19-10.87c25.94-2.68,52.11-3.78,78.2-4.07a196.34,196.34,0,0,1,64.48,9.68c10.07,3.35,19.7,7.79,27.57,15.21,12.71,12,14.74,26.83,10.68,42.91-4.85,19.17-16.89,33.86-30.94,47-29.68,27.71-64.07,48.29-100.61,65.46-28.49,13.39-58.07,23.77-89,29.93a103.19,103.19,0,0,1-16.76,1.61c-7.79.24-9.44-2.18-7.34-9.66a119.11,119.11,0,0,1,15.65-34.61c.64-.95,1.25-1.91,1.87-2.87ZM1336,367.81a9.72,9.72,0,0,0,2.27.35c24.28-5.25,47.47-13.49,67.86-27.88,6.12-4.31,11.09-10.82,15.24-17.2,5.44-8.37,2.62-15.28-6.67-18.85a62.81,62.81,0,0,0-12.37-3.46c-17.15-2.78-34.31-1.15-51.42.56-6.63.66-13.2,1.77-19.8,2.68,0,.49-.06,1-.1,1.48,3.74.89,7.49,1.7,11.2,2.68,8.75,2.3,17.79,3.89,26.11,7.26,8.06,3.26,9.05,7.65,3.48,14.24-8.1,9.57-17.12,18.34-25.75,27.46C1342.87,360.54,1339.66,364,1336,367.81Z"
                                  fill="#0066b1"/>
                            <path d="M912.88,440.56c-4.87-.6-9-.83-13-1.65-5.58-1.15-6.91-4-3.88-8.92,4-6.45,8-13,12.82-18.81,10.78-13,22-25.57,33.21-38.13,8.27-9.25,18.68-14.14,31.27-13.22,5.26.38,8.45-2,11.65-5.8,11-13.19,22.37-26.08,33.54-39.13,2.53-2.95,4.87-6.06,7.3-9.1l-.48-1.48c-6.34,0-12.68.05-19,0-4.77,0-9.55-.08-14.3-.41-3.4-.23-4.39-2.38-2.56-5.14,3.74-5.64,7.21-11.59,11.75-16.52q19-20.57,38.82-40.34c11.24-11.15,25.89-13.27,40.87-13.28,28.29,0,56.59-.28,84.86.57,32.88,1,65.73,3,98.59,4.75a55.13,55.13,0,0,1,11.18,2.12c5.56,1.5,6.72,3.45,3.43,8a277.7,277.7,0,0,1-19.51,24.3c-6.86,7.58-14.58,14.39-21.82,21.64-10,10-22.25,12.5-35.92,12.28-33.24-.54-66.49-.51-99.74-.68a208.36,208.36,0,0,0-25.92,1c1,.5,2.06,1.09,3.14,1.51,8.17,3.14,16.45,6,24.5,9.42,7.72,3.27,8.63,7.38,3.41,14-6.9,8.75-14,17.36-21.7,26.93,2.58,0,4.28.06,6,0,18-.77,36-1.71,54-2.26,7.42-.22,14.87.26,22.29.67,8.56.48,11.71,5.64,6.85,12.56-7.49,10.65-15.63,20.89-24,30.83-6.4,7.55-13.71,14.33-20.53,21.53s-15.46,10.76-25.2,11.19c-23.79,1.07-47.6,1.83-71.39,2.79-4.11.16-8.62-.24-12.17,1.35s-6.33,5-8.78,8.16c-14.11,18.12-27.72,36.65-42.1,54.55-12.94,16.09-26.51,31.68-40.09,47.24-12.6,14.44-28.57,20.21-47.63,17.39-10.93-1.62-21.92-2.89-32.85-4.52a30.46,30.46,0,0,1-7.53-2.41c-7.84-3.45-9.72-8.38-4.78-15.26,8.65-12.07,17.85-23.76,27-35.48,15.45-19.79,31.05-39.48,46.57-59.22C911.59,442.87,912,442,912.88,440.56Z"
                                  fill="#0066b1"/>
                            <path d="M1379.66,622.92c-25.43,0-53.89-.32-82.33.07-47.48.67-95,1.25-142.41,2.88-46.27,1.59-92.52,4-138.72,6.91q-60.39,3.81-120.66,9.61-70.1,6.68-140,15c-30,3.53-60,7.87-89.83,12.59-40.49,6.39-81,12.74-121.25,20.5-42.33,8.16-84.4,17.73-126.48,27.12-51.8,11.56-102.93,25.73-153.38,42.16-35,11.4-69.59,24.19-104.36,36.36l-6.89,2.41-.49-1.13c11.49-6,22.87-12.18,34.49-17.9a1267.66,1267.66,0,0,1,123.57-52.58q63.53-23.31,128.7-41.52c56.84-16,114.25-29.57,172.33-40C655.33,637.57,699,631,742.75,625.13c34.71-4.68,69.6-8.23,104.52-10.94,41-3.18,82.16-5.66,123.29-7.06,43.14-1.46,86.35-2.2,129.51-1.57,44.47.65,88.93,3,133.36,5.24,30.71,1.57,61.38,4,92,6.53C1344.57,618.88,1363.61,621.24,1379.66,622.92Z"
                                  fill="#ec6904"/>
                        </g>
                    </g>
                </svg>-->



              </span>

                                    </a>
                                </div>
                                <!-- Menu logo wrapper: End -->
                                <!-- Menu wrapper: Start -->
                                <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">

                                    <ul class="navbar-nav me-auto">

                                    </ul>
                                </div>
                                <div class="landing-menu-overlay d-lg-none"></div>
                                <!-- Menu wrapper: End -->
                                <!-- Toolbar: Start -->
                                <ul class="navbar-nav flex-row align-items-center ms-auto">
                                    <!-- Style Switcher -->
                                    <!-- / Style Switcher-->

                                    <!-- navbar button: Start -->
                                    <li>
                                        <a href="{{route('connexion')}}" class="btn btn-primary" target="_blank"
                                        ><span class="tf-icons ti ti-login scaleX-n1-rtl me-md-1"></span
                                            ><span class="d-none d-md-block">se connecter</span></a
                                        >
                                    </li>
                                    <!-- navbar button: End -->
                                </ul>
                                <!-- Toolbar: End -->
                            </div>
                        </div>
                    </nav>
                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->

                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div
                                class="faq-header d-flex flex-column justify-content-center align-items-center rounded">
                                <h3 class="text-center"></h3>

                            </div>
                            <p class="text-center mb-0 px-3"></p>
                        </div>

                    </div>

                    <div class="container-xxl flex-grow-1 container-p-y">

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                {{ $message }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                {{ $message }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if ($message = Session::get('errors'))
                        <!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                {{ $message }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>-->
                        @endif

                        @if($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                {{ $error }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endforeach
                        @endif
                        <!-- Sticky Actions -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div
                                        class="card-header bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                                        <h3 class="card-title mb-sm-0 me-2">Demande d'enrôlement</h3>
                                        <div class="action-btns">
                                            <button class="btn btn-label-primary me-3">
                                                <span class="align-middle"> <a href="{{route('/')}}">Retour</a></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-9 mx-auto">
                                                <!-- 1. Delivery Address -->

                                                <h5 class="my-4">1. Renseigner les informations </h5>

                                                <form method="POST" class="form"
                                                      action="{{ route('enrolements.store') }}"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row g-3">

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="fullname">Dénomination
                                                                    sociale</label>
                                                                <input type="text" id="raison_sociale_demande_enroleme"
                                                                       name="raison_sociale_demande_enroleme"
                                                                       class="form-control"
                                                                       placeholder="ASSOCIATION SERVICE MEDIATION"
                                                                       required="required"/>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="email">Email</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input
                                                                        class="form-control"
                                                                        type="text"
                                                                        id="email"
                                                                        name="email_demande_enrolement"
                                                                        placeholder=""
                                                                        aria-label=""
                                                                        aria-describedby="email3"/>
                                                                    <span class="input-group-text" id="email3"
                                                                          required="required"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <!--<label class="form-label" for="phone-number-mask">Téléphone du représentant</label>-->
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label"
                                                                               for="billings-country">Indicatif</label>
                                                                        <select class="form-select input-group-text"
                                                                                data-allow-clear="true"
                                                                                name="indicatif_demande_enrolement">
                                                                            <?= $pay; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <label class="form-label">Telephone </label>
                                                                        <input type="number"
                                                                               name="tel_demande_enrolement"
                                                                               class="form-control" placeholder=""
                                                                               required="required"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="state">Localité</label>
                                                                <select class="select2 form-select"
                                                                        data-allow-clear="true" name="id_localite"
                                                                        required="required">
                                                                    <?= $localite; ?>
                                                                </select>

                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="form-label" for="state">Centre des
                                                                    impôts</label>
                                                                <select class="select2 form-select"
                                                                        data-allow-clear="true" name="id_centre_impot"
                                                                        required="required">
                                                                    <?= $centreimpot; ?>
                                                                </select>

                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="form-label" for="state">Activités</label>
                                                                <select class="select2 form-select"
                                                                        data-allow-clear="true" name="id_activites"
                                                                        required="required">
                                                                    <?= $activite; ?>
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-4 col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                           for="collapsible-ncc-name">NCC</label>
                                                                    <input
                                                                        type="text"
                                                                        id="collapsible-payment-name"
                                                                        class="form-control"
                                                                        placeholder="" name="ncc_demande_enrolement"
                                                                        required="required"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                           for="collapsible-rccm-name">RCCM</label>
                                                                    <input
                                                                        type="text"
                                                                        class="form-control"
                                                                        placeholder="" name="rccm_demande_enrolement"
                                                                        required="required"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                           for="collapsible-cnps-name">N° CNPS</label>

                                                                    <input
                                                                        type="text"
                                                                        class="form-control"
                                                                        maxlength=""
                                                                        placeholder=""
                                                                        name="numero_cnps_demande_enrolement"
                                                                        required="required"/>


                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>


                                                    <hr/>

                                                    <!-- 2. Delivery Type -->
                                                    <h5 class="my-4">2. Joindre les documents</h5>


                                                    <div class="row gy-3">

                                                        <div class="col-md-4">
                                                            <label class="form-label">Piece DFE * (PDF, JPG, JPEG, PNG)
                                                                5M</label>
                                                            <input type="file" name="piece_dfe_demande_enrolement"
                                                                   class="form-control" placeholder=""
                                                                   required="required"/>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Piece RCCM * (PDF, JPG, JPEG, PNG)
                                                                5M</label>
                                                            <input type="file" name="piece_rccm_demande_enrolement"
                                                                   class="form-control" placeholder=""
                                                                   required="required"/>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Piece attestation immat * (PDF,
                                                                JPG, JPEG, PNG) 5M</label>
                                                            <input type="file" name="piece_attestation_immatriculati"
                                                                   class="form-control" placeholder=""
                                                                   required="required"/>
                                                        </div>

                                                    </div>

                                                    <br/>
                                                    <hr>

                                                    <h5 class="my-4">3. Verificateur de securite</h5>

                                                    <div class="row gy-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group mt-4 mb-4">
                                                                <div class="captcha">
                                                                    <span><?php echo captcha_img(); ?></span>
                                                                    <button type="button"
                                                                            class="btn-label-secondary waves-effect"
                                                                            class="reload" id="reload">
                                                                        &#x21bb;
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="form-group mb-4">
                                                                <input id="captcha" type="text" class="form-control"
                                                                       placeholder="Enter Captcha" name="captcha">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <hr>
                                                    <!-- 3. Apply Promo code -->
                                                    <div class="row">

                                                        <div class="col-sm-12 col-4 text-end mt-0">
                                                            <button class="btn btn-primary">Enregistrer</button>
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

    <footer class="landing-footer bg-body footer-text mt-4">
      <div class="footer-top">
        <div class="container">
          <div class="row gx-0 gy-4 g-md-5">
            <div class="col-lg-7">
              <a href="{{route('/')}}" class="app-brand-link mb-4">
                <span class="app-brand-logo demo">
                <img src="{{ asset('/frontend/logo/logo-blanc.png')}}"/>
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
              <h6 class="footer-title mb-4">Besoin<span class="badge rounded bg-primary ms-2">d'aide?</span></h6>
              <ul class="list-unstyled">
                <li class="mb-3">
                  <a href="#" target="_blank" class="footer-link">Consulter les questions fréquentes</a>
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
        <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
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
                  @foreach($reseaux as $reseau)
                    <a href="{{$reseau->mot_cle}}" class="footer-link me-3" target="_blank">
                        <img
                                src="{{ asset('/frontend/logo/'. @$reseau->logo_logo)}}"
                                alt="{{$reseau->titre_logo}}"/>
                    </a>
                  @endforeach
          </div>
        </div>
      </div>
    </footer>


    <!--<footer class="footer-wrapper pt-45 footer-layout1" data-bg-src="{{asset('assetsfront/img/bg/footer-bg.png')}}">

        <div class="footer-wrap  " data-bg-src="{{asset('assetsfront/img/bg/jiji.png')}}">
            <div class="widget-area">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-xxl-3 col-xl-3">
                            <div class="widget footer-widget">
                                <div class="th-widget-about">
                                    <div class="about-logo">
                                        <a href="{{route('/')}}"><img src="{{asset('assetsfront/img/logo-white.png')}}" alt="FDFP"></a>
                                    </div>
                                    <p class="about-text">Fonds de Dévéloppement de Formation Professionnelle.</p>
                                    <div class="th-social">
                                        <h6 class="title text-white">SUIVEZ-NOUS SUR:</h6>
                                        @foreach($reseaux as $reseau)
                                        <a href="{{$reseau->mot_cle}}" target="_blank"><i class="{{$reseau->titre_logo}}"></i></a>
                                        <!--<a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>-->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xxl-3 col-xl-3">
                            <div class="widget newsletter-widget footer-widget">
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title">Besoin d'aide?</h3>
                                <div class="menu-all-pages-container">
                                    <ul class="menu">
                                        <li><a href="#">Consulter les questions fréquentes</a></li>
                                        <li><a href="#">Contacter l'assistance</a></li>
                                        <li><a href="#">Conditions générales</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright-wrap">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <p class="copyright-text">Copyright © <?php /*echo Date('Y') ;*/?>; <a href="{{route('/')}}">FDFP</a> Tous droits réservés.</p>
                        </div>
                        <div class="col-md-6 text-end d-none d-md-block">
                            <div class="footer-links">
                                <ul>
                                    <li><a href="#">Politique de confidentialité</a></li>
                                    <li><a href="www.barnoininformatique.ci">Designed by Barnoin Informatique</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>-->


    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/node-waves/node-waves.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/i18n/i18n.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('assets/vendor/libs/jquery-sticky/jquery-sticky.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select1/select1.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select3/select3.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/forms-file-upload.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('assets/js/form-layouts.js')}}"></script>

    <script type="text/javascript">
    $('#reload').click(function () {
        //alert('tesr');
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
      });

  </script>
  </body>
</html>
