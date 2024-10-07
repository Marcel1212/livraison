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
                                            data-bs-target="#navs-top-suppressiondomaineformation"
                                            aria-controls="navs-top-suppressiondomaineformation"
                                            aria-selected="false">
                                            Information sur la demande
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="navs-top-suppressiondomaineformation" role="tabpanel">
                                        <form method="post" enctype="multipart/form-data" action="{{ route($lien.'.suppressiondomaineformationupdate', [\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                                        @csrf
                                            <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                    <label> Domaines de formation <strong
                                                            style="color:red;">*</strong></label>
                                                    <select
                                                        class="select2 form-control form-select-sm input-group"

                                                        @if($demande_suppression->flag_soumis_demande_suppression_habilitation==true)
                                                            disabled
                                                        @endif
                                                        required multiple  data-allow-clear="true" name="id_domaine_demande_habilitation[]" id="id_domaine_demande_habilitation" >
                                                        @foreach($domaineDemandeHabilitations as $domaineDemandeHabilitation)
                                                            <option value="{{$domaineDemandeHabilitation->id_domaine_demande_habilitation}}"

                                                                    @foreach($demande_suppression->domaineDemandeSuppressionHabilitations as $domaine)
                                                                        @if($domaine->id_domaine_demande_habilitation == $domaineDemandeHabilitation->id_domaine_demande_habilitation)
                                                                            selected
                                                                        @endif
                                                                    @endforeach
                                                            >{{$domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation}} /
                                                                {{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }} /
                                                                {{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label> Motif <strong
                                                            style="color:red;">*</strong></label>
                                                    <select
                                                        class="select2 form-select-sm input-group" required  data-allow-clear="true"
                                                        @if($demande_suppression->flag_soumis_demande_suppression_habilitation==true)
                                                            disabled
                                                        @endif

                                                        name="id_motif_demande_suppression_habilitation" id="id_motif_demande_suppression_habilitation" >
                                                        <option value="">Selectionner un motif</option>
                                                        @foreach($motifs as $motif)

                                                                                                        <option value="{{$motif->id_motif}}"
                                                                                                        @if(@$demande_suppression->id_motif_demande_suppression_habilitation==@$motif->id_motif)
                                                                                                        selected
                                                                                                            @endif >{{$motif->libelle_motif}}</option>

                                                                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label">Pièce justificative <strong
                                                        style="color:red;">*</strong></label>
                                                @if($demande_suppression->flag_soumis_demande_suppression_habilitation==false)

                                                <div>
                                                    <input type="file" name="piece_demande_suppression_habilitation"
                                                            class="form-control form-control-sm" placeholder=""
                                                            value="{{ old('piece_demande_suppression_habilitation') }}"/>
                                                </div>
                                                @endif
                                                @isset($demande_suppression->piece_demande_suppression_habilitation)
                                                    <div>
                                                    <span class="badge bg-secondary mt-2">
                                                                <a target="_blank"
                                                                   onclick="NewWindow('{{ asset("pieces/demande_suppression_domaine/". $demande_suppression->piece_demande_suppression_habilitation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                    Voir la pièce
                                                                </a>
                                                            </span>
                                                    </div>
                                                @endisset

                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>

                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire de la demande de suppression <strong
                                                            style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm" required
                                                              @if($demande_suppression->flag_soumis_demande_suppression_habilitation==true)
                                                                disabled
                                                              @endif
                                                                  name="commentaire_demande_suppression_habilitation"
                                                              id="commentaire_demande_suppression_habilitation" rows="7">{{@$demande_suppression->commentaire_demande_suppression_habilitation}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                @if($demande_suppression->flag_soumis_demande_suppression_habilitation==false)
                                                <button type="submit" name="action" value="soumettre"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light"
                                                        onclick='javascript:if (!confirm("Cette ction est irréversible. Voulez-vous Effectuer cette demande de supression ?")) return false;' >
                                                    Soumettre
                                                </button>
                                                <button type="submit" name="action" value="enregistrer"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                @endif

                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </form>
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
