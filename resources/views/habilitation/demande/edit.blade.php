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
                                class="nav-link <?php if( $idetape==2 and isset($demandehabilitation) ){ echo "active";} ?>"
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
                                class="nav-link <?php if($idetape==3 and count($moyenpermanentes)==1){ echo "active";} ?>"
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
                                class="nav-link <?php if($idetape==4 and count($interventions)>0){ echo "active";} ?>"
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
                                class="nav-link <?php if($idetape==5 and count($organisations)>0){ echo "active";} ?>"
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
                                class="nav-link <?php if($idetape==6 and count($organisations)>0){ echo "active";} ?>"
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
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-Soumettre"
                                aria-controls="navs-top-Soumettre"
                                aria-selected="false">
                                Soumission
                                </button>
                            </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade <?php if($idetape==1){ echo "show active";}  ?>" id="navs-top-informationentreprise" role="tabpanel">

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



                                            <div class="col-12" align="right">
                                                <hr>
                                                <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                    <button type="submit" name="action" value="Modifier"
                                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                            Modifier
                                                    </button>
                                                <?php } ?>


                                                <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div class="tab-pane fade <?php if($idetape==2 and isset($demandehabilitation)){ echo "show active";} ?>" id="navs-top-moyenpermanente" role="tabpanel">
                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                                        @csrf
                                       @method('put')
                                       <div class="row">

                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Moyen permanente <strong style="color:red;">*</strong></label>
                                                <select class="select2 form-select-sm input-group @error('id_type_moyen_permanent')
                                                    error
                                                    @enderror" data-allow-clear="true" name="id_type_moyen_permanent">
                                                    <?= $typemoyenpermanenteList; ?>
                                                </select>
                                                @error('id_type_moyen_permanent')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Nombre  <strong style="color:red;">*</strong> </label>
                                                   <input type="number" min="0" name="nombre_moyen_permanente" id="nombre_moyen_permanente"
                                                       class="form-control form-control-sm"/>
                                               </div>
                                               @error('nombre_moyen_permanente')
                                               <div class=""><label class="error">{{ $message }}</label></div>
                                               @enderror
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Capacite d'acceuil <strong style="color:red;">*</strong> </label>
                                                   <input type="number" min="0" name="capitale_moyen_permanente" id="capitale_moyen_permanente"
                                                       class="form-control form-control-sm" />
                                               </div>
                                               @error('capitale_moyen_permanente')
                                               <div class=""><label class="error">{{ $message }}</label></div>
                                               @enderror
                                           </div>


                                           <div class="col-12" align="right">
                                               <hr>

                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                               <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                   <button type="submit" name="action" value="AjouterMoyenPermanente"
                                                           class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                           Ajouter
                                                   </button>
                                               <?php } ?>


                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                               <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                   Retour</a>
                                           </div>
                                       </div>
                                   </form>
                                   <?php } ?>
                                   <hr>
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
                                <div class="tab-pane fade <?php if($idetape==3 and count($moyenpermanentes)>0){ echo "show active";} ?>" id="navs-top-intervention" role="tabpanel">
                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                        <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(3)]) }}">
                                            @csrf
                                           @method('put')
                                           <div class="row">

                                                <div class="col-md-12">
                                                    <label class="form-label" for="billings-country">Intervention <strong style="color:red;">*</strong></label>
                                                    <select class="select2 form-select-sm input-group @error('id_type_intervention')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_type_intervention[]" multiple>
                                                        <?= $typeinterventionsList; ?>
                                                    </select>
                                                    @error('id_type_intervention')
                                                    <div class=""><label class="error">{{ $message }}</label></div>
                                                    @enderror
                                                </div>


                                               <div class="col-12" align="right">
                                                   <hr>

                                                   <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                                   <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                       <button type="submit" name="action" value="AjouterDemandeIntervention"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                                   <?php } ?>


                                                   <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                                   <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                       Retour</a>
                                               </div>
                                           </div>
                                       </form>
                                       <?php } ?>
                                       <hr>
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
                                <div class="tab-pane fade <?php if($idetape==4 and count($interventions)>0){ echo "show active";} ?>" id="navs-top-organisationformation" role="tabpanel">
                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                        <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(4)]) }}">
                                            @csrf
                                           @method('put')
                                           <div class="row">

                                                <div class="col-md-12">
                                                    <label class="form-label" for="billings-country">Organisation formation <strong style="color:red;">*</strong></label>
                                                    <select class="select2 form-select-sm input-group @error('id_type_organisation_formation')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_type_organisation_formation[]" multiple>
                                                        <?= $organisationFormationsList; ?>
                                                    </select>
                                                    @error('id_type_organisation_formation')
                                                    <div class=""><label class="error">{{ $message }}</label></div>
                                                    @enderror
                                                </div>


                                               <div class="col-12" align="right">
                                                   <hr>

                                                   <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                                   <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                       <button type="submit" name="action" value="AjouterOrganisationFormation"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                                   <?php } ?>


                                                   <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                                   <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                       Retour</a>
                                               </div>
                                           </div>
                                       </form>
                                       <?php } ?>
                                       <hr>
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
                                <div class="tab-pane fade <?php if($idetape==5 and count($organisations)>0){ echo "show active";} ?>" id="navs-top-domaineformation" role="tabpanel">
                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                        <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(5)]) }}">
                                            @csrf
                                           @method('put')
                                           <div class="row">

                                                <div class="col-md-6">
                                                    <label class="form-label" for="billings-country">Type de domaine  <strong style="color:red;">*</strong></label>
                                                    <select class="select2 form-select-sm input-group @error('id_type_domaine_demande_habilitation')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_type_domaine_demande_habilitation">
                                                        <?= $typeDomaineDemandeHabilitationList; ?>
                                                    </select>
                                                    @error('id_type_domaine_demande_habilitation')
                                                    <div class=""><label class="error">{{ $message }}</label></div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label" for="billings-country">Domaine de formation <strong style="color:red;">*</strong></label>
                                                    <select class="select2 form-select-sm input-group @error('id_domaine_formation')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_domaine_formation">
                                                        <?= $domainesList; ?>
                                                    </select>
                                                    @error('id_domaine_formation')
                                                    <div class=""><label class="error">{{ $message }}</label></div>
                                                    @enderror
                                                </div>


                                               <div class="col-12" align="right">
                                                   <hr>

                                                   <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                                   <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                       <button type="submit" name="action" value="AjouterDomaineFormation"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                                   <?php } ?>


                                                   <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(6)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                                   <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                       Retour</a>
                                               </div>
                                           </div>
                                       </form>
                                       <?php } ?>
                                       <hr>
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
                                <div class="tab-pane fade <?php if($idetape==6 and count($organisations)>0){ echo "show active";} ?>" id="navs-top-formateur" role="tabpanel">
                                    <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                        <form method="POST" enctype="multipart/form-data" id="formformateur" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(6)]) }}">
                                            @csrf
                                           @method('put')
                                           <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label>Nom du formateur  <strong style="color:red;">*</strong> </label>
                                                            <input type="text" name="nom_formateur" id="nom_formateur"
                                                                class="form-control form-control-sm"  value="{{ old('nom_formateur') }}">
                                                        </div>
                                                        @error('nom_formateur')
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label>Prénom du formateur  <strong style="color:red;">*</strong> </label>
                                                            <input type="text" name="prenom_formateur" id="prenom_formateur"
                                                                class="form-control form-control-sm"  value="{{ old('prenom_formateur') }}">
                                                        </div>
                                                        @error('prenom_formateur')
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <label class="form-label" for="billings-country">Domaine de formation  <strong style="color:red;">*</strong></label>
                                                        <select class="select2 form-select-sm input-group @error('id_domaine_demande_habilitation')
                                                            error
                                                            @enderror" data-allow-clear="true" name="id_domaine_demande_habilitation">
                                                            <?= $domainedemandeList; ?>
                                                        </select>
                                                        @error('id_domaine_demande_habilitation')
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label>Date de début d'experience  <strong style="color:red;">*</strong> </label>
                                                            <input type="date" name="date_debut_formateur" id="date_debut_formateur"
                                                                class="form-control form-control-sm"  value="{{ old('date_debut_formateur') }}">
                                                        </div>
                                                        @error('date_debut_formateur')
                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="mb-1">
                                                            <label>Date de fin d'experience  </label>
                                                            <input type="date" name="date_fin_formateur" id="date_fin_formateur"
                                                                class="form-control form-control-sm"  value="{{ old('date_fin_formateur') }}">
                                                        </div>
                                                        @error('date_fin_formateur')
                                                        <div class=""><label class="error">{{ $message }}</label></div>
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
                                                                @enderror" placeholder=""

                                                               value="{{ old('cv_formateur') }}"/>
                                                        @error('cv_formateur')
                                                            <div class=""><label class="error">{{ $message }}</label></div>
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
                                                                @enderror" placeholder=""

                                                               value="{{ old('le_formateur') }}"/>
                                                        @error('le_formateur')
                                                            <div class=""><label class="error">{{ $message }}</label></div>
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
                                                        <label>Experience  </label>
                                                                <input class="form-control @error('experience_formateur') error @enderror" type="text" id="experience_formateur_val" name="experience_formateur"/>
                                                                <div id="experience_formateur" class="rounded-1">{{ old('experience_formateur') }}</div>
                                                    </div>
                                                    @error('experience_formateur')
                                                    <div class=""><label class="error">{{ $message }}</label></div>
                                                    @enderror
                                                </div>



                                               <div class="col-12" align="right">
                                                   <hr>

                                                   <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                                   <?php if ($demandehabilitation->flag_soumis_demande_habilitation != true){ ?>
                                                       <button type="submit" name="action" value="AjouterFormateur"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                                   <?php } ?>


                                                   <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(7)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                                   <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                       Retour</a>
                                               </div>
                                           </div>
                                       </form>
                                       <?php } ?>
                                       <hr>
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
                                <div class="tab-pane fade" id="navs-top-Soumettre" role="tabpanel">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- END: Content-->

        @endsection

        @section('js_perso')

            <script>
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
            </script>


        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
