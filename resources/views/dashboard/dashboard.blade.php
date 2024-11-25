<?php

use App\Helpers\Crypt;

?>

@extends('layouts.backLayout.designadmin')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <?php if ($nacodes == "ADMIN") { ?>
                @include('dashboard.menu.admin')
                <?php } elseif($nacodes == "DECID") { ?>
                @include('dashboard.menu.decideur')
                <?php } elseif($nacodes == "ENTREPRISE") { ?>
                @include('dashboard.menu.entreprise')
                <?php } elseif($nacodes == "AGTENR") { ?>
                @include('dashboard.menu.agentenroleur')
                <?php } elseif($nacodes == "CONSEILLER") { ?>
                @include('dashboard.menu.conseiller')
                <?php } elseif($nacodes == "CHEFSERVICE") { ?>
                @include('dashboard.menu.chefservice')
                <?php } elseif($nacodes == "CHARGEHABIL") { ?>
                @include('dashboard.menu.chargerhabilitation')
                <?php } elseif($naroles == "GESTIONNAIRE LIVRAISON") { ?>
                @include('dashboard.menu.gestionnaire')
                <?php  } elseif($naroles == "LIVREUR") { ?>
                @include('dashboard.menu.livreur')
                <?php }  elseif($naroles == "CLIENT") { ?>
                @include('dashboard.menu.clientlivraison')
                <?php } else { ?>
                @include('dashboard.menu.autre')
                <?php } ?>
            </div>
        </div>
    </div>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />
@endsection
