@if(auth()->user()->can('projetetude-create'))
@extends('layouts.backLayout.designadmin')
@section('content')

    @php($Module='Demandes')
    @php($titre='Liste des projets d\'études')
    @php($soustitre='Demande de projet d\'étude')
    @php($lien='projetetude')

    <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
        <span class="text-muted fw-light">
            <a href="{{route('dashboard')}}"> <i class="ti ti-home mb-2"></i>  Accueil </a> /
           <a href="{{route($lien)}}"> {{$Module}}</a> /  {{$titre}}</span>
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
                        <form method="POST" id="demandeProjetForm" class="form" action="{{ route($lien.'.store') }}">
                            @csrf
                        <div class="col-md-12 col-10">
                            <div class="row">
                                <div class="mb-1 col-md-12">
                                    <label>Titre du projet <span
                                            style="color:red;">*</span>
                                    </label>
                                    <input type="text" name="titre_projet"
                                           id="titre_projet"
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
                                              id="montant_demande_projet"
                                               class="form-control form-control-sm number">
                                    </div>

                                    <div class="mb-1 col-md-6">
                                        <label>Domaine du projet <span
                                                style="color:red;">*</span>
                                        </label>
                                        <select name="id_domaine_projet" class="select2 form-select-sm input-group" data-allow-clear="true">
                                            @foreach($domaine_formations as $domaine_formation)
                                                <option value="{{@$domaine_formation->id_domaine_formation}}">{{@$domaine_formation->libelle_domaine_formation}}</option>
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
                                               id="lieu_realisation_projet"
                                               class="form-control form-control-sm ">
                                    </div>

                                    <div class="mb-1 col-md-6">
                                        <label>Date prévisionnelle de démarrage
                                        </label>
                                        <input type="date" name="date_previsionnelle_demarrage_projet"
                                               id="date_previsionnelle_demarrage_projet"
                                               class="form-control form-control-sm ">
                                    </div>
                                </div>

                            </div>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label>Contexte ou Problèmes constatés <span
                                            style="color:red;">*</span></label>
                                    <div id="contexte_probleme" class="rounded-1">{{@$projet_etude->contexte_probleme_projet_etude}}</div>
                                    <input class="form-control" type="text" id="contexte_probleme_val" name="contexte_probleme"/>

                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label>Objectif Général <span
                                            style="color:red;">*</span> </label>
                                    <input class="form-control" type="text" id="objectif_general_val" name="objectif_general"/>
                                    <div id="objectif_general" class="rounded-1">{{@$projet_etude->objectif_general_projet_etude}}</div>

                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label>Objectifs spécifiques <span
                                            style="color:red;">*</span> </label>
                                    <input class="form-control" type="text" id="objectif_specifique_val" name="objectif_specifique"/>
                                    <div id="objectif_specifique" class="rounded-1">{{@$projet_etude->objectif_specifique_projet_etud}}</div>

                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label>Résultats attendus <span
                                            style="color:red;">*</span> </label>
                                    <input class="form-control" type="text" id="resultat_attendu_val" name="resultat_attendu"/>
                                    <div id="resultat_attendu" class="rounded-1">{{@$projet_etude->resultat_attendu_projet_etude}}</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label>Champ de l’étude <span
                                            style="color:red;">*</span></label>
                                    <input class="form-control" type="text" id="champ_etude_val" name="champ_etude"/>
                                    <div id="champ_etude" class="rounded-1">{{@$projet_etude->champ_etude_projet_etude}}</div>

                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label>Cible <span style="color:red;">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="cible_val" name="cible"/>
                                    <div id="cible" class="rounded-1">{{@$projet_etude->cible_projet_etude}}</div>
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
@section('js_perso')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/additional-methods.js')}}"></script>
    <script src="{{asset('assets/js/projetetudes/pages-demande-projet.js')}}"></script>
    <script type="text/javascript">
        //Initialisation des variable Quill
        var contexte_probleme = new Quill('#contexte_probleme',{theme: 'snow'});
        var objectif_general = new Quill('#objectif_general',{theme: 'snow'});
        var objectif_specifique = new Quill('#objectif_specifique',{theme: 'snow'});
        var resultat_attendu = new Quill('#resultat_attendu',{theme: 'snow'});
        var champ_etude = new Quill('#champ_etude',{theme: 'snow'});
        var cible = new Quill('#cible',{theme: 'snow'});

        //Hide All fields
        $("#contexte_probleme_val").hide();
        $("#objectif_general_val").hide();
        $("#objectif_specifique_val").hide();
        $("#resultat_attendu_val").hide();
        $("#champ_etude_val").hide();
        $("#cible_val").hide();

        //Submit form
        demandeProjetForm.onsubmit = function(){
            $("#contexte_probleme_val").val(contexte_probleme.root.innerHTML);
            $("#objectif_general_val").val(objectif_general.root.innerHTML);
            $("#objectif_specifique_val").val(objectif_specifique.root.innerHTML);
            $("#resultat_attendu_val").val(resultat_attendu.root.innerHTML);
            $("#champ_etude_val").val(champ_etude.root.innerHTML);
            $("#cible_val").val(cible.root.innerHTML);
        }
    </script>
@endsection
@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif

