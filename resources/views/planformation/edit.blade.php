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

$idpart = Auth::user()->id_partenaire;

//dd($idpart);
?>

@if(auth()->user()->can('planformation-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Demandes')
    @php($titre='Liste des plans de formations')
    @php($soustitre='Modifier une demande de plan de formation')
    @php($lien='planformation')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript">

       // document.getElementById("Activeajoutercabinetformation").disabled = true;

        function changeFunction() {
            //alert('code');exit;

            var selectBox = document.getElementById("id_type_formation");
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;

           // alert(selectedValue);

            $.get('/caracteristiqueTypeFormationlist/'+selectedValue, function (data) {
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

                //function telUpdate() {
                //alert('testanc'); //exit;

                document.getElementById("Activeajoutercabinetformation").disabled = true;

                $.get('/entrepriseinterneplan', function (data) {
                     //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));


                    });
                });
                // }

            }

            if(selectedValue == 1 || selectedValue ==2 || selectedValue == 5){

                document.getElementById("Activeajoutercabinetformation").disabled = true;

                $.get('/entreprisecabinetformation', function (data) {
                     //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                    });
                });

            }


            if(selectedValue == 4){

                document.getElementById("Activeajoutercabinetformation").disabled = false;

                $.get('/entreprisecabinetetrangerformation', function (data) {
                     //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                    });
                });

                //$('#Activeajoutercabinetformation').removeAttr('disabled');
               // $('#cabinetetranger').modal('show');

            }




        };



    </script>
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
                          class="nav-link <?php if($idetape==1){ echo "active";} ?>"
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
                          class="nav-link <?php if($idetape==2){ echo "active";} //dd($activetab); echo $activetab; ?>"
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
                          class="nav-link <?php if($idetape==3){ echo "active";}else{ echo "disabled";} //dd($activetab); echo $activetab; ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-actionformation"
                          aria-controls="navs-top-actionformation"
                          aria-selected="false">
                          Actions du plan de formation
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-planformation" role="tabpanel">

                      <form method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(1)]) }}">
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
                                        <label>Secteur activité <strong style="color:red;">*</strong></label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                                value="{{@$infoentreprise->secteurActivite->libelle_secteur_activite}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Localisation géographique  <strong style="color:red;">*</strong></label>
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
                                        <label>Adresse postale <strong style="color:red;">*</strong></label>
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
                                                <label class="form-label">Téléphone  <strong style="color:red;">*</strong></label>
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
                                                <label class="form-label">Cellulaire Professionnelle  <strong style="color:red;">*</strong></label>
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
                                        <label>Nom et prénom du responsable formation <strong style="color:red;">*</strong></label>
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
                                        <label>Email professionnel du responsable formation <strong style="color:red;">*</strong></label>
                                        <input type="email" name="email_professionnel_charge_plan_formation" id="email_professionnel_charge_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->email_professionnel_charge_plan_formation}}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Nombre de salariés déclarés à la CNPS <strong style="color:red;">*</strong></label>
                                        <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->nombre_salarie_plan_formation}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Type entreprises <strong style="color:red;">*</strong></label>
                                        <select class="select2 form-select-sm input-group" name="id_type_entreprise" id="id_type_entreprise" required="required">
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
                                        <label>Part entreprise ({{ @$planformation->partEntreprise->valeur_part_entreprise }})</label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                                value="{{number_format(@$planformation->part_entreprise)}}" disabled="disabled">
                                    </div>
                                </div>
                                <!--<div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Seuil de cotisation </label>
                                        <input type="number"
                                               class="form-control form-control-sm"
                                                value="10000" disabled="disabled">
                                    </div>
                                </div>-->
                                <div class="col-12" align="right">
                                    <hr>
                                    <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                                        <button type="submit" name="action" value="Modifier"
                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Enregister
                                        </button>
                                    <?php } ?>


                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


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
                      <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-categorieplan" role="tabpanel">
                      <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                      <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(1)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <label class="form-label" for="id_categorie_professionelle">Catégories <strong style="color:red;">*</strong></label>
                                        <select
                                            id="id_categorie_professionelle"
                                            name="id_categorie_professionelle"
                                            class="select2 form-select-sm input-group"
                                            aria-label="Default select example" required="required">
                                            <?= $categorieprofessionelle; ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="genre_plan">Genre <strong style="color:red;">*</strong></label>
                                        <select
                                            id="genre_plan"
                                            name="genre_plan"
                                            class="select2 form-select-sm input-group"
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
                                            min="1"
                                            class="form-control form-control-sm"
                                            required="required" />
                                    </div>

                                        <div class="col-12 col-md-2" align="right"> <br>
                                            <button  type="submit" name="action" value="Enregistrer_categorie_plan" class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>
                                        </div>

                                </div>

                        </form>

                        <hr>
                        <?php } ?>
                        <table class="table table-bordered table-striped table-hover table-sm"
                            id=""
                            style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Catégorie </th>
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
                                               class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet effectif travailleur ?")) return false;'
                                               title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                               <?php } ?>
                                            </td>
                                            </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="col-12" align="right">
                            <hr>

                            <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>
                            <?php if (count($categorieplans)>=1){ ?>


                            <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


                            <?php } ?>

                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                Retour</a>
                        </div>
                      </div>
                      <div class="tab-pane fade <?php if($idetape==3){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-actionformation" role="tabpanel">
                      <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                      <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(3)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                            <div>
                            <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="nombre_stagiaire_action_formati"><strong style="color:green;">Budget credit</strong></label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ number_format(@$planformation->montant_financement_budget) }}"
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="nombre_stagiaire_action_formati"><strong style="color:red;">Budget credit restant</strong></label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ number_format(@$planformation->montant_financement_budget - $montantactionplanformation) }}"
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-12">
                            <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de formation <strong style="color:red;">*</strong></label>
                            <input
                                type="text"
                                id="intitule_action_formation_plan"
                                name="intitule_action_formation_plan"
                                class="form-control form-control-sm"
                                value="{{ old('intitule_action_formation_plan') }}"
                                 />
                            </div>


                            <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupes <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="nombre_groupe_action_formation_"
                                name="nombre_groupe_action_formation_"
                                class="form-control form-control-sm"
                                value="{{ old('nombre_groupe_action_formation_') }}"
                                 />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="nombre_heure_action_formation_p"
                                name="nombre_heure_action_formation_p"
                                class="form-control form-control-sm"
                                value="{{ old('nombre_heure_action_formation_p') }}"
                                 />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="cout_action_formation_plan">Coût de la formation <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="cout_action_formation_plan"
                                name="cout_action_formation_plan"
                                class="form-control form-control-sm"
                                value="{{ old('cout_action_formation_plan') }}"
                                 />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>
                            <select
                                id="id_type_formation"
                                name="id_type_formation"
                                class="select2 form-select-sm input-group"
                                aria-label="Default select example"
                                onchange="changeFunction();">
                                <?= $typeformation; ?>
                            </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="id_caracteristique_type_formation">Caracteristique type de formation <strong style="color:red;">*</strong></label>
                                <select id="id_caracteristique_type_formation" name="id_caracteristique_type_formation" class="select2 form-select-sm input-group">
                                    <option value='0'></option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12 col-md-10">
                                        <label class="form-label" for="structure_etablissement_action_">Structure ou établissement de formation <strong style="color:red;">*</strong></label>

                                        <select class="select2 form-select-sm input-group" name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation">
                                            <option value='0'></option>
                                            <?php //echo $structureformation; ?>
                                        </select>

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
                            <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>
                            <select
                                id="id_but_formation"
                                name="id_but_formation"
                                class="select2 form-select-sm input-group"
                                aria-label="Default select example" >
                                <?= $butformation; ?>
                            </select>
                            </div>
                            <div class="col-12 col-md-2">
                            <label class="form-label" for="date_debut_fiche_agrement">Date début de réalisation <strong style="color:red;">*</strong></label>
                            <input
                                type="date"
                                id="date_debut_fiche_agrement"
                                name="date_debut_fiche_agrement"
                                class="form-control form-control-sm"
                                value="{{ old('date_debut_fiche_agrement') }}"
                               />
                            </div>
                            <div class="col-12 col-md-2">
                            <label class="form-label" for="date_fin_fiche_agrement">Date fin de réalisation <strong style="color:red;">*</strong></label>
                            <input
                                type="date"
                                id="date_fin_fiche_agrement"
                                name="date_fin_fiche_agrement"
                                class="form-control form-control-sm"
                                value="{{ old('date_fin_fiche_agrement') }}"
                                />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>
                            <input
                                type="text"
                                id="lieu_formation_fiche_agrement"
                                name="lieu_formation_fiche_agrement"
                                class="form-control form-control-sm"
                                value="{{ old('lieu_formation_fiche_agrement') }}"
                                 />
                            </div>
                            <!--<div class="col-12 col-md-4">
                            <label class="form-label" for="cout_total_fiche_agrement">Cout total fiche agrement <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="cout_total_fiche_agrement"
                                name="cout_total_fiche_agrement"
                                class="form-control form-control-sm"
                                 />
                            </div>-->
                            <div class="col-md-4 col-12">
                                <label>Secteur d'activité <strong style="color:red;">*</strong></label>
                                <select class="select2 form-select"
                                                data-allow-clear="true" name="id_secteur_activite"
                                                id="id_secteur_activite">
                                    <option value="">-- Sélectionnez un secteur d'activité--- </option>
                                     @foreach ($secteuractivites as $activite)
                                        <option value="{{ $activite->id_secteur_activite }}">{{ mb_strtoupper($activite->libelle_secteur_activite) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                            <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="cadre_fiche_demande_agrement"
                                name="cadre_fiche_demande_agrement"
                                class="form-control form-control-sm"
                                min="0"
                                value="{{ old('cadre_fiche_demande_agrement') }}"
                                 />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="agent_maitrise_fiche_demande_ag"
                                name="agent_maitrise_fiche_demande_ag"
                                class="form-control form-control-sm"
                                min="0"
                                value="{{ old('agent_maitrise_fiche_demande_ag') }}"
                                 />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="employe_fiche_demande_agrement"
                                name="employe_fiche_demande_agrement"
                                class="form-control form-control-sm"
                                min="0"
                                value="{{ old('employe_fiche_demande_agrement') }}"
                                 />
                            </div>

                            <div class="col-12 col-md-4">
                            <label class="form-label" for="file_beneficiare">Charger les bénéficiaires de la formation (Excel) <strong style="color:red;">*</strong></label>
                            <input
                                type="file"
                                id="file_beneficiare"
                                name="file_beneficiare"
                                class="form-control form-control-sm"
                                />
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="facture_proforma_action_formati">Joindre la facture proforma (PDF) <strong style="color:red;">*</strong></label>
                            <input
                                type="file"
                                id="facture_proforma_action_formati"
                                name="facture_proforma_action_formati"
                                class="form-control form-control-sm"
                                 />
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>
                                <textarea class="form-control form-control-sm"  name="objectif_pedagogique_fiche_agre" id="objectif_pedagogique_fiche_agre" rows="6">{{ old('objectif_pedagogique_fiche_agre') }}</textarea>
                            </div>
                                </div>
<hr>

                            <div class="col-12" align="right">



                                <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>

                                <a href="/modelfichebeneficiaire/beneficiaire.xlsx" class="btn btn-sm btn-secondary me-sm-3 me-1"  target="_blank"> Modèle de la liste des bénéficiaires à télécharger</a>

                                <?php $budget = $planformation->part_entreprise - $montantactionplanformation; if($budget != 0){?>

                                    <button onclick='javascript:if (!confirm("Voulez-vous Ajouter cette action de plan de formation  ?")) return false;'  type="submit" name="action" value="Enregistrer_action_formation" class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer l’action de formation</button>

                                <?php } ?>

                                <?php if ($actifsoumission == true){ ?>
                                    <?php if (count($actionplanformations)>=1){ ?>
                                        <button onclick='javascript:if (!confirm("Voulez-vous soumettre le plan de formation à un conseiller ? . Cette action est irréversible.")) return false;'  type="submit" name="action" value="Enregistrer_soumettre_plan_formation" class="btn btn-sm btn-success me-sm-3 me-1">Soumettre le plan de formation</button>
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
                                <th>Intituler de l'action de formation </th>
                                <th>Structure ou établissement de formation</th>
                                <th>Nombre de stagiaires</th>
                                <th>Nombre de groupes</th>
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
                                                <td>{{ number_format($actionplanformation->cout_action_formation_plan) }}</td>

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



        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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


       @endsection
    @else
       <script type="text/javascript">
           window.location = "{{ url('/403') }}";//here double curly bracket
       </script>
   @endif
