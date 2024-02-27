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
                                            <th>Message</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logs as $key => $log)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td>
                                                        {{$log->created_at}}
                                                        @isset($log->nom_hote_log)
                                                            Etat : {{$log->etat_log}};
                                                        @endisset
                                                        @isset($log->nom_hote_log)
                                                            Machine :  {{long2ip($log->ip_addr_log)}};
                                                        @endisset
                                                        @isset($log->nom_hote_log)
                                                            Nom d'hôte : {{$log->nom_hote_log}};
                                                        @endisset
                                                        @isset($log->nom_hote_log)
                                                            Identifiant : {{$log->identifiant_log}};
                                                        @endisset
                                                        @isset($log->nom_hote_log)
                                                            Utilisateur : {{$log->utilisateur_log}};
                                                        @endisset
                                                        @isset($log->nom_hote_log)
                                                            Privilege : {{$log->role_log}};
                                                        @endisset
                                                        @isset($log->module_log)
                                                            Module : {{$log->module_log}};
                                                        @endisset
                                                        @isset($log->action_log)
                                                            Action : {{$log->action_log}};
                                                        @endisset
                                                        @isset($log->code_piece_log)
                                                            Pièce : {{$log->code_piece_log}};
                                                        @endisset
                                                    </td>
                                                </tr>
                                            @endforeach
{{--                                                <td>{{ $res->lib_agce }}</td>--}}
{{--                                                <td>{{ $res->adresse_agce }}</td>--}}
{{--                                                <td>{{ $res->localisation_agce }}</td>--}}
{{--                                                <td>{{ $res->coordonne_gps_agce }}</td>--}}
{{--                                                <td>{{ $res->tel_agce}}</td>--}}
{{--                                                <td align="center">--}}
{{--                                                    <?php if($res->flag_siege_agce == 1){ ?>--}}
{{--                                                    <span class="badge bg-success">OUI</span>--}}
{{--                                                    <?php  }else{?>--}}
{{--                                                    <span class="badge bg-danger">NON</span>--}}
{{--                                                    <?php } ?>--}}
{{--                                                </td>--}}
{{--                                                <td align="center">--}}
{{--                                                    <?php if($res->flag_agce == 1){ ?>--}}
{{--                                                    <span class="badge bg-success">Actif</span>--}}
{{--                                                    <?php  }else{?>--}}
{{--                                                        <span class="badge bg-danger">Inactif</span>--}}
{{--                                                    <?php } ?>--}}
{{--                                                </td>--}}
{{--                                                <td align="center">--}}
{{--                                                    @can($lien.'-edit')--}}
{{--                                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($res->num_agce)) }}"--}}
{{--                                                           class="text-warning "--}}
{{--                                                           title="Modifier"><img src='/assets/img/editing.png'></a>--}}
{{--                                                @endcan--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
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


