@if(auth()->user()->can('cotisation-index'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Cotisation')
    @php($titre='Liste des cotisations')
    @php($lien='cotisation')

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
                                            <th>Montant</th>
                                            <th>Mois</th>
                                            <th>Année</th>
                                            <th>Date paiement</th>
                                            <th>Statut</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; ?>
                                        @foreach ($cotisations as $key => $cotisation)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ number_format($cotisation->montant) }}</td>
                                                <td>
                                                    <?php
                                                        $dateObj   = DateTime::createFromFormat('!m', $cotisation->mois_cotisation);
                                                        $monthName = $dateObj->format('M');
                                                        echo $monthName;
                                                    ?>

                                                </td>
                                                <td>{{ $cotisation->annee_cotisation }}</td>
                                                <td>{{ $cotisation->date_paiement }}</td>
                                                <td align="center">
                                                    <?php if ($cotisation->flag_cotisation == true ){?>
                                                    <span class="badge bg-success">Payé</span>
                                                    <?php } else {?>
                                                    <span class="badge bg-danger">Non payé</span>
                                                    <?php }  ?>
                                                </td>
                                                <td align="center">


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
