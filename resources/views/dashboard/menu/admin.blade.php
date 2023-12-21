<?php

use App\Helpers\Menu;
use App\Helpers\AnneeExercice;
use Carbon\Carbon;

$imagedashboard = Menu::get_info_acceuil();
$anneexercice = AnneeExercice::get_annee_exercice();

$imagedashboard = Menu::get_info_image_dashboard();
?>


    <!-- Hour chart  -->
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
            <h3 class="text text-dark"> Bonjour {{Auth::user()->name .' '.Auth::user()->prenom_users}}</strong>, 👋🏻</h3>
            <div class="col-12 col-lg-7">
                <p>Bienvenue sur notre application web ! Nous sommes ravis de vous avoir parmi nous. Nous espérons que
                    vous apprécierez votre expérience avec nous !</p>
            </div>

        </div>
        <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div>
                        <h5 class="mb-2">Période d'exercice</h5>
                    </div>
                    <div class="time-spending-chart">
                        <?php if (isset($anneexercice->id_periode_exercice)){ ?>
                        <h3 class="mb-2">
                            <span
                                class="text-muted">Du</span> <?php $dacon = Carbon::parse($anneexercice->date_debut_periode_exercice); ?>
                            <span class="badge bg-label-success">{{ strtoupper($dacon->format('d M Y')) }} </span>
                            <span
                                class="text-muted"> au </span> <?php $daconf = Carbon::parse($anneexercice->date_fin_periode_exercice); ?>
                            <span class="badge bg-label-danger"> {{ strtoupper($daconf->format('d M Y')) }}</span>
                        </h3>
                            <?php if (!empty($anneexercice->date_prolongation_periode_exercice)){ ?>
                        <h3 class="mb-2">

                            <span class="text-muted">Prolongée jusqu'au </span>
                            <span
                                class="badge bg-label-success">{{$anneexercice->date_prolongation_periode_exercice}} </span>

                        </h3>
                        <?php } ?>
                        <?php }else{ ?>
                        <h3 class="mb-2">

                            <span class="text-danger mb-0">{{$anneexercice}}</span>

                        </h3>
                        <?php } ?>
                        <?php //} ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hour chart End  -->

<!-- Topic and Instructors -->
<div class="row mb-4 g-4">
    <div class="col-12 col-xl-12">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <img src="{{ asset('/frontend/logo/'. $imagedashboard->logo_logo)}}" alt="" >
            </div>
        </div>
    </div>
</div>
<!--  Topic and Instructors  End-->



