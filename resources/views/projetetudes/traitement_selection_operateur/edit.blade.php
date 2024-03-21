@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet d\'etudes')
    @php($titre = 'Information du projet d\'etude')
    @php($soustitre = 'Traitement de sélection des opérateurs pour un projet d\'etude ')
    @php($lien = 'traitementselectionoperateurprojetetude')

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
            <div class="col-xl-12">
                <div align="right" class="mb-2">
                    <button type="button"
                            class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#modalToggle">
                        Voir le parcours de validation
                    </button>
                </div>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-entreprise"
                                aria-controls="navs-top-entreprise"
                                aria-selected="false">
                                Détails de l'entreprise
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-infoprojetetude"
                                aria-controls="navs-top-infoprojetetude"
                                aria-selected="false">
                                Informations du projet d'étude
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-piecesprojetetude"
                                aria-controls="navs-top-piecesprojetetude"
                                aria-selected="false">
                                Pièces jointes du projet
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-selectionoperateurprojetetude"
                                aria-controls="navs-top-selectionoperateurprojetetude"
                                aria-selected="false">
                                Opérateur sélectionné
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-traitementprojetetude"
                                aria-controls="navs-top-traitementprojetetude"
                                aria-selected="false">
                                Traitement
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="navs-top-entreprise" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>N° de compte contribuable (NCC) <strong style="color:red;">*</strong></label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               value="{{@$projet_etude->entreprise->ncc_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Secteur activité <strong style="color:red;">*</strong></label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               value="{{@$projet_etude->entreprise->secteurActivite->libelle_secteur_activite}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Localisation géographique <strong style="color:red;">*</strong></label>
                                        <input type="text" name="localisation_geographique_entreprise" id="localisation_geographique_entreprise"
                                               class="form-control form-control-sm"
                                               value="{{@$projet_etude->entreprise->localisation_geographique_entreprise}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Repère d'accès <strong style="color:red;">*</strong></label>
                                        <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                               class="form-control form-control-sm"
                                               value="{{@$projet_etude->entreprise->repere_acces_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Adresse postal <strong style="color:red;">*</strong></label>
                                        <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                               class="form-control form-control-sm"
                                               value="{{@$projet_etude->entreprise->adresse_postal_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">Type de forme juridique </label>
                                                <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                                    <?= $formjuridique; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Indicatif</label>
                                                <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                                    <?= $pay; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Téléphone <strong style="color:red;">*</strong> </label>
                                                <input type="text"
                                                       class="form-control form-control-sm"
                                                       value="{{@$projet_etude->entreprise->tel_entreprises}}" name="tel_entreprises" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Indicatif</label>
                                                <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                                    <?= $pay; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Cellulaire Professionnelle <strong style="color:red;">*</strong> </label>
                                                <input type="number" name="cellulaire_professionnel_entreprises" id="cellulaire_professionnel_entreprises"
                                                       class="form-control form-control-sm"
                                                       value="{{@$projet_etude->entreprise->cellulaire_professionnel_entreprises}}" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Indicatif</label>
                                                <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                                    <?= $pay; ?>

                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Fax  </label>
                                                <input type="number" name="fax_entreprises" id="fax_entreprises"
                                                       class="form-control form-control-sm"
                                                       value="{{@$projet_etude->entreprise->fax_entreprises}}" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-top-infoprojetetude" role="tabpanel">
                            <div class="row mt-2">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-12 col-10">
                                            <div class="row">
                                                <div class="mb-1 col-md-12">
                                                    <label>Titre du projet <span
                                                            style="color:red;">*</span>
                                                    </label>
                                                    <input type="text" name="titre_projet_instruction"
                                                           required="required" id="titre_projet_instruction"
                                                           disabled
                                                           value ="@isset($projet_etude){{$projet_etude->titre_projet_instruction}}@endisset"
                                                           class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-10">
                                            <div class="row">
                                                <div class="mb-1 col-md-6">
                                                    <label>Financement accordé <span
                                                            style="color:red;">*</span>
                                                    </label>
                                                    <input type="text" name="montant_demande_projet"
                                                           required="required" id="montant_demande_projet"
                                                           disabled
                                                           value ="{{number_format(@$projet_etude->montant_projet_instruction, 0, ',', ' ')}}"
                                                           class="form-control form-control-sm number">
                                                </div>

                                                <div class="mb-1 col-md-6">
                                                    <label>Secteur d'activité du projet <span
                                                            style="color:red;">*</span>
                                                    </label>
                                                    <select name="id_secteur_activite"
                                                            disabled class="select2 form-select-sm input-group" data-allow-clear="true" >
                                                        <?= $secteuractivite_projet; ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="mb-1">
                                        <label for="contexte_probleme_instruction">Contexte ou Problèmes constatés <span style="color:red;">*</span></label>
                                        <div id="contexte_probleme_instruction" class="rounded-1">{!!@$projet_etude->contexte_probleme_instruction !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="mb-1">
                                        <label for="objectif_general_instruction">Objectif Général <span style="color:red;">*</span></label>
                                        <div id="objectif_general_instruction" class="rounded-1">{!!@$projet_etude->objectif_general_instruction !!}</div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="mb-1">
                                        <label for="objectif_specifique_instruction">Objectifs spécifiques <span style="color:red;">*</span> </label>
                                        <div id="objectif_specifique_instruction" class="rounded-1">{!!@$projet_etude->objectif_specifique_instruction !!}</div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="mb-1">
                                        <label for="resultat_attendu_instruction">Résultats attendus <span style="color:red;">*</span>
                                        </label>
                                        <div id="resultat_attendu_instruction" class="rounded-1">{!!@$projet_etude->resultat_attendus_instruction !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="mb-1">
                                        <label for="champ_etude_instruction">Champ de l’étude <span style="color:red;">*</span></label>
                                        <div id="champ_etude_instruction" class="rounded-1">{!!@$projet_etude->champ_etude_instruction !!}</div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mt-2">
                                    <div class="mb-1">
                                        <label for="cible_instruction">Cible <span style="color:red;">*</span>
                                        </label>
                                        <div id="cible_instruction" class="rounded-1">{!!@$projet_etude->cible_instruction !!}</div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 mt-2">
                                    <div class="mb-1">
                                        <label for="methodologie_instruction">Méthodologie <span style="color:red;">*</span></label>
                                        <div id="methodologie_instruction" class="rounded-1">{!!@$projet_etude->methodologie_instruction !!}</div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <label class="form-label" for="fichier_instruction">Pièce jointe <span style="color:red;">*</span></label>
                                        @if($projet_etude->piece_jointe_instruction)
                                            <div><span class="badge bg-secondary mt-1"><a target="_blank"
                                                                                          onclick="NewWindow('{{ asset("pieces_projet/fichier_instruction/". $projet_etude->piece_jointe_instruction)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span></div>

                                        @endif
                                        <div id="" class="form-text">
                                            <em> Fichiers autorisés : PDF, WORD, JPG, JPEG, PNG <br>Taille
                                                maxi : 5Mo</em>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12" align="right">
                                    <hr>
                                    <a  href="{{ route($lien.'.edit',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                    <a  href="{{ route($lien.'.edit',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-top-piecesprojetetude" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type de pièce</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($pieces_projets as $key => $piece)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if($piece->code_pieces=='avant_projet_tdr')
                                                Avant-projet TDR
                                            @endif
                                            @if($piece->code_pieces=='courier_demande_fin')
                                                Courrier de demande de financement
                                            @endif
                                            @if($piece->code_pieces=='offre_technique')
                                                Offre technique
                                            @endif
                                            @if($piece->code_pieces=='offre_financiere')
                                                Offre financière
                                            @endif
                                            @if($piece->code_pieces=='autres_piece')
                                                {{@$piece->intitule_piece}}
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if($piece->code_pieces=='avant_projet_tdr')
                                                <a  href="#" onclick="NewWindow('{{ asset("pieces_projet/avant_projet_tdr/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                    title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='courier_demande_fin')
                                                <a  href="#" onclick="NewWindow('{{ asset("pieces_projet/courier_demande_fin/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                    title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='offre_technique')
                                                <a  href="#" onclick="NewWindow('{{ asset("pieces_projet/offre_technique/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                    title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='offre_financiere')
                                                <a  href="#" onclick="NewWindow('{{ asset("pieces_projet/offre_financiere/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                    title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='autres_piece')
                                                <a href="#"  onclick="NewWindow('{{ asset("pieces_projet/autres_piece/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="navs-top-selectionoperateurprojetetude" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Opérateur </th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($projet_etude->operateurs)
                                    @foreach ($projet_etude->operateurs as $key => $operateur)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $operateur->ncc_entreprises }} / {{ $operateur->raison_social_entreprises }}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade show active" id="navs-top-traitementprojetetude" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id_combi_proc) }}"/>
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>
                                            @if($parcoursexist->count()<1)
                                                <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                            @else
                                                <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if(count($parcoursexist)<1){?>
                                        <button type="submit" name="action" value="Valider"
                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                            Valider
                                        </button>
                                        <button type="submit" name="action" value="Rejeter"
                                                class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                            Rejeter
                                        </button>
                                        <?php } ?>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                           href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

