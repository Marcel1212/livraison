@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Demandes')
    @php($titre = 'Liste des projets de formation')
    @php($lien = 'projetformation')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
                {{ $titre }}
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


            <div class="content-body">

                <section id="multiple-column-form">
                    <div class="row">

                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">{{ $titre }}</h5>
                                    <?php if ($nomrole == 'ENTREPRISE') { ?>
                                    <span align="right">
                                        <a href="{{ route($lien . '.create') }}"
                                            class="btn btn-sm btn-primary waves-effect waves-light">
                                            <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter un projet de formation</a>

                                    </span>
                                    <?php } ?>
                                </div>
                                <div class="card-body">
                                    <div class="table">
                                        <!--begin: Datatable-->
                                        <table class="table table-bordered table-striped table-hover table-sm "
                                            id="exampleData" style="margin-top: 13px !important">
                                            <thead>
                                                <tr>
                                                    <th>Titre du projet </th>

                                                    <th>Entreprise</th>
                                                    <th>Date de creation</th>
                                                    <th>Statut Soumission</th>
                                                    <th>Statut instruction</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($demandeenroles as $key => $demandeenrole)
                                                    <tr>
                                                        <td>{{ $demandeenrole->titre_projet_etude }}</td>
                                                        <td></td>
                                                        {{-- <td>{{ /*Str::substr($demandeenrole->id_entreprises()->raison_social_entreprises, 0, 40)*/ }}</td> --}}
                                                        <td>{{ $demandeenrole->created_at }}</td>
                                                        <td align="center">
                                                            <?php if ($demandeenrole->flag_soumis == true ){?>
                                                            <span class="badge bg-success">Soumis</span>
                                                            <?php } else {?>
                                                            <span class="badge bg-danger">Non Soumis</span>
                                                            <?php }  ?>
                                                        </td>
                                                        <td align="center">
                                                            <?php if ($demandeenrole->flag_statut_instruction == true ){?>
                                                            <span class="badge bg-success">Recevable</span>
                                                            <?php } else if ($demandeenrole->flag_statut_instruction == null ) {?>
                                                            <span class="badge bg-warning">En cours de traitement</span>
                                                            <?php } else if ($demandeenrole->flag_statut_instruction == false ) {?>
                                                            <span class="badge bg-danger">Non recevable</span>
                                                            <?php }  ?>
                                                        </td>


                                                        <td align="center">
                                                            <a href="{{ route($lien . '.edit', \App\Helpers\Crypt::UrlCrypt($demandeenrole->id_projet_formation)) }}"
                                                                class=" " title="Modifier"><img
                                                                    src='/assets/img/editing.png'></a>
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
                    </div>
                </section>
            </div>


        </div>
    </div>
    <!-- END: Content-->
@endsection
