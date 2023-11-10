@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'PROJET ETUDE')
    @php($titre = 'Liste des projets d\'etudes')
    @php($lien = 'projetetude')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{ $titre }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{ $Module }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ $titre }}
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
                                    <h4 class="card-title">{{ $titre }}</h4>
                                    <span align="right">

                                        <a href="{{ route($lien . '.create') }}"
                                            class="btn btn-primary btn-sm waves-effect waves-float waves-light">
                                            <i data-feather='plus-circle'></i> Ajouter </a>

                                    </span>
                                </div>

                                <div class="table">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered table-striped table-hover table-sm " id="exampleData"
                                        style="margin-top: 13px !important">
                                        <thead>
                                            <tr>
                                                <th>Titre du projet </th>
                                                <th>Contexte ou Problèmes
                                                    constatés / Justification
                                                    Contexte ou Problèmes
                                                </th>
                                                <th>Cible</th>
                                                <th>Date de creation</th>
                                                <th>Statut Soumission</th>
                                                <th>Statut Etat</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($demandeenroles as $key => $demandeenrole)
                                                <tr>
                                                    <td>{{ $demandeenrole->titre_projet_etude }}</td>
                                                    <td>{{ $demandeenrole->contexte_probleme_projet_etude }}</td>
                                                    <td>{{ $demandeenrole->cible_projet_etude }}</td>
                                                    <td>{{ $demandeenrole->created_at }}</td>
                                                    <td align="center">
                                                        <?php if ($demandeenrole->FLAG_SOUMIS == true ){?>
                                                        <span class="badge bg-success">Soumis</span>
                                                        <?php } else {?>
                                                        <span class="badge bg-danger">Non Soumis</span>
                                                        <?php }  ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php if ($demandeenrole->flag_valide == true ){?>
                                                        <span class="badge bg-success">Valider</span>
                                                        <?php } else {?>
                                                        <span class="badge bg-danger">Non valider</span>
                                                        <?php }  ?>
                                                    </td>
                                                    <td align="center">

                                                        <a href="{{ route($lien . '.edit', \App\Helpers\Crypt::UrlCrypt($demandeenrole->id_projet_etude)) }}"
                                                            class=" " title="Modifier"><img
                                                                src='/app-assets/images/icons/bouton-modifier.png'></a>
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
