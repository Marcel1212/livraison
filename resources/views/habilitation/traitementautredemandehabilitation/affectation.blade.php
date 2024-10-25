<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@if(auth()->user()->can('traitementautredemandehabilitation-index'))

    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Habilitation')
        @php($titre='Liste des demandes de suppression de domaine')
        @php($lien='traitementautredemandehabilitation')

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

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="row g-6 mb-2">
                    <div class="col-sm-6 col-xl-2">
                            <div class="card border border-warning">

                            <a href="{{route('traitementautredemandehabilitation')}}" class="card-body text-white">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <span class=" text-heading">Demandes en attente de validation</span>
                                        <span class="bg-danger badge">
                                            <?php $j=0; ?>
                                            @foreach ($resultat as $demandesuppressiondomais)
                                                @foreach ($demandesuppressiondomais as  $key => $demandesuppressiondomai)
                                                        <?php $j = $j+1; ?>
                                                @endforeach
                                            @endforeach
                                            @if(isset($j))
                                            {{@$j}}
                                                @endif
                                        </span>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-2">
                        <div class="card border bg-warning">
                            <a href="{{route('traitementdemandehabilitation.affectation')}}" class="card-body text-heading">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <span class=" fw-bold text-white">Demandes en attente d'affectation
                                         </span>
                                        <span class="bg-danger badge">{{$demandesuppressiondomaines->count()}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{$titre}}</h5>

                    </div>
                    <div class="card-body">


                        <!--end: Datatable-->
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


