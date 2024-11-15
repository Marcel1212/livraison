<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module = 'Projet de formation')
    @php($titre = 'Liste des comites plénières')
    @php($soustitre = 'Ajout de comite  plénière')
    @php($lien = 'ctprojetformation')


    <style>
        /* Style pour l'arrière-plan obscurci */
        .overlay {
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            transition: all 0.135s ease-in-out;
            transform: scale(1.001);
        }
    </style>

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
                            Comite plénière
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-actionformation" aria-controls="navs-top-actionformation"
                            aria-selected="false">
                            Personnes ressouces
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-categoriesprofessionel"
                            aria-controls="navs-top-categoriesprofessionel" aria-selected="false">
                            Liste des projets de formations
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-Soumettre" aria-controls="navs-top-Soumettre" aria-selected="false">
                            Cahier
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
                                        <input type="date" name="date_debut_comite_pleniere"
                                            id="date_debut_comite_pleniere" class="form-control form-control-sm"
                                            onchange="verifierDate()" required />
                                    </div>
                                    <div class="overlay">
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#Message" id="Btn1"
                                            style="display: none;">

                                        </button>

                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#MessageFirst" id="Btn2"
                                            style="display: none;">

                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" style="display: none;">
                                    <div class="mb-1">
                                        <label>Date de fin <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_fin_comite_pleniere" id="date_fin_comite_pleniere"
                                            class="form-control form-control-sm" onchange="verifierDateFin()" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Intitulé de la comité <strong style="color:red;">*</strong></label>
                                        <input type="text" name="intitule_comite" id="intitule_comite"
                                            class="form-control form-control-sm" required />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire <strong style="color:red;">*</strong></label>
                                        <textarea class="form-control form-control-sm" name="commentaire_comite_pleniere" id="commentaire_comite_pleniere"
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

                    </div>
                    <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Date anterieur a date du jour -->
    <div class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" id="MessageFirst">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Veuillez selectionner une autre date car celle-ci est
                        déjà passé
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">
                        Fermer
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- Message erreur date de fin sup a fin-->
    <div class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" id="Message">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">La date de fin doit être superieur à la date de debut
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal">
                        Fermer
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- END: Content-->

    <script>
        function verifierDate() {
            // Obtenez la date actuelle
            var dateDuJour = new Date();

            // Obtenez la date sélectionnée (à des fins de démonstration, vous pouvez remplacer cela par la manière dont vous obtenez la date sélectionnée dans votre application)
            var dateSelectionnee = new Date(document.getElementById("date_debut_comite_pleniere").value);
            //alert(dateSelectionnee);

            // Comparez les dates
            if (dateSelectionnee.getTime() === dateDuJour.getTime()) {
                console.log("La date sélectionnée est la même que la date du jour.");
            } else if (dateSelectionnee.getTime() > dateDuJour.getTime()) {
                console.log("La date sélectionnée est dans le futur.");
            } else {
                //console.log("La date sélectionnée est dans le passé.");
                //alert("Veuillez selectionner une autre date car celle-ci est déjà passé");

                //var overlay = document.getElementById('Message');
                // overlay.style.display = 'flex';
                document.getElementById("Btn2").click();
                var champ = document.getElementById("date_debut_comite_pleniere");
                champ.value = "";
            }

            var dateFin = new Date(document.getElementById("date_fin_comite_pleniere").value);
            //alert(dateFin.getTime());
            if (isNaN(dateFin.getTime())) {
                dateFin.getTime() = "";
            } else {
                verifierDateFin();
            }
        }


        function verifierDateFin() {
            // Obtenez la date actuelle
            var dateDuJour = new Date();

            // Obtenez la date sélectionnée (à des fins de démonstration, vous pouvez remplacer cela par la manière dont vous obtenez la date sélectionnée dans votre application)
            var dateSelectionnee = new Date(document.getElementById("date_fin_comite_pleniere").value);
            //alert(dateSelectionnee);

            // Comparez les dates
            if (dateSelectionnee.getTime() === dateDuJour.getTime()) {
                console.log("La date sélectionnée est la même que la date du jour.");
            } else if (dateSelectionnee.getTime() > dateDuJour.getTime()) {
                console.log("La date sélectionnée est dans le futur.");
            } else {
                //console.log("La date sélectionnée est dans le passé.");
                //alert("Veuillez selectionner une autre date car celle-ci est déjà passé");
                document.getElementById("Btn2").click();
                var champ = document.getElementById("date_fin_comite_pleniere");
                champ.value = "";
            }

            var dateDebut = new Date(document.getElementById("date_debut_comite_pleniere").value);
            var dateFin = new Date(document.getElementById("date_fin_comite_pleniere").value);
            //alert(dateDebut);
            if (dateFin.getTime() < dateDebut.getTime()) {
                //alert('La date de fin doit être superieur à la date de debut');
                document.getElementById("Btn1").click();
                var champFin = document.getElementById("date_fin_comite_pleniere");
                champFin.value = "";
            }
        }
    </script>

@endsection
