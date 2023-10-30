<?php

use App\Helpers\Menu;

$idutil = Auth::user()->id;
$idutilClient = Auth::user()->id_partenaire;
$tabl = Menu::get_menu($idutil);
$naroles = Menu::get_menu_profil($idutil);
$monUrl = substr($_SERVER['REQUEST_URI'], 1);
$monUrlTerminer = strstr($monUrl, '/', true);
if ($monUrlTerminer == true) {
    $monUrlTerminer = strstr($monUrl, '/', true);
} else {
    $monUrlTerminer = $monUrl;
}

$logo = Menu::get_logo();
?>

<!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="/dashboard" class="app-brand-link">
              <span class="app-brand-logo demo">
                    <?php if(isset($logo->logo_logo)){?>
                        <img alt="Logo" src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}" width="32" height="22"  style="margin:5px; padding: 5px"/>
                    <?php } ?>
                <!--<svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                </svg>-->
              </span>
              <span class="app-brand-text demo menu-text fw-bold ">{{@$logo->mot_cle1}}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
              <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <?php if (Auth::user()->flag_mdp == true){
                    $i = 0;
            foreach ($tabl as $key => $tablvue) {
                    $i++;
                ?>
			<li  class="menu-item <?php if ($tablvue[0]->sousmenu == $monUrlTerminer) {
                    echo 'active open';
                } ;?>">
				
              <a href="<?php echo $key; ?>" class="menu-link menu-toggle">
                <!--<i class="menu-icon tf-icons ti ti-smart-home"></i>-->
                <?php if (isset($tablvue[0]->icone)) { ?>
                    {!! $tablvue[0]->icone !!}
                <?php } else { ?>
                    <i data-feather='menu'></i>
                <?php } ?>				
                <div data-i18n="{{$tablvue[0]->menu}}">{{ strtoupper($tablvue[0]->menu) }}</div>
                <!--<div class="badge bg-primary rounded-pill ms-auto">5</div>-->
              </a>
              <ul class="menu-sub">
			  <?php foreach ($tablvue as $key => $vue) { ?>
                <li class="menu-item <?php if (stripos($vue->sousmenu, $monUrlTerminer) !== FALSE) {
                            echo 'active';
                        } ?>">
                  <a href="{{ url('/'.$vue->sousmenu)}}" class="menu-link">
                    <div data-i18n="<?= $vue->libelle; ?>"><?= $vue->libelle; ?></div>
                  </a>
                </li>
                
				<?php } ?>
              </ul>
            </li>
        <?php }
                } ?>
          </ul>
        </aside>
        <!-- / Menu -->