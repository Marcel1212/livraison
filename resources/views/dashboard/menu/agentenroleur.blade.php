<?php

use App\Helpers\Menu;
use App\Helpers\AnneeExercice;
use App\Helpers\StatAgentEnroleur;
use Carbon\Carbon;

$nbrnontraiter = count(StatAgentEnroleur::get_infos_enrolement_non_tratier());
$nbrvalider = count(StatAgentEnroleur::get_infos_enrolement_valider());
$nbrnonrejeter = count(StatAgentEnroleur::get_infos_enrolement_rejeter());

$imagedashboard = Menu::get_info_image_dashboard();

$imagedashboard = Menu::get_info_image_dashboard();
$anneexercice = AnneeExercice::get_annee_exercice();

$imagedashboard = Menu::get_info_image_dashboard();
?>



    <!-- Hour chart  -->
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
            <h3 class="text text-dark"> Bonjour {{Auth::user()->name .' '.Auth::user()->prenom_users}}</strong>, 👋🏻</h3>
            <div class="col-12 col-lg-12">
                <p>Bienvenue sur notre application web ! Nous sommes ravis de vous avoir parmi nous. Nous espérons que
                    vous apprécierez votre expérience avec nous !</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap gap-3 me-5">

                <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-info p-2 rounded">
                          <i class="ti ti-bulb ti-folder"></i>
                        </span>
                    <div class="content-right">
                        <p class="mb-0">Enrolement non traité</p>
                        <h4 class="text-info mb-0">{{$nbrnontraiter}}</h4>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-success p-2 rounded">
                          <i class="ti ti-bulb ti-folder"></i>
                        </span>
                    <div class="content-right">
                        <p class="mb-0">Enrolement  validé</p>
                        <h4 class="text-success mb-0">{{$nbrvalider}}</h4>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-danger p-2 rounded">
                          <i class="ti ti-bulb ti-folder"></i>
                        </span>
                    <div class="content-right">
                        <p class="mb-0">Enrolement rejeté</p>
                        <h4 class="text-danger mb-0">{{$nbrnonrejeter}}</h4>
                    </div>
                </div>

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
<div class="row ">
    <div class="col-12 col-xl-8">
        <div class="row">

            <div class="col-lg-12 col-sm-12 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <a href="{{route('enrolement.index')}}">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-folder-filled"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">Traitement des enrolements</h4>
                            </div>
                            <p class="mb-1">Cliquer ici pour éffectuer un tratiement </p>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="col-12 col-xl-4 col-md-6">
        <div class="card h-100">


        </div>
    </div>

</div>
<!--  Topic and Instructors  End-->



