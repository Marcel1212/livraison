@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'PROJET ETUDE')
    @php($titre = 'Liste des projets d\'etudes')
    @php($lien = 'selectionoperateurprojetetude')

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
                                    {{--                                    <?php if ($nomrole == 'ENTREPRISE') { ?>--}}
                                    {{--                                    <span align="right">--}}
                                    {{--                                        <a href="{{ route($lien . '.create') }}"--}}
                                    {{--                                           class="btn btn-sm btn-primary waves-effect waves-light">--}}
                                    {{--                                            <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter un projet d'étude </a>--}}

                                    {{--                                    </span>--}}
                                    {{--                                    <?php }?>--}}
                                </div>
                                <div class="card-body">
                                    <div class="table">
                                        <!--begin: Datatable-->
                                        <table class="table table-bordered table-striped table-hover table-sm "
                                               id="exampleData" style="margin-top: 13px !important">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Titre du projet </th>
                                                    <th>Code</th>
                                                    <th>Chargé d'étude</th>
                                                    <th>Date d'agrément</th>
                                                    <th>Date de soumission de la sélection</th>
                                                    <th>Statut de la sélection</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($projet_etude_valides as  $key=>$projet_etude)
                                                <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ Str::title(Str::limit($projet_etude->titre_projet_instruction, 40,'...')) }}</td>
                                                <td>{{ @$projet_etude->code_projet_etude}}</td>
                                                <td>{{ @$projet_etude->chargedetude->name }} {{ @$projet_etude->chargedetude->prenom_users }}</td>
                                                    <td>@isset($projet_etude->date_fiche_agrement) {{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_fiche_agrement ))}} @endisset</td>
                                                    <td>@isset($projet_etude->date_soumis_selection_operateur) {{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_soumis_selection_operateur ))}} @endisset</td>
                                                    <td>
                                                    @if(isset($projet_etude_valide->flag_soumis_selection_operateur))
                                                        @if($projet_etude_valide->flag_soumis_selection_operateur==true && $projet_etude_valide->flag_selection_operateur_valider_par_processus==false)
                                                            <span class="badge bg-warning">Soumis pour approbation</span>
                                                        @elseif($projet_etude_valide->flag_soumis_selection_operateur==true &&
                                                            $projet_etude_valide->flag_selection_operateur_valider_par_processus==true)
                                                            <span class="badge bg-primary">En attente sélection operateur retenu</span>
                                                        @else
                                                            <span class="badge bg-secondary">Non Soumis</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-primary">En attente de traitement</span>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    {{--                                    @can($lien.'-edit')--}}
                                                    <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(4)]) }}"
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
                    </div>
                </section>
            </div>


        </div>
    </div>
    <!-- END: Content-->
@endsection
