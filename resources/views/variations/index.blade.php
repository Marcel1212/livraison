@if(auth()->user()->can('variations-index'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Paramétrage')
    @php($titre='Liste des variations des pourcentages liée aux clés de répartitions')
    @php($lien='variations')

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
                                            <th>Valeurs</th>
                                            <th>Signe</th>
                                            <th>Commentaire</th>
                                            <th>Actif</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($variations as $key => $part)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $part->valeur_vpcrf }}</td>
                                                    <td align="center">
                                                        <?php if ($part->flag_signe_variation == true){ ?>
                                                            <span class="btn btn-outline-primary round waves-effect">Ajouter</span>
                                                        <?php } else { ?>
                                                            <span class="btn btn-outline-warning round waves-effect">Déduire</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>{{ $part->commentaire_vpcrf }}</td>

                                                    <td align="center">
                                                            <?php if ($part->flag_actif_vpcrf == true){ ?>
                                                        <span class="badge bg-success">Actif</span>
                                                        <?php } else { ?>
                                                        <span class="badge bg-danger">Inactif</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td align="center">
                                                        @can($lien.'-edit')
                                                            <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($part->id_vpcrf)) }}"
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
