@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module = 'Projet d\'etude')
    @php($titre = 'Liste des comités permanents')
    @php($soustitre = 'Tenue de comité permanent')
    @php($lien = 'comitepermanenteprojetetude')


    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / {{ $titre }} /
        </span> {{ $soustitre }}
    </h5>




    <div class="content-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-xl-12">
            <h6 class="text-muted"></h6>
            <div class="nav-align-top nav-tabs-shadow mb-4">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if ($idetape == 1) {
                            echo 'active';
                        } ?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-planformation" aria-controls="navs-top-planformation"
                            aria-selected="true">
                            Comité permanent
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if ($idetape == 2) {
                            echo 'active';
                        } ?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-categorieplan" aria-controls="navs-top-categorieplan"
                            aria-selected="false">
                            Personnes ressources
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if ($idetape == 3) {
                            echo 'active';
                        } ?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-actionformation" aria-controls="navs-top-actionformation"
                            aria-selected="false">
                            Liste des projets d'etudes
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if(count($ficheagrements)<1){ echo 'disabled'; }?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-cahieraprescomite" aria-controls="navs-top-cahieraprescomite"
                            aria-selected="false"
                        >
                            Agrément
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade <?php if ($idetape == 1) {
                        echo 'show active';
                    } ?>" id="navs-top-planformation" role="tabpanel">
                        <form method="POST" class="form"
                            action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Date de debut <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_debut_comite_permanente"
                                            class="form-control form-control-sm"
                                            value="{{ $comitepermanente->date_debut_comite_permanente }}" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Date de fin <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_fin_comite_permanente"
                                            class="form-control form-control-sm"
                                            value="{{ $comitepermanente->date_fin_comite_permanente }}" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire <strong style="color:red;">*</strong></label>
                                        <textarea class="form-control form-control-sm" name="commentaire_comite_permanente" id="commentaire_comite_permanente"
                                            rows="6">{{ $comitepermanente->commentaire_comite_permanente }}</textarea>

                                    </div>
                                </div>


                                <div class="col-12" align="right">
                                    <hr>
                                    <?php if($comitepermanente->flag_statut_comite_permanente == false){?>
                                    <button type="submit" name="action" value="Modifier"
                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Modifier
                                    </button>
                                    <?php } ?>
                                    <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                        class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade <?php if ($idetape == 2) {
                        echo 'show active';
                    } ?>" id="navs-top-categorieplan" role="tabpanel">

                        <?php if ($comitepermanente->flag_statut_comite_permanente != true){ ?>
                        <form method="POST" class="form"
                            action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(2)]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12 col-md-10">
                                    <label class="form-label" for="id_user_comite_permanente_participant">Participants <strong
                                            style="color:red;">*</strong></label>
                                    <select id="id_user_comite_permanente_participant"
                                        name="id_user_comite_permanente_participant"
                                        class="select2 form-select-sm input-group" aria-label="Default select example"
                                        required="required">
                                        <?= $conseiller ?>
                                    </select>
                                </div>



                                <div class="col-12 col-md-2" align="right"> <br>
                                    <button type="submit" name="action" value="Enregistrer_conseil_poour_comite"
                                        class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>
                                </div>

                            </div>

                        </form>

                        <hr>
                        <?php } ?>
                        <table class="table table-bordered table-striped table-hover table-sm" id=""
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($comitepermanenteparticipant as $key => $comitepermanenteparticipan)
                                    <?php $i += 1; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $comitepermanenteparticipan->user->name }}</td>
                                        <td>{{ $comitepermanenteparticipan->user->prenom_users }}</td>
                                        <td>
                                            <?php if ($comitepermanente->flag_statut_comite_permanente != true){ ?>
                                            <a href="{{ route($lien . '.delete', \App\Helpers\Crypt::UrlCrypt($comitepermanenteparticipan->id_comite_permanente_participant)) }}"
                                                class=""
                                                onclick='javascript:if (!confirm("Voulez-vous supprimer cet conseiller de cette commission ?")) return false;'
                                                title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="col-12" align="right">
                            <hr>

                            <?php if (count($comitepermanenteparticipant)>=1){ ?>


                            <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>
                                <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                    class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


                                    <?php } ?>

                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                        Retour</a>
                        </div>
                    </div>

                    <div class="tab-pane fade  <?php if ($idetape == 3) {
                        echo 'show active';
                    } ?>" id="navs-top-actionformation" role="tabpanel">

                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Entreprise </th>
                                    <th>Code </th>
                                    <th>Titre du projet </th>
                                    <th>Date soumis</th>
                                    <th>Cout du projet</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php //dd($projetetudes);
                                $i = 0; ?>
                                @foreach ($projetetudes as $key => $projetetude)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ @$projetetude->entreprise->ncc_entreprises }} /
                                            {{ @$projetetude->entreprise->raison_social_entreprises }}</td>
                                        <td>{{ @$projetetude->code_projet_etude }}</td>
                                        <td>{{ @$projetetude->titre_projet_etude }}</td>
                                        <td>{{ $projetetude->date_soumis }}</td>
                                        <td align="rigth">
                                            {{ number_format($projetetude->montant_projet_instruction) }}</td>

                                        <td align="center">
                                            <?php if($comitepermanente->flag_statut_comite_permanente == false && count($comitepermanenteparticipant)>=1){?>
{{--                                            @can($lien . '-edit')--}}
                                                <a href="{{ route($lien . '.editer', [\App\Helpers\Crypt::UrlCrypt($projetetude->id_projet_etude), \App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                                    class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
{{--                                            @endcan--}}
                                            <?php } ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-12" align="right">
                            <hr>




                            <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>
                                <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                    class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


                                    <?php //}
                                    ?>

                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                        Retour</a>
                        </div>
                    </div>
                    <div class="tab-pane fade<?php if ($idetape == 4) {
                        echo 'show active';
                    } if(count($ficheagrements)<1 and count($comitepermanenteparticipant)<1){ echo 'disabled'; }?>" id="navs-top-cahieraprescomite" role="tabpanel">

                        <?php  if(count($ficheagrements)>=1 and $comitepermanente->flag_statut_comite_permanente == false){?>
                        <div class="col-12" align="right">
                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <button type="submit" name="action" value="Traiter_cahier_projet"
                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                    Valider le comite de permanente
                                </button>
                            </form>
                        </div>
                        <?php } ?>
                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Entreprise </th>
                                <th>Code </th>
                                <th>Titre du projet </th>
                                <th>Cout demandé</th>
                                <th>Cout accordé </th>
                                <th>Date soumis</th>

                            </tr>

                            </thead>
                            <tbody>

                                <?php //dd($projetetudes);
                                $i = 0; ?>
                                @foreach ($ficheagrements as $key => $projetetude)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ @$projetetude->ncc_entreprises }} /
                                            {{ @$projetetude->raison_social_entreprises }}</td>
                                        <td>{{ @$projetetude->code_projet_etude }}</td>
                                        <td>{{ @$projetetude->titre_projet_etude }}</td>
                                        <td align="rigth">
                                            {{ number_format($projetetude->montant_projet_instruction) }}</td>
                                        <td align="rigth">
                                            {{ number_format($projetetude->montant_projet) }}</td>
                                        <td>{{ $projetetude->date_soumis }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="col-12" align="right">
                            <hr>

                            <?php if (count($ficheagrements)>=1){ ?>


                            <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comitepermanente->id_comite_permanente), \App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                <?php } ?>

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                    Retour</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
