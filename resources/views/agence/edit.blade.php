@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Paramétrage')
    @php($titre='Liste des antennes')
    @php($soustitre='Modifier une antenne')
    @php($lien='agence')


    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i
                class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
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
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{$titre}}</h5>
                        <small class="text-muted float-end">

                        </small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($lien.'.update',\App\Helpers\Crypt::UrlCrypt($agence->num_agce)) }}"
                              method="POST">
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
                                    <button type="submit" name="action" value="Modifier"
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
    </div>

    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-body">

                    <form method="POST" class="form"
                          action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($agence->num_agce)) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-10 col-md-11">
                                <select
                                    id="id_localite"
                                    name="id_localite"
                                    class="select2 form-select"  required="required">
                                    <?= $localite; ?>
                                </select>
                            </div>
                            <div class="col-2 col-md-1" align="right">
                                <button type="submit" name="action" value="Lier_agence_localite"
                                        class="btn btn-sm btn-success me-sm-3 me-1">Ajouter
                                </button>
                            </div>

                        </div>

                    </form>

                    <table class="table table-bordered table-striped table-hover table-sm"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Localité</th>
                            <th align="center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                        @foreach ($listeagencelocalites as $listeagencelocalite)
                            <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $listeagencelocalite->localite->libelle_localite }}</td>
                            <td align="center">
                                <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($listeagencelocalite->id_agence_localite)) }}"
                                   class=""
                                   onclick='javascript:if (!confirm("Voulez-vous supprimer cette localité ?")) return false;'
                                   title="Supprimer"> <img src='/assets/img/trash-can-solid.png'>
                                </a>
                            </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection



