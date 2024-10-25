<!DOCTYPE html>
<?php

use App\Helpers\Menu;

$idutil = Auth::user()->id;
$naroles = Menu::get_menu_profil($idutil);
if (Auth::user()->photo_profil != '') {
    $iconUser = '/photoprofile/' . Auth::user()->photo_profil;
} else {
    $iconUser = '/assets/img/avatars/1.png';
}
$logo = Menu::get_logo();
$imagedashboard = Menu::get_info_image_dashboard();
?>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
      data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title><?php if (isset($logo->mot_cle)) {
            echo @$logo->mot_cle;
        } else {
            echo 'Application de gestion du FDFP';
        } ?></title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet"/>

        {{-- <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/vendors.min.css')}}"> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/calendars/fullcalendar.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/pickers/flatpickr/flatpickr.min.css')}}">

    {{-- <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-calendar.css"> --}}
     <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/bootstrap.css')}}">
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/bootstrap-extended.css')}}"> --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">


    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/quill/snow.css')}}"/>

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/fonts/fontawesome.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/fonts/tabler-icons.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/fonts/flag-icons.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/form-validation.css')}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/rtl/core.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/rtl/theme-default.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/css/demo.css')}}"/>
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/node-waves/node-waves.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/typeahead-js/typeahead.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}"/>
    <link rel="stylesheet"
          href="{{asset('/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}"/>
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/plugins/forms/pickers/form-flat-pickr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/plugins/forms/pickers/form-pickadate.css')}}">

    {{-- <link rel="stylesheet" href="{{asset('/assets/vendor/libs/flatpickr/flatpickr.css')}}"/> --}}
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/apex-charts/apex-charts.css')}}"/>

    {{-- <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/plugins/forms/pickers/form-flat-pickr.css')}}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

    <link rel="stylesheet" type="text/css" href="{{asset('/assets/vendor/css/pages/app-calendar.css')}}">

    <!-- Page CSS -->
<style>7


    .ql-snow .ql-editor{
        border-bottom-left-radius: 2px;
        border-bottom-right-radius: 2px;
    }

    .light-style .ql-snow.ql-toolbar, .light-style .ql-snow .ql-toolbar{
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
    }
    .ql-container{
        height: auto;
    }
    .ql-editor{
        height: 250px !important;
        overflow: scroll;
    }

    .ql-editor[contenteditable=false] {
        background-color: rgba(75, 70, 92, 0.08);
    }
</style>
    <!-- Helpers -->
    <script src="{{asset('/assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('/assets/js/config.js')}}"></script>

</head>

<body onload="startTime()">
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('layouts.backLayout.menu')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav
                class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme container-fluid"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="ti ti-menu-2 ti-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper mb-0">
                            <a class="nav-link bookmark-star">
                                <i class="menu-icon tf-icons ti ti-calendar"></i>
                            </a>
                        </div>
                    </div>
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper mb-0">
                            <a class="nav-link bookmark-star">
                                <div id="clock" class="ets-clock"></div>
                            </a>
                        </div>
                    </div>
                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-auto">

                        <!-- Notification -->
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                               data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                {{ Auth::user()->name . ' ' . Auth::user()->prenom_users }}<br>
                                @if ( Auth::user()->direction)
                             {{ Auth::user()->direction->libelle_direction }}
                                @endif

                                <em>( {{ $naroles }} ) </em>
                            </a>
                        </li>

                    </ul>
                    <!--/ Notification -->

                    <!-- User -->
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                           data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                                <img src="{{ $iconUser }}" alt class="h-auto rounded-circle"/>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="pages-account-settings-account.html">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar avatar-online">
                                                <img src="{{ $iconUser }}" alt class="h-auto rounded-circle"/>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                                <span
                                                    class="fw-medium d-block">{{ Auth::user()->name . ' ' . Auth::user()->prenom_users }}</span>
                                            <small
                                                class="text-muted">{{ $naroles }}<?php if (isset(Auth::user()->num_agce)) { ?>
                                                <em>
                                                    ({{ @Auth::user()->agence->lib_agce }})</em><?php } ?></small>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <div class="dropdown-divider"></div>

                                @if ( Auth::user()->direction)

                                <span class="dropdown-item">

                                <i class="ti ti-arrow-right me-2 ti-sm"></i>
                                Direction:  <span class="form-text">{{  Auth::user()->direction->libelle_direction}} </span>

                            </span>
                                @endif

                                    </li>
                                    <li>
                                        @if ( Auth::user()->departement)

                                        <span class="dropdown-item">

                                        <i class="ti ti-flag me-2 ti-sm"></i>
                                        Département:  <span class="form-text">{{ Auth::user()->departement->libelle_departement }}</span>

                                    </span>
                                        @endif

                                    </li>
                                    <li>
                                        @if ( Auth::user()->service)

                                        <span class="dropdown-item">

                                        <i class="ti ti-briefcase me-2 ti-sm"></i>
                                        Service:  <span class="form-text">{{ Auth::user()->service->libelle_service  }}</span>

                                        </span>
                                        @endif
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profil') }}">
                                            <i class="ti ti-user-check me-2 ti-sm"></i>
                                            <span class="align-middle">Mon profil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('deconnexion') }}">
                                            <i class="ti ti-logout me-2 ti-sm"></i>
                                            <span class="align-middle">Déconnexion</span>
                                        </a>
                                    </li>
                        </ul>
                    </li>
                    <!--/ User -->
                </div>

            </nav>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="flex-grow-1 container-p-y container-fluid ">
                    @yield('content')
                </div>
            </div>
            <!-- / Content -->
            <!-- Footer -->
            @include('layouts.backLayout.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>

            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<!-- / Layout wrapper -->

<!-- Core JS -->
<script src="{{asset('/assets/js/codeapp.js')}}"></script>

<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset('/assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('/assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('/assets/vendor/js/menu.js')}}"></script>

