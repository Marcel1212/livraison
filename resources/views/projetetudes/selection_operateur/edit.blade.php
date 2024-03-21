@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet d\'etudes')
    @php($titre = 'Information du projet d\'etude')
    @php($soustitre = 'Ajouter un projet etude ')
    @php($lien = 'selectionoperateurprojetetude')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light">
                    <a href="{{route('dashboard')}}"> <i class="ti ti-home mb-2"></i>  Accueil </a> /
                    <a href="{{route($lien.'.index')}}"> {{$Module}}</a> /  {{$titre}}</span>
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
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link @if($idetape=="1") active @endif"
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
                                            class="nav-link @if($idetape=="2") active @endif"
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
                                            class="nav-link @if($idetape=="3") active @endif"
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
                                            class="nav-link @if($idetape=="4") active @endif"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-top-selectionoperateurprojetetude"
                                            aria-controls="navs-top-selectionoperateurprojetetude"
                                            aria-selected="false">
                                            Sélection opérateur
                                        </button>
                                    </li>
                                </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade @if($idetape=="1")show active @endif" id="navs-top-entreprise" role="tabpanel">
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
                            <div class="col-12" align="right">
                                <hr>
                                <a class="btn btn-sm btn-outline-secondary waves-effect  me-sm-3 me-1" href="/{{$lien }}">Retour</a>
                                <a  href="{{ route($lien.'.edit',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                            </div>
                        </div>
                        <div class="tab-pane fade @if($idetape=="2")show active @endif" id="navs-top-infoprojetetude" role="tabpanel">
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
                        <div class="tab-pane fade @if($idetape=="3") show active @endif" id="navs-top-piecesprojetetude" role="tabpanel">
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
                            <div class="col-12" align="right">
                                <hr>
                                <a  href="{{ route($lien.'.edit',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                <a  href="{{ route($lien.'.edit',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                            </div>
                        </div>
                        <div class="tab-pane fade @if($idetape=="4") show active @endif" id="navs-top-selectionoperateurprojetetude" role="tabpanel">
                            @if(@$projet_etude->flag_selection_operateur_valider_par_processus==true && @$projet_etude->flag_validation_selection_operateur==false )
                                <form action="{{route($lien.'.mark',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)])}}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="row mb-5">
                                        <div class="col-md-11">
                                            <label class="form-label">Opérateurs<span style="color:red;">*</span></label>
                                            <select class="select2 form-select-sm input-group" name="operateur">
                                                    <?=$operateur_valider?>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mt-4" align="right">
                                            <button style="line-height:1.25rem" type="submit" value="Enregistrer_selection" name="action" class="btn btn-primary btn-sm waves-effect waves-light">
                                                Ajouter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                            @if((@$projet_etude->operateurs->count()>=1 && @$projet_etude->operateurs->count()<=5) && @$projet_etude->flag_soumis_selection_operateur == false)
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <div class="alert-body text-center">
                                        Info : Il vous faut sélectionner au moins  un opérateur et au maximum 5 operateurs avant de soumettre la sélection
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <form action="{{route($lien.'.update',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)])}}" method="post">
                                        @method('put')
                                        @csrf
                                        <div class="row mb-5">
                                            <div class="col-md-9">
                                                <label class="form-label">Opérateurs<span style="color:red;">*</span></label>
                                                <select class="select2 form-select-sm input-group" name="operateur">
                                                    <?=$operateur_selected?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-4" align="right">
                                                <button style="line-height:1.25rem" type="button" id="ajouterCabinetEtranger"
                                                        class="btn btn-sm btn-outline-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#ajouterCabinetEtrangerModal">
                                                    Nouveau Cabinet etranger
                                                </button>
                                                <button style="line-height:1.25rem"  type="submit" value="Enregistrer_selection" name="action" class="btn btn-primary btn-sm waves-effect waves-light">
                                                    Ajouter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                <hr/>
                            @endif

                            <table class="table table-bordered table-striped table-hover table-sm"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Opérateur </th>
                                    @if(@$projet_etude->flag_selection_operateur_valider_par_processus==true && isset($projet_etude->id_operateur_selection))
                                        <th>Statut </th>
                                    @endif
                                    @if(@$projet_etude->flag_soumis_selection_operateur == false)
                                    <th>Action </th>
                                        @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @isset($projet_etude->operateurs)
                                        @foreach ($projet_etude->operateurs as $key => $operateur)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $operateur->ncc_entreprises }} / {{ $operateur->raison_social_entreprises }}</td>
                                                @if(@$projet_etude->flag_selection_operateur_valider_par_processus==true && isset($projet_etude->id_operateur_selection))
                                                   @if($projet_etude->id_operateur_selection==$operateur->id_entreprises)
                                                        <td>
                                                            <i class="menu-icon tf-icons ti ti-circle-check text-success"></i>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <i class="menu-icon tf-icons ti ti-x text-danger"></i>
                                                        </td>
                                                    @endif
                                                @endif
                                                @if(@$projet_etude->flag_soumis_selection_operateur == false)

                                                <td class="text-center">
                                                    <a href="{{ route($lien.'.deleteoperateurpe',[\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($operateur->id_entreprises)]) }}"
                                                       class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet opérateur?")) return false;'
                                                       title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>

                                                </td>
                                                    @endif
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                                @if((@$projet_etude->operateurs->count()>=1 && @$projet_etude->operateurs->count()<=5)  && @$projet_etude->flag_soumis_selection_operateur == false)
                                    <hr>
                                    <form method="POST" class="form mt-3"  action="{{ route($lien.'.update',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)]) }}">
                                        @method('put')
                                        @csrf
                                        <div  class="text-end">
                                                <button onclick='javascript:if (!confirm("Voulez-vous soumettre cette sélection ? Cette action est irréversible.")) return false;'  type="submit" name="action" value="Enregistrer_soumettre_selection" class="btn btn-sm btn-success me-sm-3 me-1 "  align="right">Soumettre la sélection</button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                    Retour</a>

                                        </div>
                                    </form>
                                @endif

                                @if(@$projet_etude->flag_selection_operateur_valider_par_processus==true && isset($projet_etude->id_operateur_selection))
                                    <hr>

                                    <form action="{{route($lien.'.mark',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)])}}" method="post">
                                        @method('put')
                                        @csrf
                                        <div class="row mb-5">
                                            <div class="col-md-12" align="right">
                                                @if(@$projet_etude->flag_validation_selection_operateur==false)
                                                    <button value="Valider_selection" name="action"  onclick='javascript:if (!confirm("Voulez-vous soumettre cette sélection ? Cette action est irréversible.")) return false;'  type="submit" class="btn btn-sm btn-success me-sm-3 me-1 "  align="right">
                                                        Soumettre la sélection finale
                                                    </button>
                                                @endif
                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>
                                @endif


                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ajouterCabinetEtrangerModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-simple modal-edit-user">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="text-center mb-4">
                                <h3 class="mb-2">Saisie les informations du cabinet étranger</h3>
                                <p class="text-muted"></p>
                            </div>
                            <div class="modal-body">
                                <form class="mt-3" method="post" action="{{ route('projetetude.ajoutcabinetetrangere') }}">
                                    @csrf
                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">

                                        <input
                                            class="form-control form-control-sm"
                                            type="hidden"
                                            id="id_projet_etude"
                                            value="{{@$projet_etude->id_projet_etude}}"
                                            name="id_projet_etude"
                                            placeholder="id_projet_etude"
                                            aria-describedby="email3"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="raison_social_entreprises">Raison sociale
                                                <strong style="color:red;">*</strong></label>
                                            <input type="text" id="raison_social_entreprises"
                                                   name="raison_social_entreprises"
                                                   class="form-control form-control-sm"
                                                   placeholder="Raison sociale"
                                                   required="required"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="id_secteur_activite">Secteur d'activité
                                                <strong style="color:red;">*</strong></label>
                                            <select name="id_secteur_activite_entreprise"
                                                    readonly="readonly" class="select2 form-select-sm input-group" data-allow-clear="true" >
                                                <?= $secteuractivite_projet; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label" for="email">Email <strong style="color:red;">*</strong></label>
                                            <div class="input-group input-group-merge">
                                                <input
                                                    class="form-control form-control-sm"
                                                    type="email"
                                                    id="email"
                                                    name="email_entreprises"
                                                    placeholder="Email"
                                                    aria-label=""
                                                    aria-describedby="email3" required="required"/>
                                                <span class="input-group-text" id="email"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label"
                                                   for="billings-country">Indicatif <strong style="color:red;">*</strong> </label>
                                            <select class="select2 form-select-sm input-group" readonly=""
                                                    name="indicatif_entreprises" required="required">
                                                <?php echo "+" .$paysc; ?>

                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Téléphone <strong
                                                    style="color:red;">*</strong></label>
                                            <input type="number" min="0"
                                                   name="tel_entreprises"
                                                   class="form-control form-control-sm"
                                                   placeholder="Téléphone"
                                                   required="required"/>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label>Localisation géographique <strong style="color:red;">*</strong></label>
                                                <input type="text" name="localisation_geographique_entreprise"
                                                       id="localisation_geographique_entreprise"
                                                       class="form-control form-control-sm"
                                                       placeholder="Localisation géographique"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-12 text-center mt-5">

                                            <button type="submit" class="btn btn-primary me-sm-3 me-1 btn-submit" id="create_new">Enregistrer</button>
                                            <button
                                                type="reset"
                                                class="btn btn-label-secondary"
                                                data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Annuler
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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


