@if(auth()->user()->can('cotisation-create'))

<?php
    $anneemincotisation = $dateannee-2;
?>

@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Cotisation')
    @php($titre='Liste des cotisations')
    @php($soustitre='Ajouter une cotisation')
    @php($lien='cotisation')
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
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
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
                                    <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                                        @csrf
                                        <div class="row">

                                              <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Entreprises</label>
                                                    <select class="select2 form-select"
                                                            data-allow-clear="true" name="id_entreprise"
                                                    id="id_entreprise"
                                                            required="required">
                                                        <?php echo $entreprise; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Type de cotisation</label>
                                                    <select class="select2 form-select"
                                                            data-allow-clear="true" name="id_type_cotisation"
                                                    id="id_type_cotisation"
                                                            required="required">
                                                        <?php echo $typeCotisation; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Montant</label>
                                                    <input type="number" min="0" name="montant" id="montant"
                                                    class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Mois</label>
                                                    <input type="number" name="mois_cotisation" id="mois_cotisation"
                                                    class="form-control form-control-sm" min="1" max="12">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Année</label>
                                                    <input type="number" name="annee_cotisation" id="annee_cotisation"
                                                    class="form-control form-control-sm" min="{{ $anneemincotisation }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire</label>
                                                    <textarea  name="commentaire_coti" id="commentaire_coti"
                                                           class="form-control form-control-sm"> </textarea>
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

            </div>
        </div>

    <!-- END: Content-->

<script>
        //Select2 localité entreprise
        $("#id_entreprise").select2().val({{old('id_entreprise')}});
</script>

@endsection
@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif














