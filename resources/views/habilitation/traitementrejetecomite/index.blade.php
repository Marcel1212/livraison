<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@if(auth()->user()->can('traitementhabilitationrejete-index'))

    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Habilitation')
        @php($titre='Liste des demandes d\'habilitation rejeté')
        @php($lien='traitementhabilitationrejete')

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
                                    <td>{{  @$habilitation->name }} {{  @$habilitation->prenom_users }}</td>
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
                                                } else{
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
                                            <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($habilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt($habilitation->id_comite_rejeter)]) }}"
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

                </div>
            </div>
        </div>

    @endsection
@else
 <script type="text/javascript">
    window.location = "{{ url('/403') }}";//here double curly bracket
</script>
@endif


