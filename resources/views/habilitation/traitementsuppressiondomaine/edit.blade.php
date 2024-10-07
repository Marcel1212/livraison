<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;
use App\Helpers\Menu;

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


                        <div class="col-xl-12">
                            <div align="right" class="mb-2">
                                <button type="button"
                                        class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#modalToggle">
                                    Voir le parcours de validation
                                </button>
                            </div>
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
{{--                            <li class="nav-item">--}}
{{--                                <button--}}
{{--                                type="button"--}}
{{--                                class="nav-link"--}}
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
                                        class="nav-link active"
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
                                </div>
{{--                                <div class="tab-pane fade" id="navs-top-domaineformation" role="tabpanel">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            <label class="form-label" for="billings-country">La finalité  <strong style="color:red;">*</strong></label>--}}
{{--                                            <select disabled class="select2 input-group @error('id_type_domaine_demande_habilitation')--}}
{{--                                                        error--}}
{{--                                                        @enderror" data-allow-clear="true" name="id_type_domaine_demande_habilitation">--}}
{{--                                                    <?= $typedomaine; ?>--}}
{{--                                            </select>--}}
{{--                                            @error('id_type_domaine_demande_habilitation')--}}
{{--                                            <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-4">--}}
{{--                                            <label class="form-label" for="billings-country">Le public  <strong style="color:red;">*</strong></label>--}}
{{--                                            <select disabled class="select2 form-select-sm input-group @error('id_type_domaine_demande_habilitation_public')--}}
{{--                                                        error--}}
{{--                                                        @enderror" data-allow-clear="true" name="id_type_domaine_demande_habilitation_public">--}}
{{--                                                    <?= $typedomainepublic; ?>--}}
{{--                                            </select>--}}
{{--                                            @error('id_type_domaine_demande_habilitation_public')--}}
{{--                                            <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-4">--}}
{{--                                            <label class="form-label" for="billings-country">Domaine de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <select disabled class="select2 form-select-sm input-group @error('id_domaine_formation')--}}
{{--                                                        error--}}
{{--                                                        @enderror" data-allow-clear="true" name="id_domaine_formation">--}}
{{--                                                    <?= $domaine; ?>--}}

{{--                                            </select>--}}
{{--                                            @error('id_domaine_formation')--}}
{{--                                            <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row mt-4">--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <h5 class="mb-0">Liste des formateurs associés au domaine</h5>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-12">--}}
{{--                                            <table class="table table-bordered table-striped table-hover table-sm"--}}
{{--                                                   id=""--}}
{{--                                                   style="margin-top: 13px !important">--}}
{{--                                                <thead>--}}
{{--                                                <tr>--}}
{{--                                                    <th>No</th>--}}
{{--                                                    <th>Nom et prénom </th>--}}
{{--                                                    <th>Année d'experience </th>--}}
{{--                                                    <th>Cv  </th>--}}
{{--                                                    <th>Lettre d'engagement </th>--}}
{{--                                                </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody>--}}
{{--                                                    <?php $i = 0; ?>--}}
{{--                                                @isset($domaineH->formateurDomaineDemandeHabilitations)--}}
{{--                                                    @foreach ($domaineH->formateurDomaineDemandeHabilitations as $key => $formateur)--}}
{{--                                                            <?php $i += 1;?>--}}
{{--                                                        <tr>--}}
{{--                                                            <td>{{ $i }}</td>--}}
{{--                                                            <td>{{ $formateur->nom_formateur }} {{ $formateur->prenom_formateur }}</td>--}}
{{--                                                            <td>--}}
{{--                                                                    <?php--}}
{{--                                                                    if(isset($formateur->date_fin_formateur)){--}}
{{--                                                                        $datedebut = \Carbon\Carbon::parse($formateur->date_debut_formateur);--}}
{{--                                                                        $datefin = \Carbon\Carbon::parse($formateur->date_fin_formateur);--}}

{{--                                                                        $anneexperience = $datedebut->diffInYears($datefin);--}}
{{--                                                                    }else {--}}
{{--                                                                        $datedebut = \Carbon\Carbon::parse($formateur->date_debut_formateur);--}}
{{--                                                                        $datefin = \Carbon\Carbon::now();--}}

{{--                                                                        $anneexperience = $datedebut->diffInYears($datefin);--}}
{{--                                                                    }--}}

{{--                                                                    echo $anneexperience;--}}
{{--                                                                    ?>--}}
{{--                                                            </td>--}}
{{--                                                            <td>--}}
{{--                                                                        <span class="badge bg-secondary">--}}
{{--                                                                            <a target="_blank"--}}
{{--                                                                               onclick="NewWindow('{{ asset("/pieces/cv_formateur/". $formateur->cv_formateur)}}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                                                Voir la pièce--}}
{{--                                                                            </a>--}}
{{--                                                                        </span>--}}
{{--                                                            </td>--}}
{{--                                                            <td>--}}
{{--                                                                        <span class="badge bg-secondary">--}}
{{--                                                                            <a target="_blank"--}}
{{--                                                                               onclick="NewWindow('{{ asset("/pieces/le_formateur/". $formateur->le_formateur)}}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                                                Voir la pièce--}}
{{--                                                                            </a>--}}
{{--                                                                        </span>--}}
{{--                                                            </td>--}}
{{--                                                        </tr>--}}
{{--                                                    @endforeach--}}
{{--                                                @endisset--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="tab-pane fade show active" id="navs-top-traitement" role="tabpanel">
                                    <div class="row">
                                        <h6>Information sur la demande de suppression </h6>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                    <label> Domaines de formation <strong
                                                            style="color:red;">*</strong></label>
                                                    <select
                                                        class="select2 form-control form-select-sm input-group"
                                                        disabled
                                                        required multiple  data-allow-clear="true" name="id_domaine_demande_habilitation[]" id="id_domaine_demande_habilitation" >
                                                        @foreach($domaineDemandeHabilitations as $domaineDemandeHabilitation)
                                                            <option value="{{$domaineDemandeHabilitation->id_domaine_demande_habilitation}}"

                                                                    @foreach($domainedemandesuppression->domaineDemandeSuppressionHabilitations as $domaine)
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
                                                        disabled

                                                        name="id_motif_demande_suppression_habilitation" id="id_motif_demande_suppression_habilitation" >
                                                        <option value="">Selectionner un motif</option>
                                                        @foreach($motifs as $motif)

                                                            <option value="{{$motif->id_motif}}"
                                                                    @if(@$domainedemandesuppression->id_motif_demande_suppression_habilitation==@$motif->id_motif)
                                                                        selected
                                                                @endif >{{$motif->libelle_motif}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <label class="form-label">Pièce justificative <strong
                                                        style="color:red;">*</strong></label>
                                                <div>
                                                    <span class="badge bg-secondary mt-2">
                                                                <a target="_blank"
                                                                   onclick="NewWindow('{{ asset("pieces/demande_suppression_domaine/". $domainedemandesuppression->piece_demande_suppression_habilitation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                    Voir la pièce
                                                                </a>
                                                            </span>
                                                </div>

                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>

                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire de la demande de suppression <strong
                                                            style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm" disabled required

                                                              name="commentaire_demande_suppression_habilitation"
                                                              id="commentaire_demande_suppression_habilitation" rows="7">{{@$domainedemandesuppression->commentaire_demande_suppression_habilitation}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                                <div class="row">
                                                    <h6 class="mt-5">Traitement la demande de suppression </h6>
                                                            <div class="row">
                                                                    <div class="col-md-12">
                                                                        <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($domainedemandesuppression->id_demande_suppression_habilitation)) }}" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('put')
                                                                            <div class="row">
                                                                                <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id_combi_proc) }}"/>
                                                                                <div class="col-md-12 col-12">
                                                                                    <div class="mb-1">
                                                                                        <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>
                                                                                        @if($parcoursexist->count()<1)
                                                                                            <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                                                                        @else
                                                                                            <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12" align="right">
                                                                                    <hr>
                                                                                        <?php if(count($parcoursexist)<1){?>
                                                                                    <button type="submit" name="action" value="Valider"
                                                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                                                                        Valider
                                                                                    </button>
                                                                                    <button type="submit" name="action" value="Rejeter"
                                                                                            class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                                                                        Rejeter
                                                                                    </button>
                                                                                    <?php } ?>
                                                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                                                       href="/{{$lien }}">
                                                                                        Retour</a>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                            </div>
                                                </div>
                                            </div>

                            </div>
                        </div>
                    </div>
                </div>
    <div class="col-md-4 col-12">
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
                        <h5 class="card-header">Parcours de validation du projet d'étude</h5>
                        <div class="card-body pb-2">
                            <ul class="timeline pt-3">
                                @foreach ($ResultProssesList as $res)
                                    <li class="timeline-item pb-4 timeline-item-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                        <div class="timeline-event">
                                            <div class="timeline-header border-bottom mb-3">
                                                <h6 class="mb-0">{{ $res->priorite_combi_proc }}</h6>
                                                <span class="text-muted"><strong>{{ $res->name }}</strong></span>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                <div class="d-flex align-items-center">
                                                    @if($res->is_valide==true)
                                                        <div class="row ">
                                                            <div>
                                                                <span>Observation : {{ $res->comment_parcours }}</span>
                                                            </div>
                                                            <div>
                                                                <span>Validé le  {{ $res->date_valide }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($res->is_valide===false)
                                                        <div class="row">
                                                            <div>
                                                                <span>Observation : {{ $res->comment_parcours }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="badge bg-label-danger">Validé le {{ $res->date_valide }}</span>
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
