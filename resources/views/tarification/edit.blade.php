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
                                                        <h5 class="modal-title" id="modalToggleLabel">ETAPES </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="card">
                                                        <h5 class="card-header">Parcours de la livraison</h5>
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

                                                                        <div
                                                                            class="d-flex justify-content-between flex-wrap mb-2">
                                                                            <div class="d-flex align-items-center">

                                                                                <span>SOUMIS PAR LE CLIENT LE : </span>

                                                                                <span class="badge bg-label-info">
                                                                                    <?php
                                                                                    $locale = 'fr_FR';
                                                                                    $dateActuelle = new \DateTime($livraison->created_at);
                                                                                    $dateFormatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
                                                                                    $dateFormatee = $dateFormatter->format($dateActuelle);
                                                                                    ?>
                                                                                    {{ $dateFormatee }} </span>
                                                                            </div>
                                                                            <div class="d-flex align-items-center">

                                                                                <span>A LIVRER LE : </span>

                                                                                <span class="badge bg-label-danger">
                                                                                    <?php
                                                                                    $locale = 'fr_FR';
                                                                                    $dateActuelle = new \DateTime($livraison->date_livraison);
                                                                                    $dateFormatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
                                                                                    $dateFormatee = $dateFormatter->format($dateActuelle);
                                                                                    ?>
                                                                                    {{ $dateFormatee }} </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>


                                                            <?php //if ($projetetude->flag_statut_instruction != null ) {
                                                            ?>
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
                                                                            <h6 class="mb-0">EVOLUTION DE LA LIVRAISON
                                                                            </h6>
                                                                            <span class="text-muted"><strong>
                                                                                    <?php //echo $entreprise_info->raison_social_entreprises;
                                                                                    ?>
                                                                                </strong></span>
                                                                        </div>
                                                                        <div class="d-flex lex-wrap mb-4">
                                                                            <div class="row ">

                                                                                <span>ETAPE : <?php //if ($projetetude->flag_statut_instruction == true) {
                                                                                // echo 'RECEVABLE  ';
                                                                                // } else {
                                                                                //    echo 'NON RECEVABLE  ';
                                                                                // }
                                                                                ?> </span>
                                                                                <br>

                                                                                <span>DATE DE LIVRAISON : <span
                                                                                        class="badge bg-label-danger"><?php //echo $projetetude->date_instructions;
                                                                                        ?>
                                                                                        <?php
                                                                                        if ($livraison->date_livraison_effectue != null) {
                                                                                            $locale = 'fr_FR';
                                                                                            $dateActuelle = new \DateTime($livraison->date_livraison_effectue);
                                                                                            $dateFormatter = new \IntlDateFormatter($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
                                                                                            $dateFormatee = $dateFormatter->format($dateActuelle);
                                                                                        } else {
                                                                                            $dateFormatee = 'PAS ENCORE LIVRE';
                                                                                        } ?>
                                                                                        {{ $dateFormatee }}
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
                                                            <?php //}
                                                            ?>







                                                            </li>


                                                            </ul>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php //}
                                    ?>
                                    <form method="POST" class="form"
                                        action="{{ route($lien . '.updatelivraison', \App\Helpers\Crypt::UrlCrypt($livraison->id_livraison)) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <br>
                                        <div class="row">
                                            <div class="card-body">


                                                <hr class="my-3 mx-n4">



                                                <div class="row p-sm-4 p-0">
                                                    <div class="col-md-6 col-sm-7">
                                                        <h6 class="mb-4">
                                                            <strong>EXPEDITEUR:</strong>
                                                        </h6>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="pe-4">Nom et
                                                                        prenoms:</td>
                                                                    <td><span class="fw-medium"
                                                                            name="nom_exp"><strong>{{ $livraison->nom_exp }}</strong></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pe-4">Contact:
                                                                    </td>
                                                                    <td><span class="fw-medium"
                                                                            name="numero_exp"><strong>{{ $livraison->numero_exp }}</strong></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pe-4">Lieu de
                                                                        recuperation:</td>
                                                                    <td> <strong>{{ $livraison->localitedest->libelle_localite }}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pe-4">Details:
                                                                    </td>
                                                                    <td><strong>{{ $livraison->details_exp }}</strong>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6 col-sm-7">
                                                        <h6 class="mb-4">
                                                            <strong>DESTINATAIRE:</strong>
                                                        </h6>
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="pe-4">Nom et
                                                                        prenoms:</td>
                                                                    <td><span class="fw-medium">
                                                                            <strong>{{ $livraison->nom_dest }}</strong></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pe-4">Contact:
                                                                    </td>
                                                                    <td><span class="fw-medium"
                                                                            name="numero_exp"><strong>{{ $livraison->numero_dest }}</strong></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pe-4">Lieu de
                                                                        recuperation:</td>
                                                                    <td> <strong>{{ $livraison->localite->libelle_localite }}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pe-4">Details:
                                                                    </td>
                                                                    <td> <strong>{{ $livraison->details_dest }}</strong>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>


                                                <div class="col-lg mb-md-0 mb-4">
                                                    <div class="card border-primary border shadow-none">
                                                        <div class="card-body position-relative">

                                                            <h3 class="card-title text-center text-capitalize mb-1">
                                                                Prix / Code Livraison</h3>
                                                            <div class="text-center">
                                                                <div class="d-flex justify-content-center">

                                                                    <h1
                                                                        class="price-toggle price-yearly display-4 text-primary mb-0">
                                                                        {{ $livraison->prix }} <br>
                                                                        <small>{{ $livraison->code_livraison }}</small>
                                                                        <br>
                                                                        {{-- <button type="button"
                                                                            class="btn rounded-pill btn-success waves-effect waves-light"> --}}
                                                                        <?php if ($livraison->flag_a_traite != false ) {  ?>
                                                                        <small> LIVREUR :
                                                                            {{ $chargerHabilitations->name }}
                                                                            {{ $chargerHabilitations->prenom_users }}</small>
                                                                        {{-- </button> --}}
                                                                        <?php } ?>

                                                                        <br>

                                                                        <?php if ($livraison->commentaire_livraison != null ) {  ?>
                                                                        <small> COMMENTAIRE :
                                                                            <i>{{ $livraison->commentaire_livraison }}</i>
                                                                        </small>
                                                                        {{-- </button> --}}
                                                                        <?php } ?>

                                                                    </h1>
                                                                    </h1>
                                                                    <sup
                                                                        class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">F
                                                                        CFA</sup>


                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>




                                            </div>



                                        </div>
                                        <?php if ($nomrole == 'GESTIONNAIRE LIVRAISON' ) {
                                                ?>
                                        <div class="row">

                                            <div class="accordion mt-3" id="accordionExample">
                                                <?php if ($nomrole == 'GESTIONNAIRE LIVRAISON' && $livraison->flag_a_traite == false ) {
                                                ?>
                                                <div class="card accordion-item active">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button type="button" class="accordion-button"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionOne"
                                                            aria-expanded="true" aria-controls="accordionOne">
                                                            <strong>TRAITEMENT DE LA LIVRAISON ( AFFECTATION )</strong>
                                                        </button>
                                                    </h2>

                                                    <div id="accordionOne" class="accordion-collapse collapse show"
                                                        data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-12">
                                                                            <label class="form-label"
                                                                                for="billings-country"><strong>Liste des
                                                                                    livreurs </strong>
                                                                                <strong
                                                                                    style="color:red;">*</strong></label>
                                                                            <?php if ($livraison->flag_a_traite == false){
                                                                            ?>
                                                                            <select
                                                                                class="select2 form-select-sm input-group"
                                                                                required="required"
                                                                                data-allow-clear="true" name="id_livreur">

                                                                                <?= $chargerHabilitationsList ?>
                                                                            </select>
                                                                            <?php }elseif ($livraison->flag_a_traite == true){
                                                                            ?>
                                                                            <div class="mb-1">
                                                                                <input type="text" name="id_livreur"
                                                                                    id="id_livreur" disabled
                                                                                    class="form-control form-control-sm"
                                                                                    value="{{ $chargerHabilitations->name }} {{ $chargerHabilitations->prenom_users }}">
                                                                            </div>
                                                                            <?php }
                                                                            ?>


                                                                        </div>


                                                                    </div>
                                                                </div>
                                                                <?php if ($livraison->flag_a_traite != true){
                                                                            ?>
                                                                <div class="col-md-4">
                                                                    <table
                                                                        class="table table-bordered table-striped table-hover table-sm"
                                                                        id=""
                                                                        style="margin-top: 13px !important">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Livreur(s) </th>
                                                                                <th>Livraison(s) en cours</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i = 0; ?>
                                                                            @foreach ($NombreDemandeHabilitation as $key => $nbre)
                                                                                <tr>
                                                                                    <td>{{ ++$i }}</td>
                                                                                    <td>{{ @$nbre->name }}
                                                                                        {{ @$nbre->prenom_users }}</td>
                                                                                    <td>{{ @$nbre->nbre_dossier_en_cours }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                                <?php } ?>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-12" align="right"> <br>
                                                    <button type="submit" name="action" value="affecter_livraison"
                                                        class="btn btn-sm btn-primary me-sm-3 me-1"
                                                        onclick='javascript:if (!confirm("Voulez-vous affecter cette livraison au livreur ?")) return false;'>Affecter</button>
                                                </div>
                                                <?php }
                                                ?>



                                                <br>
                                                <?php }
                                                ?>

                                                <?php if ($nomrole == 'LIVREUR' && $livraison->flag_a_traite == true && $livraison->flag_en_attente === false  ) { ?>
                                                <div class="col-12 col-md-12" align="right"> <br>
                                                    <button type="submit" name="action" value="valider_livraison"
                                                        class="btn btn-sm btn-success me-sm-3 me-1"
                                                        onclick='javascript:if (!confirm("Voulez-vous valider la commande ?")) return false;'>VALIDER
                                                        LA LIVRAISON / DEMARREZ ! </button>
                                                </div>
                                                <?php }   ?>

                                                <?php if ($nomrole == 'LIVREUR' && $livraison->flag_a_traite == true && $livraison->flag_en_attente === true && $livraison->flag_liv_en_cours === false   ) { ?>
                                                <div class="col-12 col-md-12" align="right"> <br>
                                                    <button type="submit" name="action" value="valider_reception"
                                                        class="btn btn-sm btn-success me-sm-3 me-1"
                                                        onclick='javascript:if (!confirm("Voulez-vous valider la reception du colis ?")) return false;'>VALIDER
                                                        LA RECEPTION DU COLIS </button>
                                                </div>
                                                <?php }   ?>
                                                <?php if ($nomrole == 'LIVREUR' && $livraison->flag_a_traite == true && $livraison->flag_en_attente === true && $livraison->flag_liv_en_cours === true  && $livraison->flag_livre === false   ) { ?>
                                                <div class="col-12 col-md-12" align="right"> <br>
                                                    <button type="submit" name="action"
                                                        value="valider_succes_livraison"
                                                        class="btn btn-sm btn-success me-sm-3 me-1"
                                                        onclick='javascript:if (!confirm("Voulez-vous valider le succes de la livraison  ?")) return false;'>VALIDER
                                                        LA LIVRAISON </button>
                                                </div>
                                                <?php }   ?>

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