{{--            <div class="content-body">--}}

{{--                <section id="multiple-column-form">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header">--}}
{{--                                    <h5 class="card-title" align="center"> Details du projet d'etude</h5>--}}


{{--                                </div>--}}

{{--                                <div class="card-body">--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="accordion mt-3" id="accordionExample">--}}
{{--                                                <div class="card accordion-item">--}}
{{--                                                    <h2 class="accordion-header" id="headingOne">--}}
{{--                                                        <button type="button" class="accordion-button"--}}
{{--                                                                data-bs-toggle="collapse" data-bs-target="#accordionOne"--}}
{{--                                                                aria-expanded="true" aria-controls="accordionOne">--}}
{{--                                                            Details de l'entreprise--}}
{{--                                                        </button>--}}
{{--                                                    </h2>--}}

{{--                                                    <div id="accordionOne" class="accordion-collapse collapse"--}}
{{--                                                         data-bs-parent="#accordionExample" style="">--}}
{{--                                                        <div class="accordion-body">--}}
{{--                                                            <div class="row gy-3">--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label> <b class="term">Numero de compte--}}
{{--                                                                                contribuable: </b> </label> <br>--}}
{{--                                                                        <label> <?php echo $entreprise->ncc_entreprises; ?></label>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label> <b class="term">Raison sociale: </b>--}}
{{--                                                                        </label> <br>--}}
{{--                                                                        <label> <?php echo $entreprise->raison_social_entreprises; ?></label>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label> <b class="term">Numéro de téléphone: </b>--}}
{{--                                                                        </label> <br>--}}
{{--                                                                        <label> <?php echo $entreprise->tel_entreprises; ?></label>--}}

{{--                                                                    </div>--}}
{{--                                                                </div>--}}

{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label> <b class="term">Email: </b>--}}
{{--                                                                        </label> <br>--}}
{{--                                                                        <label> <?php echo $entreprise_mail;--}}
{{--                                                                                ?></label>--}}


{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label> <b class="term">Situation géographique:--}}
{{--                                                                            </b>--}}
{{--                                                                        </label> <br>--}}
{{--                                                                        <label> <?php echo $entreprise->localisation_geographique_entreprise; ?></label>--}}

{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label> <b class="term">Numéro CNPS:--}}
{{--                                                                            </b>--}}
{{--                                                                        </label> <br>--}}
{{--                                                                        <label> <?php echo $entreprise->numero_cnps_entreprises; ?></label>--}}

{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="card accordion-item">--}}
{{--                                                    <h2 class="accordion-header" id="headingTwo">--}}
{{--                                                        <button type="button" class="accordion-button collapsed"--}}
{{--                                                                data-bs-toggle="collapse" data-bs-target="#accordionTwo"--}}
{{--                                                                aria-expanded="false" aria-controls="accordionTwo">--}}
{{--                                                            Informations du projet d'etude--}}
{{--                                                        </button>--}}
{{--                                                    </h2>--}}
{{--                                                    <div id="accordionTwo" class="accordion-collapse collapse"--}}
{{--                                                         aria-labelledby="headingTwo" data-bs-parent="#accordionExample"--}}
{{--                                                         style="">--}}
{{--                                                        <div class="accordion-body">--}}
{{--                                                            <div class="row gy-3">--}}
{{--                                                                <div class="col-md-12 col-10" align="center">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label>Titre du projet </label>--}}
{{--                                                                        <input type="text" name="titre_projet"--}}
{{--                                                                               id="titre_projet"--}}
{{--                                                                               class="form-control form-control-sm"--}}
{{--                                                                              disabled--}}
{{--                                                                               value="{{ $projet_etude->titre_projet_etude }}">--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label>Contexte ou Problèmes constatés</label>--}}

{{--                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="contexte_probleme"--}}
{{--                                                                                  style="height: 121px;" disabled><?php echo $projet_etude->contexte_probleme_projet_etude; ?></textarea>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label>Objectif Général </label>--}}

{{--                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_general"--}}
{{--                                                                                  style="height: 121px;" disabled><?php echo $projet_etude->objectif_general_projet_etude; ?></textarea>--}}

{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label>Objectifs spécifiques </label>--}}

{{--                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_specifique"--}}
{{--                                                                                  style="height: 121px;" disabled><?php echo $projet_etude->objectif_specifique_projet_etud; ?></textarea>--}}

{{--                                                                    </div>--}}
{{--                                                                </div>--}}

{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label>Résultats attendus </label>--}}

{{--                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="resultat_attendu"--}}
{{--                                                                                  style="height: 121px;" disabled><?php echo $projet_etude->resultat_attendu_projet_etude; ?></textarea>--}}

{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label>Champ de l’étude </label>--}}

{{--                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="champ_etude"--}}
{{--                                                                                  style="height: 121px;" disabled><?php echo $projet_etude->champ_etude_projet_etude; ?></textarea>--}}

{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4 col-12">--}}
{{--                                                                    <div class="mb-1">--}}
{{--                                                                        <label>Cible </label>--}}

{{--                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="cible" style="height: 121px;"--}}
{{--                                                                            disabled><?php echo $projet_etude->cible_projet_etude; ?></textarea>--}}

{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="card accordion-item">--}}
{{--                                                    <h2 class="accordion-header" id="headingThree">--}}
{{--                                                        <button type="button" class="accordion-button collapsed"--}}
{{--                                                                data-bs-toggle="collapse" data-bs-target="#accordionThree"--}}
{{--                                                                aria-expanded="false" aria-controls="accordionThree">--}}
{{--                                                            Pieces jointes du projet--}}
{{--                                                        </button>--}}
{{--                                                    </h2>--}}
{{--                                                    <div id="accordionThree" class="accordion-collapse collapse"--}}
{{--                                                         aria-labelledby="headingThree" data-bs-parent="#accordionExample"--}}
{{--                                                         style="">--}}
{{--                                                        <div class="accordion-body">--}}
{{--                                                            <div class="row gy-3">--}}

{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <label class="form-label">Avant-projet TDR</label> <br>--}}
{{--                                                                    <span class="badge bg-secondary"><a target="_blank"--}}
{{--                                                                                                        onclick="NewWindow('{{ asset('/pieces_projet/avant_projet_tdr/' . $piecesetude1) }}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                                            Voir la pièce </a> </span>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <label class="form-label">Courrier de demande de--}}
{{--                                                                        financement</label> <br>--}}
{{--                                                                    <span class="badge bg-secondary"><a target="_blank"--}}
{{--                                                                                                        onclick="NewWindow('{{ asset('/pieces_projet/courier_demande_fin/' . $piecesetude2) }}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                                            Voir la pièce </a> </span>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <label class="form-label">Dossier d’intention </label>--}}
{{--                                                                    <br>--}}
{{--                                                                    <span class="badge bg-secondary"><a target="_blank"--}}
{{--                                                                                                        onclick="NewWindow('{{ asset('/pieces_projet/dossier_intention/' . $piecesetude3) }}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                                            Voir la pièce </a> </span>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <label class="form-label">Lettre d’engagement</label>--}}
{{--                                                                    <br>--}}
{{--                                                                    <span class="badge bg-secondary"><a target="_blank"--}}
{{--                                                                                                        onclick="NewWindow('{{ asset('/pieces_projet/lettre_engagement/' . $piecesetude4) }}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                                            Voir la pièce </a> </span>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <label class="form-label">Offre technique</label> <br>--}}
{{--                                                                    <span class="badge bg-secondary"><a target="_blank"--}}
{{--                                                                                                        onclick="NewWindow('{{ asset('/pieces_projet/offre_technique/' . $piecesetude5) }}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                                            Voir la pièce </a> </span>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <label class="form-label">Offre financière</label> <br>--}}
{{--                                                                    <span class="badge bg-secondary"><a target="_blank"--}}
{{--                                                                                                        onclick="NewWindow('{{ asset('/pieces_projet/offre_financiere/' . $piecesetude6) }}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                                            Voir la pièce </a> </span>--}}

{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div> <br>--}}
{{--                                                </div>--}}
{{--                                                <div class="card accordion-item active">--}}
{{--                                                    <h2 class="accordion-header" id="headingFour">--}}
{{--                                                        <button type="button" class="accordion-button"--}}
{{--                                                                data-bs-toggle="collapse" data-bs-target="#accordionFour"--}}
{{--                                                                aria-expanded="true" aria-controls="accordionFour">--}}
{{--                                                            Opérateurs sélectionnés--}}
{{--                                                        </button>--}}
{{--                                                    </h2>--}}

{{--                                                    <div id="accordionFour" class="accordion-collapse collapse show"--}}
{{--                                                         data-bs-parent="#accordionExample" style="">--}}
{{--                                                        <div class="accordion-body">--}}
{{--                                                            <div class="row gy-3">--}}
{{--                                                                <table class="table table-bordered table-striped table-hover table-sm "--}}
{{--                                                                       style="margin-top: 13px !important">--}}
{{--                                                                    <thead>--}}
{{--                                                                    <tr>--}}
{{--                                                                        <th>No</th>--}}
{{--                                                                        <th>Localité </th>--}}
{{--                                                                        <th>NCC </th>--}}
{{--                                                                        <th>Raison sociale </th>--}}
{{--                                                                    </tr>--}}
{{--                                                                    </thead>--}}
{{--                                                                    <tbody>--}}
{{--                                                                    @isset($projet_etude->operateurs)--}}
{{--                                                                        @foreach ($projet_etude->operateurs as $key => $operateur)--}}
{{--                                                                            <tr>--}}
{{--                                                                                <td>{{ $key+1 }}</td>--}}
{{--                                                                                <td>{{ $operateur->localite->libelle_localite }}</td>--}}
{{--                                                                                <td>{{ $operateur->ncc_entreprises }}</td>--}}
{{--                                                                                <td>{{ $operateur->raison_social_entreprises }}</td>--}}
{{--                                                                            </tr>--}}
{{--                                                                        @endforeach--}}
{{--                                                                    @endisset--}}
{{--                                                                    </tbody>--}}
{{--                                                                </table>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}


{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <br>--}}

{{--                                    <div class="card-body mt-3">--}}
{{--                                        <div class="col-12" align="left">--}}
{{--                                            <br>--}}
{{--                                            <div class="col-md-12">--}}
{{--                                                <h5 class="card-title mt-3" align="center"> Traitement de la sélection des opérateurs</h5>--}}
{{--                                            </div>--}}
{{--                                            <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)) }}" enctype="multipart/form-data">--}}
{{--                                                @csrf--}}
{{--                                                @method('put')--}}
{{--                                                <div class="row">--}}
{{--                                                    <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id_combi_proc) }}"/>--}}
{{--                                                    <div class="col-md-12 col-12">--}}
{{--                                                        <div class="mb-1">--}}
{{--                                                            <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>--}}
{{--                                                            @if($parcoursexist->count()<1)--}}
{{--                                                                <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>--}}
{{--                                                            @else--}}
{{--                                                                <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>--}}
{{--                                                            @endif--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-12" align="right">--}}
{{--                                                        <hr>--}}
{{--                                                        <?php if(count($parcoursexist)<1){?>--}}
{{--                                                        <button type="submit" name="action" value="Valider"--}}
{{--                                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >--}}
{{--                                                            Valider--}}
{{--                                                        </button>--}}
{{--                                                        <button type="submit" name="action" value="Rejeter"--}}
{{--                                                                class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >--}}
{{--                                                            Rejeter--}}
{{--                                                        </button>--}}
{{--                                                        <?php } ?>--}}
{{--                                                        <a class="btn btn-sm btn-outline-secondary waves-effect"--}}
{{--                                                           href="/{{$lien }}">--}}
{{--                                                            Retour</a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </section>--}}
{{--            </div>--}}
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggle"
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
                        <h5 class="card-header">Parcours de validation du projet d'étude</h5>
                        <div class="card-body pb-2">
                            <ul class="timeline pt-3">
                                @foreach ($ResultProssesList as $res)
                                    <li class="timeline-item pb-4 timeline-item-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                        <div class="timeline-event">
                                            <div class="timeline-header border-bottom mb-3">
                                                <h6 class="mb-0">{{ $res->priorite_combi_proc }}</h6>
                                                <span class="text-muted"><strong>{{ $res->name }}</strong></span>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                <div class="d-flex align-items-center">
                                                    @if($res->is_valide==true)
                                                        <div class="row ">
                                                            <div>
                                                                <span>Observation : {{ $res->comment_parcours }}</span>
                                                            </div>
                                                            <div>
                                                                <span>Validé le  {{ $res->date_valide }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($res->is_valide===false)
                                                        <div class="row">
                                                            <div>
                                                                <span>Observation : {{ $res->comment_parcours }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="badge bg-label-danger">Validé le {{ $res->date_valide }}</span>
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

    <!-- END: Content-->
@endsection

@section('js_perso')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/additional-methods.js')}}"></script>
    <script src="{{asset('assets/js/projetetudes/pages-traitement-projet.js')}}"></script>
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

        contexte_probleme_instruction.disable();
        objectif_general_instruction.disable();
        objectif_specifique_instruction.disable();
        resultat_attendu_instruction.disable();
        champ_etude_instruction.disable();
        cible_instruction.disable();
        methodologie_instruction.disable();
    </script>

@endsection

