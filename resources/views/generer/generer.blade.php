@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Gestion des attributions')
    @php($lien='menuprofil')

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

                                    </div>
                                    <div class="card-body">
                                    <!--begin: Datatable-->

                                        <table id="exampleData" class="table  table-bordered table-striped table-hover table-sm ">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Profil</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td align="center">
                                                    @can('attribuer')
                                                        <a href="{{ route('menuprofillayout',$role->id) }}"
                                                           class=" "
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
