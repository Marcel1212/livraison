@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet d\'étude')
    @php($titre = 'Liste des cahiers de projet d\'étude')
    @php($lien = 'cahierprojetetude')

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
                        {{--                        @can($lien . '-create') --}}
                        <a href="{{ route($lien . '.create') }}" class="btn btn-sm btn-primary waves-effect waves-light">
                            <i class="menu-icon tf-icons ti ti-plus"></i> Nouveau cahier de projet d'étude</a>
                        {{--                        @endcan --}}
                    </small>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                        style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code </th>
                                <th>Date creation</th>
                                <th>Date de soumission</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($cahiers as $key => $cahier)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ @$cahier->code_cahier_projet_etude }}</td>
                                    <td>{{ $cahier->date_creer_cahier_projet_etude }}</td>
                                    <td>{{ $cahier->date_soumis_cahier_projet_etude }}</td>
                                    <td align="center">
                                        <?php if($cahier->flag_statut_cahier_projet_etude == true){ ?>
                                        <span class="badge bg-success">Terminer</span>
                                        <?php  }else{?>
                                        <span class="badge bg-warning">En cours</span>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        {{--                                    @can($lien . '-edit') --}}
                                        <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                            class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                        {{--                                    @endcan --}}
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
