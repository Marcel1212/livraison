@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Statistiques')
    @php($titre = 'Statistiques par periode')
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


                                </div>
                                <br>
                                <br>
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-5">
                                            <label class="form-label" for="date_debut">Date de debut<strong
                                                    style="color:red;">*</strong></label>
                                            <input type="date" id="date_debut" required="required" name="date_debut"
                                                class="form-control form-control-sm" />
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label" for="date_fin">Date de fin<strong
                                                    style="color:red;">*</strong></label>
                                            <input type="date" id="date_fin" required="required" name="date_fin"
                                                class="form-control form-control-sm" />
                                        </div>
                                        <div class="col-md-2" align="right">
                                            <button type="submit"
                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Rechercher
                                            </button>
                                        </div>
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
