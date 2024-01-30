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
                <h6 class="text-muted"></h6>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link @if($id_etape==1) active @endif"
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
                                    Traitement du dossier

                                </button>
                            </li>
                        @endif
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link  @if(@$projet_etude->flag_recevablite_projet_etude!=true && $id_etape==5) active @else disabled @endif"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-traitementprojetetude"
                                    aria-controls="navs-top-traitementprojetetude"
                                    aria-selected="false">
                                    Recevabilité
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
                                    <a  href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary">Suivant</a>
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
                                                  disabled
                                                  required="required" rows="4" id="exampleFormControlTextarea"
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

                        </div>

                        <div class="tab-pane fade @if(@$projet_etude->flag_recevablite_projet_etude==true  && $id_etape==4) show active @endif" id="navs-top-traitementinstructionprojetetude" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <h5 class="text-center">Traitement de l'instruction du dossier</h5>

                                    <h6>Information du projet d'étude</h6>

                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label>Titre du projet <span style="color:red;">*</span>
                                            </label>
                                            <input type="text" name="titre_projet_instruction" required="required" id="titre_projet_instruction" class="form-control form-control-sm" placeholder="" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="montant_projet_instruction">Montant du projet <span style="color:red;">*</span>
                                            </label>
                                            <input type="number" name="montant_projet_instruction" required="required" id="montant_projet_instruction" class="form-control form-control-sm" placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label" for="fichier_instruction">Fichier d'instruction <span style="color:red;">*</span> (PDF, WORD, JPG)
                                            5M</label>
                                        <input type="file" name="fichier_instruction" class="form-control" placeholder="" required="required">
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="contexte_probleme_instruction">Contexte ou Problèmes constatés <span style="color:red;">*</span></label>
                                            <textarea class="form-control" required="required" rows="4" id="contexte_probleme_instruction" name="contexte_probleme_instruction"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="objectif_general_instruction">Objectif Général <span style="color:red;">*</span>
                                            </label>
                                            <textarea required="required" class="form-control" rows="4" id="objectif_general_instruction" name="objectif_general_instruction" ></textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="objectif_specifique_instruction">Objectifs spécifiques <span style="color:red;">*</span> </label>
                                            <textarea class="form-control" required="required" rows="4" id="objectif_specifique_instruction" name="objectif_specifique_instruction" >                                                                </textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="resultat_attendu_instruction">Résultats attendus <span style="color:red;">*</span>
                                            </label>
                                            <textarea class="form-control" required="required" rows="4" id="resultat_attendu_instruction" name="resultat_attendu_instruction" ></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="champ_etude_instruction">Champ de l’étude <span style="color:red;">*</span></label>
                                            <textarea class="form-control" rows="4" id="champ_etude_instruction" name="champ_etude_instruction"  required="required"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="cible_instruction">Cible <span style="color:red;">*</span>
                                            </label>
                                            <textarea class="form-control" rows="4" id="cible_instruction" name="cible_instruction"  required="required"> </textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 mt-2">
                                        <div class="mb-1">
                                            <label for="methodologie_instruction">Methodologie <span style="color:red;">*</span>
                                            </label>
                                            <textarea class="form-control" rows="4" id="methodologie_instruction" name="methodologie_instruction"  required="required"> </textarea>

                                        </div>
                                    </div>

                                    <h6 class="mb-3 mt-4">Avis</h6>

                                    <div class="row">

                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label>Commentaires <strong style="color:red;">(Obligatoire si rejeté)*</strong>: </label>
                                                <textarea class="form-control form-control-sm"  name="commentaires_instruction" id="commentaires_instruction" rows="6">{{@$planformation->commentaire_recevable_plan_formation}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>
                                        @if($projet_etude->flag_soumis_ct_projet_etude != true)

                                        <button onclick='javascript:if (!confirm("Voulez-vous effectuer ce traitement ? Cette action est irréversible")) return false;' type="submit" name="action" value="SoumettreCT"
                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            soumettre au CT
                                        </button>
                                            <button type="submit" name="action" value="RejetInstruction"
                                                    class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                                Rejeter
                                            </button>
                                        @endif
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
                                        <label class="form-label" for="billings-country">Motif de Recevabilité <strong style="color:red;">*</strong></label>

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
                                        <button type="submit" name="action" value="MettreEnAttente"
                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light" >
                                            Mettre en attente
                                        </button>
                                        <button type="submit" name="action" value="NonRecevable"
                                                class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                            Non recevable
                                        </button>
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
@endsection
