<?php

use Carbon\Carbon;
use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;
use App\Helpers\ListeDemandeHabilitationSoumis;
use App\Helpers\Fonction;


$response = Fonction::calculerAnneesExperience5ans($formateur->id_formateurs);


?>

@if(auth()->user()->can('demandehabilitation-edit'))


@extends('layouts.backLayout.designadmin')
<style>
    .tooltip {
        position: relative;
        cursor: pointer;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 1000PX;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 100%;
        left: 50%;
        margin-left: -100px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>

@section('content')

    @php($Module='Formateurs')
    @php($titre='Liste des formateurs')
    @php($soustitre='Modifier un formateur')
    @php($lien='formateurs')

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
                                    data-bs-target="#navs-top-formateur"
                                    aria-controls="navs-top-formateur"
                                    aria-selected="true">
                                        Informations sur le formateur
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link <?php if( $idetape==2  ){ echo "active";} ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-qualification"
                                    aria-controls="navs-top-qualification"
                                    aria-selected="false">
                                     Principale qualification
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link <?php if( $idetape==3 and isset($qualification) ){ echo "active";} ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-education"
                                    aria-controls="navs-top-education"
                                    aria-selected="false">
                                        Formations / Education
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link <?php if( $idetape==4  and count($formations)>0 ){ echo "active";} ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-experiences"
                                    aria-controls="navs-top-experiences"
                                    aria-selected="false">
                                        Experiences
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link <?php if( $idetape==5  and count($experiences)>0 ){ echo "active";} ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-competences"
                                    aria-controls="navs-top-competences"
                                    aria-selected="false">
                                        Competences
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link <?php if( $idetape==6 and count($competences)>0 ){ echo "active";} ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-langues"
                                    aria-controls="navs-top-langues"
                                    aria-selected="false">
                                        Langues
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link <?php if( $idetape==7 and count($languesformateurs)>0  ){ echo "active";} ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-autre-fin"
                                    aria-controls="navs-top-autre-fin"
                                    aria-selected="false">
                                        Autres et fin
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane fade <?php if($idetape==1){ echo "show active";}  ?>" id="navs-top-formateur" role="tabpanel">
									<form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                        @csrf
                                       @method('put')
                                       <div class="row">



                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Nom <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="nom_formateurs" id="nom_formateurs"
                                                       class="form-control form-control-sm" value="{{ $formateur->nom_formateurs }}"/>
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Prenom <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="prenom_formateurs" id="prenom_formateurs"
                                                       class="form-control form-control-sm" value="{{ $formateur->prenom_formateurs }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Contact <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="contact_formateurs" id="contact_formateurs"
                                                       class="form-control form-control-sm" value="{{ $formateur->contact_formateurs }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Second Contact</label>
                                                   <input type="text" name="contact2_formateurs" id="contact2_formateurs"
                                                       class="form-control form-control-sm"  value="{{ $formateur->contact2_formateurs }}"/>
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Email <strong style="color:red;">*</strong></label>
                                                   <input type="email" name="email_formateurs" id="email_formateurs"
                                                       class="form-control form-control-sm" value="{{ $formateur->email_formateurs }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Fonction <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="fonction_formateurs" id="fonction_formateurs"
                                                       class="form-control form-control-sm" value="{{ $formateur->fonction_formateurs }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Date de naissance <strong style="color:red;">*</strong></label>
                                                   <input type="date" name="date_de_naissance" id="date_de_naissance"
                                                       class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($formateur->date_de_naissance)->format('Y-m-d') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Date de recrutement <strong style="color:red;">*</strong></label>
                                                    <input type="date" name="date_de_recrutement" id="date_de_recrutement"
                                                        class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($formateur->date_de_recrutement)->format('Y-m-d') }}" />
                                                </div>
                                            </div>


                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label class="form-label" for="billings-country">Nationalite</label>
                                                   <select class="select2 form-select-sm input-group" data-allow-clear="true" name="id_pays" id="id_pays" required>
                                                       <?= $pay; ?>
                                                   </select>
                                               </div>
                                           </div>


                                           <div class="col-12" align="right">
                                               <hr>
                                               <?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                                   <button type="submit" name="action" value="Modifier"
                                                           class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                           Modifier
                                                   </button>
                                               <?php //} ?>


                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                                               <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                   Retour</a>
                                           </div>
                                       </div>
                                   </form>
                                </div>

                                <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} ?>" id="navs-top-qualification" role="tabpanel">
									<form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                        @csrf
                                       @method('put')
                                       <div class="row">



                                           <div class="col-md-12 col-12">
                                               <div class="mb-1">
                                                   <label>Principales qualifications: <strong style="color:red;">*</strong></label>
                                                   <textarea class="form-control" id="principale_qualification_libelle" name="principale_qualification_libelle" rows="4" cols="3">{{ @$qualification->principale_qualification_libelle }}</textarea>

                                               </div>
                                           </div>




                                           <div class="col-12" align="right">
                                               <hr>

                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                               <?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                                    @if(!isset($qualification))
                                                        <button type="submit" name="action" value="AjouterQualification"
                                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                                Ajouter
                                                        </button>
                                                    @else
                                                        <button type="submit" name="action" value="MiseAJourQualification"
                                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                                Mise a jour
                                                        </button>
                                                    @endif
                                               <?php //} ?>

                                               @if(isset($qualification))
                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                               @endif

                                               <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                   Retour</a>
                                           </div>
                                       </div>
                                   </form>
                                </div>

                                <div class="tab-pane fade <?php if($idetape==3 and isset($qualification)){ echo "show active";} ?>" id="navs-top-education" role="tabpanel">
									<?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                        @csrf
                                       @method('put')
                                       <div class="row">

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Ecole de formation <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="ecole_formation_educ" id="ecole_formation_educ"
                                                       class="form-control form-control-sm" value="{{ old('ecole_formation_educ') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Diplome  <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="diplome_formation_educ" id="diplome_formation_educ"
                                                       class="form-control form-control-sm" value="{{ old('diplome_formation_educ') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Domaine d'etude <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="domaine_formation_educ" id="domaine_formation_educ"
                                                       class="form-control form-control-sm" value="{{ old('domaine_formation_educ') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Date de debut <strong style="color:red;">*</strong></label>
                                                   <input type="month" name="date_de_debut_formations_educ" id="date_de_debut_formations_educ"
                                                       class="form-control month form-control-sm" value="{{ old('date_de_debut_formations_educ') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Date de fin <strong style="color:red;">*</strong></label>
                                                   <input type="month" name="date_de_fin_formations_educ" id="date_de_fin_formations_educ"
                                                       class="form-control month form-control-sm"  value="{{ old('date_de_fin_formations_educ') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Résultat obtenu </label>
                                                   <input type="text" name="resultat_formation_educ" id="resultat_formation_educ"
                                                       class="form-control form-control-sm" value="{{ old('resultat_formation_educ') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-6 col-12">
                                               <div class="mb-1">
                                                   <label>Description de la formation: <strong style="color:red;">*</strong></label>
                                                   <textarea class="form-control" id="description_formations_educ" name="description_formations_educ" rows="4" cols="3">{{ old('description_formations_educ') }}</textarea>

                                               </div>
                                           </div>

                                           <div class="col-md-6 col-12">
                                               <div class="mb-1">
                                                   <label>Activité/Association: </label>
                                                   <textarea class="form-control" id="activite_asso_formations_educ" name="activite_asso_formations_educ" rows="4" cols="3">{{ old('activite_asso_formations_educ') }}</textarea>

                                               </div>
                                           </div>




                                           <div class="col-12" align="right">
                                               <hr>

                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                               <?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                                       <button type="submit" name="action" value="AjouterFormationEduc"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                               <?php //} ?>

                                                @if(count($formations)>0)
                                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                                @endif

                                               <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                   Retour</a>
                                           </div>
                                       </div>
                                   </form>
                                   <?php //} ?>
                                   <hr>
                                   <table class="table table-bordered table-striped table-hover table-sm"
                                       id=""
                                       style="margin-top: 13px !important">
                                       <thead>
                                       <tr>
                                           <th>No</th>
                                           <th>Ecole </th>
                                           <th>Diplome</th>
                                           <th>Domaine de formation</th>
                                           <th>Durée formation</th>
                                           <th>Résultat</th>
                                           <th>Description</th>
                                           <th>Action</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       <?php $i = 0; ?>
                                           @foreach ($formations as $key => $formation)
                                               <?php $i += 1;?>
                                                       <tr>
                                                           <td>{{ $i }}</td>
                                                           <td>{{ $formation->ecole_formation_educ }}</td>
                                                           <td>{{ $formation->diplome_formation_educ }}</td>
                                                           <td>{{ $formation->domaine_formation_educ }}</td>
                                                           <td> {{ Carbon::parse($formation->date_de_debut_formations_educ)->format('d/m/Y') }} - {{ Carbon::parse($formation->date_de_fin_formations_educ)->format('d/m/Y') }}</td>
                                                           <td>{{ $formation->resultat_formation_educ }}</td>
                                                           <td>
                                                            <span data-bs-toggle="tooltip" title="{{ $formation->description_formations_educ }}">

                                                                    {{ Str::words($formation->description_formations_educ, 15, '...') }}

                                                            </span>
                                                           </td>
                                                           <td>

                                                                   <a href="{{ route($lien.'.deleteformation',\App\Helpers\Crypt::UrlCrypt($formation->id_formations_educ)) }}"
                                                                   class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet ligne ?")) return false;'
                                                                   title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>

                                                           </td>
                                                       </tr>
                                           @endforeach

                                       </tbody>
                                   </table>
                                </div>

                                <div class="tab-pane fade <?php if($idetape==4 and count($formations)>0){ echo "show active";} ?>" id="navs-top-experiences" role="tabpanel">
                                    <?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                        @csrf
                                       @method('put')
                                       <div class="row">

                                           <div class="col-md-3 col-12">
                                               <div class="mb-1">
                                                   <label>intitulé du poste <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="intitule_de_poste" id="intitule_de_poste"
                                                       class="form-control form-control-sm" value="{{ old('intitule_de_poste') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-3 col-12">
                                               <div class="mb-1">
                                                   <label>Type emploi <strong style="color:red;">*</strong></label>
                                                   <select class="select2 form-select-sm input-group" data-allow-clear="true" name="id_type_emploie" id="id_type_emploie" >
                                                       <?= $typeEmplois; ?>
                                                   </select>
                                               </div>
                                           </div>

                                           <div class="col-md-3 col-12">
                                               <div class="mb-1">
                                                   <label>Lieu <strong style="color:red;">*</strong></label>
                                                   <select class="select2 form-select-sm input-group" data-allow-clear="true" name="id_type_lieu" id="id_type_lieu" >
                                                       <?= $typeLieu; ?>
                                                   </select>
                                               </div>
                                           </div>

                                           <div class="col-md-3 col-12">
                                               <div class="mb-1">
                                                   <label>Nom de l'entreprise <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="nom_entreprise" id="nom_entreprise"
                                                       class="form-control form-control-sm" value="{{ old('nom_entreprise') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-3 col-12">
                                               <div class="mb-1">
                                                   <label>Localité entreprise <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="lieu_entreprise" id="lieu_entreprise"
                                                       class="form-control form-control-sm"  value="{{ old('lieu_entreprise') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-3 col-12">
                                            <div class="mb-1">
                                                <label>C'est votre poste actuel: <strong style="color:red;">*</strong></label><br>
                                                <input type="checkbox" class="form-check-input" name="flag_occuppe_poste_actuel" id="colorCheck1" onclick="myFunctionMAJ()">
                                            </div>
                                            </div>

                                           <div class="col-md-3 col-12">
                                               <div class="mb-1">
                                                   <label>Date de debut <strong style="color:red;">*</strong></label>
                                                   <input type="month" name="date_de_debut" id="date_de_debut"
                                                       class="form-control month form-control-sm" value="{{ old('date_de_debut') }}" />
                                               </div>
                                           </div>

                                           <div class="col-md-3 col-12" id="date_de_fin">
                                               <div class="mb-1">
                                                   <label>Date de fin </label>
                                                   <input type="month" name="date_de_fin" id="date_de_fin"
                                                       class="form-control month form-control-sm"  value="{{ old('date_de_fin') }}" />
                                               </div>
                                           </div>


                                           <div class="col-md-12 col-12">
                                               <div class="mb-1">
                                                   <label>Description votre experience: <strong style="color:red;">*</strong></label>
                                                   <textarea class="form-control" id="description_experience" name="description_experience" rows="4" cols="3">{{ old('description_formations_educ') }}</textarea>
                                               </div>
                                           </div>







                                           <div class="col-12" align="right">
                                               <hr>

                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                               <?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                                       <button type="submit" name="action" value="AjouterExperience"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                               <?php //} ?>

                                               @if(count($experiences)>0)
                                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                               @endif

                                               <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                   Retour</a>
                                           </div>
                                       </div>
                                   </form>
                                   <?php //} ?>
                                   <hr>

                                   @if ($response == 120)
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <div class="alert-body" style="text-align: center">
                                                Ce formateur n'est pas éligible à une demande d'habilitation. <br/>
                                                Cinq (5) années minimum d'expérience sont nécessaires.
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                   @else
                                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                            <div class="alert-body" style="text-align: center">
                                                Ce formateur est éligible à une demande d'habilitation.
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                   @endif


                                   <table class="table table-bordered table-striped table-hover table-sm"
                                       id=""
                                       style="margin-top: 13px !important">
                                       <thead>
                                       <tr>
                                           <th>No</th>
                                           <th>Intitulé du poste </th>
                                           <th>Type emploi</th>
                                           <th>Lieu</th>
                                           <th>Entreprise</th>
                                           <th>Lieu entreprise</th>
                                           <th>Periode</th>
                                           <th>Experience</th>
                                           <th>Action</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       @foreach ($experiences as $experience)
                                           <tr @if($experience->flag_occuppe_poste_actuel == 'true') style="" @endif>
                                               <td>{{ $loop->iteration }}</td> <!-- Utilisation de $loop->iteration pour l'incrémentation -->
                                               <td>{{ $experience->intitule_de_poste }}</td>
                                               <td>{{ $experience->typeEmploie->libelle_type_emploie }}</td>
                                               <td>{{ $experience->typeLieu->libelle_type_lieu }}</td>
                                               <td>{{ $experience->nom_entreprise }}</td>
                                               <td>{{ $experience->lieu_entreprise }}</td>
                                               <td>
                                                    {{ Carbon::parse($experience->date_de_debut)->format('d/m/Y') }} - @if(isset($experience->date_de_fin)) {{ Carbon::parse($experience->date_de_fin)->format('d/m/Y') }} @else Aujourd'hui @endif

                                                    <?php $res = Fonction::calculerDureeExperience($experience->date_de_debut,$experience->date_de_fin);?>
                                                    <br/>
                                                    <span></i><font size="4" color="blue">
                                                        (@if ($res->y > 0)
                                                            {{ $res->y }} ans
                                                        @endif
                                                        @if ($res->m > 0)
                                                            {{ $res->m }} mois
                                                        @endif)</font>
                                                    </i></span>
                                               </td>
                                               <td>
                                                    <span data-bs-toggle="tooltip" title="{{ $experience->description_experience }}">
                                                        {{ Str::words($experience->description_experience, 15, '...') }}
                                                    </span>
                                               </td>
                                               <td>
                                                  <!-- Vérification de flag avec Blade -->
                                                       <a href="{{ route($lien.'.deleteexperience', \App\Helpers\Crypt::UrlCrypt($experience->id_experiences)) }}"
                                                          onclick="return confirm('Voulez-vous supprimer cette ligne ?')"
                                                          title="Supprimer">
                                                          <img src="/assets/img/trash-can-solid.png" alt="Supprimer">
                                                       </a>

                                               </td>
                                           </tr>
                                       @endforeach


                                       </tbody>
                                   </table>
                                </div>

                                <div class="tab-pane fade <?php if($idetape==5 and count($experiences)>0 ){ echo "show active";} ?>" id="navs-top-competences" role="tabpanel">
									<?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                        @csrf
                                       @method('put')
                                       <div class="row">


                                           <div class="col-md-12 col-12">
                                               <div class="mb-1">
                                                   <label>Competences: <strong style="color:red;">*</strong></label>
                                                   <input type="text" name="competences_libelle" id="competences_libelle" class="form-control form-control-sm"  value="{{ old('competences_libelle') }}" />
                                               </div>
                                           </div>




                                           <div class="col-12" align="right">
                                               <hr>

                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                               <?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                                       <button type="submit" name="action" value="AjouterCompetences"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                               <?php //} ?>

                                               @if(count($competences)>0)
                                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(6)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                               @endif

                                               <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                   Retour</a>
                                           </div>
                                       </div>
                                       <?php //} ?>
                                   </form>

                                   <hr>
                                   <table class="table table-bordered table-striped table-hover table-sm"
                                       id=""
                                       style="margin-top: 13px !important">
                                       <thead>
                                       <tr>
                                           <th>No</th>
                                           <th>Compétence </th>
                                           <th>Action</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       @foreach ($competences as $comptence)
                                           <tr>
                                               <td>{{ $loop->iteration }}</td> <!-- Utilisation de $loop->iteration pour l'incrémentation -->
                                               <td>{{ $comptence->competences_libelle }}</td>
                                               <td>

                                                       <a href="{{ route($lien.'.deletecompetence', \App\Helpers\Crypt::UrlCrypt($comptence->id_competences)) }}"
                                                          onclick="return confirm('Voulez-vous supprimer cette ligne ?')"
                                                          title="Supprimer">
                                                          <img src="/assets/img/trash-can-solid.png" alt="Supprimer">
                                                       </a>

                                               </td>
                                           </tr>
                                       @endforeach


                                       </tbody>
                                   </table>
                                </div>

                                <div class="tab-pane fade <?php if($idetape==6 and count($competences)>0 ){ echo "show active";} ?>" id="navs-top-langues" role="tabpanel">
									<?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                        @csrf
                                       @method('put')
                                       <div class="row">


                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Langues <strong style="color:red;">*</strong></label>
                                                   <select class="select2 form-select-sm input-group" data-allow-clear="true" name="id_langues" id="id_langues" >
                                                       <?= $LanguesListe; ?>
                                                   </select>
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Aptitude <strong style="color:red;">*</strong></label>
                                                   <select class="select2 form-select-sm input-group" data-allow-clear="true" name="id_aptitude" id="id_aptitude" >
                                                       <?= $aptitudeListe; ?>
                                                   </select>
                                               </div>
                                           </div>

                                           <div class="col-md-4 col-12">
                                               <div class="mb-1">
                                                   <label>Mention <strong style="color:red;">*</strong></label>
                                                   <select class="select2 form-select-sm input-group" data-allow-clear="true" name="id_mention" id="id_mention" >
                                                       <?= $mentionsListe; ?>
                                                   </select>
                                               </div>
                                           </div>


                                           <div class="col-12" align="right">
                                               <hr>

                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                               <?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                                       <button type="submit" name="action" value="AjouterLangues"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                               <?php //} ?>

                                               @if(count($languesformateurs)>0)
                                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(7)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                               @endif


                                               <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                   Retour</a>
                                           </div>
                                       </div>
                                   </form>
                                   <?php //} ?>
                                   <hr>
                                   <table class="table table-bordered table-striped table-hover table-sm"
                                       id=""
                                       style="margin-top: 13px !important">
                                       <thead>
                                       <tr>
                                           <th>No</th>
                                           <th>Langues </th>
                                           <th>Aptitudes </th>
                                           <th>Mention </th>
                                           <th>Action</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       @foreach ($languesformateurs as $languesformateur)
                                           <tr>
                                               <td>{{ $loop->iteration }}</td> <!-- Utilisation de $loop->iteration pour l'incrémentation -->
                                               <td>{{ $languesformateur->langues->libelle_langues }}</td>
                                               <td>{{ $languesformateur->aptitude->libelle_aptitude }}</td>
                                               <td>{{ $languesformateur->mention->libelle_mention }}</td>
                                               <td>

                                                       <a href="{{ route($lien.'.deletelangue', \App\Helpers\Crypt::UrlCrypt($languesformateur->id_langues_formateurs)) }}"
                                                          onclick="return confirm('Voulez-vous supprimer cette ligne ?')"
                                                          title="Supprimer">
                                                          <img src="/assets/img/trash-can-solid.png" alt="Supprimer">
                                                       </a>

                                               </td>
                                           </tr>
                                       @endforeach


                                       </tbody>
                                   </table>
                                </div>

                                <div class="tab-pane fade <?php if($idetape==7 and count($languesformateurs)>0 ){ echo "show active";} ?>" id="navs-top-autre-fin" role="tabpanel">
                                    <?php //if ($formateur->flag_attestation_formateurs != true){ ?>

                                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                <div class="alert-body" style="text-align: center">
                                                    Le CV et la lettre d'engagment sont obligatoire
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>

                                        <div class="col-12" align="right">

                                            <?php if (count($piecesFormateursVerifi)==2){ ?>
                                                <?php if ($formateur->flag_attestation_formateurs != true){ ?>
                                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                                        @csrf
                                                    @method('put')
                                                        <button type="submit" name="action" value="Terminer"  onclick='javascript:if (!confirm("Voulez-vous valider ce formateur ?")) return false;'
                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                Terminer
                                                        </button>
                                                    </form>
                                                <?php }else { ?>
                                                    <span class="badge bg-secondary">
                                                        <a target="_blank" onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs)) }}','',screen.width*2,screen.height,'yes','center',1);" >
                                                            Voir le cv
                                                        </a>
                                                    </span>
                                                <?php } ?>
                                            <?php } ?>

                                        </div>
                                    <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                        @csrf
                                       @method('put')
                                       <div class="row">


                                           <div class="col-md-6 col-12">
                                               <div class="mb-1">
                                                   <label>Type de pieces <strong style="color:red;">*</strong></label>
                                                   <select class="select2 form-select-sm input-group" data-allow-clear="true" name="id_types_pieces" id="id_types_pieces" >
                                                       <?= $TypesPiecesListe; ?>
                                                   </select>
                                                   @error('id_types_pieces')
                                                   <div class=""><label class="error">{{ $message }}</label></div>
                                                   @enderror
                                               </div>
                                           </div>

                                           <div class="col-md-6 col-12">
                                               <div class="mb-1">
                                                   <label>Pieces jointes <strong style="color:red;">*</strong></label>
                                                   <input type="file" name="pieces_formateur" value="{{ old('pieces_formateur') }}" id="pieces_formateur" class="form-control form-control-sm" />
                                                   @error('pieces_formateur')
                                                   <div class=""><label class="error">{{ $message }}</label></div>
                                                   @enderror
                                               </div>
                                           </div>






                                           <div class="col-12" align="right">
                                               <hr>

                                               <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($formateur->id_formateurs),\App\Helpers\Crypt::UrlCrypt(6)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                               <?php //if ($formateur->flag_attestation_formateurs != true){ ?>
                                                       <button type="submit" name="action" value="AjouterPieces"
                                                               class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                               Ajouter
                                                       </button>
                                               <?php //} ?>




                                               <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                   Retour</a>
                                           </div>
                                       </div>
                                   </form>
                                   <?php //} ?>

                                   <hr>
                                    <table class="table table-bordered table-striped table-hover table-sm"
                                        id=""
                                        style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Types de pieces </th>
                                            <th>Pieces </th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($piecesFormateurs as $piecesFormateur)
											<tr>
												<td>{{ $loop->iteration }}</td> <!-- Utilisation de $loop->iteration pour l'incrémentation -->
												<td>{{ $piecesFormateur->typesPiece->libelle_types_pieces }}</td>
												<td>
													@if (isset($piecesFormateur->pieces_formateur))
														<span class="badge bg-secondary">
															<a target="_blank"
																onclick="NewWindow('{{ asset("/pieces/pieces_formateur/".$formateur->entreprise->ncc_entreprises."_".$formateur->nom_formateurs."_".$formateur->prenom_formateurs."/". $piecesFormateur->pieces_formateur)}}','',screen.width/2,screen.height,'yes','center',1);">
																Voir la pièce
															</a>
														</span>
													@endif
												</td>
												<td>

														<a href="{{ route($lien.'.deletepieceformateur', \App\Helpers\Crypt::UrlCrypt($piecesFormateur->id_pieces_formateur)) }}"
														   onclick="return confirm('Voulez-vous supprimer cette ligne ?')"
														   title="Supprimer">
														   <img src="/assets/img/trash-can-solid.png" alt="Supprimer">
														</a>

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


        <!-- END: Content-->

        @endsection

        @section('js_perso')



        <script>





            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })


            var idactivesmoussion = $('#colorCheck1').prop('checked', false);


            function myFunctionMAJ() {
                // Get the checkbox
                var checkBox = document.getElementById("colorCheck1");

                // If the checkbox is checked, display the output text
                if (checkBox.checked == true){
                    $("#date_de_fin").hide();
                } else {
                   $("#date_de_fin").show();
                }
            }
        </script>


        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
