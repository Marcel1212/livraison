@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet de formations')
    @php($titre = 'Liste des projets de formations')
    @php($soustitre = 'Ajouter un projet de formation ')
    @php($lien = 'projetformation')


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
                                                                        <label> <b class="term">NCC </b>
                                                                        </label> <br>
                                                                        <label> <?php echo $entreprise->ncc_entreprises; ?></label>
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
                                                                            placeholder="ex : Perfectionnement ..">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label>Promoteur <span style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" name="promoteur"
                                                                            required="required" id="promoteur"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement ..">
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

                                                                <div class="col-md-6 col-12">
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
                                                            <div class="row gy-3">
                                                                <div class="col-md-6 col-12">
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
                                                                <div class="col-md-6  col-12">
                                                                    <div class="mb-1">
                                                                        <label>Role <span
                                                                                style="color:red;">*</span></label>
                                                                        <input type="text" name="role_projet"
                                                                            required="required" id="role"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Responsabilite <span
                                                                                style="color:red;">*</span></label>
                                                                        <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                            name="responsabilite_projet" style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                                        financement (PDF, WORD, JPG)
                                                                        5M <span style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_demande_financement"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre d’engagement (PDF,
                                                                        WORD, JPG)
                                                                        5M <span style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_lettre_engagement"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Liste des bénéficiaires (si
                                                                        identifiés) selon le type de
                                                                        projet (PDF, WORD, JPG)
                                                                        5M <span style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_liste_beneficiaires"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Liste de supports
                                                                        pédagogiques nécessaires à la
                                                                        réalisation des formations (PDF, WORD, JPG)
                                                                        5M <span style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_supports_pedagogiques"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Document prouvant
                                                                        l’existence légale du
                                                                        promoteur
                                                                        (PDF, WORD, JPG)
                                                                        5M <span style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_preuve_existance"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Autre document (PDF, WORD,
                                                                        JPG)
                                                                        5M <span style="color:red;">*</span></label>
                                                                    <input type="file" name="doc_autre_document"
                                                                        class="form-control" required="required"
                                                                        placeholder="" />
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
@endsection
