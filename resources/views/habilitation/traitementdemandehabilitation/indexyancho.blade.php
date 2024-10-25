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
                @if(App\Helpers\Menu::get_code_menu_profil(Auth::user()->id) == 'CHEFSERVICE')
                    <div class="row g-6 mb-2">
                        <div class="col-sm-6 col-xl-2">
                            <div class="card border bg-warning">

                                <a href="{{route('traitementsuppressiondomaine.indexyancho')}}" class="card-body text-white">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div class="content-left">
                                            <span class=" text-white">Demandes de suprression en attente de validation</span>
                                            <span class="bg-danger badge">
                                            <?php $j=0; ?>
                                                @foreach ($resultat as $demandesuppressiondomaines)
                                                    @foreach ($demandesuppressiondomaines as  $key => $demandesuppressiondomaine)
                                                            <?php $j = $j+1; ?>
                                                    @endforeach
                                                @endforeach
                                                {{@$j}}
                                        </span>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-2">
                            <div class="card border border-warning">
                                <a href="{{route('traitementdemandehabilitation.affectation')}}" class="card-body text-heading">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div class="content-left">
                                        <span class=" fw-bold text-heading">Demandes de suprression en attente d'affectation
                                         </span>
                                            <span class="bg-danger badge">{{$demandesuppressiondomaines->count()}}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                @endif
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
                                <th>Responsable formation </th>
                                <th>Code </th>
                                <th>Domaine de formation</th>
                                <th>Date de création</th>
                                <th>Date de soumission</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; ?>

                            @foreach ($resultat as $demandesuppressiondomaines)
                                @foreach ($demandesuppressiondomaines as  $key => $demandesuppressiondomaine)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td>{{ @$demandesuppressiondomaine->nom_responsable_demande_habilitation }}</td>
                                        <td>{{ @$demandesuppressiondomaine->code_demande_habilitation }}</td>
                                        <td>{{ @$demandesuppressiondomaine->libelle_domaine_formation }}</td>
                                        <td>{{ @$demandesuppressiondomaine->date_creer_demande_habilitation }}</td>
                                        <td>{{ @$demandesuppressiondomaine->date_soumis_demande_habilitation }}</td>
                                        <td align="center">
                                            <span class="badge bg-warning">En Attente de traitement</span>
                                        </td>
                                        <td align="center">

                                            <a href="{{ route($lien . '.edit',[\App\Helpers\Crypt::UrlCrypt($demandesuppressiondomaine->id_demande_suppression_habilitation),
                                                                        \App\Helpers\Crypt::UrlCrypt($demandesuppressiondomaine->id_combi_proc)] ) }}"
                                               class=" " title="Modifier"><img
                                                    src='/assets/img/editing.png'></a>

                                        </td>
                                    </tr>

                                @endforeach
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