<!-- Vendors JS -->
{{-- <script src="{{asset('/assets/vendor/js/vendors.min.js')}}"></script> --}}
<script src="{{asset('/assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/tagify/tagify.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/bloodhound/bloodhound.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('/assets/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('/assets/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('/assets/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>

<!-- Main JS -->
<script src="{{asset('/assets/js/main.js')}}"></script>



<script src="{{asset('/assets/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('/assets/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<!-- Page JS -->
<script src="{{asset('/assets/js/forms-selects.js')}}"></script>
<script src="{{asset('/assets/js/forms-tagify.js')}}"></script>
<script src="{{asset('/assets/js/forms-typeahead.js')}}"></script>
<script src="{{asset('/assets/js/app-academy-dashboard.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/quill/quill.min.js')}}"></script>


    <script src="{{asset('/assets/vendor/js/calendar/fullcalendar.min.js')}}"></script>


<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/fr.js"></script>

    <script>
    var win = null;

    function NewWindow(mypage, myname, w, h, scroll, pos, niveau) {

        if (pos == "random") {
            LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
            TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
        }
        if (pos == "center") {
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
        } else if ((pos != "center" && pos != "random") || pos == null) {
            LeftPosition = 0;
            TopPosition = 20
        }
        settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' +
            scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes';

        if ((win == null || win.closed) && (mypage != '#')) {
            win = window.open(mypage, myname, settings);
            win.focus();
        } else {
            win.close();
            if ((mypage != '#')) {
                win = window.open(mypage, myname, settings);
                win.focus();
            }
        }

    }

    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })

    function startTime() {
        let today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        var day = today.getDay();
        var Y = today.getFullYear();
        var dayarr = ["Dimance", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
        day = dayarr[day];
        //  let ampm = h >= 24 ; h = h % 24; h = h ? h : 24; // the hour '0' should  be '12' m = m < 10 ? '0'+m : m; h = h < 10 ? '0'+h : h; s = s < 10 ? '0'+s : s;
        document.getElementById('clock').innerHTML = day + " <?= date('d/m/Y') ?> " + h + ":" + m + ":" + s;
        let t = setTimeout(startTime, 500);
    }

    $(document).ready(function () {
        $('#exampleData').DataTable();
    });


    flatpickr(".month", {
        locale: "fr",                 // Définit la langue sur le français

        dateFormat: "Y-m",
        altInput: true,
        altFormat: "F Y",
        shorthand: false,
        plugins: [
            new monthSelectPlugin({
                dateFormat: "Y-m",
                altFormat: "F Y",
                theme: "light"
            })
        ]
    });

    // $('.').flatpickr({
    //      plugins: [
    //     new monthSelectPlugin({
    //       shorthand: true, //defaults to false
    //       dateFormat: "m.y", //defaults to "F Y"
    //       altFormat: "F Y", //defaults to "F Y"
    //       theme: "dark" // defaults to "light"
    //     })
    // ]
        //   ],
    //     altInput: true,
    //     shorthand: true,

    //   altFormat: 'F Y',
    //   dateFormat: 'Y-m'
    // });

    $('input.number').keyup(function(event) {
        if(event.which >= 37 && event.which <= 40){
            event.preventDefault();
        }
        $(this).val(function(index, value) {
            return value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        });
    });
</script>



@yield('js_perso')
</body>

</html>
