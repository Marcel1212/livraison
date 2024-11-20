@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Parametre')
    @php($titre = 'Liste des tarifs')
    @php($lien = 'traitementlivraisonprix')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
                {{ $titre }}
            </h5>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($message = Session::get('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <div class="content-body">

                <section id="multiple-column-form">
                    <div class="row">

                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">{{ $titre }}</h5>
                                    <?php //if ($nomrole == 'ENTREPRISE') {
                                    ?>
                                    <span align="right">
                                        <a href="{{ route($lien . '.create') }}"
                                            class="btn btn-sm btn-primary waves-effect waves-light">
                                            <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter une tarification</a>

                                    </span>

                                    <?php // }
                                    ?>
                                </div>
                                <div class="card-body">
                                    <div class="table">
                                        <!--begin: Datatable-->
                                        <table class="table table-bordered table-striped table-hover table-sm "
                                            id="exampleData" style="margin-top: 13px !important">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Lieu d'expedition</th>
                                                    <th>Lieu de destination</th>
                                                    <th>Prix</th>
                                                    <th>Statut</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($tarification as $key => $tarifications)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{ $tarifications->localite->libelle_localite }}</td>
                                                        <td>{{ $tarifications->localitedest->libelle_localite }}</td>
                                                        <td>{{ $tarifications->prix }}</td>
                                                        <td align="center">
                                                            <?php if ($tarifications->flag_valide == true ){?>
                                                            <span class="badge bg-success">Actif</span>
                                                            <?php } else {?>
                                                            <span class="badge bg-danger">Inactif</span>
                                                            <?php }  ?>
                                                        </td>



                                                        <td align="center">
                                                            <a href="{{ route($lien . '.edit', \App\Helpers\Crypt::UrlCrypt($tarifications->id_tarif_livraison)) }}"
                                                                class=" " title="Modifier"><img
                                                                    src='/assets/img/editing.png'></a>
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
                    </div>
                </section>
            </div>


        </div>
    </div>
    <!-- END: Content-->
@endsection
