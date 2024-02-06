@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Demandes')
    @php($titre = 'Liste des projets d\'études')
    @php($soustitre = 'Modifier une demande de projet d\'étude ')
    @php($lien = 'projetetude')

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
                                class="nav-link  @if($id_etape==3) active @endif"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-piecesprojetetude"
                                aria-controls="navs-top-piecesprojetetude"
                                aria-selected="false">
                                Pièces jointes du projet
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
                        <div class="tab-pane fade  @if($id_etape==2) show active @endif" id="navs-top-infoprojetetude" role="tabpanel">
                            <form method="POST" class="form" action="{{ route($lien.'.update',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                                @csrf
                                @method('put')
                                <div class="col-md-12 col-10">
                                    <div class="row">
                                        <div class="mb-1 col-md-6">
                                            <label>Titre du projet <span
                                                    style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="titre_projet"
                                                   required="required" id="titre_projet"
                                                   class="form-control form-control-sm"
                                                   @if(@$projet_etude->flag_soumis==true)
                                                       disabled
                                                   @endif
                                                   value ="@isset($projet_etude){{$projet_etude->titre_projet_etude}}@endisset">
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
                                <div class="col-12" align="right">
                                    <hr>
                                    @if(@$projet_etude->flag_soumis==false)
                                        <button type="submit" name="action" value="Modifier"
                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Modifier
                                        </button>
                                    @endif
                                    @if(@$projet_etude->flag_soumis==false)

                                    <button type="submit" name="action" value="Modifier_suivant"
                                            class="btn btn-sm btn-primary me-sm-3 me-1">
                                        Suivant
                                    </button>
                                    @else
                                        <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                    @endif
                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                        Retour</a>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade @if($id_etape==3) show active @endif" id="navs-top-piecesprojetetude" role="tabpanel">
                            @if(!isset($avant_projet_tdr) || !isset($courier_demande_fin) || !isset($dossier_intention) || !isset($lettre_engagement) || !isset($offre_technique) || !isset($offre_financiere) )
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <div class="alert-body text-center">
                                       Info : Il vous faut ajouter tous les types de pièces et la pièce jointe associée avant de soumettre le projet d'étude
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <form method="POST" class="form"  enctype="multipart/form-data"  action="{{ route($lien.'.update',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)]) }}">
                                    @method('put')
                                    @csrf
                                    <div class="row mb-5">
                                        <div class="col-md-5">
                                            <label class="form-label">Type de pièce <span style="color:red;">*</span></label>
                                            <select
                                                class="select2 form-select-sm input-group"
                                                data-allow-clear="true" name="type_pieces">
                                                @if(!isset($avant_projet_tdr))
                                                    <option value="avant_projet_tdr">Avant-projet TDR</option>
                                                @endif
                                                @if(!isset($courier_demande_fin))
                                                    <option value="courier_demande_fin">Courrier de demande de financement</option>
                                                @endif
                                                @if(!isset($dossier_intention))
                                                    <option value="dossier_intention">Dossier d’intention</option>
                                                @endif

                                                @if(!isset($lettre_engagement))
                                                    <option value="lettre_engagement">Lettre d’engagement</option>
                                                @endif

                                                @if(!isset($offre_technique))
                                                    <option value="offre_technique">Offre technique</option>
                                                @endif
                                                @if(!isset($offre_financiere))
                                                    <option value="offre_financiere">Offre financière</option>
                                                @endif

                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Pièce jointe <span
                                                    style="color:red;">*</span> (PDF, WORD, JPG)
                                                5M</label>
                                            <input type="file" name="pieces"
                                                   class="form-control form-control-sm"
                                                   required="required" />
                                        </div>
                                        <div class="col-md-1 mt-4" align="right">
                                            <button type="submit" value="Enregistrer_fichier" name="action" class="btn btn-primary btn-sm waves-effect waves-light">
                                                Enregistrer
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
                                    <th>Type de pièce</th>
                                    <th>&nbsp;</th>
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
                                        <td>
                                            @if($piece->code_pieces=='avant_projet_tdr')
                                                <a href=""  onclick="NewWindow('{{ asset("pieces_projet/avant_projet_tdr/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='courier_demande_fin')
                                                <a href="" onclick="NewWindow('{{ asset("pieces_projet/courier_demande_fin/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='dossier_intention')
                                                <a href=""  onclick="NewWindow('{{ asset("pieces_projet/dossier_intention/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='lettre_engagement')
                                                <a href="" onclick="NewWindow('{{ asset("pieces_projet/lettre_engagement/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='offre_technique')
                                                <a href="" onclick="NewWindow('{{ asset("pieces_projet/offre_technique/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                            @if($piece->code_pieces=='offre_financiere')
                                                <a href=""  onclick="NewWindow('{{ asset("pieces_projet/offre_financiere/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                                   title="Afficher">Aperçu du ficher</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
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

                            @if(isset($avant_projet_tdr) && isset($courier_demande_fin) && isset($dossier_intention) && isset($lettre_engagement) && isset($offre_technique) && isset($offre_financiere) )
                                <form method="POST" class="form mt-3"  action="{{ route($lien.'.update',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)]) }}">
                                    @method('put')
                                    @csrf


                                    <div  class="text-end">
                                        <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1" align="right">Précédent</a>
                                        @if(@$projet_etude->flag_soumis == false)
                                            <button onclick='javascript:if (!confirm("Voulez-vous soumettre le projet ? Cette action est irréversible.")) return false;'  type="submit" name="action" value="Enregistrer_soumettre_projet_etude" class="btn btn-sm btn-success me-sm-3 me-1 "  align="right">Soumettre le projet d'étude</button>
                                        @endif
                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Content-->
@endsection
