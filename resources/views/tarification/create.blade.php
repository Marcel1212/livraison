@if (auth()->user()->can('localite-create'))

    @extends('layouts.backLayout.designadmin')

    @section('content')
        @php($Module = 'Paramétrage')
        @php($titre = 'Liste des tarifications')
        @php($soustitre = 'Ajouter une tarification')
        @php($lien = 'traitementlivraisonprix')


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
                    <div class="row">
                        <!-- Basic Layout -->
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Tarification</h5>
                                    <small class="text-muted float-end">

                                    </small>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route($lien . '.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <label class="form-label" for="state">Commune d'expediteur <span
                                                        style="color:red;">*</span> </label>
                                                <select id="id_commune_exp" name="id_commune_exp" required="required"
                                                    class="select2 select2-size-sm form-select">

                                                    <?php echo $localite;
                                                    ?>

                                                </select>

                                            </div>
                                            <div class="col-md-12 col-12">
                                                <label class="form-label" for="state">Commune destinataire <span
                                                        style="color:red;">*</span> </label>
                                                <select id="id_commune_dest" name="id_commune_dest" required="required"
                                                    class="select2 select2-size-sm form-select">

                                                    <?php echo $localite;
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="mb-1">
                                                    <label>Prix <span style="color:red;">*</span> </label><br>
                                                    <input type="number" class="form-control form-control-sm"
                                                        required="required" name="prix">
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label> <strong>Statut</strong> </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_valide"
                                                        id="colorCheck1">
                                                </div>
                                            </div> --}}
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
                </div>
            </div>
        </div>
        <!-- END: Content-->
    @endsection
@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}"; //here double curly bracket
    </script>
@endif
