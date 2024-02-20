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

@if(auth()->user()->can('cahierplanformation-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Plan de formation')
    @php($titre='Liste des cahiers de plan de formation')
    @php($soustitre='Creer un cahier de plan de formation')
    @php($lien='cahierplanformation')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript">

       // document.getElementById("Activeajoutercabinetformation").disabled = true;

        function changeFunction() {
            //alert('code');exit;

            var selectBox = document.getElementById("id_departement");
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;

            //alert(selectedValue);

            $.get('/listeagencedepartement/'+selectedValue, function (data) {
                     //alert(data); //exit;
                    $('#id_agence').empty();
                    $.each(data, function (index, tels) {
                        $('#id_agence').append($('<option>', {
                            value: tels.num_agce,
                            text: tels.lib_agce,
                        }));
                    });
                });


        };
    </script>
    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
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
                          Cahier de plan de formation
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
                          Liste des plans de formations
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
                          Cahier de plan de formation à soumettre pour le comité
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-planformation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation),\App\Helpers\Crypt::UrlCrypt(1)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Code <strong style="color:red;">*</strong></label>
                                            <input type="text" class="form-control form-control-sm" value="{{ @$cahier->code_cahier_plan_formation }}" disabled="disabled"/>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <label>Liste des departements <strong style="color:red;">*</strong></label>
                                        <select
                                                id="id_departement"
                                                name="id_departement"
                                                class="select2 form-select-sm input-group"
                                                aria-label="Default select example" required="required" onchange="changeFunction();">
                                                <option value="{{ $cahier->departement->id_departement }}">{{ $cahier->departement->libelle_departement }}   </option>
                                                @foreach ($departements as $departement)
                                                    <option value="{{ $departement->id_departement }}">{{ $departement->libelle_departement }}</option>
                                                @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <label>LIste des agences <strong style="color:red;">*</strong></label>

                                        <select id="id_agence" name="id_agence" class="select2 form-select-sm input-group">
                                            <option value='{{ $cahier->agence->num_agce }}'>{{ $cahier->agence->lib_agce }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control form-control-sm"  name="commentaire_cahier_plan_formation" id="commentaire_cahier_plan_formation" rows="6">{{ $cahier->commentaire_cahier_plan_formation }}</textarea>

                                        </div>
                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if($cahier->flag_statut_cahier_plan_formation == false){?>
                                            <button type="submit" name="action" value="Modifier"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Modifier
                                            </button>
                                        <?php } ?>
                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">Retour</a>

                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} ?>" id="navs-top-actionformation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation),\App\Helpers\Crypt::UrlCrypt(2)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <?php if(count($planformations)>0){ ?>
                                    <div class="col-12" align="right">
                                        <button type="submit" name="action" value="Traiter_cahier_plan"
                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                        Ajouter au cahier
                                        </button>
                                    </div>
                                <?php } ?>
                                <table class="table table-bordered table-striped table-hover table-sm"
                                        id="exampleData"
                                        style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Entreprise </th>
                                            <th>Conseiller </th>
                                            <th>Code </th>
                                            <th>Date soumis</th>
                                            <th>Nombre de salariés</th>
                                            <th>Cout demandé</th>
                                            <th>Cout accordé</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php //dd($planformations);
                                    $i=0 ?>
                                    @foreach ($planformations as $key => $planformation)
                                        <tr>
                                            <td>
                                                <input type="checkbox"
                                                value="<?php echo $planformation->id_plan_de_formation;?>"
                                                name="planformation[<?php echo $planformation->id_plan_de_formation;?>]"
                                                id="planformation<?php echo $planformation->id_plan_de_formation;?>"/>
                                            </td>
                                            <td>{{ @$planformation->entreprise->ncc_entreprises  }} / {{ @$planformation->entreprise->raison_social_entreprises  }}</td>
                                            <td>{{ @$planformation->userconseilplanformation->name }} {{ @$planformation->userconseilplanformation->prenom_users }}</td>
                                            <td>{{ @$planformation->code_plan_formation }}</td>
                                            <td>{{ $planformation->date_soumis_plan_formation }}</td>
                                            <td>{{ $planformation->nombre_salarie_plan_formation }}</td>
                                            <td align="rigth">{{ number_format($planformation->cout_total_demande_plan_formation, 0, ',', ' ') }}</td>
                                            <td align="rigth">{{ number_format($planformation->cout_total_accorder_plan_formation, 0, ',', ' ') }}</td>
                                            <td align="center" nowrap="nowrap">

                                                <?php if($cahier->flag_statut_comite_permanente == false){?>
                                                @can($lien.'-edit')
                                                    <a href="{{ route($lien.'.editer',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                                        class=" "
                                                        title="Modifier"><img
                                                            src='/assets/img/editing.png'></a>


                                                @endcan
                                                <?php } ?>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
                            <div class="col-12" align="right">
                                <hr>

                                <?php //if (count($comitegestionparticipant)>=1){ ?>


                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>
                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


                                <?php //} ?>

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>

                        <div class="tab-pane fade<?php if($idetape==3){ echo "show active";} //if(count($ficheagrements)>=1 and count($comitegestionparticipant)>=1){ echo "active";} ?>" id="navs-top-cahieraprescomite" role="tabpanel">

                                <div class="col-12" align="right">
                                    <?php  if(count($cahierplansformations)>=1 and $cahier->flag_statut_cahier_plan_formation == false){?>

                                    <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation),\App\Helpers\Crypt::UrlCrypt(3)]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <button type="submit" name="action" value="Traiter_cahier_plan_soumis"
                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Soumettre le cahier à la commission permanente
                                        </button>
                                    </form>

                                    <?php }else{ ?>
                                        <a onclick="NewWindow('{{ route($lien.".etat",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>
                                    <?php } ?>
                                </div>
                                <table class="table table-bordered table-striped table-hover table-sm"
                                id="exampleData"
                                style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Entreprise </th>
                                    <th>Conseiller </th>
                                    <th>Code </th>
                                    <th>Cout demandé</th>
                                    <th>Cout accordé </th>
                                    <th>Date soumis</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php //dd($planformations);
                                $i=0 ?>
                                @foreach ($cahierplansformations as $key => $planformation)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ @$planformation->ncc_entreprises  }} / {{ @$planformation->raison_social_entreprises  }}</td>
                                        <td>{{ @$planformation->name }} {{ @$planformation->prenom_users }}</td>
                                        <td>{{ @$planformation->code_plan_formation }}</td>
                                        <td align="rigth">{{ number_format($planformation->cout_total_demande_plan_formation) }}</td>
                                        <td align="rigth">{{ number_format($planformation->cout_total_accorder_plan_formation) }}</td>
                                        <td>{{ $planformation->date_soumis_plan_formation }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="col-12" align="right">
                                <hr>

                                <?php if (count($cahierplansformations)>=1){ ?>


                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_plan_formation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>

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

        @else
        <script type="text/javascript">
            window.location = "{{ url('/403') }}";//here double curly bracket
        </script>
    @endif
