<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;


?>

@if(auth()->user()->can('traitementdemandehabilitation-edit'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Habilitation')
    @php($titre='Liste des demandes habilitation')
    @php($soustitre='Demande d\'habilitation')
    @php($lien='traitementdemandehabilitation')

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
                                class="nav-link"
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
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-moyenpermanente"
                                aria-controls="navs-top-moyenpermanente"
                                aria-selected="false">
                                Moyen permanente
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-intervention"
                                aria-controls="navs-top-intervention"
                                aria-selected="false">
                                Intervention
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-organisationformation"
                                aria-controls="navs-top-organisationformation"
                                aria-selected="false">
                                Organisation formation
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
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
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-formateur"
                                aria-controls="navs-top-formateur"
                                aria-selected="false">
                                Formateur
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-divers"
                                aria-controls="navs-top-divers"
                                aria-selected="false">
                                Divers
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-Soumettre"
                                aria-controls="navs-top-Soumettre"
                                aria-selected="false">
                                Intervention hors du pays
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-affectation"
                                aria-controls="navs-top-affectation"
                                aria-selected="false">
                                Affectation
                                </button>
                            </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="navs-top-informationentreprise" role="tabpanel">

                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}">
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
                                                    <input type="text" name="nom_responsable_demande_habilitation" id="nom_responsable_demande_habilitation"
                                                        class="form-control form-control-sm"  value="{{ $demandehabilitation->nom_responsable_demande_habilitation }}">
                                                </div>
                                                @error('nom_responsable_demande_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Fonction du responsable  <strong style="color:red;">*</strong> </label>
                                                    <input type="text" name="fonction_demande_habilitation" id="fonction_demande_habilitation"
                                                        class="form-control form-control-sm"  value="{{ $demandehabilitation->fonction_demande_habilitation }}">
                                                </div>
                                                @error('fonction_demande_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Email professionnel du responsable  <strong style="color:red;">*</strong> </label>
                                                    <input type="text" name="email_responsable_habilitation" id="email_responsable_habilitation"
                                                        class="form-control form-control-sm"  value="{{ $demandehabilitation->email_responsable_habilitation }}">
                                                </div>
                                                @error('email_responsable_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Contact du responsable  <strong style="color:red;">*</strong> </label>
                                                    <input type="text" name="contact_responsable_habilitation" id="contact_responsable_habilitation"
                                                        class="form-control form-control-sm"  value="{{ $demandehabilitation->contact_responsable_habilitation }}">
                                                </div>
                                                @error('contact_responsable_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Maison mere ou tutelle <strong style="color:red;">(s'il y a lieu)</strong> </label>
                                                    <input type="text" name="maison_mere_demande_habilitation" id="maison_mere_demande_habilitation"
                                                        class="form-control form-control-sm" value="{{ $demandehabilitation->maison_mere_demande_habilitation }}"/>
                                                </div>
                                                @error('maison_mere_demande_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Agence domiciliation <strong style="color:red;">*</strong></label>
                                                <select class="select2 form-select-sm input-group @error('id_banque')
                                                    error
                                                    @enderror" data-allow-clear="true" name="id_banque">
                                                    <?= $banque; ?>
                                                </select>
                                                @error('id_banque')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                        </div>
                                    </form>

                                </div>
                                <div class="tab-pane fade" id="navs-top-moyenpermanente" role="tabpanel">

                                    <table class="table table-bordered table-striped table-hover table-sm"
                                        id=""
                                        style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Moyen permanente </th>
                                            <th>Nombre</th>
                                            <th>Capacite d'acceuil</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                            @foreach ($moyenpermanentes as $key => $moyenpermanente)
                                            <?php $i += 1;?>
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $moyenpermanente->typeMoyenPermanent->libelle_type_moyen_permanent }}</td>
                                                            <td>{{ $moyenpermanente->nombre_moyen_permanente }}</td>
                                                            <td>{{ $moyenpermanente->capitale_moyen_permanente }}</td>
                                                            <td>
                                                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                            <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($moyenpermanente->id_moyen_permanente)) }}"
                                                            class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                            title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                            <?php } ?>
                                                        </td>
                                                        </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="navs-top-intervention" role="tabpanel">

                                        <table class="table table-bordered table-striped table-hover table-sm"
                                            id=""
                                            style="margin-top: 13px !important">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Intervention </th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; ?>
                                                @foreach ($interventions as $key => $intervention)
                                                <?php $i += 1;?>
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $intervention->typeIntervention->libelle_type_intervention }}</td>
                                                                <td>
                                                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                                    <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($intervention->id_demande_intervention)) }}"
                                                                    class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                </div>
                                <div class="tab-pane fade" id="navs-top-organisationformation" role="tabpanel">

                                        <table class="table table-bordered table-striped table-hover table-sm"
                                            id=""
                                            style="margin-top: 13px !important">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Organisation </th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; ?>
                                                @foreach ($organisations as $key => $organisation)
                                                <?php $i += 1;?>
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $organisation->typeOrganisationFormation->libelle_type_organisation_formation }}</td>
                                                                <td>
                                                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                                    <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($organisation->id_organisation_formation)) }}"
                                                                    class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                </div>
                                <div class="tab-pane fade" id="navs-top-domaineformation" role="tabpanel">
                                        <table class="table table-bordered table-striped table-hover table-sm"
                                            id=""
                                            style="margin-top: 13px !important">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Type domaine de formation </th>
                                                <th>Domaine de formation </th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; ?>
                                                @foreach ($domaineDemandeHabilitations as $key => $domaineDemandeHabilitation)
                                                <?php $i += 1;?>
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}</td>
                                                                <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}</td>
                                                                <td>
                                                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                                    <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($domaineDemandeHabilitation->id_domaine_demande_habilitation)) }}"
                                                                    class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                </div>
                                <div class="tab-pane fade" id="navs-top-formateur" role="tabpanel">

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
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; ?>
                                                @foreach ($formateurs as $key => $formateur)
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
                                                                <td>
                                                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                                    <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($formateur->id_formateur_domaine_demande_habilitation)) }}"
                                                                    class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                </div>
                                <div class="tab-pane fade" id="navs-top-divers" role="tabpanel">
                                           <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label>Editez vous un catalogue de stage ?   <strong style="color:red;">*</strong> </label>
                                                            <select class="select2 form-select-sm input-group @error('information_catalogue_demande_habilitation')
                                                                error
                                                                @enderror" data-allow-clear="true" id="information_catalogue_demande_habilitation" name="information_catalogue_demande_habilitation">
                                                                <option value=""></option>
                                                                <option value="false" @if($demandehabilitation->information_catalogue_demande_habilitation == false ) selected @endif>NON</option>
                                                                <option value="true" @if($demandehabilitation->information_catalogue_demande_habilitation == true ) selected @endif>OUI</option>
                                                            </select>
                                                            @error('information_catalogue_demande_habilitation')
                                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label>La formation est-elle la seule activite de l'organisme ?   <strong style="color:red;">*</strong> </label>
                                                            <select class="select2 form-select-sm input-group @error('information_seul_activite_demande_habilitation')
                                                                error
                                                                @enderror" data-allow-clear="true"  id="information_seul_activite_demande_habilitation" name="information_seul_activite_demande_habilitation">
                                                                <option value=""></option>
                                                                <option value="false" @if($demandehabilitation->information_seul_activite_demande_habilitation == false ) selected @endif>NON</option>
                                                                <option value="true" @if($demandehabilitation->information_seul_activite_demande_habilitation == true ) selected @endif>OUI</option>
                                                            </select>
                                                            @error('information_seul_activite_demande_habilitation')
                                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6" id="dernier_catalogue_demande_habilitation_div">
                                                        <label class="form-label">Charge le catalogue </label>
                                                        <input type="file" name="dernier_catalogue_demande_habilitation" id="dernier_catalogue_demande_habilitation"
                                                               class="form-control form-control-sm  @error('dernier_catalogue_demande_habilitation')
                                                               error
                                                                @enderror" placeholder=""

                                                               value="{{ old('dernier_catalogue_demande_habilitation') }}"/>
                                                        @error('dernier_catalogue_demande_habilitation')
                                                            <div class=""><label class="error">{{ $message }}</label></div>
                                                        @enderror
                                                        <br>
                                                        @if (isset($demandehabilitation->dernier_catalogue_demande_habilitation))
                                                            <span class="badge bg-secondary">
                                                                <a target="_blank"
                                                                    onclick="NewWindow('{{ asset("/pieces/catalogue/". $demandehabilitation->dernier_catalogue_demande_habilitation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                    Voir la pièce
                                                                </a>
                                                            </span>
                                                        @endif
                                                        <div id="defaultFormControlHelp" class="form-text ">
                                                            <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                maxi : 5Mo</em>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6" id="autre_activite_demande_habilitation_div">
                                                        <div class="mb-1">
                                                            <label>Autre activité  </label>
                                                                    <input class="form-control @error('autre_activite_demande_habilitation') error @enderror" type="text" id="autre_activite_demande_habilitation_val" name="materiel_didactique_demande_habilitation"/>
                                                                    <div id="autre_activite_demande_habilitation" class="rounded-1"><?php echo @$demandehabilitation->autre_activite_demande_habilitation; ?></div>
                                                        </div>
                                                        @error('autre_activite_demande_habilitation')
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>

                                                </div>
                                             </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="mb-1">
                                                        <label>Materiel didactique  </label>
                                                                <input class="form-control @error('materiel_didactique_demande_habilitation') error @enderror" type="text" id="materiel_didactique_demande_habilitation_val" name="materiel_didactique_demande_habilitation"/>
                                                                <div id="materiel_didactique_demande_habilitation" class="rounded-1"><?php echo @$demandehabilitation->materiel_didactique_demande_habilitation; ?></div>
                                                    </div>
                                                    @error('materiel_didactique_demande_habilitation')
                                                    <div class=""><label class="error">{{ $message }}</label></div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="mb-1">
                                                        <label>Reference en cote d'ivoire (au cours des deux derniers années)  </label>
                                                                <input class="form-control @error('reference_ci_demande_habilitation') error @enderror" type="text" id="reference_ci_demande_habilitation_val" name="reference_ci_demande_habilitation"/>
                                                                <div id="reference_ci_demande_habilitation" class="rounded-1"><?php echo @$demandehabilitation->reference_ci_demande_habilitation; ?></div>
                                                    </div>
                                                    @error('reference_ci_demande_habilitation')
                                                    <div class=""><label class="error">{{ $message }}</label></div>
                                                    @enderror
                                                </div>



                                               <div class="col-12" align="right">
                                                   <hr>

                                               </div>
                                           </div>

                                </div>
                                <div class="tab-pane fade" id="navs-top-Soumettre" role="tabpanel">

                                       <table class="table table-bordered table-striped table-hover table-sm"
                                           id=""
                                           style="margin-top: 13px !important">
                                           <thead>
                                           <tr>
                                               <th>No</th>
                                               <th>Objet </th>
                                               <th>Pays </th>
                                               <th>Année  </th>
                                               <th>Sur quel financement </th>
                                               <th>Action</th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           <?php $i = 0; ?>
                                               @foreach ($interventionsHorsCis as $key => $interventionsHorsCi)
                                               <?php $i += 1;?>
                                                           <tr>
                                                               <td>{{ $i }}</td>
                                                               <td>{{ $interventionsHorsCi->objet_intervention_hors_ci }}</td>
                                                               <td>{{ $interventionsHorsCi->pay->libelle_pays }}</td>
                                                               <td>{{ $interventionsHorsCi->annee_intervention_hors_ci }}</td>
                                                               <td><?php echo $interventionsHorsCi->quel_financement_intervention_hors_ci; ?></td>
                                                               <td>
                                                                   <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                                   <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($interventionsHorsCi->id_intervention_hors_ci)) }}"
                                                                   class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                                   title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                                   <?php } ?>
                                                               </td>
                                                           </tr>
                                               @endforeach

                                           </tbody>
                                       </table>

                                </div>

                                <div class="tab-pane fade show active" id="navs-top-affectation" role="tabpanel">
                                    <?php if ($demandehabilitation->flag_soumis_charge_habilitation != true){ ?>
                                    <form method="POST" enctype="multipart/form-data" id="formAttribution" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation)) }}">
                                        @csrf
                                       @method('put')
                                       <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <div class="col-md-6 col-12">
                                                        <label class="form-label" for="billings-country">Charge d'habilitation <strong style="color:red;">*</strong></label>
                                                        <select class="select2 form-select-sm input-group @error('id_charge_habilitation')
                                                            error
                                                            @enderror" data-allow-clear="true" name="id_charge_habilitation">
                                                            <?= $chargerHabilitationsList; ?>
                                                        </select>
                                                        @error('id_charge_habilitation')
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label>Commentaire  <strong style="color:red;">*</strong></label>
                                                            <textarea rows="3" class="form-control @error('commantaire_cs') error @enderror" name="commantaire_cs">{{ $demandehabilitation->commantaire_cs }}</textarea>
                                                        </div>
                                                        @error('commantaire_cs')
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>


                                           <div class="col-12" align="right">
                                               <hr>



                                                   <button type="submit" name="action" value="FaireAttribution"
                                                           class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                           Attribution
                                                   </button>


                                               <hr>
                                           </div>
                                       </div>
                                       <br/>
                                   </form>
                                   <?php } ?>
                                    <section class="app-user-list">
                                        <div class="row">
                                            @foreach ($NombreDemandeHabilitation as $nbre)
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <h3 class="fw-bolder mb-75">{{ $nbre->count }}</h3>
                                                                <span>{{ $nbre->name }} {{ $nbre->prenom_users }}</span>
                                                            </div>
                                                            <div class="avatar bg-light-primary p-50">
                                                                <span class="avatar-content">
                                                                    <i data-feather="user" class="font-medium-4"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </section>
                                    <div class="col-12" align="right">
                                        <hr>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


        <!-- END: Content-->

        @endsection

        @section('js_perso')

            <script>
                                        $("#dernier_catalogue_demande_habilitation_div").hide();

                                        $("#autre_activite_demande_habilitation_div").hide();

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
