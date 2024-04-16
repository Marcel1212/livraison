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
                                    {{-- <span align="right">
                                        <a href="{{ route($lien . '.create') }}"
                                            class="btn btn-sm btn-primary waves-effect waves-light">
                                            <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter un projet de formation</a>

                                    </span> --}}
                                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#MessageFirst" id="Btn2"> Ajouter un
                                        projet de formation

                                    </button>

                                    <?php } ?>
                                </div>
                                <div class="card-body">
                                    <div class="table">
                                        <!--begin: Datatable-->
                                        <table class="table table-bordered table-striped table-hover table-sm "
                                            id="exampleData" style="margin-top: 13px !important">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Titre du projet </th>
                                                    <?php if ($nomrole != 'ENTREPRISE') { ?>
                                                    <th>Entreprise</th>
                                                    <?php } ?>
                                                    <th>Code</th>
                                                    <th>Date de creation</th>
                                                    <th>Date de soumission</th>
                                                    <th>Statut Soumission</th>
                                                    <th>Statut instruction</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($demandeenroles as $key => $demandeenrole)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $demandeenrole->titre_projet_etude }}</td>
                                                        <?php if ($nomrole != 'ENTREPRISE') { ?>

                                                        <td>{{ $demandeenrole->entreprise->raison_social_entreprises }}</td>
                                                        <?php } ?>
                                                        </td>
                                                        <td>{{ $demandeenrole->code_projet_formation }}</td>
                                                        <td>{{ $demandeenrole->created_at }}</td>
                                                        <td>{{ $demandeenrole->date_soumis }}</td>
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
        <div class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" id="MessageFirst">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Selectionnez un type de projet de formation
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md mb-md-0 mb-2">
                                        <div class="form-check custom-option custom-option-icon">
                                            <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                                <span class="custom-option-body">
                                                    <i class="ti ti-briefcase"></i>
                                                    <span class="custom-option-title">Perfectionnment </span>
                                                    {{-- <small>Le perfectionnement est un engagement envers l'amélioration
                                                        personnelle et professionnelle, qui implique de consacrer du temps
                                                        et des efforts à acquérir de nouvelles compétences et à approfondir
                                                        ses connaissances existantes. </small> --}}
                                                </span>
                                                <input name="customOptionRadioIcon" class="form-check-input" type="radio"
                                                    value="" id="customRadioIcon1" checked="">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md mb-md-0 mb-2">
                                        <div class="form-check custom-option custom-option-icon">
                                            <label class="form-check-label custom-option-content" for="customRadioIcon2">
                                                <span class="custom-option-body">
                                                    <i class="ti ti-briefcase"></i>
                                                    <span class="custom-option-title">Inititaion </span>
                                                    {{-- <small> L'initiation pour les débutants est
                                                        un projet conçu pour introduire les participants aux concepts
                                                        fondamentaux d'une activité. </small> --}}
                                                </span>
                                                <input name="customOptionRadioIcon" class="form-check-input" type="radio"
                                                    value="" id="customRadioIcon2">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-check custom-option custom-option-icon checked">
                                            <label class="form-check-label custom-option-content" for="customRadioIcon3">
                                                <span class="custom-option-body">
                                                    <i class="ti ti-briefcase"></i>
                                                    <span class="custom-option-title"> Developpement </span>
                                                    {{-- <small>Le développement est un processus essentiel dans un domaine afin
                                                        d'y apporter de l'amelioration.</small> --}}
                                                </span>
                                                <input name="customOptionRadioIcon" class="form-check-input"
                                                    type="radio" value="" id="customRadioIcon3">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-primary waves-effect" data-bs-dismiss="modal">
                            Valider
                        </button>
                        <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">
                            Fermer
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
