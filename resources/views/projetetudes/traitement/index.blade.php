

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Projet d\'étude')
    @php($titre='Liste des projets d\'étude')
    @php($lien='traitementprojetetude')

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
                            <th>Entreprise</th>
                            <th>Date de création</th>
                            <th>Date de soumission</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($projet_etudes as $key => $projet_etude)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ Str::title(Str::limit($projet_etude->titre_projet_etude, 40,'...')) }}</td>
                                <td>{{ @$projet_etude->code_projet_etude}}</td>
                                <td>{{ @$projet_etude->entreprise->raison_social_entreprises }}</td>
                                <td>{{ date('d/m/Y h:i:s',strtotime(@$projet_etude->created_at ))}}</td>
                                <td>{{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_soumis ))}}</td>
                                @if(@$projet_etude->flag_recevablite_projet_etude==false && @$projet_etude->flag_attente_rec==false)
                                    <td><span class="badge bg-warning">En attente de traitement</span></td>
                                @elseif(@$projet_etude->flag_recevablite_projet_etude==false && @$projet_etude->flag_attente_rec==true)
                                    <td><span class="badge bg-warning">Mise en attente</span></td>
                                @elseif(@$projet_etude->flag_recevablite_projet_etude==true)
                                    <td><span class="badge bg-warning">En cours de traitement</span></td>
                                @endif
                                <td align="center">
                                    {{--                                    @can($lien.'-edit')--}}
                                    @if($projet_etude->flag_recevablite_projet_etude==true)
                                    <a href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                       class=" "
                                       title="Modifier"><img
                                            src='/assets/img/editing.png'></a>
                                    @else
                                        <a href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(5)]) }}"
                                           class=" "
                                           title="Modifier"><img
                                                src='/assets/img/editing.png'></a>
                                        @endif
                                    {{--                                    @endcan--}}
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




