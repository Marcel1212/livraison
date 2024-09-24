@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Profil')
    @php($titre='Mon profil')
    @php($soustitre='Mise à jour des informations')

    <?php
    if (Auth::user()->photo_profil != '') {
        $iconUser = 'photoprofile/' . Auth::user()->photo_profil;
    } else {
        $iconUser = 'photoprofile/user.png';
    }
    ?>
        <!-- BEGIN: Content-->
    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i
                class="ti ti-home"></i>   {{$Module}} / {{$titre}} / </span> {{$soustitre}}
    </h5>

    <div class="content-body">
        <section class="app-user-view-account">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
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
            <div class="row">
                <!-- User Sidebar -->
                <div class="col-xl-3 col-lg-4 col-md-5 order-1 order-md-0">
                    <!-- User Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded   mb-1"
                                         src="{{$iconUser}}"
                                         height="110" width="110" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4>{{Auth::user()->name}}</h4>
                                        <span class="badge bg-light-secondary">{{strtoupper($naroles) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around my-1 pt-75">
                            </div>
                            <h4 class="fw-bolder border-bottom pb-50 mb-1">Détails</h4>
                            <div class="info-container">
                                <ul class="list-unstyled">

                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Email:</span>
                                        <span>{{Auth::user()->email}}</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Statut:</span>
                                        <span class="badge bg-success">Actif</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Role:</span>
                                        <span>{{strtoupper($naroles) }}</span>
                                    </li>
                                    <li class="mb-75">
                                        @if ( Auth::user()->direction)
                                        <span class="fw-bolder me-25">Direction:</span>
                                        <span >{{  Auth::user()->direction->libelle_direction}}</span>
                                        @endif
                                    </li>
                                    <li class="mb-75">
                                        @if ( Auth::user()->departement)
                                            <span class="fw-bolder me-25">Département:</span>
                                            <span >{{ Auth::user()->departement->libelle_departement }}</span>
                                            @endif
                                    </li>
                                    <li class="mb-75">
                                        @if ( Auth::user()->service)
                                        <span class="fw-bolder me-25">Service:</span>
                                        <span >{{ Auth::user()->service->libelle_service  }}</span>
                                        @endif
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Contact:</span>
                                        <span>{{Auth::user()->cel_users}} / {{Auth::user()->tel_users}}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center pt-2">
                                    <a href="{{ route('profil') }}"
                                       class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                        Mon profil
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /User Card -->

                    <!-- /Plan Card -->
                </div>
                <!--/ User Sidebar -->

                <!-- User Content -->
                <div class="col-xl-9 col-lg-8 col-md-7 order-0 order-md-1">
                    <!-- User Pills -->
                    <ul class="nav nav-pills mb-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round"
                                     class="feather feather-user font-medium-3 me-50">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="fw-bold"> Mon compte</span></a>
                        </li>

                    </ul>
                    <!--/ User Pills -->

                    <!-- Project table -->
                    <div class="card">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper"
                                 class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="card-body">

                                    <?php if ($naroles == "ENTREPRISE"){ ?>

                                        <div class="nav-align-top nav-tabs-shadow mb-4">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <button
                                                    type="button"
                                                    class="nav-link <?php if($idetape==1){ echo "active";}  ?>"
                                                    role="tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#navs-top-miseajour"
                                                    aria-controls="navs-top-miseajour"
                                                    aria-selected="true">
                                                        Mise a jour des informations
                                                    </button>
                                                </li>
                                                <li class="nav-item ">
                                                    <button
                                                    id="localisation"
                                                    type="button"
                                                    class="nav-link <?php if($idetape==2){ echo "active";}  ?>"
                                                    role="tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#navs-top-localisation"
                                                    aria-controls="navs-top-localisation"
                                                    aria-selected="false">
                                                        Localisation de l'entreprise
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button
                                                    type="button"
                                                    class="nav-link <?php if($idetape==3){ echo "active";}  ?>"
                                                    role="tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#navs-top-compositioncapitale"
                                                    aria-controls="navs-top-compositioncapitale"
                                                    aria-selected="false">
                                                        Composition du capitale
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button
                                                    type="button"
                                                    class="nav-link <?php if($idetape==4){ echo "active";}  ?>"
                                                    role="tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#navs-top-activite"
                                                    aria-controls="navs-top-activite"
                                                    aria-selected="false">
                                                        Activité
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} ?>" id="navs-top-miseajour" role="tabpanel">

                                                        <form method="POST" enctype="multipart/form-data"
                                                              class="form form-horizontal"
                                                              action="{{ route('modifier.mot.passe') }}">
                                                            @csrf
                                                            <div class="row">

                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Ancien mot de passe </label>
                                                                        <input type="password" id="fname-icon"
                                                                               class="form-control form-control-sm " name="cpwd"
                                                                               placeholder="Ancien mot de passe">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Nouveau mot de passe </label>
                                                                        <input type="password" id="fname-icon"
                                                                               class="form-control  form-control-sm" name="npwd"
                                                                               placeholder="Nouveau mot de passe">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Confirmer mot de passe </label>
                                                                        <input type="password" id="fname-icon"
                                                                               class="form-control form-control-sm" name="vpwd"
                                                                               placeholder="Confirmer mot de passe">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Numéro de compte contribuable (NCC)*</label>
                                                                        <input type="text"
                                                                               class="form-control form-control-sm"
                                                                               value="{{@$infoentreprise->ncc_entreprises}}"
                                                                               disabled="disabled">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Secteur d'activité </label>
                                                                        <input type="text"
                                                                               class="form-control form-control-sm"
                                                                               value="{{@$infoentreprise->secteurActivite->libelle_secteur_activite}}"
                                                                               disabled="disabled">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Localisation géographique </label>
                                                                        <input type="text" name="localisation_geographique_entreprise"
                                                                               id="localisation_geographique_entreprise"
                                                                               class="form-control form-control-sm"
                                                                               placeholder="Localisation géographique"
                                                                               value="{{@$infoentreprise->localisation_geographique_entreprise}}"
                                                                               required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Nom et prenom du dirigeant </label>
                                                                        <input type="text" name="nom_prenom_dirigeant"
                                                                               id="nom_prenom_dirigeant"
                                                                               class="form-control form-control-sm"
                                                                               placeholder="Nom et prenom du dirigeant"
                                                                               value="{{@$infoentreprise->nom_prenom_dirigeant}}"
                                                                               required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Repère d'accès </label>
                                                                        <input type="text" name="repere_acces_entreprises"
                                                                               id="repere_acces_entreprises"
                                                                               class="form-control form-control-sm"
                                                                               placeholder="Repère d'accès"
                                                                               value="{{@$infoentreprise->repere_acces_entreprises}}"
                                                                               required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Adresse postale </label>
                                                                        <input type="text" name="adresse_postal_entreprises"
                                                                               id="adresse_postal_entreprises"
                                                                               class="form-control form-control-sm"
                                                                               placeholder="Adresse postale"
                                                                               value="{{@$infoentreprise->adresse_postal_entreprises}}"
                                                                               required="required">
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label class="form-label"
                                                                                       for="billings-country">Indicatif</label>
                                                                                <select class="select2 form-select-sm input-group-text"
                                                                                        data-allow-clear="true" disabled="disabled">
                                                                                        <?= $pay; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <label class="form-label">Téléphone </label>
                                                                                <input type="text"
                                                                                       class="form-control form-control-sm"
                                                                                       value="{{@$infoentreprise->tel_entreprises}}"
                                                                                       name="tel_entreprises">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label class="form-label"
                                                                                       for="billings-country">Indicatif</label>
                                                                                <select class="select form-select-sm input-group-text"
                                                                                        data-allow-clear="true" disabled="disabled">
                                                                                        <?= $pay; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <label class="form-label">Contact Professionnel </label>
                                                                                <input type="number" min="0"
                                                                                       name="cellulaire_professionnel_entreprises"
                                                                                       id="cellulaire_professionnel_entreprises"
                                                                                       class="form-control form-control-sm"
                                                                                       value="{{@$infoentreprise->cellulaire_professionnel_entreprises}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label class="form-label"
                                                                                       for="billings-country">Indicatif</label>
                                                                                <select class="select2 form-select-sm input-group-text"
                                                                                        data-allow-clear="true" disabled="disabled">
                                                                                        <?= $pay; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <label class="form-label">Fax </label>
                                                                                <input type="number" name="fax_entreprises"
                                                                                       id="fax_entreprises"  min="0"
                                                                                       class="form-control form-control-sm"
                                                                                       value="{{@$infoentreprise->fax_entreprises}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="col-sm-12"  align="right">
                                                                    <button type="submit" name="action" value="profil_entreprise"
                                                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                                        Modifier
                                                                    </button>
                                                                    <a  href="{{ route('modifiermotpasse',[\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-warning me-sm-3 me-1">Suivant</a>
                                                                </div>
                                                            </div>
                                                        </form>

                                                </div>
                                                <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} ?>" id="navs-top-localisation" role="tabpanel">
                                                    <div id="mapid" style="height: 500px;"></div>
                                                    <br/>
                                                    <hr>
                                                    <div class="col-sm-12"  align="right">
                                                        <a  href="{{ route('modifier.mot.passe') }}"  class="btn btn-sm btn-defalut me-sm-3 me-1">Précédent</a>
                                                        <button id="savePosition" class="btn btn-sm btn-warning me-1 waves-effect waves-float waves-light">Enregistrer la position</button>
                                                        <a  href="{{ route('modifiermotpasse',[\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-warning me-sm-3 me-1">Suivant</a>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade <?php if($idetape==3){ echo "show active";} ?>" id="navs-top-compositioncapitale" role="tabpanel">
                                                    <div class="card">
                                                        <div class="table-responsive">
                                                            <div id="DataTables_Table_0_wrapper"
                                                                 class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                                <div class="card-body">
                                                                    <form method="POST" enctype="multipart/form-data"
                                                                        class="form form-horizontal"
                                                                        action="{{ route('modifier.mot.passe') }}">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-md-5 col-12">
                                                                                <label class="form-label">Liste des types de composition de capitale </label>

                                                                                <select class="select21 form-select"
                                                                                        data-allow-clear="true" name="id_type_composition_capitale"
                                                                                        required="required">
                                                                                    <?= $typeCompoCapitMAJList; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3 col-12">
                                                                                <label class="form-label">Montant </label>
                                                                                <input type="number" class="form-control form-control-sm" min="0" name="montant_composition_capitale"/>
                                                                            </div>
                                                                            <div class="col-md-4"  align="right"><br/>

																				<a  href="{{ route('modifiermotpasse',[\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-defult me-sm-3 me-1">Précédent</a>
																				<button type="submit" name="action" value="compositionCapitale"
																						class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
																					Ajouter
																				</button>
																				<a  href="{{ route('modifiermotpasse',[\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-warning me-sm-3 me-1">Suivant</a>
                                                                            </div>


                                                                        </div>
                                                                    </form>

                                                                    <table class="table table-bordered table-striped table-hover table-sm "
                                                                        id=""
                                                                        style="margin-top: 13px !important">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>composition de capitale </th>
                                                                                <th>montant </th>
                                                                                <th >Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i=0; ?>
                                                                            @foreach ($listecompocapitales as $key => $listecompocapitale)
                                                                                <tr>
                                                                                    <td>{{ ++$i }}</td>
                                                                                    <td>{{ $listecompocapitale->typeCompositionCapitale->libelle_type_composition_capitale }}</td>
                                                                                    <td>{{ number_format($listecompocapitale->montant_composition_capitale, 0, ',', ' ') }}</td>
                                                                                    <td align="center">
                                                                                    <a href="{{ route('deletecompositioncapitale',\App\Helpers\Crypt::UrlCrypt($listecompocapitale->id_composition_capitale)) }}"
                                                                                    class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cette ligne ?")) return false;'
                                                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
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
                                                <div class="tab-pane fade <?php if($idetape==4){ echo "show active";} ?>" id="navs-top-activite" role="tabpanel">
                                                    <div class="card">
                                                        <div class="table-responsive">
                                                            <div id="DataTables_Table_0_wrapper"
                                                                 class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                                <div class="card-body">
                                                                    <form method="POST" enctype="multipart/form-data"
                                                                        class="form form-horizontal"
                                                                        action="{{ route('modifier.mot.passe') }}">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-md-8 col-12">
                                                                                <label class="form-label">Liste des activités de liée à l'entreprise </label>

                                                                                <select class="select21 form-select"
                                                                                        data-allow-clear="true" name="id_activites"
                                                                                        >
                                                                                    <?= $activite; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-4"  align="right"><br/>

                                                                                <button type="submit" name="action" value="profil_entreprise_activite"
                                                                                        class="btn btn-sm btn-primary">
                                                                                    Ajouter activité
                                                                                </button>

                                                                                <a  href="{{ route('modifiermotpasse',[\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-defult me-sm-3 me-1">Précédent</a>

                                                                                <button type="submit" name="action" value="terminer"
                                                                                        class="btn btn-sm btn-success">
                                                                                    Terminer
                                                                                </button>
                                                                            </div>


                                                                        </div>
                                                                    </form>

                                                                    <table class="table table-bordered table-striped table-hover table-sm "
                                                                        id=""
                                                                        style="margin-top: 13px !important">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Activité </th>
                                                                                <th >Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i=0; ?>
                                                                            @foreach ($listeactivites as $key => $listeactivite)
                                                                                <tr>
                                                                                    <td>{{ ++$i }}</td>
                                                                                    <td>{{ $listeactivite->activite->libelle_activites }}</td>
                                                                                    <td align="center">
                                                                                    <a href="{{ route('deleteactiviteentreprise',\App\Helpers\Crypt::UrlCrypt($listeactivite->id_activites_entreprises)) }}"
                                                                                    class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cette ligne ?")) return false;'
                                                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
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
                                            </div>
                                        </div>

                                    <?php }else{ ?>
                                    <form method="POST" enctype="multipart/form-data"
                                          class="form form-horizontal"
                                          action="{{ route('modifier.mot.passe') }}">
                                        @csrf
                                        <div class="row">

                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label"
                                                               for="fname-icon">Ancien mot de passe </label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="input-group input-group-merge">
                                                                            <span class="input-group-text"> <i
                                                                                    data-feather='lock'></i></span>
                                                            <input type="password" id="fname-icon"
                                                                   class="form-control" name="cpwd"
                                                                   placeholder="Ancien mot de passe">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label"
                                                               for="fname-icon">Nouveau mot de passe </label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="input-group input-group-merge">
                                                                            <span class="input-group-text"> <i
                                                                                    data-feather='lock'></i></span>
                                                            <input type="password" id="fname-icon"
                                                                   class="form-control" name="npwd"
                                                                   placeholder="Nouveau mot de passe">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label"
                                                               for="fname-icon">Confirmer mot de passe </label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="input-group input-group-merge">
                                                                            <span class="input-group-text"> <i
                                                                                    data-feather='lock'></i></span>
                                                            <input type="password" id="fname-icon"
                                                                   class="form-control" name="vpwd"
                                                                   placeholder="Confirmer mot de passe">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-sm-12" align="right">
                                                <button type="submit" name="action" value="autre_profil"
                                                        class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                    Modifier
                                                </button>

                                            </div>
                                        </div>
                                    </form>
                                    <?php } ?>
                                </div>
                                </div>
                                </div>
                                </div>
                                <br/>

                </div>
                </div>
            </div>
            <!-- END: Content-->




