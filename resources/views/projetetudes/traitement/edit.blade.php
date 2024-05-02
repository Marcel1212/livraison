@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet d\'étude')
    @php($titre = 'Liste des projets d\'études')
    @php($soustitre = 'Instruction')
    @php($lien = 'traitementprojetetude')

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
                <div align="right">
                    <button type="button"
                            class="btn rounded-pill btn-outline-success waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#modalToggle">
                        Voir le parcours d'affectation
                    </button>
                </div>
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
                                aria-selected="false">
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
                        @if(@$projet_etude->flag_recevablite_projet_etude==true)
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link  @if($id_etape==4) active @endif"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-traitementinstructionprojetetude"
                                    aria-controls="navs-top-traitementinstructionprojetetude"
                                    aria-selected="false">
                                    Instruction du dossier

                                </button>
                            </li>
                        @endif
                        @if(@$projet_etude->flag_recevablite_projet_etude!=true && $id_etape==5)
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link active"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-traitementprojetetude"
                                    aria-controls="navs-top-traitementprojetetude"
                                    aria-selected="false">
                                    Recevabilité
                                </button>
                            </li>
                        @endif



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
                                <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>
                        <div class="tab-pane fade @if($id_etape==2) show active @endif" id="navs-top-infoprojetetude" role="tabpanel">
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
                                                       value ="{{@$projet_etude->titre_projet_etude}}"
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
                                                                @if($projet_etude->flag_enregistrer==true)
                                                                    @if($projet_etude->DomaineProjetEtude->id_domaine_projet==$domaine_projet->id_domaine_projet)
                                                                        selected
                                                                     @endif
                                                                  @endif
                                                        >{{$domaine_projet->libelle_domaine_formation}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-10">
                                        <div class="row">
                                            <div class="mb-1 col-md-6">
                                                <label>Lieu de réalisation <span
                                                        style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="lieu_realisation_projet"
                                                       id="lieu_realisation_projet" disabled
                                                       value="{{@$projet_etude->lieu_realisation_projet}}"
                                                       class="form-control form-control-sm ">
                                            </div>

                                            <div class="mb-1 col-md-6">
                                                <label>Date prévisionnelle de démarrage
                                                </label>
                                                <input type="date" name="date_previsionnelle_demarrage_projet"
                                                       id="date_previsionnelle_demarrage_projet" disabled
                                                       value="{{@$projet_etude->date_previsionnelle_demarrage_projet}}"
                                                       class="form-control form-control-sm ">
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
                                <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                            </div>
                        </div>
                        <div class="tab-pane fade @if($id_etape==3) show active @endif" id="navs-top-piecesprojetetude" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type de pièce</th>
                                    @if(@$projet_etude->flag_recevablite_projet_etude==true)
                                        <th>
                                            Commentaire
                                        </th>
                                    @endif
                                    <th>Aperçu</th>

                                    @if(@$projet_etude->flag_recevablite_projet_etude==true)
                                        <th>
                                            Action
                                        </th>
                                    @endif
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
                                        <td>
                                            @if($piece->code_pieces=='avant_projet_tdr')
                                                <a href="#"  onclick="NewWindow('{{ asset("pieces_projet/avant_projet_tdr/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='courier_demande_fin')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/courier_demande_fin/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='dossier_intention')
                                                <a href="#"  onclick="NewWindow('{{ asset("pieces_projet/dossier_intention/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='lettre_engagement')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/lettre_engagement/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='offre_technique')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/offre_technique/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='offre_financiere')
                                                <a href="#"  onclick="NewWindow('{{ asset("pieces_projet/offre_financiere/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif

                                                @if($piece->code_pieces=='autres_piece')
                                                    <a href="#"  onclick="NewWindow('{{ asset("pieces_projet/autres_piece/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                       title="Afficher">Aperçu du ficher</a>
                                                @endif
                                        </td>
                                        @if(@$projet_etude->flag_recevablite_projet_etude==true)
                                            <td>
                                                <a href="javascript:void(0);" data-id="{{@$piece->id_pieces_projet_etude}}" data-bs-toggle="modal" data-bs-target="#modal_add_commentaire"
                                                   class="add_commentaire"
                                                   title="Modifier"><img
                                                        src='/assets/img/editing.png'></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="col-12" align="right">
                                <hr>
                                <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                @if(@$projet_etude->flag_recevablite_projet_etude!=true)
                                    <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                    @else
                                    <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                @endif

