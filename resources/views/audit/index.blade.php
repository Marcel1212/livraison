@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Audit')
    @php($titre='Liste des logs')
    @php($lien='audit')

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
                                    <table class="table table-bordered table-striped table-hover table-sm "
                                           id="" >
                                        <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Date d'action</th>
                                            <th>Nom d'hôte</th>
                                            <th>Adresse IP</th>
                                            <th>Etat</th>
                                            <th>Utilisateur</th>
                                            <th>Privilège</th>
                                            <th>Module</th>
                                            <th>Action</th>
                                            <th>Pièce</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logs as $key => $log)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $log->created_at }}</td>
                                                    <td>{{ $log->nom_hote_log }}</td>
                                                    <td>{{ long2ip($log->ip_addr_log) }}</td>
                                                    <td>{{ $log->etat_log }}</td>
                                                    <td>{{ $log->identifiant_log }} / {{ $log->utilisateur_log }}</td>
                                                    <td>{{ $log->role_log }}</td>
                                                    <td>{{ $log->menu_log }}</td>
                                                    <td>{{ $log->action_log }}</td>
                                                    <td>{{ $log->code_piece_log }}</td>
                                                </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!--end: Datatable-->
                                    </div>
                                    <div class="mt-2">
                                        @isset($logs)
                                            {{@$logs->links('pagination::bootstrap-5')}}
                                        @endisset
                                    </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection


