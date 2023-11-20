<?php

use App\Helpers\Menu;
use App\Helpers\AnneeExercice;

$imagedashboard = Menu::get_info_image_dashboard();
$anneexercice = AnneeExercice::get_annee_exercice();

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
                <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                        <span class="bg-label-success p-2 rounded">
                          <i class="ti ti-device-laptop ti-report-money ti-xl"></i>
                        </span>
                    <div class="content-right">
                        <p class="mb-0">&Agrave; jour de mes cotisations ?</p>
                        <h4 class="text-success mb-0">OUI</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-info p-2 rounded">
                          <i class="ti ti-bulb ti-folder ti-xl"></i>
                        </span>
                    <div class="content-right">
                        <p class="mb-0">Demande en cours de traitement</p>
                        <h4 class="text-info mb-0">82</h4>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-warning p-2 rounded">
                          <i class="ti ti-discount-check ti-xl"></i>
                        </span>
                    <div class="content-right">
                        <p class="mb-0">Demandes traitées</p>
                        <h4 class="text-warning mb-0">14</h4>
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
                        <?php if(isset($anneexercice->id_periode_exercice)){ ?>
                            <h3 class="mb-2">
                                <span class="text-muted">Du</span> 
                                <span class="badge bg-label-success">{{$anneexercice->date_debut_periode_exercice}} </span>
                                <span class="text-muted"> au </span> 
                                <span class="badge bg-label-danger"> {{$anneexercice->date_fin_periode_exercice}}</span>
                            </h3>
                            <?php if(!empty($anneexercice->date_prolongation_periode_exercice)){ ?>
                                <h3 class="mb-2">

                                    <span class="text-muted">Prolongée jusqu'au </span> 
                                    <span class="badge bg-label-success">{{$anneexercice->date_prolongation_periode_exercice}} </span>

                                </h3>
                            <?php } ?>
                        <?php }else{ ?>
                            <h3 class="mb-2">

                                <span class="text-danger mb-0">{{$anneexercice}}</span> 

                            </h3>
                        <?php } ?>

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

            <!-- Card Border Shadow -->

            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card card-border-shadow-primary h-100">
                    <a href="{{route('planformation.index')}}">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-folder-filled"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">Plan de formation</h4>
                            </div>
                            <p class="mb-1">Cliquer ici pour éffectuer une demande </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card card-border-shadow-warning h-100">
                    <a href="">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-warning"><i
                                            class="ti ti-folder-plus ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">Projet de formation</h4>
                            </div>
                            <p class="mb-1">Cliquer ici pour éffectuer une demande </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card card-border-shadow-danger h-100">
                    <a href="">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-danger"><i
                                            class="ti ti-school ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">Projet d'étude</h4>
                            </div>
                            <p class="mb-1">Cliquer ici pour éffectuer une demande </p>
                        </div>
                    </a>
                </div>
            </div>
            <!--/ Card Border Shadow -->

        </div>
    </div>

    <div class="col-12 col-xl-4 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Popular Instructors</h5>
                </div>
                <div class="dropdown">
                    <button
                        class="btn p-0"
                        type="button"
                        id="popularInstructors"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"
                         aria-labelledby="popularInstructors">
                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless border-top">
                    <thead class="border-bottom">
                    <tr>
                        <th>Instructors</th>
                        <th class="text-end">courses</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="pt-2">
                            <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                <div class="avatar me-3 avatar-sm">
                                    <img src="/assets/img/avatars/1.png" alt="Avatar"
                                         class="rounded-circle"/>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0">Maven Analytics</h6>
                                    <small class="text-truncate text-muted">Business
                                        Intelligence</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pt-2">
                            <div class="user-progress mt-lg-4">
                                <p class="mb-0 fw-medium">33</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar me-3 avatar-sm">
                                    <img src="/assets/img/avatars/2.png" alt="Avatar"
                                         class="rounded-circle"/>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0">Zsazsa McCleverty</h6>
                                    <small class="text-truncate text-muted">Digital
                                        Marketing</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="user-progress">
                                <p class="mb-0 fw-medium">52</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar me-3 avatar-sm">
                                    <img src="/assets/img/avatars/3.png" alt="Avatar"
                                         class="rounded-circle"/>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0">Nathan Wagner</h6>
                                    <small class="text-truncate text-muted">UI/UX Design</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="user-progress">
                                <p class="mb-0 fw-medium">12</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="avatar me-3 avatar-sm">
                                    <img src="/assets/img/avatars/4.png" alt="Avatar"
                                         class="rounded-circle"/>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0">Emma Bowen</h6>
                                    <small class="text-truncate text-muted">React Native</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="user-progress">
                                <p class="mb-0 fw-medium">8</p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--  Topic and Instructors  End-->



