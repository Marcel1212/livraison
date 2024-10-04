<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;


?>

@if(auth()->user()->can('demandehabilitation-create'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Formateurs')
    @php($titre='Liste des formateurs')
    @php($soustitre='Ajouter un formateur')
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
                                class="nav-link active"
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
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-Soumettre"
                                aria-controls="navs-top-Soumettre"
                                aria-selected="false">
                                 Principale qualification
                                </button>
                            </li>

                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link disabled"
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
                                class="nav-link disabled"
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
                                class="nav-link disabled"
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
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-langues"
                                aria-controls="navs-top-langues"
                                aria-selected="false">
                                    Langues
                                </button>
                            </li>

                            </ul>
                            <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-top-planformation" role="tabpanel">

                                <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Nom <strong style="color:red;">*</strong></label>
                                                <input type="text" name="nom_formateurs" id="nom_formateurs"
                                                    class="form-control form-control-sm" value="{{ old("nom_formateurs") }}" required/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Prenom <strong style="color:red;">*</strong></label>
                                                <input type="text" name="prenom_formateurs" id="prenom_formateurs"
                                                    class="form-control form-control-sm" value="{{ old("prenom_formateurs") }}" required/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Contact <strong style="color:red;">*</strong></label>
                                                <input type="text" name="contact_formateurs" id="contact_formateurs"
                                                    class="form-control form-control-sm" value="{{ old("contact_formateurs") }}" required/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Second Contact</label>
                                                <input type="text" name="contact2_formateurs" id="contact2_formateurs"
                                                    class="form-control form-control-sm"  value="{{ old("contact2_formateurs") }}"/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Email <strong style="color:red;">*</strong></label>
                                                <input type="email" name="email_formateurs" id="email_formateurs"
                                                    class="form-control form-control-sm" value="{{ old("email_formateurs") }}" required/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Fonction <strong style="color:red;">*</strong></label>
                                                <input type="text" name="fonction_formateurs" id="fonction_formateurs"
                                                    class="form-control form-control-sm" value="{{ old("fonction_formateurs") }}" required/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Date de naissance <strong style="color:red;">*</strong></label>
                                                <input type="date" name="date_de_naissance" id="date_de_naissance"
                                                    class="form-control form-control-sm" value="{{ old("date_de_naissance") }}" required/>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Date de recrutement <strong style="color:red;">*</strong></label>
                                                <input type="date" name="date_de_recrutement" id="date_de_recrutement"
                                                    class="form-control form-control-sm"  value="{{ old("date_de_recrutement") }}" required/>
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
                $("#id_pays").select2().val({{old('id_pays')}});
            </script>

        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
