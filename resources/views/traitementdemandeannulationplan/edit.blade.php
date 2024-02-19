<?php
    /*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{

	}*/
?>

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Plan de formation')
    @php($titre='Liste des plans de formations')
    @php($soustitre='Traitement de la demande de plan de formation')
    @php($lien='traitementdemandeannulationplan')


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

             @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
        <div class="col-xl-12">
                    <div align="right" class="mb-3">
                        <button type="button"
                                class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#modalToggle">
                            Voir le parcours de validation
                        </button>
                    </div>
                  <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        @isset($demande_annulation->id_action_plan)
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-actionformation"
                                    aria-controls="navs-top-actionformation"
                                    aria-selected="true">
                                    Action de formation
                                </button>
                            </li>
                                <li class="nav-item">
                                    <button
                                        type="button"
                                        class="nav-link active"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-top-demande-annulation-action"
                                        aria-controls="navs-top-demande-annulation-action"
                                        aria-selected="false">
                                        Traitement de la demande d'annulation de l'action
                                    </button>
                                </li>
                            @endisset
                            @isset($demande_annulation->id_plan_formation)
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


                            <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-histortiqueactionformation"
                          aria-controls="navs-top-histortiqueactionformation"
                          aria-selected="false">
                          Historiques des actions du plan de formation
                        </button>
                      </li>
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
                                data-bs-target="#navs-top-demande-annulation"
                                aria-controls="navs-top-demande-annulation"
                                aria-selected="false">
                                Traitement de la demande d'annulation plan
                            </button>
                        </li>
                            @endisset
                    </ul>
                    <div class="tab-content">
                        @isset($demande_annulation->id_action_plan)
                            <div class="tab-pane fade" id="navs-top-actionformation" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 col-md-9">
                                        <label class="form-label" for="masse_salariale">Entreprise</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->raison_social_entreprises}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="masse_salariale">Masse salariale</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->masse_salariale}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <label class="form-label" for="intitule_action_formation_plan">Intituler de l'action de formation</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->intitule_action_formation_plan}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->objectif_pedagogique_fiche_agre}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="part_entreprise">Part entreprise</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->part_entreprise}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="structure_etablissement_action_">Structure ou établissement de formation</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->structure_etablissement_action_}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de stagiaires</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->nombre_stagiaire_action_formati}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupes</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->nombre_groupe_action_formation_}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->nombre_heure_action_formation_p}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" >Coût de la formation</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->cout_action_formation_plan}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" >Type de formation</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->type_formation}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="but_formation">But de la formation</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->but_formation}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="date_debut_fiche_agrement">Date début de réalisation</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->date_debut_fiche_agrement}}"
                                            disabled="disabled"/>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="date_fin_fiche_agrement">Date fin de réalisation</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->date_fin_fiche_agrement}}"
                                            disabled="disabled"/>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->lieu_formation_fiche_agrement}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="cout_total_fiche_agrement">Cout total fiche agrément</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->cout_total_fiche_agrement}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->cadre_fiche_demande_agrement}}"
                                            disabled="disabled"/>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->agent_maitrise_fiche_demande_ag}}"
                                            disabled="disabled"/>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->employe_fiche_demande_agrement}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="cout_accorde_action_formation">Montant accordé</label>
                                        <input
                                            type="number"
                                            class="form-control form-control-sm"
                                            value="{{@$infosactionplanformation->cout_accorde_action_formation}}"
                                            disabled="disabled" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="mb-1">
                                            <label>Facture proforma </label> <br>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                                                onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $infosactionplanformation->facture_proforma_action_formati)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="navs-top-demande-annulation-action" role="tabpanel">
                                        <div class="col-md-12" align="center">
                                            <h6 class="card-title mb-3"> Détail de la demande d'annulation</h6>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <div class="mb-1">
                                                                <label> Motif de la demande d'annulation du plan</label>
                                                                <select  class="select2 form-select-sm input-group" disabled name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >
                                                                    @foreach($action_motifs as $motif)
                                                                        <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>
                                                                    @endforeach
                                                                </select>
                                                                {{--                                                  <input class="form -control" type="text"--}}
                                                                {{--                                                         disabled @isset($demande_annulation->motif_demande_annulation_plan)value="{{$demande_annulation->motif_demande_annulation_plan}}" @endisset />--}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <label class="form-label">Pièce justificatif
                                                                de la demande d'annulation</label>
                                                            <br>
                                                            @isset($demande_annulation->piece_demande_annulation_plan)
                                                                <span class="badge bg-secondary"> <a target="_blank"
                                                                                                     onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                          Voir la pièce  </a></span>
                                                                <div id="defaultFormControlHelp" class="form-text ">
                                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                        maxi : 5Mo</em>
                                                                </div>


                                                            @endisset
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-1">
                                                        <label> Commentaire de la demande d'annulation du plan</label>
                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                                  style="height: 121px;" disabled>@isset($demande_annulation->commentaire_demande_annulation_plan) {{$demande_annulation->commentaire_demande_annulation_plan}} @endisset</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3" align="center">
                                            <h6 class="card-title mt-3"> Traitement de la demande d'annulation</h6>
                                        </div>
                                        <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($demande_annulation->id_demande_annulation_plan)) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id2) }}"/>
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>
                                                        @if($parcoursexist->count()<1)
                                                            <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                                        @else
                                                            <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12" align="right">
                                                    <hr>
                                                        <?php if(count($parcoursexist)<1){?>
                                                    <button type="submit" name="action" value="Valider"
                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                                        Valider
                                                    </button>
                                                    <button type="submit" name="action" value="Rejeter"
                                                            class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                                        Rejeter
                                                    </button>
                                                    <?php } ?>
                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                       href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                        @endisset


                    @isset($demande_annulation->id_plan_formation)

                        <div class="tab-pane fade" id="navs-top-planformation" role="tabpanel">

                      <form method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>N° de compte contribuable </label>
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
                                        <label>Activité </label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->activite->libelle_activites}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Localisation geaographique </label>
                                        <input type="text" name="localisation_geographique_entreprise" id="localisation_geographique_entreprise"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->localisation_geographique_entreprise}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Repère d'accès </label>
                                        <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->repere_acces_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Adresse postal </label>
                                        <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->adresse_postal_entreprises}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Adresse postal </label>
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
                                                <label class="form-label">Telephone  </label>
                                                <input type="text"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->tel_entreprises}}" disabled="disabled">
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
                                                <label class="form-label">Cellulaire Professionnelle  </label>
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

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Nom et prenom du responsable formation </label>
                                        <input type="text" name="nom_prenoms_charge_plan_formati" id="nom_prenoms_charge_plan_formati"
                                               class="form-control form-control-sm" value="{{@$planformation->nom_prenoms_charge_plan_formati}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Fonction du responsable formation </label>
                                        <input type="text" name="fonction_charge_plan_formation" id="fonction_charge_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->fonction_charge_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Email professsionel du responsable formation </label>
                                        <input type="email" name="email_professionnel_charge_plan_formation" id="email_professionnel_charge_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->email_professionnel_charge_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Nombre total de salarié </label>
                                        <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->nombre_salarie_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Type entreprises </label>
                                        <select class="select2 form-select-sm input-group" name="id_type_entreprise" id="id_type_entreprise" disabled="disabled">
                                            <?php echo $typeentreprise; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Masse salariale </label>
                                        <input type="number" name="masse_salariale" id="masse_salariale"
                                               class="form-control form-control-sm" value="{{@$planformation->masse_salariale}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Part entreprise </label>
                                        <input type="text" name="part_entreprise" id="part_entreprise"
                                               class="form-control form-control-sm" value="{{@$planformation->part_entreprise}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Code plan </label>
                                        <input type="text" name="code_plan_formation" id="code_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->code_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-12" align="right">
                                    <hr>


                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                        Retour</a>
                                </div>
                            </div>
                        </form>

                      </div>
                        @endisset
                            @isset($demande_annulation->id_plan_formation)

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
                            <?php $i = 0; ?>
                                @foreach ($categorieplans as $key => $categorieplan)
                                <?php $i += 1;?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $categorieplan->categorieProfessionelle->categorie_profeessionnelle }}</td>
                                                <td>{{ $categorieplan->genre_plan }}</td>
                                                <td>{{ $categorieplan->nombre_plan }}</td>

                                            </tr>
                                @endforeach

                            </tbody>
                        </table>
                      </div>

                            @endisset
                            @isset($demande_annulation->id_plan_formation)

                     <div class="tab-pane fade" id="navs-top-histortiqueactionformation" role="tabpanel">

                        <div class="col-12" align="right">


                        </div>
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
                            <?php $i = 0; ?>


                            </tbody>
                        </table>
                      </div>
                            @endisset
                            @isset($demande_annulation->id_plan_formation)

                      <div class="tab-pane fade" id="navs-top-actionformation" role="tabpanel">

                        <div class="col-12" align="right">

                            <?php if($nombreaction == $nombreactionvalider and $planformation->flag_soumis_ct_plan_formation != true){?>
                                <form method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}">
                                    @csrf
                                    @method('put')
                                    <button type="submit" name="action" value="Soumission_ct_plan_formation"
                                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Valider le plan de formation
                                    </button>
                                </form>
                            <?php } ?>
                        </div>
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
                            <?php $i = 0; ?>
                                @foreach ($actionplanformations as $key => $actionplanformation)
                                <?php $i += 1;?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $actionplanformation->intitule_action_formation_plan }}</td>
                                                <td>{{ $actionplanformation->structure_etablissement_action_ }}</td>
                                                <td>{{ $actionplanformation->nombre_stagiaire_action_formati }}</td>
                                                <td>{{ $actionplanformation->nombre_groupe_action_formation_ }}</td>
                                                <td>{{ $actionplanformation->nombre_heure_action_formation_p }}</td>
                                                <td>{{ $actionplanformation->cout_action_formation_plan }}</td>
                                                <td>{{ $actionplanformation->cout_accorde_action_formation }}</td>
                                            </tr>
                                @endforeach

                            </tbody>
                        </table>
                      </div>
                            @endisset
                            @isset($demande_annulation->id_plan_formation)
                            <div class="tab-pane fade show active" id="navs-top-demande-annulation" role="tabpanel">

                          <div class="col-md-12">
                              <h6 class="card-title mb-3" align="center"> Détail de la demande d'annulation</h6>
                          </div>
                          <div class="col-md-12">
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="row">
                                          <div class="col-md-12 mb-3">
                                              <div class="mb-1">
                                                  <label> Motif de la demande d'annulation du plan</label>
                                                  <select  class="select2 form-select-sm input-group" disabled name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >
                                                      @foreach($motifs as $motif)
                                                          <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>
                                                      @endforeach
                                                  </select>
{{--                                                  <input class="form -control" type="text"--}}
{{--                                                         disabled @isset($demande_annulation->motif_demande_annulation_plan)value="{{$demande_annulation->motif_demande_annulation_plan}}" @endisset />--}}
                                              </div>
                                          </div>
                                          <div class="col-md-12 mt-3">
                                              <label class="form-label">Pièce justificatif
                                                  de la demande d'annulation</label>
                                              <br>
                                              @isset($demande_annulation->piece_demande_annulation_plan)
                                                  <span class="badge bg-secondary"> <a target="_blank"
                                                                                       onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                          Voir la pièce  </a></span>

                                                  <div id="defaultFormControlHelp" class="form-text ">
                                                      <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                          maxi : 5Mo</em>
                                                  </div>
                                              @endisset
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="mb-1">
                                          <label> Commentaire de la demande d'annulation du plan</label>
                                          <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                    style="height: 121px;" disabled>@isset($demande_annulation->commentaire_demande_annulation_plan) {{$demande_annulation->commentaire_demande_annulation_plan}} @endisset</textarea>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-12 mb-3" align="center">
                              <h6 class="card-title mt-3"> Traitement de la demande d'annulation</h6>
                          </div>
                          <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($demande_annulation->id_demande_annulation_plan)) }}" enctype="multipart/form-data">
                              @csrf
                              @method('put')
                              <div class="row">
                                  <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id2) }}"/>
                                  <div class="col-md-12 col-12">
                                      <div class="mb-1">
                                          <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>
                                          @if($parcoursexist->count()<1)
                                              <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                          @else
                                              <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                          @endif
                                      </div>
                                  </div>
                                  <div class="col-12" align="right">
                                      <hr>
                                      <?php if(count($parcoursexist)<1){?>
                                      <button type="submit" name="action" value="Valider"
                                              class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                          Valider
                                      </button>
                                      <button type="submit" name="action" value="Rejeter"
                                              class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                          Rejeter
                                      </button>
                                      <?php } ?>
                                      <a class="btn btn-sm btn-outline-secondary waves-effect"
                                         href="/{{$lien }}">
                                          Retour</a>
                                  </div>
                              </div>
                          </form>
                      </div>
                            @endisset

                            <div class="col-md-4 col-12">
                                <div class="modal animate__animated animate__fadeInDownBig fade" id="modalToggle"
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
                                            <h5 class="card-header">Parcours de la demande d'annulation du plan de formation</h5>
                                            <div class="card-body pb-2">
                                                <ul class="timeline pt-3">
                                                    @foreach ($ResultProssesList as $res)
                                                        <li class="timeline-item pb-4 timeline-item-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                            <span class="timeline-indicator-advanced timeline-indicator-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                              <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                            </span>
                                                            <div class="timeline-event">
                                                                <div class="timeline-header border-bottom mb-3">
                                                                    <h6 class="mb-0">{{ $res->priorite_combi_proc }}</h6>
                                                                    <span class="text-muted"><strong>{{ $res->name }}</strong></span>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                                                    <div class="d-flex align-items-center">
                                                                        @if($res->is_valide==true)
                                                                            <div class="row ">
                                                                                <div>
                                                                                    <span>Observation : {{ $res->comment_parcours }}</span>
                                                                                </div>
                                                                                <div>
                                                                                    <span>Validé le  {{ $res->date_valide }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($res->is_valide===false)
                                                                            <div class="row">
                                                                                <div>
                                                                                    <span>Observation : {{ $res->comment_parcours }}</span>
                                                                                </div>
                                                                                <div>
                                                                                    <span class="badge bg-label-danger">Validé le {{ $res->date_valide }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                  </div>
                </div>
    </div>


    <!-- Edit User Modal -->
          @foreach($infosactionplanformations as $infosactionplanformation)
            <div class="modal fade" id="traiterActionFomationPlan<?php echo $infosactionplanformation->id_action_formation_plan ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-simple modal-edit-user">
                  <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                        <h3 class="mb-2">Traitement d'une action de plan de formation</h3>
                        <p class="text-muted"></p>
                      </div>
                      <form id="editUserForm" class="row g-3" method="POST" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan)) }}">
                            @csrf
                            @method('put')
                        <div class="col-12 col-md-9">
                          <label class="form-label" for="masse_salariale">Entreprise</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->raison_social_entreprises}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="masse_salariale">Masse salariale</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->masse_salariale}}"
                            disabled="disabled" />
                        </div>

                        <div class="col-12 col-md-12">
                          <label class="form-label" for="intitule_action_formation_plan">Intituler de l'action de formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            name="intitule_action_formation_plan"
                            value="{{@$infosactionplanformation->intitule_action_formation_plan}}" />
                        </div>
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pedagogique</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              name="objectif_pedagogique_fiche_agre"
                              value="{{@$infosactionplanformation->objectif_pedagogique_fiche_agre}}"
                               />
                          </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="part_entreprise">Part entreprise</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              value="{{@$infosactionplanformation->part_entreprise}}"
                              disabled="disabled" />
                          </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="structure_etablissement_action_">Structure ou etablissemnt de formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->structure_etablissement_action_}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de stagiaires</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->nombre_stagiaire_action_formati}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupe</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->nombre_groupe_action_formation_}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->nombre_heure_action_formation_p}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" >Cout de la formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->cout_action_formation_plan}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" >Type de formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->type_formation}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="but_formation">But de la formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->but_formation}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->date_debut_fiche_agrement}}"
                            disabled="disabled"/>
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->date_fin_fiche_agrement}}"
                            disabled="disabled"/>
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->lieu_formation_fiche_agrement}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="cout_total_fiche_agrement">Cout total fiche agrement</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->cout_total_fiche_agrement}}"
                            disabled="disabled" />
                        </div>

                        <div class="col-12 col-md-3">
                          <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadre</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->cadre_fiche_demande_agrement}}"
                            disabled="disabled"/>
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agent de maitrise</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->agent_maitrise_fiche_demande_ag}}"
                            disabled="disabled"/>
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employe / ouvriers</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->employe_fiche_demande_agrement}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                    <label>Facture proforma </label> <br>
                                                            <span class="badge bg-secondary"><a target="_blank"
                                                            onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $infosactionplanformation->facture_proforma_action_formati)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                                </div>
                        </div>


                        <hr/>

                        <div class="col-md-6 col-12">
                            <label class="form-label" for="billings-country">Motif de non-financement <strong style="color:red;">(obligatoire si le montant accordé est egal a 0*)</strong></label>

                            <select class="form-select form-select-sm" data-allow-clear="true" name="motif_non_financement_action_formation" id="motif_non_financement_action_formation">
                                <?= $motif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label>Montant accorder <strong style="color:red;">*</strong>: </label>
                                <input type="number" name="cout_accorde_action_formation" id="cout_accorde_action_formation" class="form-control form-control-sm" value="{{@$infosactionplanformation->cout_accorde_action_formation}}">                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-1">
                                <label>Commentaire <strong style="color:red;">*</strong>: </label>
                                <textarea class="form-control form-control-sm"  name="commentaire_action_formation" id="commentaire_action_formation" rows="6">{{@$infosactionplanformation->commentaire_action_formation}}</textarea>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                        <?php if($planformation->flag_soumis_ct_plan_formation != true){?>
                          <button onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;' type="submit" name="action" value="Traiter_action_formation" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
                          <?php } ?>
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
          @endforeach


            <div id='myModal' class='modal fade' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div id='modal-content'>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $('#btnChange').click(function (eve) {
                    var url = "/DeviceLocation/ChangeLocation?deviceID=" + $(this).data("id");
                    alert(url);
                    $("#modal-content").load(url, function () {
                        $("#myModal").modal("show");
                    });
                })
            </script>

        @endsection