</div>
</div>

<div class="tab-pane fade @if(@$projet_etude->flag_recevablite_projet_etude==true  && $id_etape==4) show active @endif" id="navs-top-traitementinstructionprojetetude" role="tabpanel">
<form  method="POST" id="formSoumettreCT" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)) }}" enctype="multipart/form-data">
   @csrf
   @method('put')
   <div class="row">
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
                                  @if($projet_etude->flag_enregistrer==true)
                                      value ="@isset($projet_etude){{$projet_etude->titre_projet_instruction}}@endisset"
                                  @else
                                      value ="@isset($projet_etude){{$projet_etude->titre_projet_etude}}@endisset"
                                  @endif

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
                           <select name="id_domaine_projet_instruction" class="select2 form-select-sm input-group" data-allow-clear="true">
                              @foreach($domaine_projets as $domaine_projet)
                                   <option value="{{$domaine_projet->id_domaine_formation}}"
                                           @if($projet_etude->flag_enregistrer==true)
                                                @if($projet_etude->id_domaine_projet_instruction==$domaine_projet->id_domaine_formation)
                                                    selected
                                                @endif
                                            @else
                                                @if($projet_etude->DomaineProjetEtude->id_domaine_projet==$domaine_projet->id_domaine_formation)
                                                    selected
                                                @endif
                                          @endif
                                   >{{$domaine_projet->libelle_domaine_formation}}</option>
                              @endforeach
                           </select>
                       </div>
                   </div>

               </div>
               <div class="col-md-12 col-10">
                   <div class="row">
                       <div class="mb-1 col-md-6">
                           <label>Lieu de réalisation <span
                                   style="color:red;">*</span>
                           </label>
                           <input type="text" name="lieu_realisation_projet_instruction"
                                  id="lieu_realisation_projet"
                                  @if($projet_etude->flag_enregistrer==true)
                                      value ="@isset($projet_etude){{$projet_etude->lieu_realisation_projet_instruction}}@endisset"
                                  @else
                                      value ="@isset($projet_etude){{$projet_etude->lieu_realisation_projet}}@endisset"
                                  @endif
                                  class="form-control form-control-sm ">
                       </div>

                       <div class="mb-1 col-md-6">
                           <label>Date prévisionnelle de démarrage
                           </label>
                           <input type="date" name="date_previsionnelle_demarrage_projet_instruction"
                                  id="date_previsionnelle_demarrage_projet"
                                  @if($projet_etude->flag_enregistrer==true)
                                      value ="@isset($projet_etude){{$projet_etude->date_previsionnelle_demarrage_projet_instruction}}@endisset"
                                  @else
                                      value ="@isset($projet_etude){{$projet_etude->date_previsionnelle_demarrage_projet}}@endisset"
                                  @endif
                                  class="form-control form-control-sm ">
                       </div>
                   </div>

               </div>

           </div>
       </div>
       <div class="col-md-6 col-12 mt-2">
           <div class="mb-1">
               <label for="contexte_probleme_instruction">Contexte ou Problèmes constatés <span style="color:red;">*</span></label>
               <input class="form-control" type="text" id="contexte_probleme_instruction_val" name="contexte_probleme_instruction"/>
               <div id="contexte_probleme_instruction" class="rounded-1">
                   @if($projet_etude->flag_enregistrer==true)
                       {!!@$projet_etude->contexte_probleme_instruction!!}
                   @else
                       {!!@$projet_etude->contexte_probleme_projet_etude!!}
                   @endif</div>
           </div>
       </div>
       <div class="col-md-6 col-12 mt-2">
           <div class="mb-1">
               <label for="objectif_general_instruction">Objectif Général <span style="color:red;">*</span></label>
               <input class="form-control" type="text" id="objectif_general_instruction_val" name="objectif_general_instruction"/>
               <div id="objectif_general_instruction" class="rounded-1">
                   @if($projet_etude->flag_enregistrer==true)
                       {!!@$projet_etude->objectif_general_instruction!!}
                   @else
                       {!!@$projet_etude->objectif_general_projet_etude!!}
                   @endif</div>

           </div>
       </div>
       <div class="col-md-6 col-12 mt-2">
           <div class="mb-1">
               <label for="objectif_specifique_instruction">Objectifs spécifiques <span style="color:red;">*</span> </label>
               <input class="form-control" type="text" id="objectif_specifique_instruction_val" name="objectif_specifique_instruction"/>
               <div id="objectif_specifique_instruction" class="rounded-1">
                   @if($projet_etude->flag_enregistrer==true)
                       {!!@$projet_etude->objectif_specifique_instruction!!}
                   @else
                       {!!@$projet_etude->objectif_specifique_projet_etud!!}
                   @endif
               </div>

           </div>
       </div>
       <div class="col-md-6 col-12 mt-2">
           <div class="mb-1">
               <label for="resultat_attendu_instruction">Résultats attendus <span style="color:red;">*</span>
               </label>
               <input class="form-control" type="text" id="resultat_attendu_instruction_val" name="resultat_attendu_instruction"/>
               <div id="resultat_attendu_instruction" class="rounded-1">
                   @if($projet_etude->flag_enregistrer==true)
                       {!!@$projet_etude->resultat_attendu_instruction!!}
                   @else
                       {!!@$projet_etude->resultat_attendu_projet_etude!!}
                   @endif
               </div>
           </div>
       </div>
       <div class="col-md-6 col-12 mt-2">
           <div class="mb-1">
               <label for="champ_etude_instruction">Champ de l’étude <span style="color:red;">*</span></label>
               <input class="form-control" type="text" id="champ_etude_instruction_val" name="champ_etude_instruction"/>
               <div id="champ_etude_instruction" class="rounded-1">
                   @if($projet_etude->flag_enregistrer==true)
                       {!!@$projet_etude->champ_etude_instruction!!}
                   @else
                       {!!@$projet_etude->champ_etude_projet_etude!!}
                   @endif
               </div>

           </div>
       </div>
       <div class="col-md-6 col-12 mt-2">
           <div class="mb-1">
               <label for="cible_instruction">Cible <span style="color:red;">*</span>
               </label>
               <input class="form-control" type="text" id="cible_instruction_val" name="cible_instruction"/>
               <div id="cible_instruction" class="rounded-1">
                   @if($projet_etude->flag_enregistrer==true)
                       {!!@$projet_etude->cible_instruction!!}
                   @else
                       {!!@$projet_etude->cible_projet_etude!!}
                   @endif</div>
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
                   <input type="text" name="montant_projet_instruction" id="montant_projet_instruction" class="form-control form-control-sm number"
                          value ="{{number_format(@$projet_etude->montant_projet_instruction, 0, ',', ' ')}}"
                   >
               </div>
           </div>
           <div class="col-md-6 mt-2">
               <label class="form-label" for="fichier_instruction">Pièce jointe <span style="color:red;">*</span></label>
               <input type="file" name="fichier_instruction" class="form-control" placeholder=""
                      @if(!$projet_etude->piece_jointe_instruction)
                      required="required"
                   @endif

               >
               <div>
                   @isset($projet_etude->piece_jointe_instruction)
                       <span class="badge bg-secondary mt-1"><a target="_blank"
                                                                onclick="NewWindow('{{ asset("pieces_projet/fichier_instruction/". $projet_etude->piece_jointe_instruction)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                   @endisset
               </div>
               <div id="defaultFormControlHelp" class="form-text">
                   <em> Fichiers autorisés : PDF, WORD, JPG, JPEG, PNG <br>Taille
                       maxi : 5Mo</em>
               </div>
           </div>
       </div>



       <div class="row">

           <div class="col-md-12 col-12">
               <div class="mb-1">
                   <label>Commentaires <strong style="color:red;">(Obligatoire si rejeté)*</strong>: </label>
                   <textarea class="form-control form-control-sm"  name="commentaires_instruction" id="commentaires_instruction" rows="10">{{@$projet_etude->commentaires_instruction}}</textarea>
               </div>
           </div>
       </div>
       <div class="col-12" align="right">
           <hr>
           @if($projet_etude->flag_soumis_ct_projet_etude != true)

           <button onclick='javascript:if (!confirm("Voulez-vous effectuer ce traitement ? Cette action est irréversible")) return false;' type="submit" name="action" value="SoumettreCT"
                   class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" id="SoumettreCT">
               Soumettre au comité
           </button>
               <button type="submit" name="action" value="EnregistrerInstruction"
                       class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                   Enregistrer
               </button>
               <button type="submit" name="action" value="RejetInstruction"
                       class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                   Rejeter
               </button>

           @endif
           <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-1" align="right">Précédent</a>
           <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
               Retour</a>
       </div>
   </div>

