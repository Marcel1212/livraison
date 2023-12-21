<?php

use App\Helpers\Menu;
use App\Helpers\ListePlanFormationSoumis;
use App\Helpers\AnneeExercice;
use Carbon\Carbon;

$imagedashboard = Menu::get_info_image_dashboard();
$anneexercice = AnneeExercice::get_annee_exercice();

$IdUser = Auth::user()->id;
$numAgce = Auth::user()->num_agce;

$planformations = ListePlanFormationSoumis::get_liste_plan_formation_soumis($IdUser,$numAgce);
$planformationstraitement = ListePlanFormationSoumis::get_plan_en_traitement($IdUser);
$planformationssoumis = ListePlanFormationSoumis::get_plan_en_soumis_ct($IdUser);
//dd($planformations);
?>

@php($lien='traitementplanformation')
    <!-- Hour chart  -->
    <div class="card bg-transparent shadow-none my-4 border-0">
        <div class="card-body row p-0 pb-3">
            <div class="col-12 col-md-8 card-separator">
                <h3 class="text text-dark"> Bonjour {{Auth::user()->name .' '.Auth::user()->prenom_users}}</strong>,  👋🏻</h3>
                <div class="col-12 col-lg-7">
                    <p>Bienvenue sur notre application web ! Nous sommes ravis de vous avoir parmi nous. Nous espérons que vous apprécierez votre expérience avec nous !</p>
                </div>
                <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                    <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                        <span class="bg-label-primary p-2 rounded">
                          <i class="ti ti-device-laptop ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Plan de formation non attribuer</p>
                            <h4 class="text-primary mb-0">{{count($planformations)}}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-info p-2 rounded">
                          <i class="ti ti-bulb ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Plan en traitement</p>
                            <h4 class="text-info mb-0">{{count($planformationstraitement)}}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-warning p-2 rounded">
                          <i class="ti ti-discount-check ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Plan soumis au CT</p>
                            <h4 class="text-warning mb-0">{{count($planformationssoumis)}}</h4>
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
    <div class="row mb-4 g-4">
        <div class="col-12 col-xl-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Topic you are interested in</h5>
                    <div class="dropdown">
                        <button
                            class="btn p-0"
                            type="button"
                            id="topic"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topic">
                            <a class="dropdown-item" href="javascript:void(0);">Highest Views</a>
                            <a class="dropdown-item" href="javascript:void(0);">See All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <div id="horizontalBarChart"></div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-around align-items-center">
                        <div>
                            <div class="d-flex align-items-baseline">
                                <span class="text-primary me-2"><i class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">UI Design</p>
                                    <h5>35%</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline my-3">
                                <span class="text-success me-2"><i class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">Music</p>
                                    <h5>14%</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <span class="text-danger me-2"><i class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">React</p>
                                    <h5>10%</h5>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-baseline">
                                                <span class="text-info me-2"><i
                                                        class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">UX Design</p>
                                    <h5>20%</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline my-3">
                                                <span class="text-secondary me-2"><i
                                                        class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">Animation</p>
                                    <h5>12%</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <span class="text-warning me-2"><i class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">SEO</p>
                                    <h5>9%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Plan de formation non attribuer</h5>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-borderless border-top">
                        <thead class="border-bottom">
                        <tr>
                            <th>Entreprise</th>
                            <th>Date de soumission</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($planformations as $planformation)
                        <tr>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">{{$planformation->ncc_entreprises}}</h6>
                                        <small class="text-truncate text-muted">{{$planformation->raison_social_entreprises}}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">{{ $planformation->date_soumis_plan_formation }}</h6>

                                    </div>
                                </div>
                            </td>
                            <td class="text-end pt-2">
                                <div class="user-progress mt-lg-4">
                                     @can($lien.'-edit')
                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}"
                                           class=" "
                                           title="Modifier"><img
                                                src='/assets/img/editing.png'></a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!--  Topic and Instructors  End-->