@endsection
@section('js_perso')
<script>

    var mymap = L.map('mapid').setView([51.505, -0.09], 13);
    let selectedMarker;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // maxZoom: 1000,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mymap);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var marker = L.marker([lat, lng]).addTo(mymap);
            mymap.setView([lat, lng], 13);
            selectedMarker = L.marker([lat, lng]).addTo(mymap);
            //alert(lat);
        });
    } else {
        console.log("La géolocalisation n'est pas disponible.");
    }
    mymap.on('click', function(e) {
            if (selectedMarker) {
                mymap.removeLayer(selectedMarker);
            }
            selectedMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(mymap);
        });

        document.getElementById('savePosition').addEventListener('click', function() {
            if (selectedMarker) {
                const pos = selectedMarker.getLatLng();
                savePosition(pos.lat, pos.lng);
                //alert(pos.lat);alert(pos.lng);
            } else {
                alert('Veuillez sélectionner une position sur la carte.');
            }
        });

        function savePosition(lat, lng) {
            fetch('/save-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                //console.log(data.message);
                alert('Position enregistrée avec succès!');
                location.reload(); // Actualiser la page après l'enregistrement
            })
            .catch(error => console.error('Erreur:', error));
        }
    document.querySelector('#localisation').addEventListener('shown.bs.tab', function (e) {
        mymap.invalidateSize();
        });
</script>
@endsection
