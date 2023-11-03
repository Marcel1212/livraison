@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Liste des profils')

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
                                            <a href="{{ route('roles.create') }}"
                                               class="btn btn-sm btn-primary waves-effect waves-float waves-light">
                                           <i data-feather='plus-circle'></i> Ajouter </a>
                                        @endcan
                                </span>
                                </div>

                                <div class="table">
                                    <table  id="exampleData" class="table  table-bordered table-striped table-hover table-sm ">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nom</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td align="center">
                                                    @can('role-edit')
                                                        <a href="{{ route('roles.edit',\App\Helpers\Crypt::UrlCrypt($role->id)) }}"
                                                           class=" "
                                                           title="Modifier"><img src='/app-assets/images/icons/bouton-modifier.png'></a>

                                                    @endcan
                                                    @can('role-delete1')
                                                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
