<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>
{{--@if(auth()->user()->can('commissionevaluationoffres-create'))--}}
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Comites')
    @php($titre='Liste des comites techniques')
    @php($soustitre='Ajout de comite technique')
    @php($lien='commissionevaluationoffres')
    @php($lienacceuil='dashboard')

    <!-- BEGIN: Content-->
    <script type="text/javascript">

    </script>


{{--    <h5 class="py-2 mb-1">--}}
{{--        <span class="text-muted fw-light"> <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i>  Accueil </a> / {{$Module}} / <a href="/{{ $lien }}"> {{$titre}}</a> / </span> {{$soustitre}}--}}
{{--    </h5>--}}




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
                          data-bs-target="#navs-top-commission"
                          aria-controls="navs-top-commission"
                          aria-selected="true">
                          Commission
                        </button>
                      </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-projet"
                                aria-controls="navs-top-projet"
                                aria-selected="true">
                                Liste des projets
                            </button>
                        </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link disabled"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-offretechnique"
                          aria-controls="navs-top-offretechnique"
                          aria-selected="false">
                          Offre Technique
                        </button>
                      </li>


                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-participant"
                                aria-controls="navs-top-participant"
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
                                data-bs-target="#navs-top-offre-fin"
                                aria-controls="navs-top-offre-fin"
                                aria-selected="false">
                                Offre Financière
                            </button>
                        </li>

                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-soumettre"
                                aria-controls="navs-top-soumettre"
                                aria-selected="false">
                                Valider la commission
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-top-planformation" role="tabpanel">

                        <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <label>Nombre d'évaluateur <strong style="color:red;">*</strong></label>
                                    <input type="number" name="nombre_evaluateur_commission_evaluation_offre"
                                           class="form-control form-control-sm" required min="0"/>
                                    @error('nombre_evaluateur_commission_evaluation_offre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-12">
                                    <label>Numéro de la Commission <strong style="color:red;">*</strong></label>
                                    <input type="number" name="numero_commission_evaluation_offre"
                                           class="form-control form-control-sm" required min="0"/>
                                    @error('numero_commission_evaluation_offre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-12">
                                    <label>Région </label>
                                    <input type="text" name="region_commission_evaluation_offre"
                                           class="form-control form-control-sm"  min="0"/>
                                    @error('region_commission_evaluation_offre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-12">
                                    <label>Spéculation</label>
                                    <input type="text" name="speculation_commission_evaluation_offre"
                                           class="form-control form-control-sm" min="0"/>
                                    @error('speculation_commission_evaluation_offre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="row">
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="row">--}}
                                            <div class="col-md-3 col-12">
                                                <div class="mb-1">
                                                    <label>Date de début <strong style="color:red;">*</strong></label>
                                                    <input type="date" name="date_debut_commission_evaluation_offre"
                                                           class="form-control form-control-sm" required/>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="mb-1">
                                                    <label>Date de fin </label>
                                                    <input type="date" name="date_fin_commission_evaluation_offre"
                                                           class="form-control form-control-sm" />
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="mb-1">
                                                    <label>Pourcentage offre technique <strong style="color:red;">*</strong></label>
                                                    <input type="number" id="pourcentage_offre_tech_commission_evaluation_offre" name="pourcentage_offre_tech_commission_evaluation_offre" min="0"
                                                           class="form-control form-control-sm" required/>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-12">
                                                <div class="mb-1">
                                                    <label>Pourcentage offre financière </label>
                                                    <input type="number" readonly id="pourcentage_offre_fin_commission_evaluation_offre" name="pourcentage_offre_fin_commission_evaluation_offre"  min="0"
                                                           class="form-control form-control-sm" />
                                                </div>
                                            </div>
                                <div class="col-md-3 col-12">
                                    <div class="mb-1">
                                        <label>Note éliminatoire offre technique (/100)</label>
                                        <input type="number" id="note_eliminatoire_offre_tech_commission_evaluation_offre" name="note_eliminatoire_offre_tech_commission_evaluation_offre"  min="0"
                                               class="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="mb-1">
                                        <label>Marge inférieure offre financière (%) </label>
                                        <input type="number" id="marge_inf_offre_fin_commission_evaluation_offre" name="marge_inf_offre_fin_commission_evaluation_offre"  min="0"
                                               class="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="mb-1">
                                        <label>Marge supérieure offre financière (%) </label>
                                        <input type="number" id="marge_sup_offre_fin_commission_evaluation_offre" name="marge_sup_offre_fin_commission_evaluation_offre"  min="0"
                                               class="form-control form-control-sm" />
                                    </div>
                                </div>
{{--                                        </div>--}}

{{--                                    </div>--}}


                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control form-control-sm"  name="commentaire_commission_evaluation_offre" id="commentaire_commission_evaluation_offre" rows="6"></textarea>

                                        </div>
                                    </div>
                                </div>




                                <div class="col-12" align="right">
                                    <hr>
                                    <button type="submit" name="action" value="Enregistrer"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Enregister
                                    </button>
                                    <button type="submit" name="action" value="Enregistrer_Suivant"
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
        $( "#pourcentage_offre_tech_commission_evaluation_offre" ).on( "keyup", function() {
            $("#pourcentage_offre_fin_commission_evaluation_offre").val(100-$("#pourcentage_offre_tech_commission_evaluation_offre" ).val())
        } );
    </script>
@endsection

{{--        @else--}}
{{--        <script type="text/javascript">--}}
{{--            window.location = "{{ url('/403') }}";//here double curly bracket--}}
{{--        </script>--}}
{{--    @endif--}}

