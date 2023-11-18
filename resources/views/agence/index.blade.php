@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Paramétrage')
    @php($titre='Liste des agences')
    @php($lien='agence')

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
                                           id="exampleData"
                                           style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Libelle</th>
                                            <th>Adresse</th>
                                            <th>Localisation</th>
                                            <th>Coordonnée GPS</th>
                                            <th>Contact</th>
                                            <th>Siege</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($Resultat as $key => $res)
                                            <tr>
                                                <td>{{ $res->num_agce }}</td>
                                                <td>{{ $res->code_agce }}</td>
                                                <td>{{ $res->lib_agce }}</td>
                                                <td>{{ $res->adresse_agce }}</td>
                                                <td>{{ $res->localisation_agce }}</td>
                                                <td>{{ $res->coordonne_gps_agce }}</td>
                                                <td>{{ $res->tel_agce}}</td>
                                                <td align="center">
                                                    <?php if($res->flag_siege_agce == 1){ ?>
                                                    <span class="badge bg-success">OUI</span>
                                                    <?php  }else{?>
                                                    <span class="badge bg-danger">NON</span>
                                                    <?php } ?>
                                                </td>
                                                <td align="center">
                                                    <?php if($res->flag_agce == 1){ ?>
                                                    <span class="badge bg-success">Actif</span>
                                                    <?php  }else{?>
                                                        <span class="badge bg-danger">Inactif</span>
                                                    <?php } ?>
                                                </td>
                                                <td align="center">
                                                    @can($lien.'-edit')
                                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($res->num_agce)) }}"
                                                           class="text-warning "
                                                           title="Modifier"><img src='/assets/img/editing.png'></a>
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
    <!-- END: Content-->
@endsection


