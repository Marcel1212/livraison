<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>
@if(auth()->user()->can('traitementcomitetechniques-index'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Comite')
    @php($titre='Liste des comites techniques')
    @php($lien='traitementcomitetechniques')
    @php($lienacceuil='dashboard')

    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light">   <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i> Accueil</a> / {{$Module}} / </span> {{$titre}}
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
                        @can($lien.'-create')
                            <a href="{{ route($lien.'.create') }}"
                               class="btn btn-sm btn-primary waves-effect waves-light">
                                <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter </a>
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
                            <th>Code </th>
                            <th>Libelle </th>
                            <th>Processus </th>
                            <th>Date debut</th>
                            <th>Date fin</th>
                            <th>Objet</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; ?>
                        @foreach ($comites as $key => $comitep)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ @$comitep->code_comite }}</td>
                                <td>{{ @$comitep->libelle_categorie_comite }}</td>
                                <td>{{ @$comitep->libelle_processus_comite }}</td>
                                <td>{{ $comitep->date_debut_comite }}</td>
                                <td>{{ $comitep->date_fin_comite }}</td>
                                <td>{{ $comitep->commentaire_comite }}</td>
                                <td align="center">
                                    <?php if($comitep->flag_statut_comite == true){ ?>
                                        <span class="badge bg-success">Terminer</span>
                                    <?php  }else{?>
                                            <span class="badge bg-warning">En cours</span>
                                    <?php } ?>
                                </td>
                                <td align="center">
                                    @can($lien.'-edit')
                                        <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($comitep->id_comite),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
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


