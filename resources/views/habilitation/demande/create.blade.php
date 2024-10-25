<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;


?>

@if(auth()->user()->can('demandehabilitation-create'))

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
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-planformation"
                                aria-controls="navs-top-planformation"
                                aria-selected="true">
                                Informations sur l'entreprise
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-actionformation"
                                aria-controls="navs-top-actionformation"
                                aria-selected="false">
                                Moyen permanente
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-categoriesprofessionel"
                                aria-controls="navs-top-categoriesprofessionel"
                                aria-selected="false">
                                Intervention
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
                                Organisation formation
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
                                Domaine de formation
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
                            <div class="tab-pane fade show active" id="navs-top-planformation" role="tabpanel">

                                <form method="POST" class="form" action="{{ route($lien.'.store') }}" enctype="multipart/form-data">
                                    @csrf
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
                                                    class="form-control form-control-sm" required="required" value="{{ old('nom_responsable_demande_habilitation') }}">
                                            </div>
                                            @error('nom_responsable_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Fonction du responsable  <strong style="color:red;">*</strong> </label>
                                                <input type="text" name="fonction_demande_habilitation" id="fonction_demande_habilitation"
                                                    class="form-control form-control-sm" required="required" value="{{ old('fonction_demande_habilitation') }}">
                                            </div>
                                            @error('fonction_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Email professionnel du responsable  <strong style="color:red;">*</strong> </label>
                                                <input type="text" name="email_responsable_habilitation" id="email_responsable_habilitation"
                                                    class="form-control form-control-sm" required="required" value="{{ old('email_responsable_habilitation') }}">
                                            </div>
                                            @error('email_responsable_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Contact du responsable  <strong style="color:red;">*</strong> </label>
                                                <input type="text" name="contact_responsable_habilitation" id="contact_responsable_habilitation"
                                                    class="form-control form-control-sm" required="required" value="{{ old('contact_responsable_habilitation') }}">
                                            </div>
                                            @error('contact_responsable_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <label class="form-label" for="billings-country">Agence domiciliation <strong style="color:red;">*</strong></label>
                                            <select class="select2 form-select-sm input-group @error('id_banque')
                                                error
                                                @enderror" data-allow-clear="true" name="id_banque" required>
                                                <?= $banque; ?>
                                            </select>
                                            @error('id_banque')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>



                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Maison mere ou tutelle <strong style="color:red;">(s'il y a lieu)</strong> </label>
                                                <input type="text" name="maison_mere_demande_habilitation" id="maison_mere_demande_habilitation"
                                                    class="form-control form-control-sm" value="{{ old('maison_mere_demande_habilitation') }}"/>
                                            </div>
                                            @error('maison_mere_demande_habilitation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <label class="form-label" for="billings-country">Titre ou Contrat de bail <strong style="color:red;">*</strong></label>

                                            <input type="file" name="titre_propriete_contrat_bail" value="{{ old('titre_propriete_contrat_bail') }}" id="titre_propriete_contrat_bail" class="form-control form-control-sm" />
                                            @error('titre_propriete_contrat_bail')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                            <div id="defaultFormControlHelp" class="form-text ">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>

                                        </div>

                                        <div class="col-md-4 col-12">
                                            <label class="form-label" for="billings-country">Type entreprise <strong style="color:red;">*</strong></label>
                                            <select class="select2 form-select-sm input-group @error('flag_ecole_autre_entreprise')
                                                error
                                                @enderror" data-allow-clear="true" name="flag_ecole_autre_entreprise" id="flag_ecole_autre_entreprise">
                                                <option value="">---Choix du type entreprise--</option>
                                                <option value="true">Ecoles</option>
                                                <option value="false" >Autres</option>
                                            </select>
                                            @error('flag_ecole_autre_entreprise')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 col-12" id="autorisation_ouverture_ecole_div">
                                            <label class="form-label" for="billings-country">Autorisation d'ouverture <strong style="color:red;">(*)</strong></label>

                                            <input type="file" name="autorisation_ouverture_ecole" value="{{ old('autorisation_ouverture_ecole') }}" id="autorisation_ouverture_ecole" class="form-control form-control-sm"/>
                                            @error('autorisation_ouverture_ecole')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                            <div id="defaultFormControlHelp" class="form-text ">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>



                                        <div class="col-12" align="right">
                                            <hr>
                                            <button type="submit" name="action" value="Enregister"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Enregister
                                            </button>
                                            <button type="submit" name="action" value="Enregistrer_suivant"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Suivant
                                            </button>
                                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                Retour</a>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane fade" id="navs-top-actionformation" role="tabpanel">

                            </div>
                            <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

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
                $("#id_banque").select2().val({{old('id_banque')}});
            </script>


        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
