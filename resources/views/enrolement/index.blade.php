@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='enrôlement')
    @php($titre='Liste des enrôlements')
    @php($lien='enrolement')

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

                @if ($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                                    <table class="table table-bordered table-striped table-hover table-sm "
                                             id="exampleData"
                                             style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Localité </th>
                                            <th>NCC </th>
                                            <th>Raison sociale </th>
                                            <th>Date de la demande </th>
                                            <th>Recevabilité</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($demandeenroles as $key => $demandeenrole)
                                            <tr>
                                                <td>{{ $demandeenrole->id_demande_enrolement }}</td>
                                                <td>{{ $demandeenrole->localite->libelle_localite }}</td>
                                                <td>{{ $demandeenrole->ncc_demande_enrolement }}</td>
                                                <td>{{ $demandeenrole->raison_sociale_demande_enroleme }}</td>
                                                <td>{{ $demandeenrole->date_depot_demande_enrolement }}</td>
                                                <td align="center">
                                                    <?php if ($demandeenrole->flag_recevablilite_demande_enrolement == true ){?>
                                                    <span class="badge bg-success">Recevable</span>
                                                    <?php } else {?>
                                                    <span class="badge bg-danger">Non Traité</span>
                                                    <?php }  ?>
                                                </td>

                                                <td align="center">
                                                    @can($lien.'-edit')
                                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($demandeenrole->id_demande_enrolement)) }}"
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
