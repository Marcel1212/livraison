<?php
$idconnect = Auth::user()->id;
if ($projetetude->flag_soumis == true and $projetetude->flag_recevabilite == null) {
    $disable = 'disabled';
} elseif ($projetetude->flag_soumis == true and $projetetude->flag_recevabilite == true and $projetetude->flag_statut_instruction == null) {
    $disable = '';
} elseif ($projetetude->flag_statut_instruction == true) {
    $disable = 'disabled';
} else {
    $disable = '';
} ?>

<?php if ($projetetude->flag_statut_instruction != null) {
    $disable_ins = 'disabled';
} else {
    $disable_ins = '';
}
?>

@extends('layouts.backLayout.designadmin')


@section('content')

    @php($Module = ' Comités')
    @php($titre = 'Liste des comites')
    @php($soustitre = 'Tenue de comite')
    @php($lien = 'traitementcomite')
    @php($lienacceuil = 'dashboard')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
                {{ $titre }} / {{ $soustitre }}
            </h5>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $error }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif
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


            <div>

                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $soustitre }} </h5>
                                </div>
                                <div class="card-body">
                                    <?php if ($projetetude->flag_soumis == true ) {?>
                                    <div align="right">
                                        <button type="button"
                                            class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#modalToggle">
                                            Voir le parcours
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        {{-- <button type="button" class="btn rounded-pill btn-info waves-effect waves-light" --}}

                                        <div class="modal animate__animated animate__fadeInDownBig fade" id="modalToggle"
                                            aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalToggleLabel">Etapes </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="card">
                                                        <h5 class="card-header">Parcours du projet de formation</h5>
                                                        <div class="card-body pb-2">
                                                            <ul class="timeline pt-3">

                                                                <li
                                                                    class="timeline-item timeline-item-success border-left-dashed">
                                                                    <span
                                                                        class="timeline-indicator-advanced timeline-indicator-success">
                                                                        <i
                                                                            class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                                    </span>
                                                                    <div class="timeline-event">
                                                                        <?php if ($nomrole != "ENTREPRISE"){ ?>
                                                                        <div class="timeline-header border-bottom mb-3">
                                                                            <h6 class="mb-0">Nom de l'entreprise</h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php echo $entreprise_info->raison_social_entreprises; ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <?php } ?>
                                                                        <div
                                                                            class="d-flex justify-content-between flex-wrap mb-2">
                                                                            <div class="d-flex align-items-center">

                                                                                <span>Soumis le </span>

                                                                                <span
                                                                                    class="badge bg-label-danger"><?php echo $projetetude->date_soumis; ?></span>
                                                                            </div>
                                                                            <div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center">

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>


                                                            <?php if ($projetetude->flag_statut_instruction != null ) {?>
                                                            <ul class="timeline pt-3">

                                                                <li
                                                                    class="timeline-item timeline-item-success border-left-dashed">
                                                                    <span
                                                                        class="timeline-indicator-advanced timeline-indicator-success">
                                                                        <i
                                                                            class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                                    </span>
                                                                    <div class="timeline-event">
                                                                        <div class="timeline-header border-bottom mb-4">
                                                                            <h6 class="mb-0">Traitement de l'instruction
                                                                            </h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div class="d-flex lex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>Statut : <?php if ($projetetude->flag_statut_instruction == true) {
                                                                                    echo 'RECEVABLE  ';
                                                                                } else {
                                                                                    echo 'NON RECEVABLE  ';
                                                                                } ?> </span>
                                                                                <br>

                                                                                <span>Date : <span
                                                                                        class="badge bg-label-danger"><?php echo $projetetude->date_instructions; ?>
                                                                                    </span> </span> <br>

                                                                            </div>
                                                                            <div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center">

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <?php }?>


                                                            <?php if ($projetetude->flag_recevabilite != null ) {?>
                                                            <ul class="timeline pt-3">

                                                                <li
                                                                    class="timeline-item timeline-item-success border-left-dashed">
                                                                    <span
                                                                        class="timeline-indicator-advanced timeline-indicator-success">
                                                                        <i
                                                                            class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                                    </span>
                                                                    <div class="timeline-event">
                                                                        <div class="timeline-header border-bottom mb-4">
                                                                            <h6 class="mb-0">Traitement de la
                                                                                recevabilite</h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div class="d-flex lex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>Statut : <?php if ($projetetude->flag_recevabilite == true) {
                                                                                    echo 'RECEVABLE  ';
                                                                                } else {
                                                                                    echo 'NON RECEVABLE  ';
                                                                                } ?> </span>
                                                                                <br>
                                                                                <span>Date : <span
                                                                                        class="badge bg-label-danger"><?php echo $projetetude->date_recevabilite; ?>
                                                                                    </span> </span>
                                                                            </div>
                                                                            <div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center">

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <?php }?>

                                                            <?php if ($projetetude->flag_affect_conseiller_formation == true ) {?>
                                                            <ul class="timeline pt-3">

                                                                <li
                                                                    class="timeline-item timeline-item-success border-left-dashed">
                                                                    <span
                                                                        class="timeline-indicator-advanced timeline-indicator-success">
                                                                        <i
                                                                            class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                                    </span>
                                                                    <div class="timeline-event">
                                                                        <div class="timeline-header border-bottom mb-4">
                                                                            <h6 class="mb-0">Traitement du chef de
                                                                                service
                                                                            </h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between flex-wrap mb-4">
                                                                            <div class="row">

                                                                                <span>Commentaire: <?php echo $projetetude->commentaire_chef_service; ?>
                                                                                </span> <br>

                                                                                <span>Date de l'affectation: <span
                                                                                        class="badge bg-label-danger"><?php echo $projetetude->date_trans_conseiller_formation; ?></span>
                                                                                </span> <br>

                                                                                <span>Affecté a: <span
                                                                                        class="badge bg-label-danger"><?php echo $conseiller_name; ?></span>
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center">

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <?php }?>


                                                            <?php if ($projetetude->flag_affect_service == true ) {?>
                                                            <ul class="timeline pt-3">

                                                                <li
                                                                    class="timeline-item timeline-item-success border-left-dashed">
                                                                    <span
                                                                        class="timeline-indicator-advanced timeline-indicator-success">
                                                                        <i
                                                                            class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                                    </span>
                                                                    <div class="timeline-event">
                                                                        <div class="timeline-header border-bottom mb-4">
                                                                            <h6 class="mb-0">Traitement du chef de
                                                                                departement</h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between flex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>Commentaire: <?php echo $projetetude->commentaire_departement; ?>
                                                                                </span> <br>

                                                                                <span>Date de l'affectation: <span
                                                                                        class="badge bg-label-danger"><?php echo $projetetude->date_trans_service; ?></span>
                                                                                </span> <br>

                                                                                <span>Service: <?php echo $service_name; ?> </span>
                                                                                <br>


                                                                            </div>
                                                                            <div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center">

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <?php }?>

                                                            <?php if ($projetetude->flag_affect_departement == true ) /*START*/ {?>
                                                            <ul class="timeline pt-3">

                                                                <li
                                                                    class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                                                    <span
                                                                        class="timeline-indicator-advanced timeline-indicator-success">
                                                                        <i
                                                                            class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                                    </span>
                                                                    <div class="timeline-event">
                                                                        <div class="timeline-header border-bottom mb-4">
                                                                            <h6 class="mb-0">Traitement du directeur</h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div
                                                                            class="justify-content-between flex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>Commentaire: <?php echo $projetetude->commentaire_directeur; ?>
                                                                                </span> <br>
                                                                                <span>Date de l'affectation :
                                                                                    <span class="badge bg-label-danger">
                                                                                        <?php echo $projetetude->date_trans_chef_service; ?> </span>
                                                                                </span>
                                                                                <br>
                                                                                <span>Departement : <?php echo $departement_name; ?>
                                                                                </span> <br>
                                                                            </div>
                                                                            <div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex align-items-center">

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <?php }?>


                                                            </li>


                                                            </ul>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <form method="POST" class="form"
                                        action="{{ route($lien . '.updater', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt($projetetude->id_projet_formation), \App\Helpers\Crypt::UrlCrypt($cahiersplanprojet->id_cahier_plans_projets), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">

                                            <div class="accordion mt-3" id="accordionExample">
                                                <?php //if ($nomrole == 'ENTREPRISE' ) {
                                                ?>
                                                <div class="card accordion-item active">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button type="button" class="accordion-button"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionOne"
                                                            aria-expanded="true" aria-controls="accordionOne">
                                                            <strong>DETAILS DE L'ENTREPRISE</strong>
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
                                                                        <label><?php echo $entreprise->ncc_entreprises; ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Raison sociale: </b>
                                                                        </label> <br>
                                                                        <label><?php echo $entreprise->raison_social_entreprises; ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">RCCM </b>
                                                                        </label> <br>
                                                                        <label><?php echo $entreprise->rccm_entreprises; ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">NCC </b>
                                                                        </label> <br>
                                                                        <label><?php echo $entreprise->ncc_entreprises; ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Numéro de téléphone: </b>
                                                                        </label> <br>
                                                                        <label><?php echo $entreprise->tel_entreprises; ?></label>

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
                                                                        <label><?php echo $entreprise->localisation_geographique_entreprise; ?></label>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label> <b class="term">Numéro CNPS:
                                                                            </b>
                                                                        </label> <br>
                                                                        <label><?php echo $entreprise->numero_cnps_entreprises; ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php //}
                                                ?>
                                                <?php //if ($nomrole == 'ENTREPRISE' OR $nomrole == 'DIRECTEUR'  ) {
                                                ?>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionTwo"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            <strong>FICHE PROMOTEUR </strong>
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
                                                                            placeholder="ex : Perfectionnement .."
                                                                            <?php echo $disable; ?>
                                                                            value="{{ $projetetude->titre_projet_etude }}">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label>Operateur <span style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" name="operateur"
                                                                            required="required" id="operateur"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement .."
                                                                            <?php echo $disable; ?>
                                                                            value="{{ $projetetude->operateur }}">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label>Promoteur <span style="color:red;">*</span>
                                                                        </label>
                                                                        <input type="text" name="promoteur"
                                                                            required="required" id="promoteur"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement .."
                                                                            <?php echo $disable; ?>
                                                                            value="{{ $projetetude->promoteur }}">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-6
                                                                            col-12">
                                                                    <div class="mb-1">
                                                                        <label>Beneficiaire / Cible <span
                                                                                style="color:red;">*</span></label>
                                                                        <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                            name="beneficiaire_cible" style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->beneficiaires_cible; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Zone du projet <span
                                                                                style="color:red;">*</span>
                                                                        </label>
                                                                        <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                                                            name="zone_projey" style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->zone_projet; ?></textarea>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php //}
                                                ?>
                                                <?php //if ($nomrole == 'ENTREPRISE'  OR $nomrole == 'CONSEILLER EN FORMATION' ) {
                                                ?>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionPC"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            <strong>PERSONNE A CONTACTER</strong>
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
                                                                            placeholder="ex : Koa Augustin .."
                                                                            <?php echo $disable; ?>
                                                                            value="{{ $projetetude->nom_prenoms }}">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-6
                                                                            col-12">
                                                                    <div class="mb-1">
                                                                        <label>Fonction
                                                                        </label>
                                                                        <input type="text" name="fonction"
                                                                            id="fonction"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Charge d'etude .."
                                                                            <?php echo $disable; ?>
                                                                            value="{{ $projetetude->fonction }}">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-6
                                                                                col-12">
                                                                    <div class="mb-1">
                                                                        <label>Téléphone
                                                                        </label>
                                                                        <input type="number" name="telephone"
                                                                            minlength="9" maxlength="10" id="telephone"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : 02014575777"
                                                                            <?php echo $disable; ?>
                                                                            value="{{ $projetetude->telephone }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="card
                                                                                    accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionDP"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            <strong>DESCRIPTION DU PROJET</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="accordionDP" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-12">

                                                                <div class="col-md-12 col-12">
                                                                    <div class="mb-4">
                                                                        <label>Environnement /
                                                                            contexte <span
                                                                                style="color:red;">*</span></label>
                                                                        <textarea class="form-control" required="required" rows="4" id="exampleFormControlTextarea"
                                                                            name="environnement_contexte" style="height: 150px;" <?php echo $disable; ?>><?php echo $projetetude->environnement_contexte; ?></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Domaine selectionné :
                                                                            <span style="color:red;"></span></label>
                                                                        <div class="align-items-center">
                                                                            <span class="badge bg-info rounded-pill">

                                                                                <?php echo $projetetude->domaineFormation->libelle; ?>
                                                                            </span>

                                                                        </div>
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
                                                            <strong>ACTEURS</strong>
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
                                                                        <li class="nav-item">
                                                                            <button type="button" class="nav-link active"
                                                                                data-bs-toggle="tab"
                                                                                data-bs-target="#form-tabs-personal"
                                                                                role="tab" aria-selected="true">
                                                                                Les beneficiaires
                                                                            </button>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <div type="button" class="nav-link"
                                                                                data-bs-toggle="tab"
                                                                                data-bs-target="#form-tabs-account"
                                                                                role="tab" tabindex="-1">
                                                                                Le promoteur
                                                                            </div>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <div type="button" class="nav-link"
                                                                                data-bs-toggle="tab"
                                                                                data-bs-target="#form-tabs-social"
                                                                                role="tab" aria-selected="false"
                                                                                tabindex="-1">
                                                                                Les partenaires
                                                                            </div>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <div type="button" class="nav-link"
                                                                                data-bs-toggle="tab"
                                                                                data-bs-target="#form-tabs-autres"
                                                                                role="tab" aria-selected="false"
                                                                                tabindex="-1">
                                                                                Autres acteurs
                                                                            </div>
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
                                                                                    style="height: 150px;"<?php echo $disable; ?>><?php echo $projetetude->roles_beneficiaire; ?></textarea>

                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-last-name">Responsabilités</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_beneficiaires"
                                                                                    style="height: 150px;"<?php echo $disable; ?>><?php echo $projetetude->responsabilites_beneficiaires; ?></textarea>
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
                                                                                    style="height: 150px;"<?php echo $disable; ?>><?php echo $projetetude->roles_promoteur; ?></textarea>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-last-name">Responsabilités</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_promoteur"
                                                                                    style="height: 150px;"<?php echo $disable; ?>><?php echo $projetetude->responsabilites_promoteur; ?></textarea>
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
                                                                                    style="height: 150px;"<?php echo $disable; ?>><?php echo $projetetude->roles_partenaires; ?></textarea>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-last-name">Responsabilités</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_partenaires"
                                                                                    style="height: 150px;"<?php echo $disable; ?>><?php echo $projetetude->responsabilites_partenaires; ?></textarea>
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
                                                                                    <?php echo $disable; ?>
                                                                                    value="{{ $projetetude->autre_acteur }} "
                                                                                    placeholder="ex : Panelistes">
                                                                            </div>
                                                                        </div> <br>
                                                                        <div class="row g-3">

                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-first-name">Roles</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_autres"
                                                                                    style="height: 150px;" <?php echo $disable; ?>><?php echo $projetetude->roles_autres; ?></textarea>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="form-label"
                                                                                    for="formtabs-last-name">Responsabilités</label>
                                                                                <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_autres"
                                                                                    style="height: 150px;" <?php echo $disable; ?>><?php echo $projetetude->responsabilites_autres; ?></textarea>
                                                                            </div>


                                                                        </div>
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
                                                            <strong>PROBLEMES OBSERVES, OBJET DE LA DEMANDE DE
                                                                FINANCEMENT</strong>
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
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->problemes; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6  col-12">
                                                                    <div class="mb-1">
                                                                        <label>Manifestations
                                                                            /
                                                                            Impacts / Effet
                                                                        </label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="manifestation_impacts_odf"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->manifestation_impact_effet; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Moyens
                                                                            probables
                                                                            de résolution
                                                                        </label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="moyens_problemes_odf"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->moyens_probables; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <label>Coût de la formation <span
                                                                            style="color:red;">*</span>
                                                                    </label>
                                                                    <input type="text" name="cout_projet_formation"
                                                                        required="required" id="cout_projet_formation"
                                                                        class="form-control form-control-sm number"
                                                                        placeholder="ex : 2000000" <?php echo $disable;
                                                                        ?>
                                                                        value={{ number_format($projetetude->cout_projet_formation) }}>
                                                                    {{-- <input type="text"
                                                                        class="form-control form-control-sm number"
                                                                        <?php //echo $disable;
                                                                        ?>
                                                                        value={{ $projetetude->cout_projet_formation }} /> --}}
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
                                                            <strong>ANALYSE DES COMPETENCES DES BENEFICIAIRES</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="accordionACD" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">

                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label>
                                                                            Compétences</label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="competences_odf"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->competences; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Evaluation
                                                                            des
                                                                            compétences
                                                                        </label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->evaluation_contexte; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="mb-1">
                                                                        <label> Sources de
                                                                            verification</label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="sources_verification_odf"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->source_verification; ?></textarea>
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
                                                            <strong>PIECES JUSTIFICATIVES</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="accordionThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">

                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre
                                                                        de demande de
                                                                        financement</label>
                                                                    <br>
                                                                    <?php if($piecesetude1 != ''){?>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet_formation/lettre_demande_fin/' . $piecesetude1) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span> <?php } ?>
                                                                    <?php if($projetetude->flag_soumis == false){?>
                                                                    <input type="file" name="doc_demande_financement"
                                                                        class="form-control" placeholder="" />
                                                                    <?php } ?>
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre
                                                                        d’engagement </label>
                                                                    <br>
                                                                    <?php if($piecesetude2 != ''){?>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet_formation/lettre_engagement/' . $piecesetude2) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span> <?php } ?>
                                                                    <?php if($projetetude->flag_soumis == false){?>
                                                                    <input type="file" name="doc_lettre_engagement"
                                                                        class="form-control" placeholder="" />
                                                                    <?php } ?>
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Liste
                                                                        des
                                                                        bénéficiairesselon le
                                                                        type de
                                                                        projet </label>
                                                                    <br>
                                                                    <?php if($piecesetude3 != ''){?>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet_formation/liste_beneficiaires/' . $piecesetude3) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span> <?php } ?>
                                                                    <?php if($projetetude->flag_soumis == false){?>
                                                                    <input type="file" name="doc_liste_beneficiaires"
                                                                        class="form-control" placeholder="" />
                                                                    <?php } ?>
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Liste
                                                                        de supports
                                                                        pédagogiques
                                                                        nécessaires </label>
                                                                    <br>
                                                                    <?php if($piecesetude4 != ''){?>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet_formation/liste_de_supports/' . $piecesetude4) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span> <?php } ?>
                                                                    <?php if($projetetude->flag_soumis == false){?>
                                                                    <input type="file" name="doc_supports_pedagogiques"
                                                                        class="form-control" placeholder="" />
                                                                    <?php } ?>
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Preuve legale </label>
                                                                    <br>
                                                                    <?php if($piecesetude5 != ''){?>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet_formation/preuv_legales/' . $piecesetude5) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span> <?php } ?>
                                                                    <?php if($projetetude->flag_soumis == false){?>
                                                                    <input type="file" name="doc_preuve_existance"
                                                                        class="form-control" placeholder="" />
                                                                    <?php } ?>
                                                                    <div id="defaultFormControlHelp" class="form-text">
                                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                                            <br>Taille
                                                                            maxi : 5Mo</em>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Autre
                                                                        document </label>
                                                                    <br>
                                                                    <?php if($piecesetude6 != ''){?>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet_formation/autres_docs/' . $piecesetude6) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span><?php } ?>
                                                                    <?php if ($projetetude->flag_soumis == false) { ?>
                                                                    <input type="file" name="doc_autre_document"
                                                                        class="form-control" placeholder="" />
                                                                    <?php } ?>
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
                                                <?php //}
                                                ?>

                                                <?php if ($nomrole == "DIRECTEUR" && $projetetude->flag_soumis == true) { ?>
                                                <div class="card-body">
                                                    <?php if ($nomrole == "DIRECTEUR" && $projetetude->flag_soumis == true  && $projetetude->flag_affect_departement == null) { ?>
                                                    <h5 class="card-title" align="center"> Traitement du directeur</h5>
                                                    <div class="row">
                                                        <label class="form-label">Liste des departements <span
                                                                style="color:red;">*</span></label>
                                                        <select class="select2 select2-size-sm form-select"
                                                            id="id_departements" name="id_departements"
                                                            <?php //echo $disable_cs;
                                                            ?> required="required">
                                                            <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_affect_departement != true  ) {?>
                                                            <?php echo $listedepartment; ?>
                                                            <?php }else{?>
                                                            <option value="1"> <?php //echo $user_ce_name;
                                                            ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <label class="form-label">Commentaires</label>
                                                        <textarea class="form-control" id="commentaires_directeur" name="commentaires_directeur" rows="4"
                                                            <?php //echo $disable_cs;
                                                            ?>><?php //echo $projetetude->commentaires_cs;
                                                            ?></textarea>
                                                    </div>
                                                    <?php }?>
                                                    <div class="col-12" align="left">
                                                        <br>
                                                        <div class="col-12" align="right">
                                                            <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_affect_departement == null) {?>
                                                            <button type="submit" type="submit" name="action"
                                                                value="soumission_projet_formation_departement"
                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                Imputer
                                                            </button>

                                                            <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                                href="/{{ $lien }}">
                                                                Retour</a>
                                                            <?php }?>

                                                        </div>
                                                    </div>

                                                </div>
                                                <?php }?>

                                                <?php if ($nomrole == "CHEF DE DEPARTEMENT" && $projetetude->flag_affect_departement == true && $projetetude->flag_affect_service == null) { ?>
                                                <div class="card-body">
                                                    <?php //if ($nomrole == "DIRECTEUR" && $projetetude->flag_soumis == true  && $projetetude->flag_affect_departement == null) {
                                                    ?>
                                                    <h5 class="card-title" align="center"> Traitement du chef de
                                                        departement</h5>
                                                    <div class="row">
                                                        <label class="form-label">Liste des services <span
                                                                style="color:red;">*</span></label>
                                                        <select id="id_service" name="id_service"
                                                            class="select2 select2-size-sm form-select"
                                                            <?php //echo $disable_cs;
                                                            ?> required="required">
                                                            <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_affect_departement == true  ) {?>
                                                            <?php echo $listeservice; ?>
                                                            <?php }else{?>
                                                            <option value="1"> <?php //echo $user_ce_name;
                                                            ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <label class="form-label">Commentaires</label>
                                                        <textarea class="form-control" id="commentaires_cs" name="commentaires_directeur" rows="4"
                                                            <?php //echo $disable_cs;
                                                            ?>><?php //echo $projetetude->commentaires_cs;
                                                            ?></textarea>
                                                    </div>
                                                    <?php //}
                                                    ?>
                                                    <div class="col-12" align="left">
                                                        <br>
                                                        <div class="col-12" align="right">
                                                            <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_affect_departement == true) {?>
                                                            <button type="submit" type="submit" name="action"
                                                                value="soumission_projet_formation_cs"
                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                Imputer
                                                            </button>

                                                            <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                                href="/{{ $lien }}">
                                                                Retour</a>
                                                            <?php }?>

                                                        </div>
                                                    </div>

                                                </div>
                                                <?php }?>

                                                <?php if ($nomrole == "CHEF DE SERVICE" && $projetetude->flag_affect_departement == true && $projetetude->flag_affect_service == true && $projetetude->flag_affect_conseiller_formation == null ) { ?>
                                                <div class="card-body">
                                                    <?php //if ($nomrole == "DIRECTEUR" && $projetetude->flag_soumis == true  && $projetetude->flag_affect_departement == null) {
                                                    ?>
                                                    <h5 class="card-title" align="center"> Traitement du chef de
                                                        service</h5>
                                                    <div class="row">
                                                        <label class="form-label">Liste des conseillers <span
                                                                style="color:red;">*</span></label>
                                                        <select id="id_conseiller" name="id_conseiller"
                                                            class="select2 select2-size-sm form-select"
                                                            <?php //echo $disable_cs;
                                                            ?> required="required">
                                                            <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_affect_departement == true  ) {?>
                                                            <?php echo $listeuserfinal; ?>
                                                            <?php }else{?>
                                                            <option value="1"> <?php //echo $user_ce_name;
                                                            ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <label class="form-label">Commentaires</label>
                                                        <textarea class="form-control" id="commentaires_chef_serv" name="commentaires_chef_serv" rows="4"
                                                            <?php //echo $disable_cs;
                                                            ?>><?php //echo $projetetude->commentaires_cs;
                                                            ?></textarea>
                                                    </div>
                                                    <?php //}
                                                    ?>
                                                    <div class="col-12" align="left">
                                                        <br>
                                                        <div class="col-12" align="right">
                                                            <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_affect_departement == true) {?>
                                                            <button type="submit" type="submit" name="action"
                                                                value="soumission_projet_formation_conseiller"
                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                Imputer
                                                            </button>

                                                            <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                                href="/{{ $lien }}">
                                                                Retour</a>
                                                            <?php }?>

                                                        </div>
                                                    </div>

                                                </div>
                                                <?php }?>

                                                <?php if ($nomrole == "CONSEILLER EN FORMATION" && $projetetude->flag_affect_conseiller_formation == true  && $projetetude->flag_recevabilite == null ) { ?>
                                                <div class="card-body">
                                                    <?php //if ($nomrole == "DIRECTEUR" && $projetetude->flag_soumis == true  && $projetetude->flag_affect_departement == null) {
                                                    ?>
                                                    <h5 class="card-title" align="center"> Traitement de la recevabilité
                                                    </h5>
                                                    <div class="row">
                                                        <label class="form-label">Statut <span
                                                                style="color:red;">*</span></label>
                                                        <select id="statut_rec" name="statut_rec"
                                                            class="select2 select2-size-sm form-select"
                                                            <?php //echo $disable_cs;
                                                            ?> required="required">
                                                            <option value=''> Selectionnez un statut </option>
                                                            <option value='RECEVABLE'>RECEVABLE </option>
                                                            <option value='NON RECEVABLE'>NON RECEVABLE</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <?php //}
                                                    ?>
                                                    <br>
                                                    <div class="row">
                                                        <label class="form-label">Commentaires</label>
                                                        <textarea class="form-control" id="commentaires_conseiller_rec" name="commentaires_recevabilite" rows="4"
                                                            <?php //echo $disable_cs;
                                                            ?>><?php //echo $projetetude->commentaires_cs;
                                                            ?></textarea>
                                                    </div>
                                                    <div class="col-12" align="left">
                                                        <br>
                                                        <div class="col-12" align="right">
                                                            <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_recevabilite == null) {?>
                                                            <button type="submit" type="submit" name="action"
                                                                value="soumission_recevabilite"
                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                Confirmer
                                                            </button>

                                                            <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                                href="/{{ $lien }}">
                                                                Retour</a>
                                                            <?php }?>

                                                        </div>
                                                    </div>

                                                </div>
                                                <?php }?>
                                                <br>


                                                <?php if ($nomrole == "CONSEILLER EN FORMATION" && $projetetude->flag_affect_conseiller_formation == true  && $projetetude->flag_recevabilite == true  ) { ?>
                                                <div class="row">

                                                    <div class="accordion mt-3" id="accordionExample">
                                                        <div class="card-body">
                                                            <?php //if ($nomrole == "DIRECTEUR" && $projetetude->flag_soumis == true  && $projetetude->flag_affect_departement == null) {
                                                            ?>
                                                            <h5 class="card-title" align="center"> <strong>TRAITEMENT DE
                                                                    LA
                                                                    RECEVABILITE </strong>
                                                            </h5>
                                                            <div class="row">
                                                                <div class="card accordion-item">
                                                                    <h2 class="accordion-header" id="headingTwo">
                                                                        <button type="button"
                                                                            class="accordion-button collapsed"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#accordionTwo22"
                                                                            aria-expanded="true"
                                                                            aria-controls="accordionTwo22">
                                                                            <strong> ELABORATION DU PROJET DE FORMATION
                                                                            </strong>
                                                                        </button>
                                                                    </h2>
                                                                    <div id="accordionTwo22"
                                                                        class="accordion-collapse collapse"
                                                                        aria-labelledby="headingTwo"
                                                                        data-bs-parent="#accordionExample" style="">
                                                                        <div class="accordion-body">
                                                                            <div class="row gy-3">
                                                                                <div class="col-md-12 col-10"
                                                                                    align="left">
                                                                                    <div class="mb-1">
                                                                                        <label>Titre du projet <span
                                                                                                style="color:red;">*</span>
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            name="titre_projet_instruction"
                                                                                            required="required"
                                                                                            id="titre_projet_instruction"
                                                                                            class="form-control form-control-sm"
                                                                                            placeholder="ex : Perfectionnement .."
                                                                                            <?php echo $disable_ins; ?>
                                                                                            value="{{ $projetetude->titre_projet_instruction }}">
                                                                                    </div>
                                                                                    <br>

                                                                                    <div class="col-md-12">
                                                                                        <label class="form-label">Piece
                                                                                            jointe instruction
                                                                                            (PDF,
                                                                                            WORD,
                                                                                            JPG)
                                                                                            5M</label> <br>

                                                                                        <?php if($piecesetude7 != ''){?>
                                                                                        <span class="badge bg-secondary"><a
                                                                                                target="_blank"
                                                                                                onclick="NewWindow('{{ asset('/pieces_projet_formation/autre_doc_instruction/' . $piecesetude7) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                                                Voir la pièce </a> </span>
                                                                                        <br>
                                                                                        <?php } else { ?>


                                                                                        <input type="file"
                                                                                            name="doc_autre_document_instruction"
                                                                                            class="form-control"
                                                                                            placeholder="" />
                                                                                        <?php } ?> <br>

                                                                                        <label>Coût du projet <span
                                                                                                style="color:red;">*</span>
                                                                                        </label>
                                                                                        <input
                                                                                            name="cout_projet_instruction"
                                                                                            required="required"
                                                                                            type="text"
                                                                                            id="cout_projet_instruction"
                                                                                            class="form-control form-control-sm number"
                                                                                            <?php echo $disable_ins; ?>
                                                                                            value="{{ $projetetude->cout_projet_instruction }}"
                                                                                            placeholder="200000">

                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                            </div>

                                                            <?php if ($projetetude->flag_statut_instruction == null ) { ?>
                                                            <div class="row">
                                                                <div>
                                                                    <br>
                                                                    <h5 class="card-title" align="center"> <strong> Avis
                                                                            global </strong>
                                                                    </h5>
                                                                    <div class="row">
                                                                        <label class="form-label">Statut <span
                                                                                style="color:red;">*</span></label>
                                                                        <select id="statut_rec_global"
                                                                            name="statut_rec_global_instruction"
                                                                            class="select2 select2-size-sm form-select"
                                                                            <?php //echo $disable_cs;
                                                                            ?> required="required">
                                                                            <option value=''> Selectionnez un statut
                                                                            </option>
                                                                            <option value='RECEVABLE'>RECEVABLE </option>
                                                                            <option value='NON RECEVABLE'>NON RECEVABLE
                                                                            </option>
                                                                        </select>


                                                                    </div>
                                                                    <div class="row">
                                                                        <label> Compétences</label>
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="competences_instruction"
                                                                            style="height: 121px;"></textarea>
                                                                    </div>


                                                                    <br>
                                                                    <?php //}
                                                                    ?>
                                                                    <div class="col-12" align="left">
                                                                        <br>
                                                                        <div class="col-12" align="right">
                                                                            <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_recevabilite == true ) {?>
                                                                            <button type="submit" type="submit"
                                                                                name="action"
                                                                                value="soumission_recevabilite_global_instruction"
                                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                                Confirmer
                                                                            </button>

                                                                            <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                                                href="/{{ $lien }}">
                                                                                Retour</a>
                                                                            <?php }?>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <?php }?>

                                                        </div>
                                                    </div>
                                                    <?php }?>

                                                </div>


                                                <br>
                                                <div class="col-12" align="left">
                                                    <br>
                                                    <div class="col-12" align="right">
                                                        @if ($cahiersplanprojet->code_commission_permante_comite_gestion == 'COP')
                                                            @if ($projetetude->flag_traiter_commission_permanente == false)
                                                                <form method="POST" class="form"
                                                                    action="{{ route($lien . '.updater', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt($projetetude->id_projet_formation), \App\Helpers\Crypt::UrlCrypt($cahiersplanprojet->id_cahier_plans_projets), \App\Helpers\Crypt::UrlCrypt(1)]) }}">
                                                                    @csrf
                                                                    @method('put')
                                                                    <div align="right">
                                                                        <button type="submit" name="action"
                                                                            value="Traiter_valider_projet_formation"
                                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                            Valider le projet de formation pour cette
                                                                            commission
                                                                            permanente
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        @endif
                                                        @if ($cahiersplanprojet->code_commission_permante_comite_gestion == 'COG')
                                                            @if ($projetetude->flag_traiter_commission_permanente == false)
                                                                <form method="POST" class="form"
                                                                    action="{{ route($lien . '.updater', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt($projetetude->id_projet_formation), \App\Helpers\Crypt::UrlCrypt($cahiersplanprojet->id_cahier_plans_projets), \App\Helpers\Crypt::UrlCrypt(1)]) }}">
                                                                    @csrf
                                                                    @method('put')
                                                                    <div align="right">
                                                                        <button type="submit" name="action"
                                                                            value="Traiter_valider_projet_formation"
                                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                                            Valider le projet de formation pour ce comité
                                                                            de
                                                                            gestion
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        @endif

                                                        <?php if($projetetude->flag_soumis != true) {
                                                    ?>
                                                        <button type="submit" type="submit" name="action"
                                                            value="soumettre"
                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                            Soumettre
                                                        </button>
                                                        <button type="submit" type="submit" name="action"
                                                            value="modifier"
                                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                            Modifier
                                                        </button>

                                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                            href="/{{ $lien }}">
                                                            Retour</a>
                                                        <?php } ?>
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
@section('js_perso')
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.js') }}"></script>
    <script src="{{ asset('assets/js/projetetudes/pages-traitement-projet.js') }}"></script>
    <script type="text/javascript">
        //Initialisation des variable Quill
        var contexte_probleme_instruction = new Quill('#contexte_probleme_instruction', {
            theme: 'snow'
        });
        var objectif_general_instruction = new Quill('#objectif_general_instruction', {
            theme: 'snow'
        });
        var objectif_specifique_instruction = new Quill('#objectif_specifique_instruction', {
            theme: 'snow'
        });
        var resultat_attendu_instruction = new Quill('#resultat_attendu_instruction', {
            theme: 'snow'
        });
        var champ_etude_instruction = new Quill('#champ_etude_instruction', {
            theme: 'snow'
        });
        var cible_instruction = new Quill('#cible_instruction', {
            theme: 'snow'
        });
        var methodologie_instruction = new Quill('#methodologie_instruction', {
            theme: 'snow'
        });

        //Hide All fields
        $("#contexte_probleme_instruction_val").hide();
        $("#objectif_general_instruction_val").hide();
        $("#objectif_specifique_instruction_val").hide();
        $("#resultat_attendu_instruction_val").hide();
        $("#champ_etude_instruction_val").hide();
        $("#cible_instruction_val").hide();
        $("#methodologie_instruction_val").hide();

        //Initialisation des variable Quill
        var contexte_probleme = new Quill('#contexte_probleme', {
            theme: 'snow'
        });
        var objectif_general = new Quill('#objectif_general', {
            theme: 'snow'
        });
        var objectif_specifique = new Quill('#objectif_specifique', {
            theme: 'snow'
        });
        var resultat_attendu = new Quill('#resultat_attendu', {
            theme: 'snow'
        });
        var champ_etude = new Quill('#champ_etude', {
            theme: 'snow'
        });
        var cible = new Quill('#cible', {
            theme: 'snow'
        });

        contexte_probleme.disable();
        objectif_general.disable();
        objectif_specifique.disable();
        resultat_attendu.disable();
        champ_etude.disable();
        cible.disable();


        contexte_probleme_instruction.disable();
        objectif_general_instruction.disable();
        objectif_specifique_instruction.disable();
        resultat_attendu_instruction.disable();
        champ_etude_instruction.disable();
        cible_instruction.disable();
        methodologie_instruction.disable();
    </script>
@endsection
