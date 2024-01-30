@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Liste des sous modules')
    @php($lien='sousmenus')

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
{{--                        @can('role-create')--}}
                            <a href="{{ route($lien.'.create') }}"
                               class="btn btn-sm btn-primary waves-effect waves-light">
                                <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter </a>
{{--                        @endcan--}}
                    </small>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table id="exampleData" class="table  table-bordered table-striped table-hover table-sm ">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Module</th>
                            <th>Sous module</th>
                            <th>Lien</th>
                            <th>Priorité</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($data as $key => $sousmenu)
                            <tr>
                                <td>{{ $sousmenu->id_sousmenu }}</td>
                                <td>{{ $sousmenu->menu }}</td>
                                <td>{{ $sousmenu->libelle }}</td>
                                <td>{{ $sousmenu->sousmenu }}</td>
                                <td>{{ $sousmenu->priorite_sousmenu }}</td>
                                <td align="center">
                                        <?php if ($sousmenu->is_valide == true){ ?>
                                    <span class="badge bg-success">Actif</span>
                                    <?php } else { ?>
                                    <span class="badge bg-danger">Inactif</span>
                                    <?php } ?>
                                </td>
                                <td align="center">
                                    @can('role-edit')
                                        <a href="{{ route('sousmenus.edit',$sousmenu->id_sousmenu) }}"
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




