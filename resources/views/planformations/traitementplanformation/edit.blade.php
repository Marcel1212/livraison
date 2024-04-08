<?php
    /*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{

	}*/
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

             @if ($message = Session::get('error'))
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
                                        <label>Nombre de salariés déclarés à la CNPS </label>
                                        <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->nombre_salarie_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Masse salariale brute annuelle prévisionnelle </label>
                                        <input type="text" name="masse_salariale" id="masse_salariale"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->masse_salariale, 0, ',', ' ')}}" disabled="disabled">
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

                                        <label>Part entreprise determiné</label>
                                        <input type="text" name="part_entreprise_previsionnel" id="part_entreprise_previsionnel"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->part_entreprise_previsionnel, 0, ',', ' ')}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Budget de financement </label>
                                        <input type="text" name="montant_financement_budget" id="montant_financement_budget"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->montant_financement_budget, 0, ',', ' ')}}" disabled="disabled">
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
                                <th>Intituler de l'action de formation </th>
                                <th>Structure ou établissement de formation</th>
                                <th>Nombre de bénéficiaires de l’action de formation</th>
                                <th>Nombre de groupes</th>
                                <th>Nombre d'heures par groupe</th>
                                <th>Cout de l'action</th>
                                <th>Cout de financement</th>
                                <th>Cout de l'action accordée</th>
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
                                <td>{{ $historiquesplanformation->nombre_stagiaire_action_formati }}</td>
                                <td>{{ $historiquesplanformation->nombre_groupe_action_formation_ }}</td>
                                <td>{{ $historiquesplanformation->nombre_heure_action_formation_p }}</td>
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

                        <div class="col-12" align="right">

                            <?php if($nombreaction == $nombreactionvalider and $planformation->flag_soumis_ct_plan_formation != true){?>
                                @if (!isset($planformation->commentaire_plan_formation))
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inlineForm">
                                        Ajouter un commentaire
                                    </button>
                                @else
                                    <div class="row">
                                        <div class="col-6">
                                        </div>
                                        <div class="col-3">
                                        <button type="button" class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#modalToggle">
                                            Voir le commentaire
                                        </button>
                                        </div>
                                        <div class="col-3">
                                        <form method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}">
                                            @csrf
                                            @method('put')
                                            <button onclick='javascript:if (!confirm("Le plan de formation sera soumis au comite technique en ligne ? . Cette action est irréversible.")) return false;' type="submit" name="action" value="Soumission_ct_plan_formation"
                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                            Soumettre pour le comite
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                @endif
                            <?php } ?>
                        </div>

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
                                <th>Intituler de l'action de formation </th>
                                <th>Structure ou établissement de formation</th>
                                <th>Nombre de bénéficiaires de l’action de formation</th>
                                <th>Nombre de groupes</th>
                                <th>Nombre d'heures par groupe</th>
                                <th>Priorité</th>
                                <th>Cout de l'action</th>
                                <th>Cout de financement</th>
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
                                                <td>{{ $actionplanformation->pirorite_action_formation }}</td>
                                                <td>{{ number_format($actionplanformation->cout_action_formation_plan, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($actionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($actionplanformation->cout_accorde_action_formation, 0, ',', ' ') }}</td>

                                                <td align="center" nowrap="nowrap">
                                                    @can($lien.'-edit')
                                                        <a onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                           class=" "
                                                           title="Modifier"><img src='/assets/img/eye-solid.png'></a>  &nbsp;
                                                           <?php if($planformation->flag_recevablite_plan_formation==true){ ?>
                                                           <a type="button"
                                                                    class="" data-bs-toggle="modal" data-bs-target="#traiterActionFomationPlan<?php echo $actionplanformation->id_action_formation_plan ?>" href="#myModal1" data-url="http://example.com">
                                                                        <img src='/assets/img/editing.png'>
                                                                    </a>

                                                            <!--<a href="#myModal" id="btnChange"class="btn btn-default" data-toggle="modal" data-id="@$actionplanformation->id_action_formation_plan">Change Location</a>-->

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
                                                    <label class="form-label" for="billings-country">Les motifs d'irrecevabilité <strong style="color:red;">*</strong></label>

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

    <!-- Edit User Modal -->
          @foreach($infosactionplanformations as $key=>$infosactionplanformation)
              <?php $key = $key+1 ?>
            <div class="modal fade" id="traiterActionFomationPlan<?php echo $infosactionplanformation->id_action_formation_plan ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-simple modal-edit-user">
                  <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                        <h3 class="mb-2">Traitement d'une action de plan de formation</h3>
                        <p class="text-muted"></p>
                      </div>
                      {{-- editUserForm1  --}}
                      <form id="" class="row g-3 actionformationForm" method="POST" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan)) }}">
                            @csrf
                            @method('put')

                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nombre_stagiaire_action_formati"><strong style="color:green;">Budget crédit</strong></label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ number_format(@$planformation->montant_financement_budget, 0, ',', ' ') }}"
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nombre_stagiaire_action_formati"><strong style="color:red;">Budget crédit sollicité</strong></label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ number_format($montantactionplanformation, 0, ',', ' ') }}"
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nombre_stagiaire_action_formati"><strong style="color:blue;">Budget crédit accordé</strong></label>
                                <input
                                    type="text"
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
                          <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            name="intitule_action_formation_plan"
                            value="{{@$infosactionplanformation->intitule_action_formation_plan}}" />
                        </div>
                        <div class="col-md-12 mb-5">
                            <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>
                            <input class="form-control objectif_pedagogique_fiche_agre_val @error('objectif_pedagogique_fiche_agre') error @enderror" type="text" id="" name="objectif_pedagogique_fiche_agre"/>
                            <div id="" class="rounded-1 objectif_pedagogique_fiche_agre">{!! $infosactionplanformation->objectif_pedagogique_fiche_agre !!}</div>
                           @error('objectif_pedagogique_fiche_agre')
                            <div class=""><label class="error">{{ $message }}</label></div>
                            @enderror
                        </div>


                        <div class="col-md-4 col-12">
                            <label>Secteur d'activité:</label>
                            <select class="select2 form-select" data-allow-clear="true" name="id_secteur_activite" id="id_secteur_activite">
                                <option value="{{@$infosactionplanformation->id_secteur_activitee }}">{{@$infosactionplanformation->libelle_secteur_activite }} </option>
                                @foreach ($secteuractivites as $activite)
                                    <option value="{{ $activite->id_secteur_activite }}">{{ mb_strtoupper($activite->libelle_secteur_activite) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                          <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupes</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            name="nombre_groupe_action_formation_"
                            value="{{@$infosactionplanformation->nombre_groupe_action_formation_}}"/>
                        </div>
                        <div class="col-12 col-md-4">
                          <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes</label>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            name="nombre_heure_action_formation_p"
                            value="{{@$infosactionplanformation->nombre_heure_action_formation_p}}"/>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>
                            <select
                                id="id_but_formation"
                                name="id_but_formation"
                                class="select2 form-select input-group @error('id_but_formation')
                                error
                                @enderror"
                                aria-label="Default select example" >
								     <option value="{{@$infosactionplanformation->id_but_formation }}">{{@$infosactionplanformation->but_formation }} </option>
                                  @foreach ($butformations as $butformation)
                                      <option value="{{ $butformation->id_but_formation }}">{{ mb_strtoupper($butformation->but_formation) }}</option>
                                  @endforeach
                            </select>
                            @error('id_but_formation')
                            <div class=""><label class="error">{{ $message }}</label></div>
                            @enderror
                            </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres</label>
                            <input
                              type="number"
                              class="form-control form-control-sm"
                              name="cadre_fiche_demande_agrement"
                              value="{{@$infosactionplanformation->cadre_fiche_demande_agrement}}"/>
                          </div>
                          <div class="col-12 col-md-4">
                            <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maîtrise</label>
                            <input
                              type="number"
                              class="form-control form-control-sm"
                              name="agent_maitrise_fiche_demande_ag"
                              value="{{@$infosactionplanformation->agent_maitrise_fiche_demande_ag}}"/>
                          </div>
                          <div class="col-12 col-md-4">
                            <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers</label>
                            <input
                              type="number"
                              class="form-control form-control-sm"
                              name="employe_fiche_demande_agrement"
                              value="{{@$infosactionplanformation->employe_fiche_demande_agrement}}"/>
                          </div>


                          <div class="col-12 col-md-4">
                            <label class="form-label" for="id_type_formation_{{$key}}">Type de formation <strong style="color:red;">*</strong></label>
                            <select
                                id="id_type_formation_{{$key}}"
                                name="id_type_formation"
                                class="select2 form-select-sm input-group @error('id_type_formation')
                                error
                                @enderror"
                                aria-label="Default select example">
									<option value="{{@$infosactionplanformation->id_type_formation }}">{{@$infosactionplanformation->type_formation }} </option>
                                  @foreach ($typeformationss as $typeformation)
                                    <option value="{{ $typeformation->id_type_formation }}">{{ mb_strtoupper($typeformation->type_formation) }}</option>
                                  @endforeach
                            </select>
                            @error('id_type_formation')
                            <div class=""><label class="error">{{ $message }}</label></div>
                            @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label" for="id_caracteristique_type_formation">Caractéristique type de formation <strong style="color:red;">*</strong></label>
                                <select id="id_caracteristique_type_formation_{{$key}}" name="id_caracteristique_type_formation" class="select2 form-select-sm input-group @error('id_caracteristique_type_formation')
                                error
                                @enderror">
                                    <option value='{{@$infosactionplanformation->caracteristiqueTypeFormation->id_caracteristique_type_formation}}'>{{@$infosactionplanformation->caracteristiqueTypeFormation->libelle_ctf}}</option>
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
                                        @enderror" name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation_{{$key}}">
                                            <option value='{{@$infosactionplanformation->id_entreprise_structure_formation_action}}'>{{@$infosactionplanformation->structure_etablissement_action_}}</option>
                                            <?php //echo $structureformation; ?>
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

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>
                            <input
                                type="text"
                                id="lieu_formation_fiche_agrement"
                                name="lieu_formation_fiche_agrement"
                                class="form-control form-control-sm @error('lieu_formation_fiche_agrement')
                                error
                                @enderror"
                                value="{{@$infosactionplanformation->lieu_formation_fiche_agrement}}"
                                 />
                                 @error('lieu_formation_fiche_agrement')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>

                            <div class="col-12 col-md-2">
                                <label class="form-label" for="date_debut_fiche_agrement">Date début de réalisation </label>
                                <input
                                    type="date"
                                    id="date_debut_fiche_agrement"
                                    name="date_debut_fiche_agrement"
                                    class="form-control form-control-sm"
                                    value="{{@$infosactionplanformation->date_debut_fiche_agrement}}"
                                   />
                                </div>
                                <div class="col-12 col-md-2">
                                <label class="form-label" for="date_fin_fiche_agrement">Date fin de réalisation </label>
                                <input
                                    type="date"
                                    id="date_fin_fiche_agrement"
                                    name="date_fin_fiche_agrement"
                                    class="form-control form-control-sm"
                                    value="{{@$infosactionplanformation->date_fin_fiche_agrement}}"
                                    />
                                </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de bénéficiaires de l’action de formation</label>
                            <input
                              type="number"
                              class="form-control form-control-sm"
                              value="{{@$infosactionplanformation->nombre_stagiaire_action_formati}}"
                              disabled="disabled" />
                          </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="part_entreprise">Part entreprise</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              value="{{number_format(@$infosactionplanformation->part_entreprise, 0, ',', ' ')}}"
                              disabled="disabled" />
                          </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_jour_action_formation">Nombre de jours</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              value="{{@$infosactionplanformation->nombre_jour_action_formation}}"
                              disabled="disabled" />
                          </div>
                        <div class="col-12 col-md-4">
                          <label class="form-label" >Coût de la formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{number_format(@$infosactionplanformation->cout_action_formation_plan, 0, ',', ' ')}}"
                            disabled="disabled" />
                        </div>


                        <div class="col-12 col-md-4">
                          <label class="form-label" for="cout_total_fiche_agrement">Coût de financement</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{number_format(@$infosactionplanformation->montant_attribuable_fdfp, 0, ',', ' ')}}"
                            disabled="disabled" />
                        </div>


                        <div class="col-12 col-md-4">
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
                                <label>Montant accordé <strong style="color:red;">*</strong>: </label>
                                <input type="text" name="cout_accorde_action_formation" id="cout_accorde_action_formation" class="form-control form-control-sm number" value="@if ($infosactionplanformation->cout_action_formation_plan<$infosactionplanformation->montant_attribuable_fdfp){{ number_format($infosactionplanformation->cout_action_formation_plan, 0, ',', ' ')}}@elseif($infosactionplanformation->cout_action_formation_plan>$infosactionplanformation->montant_attribuable_fdfp){{ number_format($infosactionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}@else{{ number_format($infosactionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}@endif"/>
                            </div>
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
                    {{--var all_count_actions = {{$infosactionplanformations->count()}};--}}
                    {{--for(var i=1; i < all_count_actions+1 ; i++){--}}
                        var selectBox = $("#id_type_formation_"+i);
                        selectBox.on("change", function() {
                            let selectedValue = $(this).val();
                            alert('select'+i+' '+selectedValue);
                             $.get('{{url('/')}}/caracteristiqueTypeFormationlist/'+selectedValue, function (data) {
                                //alert(data); //exit;
                                $('#id_caracteristique_type_formation_'+i).empty();
                                $.each(data, function (index, tels) {
                                    $('#id_caracteristique_type_formation_'+i).append($('<option>', {
                                        value: tels.id_caracteristique_type_formation,
                                        text: tels.libelle_ctf,
                                    }));
                                });
                            });

                            if(selectedValue == 3){
                                document.getElementById("Activeajoutercabinetformation").disabled = true;
                                $.get('{{url('/')}}/entrepriseinterneplan', function (data) {
                                    $('#id_entreprise_structure_formation_plan_formation_'+i).empty();
                                    $.each(data, function (index, tels) {
                                        $('#id_entreprise_structure_formation_plan_formation_'+i).append($('<option>', {
                                            value: tels.id_entreprises,
                                            text: tels.raison_social_entreprises,
                                        }));
                                    });
                                });
                            }

                            if(selectedValue == 1 || selectedValue ==2 || selectedValue == 5){
                                document.getElementById("Activeajoutercabinetformation").disabled = true;
                                $.get('{{url('/')}}/entreprisecabinetformation', function (data) {
                                    //alert(data); //exit;
                                    $('#id_entreprise_structure_formation_plan_formation_'+i).empty();
                                    $.each(data, function (index, tels) {
                                        $('#id_entreprise_structure_formation_plan_formation_'+i).append($('<option>', {
                                            value: tels.id_entreprises,
                                            text: tels.raison_social_entreprises,
                                        }));
                                    });
                                });
                            }

                            if(selectedValue == 4){
                                document.getElementById("Activeajoutercabinetformation").disabled = false;
                                $.get('{{url('/')}}/entreprisecabinetetrangerformation', function (data) {
                                    //alert(data); //exit;
                                    $('#id_entreprise_structure_formation_plan_formation_'+i).empty();
                                    $.each(data, function (index, tels) {
                                        $('#id_entreprise_structure_formation_plan_formation_'+i).append($('<option>', {
                                            value: tels.id_entreprises,
                                            text: tels.raison_social_entreprises,
                                        }));
                                    });
                                });
                            }
                        });
                    // }
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


                let containers = document.querySelectorAll('.objectif_pedagogique_fiche_agre');
                let objectif_pedagogique_fiche_agre = Array.from(containers).map(function(container) {
                    return new Quill(container,{
                        theme: 'snow'
                    });
                });


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

            //Select2 But de formation
            $("#id_but_formation").select2().val({{old('id_but_formation')}});

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
