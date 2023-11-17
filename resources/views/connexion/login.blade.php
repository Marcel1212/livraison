<?php

use App\Helpers\Menu;

$logo = Menu::get_logo();
$infosa = Menu::get_info_acceuil();
$couleur = Menu::get_info_couleur();
?>

<!DOCTYPE html>

<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('assets/')}}"
  data-template="horizontal-menu-template-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <?php if(isset($logo->mot_cle)){?>
          <title><?php echo @$logo->mot_cle;?> | Connexion</title>
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
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover authentication-bg">
      <div class="authentication-inner row">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 p-0">
          <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img
              src="{{asset('assets/img/illustrations/auth-login-illustration-light.png')}}"
              alt="auth-login-cover"
              class="img-fluid my-5 auth-illustration" />

            <img
              src="{{asset('assets/img/illustrations/bg-shape-image-light.png')}}"
              alt="auth-login-cover"
              class="platform-bg" />
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
          <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
              <a href="{{route('/')}}" class="app-brand-link gap-2">
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
            <!-- /Logo -->
            <h3 class="mb-1">Bienvenue !</h3>
            <p class="mb-4">Connectez-vous à votre compte</p>

            <form id="formAuthentication" class="mb-3" action="{{ url('connexion') }}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                  @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="alert-body">
                                <b>Echec: </b> {{ $message }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
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
              <div class="mb-3">
                <label for="username" class="form-label">Mon identifiant</label>
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  name="username"
                  placeholder="Mon identifiant"
                  autofocus/>
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Mon mot de passe</label>
                  <a href="#">
                    <small>Mot de passe oublié ?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
              </div>
              <!--<div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" />
                  <label class="form-check-label" for="remember-me"> Souvenez-vous de moi </label>
                </div>
              </div>-->
              <div class="form-group mt-4 mb-4">
                <div class="captcha">
                    <span><?php echo captcha_img(); ?></span>
                    <button type="button" class="btn-label-secondary waves-effect" class="reload" id="reload">
                    &#x21bb;
                    </button>
                </div>
                </div>
        
                <div class="form-group mb-4">
                    <span></span>
                    <label class="form-label">Saisir les caractères ci-dessus</label>
                    <input id="captcha" type="text" class="form-control" placeholder="Saisir les caractères ci-dessus" name="captcha">
                </div>
              
              <button type="submit" class="btn btn-primary d-grid w-100">Se connecter</button>
            </form>

            <p class="text-center">
              <span>Vous êtes nouveau sur la plateforme ?</span>
              <a href="{{route('enrolements')}}">
                <span>Faites vous enroler</span>
              </a>
            </p>

            <div class="divider my-4">
              <div class="divider-text">Nous suivre</div>
            </div>

            <div class="d-flex justify-content-center">
              <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                <i class="tf-icons fa-brands fa-google fs-5"></i>
              </a>

              <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                <i class="tf-icons fa-brands fa-twitter fs-5"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>

    <!-- / Content -->

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
    <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('assets/js/pages-auth.js')}}"></script>

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
