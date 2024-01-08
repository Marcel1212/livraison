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
                    <?php if (isset($logo->logo_logo)){ ?>
                        <img alt="Logo" src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}" height="35"
                             style="margin:5px; padding: 5px"/>
                    <?php } ?>
              </span>
            <span class="app-brand-text demo menu-text fw-bold ">{{@$logo->mot_cle1}}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Application</span>
        </li>
        @if(Auth::user()->flag_mdp == true)
            @foreach($tabl as $key=>$tablvue)
                <li class="menu-item @foreach ($tablvue as $key_vue=>$vue){{ Request::routeIs($vue->sousmenu.'*') ? 'open' : ''}}@endforeach">
                    <a href="{{$key}}" class="menu-link menu-toggle">
                        @isset($tablvue[0]->icone)
                            {!! $tablvue[0]->icone !!}
                        @else
                            <i data-feather='menu'></i>
                        @endisset
                        <div data-i18n="{{$tablvue[0]->menu}}">{{ strtoupper($tablvue[0]->menu) }}</div>
                    </a>
                    <ul class="menu-sub">

                    @foreach ($tablvue as $key_vue=>$vue)



                    <li class="menu-item  {{ Request::routeIs($vue->sousmenu.'*') ? 'active' : '' }}">
                        <a href="{{ url('/'.$vue->sousmenu)}}" class="menu-link">
                            <div data-i18n="<?= $vue->libelle; ?>"><?= $vue->libelle; ?></div>
                        </a>
                    </li>
                @endforeach
                    </ul>

                </li>
            @endforeach
        @endif
    </ul>
</aside>
<!-- / Menu -->
