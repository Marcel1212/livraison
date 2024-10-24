<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>
{{--@if (auth()->user()->can('cahierplansprojets-index'))--}}
    @extends('layouts.backLayout.designadmin')

    @section('content')
        @php($Module = 'Cahiers')
        @php($titre = 'Liste des cahiers des Demandes d\'extension')
        @php($lien = 'cahierautredemandehabilitations')
        @php($lienacceuil = 'dashboard')

        <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light"> <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i>
                    Accueil</a> / {{ $Module }} / </span> {{ $titre }}
        </h5>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{ $anneexercice }}
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
                        <h5 class="mb-0">{{ $titre }}</h5>
                        <small class="text-muted float-end">
{{--                            @can($lien . '-create')--}}
                                <a href="{{ route($lien . '.create') }}"
                                    class="btn btn-sm btn-primary waves-effect waves-light">
                                    <i class="menu-icon tf-icons ti ti-plus"></i> Nouveau cahier de demande d'extension </a>
{{--                            @endcan--}}
                        </small>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code </th>
                                    <th>Processus </th>
                                    <th>Commentaire </th>
                                    <th>Date création</th>
                                    <th>Date de soumission</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($cahiers as $key => $cahier)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ @$cahier->code_cahier_autre_demande_habilitations }}</td>

                                        <td>{{ strtoupper(@$cahier->processusAutreDemande->libelle_processus_autre_demande) }}</td>
                                        <td>{{ @$cahier->commentaire_cahier_autre_demande_habilitations }}</td>
                                        <td>{{ date('d/m/Y',strtotime(@$cahier->date_creer_cahier_autre_demande_habilitations))}}</td>
                                        <td>@isset($cahier->date_soumis_cahier_autre_demande_habilitations){{ date('d/m/Y H:i:s',strtotime(@$cahier->date_soumis_cahier_autre_demande_habilitations))}}@endisset</td>
                                        <td>
                                            <?php if($cahier->flag_statut_cahier_autre_demande_habilitations == true){ ?>
                                            <span class="badge bg-success">Terminé</span>
                                            <?php  }else{?>
                                            <span class="badge bg-warning">En cours</span>
                                            <?php } ?>
                                        </td>
                                        <td align="center">
                                            @if($cahier->flag_statut_cahier_autre_demande_habilitations == true)
                                                <a onclick="NewWindow('{{ route($lien.".notetechnique",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>
                                            @endif
{{--                                            @can($lien . '-edit')--}}
                                                <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                    class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
{{--                                            @endcan--}}
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
{{--        window.location = "{{ url('/403') }}"; //here double curly bracket--}}
{{--    </script>--}}
{{--@endif--}}
