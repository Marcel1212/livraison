<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@if(auth()->user()->can('traitementsuppressiondomaine-index'))

    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Habilitation')
        @php($titre='Liste des demandes de suppression de domaine')
        @php($lien='traitementsuppressiondomaine')

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

                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-striped table-hover table-sm"
                               id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Code </th>
                                <th>Type de demande</th>
                                <th>Entreprise </th>
                                <th>Responsable formation </th>
                                <th>Date de création</th>
                                <th>Date de soumission</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; ?>
                                @foreach ($demandesuppressiondomaines as  $key => $demandesuppressiondomaine)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td>{{@$demandesuppressiondomaine->code_demande_suppression_habilitation}}</td>
                                        <td>
                                            @if(@$demandesuppressiondomaine->type_autre_demande=='demande_suppression')
                                            Demande de suppression
                                            @elseif(@$demandesuppressiondomaine->type_autre_demande=='demande_extension')
                                            Demande d'extension
                                            @endif
                                        </td>
                                        <td>{{ @$demandesuppressiondomaine->raison_social_entreprises }}</td>
                                        <td>{{ @$demandesuppressiondomaine->nom_responsable_demande_habilitation }}</td>
                                        <td>{{ @$demandesuppressiondomaine->date_creer_demande_habilitation }}</td>
                                        <td>{{ @$demandesuppressiondomaine->date_soumis_demande_habilitation }}</td>
                                        <td>
                                                <span class="badge bg-warning">En Attente de traitement</span>
                                        </td>
                                        <td align="center">
                                                <a href="{{ route('traitementextensiondomaine' . '.edit',[\App\Helpers\Crypt::UrlCrypt($demandesuppressiondomaine->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(5)],
                                                                         ) }}"
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

    @endsection
@else
 <script type="text/javascript">
    window.location = "{{ url('/403') }}";//here double curly bracket
</script>
@endif


