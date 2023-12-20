<?php

use App\Helpers\Menu;
use App\Helpers\AnneeExercice;
use Carbon\Carbon;

$imagedashboard = Menu::get_info_image_dashboard();
$anneexercice = AnneeExercice::get_annee_exercice();
$iduser = Auth::user()->id;
$projetetudeenattente = ProjetEtude::where([['id_user', '=', $iduser], ['flag_attente_rec', '=', true]])->get();
$projetetuderecevable = ProjetEtude::where([['id_user', '=', $iduser], ['flag_valide', '=', true]])->get();
$projetetudesoumis = ProjetEtude::where([['id_user', '=', $iduser], ['flag_soumis', '=', true]])->get();
$projetetudenonsoumis = ProjetEtude::where([['id_user', '=', $iduser], ['flag_soumis', '=', false]])->get();

//dd(count($projetetudeenattente));

?>

@php($lien = 'projetetude')
@php($lienformation = 'projetformation')

<!-- Hour chart  -->
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
            <h3 class="text text-dark"> Bonjour {{ Auth::user()->name . ' ' . Auth::user()->prenom_users }}</strong>,
                👋🏻
            </h3>
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
                                <span class="text-muted">Du</span> <?php $dacon = Carbon::parse($anneexercice->date_debut_periode_exercice); ?>
                                <span class="badge bg-label-success">{{ strtoupper($dacon->format('d M Y')) }} </span>
                                <span class="text-muted"> au </span> <?php $daconf = Carbon::parse($anneexercice->date_fin_periode_exercice); ?>
                                <span class="badge bg-label-danger"> {{ strtoupper($daconf->format('d M Y')) }}</span>
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
                    <a href="{{ route('planformation.index') }}">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti ti-folder-filled"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">Plan de formation</h4>
                            </div>
                            <a href="{{ route($lienformation . '.create') }}" class="mb-1">
                                Cliquer ici pour éffectuer une
                                demande</a>
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
                            <a href="{{ route($lien . '.create') }}" class="mb-1">
                                Cliquer ici pour éffectuer une
                                demande</a>
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
                    <h5 class="m-0 me-2">Notifications</h5>
                </div>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="popularInstructors" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">

                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless border-top">
                    <thead class="border-bottom">
                        <tr>
                            <th>Projet d'etudes</th>
                            <th class="text-end">Nbres</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">

                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Projet soumis</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end pt-2">
                                <div class="user-progress mt-lg-4">
                                    <p class="mb-0 fw-medium"><?php echo count($projetetudesoumis); ?></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">

                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Projet non-soumis</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium"><?php echo count($projetetudenonsoumis); ?></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">

                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Projet en attente</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium"><?php echo count($projetetudeenattente); ?></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">

                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Projet recevable</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium"><?php echo count($projetetuderecevable); ?></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-borderless border-top">
                    <thead class="border-bottom">
                        <tr>
                            <th>Projet de formation</th>
                            <th class="text-end">Nbres</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">

                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Projet soumis</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end pt-2">
                                <div class="user-progress mt-lg-4">
                                    <p class="mb-0 fw-medium">0</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">

                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Projet non-soumis</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">0</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">

                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Projet en attente</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">0</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">

                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Projet recevable</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">0</p>
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
