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
                <?php } else { ?>
                @include('dashboard.menu.autre')
                <?php } ?>
            </div>
        </div>
    </div>

@endsection
