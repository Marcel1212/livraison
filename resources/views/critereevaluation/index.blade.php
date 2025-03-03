@if(auth()->user()->can('critereevaluation-index'))
    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Paramétrage')
        @php($titre='Liste des criteres evaluations')
        @php($lien='critereevaluation')
        @php($lienacceuil='dashboard')


        <!-- BEGIN: Content-->
        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light">   <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i> Accueil</a> / {{$Module}} / </span> {{$titre}}
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

                        <table class="table table-bordered table-striped table-hover table-sm "
                            id="exampleData" >
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Libelle</th>
                                <th>Type de comité</th>
                                <th>Processus</th>
                                <th>Actif</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; ?>
                            @foreach ($criteres as $key => $res)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ @$res->libelle_critere_evaluation }}</td>
                                    <td>{{ @$res->categorieComite->libelle_categorie_comite }}</td>
                                    <td>{{ @$res->processusComite->libelle_processus_comite }}</td>
                                    <td align="center">
                                            <?php if($res->flag_critere_evaluation == true){ ?>
                                        <span class="badge bg-success">Actif</span>
                                        <?php  }else{?>
                                        <span class="badge bg-danger">Inactif</span>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        @can($lien.'-edit')
                                            <a href="{{ route($lien.'.edit',\App\Helpers\Crypt::UrlCrypt($res->id_critere_evaluation)) }}"
                                            class="text-warning "
                                            title="Modifier"><img src='/assets/img/editing.png'></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


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

