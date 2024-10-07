<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@if(auth()->user()->can('demandehabilitation-index'))

    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Habilitation')
        @php($titre='Liste des demandes habilitation')
        @php($lien='demandehabilitation')

        <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / </span> {{$titre}}
        </h5>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{$titre}}</h5>
                        <small class="text-muted float-end">
                            @can($lien.'-create')
{{--                                 <a href="#"
                                class="btn btn-sm btn-primary waves-effect waves-light">
                                    <i class="menu-icon tf-icons ti ti-plus"></i> Creer </a> --}}
                                    @if($formejuridique == 'PR')
                                        <a href="{{ route($lien.'.create') }}"  class="btn btn-sm btn-info me-1 mt-1"> <i class="menu-icon tf-icons ti ti-plus"></i> Nouvelle demande</a>
                                    @else
                                        <a href="#"  class="btn btn-sm btn-info me-1 mt-1"> <i class="menu-icon tf-icons ti ti-plus"></i> Nouvelle demande</a>
                                    @endif
                            @endcan
                        </small>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Responsable formation </th>
                                <th>Code </th>
                                <th>Nom du chargé d'habilitation</th>
                                <th>Date de création</th>
                                <th>Date de soumission</th>
                                <th>Date d'agrément</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; ?>
                            @foreach ($habilitations as $key => $habilitation)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ @$habilitation->nom_responsable_demande_habilitation }}</td>
                                    <td>{{ @$habilitation->code_demande_habilitation }}</td>
                                    <td>{{  @$habilitation->userchargehabilitation->name }} {{  @$habilitation->userchargehabilitation->prenom_users }}</td>
                                    <td>{{ @$habilitation->date_creer_demande_habilitation }}</td>
                                    <td>{{ @$habilitation->date_soumis_demande_habilitation }}</td>
                                    <td>{{ @$habilitation->date_agrement_demande_habilitation }}</td>
                                    <td align="center">
                                        <?php
                                            $flags = [
                                                'soumis' => $habilitation->flag_soumis_demande_habilitation,
                                                'reception' => $habilitation->flag_reception_demande_habilitation,
                                                'valide' => $habilitation->flag_valide_demande_habilitation,
                                                'rejet' => $habilitation->flag_rejet_demande_habilitation,
                                                'agrement' => $habilitation->flag_agrement_demande_habilitaion,
                                                'annulation' => $habilitation->flag_annulation_plan,
                                            ];

                                            // Déterminer le badge à afficher
                                            if ($flags['soumis'] === true && $flags['reception'] === true) {
                                                if ($flags['valide']) {
                                                    $badge = '<span class="badge bg-success">Valider</span>';
                                                } elseif ($flags['agrement']) {
                                                    $badge = '<span class="badge bg-success">Agrée</span>';
                                                } else {
                                                    $badge = '<span class="badge bg-warning">En cours de traitement</span>';
                                                }
                                            } elseif ($flags['soumis'] === true && $flags['reception'] === false)  {
                                                if ($flags['valide']) {
                                                    $badge = '<span class="badge bg-success">Valider</span>';
                                                } elseif ($flags['agrement']) {
                                                    $badge = '<span class="badge bg-success">Agrée</span>';
                                                } elseif ($flags['rejet']) {
                                                    $badge = '<span class="badge bg-secondary">Soumis</span>';
                                                } elseif ($flags['annulation']) {
                                                    $badge = '<span class="badge bg-danger">Annulé</span>';
                                                } else {
                                                    $badge = '<span class="badge bg-warning">En cours de traitement</span>';
                                                }
                                            } elseif ($flags['soumis'] === false) {
                                                if ($flags['reception'] === false) {
                                                    $badge = '<span class="badge bg-primary">Non Soumis</span>';
                                                } elseif ($flags['rejet']) {
                                                    $badge = '<span class="badge bg-danger">Non recevable</span>';
                                                } else {
                                                    $badge = '<span class="badge bg-secondary">Soumis</span>';
                                                }
                                            } else {
                                                $badge = '<span class="badge bg-danger">Non recevable</span>';
                                            }

                                            echo $badge;
                                            ?>
                                    </td>
                                    <td align="center">
                                        @can($lien.'-edit')
                                            <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($habilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                            class=" "
                                            title="Modifier"><img
                                                    src='/assets/img/editing.png'></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                    <!-- add new card modal  -->
                    <div class="modal fade" id="addNewhabilitation" tabindex="-1" aria-labelledby="addNewhabilitationTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50">
                                    @if($formejuridique == 'PR')
                                        @if(count($habilitations)<1 )
                                            <a href="{{ route($lien.'.create') }}"  class="btn btn-sm btn-info me-1 mt-1">Nouvelle demande</a>
                                        @else
                                            <a href="#"  class="btn btn-sm btn-success me-1 mt-1">Demande d'extension </a>
                                            <a href="#"  class="btn btn-sm btn-secondary me-1 mt-1">Demande de renouvellement </a>
                                            <a href="#"  class="btn btn-sm btn-primary me-1 mt-1">Demande de subtitution </a>
                                            <a href="#"  class="btn btn-sm btn-danger me-1 mt-1">Demande de suppression </a>
                                        @endif
                                        {{-- <button type="reset" class="btn btn-sm btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">Annuler</button> --}}
                                    @else
                                        <a href="#"  class="btn btn-sm btn-info me-1 mt-1">Nouvelle demande</a>
                                        {{-- <button type="reset" class="btn btn-sm btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">Annuler</button> --}}
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ add new card modal  -->
                </div>
            </div>
        </div>

    @endsection
@else
 <script type="text/javascript">
    window.location = "{{ url('/403') }}";//here double curly bracket
</script>
@endif


