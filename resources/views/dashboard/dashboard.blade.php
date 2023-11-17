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
                <?php } else { ?>
                @include('dashboard.menu.autre')
                <?php } ?>
            </div>
        </div>
    </div>

@endsection
