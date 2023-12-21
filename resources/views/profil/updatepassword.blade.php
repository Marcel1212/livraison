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
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
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
                                        <span class="fw-bolder me-25">Status:</span>
                                        <span class="badge bg-success">Active</span>
                                    </li>
                                    <li class="mb-75">
                                        <span class="fw-bolder me-25">Role:</span>
                                        <span>{{strtoupper($naroles) }}</span>
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
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
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
                                                    <label>N° de compte contribuable </label>
                                                    <input type="text"
                                                           class="form-control form-control-sm"
                                                           value="{{@$infoentreprise->ncc_entreprises}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Activité </label>
                                                    <input type="text"
                                                           class="form-control form-control-sm"
                                                           value="{{@$infoentreprise->activite->libelle_activites}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Localisation geaographique </label>
                                                    <input type="text" name="localisation_geographique_entreprise"
                                                           id="localisation_geographique_entreprise"
                                                           class="form-control form-control-sm"
                                                           value="{{@$infoentreprise->localisation_geographique_entreprise}}"
                                                           required="required">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Repère d'accès </label>
                                                    <input type="text" name="repere_acces_entreprises"
                                                           id="repere_acces_entreprises"
                                                           class="form-control form-control-sm"
                                                           value="{{@$infoentreprise->repere_acces_entreprises}}"
                                                           required="required">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Adresse postal </label>
                                                    <input type="text" name="adresse_postal_entreprises"
                                                           id="adresse_postal_entreprises"
                                                           class="form-control form-control-sm"
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
                                                            <label class="form-label">Telephone </label>
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
                                                            <label class="form-label">Contact Professionnelle </label>
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
                                            <div class="col-sm-9 offset-sm-3">

                                                <hr>
                                                <button type="submit" name="action" value="profil_entreprise"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Modifier
                                                </button>
                                            </div>
                                        </div>
                                    </form>

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
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" name="action" value="autre_profil"
                                                        class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                    Modifier
                                                </button>
                                                <button type="reset"
                                                        class="btn btn-outline-secondary waves-effect">Annuler
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Content-->
@endsection
