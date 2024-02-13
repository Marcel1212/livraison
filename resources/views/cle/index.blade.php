<?php

 use App\Helpers\GrilleDeRepartitionFC;

$grille = GrilleDeRepartitionFC::get_calcul_financement(148000);

//dd($grille);

?>

@if(auth()->user()->can('clederepartitionfinancement-index'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Parametrage')
    @php($titre='Liste des clés de répartitions de financement')
    @php($lien='clederepartitionfinancement')

     <!-- BEGIN: Content-->
     <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / </span> {{$titre}}
            </h5>


                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="row">
                    <!-- Basic Layout -->
                    <div class="col-xxl">
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="mb-0">{{$titre}}</h5>
                                <small class="text-muted float-end">
                                    @can($lien.'-create')
                                        <a href="{{ route($lien.'.create') }}"
                                               class="btn btn-sm btn-primary waves-effect waves-light">
                                           <i data-feather="menu-icon tf-icons ti ti-plus"></i> Ajouter </a>
                                        @endcan
                                </span>
                                </div>

                                <div class="table">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered table-striped table-hover table-sm "
                                             id="exampleData"
                                             style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Année d'exercice</th>
                                            <th>Marge inferieur</th>
                                            <th>Marge superieur</th>
                                            <th>Montant FC</th>
                                            <th>coefficient</th>
                                            <th>Statut</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=0; ?>
                                        @foreach ($cles as $key => $cle)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $cle->periodeExercice->annee }}</td>
                                                <td>{{ number_format($cle->marge_inferieur) }}</td>
                                                <td>{{ number_format($cle->marge_superieur) }}</td>
                                                <td>{{ number_format($cle->montant_fc) }}</td>
                                                <td>{{ $cle->coefficient }}</td>
                                                <td align="center">
                                                    <?php if ($cle->flag_cle_de_repartition_financement == true ){?>
                                                        <span class="badge bg-success">Actif</span>
                                                    <?php } else {?>
                                                        <span class="badge bg-danger">Inactif</span>
                                                    <?php }  ?>
                                                </td>
                                                <td align="center">
                                                    @can($lien.'-edit')
                                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($cle->id_cle_de_repartition_financement)) }}"
                                                           class=" "
                                                           title="Modifier"><img src='/assets/img/editing.png'></a>
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!--end: Datatable-->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
