@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet de formations')
    @php($titre = 'Liste des projets de formations')
    @php($soustitre = 'Ajouter un projet de formation ')
    @php($lien = 'projetformation')

    <!-- Vendors JS -->
    <script src="../../public/assets/vendor/libs/select2/select2.js"></script>
    <script src="../../public/assets/vendor/libs/tagify/tagify.js"></script>
    <script src="../../public/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="../../public/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../public/assets/vendor/libs/bloodhound/bloodhound.js"></script>

    <!-- Main JS -->
    <script src="../../public/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../public/assets/js/forms-selects.js"></script>
    <script src="../../public/assets/js/forms-tagify.js"></script>
    <script src="../../public/assets/js/forms-typeahead.js"></script>
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
                                                            DETAILS DE L'ENTREPRISE
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
                                                                        <label> <b class="term">RCCM </b>
                                                                        </label> <br>
                                                                        <label> <?php echo $entreprise->rccm_entreprises; ?></label>
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
                                                            FICHE PROMOTEUR
                                                        </button>
                                                    </h2>
                                                    <div id="accordionTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">
                                                                <div class="col-md-12 col-10" align="left">
                                                                    <div class="mb-1">
                                                                        <label>Titre du projet <span
                                                                                style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" name="titre_projet"
                                                                            required="required" id="titre_projet"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement ..">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label>Operateur <span style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" name="operateur"
                                                                            required="required" id="operateur"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : CAF ..">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label>Promoteur <span style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" name="promoteur"
                                                                            required="required" id="promoteur"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : MGroupe ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">

                                                                        <label>Beneficiaire / Cible <span
                                                                                style="color:red;">*</span></label>
                                                                        <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                            name="beneficiaire_cible" style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Zone du projet <span
                                                                                style="color:red;">*</span>
                                                                        </label>
                                                                        <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                                                            name="zone_projey" style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionPC"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            PERSONNE A CONTACTER
                                                        </button>
                                                    </h2>
                                                    <div id="accordionPC" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Nom et prenoms
                                                                        </label>
                                                                        <input type="text" name="nom_prenoms"
                                                                            id="titre_projet"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Koa Augustin ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Fonction
                                                                        </label>
                                                                        <input type="text" name="fonction"
                                                                            id="fonction"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Charge d'etude ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Téléphone
                                                                        </label>
                                                                        <input type="number" name="telephone"
                                                                            minlength="9" maxlength="10" id="telephone"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : 02014575777">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionDP"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            DESCRIPTION DU PROJET
                                                        </button>
                                                    </h2>
                                                    <div id="accordionDP" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">

                                                                <div class="col-md-12 col-12">
                                                                    <div class="mb-4">
                                                                        <label>Environnement / contexte <span
                                                                                style="color:red;">*</span></label>
                                                                        <textarea class="form-control" required="required" rows="4" id="exampleFormControlTextarea"
                                                                            name="environnement_contexte" style="height: 150px;"></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionAC"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            ACTEURS
                                                        </button>
                                                    </h2>
                                                    <div id="accordionAC" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="card mb-3">
                                                                <div class="card-header pt-2">
                                                                    <ul class="nav nav-tabs card-header-tabs"
                                                                        role="tablist">
                                                                        <li class="nav-item" role="presentation">
                                                                            <button class="nav-link active"
                                                                                data-bs-toggle="tab"
                                                                                data-bs-target="#form-tabs-personal"
                                                                                role="tab" aria-selected="true">
                                                                                Les beneficiaires
                                                                            </button>
                                                                        </li>
                                                                        <li class="nav-item" role="presentation">
                                                                            <button class="nav-link" data-bs-toggle="tab"
                                                                                data-bs-target="#form-tabs-account"
                                                                                role="tab" aria-selected="false"
                                                                                tabindex="-1">
                                                                                Le promoteur
                                                                            </button>
                                                                        </li>
                                                                        <li class="nav-item" role="presentation">
                                                                            <button class="nav-link" data-bs-toggle="tab"
                                                                                data-bs-target="#form-tabs-social"
                                                                                role="tab" aria-selected="false"
                                                                                tabindex="-1">
                                                                                Les partenaires
                                                                            </button>
                                                                        </li>
                                                                        <li class="nav-item" role="presentation">
                                                                            <button class="nav-link" data-bs-toggle="tab"
                                                                                data-bs-target="#form-tabs-autres"
                                                                                role="tab" aria-selected="false"
                                                                                tabindex="-1">
                                                                                Autres acteurs
                                                                            </button>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="tab-content">
                                                                    <div class="tab-pane fade active show"
                                                                        id="form-tabs-personal" role="tabpanel">
                                                                        <div class="row g-3">
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-first-name">Roles</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_beneficiaire"
                                                                                    style="height: 150px;"></textarea>

                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-last-name">Responsabilités</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_beneficiaires"
                                                                                    style="height: 150px;"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="form-tabs-account"
                                                                        role="tabpanel">
                                                                        <div class="row g-3">
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-first-name">Roles</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_promoteur"
                                                                                    style="height: 150px;"></textarea>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-last-name">Responsabilités</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_promoteur"
                                                                                    style="height: 150px;"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="form-tabs-social"
                                                                        role="tabpanel">
                                                                        <div class="row g-3">

                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-first-name">Roles</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_partenaires"
                                                                                    style="height: 150px;"></textarea>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-last-name">Responsabilités</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_partenaires"
                                                                                    style="height: 150px;"></textarea>
                                                                            </div>


                                                                        </div>


                                                                    </div>
                                                                    <div class="tab-pane fade" id="form-tabs-autres"
                                                                        role="tabpanel">
                                                                        <div class="row g-3">
                                                                            <div class="mb-1">
                                                                                <label>Precisez
                                                                                </label>
                                                                                <input type="text" name="autre_acteur"
                                                                                    id="autre_acteur"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="ex : Panelistes">
                                                                            </div>
                                                                        </div> <br>
                                                                        <div class="row g-3">

                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-first-name">Roles</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_autres"
                                                                                    style="height: 150px;"></textarea>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-last-name">Responsabilités</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_autres"
                                                                                    style="height: 150px;"></textarea>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="row gy-3">
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Acteurs<span style="color:red;">*</span>
                                                                        </label>
                                                                        <select required="required" class="form-select"
                                                                            id="exampleFormControlSelect1"
                                                                            name="acteurs_projet"
                                                                            aria-label="Default select example">
                                                                            <option selected="">Selectionnez un acteur
                                                                            </option>
                                                                            <option value="Les bénéficiaires">Les
                                                                                bénéficiaires</option>
                                                                            <option value="Le promoteur">Le promoteur
                                                                            </option>
                                                                            <option value="Les partenaires">Les partenaires
                                                                            </option>
                                                                            <option value="Autres acteurs">Autres acteurs
                                                                            </option>
                                                                            </option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4  col-12">
                                                                    <div class="mb-1">
                                                                        <label>Role <span
                                                                                style="color:red;">*</span></label>
                                                                        <input type="text" name="role_projet"
                                                                            required="required" id="role"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Responsabilite <span
                                                                                style="color:red;">*</span></label>
                                                                        <input type="text" name="responsabilite_projet"
                                                                            required="required" id="role"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement ..">
                                                                    </div>
                                                                </div>
                                                                <div class="row gy-3">
                                                                    <div class="col-md-4 col-12">
                                                                        <div class="mb-1" id="AddActeur"
                                                                            name="AddActeur">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-12">
                                                                        <div class="mb-1" id="AddRole"
                                                                            name="AddRole">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-12">
                                                                        <div class="mb-1" id="AddResponsabilite"
                                                                            name="AddResponsabilite">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div align="top-left" class="col-md-4 ">
                                                                    <button
                                                                        class="btn btn-primary waves-effect waves-light"
                                                                        id="btn_add_1" onclick="ajouterInput()">Ajouter
                                                                        un acteur</button>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionPOD"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            PROBLEMES OBSERVES , OBJET DE LA DEMANDE DE FINANCEMENT
                                                        </button>
                                                    </h2>
                                                    <div id="accordionPOD" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Problèmes
                                                                        </label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="problemes_odf"
                                                                            style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6  col-12">
                                                                    <div class="mb-1">
                                                                        <label>Manifestations / Impacts / Effet </label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="manifestation_impacts_odf"
                                                                            style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Moyens probables de résolution </label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="moyens_problemes_odf"
                                                                            style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionACD"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            ANALYSE DES COMPETENCES DES BENEFICIAIRES
                                                        </button>
                                                    </h2>
                                                    <div id="accordionACD" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">

                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Compétences</label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="competences_odf"
                                                                            style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Evaluation des compétences </label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                                            style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Sources de verification</label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="sources_verification_odf"
                                                                            style="height: 121px;"></textarea>
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
                                                            PIECES JUSTIFICATIVES
                                                        </button>
                                                    </h2>
                                                    <div id="accordionThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">

                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre de demande de
                                                                        financement <span
                                                                            style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_demande_financement"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre d’engagement <span
                                                                            style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_lettre_engagement"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Liste des bénéficiaires (si
                                                                        identifiés) selon le type de
                                                                        projet <span style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_liste_beneficiaires"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Liste de supports
                                                                        pédagogiques nécessaires à la
                                                                        réalisation des formations <span
                                                                            style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_supports_pedagogiques"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Document prouvant
                                                                        l’existence légale du
                                                                        promoteur<span style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_preuve_existance"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Autre document <span
                                                                            style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_autre_document"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
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
    </div> <!-- END: Content-->

    <script>
        function ajouterInput() {
            // Création d'un élément input
            var nouvelInput = document.createElement("input");
            var role = document.createElement("input");
            var responsabilite = document.createElement("input");

            // Définition des attributs de l'input
            nouvelInput.setAttribute("type", "text");
            nouvelInput.setAttribute("class", "form-control form-control-sm col-md-4  col-12");
            nouvelInput.setAttribute("name", "nouveauacteur");
            nouvelInput.setAttribute("placeholder", "Acteur");

            // Definition des acteurs
            var acteur = document.createElement("select");
            acteur.setAttribute("class", "form-select form-control form-control-sm col-md-4  col-12");
            acteur.setAttribute("name", "acteur");
            const opt1 = document.createElement("option");
            const opt2 = document.createElement("option");
            const opt3 = document.createElement("option");

            opt1.value = "Les bénéficiaires";
            opt1.text = "Les bénéficiaires";
            opt2.value = "Le promoteur";
            opt2.text = "Le promoteur";
            opt3.value = "Les partenaires";
            opt3.text = "Les partenaires";

            acteur.add(opt1, null);
            acteur.add(opt2, null);
            acteur.add(opt3, null);

            // Definition du role
            role.setAttribute("type", "text");
            role.setAttribute("class", "form-control form-control-sm col-md-4  col-12");
            role.setAttribute("name", "nouveaurole");
            role.setAttribute("placeholder", "Role");

            // Definition de la responsabilite
            responsabilite.setAttribute("type", "text");
            responsabilite.setAttribute("class", "form-control form-control-sm col-md-4  col-12");
            responsabilite.setAttribute("name", "nouveauResp");
            responsabilite.setAttribute("placeholder", "Responsabilite");

            // Récupération du formulaire existant
            var formulaire = document.getElementById("monFormulaire");

            // Ajout de l'input au formulaire
            AddActeur.appendChild(acteur);
            AddRole.appendChild(role);
            AddResponsabilite.appendChild(responsabilite);

            // Desactivation du bouton
            // document.getElementById("btn_add_1").disabled = true;
            var parentElement = document.getElementById("btn_add_1").parentNode;
            var bouton = document.getElementById("btn_add_1");
            parentElement.removeChild(bouton);




        }
    </script>


    <script>
        'use strict';

        $(function() {
            const selectPicker = $('.selectpicker'),
                select2 = $('.select2'),
                select2Icons = $('.select2-icons');

            // Bootstrap Select
            // --------------------------------------------------------------------
            if (selectPicker.length) {
                selectPicker.selectpicker();
            }

            // Select2
            // --------------------------------------------------------------------

            // Default
            if (select2.length) {
                select2.each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }

            // Select2 Icons
            if (select2Icons.length) {
                // custom template to render icons
                function renderIcons(option) {
                    if (!option.id) {
                        return option.text;
                    }
                    var $icon = "<i class='" + $(option.element).data('icon') + " me-2'></i>" + option.text;

                    return $icon;
                }
                select2Icons.wrap('<div class="position-relative"></div>').select2({
                    dropdownParent: select2Icons.parent(),
                    templateResult: renderIcons,
                    templateSelection: renderIcons,
                    escapeMarkup: function(es) {
                        return es;
                    }
                });
            }
        });
    </script>
@endsection
