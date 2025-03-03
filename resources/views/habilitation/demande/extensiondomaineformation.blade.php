<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;


?>

@if(auth()->user()->can('demandehabilitation-create'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Habilitation')
    @php($titre='Liste des demandes habilitation')
    @php($soustitre='Demande d\'habilitation')
    @php($lien='demandehabilitation')

    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
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

        @if($errors->any())
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
                            <div class="nav-align-top nav-tabs-shadow mb-4">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-top-extensiondomaineformation"
                                            aria-controls="navs-top-extensiondomaineformation"
                                            aria-selected="false">
                                            Information sur la demande
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link disabled"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-top-domaineformation"
                                            aria-controls="navs-top-domaineformation"
                                            aria-selected="false">
                                            Domaine de formation
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link disabled"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-top-formateur"
                                            aria-controls="navs-top-formateur"
                                            aria-selected="false">
                                            Formateur
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="navs-top-extensiondomaineformation" role="tabpanel">
                                        <form method="post" enctype="multipart/form-data" action="{{ route($lien.'.extensiondomaineformationstore', [\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                                        @csrf
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label> Motif <strong
                                                            style="color:red;">*</strong></label>
                                                    <select
                                                        class="select2 form-select-sm input-group" required  data-allow-clear="true" name="id_motif_demande_suppression_habilitation" id="id_motif_demande_suppression_habilitation" >
                                                        <option value="">Selectionner un motif</option>
                                                                                                    @foreach($motifs as $motif)
                                                                                                        <option value="{{$motif->id_motif}}"
                                                                                                        >{{$motif->libelle_motif}}</option>
                                                                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label">Pièce justificative <strong
                                                        style="color:red;">*</strong></label>
                                                <div><input type="file" name="piece_demande_suppression_habilitation"
                                                            class="form-control form-control-sm" placeholder="" required
                                                            value="{{ old('piece_domaine_demande_extension_habilitation') }}"/>
                                                </div>

                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire de la demande d'extension <strong
                                                            style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm" required
                                                              name="commentaire_demande_suppression_habilitation"
                                                              id="commentaire_demande_suppression_habilitation" rows="7"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit" name="action" value="enregistrer"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="navs-top-domaineformation" role="tabpanel">
                                    </div>
                                    <div class="tab-pane fade" id="navs-top-formateur" role="tabpanel">
                                    </div>
                                        </div>
                                </div>
                                </div>
                        </div>

        <!-- END: Content-->

        @endsection

        @section('js_perso')
        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
