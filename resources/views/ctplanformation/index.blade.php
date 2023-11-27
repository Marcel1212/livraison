

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Plan de formation')
    @php($titre='Liste des plans de formations a validés')
    @php($lien='ctplanformation')

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
                            <th>No</th>
                            <th>Entreprise </th>
                            <th>Conseiller </th>
                            <th>Code </th>
                            <th>Date soumis</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0 ?>
                        @foreach ($planformations as $key => $planformation)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ @$planformation->entreprise->ncc_entreprises  }} / {{ @$planformation->entreprise->raison_social_entreprises  }}</td>
                                <td>{{ @$planformation->userconseilplanformation->name }} {{ @$planformation->userconseilplanformation->prenom_users }}</td>
                                <td>{{ @$planformation->code_plan_formation }}</td>
                                <td>{{ $planformation->date_soumis_plan_formation }}</td>
                                <td align="center">
                                        <?php if ($planformation->flag_soumis_plan_formation == true and
                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == true
                                        and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==false){ ?>
                                            <span class="badge bg-success">Valider</span>
                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and
                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false
                                        and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==false){ ?>
                                        <span class="badge bg-warning">En cours de traitement</span>
                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and
                                        $planformation->flag_recevablite_plan_formation == false and $planformation->flag_valide_plan_formation == false
                                        and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==false) { ?>
                                        <span class="badge bg-secondary">Soumis</span>
                                    <?php } elseif ($planformation->flag_soumis_plan_formation == false and
                                        $planformation->flag_recevablite_plan_formation == false and $planformation->flag_valide_plan_formation == false
                                        and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==false) { ?>
                                        <span class="badge bg-primary">Non Soumis</span>
                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and
                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false
                                        and $planformation->flag_rejeter_plan_formation == true and $planformation->flag_soumis_ct_plan_formation==false) { ?>
                                        <span class="badge bg-danger">Rejeter</span>
                                    <?php } elseif ($planformation->flag_soumis_plan_formation == true and
                                        $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false
                                        and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==true) { ?>
                                        <span class="badge bg-warning">Soumis au ct</span>
                                    <?php } else { ?>
                                        <span class="badge bg-secondary">Soumis</span>
                                    <?php } ?>
                                </td>
                                <td align="center">
                                    @can($lien.'-edit')
                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}"
                                           class=" "
                                           title="Modifier"><img
                                                src='/assets/img/editing.png'></a>
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

@endsection




