<?php
    /*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{

	}*/
    $NumAgce = Auth::user()->num_agce;
    $Iddepartement = Auth::user()->id_departement;
    use App\Helpers\ConseillerParAgence;
    use App\Helpers\NombreActionValiderParLeConseiller;
    use App\Helpers\ListeTraitementCritereParUser;
    use App\Helpers\ListePlanFormationSoumis;
    $conseilleragence = ConseillerParAgence::get_conseiller_par_agence($NumAgce,$Iddepartement);
    $conseillerplan = NombreActionValiderParLeConseiller::get_conseiller_valider_plan($planformation->id_plan_de_formation , Auth::user()->id);
    $nombre = count($conseilleragence);
    //dd($nombre);
?>
@if(auth()->user()->can('ctplanformationvalider-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Demandes')
    @php($titre='Liste des plans de formations')
    @php($soustitre='Comite technique à valider')
    @php($lien='ctplanformationvalider')


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



                <div class="row">
                    <div align="right">
                        <button type="button"
                                class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#modalToggle">
                            Voir le parcours de validation
                        </button>
                        <button type="button"
                                class="btn rounded-pill btn-outline-success btn-sm waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#modalToggleCommentaireplan">
                            Voir le commentaire du plan de formation
                        </button>
                    </div>
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
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-histortiqueactionformation"
                          aria-controls="navs-top-histortiqueactionformation"
                          aria-selected="false">
                          Historiques des actions des plans de formation
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link active"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-recevabilite"
                          aria-controls="navs-top-recevabilite"
                          aria-selected="false">
                          Traitement
                        </button>
                      </li>
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
                                        <label>Type entreprises </label>
                                        <select class="select2 form-select-sm input-group" name="id_type_entreprise" id="id_type_entreprise" disabled="disabled">
                                            <?php echo $typeentreprise; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Masse salariale </label>
                                        <input type="text" name="masse_salariale" id="masse_salariale"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->masse_salariale, 0, ',', ' ')}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Part entreprise ({{ @$planformation->partEntreprise->valeur_part_entreprise }})</label>
                                        <input type="text" name="part_entreprise" id="part_entreprise"
                                               class="form-control form-control-sm" value="{{number_format(@$planformation->part_entreprise, 0, ',', ' ')}}" disabled="disabled">
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
                                <th>Catégorie </th>
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

                      <div class="tab-pane fade" id="navs-top-actionformation" role="tabpanel">

                        <div class="col-12" align="right">

                            <?php if($nombreaction == $nombreactionvaliderparconseiller){?>
                                <?php if(count($conseillerplan)<1){?>
                                    <form method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}">
                                        @csrf
                                        @method('put')
                                        <button onclick='javascript:if (!confirm("Vous allez effectuer la validation du comite en ligne pour ce plan de formation ? . Cette action est irréversible.")) return false;' type="submit" name="action" value="Traiter_action_formation_valider_plan"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                        Valider
                                        </button>
                                    </form>
                                <?php }else{?>
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <div class="alert-body" style="text-align:center">
                                            Vous avez effectué votre comite technique en ligne
                                        </div>
                                    </div>
                                <?php } ?>

                            <?php } ?>
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
                                <th>Commentaire</th>
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
                                                <td>{{ number_format($actionplanformation->cout_action_formation_plan, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($actionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($actionplanformation->cout_accorde_action_formation, 0, ',', ' ') }}</td>
                                                <td align="center" nowrap>

                                                    <button type="button"
                                                        class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light"
                                                        data-bs-toggle="modal" data-bs-target="#modalToggleConseil<?php echo $actionplanformation->id_action_formation_plan; ?>">
                                                            Voir commentaire CT
                                                    </button>


                                                </td>
                                                <td align="center" nowrap="nowrap">
                                                    @can($lien.'-edit')
                                                        <a onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                           class=" "
                                                           title="Modifier"><img src='/assets/img/eye-solid.png'></a>  &nbsp;
                                                           <?php //if($planformation->flag_recevablite_plan_formation==true){ ?>
                                                           <a type="button"
                                                                    class="" data-bs-toggle="modal" data-bs-target="#traiterActionFomationPlan<?php echo $actionplanformation->id_action_formation_plan ?>" href="#myModal1" data-url="http://example.com">
                                                                        <img src='/assets/img/editing.png'>
                                                                    </a>

                                                            <!--<a href="#myModal" id="btnChange"class="btn btn-default" data-toggle="modal" data-id="@$actionplanformation->id_action_formation_plan">Change Location</a>-->

                                                            <?php //} ?>
                                                    @endcan

                                                </td>
                                            </tr>
                                @endforeach

                            </tbody>
                        </table>
                      </div>
                      <div class="tab-pane fade show active" id="navs-top-recevabilite" role="tabpanel">

                      <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                                <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id2) }}"/>
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>
                                                        <?php if(count($parcoursexist)<1){?>
                                                            <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                                        <?php }else{?>
                                                            <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                                        <?php } ?>
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
                            value="{{number_format(@$infosactionplanformation->masse_salariale)}}"
                            disabled="disabled" />
                        </div>

                        <div class="col-12 col-md-12">
                          <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->intitule_action_formation_plan}}"
                            disabled="disabled" />
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique</label>
                            <textarea class="form-control form-control-sm"  name="objectif_pedagogique_fiche_agre" id="objectif_pedagogique_fiche_agre" rows="6" disabled="disabled">{{@$infosactionplanformation->objectif_pedagogique_fiche_agre}}</textarea>
                          </div>

                          <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de bénéficiaires de l’action de formation</label>
                            <input
                              type="number"
                              class="form-control form-control-sm"
                              value="{{@$infosactionplanformation->nombre_stagiaire_action_formati}}"
                              disabled="disabled" />
                          </div>

                          <div class="col-12 col-md-3">
                            <label class="form-label" for="id_domaine_formation">Domaine de formation</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              value="{{@$infosactionplanformation->libelle_domaine_formation}}"
                              disabled="disabled" />
                          </div>

                          <div class="col-12 col-md-3">
                            <label class="form-label" for="part_entreprise">Part entreprise</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              value="{{number_format(@$infosactionplanformation->part_entreprise)}}"
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
                            <label class="form-label" for="nombre_jour_action_formation">Nombre de jours</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              value="{{@$infosactionplanformation->nombre_jour_action_formation}}"
                              disabled="disabled" />
                          </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" >Coût de la formation</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{number_format(@$infosactionplanformation->cout_action_formation_plan)}}"
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
                            <label class="form-label">Caractéristique type de formation</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              value="{{@$infosactionplanformation->caracteristiqueTypeFormation->libelle_ctf}}"
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
                            <label class="form-label" for="cout_total_fiche_agrement">Cout de financement</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              value="{{number_format(@$infosactionplanformation->montant_attribuable_fdfp)}}"
                              disabled="disabled" />
                          </div>
                        <div class="col-12 col-md-3">
                          <label class="form-label" for="cout_accorde_action_formation">Montant accordée</label>
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            value="{{number_format(@$infosactionplanformation->cout_accorde_action_formation)}}"
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
                        <div class="col-12 col-md-3">
                            <div class="mb-1">
                                <label class="form-label" for="">But de la formation </label>

                                <?php
                                    $butformationsenres =    ListePlanFormationSoumis::get_liste_but_formations(@$infosactionplanformation->id_fiche_agrement);
                                ?>
                                @foreach ($butformationsenres as $pc)
                                <input type="text" name="" class="form-control form-control-sm"
                                    value="{{ $pc->butFormation->but_formation }}"
                                    disabled />
                                @endforeach
                                </div>
                        </div>
                        <div class="col-12 col-md-12">
                          <label class="form-label" for="cout_accorde_action_formation">Commentaire</label>
                          <!--<input
                            type="number"
                            class="form-control form-control-sm"
                            value="{{@$infosactionplanformation->cout_accorde_action_formation}}"
                            disabled="disabled" />-->
                            <textarea class="form-control form-control-sm"  name="commentaire_action_formation" id="commentaire_action_formation" rows="6" disabled="disabled">{{@$infosactionplanformation->commentaire_action_formation}}</textarea>
                        </div>



                        <hr/>

                        <!--<div class="col-md-6 col-12">
                            <label class="form-label" for="billings-country">Motif de validationt <strong style="color:red;">(obligatoire si actiona corrigé)</strong></label>

                            <select class="form-select form-select-sm" data-allow-clear="true" name="id_motif" id="id_motif">
                                <?= $motif; ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label>Commentaire <strong style="color:red;">*</strong>: </label>
                                <textarea class="form-control form-control-sm"  name="commentaire" id="commentaire" rows="6"></textarea>
                            </div>
                        </div>-->

                        <div class="col-12 text-center">
                            <?php
                                $conseilleraction = NombreActionValiderParLeConseiller::get_conseiller_valide_action_plan($infosactionplanformation->id_action_formation_plan , Auth::user()->id);
                            ?>
                          <?php if(count($conseilleraction)<1){?>
                            <!--<button onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;' type="submit" name="action" value="Traiter_action_formation_valider" class="btn btn-success me-sm-3 me-1">Valider</button>
                            <button onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;' type="submit" name="action" value="Traiter_action_formation_rejeter" class="btn btn-danger me-sm-3 me-1">Action à corriger</button>-->
                          <?php }else{?>
                            <!--<div class="alert alert-info alert-dismissible fade show" role="alert">
                                <div class="alert-body" style="text-align:center">
                                    Action déja traité
                                </div>
                            </div>-->
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
                                        <h5 class="card-header">Parcours de la demande de validation du plan de formation</h5>
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

                    <div class="col-md-4 col-12">
                        <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggleCommentaireplan"
                             aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalToggleLabel">Commentaire </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="card">
                                        <h5 class="card-header">Commentaire du plan de formation</h5>
                                        <div class="card-body pb-2">
                                            <ul class="timeline pt-3">

                                                    <li class="timeline-item pb-4 timeline-item-primary border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-primary">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                                        <div class="timeline-event">
                                                            <div class="timeline-header border-bottom mb-3">
                                                                <h6 class="mb-0"></h6>
                                                                <span class="text-muted"><strong>{{ $planformationuser->name .' '. $planformationuser->prenom_users}}</strong></span>
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                                <div class="d-flex align-items-center">

                                                                        <div class="row ">
                                                                            <div>
                                                                                <span>Observation : <?php echo $planformationuser->commentaire_plan_formation; ?></span>
                                                                            </div>
                                                                            <div>
                                                                                <span>Validé le  {{ $planformationuser->date_commentaire_plan_formation }}</span>
                                                                            </div>
                                                                        </div>


                                                                </div>

                                                            </div>
                                                        </div>
                                                    </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>




                    @foreach($infosactionplanformations as $infosactionplanformation)
                    <div class="col-md-4 col-12">
                        <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggleConseil<?php echo $infosactionplanformation->id_action_formation_plan; ?>"
                             aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;"
                             aria-hidden="true">
                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalToggleLabel">Commentaires </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="card">
                                        <h5 class="card-header">Recommandations</h5>
                                        <div class="card-body pb-2">
                                            <ul class="timeline pt-3">
                                                <?php $ResultatTraitement = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user($infosactionplanformation->id_action_formation_plan); ?>
                                                @foreach ($ResultatTraitement as $res)
                                                    <li class="timeline-item pb-4 timeline-item-<?php if($res->flag_traitement_par_critere_commentaire == true){ ?>success<?php }else if($res->flag_traitement_par_critere_commentaire == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                                    <span class="timeline-indicator-advanced timeline-indicator-<?php if($res->flag_traitement_par_critere_commentaire == true){ ?>success<?php }else if($res->flag_traitement_par_critere_commentaire == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                                      <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                    </span>
                                                        <div class="timeline-event">
                                                            <div class="timeline-header border-bottom mb-3">
                                                                <h6 class="mb-0">{{ $res->name }} {{ $res->prenom_users }} ({{ $res->profil }})</h6>
                                                                <span class="text-muted"><strong>Critère : {{ $res->libelle_critere_evaluation }}</strong></span>
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    @if($res->flag_traitement_par_critere_commentaire==true)
                                                                        <div class="row ">
                                                                            <div>
                                                                                <span>Observation : {{ $res->commentaire_critere }}</span>
                                                                            </div>
                                                                            <div>
                                                                                <span>Traité le  {{ $res->created_at }}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if($res->flag_traitement_par_critere_commentaire===false)
                                                                        <div class="row">
                                                                            <div>
                                                                                <span>Observation : {{ $res->commentaire_critere }}</span>
                                                                            </div>
                                                                            <div>
                                                                                <span class="badge bg-label-danger">Traité le {{ $res->created_at }}</span>
                                                                            </div> <br/><br/><br/>
                                                                            @if ($res->flag_traite_par_user_conserne != true)
                                                                            <div>

                                                                            </div>
                                                                            @else
                                                                            <div>
                                                                                <span>
                                                                                    Statut : @if ($res->flag_traitement_par_critere_commentaire_traiter == true)
                                                                                            Prise en compte
                                                                                        @else
                                                                                            Pas prise en compte
                                                                                        @endif
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <span>Reponse : {{ $res->commentaire_reponse }}</span>
                                                                            </div>
                                                                            @endif
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
                    @endforeach

        @endsection

        @else
        <script type="text/javascript">
            window.location = "{{ url('/403') }}";//here double curly bracket
        </script>
    @endif
