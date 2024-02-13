<?php
    $idconnect = Auth::user()->id;
?>
@extends('layouts.backLayout.designadmin')


@section('content')
    @php($Module = 'Projet d\'étude')
    @php($titre = 'Liste des comités gestions')
    @php($soustitre = 'Tenue de comité de gestion')
    @php($lien = 'comitegestionprojetetude')

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
                                class="nav-link @if($id_etape==1) active @endif"
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
                                class="nav-link @if($id_etape==2) active @endif"
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
                                class="nav-link  @if($id_etape==3) active   @endif"
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
                                    class="nav-link  @if($id_etape==4) active @endif"
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
                        <div class="tab-pane fade @if($id_etape==1) show active @endif" id="navs-top-entreprise" role="tabpanel">
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
                                    <a  href="{{ route($lien.'.editer',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade @if($id_etape==2) show active @endif" id="navs-top-infoprojetetude" role="tabpanel">
                            <div class="col-md-12 col-10" align="center">
                                <div class="mb-1">
                                    <label>Titre du projet <span
                                            style="color:red;">*</span>
                                    </label>
                                    <input type="text" name="titre_projet"
                                           required="required" id="titre_projet"
                                           class="form-control form-control-sm"
                                           disabled
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
                                                  disabled
                                                  rows="4" id="exampleFormControlTextarea"
                                                  name="contexte_probleme" >@isset($projet_etude){{$projet_etude->contexte_probleme_projet_etude}}@endisset</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Objectif Général <span
                                                style="color:red;">*</span> </label>
                                        <textarea required="required" class="form-control"
                                                  disabled
                                                  rows="4" id="exampleFormControlTextarea"
                                                  name="objectif_general" >@isset($projet_etude){{$projet_etude->objectif_general_projet_etude}}@endisset</textarea>

                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Objectifs spécifiques <span
                                                style="color:red;">*</span> </label>
                                        <textarea class="form-control" required="required"
                                                  disabled
                                                  rows="4" id="exampleFormControlTextarea"
                                                  name="objectif_specifique" >@isset($projet_etude){{$projet_etude->objectif_specifique_projet_etud}}@endisset</textarea>

                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Résultats attendus <span
                                                style="color:red;">*</span> </label>
                                        <textarea class="form-control"
                                                  required="required" rows="4" id="exampleFormControlTextarea" disabled
                                                  name="resultat_attendu" >@isset($projet_etude){{$projet_etude->resultat_attendu_projet_etude}}@endisset</textarea>

                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Champ de l’étude <span
                                                style="color:red;">*</span></label>
                                        <textarea class="form-control"
                                                  disabled
                                                  rows="4" id="exampleFormControlTextarea" name="champ_etude"
                                                  required="required">@isset($projet_etude){{$projet_etude->champ_etude_projet_etude}}@endisset</textarea>

                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Cible <span style="color:red;">*</span>
                                        </label>
                                        <textarea class="form-control"
                                                  disabled
                                                  rows="4" id="exampleFormControlTextarea" name="cible"
                                                  required="required">@isset($projet_etude){{$projet_etude->cible_projet_etude}}@endisset</textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="col-12" align="right">
                                <hr>
                                <a  href="{{ route($lien.'.editer',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                <a  href="{{ route($lien.'.editer',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                            </div>
                        </div>
                        <div class="tab-pane fade @if($id_etape==3) show active @endif" id="navs-top-piecesprojetetude" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type de pièce</th>
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
                                        <td align="center">
                                            @if($piece->code_pieces=='avant_projet_tdr')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/avant_projet_tdr/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du fichier</a>
                                            @endif
                                            @if($piece->code_pieces=='courier_demande_fin')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/courier_demande_fin/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du fichier</a>
                                            @endif
                                            @if($piece->code_pieces=='dossier_intention')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/dossier_intention/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du fichier</a>
                                            @endif
                                            @if($piece->code_pieces=='lettre_engagement')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/lettre_engagement/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
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

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="col-12" align="right">
                                <hr>
                                <a  href="{{ route($lien.'.editer',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                <a  href="{{ route($lien.'.editer',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                            </div>
                        </div>

                        <div class="tab-pane fade @if($id_etape==4) show active @endif" id="navs-top-traitementinstructionprojetetude" role="tabpanel">

                            <?php  if( $projet_etude->flag_valider_par_processus == true && $projet_etude->flag_valider_comite_gestion_projet_etude == true){?>
                                <div align="right">
                                    <form method="POST" class="form" action="{{ route($lien.'.agrementupdate', [\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($id_etape)]) }}">
                                        @csrf
                                        @method('put')
                                        <button type="submit" name="action" value="Traiter_valider_projet"
                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Valider le comité pour ce projet d'étude
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>


                            <form  method="POST" class="form" action="{{ route($lien.'.agrementupdate', [\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($idcomite),\App\Helpers\Crypt::UrlCrypt($id_etape)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row mt-2">
                                    <div  class="row">
                                        <div class="col-md-6 col-12 mt-2">
                                            <div class="mb-1">
                                                <label>Titre du projet <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="titre_projet_instruction"
                                                       required="required" id="titre_projet_instruction" class="form-control form-control-sm" placeholder="" value="{{@$projet_etude->titre_projet_instruction}}">
                                            </div>
                                        </div>
                                        <div class="mb-1 col-md-6">
                                            <label>Secteur d'activité du projet <span
                                                    style="color:red;">*</span>
                                            </label>
                                            <select name="id_secteur_activite" class="select2 form-select-sm input-group" data-allow-clear="true">
                                                <?= $secteuractivite_projet; ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="contexte_probleme_instruction">Contexte ou Problèmes constatés <span style="color:red;">*</span></label>
                                            <textarea class="form-control" required="required" rows="4" id="contexte_probleme_instruction" name="contexte_probleme_instruction">{{@$projet_etude->contexte_probleme_instruction}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="objectif_general_instruction">Objectif Général <span style="color:red;">*</span>
                                            </label>
                                            <textarea required="required" class="form-control" rows="4" id="objectif_general_instruction" name="objectif_general_instruction" >{{@$projet_etude->objectif_general_instruction}}</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="objectif_specifique_instruction">Objectifs spécifiques <span style="color:red;">*</span> </label>
                                            <textarea class="form-control" required="required" rows="4" id="objectif_specifique_instruction" name="objectif_specifique_instruction" >{{@$projet_etude->objectif_specifique_instruction}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="resultat_attendu_instruction">Résultats attendus <span style="color:red;">*</span>
                                            </label>
                                            <textarea class="form-control" required="required" rows="4" id="resultat_attendu_instruction" name="resultat_attendu_instruction" >{{@$projet_etude->resultat_attendus_instruction}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="champ_etude_instruction">Champ de l’étude <span style="color:red;">*</span></label>
                                            <textarea class="form-control" rows="4" id="champ_etude_instruction" name="champ_etude_instruction"  required="required">{{@$projet_etude->champ_etude_instruction}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="cible_instruction">Cible <span style="color:red;">*</span>
                                            </label>
                                            <textarea class="form-control" rows="4" id="cible_instruction" name="cible_instruction"  required="required">{{@$projet_etude->cible_instruction}}</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="methodologie_instruction">Methodologie <span style="color:red;">*</span>
                                            </label>
                                            <textarea class="form-control" rows="7" id="methodologie_instruction" name="methodologie_instruction"  required="required">{{@$projet_etude->methodologie_instruction}}</textarea>

                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="mb-1">
                                                    <label for="montant_projet_instruction">Montant du projet demandé <span style="color:red;">*</span>
                                                    </label>
                                                    <input type="number" disabled name="montant_projet_instruction" required="required" id="montant_projet_instruction" class="form-control form-control-sm" placeholder="" value="{{@$projet_etude->montant_projet_instruction}}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-1 mt-3">
                                                    <label for="montant_projet_instruction">Montant à accorder<span style="color:red;">*</span>
                                                    </label>
                                                    <input type="number" name="montant_projet" required="required" id="montant_projet" class="form-control form-control-sm" placeholder="" value="{{@$projet_etude->montant_projet}}">
                                                </div>
                                            </div>
                                        </div>



                                            </div>

                                    <div class="col-md-4 mt-2">
                                        <div class="row">

                                        <div class="col-md-12">

                                        <label class="form-label" for="fichier_instruction">Pièce jointe <span style="color:red;">*</span></label>
                                        <input type="file" name="fichier_instruction" class="form-control" placeholder="">
                                        @if($projet_etude->piece_jointe_instruction)
                                            <span class="badge bg-secondary mt-1"><a target="_blank"
                                                                                onclick="NewWindow('{{ asset("pieces_projet/fichier_instruction/". $projet_etude->piece_jointe_instruction)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                        @endif
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, WORD, JPG, JPEG, PNG <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>


                                        </div>
                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <button type="submit" name="action" value="Modifier"
                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Valider
                                        </button>
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
