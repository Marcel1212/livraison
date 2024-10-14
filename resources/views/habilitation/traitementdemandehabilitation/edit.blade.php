<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;
use App\Helpers\Fonction;
use App\Helpers\Menu;

$codeRoles = Menu::get_code_menu_profil(Auth::user()->id);

//dd($codeRoles);
//dd($demandehabilitation->flag_reception_demande_habilitation);

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
                            @if($demandehabilitation->flag_rejet_demande_habilitation == true)
                                <div align="right">
                                    <button type="button"
                                            class="btn rounded-pill btn-outline-success btn-sm waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#modalToggleCommentaireplan">
                                        Voir les commentaire de la non recevabilité
                                    </button>
                                </div>
                            @endif
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
                                class="nav-link <?php if($idetape==7 and count($formateurs)>0){ echo "active";} ?>"
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
                                class="nav-link <?php if($idetape==8 and count($formateurs)>0){ echo "active";} ?>"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-Soumettre"
                                aria-controls="navs-top-Soumettre"
                                aria-selected="false">
                                Intervention hors du pays
                                </button>
                            </li>
                            @if ($codeRoles == 'CHEFSERVICE')
                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link <?php if($idetape==9 ){ echo "active";} ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-affectation"
                                    aria-controls="navs-top-affectation"
                                    aria-selected="false">
                                    Affectation
                                    </button>
                                </li>
                            @else
                                <?php if($demandehabilitation->flag_reception_demande_habilitation==false){ ?>
                                    <li class="nav-item">
                                        <button
                                        type="button"
                                        class="nav-link <?php if($idetape==9 and $demandehabilitation->flag_reception_demande_habilitation==false){ echo "active";} ?>"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-top-recevabilite"
                                        aria-controls="navs-top-recevabilite"
                                        aria-selected="false">
                                        Recevabilité
                                        </button>
                                    </li>
                                <?php }else{ ?>
                                    <li class="nav-item">
                                        <button
                                        type="button"
                                        class="nav-link <?php if($idetape==9 ){ echo "active";} ?>"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-top-traitement"
                                        aria-controls="navs-top-traitement"
                                        aria-selected="false">
                                        Traitement
                                        </button>
                                    </li>
                                <?php } ?>
                            @endif

                            @if(@$visites->statut == "terminer")
                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link <?php if($idetape==10 and @$visites->statut == "terminer"){ echo "active";} ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-Rpport-visite"
                                    aria-controls="navs-top-Rpport-visite"
                                    aria-selected="false">
                                        Rapport de visite
                                    </button>
                                </li>
                            @endif
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade <?php if($idetape==1){ echo "show active";}  ?>" id="navs-top-informationentreprise" role="tabpanel">

                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}" enctype="multipart/form-data">
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

                                            <div class="col-md-4 col-12">
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

                                            <div class="col-md-4 col-12">
                                                <label class="form-label" for="billings-country">Type entreprise <strong style="color:red;">*</strong></label>
                                                <select class="select2 form-select-sm input-group @error('flag_ecole_autre_entreprise')
                                                    error
                                                    @enderror" data-allow-clear="true" name="flag_ecole_autre_entreprise" id="flag_ecole_autre_entreprise">
                                                    <option value="">---Choix du type entreprise--</option>
                                                    <option value="true" @if($demandehabilitation->flag_ecole_autre_entreprise == true ) selected @endif>Ecoles</option>
                                                    <option value="false" @if($demandehabilitation->flag_ecole_autre_entreprise == false ) selected @endif>Autres</option>
                                                </select>
                                                @error('flag_ecole_autre_entreprise')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <label class="form-label" for="billings-country">Titre ou Contrat de bail <strong style="color:red;">*</strong></label><br/>
                                                @if (isset($demandehabilitation->titre_propriete_contrat_bail))
                                                    <span class="badge bg-secondary">
                                                        <a target="_blank"
                                                            onclick="NewWindow('{{ asset("/pieces/titre_propriete_contrat_bail/". $demandehabilitation->titre_propriete_contrat_bail)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce
                                                        </a>
                                                    </span>
                                                @endif

                                            </div>

                                            <div class="col-md-4 col-12" id="autorisation_ouverture_ecole_div">
                                                <label class="form-label" for="billings-country">Autorisation d'ouverture <strong style="color:red;">(*)</strong></label>
                                                @if (isset($demandehabilitation->autorisation_ouverture_ecole))
                                                    <span class="badge bg-secondary">
                                                        <a target="_blank"
                                                            onclick="NewWindow('{{ asset("/pieces/autorisation_ouverture_ecole/". $demandehabilitation->autorisation_ouverture_ecole)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce
                                                        </a>
                                                    </span>
                                                @endif

                                            </div>

                                        </div>
                                    </form>

                                </div>
                                <div class="tab-pane fade <?php if($idetape==2 and isset($demandehabilitation)){ echo "show active";} ?>" id="navs-top-moyenpermanente" role="tabpanel">

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
                                        <table class="table table-bordered table-striped table-hover table-sm"
                                            id=""
                                            style="margin-top: 13px !important">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Finalité </th>
                                                <th>Public </th>
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
                                                                <td>{{ @$domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }}</td>
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
                                                        <td>{{ Fonction::calculerAnneesExperience($formateur->id_formateurs) }}</td>
                                                        <td>
                                                            <a onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                                class=" "
                                                                title="Modifier"><img src='/assets/img/eye-solid.png'></a>
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
                                <div class="tab-pane fade <?php if($idetape==7 and count($formateurs)>0){ echo "show active";} ?>" id="navs-top-divers" role="tabpanel">
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
                                                    @if (isset($demandehabilitation->dernier_catalogue_demande_habilitation_div))
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
                                                    @endif
                                                    @if (isset($demandehabilitation->autre_activite_demande_habilitation_div))
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
                                                    @endif

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
                                <div class="tab-pane fade <?php if($idetape==8 and count($formateurs)>0){ echo "show active";} ?>" id="navs-top-Soumettre" role="tabpanel">

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

                                @if ($codeRoles == 'CHEFSERVICE')
                                            <?php //if ($demandehabilitation->flag_soumis_charge_habilitation != true){ ?>
                                            <div class="tab-pane fade <?php if($idetape==9){ echo "show active";} ?>" id="navs-top-affectation" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <form method="POST" enctype="multipart/form-data" id="formAttribution" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(9)]) }}">
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

                                                    </div>
                                                    <div class="col-md-4">

                                                        <table class="table table-bordered table-striped table-hover table-sm"
                                                        id=""
                                                        style="margin-top: 13px !important">
                                                        <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Chargés habilitations </th>
                                                            <th>Dossiers en cours</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $i=0; ?>
                                                        @foreach ($NombreDemandeHabilitation as $key => $nbre)
                                                            <tr>
                                                                <td>{{ ++$i }}</td>
                                                                <td>{{  @$nbre->name }} {{  @$nbre->prenom_users }}</td>
                                                                <td>{{  @$nbre->nbre_dossier_en_cours }} </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    </div>
                                                </div>


                                                <div class="col-12" align="right">
                                                    <hr>

                                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                            </div>
                                        <?php //} ?>
                                @else
                                    <?php if ($demandehabilitation->flag_reception_demande_habilitation != true){ ?>
                                    <div class="tab-pane fade <?php if($idetape==9){ echo "show active";} ?>" id="navs-top-recevabilite" role="tabpanel">
                                        <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(9)]) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                            <div class="col-md-6 col-12">
                                                                    <label class="form-label" for="billings-country">Les motifs d'irrecevabilité <strong style="color:red;">(Obligatoire si non recevable)*</strong></label>

                                                                        <select class="select2 form-select input-group" data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">
                                                                            <?= $motif; ?>
                                                                        </select>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Commentaire Recevabilité <strong style="color:red;">(Obligatoire si non recevable)*</strong>: </label>
                                                                        <textarea class="form-control form-control-sm"  name="commentaire_recevabilite" id="commentaire_recevabilite" rows="6">{{@$demandehabilitation->commentaire_recevabilite}}</textarea>
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
                                    </div>
                                    <?php }else{ ?>
                                        <div class="tab-pane fade <?php if($idetape==9){ echo "show active";} ?>" id="navs-top-traitement" role="tabpanel">
                                            <!-- Full calendar start -->
                                                <?php //dd($demandehabilitation->visites->statut); ?>
										        <div class="row">
                                                    <div class="col-8">

                                                    </div>
                                                    <div class="col-4" align="right">
													@if (@$visites->statut == "terminer")
														<a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(10)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Editer le rapport</a>
													@endif
                                                    </div>

                                                    <br/>
                                                    <br/>
                                                </div>
                                                <div id="success_text"></div>
                                                <div id="success_text_rapport"></div>
                                                <section>
                                                    <div class="app-calendar overflow-hidden border">
                                                        <div class="row ">
                                                            <!-- Sidebar -->
                                                            <div class="col-md-2 ps-4 pt-4 pe-4 app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                                                                <div class="sidebar-wrapper">
                                                                    @if (count(@$rapportVisite)<1)
                                                                        <div class="card-body d-flex justify-content-center">
                                                                            <button class="btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="modal" data-bs-target="#add-new-sidebar">
                                                                                <span class="align-middle">Prise de rendez-vous</span>
                                                                            </button>
                                                                        </div>
                                                                    @endif


                                                                    <div class="filter-section">
                                                                        <label for="filter-status" class="form-label">Filtrer par statut</label>
                                                                        <select id="filter-status" class="form-select w-100">
                                                                            <option value="">Tous</option>
                                                                            <option value="planifier">Planifier</option>
                                                                            <option value="commencer">Commencer</option>
                                                                            <option value="terminer">Terminer</option>
                                                                            <option value="annuler">Annuler</option>
                                                                            <option value="reporter">Reporter</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /Sidebar -->

                                                            <!-- Calendar -->
                                                            <div class="col-md-10 position-relative">
                                                                <div class="card shadow-none border-0 mb-0 rounded-0">
                                                                    <div class="card-body pb-0">
                                                                        <div id="calendar"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /Calendar -->
                                                            <div class="body-content-overlay"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Calendar Add/Update/Delete event modal-->
                                                    <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
                                                        <div class="modal-dialog sidebar-lg">
                                                            <div class="modal-content p-0">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                                                <div class="modal-header mb-1">
                                                                    <h5 class="modal-title">Prise de rendez-vous</h5>
                                                                </div>
                                                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                                                    <div id="error_text"></div>



                                                                    <!-- Formulaire d'événement -->
                                                                        <form class="event-form needs-validation" id="event-form" data-ajax="false" novalidate>
                                                                            <!-- Champ caché pour l'ID de la demande d'habilitation -->
                                                                            <input type="hidden" id="id_demande_habilitation" name="id_demande_habilitation" value="{{ $demandehabilitation->id_demande_habilitation }}">



                                                                            <!-- Sélection du statut -->
                                                                            <div class="mb-1">
                                                                                <label for="select-label" class="form-label">Statut</label>
                                                                                <select class="select2 select-label form-select w-100" id="select-label" name="select-label" required>
                                                                                    <option data-label="primary" value="planifier">Planifier</option>
                                                                                    <option data-label="info" value="commencer">Commencer</option>
                                                                                    <option data-label="success" value="terminer">Terminer</option>
                                                                                    <option data-label="danger" value="annuler">Annuler</option>
                                                                                    <option data-label="warning" value="reporter">Reporter</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Date de début -->
                                                                            <div class="mb-1 position-relative">
                                                                                <label for="start-date" class="form-label">Date de début provisoire</label>
                                                                                <input type="date" class="form-control" id="start-date" name="start-date" placeholder="Date de début" required />
                                                                            </div>

                                                                            <!-- Heure de fin -->
                                                                            <div class="mb-1 position-relative">
                                                                                <label for="end-date" class="form-label">Heure de debut provisoire </label>
                                                                                <input type="time" class="form-control" id="end-date" name="end-date" placeholder="Heure de fin provisoire" required />
                                                                            </div>

                                                                            <div class="mb-1 position-relative">
                                                                                <label for="enddateP" class="form-label">Heure de fin provisoire </label>
                                                                                <input type="time" class="form-control" id="enddateP" name="enddateP" placeholder="Heure de fin provisoire" required />
                                                                            </div>

                                                                            <div class="mb-1 position-relative">
                                                                                <label for="enddateR" class="form-label">Heure de fin reel </label>
                                                                                <input type="time" class="form-control" id="enddateR" name="enddateR" placeholder="Heure de fin reel" required />
                                                                            </div>

                                                                            <!-- Description de l'événement -->
                                                                            <div class="mb-1">
                                                                                <label for="event-description-editor" class="form-label">Description</label>
                                                                                <textarea class="form-control" id="event-description-editor" name="event-description-editor" required></textarea>
                                                                            </div>

                                                                            <!-- Boutons d'action -->
                                                                            <div class="d-flex mb-1">
                                                                                <button type="submit" class="btn btn-primary add-event-btn me-1">Ajouter</button>
                                                                                <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Annuler</button>
                                                                                <button type="submit" class="btn btn-primary update-event-btn d-none me-1">Mettre à jour</button>
                                                                                <a href="" class="btn btn-success update-lien-event-btn d-none me-1">Aller sur le dossier</a>
                                                                                <button type="button" class="btn btn-outline-danger btn-delete-event d-none">Supprimer</button>
                                                                            </div>
                                                                        </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/ Calendar Add/Update/Delete event modal-->
                                                </section>
                                            <!-- Full calendar end -->

                                        </div>
                                    <?php } ?>
                                @endif


                                <div class="tab-pane fade <?php if($idetape==10 and @$visites->statut == "terminer"){ echo "show active";} ?>" id="navs-top-Rpport-visite" role="tabpanel">
                                    <div class="row">
                                        <div class="col-8">

                                        </div>
                                        <div class="col-4" align="right">
                                                @if ( count($rapportVisite)>0)
                                                    @if ($demandehabilitation->flag_soumis_comite_technique == false)
                                                        <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(9)]) }}">
                                                            @csrf
                                                            @method('put')
                                                            <button onclick='javascript:if (!confirm("La demande sera soumis au comite technique  ? . Cette action est irréversible.")) return false;' type="submit" name="action" value="Soumission_demande_ct"
                                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                            Soumettre pour le comite
                                                            </button>
                                                        </form>
                                                    @else

                                                            <a onclick="NewWindow('{{ route($lien.".rapport",\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light"
                                                                title="Modifier">Fiche d'analyse</a>

                                                    @endif
                                                @endif
                                        </div>

                                        <br/>
                                        <br/>
                                    </div>
                                    <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(10)]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label" for="etat_locaux_rapport">Etat des locaux
                                                    <strong style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm" name="etat_locaux_rapport" id="etat_locaux_rapport" rows="6">{{ @$rapportVisite[0]->etat_locaux_rapport }}</textarea>
                                            </div>



                                            <div class="col-md-6">
                                                <label class="form-label" for="equipement_rapport">Equipements
                                                    <strong style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm" name="equipement_rapport" id="equipement_rapport" rows="6">{{ @$rapportVisite[0]->equipement_rapport }}</textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="salubrite_rapport">Salubrité/Securité
                                                    <strong style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm" name="salubrite_rapport" id="salubrite_rapport" rows="6">{{ @$rapportVisite[0]->salubrite_rapport }}</textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="contenu">Autres</label>
                                                    <textarea class="form-control form-control-sm" name="contenu" id="contenu" rows="6">{{ @$rapportVisite[0]->contenu }}</textarea>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-12">
                                            <label class="form-label" for="avis_comite_technique">Avis de la commission technique <strong style="color:red;">*</strong></label>
                                                <textarea class="form-control form-control-sm" name="avis_comite_technique" id="avis_comite_technique"></textarea>
                                        </div> --}}

                                        <div class="col-12" align="right">
                                            <hr>



                                                     <button type="submit" name="action" value="Rapport"
                                                             class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                             Rapport
                                                     </button>

                                        </div>


                                    </form>

                                </div>




                            </div>
                        </div>
                    </div>

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

                <input name="idddemha" class="idddemha" value="{{ $demandehabilitation->id_demande_habilitation }}" type="hidden" id="idddemha"/>
                <input name="id_visite" class="id_visite"  type="hidden" id="id_visite"/>

        <!-- END: Content-->

        @endsection



        @section('js_perso')



        <script>

    var idddemha;
    var idddemha = $('#idddemha').val();

            document.addEventListener('DOMContentLoaded', function () {

var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    editable: false,
                    selectable: true,
                    allDaySlot: true,
                    locale: 'fr',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    businessHours: {
                        //daysOfWeek: [1, 2, 3, 4, 5], // Lundi à vendredi
                        startTime: '08:00',
                        endTime: '18:00'
                    },
                    allDaySlot: true,
                    buttonText: {
                        today:    'Aujourd\'hui',
                        month:    'Mois',
                        week:     'Semaine',
                        day:      'Jour',
                        list:     'Liste'
                    },
                    hiddenDays: [0,6],
                    aspectRatio: 3,
                    events: {
                        url: '/traitementdemandehabilitation/calendar-events', // Route Laravel pour récupérer les événements
                        method: 'GET',
                        extraParams: function() {
                            return {
                                statut: $('#filter-status').val() // Filtrer les événements selon le statut sélectionné
                            };
                        },
                        failure: function() {
                            alert('Erreur lors du chargement des événements.');
                        }
                    },
                    eventDidMount: function(info) {
                        var statut = info.event.extendedProps.selectlabel;
                        if (statut === 'planifier') {
                        info.el.style.backgroundColor = '#007bff';
                        info.el.style.borderColor = '#007bff';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        } else if (statut === 'commencer') {
                        info.el.style.backgroundColor = '#17a2b8';
                        info.el.style.borderColor = '#17a2b8';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        } else if (statut === 'terminer') {
                        info.el.style.backgroundColor = '#28a745';
                        info.el.style.borderColor = '#28a745';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        } else if (statut === 'annuler') {
                        info.el.style.backgroundColor = '#dc3545';
                        info.el.style.borderColor = '#dc3545';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        } else if (statut === 'reporter') {
                        info.el.style.backgroundColor = '#ffc107';
                        info.el.style.borderColor = '#ffc107';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        }
                    },
                    dateClick: function(info) {
                        //alert(info);
                    resetModalForm(); // Réinitialise les champs du formulaire
                    $('#start-date').val(info.dateStr); // Remplit la date de début automatiquement
                    $('.add-event-btn').removeClass('d-none'); // Affiche le bouton "Add"
                    $('.update-event-btn, .update-lien-event-btn').addClass('d-none'); // Cache les boutons "Update" et "Delete"
                    $('#add-new-sidebar').modal('show');
                     },
                    eventClick: function(info) {
                        // Récupération de l'ID de l'événement (visite) cliqué
                       // var visiteId = info.event.id;
                       resetModalForm();
                       var visiteId = getVisiteId(info.event);
                       openAndRefreshModal(info.event.id);
                        //populateModalForm(info.event); // Remplit les champs du formulaire avec les informations de l'événement
                       // alert(info.event.extendedProps.selectlabel)
                       if (info.event.extendedProps.selectlabel === "terminer") {
                            $('.add-event-btn').addClass('d-none');
                            $('.update-event-btn').addClass('d-none');
                            $('.update-lien-event-btn').removeClass('d-none'); // Affiche un bouton spécifique pour les événements terminés
                        } else {
                            $('.add-event-btn').addClass('d-none');
                            $('.update-lien-event-btn').addClass('d-none');
                            $('.update-event-btn').removeClass('d-none'); // Affiche le bouton de mise à jour pour les autres statuts
                        }
                        $('#add-new-sidebar').modal('show');
                    },
                    eventDrop: function(info) {
                        updateEvent(info.event); // Met à jour l'événement après un drag and drop
                    }
                });

                calendar.render();

                    // Apply filter when the select option changes
                $('#filter-status').on('change', function() {
                    calendar.refetchEvents(); // Recharge les événements avec le nouveau filtre
                });

                // Fonction pour récupérer l'ID de la visite sélectionnée
                function getVisiteId(event) {
                    return event.id;
                }

                // Fonction pour réinitialiser le modal
                function resetModal() {
                    $('#event-form')[0].reset();  // Réinitialiser le formulaire
                    $('#event-form .is-invalid').removeClass('is-invalid');  // Retirer les validations précédentes
                    $('#event-form .is-valid').removeClass('is-valid');      // Retirer les validations précédentes
                }

                // Fonction pour réinitialiser le modal
                function resetModalRapport() {
                    $('#rapport-form')[0].reset();  // Réinitialiser le formulaire
                    $('#rapport-form .is-invalid').removeClass('is-invalid');  // Retirer les validations précédentes
                    $('#rapport-form .is-valid').removeClass('is-valid');      // Retirer les validations précédentes
                }

                $('#add-new-sidebar').on('hidden.bs.modal', function () {
                    resetModal();  // Réinitialiser le modal à chaque fermeture
                });

                $('#ActiveRapport').on('hidden.bs.modal', function () {
                    resetModalRapport();  // Réinitialiser le modal à chaque fermeture
                });


                // Rafraîchir le contenu du modal
                function refreshModal(eventId) {
                   // alert(eventId)
                    $.ajax({
                        url: '/traitementdemandehabilitation/calendar-events/get-event-data/' + eventId,  // URL pour récupérer les données de l'événement
                        type: 'GET',
                        success: function(response) {
                            //console.log(response)
                            // Injecter les nouvelles données dans le modal
                            $('#id_demande_habilitation').val(response.id_demande_habilitation);
                            $('#title').val(response.title);
                            $('#end-date').val(response.timestart);
                            $('#event-description-editor').val(response.eventdescriptioneditor);
                            $('#select-label').val(response.selectlabel).change();
                            let formattedStartDate = moment(response.datevisite).format('YYYY-MM-DD');
                            $('#start-date').val(formattedStartDate);
                            $('#enddateP').val(response.timeend);
                            $('#enddateR').val(response.timeendr);
                            $('#id_visite').val(response.id); // Stocker l'ID dans un champ caché pour une utilisation ultérieure
                            $('.update-lien-event-btn').attr('href', response.url);
                            // Ouvrir le modal après mise à jour
                            $('#add-new-sidebar').modal('show');
                        },
                        error: function(error) {
                            alert('Erreur lors du rafraîchissement du modal')
                            console.log('Erreur lors du rafraîchissement du modal', error);
                        }
                    });
                }


                function openAndRefreshModal(eventId) {
                    resetModal();  // Réinitialiser le contenu
                    refreshModal(eventId);  // Charger les nouvelles données
                }

                // Bouton d'édition
                $('.edit-event-btn').on('click', function(e) {
                    e.preventDefault();
                    let eventId = $(this).data('event-id');  // Récupérer l'ID de l'événement
                    openAndRefreshModal(eventId);  // Rafraîchir et ouvrir le modal
                });

                // Fonction pour réinitialiser le formulaire du modal
                function resetModalForm() {
                    $('#title').val('');
                    $('#start-date').val('');
                    $('#end-date').val('');
                    $('#enddateP').val('');
                    $('#enddateR').val('');
                    $('#event-description-editor').val('');
                    $('#id_visite').val('');
                    $('#select-label').val('planifier').change();
                    $('#id_demande_habilitation').val('');
                }

                function resetModalFormRapport() {
                    $('#etat_locaux_rapport').val('');
                    $('#equipement_rapport').val('');
                    $('#salubrite_rapport').val('');
                    $('#contenu').val('');
                    $('#avis_comite_technique').val('');
                    $('#id_demande_habilitation').val(idddemha);
                }



                // Fonction pour remplir le formulaire du modal avec les détails de l'événement
                function populateModalForm(event) {
                    const formattedDate = formatDateToDDMMYYYY(event.extendedProps.datevisite);
                    //alert(event.extendedProps.timeendr);
                   // alert(formattedDate);
                   // console.log(event);
                    // $('#title').val(event.title);
                    // $('#start-date').val(moment(event.startStr).format('DD/MM/YYYY'));
                    // $('#end-date').val(event.endStr);
                    // $('#event-description-editor').append(event.eventdescriptioneditor);
                    // $('#select-label').val(event.selectlabelStr);
                   // console.log(event)
                    $('#title').val(event.title);
                    let formattedStartDate = moment(event.extendedProps.datevisite).format('YYYY-MM-DD');
                    $('#start-date').val(formattedStartDate);
                    $('#end-date').val(event.extendedProps.timestart);
                    $('#enddateP').val(event.extendedProps.timeend);
                    $('#enddateR').val(event.extendedProps.timeendr);
                    $('#id_visite').val(event.id); // Stocker l'ID dans un champ caché pour une utilisation ultérieure
                    $('#id_demande_habilitation').val(event.extendedProps.iddemandehabilitation);
                    $('#event-description-editor').val(event.extendedProps.eventdescriptioneditor);
                    $("#select-label").val(event.extendedProps.selectlabel);
                }

                // Fonction pour ajouter un nouvel événement
                $('.add-event-btn').on('click', function (e) {
                    e.preventDefault();
                    sendEventRequest('/traitementdemandehabilitation/' + idddemha + '/store/visite', 'POST', 'Événement ajouté avec succès');
                });

                // Fonction pour mettre à jour un événement existant
                $('.update-event-btn').on('click', function (e) {
                    e.preventDefault();
                    var eventId = $('#id_visite').val();
                    sendEventRequest('/traitementdemandehabilitation/' + eventId  + '/update/visite', 'POST', 'Événement mis à jour avec succès');
                });

                // Fonction pour supprimer un événement
                $('.btn-delete-event').on('click', function (e) {
                    e.preventDefault();
                    var eventId = visiteId; // Fonction à implémenter pour obtenir l'ID de l'événement sélectionné
                    sendEventRequest('/calendar/delete/' + eventId, 'POST', 'Événement supprimé avec succès');
                });

                // Fonction pour ajouter un nouvel événement
                $('.add-rapport-btn').on('click', function (e) {
                    e.preventDefault();
                    sendRapportRequest('/traitementdemandehabilitation/' + idddemha + '/rapport/visite', 'POST', 'Événement ajouté avec succès');
                });

                // Fonction générique pour envoyer une requête Ajax
                function sendEventRequest(url, method, successMessage) {
                    $.ajax({
                        url: url,
                        type: method,
                        data: {
                            title: $('#title').val(),
                            iddemandehabilitation: $('#id_demande_habilitation').val(),
                            start: $('#start-date').val(),
                            end: $('#end-date').val(),
                            endfin: $('#enddateP').val(),
                            endfinR: $('#enddateR').val(),
                            eventdescriptioneditor: $('#event-description-editor').val(),
                            selectlabel: $('#select-label').val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            resetModal();  // Réinitialiser le modal
                            $('#add-new-sidebar').modal('hide');
                            calendar.refetchEvents(); // Rafraîchir les événements du calendrier
                            displayMessage('success', successMessage);
                        },
                        error: function (xhr) {
                            var errors = xhr.responseJSON.errors;
                            if (typeof errors === 'object') {
                                displayMessage('error', formatErrors(errors)); // Fonction pour formater les erreurs
                            }else{
                                displayMessage('error', errors);
                            }

                        }
                    });
                }

                function sendRapportRequest(url, method, successMessage) {
                    $.ajax({
                        url: url,
                        type: method,
                        data: {
                            etat_locaux_rapport: $('#etat_locaux_rapport').val(),
                            equipement_rapport: $('#equipement_rapport').val(),
                            salubrite_rapport: $('#salubrite_rapport').val(),
                            contenu: $('#contenu').val(),
                            avis_comite_technique: $('#avis_comite_technique').val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            resetModalRapport();  // Réinitialiser le modal
                            $('#ActiveRapport').modal('hide');
                            window.location.reload();
                            displayMessageRapport('success', successMessage);
                        },
                        error: function (xhr) {
                            var errors = xhr.responseJSON.errors;
                            if (typeof errors === 'object') {
                                displayMessageRapport('error', formatErrors(errors)); // Fonction pour formater les erreurs
                            }else{
                                displayMessageRapport('error', errors);
                            }

                        }
                    });
                }


                // Fonction pour formater la date
                function formatDateToDDMMYYYY(dateStr) {
                    // Convertir la chaîne en objet Date
                    const dateObj = new Date(dateStr);

                    // Vérifier si la date est valide
                    if (isNaN(dateObj.getTime())) {
                        throw new Error('Date invalide');
                    }

                    // Extraire le jour, le mois et l'année
                    const day = String(dateObj.getDate()).padStart(2, '0'); // Ajouter un 0 devant si nécessaire
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Les mois commencent à 0
                    const year = dateObj.getFullYear();

                    // Retourner la date au format jj/mm/aaaa
                    return `${day}/${month}/${year}`;
                }
                // Fonction pour afficher des messages (succès ou erreur)
                function displayMessage(type, message) {
                    //alert(message);
                    if (type === 'success') {
                        suces = $("#success_text")
                        suces.empty();
                        alertBox = suces.append('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') + '">'+message+'</div>')
                    } else {
                        error = $("#error_text")
                        error.empty();
                        alertBox = error.append('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') + '">'+message+'</div>')
                    }

                }

                function displayMessageRapport(type, message) {
                    //alert(message);
                    if (type === 'success') {
                        suces = $("#success_text_rapport")
                        suces.empty();
                        alertBox = suces.append('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') + '">'+message+'</div>')
                    } else {
                        error = $("#error_text_rapport")
                        error.empty();
                        alertBox = error.append('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') + '">'+message+'</div>')
                    }

                }

                // Fonction pour formater les messages d'erreur
                function formatErrors(errors) {
                    var errorMessage = '';
                    $.each(errors, function (key, value) {
                        errorMessage += value + '<br>';
                    });

                    return errorMessage;
                }

            });


        </script>





            <script>


                    $("#flag_ecole_autre_entreprise").select2().val({{old('flag_ecole_autre_entreprise')}});

                    var typentre = $('#flag_ecole_autre_entreprise').val();

                    if (typentre == true) {
                        $("#autorisation_ouverture_ecole_div").show();
                    }else{
                        $("#autorisation_ouverture_ecole_div").hide();
                    }

                    $('#flag_ecole_autre_entreprise').on('change', function (e) {
                        if(e.target.value=='true'){
                            $("#autorisation_ouverture_ecole_div").show();
                        }
                        if(e.target.value=='false'){
                            $("#autorisation_ouverture_ecole_div").hide();
                        }
                    });
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


