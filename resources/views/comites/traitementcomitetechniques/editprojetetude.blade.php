<?php
$idconnect = Auth::user()->id;
?>
@extends('layouts.backLayout.designadmin')


@section('content')
    @php($Module=' Comités')
    @php($titre='Liste des comites plénières')
    @php($soustitre='Tenue de comite plénière')
    @php($lien='traitementcomitetechniques')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
                {{ $titre }} / {{ $soustitre }}
            </h5>
            @if($errors->any())
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

            <div class="col-xl-12">
                <h6 class="text-muted"></h6>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link @if($idetape==1) active @endif"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-entreprise"
                                aria-controls="navs-top-entreprise"
                                aria-selected="true">
                                Détails de l'entreprise
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link @if($idetape==2) active @endif"
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
                                class="nav-link  @if($idetape==3) active   @endif"
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
                                class="nav-link  @if($idetape==4) active @endif"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-traitementinstructionprojetetude"
                                aria-controls="navs-top-traitementinstructionprojetetude"
                                aria-selected="false">
                                Traitement

                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade @if($idetape==1) show active @endif" id="navs-top-entreprise" role="tabpanel">
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
                                                       value="{{@@$projet_etude->entreprise->tel_entreprises}}" name="tel_entreprises" disabled="disabled">
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

                                <div class="col-12" align="right">
                                    <hr>
                                    <a class="btn btn-sm btn-outline-secondary waves-effect  me-sm-3 me-1" href="/{{$lien }}">Retour</a>
                                    <a  href="{{ route($lien.'.edit.projetetude',[\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade @if($idetape==2) show active @endif" id="navs-top-infoprojetetude" role="tabpanel">

                            <div class="row">

                                <div class="col-md-12 col-10">
                                    <div class="col-md-12 col-10">
                                        <div class="row">
                                            <div class="mb-1 col-md-12">
                                                <label>Titre du projet <span
                                                        style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="titre_projet"
                                                       required="required" id="titre_projet"
                                                       disabled
                                                       value ="@isset($projet_etude){{$projet_etude->titre_projet_etude}}@endisset"
                                                       class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-10">
                                        <div class="row">
                                            <div class="mb-1 col-md-6">
                                                <label>Financement sollicité <span
                                                        style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="montant_demande_projet"
                                                       required="required" id="montant_demande_projet"
                                                       disabled
                                                       value ="{{number_format(@$projet_etude->montant_demande_projet_etude, 0, ',', ' ')}}"

                                                       class="form-control form-control-sm number">
                                            </div>

                                            <div class="mb-1 col-md-6">
                                                <label>Domaine du projet <span
                                                        style="color:red;">*</span>
                                                </label>
                                                <select name="id_domaine_projet" class="select2 form-select-sm input-group" data-allow-clear="true"  @if(@$projet_etude->flag_soumis==true)
                                                    disabled
                                                    @endif>
                                                    @foreach($domaine_projets as $domaine_projet)
                                                        <option value="{{$domaine_projet->id_domaine_formation}}"
                                                                @if($projet_etude->DomaineProjetEtude->id_domaine_projet==$domaine_projet->id_domaine_projet)
                                                                    selected
                                                            @endif
                                                        >{{$domaine_projet->libelle_domaine_formation}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Contexte ou Problèmes constatés <span
                                                        style="color:red;">*</span></label>
                                                <input class="form-control" type="text" id="contexte_probleme_val" name="contexte_probleme"/>
                                                <div id="contexte_probleme" class="rounded-1"  readonly="true">{!!@$projet_etude->contexte_probleme_projet_etude !!}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Objectif Général <span
                                                        style="color:red;">*</span> </label>
                                                <input class="form-control" type="text" id="objectif_general_val" name="objectif_general"/>
                                                <div id="objectif_general" class="rounded-1">{!!@$projet_etude->objectif_general_projet_etude!!}</div>

                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Objectifs spécifiques <span
                                                        style="color:red;">*</span> </label>
                                                <input class="form-control" type="text" id="objectif_specifique_val" name="objectif_specifique"/>
                                                <div id="objectif_specifique" class="rounded-1">{!!@$projet_etude->objectif_specifique_projet_etud!!}</div>

                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Résultats attendus <span
                                                        style="color:red;">*</span> </label>
                                                <input class="form-control" type="text" id="resultat_attendu_val" name="resultat_attendu"/>
                                                <div id="resultat_attendu" class="rounded-1">{!!@$projet_etude->resultat_attendu_projet_etude!!}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Champ de l’étude <span
                                                        style="color:red;">*</span></label>
                                                <input class="form-control" type="text" id="champ_etude_val" name="champ_etude"/>
                                                <div id="champ_etude" class="rounded-1">{!!@$projet_etude->champ_etude_projet_etude!!}</div>

                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Cible <span style="color:red;">*</span>
                                                </label>
                                                <input class="form-control" type="text" id="cible_val" name="cible"/>
                                                <div id="cible" class="rounded-1">{!!@$projet_etude->cible_projet_etude!!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" align="right">
                                <hr>
                                <a  href="{{ route($lien.'.edit.projetetude',[\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                <a  href="{{ route($lien.'.edit.projetetude',[\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                            </div>

                        </div>
                        <div class="tab-pane fade @if($idetape==3) show active @endif" id="navs-top-piecesprojetetude" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type de pièce</th>
                                    <th>Commentaire</th>
                                    <th>&nbsp;</th>
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
                                        @if(@$projet_etude->flag_recevablite_projet_etude==true)
                                            <td class="my-auto">
                                                @isset($piece->commentaire_piece)
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <i class="m-0">{{@$piece->commentaire_piece}}</i>
                                                        </div>
                                                    </div>
                                                @endisset
                                            </td>
                                        @endif
                                        <td align="center">
                                            @if($piece->code_pieces=='avant_projet_tdr')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/avant_projet_tdr/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du fichier</a>
                                            @endif
                                            @if($piece->code_pieces=='courier_demande_fin')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/courier_demande_fin/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du fichier</a>
                                            @endif
                                            @if($piece->code_pieces=='offre_technique')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/offre_technique/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du fichier</a>
                                            @endif
                                            @if($piece->code_pieces=='offre_financiere')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/offre_financiere/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du fichier</a>
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
                            <div class="col-12" align="right">
                                <hr>
                                <a  href="{{ route($lien.'.edit.projetetude',[\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                <a  href="{{ route($lien.'.edit.projetetude',[\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                            </div>
                        </div>
                        <div class="tab-pane fade @if($idetape==4) show active @endif" id="navs-top-traitementinstructionprojetetude" role="tabpanel">
                            @if(@$comite->categorieComite->type_code_categorie_comite=='CT')
                                @if( $projet_etude->flag_soumis_ct_pleniere == true and $projet_etude->flag_valider_ct_pleniere_projet_etude!=true and $projet_etude->id_charge_etude == $idconnect)
                                    <div class="col-12" align="right">
                                    <div class="row">
                                        <div class="col-8">
                                        </div>
                                        <div class="col-4" align="right">

                                            <form method="POST" class="form mb-2" action="{{ route($lien.'.cahierupdateprojetetude', [\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}">
                                                @csrf
                                                @method('put')
                                                <button type="submit" onclick='javascript:if (!confirm("Voulez-vous effectuer ce traitement ? Cette action est irréversible")) return false;' name="action" value="Traiter_valider_projet"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Valider le projet
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @elseif(@$comite->categorieComite->type_code_categorie_comite=='CC')
                                @if($projet_etude->flag_valider_cc_projet_etude != true)
                                    <div class="col-12" align="right">
                                    <div class="row">


                                        <div class="col-8">
                                        </div>
                                        <div class="col-4" align="right">

                                            <form method="POST" class="form mb-2" action="{{ route($lien.'.cahierupdateprojetetude', [\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}">
                                                @csrf
                                                @method('put')
                                                <button type="submit" name="action" value="Traiter_valider_projet"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Valider le projet
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif

                            <form  method="POST" id="formTraitement" class="form" action="{{ route($lien.'.cahierupdateprojetetude', [\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($idetape)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
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
                                                               @if($projet_etude->flag_soumis_ct_pleniere == true and $projet_etude->flag_valider_ct_pleniere_projet_etude!=true and $projet_etude->id_charge_etude != $idconnect)
                                                                   disabled
                                                               @endif

                                                                       value ="@isset($projet_etude){{$projet_etude->titre_projet_instruction}}@endisset"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-10">
                                                <div class="row">
                                                    <div class="mb-1 col-md-6">
                                                        <label>Financement sollicité <span
                                                                style="color:red;">*</span>
                                                        </label>
                                                        <input type="text" name="montant_demande_projet"
                                                               required="required" id="montant_demande_projet"
                                                               disabled
                                                               value ="{{number_format(@$projet_etude->montant_demande_projet_etude, 0, ',', ' ')}}"
                                                               class="form-control form-control-sm number">
                                                    </div>

                                                    <div class="mb-1 col-md-6">
                                                        <label>Domaine du projet <span
                                                                style="color:red;">*</span>
                                                        </label>
                                                        <select name="id_domaine_projet_instruction" class="select2 form-select-sm input-group" data-allow-clear="true"
                                                                @if($projet_etude->flag_soumis_ct_pleniere == true and $projet_etude->flag_valider_ct_pleniere_projet_etude!=true and $projet_etude->id_charge_etude != $idconnect)
                                                                    disabled
                                                            @endif
                                                        >

                                                            @foreach($domaine_projets as $domaine_projet)
                                                                <option value="{{$domaine_projet->id_domaine_formation}}"
                                                                    @if($projet_etude->id_domaine_projet_instruction==$domaine_projet->id_domaine_projet)
                                                                         selected
                                                                    @endif
                                                                >{{$domaine_projet->libelle_domaine_formation}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="contexte_probleme_instruction">Contexte ou Problèmes constatés <span style="color:red;">*</span></label>
                                            <input class="form-control" type="text" id="contexte_probleme_instruction_val" name="contexte_probleme_instruction"/>
                                            <div id="contexte_probleme_instruction" class="rounded-1">{!!@$projet_etude->contexte_probleme_instruction !!}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="objectif_general_instruction">Objectif Général <span style="color:red;">*</span></label>
                                            <input class="form-control" type="text" id="objectif_general_instruction_val" name="objectif_general_instruction"/>
                                            <div id="objectif_general_instruction" class="rounded-1">{!!@$projet_etude->objectif_general_instruction !!}</div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="objectif_specifique_instruction">Objectifs spécifiques <span style="color:red;">*</span> </label>
                                            <input class="form-control" type="text" id="objectif_specifique_instruction_val" name="objectif_specifique_instruction"/>
                                            <div id="objectif_specifique_instruction" class="rounded-1">{!!@$projet_etude->objectif_specifique_instruction !!}</div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="resultat_attendu_instruction">Résultats attendus <span style="color:red;">*</span>
                                            </label>
                                            <input class="form-control" type="text" id="resultat_attendu_instruction_val" name="resultat_attendu_instruction"/>
                                            <div id="resultat_attendu_instruction" class="rounded-1">{!!@$projet_etude->resultat_attendus_instruction !!}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="champ_etude_instruction">Champ de l’étude <span style="color:red;">*</span></label>
                                            <input class="form-control" type="text" id="champ_etude_instruction_val" name="champ_etude_instruction"/>
                                            <div id="champ_etude_instruction" class="rounded-1">{!!@$projet_etude->champ_etude_instruction !!}</div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="cible_instruction">Cible <span style="color:red;">*</span>
                                            </label>
                                            <input class="form-control" type="text" id="cible_instruction_val" name="cible_instruction"/>
                                            <div id="cible_instruction" class="rounded-1">{!!@$projet_etude->cible_instruction !!}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="methodologie_instruction">Méthodologie <span style="color:red;">*</span></label>
                                            <input class="form-control" type="text" id="methodologie_instruction_val" name="methodologie_instruction"/>
                                            <div id="methodologie_instruction" class="rounded-1">{!!@$projet_etude->methodologie_instruction !!}</div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mt-2">
                                            <div class="mb-1">
                                                <label for="montant_projet_instruction">Financement à accorder <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="montant_projet_instruction" id="montant_projet_instruction" class="number form-control form-control-sm number"
                                                       @if($projet_etude->flag_soumis_ct_pleniere == true and $projet_etude->flag_valider_ct_pleniere_projet_etude!=true and $projet_etude->id_charge_etude != $idconnect)
                                                           disabled
                                                       @endif

                                                       value ="{{number_format(@$projet_etude->montant_projet_instruction, 0, ',', ' ')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label" for="fichier_instruction">Pièce jointe <span style="color:red;">*</span></label>
                                            @if($projet_etude->flag_soumis_ct_pleniere == true and $projet_etude->flag_valider_ct_pleniere_projet_etude!=true and $projet_etude->id_charge_etude != $idconnect)
                                                @if($projet_etude->piece_jointe_instruction)
                                                    <div><span class="badge bg-secondary mt-1"><a target="_blank"
                                                                                             onclick="NewWindow('{{ asset("pieces_projet/fichier_instruction/". $projet_etude->piece_jointe_instruction)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span></div>

                                                @endif
                                            @else
                                                <input type="file" name="fichier_instruction" class="form-control" placeholder="" >
                                                @if($projet_etude->piece_jointe_instruction)
                                                    <div><span class="badge bg-secondary mt-1"><a target="_blank"
                                                                                             onclick="NewWindow('{{ asset("pieces_projet/fichier_instruction/". $projet_etude->piece_jointe_instruction)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span></div>

                                                @endif
                                            @endif

                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, WORD, JPG, JPEG, PNG <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-12" align="right">
                                        <hr>
                                        @if(@$comite->categorieComite->type_code_categorie_comite=='CT')
                                            @if( $projet_etude->flag_soumis_ct_pleniere == true and $projet_etude->flag_valider_ct_pleniere_projet_etude!=true and $projet_etude->id_charge_etude == $idconnect)
                                            <button type="submit" name="action" value="Modifier"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Modifier
                                            </button>
                                            @endif
                                        @elseif(@$comite->categorieComite->type_code_categorie_comite=='CC')
                                                @if($projet_etude->flag_valider_cc_projet_etude != true)
                                            <button type="submit" name="action" value="Modifier"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Modifier
                                            </button>
                                            @endif
                                        @endif
                                        <a  href="{{ route($lien.'.edit.projetetude',[\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-1" align="right">Précédent</a>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
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
@endsection
@section('js_perso')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/additional-methods.js')}}"></script>
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

        //Submit form
        formTraitement.onsubmit = function(){
            $("#contexte_probleme_instruction_val").val(contexte_probleme_instruction.root.innerHTML);
            $("#objectif_general_instruction_val").val(objectif_general_instruction.root.innerHTML);
            $("#objectif_specifique_instruction_val").val(objectif_specifique_instruction.root.innerHTML);
            $("#resultat_attendu_instruction_val").val(resultat_attendu_instruction.root.innerHTML);
            $("#champ_etude_instruction_val").val(champ_etude_instruction.root.innerHTML);
            $("#cible_instruction_val").val(cible_instruction.root.innerHTML);
            $("#methodologie_instruction_val").val(methodologie_instruction.root.innerHTML);
        }


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
        //Hide All fields
        $("#contexte_probleme_val").hide();
        $("#objectif_general_val").hide();
        $("#objectif_specifique_val").hide();
        $("#resultat_attendu_val").hide();
        $("#champ_etude_val").hide();
        $("#cible_val").hide();

        @if($projet_etude->flag_soumis_ct_pleniere == true and $projet_etude->flag_valider_ct_pleniere_projet_etude!=true and $projet_etude->id_charge_etude != $idconnect)
            contexte_probleme_instruction.disable();
            objectif_general_instruction.disable();
            objectif_specifique_instruction.disable();
            resultat_attendu_instruction.disable();
            champ_etude_instruction.disable();
            cible_instruction.disable();
            methodologie_instruction.disable();
        @endif

        //Desactivate if is submit
        contexte_probleme.disable();
        objectif_general.disable();
        objectif_specifique.disable();
        resultat_attendu.disable();
        champ_etude.disable();
        cible.disable();




    </script>

@endsection
