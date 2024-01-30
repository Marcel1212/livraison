@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module='Demandes')
    @php($titre='Liste des projets d\'études')
    @php($lien='projetetude')

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
{{--                        @can($lien.'-create')--}}
                            <a href="{{ route($lien.'.create') }}"
                               class="btn btn-sm btn-primary waves-effect waves-light">
                                <i class="menu-icon tf-icons ti ti-plus"></i> Nouvelle demande de projet d'étude </a>
{{--                        @endcan--}}
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
                                <th>Contexte</th>
                                <th>Cible</th>
                                <th>Date de soumission</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($projet_etudes as $key => $projet_etude)
                            <tr>

                                <td>{{ $key+1 }}</td>
                                <td>{{ @$projet_etude->titre_projet_etude }}</td>
                                <td>{{ Str::substr($projet_etude->contexte_probleme_projet_etude, 0, 30) }}</td>
                                <td>{{ Str::substr($projet_etude->cible_projet_etude, 0, 40) }}</td>
                                <td>{{ @$projet_etude->date_soumis }}</td>
                                @if(@$projet_etude->flag_soumis==true)
                                    <td><span class="badge bg-secondary">Soumis</span></td>
                                @endif
                                @if(@$projet_etude->flag_soumis==false)
                                    <td><span class="badge bg-primary">Non Soumis</span></td>
                                @endif

                                {{--                                <td>{{ @$planformation->entreprise->raison_social_entreprises }}</td>--}}
{{--                                <td>{{  @$planformation->userconseilplanformation->name }} {{  @$planformation->userconseilplanformation->prenom_users }}</td>--}}
{{--                                <td>{{  @$planformation->agence->lib_agce }}</td>--}}
{{--                                <td>{{ $planformation->date_soumis_plan_formation }}</td>--}}
{{--                                <td align="center">--}}
{{--                                        <?php if ($planformation->flag_soumis_plan_formation == true and--}}
{{--                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == true--}}
{{--                                        and $planformation->flag_rejeter_plan_formation == false){ ?>--}}
{{--                                    <span class="badge bg-success">Valider</span>--}}
{{--                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and $planformation->flag_annulation_plan == false and--}}
{{--                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false--}}
{{--                                        and $planformation->flag_rejeter_plan_formation == false){ ?>--}}
{{--                                    <span class="badge bg-warning">En cours de traitement</span>--}}
{{--                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and--}}
{{--                                        $planformation->flag_recevablite_plan_formation == false and $planformation->flag_valide_plan_formation == false--}}
{{--                                        and $planformation->flag_rejeter_plan_formation == false) { ?>--}}
{{--                                    <span class="badge bg-secondary">Soumis</span>--}}
{{--                                    <?php } elseif ($planformation->flag_soumis_plan_formation == false and--}}
{{--                                        $planformation->flag_recevablite_plan_formation == false and $planformation->flag_valide_plan_formation == false--}}
{{--                                        and $planformation->flag_rejeter_plan_formation == false) { ?>--}}
{{--                                    <span class="badge bg-primary">Non Soumis</span>--}}
{{--                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and--}}
{{--                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false--}}
{{--                                        and $planformation->flag_rejeter_plan_formation == true) { ?>--}}
{{--                                    <span class="badge bg-danger">Non recevable</span>--}}
{{--                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and $planformation->flag_annulation_plan == true and--}}
{{--                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false--}}
{{--                                        and $planformation->flag_rejeter_plan_formation == false) { ?>--}}

{{--                                    <span class="badge bg-danger">Annulé</span>--}}
{{--                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and $planformation->flag_annulation_plan == false and--}}
{{--                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_annulation_plan == true--}}
{{--                                        and $planformation->flag_rejeter_plan_formation == false) { ?>--}}

{{--                                    <span class="badge bg-danger">Annulé</span>--}}
{{--                                    <?php }--}}


{{--                                    else { ?>--}}
{{--                                    <span class="badge bg-danger"> </span>--}}
{{--                                    <?php } ?>--}}
{{--                                </td>--}}
                                <td align="center">
{{--                                    @can($lien.'-edit')--}}
                                        <a href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                           class=" "
                                           title="Modifier"><img
                                                src='/assets/img/editing.png'></a>
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
