<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Agrément')
    @php($titre = 'Liste des agréments pour les projets de d\'études')
    @php($lien = 'agreementprojetetude')

    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
        {{ $titre }}
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
                    <h5 class="mb-0">{{ $titre }}</h5>
                    <small class="text-muted float-end">

                    </small>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                        style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Titre du projet </th>
                                <th>Code </th>
                                <th>Chargé d'étude </th>
                                <th>Date de soumission</th>
                                <th>Date D'agrément</th>
                                <th>Statut </th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agreements as $key => $projet_etude)
                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ Str::title(Str::limit($projet_etude->titre_projet_instruction, 40, '...')) }}</td>
                                    <td>{{ @$projet_etude->code_projet_etude }}</td>
                                    <td>{{ @$projet_etude->name }} {{ @$projet_etude->prenom_users }}</td>
                                    <td>{{ date('d/m/Y h:i:s', strtotime(@$projet_etude->created_at)) }}</td>
                                    <td>{{ date('d/m/Y h:i:s', strtotime(@$projet_etude->date_fiche_agrement)) }}</td>
                                    <td> <span class="badge bg-success xs">Agrée</span></td>
                                    <td align="center">
                                        <a onclick="NewWindow('{{ route($lien . '.show', \App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)) }}','',screen.width*2,screen.height,'yes','center',1);"
                                            target="_blank" class=" "title="Afficher"><img
                                                src='/assets/img/eye-solid.png'></a>
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
