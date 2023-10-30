@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Paramétrage')
    @php($titre='Liste des agences')
    @php($soustitre='Modifier une agence')
    @php($lien='agence')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{$soustitre}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{$Module}}</a></li>
                                    <li class="breadcrumb-item"><a href="/{{$lien}}">{{$titre}}</a></li>
                                    <li class="breadcrumb-item active">{{$soustitre}}  </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                    <h4 class="card-title">{{$soustitre}} </h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route($lien.'.update',$agence->num_agce) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Libellé </label>
                                                    <input type="text" name="lib_agce" id="lib_agce"
                                                           value="{{$agence->lib_agce }}"
                                                           class="form-control form-control-sm" placeholder="Libellé"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Code </label>
                                                    <input type="text" name="code_agce" id="code_agce"
                                                           value="{{$agence->code_agce }}"
                                                           class="form-control form-control-sm" placeholder="Code">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Localisation </label>
                                                    <input type="text" name="localisation_agce" id="localisation_agce"
                                                           value="{{$agence->localisation_agce }}"
                                                           class="form-control form-control-sm">
                                                </div>
                                            </div>                                            
                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Coordonée GPS </label>
                                                    <input type="text" name="coordonne_gps_agce" id="coordonne_gps_agce"
                                                           value="{{$agence->coordonne_gps_agce }}"
                                                           class="form-control form-control-sm">
                                                </div>
                                            </div>


                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Adresse </label>
                                                    <input type="text" name="adresse_agce" id="adresse_agce"
                                                           value="{{$agence->adresse_agce }}"
                                                           class="form-control form-control-sm" placeholder="Adresse">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Tel. </label>
                                                    <input type="text" name="tel_agce" id="tel_agce"
                                                           value="{{$agence->tel_agce }}"
                                                           class="form-control form-control-sm" placeholder="Tel.">
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Siège </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_siege_agce"
                                                           id="flag_siege_agce" {{  ($agence->flag_siege_agce == true ? ' checked' : '') }}>
                                                </div>
                                            </div>


                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Statut </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_agce"
                                                           id="colorCheck1" {{  ($agence->flag_agce == true ? ' checked' : '') }}>
                                                </div>
                                            </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
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



