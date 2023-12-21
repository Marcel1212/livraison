@extends('layouts.backLayout.designadmin')
@section('content')
    <?php
    if (Auth::user()->photo_profil != '') {
        $iconUser = '/photoprofile/' . Auth::user()->photo_profil;
    } else {
        $iconUser = '/photoprofile/user.png';
    }
    ?>



        <!-- BEGIN: Content-->
    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Mon profil / Accueil / </span>  Mon profil
    </h5>

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="alert-body">
                {{ $message }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-body">
                {{ $message }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif




    <section class="app-user-view-account">

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
                                    <span class="badge bg-light-success">Active</span>
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
                                <a href="{{ route('modifier.mot.passe') }}"
                                   class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                >
                                    Je modifie mon mot de passe
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
                            <span class="fw-bold">Les informations de mon compte</span></a>
                    </li>

                </ul>
                <!--/ User Pills -->

                <!-- Project table -->
                <div class="card">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper"
                             class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="card-body">
                                <form method="POST" enctype="multipart/form-data"
                                      class="form form-horizontal" action="{{ route('profil') }}">
                                    @csrf

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label"
                                                           for="fname-icon">Photo de profil </label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="input-group input-group-merge">
                                                        <input class="form-control" type="file"
                                                               name="profile_avatar"
                                                               accept=".png, .jpg, .jpeg"/>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label"
                                                           for="fname-icon">Nom </label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="input-group input-group-merge">
                                                                    <span class="input-group-text"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="14" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-user"><path
                                                                                d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle
                                                                                cx="12" cy="7"
                                                                                r="4"></circle></svg></span>
                                                        <input type="text" id="fname-icon"
                                                               value="{{Auth::user()->name}}"
                                                               class="form-control" name="name"
                                                               placeholder="Nom">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label"
                                                           for="fname-icon">Prénoms</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="input-group input-group-merge">
                                                                    <span class="input-group-text"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="14" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-user"><path
                                                                                d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle
                                                                                cx="12" cy="7"
                                                                                r="4"></circle></svg></span>
                                                        <input type="text" id="fname-icon"
                                                               value="{{Auth::user()->prenom_users}}"
                                                               class="form-control" name="prenom_users"
                                                               placeholder="Prénoms">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label"
                                                           for="contact-icon">Mobile</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="input-group input-group-merge">
                                                                    <span class="input-group-text"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="14" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-smartphone"><rect
                                                                                x="5" y="2" width="14" height="20"
                                                                                rx="2" ry="2"></rect><line x1="12"
                                                                                                           y1="18"
                                                                                                           x2="12.01"
                                                                                                           y2="18"></line></svg></span>
                                                        <input type="number" id="contact-icon"
                                                               value="{{Auth::user()->cel_users}}"
                                                               class="form-control" name="cel_users"
                                                               placeholder="Mobile">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit"
                                                    class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                Modifier
                                            </button>
                                            <button type="reset"
                                                    class="btn btn-outline-secondary waves-effect">Annuler
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Project table -->


            </div>
            <!--/ User Content -->
        </div>
    </section>
@endsection
