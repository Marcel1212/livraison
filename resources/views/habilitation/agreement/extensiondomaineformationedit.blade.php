<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;
use App\Helpers\Fonction;


?>

@if(auth()->user()->can('agrementhabilitation-index'))

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
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                                class="nav-link <?php if($idetape==1){ echo "active";} ?>"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-suppressiondomaineformation"
                                aria-controls="navs-top-suppressiondomaineformation"
                                aria-selected="false">
                                Information sur la demande
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link <?php if($idetape==2){ echo "active";} ?>"
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
                        <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} ?>" id="navs-top-suppressiondomaineformation" role="tabpanel">
                            <form method="post" enctype="multipart/form-data" action="{{ route($lien.'.extensiondomaineformationupdate', [\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(1)]) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label> Motif <strong
                                                    style="color:red;">*</strong></label>
                                            <select
                                                class="select2 form-select-sm input-group" required  data-allow-clear="true"
                                                @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation==true)
                                                    disabled
                                                @endif

                                                name="id_motif_autre_demande_habilitation_formation" id="id_motif_autre_demande_habilitation_formation" >
                                                <option value="">Selectionner un motif</option>
                                                @foreach($motifs as $motif)

                                                    <option value="{{$motif->id_motif}}"
                                                            @if(@$autre_demande_habilitation_formation->id_motif_autre_demande_habilitation_formation==@$motif->id_motif)
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
                                            @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation==false)

                                                <div>
                                                    <input type="file" name="piece_autre_demande_habilitation_formation"
                                                           class="form-control form-control-sm" placeholder=""
                                                           value="{{ old('piece_autre_demande_habilitation_formation') }}"/>
                                                </div>
                                            @endif
                                            @isset($autre_demande_habilitation_formation->piece_autre_demande_habilitation_formation)
                                                <div>
                                                    <span class="badge bg-secondary mt-2">
                                                                <a target="_blank"
                                                                   onclick="NewWindow('{{ asset("pieces/demande_suppression_domaine/". $autre_demande_habilitation_formation->piece_autre_demande_habilitation_formation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                    Voir la pièce
                                                                </a>
                                                            </span>
                                                </div>
                                            @endisset
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
                                                      @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation==true)
                                                          disabled
                                                      @endif
                                                      name="commentaire_autre_demande_habilitation_formation"
                                                      id="commentaire_autre_demande_habilitation_formation" rows="7">{{@$autre_demande_habilitation_formation->commentaire_autre_demande_habilitation_formation}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" align="right">
                                    <hr>
                                    <a class="btn btn-sm me-1 btn-outline-secondary waves-effect"
                                       href="/{{$lien }}">
                                        Retour</a>
                                    @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation!=true)

                                    <button type="submit" name="action" value="enregistrer_info_demande"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Modifier
                                    </button>
                                    @endif

                                    <a class="btn btn-sm btn-primary waves-effect"
                                       href="{{route('agrementhabilitation.extensiondomaineformationedit',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(2)])}}">
                                        Suivant</a>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} ?>" id="navs-top-domaineformation" role="tabpanel">

                            <form method="post" enctype="multipart/form-data" action="{{ route($lien.'.extensiondomaineformationupdate', [\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                            @csrf
                                <div class="row">

                                @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation!=true)


                                <div class="col-md-4">
                                    <label class="form-label" for="billings-country">La finalité  <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select-sm input-group @error('id_type_domaine_demande_habilitation')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_type_domaine_demande_habilitation">
                                            <?= $typeDomaineDemandeHabilitationList; ?>
                                    </select>
                                    @error('id_type_domaine_demande_habilitation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="billings-country">Le public  <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select-sm input-group @error('id_type_domaine_demande_habilitation_public')
                                                        error
                                                        @enderror" data-allow-clear="true" name="id_type_domaine_demande_habilitation_public">
                                            <?= $typeDomaineDemandeHabilitationPublicList; ?>
                                    </select>
                                    @error('id_type_domaine_demande_habilitation_public')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
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

                                @endif

                                <div class="col-12" align="right">
                                    <hr>
                                    <a class="btn btn-sm me-1 btn-outline-secondary waves-effect" href="/{{$lien }}">
                                        Retour</a>
                                    <a  href="{{route('agrementhabilitation.extensiondomaineformationedit',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(1)])}}"  class="btn btn-sm btn-secondary me-1">Précédent</a>

                                @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation!=true)

                                    <button type="submit" name="action" value="enregistrer_domaine_demande"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Ajouter
                                    </button>
                                    @endif


                                @if (count($domaine_list_demandes)>0)
                                        <a  href="{{ route($lien.'.extensiondomaineformationedit',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                    @endif


                                </div>
                            </div>
                                                                    </form>
                            <hr>


                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id=""
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Finalité </th>
                                    <th>Public </th>
                                    <th>Domaine de formation </th>
                                    @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation!=true)

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
                                                                                    @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation!= true)

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
                        @if(count($domaine_list_demandes)>0)
                        <div class="tab-pane fade @if($idetape==3) show active  @else disabled @endif" id="navs-top-formateur" role="tabpanel">
                            <form method="post" enctype="multipart/form-data" action="{{ route($lien.'.extensiondomaineformationupdate', [\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(3)]) }}">
                                    @csrf

                            @if(count($domainedemandes)==0)
                                    @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation!=true)

                                    <div class="col-md-12" align="right">
                                    <button value="soumettreDemandeExtension" name="action"
                                        type="submit"
                                        class="btn btn-outline-success"
                                       onclick='javascript:if (!confirm("Voulez-vous soummettre cette demande ?")) return false;'
                                    >
                                        Soumettre la demande d'extension
                                    </button>
                                </div>
                                        @endif

                            @else
                                <div class="col-12" align="right">
                                    <a href="{{ route('formateurs.create') }}" class="btn btn-sm btn-primary waves-effect waves-light" target="_blank">
                                        <i class="menu-icon tf-icons ti ti-plus"></i> Créer un formateur
                                    </a>
                                </div>
                                <br/>
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <div class="alert-body" style="text-align: center">
                                        Ajouter un formateur à chaque domaine, avant de pouvoir soumettre votre demande d'extensoin
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <label class="form-label" for="billings-country">Domaine de formation  <strong style="color:red;">*</strong></label>
                                            <select class="select2 form-select-sm input-group @error('id_domaine_demande_habilitation')
                                                            error
                                                            @enderror" data-allow-clear="true" name="id_domaine_demande_habilitation">
                                                    <?= $domainedemandeList; ?>
                                            </select>
                                            @error('id_domaine_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <label class="form-label" for="billings-country">Mes formateurs  <strong style="color:red;">*</strong></label>
                                            <select class="select2 form-select-sm input-group @error('id_formateurs')
                                                            error
                                                            @enderror" data-allow-clear="true" name="id_formateurs">
                                                    <?= $MesformateursList; ?>
                                            </select>
                                            @error('id_formateurs')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>


                                        <div class="col-12" align="right">
                                            <hr>
                                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                Retour</a>
                                            <a  href="{{ route($lien.'.extensiondomaineformationedit',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(2)])}}"  class="btn btn-sm btn-secondary ms-1">Précédent</a>
                                            @if($autre_demande_habilitation_formation->flag_soumis_demande_habilitation!=true)

                                                <button type="submit" name="action" value="AjouterFormateur"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Ajouter
                                                </button>
                                            @endif

                                        </div>
                                    </div>

                            @endif


                            <hr>
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

                                                                                            @if($autre_demande_habilitation_formation->flag_soumis_autre_demande_habilitation_formation != true)
                                                                                                <a href="{{ route($lien.'.deleteformateursDemandeExtension',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),
\App\Helpers\Crypt::UrlCrypt($formateur->id_formateur_domaine_demande_habilitation)]) }}"
                                                                                                   class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                                                                   title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach

                                </tbody>
                            </table>

                            </form>
                            <div class="col-12" align="right">
                                <hr>
                                <a class="btn btn-sm me-1 btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                                <a  href="{{route('agrementhabilitation.extensiondomaineformationedit',[\App\Helpers\Crypt::UrlCrypt($id),\App\Helpers\Crypt::UrlCrypt($id1),\App\Helpers\Crypt::UrlCrypt(2)])}}"  class="btn btn-sm btn-secondary me-1">Précédent</a>
                            </div>
                        </div>

                        @endif
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

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
