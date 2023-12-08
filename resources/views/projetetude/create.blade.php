@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet d\'etudes')
    @php($titre = 'Liste des  projets')
    @php($soustitre = 'Ajouter un projet etude ')
    @php($lien = 'projetetude')


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
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                                    <h5 class="card-title">{{ $soustitre }} </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" class="form" action="{{ route($lien . '.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="accordion mt-3" id="accordionExample">
                                                <div class="card accordion-item active">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button type="button" class="accordion-button"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionOne"
                                                            aria-expanded="true" aria-controls="accordionOne">
                                                            Details de l'entreprise
                                                        </button>
                                                    </h2>

                                                    <div id="accordionOne" class="accordion-collapse collapse show"
                                                        data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Numero de compte
                                                                                contribuable: </b> </label> <br>
                                                                        <label> <?php echo $entreprise->ncc_entreprises; ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Raison sociale: </b>
                                                                        </label> <br>
                                                                        <label> <?php echo $entreprise->raison_social_entreprises; ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Numéro de téléphone: </b>
                                                                        </label> <br>
                                                                        <label> <?php echo $entreprise->tel_entreprises; ?></label>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Email: </b>
                                                                        </label> <br>
                                                                        <label> <?php echo $user->email; ?></label>


                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Situation géographique:
                                                                            </b>
                                                                        </label> <br>
                                                                        <label> <?php echo $entreprise->localisation_geographique_entreprise; ?></label>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Numéro CNPS:
                                                                            </b>
                                                                        </label> <br>
                                                                        <label> <?php echo $entreprise->numero_cnps_entreprises; ?></label>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionTwo"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            Informations du projet d'etude
                                                        </button>
                                                    </h2>
                                                    <div id="accordionTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">
                                                                <div class="col-md-12 col-10" align="center">
                                                                    <div class="mb-1">
                                                                        <label>Titre du projet <span
                                                                                style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" name="titre_projet"
                                                                            required="required" id="titre_projet"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Contexte ou Problèmes constatés <span
                                                                                style="color:red;">*</span></label>
                                                                        <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                            name="contexte_probleme" style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Objectif Général <span
                                                                                style="color:red;">*</span> </label>
                                                                        <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                                                            name="objectif_general" style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Objectifs spécifiques <span
                                                                                style="color:red;">*</span> </label>
                                                                        <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                            name="objectif_specifique" style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Résultats attendus <span
                                                                                style="color:red;">*</span> </label>
                                                                        <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                            name="resultat_attendu" style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Champ de l’étude <span
                                                                                style="color:red;">*</span></label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="champ_etude"
                                                                            style="height: 121px;" required="required"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Cible <span style="color:red;">*</span>
                                                                        </label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="cible" style="height: 121px;"
                                                                            required="required"></textarea>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionThree"
                                                            aria-expanded="false" aria-controls="accordionThree">
                                                            Pieces jointes du projet
                                                        </button>
                                                    </h2>
                                                    <div id="accordionThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">

                                                                <div class="col-md-4">
                                                                    <label class="form-label">Avant-projet TDR <span
                                                                            style="color:red;">*</span> (PDF, WORD, JPG)
                                                                        5M</label>
                                                                    <input type="file" name="avant_projet_tdr"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Courrier de demande de
                                                                        financement<span style="color:red;">*</span> (PDF,
                                                                        WORD, JPG)
                                                                        5M</label>
                                                                    <input type="file" name="courier_demande_fin"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Dossier d’intention <span
                                                                            style="color:red;">*</span> (PDF, WORD, JPG)
                                                                        5M</label>
                                                                    <input type="file" name="dossier_intention"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre d’engagement<span
                                                                            style="color:red;">*</span> (PDF, WORD, JPG)
                                                                        5M</label>
                                                                    <input type="file" name="lettre_engagement"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre technique<span
                                                                            style="color:red;">*</span> (PDF, WORD, JPG)
                                                                        5M</label>
                                                                    <input type="file" name="offre_technique"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre financière<span
                                                                            style="color:red;">*</span> (PDF, WORD, JPG)
                                                                        5M</label>
                                                                    <input type="file" name="offre_financiere"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <br>
                                            <div class="col-12" align="left">
                                                <br>
                                                <div class="col-12" align="right">
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