</form>
</div>


<div class="tab-pane fade @if(@$projet_etude->flag_recevablite_projet_etude!=true  && $id_etape==5) show active @endif" id="navs-top-traitementprojetetude" role="tabpanel">
<form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)) }}" enctype="multipart/form-data">
   @csrf
   @method('put')
   <div class="row">
       <div class="col-md-6 col-12">
           <label class="form-label" for="billings-country">Motif de recevabilité <strong style="color:red;">*</strong></label>

           <select class="form-select" data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">
               <?= $motifs; ?>
           </select>
       </div>
       <div class="col-md-6 col-12">
           <div class="mb-1">
               <label>Commentaire Recevabilité <strong style="color:red;">(Obligatoire si non recevable)*</strong>: </label>
               <textarea class="form-control form-control-sm"  name="commentaires_recevabilite" id="commentaire_recevable_plan_formation" rows="6">{{@$projet_etude->commentaires_recevabilite}}</textarea>
           </div>
       </div>
       <div class="col-12" align="right">
           <hr>
           <button type="submit" name="action" value="Recevable"
                   class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
               Recevable
           </button>
           <button type="submit" name="action" value="NonRecevable"
                   class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
               Non recevable
           </button>
           <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-1" align="right">Précédent</a>

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
        <div class="modal fade" id="modal_add_commentaire" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-2">
                            <h3 class="mb-2">Saisir le commentaire de la pièce</h3>
                            <p class="text-muted"></p>
                        </div>
                        <div class="modal-body">
                            <form class="mt-3" method="post" id="formAddCommentairePiece" action="{{ route('traitementprojetetude.add.piece.commentaire') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <input type="hidden" id="id_pieces_projet_etude"
                                               class="form-control form-control-sm"
                                               name="id_pieces_projet_etude"
                                               required="required"/>
                                    </div>
                                    <div class="col-md-12 ">
                                        <label class="form-label" for="piece_select">Type de pièce sélectionnée
                                            <strong style="color:red;">*</strong></label>
                                        <input type="text" id="piece_select"
                                               class="form-control form-control-sm"
                                               disabled
                                               required="required"
                                        />
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="email">Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control" rows="6" id="commentaire_piece" name="commentaire_piece" required="required"></textarea>
                                    </div>

                                    <div class="col-12 text-center">

                                        <button class="btn btn-primary me-sm-3 me-1 btn-submit" id="create_new_commentaire">Enregistrer</button>

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
                        <h5 class="card-header">Parcours d'affectation du projet d'étude</h5>
                        <div class="card-body pb-2">
                            <ul class="timeline pt-3">
                                @if($projet_etude->flag_soumis_chef_depart==false)
                                    <li class="timeline-item pb-4 timeline-item-primary  border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-success primary">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                        <div class="timeline-event">
                                            <div class="timeline-header border-bottom mb-3">
                                                <h6 class="mb-0"></h6>
                                                <span class="text-muted"><strong></strong></span>
                                                <div class="timeline-header border-bottom mb-3">
                                                    <h6 class="mb-0">1.</h6>
                                                    <span class="text-muted"><strong>CHEF DE DEPARTEMENT</strong></span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="row ">
                                                        <div>
                                                            <span>Observation : </span>
                                                        </div>
                                                        <div>
                                                            <span>Affecté le  </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li class="timeline-item pb-4 timeline-item-success  border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-success primary">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                        <div class="timeline-event">

                                            <div class="timeline-header border-bottom mb-3">
                                                <h6 class="mb-0"></h6>
                                                <span class="text-muted"><strong></strong></span>
                                                <div class="timeline-header border-bottom mb-3">
                                                    <h6 class="mb-0">1.</h6>
                                                    <span class="text-muted"><strong>CHEF DE DEPARTEMENT</strong></span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="row ">
                                                        <div>
                                                            <span>Observation : {{@$projet_etude->commentaires_cd}}</span>
                                                        </div>
                                                        <div>
                                                            <span>Affecté le {{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_soumis_chef_depart ))}} par {{@$projet_etude->chefDepartement->name}}
                                                                {{@$projet_etude->chefDepartement->prenom_users}}
                                                            à  {{@$projet_etude->chefService->name}}
                                                                {{@$projet_etude->chefService->prenom_users}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                @endif

                                @if($projet_etude->flag_soumis_chef_service==false)
                                    <li class="timeline-item pb-4 timeline-item-primary  border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-success primary">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                        <div class="timeline-event">
                                            <div class="timeline-header border-bottom mb-3">
                                                <h6 class="mb-0"></h6>
                                                <span class="text-muted"><strong></strong></span>
                                                <div class="timeline-header border-bottom mb-3">
                                                    <h6 class="mb-0">2.</h6>
                                                    <span class="text-muted"><strong>CHEF DE SERVICE</strong></span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="row ">
                                                        <div>
                                                            <span>Observation : </span>
                                                        </div>
                                                        <div>
                                                            <span>Affecté le  </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li class="timeline-item pb-4 timeline-item-success  border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-success primary">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                        <div class="timeline-event">

                                            <div class="timeline-header border-bottom mb-3">
                                                <h6 class="mb-0"></h6>
                                                <span class="text-muted"><strong></strong></span>
                                                <div class="timeline-header border-bottom mb-3">
                                                    <h6 class="mb-0">2.</h6>
                                                    <span class="text-muted"><strong>CHEF DE SERVICE</strong></span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="row ">
                                                        <div>
                                                            <span>Observation : {{@$projet_etude->commentaires_cd}}</span>
                                                        </div>
                                                        <div>
                                                                <span>Affecté le {{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_soumis_chef_service ))}} par {{@$projet_etude->chefService->name}}
                                                                    {{@$projet_etude->chefService->prenom_users}}
                                                            à  {{@$projet_etude->chargedetude->name}}
                                                                    {{@$projet_etude->chargedetude->prenom_users}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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

        //Hide All fields
        $("#contexte_probleme_instruction_val").hide();
        $("#objectif_general_instruction_val").hide();
        $("#objectif_specifique_instruction_val").hide();
        $("#resultat_attendu_instruction_val").hide();
        $("#champ_etude_instruction_val").hide();
        $("#cible_instruction_val").hide();
        $("#methodologie_instruction_val").hide();

        //Submit form
        formSoumettreCT.onsubmit = function(){
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

        //Desactivate if is submit
        contexte_probleme.disable();
        objectif_general.disable();
        objectif_specifique.disable();
        resultat_attendu.disable();
        champ_etude.disable();
        cible.disable();

        //Ajouter un commentaire
        var id;
        $(document).on('click', '.add_commentaire', function () {
            id = $(this).attr('data-id');
            var piece_select = $('#piece_select');
            var commentaire_piece = $('#commentaire_piece');
            var id_pieces_projet_etude = $('#id_pieces_projet_etude');

            $("#modal_add_commentaire").modal('show');
            $.get('{{url('/')}}/traitementprojetetude/piece/'+id+'/selectionnee',
                function (data) {
                    id_pieces_projet_etude.val(data.id_pieces_projet_etude);
                    piece_select.val(data.type_piece);
                    commentaire_piece.val(data.commentaire_piece);
                });
        });
    </script>
@endsection

