<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>
{{--@if(auth()->user()->can('commissionevaluationoffres-index'))--}}
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Evaluation offre')
    @php($titre='Liste des commissions')
    @php($lien='commissionevaluationoffres')
    @php($lienacceuil='dashboard')

    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light">
            <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i> Accueil</a> / {{$Module}} / </span> {{$titre}}
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
{{--                        @can($lien.'-create')--}}
                            <a href="{{ route($lien.'.create') }}"
                               class="btn btn-sm btn-primary waves-effect waves-light">
                                <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter </a>
{{--                        @endcan--}}
                    </small>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-striped table-hover table-sm"
                           id="exampleData"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Code </th>
                            <th>Libelle </th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Objet</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; ?>
                        @foreach ($commission_evaluation_offres as $key => $commission_evaluation_offre)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ @$commission_evaluation_offre->code_commission_evaluation_offre }}</td>
                                <td>Projet d'étude</td>
                                <td>{{ @$commission_evaluation_offre->date_debut_commission_evaluation_offre }}</td>
                                <td>{{ @$commission_evaluation_offre->date_fin_commission_evaluation_offre }}</td>
                                <td>{{ @$commission_evaluation_offre->commentaire_commission_evaluation_offre }}</td>
                                <td align="center">
                                    <?php if($commission_evaluation_offre->flag_statut_commission_evaluation_offre == true){ ?>
                                        <span class="badge bg-success">Terminer</span>
                                    <?php  }else{?>
                                            <span class="badge bg-warning">En cours</span>
                                    <?php } ?>
                                </td>
                                <td align="center">
{{--                                    @can($lien.'-edit')--}}
                                        <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commission_evaluation_offre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                           class=" "
                                           title="Modifier"><img
                                                src='/assets/img/editing.png'></a>
{{--                                    @endcan--}}
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

{{--@else--}}
{{--    <script type="text/javascript">--}}
{{--        window.location = "{{ url('/403') }}";//here double curly bracket--}}
{{--    </script>--}}
{{--@endif--}}


