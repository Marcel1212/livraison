@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet d\'etudes')
    @php($titre = 'Information du projet d\'etude')
    @php($soustitre = 'Ajouter un projet etude ')
    @php($lien = 'projetetude')
    <?php if ($projetetude->flag_soumis == true) {
        $disable = 'disabled';
    } else {
        $disable = '';
    } ?>
    <?php if ($projetetude->flag_soumis_chef_service == true) {
        $disable_cp = 'disabled';
    } else {
        $disable_cp = '';
    } ?>
    <?php if ($projetetude->flag_soumis_charge_etude == true) {
        $disable_cs = 'disabled';
    } else {
        $disable_cs = '';
    } ?>
    <?php if ($projetetude->flag_soumis == true && $projetetude->flag_soumis_chef_service == true && $projetetude->flag_soumis_charge_etude == true && $projetetude->flag_rejet != false or $projetetude->flag_valide != false) {
        $disable_rec = 'disabled';
    } else {
        $disable_rec = '';
    }
    ?>

    <?php if ($projetetude->statut_instruction !== null) {
        $disable_ins = 'disabled';
    } else {
        $disable_ins = '';
    }
    ?>
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
            @if ($message = Session::get('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="content-body">

                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title" align="center"> Details du projet d'etude</h5>


                                </div>

                                <div class="card-body">
                                    <?php if ($projetetude->flag_soumis == true ) {?>
                                    <div align="right">
                                        <button type="button"
                                            class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#modalToggle">
                                            Voir le parcours de validation
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-12">

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
                                                        <h5 class="card-header">Parcours du projet d'etude</h5>
                                                        <div class="card-body pb-2">
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
                                                                            <h6 class="mb-0">Entreprise</h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php echo $entreprise->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between flex-wrap mb-4">
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
                                                            <?php if ($projetetude->flag_soumis_chef_service == true ) {?>
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
                                                                            <h6 class="mb-0">Traitement du chef de
                                                                                departement</h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div class="justify-content-between flex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>Commentaires: <?php echo $projetetude->commentaires_cd; ?>
                                                                                </span> <br>
                                                                                <span>Affecté à :
                                                                                    <span class="badge bg-label-success">
                                                                                        <?php echo $user_cs_name; ?></span>
                                                                                </span> <br>
                                                                                <span>Date de l'affectation :
                                                                                    <span class="badge bg-label-danger">
                                                                                        <?php echo $projetetude->date_trans_chef_s; ?> </span>
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
                                                            <?php if ($projetetude->flag_soumis_charge_etude == true ) {?>
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
                                                                            <div class="row ">

                                                                                <span>Commentaire: <?php echo $projetetude->commentaires_cs; ?>
                                                                                </span> <br>
                                                                                <span>Affecté à :
                                                                                    <span class="badge bg-label-success">
                                                                                        <?php echo $user_ce_name; ?></span>
                                                                                </span> <br>

                                                                                <span>Date de l'affectation: <span
                                                                                        class="badge bg-label-danger"><?php echo $projetetude->date_trans_charg_etude; ?></span>
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

                                                            <?php if ($projetetude->flag_valide == null && $projetetude->flag_rejet == null && $projetetude->flag_attente_rec == true   ) {?>
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
                                                                            <h6 class="mb-0">Traitement de la
                                                                                recevabilite</h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div class="d-flex lex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>Statut : <span
                                                                                        class="badge bg-label-warning"> EN
                                                                                        ATTENTE
                                                                                    </span> </span> <br>
                                                                                </span>

                                                                                <span>Motif : <?php echo $projetetude->motif_rec;
                                                                                ?></span>
                                                                                <br>
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


                                                            <?php if ($projetetude->flag_valide != null OR $projetetude->flag_rejet != null ) {?>
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
                                                                            <h6 class="mb-0">Traitement de la
                                                                                recevabilite</h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div class="d-flex lex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>Statut : <?php if ($projetetude->flag_valide == true) {
                                                                                    echo 'RECEVABLE';
                                                                                } else {
                                                                                    echo 'NON RECEVABLE  ';
                                                                                } ?>
                                                                                </span>
                                                                                <br>
                                                                                <span>Motif : <?php echo $projetetude->motif_rec;
                                                                                ?></span>
                                                                                <br>
                                                                                <span>Date : <span
                                                                                        class="badge bg-label-danger"><?php echo $projetetude->date_valide; ?>
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
                                                            <?php if ($projetetude->statut_instruction != null ) {?>
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
                                                                            <h6 class="mb-0">Traitement de
                                                                                l'instruction
                                                                            </h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div class="d-flex lex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>Statut : <?php if ($projetetude->statut_instruction == true) {
                                                                                    echo 'RECEVABLE  ';
                                                                                } else {
                                                                                    echo 'NON RECEVABLE  ';
                                                                                } ?>
                                                                                </span>
                                                                                <br>
                                                                                <span>Commentaires : <?php echo $projetetude->commentaires_instruction; ?>
                                                                                </span>
                                                                                <br>

                                                                                <span>Date : <span
                                                                                        class="badge bg-label-danger"><?php echo $projetetude->date_instruction; ?>
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

                                    <?php }?>
                                    {{-- <?php //if ($projetetude->flag_soumis == true && $projetetude->flag_valide == null && $projetetude->flag_rejet == null) {
                                    ?>
                                    <li class="mb-4 pb-1 d-flex justify-content-between align-items-center"
                                        align="center">
                                        <div class="badge bg-label-success rounded p-2"><i class="ti ti-circle-check"></i>
                                        </div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap">
                                            <h6 class="mb-0 ms-3">Soumis</h6>
                                        </div>

                                    </li>
                                    <?php //}else if ($projetetude->flag_soumis == true &&  $projetetude->flag_valide == true && $projetetude->flag_rejet == false){
                                    ?>
                                    <li class="mb-4 pb-1 d-flex justify-content-between align-items-center"
                                        align="center">
                                        <div class="badge bg-label-success rounded p-2"><i class="ti ti-link ti-sm"></i>
                                        </div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap">
                                            <h6 class="mb-0 ms-3">Recevable</h6>
                                        </div>

                                    </li>
                                    <?php// }else if ($projetetude->flag_rejet == true &&  $projetetude->flag_valide == false && $projetetude->flag_soumis == true){?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?>
                                    <div class ="row  gy-3">
                                        <div class="col-md-4 col-12">
                                            <li class="mb-4 pb-1 d-flex justify-content-between align-items-center"
                                                align="center">
                                                <div class="badge bg-label-danger rounded p-2"><i
                                                        class="ti ti-ban ti-sm"></i>
                                                </div>
                                                <div class="d-flex justify-content-between w-100 flex-wrap">
                                                    <h6 class="mb-0 ms-3">Rejeter</h6>
                                                </div>

                                            </li>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <button type="button" class="btn btn-secondary waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target="#modalToggle">
                                                Motif
                                            </button>
                                            <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel"
                                                tabindex="-1" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalToggleLabel">Motif</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"><?php //echo $projetetude->motif_rec;
                                                        ?></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php //}
                                    ?>
                                    <?php// if ($projetetude->flag_attente_rec == true ) {?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?>
                                    <div class ="row  gy-3">
                                        <div class="col-md-4 col-12">
                                            <li class="mb-4 pb-1 d-flex justify-content-between align-items-center"
                                                align="center">
                                                <div class="badge bg-label-warning rounded p-2"><i
                                                        class="ti ti-circle-check"></i>
                                                </div>
                                                <div class="d-flex justify-content-between w-100 flex-wrap">
                                                    <h6 class="mb-0 ms-3">Mis en attente</h6>
                                                </div>

                                            </li>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <button type="button" class="btn btn-secondary waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target="#modalToggle">
                                                Motif
                                            </button>
                                            <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel"
                                                tabindex="-1" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalToggleLabel">Motif</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"><?php //echo $projetetude->motif_rec;
                                                        ?></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php //}
                                    ?> --}}
                                    <form method="POST" class="form"
                                        action="{{ route($lien . '.update', \App\Helpers\Crypt::UrlCrypt($projetetude->id_projet_etude)) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
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
                                                                        <label> <?php echo $enterprise_mail;
                                                                        ?></label>


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
                                                                        <label>Titre du projet </label>
                                                                        <input type="text" name="titre_projet"
                                                                            id="titre_projet"
                                                                            class="form-control form-control-sm"
                                                                            <?php echo $disable; ?>
                                                                            value="{{ $projetetude->titre_projet_etude }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Contexte ou Problèmes constatés</label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="contexte_probleme"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->contexte_probleme_projet_etude; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Objectif Général </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_general"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->objectif_general_projet_etude; ?></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Objectifs spécifiques </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_specifique"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->objectif_specifique_projet_etud; ?></textarea>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Résultats attendus </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="resultat_attendu"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->resultat_attendu_projet_etude; ?></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Champ de l’étude </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="champ_etude"
                                                                            style="height: 121px;" <?php echo $disable; ?>><?php echo $projetetude->champ_etude_projet_etude; ?></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Cible </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="cible" style="height: 121px;"
                                                                            <?php echo $disable; ?>><?php echo $projetetude->cible_projet_etude; ?></textarea>

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
                                                                    <label class="form-label">Avant-projet TDR</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/avant_projet_tdr/' . $piecesetude1) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <?php if ($projetetude->flag_soumis == false) { ?>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="avant_projet_tdr_modif"
                                                                        class="form-control" placeholder="" />
                                                                    <?php }?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Courrier de demande de
                                                                        financement</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/courier_demande_fin/' . $piecesetude2) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <?php if ($projetetude->flag_soumis == false) { ?>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="courier_demande_fin_modif"
                                                                        class="form-control" placeholder="" />
                                                                    <?php }?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Dossier d’intention </label>w
                                                                    <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/dossier_intention/' . $piecesetude3) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <?php if ($projetetude->flag_soumis == false) { ?>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="dossier_intention_modif"
                                                                        class="form-control" placeholder="" />
                                                                    <?php }?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre d’engagement</label>
                                                                    <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/lettre_engagement/' . $piecesetude4) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <?php if ($projetetude->flag_soumis == false) { ?>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="lettre_engagement_modif"
                                                                        class="form-control" placeholder="" />
                                                                    <?php }?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre technique</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/offre_technique/' . $piecesetude5) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <?php if ($projetetude->flag_soumis == false) { ?>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="offre_technique_modif"
                                                                        class="form-control" placeholder="" />
                                                                    <?php }?>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre financière</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/offre_financiere/' . $piecesetude6) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <?php if ($projetetude->flag_soumis == false) { ?>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="offre_financiere_modif"
                                                                        class="form-control" placeholder="" />
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <br>
                                                </div>
                                            </div>


                                            <br>
                                            <div class="col-12" align="left">
                                                <br>
                                                <div class="col-12" align="right">
                                                    <?php if($projetetude->flag_soumis == false) {?>
                                                    <button type="submit" type="submit" name="action"
                                                        value="soumission_plan_formation"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                        Soumettre
                                                    </button>

                                                    <button type="submit" type="submit" name="action"
                                                        value="modifier_plan_formation"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                        Modifier
                                                    </button>
                                                    <?php }?>
                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                        href="/{{ $lien }}">
                                                        Retour</a>

                                                </div>
                                            </div>
                                    </form>
                                    <?php if ($nomrole == "CHEF DE DEPARTEMENT" && $projetetude->flag_soumis_chef_service == null) { ?>
                                    <div class="card-body">
                                        <h5 class="card-title" align="center"> Traitement du chef de
                                            departement</h5>
                                        <div class="row">
                                            <label class="form-label">Liste des chefs de service <span
                                                    style="color:red;">*</span></label>
                                            <select id="id_chef_service" name="id_chef_service" class="form-select"
                                                <?php echo $disable_cp; ?> required="required">
                                                <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_soumis_chef_service != true) {?>
                                                <?php echo $listeuserfinal; ?>
                                                <?php }else{?>
                                                <option value="1"> <?php echo $user_cs_name; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="form-label">Commentaires</label>
                                            <textarea class="form-control" id="commentaires_chef_dep" name="commentaires_chef_dep" rows="4"
                                                <?php echo $disable_cp; ?>><?php echo $projetetude->commentaires_cd; ?></textarea>
                                        </div>
                                        <div class="col-12" align="left">
                                            <br>
                                            <div class="col-12" align="right">
                                                <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_soumis_chef_service != true) {?>
                                                <button type="submit" type="submit" name="action"
                                                    value="soumission_plan_etude_cd"
                                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Soumettre au chef de service
                                                </button>
                                                <?php }?>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                    href="/{{ $lien }}">
                                                    Retour</a>

                                            </div>
                                        </div>

                                    </div>
                                    <?php }?>

                                    <?php if ($nomrole == "CHEF DE SERVICE" && $projetetude->flag_soumis_chef_service == true && $projetetude->flag_soumis_charge_etude == null ) { ?>
                                    <div class="card-body">
                                        <h5 class="card-title" align="center"> Traitement du chef de service</h5>
                                        <div class="row">
                                            <label class="form-label">Liste des charge d'etude <span
                                                    style="color:red;">*</span></label>
                                            <select id="id_chef_service" name="id_charge_etude" class="form-select"
                                                <?php echo $disable_cs; ?> required="required">
                                                <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_soumis_chef_service == true  &&  $projetetude->flag_soumis_charge_etude != true ) {?>
                                                <?php echo $listeuserfinal; ?>
                                                <?php }else{?>
                                                <option value="1"> <?php echo $user_ce_name; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="form-label">Commentaires</label>
                                            <textarea class="form-control" id="commentaires_chef_service" name="commentaires_chef_service" rows="4"
                                                <?php echo $disable_cs; ?>><?php echo $projetetude->commentaires_cs; ?></textarea>
                                        </div>
                                        <div class="col-12" align="left">
                                            <br>
                                            <div class="col-12" align="right">
                                                <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_soumis_chef_service == true &&  $projetetude->flag_soumis_charge_etude != true) {?>
                                                <button type="submit" type="submit" name="action"
                                                    value="soumission_plan_etude_cs"
                                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Soumettre au charge d'etude
                                                </button>
                                                <?php }?>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                    href="/{{ $lien }}">
                                                    Retour</a>

                                            </div>
                                        </div>

                                    </div>
                                    <?php }?>


                                    <?php if ($nomrole == "CHARGER ETUDE" && $projetetude->flag_soumis_charge_etude == true && $projetetude->flag_valide == null ) { ?>
                                    <div class="card-body">
                                        <h5 class="card-title" align="center"> Traitement de la recevabilité du dossier
                                        </h5>
                                        <div class="row">
                                            <label class="form-label">Statut de la recevabilité <span
                                                    style="color:red;">*</span></label>
                                            <select required="required" id="id_charge_etude" name="id_charge_etude"
                                                class="form-select" <?php echo $disable_rec; ?> required="required">
                                                <?php if($projetetude->date_valide == null && $projetetude->date_rejet == null) { ?>
                                                ?>
                                                <?php echo $statuts;
                                                ?>
                                                <?php }else{
                                            ?>
                                                <option value="1"> <?php echo $etat_dossier; ?></option>
                                                <?php }
                                            ?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="form-label">Motif<span style="color:red;">*</span></label>
                                            <select required="required" id="motif_rec" name="motif_rec"
                                                class="form-select" <?php echo $disable_rec; ?> required="required">
                                                <?php if($projetetude->date_valide == null && $projetetude->date_rejet == null) { ?>
                                                <?php echo $motifs;
                                                ?>
                                                <?php }else{
                                            ?>
                                                <option value="1"> <?php echo $motif_p; ?></option>
                                                <?php }
                                            ?>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="form-label">Commentaires </label>
                                            <textarea class="form-control" id="commentaires_chef_service" name="commentaires_chef_service" rows="4"
                                                <?php echo $disable_rec;
                                                ?>><?php echo $projetetude->commentaires_recevabilite;
                                                ?></textarea>
                                        </div>

                                        <div class="col-12" align="left">
                                            <br>
                                            <div class="col-12" align="right">
                                                <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_soumis_chef_service == true &&  $projetetude->flag_soumis_charge_etude == true &&  $projetetude->flag_rejet == false  &&  $projetetude->flag_valide == false ) {?>
                                                <button type="submit" type="submit" name="action"
                                                    value="soumission_recevabilite"
                                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Valider
                                                </button>
                                                <?php }?>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                    href="/{{ $lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }
                                    ?>
                                    <?php if ($projetetude->flag_valide == true && $projetetude->flag_rejet == false) { ?>
                                    <div class="card-body">
                                        <h5 align="center"> Traitement de l'instruction du dossier
                                        </h5>

                                        <div class="row">
                                            <?php if ($projetetude->statut_instruction === null) {?>
                                            <label class="form-label">Statut d'instruction <span
                                                    style="color:red;">*</span></label>
                                            <select required="required" id="id_charge_etude" name="id_statut_instruction"
                                                class="form-select" <?php //echo $disable_rec;
                                                ?> required="required">
                                                <?php if($projetetude->flag_soumis == true &&  $projetetude->flag_soumis_chef_service == true  &&  $projetetude->flag_soumis_charge_etude == true &&  $projetetude->flag_valide == true &&  $projetetude->statut_instruction == null ) {
                                            ?>
                                                <?php echo $statutinst;
                                                ?>
                                                <?php }else{
                                                ?>
                                                <option value="1"> <?php //echo $user_ce_name;
                                                ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <?php }else {?>
                                        <?php if ($projetetude->statut_instruction == true){?>

                                        <div class="row">
                                            <li class="mb-4 pb-1 d-flex justify-content-between  align-items-center"
                                                align="center">
                                                <div class="badge bg-label-success rounded p-2"><i
                                                        class="ti ti-circle-check"></i>
                                                </div>
                                                <div class="d-flex justify-content-between w-100 flex-wrap">
                                                    <h6 class="mb-0 ms-3">Dossier Validé</h6>
                                                </div>

                                            </li>
                                        </div>
                                        <?php }else if($projetetude->statut_instruction == false) {?>

                                        <div class="row">
                                            <li class="mb-4 pb-1 d-flex justify-content-between  align-items-center"
                                                align="center">
                                                <div class="badge bg-label-danger rounded p-2"><i
                                                        class="ti ti-ban ti-sm"></i>
                                                </div>
                                                <div class="d-flex justify-content-between w-100 flex-wrap">
                                                    <h6 class="mb-0 ms-3">Dossier Rejété</h6>
                                                </div>

                                            </li>
                                        </div>

                                        <?php }?>
                                        <?php }?>
                                        <?php if ($disable_ins == '') { ?>
                                        <div class="row">
                                            <label class="form-label">Commentaires </label>
                                            <textarea class="form-control" id="commentaires_instruction" name="commentaires_instruction" rows="4"
                                                <?php echo $disable_ins; ?>><?php if ($disable_ins != '') {
                                                    echo $projetetude->commentaires_instruction;
                                                } ?></textarea>
                                        </div>
                                        <?php }?>
                                        <div class="accordion mt-3" id="accordionExample">
                                            <div class="card accordion-item">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button type="button" class="accordion-button collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#accordionTwoInstruction" aria-expanded="false"
                                                        aria-controls="accordionTwo">
                                                        Informations du projet d'etude
                                                    </button>
                                                </h2>
                                                <div id="accordionTwoInstruction" class="accordion-collapse collapse"
                                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                    style="">
                                                    <div class="accordion-body">
                                                        <div class="row gy-3">
                                                            <div class="col-md-12 col-10" align="center">
                                                                <div class="mb-1">
                                                                    <label>Titre du projet <span
                                                                            style="color:red;">*</span>
                                                                    </label>
                                                                    <input type="text" name="titre_projet_instruction"
                                                                        required="required" id="titre_projet_instruction"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="ex : Perfectionnement .."
                                                                        <?php echo $disable_ins; ?>
                                                                        value="{{ $projetetude->titre_projet_instruction }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="mb-1">
                                                                    <label>Contexte ou Problèmes constatés <span
                                                                            style="color:red;">*</span></label>
                                                                    <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                        name="contexte_probleme_instruction" style="height: 121px;" <?php echo $disable_ins; ?>><?php if ($disable_ins != '') {
                                                                            echo $projetetude->contexte_probleme_instruction;
                                                                        } ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="mb-1">
                                                                    <label>Objectif Général <span
                                                                            style="color:red;">*</span>
                                                                    </label>
                                                                    <textarea required="required" class="form-control" rows="3"
                                                                        id="exampleFormControlTextarea"name="objectif_general_instruction" style="height: 121px;" <?php echo $disable_ins; ?>><?php if ($disable_ins != '') {
                                                                            echo $projetetude->objectif_general_instruction;
                                                                        } ?></textarea>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="mb-1">
                                                                    <label>Objectifs spécifiques <span
                                                                            style="color:red;">*</span> </label>
                                                                    <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                        name="objectif_specifique_instruction" style="height: 121px;" <?php echo $disable_ins; ?>><?php if ($disable_ins != '') {
                                                                            echo $projetetude->objectif_specifique_instruction;
                                                                        } ?>
                                                                </textarea>

                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 col-12">
                                                                <div class="mb-1">
                                                                    <label>Résultats attendus <span
                                                                            style="color:red;">*</span>
                                                                    </label>
                                                                    <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                                        name="resultat_attendu_instruction" style="height: 121px;" <?php echo $disable_ins; ?>><?php if ($disable_ins != '') {
                                                                            echo $projetetude->resultat_attendus_instruction;
                                                                        } ?></textarea>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="mb-1">
                                                                    <label>Champ de l’étude <span
                                                                            style="color:red;">*</span></label>
                                                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="champ_etude_instruction"
                                                                        style="height: 121px;" required="required" <?php echo $disable_ins; ?>><?php if ($disable_ins != '') {
                                                                            echo $projetetude->champ_etude_instruction;
                                                                        } ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="mb-1">
                                                                    <label>Cible <span style="color:red;">*</span>
                                                                    </label>
                                                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="cible_instruction"
                                                                        style="height: 121px;" required="required" <?php echo $disable_ins; ?>> <?php if ($disable_ins != '') {
                                                                            echo $projetetude->cible_instruction;
                                                                        } ?></textarea>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="mb-1">
                                                                    <label>Methodologie <span style="color:red;">*</span>
                                                                    </label>
                                                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="methodologie_instruction"
                                                                        style="height: 121px;" required="required" <?php echo $disable_ins; ?>> <?php if ($disable_ins != '') {
                                                                            echo $projetetude->methodologie_instruction;
                                                                        } ?></textarea>

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
                                                                <?php if ($disable_ins == '') { ?>
                                                                <label class="form-label">Fichier d'instruction <span
                                                                        style="color:red;">*</span> (PDF, WORD, JPG)
                                                                    5M</label>
                                                                <input type="file" name="fichier_instruction"
                                                                    class="form-control" placeholder=""
                                                                    required="required" />
                                                                <?php }else {?>
                                                                <label class="form-label">Fichier d'instruction </label>
                                                                <br>
                                                                <span class="badge bg-secondary"><a target="_blank"
                                                                        onclick="NewWindow('{{ asset('/pieces_projet/fichier_instruction/' . $projetetude->piece_jointe_instruction) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                        Voir la pièce </a> </span>
                                                                <?php }?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div> <br>
                                            </div>
                                            <?php if ($disable_ins == '') { ?>
                                            <div class="col-12" align="left">
                                                <br>
                                                <div class="col-12" align="right">

                                                    <button type="submit" type="submit" name="action"
                                                        value="soumission_instruction"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                        Soumettre au comité technique
                                                    </button>

                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                        href="/{{ $lien }}">
                                                        Retour</a>

                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <?php }?>
                                    <?php //}
                                    ?>
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
