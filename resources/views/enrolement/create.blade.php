<?php 
use App\Helpers\Menu;
$logo = Menu::get_logo();
?>

<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-wide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assetsnewversion/"
  data-template="front-pages">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <?php if(isset($logo->mot_cle)){?>
        <title><?php echo @$logo->mot_cle;?></title>
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

    <link rel="stylesheet" href="/assetsnewversion/vendor/fonts/tabler-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assetsnewversion/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assetsnewversion/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assetsnewversion/css/demo.css" />
    <link rel="stylesheet" href="/assetsnewversion/vendor/css/pages/front-page.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assetsnewversion/vendor/libs/node-waves/node-waves.css" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="/assetsnewversion/vendor/css/pages/front-page-payment.css" />

    <!-- Helpers -->
    <script src="/assetsnewversion/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/assetsnewversion/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assetsnewversion/js/front-config.js"></script>
  </head>

  <body>
    <script src="/assetsnewversion/vendor/js/dropdown-hover.js"></script>
    <script src="/assetsnewversion/vendor/js/mega-dropdown.js"></script>

    <!-- Navbar: Start -->
    
    <!-- Navbar: End -->

    <!-- Sections:Start -->

    <section class="section-py bg-body first-section-pt">
      <div class="container mt-2">
        <div class="card px-3">
          <div class="row">

            <div class="col-lg-12 card-body border-end">
              <h4 class="mb-2">Activation de compte</h4>
              <p class="mb-0">
                Voulez vous activer votre compte e-FDFP?
              </p>


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
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
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
              <h4 class="mt-2 mb-4">Veuillez renseigner les informations ci-dessous</h4>
              <form method="POST" class="form" action="{{ route('enrolement.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                  <div class="col-md-4">
                    <label class="form-label">Raison sociale </label>
                    <input type="text" name="raison_sociale_demande_enroleme"  class="form-control" placeholder="" required="required"/>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label" for="billings-email">Email</label>
                    <input type="text" id="billings-email" name="email_demande_enrolement" class="form-control" placeholder="" />
                  </div>                
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="form-label" for="billings-country">Indicatif</label>
                        <select class="form-select" data-allow-clear="true" name="indicatif_demande_enrolement">
                            <?= $pay; ?>
                        </select>
                      </div>                     
                      <div class="col-md-8">
                        <label class="form-label">Telephone  </label>
                        <input type="number" name="tel_demande_enrolement"  class="form-control" placeholder="" required="required"/>
                      </div>
                    </div>
                  </div> 


                 <div class="col-md-4">
                    <label class="form-label" for="billings-country">Localite</label>
                    <select  class="form-select" data-allow-clear="true" name="id_localite">
                        <?= $localite; ?>
                    </select>
                  </div>                 
                  <div class="col-md-4">
                    <label class="form-label" for="billings-country">Centre impot</label>
                    <select class="form-select" data-allow-clear="true" name="id_centre_impot">
                        <?= $centreimpot; ?>
                    </select>
                  </div>                 
                  <div class="col-md-4">
                    <label class="form-label" for="billings-country">Activité</label>
                    <select class="form-select" data-allow-clear="true" name="id_activites">
                        <?= $activite; ?>
                    </select>
                  </div>                 



                  <div class="col-md-4">
                    <label class="form-label">NCC </label>
                    <input type="text" name="ncc_demande_enrolement"  class="form-control" placeholder="" maxlength="8" required="required"/>
                  </div>   
                  <div class="col-md-4">
                    <label class="form-label">RCCM  </label>
                    <input type="text" name="rccm_demande_enrolement"  class="form-control" placeholder="" required="required"/>
                  </div>                               
                  <div class="col-md-4">
                    <label class="form-label">Numero CNPS </label>
                    <input type="number" name="numero_cnps_demande_enrolement"  class="form-control" placeholder="" required="required"/>
                  </div>                  



                  <div class="col-md-4">
                    <label class="form-label">Piece DFE * (PDF, JPG, JPEG, PNG) 5M</label>
                    <input type="file" name="piece_dfe_demande_enrolement"  class="form-control" placeholder="" required="required"/>
                  </div>                  
                  <div class="col-md-4">
                    <label class="form-label">Piece RCCM * (PDF, JPG, JPEG, PNG) 5M</label>
                    <input type="file" name="piece_rccm_demande_enrolement"  class="form-control" placeholder="" required="required"/>
                  </div>                  
                  <div class="col-md-4">
                    <label class="form-label">Piece attestation immatriculation * (PDF, JPG, JPEG, PNG) 5M</label>
                    <input type="file" name="piece_attestation_immatriculati"  class="form-control" placeholder="" required="required"/>
                  </div>
                </div>

                <div class="col-12" align="right">
                    <hr>
                      <button type="submit" class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                        Enregistrer
                     </button>
                </div>

              </form>
              
            </div>
            
          </div>
        </div>
      </div>
    </section>

    <!-- Modal -->
    <!-- Pricing Modal -->
    
    <!--/ Pricing Modal -->

    <script src="/assetsnewversion/js/pages-pricing.js"></script>

    <!-- /Modal -->

    <!-- / Sections:End -->

    <!-- Footer: Start -->
    <footer class="landing-footer bg-body footer-text">
      <div class="footer-top">
        <div class="container">
          <div class="row gx-0 gy-4 g-md-5">
            <div class="col-lg-5">
              <a href="landing-page.html" class="app-brand-link mb-4">
                <span class="app-brand-logo demo">
                  <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                      fill="#7367F0" />
                    <path
                      opacity="0.06"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                      fill="#161616" />
                    <path
                      opacity="0.06"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                      fill="#161616" />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                      fill="#7367F0" />
                  </svg>
                </span>
                <span class="app-brand-text demo footer-link fw-bold ms-2 ps-1">Vuexy</span>
              </a>
              <p class="footer-text footer-logo-description mb-4">
                Most developer friendly & highly customisable Admin Dashboard Template.
              </p>
              <form class="footer-form">
                <label for="footer-email" class="small">Subscribe to newsletter</label>
                <div class="d-flex mt-1">
                  <input
                    type="email"
                    class="form-control rounded-0 rounded-start-bottom rounded-start-top"
                    id="footer-email"
                    placeholder="Your email" />
                  <button
                    type="submit"
                    class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">
                    Subscribe
                  </button>
                </div>
              </form>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
              <h6 class="footer-title mb-4">Demos</h6>
              <ul class="list-unstyled">
                <li class="mb-3">
                  <a href="../vertical-menu-template/" target="_blank" class="footer-link">Vertical Layout</a>
                </li>
                <li class="mb-3">
                  <a href="../horizontal-menu-template/" target="_blank" class="footer-link">Horizontal Layout</a>
                </li>
                <li class="mb-3">
                  <a href="../vertical-menu-template-bordered/" target="_blank" class="footer-link">Bordered Layout</a>
                </li>
                <li class="mb-3">
                  <a href="../vertical-menu-template-semi-dark/" target="_blank" class="footer-link"
                    >Semi Dark Layout</a
                  >
                </li>
                <li class="mb-3">
                  <a href="../vertical-menu-template-dark/" target="_blank" class="footer-link">Dark Layout</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
              <h6 class="footer-title mb-4">Pages</h6>
              <ul class="list-unstyled">
                <li class="mb-3">
                  <a href="pricing-page.html" class="footer-link">Pricing</a>
                </li>
                <li class="mb-3">
                  <a href="payment-page.html" class="footer-link"
                    >Payment<span class="badge rounded bg-primary ms-2">New</span></a
                  >
                </li>
                <li class="mb-3">
                  <a href="checkout-page.html" class="footer-link">Checkout</a>
                </li>
                <li class="mb-3">
                  <a href="help-center-landing.html" class="footer-link">Help Center</a>
                </li>
                <li class="mb-3">
                  <a href="../vertical-menu-template/auth-login-cover.html" target="_blank" class="footer-link"
                    >Login/Register</a
                  >
                </li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-4">
              <h6 class="footer-title mb-4">Download our app</h6>
              <a href="javascript:void(0);" class="d-block footer-link mb-3 pb-2"
                ><img src="/assetsnewversion/img/front-pages/landing-page/apple-icon.png" alt="apple icon"
              /></a>
              <a href="javascript:void(0);" class="d-block footer-link"
                ><img src="/assetsnewversion/img/front-pages/landing-page/google-play-icon.png" alt="google play icon"
              /></a>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom py-3">
        <div
          class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
          <div class="mb-2 mb-md-0">
            <span class="footer-text"
              >©
              <script>
                document.write(new Date().getFullYear());
              </script>
            </span>
            <a href="https://pixinvent.com" target="_blank" class="fw-medium text-white footer-link">Pixinvent,</a>
            <span class="footer-text"> Made with ❤️ for a better web.</span>
          </div>
          <div>
            <a href="https://github.com/pixinvent" class="footer-link me-3" target="_blank">
              <img
                src="/assetsnewversion/img/front-pages/icons/github-light.png"
                alt="github icon"
                data-app-light-img="front-pages/icons/github-light.png"
                data-app-dark-img="front-pages/icons/github-dark.png" />
            </a>
            <a href="https://www.facebook.com/pixinvents/" class="footer-link me-3" target="_blank">
              <img
                src="/assetsnewversion/img/front-pages/icons/facebook-light.png"
                alt="facebook icon"
                data-app-light-img="front-pages/icons/facebook-light.png"
                data-app-dark-img="front-pages/icons/facebook-dark.png" />
            </a>
            <a href="https://twitter.com/pixinvents" class="footer-link me-3" target="_blank">
              <img
                src="/assetsnewversion/img/front-pages/icons/twitter-light.png"
                alt="twitter icon"
                data-app-light-img="front-pages/icons/twitter-light.png"
                data-app-dark-img="front-pages/icons/twitter-dark.png" />
            </a>
            <a href="https://www.instagram.com/pixinvents/" class="footer-link" target="_blank">
              <img
                src="/assetsnewversion/img/front-pages/icons/instagram-light.png"
                alt="google icon"
                data-app-light-img="front-pages/icons/instagram-light.png"
                data-app-dark-img="front-pages/icons/instagram-dark.png" />
            </a>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer: End -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assetsnewversion/vendor/libs/popper/popper.js"></script>
    <script src="/assetsnewversion/vendor/js/bootstrap.js"></script>
    <script src="/assetsnewversion/vendor/libs/node-waves/node-waves.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assetsnewversion/vendor/libs/cleavejs/cleave.js"></script>

    <!-- Main JS -->
    <script src="/assetsnewversion/js/front-main.js"></script>

    <!-- Page JS -->
    <script src="/assetsnewversion/js/pages-pricing.js"></script>
    <script src="/assetsnewversion/js/front-page-payment.js"></script>
  </body>
</html>
