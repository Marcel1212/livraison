<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;

?>

@if (auth()->user()->can('traitementdemandehabilitation-editpu'))

    @extends('layouts.backLayout.designadmin')

    @section('content')
        @php($Module = 'Habilitation')
        @php($titre = 'Liste des demandes habilitation')
        @php($soustitre = 'Traitement demande d\'habilitation')
        @php($lien = 'traitementdemandehabilitation')

        <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / {{ $titre }}
                / </span> {{ $soustitre }}
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

            <style>
                .header,
                .footer {
                    text-align: right;
                }

                .main {
                    text-align: left;
                }

                .subject {
                    text-align: center;
                    font-weight: bold;
                }

                .signature {
                    text-align: right;
                    margin-top: 50px;
                }

                ul {
                    list-style-type: none;
                    padding-left: 0;
                }
            </style>


            <div class="col-xl-12">
                <h6 class="text-muted"></h6>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 1) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-informationentreprise"
                                aria-controls="navs-top-informationentreprise" aria-selected="true">
                                Informations sur l'entreprise
                            </button>
                        </li>

                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 3) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-intervention" aria-controls="navs-top-intervention"
                                aria-selected="false">
                                Domaines d'intervention
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 7) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-divers" aria-controls="navs-top-divers" aria-selected="false">
                                Divers
                            </button>
                        </li>

                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 8) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-Soumettre" aria-controls="navs-top-Soumettre"
                                aria-selected="false">
                                Pieces jointes
                            </button>
                        </li>

                        <?php if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_reception_demande_habilitation == true ){ ?>
                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 9) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-DossierEnreg" aria-controls="navs-top-DossierEnreg"
                                aria-selected="false">
                                Dossier d'enregistrement
                            </button>
                        </li>
                        <?php } ?>

                        <?php if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_reception_demande_habilitation == true && $role !='CHARGEHABIL' ){ ?>
                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 10) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-traitement" aria-controls="navs-top-traitement"
                                aria-selected="false">
                                Traitement
                            </button>
                        </li>
                        <?php } ?>


                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if ($idetape == 1) {
                            echo 'show active';
                        } ?>" id="navs-top-informationentreprise" role="tabpanel">

                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(1)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>N° de compte contribuable (NCC) </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="ncc_entreprises" id="ncc_entreprises"
                                                value="{{ @$infoentreprise->ncc_entreprises }}" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Secteur activité </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="libelle_secteur_activite" id="libelle_secteur_activite"
                                                value="{{ @$infoentreprise->secteurActivite->libelle_secteur_activite }}"
                                                disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Localisation géographique </label>
                                            <input type="text" name="localisation_geographique_entreprise"
                                                id="localisation_geographique_entreprise"
                                                class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->localisation_geographique_entreprise }}"
                                                disabled="disabled">
                                        </div>
                                    </div>




                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Denomination </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="raison_social_entreprises" id="raison_social_entreprises"
                                                value="{{ @$infoentreprise->raison_social_entreprises }}"
                                                disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Sigle </label>
                                            <input type="text" class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->sigl_entreprises }}" disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Adresse Postale </label>
                                            <input type="text" name="adresse_postal_entreprises"
                                                id="adresse_postal_entreprises" class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->adresse_postal_entreprises }}"
                                                disabled="disabled">
                                        </div>
                                    </div>

                                    {{--
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Adresse email </label>
                                            <input type="text" name="email_entreprises" id="email_entreprises"
                                                class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->email_entreprises }}" disabled="disabled">
                                        </div>
                                    </div> --}}




                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Repère d'accès </label>
                                            <input type="text" name="repere_acces_entreprises"
                                                id="repere_acces_entreprises" class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->repere_acces_entreprises }}"
                                                disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Adresse postal </label>
                                            <input type="text" name="adresse_postal_entreprises"
                                                id="adresse_postal_entreprises" class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->adresse_postal_entreprises }}"
                                                disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="billings-country">Indicatif</label>
                                                    <select class="select2 form-select-sm input-group"
                                                        data-allow-clear="true" disabled="disabled">
                                                        <?= $pay ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Téléphone </label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ @$infoentreprise->tel_entreprises }}"
                                                        name="tel_entreprises" disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="billings-country">Indicatif</label>
                                                    <select class="select2 form-select-sm input-group"
                                                        data-allow-clear="true" disabled="disabled">
                                                        <?= $pay ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Cellulaire Professionnelle </label>
                                                    <input type="number" name="cellulaire_professionnel_entreprises"
                                                        id="cellulaire_professionnel_entreprises"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$infoentreprise->cellulaire_professionnel_entreprises }}"
                                                        disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="billings-country">Indicatif</label>
                                                    <select class="select2 form-select-sm input-group"
                                                        data-allow-clear="true" disabled="disabled">
                                                        <?= $pay ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Fax </label>
                                                    <input type="number" name="fax_entreprises" id="fax_entreprises"
                                                        class="form-control form-control-sm"
                                                        value="{{ @$infoentreprise->fax_entreprises }}"
                                                        disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="mb-1">
                                            <label>Latitude </label> <br>
                                            <input type="text" name="latitude_entreprises" id="latitude_entreprises"
                                                class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->latitude_entreprises }}" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="mb-1">
                                            <label>Longitude </label> <br>
                                            <input type="text" name="longitude_entreprises" id="longitude_entreprises"
                                                class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->longitude_entreprises }}"
                                                disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Nom et prénoms du responsable <strong style="color:red;">*</strong>
                                            </label>
                                            <input type="text" name="nom_responsable_demande_habilitation"
                                                id="nom_responsable_demande_habilitation"
                                                class="form-control form-control-sm" required="required"
                                                disabled="disabled"
                                                value="{{ $demandehabilitation->nom_responsable_demande_habilitation }}">
                                        </div>
                                        @error('nom_responsable_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Fonction du responsable <strong style="color:red;">*</strong> </label>
                                            <input type="text" name="fonction_demande_habilitation"
                                                id="fonction_demande_habilitation" class="form-control form-control-sm"
                                                disabled="disabled" required="required"
                                                value="{{ $demandehabilitation->fonction_demande_habilitation }}">
                                        </div>
                                        @error('fonction_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>



                                    {{-- <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Email professionnel du responsable <strong style="color:red;">*</strong>
                                            </label>
                                            <input type="text" name="email_responsable_habilitation"
                                                id="email_responsable_habilitation" class="form-control form-control-sm"
                                                required="required" value="{{ old('email_responsable_habilitation') }}">
                                        </div>
                                        @error('email_responsable_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div> --}}

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Contact du responsable <strong style="color:red;">*</strong> </label>
                                            <input type="text" name="contact_responsable_habilitation"
                                                id="contact_responsable_habilitation" class="form-control form-control-sm"
                                                disabled="disabled" required="required"
                                                value="{{ $demandehabilitation->contact_responsable_habilitation }}">
                                        </div>
                                        @error('contact_responsable_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>


                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Email professionnel du responsable <strong style="color:red;">*</strong>
                                            </label>
                                            <input type="text" name="email_responsable_habilitation"
                                                id="email_responsable_habilitation" class="form-control form-control-sm"
                                                disabled="disabled"
                                                value="{{ $demandehabilitation->email_responsable_habilitation }}">
                                        </div>
                                        @error('email_responsable_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <label class="form-label" for="billings-country">Statut Juridique<strong
                                                style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select-sm input-group @error('id_statut_jur')
                                                error
                                                @enderror"
                                            data-allow-clear="true" name="id_statut_jur" required>
                                            <? // = $statjur ?>
                                        </select>
                                        @error('id_statut_jur')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div> --}}

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Maison mere ou tutelle <strong style="color:red;">(s'il y a
                                                    lieu)</strong> </label>
                                            <input type="text" name="maison_mere_demande_habilitation"
                                                id="maison_mere_demande_habilitation" class="form-control form-control-sm"
                                                disabled="disabled" disabled="disabled"
                                                value="{{ $demandehabilitation->maison_mere_demande_habilitation }}" />
                                        </div>
                                        @error('maison_mere_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>N° Registre de commerce ou enregistrement J.O <strong
                                                    style="color:red;">*</strong> </label>
                                            <input type="text" name="registre_commerce" id="registre_commerce"
                                                class="form-control form-control-sm"
                                                value="{{ $demandehabilitation->registre_commerce }}" />
                                        </div>
                                        @error('registre_commerce')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>N° Identification Impots <strong style="color:red;">*</strong>
                                            </label>
                                            <input type="text" name="num_id_impot" id="num_id_impot"
                                                class="form-control form-control-sm"
                                                value="{{ $demandehabilitation->num_id_impot }}" />
                                        </div>
                                        @error('num_id_impot')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>N° CNPS Employeur <strong style="color:red;">*</strong>
                                            </label>
                                            <input type="text" name="num_cnps_emp" id="num_cnps_emp"
                                                class="form-control form-control-sm"
                                                value="{{ $demandehabilitation->num_cnps_emp }}" />
                                        </div>
                                        @error('num_cnps_emp')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div> --}}

                                    <div class="col-md-4">
                                        <label class="form-label" for="billings-country">Domiciliation bancaire <strong
                                                style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select-sm input-group @error('id_banque')
                                                error
                                                @enderror"
                                            data-allow-clear="true" disabled="disabled" name="id_banque" required>
                                            <?= $banque ?>
                                        </select>
                                        @error('id_banque')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>



                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <div class="tab-pane fade <?php if ($idetape == 3) {
                            echo 'show active';
                        } ?>" id="navs-top-intervention" role="tabpanel">
                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(3)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">

                                    <div class="col-md-6">
                                        <label class="form-label" for="billings-country">Type de domaine <strong
                                                style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select-sm input-group @error('id_type_domaine_demande_habilitation')
                                                        error
                                                        @enderror"
                                            data-allow-clear="true" name="id_type_domaine_demande_habilitation">
                                            <?= $typeDomaineDemandeHabilitationList ?>
                                        </select>
                                        @error('id_type_domaine_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label" for="billings-country">Domaine de formation <strong
                                                style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select-sm input-group @error('id_domaine_formation')
                                                        error
                                                        @enderror"
                                            data-allow-clear="true" name="id_domaine_formation">
                                            <?= $domainesList ?>
                                        </select>
                                        @error('id_domaine_formation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>


                                    <div class="col-12" align="right">
                                        <hr>

                                        <a href="{{ route($lien . '.editpu', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                            class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                        <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                        <button type="submit" name="action" value="AjouterDomaineFormationPU"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Ajouter
                                        </button>
                                        <?php } ?>


                                        <a href="{{ route($lien . '.editpu', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(7)]) }}"
                                            class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                            <?php } ?>
                            <hr>
                            <table class="table table-bordered table-striped table-hover table-sm" id=""
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Finalité </th>
                                        <th>Public </th>
                                        <th>Domaine de formation </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>

                                    @foreach ($domaineDemandeHabilitations as $key => $domaineDemandeHabilitation)
                                        <?php $i += 1; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}
                                            </td>
                                            <td>{{ @$domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }}
                                            </td>
                                            <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade <?php if ($idetape == 4) {
                            echo 'show active';
                        } ?>" id="navs-top-organisationformation"
                            role="tabpanel">
                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(4)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">

                                    <div class="col-md-12">
                                        <label class="form-label" for="billings-country">Organisation formation <strong
                                                style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select-sm input-group @error('id_type_organisation_formation')
                                                        error
                                                        @enderror"
                                            data-allow-clear="true" name="id_type_organisation_formation[]" multiple>
                                            <?= $organisationFormationsList ?>
                                        </select>
                                        @error('id_type_organisation_formation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>


                                    <div class="col-12" align="right">
                                        <hr>

                                        <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                            class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                        <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                        <button type="submit" name="action" value="AjouterOrganisationFormation"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Ajouter
                                        </button>
                                        <?php } ?>


                                        <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(5)]) }}"
                                            class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                            <?php } ?>
                            <hr>
                            <table class="table table-bordered table-striped table-hover table-sm" id=""
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
                                        <?php $i += 1; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $organisation->typeOrganisationFormation->libelle_type_organisation_formation }}
                                            </td>
                                            <td>
                                                <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                <a href="{{ route($lien . '.delete', \App\Helpers\Crypt::UrlCrypt($organisation->id_organisation_formation)) }}"
                                                    class=""
                                                    onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade <?php if ($idetape == 5) {
                            echo 'show active';
                        } ?>" id="navs-top-domaineformation" role="tabpanel">
                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(5)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">

                                    <div class="col-md-6">
                                        <label class="form-label" for="billings-country">Type de domaine <strong
                                                style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select-sm input-group @error('id_type_domaine_demande_habilitation')
                                                        error
                                                        @enderror"
                                            data-allow-clear="true" name="id_type_domaine_demande_habilitation">
                                            <?= $typeDomaineDemandeHabilitationList ?>
                                        </select>
                                        @error('id_type_domaine_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="billings-country">Domaine de formation <strong
                                                style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select-sm input-group @error('id_domaine_formation')
                                                        error
                                                        @enderror"
                                            data-allow-clear="true" name="id_domaine_formation">
                                            <?= $domainesList ?>
                                        </select>
                                        @error('id_domaine_formation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>


                                    <div class="col-12" align="right">
                                        <hr>

                                        <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                            class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                        <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                        <button type="submit" name="action" value="AjouterDomaineFormation"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Ajouter
                                        </button>
                                        <?php } ?>


                                        <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(6)]) }}"
                                            class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                            <?php } ?>
                            <hr>
                            <table class="table table-bordered table-striped table-hover table-sm" id=""
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
                                        <?php $i += 1; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}
                                            </td>
                                            <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}
                                            </td>
                                            <td>
                                                <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                <a href="{{ route($lien . '.delete', \App\Helpers\Crypt::UrlCrypt($domaineDemandeHabilitation->id_domaine_demande_habilitation)) }}"
                                                    class=""
                                                    onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade <?php if ($idetape == 6 and count($organisations) > 0) {
                            echo 'show active';
                        } ?>" id="navs-top-formateur" role="tabpanel">
                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                            <form method="POST" enctype="multipart/form-data" id="formformateur" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(6)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Nom du formateur <strong style="color:red;">*</strong> </label>
                                                    <input type="text" name="nom_formateur" id="nom_formateur"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('nom_formateur') }}">
                                                </div>
                                                @error('nom_formateur')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Prénom du formateur <strong style="color:red;">*</strong>
                                                    </label>
                                                    <input type="text" name="prenom_formateur" id="prenom_formateur"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('prenom_formateur') }}">
                                                </div>
                                                @error('prenom_formateur')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <label class="form-label" for="billings-country">Domaine de formation
                                                    <strong style="color:red;">*</strong></label>
                                                <select
                                                    class="select2 form-select-sm input-group @error('id_domaine_demande_habilitation')
                                                            error
                                                            @enderror"
                                                    data-allow-clear="true" name="id_domaine_demande_habilitation">
                                                    <?= $domainedemandeList ?>
                                                </select>
                                                @error('id_domaine_demande_habilitation')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Date de début d'experience <strong style="color:red;">*</strong>
                                                    </label>
                                                    <input type="date" name="date_debut_formateur"
                                                        id="date_debut_formateur" class="form-control form-control-sm"
                                                        value="{{ old('date_debut_formateur') }}">
                                                </div>
                                                @error('date_debut_formateur')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Date de fin d'experience </label>
                                                    <input type="date" name="date_fin_formateur"
                                                        id="date_fin_formateur" class="form-control form-control-sm"
                                                        value="{{ old('date_fin_formateur') }}">
                                                </div>
                                                @error('date_fin_formateur')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Cv du formation <strong
                                                        style="color:red;">*</strong></label>
                                                <input type="file" name="cv_formateur"
                                                    class="form-control form-control-sm  @error('cv_formateur')
                                                               error
                                                                @enderror"
                                                    placeholder="" value="{{ old('cv_formateur') }}" />
                                                @error('cv_formateur')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Lettre d'engagement du formation <strong
                                                        style="color:red;">*</strong></label>
                                                <input type="file" name="le_formateur"
                                                    class="form-control form-control-sm  @error('le_formateur')
                                                               error
                                                                @enderror"
                                                    placeholder="" value="{{ old('le_formateur') }}" />
                                                @error('le_formateur')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label>Experience </label>
                                            <input class="form-control @error('experience_formateur') error @enderror"
                                                type="text" id="experience_formateur_val"
                                                name="experience_formateur" />
                                            <div id="experience_formateur" class="rounded-1">
                                                {{ old('experience_formateur') }}</div>
                                        </div>
                                        @error('experience_formateur')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>



                                    <div class="col-12" align="right">
                                        <hr>

                                        <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(5)]) }}"
                                            class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                        <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                        <button type="submit" name="action" value="AjouterFormateur"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Ajouter
                                        </button>
                                        <?php } ?>


                                        <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(7)]) }}"
                                            class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                            <?php } ?>
                            <hr>
                            <table class="table table-bordered table-striped table-hover table-sm" id=""
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nom et prénom </th>
                                        <th>Année d'experience </th>
                                        <th>Cv </th>
                                        <th>Lettre d'engagement </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($formateurs as $key => $formateur)
                                        <?php $i += 1; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $formateur->nom_formateur }} {{ $formateur->prenom_formateur }}</td>
                                            <td>
                                                <?php
                                                if (isset($formateur->date_fin_formateur)) {
                                                    $datedebut = \Carbon\Carbon::parse($formateur->date_debut_formateur);
                                                    $datefin = \Carbon\Carbon::parse($formateur->date_fin_formateur);
                                                
                                                    $anneexperience = $datedebut->diffInYears($datefin);
                                                } else {
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
                                                        onclick="NewWindow('{{ asset('/pieces/cv_formateur/' . $formateur->cv_formateur) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                        Voir la pièce
                                                    </a>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <a target="_blank"
                                                        onclick="NewWindow('{{ asset('/pieces/le_formateur/' . $formateur->le_formateur) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                        Voir la pièce
                                                    </a>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                <a href="{{ route($lien . '.delete', \App\Helpers\Crypt::UrlCrypt($formateur->id_formateur_domaine_demande_habilitation)) }}"
                                                    class=""
                                                    onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade <?php if ($idetape == 7) {
                            echo 'show active';
                        } ?>" id="navs-top-divers" role="tabpanel">
                            <?php //if ($demandehabilitation->flag_soumis_demande_habilitation != true){
                            ?>
                            <form method="POST" enctype="multipart/form-data" id="Diversformateur" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(7)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label> <strong>Editez-vous un catalogue de stage ou d'action de
                                                            formation?</strong>
                                                        <strong style="color:red;">*</strong> </label>
                                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true) {?>
                                                    <select
                                                        class="select2 form-select-sm input-group @error('information_catalogue_demande_habilitation')
                                                                error
                                                                @enderror"
                                                        data-allow-clear="true"
                                                        id="information_catalogue_demande_habilitation"
                                                        name="information_catalogue_demande_habilitation">
                                                        <option value=""></option>
                                                        <option value="false"
                                                            @if ($demandehabilitation->information_catalogue_demande_habilitation == false) selected @endif>NON</option>
                                                        <option value="true"
                                                            @if ($demandehabilitation->information_catalogue_demande_habilitation == true) selected @endif>OUI</option>
                                                    </select>
                                                    <?php } else {?>

                                                    @if ($demandehabilitation->information_catalogue_demande_habilitation == false)
                                                        <input type="text"
                                                            name="dernier_catalogue_demande_habilitation"
                                                            id="dernier_catalogue_demande_habilitation"
                                                            class="form-control form-control-sm" value="NON"
                                                            disabled='disabled' />
                                                    @else
                                                        <input type="text"
                                                            name="dernier_catalogue_demande_habilitation"
                                                            id="dernier_catalogue_demande_habilitation"
                                                            class="form-control form-control-sm" value="OUI"
                                                            disabled='disabled' />
                                                    @endif

                                                    <?php }?>
                                                    @error('information_catalogue_demande_habilitation')
                                                        <div class=""><label class="error">{{ $message }}</label>
                                                        </div>
                                                        <div class=""><label class="error">{{ $message }}</label>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label><strong>La formation est-elle la seule activite de l'organisme
                                                            ?</strong> <strong style="color:red;">*</strong> </label>
                                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true) {?>
                                                    <select
                                                        class="select2 form-select-sm input-group @error('information_seul_activite_demande_habilitation')
                                                                error
                                                                @enderror"
                                                        data-allow-clear="true"
                                                        id="information_seul_activite_demande_habilitation"
                                                        name="information_seul_activite_demande_habilitation">
                                                        <option value=""></option>
                                                        <option value="false"
                                                            @if ($demandehabilitation->information_seul_activite_demande_habilitation == false) selected @endif>NON</option>
                                                        <option value="true"
                                                            @if ($demandehabilitation->information_seul_activite_demande_habilitation == true) selected @endif>OUI</option>
                                                    </select>
                                                    <?php } else {?>

                                                    @if ($demandehabilitation->information_seul_activite_demande_habilitation == false)
                                                        <input type="text"
                                                            name="dernier_catalogue_demande_habilitation"
                                                            id="dernier_catalogue_demande_habilitation"
                                                            class="form-control form-control-sm" value="NON"
                                                            disabled='disabled' />
                                                    @else
                                                        <input type="text"
                                                            name="dernier_catalogue_demande_habilitation"
                                                            id="dernier_catalogue_demande_habilitation"
                                                            class="form-control form-control-sm" value="OUI"
                                                            disabled='disabled' />
                                                    @endif

                                                    <?php }?>
                                                    @error('information_seul_activite_demande_habilitation')
                                                        <div class=""><label class="error">{{ $message }}</label>
                                                        </div>
                                                        <div class=""><label class="error">{{ $message }}</label>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-6" id="dernier_catalogue_demande_habilitation_div">
                                                <label class="form-label">Joindre un exemplaire du dernier
                                                    catalogue</label>
                                                <input type="file" name="dernier_catalogue_demande_habilitation"
                                                    id="dernier_catalogue_demande_habilitation"
                                                    class="form-control form-control-sm  @error('dernier_catalogue_demande_habilitation')
                                                               error
                                                                @enderror"
                                                    placeholder=""
                                                    value="{{ old('dernier_catalogue_demande_habilitation') }}" />
                                                @error('dernier_catalogue_demande_habilitation')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                                <br>
                                                @if (isset($demandehabilitation->dernier_catalogue_demande_habilitation))
                                                    <span class="badge bg-secondary">
                                                        <a target="_blank"
                                                            onclick="NewWindow('{{ asset('/pieces/catalogue/' . $demandehabilitation->dernier_catalogue_demande_habilitation) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce
                                                        </a>
                                                    </span>
                                                @endif
                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-6" id="autre_activite_demande_habilitation_div">
                                                <div class="mb-1">
                                                    <label>Autre activité </label>
                                                    <input
                                                        class="form-control @error('autre_activite_demande_habilitation') error @enderror"
                                                        type="text" id="autre_activite_demande_habilitation_val"
                                                        name="materiel_didactique_demande_habilitation" />
                                                    <div id="autre_activite_demande_habilitation" class="rounded-1">
                                                        <?php //echo @$demandehabilitation->autre_activite_demande_habilitation;
                                                        ?></div>
                                                </div>
                                                @error('autre_activite_demande_habilitation')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                            </div> --}}

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label> <strong>Autre activites </strong></label>
                                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true) {?>
                                            <input
                                                class="form-control @error('materiel_didactique_demande_habilitation') error @enderror"
                                                type="text" id="materiel_didactique_demande_habilitation_val"
                                                name="materiel_didactique_demande_habilitation" />
                                            <?php }?>
                                            <div id="materiel_didactique_demande_habilitation" class="rounded-1">
                                                <?php echo @$demandehabilitation->materiel_didactique_demande_habilitation; ?></div>
                                        </div>
                                        @error('materiel_didactique_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label><strong>Reference en cote d'ivoire (au cours des deux derniers années)
                                                </strong></label>
                                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true) {?>
                                            <input
                                                class="form-control @error('reference_ci_demande_habilitation') error @enderror"
                                                type="text" id="reference_ci_demande_habilitation_val"
                                                name="reference_ci_demande_habilitation" />
                                            <?php }?>
                                            <div id="reference_ci_demande_habilitation" class="rounded-1">
                                                <?php echo @$demandehabilitation->reference_ci_demande_habilitation; ?></div>
                                        </div>
                                        @error('reference_ci_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <br>
                                    <br>
                                    <br>
                                    <br>

                                    <div class="mb-1">
                                        <label> <strong>INTERVENTION(S) HORS COTE D'IVOIRE LE CAS ECHEANT</strong> </label>
                                    </div>


                                    <form method="POST" enctype="multipart/form-data" id="formInterventionHorsCi"
                                        class="form"
                                        action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(8)]) }}">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true) {?>
                                                <div class="row">
                                                    <div class="col-md-2 col-12">
                                                        <div class="mb-1">
                                                            <label>Objet <strong style="color:red;">*</strong> </label>
                                                            <input type="text" name="objet_intervention_hors_ci"
                                                                id="objet_intervention_hors_ci"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('objet_intervention_hors_ci') }}">
                                                        </div>
                                                        @error('objet_intervention_hors_ci')
                                                            <div class=""><label
                                                                    class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2 col-12">
                                                        <label class="form-label" for="billings-country">Pays <strong
                                                                style="color:red;">*</strong></label>
                                                        <select
                                                            class="select2 form-select-sm input-group @error('id_pays')
                                                            error
                                                            @enderror"
                                                            data-allow-clear="true" name="id_pays">
                                                            <?= $payList ?>
                                                        </select>
                                                        @error('id_pays')
                                                            <div class=""><label
                                                                    class="error">{{ $message }}</label></div>
                                                            <div class=""><label
                                                                    class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2 col-12">
                                                        <div class="mb-1">
                                                            <label>Année <strong style="color:red;">*</strong> </label>
                                                            <input type="text" maxlength="4"
                                                                name="annee_intervention_hors_ci"
                                                                id="annee_intervention_hors_ci"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('annee_intervention_hors_ci') }}">
                                                        </div>
                                                        @error('annee_intervention_hors_ci')
                                                            <div class=""><label
                                                                    class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-1">
                                                            <label>Sur quel financement <strong
                                                                    style="color:red;">*</strong> </label>
                                                            <input type="text"
                                                                name="quel_financement_intervention_hors"
                                                                id="quel_financement_intervention_hors_val"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('quel_financement_intervention_hors') }}">
                                                        </div>
                                                        @error('quel_financement_intervention_hors')
                                                            <div class=""><label
                                                                    class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-3  col-12">
                                                        <div class="mb-1">
                                                            <br>

                                                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                            <button type="submit" name="action"
                                                                value="AjouterInterventionsHorsCisPU"
                                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                                Ajouter
                                                            </button>
                                                            <?php } ?>
                                                        </div>


                                                    </div>
                                                </div>
                                                <?php  }?>
                                            </div>


                                        </div>
                                    </form>
                                    <br>
                                    <br>
                                    <hr>
                                    <table class="table table-bordered table-striped table-hover table-sm" id=""
                                        style="margin-top: 13px !important">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Objet </th>
                                                <th>Pays </th>
                                                <th>Année </th>
                                                <th>Sur quel financement </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($interventionsHorsCis as $key => $interventionsHorsCi)
                                                <?php $i += 1; ?>
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $interventionsHorsCi->objet_intervention_hors_ci }}</td>
                                                    <td>{{ $interventionsHorsCi->pay->libelle_pays }}</td>
                                                    <td>{{ $interventionsHorsCi->annee_intervention_hors_ci }}</td>
                                                    <td><?php echo $interventionsHorsCi->quel_financement_intervention_hors_ci; ?></td>
                                                    <td>
                                                        <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                        <a href="{{ route($lien . '.delete', \App\Helpers\Crypt::UrlCrypt($interventionsHorsCi->id_intervention_hors_ci)) }}"
                                                            class=""
                                                            onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                            title="Suprimer"> <img src='/assets/img/trash-can-solid.png'>
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>




                                    <div class="col-12" align="right">
                                        <hr>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                            <?php //}
                            ?>
                        </div>
                        <div class="tab-pane fade <?php if ($idetape == 8) {
                            echo 'show active';
                        } ?>" id="navs-top-Soumettre" role="tabpanel">
                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                            <div class="col-md-12" align="right">
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#SoummissiondemandehabilitationApprouve1">
                                    Soumettre la demande d'habilitation
                                </button>
                            </div>

                            <br />
                            <br />
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <div class="alert-body" style="text-align: center">
                                    Veuillez joindre les fichiers afin de valider votre demande d'habilitation
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php } ?>

                            <div class="col-md-12" align="right">
                                <?php if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_reception_demande_habilitation == null && $role =='CHARGEHABIL'){ ?>
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#Recevabilite">
                                    Effectuer la recevabilité
                                </button>
                                <?php } ?>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-12" align="right">
                                    <?php //if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_reception_demande_habilitation == true && $role =='CHARGEHABIL'){
                                    ?>
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#LettreEngagement">
                                        Valider la lettre d'enregistrement
                                    </button>
                                    <?php //}
                                    ?>
                                </div>
                                <br>
                                <div class="col-md-12" align="right">
                                    <?php //if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_reception_demande_habilitation == true && $role =='CHARGEHABIL'){
                                    ?>
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#NoteTechnique">
                                        Valider la note technique
                                    </button>
                                    <?php //}
                                    ?>
                                </div>
                            </div> --}}
                            <form method="POST" enctype="multipart/form-data" id="formInterventionHorsCi"
                                class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(8)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <label class="form-label">Décret de création de la structure publique
                                                    <strong style="color:red;">*</strong></label>
                                                <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                <input type="file" name="decret_structure_public"
                                                    class="form-control form-control-sm  @error('decret_structure_public')
                                                       error
                                                        @enderror"
                                                    placeholder="" value="{{ old('decret_structure_public') }}" />

                                                @error('decret_structure_public')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>
                                                <?php } ?> <br>
                                                @if ($demandehabilitation->decret_structure_public != null)
                                                    <td>
                                                        <span class="badge bg-secondary">
                                                            <a target="_blank"
                                                                onclick="NewWindow('{{ asset('/pieces/decret_structure_public/' . $demandehabilitation->decret_structure_public) }}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                                                Voir la pièce
                                                            </a>

                                                        </span>
                                                    </td>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Décret de nomination du directeur actuel :
                                                    <strong style="color:red;">*</strong></label>
                                                <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                <input type="file" name="decret_nomination_directeur"
                                                    class="form-control form-control-sm  @error('decret_nomination_directeur')
                                                       error
                                                        @enderror"
                                                    placeholder="" value="{{ old('decret_nomination_directeur') }}" />
                                                @error('decret_nomination_directeur')
                                                    <div class=""><label class="error">{{ $message }}</label>
                                                    </div>
                                                @enderror
                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>
                                                <?php } ?> <br>
                                                @if ($demandehabilitation->decret_nomination_directeur != null)
                                                    <td>
                                                        <span class="badge bg-secondary">
                                                            <a target="_blank"
                                                                onclick="NewWindow('{{ asset('/pieces/decret_nomination_directeur/' . $demandehabilitation->decret_nomination_directeur) }}','',screen.width/2,screen.height,'yes','center',1);
                                                                                    ">
                                                                Voir la pièce
                                                            </a>

                                                        </span>
                                                    </td>
                                                @endif
                                            </div>




                                        </div>
                                    </div>

                                    <?php if  ( $role =='CHEFSERVICE'){ ?>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <label class="form-label" for="billings-country">Charge d'habilitation
                                                        <strong style="color:red;">*</strong></label>
                                                    <?php if ($demandehabilitation->flag_soumis_charge_habilitation != true){
                                                    ?>
                                                    <select class="select2 form-select-sm input-group"
                                                        @if ($demandehabilitation->flag_soumis_charge_habilitation == true) disabled @endif
                                                        class="select2 form-select-sm input-group"
                                                        @if ($demandehabilitation->flag_soumis_charge_habilitation == true) disabed @endif
                                                        data-allow-clear="true" name="id_charge_habilitation">

                                                        <?= $chargerHabilitationsList ?>
                                                    </select>
                                                    <?php }elseif ($demandehabilitation->flag_soumis_charge_habilitation == true){
                                                    ?>
                                                    <div class="mb-1">
                                                        <input type="text" name="id_charge_habilitation"
                                                            id="id_charge_habilitation" disabled
                                                            class="form-control form-control-sm"
                                                            value="{{ $chargerHabilitations->name }} {{ $chargerHabilitations->prenom_users }}">
                                                    </div>
                                                    <?php }
                                                    ?>


                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire <strong style="color:red;">*</strong></label>
                                                        <textarea @if ($demandehabilitation->flag_soumis_charge_habilitation == true) disabled @endif rows="3" class="form-control"
                                                            name="commentaire_cs">{{ @$demandehabilitation->commentaire_cs }}</textarea>
                                                    </div>



                                                </div>

                                            </div>
                                        </div>
                                        <?php if ($demandehabilitation->flag_soumis_charge_habilitation != true){
                                                    ?>
                                        <div class="col-md-4">
                                            <table class="table table-bordered table-striped table-hover table-sm"
                                                id="" style="margin-top: 13px !important">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Chargés habilitations </th>
                                                        <th>Dossiers en cours</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach ($NombreDemandeHabilitation as $key => $nbre)
                                                        <tr>
                                                            <td>{{ ++$i }}</td>
                                                            <td>{{ @$nbre->name }} {{ @$nbre->prenom_users }}</td>
                                                            <td>{{ @$nbre->nbre_dossier_en_cours }} </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        <?php } ?>


                                    </div>

                                    <?php }  ?>


                                    <div class="col-12" align="right">
                                        <hr>

                                        {{-- <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(7)]) }}"
                                            class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a> --}}

                                        <?php if ($demandehabilitation->flag_soumis_charge_habilitation != true){ ?>
                                        <button type="submit" name="action" value="FaireAttributionPU"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Imputer
                                        </button>
                                        <?php } ?>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>

                                    </div>
                                </div>

                            </form>
                            <?php //}
                            ?>
                            <hr>


                        </div>
                        <div class="tab-pane fade <?php if ($idetape == 9) {
                            echo 'show active';
                        } ?>" id="navs-top-DossierEnreg" role="tabpanel">
                            <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                            <div class="col-md-12" align="right">
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#SoummissiondemandehabilitationApprouve1">
                                    Soumettre la demande d'habilitation
                                </button>
                            </div>

                            <br />
                            <br />
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <div class="alert-body" style="text-align: center">
                                    Veuillez joindre les fichiers afin de valider votre demande d'habilitation
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php } ?>

                            <div class="col-md-12" align="right">
                                <?php if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_reception_demande_habilitation == null && $role =='CHARGEHABIL'){ ?>
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#Recevabilite">
                                    Effectuer la recevabilité
                                </button>
                                <?php } ?>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-12" align="right">
                                    <?php //if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_reception_demande_habilitation == true && $role =='CHARGEHABIL'){
                                    ?>
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#LettreEngagement">
                                        Valider la lettre d'enregistrement
                                    </button>
                                    <?php //}
                                    ?>
                                </div>
                                <br>
                                <div class="col-md-12" align="right">
                                    <?php //if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_reception_demande_habilitation == true && $role =='CHARGEHABIL'){
                                    ?>
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#NoteTechnique">
                                        Valider la note technique
                                    </button>
                                    <?php //}
                                    ?>
                                </div>
                            </div> --}}
                            <form method="POST" enctype="multipart/form-data" id="formInterventionHorsCi"
                                class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(9)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <label class="form-label">Lettre d'enregistrement
                                                </label>
                                                <div class="col-md-12">
                                                    <?php if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_lettre_enregistrement == null && $role =='CHARGEHABIL'){
                                                    ?>
                                                    <button type="button" class="btn btn-outline-success"
                                                        data-bs-toggle="modal" data-bs-target="#LettreEngagement">
                                                        Valider la lettre d'enregistrement
                                                    </button>
                                                    <?php }
                                                    ?>
                                                </div>
                                                @if ($demandehabilitation->flag_lettre_enregistrement != null)
                                                    <td>

                                                        {{-- <a target="_blank"
                                                                onclick="NewWindow('{{ asset('/pieces/lettre_enregistrement/' . $demandehabilitation->lettre_enregistrement) }}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                                                Voir la pièce
                                                            </a> --}}
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-toggle="modal" data-bs-target="#LettreEngagement">
                                                            Voir la lettre d'enregistrement
                                                        </button>


                                                    </td>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Note technique </label>
                                                <div class="col-md-12">
                                                    <?php if ($demandehabilitation->flag_soumis_charge_habilitation == true && $demandehabilitation->flag_note_technique == null && $role =='CHARGEHABIL'){
                                                    ?>
                                                    <button type="button" class="btn btn-outline-success"
                                                        data-bs-toggle="modal" data-bs-target="#NoteTechnique">
                                                        Valider la note technique
                                                    </button>
                                                    <?php }
                                                    ?>
                                                </div>
                                                @if ($demandehabilitation->flag_note_technique != null)
                                                    <td>

                                                        {{-- <a target="_blank"
                                                                onclick="NewWindow('{{ asset('/pieces/note_technique/' . $demandehabilitation->note_technique) }}','',screen.width/2,screen.height,'yes','center',1);
                                                                                    ">
                                                                Voir la pièce
                                                            </a> --}}
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-toggle="modal" data-bs-target="#NoteTechnique">
                                                            Voir la note technique
                                                        </button>


                                                    </td>
                                                @endif
                                            </div>




                                        </div>
                                    </div>


                                    <div class="col-12" align="right">
                                        <hr>

                                        {{-- <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(7)]) }}"
                                            class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a> --}}

                                        {{-- <?php //if ($demandehabilitation->flag_soumis_charge_habilitation != true){
                                        ?>
                                        <button type="submit" name="action" value="FaireAttributionPU"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Affecter au chargé d'habillitation
                                        </button>
                                        <?php //}
                                        ?>

                                        <?php //if ($demandehabilitation->flag_reception_chef_departement == null && $role ==  'CHEFSERVICE'){
                                        ?>
                                        <button type="submit" name="action" value="AttributionChefDepartement"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Affecter au chef de departement
                                        </button>
                                        <?php //}
                                        ?>

                                        <?php //if ($demandehabilitation->flag_reception_chef_departement == true && $demandehabilitation->flag_reception_directerur == null  && $role ==  'CHEFDEPART' ){
                                        ?>
                                        <button type="submit" name="action" value="AttributionDirecteur"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Affecter au directeur
                                        </button>
                                        <?php //}
                                        ?>

                                        <?php //if ($demandehabilitation->flag_reception_chef_departement == true && $demandehabilitation->flag_reception_directerur == true && $demandehabilitation->flag_reception_secretaiaire == null  && $role ==  'DR'  ){
                                        ?>
                                        <button type="submit" name="action" value="AttributionSecretaire"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Affecter au secretaire
                                        </button>
                                        <?php //}
                                        ?>

                                        <?php //if ($demandehabilitation->flag_reception_chef_departement == true && $demandehabilitation->flag_reception_directerur == true && $demandehabilitation->flag_reception_secretaiaire == true  && $demandehabilitation->flag_agrement_demande_habilitaion == false  &&  $role ==  'SG'  ){
                                        ?>
                                        <button type="submit" name="action" value="GenererAgrement"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Generer l'agrement
                                        </button>
                                        <?php //}
                                        ?> --}}

                                        <?php if ( $demandehabilitation->flag_agrement_demande_habilitaion == true  ){ ?>
                                        <button type="submit" name="action" value="GenererAgrement"
                                            class="btn btn-sm btn-info me-1 waves-effect waves-float waves-light"
                                            onclick="NewWindow('{{ route('traitementdemandehabilitation.showagrement', \App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation)) }}','',screen.width*2,screen.height,'yes','center',1);">
                                            Voir l'agrement
                                        </button>

                                        <?php } ?>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                            <?php //}
                            ?>
                            <hr>


                        </div>

                        <div class="tab-pane fade <?php if ($idetape == 10) {
                            echo 'show active';
                        } ?>" id="navs-top-traitement" role="tabpanel">

                            <button type="button"
                                class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#modalToggle">
                                Voir le parcours de validation
                            </button>

                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(9)]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <input type="hidden" name="id_combi_proc" value={{ $id_num_comb }} />
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire : </label>
                                            <?php if(count($parcoursexist)<1){?>
                                            <textarea class="form-control form-control-sm" name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                            <?php
                                             }else{
                                            ?>
                                            <textarea class="form-control form-control-sm" name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if(count($parcoursexist)<1){?>
                                        <button type="submit" name="action" value="Valider"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Valider
                                        </button>
                                        {{-- <button type="submit" name="action" value="Rejeter"
                                                                  class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                                              Rejeter
                                                          </button> --}}
                                        <?php } ?>
                                        <?php if ( $demandehabilitation->flag_agrement_demande_habilitaion == true  ){ ?>
                                        <button type="submit" name="action" value="GenererAgrement"
                                            class="btn btn-sm btn-info me-1 waves-effect waves-float waves-light"
                                            onclick="NewWindow('{{ route('traitementdemandehabilitation.showagrement', \App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation)) }}','',screen.width*2,screen.height,'yes','center',1);">
                                            Voir l'agrement
                                        </button>

                                        <?php } ?>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                    <!--<div class="col-12 col-md-2" align="right"> <br>
                                                                                                                                      <button  type="submit" name="action" value="Enregistrer_categorie_plan" class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>
                                                                                                                                  </div>-->

                                </div>



                            </form>

                            <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggle"
                                aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel">Etapes </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="card">
                                            <h5 class="card-header">Parcours de la demande de validation du plan de
                                                formation</h5>
                                            <div class="card-body pb-2">
                                                <ul class="timeline pt-3">
                                                    @foreach ($ResultProssesList as $res)
                                                        <li
                                                            class="timeline-item pb-4 timeline-item-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                                                            <span
                                                                class="timeline-indicator-advanced timeline-indicator-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                                                                <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                            </span>
                                                            <div class="timeline-event">
                                                                <div class="timeline-header border-bottom mb-3">
                                                                    <h6 class="mb-0">{{ $res->priorite_combi_proc }}
                                                                    </h6>
                                                                    <span
                                                                        class="text-muted"><strong>{{ $res->name }}</strong></span>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                                                    <div class="d-flex align-items-center">
                                                                        @if ($res->is_valide == true)
                                                                            <div class="row ">
                                                                                <div>
                                                                                    <span>Observation :
                                                                                        {{ $res->comment_parcours }}</span>
                                                                                </div>
                                                                                <div>
                                                                                    <span>Validé le
                                                                                        {{ $res->date_valide }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if ($res->is_valide === false)
                                                                            <div class="row">
                                                                                <div>
                                                                                    <span>Observation :
                                                                                        {{ $res->comment_parcours }}</span>
                                                                                </div>
                                                                                <div>
                                                                                    <span
                                                                                        class="badge bg-label-danger">Validé
                                                                                        le {{ $res->date_valide }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="SoummissiondemandehabilitationApprouve1" tabindex="-1"
            aria-labelledby="SoummissiondemandehabilitationApprouve" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <form method="POST" class="form"
                        action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(8)]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h5 class="modal-title" id="SoummissiondemandehabilitationApprouve">Soumission de la demande
                                d'habiliation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                <?php
                                $message =
                                    "Je soussigné(e) <strong>$demandehabilitation->nom_responsable_demande_habilitation</strong>, " .
                                    @$demandehabilitation->fonction_demande_habilitation .
                                    ", atteste l'exactitude des informations contenue dans ce document.
                                
                                
                                
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        En cochant sur la mention <strong>Lu et approuvé</strong> ci-dessous, j'atteste cela.";
                                ?>
                                <?php echo wordwrap($message, 144, "<br>\n"); ?>


                            </p>

                        </div>
                        <div class="modal-footer">



                            <input type="checkbox" class="form-check-input" name="is_valide" id="colorCheck1"
                                onclick="myFunctionMAJ()">
                            <label>Lu et approuvé </label>
                            <button class="btn btn-success me-sm-3 me-1 btn-submit" type="submit" name="action"
                                value="Enregistrer_soumettre_demande_habilitation_PU"
                                id="Enregistrer_soumettre_demande_habilitation_PU" disabled>Valider la demande
                                d'habilitation</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="LettreEngagement" tabindex="-1" aria-labelledby="LettreEngagement"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl modal-simple modal-pricing">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="LettreEngagement" align="center"> <strong>LETTRE
                                D'ENREGISTREMENT</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="modal-body">
                        <button class=" btn-secondary me-1 waves-effect waves-float waves-light" align="right"
                            onclick="NewWindow('{{ route('traitementdemandehabilitation.show', \App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation)) }}','',screen.width*2,screen.height,'yes','center',1);">
                            Imprimer
                        </button>
                        <h6 class="modal-title" align="center"> <strong>LETTRE D'ENREGISTREMENT</strong></h6>
                        <div style="margin-bottom: 25px;" id="">
                            <div>
                                <div align="right">

                                    {{-- <input type="button" name="Submit" value="Imprimer"
                                            class="ecran visuel_bouton" onclick="window.print();" /> --}}
                                </div>
                                <br />
                            </div>
                        </div>

                        <div class="header">
                            <p>Abidjan, le 27 octobre 2023</p>
                        </div>
                        <div class="main">
                            <p>LE SECRETAIRE GENERAL</p>

                            <p>A</p>
                            <p>Monsieur le Président<br>
                                <?php echo $entreprise->nom_prenom_dirigeant; ?><br>
                                <?php echo $entreprise->adresse_postal_entreprises; ?><br>
                                <?php echo $entreprise->localisation_geographique_entreprise; ?></p>
                            <br>

                            <p><strong>N/Réf. :</strong> FDFP-SG/D2EQPC/N<sup>o</sup><s>180</s>-2023/NKP/AD/fcd</p>
                            <p><strong>Objet :</strong> V/Demande d’habilitation</p>

                            <br>

                            <p>Monsieur le Président,</p>
                            <p>Par courrier en date du 19 octobre 2023, vous avez bien voulu solliciter
                                l’habilitation du Fonds de Développement de la Formation Professionnelle (FDFP) pour
                                mener des actions de formation continue auprès des entreprises.</p>

                            <p>Par la présente, j’ai l’honneur de vous faire connaître qu’au regard du décret
                                N°2021-278 du 09 juin 2021 portant création, attributions, organisation et
                                fonctionnement , <strong> <?php echo $entreprise->raison_social_entreprises; ?> </strong> est autorisé à mener des
                                actions
                                de formation continue au profit des entreprises dans les domaines d'interventions
                                ci-après :</p>

                            {{-- <table class="table table-bordered table-striped table-hover table-sm" id=""
                                    style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Type domaine de formation </th>
                                            <th>Domaine de formation </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($domaineDemandeHabilitations as $key => $domaineDemandeHabilitation)
                                            <?php $i += 1; ?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}
                                                </td>
                                                <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table> --}}

                            <table class="table table-bordered table-striped table-hover table-sm" id=""
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Finalité </th>
                                        <th>Public </th>
                                        <th>Domaine de formation </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>

                                    @foreach ($domaineDemandeHabilitations as $key => $domaineDemandeHabilitation)
                                        <?php $i += 1; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}
                                            </td>
                                            <td>{{ @$domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }}
                                            </td>
                                            <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <br>

                            <p>Je vous prie d’agréer, Monsieur le Président, l’expression de ma considération
                                distinguée.</p>

                        </div>
                        </p>
                        <br>
                        <br>



                    </div>
                    @if ($demandehabilitation->flag_lettre_enregistrement == null)
                        <div class="modal-footer">

                            <div class="col-md-12" align="right">
                                <button class="btn btn-success me-sm-3 me-1 btn-submit" type="submit" name="action"
                                    value="ValideLettre" id="ValideLettre">Valider la lettre d'enregistrement</button>
                            </div>

                        </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="modal fade" id="NoteTechnique" tabindex="-1" aria-labelledby="NoteTechnique" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl modal-simple modal-pricing">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="NoteTechnique"> NOTE TECHNIQUE</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>


                    </div>


                    <div class="modal-body">
                        <button class=" btn-secondary me-1 waves-effect waves-float waves-light " align="right"
                            onclick="NewWindow('{{ route('traitementdemandehabilitation.shownotetechnique', \App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation)) }}','',screen.width*2,screen.height,'yes','center',1);">
                            Imprimer
                        </button>
                        <h6 class="modal-title" align="center"> <strong>NOTE TECHNIQUE</strong></h6>
                        <br>
                        <p> <br>

                        <div class="header">
                            <p>Abidjan, le 27 octobre 2023</p>
                        </div>

                        <div class="main">
                            <p><strong>Direction des Etudes, de l’Evaluation,</strong><br>
                                <strong>de la Qualité, de la Prospective et de la Communication</strong><br>
                                --------------<br>
                                <strong>Département Habilitation, Contrôle-Liquidation et du Suivi-Evaluation</strong>
                            </p>

                            <br><br>

                            <p class="subject">NOTE TECHNIQUE</p>

                            <p><strong>Objet :</strong> Demande d’habilitation <?php echo $entreprise->raison_social_entreprises . ' (' . $entreprise->sigl_entreprises . ')'; ?> </p>

                            <p>Le Département chargé de l’Habilitation, du Contrôle-Liquidation et du Suivi-Evaluation a
                                reçu la demande d’habilitation du <strong> <?php echo $entreprise->raison_social_entreprises . ' (' . $entreprise->sigl_entreprises . ')'; ?> </strong>.</p>

                            <p>Les établissements publics n’étant pas assujetti à la procédure d’habilitation, <strong>
                                    nous
                                    sollicitons par la présente note, votre accord pour son enregistrement dans la base
                                    de
                                    données du FDFP </strong> comme organisme public de formation autorisé à mener des
                                actions de
                                formation continue au profit des entreprises dans les domaines de compétences conférés à
                                l’Université de San Pedro par son décret de création.</p>
                            <br>
                            <p class="signature">Le Chef de Département</p>

                            <h5 align="center"> <strong> DOMAINES D'INTERVENTIONS</strong></h5>

                            <table class="table table-bordered table-striped table-hover table-sm" id=""
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Finalité </th>
                                        <th>Public </th>
                                        <th>Domaine de formation </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>

                                    @foreach ($domaineDemandeHabilitations as $key => $domaineDemandeHabilitation)
                                        <?php $i += 1; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}
                                            </td>
                                            <td>{{ @$domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }}
                                            </td>
                                            <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>



                            {{-- <table class="table">
                                    <tr>
                                        <th>AVIS DE LA DIRECTRICE</th>
                                        <th>DECISION DU SECRETAIRE GENERAL</th>
                                    </tr>
                                    <tr>
                                        <td style="height: 100px;"></td>
                                        <td></td>
                                    </tr>
                                </table> --}}

                            {{-- <p>PJ : Domaines de formation du CFC-USP</p> --}}

                        </div>


                        </p>
                        <br>
                        <br>



                    </div>
                    @if ($demandehabilitation->flag_note_technique == null)
                        <div class="modal-footer">

                            <div class="col-md-12" align="right">
                                <button class="btn btn-success me-sm-3 me-1 btn-submit" type="submit" name="action"
                                    value="ValideNote" id="ValideNote">Valider la note technique</button>
                            </div>

                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="modal fade" id="Recevabilite" tabindex="-1" aria-labelledby="Recevabilite"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <form method="POST" class="form"
                        action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation), \App\Helpers\Crypt::UrlCrypt(8)]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h5 class="modal-title" id="Recevabilite">Traitement de la recevabilité
                                d'habiliation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6 class="modal-title" align="center"> <strong>CAS D'APPROBATION</strong></h5>
                                <br>
                                <p>
                                    <?php
                                    $message = "La demande de Mr/Mlle/Mde  <strong>$demandehabilitation->nom_responsable_demande_habilitation</strong>, " . @$demandehabilitation->fonction_demande_habilitation . ', a correctement renseigner les informations liée a sa demande et que nous approuvons sa demande pour la validation car celle ci est conforme.';
                                    ?>
                                    <?php echo wordwrap($message, 120, "<br>\n"); ?>
                                    <br>
                                    {{-- <input type="checkbox" class="form-check-input" name="is_valide" id="colorCheck1"
                                        onclick="myFunctionMAJV()">
                                    <label>Lu et approuvé </label> <br> <br> --}}


                                    {{-- <div class="mb-1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Note technique <strong style="color:red;">*</strong>
                                            </label>
                                            <input type="text" name="note_technique_demande_habilitation"
                                                id="note_technique_demande_habilitation"
                                                class="form-control form-control-sm" required="required"
                                                value="{{ old('note_technique_demande_habilitation') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Lettre d'enregistrement<strong
                                                    style="color:red;">*</strong></label>
                                            <input type="file" name="lettre_engagement"
                                                class="form-control form-control-sm  @error('lettre_engagement')
                                                               error
                                                                @enderror"
                                                placeholder="" value="{{ old('lettre_engagement') }}" />
                                            @error('lettre_engagement')
                                                <div class=""><label class="error">{{ $message }}</label>
                                                </div>
                                            @enderror
                                            <div id="defaultFormControlHelp" class="form-text ">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                    <br>
                                <div class="col-md-12" align="right">
                                    <button class="btn btn-success me-sm-3 me-1 btn-submit" type="submit"
                                        name="action" value="Recevable_PUV" id="Recevable_PUV">Valider la demande
                                        d'habilitation</button>
                                </div>
                                </p>
                                <br>

                                <h6 class="modal-title" align="center"> <strong>CAS DE REJET</strong></h5>
                                    <br>
                                    <p>
                                        <?php
                                        $message = "La demande de Mr/Mlle/Mde <strong>$demandehabilitation->nom_responsable_demande_habilitation</strong>, " . @$demandehabilitation->fonction_demande_habilitation . ", n'a pas correctement renseigner les informations liée a sa demande et que nous rejetons sa demande pour la validation.";
                                        ?>
                                        <?php echo wordwrap($message, 100, "<br>\n"); ?>
                                        <br> <br>

                                        {{-- <input type="checkbox" class="form-check-input" name="is_valide"
                                            id="colorCheck1" onclick="myFunctionMAJR()">
                                        <label>Lu et approuvé </label> <br> --}}

                                    <div>
                                        <div class="mb-1">
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <div class="mb-1">
                                                        <label>Commentaire de non-recevabilité <strong
                                                                style="color:red;">(Obligatoire si non
                                                                recevable)*</strong>: </label>
                                                        <textarea class="form-control form-control-sm" name="commentaire_recevabilite" id="commentaire_recevabilite"
                                                            rows="8">{{ @$demandehabilitation->commentaire_recevabilite }}</textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" align="right">
                                        <button class="btn btn-danger me-sm-3 me-1 btn-submit" type="submit"
                                            name="action" value="NonRecevable_PUV" id="NonRecevable_PUV">Rejeter la
                                            demande
                                            d'habilitation</button>
                                    </div>
                                    </p>

                        </div>
                        <div class="modal-footer">



                            {{-- <input type="checkbox" class="form-check-input" name="is_valide" id="colorCheck1"
                                onclick="myFunctionMAJ()">
                            <label>Lu et approuvé </label>
                            <button class="btn btn-success me-sm-3 me-1 btn-submit" type="submit" name="action"
                                value="Enregistrer_soumettre_demande_habilitation_PU"
                                id="Enregistrer_soumettre_demande_habilitation_PU" disabled>Valider la demande
                                d'habilitation</button> --}}

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    @endsection

    @section('js_perso')
        <script>
            $("#dernier_catalogue_demande_habilitation_div").hide();

            $("#autre_activite_demande_habilitation_div").hide();

            $('#information_catalogue_demande_habilitation').on('change', function(e) {
                if (e.target.value == 'true') {
                    $("#dernier_catalogue_demande_habilitation_div").show();
                }
                if (e.target.value == 'false') {
                    $("#dernier_catalogue_demande_habilitation_div").hide();
                }
            });

            $('#information_seul_activite_demande_habilitation').on('change', function(e) {
                if (e.target.value == 'false') {
                    $("#autre_activite_demande_habilitation_div").show();
                }
                if (e.target.value == 'true') {
                    $("#autre_activite_demande_habilitation_div").hide();
                }
            });

            //Select2 banque
            $("#id_banque").select2().val({{ old('id_banque') }});

            var experience_formateur = new Quill('#experience_formateur', {
                theme: 'snow'
            });

            $("#experience_formateur_val").hide();

            var formformateur = document.getElementById("formformateur");


            formformateur.onsubmit = function() {
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

            formdivers.onsubmit = function() {
                $("#materiel_didactique_demande_habilitation_val").val(materiel_didactique_demande_habilitation.root
                    .innerHTML);
                $("#reference_ci_demande_habilitation_val").val(reference_ci_demande_habilitation.root.innerHTML);
                $("#autre_activite_demande_habilitation_val").val(autre_activite_demande_habilitation.root.innerHTML);
            }


            var quel_financement_intervention_hors_ci = new Quill('#quel_financement_intervention_hors_ci', {
                theme: 'snow'
            });

            $("#quel_financement_intervention_hors_ci_val").hide();

            var formInterventionHorsCi = document.getElementById("formInterventionHorsCi");


            formInterventionHorsCi.onsubmit = function() {
                $("#quel_financement_intervention_hors_ci_val").val(quel_financement_intervention_hors_ci.root.innerHTML);
            }

            var idactivesmoussion = $('#colorCheck1').prop('checked', false);


            function myFunctionMAJ() {
                // Get the checkbox
                var checkBox = document.getElementById("colorCheck1");

                // If the checkbox is checked, display the output text
                if (checkBox.checked == true) {
                    $("#Enregistrer_soumettre_demande_habilitation_PU").prop("disabled", false);
                } else {
                    $("#Enregistrer_soumettre_demande_habilitation_PU").prop("disabled", true);
                }
            }

            function myFunctionMAJV() {
                // Get the checkbox
                var checkBox = document.getElementById("colorCheck1");

                // If the checkbox is checked, display the output text
                if (checkBox.checked == true) {
                    $("#Enregistrer_soumettre_demande_habilitation_PUV").prop("disabled", false);
                } else {
                    $("#Enregistrer_soumettre_demande_habilitation_PUV").prop("disabled", true);
                }
            }

            function myFunctionMAJR() {
                // Get the checkbox
                var checkBox = document.getElementById("colorCheck1");

                // If the checkbox is checked, display the output text
                if (checkBox.checked == true) {
                    $("#Enregistrer_soumettre_demande_habilitation_PUR").prop("disabled", false);
                } else {
                    $("#Enregistrer_soumettre_demande_habilitation_PUR").prop("disabled", true);
                }
            }
        </script>
    @endsection
@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}"; //here double curly bracket
    </script>
@endif
