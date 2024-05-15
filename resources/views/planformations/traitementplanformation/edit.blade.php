<?php
use App\Helpers\ListePlanFormationSoumis;
?>
@if(auth()->user()->can('traitementplanformation-edit'))
@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Plan de formation')
    @php($titre='Liste des plans de formations')
    @php($soustitre='Instruction')
    @php($lien='traitementplanformation')
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
        @if($message = Session::get('error'))
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
                          data-bs-target="#navs-top-planformation"
                          aria-controls="navs-top-planformation"
                          aria-selected="true">
                          Informations sur l'entreprise
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
                          Nombre de salariés déclarés à la CNPS
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?php if($planformation->flag_recevablite_plan_formation==true){ echo "active";} ?>"
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
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-histortiqueactionformation"
                          aria-controls="navs-top-histortiqueactionformation"
                          aria-selected="false">
                          Historiques des actions des plans de formation
                        </button>
                      </li>
                      <?php if($planformation->flag_recevablite_plan_formation!=true){ ?>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link <?php if($planformation->flag_recevablite_plan_formation!=true){ echo "active";}else{ echo "disabled";} ?>"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-recevabilite"
                            aria-controls="navs-top-recevabilite"
                            aria-selected="false">
                            Recevabilité
                            </button>
                        </li>
                      <?php } ?>
                    </ul>
                    <div class="tab-content">
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
                                        <label>Localisation géographique </label>
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
                                        <label>Adresse postale </label>
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
                                                <label class="form-label">Téléphone  </label>
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
                                        <label>Type entreprises </label>
                                        <select class="select2 form-select-sm input-group" name="id_type_entreprise" id="id_type_entreprise" disabled="disabled">
                                            <?php echo $typeentreprise; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Nom et prénoms du responsable formation </label>
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
                                        <label>Email professionnel du responsable formation </label>
                                        <input type="email" name="email_professionnel_charge_plan_formation" id="email_professionnel_charge_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->email_professionnel_charge_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Contact du responsable formation <strong style="color:red;">*</strong> </label>
                                        <input type="text" name="contact_professionnel_charge_plan_formation" id="contact_professionnel_charge_plan_formation"
                                            class="form-control form-control-sm" value="{{@$planformation->contact_professionnel_charge_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Nombre de salariés déclarés à la CNPS </label>
                                        <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->nombre_salarie_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Masse salariale brute annuelle prévisionnelle </label>
                                        <input type="text" name="masse_salariale" id="masse_salariale"
                                               class="form-control form-control-sm number" value="{{number_format(@$planformation->masse_salariale, 0, ',', ' ')}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="mb-1">

                                        <label>Part entreprise ({{ @$planformation->partEntreprise->valeur_part_entreprise }})</label>
                                        <input type="text" name="part_entreprise" id="part_entreprise"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->part_entreprise, 0, ',', ' ')}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="mb-1">

                                        <label>Part entreprise determinée</label>
                                        <input type="text" name="part_entreprise_previsionnel" id="part_entreprise_previsionnel"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->part_entreprise_previsionnel, 0, ',', ' ')}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="mb-1">

                                        <label>Budget de financement </label>
                                        <input type="text" name="montant_financement_budget" id="montant_financement_budget"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->montant_financement_budget, 0, ',', ' ')}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="mb-1">

                                        <label>Code plan </label>
                                        <input type="text" name="code_plan_formation" id="code_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->code_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="mb-1">

                                        <label>Le coût demandé </label>
                                        <input type="text" name="cout_total_demande_plan_formation" id="cout_total_demande_plan_formation"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->cout_total_demande_plan_formation, 0, ',', ' ')}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="mb-1">

                                        <label>Le coût accordé </label>
                                        <input type="text" name="cout_total_accorder_plan_formation" id="cout_total_accorder_plan_formation"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->cout_total_accorder_plan_formation, 0, ',', ' ')}}" disabled="disabled">
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


                     <div class="tab-pane fade" id="navs-top-histortiqueactionformation" role="tabpanel">

                        <div class="col-12" align="right">


                        </div>
                        <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Intitulé de l'action de formation </th>
                                <th>Structure ou établissement de formation</th>
                                <th>Coût de l'action</th>
                                <th>Coût de financement</th>
                                <th>Coût de l'action accordée</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @foreach ($historiquesplanformations as $historiquesplanformation)
                            <?php $i += 1;?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $historiquesplanformation->intitule_action_formation_plan }}</td>
                                <td>{{ $historiquesplanformation->structure_etablissement_action_ }}</td>
                                <td>{{ number_format($historiquesplanformation->cout_action_formation_plan, 0, ',', ' ') }}</td>
                                <td>{{ number_format($historiquesplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}</td>
                                <td>{{ number_format($historiquesplanformation->cout_accorde_action_formation, 0, ',', ' ') }}</td>

                                <td align="center">

                                        <a onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($historiquesplanformation->id_action_formation_plan)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                           class=" "
                                           title="Modifier"><img src='/assets/img/eye-solid.png'></a>  &nbsp;

                                </td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                      </div>

                      <div class="tab-pane fade <?php if($planformation->flag_recevablite_plan_formation==true){ echo "show active";} ?>" id="navs-top-actionformation" role="tabpanel">
                        <?php if($nombreaction == $nombreactionvalider and $planformation->flag_soumis_ct_plan_formation != true){?>
                        <div class="row">
                            @if (isset($planformation->commentaire_plan_formation))
                        <div class="col-3">
                            <form method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}">
                                @csrf
                                @method('put')
                                <button onclick='javascript:if (!confirm("Le plan de formation sera soumis au comite technique  ? . Cette action est irréversible.")) return false;' type="submit" name="action" value="Soumission_ct_plan_formation"
                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                Soumettre pour le comite
                                </button>
                            </form>
                            </div>
                            @endif
                        <div class="col-9" align="right">


                                @if (!isset($planformation->commentaire_plan_formation))
                                    <div class="col-6">
                                    </div>
                                    <div class="col-3">
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#inlineForm">
                                            Ajouter un commentaire
                                        </button>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-6">
                                        </div>
                                        <div class="col-3">
                                        </div>
                                        <div class="col-3">
                                        <button type="button" class="btn rounded-pill btn-outline-primary waves-effect waves-light btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#modalToggle">
                                            Voir le commentaire
                                        </button>
                                        </div>

                                    </div>
                                @endif

                        </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-4 col-12">
                            <div class="modal animate__animated animate__fadeInDownBig fade" id="modalToggle"
                                aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel">Commentaire </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="card">
                                            <h5 class="card-header">Commentaire</h5>
                                            <div class="card-body pb-2">
                                                <ul class="timeline pt-3">

                                                    <li class="timeline-item pb-4 timeline-item-success border-left-dashed">
                                                        <span class="timeline-indicator-advanced timeline-indicator-success">
                                                            <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                        </span>
                                                        <div class="timeline-event">

                                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                                <div class="d-flex align-items-center">

                                                                    <span>Fait le </span>

                                                                    <span class="badge bg-label-danger"><?php echo @$planformation->date_commentaire_plan_formation; ?></span>
                                                                </div>
                                                                <div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <?php echo @$planformation->commentaire_plan_formation; ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>

                                                </li>


                                                </ul>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                        class="modal fade text-start"
                        id="inlineForm"
                        tabindex="-1"
                        aria-labelledby="myModalLabel33"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel33">Ajouter un commentaire</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}" enctype="multipart/form-data" id="commentaireplanformationForm">
                                @csrf
                                @method('put')
                                <div class="modal-body">
                                <div class="col-md-12 mb-5">
                                    <textarea class="form-control form-control-sm"  name="commentaire_plan_formation" id="commentaire_plan_formation" rows="6" >{{@$planformation->commentaire_plan_formation}}</textarea>
                                   @error('commentaire_plan_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="action" value="CommentairePlanFormation" class="btn btn-primary" data-bs-dismiss="modal">Ajouter</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                        <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Intitulé de l'action de formation </th>
                                <th>Structure ou établissement de formation</th>
                                <th>Coût de l'action</th>
                                <th>Coût de financement</th>
                                <th>Coût de l'action accordée</th>
                                <th>Utilisation direct</th>
                                <th>Finan. complémentaire</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                                @foreach ($actionplanformations as $key => $actionplanformation)

                                <?php
                                //dd($actionplanformation);
                                $i += 1;
                                ?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $actionplanformation->intitule_action_formation_plan }}</td>
                                                <td>{{ $actionplanformation->structure_etablissement_action_ }}</td>
                                                <td>{{ number_format($actionplanformation->cout_action_formation_plan, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($actionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($actionplanformation->cout_accorde_action_formation, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($actionplanformation->utilisation_direct_action_formation, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($actionplanformation->finan_complemantaire_action_formation, 0, ',', ' ') }}</td>
                                                <td>
                                                    @if(@$actionplanformation->flag_action_formation_plan_traite_instruction ==true)
                                                        <span class="badge bg-success">Traité</span>
                                                    @else
                                                        <span class="badge bg-warning">En attente de traitement</span>
                                                    @endif
                                                </td>
                                                <td align="center" nowrap="nowrap">
                                                    @can($lien.'-edit')
                                                        <a onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                           class=" "
                                                           title="Modifier"><img src='/assets/img/eye-solid.png'></a>  &nbsp;
                                                           <?php if($planformation->flag_recevablite_plan_formation==true){ ?>
                                                                    <a type="button"
                                                                    class="traiterActionFomationPlan" data-bs-toggle="modal" data-id="{{\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)}}"
                                                                       data-bs-target="#traiterActionFomationPlan"
                                                                       href="#">
                                                                        <img src='/assets/img/editing.png'>
                                                                    </a>
                                                                    <a type="button"
                                                                    class="" data-bs-toggle="modal" data-bs-target="#traiterBeneficiaire<?php  echo $actionplanformation->id_fiche_agrement; ?>" href="#myModal11" data-url="http://example.com">
                                                                        <img src='/assets/img/display.png'>
                                                                    </a>
                                                            <?php } ?>
                                                    @endcan

                                                </td>
                                            </tr>
                                @endforeach

                            </tbody>
                        </table>
                      </div>
                      <div class="tab-pane fade <?php if($planformation->flag_recevablite_plan_formation!=true){ echo "show active";} ?>" id="navs-top-recevabilite" role="tabpanel">

                      <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                            <div class="col-md-6 col-12">
                                                    <label class="form-label" for="billings-country">Les motifs d'irrecevabilité <strong style="color:red;">(Obligatoire si non recevable)*</strong></label>

                                                        <select class="select2 form-select input-group" data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">
                                                            <?= $motif; ?>
                                                        </select>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire Recevabilité <strong style="color:red;">(Obligatoire si non recevable)*</strong>: </label>
                                                        <textarea class="form-control form-control-sm"  name="commentaire_recevable_plan_formation" id="commentaire_recevable_plan_formation" rows="6">{{@$planformation->commentaire_recevable_plan_formation}}</textarea>
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
                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                    href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                        <!--<div class="col-12 col-md-2" align="right"> <br>
                                            <button  type="submit" name="action" value="Enregistrer_categorie_plan" class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>
                                        </div>-->

                                </div>



                        </form>




                      </div>
                      <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

                      </div>
                    </div>
                  </div>
                </div>
    </div>
    <?php //dd($infosactionplanformationsficheagrements); ?>
    <!-- Edit User Modal -->
{{--          @foreach($infosactionplanformations as $key=>$infosactionplanformation)--}}
{{--              <?php $key = $key+1 ?>--}}
            <div class="modal fade" id="traiterActionFomationPlan" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-simple modal-edit-user">
                  <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                        <h3 class="mb-2">Traitement d'une action de plan de formation</h3>
                        <p class="text-muted"></p>
                      </div>
                        <form id="" class="row g-3 actionformationForm" method="POST" action="">
{{--                            <form id="" class="row g-3 actionformationForm" method="POST" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan)) }}">--}}
{{--                            @csrf--}}
{{--                            @method('put')--}}

                            <div class="col-12 col-md-3">
                                <label class="form-label" for="montant_financement_budget"><strong style="color:green;">Budget crédit</strong></label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm" id="montant_financement_budget"
                                    value="{{ number_format(@$planformation->montant_financement_budget, 0, ',', ' ') }}"
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="montantactionplanformation"><strong style="color:red;">Budget crédit sollicité</strong></label>
                                <input
                                    type="text" id="montantactionplanformation"
                                    class="form-control form-control-sm"
                                    value="{{ number_format($montantactionplanformation, 0, ',', ' ') }}"
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="montantactionplanformationacc"><strong style="color:blue;">Budget crédit accordé</strong></label>
                                <input
                                    type="text" id="montantactionplanformationacc"
                                    class="form-control form-control-sm"
                                    value="{{ number_format($montantactionplanformationacc, 0, ',', ' ') }}"
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nombre_stagiaire_action_formati"><strong style="color:orange;">Budget crédit restant</strong></label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ number_format(@$planformation->montant_financement_budget-$montantactionplanformationacc, 0, ',', ' ') }}"
                                    disabled="disabled"/>
                            </div>
                        <div class="col-12 col-md-9">
                          <label class="form-label" for="raison_social_entreprises">Entreprise</label>
                          <input
                            type="text" id="raison_social_entreprises"
                            class="form-control form-control-sm"
{{--                            value="{{@$infosactionplanformation->raison_social_entreprises}}"--}}
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="masse_salariale">Masse salariale</label>
                          <input
                            type="text" id="masse_salariale_ins"
                            class="form-control form-control-sm number"
                            disabled="disabled" />
                        </div>

                        <div class="col-12 col-md-12">
                          <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de formation</label>
                          <input
                            type="text" id="intitule_action_formation_plan"
                            class="form-control form-control-sm"
                            name="intitule_action_formation_plan"
                          />
                        </div>
                        <div class="col-md-12 mb-5">
                            <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>
                            <input class="form-control objectif_pedagogique_fiche_agre_val @error('objectif_pedagogique_fiche_agre') error @enderror" type="text" id="" name="objectif_pedagogique_fiche_agre"/>
                            <div id="objectif_pedagogique_fiche_agre" class="rounded-1 objectif_pedagogique_fiche_agre"></div>
                           @error('objectif_pedagogique_fiche_agre')
                            <div class=""><label class="error">{{ $message }}</label></div>
                            @enderror
                        </div>



                        <div class="col-12 col-md-4">
                          <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupes</label>
                          <input
                            type="number" id="nombre_groupe_action_formation_"
                            class="form-control form-control-sm"
                            name="nombre_groupe_action_formation_"
                          />
                        </div>
                        <div class="col-12 col-md-4">
                          <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes</label>
                          <input
                            type="number" id="nombre_heure_action_formation_p"
                            class="form-control form-control-sm"
                            name="nombre_heure_action_formation_p"
                          />
                        </div>



                        <div class="col-12 col-md-4">
                            <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres</label>
                            <input
                              type="number" id="cadre_fiche_demande_agrement"
                              class="form-control form-control-sm"
                              name="cadre_fiche_demande_agrement"
                            />
                          </div>
                          <div class="col-12 col-md-4">
                            <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maîtrise</label>
                            <input
                              type="number" id="agent_maitrise_fiche_demande_ag"
                              class="form-control form-control-sm"
                              name="agent_maitrise_fiche_demande_ag"
                            />
                          </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers</label>
                            <input
                              type="number" id="employe_fiche_demande_agrement"
                              class="form-control form-control-sm"
                              name="employe_fiche_demande_agrement"
                            />
                          </div>
                          <div class="col-12 col-md-4">
                            <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>
                            <select
                                id="id_type_formation"
                                name="id_type_formation"
                                class="select2 form-select-sm input-group @error('id_type_formation')
                                error
                                @enderror"

                                aria-label="Default select example">
                                @foreach ($typeformationss as $typeformation)
                                    <option value="{{$typeformation->id_type_formation}}">{{mb_strtoupper($typeformation->type_formation)}}</option>
                                @endforeach

                            </select>
                            @error('id_type_formation')
                            <div class=""><label class="error">{{ $message }}</label></div>
                            @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label" for="id_caracteristique_type_formation">Caractéristique type de formation <strong style="color:red;">*</strong></label>
                                <select id="id_caracteristique_type_formation" name="id_caracteristique_type_formation" class="select2 form-select-sm input-group @error('id_caracteristique_type_formation')
                                error
                                @enderror">
{{--                                    @foreach ($infoscaracteristique as $infoscaracte)--}}
{{--                                        <option value="{{$infoscaracte->id_caracteristique_type_formation}}">{{mb_strtoupper($infoscaracte->libelle_ctf)}}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                                @error('id_caracteristique_type_formation')
                                <div class=""><label class="error">{{ $message }}</label></div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12 col-md-10">
                                        <label class="form-label" for="structure_etablissement_action_">Etablissement de formation <strong style="color:red;">*</strong></label>

                                        <select class="select2 form-select-sm input-group @error('id_entreprise_structure_formation_plan_formation')
                                        error
                                        @enderror" name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation">
                                        </select>
                                        @error('id_entreprise_structure_formation_plan_formation')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <br>
                                        <button type="button" id="Activeajoutercabinetformation"
                                        class="btn btn-icon btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#Ajoutercabinetformation" href="#myModal1" data-url="http://example.com">
                                            <span class="ti ti-plus"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12" id="id_domaine_formation_div">
                                <label>Domaine de formation <strong style="color:red;">*</strong></label>
                                <select class="select2 form-select-sm input-group @error('id_domaine_formation')
                                error
                                @enderror"
                                                data-allow-clear="true" name="id_domaine_formation"
                                                id="id_domaine_formation">
                                </select>
                                @error('id_domaine_formation')
                                <div class=""><label class="error">{{ $message }}</label></div>
                                @enderror
                            </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>
                            <input
                                type="text"
                                id="lieu_formation_fiche_agrement"
                                name="lieu_formation_fiche_agrement"
                                class="form-control form-control-sm @error('lieu_formation_fiche_agrement')
                                error
                                @enderror"
                                 />
                                 @error('lieu_formation_fiche_agrement')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-1">
                                    <label class="form-label" for="">But de la formation </label>
                                    <select class="select2 form-select form-select-sm" multiple data-allow-clear="true" name="but_formation" id="but_formation">
                                        @foreach ($butformations as $pc)
                                            <option value="{{ $pc->id_but_formation }}">
                                                {{$pc->but_formation}}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label" for="date_debut_fiche_agrement">Date début de réalisation </label>
                                <input
                                    type="date"
                                    id="date_debut_fiche_agrement"
                                    name="date_debut_fiche_agrement"
                                    class="form-control form-control-sm"
                                   />
                                </div>
                                <div class="col-12 col-md-2">
                                <label class="form-label" for="date_fin_fiche_agrement">Date fin de réalisation </label>
                                <input
                                    type="date"
                                    id="date_fin_fiche_agrement"
                                    name="date_fin_fiche_agrement"
                                    class="form-control form-control-sm"
                                    />
                                </div>
                          <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de bénéficiaires de l’action de formation</label>
                            <input
                              type="number" id="nombre_stagiaire_action_formati"
                              class="form-control form-control-sm"
                              disabled="disabled" />
                          </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="part_entreprise">Part entreprise</label>
                            <input
                              type="text" id="part_entreprise_inst"
                              class="form-control form-control-sm"
                              disabled="disabled" />
                          </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_jour_action_formation">Nombre de jours</label>
                            <input
                              type="text" id="nombre_jour_action_formation"
                              class="form-control form-control-sm"
                              disabled="disabled" />
                          </div>
                        <div class="col-12 col-md-4">
                          <label class="form-label" >Coût de la formation</label>
                          <input
                            type="text" id="cout_action_formation_plan"
                            class="form-control form-control-sm number"
                            disabled="disabled" />
                        </div>


                        <div class="col-12 col-md-4">
                          <label class="form-label" for="montant_attribuable_fdfp">Coût de financement</label>
                          <input
                            type="text" id="montant_attribuable_fdfp"
                            class="form-control form-control-sm number"
                            disabled="disabled" />
                        </div>


{{--                        <div class="col-12 col-md-4">--}}
{{--                                            <div class="mb-1">--}}
{{--                                                    <label>Facture proforma </label> <br>--}}
{{--                                                            <span class="badge bg-secondary"><a target="_blank"--}}
{{--                                                            onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $infosactionplanformation->facture_proforma_action_formati)}}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                            Voir la pièce  </a> </span>--}}
{{--                                                </div>--}}
{{--                        </div>--}}


                        <hr/>
                        <div class="col-md-6 col-12">
                            <label class="form-label" for="billings-country">Motif de non-financement <strong style="color:red;">(obligatoire si le montant accordé est egal a 0*)</strong></label>
                            <select class="form-select form-select-sm" data-allow-clear="true" name="motif_non_financement_action_formation" id="motif_non_financement_action_formation">
                                <?= $motif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label>Montant accordé <strong style="color:red;">*</strong>: </label>
                                <input type="text" name="cout_accorde_action_formation" id="cout_accorde_action_formation" class="number form-control form-control-sm number">
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-1">
                                <label>Commentaire <strong style="color:red;">*</strong>: </label>
                                <textarea class="form-control form-control-sm"  name="commentaire_action_formation" id="commentaire_action_formation" rows="6"></textarea>
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
{{--           @endforeach

          @foreach($infosactionplanformationsficheagrements as $key=>$infosactionplanformation)
              <?php $key = $key+1 ?> --}}
{{--            <div class="modal fade" id="traiterBeneficiaire<?php echo $infosactionplanformation->id_fiche_agrement ?>" tabindex="-1" aria-hidden="true">--}}
{{--                <div class="modal-dialog modal-xl modal-simple modal-edit-user">--}}
{{--                  <div class="modal-content p-5 p-md-5">--}}
{{--                    <div class="modal-body">--}}
{{--                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                      <div class="text-center mb-4">--}}
{{--                        <h3 class="mb-2">Traitement des bénéficiaires</h3>--}}
{{--                        <p class="text-muted"></p>--}}
{{--                      </div>--}}

{{--                      <form id="" class="row g-3 actionformationbeneficiaireForm" method="POST" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_fiche_agrement)) }}">--}}
{{--                            @csrf--}}
{{--                            @method('put')--}}

