<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>
@if(auth()->user()->can('comites-create'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Comites')
    @php($titre='Liste des comites')
    @php($soustitre='Ajout de comite')
    @php($lien='comites')
    @php($lienacceuil='dashboard')

    <!-- BEGIN: Content-->
    <script type="text/javascript">

       /* function changeFuncSelect() {
            var selectBox = document.getElementById("id_type_comite");
            var id_processus_comite = document.getElementById("id_processus_comite");
            //var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;
            //alert(selectedValue);
            const myArray = selectedValue.split("/");
            //alert(myArray);
            let id_type_comite = myArray[0];
            //alert(id_type_comite);
            let libelle_type_comite = myArray[1];
           // alert(libelle_type_comite);

            if(libelle_type_comite =="Commission permanente"){
                id_processus_comite.setAttribute('multiple', '')
            }else{
                id_processus_comite.removeAttribute('multiple');
            }


        };*/



    </script>


    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i>  Accueil </a> / {{$Module}} / <a href="/{{ $lien }}"> {{$titre}}</a> / </span> {{$soustitre}}
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
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="alert-body">
                {{ $message }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        @if(!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{$anneexercice}}
                </div>
                <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
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
                          Comité
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
                          Liste des cahiers
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
                          Liste des participants
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
                          Valider le comite
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-top-planformation" role="tabpanel">

                        <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <label>Type de comité <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select @error('id_categorie_comite')
                                    error
                                    @enderror"
                                                    data-allow-clear="true" name="id_categorie_comite"
                                                    id="id_categorie_comite"  required>
                                        <?php echo $typecomitesListe; ?>
                                    </select>
                                    @error('id_categorie_comite')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-12">
                                    <label>Liste des processus <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select @error('id_processus_comite')
                                    error
                                    @enderror"
                                                    data-allow-clear="true" name="id_processus_comite[]"
                                                    id="id_processus_comite" multiple>
                                         <?php echo $processuscomitesListe ?>
                                    </select>
                                    @error('id_processus_comite')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="mb-1">
                                        <label>Date de début <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_debut_comite"
                                               class="form-control form-control-sm" required/>
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="mb-1">
                                        <label>Date de fin </label>
                                        <input type="date" name="date_fin_comite"
                                               class="form-control form-control-sm" />
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire <strong style="color:red;">*</strong></label>
                                        <textarea class="form-control form-control-sm"  name="commentaire_comite" id="commentaire_comite" rows="6"></textarea>

                                    </div>
                                </div>


                                <div class="col-12" align="right">
                                    <hr>
                                    <button type="submit"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Enregistrer
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

        @else
        <script type="text/javascript">
            window.location = "{{ url('/403') }}";//here double curly bracket
        </script>
    @endif

