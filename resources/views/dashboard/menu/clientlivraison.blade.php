<?php

use App\Helpers\Menu;
use App\Helpers\AnneeExercice;
use App\Helpers\ListeDemandeHabilitationSoumis;
use Carbon\Carbon;
$imagedashboard = Menu::get_info_image_dashboard();
$imagedashboard = Menu::get_info_image_dashboard();
$numAgce = Auth::user()->num_agce;
$idlivreur = Auth::user()->id;
$lien = 'traitementlivraisonprix';

?>
<!-- Hour chart  -->
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
    rel="stylesheet" />
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-12 card-separator">
            <h3 class="text text-dark"> Bonjour {{ Auth::user()->name . ' ' . Auth::user()->prenom_users }}</strong>,
                👋🏻
            </h3>
            <div class="col-12 col-lg-12">
                <p>Bienvenue sur LOS LIVRAISON ! Nous sommes ravis de vous avoir parmi nous. Nous espérons que
                    vous apprécierez votre expérience avec nous !</p>
            </div>
        </div>
        <br>
        <br>
        <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
            <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                <span class="bg-label-info p-2 rounded">
                    <i class="ti ti-device-laptop ti-xl"></i>
                </span>
                <div class="content-right">
                    <p class="mb-0">Nouvelle de livaison en attente de traiment</p>
                    <h4 class="text-info mb-0">0</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="bg-label-success p-2 rounded">
                    <i class="ti ti-bulb ti-xl"></i>
                </span>
                <div class="content-right">
                    <p class="mb-0">Nouvelle de livaison en cours de livraison</p>
                    <h4 class="text-success mb-0">0</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="bg-label-default p-2 rounded">
                    <i class="ti ti-discount-check ti-xl"></i>
                </span>
                <div class="content-right">
                    <p class="mb-0">Nouvelle de livaison livré</p>
                    <h4 class="text-default mb-0">0</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="bg-label-warning p-2 rounded">
                    <i class="ti ti-discount-check ti-xl"></i>
                </span>
                <div class="content-right">
                    <p class="mb-0">Nouvelle de livaison echoué</p>
                    <h4 class="text-warning mb-0">0</h4>
                    {{-- {{ count($demandehabilitationssb) }} --}}
                </div>
            </div>

        </div>
    </div>


</div>



<!-- Hour chart End  -->
<div class="row mb-4 g-4">
    <div class="col-12 col-xl-12">
        <div class="card h-100">
            <div align="center">
                <img src="{{ asset('/frontend/logo/' . $imagedashboard->logo_logo) }}" alt="">
            </div>
        </div>
    </div>
</div>
