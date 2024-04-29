@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet d\'étude')
    @php($titre = 'Liste des projets d\'études à affecter')
    @php($soustitre = 'Détails du projet d\'étude ')
    @php($lien = 'affectationprojetetude')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light">
                    <a href="{{route('dashboard')}}"> <i class="ti ti-home mb-2"></i>  Accueil </a> /
                   <a href="{{route($lien)}}"> {{$titre}}</a> /  {{$soustitre}}
                </span>
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
                                aria-selected="true">
                                Détails de l'entreprise
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link @if($id_etape==2) active   @endif"
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
                                class="nav-link  @if($id_etape==3) active  @endif"
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
                                class="nav-link  @if($id_etape==4) active  @endif"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-affectationprojetetude"
                                aria-controls="navs-top-affectationprojetetude"
                                aria-selected="false">
                                Affectation
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade  @if($id_etape==1) show active @endif" id="navs-top-entreprise" role="tabpanel">
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
                                    <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                    <a class="btn btn-sm btn-outline-secondary waves-effect  ms-sm-3 me-1" href="/{{$lien }}">Retour</a>

                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade  @if($id_etape==2) show active @endif" id="navs-top-infoprojetetude" role="tabpanel">

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
                                                       value ="{{@$projet_etude->montant_demande_projet_etude}}"

                                                       class="form-control form-control-sm number">
                                            </div>

                                            <div class="mb-1 col-md-6">
                                                <label>Secteur d'activité du projet <span
                                                        style="color:red;">*</span>
                                                </label>
                                                <select name="id_secteur_activite" class="select2 form-select-sm input-group" data-allow-clear="true"  @if(@$projet_etude->flag_soumis==true)
                                                    disabled
                                                    @endif>
                                                    <?= $secteuractivite_projet; ?>
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
                            <div class="row">
                                <div class="col-md-12" align="right">
                                    <hr>
                                    <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                    <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary">Suivant</a>

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade @if($id_etape==3) show active @endif" id="navs-top-piecesprojetetude" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>N°</th>
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
                                                @if($piece->code_pieces=='autres_piece')
                                                   {{@$piece->intitule_piece}}
                                                @endif
                                        </td>
                                        <td>
                                            @if($piece->code_pieces=='avant_projet_tdr')
                                                <a href="#"  onclick="NewWindow('{{ asset("pieces_projet/avant_projet_tdr/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='courier_demande_fin')
                                                <a href="#" onclick="NewWindow('{{ asset("pieces_projet/courier_demande_fin/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
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
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                                        <div  class="text-end mt-3">
                                            <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                            <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(4)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                        </div>

                        </div>
                        <div class="tab-pane fade  @if($id_etape==4) show active @endif" id="navs-top-affectationprojetetude" role="tabpanel">
                            @if(@$role=="CHEF DE DEPARTEMENT")
                                <form id="affectProjetChefDepartForm" action="{{route('affectationprojetetude.update',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)])}}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <label class="form-label" for="id_chef_serv">Liste des chefs de service <span
                                                class="text-danger">*</span></label>
                                        <select id="id_chef_serv" name="id_chef_serv" class="select2 form-select-sm input-group"
                                            @if(@$projet_etude->flag_soumis_chef_depart==true)
                                                disabled
                                            @endif
                                        >
                                            <option></option>
                                            @foreach($chef_services as $chef_service)
                                                <option value="{{@$chef_service->id}}" @if(@$chef_service->id==@$projet_etude->id_chef_serv) selected @endif>{{@$chef_service->name}} {{@$chef_service->prenom_users}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <label class="form-label" for="commentaires_cd">Commentaires <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="commentaires_cd" name="commentaires_cd" rows="4"
                                                  @if(@$projet_etude->flag_soumis_chef_depart==true)
                                                      disabled
                                            @endif
                                        >{{@$projet_etude->commentaires_cd}}</textarea>
                                    </div>
                                        <div class="col-12" align="left">
                                            <br>

                                            <div class="col-12" align="right">
                                                <a  href="{{route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1 " align="right">Précédent</a>
                                                @if(@$projet_etude->flag_soumis_chef_depart==false)

                                                <button onclick='javascript:if (!confirm("Voulez-vous attribuer ce projet au chef de service sélectionné ? . Cette action est irréversible.")) return false;'  type="submit" name="action"
                                                        value="soumission_projet_etude_cd"
                                                        class="ms-sm-3   me-sm-3 ms-1 btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Imputer au chef de service
                                                </button>
                                                @endif

                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">Retour</a>


                                            </div>
                                        </div>

                                </form>
                            @endif
                            @if(@$role=="CHEF DE SERVICE")
                                    <form id="affectProjetChefServForm" action="{{route('affectationprojetetude.update',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)])}}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <label class="form-label" for="id_charge_etude">Liste des chargés d'étude <span
                                                   class="text-danger">*</span></label>
                                            <select @if(@$projet_etude->flag_soumis_chef_service==true)
                                                        disabled
                                                    @endif id="id_charge_etude" name="id_charge_etude" class="select2 form-select-sm input-group"
                                            >
                                                <option></option>
                                                @foreach($charger_etudes as $charger_etude)
                                                    <option value="{{$charger_etude->id}}" @if(@$charger_etude->id==@$projet_etude->id_charge_etude) selected @endif>{{mb_strtoupper(@$charger_etude->name)}} {{strtoupper(@$charger_etude->prenom_users)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="form-label" for="commentaires_cs">Commentaires <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control"
                                                      @if(@$projet_etude->flag_soumis_chef_service==true)
                                                          disabled
                                                      @endif
                                                      id="commentaires_cs" name="commentaires_cs" rows="4">{{@$projet_etude->commentaires_cs}}</textarea>
                                        </div>
                                        <div class="col-12" align="left">
                                            <br>
                                            <div class="col-12" align="right">
                                                <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                                @if(@$projet_etude->flag_soumis_chef_service==false)

                                                <button onclick='javascript:if (!confirm("Voulez-vous attribuer ce projet au chargé d étude sélectionné ? . Cette action est irréversible.")) return false;' type="submit" name="action"
                                                        value="soumission_projet_etude_cs"
                                                        class="ms-sm-3   me-sm-3 ms-1 btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Imputer au  chargé d'étude
                                                </button>
                                                    @endif

                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">Retour</a>

                                            </div>
                                        </div>
                                    </form>
                            @endif

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
    <script src="{{asset('assets/js/projetetudes/pages-affectation-projet.js')}}"></script>
    <script type="text/javascript">
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
    var methodologie = new Quill('#methodologie', {
        theme: 'snow'
    });

    //Hide All fields
    $("#contexte_probleme_val").hide();
    $("#objectif_general_val").hide();
    $("#objectif_specifique_val").hide();
    $("#resultat_attendu_val").hide();
    $("#champ_etude_val").hide();
    $("#cible_val").hide();
    $("#methodologie_val").hide();

    //Desactivate if is submit
    contexte_probleme.disable();
    objectif_general.disable();
    objectif_specifique.disable();
    resultat_attendu.disable();
    champ_etude.disable();
    cible.disable();
    methodologie.disable();

    //Submit form
    demandeProjetForm.onsubmit = function(){
        $("#contexte_probleme_val").val(contexte_probleme.root.innerHTML);
        $("#objectif_general_val").val(objectif_general.root.innerHTML);
        $("#objectif_specifique_val").val(objectif_specifique.root.innerHTML);
        $("#resultat_attendu_val").val(resultat_attendu.root.innerHTML);
        $("#champ_etude_val").val(champ_etude.root.innerHTML);
        $("#cible_val").val(cible.root.innerHTML);
        $("#methodologie_val").val(methodologie.root.innerHTML);
    }

    $("#div_libelle_piece").hide();
    $("#intitule_piece").prop( "disabled", true );
    $('#type_pieces').on('change', function() {
        if(this.value=='autres'){
            $("#div_libelle_piece").show();
            $("#intitule_piece").prop( "disabled", false );
        }else{
            $("#div_libelle_piece").hide();
            $("#intitule_piece").prop( "disabled", true );
        }
    });

</script>

@endsection