/*                 formformateur.onsubmit = function(){
                    $("#experience_formateur_val").val(experience_formateur.root.innerHTML);
                 } */


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

/*                 formdivers.onsubmit = function(){
                    $("#materiel_didactique_demande_habilitation_val").val(materiel_didactique_demande_habilitation.root.innerHTML);
                    $("#reference_ci_demande_habilitation_val").val(reference_ci_demande_habilitation.root.innerHTML);
                    $("#autre_activite_demande_habilitation_val").val(autre_activite_demande_habilitation.root.innerHTML);
                 } */


                var quel_financement_intervention_hors_ci = new Quill('#quel_financement_intervention_hors_ci', {
                    theme: 'snow'
                });

                $("#quel_financement_intervention_hors_ci_val").hide();

                var formInterventionHorsCi = document.getElementById("formInterventionHorsCi");


/*                 formInterventionHorsCi.onsubmit = function(){
                    $("#quel_financement_intervention_hors_ci_val").val(quel_financement_intervention_hors_ci.root.innerHTML);
                 } */

                 var commantaire_cs = new Quill('#commantaire_cs', {
                    theme: 'snow'
                });

                $("#commantaire_cs_val").hide();

                var formAttribution = document.getElementById("formAttribution");


/*                 formAttribution.onsubmit = function(){
                    $("#commantaire_cs_val").val(commantaire_cs.root.innerHTML);
                 } */

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
