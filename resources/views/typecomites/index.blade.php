@if(auth()->user()->can('typecomites-index'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Paramétrage')
    @php($titre='Liste des types de comités')
    @php($lien='typecomites')

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
                                                <a href="{{ route($lien.'.create') }}"
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
                                            <th>Libellé</th>
                                            <th>Valeur min</th>
                                            <th>Valeur max</th>
                                            <th>Type de prestation</th>
                                            <th>Actif</th>
                                            <th >Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; ?>
                                        @foreach ($typecomites as $key => $typecomite)
                                        <?php $i += 1;?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $typecomite->libelle_type_comite }}</td>
                                                <td>{{ number_format($typecomite->valeur_min_type_comite, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($typecomite->valeur_max_type_comite, 0, ',', ' ') }}</td>
                                                <td><?php if($typecomite->code_type_comite=="PF"){
                                                    echo "Plan de formation";
                                                }elseif ($typecomite->code_type_comite=="PRF") {
                                                    echo "Projet de formation";
                                                }elseif ($typecomite->code_type_comite=="PE") {
                                                    echo "Projet etude";
                                                }else {
                                                    echo "";
                                                }?></td>
                                                <td align="center">
                                                    <?php if ($typecomite->flag_actif_type_comite == true ){?>
                                                    <span class="badge bg-success">Actif</span>
                                                    <?php } else {?>
                                                    <span class="badge bg-danger">Inactif</span>
                                                    <?php }  ?>
                                                </td>
                                                <td align="center">
                                                    @can($lien.'-edit')
                                                        <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($typecomite->id_type_comite)) }}"
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
