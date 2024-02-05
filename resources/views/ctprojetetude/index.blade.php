@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projets d\'etudes')
    @php($titre = 'Liste des projets d\'etudes à valider')
    @php($lien = 'comitetechniquepe')

    <!-- BEGIN: Content-->

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

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $titre }}</h5>
                    <small class="text-muted float-end">

                    </small>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                        style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Entreprise </th>
                                <th>Code du dossier </th>
                                <th>Date de soumission</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($projetformations as $key => $projetformation)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ @$projetformation->entreprise->raison_social_entreprises }}</td>
                                    <td>{{ @$projetformation->code_projet_etude }}</td>
                                    <td>{{ $projetformation->date_soumis }}</td>
{{--                                    <td align="center">--}}
{{--                                        <?php if ($projetformation->statut_instruction == true ){ ?>--}}
{{--                                        <span class="badge bg-success">Dossier Instruit</span>--}}
{{--                                        <?php } ?>--}}
{{--                                    </td>--}}
                                    <td align="center">
                                        <a href="{{ route($lien . '.edit', \App\Helpers\Crypt::UrlCrypt($projetformation->id_projet_etude)) }}"
                                            class=" " title="Modifier"><img src='/assets/img/editing.png'></a>

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
