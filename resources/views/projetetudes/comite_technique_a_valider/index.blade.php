@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Projet d\'étude')
    @php($titre='Liste des projets d\'étude')
    @php($soustitre='Comite technique à valider')
    @php($lien='ctprojetetudevalider')

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

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{$titre}}</h5>
                    <small class="text-muted float-end">

                    </small>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-striped table-hover table-sm"
                           id="exampleData"
                           style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Titre du projet </th>
                                <th>Code</th>
                                <th>Chargé d'étude</th>
                                <th>Entreprise</th>
                                <th>Date de création</th>
                                <th>Date de soumission</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0 ?>
                        @foreach ($Resultat as $key => $res1)
                            @foreach ($res1 as $key => $projet_etude)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ Str::title(Str::limit($projet_etude->titre_projet_etude, 40,'...')) }}</td>
                                    <td>{{ @$projet_etude->code_projet_etude}}</td>
                                    <td>{{ mb_strtoupper(@$projet_etude->name) }} {{  mb_strtoupper(@$projet_etude->prenom_users) }}</td>
                                    <td>{{ @$projet_etude->ncc_entreprises }} / {{ @$projet_etude->raison_social_entreprises}}</td>
                                    <td>{{ date('d/m/Y h:i:s',strtotime(@$projet_etude->created_at ))}}</td>
                                    <td>{{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_soumis ))}}</td>
                                    <td align="center">
                                        <span class="badge bg-warning">En attente de traitement</span>
                                    </td>
                                    <td align="center">
                                        <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($projet_etude->id_combi_proc)]) }}"
                                           class=" "
                                           title="Modifier"><img
                                                src='/assets/img/editing.png'></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection




