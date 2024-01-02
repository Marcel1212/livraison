@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Plan de formation')
    @php($titre='Liste des demandes d\'annulation des plans de formation')
    @php($lien='traitementdemandeannulationplan')

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
                            <th>Entreprise </th>
                            <th>Conseiller </th>
                            <th>Code </th>
                            <th>Date soumis</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($resultat as $key => $res1)
                            @foreach ($res1 as  $planformation)
                                <tr>
                                    <td>{{$key+1 }}</td>
                                    <td>{{ @$planformation->ncc_entreprises  }} / {{ @$planformation->raison_social_entreprises  }}</td>
                                    <td>{{ @$planformation->name }} {{ @$planformation->prenom_users }}</td>
                                    <td>{{ @$planformation->code_plan_formation }}</td>
                                    <td>{{ $planformation->date_soumis_demande_annulation_plan }}</td>
                                    <td align="center">
                                        <span class="badge bg-warning">En attente de traitement</span>
                                    </td>
                                    <td align="center">
{{--                                        @can($lien.'-edit')--}}
                                            <a href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($planformation->id_demande_annulation_plan),'id2'=>\App\Helpers\Crypt::UrlCrypt($planformation->id_combi_proc)]) }}"
                                               class=" "
                                               title="Modifier"><img
                                                    src='/assets/img/editing.png'></a>
{{--                                        @endcan--}}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection




