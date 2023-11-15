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
                                    <?php if ($projetetude->flag_soumis == true) {?>
                                    <li class="mb-4 pb-1 d-flex justify-content-between align-items-center" align="left">
                                        <div class="badge bg-label-success rounded p-2"><i class="ti ti-circle-check"></i>
                                        </div>
                                        <div class="d-flex justify-content-between w-100 flex-wrap">
                                            <h6 class="mb-0 ms-3">Soumis</h6>
                                        </div>

                                    </li>
                                    <?php }?>
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
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="avant_projet_tdr_modif"
                                                                        class="form-control" placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Courrier de demande de
                                                                        financement</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/courier_demande_fin/' . $piecesetude2) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="courier_demande_fin_modif"
                                                                        class="form-control" placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Dossier d’intention </label>
                                                                    <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/dossier_intention/' . $piecesetude3) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="dossier_intention_modif"
                                                                        class="form-control" placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre d’engagement</label>
                                                                    <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/lettre_engagement/' . $piecesetude4) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="lettre_engagement_modif"
                                                                        class="form-control" placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre technique</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/offre_technique/' . $piecesetude5) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="offre_technique_modif"
                                                                        class="form-control" placeholder="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre financière</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/offre_financiere/' . $piecesetude6) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                    <br>
                                                                    <label class="form-label">Charger un fichier en
                                                                        remplacement </label> <br>
                                                                    <input type="file" name="offre_financiere_modif"
                                                                        class="form-control" placeholder="" />
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
