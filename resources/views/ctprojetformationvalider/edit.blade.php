<?php
/*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{

	}*/
$NumAgce = Auth::user()->num_agce;
$Iddepartement = Auth::user()->id_departement;
use App\Helpers\ConseillerParAgence;
use App\Helpers\NombreActionValiderParLeConseiller;
$conseilleragence = ConseillerParAgence::get_conseiller_par_agence($NumAgce, $Iddepartement);
$conseillerplan = NombreActionValiderParLeConseiller::get_conseiller_valider_plan($planformation->id_plan_de_formation, Auth::user()->id);
$nombre = count($conseilleragence);
//dd($nombre);
?>

<?php if ($projetetude->flag_soumis == true) {
    $disable = 'disabled';
} else {
    $disable = '';
} ?>

<?php if ($projetetude->flag_statut_instruction != null) {
    $disable_ins = 'disabled';
} else {
    $disable_ins = '';
} ?>

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module = 'Demandes')
    @php($titre = 'Liste des projets de formations')
    @php($soustitre = 'Comite technique à valider')
    @php($lien = 'ctprojetformationvalider')


    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / {{ $titre }} /
        </span> {{ $soustitre }}
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

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <div class="row">
            <div class="row col-12">

                <div align="right">
                    <button type="button" class="btn rounded-pill btn-outline-success waves-effect waves-light"
                        data-bs-toggle="modal" data-bs-target="#modalToggleRec">
                        Voir le parcours de la recevabilité
                    </button>

                    <button type="button" class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                        data-bs-toggle="modal" data-bs-target="#modalToggle">
                        Voir le parcours de validation
                    </button>
                </div>
            </div>

            <div class="col-md-4 col-12">
                {{-- <button type="button" class="btn rounded-pill btn-info waves-effect waves-light" --}}

                <div class="modal animate__animated animate__fadeInDownBig fade" id="modalToggleRec"
                    aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
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

                                        <li class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                            <span class="timeline-indicator-advanced timeline-indicator-success">
                                                <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                            </span>
                                            <div class="timeline-event">

                                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                                    <div class="d-flex align-items-center">

                                                        <span>Soumis le </span>

                                                        <span class="badge bg-label-danger"><?php echo $projetetude->date_soumis; ?></span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">

                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <?php if ($projetetude->flag_affect_departement == true ) {?>
                                    <ul class="timeline pt-3">

                                        <li class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                            <span class="timeline-indicator-advanced timeline-indicator-success">
                                                <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                            </span>
                                            <div class="timeline-event">
                                                <div class="timeline-header border-bottom mb-4">
                                                    <h6 class="mb-0">Traitement du directeur</h6>
                                                    <span class="text-muted"><strong>
                                                            <?php //echo $entreprise_info->raison_social_entreprises;
                                                            ?>
                                                        </strong></span>
                                                </div>
                                                <div class="justify-content-between flex-wrap mb-4">
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
                                    <?php if ($projetetude->flag_affect_service == true ) {?>
                                    <ul class="timeline pt-3">

                                        <li class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                            <span class="timeline-indicator-advanced timeline-indicator-success">
                                                <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
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
                                                <div class="d-flex justify-content-between flex-wrap mb-4">
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
                                    <?php if ($projetetude->flag_affect_conseiller_formation == true ) {?>
                                    <ul class="timeline pt-3">

                                        <li class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                            <span class="timeline-indicator-advanced timeline-indicator-success">
                                                <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
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
                                                <div class="d-flex justify-content-between flex-wrap mb-4">
                                                    <div class="row">

                                                        <span>Commentaire: <?php echo $projetetude->commentaire_chef_service; ?>
                                                        </span> <br>

                                                        <span>Date de l'affectation: <span
                                                                class="badge bg-label-danger"><?php echo $projetetude->date_trans_conseiller_formation; ?></span>
                                                        </span> <br>

                                                        <span>Affecté a: <span
                                                                class="badge bg-label-danger"><?php echo $conseiller_name; ?></span>
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

                                    <?php if ($projetetude->flag_recevabilite != null ) {?>
                                    <ul class="timeline pt-3">

                                        <li class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                            <span class="timeline-indicator-advanced timeline-indicator-success">
                                                <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
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
                                                        <br>
                                                        <span>Date : <span
                                                                class="badge bg-label-danger"><?php echo $projetetude->date_recevabilite; ?>
                                                            </span> </span> <br> <br>



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
                                    <?php if ($projetetude->flag_statut_instruction != null ) {?>
                                    <ul class="timeline pt-3">

                                        <li class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                            <span class="timeline-indicator-advanced timeline-indicator-success">
                                                <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
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
                                                        <br> <br>

                                                        <span>Date : <span
                                                                class="badge bg-label-danger"><?php echo $projetetude->date_instructions; ?>
                                                            </span> </span> <br> <br>



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

            <div class="col-xl-12">
                <h6 class="text-muted"></h6>
                <div class="nav-align-top nav-tabs-shadow mb-4">



                    <div class="accordion mt-3" id="accordionExample">


                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>FICHE PROMOTEUR </strong>
                                </button>
                            </h2>
                            <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-12 col-10" align="left">
                                            <div class="mb-1">
                                                <label>Titre du projet <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="titre_projet" required="required"
                                                    id="titre_projet" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." <?php echo $disable; ?>
                                                    value="{{ $projetetude->titre_projet_etude }}">
                                            </div>
                                            <div class="mb-1">
                                                <label>Operateur <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="operateur" required="required"
                                                    id="operateur" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." <?php echo $disable; ?>
                                                    value="{{ $projetetude->operateur }}">
                                            </div>
                                            <div class="mb-1">
                                                <label>Promoteur <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="promoteur" required="required"
                                                    id="promoteur" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." <?php echo $disable; ?>
                                                    value="{{ $projetetude->promoteur }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6
                                                    col-12">
                                            <div class="mb-1">
                                                <label>Beneficiaire / Cible <span style="color:red;">*</span></label>
                                                <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                    name="beneficiaire_cible" style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->beneficiaires_cible; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Zone du projet <span style="color:red;">*</span>
                                                </label>
                                                <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                                    name="zone_projey" style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->zone_projet; ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionPC" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>PERSONNE A CONTACTER</strong>
                                </button>
                            </h2>
                            <div id="accordionPC" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Nom et prenoms
                                                </label>
                                                <input type="text" name="nom_prenoms" id="titre_projet"
                                                    class="form-control form-control-sm"
                                                    placeholder="ex : Koa Augustin .." <?php echo $disable; ?>
                                                    value="{{ $projetetude->nom_prenoms }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6
                                                    col-12">
                                            <div class="mb-1">
                                                <label>Fonction
                                                </label>
                                                <input type="text" name="fonction" id="fonction"
                                                    class="form-control form-control-sm"
                                                    placeholder="ex : Charge d'etude .." <?php echo $disable; ?>
                                                    value="{{ $projetetude->fonction }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                        col-12">
                                            <div class="mb-1">
                                                <label>Téléphone
                                                </label>
                                                <input type="number" name="telephone" minlength="9" maxlength="10"
                                                    id="telephone" class="form-control form-control-sm"
                                                    placeholder="ex : 02014575777" <?php echo $disable; ?>
                                                    value="{{ $projetetude->telephone }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card
                                                            accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionDP" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>DESCRIPTION DU PROJET</strong>
                                </button>
                            </h2>
                            <div id="accordionDP" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-12">

                                        <div class="col-md-12 col-12">
                                            <div class="mb-4">
                                                <label>Environnement /
                                                    contexte <span style="color:red;">*</span></label>
                                                <textarea class="form-control" required="required" rows="4" id="exampleFormControlTextarea"
                                                    name="environnement_contexte" style="height: 150px;" <?php echo $disable; ?>><?php echo $projetetude->environnement_contexte; ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionAC" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>ACTEURS</strong>
                                </button>
                            </h2>
                            <div id="accordionAC" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="card mb-3">
                                        <div class="card-header pt-2">
                                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link active" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-personal" role="tab"
                                                        aria-selected="true">
                                                        Les beneficiaires
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-account" role="tab"
                                                        tabindex="-1">
                                                        Le promoteur
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-social" role="tab"
                                                        aria-selected="false" tabindex="-1">
                                                        Les partenaires
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-autres" role="tab"
                                                        aria-selected="false" tabindex="-1">
                                                        Autres acteurs
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="form-tabs-personal"
                                                role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
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
                                            <div class="tab-pane fade" id="form-tabs-account" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
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
                                            <div class="tab-pane fade" id="form-tabs-social" role="tabpanel">
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
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
                                            <div class="tab-pane fade" id="form-tabs-autres" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="mb-1">
                                                        <label>Precisez
                                                        </label>
                                                        <input type="text" name="autre_acteur" id="autre_acteur"
                                                            class="form-control form-control-sm" <?php echo $disable; ?>
                                                            value="{{ $projetetude->autre_acteur }} "
                                                            placeholder="ex : Panelistes">
                                                    </div>
                                                </div> <br>
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
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
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionPOD" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>PROBLEMES OBSERVES, OBJET DE LA DEMANDE DE
                                        FINANCEMENT</strong>
                                </button>
                            </h2>
                            <div id="accordionPOD" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
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
                                            <label>Cout de la formation <span style="color:red;">*</span>
                                            </label>
                                            <input type="number" name="cout_projet_formation" required="required"
                                                id="cout_projet_formation" class="form-control form-control-sm"
                                                placeholder="ex : 2000000" <?php echo $disable; ?>
                                                value={{ $projetetude->cout_projet_formation }}>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionACD" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>ANALYSE DES COMPETENCES DES BENEFICIAIRES</strong>
                                </button>
                            </h2>
                            <div id="accordionACD" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
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
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionThree" aria-expanded="false"
                                    aria-controls="accordionThree">
                                    <strong>PIECES JUSTIFICATIVES</strong>
                                </button>
                            </h2>
                            <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample" style="">
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
                                            <input type="file" name="doc_demande_financement" class="form-control"
                                                placeholder="" />
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
                                            <input type="file" name="doc_lettre_engagement" class="form-control"
                                                placeholder="" />
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
                                            <input type="file" name="doc_liste_beneficiaires" class="form-control"
                                                placeholder="" />
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
                                            <input type="file" name="doc_supports_pedagogiques" class="form-control"
                                                placeholder="" />
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
                                            <input type="file" name="doc_preuve_existance" class="form-control"
                                                placeholder="" />
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
                                            <input type="file" name="doc_autre_document" class="form-control"
                                                placeholder="" />
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


                        {{-- <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionACDT" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>Traitement du dossier</strong>
                                </button>
                            </h2>
                            <div id="accordionACDT" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>
                                                    Compétences A CHANGER </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="competences_odf"
                                                    style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->competences; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Evaluation
                                                    des
                                                    compétences A CHANGER
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                    style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->evaluation_contexte; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Sources de
                                                    verification A CHANGER</label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="sources_verification_odf"
                                                    style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->source_verification; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </div>





                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="navs-top-recevabilite" role="tabpanel">

                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_projet_formation)) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <input type="hidden" name="id_combi_proc"
                                        value="{{ \App\Helpers\Crypt::UrlCrypt($id2) }}" />
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">(obligatoire si
                                                    rejeté)*</strong>: </label>
                                            <?php if(count($parcoursexist)<1){?>
                                            <textarea class="form-control form-control-sm" name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                            <?php }else{?>
                                            <textarea class="form-control form-control-sm" name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if(count($parcoursexist)<1){?>
                                        <button type="submit" name="action" value="Valider"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Valider
                                        </button>
                                        <button type="submit" name="action" value="Rejeter"
                                            class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light">
                                            Rejeter
                                        </button>
                                        <?php } ?>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                                    </div>
                                    <!--<div class="col-12 col-md-2" align="right"> <br>
                                                                                                                                                                    <button  type="submit" name="action" value="Enregistrer_categorie_plan" class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>
                                                                                                                                                                </div>-->

                                </div>



                            </form>




                        </div>
                        <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

                        </div>
                    </div>
                </div>
            </div>

        </div>




        <div class="col-md-4 col-12">
            <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggle"
                aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalToggleLabel">Etapes </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="card">
                            <h5 class="card-header">Parcours de la demande de validation du plan de formation</h5>
                            <div class="card-body pb-2">
                                <ul class="timeline pt-3">
                                    @foreach ($ResultProssesList as $res)
                                        <li
                                            class="timeline-item pb-4 timeline-item-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                                            <span
                                                class="timeline-indicator-advanced timeline-indicator-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                                                <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                            </span>
                                            <div class="timeline-event">
                                                <div class="timeline-header border-bottom mb-3">
                                                    <h6 class="mb-0">{{ $res->priorite_combi_proc }}</h6>
                                                    <span class="text-muted"><strong>{{ $res->name }}</strong></span>
                                                </div>
                                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                                    <div class="d-flex align-items-center">
                                                        @if ($res->is_valide == true)
                                                            <div class="row ">
                                                                <div>
                                                                    <span>Observation : {{ $res->comment_parcours }}</span>
                                                                </div>
                                                                <div>
                                                                    <span>Validé le {{ $res->date_valide }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($res->is_valide === false)
                                                            <div class="row">
                                                                <div>
                                                                    <span>Observation : {{ $res->comment_parcours }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="badge bg-label-danger">Validé le
                                                                        {{ $res->date_valide }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @endsection
