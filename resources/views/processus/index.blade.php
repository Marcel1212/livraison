@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Parametrage')
    @php($titre='Liste des processus')
    @php($lien='processus')

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
                                                <a href="{{ route($lien.'add') }}"
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
                                            <th>Libellé</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($Resultat as $key => $res)
                                            <tr>
                                                <td>{{ $res->id_processus }}</td>
                                                <td>{{ $res->lib_processus }}</td>
                                                <td align="center">
                                                    <?php if($res->is_valide == true){ ?>
                                                    <span class="badge bg-success">Actif</span>
                                                    <?php  }else{?>
                                                    <span class="badge bg-danger">Inactif</span>
                                                    <?php } ?>
                                                </td>
                                                <td align="center">
                                                @can($lien.'-create')
                                                    <a href="processus/edit/{{ \App\Helpers\Crypt::UrlCrypt($res->id_processus) }}"
                                                       class=" "
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
    </div>
    <!-- END: Content-->




@endsection

