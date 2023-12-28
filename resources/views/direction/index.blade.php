@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Paramétrage')
    @php($titre='Liste des directions')
    @php($lien='direction')



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
                        @can('role-create')
                            <a href="{{ route($lien.'.create') }}"
                               class="btn btn-sm btn-primary waves-effect waves-light">
                                <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter </a>
                        @endcan
                    </small>
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-striped table-hover table-sm "
                           id="exampleData" >
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Agence</th>
                            <th>Libelle</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($Resultat as $key => $res)
                            <tr>
                                <td>{{ $res->id_direction }}</td>
                                <td>{{ $res->agence->lib_agce }}</td>
                                <td>{{ $res->libelle_direction }}</td>
                                <td align="center">
                                        <?php if($res->flag_direction == true){ ?>
                                    <span class="badge bg-success">Actif</span>
                                    <?php  }else{?>
                                    <span class="badge bg-danger">Inactif</span>
                                    <?php } ?>
                                </td>
                                <td align="center">
                                    @can($lien.'-edit')
                                        <a href="{{ route($lien.'.edit',$res->id_direction) }}"
                                           class="text-warning "
                                           title="Modifier"><img src='/assets/img/editing.png'></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- END: Content-->





    <!-- END: Content-->
@endsection


