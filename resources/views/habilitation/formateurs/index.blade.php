<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@if(auth()->user()->can('demandehabilitation-index'))

    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Formateurs')
        @php($titre='Liste des formateurs')
        @php($lien='formateurs')

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
                            @can($lien.'-create')
                                <a href="{{ route($lien.'.create') }}" class="btn btn-sm btn-primary waves-effect waves-light">
                                    <i class="menu-icon tf-icons ti ti-plus"></i> Créer un formateur
                                </a>
                            @endcan
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
                                <th>Matricle </th>
                                <th>Nom et prenom </th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>fonction_formateurs</th>
                                <th>Date de recrutement</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; ?>
                            @foreach ($formateurs as $key => $formateur)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ @$formateur->numero_matricule_fdfp }}</td>
                                    <td>{{  @$formateur->nom_formateurs }} {{  @$formateur->prenom_formateurs }}</td>
                                    <td>{{ @$formateur->contact_formateurs }} / {{  @$formateur->contact2_formateurs }}</td>
                                    <td>{{ @$formateur->email_formateurs }}</td>
                                    <td>{{ @$formateur->fonction_formateurs }}</td>
                                    <td>{{ @$formateur->date_de_recrutement }}</td>
                                    <td align="center">
                                        <?php if ($formateur->flag_formateurs == true and $formateur->flag_attestation_formateurs == true ){ ?>
                                                <span class="badge bg-success">Valider</span>
                                        <?php } elseif ($formateur->flag_formateurs == true and $formateur->flag_attestation_formateurs == false ){ ?>
                                            <span class="badge bg-warning">En cours de traitement</span>
                                        <?php } elseif ($formateur->flag_formateurs == false and $formateur->flag_attestation_formateurs == false ){ ?>
                                                <span class="badge bg-danger">Annuler</span>
                                        <?php } elseif ($formateur->flag_formateurs == false and $formateur->flag_attestation_formateurs == true ){ ?>
                                                <span class="badge bg-danger">Annuler</span>
                                        <?php } else { ?>
                                        <span class="badge bg-danger">Annuler </span>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        @can($lien.'-edit')
                                            <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
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
@else
 <script type="text/javascript">
    window.location = "{{ url('/403') }}";//here double curly bracket
</script>
@endif


