@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Plan de formation')
    @php($titre='Liste des demandes de substituion d\'acion  de plan de formation')
    @php($lien='traitementdemandesubstitutionplan')

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
                            <th>Intitluer de l'action de formation </th>
                            <th>Structure ou etablissemnt de formation </th>
                            <th>Date soumis</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($resultat as $key => $res1)
                            @foreach ($res1 as  $action_formation)
                                <tr>
                                    <td>{{$key+1 }}</td>
                                    <td>{{ $action_formation->intitule_action_formation_plan  }}</td>
                                    <td>{{ $action_formation->structure_etablissement_action_ }}</td>
                                    <td>{{ $action_formation->date_soumis_demande_substitution_action_plan }}</td>
                                    <td align="center">
                                        <span class="badge bg-warning">En attente de traitement</span>
                                    </td>
                                    <td align="center">
                                            <a href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($action_formation->id_action_formation_plan_substi),
'id2'=>\App\Helpers\Crypt::UrlCrypt($action_formation->id_combi_proc)]) }}"
                                               class=" "
                                               title="Modifier"><img
                                                    src='/assets/img/editing.png'></a>
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




