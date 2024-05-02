<?php

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
@if(auth()->user()->can('traitementcomitetechniques-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Comites')
    @php($titre='Liste des comite techniques')
    @php($soustitre='Traitement du comite technique')
    @php($lien='traitementcomitetechniques')
    @php($lienacceuil='dashboard')


    <!-- BEGIN: Content-->

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
                          Liste des plans/projets
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?php if($idetape==2){ echo "active";}  ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-categorieplan"
                          aria-controls="navs-top-categorieplan"
                          aria-selected="false">
                          Liste des participants
                        </button>
                      </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-planformation" role="tabpanel">
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
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php //dd($planformations);
                                $i=0 ?>
                                @foreach ($listedemandesss as $key => $demande)
                                    <tr>
                                        <td> {{ ++$i }}</td>
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
                                        <td>{{ date('d/m/Y H:i:s',strtotime(@$demande->date_demande))}}</td>
                                        <td>{{ date('d/m/Y H:i:s',strtotime(@$demande->date_soumis))}}</td>
                                        <td align="rigth">{{ number_format($demande->montant_total, 0, ',', ' ') }}</td>
                                        <td>
                                            @if(@$demande->flag_valide_ct ==true)
                                                <span class="badge bg-success">Traité</span>
                                            @else
                                                <span class="badge bg-warning">En attente de traiement</span>
                                            @endif
                                        </td>
                                        <td align="center" nowrap="nowrap">
                                            @can($lien.'-edit')
                                            @if($demande->code_processus =='PF')
                                                <a href="{{ route($lien.'.edit.planformation',[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt($demande->id_demande),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                    class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                            @endif
                                            @if($demande->code_processus =='PE')
                                                <a href="{{ route($lien.'.edit.projetetude',[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt($demande->id_demande),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                    class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                            @endif
                                            @if($demande->code_processus =='PRF')
                                                <a href="{{ route($lien.'.edit.projetformation',[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt($demande->id_demande),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                    class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                            @endif
                                        @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="col-12" align="right">

                                <hr>

                                <?php //if (count($comitegestionparticipant)>=1){ ?>

                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


                                <?php //} ?>

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>
                        <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-categorieplan" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm" id="" style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Profil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($comiteparticipants as $key => $comiteparticipant)
                                        <?php $i += 1; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $comiteparticipant->name }}</td>
                                            <td>{{ $comiteparticipant->prenom_users }}</td>
                                            <td>{{ $comiteparticipant->profile }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <div class="col-12" align="right">

                                <hr>

                                <?php //if (count($comitegestionparticipant)>=1){ ?>


                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>


                                <?php //} ?>

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>
                        <div class="tab-pane fade <?php if($idetape==3){ echo "show active";} ?>" id="navs-top-actionformation" role="tabpanel">


                        </div>

                        <div class="tab-pane fade<?php if($idetape==4){ echo "show active";} //if(count($ficheagrements)>=1 and count($comitegestionparticipant)>=1){ echo "active";} ?>" id="navs-top-cahieraprescomite" role="tabpanel">


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
