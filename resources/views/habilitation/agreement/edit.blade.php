<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;
use App\Helpers\Fonction;


?>

@if(auth()->user()->can('agrementhabilitation-edit'))

    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Habilitation')
        @php($titre='Liste des demandes habilitation')
        @php($soustitre='Demande d\'habilitation')
        @php($lien='agrementhabilitation')

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
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-substitution"
                                aria-controls="navs-top-substitution"
                                aria-selected="false">
                                Demande Substitution / Suppression / Extension
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-top-substitution" role="tabpanel">
                            <div class="d-flex align-items-end justify-content-end">
                                <div class="btn-group float-end mb-2">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Nouvelle demande
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="{{route($lien.'.substitutiondomaineformation',[\App\Helpers\Crypt::UrlCrypt($habilitation->id_demande_habilitation)])}}">Substitution domaine de formation</a></li>
                                        <li><a class="dropdown-item" href="{{route($lien.'.extensiondomaineformation',[\App\Helpers\Crypt::UrlCrypt($habilitation->id_demande_habilitation)])}}">Extension domaine de formation</a></li>
                                        <li><a class="dropdown-item" href="{{route($lien.'.suppressiondomaineformation',[\App\Helpers\Crypt::UrlCrypt($habilitation->id_demande_habilitation)])}}">Suppression domaine de formation</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="">
                                <table class="table table-bordered table-striped table-hover table-sm"
                                       id="exampleData"
                                       style="margin-top: 13px !important">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code de la demande</th>
                                        <th>Type de demande</th>
                                        <th>Motif de la demande</th>
                                        <th>Commentaire de la demande</th>
                                        <th>Pièce justificatif  </th>
                                        <th>Date de soumission</th>
                                        <th>Statut </th>
                                        <th>Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                    @isset($autre_demande_habilitation_formations)
                                        @foreach (@$autre_demande_habilitation_formations as $key => $autre_demande_habilitation_formation)
                                                <?php $i += 1;?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{@$autre_demande_habilitation_formation->code_autre_demande_habilitation_formation}}</td>
                                                <td>
                                                    @if(@$autre_demande_habilitation_formation->type_autre_demande=='demande_suppression')
                                                        Demande de suppression
                                                    @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                        Demande d'extension
                                                    @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_substitution')
                                                        Demande d'extension
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(@$autre_demande_habilitation_formation->motif)
                                                        {{ $autre_demande_habilitation_formation->motif->libelle_motif }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(@$autre_demande_habilitation_formation->commentaire_autre_demande_habilitation_formation)
                                                        {{ $autre_demande_habilitation_formation->commentaire_autre_demande_habilitation_formation }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @isset($autre_demande_habilitation_formation->piece_autre_demande_habilitation_formation)
                                                        <span class="badge bg-secondary mt-2">
                                                                <a target="_blank" class="text-white"
                                                                   onclick="NewWindow('{{ asset("pieces/demande_suppression_domaine/". $autre_demande_habilitation_formation->piece_autre_demande_habilitation_formation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                    Voir la pièce
                                                                </a>
                                                            </span>
                                                    @endisset
                                                </td>
                                                <td>
                                                    @isset($autre_demande_habilitation_formation->date_soumis_autre_demande_habilitation_formation)
                                                        {{ date('d/m/Y H:i:s',strtotime(@$autre_demande_habilitation_formation->date_soumis_autre_demande_habilitation_formation))  }}
                                                    @endisset
                                                </td>
                                                <td>
                                                    @if($autre_demande_habilitation_formation->flag_enregistrer_autre_demande_habilitation_formation==true &&
$autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation==false && (!isset($autre_demande_habilitation_formation->id_charge_habilitation) or $autre_demande_habilitation_formation->flag_recevabilite==false)

&& $autre_demande_habilitation_formation->flag_validation_domaine_autre_demande_habilitation_formation==false && $autre_demande_habilitation_formation->flag_rejeter_autre_demande_habilitation_formation==false

)
                                                        <span class="badge bg-secondary">Non soumis</span>
                                                    @elseif($autre_demande_habilitation_formation->flag_enregistrer_autre_demande_habilitation_formation==true &&

$autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation==true && !isset($autre_demande_habilitation_formation->id_charge_habilitation)
&& $autre_demande_habilitation_formation->flag_validation_autre_demande_habilitation_formation==false && $autre_demande_habilitation_formation->flag_rejeter_autre_demande_habilitation_formation==false
)
                                                        <span class="badge bg-primary">soumis</span>
                                                    @elseif($autre_demande_habilitation_formation->flag_enregistrer_autre_demande_habilitation_formation==true &&

$autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation==true && isset($autre_demande_habilitation_formation->id_charge_habilitation)
&& $autre_demande_habilitation_formation->flag_validation_autre_demande_habilitation_formation==false && $autre_demande_habilitation_formation->flag_rejeter_autre_demande_habilitation_formation==false
)
                                                        <span class="badge bg-primary">En cours de traitement</span>
                                                    @elseif($autre_demande_habilitation_formation->flag_enregistrer_autre_demande_habilitation_formation==true &&

$autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation==true && isset($autre_demande_habilitation_formation->id_charge_habilitation)
&& $autre_demande_habilitation_formation->flag_validation_autre_demande_habilitation_formation==true && $autre_demande_habilitation_formation->flag_rejeter_autre_demande_habilitation_formation==false)
                                                        <span class="badge bg-success">Validé</span>
                                                    @elseif($autre_demande_habilitation_formation->flag_enregistrer_autre_demande_habilitation_formation==true &&

$autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation==true && isset($autre_demande_habilitation_formation->id_charge_habilitation)
&& $autre_demande_habilitation_formation->flag_validation_autre_demande_habilitation_formation==false && $autre_demande_habilitation_formation->flag_rejeter_autre_demande_habilitation_formation==true)
                                                        <span class="badge bg-success">Rejeté</span>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    @can($lien.'-edit')

                                                        @if($autre_demande_habilitation_formation->type_autre_demande=='demande_suppression')
                                                            <a href="{{ route($lien.'.suppressiondomaineformationedit',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                               class=" "
                                                               title="Modifier"><img
                                                                    src='/assets/img/editing.png'></a>
                                                        @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                            <a href="{{ route($lien.'.extensiondomaineformationedit',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                               class=" "
                                                               title="Modifier"><img
                                                                    src='/assets/img/editing.png'></a>
                                                        @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_substitution')
                                                            <a href="{{ route($lien.'.substitutiondomaineformationedit',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_demande_habilitation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                               class=" "
                                                               title="Modifier"><img
                                                                    src='/assets/img/editing.png'></a>
                                                        @endif

                                                    @endcan
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
                                class="nav-link <?php if( $idetape==2 and isset($habilitation) ){ echo "active";} ?>"
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
                                class="nav-link active"
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
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link <?php if($idetape==8 and count($formateurs)>0){ echo "active";} ?>"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-piece"
                                aria-controls="navs-top-piece"
                                aria-selected="false">
                                Pièces
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="navs-top-informationentreprise" role="tabpanel">
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
                                                   class="form-control form-control-sm"  value="{{ $habilitation->nom_responsable_demande_habilitation }}">
                                        </div>
                                        @error('nom_responsable_demande_habilitation')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Fonction du responsable  <strong style="color:red;">*</strong> </label>
                                            <input disabled type="text" name="fonction_demande_habilitation" id="fonction_demande_habilitation"
                                                   class="form-control form-control-sm"  value="{{ $habilitation->fonction_demande_habilitation }}">
                                        </div>
                                        @error('fonction_demande_habilitation')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Email professionnel du responsable  <strong style="color:red;">*</strong> </label>
                                            <input disabled type="text" name="email_responsable_habilitation" id="email_responsable_habilitation"
                                                   class="form-control form-control-sm"  value="{{ $habilitation->email_responsable_habilitation }}">
                                        </div>
                                        @error('email_responsable_habilitation')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Contact du responsable  <strong style="color:red;">*</strong> </label>
                                            <input disabled type="text" name="contact_responsable_habilitation" id="contact_responsable_habilitation"
                                                   class="form-control form-control-sm"  value="{{ $habilitation->contact_responsable_habilitation }}">
                                        </div>
                                        @error('contact_responsable_habilitation')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <label class="form-label" for="billings-country">Titre ou Contrat de bail <strong style="color:red;">*</strong></label>
                                        <br>
                                            <span class="badge bg-secondary">
                                                        <a target="_blank"
                                                           onclick="NewWindow('{{ asset("/pieces/titre_propriete_contrat_bail/". $habilitation->titre_propriete_contrat_bail)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce
                                                        </a>
                                                    </span>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Maison mere ou tutelle <strong style="color:red;">(s'il y a lieu)</strong> </label>
                                            <input disabled type="text" name="maison_mere_demande_habilitation" id="maison_mere_demande_habilitation"
                                                   class="form-control form-control-sm" value="{{ $habilitation->maison_mere_demande_habilitation }}"/>
                                        </div>
                                        @error('maison_mere_demande_habilitation')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="billings-country">Agence domiciliation <strong style="color:red;">*</strong></label>
                                        <select disabled class="select2 form-select-sm input-group @error('id_banque')
                                                    error
                                                    @enderror" data-allow-clear="true" name="id_banque">
                                                <?= $banque; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <label class="form-label" for="billings-country">Type entreprise <strong style="color:red;">*</strong></label>
                                        <select disabled class="select2 form-select-sm input-group @error('flag_ecole_autre_entreprise')
                                                    error
                                                    @enderror" data-allow-clear="true" name="flag_ecole_autre_entreprise" id="flag_ecole_autre_entreprise">
                                            <option value="">---Choix du type entreprise--</option>
                                            <option value="true" @if($habilitation->flag_ecole_autre_entreprise == true ) selected @endif>Ecoles</option>
                                            <option value="false" @if($habilitation->flag_ecole_autre_entreprise == false ) selected @endif>Autres</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane fade <?php if($idetape==2 and isset($habilitation)){ echo "show active";} ?>" id="navs-top-moyenpermanente" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id=""
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Moyen permanente </th>
                                    <th>Nombre</th>
                                    <th>Capacite d'acceuil</th>
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
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                @foreach ($interventions as $key => $intervention)
                                        <?php $i += 1;?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $intervention->typeIntervention->libelle_type_intervention }}</td>
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
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                @foreach ($organisations as $key => $organisation)
                                        <?php $i += 1;?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $organisation->typeOrganisationFormation->libelle_type_organisation_formation }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade show active" id="navs-top-domaineformation" role="tabpanel">

                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id="exampleData"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Finalité </th>
                                    <th>Public </th>
                                    <th>Domaine de formation </th>
                                    <th>Statut</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                @foreach ($domaineDemandeHabilitations as $key => $domaineDemandeHabilitation)
                                        <?php $i += 1;?>
                                    @if($domaineDemandeHabilitation->flag_agree_domaine_demande_habilitation==true or
$domaineDemandeHabilitation->flag_extension_domaine_demande_habilitation==false)


                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}</td>
                                            <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }}</td>
                                            <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}</td>
                                            <td>
                                                @if($domaineDemandeHabilitation->flag_agree_domaine_demande_habilitation==true)
                                                    <span class="badge bg-success">Valide</span>

                                                @elseif($domaineDemandeHabilitation->flag_agree_domaine_demande_habilitation==false &&
                                               $domaineDemandeHabilitation->flag_extension_domaine_demande_habilitation==false)
                                                    <span class="badge bg-danger">Supprimée</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif

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
                                    <th>Fonction </th>
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
                                        <td>{{ $formateur->formateur->fonction_formateurs }} </td>
                                        <td>{{   Fonction::calculerAnneesExperience($formateur->id_formateurs)  }}</td>
                                        <td>
                                            <a onclick="NewWindow('{{ route($lien.".showformateur",\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                               class=" "
                                               title="Modifier"><img src='/assets/img/eye-solid.png'></a>
                                            <a onclick="NewWindow('{{ asset("/pieces/pieces_formateur/".$habilitation->entreprise->ncc_entreprises."_".$formateur->nom_formateurs."_".$formateur->prenom_formateurs."/".$formateur->pieces_formateur)}}','',screen.width/2,screen.height,'yes','center',1);" target="_blank"
                                               class=" "
                                               title="Modifier"><img src='/assets/img/display.png'></a>

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade <?php if($idetape==7 and count($formateurs)>0){ echo "show active";} ?>" id="navs-top-divers" role="tabpanel">
                                <div class="row">
                                    <table class="table table-bordered table-striped table-hover table-sm"
                                           id=""
                                           style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Editez vous un catalogue de stage</th>
                                            <th>La formation est-elle la seule activite de l'organisme ?  </th>
                                            <th>Materiel didactique </th>
                                            <th>Reference en cote d'ivoire (au cours des deux derniers années)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>
                                                    @if($habilitation->information_catalogue_demande_habilitation == false )
                                                        Non
                                                        @else
                                                        Oui
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($habilitation->information_seul_activite_demande_habilitation == false )
                                                        Non
                                                    @else
                                                        Oui
                                                    @endif
                                                </td>

                                                <td>
                                                    {!!@$habilitation->materiel_didactique_demande_habilitation!!}
                                                </td>

                                                <td>
                                                    {!!@$habilitation->reference_ci_demande_habilitation!!}
                                                </td>

                                            </tr>


                                        </tbody>
                                    </table>
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
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade <?php if($idetape==9){ echo "show active";} ?>" id="navs-top-piece" role="tabpanel">

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
                                                                       onclick="NewWindow('{{ asset("/pieces/pieces_demande_habilitation/".$habilitation->entreprise->ncc_entreprises."/". $piecesDemandeHabilitation->pieces_demande_habilitation)}}','',screen.width/2,screen.height,'yes','center',1);">
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
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="SoummissionagrementhabilitationApprouve1"
            tabindex="-1"
            aria-labelledby="SoummissionagrementhabilitationApprouve"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="SoummissionagrementhabilitationApprouve">Soumission de la demande d'habiliation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                    <?php
                                    $message = "Je soussigné(e) <strong>$habilitation->nom_responsable_demande_habilitation</strong>, ".@$habilitation->fonction_demande_habilitation.", atteste l'exactitude des informations contenue dans ce document.

                                                        En cochant sur la mention <strong>Lu et approuvé</strong> ci-dessous, j'atteste cela.";
                                    ?>
                                    <?php echo wordwrap($message,144,"<br>\n"); ?>


                            </p>

                        </div>
                        <div class="modal-footer">



                            <input type="checkbox" class="form-check-input" name="is_valide" id="colorCheck1" onclick="myFunctionMAJ()">
                            <label>Lu et approuvé </label>
                            <button class="btn btn-success me-sm-3 me-1 btn-submit" type="submit" name="action" value="Enregistrer_soumettre_demande_habilitation" id="Enregistrer_soumettre_demande_habilitation" disabled>Valider la demande d'habilitation</button>

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
