@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Demandes')
    @php($titre = 'Liste des projets d\'études')
    @php($soustitre = 'Modifier une demande de projet d\'étude ')
    @php($lien = 'ctprojetetudevalider')

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

            <div class="col-xl-12">
                <div align="right">
                    <button type="button"
                            class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#modalToggle">
                        Voir le parcours de validation
                    </button>
                </div>
                <h6 class="text-muted"></h6>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-projetetude"
                                aria-controls="navs-top-projetetude"
                                aria-selected="true">
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
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-traitement"
                                aria-controls="navs-top-traitement"
                                aria-selected="false">
                                Traitement
                            </button>
                        </li>


                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade" id="navs-top-projetetude" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>N° de compte contribuable (NCC) <strong style="color:red;">*</strong></label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               value="{{@$infoentreprise->ncc_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Secteur activité <strong style="color:red;">*</strong></label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               value="{{@$infoentreprise->secteurActivite->libelle_secteur_activite}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Localisation géographique <strong style="color:red;">*</strong></label>
                                        <input type="text" name="localisation_geographique_entreprise" id="localisation_geographique_entreprise"
                                               class="form-control form-control-sm"
                                               value="{{@$infoentreprise->localisation_geographique_entreprise}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Repère d'accès <strong style="color:red;">*</strong></label>
                                        <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                               class="form-control form-control-sm"
                                               value="{{@$infoentreprise->repere_acces_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Adresse postal <strong style="color:red;">*</strong></label>
                                        <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                               class="form-control form-control-sm"
                                               value="{{@$infoentreprise->adresse_postal_entreprises}}" disabled="disabled">
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
                                                       value="{{@$infoentreprise->tel_entreprises}}" name="tel_entreprises" disabled="disabled">
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
                                                       value="{{@$infoentreprise->cellulaire_professionnel_entreprises}}" disabled="disabled">
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
                                                       value="{{@$infoentreprise->fax_entreprises}}" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade " id="navs-top-infoprojetetude" role="tabpanel">
                            <div class="col-md-12 col-10" align="center">
                                    <div class="mb-1">
                                        <label>Titre du projet <span
                                                style="color:red;">*</span>
                                        </label>
                                        <input type="text" name="titre_projet"
                                               required="required" id="titre_projet"
                                               class="form-control form-control-sm"
                                               @if(@$projet_etude->flag_soumis==true)
                                                   disabled
                                               @endif
                                               value ="@isset($projet_etude){{$projet_etude->titre_projet_etude}}@endisset"

                                               placeholder="ex : Perfectionnement ..">
                                    </div>
                                </div>
                            <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Contexte ou Problèmes constatés <span
                                                    style="color:red;">*</span></label>
                                            <textarea class="form-control" required="required"
                                                      @if(@$projet_etude->flag_soumis==true)
                                                          disabled
                                                      @endif
                                                      rows="3" id="exampleFormControlTextarea"
                                                      name="contexte_probleme" style="height: 121px;">@isset($projet_etude){{$projet_etude->contexte_probleme_projet_etude}}@endisset</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Objectif Général <span
                                                    style="color:red;">*</span> </label>
                                            <textarea required="required" class="form-control"
                                                      @if(@$projet_etude->flag_soumis==true)
                                                          disabled
                                                      @endif
                                                      rows="3" id="exampleFormControlTextarea"
                                                      name="objectif_general" style="height: 121px;">@isset($projet_etude){{$projet_etude->objectif_general_projet_etude}}@endisset</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Objectifs spécifiques <span
                                                    style="color:red;">*</span> </label>
                                            <textarea class="form-control" required="required"
                                                      @if(@$projet_etude->flag_soumis==true)
                                                          disabled
                                                      @endif
                                                      rows="3" id="exampleFormControlTextarea"
                                                      name="objectif_specifique" style="height: 121px;">@isset($projet_etude){{$projet_etude->objectif_specifique_projet_etud}}@endisset</textarea>

                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Résultats attendus <span
                                                    style="color:red;">*</span> </label>
                                            <textarea class="form-control"
                                                      @if(@$projet_etude->flag_soumis==true)
                                                          disabled
                                                      @endif
                                                      required="required" rows="3" id="exampleFormControlTextarea"
                                                      name="resultat_attendu" style="height: 121px;">@isset($projet_etude){{$projet_etude->resultat_attendu_projet_etude}}@endisset</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Champ de l’étude <span
                                                    style="color:red;">*</span></label>
                                            <textarea class="form-control"
                                                      @if(@$projet_etude->flag_soumis==true)
                                                          disabled
                                                      @endif
                                                      rows="3" id="exampleFormControlTextarea" name="champ_etude"
                                                      style="height: 121px;" required="required">@isset($projet_etude){{$projet_etude->champ_etude_projet_etude}}@endisset</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Cible <span style="color:red;">*</span>
                                            </label>
                                            <textarea class="form-control"
                                                      @if(@$projet_etude->flag_soumis==true)
                                                          disabled
                                                      @endif
                                                      rows="3" id="exampleFormControlTextarea" name="cible" style="height: 121px;"
                                                      required="required">@isset($projet_etude){{$projet_etude->cible_projet_etude}}@endisset</textarea>

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="navs-top-piecesprojetetude" role="tabpanel">

                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id="exampleData"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type de pièce</th>
                                    <th>Libelle de la pièce</th>
                                    <th>Action</th>
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
                                            @if($piece->code_pieces=='dossier_intention')
                                                Dossier d’intention
                                            @endif
                                            @if($piece->code_pieces=='lettre_engagement')
                                                Lettre d’engagement
                                            @endif
                                            @if($piece->code_pieces=='offre_technique')
                                                Offre technique
                                            @endif
                                            @if($piece->code_pieces=='offre_financiere')
                                                Offre financière
                                            @endif
                                        </td>
                                        <td>{{ $piece->libelle_pieces }}</td>
                                        <td align="center">
                                            {{--                                            @can($lien.'-edit')--}}
                                            @if($piece->code_pieces=='avant_projet_tdr')
                                                <a onclick="NewWindow('{{ asset("pieces_projet/avant_projet_tdr/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher"><img src='/assets/img/eye-solid.png'></a>
                                            @endif
                                            @if($piece->code_pieces=='courier_demande_fin')
                                                <a onclick="NewWindow('{{ asset("pieces_projet/courier_demande_fin/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher"><img src='/assets/img/eye-solid.png'></a>
                                            @endif
                                            @if($piece->code_pieces=='dossier_intention')
                                                <a onclick="NewWindow('{{ asset("pieces_projet/dossier_intention/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher"><img src='/assets/img/eye-solid.png'></a>
                                            @endif
                                            @if($piece->code_pieces=='lettre_engagement')
                                                <a onclick="NewWindow('{{ asset("pieces_projet/lettre_engagement/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher"><img src='/assets/img/eye-solid.png'></a>
                                            @endif
                                            @if($piece->code_pieces=='offre_technique')
                                                <a onclick="NewWindow('{{ asset("pieces_projet/offre_technique/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher"><img src='/assets/img/eye-solid.png'></a>
                                            @endif
                                            @if($piece->code_pieces=='offre_financiere')
                                                <a onclick="NewWindow('{{ asset("pieces_projet/offre_financiere/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher"><img src='/assets/img/eye-solid.png'></a>
                                            @endif

                                            @if(@$projet_etude->flag_soumis == false)
                                                <a href="{{ route($lien.'.deletefpe',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_piece_projet'=>\App\Helpers\Crypt::UrlCrypt($piece->id_pieces_projet_etude)]) }}"
                                                   class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cette pièce?")) return false;'
                                                   title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade show active" id="navs-top-traitement" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', ["id_projet_etude"=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <input type="hidden" name="id_combi_proc" value="{{\App\Helpers\Crypt::UrlCrypt($id_combi_proc) }}"/>
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>
                                            <?php if(count($parcoursexist)<1){?>
                                            <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                            <?php }else{?>
                                            <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                            <?php } ?>
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

        </div>
    </div>
    <!-- END: Content-->
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

@endsection