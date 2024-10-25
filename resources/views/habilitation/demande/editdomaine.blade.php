<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;


?>

@if(auth()->user()->can('demandehabilitation-edit'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Habilitation')
    @php($titre='Liste des demandes habilitation')
    @php($soustitre='Demande de suppression')
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
                        <h6 class="text-muted"></h6>
                        <div class="nav-align-top nav-tabs-shadow mb-4">
                            <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link <?php if($idetape==1){ echo "active";} ?>"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-domaineformation"
                                aria-controls="navs-top-domaineformation"
                                aria-selected="true">
                                Domaine de formation
                                </button>
                            </li>

                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link <?php if($idetape==2){ echo "active";} ?>"

                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-demandesuppression"
                                aria-controls="navs-top-demandesuppression"
                                aria-selected="false">
                                Demande de suppression
                                </button>
                            </li>
{{--                                <li class="nav-item">--}}
{{--                                    <button--}}
{{--                                        type="button"--}}
{{--                                        class="nav-link <?php if($idetape==3){ echo "active";} ?>"--}}
{{--                                        role="tab"--}}
{{--                                        data-bs-toggle="tab"--}}
{{--                                        data-bs-target="#navs-top-historique"--}}
{{--                                        aria-controls="navs-top-historique"--}}
{{--                                        aria-selected="true">--}}
{{--                                        Historique des demandes de suppression--}}
{{--                                        du domaine--}}
{{--                                    </button>--}}
{{--                                </li>--}}

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade <?php if($idetape==1){ echo "show active";}  ?>" id="navs-top-domaineformation" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="billings-country">La finalité  <strong style="color:red;">*</strong></label>
                                            <select disabled class="select2 input-group @error('id_type_domaine_demande_habilitation')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_type_domaine_demande_habilitation">
                                                    <?= $typedomaine; ?>
                                            </select>
                                            @error('id_type_domaine_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label" for="billings-country">Le public  <strong style="color:red;">*</strong></label>
                                            <select disabled class="select2 form-select-sm input-group @error('id_type_domaine_demande_habilitation_public')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_type_domaine_demande_habilitation_public">
                                                    <?= $typedomainepublic; ?>
                                            </select>
                                            @error('id_type_domaine_demande_habilitation_public')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label" for="billings-country">Domaine de formation <strong style="color:red;">*</strong></label>
                                            <select disabled class="select2 form-select-sm input-group @error('id_domaine_formation')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_domaine_formation">
                                                    <?= $domaine; ?>

                                            </select>
                                            @error('id_domaine_formation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h5 class="mb-0">Liste des formateurs associés au domaine</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-striped table-hover table-sm"
                                                   id=""
                                                   style="margin-top: 13px !important">
                                                <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nom et prénom </th>
                                                    <th>Année d'experience </th>
                                                    <th>Cv  </th>
                                                    <th>Lettre d'engagement </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                @isset($domaineHabilitation->formateurDomaineDemandeHabilitations)
                                                    @foreach ($domaineHabilitation->formateurDomaineDemandeHabilitations as $key => $formateur)
                                                            <?php $i += 1;?>
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $formateur->nom_formateur }} {{ $formateur->prenom_formateur }}</td>
                                                            <td>
                                                                    <?php
                                                                    if(isset($formateur->date_fin_formateur)){
                                                                        $datedebut = \Carbon\Carbon::parse($formateur->date_debut_formateur);
                                                                        $datefin = \Carbon\Carbon::parse($formateur->date_fin_formateur);

                                                                        $anneexperience = $datedebut->diffInYears($datefin);
                                                                    }else {
                                                                        $datedebut = \Carbon\Carbon::parse($formateur->date_debut_formateur);
                                                                        $datefin = \Carbon\Carbon::now();

                                                                        $anneexperience = $datedebut->diffInYears($datefin);
                                                                    }

                                                                    echo $anneexperience;
                                                                    ?>
                                                            </td>
                                                            <td>
                                                                        <span class="badge bg-secondary">
                                                                            <a target="_blank"
                                                                               onclick="NewWindow('{{ asset("/pieces/cv_formateur/". $formateur->cv_formateur)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                                Voir la pièce
                                                                            </a>
                                                                        </span>
                                                            </td>
                                                            <td>
                                                                        <span class="badge bg-secondary">
                                                                            <a target="_blank"
                                                                               onclick="NewWindow('{{ asset("/pieces/le_formateur/". $formateur->le_formateur)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                                Voir la pièce
                                                                            </a>
                                                                        </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endisset
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade <?php if($idetape==2){ echo "show active";}  ?>" id="navs-top-demandesuppression" role="tabpanel">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">{{$soustitre}}</h5>
                                        <small class="text-muted float-end">
                                        @if($domaineHabilitation->flag_agree_domaine_demande_habilitation==true)
                                                @can($lien.'-create')
                                                    <a href="#"
                                                       data-bs-toggle="modal" data-bs-target="#new_demande"
                                                       class="btn btn-sm btn-primary waves-effect waves-light">
                                                        <i class="menu-icon tf-icons ti ti-plus"></i> Nouvelle demande </a>
                                                @endcan
                                            @endif
                                        </small>
                                    </div>
                                    <table class="table table-bordered table-striped table-hover table-sm"
                                           id=""
                                           style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Motif de la demande</th>
                                            <th>Commentaire de la demande</th>
                                            <th>Pièce justificatif  </th>
                                            <th>Réponse du traitment de la demande</th>
                                            <th>Statut </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                        @isset($domaineSuppressionHabilitations)
                                            @foreach (@$domaineSuppressionHabilitations as $key => $domaineSuppressionHabilitation)
                                                    <?php $i += 1;?>
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>
                                                        @if(@$domaineSuppressionHabilitation->motif)
                                                            {{ $domaineSuppressionHabilitation->motif->libelle_motif }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(@$domaineSuppressionHabilitation->commentaire_domaine_demande_suppression_habilitation)
                                                            {{ $domaineSuppressionHabilitation->commentaire_domaine_demande_suppression_habilitation }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                            @isset($domaineSuppressionHabilitation->piece_domaine_demande_suppression_habilitation)
                                                                <span class="badge bg-secondary mt-2">
                                                                <a target="_blank"
                                                                   onclick="NewWindow('{{ asset("pieces/demande_suppression_domaine/". $domaineSuppressionHabilitation->piece_domaine_demande_suppression_habilitation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                    Voir la pièce
                                                                </a>
                                                            </span>
                                                        @endisset
                                                    </td>
                                                    <td>
                                                        @isset($domaineSuppressionHabilitation->commentaire_final_domaine_demande_suppression_habilitation)
                                                            {{$domaineSuppressionHabilitation->commentaire_final_domaine_demande_suppression_habilitation}}
                                                        @endisset
                                                    </td>
                                                    <td>
                                                        @if($domaineSuppressionHabilitation->flag_rejeter_domaine_demande_suppression_habilitation==false &&
$domaineSuppressionHabilitation->flag_validation_domaine_demande_suppression_habilitation==false
                                                         )
                                                            <span class="badge bg-warning">En cours de traitement</span>
                                                        @elseif($domaineSuppressionHabilitation->flag_rejeter_domaine_demande_suppression_habilitation==true)
                                                            <span class="badge bg-danger">Rejeté</span>
                                                        @elseif($domaineSuppressionHabilitation->flag_validation_domaine_demande_suppression_habilitation==true)
                                                            <span class="badge bg-success">Validé</span>

                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endisset
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                        </div>
                        </div>
    </div>

        <!-- END: Content-->
    <div class="modal fade" id="new_demande" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Demande de suppression</h3>
                        <p class="text-muted"></p>
                    </div>
                    @isset($domaineSuppressionHabilitationEnCours)
                        <div class="alert alert-warning text-center">
                            <p>Une demande de suppression est déjà en cours pour votre compte. Nous vous remercions de patienter pendant son traitement.</p>
                        </div>
                        @else
                        <form method="post" enctype="multipart/form-data" action="{{ route($lien.'.deletedomainestore', [\App\Helpers\Crypt::UrlCrypt($domaineHabilitation->id_domaine_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                            @csrf
                            <div class="col-md-12">
                                <div class="mb-1">
                                    <label> Motif <strong
                                            style="color:red;">*</strong></label>
                                    <select
                                        class="select2 form-select-sm input-group" required  data-allow-clear="true" name="id_motif_domaine_demande_suppression_habilitation" id="id_motif_domaine_demande_suppression_habilitation" >
                                        <option value="">Selectionner un motif</option>
                                        @foreach($motifs as $motif)
                                            <option value="{{$motif->id_motif}}"
                                            >{{$motif->libelle_motif}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 mt-3">
                                <div class="mb-1">
                                    <label>Commentaire de la demande de suppression <strong
                                            style="color:red;">*</strong></label>
                                    <textarea class="form-control form-control-sm" required
                                              name="commentaire_domaine_demande_suppression_habilitation"
                                              id="commentaire_domaine_demande_suppression_habilitation" rows="7"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="form-label">Pièce justificative <strong
                                        style="color:red;">*</strong></label>
                                <div><input type="file" name="piece_domaine_demande_suppression_habilitation"
                                            class="form-control form-control-sm" placeholder="" required
                                            value="{{ old('piece_domaine_demande_suppression_habilitation') }}"/>
                                </div>

                                <div id="defaultFormControlHelp" class="form-text ">
                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                        maxi : 5Mo</em>
                                </div>
                            </div>


                            <div class="col-12 text-center mt-2">
                                <button onclick='javascript:if (!confirm("Voulez-vous Effectuer la demande de supression de ce domaine de formation ?")) return false;' type="submit" name="action" value="soumettre" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
                                <button
                                    type="reset"
                                    class="btn btn-label-secondary"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Annuler
                                </button>
                            </div>
                        </form>

                    @endisset
                </div>
            </div>
        </div>
    </div>


@endsection

        @section('js_perso')


        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
