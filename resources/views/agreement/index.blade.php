<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Agréement')
    @php($titre='Liste des agréements pour les plans de formations')
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
                            <th>Entreprise</th>
                            <th>Conseiller en charge</th>
                            <th>Montant demandée</th>
                            <th>Montant accordée</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($agreements as $key => $planformation)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ @$planformation->code_plan_formation }}</td>
                                <td>{{ $planformation->raison_social_entreprises }}</td>
                                <td>{{ $planformation->name }} {{ $planformation->prenom_users }}</td>
                                <td>{{ $planformation->cout_total_demande_plan_formation }}</td>
                                <td>{{ $planformation->cout_total_accorder_plan_formation }}</td>
                                <td>
                                    @isset($planformation->flag_annulation_plan)
                                        <span class="badge bg-danger">Annulé</span>
                                    @else
                                        <span class="badge bg-success xs">Agrée</span>
                                    @endisset
                                </td>
                                <td align="center">
                                    <a onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank" class=" "title="Afficher"><img src='/assets/img/eye-solid.png'></a>

{{--                                    @can($lien.'-edit')--}}
                                    <a href="{{ route($lien.'.edit',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(4)])}}"
                                       class="me-2"
                                       title="Modifier"><img
                                            src='/assets/img/editing.png'></a>
{{--                                    @endcan--}}
{{--                                    @can($lien.'-cancel')--}}
                                        @if($anneexercice->date_fin_periode_exercice>now())
                                            @if($planformation->flag_annulation_plan)
                                                <a href="{{ route($lien.'.edit',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(5)])}}"
                                                   class="btn btn-danger btn-xs"
                                                   title="Annuler">Annuler l'agréement</a>

{{--                                                <a href="{{ route($lien.'.cancel',['id'=>\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)]) }}"--}}
{{--                                                   class="btn btn-danger btn-xs"--}}
{{--                                                   title="Annuler" >Annuler l'agréement</a>--}}
                                           @endif
                                       @endif
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




