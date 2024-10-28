<?php
    /*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{

	}*/
?>
<?php

use App\Helpers\AnneeExercice;
use Carbon\Carbon;
$anneexercice = AnneeExercice::get_annee_exercice();
$dateday = Carbon::now()->format('d-m-Y');
$actifsoumission = false;

if(isset($anneexercice->id_periode_exercice)){
    $actifsoumission = true;
}else{
    $actifsoumission = false;
}

if(!empty($anneexercice->date_prolongation_periode_exercice)){
    $dateexercice = $anneexercice->date_prolongation_periode_exercice;
    if($dateday <= $dateexercice){
        $actifsoumission = true;
    }else{
        $actifsoumission = false;
    }
}



?>

{{--@if(auth()->user()->can('cahierplansprojets-edit'))--}}
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Cahiers')
    @php($titre='Liste des cahiers des demandes extension / substitution')
    @php($soustitre='Modifier le cahier')
    @php($lien='traitementcahierautredemandehabilitations')
    @php($lienacceuil='dashboard')


    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i>  Accueil </a> / {{$Module}} / <a href="/{{ $lien }}"> {{$titre}}</a> / </span> {{$soustitre}}
    </h5>




    <div class="content-body">
    @if(!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{$anneexercice}}
                </div>
                <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
            </div>
         @endif
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

             @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
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
                          class="nav-link <?php if($idetape==1){ echo "active";}  ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-autre_demande_habilitation"
                          aria-controls="navs-top-autre_demande_habilitation"
                          aria-selected="true">
                            Cahier des demandes d'extension / de substitution
                        </button>
                      </li>


                      <li class="nav-item">
                        <button
                          type="button"

                          class="nav-link @if($idetape==2) active @endif"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-cahieraprescomite"
                          aria-controls="navs-top-cahieraprescomite"
                          aria-selected="false">
                            Liste des demandes d'extension / de substitution
                        </button>
                      </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link @if($idetape==3) active @endif"
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
                        <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-autre_demande_habilitation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations),\App\Helpers\Crypt::UrlCrypt(1)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="mb-1">
                                                    <label>Code <strong style="color:red;">*</strong></label>
                                                    <input disabled type="text" class="form-control form-control-sm" value="{{ @$cahier->code_cahier_autre_demande_habilitations }}" disabled="disabled"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <label>Type de cabinet <strong style="color:red;">*</strong></label>
                                                <select disabled class="select2 form-select @error('type_entreprise')
                                    error
                                    @enderror"
                                                        data-allow-clear="true" name="type_entreprise"
                                                        id="type_entreprise" >
                                                    <option value="PU" @if($cahier->type_entreprise=="PU") selected @endif>Publique</option>
                                                    <option value="PR" @if($cahier->type_entreprise=="PR") selected @endif>Privé</option>
                                                </select>
                                                @error('type_entreprise')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <label>Liste des demandes <strong style="color:red;">*</strong></label>
                                                <select disabled class="select2 form-select @error('id_processus_autre_demande')
                                    error
                                    @enderror"
                                                        data-allow-clear="true" name="id_processus_autre_demande"
                                                        id="id_processus_autre_demande" >
                                                    @foreach($processusautre_demandes as $processusautre_demande)
                                                        <option value="{{$processusautre_demande->id_processus_autre_demande}}"

                                                                @if(isset($cahier))
                                                                    @if($cahier->code_pieces_cahier_autre_demande_habilitations==$processusautre_demande->code_processus_autre_demande)
                                                                        selected
                                                            @endif
                                                            @endif

                                                        >{{$processusautre_demande->libelle_processus_autre_demande}}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_processus_autre_demande')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control form-control-sm" disabled name="commentaire_cahier_autre_demande_habilitations" id="commentaire_cahier_autre_demande_habilitations" rows="6">{{ $cahier->commentaire_cahier_autre_demande_habilitations }}</textarea>

                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>


                        <div class="tab-pane fade<?php if($idetape==2){ echo "show active";} ?>" id="navs-top-cahieraprescomite" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Type processus </th>
                                        <th>Entreprise </th>
                                        <th>Chargé d'habilitation </th>
                                        <th>Code </th>
                                        <th>Date soumise au FDFP</th>
                                        <th>Date fin instruction</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i=0 ?>
                                @foreach ($cahierautredemandehabilitations as $key => $demande)
                                    <tr>
                                        <td> {{ ++$i }} </td>
                                        <td>
                                            @if(@$demande->code_processus=='DED')
                                                DEMANDE D'EXTENSION
                                            @elseif(@$demande->code_processus=='DSD')
                                                DEMANDE DE SUBSTITUTION
                                            @endif

                                        </td>
                                        <td>{{ @$demande->raison_sociale  }}</td>
                                        <td>{{ @$demande->nom_conseiller }}</td>
                                        <td>{{ @$demande->code }}</td>
                                        <td>{{date('d/m/Y H:i:s',strtotime(@$demande->date_demande))}}</td>
                                        <td>{{ date('d/m/Y H:i:s',strtotime(@$demande->date_soumis))}}</td>
                                        <td>
                                            <a target="_blank" href="{{ route($lien . '.show', [\App\Helpers\Crypt::UrlCrypt($demande->id_demande), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                               class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="col-12" align="right">
                                <hr>
                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>

                        <div class="tab-pane fade <?php if($idetape==3){ echo "show active";} ?>" id="navs-top-traitement" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations)) }}" enctype="multipart/form-data">
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

    </div>


        @endsection
        @section('js_perso')
        <script  type="text/javascript">
            $('#allcb').change(function(){
                if($(this).prop('checked')){
                    $('tbody tr td input[type="checkbox"]').each(function(){
                        $(this).prop('checked', true);
                    });
                }else{
                    $('tbody tr td input[type="checkbox"]').each(function(){
                        $(this).prop('checked', false);
                    });
                }
            });

        </script>
        <!-- BEGIN: Content-->
        @endsection

{{--        @else--}}
{{--        <script type="text/javascript">--}}
{{--            window.location = "{{ url('/403') }}";//here double curly bracket--}}
{{--        </script>--}}
{{--    @endif--}}
