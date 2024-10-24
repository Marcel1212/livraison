<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;
use App\Helpers\Fonction;


?>

{{--@if(auth()->user()->can('cahierautredemandehabilitations-create'))--}}

    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Habilitation')
        @php($titre='Liste des demandes habilitation')
        @php($soustitre='Demande d\'habilitation')
        @php($lien='cahierautredemandehabilitations')

        <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
        </h5>
        @if($autre_demande_habilitation_formation->flag_rejeter_recevabilit_suppression_habilitation == true)
            <div align="right " class="mb-2">
                <button type="button"
                        class="btn rounded-pill btn-outline-danger btn-sm waves-effect waves-light"
                        data-bs-toggle="modal" data-bs-target="#modalToggleCommentaireplan">
                    Voir les commentaire de la non recevabilité
                </button>
            </div>
        @endif
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
                                aria-selected="false">
                                Information sur la demande
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link <?php if($idetape==3){ echo "active";} ?>"
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
                                class="nav-link @if(count($domaine_list_demandes)>0) @if($idetape==3) active @endif @else disabled @endif"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-formateur"
                                aria-controls="navs-top-formateur"
                                aria-selected="false">
                                Formateur
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-top-informationentreprise" role="tabpanel">
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
                        <div class="tab-pane fade <?php if($idetape==2){ echo "show active";}  ?>" id="navs-top-informationdemande" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label> Type de demande</label>
                                        <input class="form-control" type="text" disabled
                                               @if(@$autre_demande_habilitation_formation->type_autre_demande=='demande_suppression')
                                                   value=" Demande de suppression"
                                               @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                   value=" Demande d'extension"

                                            @endif >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label> Motif <strong
                                                style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select-sm input-group" required  data-allow-clear="true"
                                            disabled
                                            name="id_motif_autre_demande_habilitation_formation" id="id_motif_autre_demande_habilitation_formation" >
                                            @foreach($motifs as $motif)

                                                <option value="{{$motif->id_motif}}"
                                                        @if(@$autre_demande_habilitation_formation->id_motif_autre_demande_habilitation_formation==@$motif->id_motif)
                                                            selected
                                                    @endif >{{$motif->libelle_motif}}</option>

                                            @endforeach                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label">Pièce justificative <strong
                                            style="color:red;">*</strong></label>
                                    <div>
                                        <div>
                                                    <span class="badge bg-secondary mt-2">
                                                                <a target="_blank"
                                                                   onclick="NewWindow('{{ asset("pieces/demande_suppression_domaine/". $autre_demande_habilitation_formation->piece_autre_demande_habilitation_formation)}}','',screen.width/2,screen.height,'yes','center',1);">
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
                                                  name="commentaire_autre_demande_habilitation_formation"
                                                  id="commentaire_autre_demande_habilitation_formation" rows="7">{{@$autre_demande_habilitation_formation->commentaire_autre_demande_habilitation_formation}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade <?php if($idetape==3){ echo "show active";} ?>" id="navs-top-domaineformation" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id=""
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
                                @foreach ($domaine_list_demandes as $key => $domainecahierautredemandehabilitations)
                                        <?php $i += 1;?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $domainecahierautredemandehabilitations->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}</td>
                                        <td>{{ $domainecahierautredemandehabilitations->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }}</td>
                                        <td>{{ $domainecahierautredemandehabilitations->domaineFormation->libelle_domaine_formation }}</td>
                                        @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation!= true)

                                            <td>
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                            <div class="tab-pane fade @if($idetape==3) show active  @else disabled @endif" id="navs-top-formateur" role="tabpanel">
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
                        <div class="tab-pane fade @if($idetape==4) show active  @else disabled @endif" id="navs-top-traitement" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <label>Observation</label>
                                        <textarea rows="5" class="form-control" disabled>@isset($autre_demande_habilitation_formation->observation_instruction){{$autre_demande_habilitation_formation->observation_instruction}} @endisset</textarea>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- END: Content-->
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
    @endsection

    @section('js_perso')
    @endsection

{{--@else--}}
{{--    <script type="text/javascript">--}}
{{--        window.location = "{{ url('/403') }}";//here double curly bracket--}}
{{--    </script>--}}
{{--@endif--}}
