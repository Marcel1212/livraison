@php
use App\Helpers\AnneeExercice;
$anneexercice = AnneeExercice::get_annee_exercice();
@endphp
@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Agréement')
    @php($titre='Liste des plans de formations agrées')
    @php($soustitre='Annulation de plan de formation')
    @php($lien='agreement')
    <!-- BEGIN: Content-->


    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
    </h5>
    <div class="content-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
        @if(!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{$anneexercice}}
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
                                data-bs-target="#navs-top-planformation"
                                aria-controls="navs-top-planformation"
                                aria-selected="true">
                                Plan de formation
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-categorieplan"
                                aria-controls="navs-top-categorieplan"
                                aria-selected="false">
                                Effectif de l'entreprise
                            </button>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="nav-link"--}}
{{--                                role="tab"--}}
{{--                                data-bs-toggle="tab"--}}
{{--                                data-bs-target="#navs-top-histortiqueactionformation"--}}
{{--                                aria-controls="navs-top-histortiqueactionformation"--}}
{{--                                aria-selected="false">--}}
{{--                                Historiques des actions du plan de formation--}}
{{--                            </button>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-actionformation"
                                aria-controls="navs-top-actionformation"
                                aria-selected="false">
                                Actions du plan de formation
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-annulation"
                                aria-controls="navs-top-annulation"
                                aria-selected="true">
                                Demande d'annulation
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="navs-top-planformation" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>N° de compte contribuable </label>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   value="{{$infoentreprise->ncc_entreprises}}" disabled="disabled">
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
                                            <label>Activité </label>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   value="{{$infoentreprise->activite->libelle_activites}}" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Localisation geaographique </label>
                                            <input type="text" name="localisation_geographique_entreprise" id="localisation_geographique_entreprise"
                                                   class="form-control form-control-sm"
                                                   value="{{$infoentreprise->localisation_geographique_entreprise}}" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Repère d'accès </label>
                                            <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                                   class="form-control form-control-sm"
                                                   value="{{$infoentreprise->repere_acces_entreprises}}" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Adresse postal </label>
                                            <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                                   class="form-control form-control-sm"
                                                   value="{{$infoentreprise->adresse_postal_entreprises}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Adresse postal </label>
                                            <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                                   class="form-control form-control-sm"
{{--                                                   value="{{$infoentreprise->adresse_postal_entreprises}}"--}}
                                                   disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="billings-country">Indicatif</label>
                                                    <select class="select form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                                        @foreach($pays as $pay)
                                                            <option value="{{$pay->id}}" @if($infoentreprise->pay->indicatif==$pay->indicatif) selected @endif>
                                                                {{$pay->indicatif}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Telephone  </label>
                                                    <input type="text"
                                                           class="form-control form-control-sm"
                                                           value="{{$infoentreprise->tel_entreprises}}"
                                                           disabled="disabled">
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
                                                        @foreach($pays as $pay)
                                                            <option value="{{$pay->id}}" @if($infoentreprise->pay->indicatif==$pay->indicatif) selected @endif>
                                                                {{$pay->indicatif}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Cellulaire Professionnelle  </label>
                                                    <input type="number" name="cellulaire_professionnel_entreprises" id="cellulaire_professionnel_entreprises"
                                                           class="form-control form-control-sm"
                                                           value="{{$infoentreprise->cellulaire_professionnel_entreprises}}"
                                                           disabled="disabled">
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
                                                        @foreach($pays as $pay)
                                                            <option value="{{$pay->id_pays}}" @if($infoentreprise->id_pays==$pay->id_pays) selected @endif>
                                                                {{$pay->indicatif}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Fax  </label>
                                                    <input type="number" name="fax_entreprises" id="fax_entreprises"
                                                           class="form-control form-control-sm"
                                                           value="{{$infoentreprise->fax_entreprises}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Nom et prenom du responsable formation </label>
                                            <input type="text" name="nom_prenoms_charge_plan_formati" id="nom_prenoms_charge_plan_formati"
                                                   class="form-control form-control-sm"
                                                   value="{{$plan_de_formation->nom_prenoms_charge_plan_formati}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Fonction du responsable formation </label>
                                            <input type="text" name="fonction_charge_plan_formation" id="fonction_charge_plan_formation"
                                                   class="form-control form-control-sm"
                                                   value="{{$plan_de_formation->fonction_charge_plan_formation}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Email professsionel du responsable formation </label>
                                            <input type="email" name="email_professionnel_charge_plan_formation" id="email_professionnel_charge_plan_formation"
                                                   class="form-control form-control-sm"
                                                   value="{{$plan_de_formation->email_professionnel_charge_plan_formation}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Nombre total de salarié </label>
                                            <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"
                                                   class="form-control form-control-sm"
                                                   value="{{$plan_de_formation->nombre_salarie_plan_formation}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Type entreprises </label>
                                            <select class="select2 form-select-sm input-group" name="id_type_entreprise" id="id_type_entreprise" disabled="disabled">
                                                @foreach($type_entreprises as $type_entreprise)
                                                    <option value="{{$type_entreprise->id_type_entreprise}}" @if($plan_de_formation->id_type_entreprise==$type_entreprise->id_type_entreprise) selected @endif>
                                                        {{$type_entreprise->lielle_type_entrepise}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">

                                            <label>Masse salariale </label>
                                            <input type="number" name="masse_salariale" id="masse_salariale"
                                                   class="form-control form-control-sm"
                                                   value="{{$plan_de_formation->masse_salariale}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">

                                            <label>Part entreprise </label>
                                            <input type="text" name="part_entreprise" id="part_entreprise"
                                                   class="form-control form-control-sm"
                                                   value="{{$plan_de_formation->part_entreprise}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">

                                            <label>Code plan </label>
                                            <input type="text" name="code_plan_formation" id="code_plan_formation"
                                                   class="form-control form-control-sm"
                                                   value="{{$plan_de_formation->code_plan_formation}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>


                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="navs-top-categorieplan" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id=""
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Categorie </th>
                                    <th>Genre</th>
                                    <th>Nombre</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categorieplans as $key => $categorieplan)
                                        <tr>
                                            <td>{{ $key+1}}</td>
                                            <td>{{ $categorieplan->categorieProfessionelle->categorie_profeessionnelle }}</td>
                                            <td>{{ $categorieplan->genre_plan }}</td>
                                            <td>{{ $categorieplan->nombre_plan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="navs-top-actionformation" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id="exampleData"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Intitluer de l'action de formation </th>
                                    <th>Structure ou etablissemnt de formation</th>
                                    <th>Nombre de stagiaires</th>
                                    <th>Nombre de groupe</th>
                                    <th>Nombre d'heures par groupe</th>
                                    <th>Cout de l'action</th>
                                    <th>Cout de l'action accordée</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($actionplanformations as $key => $actionplanformation)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $actionplanformation->intitule_action_formation_plan }}</td>
                                        <td>{{ $actionplanformation->structure_etablissement_action_ }}</td>
                                        <td>{{ $actionplanformation->nombre_stagiaire_action_formati }}</td>
                                        <td>{{ $actionplanformation->nombre_groupe_action_formation_ }}</td>
                                        <td>{{ $actionplanformation->nombre_heure_action_formation_p }}</td>
                                        <td>{{ $actionplanformation->cout_action_formation_plan }}</td>
                                        <td>{{ $actionplanformation->cout_accorde_action_formation }}</td>
                                        <td align="center">
{{--                                            @can($lien.'-edit')--}}
                                                <a onclick="NewWindow('{{ route("planformation.show",\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                   class=" "
                                                   title="Modifier"><img src='/assets/img/eye-solid.png'></a>
{{--                                            @endcan--}}

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade show active" id="navs-top-annulation" role="tabpanel">
                            @isset($demande_annulation_plan)
                                @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true)
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <h5 class="card-title mb-3" align="center"> Détail de la demande d'annulation</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <div class="mb-1">
                                                            <label> Motif de la demande d'annulation du plan</label>
                                                            <select class="select2 form-select-sm input-group" disabled data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">
                                                                @foreach($motifs as $motif)
                                                                    <option value="{{$motif->id_motif}}">{{$motif->libelle_motif}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <label class="form-label">Pièce justificatif
                                                            de la demande d'annulation</label>
                                                        <br>
                                                        @isset($demande_annulation_plan->piece_demande_annulation_plan)
                                                            <span class="badge bg-secondary"> <a target="_blank"
                                                                                                 onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                          Voir la pièce  </a></span>
                                                        @endisset
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-1">
                                                    <label> Commentaire de la demande d'annulation du plan</label>
                                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                              style="height: 121px;" disabled>@isset($demande_annulation_plan->commentaire_demande_annulation_plan) {{$demande_annulation_plan->commentaire_demande_annulation_plan}} @endisset</textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12" align="right">
                                            <hr>
                                            <a class="btn btn-sm btn-outline-secondary float-end waves-effect"
                                               href="/{{$lien }}">
                                                Retour</a>
                                        </div>
                                    </div>
                                @else
                                    <form method="POST" class="form"
                                          action="{{route($lien.'.cancel.update',['id_demande'=>\App\Helpers\Crypt::UrlCrypt($demande_annulation_plan->id_demande_annulation_plan), 'id_plan'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)])}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-1">
                                                            <label> Motif de la demande d'annulation du plan</label>
                                                            <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >
                                                                @foreach($motifs as $motif)
                                                                    <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="form-label">Pièce justificatif de la demande d'annulation <strong
                                                                style="color:red;"></strong></label>
                                                        <input type="file" name="piece_demande_annulation_plan"
                                                               class="form-control form-control-sm" placeholder=""
                                                               @isset($demande_annulation_plan->piece_demande_annulation_plan)value="{{$demande_annulation_plan->piece_demande_annulation_plan}}"@endisset/>
                                                        <div id="defaultFormControlHelp" class="form-text ">
                                                            <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                maxi : 5Mo</em>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        @isset($demande_annulation_plan->piece_demande_annulation_plan)
                                                            <span class="badge bg-secondary"> <a target="_blank"
                                                                                                 onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                          Voir la pièce précédemment enregistrée  </a></span>
                                                        @endisset
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire de la demande d'annuation <strong
                                                            style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm"  name="commentaire_demande_annulation_plan" id="commentaire_demande_annulation_plan" rows="6">@isset($demande_annulation_plan->commentaire_demande_annulation_plan){{$demande_annulation_plan->commentaire_demande_annulation_plan}}@endisset</textarea>
                                                </div>
                                            </div>


                                            <div class="col-12" align="right">
                                                <hr>
                                                <button onclick='javascript:if (!confirm("Voulez-vous soumettre la demande d annulation de ce plan de formation à un conseiller ? . Cette action est irreversible")) return false;'  type="submit" name="action" value="Enregistrer_soumettre_plan_formation" class="btn btn-sm btn-success me-sm-3 me-1">Soumettre la demande d'annulation</button>

                                                <button type="submit"
                                                        class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">
                                                    Modifier
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>

                                        </div>
                                    </form>
                                @endif
                            @else
                                <form method="POST" class="form"
                                          action="{{ route($lien.'.cancel.store', \App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-1">
                                                            <label> Motif de la demande d'annulation du plan</label>
                                                            <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >
                                                                @foreach($motifs as $motif)
                                                                    <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="form-label">Pièce justificatif de la demande d'annulation <strong
                                                                style="color:red;">*</strong></label>
                                                        <input type="file" name="piece_demande_annulation_plan"
                                                               class="form-control form-control-sm" placeholder=""
                                                               required="required"
                                                               value="{{ old('piece_demande_annulation_plan') }}"/>
                                                        <div id="defaultFormControlHelp" class="form-text ">
                                                            <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                maxi : 5Mo</em>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire de la demande d'annuation <strong
                                                            style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm"  name="commentaire_demande_annulation_plan" id="commentaire_demande_annulation_plan" rows="6">{{ old('commentaire_demande_annulation_plan') }}</textarea>
                                                </div>
                                            </div>


                                            <div class="col-12" align="right">
                                                <hr>

                                                <button type="submit"
                                                        class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>

                                        </div>
                                    </form>
                            @endisset
                        </div>

                    </div>
                </div>
            </div>
    </div>


    <!-- Edit User Modal -->
{{--    @foreach($infosactionplanformations as $infosactionplanformation)--}}
        <div class="modal fade" id="traiterActionFomationPlan

{{--<?php echo $infosactionplanformation->id_action_formation_plan ?>--}}

" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="mb-2">Traitement d'une action de plan de formation</h3>
                            <p class="text-muted"></p>
                        </div>
                        <form id="editUserForm" class="row g-3" method="POST" action="
{{--                        {{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan)) }}--}}
                        ">
                            @csrf
                            @method('put')
                            <div class="col-12 col-md-9">
                                <label class="form-label" for="masse_salariale">Entreprise</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->raison_social_entreprises}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="masse_salariale">Masse salariale</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->masse_salariale}}"--}}
                                    disabled="disabled" />
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="form-label" for="intitule_action_formation_plan">Intituler de l'action de formation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    name="intitule_action_formation_plan"
{{--                                    value="{{@$infosactionplanformation->intitule_action_formation_plan}}" --}}
                                />
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pedagogique</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    name="objectif_pedagogique_fiche_agre"
{{--                                    value="{{@$infosactionplanformation->objectif_pedagogique_fiche_agre}}"--}}
                                />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="part_entreprise">Part entreprise</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->part_entreprise}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="structure_etablissement_action_">Structure ou etablissemnt de formation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->structure_etablissement_action_}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de stagiaires</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->nombre_stagiaire_action_formati}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupe</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->nombre_groupe_action_formation_}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->nombre_heure_action_formation_p}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" >Cout de la formation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->cout_action_formation_plan}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" >Type de formation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->type_formation}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="but_formation">But de la formation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->but_formation}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->date_debut_fiche_agrement}}"--}}
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->date_fin_fiche_agrement}}"--}}
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->lieu_formation_fiche_agrement}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="cout_total_fiche_agrement">Cout total fiche agrement</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->cout_total_fiche_agrement}}"--}}
                                    disabled="disabled" />
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadre</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->cadre_fiche_demande_agrement}}"--}}
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agent de maitrise</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->agent_maitrise_fiche_demande_ag}}"--}}
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employe / ouvriers</label>
                                <input
                                    type="number"
                                    class="form-control form-control-sm"
{{--                                    value="{{@$infosactionplanformation->employe_fiche_demande_agrement}}"--}}
                                    disabled="disabled" />
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="mb-1">
                                    <label>Facture proforma </label> <br>
                                    <span class="badge bg-secondary"><a target="_blank"
                                                            Voir la pièce  </a> </span>
                                </div>
                            </div>


                            <hr/>

                            <div class="col-md-6 col-12">
                                <label class="form-label" for="billings-country">Motif de non-financement <strong style="color:red;">(obligatoire si le montant accordé est egal a 0*)</strong></label>

                                <select class="form-select form-select-sm" data-allow-clear="true" name="motif_non_financement_action_formation" id="motif_non_financement_action_formation">
{{--                                        <?= $motif; ?>--}}
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label>Montant accorder <strong style="color:red;">*</strong>: </label>
                                    <input type="number" name="cout_accorde_action_formation" id="cout_accorde_action_formation" class="form-control form-control-sm"
{{--                                           value="{{@$infosactionplanformation->cout_accorde_action_formation}}"--}}
                                    >                            </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-1">
                                    <label>Commentaire <strong style="color:red;">*</strong>: </label>
                                    <textarea class="form-control form-control-sm"  name="commentaire_action_formation" id="commentaire_action_formation" rows="6">
{{--                                        {{@$infosactionplanformation->commentaire_action_formation}}--}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-12 text-center">
{{--                                    <?php if($plan_de_formation->flag_soumis_ct_plan_formation != true){?>--}}
{{--                                <button onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;' type="submit" name="action" value="Traiter_action_formation" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>--}}
{{--                                <?php } ?>--}}
                                <button
                                    type="reset"
                                    class="btn btn-label-secondary"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

{{--    @endforeach--}}
@endsection
