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
                <h6 class="text-muted"></h6>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        @if(App\Helpers\Menu::get_code_menu_profil(Auth::user()->id) == 'CHARGEHABIL')

                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link "
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-instruction"
                                    aria-controls="navs-top-instruction"
                                    aria-selected="true">
                                    Demandes en attente d'instruction
                                    <span class="ms-1 badge bg-danger"> {{$autre_demande_habilitation_formations->count()}}</span>
                                </button>
                            </li>
                        @endif
                        @if(App\Helpers\Menu::get_code_menu_profil(Auth::user()->id) == 'CHEFSERVICE')

                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link show active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-affectation"
                                aria-controls="navs-top-affectation"
                                aria-selected="true">
                                Demandes en attente d'affectation
                                <span class="ms-1 badge bg-danger"> {{$autre_demande_habilitation_formations->count()}}</span>
                            </button>
                        </li>
                        @endif
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link @if(App\Helpers\Menu::get_code_menu_profil(Auth::user()->id) != 'CHEFSERVICE') show active @endif"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-attente"
                                aria-controls="navs-top-attente"
                                aria-selected="false">
                                Demandes en attente de validation
                                    <?php $j=0; ?>
                                @foreach ($resultat as $demandesuppressiondomais)
                                    @foreach ($demandesuppressiondomais as  $key => $autre_demande_habilitation_formation)
                                            <?php $j = $j+1; ?>
                                    @endforeach
                                @endforeach
                                <span class="ms-1 badge bg-danger">{{@$j}}</span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @if(App\Helpers\Menu::get_code_menu_profil(Auth::user()->id) == 'CHEFSERVICE')

                        <div class="tab-pane fade show active" id="navs-top-affectation" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id="exampleData"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code </th>
                                    <th>Type de demande </th>
                                    <th>Entreprise </th>
                                    <th>Responsable formation </th>
                                    <th>Date de création</th>
                                    <th>Date de soumission</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; ?>

                                @foreach ($autre_demande_habilitation_formations as $key => $autre_demande_habilitation_formation)
                                    <tr>
                                        <td>{{ ++$i }}</td>

                                        <td>{{@$autre_demande_habilitation_formation->code_autre_demande_habilitation_formation}}</td>
                                        <td>
                                            @if(@$autre_demande_habilitation_formation->type_autre_demande=='demande_suppression')
                                                Demande de suppression
                                            @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                Demande d'extension
                                            @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_substitution')
                                                Demande de substitution
                                            @endif
                                        </td>
                                        <td>{{ @$autre_demande_habilitation_formation->raison_social_entreprises }}</td>
                                        <td>{{ @$autre_demande_habilitation_formation->nom_responsable_demande_habilitation }}</td>
                                        <td>{{ date('d/m/Y H:i:s',strtotime(@$autre_demande_habilitation_formation->date_enregistrer_autre_demande_habilitation_formation))  }}</td>
                                        <td>{{ date('d/m/Y H:i:s',strtotime(@$autre_demande_habilitation_formation->date_soumis_autre_demande_habilitation_formation))  }}</td>
                                        <td align="">

                                            @if($autre_demande_habilitation_formation->flag_rejeter_domaine_autre_demande_habilitation_formation==false &&
    $autre_demande_habilitation_formation->flag_validation_domaine_autre_demande_habilitation_formation==false
                                                             )
                                                <span class="badge bg-warning">En cours de traitement</span>
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if(@$autre_demande_habilitation_formation->type_autre_demande=='demande_suppression')
                                                <a href="{{ route($lien.'.editaffectation',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),\App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                                   class=" "
                                                   title="Modifier"><img
                                                        src='/assets/img/editing.png'></a>
                                            @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                <a href="{{ route($lien.'.editaffectationExtension',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),\App\Helpers\Crypt::UrlCrypt(5)]) }}"
                                                   class=" "
                                                   title="Modifier"><img
                                                        src='/assets/img/editing.png'></a>
                                            @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_substitution')
                                                <a href="{{ route($lien.'.editaffectationsubsitution',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),\App\Helpers\Crypt::UrlCrypt(5)]) }}"
                                                   class=" "
                                                   title="Modifier"><img
                                                        src='/assets/img/editing.png'></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                            @if(App\Helpers\Menu::get_code_menu_profil(Auth::user()->id) == 'CHARGEHABIL')

                                <div class="tab-pane fade" id="navs-top-instruction" role="tabpanel">
                                    <table class="table table-bordered table-striped table-hover table-sm"
                                           id="exampleData"
                                           style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Code </th>
                                            <th>Type de demande </th>
                                            <th>Entreprise </th>
                                            <th>Responsable formation </th>
                                            <th>Date de création</th>
                                            <th>Date de soumission</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; ?>

                                        @foreach ($autre_demande_habilitation_formations as $key => $autre_demande_habilitation_formation)
                                            <tr>
                                                <td>{{ ++$i }}</td>

                                                <td>{{@$autre_demande_habilitation_formation->code_autre_demande_habilitation_formation}}</td>
                                                <td>
                                                    @if(@$autre_demande_habilitation_formation->type_autre_demande=='demande_suppression')
                                                        Demande de suppression
                                                    @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                        Demande d'extension
                                                    @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_substitution')
                                                        Demande de substitution
                                                    @endif
                                                </td>
                                                <td>{{ @$autre_demande_habilitation_formation->raison_social_entreprises }}</td>
                                                <td>{{ @$autre_demande_habilitation_formation->nom_responsable_demande_habilitation }}</td>
                                                <td>{{ date('d/m/Y d:i:s',strtotime(@$autre_demande_habilitation_formation->date_enregistrer_autre_demande_habilitation_formation))  }}</td>
                                                <td>{{ date('d/m/Y d:i:s',strtotime(@$autre_demande_habilitation_formation->date_soumis_autre_demande_habilitation_formation))  }}</td>
                                                <td align="">

                                                    @if($autre_demande_habilitation_formation->flag_rejeter_domaine_autre_demande_habilitation_formation==false &&
            $autre_demande_habilitation_formation->flag_validation_domaine_autre_demande_habilitation_formation==false
                                                                     )
                                                        <span class="badge bg-warning">En cours de traitement</span>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    @if(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                        <a href="{{ route($lien.'.editExtension',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),\App\Helpers\Crypt::UrlCrypt(5)]) }}"
                                                           class=" "
                                                           title="Modifier"><img
                                                                src='/assets/img/editing.png'></a>
                                                    @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_substitution')
                                                        <a href="{{ route($lien.'.editsubstitution',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),\App\Helpers\Crypt::UrlCrypt(5)]) }}"
                                                           class=" "
                                                           title="Modifier"><img
                                                                src='/assets/img/editing.png'></a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif


                            <div class="tab-pane fade @if(App\Helpers\Menu::get_code_menu_profil(Auth::user()->id) != 'CHEFSERVICE') show active @endif" id="navs-top-attente" role="tabpanel">
                             <table class="table table-bordered table-striped table-hover table-sm"
                                           id="exampleData"
                                           style="margin-top: 13px !important">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Code </th>
                                            <th>Type de demande</th>
                                            <th>Entreprise </th>
                                            <th>Responsable formation </th>
                                            <th>Date de création</th>
                                            <th>Date de soumission</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; ?>

                                        @foreach ($resultat as $autre_demande_habilitation_formations)
                                            @foreach ($autre_demande_habilitation_formations as  $key => $autre_demande_habilitation_formation)
                                                <tr>
                                                    <td>{{ $key+1}}</td>
                                                    <td>{{@$autre_demande_habilitation_formation->code_autre_demande_habilitation_formation}}</td>
                                                    <td>
                                                        @if(@$autre_demande_habilitation_formation->type_autre_demande=='demande_suppression')
                                                            Demande de suppression
                                                        @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                            Demande d'extension
                                                        @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_substitution')
                                                            Demande de substitution
                                                        @endif
                                                    </td>
                                                    <td>{{ @$autre_demande_habilitation_formation->raison_social_entreprises }}</td>
                                                    <td>{{ @$autre_demande_habilitation_formation->nom_responsable_demande_habilitation }}</td>
                                                    <td>{{ @$autre_demande_habilitation_formation->date_creer_demande_habilitation }}</td>
                                                    <td>{{ @$autre_demande_habilitation_formation->date_soumis_demande_habilitation }}</td>
                                                    <td align="center">
                                                        <span class="badge bg-warning">En Attente de traitement</span>
                                                    </td>
                                                    <td align="center">
                                                        <a href="{{ route($lien . '.edit',[\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation),
                                                                        \App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_combi_proc)] ) }}"
                                                           class=" " title="Modifier"><img
                                                                src='/assets/img/editing.png'></a>
                                                    </td>
                                                </tr>

                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                        </div>
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


