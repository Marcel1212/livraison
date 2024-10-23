<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;
use App\Helpers\Menu;
use App\Helpers\Fonction;

$codeRoles = Menu::get_code_menu_profil(Auth::user()->id);

//dd($codeRoles);
//dd($demandehabilitation->flag_reception_demande_habilitation);

?>

@if(auth()->user()->can('traitementsuppressiondomaine-edit'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Habilitation')
    @php($titre='Liste des demandes habilitation')
    @php($soustitre='Demande d\'habilitation')
    @php($lien='traitementsuppressiondomaine')

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

            @if($demande_extension->flag_rejeter_recevabilit_suppression_habilitation == true)
                <div align="right">
                    <button type="button"
                            class="btn rounded-pill btn-outline-success btn-sm waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#modalToggleCommentaireplan">
                        Voir les commentaire de la non recevabilité
                    </button>
                </div>
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
                                data-bs-target="#navs-top-informationentreprise"
                                aria-controls="navs-top-informationentreprise"
                                aria-selected="true">
                                Informations sur l'entreprise
                                </button>
                            </li>
                                <li class="nav-item">
                                    <button
                                        type="button"
                                        class="nav-link <?php if($idetape==2){ echo "active";} ?>"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-top-informationdemande"
                                        aria-controls="navs-top-informationdemande"
                                        aria-selected="true">
                                        Informations sur la demande
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button
                                        type="button"
                                        class="nav-link <?php if($idetape==3){ echo "active";} ?>"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-top-domaineformationdemande"
                                        aria-controls="navs-top-domaineformationdemande"
                                        aria-selected="true">
                                        Domaine de formation demandée
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button
                                        type="button"
                                        class="nav-link <?php if($idetape==4){ echo "active";} ?>"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-top-formateurs"
                                        aria-controls="navs-top-formateurs"
                                        aria-selected="true">
                                        Formateur associé à la demande
                                    </button>
                                </li>
{{--                            <li class="nav-item">--}}
{{--                                <button--}}
{{--                                type="button"--}}
{{--                                class="nav-link <?php if($idetape==5 and count($organisations)>0){ echo "active";} ?>"--}}
{{--                                role="tab"--}}
{{--                                data-bs-toggle="tab"--}}
{{--                                data-bs-target="#navs-top-domaineformation"--}}
{{--                                aria-controls="navs-top-domaineformation"--}}
{{--                                aria-selected="false">--}}
{{--                                Domaine de formation--}}
{{--                                </button>--}}
{{--                            </li>--}}
                                <li class="nav-item">
                                    <button
                                        type="button"
                                        class="nav-link <?php if($idetape==5){ echo "active";} ?>"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-top-traitement"
                                        aria-controls="navs-top-traitement"
                                        aria-selected="false">
                                        Traitement
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane fade <?php if($idetape==1){ echo "show active";}  ?>" id="navs-top-informationentreprise" role="tabpanel">

                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>N° de compte contribuable (NCC) </label>
                                                <input type="text"
                                                       class="form-control form-control-sm"
                                                       value="{{@$infoentreprise->ncc_entreprises}}" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Secteur activité </label>
                                                <input type="text"
                                                       class="form-control form-control-sm"
                                                       value="{{@$infoentreprise->secteurActivite->libelle_secteur_activite}}" disabled="disabled">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Localisation géographique </label>
                                                <input type="text" name="localisation_geographique_entreprise" id="localisation_geographique_entreprise"
                                                       class="form-control form-control-sm"
                                                       value="{{@$infoentreprise->localisation_geographique_entreprise}}" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Repère d'accès </label>
                                                <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                                       class="form-control form-control-sm"
                                                       value="{{@$infoentreprise->repere_acces_entreprises}}" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Adresse postal </label>
                                                <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                                       class="form-control form-control-sm"
                                                       value="{{@$infoentreprise->adresse_postal_entreprises}}" disabled="disabled">
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="billings-country">Indicatif</label>
                                                        <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                                                <?= $pay; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="form-label">Téléphone  </label>
                                                        <input type="text"
                                                               class="form-control form-control-sm"
                                                               value="{{@$infoentreprise->tel_entreprises}}" name="tel_entreprises" disabled="disabled">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="billings-country">Indicatif</label>
                                                        <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                                                <?= $pay; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="form-label">Cellulaire Professionnelle  </label>
                                                        <input type="number" name="cellulaire_professionnel_entreprises" id="cellulaire_professionnel_entreprises"
                                                               class="form-control form-control-sm"
                                                               value="{{@$infoentreprise->cellulaire_professionnel_entreprises}}" disabled="disabled">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="billings-country">Indicatif</label>
                                                        <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                                                <?= $pay; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="form-label">Fax  </label>
                                                        <input type="number" name="fax_entreprises" id="fax_entreprises"
                                                               class="form-control form-control-sm"
                                                               value="{{@$infoentreprise->fax_entreprises}}" disabled="disabled">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-12">
                                            <div class="mb-1">
                                                <label>Latitude </label> <br>
                                                <input type="text" name="latitude_entreprises" id="latitude_entreprises"
                                                       class="form-control form-control-sm"
                                                       value="{{@$infoentreprise->latitude_entreprises}}" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="mb-1">
                                                <label>Longitude </label> <br>
                                                <input type="text" name="longitude_entreprises" id="longitude_entreprises"
                                                       class="form-control form-control-sm"
                                                       value="{{@$infoentreprise->longitude_entreprises}}" disabled="disabled">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Nom et prénoms du responsable <strong style="color:red;">*</strong> </label>
                                                <input disabled type="text" name="nom_responsable_demande_habilitation" id="nom_responsable_demande_habilitation"
                                                       class="form-control form-control-sm"  value="{{ $demandehabilitation->nom_responsable_demande_habilitation }}">
                                            </div>
                                            @error('nom_responsable_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Fonction du responsable  <strong style="color:red;">*</strong> </label>
                                                <input disabled type="text" name="fonction_demande_habilitation" id="fonction_demande_habilitation"
                                                       class="form-control form-control-sm"  value="{{ $demandehabilitation->fonction_demande_habilitation }}">
                                            </div>
                                            @error('fonction_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Email professionnel du responsable  <strong style="color:red;">*</strong> </label>
                                                <input disabled type="text" name="email_responsable_habilitation" id="email_responsable_habilitation"
                                                       class="form-control form-control-sm"  value="{{ $demandehabilitation->email_responsable_habilitation }}">
                                            </div>
                                            @error('email_responsable_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Contact du responsable  <strong style="color:red;">*</strong> </label>
                                                <input disabled type="text" name="contact_responsable_habilitation" id="contact_responsable_habilitation"
                                                       class="form-control form-control-sm"  value="{{ $demandehabilitation->contact_responsable_habilitation }}">
                                            </div>
                                            @error('contact_responsable_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Maison mere ou tutelle <strong style="color:red;">(s'il y a lieu)</strong> </label>
                                                <input  disabled type="text" name="maison_mere_demande_habilitation" id="maison_mere_demande_habilitation"
                                                        class="form-control form-control-sm" value="{{ $demandehabilitation->maison_mere_demande_habilitation }}"/>
                                            </div>
                                            @error('maison_mere_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label"  for="billings-country">Agence domiciliation <strong style="color:red;">*</strong></label>
                                            <select disabled class="select2 form-select-sm input-group @error('id_banque')
                                                    error
                                                    @enderror" data-allow-clear="true" name="id_banque">
                                                    <?= $banque; ?>
                                            </select>
                                            @error('id_banque')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <a class="btn btn-sm me-1 btn-outline-secondary waves-effect"
                                           href="/{{$lien }}">
                                            Retour</a>

                                        <a class="btn btn-sm btn-primary waves-effect"
                                           href="{{route('traitementextensiondomaine.edit',[\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(2)])}}">
                                            Suivant</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade <?php if($idetape==2){ echo "show active";}  ?>" id="navs-top-informationdemande" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-1">
                                                <label> Motif <strong
                                                        style="color:red;">*</strong></label>
                                                <select
                                                    class="select2 form-select-sm input-group" required  data-allow-clear="true"
                                                        disabled
                                                    name="id_motif_demande_suppression_habilitation" id="id_motif_demande_suppression_habilitation" >
                                                    <?=$motif;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="form-label">Pièce justificative <strong
                                                    style="color:red;">*</strong></label>
                                            <div>
                                                    <div>
                                                    <span class="badge bg-secondary mt-2">
                                                                <a target="_blank"
                                                                   onclick="NewWindow('{{ asset("pieces/demande_suppression_domaine/". $demande_extension->piece_demande_suppression_habilitation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                    Voir la pièce
                                                                </a>
                                                            </span>
                                                    </div>
                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label>Commentaire de la demande de suppression <strong
                                                        style="color:red;">*</strong></label>
                                                <textarea class="form-control form-control-sm" required
                                                              disabled
                                                          name="commentaire_demande_suppression_habilitation"
                                                          id="commentaire_demande_suppression_habilitation" rows="7">{{@$demande_extension->commentaire_demande_suppression_habilitation}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <a class="btn btn-sm me-1 btn-outline-secondary waves-effect"
                                           href="/{{$lien }}">
                                            Retour</a>
                                        <a class="btn btn-sm btn-secondary waves-effect"
                                           href="{{route('traitementextensiondomaine.edit',[\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(1)])}}">
                                            Précédent</a>
                                        <a class="btn btn-sm btn-primary waves-effect"
                                           href="{{route('traitementextensiondomaine.edit',[\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(3)])}}">
                                            Suivant</a>
                                    </div>

                                </div>
                                <div class="tab-pane fade <?php if($idetape==3){ echo "show active";}  ?>" id="navs-top-domaineformationdemande" role="tabpanel">
                                    <div class="row">
                                        <table class="table table-bordered table-striped table-hover table-sm"
                                               id=""
                                               style="margin-top: 13px !important">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Finalité </th>
                                                <th>Public </th>
                                                <th>Domaine de formation </th>
                                                @if($demande_extension->flag_soumis_demande_suppression_habilitation!=true)

                                                    <th>Action</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                            @foreach ($domaine_list_demandes as $key => $domaineDemandeHabilitation)
                                                    <?php $i += 1;?>
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}</td>
                                                    <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }}</td>
                                                    <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}</td>
                                                    @if($demande_extension->flag_soumis_demande_suppression_habilitation!= true)

                                                        <td>
                                                            <a href="{{ route($lien.'.deletedomaineDemandeExtension',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt($domaineDemandeHabilitation->id_domaine_demande_habilitation)]) }}"
                                                               class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                               title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                        </td>
                                                    @endif

                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <a class="btn btn-sm me-1 btn-outline-secondary waves-effect"
                                           href="/{{$lien }}">
                                            Retour</a>
                                        <a class="btn btn-sm btn-secondary waves-effect"
                                           href="{{route('traitementextensiondomaine.edit',[\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(2)])}}">
                                            Précédent</a>
                                        <a class="btn btn-sm btn-primary waves-effect"
                                           href="{{route('traitementextensiondomaine.edit',[\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(4)])}}">
                                            Suivant</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade <?php if($idetape==4){ echo "show active";}  ?>" id="navs-top-formateurs" role="tabpanel">
                                    <div class="row">
                                        <table class="table table-bordered table-striped table-hover table-sm"
                                               id=""
                                               style="margin-top: 13px !important">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Domaine</th>
                                                <th>Nom et prénom </th>
                                                <th>Année d'experience </th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                            @foreach ($formateurs as $key => $formateur)
                                                    <?php $i += 1;?>
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $formateur->libelle_type_domaine_demande_habilitation }} - {{ $formateur->libelle_type_domaine_demande_habilitation_public }} - {{ $formateur->libelle_domaine_formation }}</td>
                                                    <td>{{ $formateur->formateur->nom_formateurs }} {{ $formateur->prenom_formateurs }}</td>
                                                    <td>{{  Fonction::calculerAnneesExperience($formateur->id_formateurs)  }}</td>
                                                    <td>
                                                        <a onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                           class=" "
                                                           title="Modifier"><img src='/assets/img/eye-solid.png'></a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>
                                        <a class="btn btn-sm me-1 btn-outline-secondary waves-effect"
                                           href="/{{$lien }}">
                                            Retour</a>
                                        <a class="btn btn-sm btn-secondary waves-effect"
                                           href="{{route('traitementextensiondomaine.edit',[\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(3)])}}">
                                            Précédent</a>
                                        <a class="btn btn-sm btn-primary waves-effect"
                                           href="{{route('traitementextensiondomaine.edit',[\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(5)])}}">
                                            Suivant</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade <?php if($idetape==5){ echo "show active";}  ?>" id="navs-top-traitement" role="tabpanel">
                                    @if ($demande_extension->flag_recevabilite != true)
                                        <form  method="POST" class="form" action="{{ route('traitementextensiondomaine'.'.update', [\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(5)]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="billings-country">Les motifs d'irrecevabilité <strong style="color:red;">(Obligatoire si non recevable)*</strong></label>
                                                                                    <select class="select2 form-select input-group" data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">
                                                                                            <?= $motif_recevabilite; ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label>Commentaire Recevabilité <strong style="color:red;">(Obligatoire si non recevable)*</strong>: </label>
                                                                                        <textarea class="form-control form-control-sm"  name="commentaire_recevabilite" id="commentaire_recevabilite" rows="6">{{@$demande_extension->commentaire_recevabilite}}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12" align="right">
                                                                                    <hr>
                                                                                    <button type="submit" name="action" value="Recevable"
                                                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                                                                        Recevable
                                                                                    </button>
                                                                                    <button type="submit" name="action" value="NonRecevable"
                                                                                            class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                                                                        Non recevable
                                                                                    </button>
                                                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                                                       href="/{{$lien }}">
                                                                                        Retour</a>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                    @else
                                        <form  method="POST" class="form" action="{{ route('traitementextensiondomaine'.'.update', [\App\Helpers\Crypt::UrlCrypt($demande_extension->id_demande_suppression_habilitation),\App\Helpers\Crypt::UrlCrypt(5)]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')

                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-1">
                                                        <label>Observations <strong style="color:red;">*</strong>: </label>
                                                        <textarea class="form-control form-control-sm"  name="observation_instruction" id="observation_instruction" rows="6">{{@$demande_extension->observation_instruction}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12" align="right">
                                                    <hr>
                                                    <button type="submit" name="action" value="instruction"
                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                                        Valider
                                                    </button>

                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                       href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                            </div>
                                        </form>
                                    @endif

                                </div>
                                <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggleCommentaireplan"
                                     aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalToggleLabel">Commentaire </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="card">
                                                <h5 class="card-header">Commentaire des non recevabilités</h5>
                                                <div class="card-body pb-2">
                                                    <ul class="timeline pt-3">

                                                        <li class="timeline-item pb-4 timeline-item-primary border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-primary">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                                            @foreach($commentairenonrecevables as $com)
                                                                <div class="timeline-event">
                                                                    <div class="timeline-header border-bottom mb-3">
                                                                        <h6 class="mb-0"></h6>
                                                                        <span class="text-muted"><strong>{{ $com->motif->libelle_motif}}</strong></span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between flex-wrap mb-2">
                                                                        <div class="d-flex align-items-center">

                                                                            <div class="row ">
                                                                                <div>
                                                                                    <span>Observation :   <?php echo $com->commentaire_commentaire_non_recevable_demande; ?></span>
                                                                                </div>
                                                                            </div>


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
{{--                                <div class="tab-pane fade <?php if($idetape==9){ echo "show active";} ?>" id="navs-top-recevabilite" role="tabpanel">--}}
{{--
{{--                                </div>--}}
{{--                                <div class="tab-pane fade <?php if($idetape==9){ echo "show active";} ?>" id="navs-top-traitement" role="tabpanel">--}}
{{--                                    <!-- Full calendar start -->--}}
{{--                                        <?php //dd($demandehabilitation->visites->statut); ?>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-8">--}}

{{--                                        </div>--}}
{{--                                        <div class="col-4" align="right">--}}
{{--                                            @if (@$visites->statut == "terminer")--}}
{{--                                                <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(10)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Editer le rapport</a>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}

{{--                                        <br/>--}}
{{--                                        <br/>--}}
{{--                                    </div>--}}
{{--                                    <div id="success_text"></div>--}}
{{--                                    <div id="success_text_rapport"></div>--}}
{{--                                    <section>--}}
{{--                                        <div class="app-calendar overflow-hidden border">--}}
{{--                                            <div class="row ">--}}
{{--                                                <!-- Sidebar -->--}}
{{--                                                <div class="col-md-2 ps-4 pt-4 pe-4 app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">--}}
{{--                                                    <div class="sidebar-wrapper">--}}
{{--                                                        @if (count(@$rapportVisite)<1)--}}
{{--                                                            <div class="card-body d-flex justify-content-center">--}}
{{--                                                                <button class="btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="modal" data-bs-target="#add-new-sidebar">--}}
{{--                                                                    <span class="align-middle">Prise de rendez-vous</span>--}}
{{--                                                                </button>--}}
{{--                                                            </div>--}}
{{--                                                        @endif--}}


{{--                                                        <div class="filter-section">--}}
{{--                                                            <label for="filter-status" class="form-label">Filtrer par statut</label>--}}
{{--                                                            <select id="filter-status" class="form-select w-100">--}}
{{--                                                                <option value="">Tous</option>--}}
{{--                                                                <option value="planifier">Planifier</option>--}}
{{--                                                                <option value="commencer">Commencer</option>--}}
{{--                                                                <option value="terminer">Terminer</option>--}}
{{--                                                                <option value="annuler">Annuler</option>--}}
{{--                                                                <option value="reporter">Reporter</option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <!-- /Sidebar -->--}}

{{--                                                <!-- Calendar -->--}}
{{--                                                <div class="col-md-10 position-relative">--}}
{{--                                                    <div class="card shadow-none border-0 mb-0 rounded-0">--}}
{{--                                                        <div class="card-body pb-0">--}}
{{--                                                            <div id="calendar"></div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <!-- /Calendar -->--}}
{{--                                                <div class="body-content-overlay"></div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!-- Calendar Add/Update/Delete event modal-->--}}
{{--                                        <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">--}}
{{--                                            <div class="modal-dialog sidebar-lg">--}}
{{--                                                <div class="modal-content p-0">--}}
{{--                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>--}}
{{--                                                    <div class="modal-header mb-1">--}}
{{--                                                        <h5 class="modal-title">Prise de rendez-vous</h5>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">--}}
{{--                                                        <div id="error_text"></div>--}}



{{--                                                        <!-- Formulaire d'événement -->--}}
{{--                                                        <form class="event-form needs-validation" id="event-form" data-ajax="false" novalidate>--}}
{{--                                                            <!-- Champ caché pour l'ID de la demande d'habilitation -->--}}
{{--                                                            <input type="hidden" id="id_demande_habilitation" name="id_demande_habilitation" value="{{ $demandehabilitation->id_demande_habilitation }}">--}}



{{--                                                            <!-- Sélection du statut -->--}}
{{--                                                            <div class="mb-1">--}}
{{--                                                                <label for="select-label" class="form-label">Statut</label>--}}
{{--                                                                <select class="select2 select-label form-select w-100" id="select-label" name="select-label" required>--}}
{{--                                                                    <option data-label="primary" value="planifier">Planifier</option>--}}
{{--                                                                    <option data-label="info" value="commencer">Commencer</option>--}}
{{--                                                                    <option data-label="success" value="terminer">Terminer</option>--}}
{{--                                                                    <option data-label="danger" value="annuler">Annuler</option>--}}
{{--                                                                    <option data-label="warning" value="reporter">Reporter</option>--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}

{{--                                                            <!-- Date de début -->--}}
{{--                                                            <div class="mb-1 position-relative">--}}
{{--                                                                <label for="start-date" class="form-label">Date de début provisoire</label>--}}
{{--                                                                <input type="date" class="form-control" id="start-date" name="start-date" placeholder="Date de début" required />--}}
{{--                                                            </div>--}}

{{--                                                            <!-- Heure de fin -->--}}
{{--                                                            <div class="mb-1 position-relative">--}}
{{--                                                                <label for="end-date" class="form-label">Heure de debut provisoire </label>--}}
{{--                                                                <input type="time" class="form-control" id="end-date" name="end-date" placeholder="Heure de fin provisoire" required />--}}
{{--                                                            </div>--}}

{{--                                                            <div class="mb-1 position-relative">--}}
{{--                                                                <label for="enddateP" class="form-label">Heure de fin provisoire </label>--}}
{{--                                                                <input type="time" class="form-control" id="enddateP" name="enddateP" placeholder="Heure de fin provisoire" required />--}}
{{--                                                            </div>--}}

{{--                                                            <div class="mb-1 position-relative">--}}
{{--                                                                <label for="enddateR" class="form-label">Heure de fin reel </label>--}}
{{--                                                                <input type="time" class="form-control" id="enddateR" name="enddateR" placeholder="Heure de fin reel" required />--}}
{{--                                                            </div>--}}

{{--                                                            <!-- Description de l'événement -->--}}
{{--                                                            <div class="mb-1">--}}
{{--                                                                <label for="event-description-editor" class="form-label">Description</label>--}}
{{--                                                                <textarea class="form-control" id="event-description-editor" name="event-description-editor" required></textarea>--}}
{{--                                                            </div>--}}

{{--                                                            <!-- Boutons d'action -->--}}
{{--                                                            <div class="d-flex mb-1">--}}
{{--                                                                <button type="submit" class="btn btn-primary add-event-btn me-1">Ajouter</button>--}}
{{--                                                                <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Annuler</button>--}}
{{--                                                                <button type="submit" class="btn btn-primary update-event-btn d-none me-1">Mettre à jour</button>--}}
{{--                                                                <a href="" class="btn btn-success update-lien-event-btn d-none me-1">Aller sur le dossier</a>--}}
{{--                                                                <button type="button" class="btn btn-outline-danger btn-delete-event d-none">Supprimer</button>--}}
{{--                                                            </div>--}}
{{--                                                        </form>--}}

{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!--/ Calendar Add/Update/Delete event modal-->--}}
{{--                                    </section>--}}
{{--                                    <!-- Full calendar end -->--}}

{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>


        <!-- END: Content-->

        @endsection

        @section('js_perso')

            <script>
                                        $("#dernier_catalogue_demande_habilitation_div").show();

                                        $("#autre_activite_demande_habilitation_div").show();

                $('#information_catalogue_demande_habilitation').on('change', function (e) {
                    if(e.target.value=='true'){
                        $("#dernier_catalogue_demande_habilitation_div").show();
                    }
                    if(e.target.value=='false'){
                        $("#dernier_catalogue_demande_habilitation_div").hide();
                    }
                });

                $('#information_seul_activite_demande_habilitation').on('change', function (e) {
                    if(e.target.value=='false'){
                        $("#autre_activite_demande_habilitation_div").show();
                    }
                    if(e.target.value=='true'){
                        $("#autre_activite_demande_habilitation_div").hide();
                    }
                });

                //Select2 banque
                $("#id_banque").select2().val({{old('id_banque')}});

                var experience_formateur = new Quill('#experience_formateur', {
                    theme: 'snow'
                });

                $("#experience_formateur_val").hide();

                var formformateur = document.getElementById("formformateur");


                formformateur.onsubmit = function(){
                    $("#experience_formateur_val").val(experience_formateur.root.innerHTML);
                 }


                var materiel_didactique_demande_habilitation = new Quill('#materiel_didactique_demande_habilitation', {
                    theme: 'snow'
                });

                $("#materiel_didactique_demande_habilitation_val").hide();

                var reference_ci_demande_habilitation = new Quill('#reference_ci_demande_habilitation', {
                    theme: 'snow'
                });

                $("#reference_ci_demande_habilitation_val").hide();

                var autre_activite_demande_habilitation = new Quill('#autre_activite_demande_habilitation', {
                    theme: 'snow'
                });

                $("#autre_activite_demande_habilitation_val").hide();

                var formdivers = document.getElementById("Diversformateur");

                formdivers.onsubmit = function(){
                    $("#materiel_didactique_demande_habilitation_val").val(materiel_didactique_demande_habilitation.root.innerHTML);
                    $("#reference_ci_demande_habilitation_val").val(reference_ci_demande_habilitation.root.innerHTML);
                    $("#autre_activite_demande_habilitation_val").val(autre_activite_demande_habilitation.root.innerHTML);
                 }


                var quel_financement_intervention_hors_ci = new Quill('#quel_financement_intervention_hors_ci', {
                    theme: 'snow'
                });

                $("#quel_financement_intervention_hors_ci_val").hide();

                var formInterventionHorsCi = document.getElementById("formInterventionHorsCi");


                formInterventionHorsCi.onsubmit = function(){
                    $("#quel_financement_intervention_hors_ci_val").val(quel_financement_intervention_hors_ci.root.innerHTML);
                 }

                 var commantaire_cs = new Quill('#commantaire_cs', {
                    theme: 'snow'
                });

                $("#commantaire_cs_val").hide();

                var formAttribution = document.getElementById("formAttribution");


                formAttribution.onsubmit = function(){
                    $("#commantaire_cs_val").val(commantaire_cs.root.innerHTML);
                 }

                 var idactivesmoussion = $('#colorCheck1').prop('checked', false);


                function myFunctionMAJ() {
                    // Get the checkbox
                    var checkBox = document.getElementById("colorCheck1");

                    // If the checkbox is checked, display the output text
                    if (checkBox.checked == true){
                        $("#Enregistrer_soumettre_demande_habilitation").prop( "disabled", false );
                    } else {
                        $("#Enregistrer_soumettre_demande_habilitation").prop( "disabled", true );
                    }
                }


            </script>


        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
