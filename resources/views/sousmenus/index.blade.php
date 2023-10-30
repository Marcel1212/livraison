@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Liste des sous modules')
    @php($lien='sousmenus')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{$titre}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{$Module}}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{$titre}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="content-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <section id="multiple-column-form">
                    <div class="row">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$titre}}</h4>
                                    <span align="right">
                                    @can('role-create')
                                            <a href="{{ route($lien.'.create') }}"
                                               class="btn btn-sm btn-primary waves-effect waves-float waves-light">
                                           <i data-feather='plus-circle'></i> Ajouter </a>
                                        @endcan
                                </span>
                                </div>

                                <div class="table">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered table-striped table-hover table-sm "
                                           id="exampleData"
                                           style="margin-top: 13px !important">
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
                                                    <span class="badge badge-light-success">Actif</span>
                                                    <?php } else { ?>
                                                    <span class="badge badge-light-danger">Inactif</span>
                                                    <?php } ?>
                                                </td>
                                                <td align="center">
                                                    @can('role-edit')
                                                        <a href="{{ route('sousmenus.edit',$sousmenu->id_sousmenu) }}"
                                                           class=" "
                                                           title="Modifier"><img src='/app-assets/images/icons/bouton-modifier.png'></a>
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
                </section>
            </div>


        </div>
    </div>
    <!-- END: Content-->

@endsection




