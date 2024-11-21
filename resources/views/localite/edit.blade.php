@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Paramétrage')
    @php($titre = 'Liste des communes')
    @php($soustitre = 'Modifier une commune')
    @php($lien = 'localite')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">

                            <div class="breadcrumb-wrapper">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} /
                    {{ $titre }} / </span> {{ $soustitre }}
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
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $soustitre }} </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" class="form"
                                        action="{{ route($lien . '.update', \App\Helpers\Crypt::UrlCrypt($localite->id_localite)) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-10 col-12">
                                                <div class="mb-1">
                                                    <label>Libellé commune </label>
                                                    <input type="text" name="libelle_localite" id="libelle_localite"
                                                        class="form-control form-control-sm"
                                                        value="{{ $localite->libelle_localite }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Statut </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_localite"
                                                        {{ $localite->flag_localite == true ? ' checked' : '' }}
                                                        id="colorCheck1">
                                                </div>
                                            </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                    href="/{{ $lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>

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
