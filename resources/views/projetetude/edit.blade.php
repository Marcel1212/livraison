@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'projetetude')
    @php($titre = 'Liste des  projets')
    @php($soustitre = 'Ajouter un projet etude ')
    @php($lien = 'projetetude')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{ $soustitre }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{ $Module }}</a></li>
                                    <li class="breadcrumb-item"><a href="/{{ $lien }}">{{ $titre }}</a></li>
                                    <li class="breadcrumb-item active">{{ $soustitre }} </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

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
                                    <h4 class="card-title">{{ $soustitre }} </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" class="form"
                                        action="{{ route($lien . '.update', \App\Helpers\Crypt::UrlCrypt($projetetude->id_projet_etude)) }}">
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
                                                                            value="{{ $projetetude->titre_projet_etude }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Contexte ou Problèmes constatés</label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="contexte_probleme"
                                                                            style="height: 121px;"><?php echo $projetetude->contexte_probleme_projet_etude; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Objectif Général </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_general"
                                                                            style="height: 121px;"><?php echo $projetetude->objectif_general_projet_etude; ?></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Objectifs spécifiques </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_specifique"
                                                                            style="height: 121px;"><?php echo $projetetude->objectif_specifique_projet_etud; ?></textarea>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Résultats attendus </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="resultat_attendu"
                                                                            style="height: 121px;"><?php echo $projetetude->resultat_attendu_projet_etude; ?></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Champ de l’étude </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="champ_etude"
                                                                            style="height: 121px;"><?php echo $projetetude->champ_etude_projet_etude; ?></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Cible </label>

                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="cible"
                                                                            style="height: 121px;"><?php echo $projetetude->cible_projet_etude; ?></textarea>

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
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/avant_projet_tdr/' . $projetetude->piecesProjetEtudes['0']->libelle_pieces) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Courrier de demande de
                                                                        financement</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/courier_demande_fin/' . $projetetude->piecesProjetEtudes['1']->libelle_pieces) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Dossier d’intention </label>
                                                                    <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/dossier_intention/' . $projetetude->piecesProjetEtudes['2']->libelle_pieces) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre d’engagement</label>
                                                                    <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/lettre_engagement/' . $projetetude->piecesProjetEtudes['3']->libelle_pieces) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre technique</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/offre_technique/' . $projetetude->piecesProjetEtudes['4']->libelle_pieces) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre financière</label> <br>
                                                                    <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset('/pieces_projet/offre_financiere/' . $projetetude->piecesProjetEtudes['5']->libelle_pieces) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <br>
                                                </div>
                                            </div>


                                            <br>
                                            <div class="col-12" align="left">

                                                <div class="col-12" align="right">
                                                    <button type="submit"
                                                        href="{{ route('projetetudesoumettre', \App\Helpers\Crypt::UrlCrypt($projetetude->id_projet_etude)) }}"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                        Soumettre
                                                    </button>
                                                    <button type="submit"
                                                        href="{{ route($lien . '.edit', \App\Helpers\Crypt::UrlCrypt($projetetude->id_projet_etude)) }}"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                        Modifier
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