{{--                            <table class="table table-bordered table-hover table-checkable"--}}
{{--                               style="margin-top: 13px !important">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--								<th>N°</th>--}}
{{--                                <th>Nom et prénoms</th>--}}
{{--                                <th>Genre</th>--}}
{{--                                <th>Année de naissance</th>--}}
{{--                                <th>Nationalité</th>--}}
{{--                                <th>Fonction</th>--}}
{{--                                <th>Catégorie</th>--}}
{{--                                <th>Année d'embauche</th>--}}
{{--                                <th>Matricule CNPS</th>--}}
{{--                            </tr>--}}

{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            <?php--}}
{{--							$beneficiaires = ListePlanFormationSoumis::get_liste_beneficiare($infosactionplanformation->id_fiche_agrement);--}}
{{--                            $i=0;--}}
{{--                            foreach ($beneficiaires as $key => $res):--}}
{{--                            $i++;--}}

{{--                            ?>--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        {{ $i }}--}}
{{--                                        <input type="hidden" class="form-control form-control-sm" name="id_beneficiaire_formation/{{ $res->id_beneficiaire_formation }}" value="{{$res->id_beneficiaire_formation}}"/>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--									    <input type="text" class="form-control form-control-sm" value="{{$res->nom_prenoms}}" name="nom_prenoms/{{ $res->id_beneficiaire_formation }}"/>--}}
{{--									</td>--}}
{{--                                    <td>--}}
{{--										<input type="text" class="form-control form-control-sm" value="{{$res->genre}}" name="genre/{{ $res->id_beneficiaire_formation }}"/>--}}
{{--									</td>--}}
{{--									<td>--}}
{{--										<input type="text" class="form-control form-control-sm" value="{{$res->annee_naissance}}" name="annee_naissance/{{ $res->id_beneficiaire_formation }}"/>--}}
{{--									</td>--}}
{{--									<td>--}}
{{--										<input type="text" class="form-control form-control-sm" value="{{$res->nationalite}}" name="nationalite/{{ $res->id_beneficiaire_formation }}"/>--}}
{{--									</td>--}}
{{--									<td>--}}
{{--										<input type="text" class="form-control form-control-sm" value="{{$res->fonction}}" name="fonction/{{ $res->id_beneficiaire_formation }}"/>--}}
{{--									</td>--}}
{{--									<td>--}}
{{--										<input type="text" class="form-control form-control-sm" value="{{$res->categorie}}" name="categorie/{{ $res->id_beneficiaire_formation }}"/>--}}
{{--									</td>--}}
{{--									<td>--}}
{{--										<input type="text" class="form-control form-control-sm" value="{{$res->annee_embauche}}" name="annee_embauche/{{ $res->id_beneficiaire_formation }}"/>--}}
{{--									</td>--}}
{{--									<td>--}}
{{--										<input type="text" class="form-control form-control-sm" value="{{$res->matricule_cnps}}" name="matricule_cnps/{{ $res->id_beneficiaire_formation }}"/>--}}
{{--									</td>--}}


{{--                                </tr>--}}
{{--                            <?php endforeach; ?>--}}


{{--                            </tbody>--}}
{{--                        </table>--}}

{{--                        <div class="col-12 text-center">--}}
{{--                        <?php if($planformation->flag_soumis_ct_plan_formation != true){?>--}}
{{--                          <button onclick='javascript:if (!confirm("Voulez-vous Traiter cette liste de bénéficiaire ?")) return false;' type="submit" name="action" value="Traiter_action_formation_beneficiaire" class="btn btn-primary me-sm-3 me-1">Modifier</button>--}}
{{--                          <?php } ?>--}}
{{--                          <button--}}
{{--                            type="reset"--}}
{{--                            class="btn btn-label-secondary"--}}
{{--                            data-bs-dismiss="modal"--}}
{{--                            aria-label="Close">--}}
{{--                            Annuler--}}
{{--                          </button>--}}
{{--                        </div>--}}
{{--                      </form>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--          @endforeach--}}


            <!--<div id='myModal' class='modal fade' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
            </script>-->

            <div class="modal fade" id="Ajoutercabinetformation" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Saisie les informations du cabinet étranger</h3>
                        <p class="text-muted"></p>
                    </div>
                    <div class="modal-body">
                    <form class="mt-3" id="ajax-form" action="{{ route('ajoutcabinetetrangere') }}">
                        @csrf
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                    <div class="row">

                    <div class="col-md-12">
                        <label class="form-label" for="fullname">Raison sociale
                            <strong style="color:red;">*</strong></label>
                        <input type="text" id="raison_social_entreprises"
                               name="raison_social_entreprises"
                               class="form-control form-control-sm"
                               placeholder="Raison sociale"
                               required="required"
                               />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="email">Email <strong style="color:red;">*</strong></label>
                        <div class="input-group input-group-merge">
                            <input
                                class="form-control form-control-sm"
                                type="email"
                                id="email"
                                name="email_entreprises"
                                placeholder="Email"
                                aria-label=""
                                aria-describedby="email3" required="required"/>
                            <span class="input-group-text" id="email"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!--<label class="form-label" for="phone-number-mask">Téléphone du représentant</label>-->

                        <label class="form-label"
                               for="billings-country">Indicatif <strong style="color:red;">*</strong> </label>
                        <select class="select2 form-select-sm input-group" readonly=""
                                name="indicatif_entreprises" required="required">
                            <?php echo "+" .$paysc; ?>

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Téléphone <strong
                                style="color:red;">*</strong></label>
                        <input type="number" min="0"
                               name="tel_entreprises"
                               class="form-control form-control-sm"
                               placeholder="Téléphone"
                               required="required"/>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="mb-1">
                            <label>Localisation géographique <strong style="color:red;">*</strong></label>
                            <input type="text" name="localisation_geographique_entreprise"
                                   id="localisation_geographique_entreprise"
                                   class="form-control form-control-sm"
                                   placeholder="Localisation géographique"
                                   required="required">
                        </div>
                    </div>

                         <div class="col-12 text-center">

                          <button class="btn btn-primary me-sm-3 me-1 btn-submit" id="create_new">Enregistrer</button>

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

        @endsection

        @section('js_perso')
                <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
                <script src="{{asset('assets/js/additional-methods.js')}}"></script>
                <script type="text/javascript">
                    var selectBox = $("#id_type_formation");
                    selectBox.on("change", function() {
                        let selectedValue = $(this).val();
                        $.get('{{url('/')}}/caracteristiqueTypeFormationlist/'+selectedValue, function (data) {
                            //alert(data); //exit;
                            $('#id_caracteristique_type_formation').empty();
                            $.each(data, function (index, tels) {
                                $('#id_caracteristique_type_formation').append($('<option>', {
                                    value: tels.id_caracteristique_type_formation,
                                    text: tels.libelle_ctf,
                                }));
                            });
                        });

                        if(selectedValue == 3){
                            document.getElementById("Activeajoutercabinetformation").disabled = true;
                            $.get('{{url('/')}}/entrepriseinterneplanGeneral/{{$infoentreprise->id_entreprises}}', function (data) {
                                $('#id_entreprise_structure_formation_plan_formation').empty();
                                $.each(data, function (index, tels) {
                                    $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                                        value: tels.id_entreprises,
                                        text: tels.raison_social_entreprises,
                                    }));

                                    $.get('{{url('/')}}/domaineformations', function (data) {
                                        //alert(tels.id_entreprises); //exit;
                                        $('#id_domaine_formation').empty();
                                        $.each(data, function (index, tels) {
                                            $('#id_domaine_formation').append($('<option>', {
                                                value: tels.id_domaine_formation,
                                                text: tels.libelle_domaine_formation,
                                            }));
                                        });
                                    });
                                });
                            });
                        }

                        if(selectedValue == 1 || selectedValue ==2 || selectedValue == 5){
                            document.getElementById("Activeajoutercabinetformation").disabled = true;
                            $.get('{{url('/')}}/entreprisecabinetformation', function (data) {
                                //alert(data); //exit;
                                $('#id_entreprise_structure_formation_plan_formation').empty();
                                $.each(data, function (index, tels) {
                                    $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                                        value: tels.id_entreprises,
                                        text: tels.raison_social_entreprises,
                                    }));

                                    $.get('{{url('/')}}/domaineformation/'+tels.id_entreprises, function (data) {
                                        //alert(tels.id_entreprises); //exit;
                                        // alert(data); //exit;
                                        $('#id_domaine_formation').empty();
                                        $.each(data, function (index, tels) {
                                            $('#id_domaine_formation').append($('<option>', {
                                                value: tels.id_domaine_formation,
                                                text: tels.libelle_domaine_formation,
                                            }));
                                        });
                                    });
                                });
                            });
                        }

                        if(selectedValue == 4){
                            document.getElementById("Activeajoutercabinetformation").disabled = false;
                            $.get('{{url('/')}}/entreprisecabinetetrangerformation', function (data) {
                                //alert(data); //exit;
                                $('#id_entreprise_structure_formation_plan_formation').empty();
                                $.each(data, function (index, tels) {
                                    $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                                        value: tels.id_entreprises,
                                        text: tels.raison_social_entreprises,
                                    }));

                                    $.get('{{url('/')}}/domaineformations', function (data) {
                                        //alert(tels.id_entreprises); //exit;
                                        $('#id_domaine_formation').empty();
                                        $.each(data, function (index, tels) {
                                            $('#id_domaine_formation').append($('<option>', {
                                                value: tels.id_domaine_formation,
                                                text: tels.libelle_domaine_formation,
                                            }));
                                        });
                                    });
                                });
                            });
                        }
                    });

                    //Traitement Action formation
                    //Initialisation des variables
                    var id;
                    var traiterActionFomationModal = $("#traiterActionFomationPlan");
                    var raison_social_entreprises = $("#raison_social_entreprises");
                    var masse_salariale_ins = $("#masse_salariale_ins");
                    var intitule_action_formation_plan = $("#intitule_action_formation_plan");
                    var nombre_groupe_action_formation_ = $("#nombre_groupe_action_formation_");
                    var nombre_heure_action_formation_p = $("#nombre_heure_action_formation_p");
                    var cadre_fiche_demande_agrement = $("#cadre_fiche_demande_agrement");
                    var agent_maitrise_fiche_demande_ag = $("#agent_maitrise_fiche_demande_ag");
                    var employe_fiche_demande_agrement = $("#employe_fiche_demande_agrement");
                    var id_type_formation = $("#id_type_formation");
                    var lieu_formation_fiche_agrement = $("#lieu_formation_fiche_agrement");
                    var part_entreprise_inst = $("#part_entreprise_inst");
                    var nombre_jour_action_formation = $("#nombre_jour_action_formation");
                    var cout_action_formation_plan = $("#cout_action_formation_plan");
                    var montant_attribuable_fdfp = $("#montant_attribuable_fdfp");
                    var commentaire_action_formation = $("#commentaire_action_formation");
                    var but_formation = $("#but_formation");
                    var date_debut_fiche_agrement = $("#date_debut_fiche_agrement");
                    var date_fin_fiche_agrement = $("#date_fin_fiche_agrement");
                    var nombre_stagiaire_action_formati = $("#nombre_stagiaire_action_formati");
                    var cout_accorde_action_formation = $("#cout_accorde_action_formation");
                    var id_domaine_formation = $("#id_domaine_formation");
                    var id_entreprise_structure_formation_plan_formation = $("#id_entreprise_structure_formation_plan_formation");
                    var id_caracteristique_type_formation = $("#id_caracteristique_type_formation");

                    var objectif_pedagogique_fiche_agre = new Quill("#objectif_pedagogique_fiche_agre",{
                        theme: 'snow'
                    });

                    $(document).on('click', '.traiterActionFomationPlan', function () {
                        id = $(this).data('id');
                        traiterActionFomationModal.modal('show');
                        $.get("{{url('/')}}/traitementplanformation/"+id+"/informationaction",
                            function (data) {
                                initvalue();
                                raison_social_entreprises.val(data.information.raison_social_entreprises);
                                masse_salariale_ins.val(data.information.masse_salariale);
                                intitule_action_formation_plan.val(data.information.intitule_action_formation_plan);
                                nombre_groupe_action_formation_.val(data.information.nombre_groupe_action_formation_);
                                nombre_heure_action_formation_p.val(data.information.nombre_heure_action_formation_p);
                                cadre_fiche_demande_agrement.val(data.information.cadre_fiche_demande_agrement);
                                agent_maitrise_fiche_demande_ag.val(data.information.agent_maitrise_fiche_demande_ag);
                                employe_fiche_demande_agrement.val(data.information.employe_fiche_demande_agrement);
                                id_type_formation.val(data.information.id_type_formation).trigger('change');
                                lieu_formation_fiche_agrement.val(data.information.lieu_formation_fiche_agrement);
                                part_entreprise_inst.val(data.information.part_entreprise);
                                nombre_jour_action_formation.val(data.information.nombre_jour_action_formation);
                                cout_action_formation_plan.val(data.information.cout_action_formation_plan);
                                montant_attribuable_fdfp.val(data.information.montant_attribuable_fdfp);
                                commentaire_action_formation.val(data.information.commentaire_action_formation);
                                date_debut_fiche_agrement.val(data.information.date_debut_fiche_agrement.split(' ')[0]);
                                date_fin_fiche_agrement.val(data.information.date_fin_fiche_agrement.split(' ')[0]);
                                nombre_stagiaire_action_formati.val(data.information.nombre_stagiaire_action_formati);
                                if(data.information.cout_accorde_action_formation<data.information.montant_attribuable_fdfp){
                                    cout_accorde_action_formation.val(data.information.cout_action_formation_plan);
                                }else if(data.information.cout_action_formation_plan>data.information.montant_attribuable_fdfp){
                                    cout_accorde_action_formation.val(data.information.montant_attribuable_fdfp);
                                }else{
                                    cout_accorde_action_formation.val(data.information.montant_attribuable_fdfp);
                                }
                                $.each(data.butformations, function(key,val) {
                                    but_formation.val(val.id_but_formation).trigger('change');
                                });
                                objectif_pedagogique_fiche_agre.pasteHTML(data.information.objectif_pedagogique_fiche_agre);
                                id_domaine_formation.append("<option selected value="+data.information.id_domaine_formation+">"+data.information.libelle_domaine_formation+"</option>");
                                id_entreprise_structure_formation_plan_formation.append("<option selected value="+data.information.id_entreprise_structure_formation_action+">"+data.information.structure_etablissement_action_+"</option>");
                                id_caracteristique_type_formation.append("<option selected value="+data.information.id_caracteristique_type_formation+">"+data.information.libelle_ctf+"</option>");

                            }
                        );
                    });

                    function initvalue(){
                        raison_social_entreprises.empty();
                        masse_salariale_ins.empty();
                        intitule_action_formation_plan.empty();
                        nombre_groupe_action_formation_.empty();
                        nombre_heure_action_formation_p.empty();
                        cadre_fiche_demande_agrement.empty();
                        agent_maitrise_fiche_demande_ag.empty();
                        employe_fiche_demande_agrement.empty();
                        lieu_formation_fiche_agrement.empty();
                        part_entreprise_inst.empty();
                        nombre_jour_action_formation.empty();
                        cout_action_formation_plan.empty();
                        montant_attribuable_fdfp.empty();
                        commentaire_action_formation.empty();
                        date_debut_fiche_agrement.empty();
                        date_fin_fiche_agrement.empty();
                        nombre_stagiaire_action_formati.empty();
                        id_domaine_formation.empty();
                        id_entreprise_structure_formation_plan_formation.empty();
                        objectif_pedagogique_fiche_agre.pasteHTML("");
                    }
                </script>




                <script type="text/javascript">

            /*------------------------------------------
            --------------------------------------------
            Form Submit Event
            --------------------------------------------
            --------------------------------------------*/
            $('#ajax-form').submit(function(e) {
                e.preventDefault();
                //alert(this);
                var url = $(this).attr("action");
                //alert(url);
                let formData = new FormData(this);
                $.ajax({
                        type:'POST',
                        url: url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: (response) => {

                            //alert(response.data.id_entreprises);
                            //alert(response.success);
                            /*$('#id_entreprise_structure_formation_plan_formation').empty();
                            $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                                value: response.data.id_entreprises,
                                text: response.data.raison_social_entreprises,
                             }));*/
                             $.get('/entreprisecabinetetrangerformationmax', function (data) {
                                    //alert(data); //exit;
                                    $('#id_entreprise_structure_formation_plan_formation').empty();
                                    $.each(data, function (index, tels) {
                                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                                            value: tels.id_entreprises,
                                            text: tels.raison_social_entreprises,
                                        }));


                                    });
                                });
                            //location.reload();
                            $('#Ajoutercabinetformation').modal('hide');
                            return false;
                        },
                        error: function(response){
                            $('#ajax-form').find(".print-error-msg").find("ul").html('');
                            $('#ajax-form').find(".print-error-msg").css('display','block');
                            $.each( response.responseJSON.errors, function( key, value ) {
                                $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            });
                        }
                   });

            });

        </script>

        <script>





                var commentaire_plan_formation = new Quill('#commentaire_plan_formation', {
                    theme: 'snow'
                });

                $(".objectif_pedagogique_fiche_agre_val").hide();

                $("#commentaire_plan_formation_val").hide();

                var commentaireplanformationForm = $("#commentaireplanformationForm");

                var form = document.querySelectorAll('.actionformationForm');
                for (let i = 0; i < form.length; i++) {
                    const data_element = form[i];
                    data_element.onsubmit =function(){
                        $(".objectif_pedagogique_fiche_agre_val").val(objectif_pedagogique_fiche_agre[i].root.innerHTML)
                    }
                }

                 commentaireplanformationForm.onsubmit = function(){
                    $("#commentaire_plan_formation_val").val(commentaire_plan_formation.root.innerHTML);
                 }

            //Select2 type de formation
            $("#id_type_formation").select2().val({{old('id_type_formation')}});

            //Select2 caracteristique type de formation
            $("#id_caracteristique_type_formation").select2().val({{old('id_caracteristique_type_formation')}});

            //Select2 structure entreprise
            $("#id_entreprise_structure_formation_plan_formation").select2().val({{old('id_entreprise_structure_formation_plan_formation')}});



            //Select2 secteur d'activité
            $("#id_secteur_activite").select2().val({{old('id_secteur_activite')}});

            var idactivesmoussion = $('#colorCheck1').prop('checked', false);


                function myFunctionMAJ() {
                    // Get the checkbox
                    var checkBox = document.getElementById("colorCheck1");

                    // If the checkbox is checked, display the output text
                    if (checkBox.checked == true){
                        $("#Enregistrer_soumettre_plan_formation").prop( "disabled", false );
                    } else {
                        $("#Enregistrer_soumettre_plan_formation").prop( "disabled", true );
                    }
                }

        </script>


    @endsection

    @else
        <script type="text/javascript">
            window.location = "{{ url('/403') }}";//here double curly bracket
        </script>
    @endif
