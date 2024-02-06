@extends('layouts.backLayout.designadmin')
@section('content')

    @php($Module='Demandes')
    @php($titre='Liste des plans de formations')
    @php($soustitre='Demande de plan de formation')
    @php($lien='projetetude')

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
                            class="nav-link active"
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
                            class="nav-link  disabled"
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
                    <div class="tab-pane fade show active" id="navs-top-infoprojetetude" role="tabpanel">
                        <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                            @csrf
                        <div class="col-md-12 col-10">
                            <div class="row">
                                <div class="mb-1 col-md-6">
                                    <label>Titre du projet <span
                                            style="color:red;">*</span>
                                    </label>
                                    <input type="text" name="titre_projet"
                                           required="required" id="titre_projet"
                                           class="form-control form-control-sm">
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

                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Contexte ou Problèmes constatés <span
                                            style="color:red;">*</span></label>
                                    <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                              name="contexte_probleme" style="height: 121px;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Objectif Général <span
                                            style="color:red;">*</span> </label>
                                    <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                              name="objectif_general" style="height: 121px;"></textarea>

                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Objectifs spécifiques <span
                                            style="color:red;">*</span> </label>
                                    <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                              name="objectif_specifique" style="height: 121px;"></textarea>

                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Résultats attendus <span
                                            style="color:red;">*</span> </label>
                                    <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                              name="resultat_attendu" style="height: 121px;"></textarea>

                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Champ de l’étude <span
                                            style="color:red;">*</span></label>
                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="champ_etude"
                                              style="height: 121px;" required="required"></textarea>

                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Cible <span style="color:red;">*</span>
                                    </label>
                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="cible" style="height: 121px;"
                                              required="required"></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="col-12" align="right">
                            <hr>
                            <button type="submit" name="action" value="Enregister"
                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                Enregister
                            </button>
                            <button type="submit" name="action" value="Enregistrer_suivant"
                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                Suivant
                            </button>
                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                Retour</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


