<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Agreement')
    @php($titre='Liste des agreements pour les plans de formations')
    @php($lien='agreement')

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

    @if(!isset($anneexercice->id_periode_exercice))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="alert-body" style="text-align:center">
                 {{$anneexercice}}
            </div>
            <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
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
                            <th>Code </th>
                            <th>Nom et prenom de la charger de formation</th>
                            <th>Montant demandée</th>
                            <th>Montant accordée</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                            <?php $i=0; ?>
                        @foreach ($agreements as $key => $planformation)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ @$planformation->code_plan_formation }}</td>
                                <td>{{ $planformation->nom_prenoms_charge_plan_formati }}</td>
                                <td>{{ $planformation->cout_total_demande_plan_formation }}</td>
                                <td>{{ $planformation->cout_total_accorder_plan_formation }}</td>
                                <td align="center">
                                    @can($lien.'-edit')
                                        <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)]) }}"
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



