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

@if(auth()->user()->can('cahierplansprojets-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Cahiers')
    @php($titre='Liste des cahiers des plans/projets')
    @php($soustitre='Modifier le cahier')
    @php($lien='cahierplansprojets')
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
                  <h6 class="text-muted"></h6>
                  <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?php if($idetape==1){ echo "active";}  ?>"
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
                          class="nav-link <?php if($idetape==2){ echo "active";}  ?>"
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
                          class="nav-link <?php if($idetape==3){ echo "active";}else{ echo "disabled";}  ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-cahieraprescomite"
                          aria-controls="navs-top-cahieraprescomite"
                          aria-selected="false">
                          Cahier à soumettre
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-planformation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets),\App\Helpers\Crypt::UrlCrypt(1)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Code <strong style="color:red;">*</strong></label>
                                            <input type="text" class="form-control form-control-sm" value="{{ @$cahier->code_cahier_plans_projets }}" disabled="disabled"/>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <label>Liste des processus <strong style="color:red;">*</strong></label>
                                        <select class="select2 form-select @error('id_processus_comite')
                                        error
                                        @enderror"
                                                        data-allow-clear="true" name="id_processus_comite"
                                                        id="id_processus_comite" required >
                                             <?php echo $processuscomitesListe ?>
                                        </select>
                                        @error('id_processus_comite')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 col-12" id="id_departement_div">
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

                                    <div class="col-md-3 col-12" id="id_categorie_comite_div">
                                        <label>Liste des comités <strong style="color:red;">*</strong></label>
                                        <select class="select2 form-select @error('id_categorie_comite')
                                        error
                                        @enderror"
                                                        data-allow-clear="true" name="id_categorie_comite"
                                                        id="id_categorie_comite" >
                                             <?php echo $categoriecomitesListe ?>
                                        </select>
                                        @error('id_categorie_comite')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control form-control-sm"  name="commentaire_cahier_plans_projets" id="commentaire_cahier_plans_projets" rows="6">{{ $cahier->commentaire_cahier_plans_projets }}</textarea>

                                        </div>
                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if($cahier->flag_statut_cahier_plans_projets == false){?>
                                            <button type="submit" name="action" value="Modifier"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Modifier
                                            </button>
                                        <?php } ?>
                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">Retour</a>

                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} ?>" id="navs-top-actionformation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets),\App\Helpers\Crypt::UrlCrypt(2)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                            <?php //if(count($cahiers)>0){ ?>
                                <div class="col-12" align="right">
                                    <button type="submit" name="action" value="Ajouter_cahier_plans_projets"
                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                    Ajouter au cahier
                                    </button>
                                </div>
                            <?php //} ?>

                            <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th><label>Selectionnez tous</label><br/><input type="checkbox" id="allcb" name="allcb"/></th>
                                        <th>Type processus </th>
                                        <th>Entreprise </th>
                                        <th>Conseiller </th>
                                        <th>Code </th>
                                        <th>Date soumise au FDFP</th>
                                        <th>Date fin instruction</th>
                                        <th>Coût accordé</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php //dd($planformations);
                                $i=0 ?>
                                @foreach ($demandes as $key => $demande)
                                    <tr>
                                        <td>
                                            <input type="checkbox"
                                            value="<?php echo $demande->id_demande;?>/<?php echo $demande->code_processus;?>"
                                            name="demande[<?php echo $demande->id_demande;?>]"
                                            id="demande<?php echo $demande->id_demande;?>"/>
                                        </td>
                                        <td>
                                            @if ($demande->code_processus =='PF')
                                                PLAN DE FORMATION
                                            @endif
                                            @if ($demande->code_processus =='PE')
                                                PROJET ETUDE
                                            @endif
                                            @if ($demande->code_processus =='PRF')
                                                PROJET DE FORMATION
                                            @endif
                                        </td>
                                        <td>{{ @$demande->raison_sociale  }}</td>
                                        <td>{{ @$demande->nom_conseiller }}</td>
                                        <td>{{ @$demande->code }}</td>
                                        <td>{{ $demande->date_demande }}</td>
                                        <td>{{ $demande->date_soumis }}</td>
                                        <td align="rigth">{{ number_format($demande->montant_total, 0, ',', ' ') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </form>
                            <div class="col-12" align="right">
                                <hr>

                                <?php //if (count($comitegestionparticipant)>=1){ ?>


                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>
                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


                                <?php //} ?>

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>

                        <div class="tab-pane fade<?php if($idetape==3){ echo "show active";} //if(count($ficheagrements)>=1 and count($comitegestionparticipant)>=1){ echo "active";} ?>" id="navs-top-cahieraprescomite" role="tabpanel">

                            <div class="col-12" align="right">
                                <?php  if(count($cahierplansprojets)>=1 and $cahier->flag_statut_cahier_plans_projets == false){?>

                                <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets),\App\Helpers\Crypt::UrlCrypt(3)]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <button onclick='javascript:if (!confirm("Vous allez soumettre ce cahier à la commission  ? . Cette action est irréversible.")) return false;' type="submit" name="action" value="Traiter_cahier_plan_projet_soumis"
                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                        Soumettre le cahier à la commission
                                    </button>
                                </form>

                                <?php }else{ ?>
                                    @if ($cahier->processusComite->code_processus_comite =='PF')

                                    <a onclick="NewWindow('{{ route($lien.".etatpf",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>

                                    @endif
                                    @if ($cahier->processusComite->code_processus_comite =='PE')

                                    <a onclick="NewWindow('{{ route($lien.".etatpe",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>

                                    @endif
                                    @if ($cahier->processusComite->code_processus_comite =='PRF')

                                    <a onclick="NewWindow('{{ route($lien.".etatprf",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>

                                    @endif
                                <?php } ?>
                            </div>

                            <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Type processus </th>
                                        <th>Entreprise </th>
                                        <th>Conseiller </th>
                                        <th>Code </th>
                                        <th>Date soumise au FDFP</th>
                                        <th>Date fin instruction</th>
                                        <th>Coût accordé</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php //dd($planformations);
                                $i=0 ?>
                                @foreach ($cahierplansprojets as $key => $demande)
                                    <tr>
                                        <td> {{ ++$i }} </td>
                                        <td>
                                            @if ($demande->code_processus =='PF')
                                                PLAN DE FORMATION
                                            @endif
                                            @if ($demande->code_processus =='PE')
                                                PROJET ETUDE
                                            @endif
                                            @if ($demande->code_processus =='PRF')
                                                PROJET DE FORMATION
                                            @endif
                                        </td>
                                        <td>{{ @$demande->raison_sociale  }}</td>
                                        <td>{{ @$demande->nom_conseiller }}</td>
                                        <td>{{ @$demande->code }}</td>
                                        <td>{{ $demande->date_demande }}</td>
                                        <td>{{ $demande->date_soumis }}</td>
                                        <td align="rigth">{{ number_format($demande->montant_total, 0, ',', ' ') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="col-12" align="right">
                                <hr>

                                <?php if (count($cahierplansprojets)>=1){ ?>


                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plans_projets),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>

                                <?php } ?>

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
    </div>


        @endsection
        @section('js_perso')
        <script type="text/javascript">

            // $valuestar = $cahiers->id_processus_comite;

            // if($valuestar != '1'){
            //          hiddenPufield();
            //          //alert(selectedValue);
            //      }else{
            //          displayPufield();
            //      }

                function hiddenPufield(){
                     $("#id_departement").prop( "disabled", true );
                     $("#id_departement_div").hide();
                     $("#id_categorie_comite").prop( "disabled", false );
                     $("#id_categorie_comite_div").show();
                 }

                 function displayPufield(){
                     $("#id_departement").prop( "disabled", false );
                     $("#id_departement_div").show();
                     $("#id_categorie_comite").prop( "disabled", true );
                     $("#id_categorie_comite_div").hide();
                 }

                changeFunction($("#id_processus_comite").val());

                $("#id_processus_comite").change(function(){
                    changeFunction(this.value)
                });

             function changeFunction(idproc) {
                //  //alert('code');exit;

                //  var selectBox = document.getElementById("id_processus_comite");
                //  let selectedValue = selectBox.options[selectBox.selectedIndex].value;

                 //alert(selectedValue);

                 if(idproc != '1'){
                     hiddenPufield();
                     //alert(selectedValue);
                 }else{
                     displayPufield();
                 }


                 /*$.get('/listeagencedepartement/'+selectedValue, function (data) {
                          //alert(data); //exit;
                         $('#id_agence').empty();
                         $.each(data, function (index, tels) {
                             $('#id_agence').append($('<option>', {
                                 value: tels.num_agce,
                                 text: tels.lib_agce,
                             }));
                         });
                     });*/


             };

             function hiddenPufield(){
                     $("#id_departement").prop( "disabled", true );
                     $("#id_departement_div").hide();
                     $("#id_categorie_comite").prop( "disabled", false );
                     $("#id_categorie_comite_div").show();
                 }

                 function displayPufield(){
                     $("#id_departement").prop( "disabled", false );
                     $("#id_departement_div").show();
                     $("#id_categorie_comite").prop( "disabled", true );
                     $("#id_categorie_comite_div").hide();
                 }
         </script>

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

        @else
        <script type="text/javascript">
            window.location = "{{ url('/403') }}";//here double curly bracket
        </script>
    @endif
