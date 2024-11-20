<?php

use App\Helpers\Menu;
use App\Helpers\AnneeExercice;
use App\Helpers\ListeDemandeHabilitationSoumis;
use Carbon\Carbon;
$imagedashboard = Menu::get_info_image_dashboard();
$imagedashboard = Menu::get_info_image_dashboard();
$numAgce = Auth::user()->num_agce;
$idlivreur = Auth::user()->id;
$lien = 'traitementlivraisonprix';

$demandehabilitations = ListeDemandeHabilitationSoumis::get_livraisons_livreur($idlivreur);
?>
<!-- Hour chart  -->
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-12 card-separator">
            <h3 class="text text-dark"> Bonjour {{ Auth::user()->name . ' ' . Auth::user()->prenom_users }}</strong>,
                👋🏻
            </h3>
            <div class="col-12 col-lg-12">
                <p>Bienvenue sur LOS LIVRAISON ! Nous sommes ravis de vous avoir parmi nous. Nous espérons que
                    vous apprécierez votre expérience avec nous !</p>
            </div>
        </div>
        <br>
        <br>
        <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
            <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                <span class="bg-label-info p-2 rounded">
                    <i class="ti ti-device-laptop ti-xl"></i>
                </span>
                <div class="content-right">
                    <p class="mb-0">Nouvelle de livaison en attente de traiment</p>
                    <h4 class="text-info mb-0">0</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="bg-label-success p-2 rounded">
                    <i class="ti ti-bulb ti-xl"></i>
                </span>
                <div class="content-right">
                    <p class="mb-0">Nouvelle de livaison en cours de livraison</p>
                    <h4 class="text-success mb-0">0</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="bg-label-default p-2 rounded">
                    <i class="ti ti-discount-check ti-xl"></i>
                </span>
                <div class="content-right">
                    <p class="mb-0">Nouvelle de livaison livré</p>
                    <h4 class="text-default mb-0">0</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="bg-label-warning p-2 rounded">
                    <i class="ti ti-discount-check ti-xl"></i>
                </span>
                <div class="content-right">
                    <p class="mb-0">Nouvelle de livaison echoué</p>
                    <h4 class="text-warning mb-0">0</h4>
                    {{-- {{ count($demandehabilitationssb) }} --}}
                </div>
            </div>

        </div>
    </div>


</div>

<div class="row  mb-12 g-12">
    <div class="row mb-12 g-12">
        <div class="col-12 col-xl-12 col-md-12">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Nouvelle(s) demande(s) de livraisons</h5>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-borderless border-top">
                        <thead class="border-bottom">
                            <tr>
                                <th>Expediteur / Lieu </th>
                                <th>Destinataire / Lieu</th>
                                <th>Prix / Code</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($demandehabilitations as $demandehabilitation)
                                <tr>
                                    <td class="pt-2">
                                        <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0">{{ $demandehabilitation->nom_exp }}</h6>
                                                <small
                                                    class="text-truncate text-muted">{{ $demandehabilitation->localite->libelle_localite }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pt-2">
                                        <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0">{{ $demandehabilitation->nom_dest }}</h6>
                                                <small
                                                    class="text-truncate text-muted">{{ $demandehabilitation->localitedest->libelle_localite }}</small>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="pt-2">
                                        <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0">{{ $demandehabilitation->prix }}</h6>
                                                <small
                                                    class="text-truncate text-muted">{{ $demandehabilitation->code_livraison }}</small>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pt-2">
                                        <div class="user-progress mt-lg-4">

                                            <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($demandehabilitation->id_livraison)]) }}"
                                                class=" " title="Traiter la livraison"><img
                                                    src='/assets/img/editing.png'></a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Hour chart End  -->
<div class="row mb-4 g-4">
    <div class="col-12 col-xl-12">
        <div class="card h-100">
            <div align="center">
                <img src="{{ asset('/frontend/logo/' . $imagedashboard->logo_logo) }}" alt="">
            </div>
        </div>
    </div>
</div>
