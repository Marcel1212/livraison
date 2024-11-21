@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Livraison')
    @php($titre = 'Liste des livraisons')
    @php($soustitre = 'Livraison')
    @php($lien = 'traitementlivraison')



    <!-- BEGIN: Content-->
    <div class="app-content content ">

        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
                {{ $titre }}
            </h5>


            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        <i class="fas fa-allergies mb-2"></i>
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="content-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <i class="fab fa-angellist mb-2"></i>
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($message = Session::get('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <i class="fas fa-allergies mb-2"></i>
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
                                    <h5 class="card-title">{{ $soustitre }} </h5>
                                </div>
                                <div class="card-body">
                                    <?php //if ($projetetude->flag_soumis == true ) {
                                    ?>

                                    <?php //}
                                    ?>
                                    <form method="POST" class="form"
                                        action="{{ route($lien . '.updateprixlivraison', \App\Helpers\Crypt::UrlCrypt($tariflivraison->id_tarif_livraison)) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <br>
                                        <div class="row">
                                            <div class="card-body">


                                                <hr class="my-3 mx-n4">


                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <label class="form-label" for="state">Commune d'expediteur <span
                                                                style="color:red;">*</span> </label>
                                                        <select id="id_commune_exp" name="id_commune_exp"
                                                            required="required" class="select2 select2-size-sm form-select"
                                                            value="1">

                                                            <?php echo $localiteexp;
                                                            ?>

                                                        </select>

                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <label class="form-label" for="state">Commune destinataire
                                                            <span style="color:red;">*</span> </label>
                                                        <select id="id_commune_dest" name="id_commune_dest"
                                                            required="required" class="select2 select2-size-sm form-select">

                                                            <?php echo $localitedest;
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="mb-1">
                                                            <label>Prix <span style="color:red;">*</span> </label><br>
                                                            <input type="number" class="form-control form-control-sm"
                                                                required="required" name="prix"
                                                                value={{ $tariflivraison->prix }}>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-2 col-12">
                                                        <div class="mb-1">
                                                            <label> <strong>Statut</strong> </label><br>
                                                            <input type="checkbox" class="form-check-input"
                                                                name="flag_valide" id="colorCheck1">
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
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                        <br>
                    </div>
                    <br>
                </section>
            </div>
        </div>
    </div> <!-- END: Content-->
@endsection
