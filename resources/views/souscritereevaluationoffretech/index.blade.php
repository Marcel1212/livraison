@if(auth()->user()->can('souscritereevaluationoffretech-index'))
@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Paramétrage')
    @php($titre='Liste des sous-critères d\'évaluations des offres techniques')
    @php($lien='souscritereevaluationoffretech')

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
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">{{$titre}}</h5>
                                        <small class="text-muted float-end">
                                            @can($lien.'-create')
                                                <a href="{{route($lien.'.create')}}"
                                                class="btn btn-sm btn-primary waves-effect waves-light">
                                                    <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter </a>
                                            @endcan
                                        </small>
                                    </div>
                                    <div class="card-body">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered table-striped table-hover table-sm "
                                             id="exampleData"
                                             style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Libellé Sous-critère</th>
                                            <th>Critère</th>
                                            <th>Actif</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($souscritereevaluationoffretechs as $key => $souscritereevaluationoffretech)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ @$souscritereevaluationoffretech->libelle_sous_critere_evaluation_offre_tech }}</td>
                                                <td>{{ @$souscritereevaluationoffretech->critereevaluationoffretech->libelle_critere_evaluation_offre_tech }}</td>
                                                <td align="center">
                                                    <?php if (@$souscritereevaluationoffretech->flag_sous_critere_evaluation_offre_tech == true ){?>
                                                    <span class="badge bg-success">Actif</span>
                                                    <?php } else {?>
                                                    <span class="badge bg-danger">Inactif</span>
                                                    <?php }  ?>
                                                </td>
                                                <td align="center">
                                                    @can($lien.'-edit')
                                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($souscritereevaluationoffretech->id_sous_critere_evaluation_offre_tech)) }}"
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
    <!-- END: Content-->
@endsection
@else
 <script type="text/javascript">
    window.location = "{{ url('/403') }}";//here double curly bracket
</script>
@endif
