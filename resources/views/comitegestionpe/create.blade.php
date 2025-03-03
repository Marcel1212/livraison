<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module = 'Projet d\'etude')
    @php($titre = 'Liste des comites de gestion')
    @php($soustitre = 'Ajout de comite de gestion')
    @php($lien = 'comitegestionpe')

    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / {{ $titre }} /
        </span> {{ $soustitre }}
    </h5>




    <div class="content-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{ $anneexercice }}
                </div>
                <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif


        <div class="col-xl-12">
            <h6 class="text-muted"></h6>
            <div class="nav-align-top nav-tabs-shadow mb-4">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-planformation" aria-controls="navs-top-planformation"
                            aria-selected="true">
                            Comite de gestion
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-categoriesprofessionel"
                            aria-controls="navs-top-categoriesprofessionel" aria-selected="false">
                            Personnes ressources
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-actionformation" aria-controls="navs-top-actionformation"
                            aria-selected="false">
                            Liste des projets d'etudes
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-Soumettre" aria-controls="navs-top-Soumettre" aria-selected="false">
                            Agrément
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-top-planformation" role="tabpanel">

                        <form method="POST" class="form" action="{{ route($lien . '.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Date de debut <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_debut_comite_gestion"
                                            class="form-control form-control-sm" required />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Date de fin <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_fin_comite_gestion"
                                            class="form-control form-control-sm" required />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire <strong style="color:red;">*</strong></label>
                                        <textarea class="form-control form-control-sm" name="commentaire_comite_gestion" id="commentaire_comite_gestion"
                                            rows="6"></textarea>

                                    </div>
                                </div>


                                <div class="col-12" align="right">
                                    <hr>
                                    <button type="submit"
                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Suivant
                                    </button>
                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                        Retour</a>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="navs-top-actionformation" role="tabpanel">
                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Entreprise </th>
                                    {{-- <th>Conseiller </th> --}}
                                    <th>Code </th>
                                    <th>Date de soumission</th>
                                    <th>Cout formation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php //dd($planformations);
                                $i = 0; ?>
                                @foreach ($planformations as $key => $planformation)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ @$planformation->entreprise->ncc_entreprises }} /
                                            {{ @$planformation->entreprise->raison_social_entreprises }}</td>
                                        {{-- <td>{{ @$planformation->userconseilplanformation->name }}
                                            {{ @$planformation->userconseilplanformation->prenom_users }}</td> --}}
                                        <td>{{ @$planformation->code_projet_etude }}</td>
                                        <td>{{ $planformation->date_soumis }}</td>
                                        <td align="rigth">
                                            {{ number_format($planformation->cout_projet_etude) }}</td>
                                        <td align="center">

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-12" align="right">
                            <hr>



                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                Retour</a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END: Content-->

@endsection
