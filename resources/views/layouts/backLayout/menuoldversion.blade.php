<!-- BEGIN: Main Menu-->
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
<div class="horizontal-menu-wrapper">
    <div
        class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-shadow menu-border "
        role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="/dashboard">
                        <span class="brand-logo">
                                 <!--<img  src="/app-assets/images/logo/logo.png">-->
                                 <?php if(isset($logo->logo_logo)){?>
                                    <img alt="Logo" src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}" height="40" style="margin:5px; padding: 5px"/>
                                <?php } ?>
                        </span>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                            class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i></a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <!-- Horizontal menu content-->
        <div class="navbar-container main-menu-content bg-menu-2ge  " data-menu="menu-container">
            <!-- include /includes/mixins-->
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <?php if (Auth::user()->flag_mdp == true){
                    $i = 0;
                foreach ($tabl as $key => $tablvue) {
                    $i++;
                    ?>

                <li class="dropdown nav-item <?php if ($tablvue[0]->sousmenu == $monUrlTerminer) {
                    echo 'has-sub sidebar-group-active open';
                } ;?>" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="#<?php echo $key; ?>"
                       data-bs-toggle="dropdown">
                            <?php if (isset($tablvue[0]->icone)) { ?>
                        {!! $tablvue[0]->icone !!}
                        <?php } else { ?>
                        <i data-feather='menu'></i>

                        <?php } ?>
                        <span data-i18n="{{$tablvue[0]->menu}}">{{ strtoupper($tablvue[0]->menu) }}</span>
                    </a>

                    <ul class="dropdown-menu" data-bs-popper="none">
                            <?php foreach ($tablvue as $key => $vue) { ?>
                        <li class="<?php if (stripos($vue->sousmenu, $monUrlTerminer) !== FALSE) {
                            echo 'active';
                        } ?>" data-menu="">
                            <a class="dropdown-item d-flex align-items-center"
                               href="{{ url('/'.$vue->sousmenu)}}" data-bs-toggle=""
                               data-i18n="Analytics"><i data-feather='corner-down-right'></i><span
                                    data-i18n="<?= $vue->libelle; ?>"><?= $vue->libelle; ?></span></a>
                        </li>
                        <?php } ?>

                    </ul>
                </li>

                <?php }
                } ?>


            </ul>
        </div>
    </div>
</div>


<!-- END: Main Menu-->
