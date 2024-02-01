@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Demandes')
    @php($titre = 'Liste des projets d\'études')
    @php($soustitre = 'Modifier une demande de projet d\'étude ')
    @php($lien = 'affectationprojetetude')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
                {{ $titre }}
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
                                class="nav-link @if($id_etape==1) active @else disabled  @endif"
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
                                class="nav-link @if($id_etape==2) active @else disabled  @endif"
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
                                class="nav-link  @if($id_etape==3) active @else disabled  @endif"
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
                                class="nav-link  @if($id_etape==4) active @else disabled @endif"
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
                        <div class="tab-pane fade @if($id_etape==1) show active @endif" id="navs-top-projetetude " role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>N° de compte contribuable (NCC) <strong style="color:red;">*</strong></label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               value="{{@@$projet_etude->entreprise->ncc_entreprises}}" disabled="disabled">
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
                                    <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade  @if($id_etape==2) show active @endif" id="navs-top-infoprojetetude" role="tabpanel">
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
                                                      rows="3" id="exampleFormControlTextarea"
                                                      name="contexte_probleme" style="height: 121px;">@isset($projet_etude){{$projet_etude->contexte_probleme_projet_etude}}@endisset</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Objectif Général <span
                                                    style="color:red;">*</span> </label>
                                            <textarea required="required" class="form-control"
                                                          disabled
                                                      rows="3" id="exampleFormControlTextarea"
                                                      name="objectif_general" style="height: 121px;">@isset($projet_etude){{$projet_etude->objectif_general_projet_etude}}@endisset</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Objectifs spécifiques <span
                                                    style="color:red;">*</span> </label>
                                            <textarea class="form-control" required="required"
                                                          disabled
                                                      rows="3" id="exampleFormControlTextarea"
                                                      name="objectif_specifique" style="height: 121px;">@isset($projet_etude){{$projet_etude->objectif_specifique_projet_etud}}@endisset</textarea>

                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Résultats attendus <span
                                                    style="color:red;">*</span> </label>
                                            <textarea class="form-control"
                                                          disabled
                                                      required="required" rows="3" id="exampleFormControlTextarea"
                                                      name="resultat_attendu" style="height: 121px;">@isset($projet_etude){{$projet_etude->resultat_attendu_projet_etude}}@endisset</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Champ de l’étude <span
                                                    style="color:red;">*</span></label>
                                            <textarea class="form-control"
                                                          disabled
                                                      rows="3" id="exampleFormControlTextarea" name="champ_etude"
                                                      style="height: 121px;" required="required">@isset($projet_etude){{$projet_etude->champ_etude_projet_etude}}@endisset</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Cible <span style="color:red;">*</span>
                                            </label>
                                            <textarea class="form-control"
                                                          disabled
                                                      rows="3" id="exampleFormControlTextarea" name="cible" style="height: 121px;"
                                                      required="required">@isset($projet_etude){{$projet_etude->cible_projet_etude}}@endisset</textarea>

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
                                <form action="{{route('affectationprojetetude.update',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)])}}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <label class="form-label" for="id_chef_serv">Liste des chefs de service <span
                                                style="color:red;">*</span></label>
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
                                        <label class="form-label" for="commentaires_cd">Commentaires</label>
                                        <textarea class="form-control" id="commentaires_cd" name="commentaires_cd" rows="4"
                                                  @if(@$projet_etude->flag_soumis_chef_depart==true)
                                                      disabled
                                            @endif
                                        >{{@$projet_etude->commentaires_cd}}</textarea>
                                    </div>
                                        <div class="col-12" align="left">
                                            <br>

                                            <div class="col-12" align="right">
                                                <a  href="{{route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary " align="right">Précédent</a>
                                                @if(@$projet_etude->flag_soumis_chef_depart==false)

                                                <button onclick='javascript:if (!confirm("Voulez-vous attribuer ce projet au chef de service sélectionné ? . Cette action est irréversible.")) return false;'  type="submit" name="action"
                                                        value="soumission_projet_etude_cd"
                                                        class="ms-sm-3 ms-1 btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Soumettre au chef de service
                                                </button>
                                                @endif

                                            </div>
                                        </div>

                                </form>
                            @endif
                            @if(@$role=="CHEF DE SERVICE")
                                    <form action="{{route('affectationprojetetude.update',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)])}}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <label class="form-label" for="id_charge_etude">Liste des chargés d'étude <span
                                                    style="color:red;">*</span></label>
                                            <select @if(@$projet_etude->flag_soumis_charge_etude==true)
                                                        disabled
                                                    @endif id="id_charge_etude" name="id_charge_etude" class="select2 form-select-sm input-group"
                                            >
                                                <option></option>
                                                @foreach($charger_etudes as $charger_etude)
                                                    <option value="{{$charger_etude->id}}" @if(@$charger_etude->id==@$projet_etude->id_charge_etude) selected @endif>{{@$charger_etude->name}} {{@$charger_etude->prenom_users}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label class="form-label" for="commentaires_cs">Commentaires</label>
                                            <textarea class="form-control"
                                                      @if(@$projet_etude->flag_soumis_charge_etude==true)
                                                          disabled
                                                      @endif
                                                      id="commentaires_cs" name="commentaires_cs" rows="4">{{@$projet_etude->commentaires_cs}}</textarea>
                                        </div>
                                        <div class="col-12" align="left">
                                            <br>
                                            <div class="col-12" align="right">
                                                <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                                @if(@$projet_etude->flag_soumis_charge_etude==false)

                                                <button type="submit" name="action"
                                                        value="soumission_projet_etude_cs"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Soumettre au  chargé d'étude
                                                </button>
                                                    @endif
                                            </div>
                                        </div>
                                    </form>
                            @endif




                                {{--                            <form method="POST" class="form" action="{{ route($lien.'.update',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(2)]) }}">--}}
{{--                                @csrf--}}
{{--                                @method('put')--}}
{{--                                <div class="col-md-12 col-10" align="center">--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label>Titre du projet <span--}}
{{--                                                style="color:red;">*</span>--}}
{{--                                        </label>--}}
{{--                                        <input type="text" name="titre_projet"--}}
{{--                                               required="required" id="titre_projet"--}}
{{--                                               class="form-control form-control-sm"--}}
{{--                                               @if(@$projet_etude->flag_soumis==true)--}}
{{--                                                   disabled--}}
{{--                                               @endif--}}
{{--                                               value ="@isset($projet_etude){{$projet_etude->titre_projet_etude}}@endisset"--}}

{{--                                               placeholder="ex : Perfectionnement ..">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-4 col-12">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <label>Contexte ou Problèmes constatés <span--}}
{{--                                                    style="color:red;">*</span></label>--}}
{{--                                            <textarea class="form-control" required="required"--}}
{{--                                                      @if(@$projet_etude->flag_soumis==true)--}}
{{--                                                          disabled--}}
{{--                                                      @endif--}}
{{--                                                      rows="3" id="exampleFormControlTextarea"--}}
{{--                                                      name="contexte_probleme" style="height: 121px;">@isset($projet_etude){{$projet_etude->contexte_probleme_projet_etude}}@endisset</textarea>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4 col-12">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <label>Objectif Général <span--}}
{{--                                                    style="color:red;">*</span> </label>--}}
{{--                                            <textarea required="required" class="form-control"--}}
{{--                                                      @if(@$projet_etude->flag_soumis==true)--}}
{{--                                                          disabled--}}
{{--                                                      @endif--}}
{{--                                                      rows="3" id="exampleFormControlTextarea"--}}
{{--                                                      name="objectif_general" style="height: 121px;">@isset($projet_etude){{$projet_etude->objectif_general_projet_etude}}@endisset</textarea>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4 col-12">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <label>Objectifs spécifiques <span--}}
{{--                                                    style="color:red;">*</span> </label>--}}
{{--                                            <textarea class="form-control" required="required"--}}
{{--                                                      @if(@$projet_etude->flag_soumis==true)--}}
{{--                                                          disabled--}}
{{--                                                      @endif--}}
{{--                                                      rows="3" id="exampleFormControlTextarea"--}}
{{--                                                      name="objectif_specifique" style="height: 121px;">@isset($projet_etude){{$projet_etude->objectif_specifique_projet_etud}}@endisset</textarea>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-md-4 col-12">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <label>Résultats attendus <span--}}
{{--                                                    style="color:red;">*</span> </label>--}}
{{--                                            <textarea class="form-control"--}}
{{--                                                      @if(@$projet_etude->flag_soumis==true)--}}
{{--                                                          disabled--}}
{{--                                                      @endif--}}
{{--                                                      required="required" rows="3" id="exampleFormControlTextarea"--}}
{{--                                                      name="resultat_attendu" style="height: 121px;">@isset($projet_etude){{$projet_etude->resultat_attendu_projet_etude}}@endisset</textarea>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4 col-12">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <label>Champ de l’étude <span--}}
{{--                                                    style="color:red;">*</span></label>--}}
{{--                                            <textarea class="form-control"--}}
{{--                                                      @if(@$projet_etude->flag_soumis==true)--}}
{{--                                                          disabled--}}
{{--                                                      @endif--}}
{{--                                                      rows="3" id="exampleFormControlTextarea" name="champ_etude"--}}
{{--                                                      style="height: 121px;" required="required">@isset($projet_etude){{$projet_etude->champ_etude_projet_etude}}@endisset</textarea>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-4 col-12">--}}
{{--                                        <div class="mb-1">--}}
{{--                                            <label>Cible <span style="color:red;">*</span>--}}
{{--                                            </label>--}}
{{--                                            <textarea class="form-control"--}}
{{--                                                      @if(@$projet_etude->flag_soumis==true)--}}
{{--                                                          disabled--}}
{{--                                                      @endif--}}
{{--                                                      rows="3" id="exampleFormControlTextarea" name="cible" style="height: 121px;"--}}
{{--                                                      required="required">@isset($projet_etude){{$projet_etude->cible_projet_etude}}@endisset</textarea>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-12" align="right">--}}
{{--                                    <hr>--}}
{{--                                    @if(@$projet_etude->flag_soumis==false)--}}
{{--                                        <button type="submit" name="action" value="Modifier"--}}
{{--                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">--}}
{{--                                            Modifier--}}
{{--                                        </button>--}}
{{--                                    @endif--}}

{{--                                    <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>--}}

{{--                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">--}}
{{--                                        Retour</a>--}}
{{--                                </div>--}}
{{--                            </form>--}}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Content-->
@endsection
