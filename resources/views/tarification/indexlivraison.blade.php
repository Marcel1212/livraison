@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Livraisons')
    @php($titre = 'Liste des livraisons')
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
                                    @if ($nomrole == 'CLIENT')
                                        <span align="right">
                                            <a href="{{ route('livraison') }}"
                                                class="btn btn-sm btn-primary waves-effect waves-light">
                                                <i class="menu-icon tf-icons ti ti-plus"></i> Creer une livraison</a>
                                        </span>
                                    @endif



                                </div>
                                <div class="card-body">
                                    <div class="table">
                                        <!--begin: Datatable-->
                                        <table class="table table-bordered table-striped table-hover table-sm "
                                            id="exampleData" style="margin-top: 13px !important">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Expediteur / Lieu </th>
                                                    <th>Destinataire / Lieu</th>
                                                    <th>Prix / Code</th>
                                                    <th>Date de livraison</th>
                                                    @if ($nomrole != 'CLIENT')
                                                        <th>Statut traitement</th>
                                                    @endif

                                                    <th>Statut livraison</th>
                                                    <th class="text-end">Actions</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($livraison as $livraisons)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>
                                                            <h6 class="mb-0">{{ $livraisons->nom_exp }}</h6>
                                                            <small
                                                                class="text-truncate text-muted">{{ $livraisons->localite->libelle_localite }}</small>


                                                        </td>
                                                        <td>

                                                            <h6 class="mb-0">{{ $livraisons->nom_dest }}</h6>
                                                            <small
                                                                class="text-truncate text-muted">{{ $livraisons->localitedest->libelle_localite }}</small>

                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0">{{ $livraisons->prix }}</h6>
                                                            <small
                                                                class="text-truncate text-muted">{{ $livraisons->code_livraison }}</small>
                                                        </td>
                                                        <td>

                                                            <?php
                                                            $locale = 'fr_FR';
                                                            $dateActuelle = new \DateTime($livraisons->date_livraison);
                                                            $dateFormatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
                                                            $dateFormatee = $dateFormatter->format($dateActuelle);
                                                            ?>
                                                            {{ $dateFormatee }} </td>
                                                        @if ($nomrole != 'CLIENT')
                                                            <td align="center">
                                                                <?php if ($livraisons->flag_a_traite == true ){?>
                                                                <span class="badge bg-success">Livraison traitée & affecté a
                                                                    un
                                                                    livreur</span>
                                                                <?php } else {?>
                                                                {{-- <div class="spinner-grow text-danger" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div> <br> --}}
                                                                <span class="badge bg-danger">Livraison à traité </span>
                                                                <br>

                                                                <?php }  ?>
                                                            </td>
                                                        @endif


                                                        <td align="center">
                                                            <?php if ($livraisons->flag_en_attente == true && $livraisons->flag_livre == false  ){?>
                                                            <span class="badge bg-warning">Livraison en cours</span>
                                                            <?php } ?>
                                                            <?php if ($livraisons->flag_en_attente == false   ) {?>
                                                            <span class="badge bg-danger">Livraison non en cours</span>
                                                            <?php }  ?>

                                                            <?php if ($livraisons->flag_livre == true ){?>
                                                            <span class="badge bg-success">Livraison effectué avec
                                                                succ</span>
                                                            <?php } ?>
                                                        </td>

                                                        <td class="text-end pt-2">
                                                            <div class="user-progress mt-lg-4">

                                                                <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($livraisons->id_livraison)]) }}"
                                                                    class=" " title="Traiter la livraison"><img
                                                                        src='/assets/img/editing.png'></a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach


                                            </tbody>
                                        </table>




                                        {{-- <table class="table table-bordered table-striped table-hover table-sm "
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
                                        </table> --}}
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
