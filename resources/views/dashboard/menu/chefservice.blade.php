<?php

use App\Helpers\Menu;
use App\Helpers\DemandeAnnulation;
use App\Helpers\ListeDemandeHabilitationSoumis;
use App\Helpers\AnneeExercice;
use Carbon\Carbon;

$imagedashboard = Menu::get_info_image_dashboard();
$IdUser = Auth::user()->id;
$numAgce = Auth::user()->num_agce;
//dd($IdUser,$numAgce);

$demandehabilitations = ListeDemandeHabilitationSoumis::get_liste_demande_habilitation_soumis($numAgce);
$demandehabilitationsnv = ListeDemandeHabilitationSoumis::get_liste_demande_habilitation_soumis_nouvelle_demande($numAgce);
$demandehabilitationsex = [];
$demandehabilitationsre = [];
$demandehabilitationssb = [];
$demandehabilitationssup = [];

?>

@php($lien='traitementdemandehabilitation')
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
                        <span class="bg-label-info p-2 rounded">
                          <i class="ti ti-device-laptop ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Nouvelle demande d'habilitation reçus</p>
                            <h4 class="text-info mb-0">{{count($demandehabilitationsnv)}}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-success p-2 rounded">
                          <i class="ti ti-bulb ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Demande expensien d'habilitation reçus</p>
                            <h4 class="text-success mb-0">{{count($demandehabilitationsex)}}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-default p-2 rounded">
                          <i class="ti ti-discount-check ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Demande de renouvellement d'habilitation reçus</p>
                            <h4 class="text-default mb-0">{{count($demandehabilitationsre)}}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-warning p-2 rounded">
                          <i class="ti ti-discount-check ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Demande de subtitution d'habilitation reçus</p>
                            <h4 class="text-warning mb-0">{{count($demandehabilitationssb)}}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-danger p-2 rounded">
                          <i class="ti ti-discount-check ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Demande de suppression d'habilitation reçus</p>
                            <h4 class="text-danger mb-0">{{count($demandehabilitationssup)}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            @include('dashboard.annee')
        </div>
    </div>
    <!-- Hour chart End  -->

    <!-- Topic and Instructors -->
    <div class="row mb-4 g-4">


        <div class="col-12 col-xl-6 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Nouvelle demande d'habilitation reçus</h5>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-borderless border-top">
                        <thead class="border-bottom">
                        <tr>
                            <th>Entreprise</th>
                            <th>Date de soumission</th>
                            <th>Type de demande</th>
                            <th class="text-end">Instruction</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($demandehabilitations as $demandehabilitation)
                        <tr>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">{{$demandehabilitation->ncc_entreprises}}</h6>
                                        <small class="text-truncate text-muted">{{$demandehabilitation->raison_social_entreprises}}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">{{ $demandehabilitation->date_soumis_demande_habilitation }}</h6>

                                    </div>
                                </div>
                            </td>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">{{ $demandehabilitation->type_demande }}</h6>

                                    </div>
                                </div>
                            </td>
                            <td class="text-end pt-2">
                                <div class="user-progress mt-lg-4">
                                     @can($lien.'-edit')
                                     <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(9)]) }}"
                                        class=" "
                                           title="Faire la recevabilité"><img
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



