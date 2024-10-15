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

@if(auth()->user()->can('traitementcomitetechniques-edit'))

@extends('layouts.backLayout.designadmin')




@section('content')

    @php($Module='Habilitation')
    @php($titre='Liste des demandes habilitation')
    @php($soustitre='Demande d\'habilitation')
    @php($lien='traitementcomitetechniques')

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
                                Intervention hors du pays et Pieces jointes
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link <?php if($idetape==9 and count($formateurs)>0){ echo "active";} ?>"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-Rpport-visite"
                                aria-controls="navs-top-Rpport-visite"
                                aria-selected="false">
                                    Rapport de visite
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link <?php if($idetape==10 and count($formateurs)>0){ echo "active";} ?>"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-traitement-comite"
                                aria-controls="navs-top-traitement-comite"
                                aria-selected="false">
                                    Traitement comité
                                </button>
                            </li>
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

                                            <div class="col-12" align="right">
                                                <hr>

                                                <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                    Retour</a>
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

                                                        </td>
                                                        </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                        <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>
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

                                                                </td>
                                                            </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                        <div class="col-12" align="right">
                                            <hr>
                                            <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                            <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                Retour</a>
                                        </div>
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

                                                                </td>
                                                            </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                        <div class="col-12" align="right">
                                            <hr>
                                            <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                            <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                Retour</a>
                                        </div>
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

                                                                </td>
                                                            </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                        <div class="col-12" align="right">
                                            <hr>
                                            <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                            <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(6)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                Retour</a>
                                        </div>
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
                                                            <a onclick="NewWindow('{{ route("traitementdemandehabilitation.show",\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                                class=" "
                                                                title="Modifier"><img src='/assets/img/eye-solid.png'></a>

                                                        </td>
                                                    </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="col-12" align="right">
                                    <hr>
                                    <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                    <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(7)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                        Retour</a>
                                </div>
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
                                                    <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(6)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                                    <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(8)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                           </div>

                                </div>
                                <div class="tab-pane fade <?php if($idetape==8 and count($formateurs)>0){ echo "show active";} ?>" id="navs-top-Soumettre" role="tabpanel">
                                    <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-striped table-hover table-sm"
                                        id=""
                                        style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                             <th>No</th>
                                             <th>Types de pieces </th>
                                             <th>Pieces </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($piecesDemandeHabilitations as $piecesDemandeHabilitation)
                                                 <tr>
                                                     <td>{{ $loop->iteration }}</td> <!-- Utilisation de $loop->iteration pour l'incrémentation -->
                                                     <td>{{ $piecesDemandeHabilitation->typesPiece->libelle_types_pieces }}</td>
                                                     <td>
                                                         @if (isset($piecesDemandeHabilitation->pieces_demande_habilitation))
                                                             <span class="badge bg-secondary">
                                                                 <a target="_blank"
                                                                     onclick="NewWindow('{{ asset("/pieces/pieces_demande_habilitation/".$demandehabilitation->entreprise->ncc_entreprises."/". $piecesDemandeHabilitation->pieces_demande_habilitation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                     Voir la pièce
                                                                 </a>
                                                             </span>
                                                         @endif
                                                     </td>
                                                 </tr>
                                             @endforeach

                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="col-md-6">
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

                                                               </td>
                                                           </tr>
                                               @endforeach

                                           </tbody>
                                       </table>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>
                                        <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(7)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                        <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(9)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade <?php if($idetape==9 and count($formateurs)>0){ echo "show active";} ?>" id="navs-top-Rpport-visite" role="tabpanel">
                                    <div class="row">
                                        <div class="col-8">

                                        </div>
                                        <div class="col-4" align="right">
                                                <a onclick="NewWindow('{{ route($lien.".show.ficheanalyse",[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light"
                                                                title="Modifier">Fiche d'analyse</a>

                                        </div>

                                        <br/>
                                        <br/>
                                    </div>

                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                    <label class="form-label" for="billings-country">Materiels pedagogiques <strong style="color:red;">*</strong></label>

                                                    <select class="select2 form-select input-group" data-allow-clear="true" name="flag_materiel_pedagogique" id="flag_materiel_pedagogique">
                                                        <option value="true" @if(@$rapportVisite[0]->flag_materiel_pedagogique == true ) selected @endif>OUI</option>
                                                        <option value="false" @if(@$rapportVisite[0]->flag_materiel_pedagogique == false ) selected @endif>NON</option>
                                                    </select>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                    <label class="form-label" for="billings-country">Salle de formation <strong style="color:red;">*</strong></label>

                                                    <select class="select2 form-select input-group" data-allow-clear="true" name="flag_salle_formation" id="flag_salle_formation">
                                                        <option value="true" @if(@$rapportVisite[0]->flag_salle_formation == true ) selected @endif>OUI</option>
                                                        <option value="false" @if(@$rapportVisite[0]->flag_salle_formation == false ) selected @endif>NON</option>
                                                    </select>
                                            </div>
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
                                        <div class="col-12" align="right">
                                            <hr>
                                            <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(8)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                            <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(10)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                Retour</a>
                                        </div>
                                </div>

                                <div class="tab-pane fade <?php if($idetape==10 and count($formateurs)>0){ echo "show active";} ?>" id="navs-top-traitement-comite" role="tabpanel">
                                    @if ($demandehabilitation->id_charge_habilitation == Auth::user()->id)

                                        <button type="button" class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light Consultercommentairereponse"
                                            data-bs-toggle="modal"
                                            data-id="{{\App\Helpers\Crypt::UrlCrypt($id)}}"
                                            data-id1="{{\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation)}}"
                                            data-id2="{{\App\Helpers\Crypt::UrlCrypt(10)}}"
                                            href="#">
                                                Voir commentaire
                                        </button>
                                    @else
                                        <button type="button" class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light Consultercommentaire"
                                            data-bs-toggle="modal"
                                            data-id="{{\App\Helpers\Crypt::UrlCrypt($id)}}"
                                            data-id1="{{\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation)}}"
                                            data-id2="{{\App\Helpers\Crypt::UrlCrypt(10)}}"
                                            href="#">
                                                Voir commentaire
                                        </button>
                                    @endif
                                    <div id="commentaire_view"></div>
                                    <div id="commentaire_view_all"></div>

                                    @if ($demandehabilitation->id_charge_habilitation != Auth::user()->id)
                                        <?php //dd($traitement);  ?>
                                        @if(count($traitement)==0)

                                            <form method="POST" class="form" action="{{ route($lien.'.update.habilitation', [\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(10)]) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <div class="card card-custom" style="width: 100%" id="divcritere">
                                                        <h2>Critères évaluations</h2>
                                                        <div class="card-body">
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>N°</th>
                                                                        <th>Critère</th>
                                                                        <th>Status</th>
                                                                        <th>Commentaire</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="critere">
                                                                    @foreach($criteres as $critere)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="hidden" name="id_critere_evaluation[{{$critere->id_critere_evaluation}}]" value="{{$critere->id_critere_evaluation}}">
                                                                                {{ $loop->iteration }}
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm" value="{{$critere->libelle_critere_evaluation}}" disabled>
                                                                            </td>
                                                                            <td>
                                                                                <select class="select2 form-select" name="flag_traitement_par_critere_commentaire[{{$critere->id_critere_evaluation}}]" onchange="checkObligation(this, {{$critere->id_critere_evaluation}})">
                                                                                    <option value="">-------</option>
                                                                                    <option value="true">D'accord</option>
                                                                                    <option value="false">Pas d'accord</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <textarea class="form-control form-control-sm" name="commentaire_critere[{{$critere->id_critere_evaluation}}]" id="commentaire_{{$critere->id_critere_evaluation}}" rows="6"></textarea>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>



                                                    <div class="col-12" align="right">
                                                    <hr>
                                                    <button type="submit" name="action" value="Traiter_action_formation_valider_critere" class="btn btn-sm btn-success me-3 btn-submit" onclick="return confirm('Voulez-vous Traiter cette demande ?')">Valider</button>

                                                    <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(9)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                            </form>

                                        @else

                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <div class="alert-body" style="text-align: center;">
                                                    Vous avez déjà traité ce dossier
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>

                                            <div class="col-12" align="right">
                                                <hr>

                                                <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(9)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                    Retour</a>
                                            </div>

                                        @endif

                                    @else


                                    <div class="col-12" align="right">
                                        <hr>

                                        <a  href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(9)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>

                                    @endif


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
            function checkObligation(select, id) {
                const commentaire = document.getElementById('commentaire_' + id);
                if (select.value === "false") {
                    commentaire.required = true;
                } else {
                    commentaire.required = false;
                }
            }

            $(document).on('click', '.Consultercommentairereponse', function () {
                var id = $(this).data('id');      // Récupère data-id
                var id1 = $(this).data('id1');    // Récupère data-id1
                var id2 = $(this).data('id2');    // Récupère data-id2
                $.get("{{ url('/') }}/page-commentaire-comite-technique/" + id +"/"+ id1 +"/"+ id2, function (data) {
                    $('#commentaire_view').html(data);
                });
            });

            $(document).on('click', '.Consultercommentaire', function () {
               // alert('alluser')
                var id = $(this).data('id');      // Récupère data-id
                var id1 = $(this).data('id1');    // Récupère data-id1
                var id2 = $(this).data('id2');    // Récupère data-id2
                $.get("{{ url('/') }}/page-commentaire-all-comite-technique/" + id +"/"+ id1 +"/"+ id2, function (data) {
                    $('#commentaire_view_all').html(data);
                });
            });



        </script>

        <script>

    var idddemha;
    var idddemha = $('#idddemha').val();




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
