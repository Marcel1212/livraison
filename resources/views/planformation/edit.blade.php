<?php
    /*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{
						
	}*/
?>
<?php

use App\Helpers\AnneeExercice;
use Carbon\Carbon;
$anneexercice = AnneeExercice::get_annee_exercice();
$dateday = Carbon::now()->format('d-m-Y');
$actifsoumission = false;

if(isset($anneexercice->id_periode_exercice)){
    $actifsoumission = true; 
}else{
    $actifsoumission = false; 
}

if(!empty($anneexercice->date_prolongation_periode_exercice)){
    $dateexercice = $anneexercice->date_prolongation_periode_exercice;
    if($dateday <= $dateexercice){
        $actifsoumission = true; 
    }else{
        $actifsoumission = false;
    }   
}



?>
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Demandes')
    @php($titre='Liste des plans de formations')
    @php($soustitre='Modifier une demande de plan de formations')
    @php($lien='planformation')


    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
    </h5>




    <div class="content-body">
    @if(!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{$anneexercice}}
                </div>
                <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
            </div>
         @endif       
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
                          Plan de formation
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?php if(count($categorieplans)<1){ echo "active";} //dd($activetab); echo $activetab; ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-categorieplan"
                          aria-controls="navs-top-categorieplan"
                          aria-selected="false">
                          Categorie des travailleurs
                        </button>
                      </li>                      
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?php if(count($categorieplans)>=1){ echo "active";}else{ echo "disabled";} //dd($activetab); echo $activetab; ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-actionformation"
                          aria-controls="navs-top-actionformation"
                          aria-selected="false">
                          Action de formation
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
                                        <label>N° de compte contribuable <strong style="color:red;">*</strong></label>
                                        <input type="text" 
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->ncc_entreprises}}" disabled="disabled">
                                    </div>
                                </div>                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Activité <strong style="color:red;">*</strong></label>
                                        <input type="text" 
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->activite->libelle_activites}}" disabled="disabled">
                                    </div>
                                </div>                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Localisation geaographique <strong style="color:red;">*</strong></label>
                                        <input type="text" name="localisation_geographique_entreprise" id="localisation_geographique_entreprise"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->localisation_geographique_entreprise}}" required="required">
                                    </div>
                                </div>                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Repère d'accès <strong style="color:red;">*</strong></label>
                                        <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->repere_acces_entreprises}}" required="required">
                                    </div>
                                </div>                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Adresse postal <strong style="color:red;">*</strong></label>
                                        <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->adresse_postal_entreprises}}" required="required">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Indicatif</label>
                                                <select class="select2 form-select-sm input-group-text" data-allow-clear="true" disabled="disabled">
                                                    <?= $pay; ?>
                                                </select>
                                            </div>                     
                                            <div class="col-md-8">
                                                <label class="form-label">Telephone  <strong style="color:red;">*</strong></label>
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
                                                <select class="select2 form-select-sm input-group-text" data-allow-clear="true" disabled="disabled">
                                                    <?= $pay; ?>
                                                </select>
                                            </div>                     
                                            <div class="col-md-8">
                                                <label class="form-label">Cellulaire Professionnelle  <strong style="color:red;">*</strong></label>
                                                <input type="number" name="cellulaire_professionnel_entreprises" id="cellulaire_professionnel_entreprises"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->cellulaire_professionnel_entreprises}}">
                                            </div>
                                        </div> 
                                    </div>
                                </div>     

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Indicatif</label>
                                                <select class="select2 form-select-sm input-group-text" data-allow-clear="true" disabled="disabled">
                                                    <?= $pay; ?>
                                                </select>
                                            </div>                     
                                            <div class="col-md-8">
                                                <label class="form-label">Fax  </label>
                                                <input type="number" name="fax_entreprises" id="fax_entreprises"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->fax_entreprises}}">
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Nom et prenom du responsable formation <strong style="color:red;">*</strong></label>
                                        <input type="text" name="nom_prenoms_charge_plan_formati" id="nom_prenoms_charge_plan_formati"
                                               class="form-control form-control-sm" value="{{@$planformation->nom_prenoms_charge_plan_formati}}">
                                    </div>
                                </div>                                
                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Fonction du responsable formation <strong style="color:red;">*</strong></label>
                                        <input type="text" name="fonction_charge_plan_formation" id="fonction_charge_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->fonction_charge_plan_formation}}">
                                    </div>
                                </div>                                
                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Email professsionel du responsable formation <strong style="color:red;">*</strong></label>
                                        <input type="email" name="email_professionnel_charge_plan_formation" id="email_professionnel_charge_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->email_professionnel_charge_plan_formation}}">
                                    </div>
                                </div>                                
                                
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Nombre total de salarié <strong style="color:red;">*</strong></label>
                                        <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->nombre_salarie_plan_formation}}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Type entreprises <strong style="color:red;">*</strong></label>
                                        <select class="select2 form-select input-group-text" name="id_type_entreprise" id="id_type_entreprise" required="required">
                                            <?php echo $typeentreprise; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Masse salariale <strong style="color:red;">*</strong></label>
                                        <input type="number" name="masse_salariale" id="masse_salariale"
                                               class="form-control form-control-sm" value="{{@$planformation->masse_salariale}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Part entreprise </label>
                                        <input type="number" 
                                               class="form-control form-control-sm"
                                                value="{{@$planformation->part_entreprise}}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-12" align="right">
                                    <hr>
                                    <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                                        <button type="submit" name="action" value="Modifier"
                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Modifier
                                        </button>
                                    <?php } ?>                                    
                                    
                                    <!--<button type="button"
                                            class="btn btn-sm btn-secondary me-1 waves-effect waves-float waves-light" data-bs-toggle="modal" data-bs-target="#ajoutActionFomationPlan">
                                        Ajouter action
                                    </button>-->

                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                        Retour</a>
                                </div>
                            </div>
                        </form>

                      </div>
                      <div class="tab-pane fade <?php if(count($categorieplans)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-categorieplan" role="tabpanel">
                      <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                      <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <label class="form-label" for="id_categorie_professionelle">Categorie <strong style="color:red;">*</strong></label>
                                        <select
                                            id="id_categorie_professionelle"
                                            name="id_categorie_professionelle"
                                            class="select2 form-select"
                                            aria-label="Default select example" required="required">
                                            <?= $categorieprofessionelle; ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="genre_plan">Genre <strong style="color:red;">*</strong></label>
                                        <select
                                            id="genre_plan"
                                            name="genre_plan"
                                            class="select2 form-select"
                                            aria-label="Default select example" required="required">
                                           <option value="">Selectionnez le genre</option>
                                           <option value="HOMMES">HOMMES</option>
                                           <option value="FEMMES">FEMMES</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="nombre_plan">Nombre <strong style="color:red;">*</strong></label>
                                        <input
                                            type="number"
                                            id="nombre_plan"
                                            name="nombre_plan"
                                            class="form-control form-control-sm"
                                            required="required" />
                                    </div>
                                   
                                        <div class="col-12 col-md-2" align="right"> <br>
                                            <button  type="submit" name="action" value="Enregistrer_categorie_plan" class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>
                                        </div> 
                                    
                                </div>
                                <?php if (count($categorieplans)>=4){ ?>
                                   <!-- <hr>
                                    
                                    <div class="col-12" align="right"> <br>
                                        <button  type="submit" name="action" value="Enregistrer_categorie_plan_suivant" class="btn btn-sm btn-secondary me-sm-3 me-1">Suivant</button>
                                    </div>-->
                                <?php } ?>
                        </form>
                       
                        <hr>
                        <?php } ?>
                        <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Categorie </th>
                                <th>Genre</th>
                                <th>Nombre</th>
                                <th>Action</th>
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
                                                <td>
                                                <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                                               <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($categorieplan->id_categorie_plan)) }}"
                                               class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cette categorie travailleurs ?")) return false;'
                                               title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                               <?php } ?>
                                            </td>
                                            </tr>                                    
                                @endforeach
                            
                            </tbody>
                        </table>
                      </div>
                      <div class="tab-pane fade <?php if(count($categorieplans)>=1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-actionformation" role="tabpanel">
                      <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                      <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation)) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="intitule_action_formation_plan">Inititule de l'action de formation <strong style="color:red;">*</strong></label>
                            <input
                                type="text"
                                id="intitule_action_formation_plan"
                                name="intitule_action_formation_plan"
                                class="form-control form-control-sm"
                                 />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="structure_etablissement_action_">Structure ou etablissemnt de formation <strong style="color:red;">*</strong></label>

                                <select class="select2 form-select" name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation">
                                    <?php echo $structureformation; ?>
                                 </select>
                                    
                            <!--<input
                                type="text"
                                id="structure_etablissement_action_"
                                name="structure_etablissement_action_"
                                class="form-control form-control-sm"
                                 />-->
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de stagiaires <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="nombre_stagiaire_action_formati"
                                name="nombre_stagiaire_action_formati"
                                class="form-control form-control-sm"
                                 />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupe <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="nombre_groupe_action_formation_"
                                name="nombre_groupe_action_formation_"
                                class="form-control form-control-sm"
                                 />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="nombre_heure_action_formation_p"
                                name="nombre_heure_action_formation_p"
                                class="form-control form-control-sm"
                                 />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="cout_action_formation_plan">Cout de la formation <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="cout_action_formation_plan"
                                name="cout_action_formation_plan"
                                class="form-control form-control-sm"
                                 />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>
                            <select
                                id="id_type_formation"
                                name="id_type_formation"
                                class="select2 form-select"
                                aria-label="Default select example" >
                                <?= $typeformation; ?>
                            </select>
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>
                            <select
                                id="id_but_formation"
                                name="id_but_formation"
                                class="select2 form-select"
                                aria-label="Default select example" >
                                <?= $butformation; ?>
                            </select>
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation <strong style="color:red;">*</strong></label>
                            <input
                                type="date"
                                id="date_debut_fiche_agrement"
                                name="date_debut_fiche_agrement"
                                class="form-control form-control-sm"
                               />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation <strong style="color:red;">*</strong></label>
                            <input
                                type="date"
                                id="date_fin_fiche_agrement"
                                name="date_fin_fiche_agrement"
                                class="form-control form-control-sm"
                                />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>
                            <input
                                type="text"
                                id="lieu_formation_fiche_agrement"
                                name="lieu_formation_fiche_agrement"
                                class="form-control form-control-sm"
                                 />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="cout_total_fiche_agrement">Cout total fiche agrement <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="cout_total_fiche_agrement"
                                name="cout_total_fiche_agrement"
                                class="form-control form-control-sm"
                                 />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pedagogique <strong style="color:red;">*</strong></label>
                            <input
                                type="text"
                                id="objectif_pedagogique_fiche_agre"
                                name="objectif_pedagogique_fiche_agre"
                                class="form-control form-control-sm"
                                 />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadre <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="cadre_fiche_demande_agrement"
                                name="cadre_fiche_demande_agrement"
                                class="form-control form-control-sm"
                                 />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agent de maitrise <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="agent_maitrise_fiche_demande_ag"
                                name="agent_maitrise_fiche_demande_ag"
                                class="form-control form-control-sm"
                                 />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employe / ouvriers <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="employe_fiche_demande_agrement"
                                name="employe_fiche_demande_agrement"
                                class="form-control form-control-sm"
                                 />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="file_beneficiare">Charger les beneficiaires de la formation (Excel) <strong style="color:red;">*</strong></label>
                            <input
                                type="file"
                                id="file_beneficiare"
                                name="file_beneficiare"
                                class="form-control form-control-sm"
                                />
                            </div>                        
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="facture_proforma_action_formati">Jointre les factures proforma (PDF) <strong style="color:red;">*</strong></label>
                            <input
                                type="file"
                                id="facture_proforma_action_formati"
                                name="facture_proforma_action_formati"
                                class="form-control form-control-sm"
                                 />
                            </div>
                            
                            
                            
                            
                            <div class="col-12" align="right"> 

                             
                                <br/>
                                <a href="/modelfichebeneficiaire/beneficiaire.xlsx" class="btn btn-sm btn-secondary me-sm-3 me-1"  target="_blank"> Model de la liste des beneficaires a telecharger</a>
                                <button onclick='javascript:if (!confirm("Voulez-vous Ajouter cet action de plan de formation  ?")) return false;'  type="submit" name="action" value="Enregistrer_action_formation" class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>

                                <?php if ($actifsoumission == true){ ?>
                                    <?php if (count($actionplanformations)>=1){ ?>
                                        <button onclick='javascript:if (!confirm("Voulez-vous soumettre le plan de formation à un conseiller ? . Cette action est irreversible")) return false;'  type="submit" name="action" value="Enregistrer_soumettre_plan_formation" class="btn btn-sm btn-success me-sm-3 me-1">Soumettre le plan de formation</button>
                                    <?php } ?>    
                                <?php } ?>    
                                

                            </div>
                            </div>
                        </form>
       
                        <hr/>
                        <?php } ?>
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
                                                        
                                                <td align="center">
                                                    @can($lien.'-edit')
                                                        <a onclick="NewWindow('{{ route($lien.".show",\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                           class=" "
                                                           title="Modifier"><img src='/assets/img/eye-solid.png'></a>                                                        
                                                        
                                                           <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                                                                    <a href="{{ route($lien.'.deleteapf',\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}"
                                                                    class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet action de plan de formation ?")) return false;'
                                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>

                                                            <?php } ?>    
                                                    @endcan

                                                </td>
                                            </tr>                                    
                                @endforeach
                            
                            </tbody>
                        </table>
                      </div>
                      <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

                      </div>
                    </div>
                  </div>
                </div>
    </div>

        @endsection

