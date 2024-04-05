<?php
    /*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{

	}*/

    $idconnect = Auth::user()->id;
    $NumAgce = Auth::user()->num_agce;
    $Iddepartement = Auth::user()->id_departement;
    use App\Helpers\ConseillerParAgence;
    use App\Helpers\ListeTraitementCritereParUser;
    use App\Helpers\NombreActionValiderParLeConseiller;
    $conseilleragence = ConseillerParAgence::get_conseiller_par_agence($NumAgce,$Iddepartement);
    //$conseillerplan = NombreActionValiderParLeConseiller::get_conseiller_valider_plan($planformation->id_plan_de_formation , Auth::user()->id);
    $nombre = count($conseilleragence);
    //dd($conseillerplan);
?>
@if(auth()->user()->can('traitementcomite-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module=' Comités')
    @php($titre='Liste des comites')
    @php($soustitre='Tenue de comite')
    @php($lien='traitementcomite')
    @php($lienacceuil='dashboard')



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
                          class="nav-link active"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-planformation"
                          aria-controls="navs-top-planformation"
                          aria-selected="true">
                          Liste des plans de formation
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link "
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-categorieplan"
                          aria-controls="navs-top-categorieplan"
                          aria-selected="false">

                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link "
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-actionformation"
                          aria-controls="navs-top-actionformation"
                          aria-selected="false">

                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link disabled"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-recevabilite"
                          aria-controls="navs-top-recevabilite"
                          aria-selected="false">

                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-top-planformation" role="tabpanel">

                        <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Entreprise </th>
                                        <th>Conseiller </th>
                                        <th>Code </th>
                                        <th>Date soumise au FDFP</th>
                                        <th>Date fin instruction</th>
                                        <th>Date soumis a la commision</th>
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
                                        <td>{{ @$demande->raison_social_entreprises  }}</td>
                                        <td>{{ @$demande->name .''. @$demande->prenom_users }}</td>
                                        <td>{{ @$demande->code_plan_formation }}</td>
                                        <td>{{ $demande->date_soumis_plan_formation }}</td>
                                        <td>{{ $demande->date_soumis_ct_plan_formation }}</td>
                                        <td>{{ $demande->date_soumis_cahier_plans_projets }}</td>
                                        <td align="rigth">{{ number_format($demande->cout_total_accorder_plan_formation, 0, ',', ' ') }}</td>
                                        <td>
                                            @if(@$demande->flag_traiter_commission_permanente ==true)
                                                <span class="badge bg-success">Traité</span>
                                            @else
                                                <span class="badge bg-warning">En attente de traiement</span>
                                            @endif
                                        </td>
                                        <td align="center" nowrap="nowrap">
                                            @can($lien.'-edit')

                                                <a href="{{ route($lien.'.editer.planformation',[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt($demande->id_demande),\App\Helpers\Crypt::UrlCrypt(1),\App\Helpers\Crypt::UrlCrypt($demande->id_cahier_plans_projets)]) }}"
                                                    class=" " title="Modifier"><img src='/assets/img/editing.png'></a>


                                        @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="col-12" align="right">

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt(1)]) }}">
                                    Retour</a>
                            </div>
                      </div>

                      <div class="tab-pane fade" id="navs-top-categorieplan" role="tabpanel">


                      </div>


                      <div class="tab-pane fade " id="navs-top-actionformation" role="tabpanel">


                      </div>
                      <div class="tab-pane fade" id="navs-top-recevabilite" role="tabpanel">



                      </div>
                      <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

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
