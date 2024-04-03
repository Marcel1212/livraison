<?php

use App\Helpers\AnneeExercice;
use App\Models\PlanFormation;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@if(auth()->user()->can('cahierplansprojets-create'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Cahiers')
    @php($titre='Liste des cahiers des plans/projets')
    @php($soustitre='Creer un cahier')
    @php($lien='cahierplansprojets')
    @php($lienacceuil='dashboard')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript">

       // document.getElementById("Activeajoutercabinetformation").disabled = true;

        function changeFunction() {
            //alert('code');exit;

            var selectBox = document.getElementById("id_processus_comite");
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;

            //alert(selectedValue);

            if(selectedValue != '1'){
                hiddenPufield();
                //alert(selectedValue);
            }else{
                displayPufield();
            }


        };

        function hiddenPufield(){
                $("#id_departement").prop( "disabled", true );

                $("#id_departement_div").hide();
            }
            function displayPufield(){
                $("#id_departement").prop( "disabled", false );

                $("#id_departement_div").show();
            }
    </script>

    <!-- BEGIN: Content-->




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
                          Cahier des plans/projets
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
                          Liste des plans/projets
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
                          Cahier à soumettre
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-top-planformation" role="tabpanel">

                        <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                            @csrf
                            <div class="row">

                                <div class="col-md-4 col-12">
                                    <label>Liste des processus <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select @error('id_processus_comite')
                                    error
                                    @enderror"
                                                    data-allow-clear="true" name="id_processus_comite"
                                                    id="id_processus_comite" required onchange="changeFunction()">
                                         <?php echo $processuscomitesListe ?>
                                    </select>
                                    @error('id_processus_comite')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-12" id="id_departement_div">
                                    <label>Liste des departements <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select @error('id_departement')
                                    error
                                    @enderror"
                                                    data-allow-clear="true" name="id_departement"
                                                    id="id_departement" >
                                         <?php echo $departementsListe ?>
                                    </select>
                                    @error('id_departement')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire <strong style="color:red;">*</strong></label>
                                        <textarea class="form-control form-control-sm"  name="commentaire_cahier_plans_projets" id="commentaire_cahier_plans_projets" rows="6" required></textarea>

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
