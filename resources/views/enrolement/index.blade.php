@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='DEMANDE ENROLEMENT')
    @php($titre='Liste des demandes d\'enrolements')
    @php($lien='enrolement')

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
                              
                @if ($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                                            <th>Localité </th>
                                            <th>Ncc </th>
                                            <th>Raison sociale </th>
                                            <th>Date de demande </th>
                                            <th>Recevablilite</th>
                                            <th>Statut</th>
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
                                                    <span class="badge bg-danger">Non recevable</span>
                                                    <?php }  ?>
                                                </td>                                                
                                                <td align="center">
                                                    <?php if ($demandeenrole->flag_traitement_demande_enrolem == true ){?>
                                                    <span class="badge bg-success">Valider</span>
                                                    <?php } else {?>
                                                    <span class="badge bg-danger">Rejeter</span>
                                                    <?php }  ?>
                                                </td>
                                                <td align="center">
                                                    @can($lien.'-edit')
                                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($demandeenrole->id_demande_enrolement)) }}"
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
