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

                $.get('/entrepriseinterneplanGeneral/{{$infoentreprise->id_entreprises}}', function (data) {
                     //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                   // $("#id_domaine_formation").prop( "disabled", false );
                   // $("#id_domaine_formation_div").show();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));

                        $.get('/domaineformations', function (data) {
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
                // }

            }

            if(selectedValue == 1 || selectedValue ==2 || selectedValue == 5){

                document.getElementById("Activeajoutercabinetformation").disabled = true;

                $.get('/entreprisecabinetformation', function (data) {
                     //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                  //  $("#id_domaine_formation").prop( "disabled", false );
                  //  $("#id_domaine_formation_div").show();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                        $('#id_domaine_formation').empty();

/*                         $.get('/domaineformation/'+tels.id_entreprises, function (data) {
                            //alert(tels.id_entreprises); //exit;
                            //alert(data); //exit;
                            $('#id_domaine_formation').empty();
                            $.each(data, function (index, tels) {
                                $('#id_domaine_formation').append($('<option>', {
                                    value: tels.id_domaine_formation,
                                    text: tels.libelle_domaine_formation,
                                }));
                            });
                        }); */

                    });

                });

            }


            if(selectedValue == 4){

                document.getElementById("Activeajoutercabinetformation").disabled = false;

                $.get('/entreprisecabinetetrangerformation', function (data) {
                     //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                   // $('#id_domaine_formation').empty();
                    //$("#id_domaine_formation").prop( "disabled", true );
                    //$("#id_domaine_formation_div").hide();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));

                        $.get('/domaineformations', function (data) {
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

                //$('#Activeajoutercabinetformation').removeAttr('disabled');
               // $('#cabinetetranger').modal('show');

            }
        }
        function changeFunction1(){
            var SelectEntreprise = document.getElementById("id_entreprise_structure_formation_plan_formation");
            let SelectedEntrepriseValue = SelectEntreprise.options[SelectEntreprise.selectedIndex].value;
            //alert(SelectedEntrepriseValue);
            //$("#id_domaine_formation").prop( "disabled", false );
            //$("#id_domaine_formation_div").show();
            $('#id_domaine_formation').empty();
            $.get('/domaineformation/'+SelectedEntrepriseValue, function (data) {
                            //alert(data); //exit;
                            $('#id_domaine_formation').empty();
                            $.each(data, function (index, tels) {
                                $('#id_domaine_formation').append($('<option>', {
                                    value: tels.id_domaine_formation,
                                    text: tels.libelle_domaine_formation,
                                }));
                            });
                        });
        }
    </script>

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
                          Informations sur l'entreprise
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
                                        <label>Type entreprises <strong style="color:red;">*</strong></label>
                                        <select class="select2 form-select-sm input-group" name="id_type_entreprise" id="id_type_entreprise" required="required">
                                            <?php echo $typeentreprise; ?>
                                        </select>
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
                                        <label>Contact du responsable formation <strong style="color:red;">*</strong> </label>
                                        <input type="text" name="contact_professionnel_charge_plan_formation" id="contact_professionnel_charge_plan_formation"
                                            class="form-control form-control-sm" value="{{@$planformation->contact_professionnel_charge_plan_formation}}">
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Masse salariale brute annuelle prévisionnelle <strong style="color:red;">*</strong></label>
                                        <input type="text" name="masse_salariale" id="masse_salariale"
                                               onkeyup="FuncCalculPartENtre({{@$planformation->partEntreprise->valeur_part_entreprise }});"
                                               class="form-control form-control-sm number" value="{{number_format(@$planformation->masse_salariale, 0, ',', ' ')}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Part entreprise ({{ @$planformation->partEntreprise->valeur_part_entreprise }})</label>
                                        <input type="text" name="part_entreprise"
                                               class="form-control form-control-sm" id="part_entreprise"
                                                value="{{number_format(@$planformation->part_entreprise, 0, ',', ' ')}}" disabled="disabled">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Nombre de salariés déclarés à la CNPS <strong style="color:red;">*</strong></label>
                                        <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"
                                               class="form-control form-control-sm" value="{{@$planformation->nombre_salarie_plan_formation}}" disabled="disabled">
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


                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


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
                                            class="select2 form-select-sm @error('id_categorie_professionelle')
                                            error
                                            @enderror input-group"
                                            aria-label="Default select example" required="required">
                                            <?= $categorieprofessionelle; ?>
                                        </select>
                                        @error('id_categorie_professionelle')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="genre_plan">Genre <strong style="color:red;">*</strong></label>
                                        <select
                                            id="genre_plan"
                                            name="genre_plan"
                                            class="select2 form-select-sm @error('genre_plan')
                                            error
                                            @enderror input-group"
                                            aria-label="Default select example" required="required">
                                           <option value="">Selectionnez le genre</option>
                                           <option value="HOMMES">HOMMES</option>
                                           <option value="FEMMES">FEMMES</option>
                                        </select>
                                        @error('genre_plan')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="nombre_plan">Nombre <strong style="color:red;">*</strong></label>
                                        <input
                                            type="number"
                                            id="nombre_plan"
                                            name="nombre_plan"
                                            min="1"
                                            class="form-control form-control-sm @error('nombre_plan')
                                            error
                                            @enderror"
                                            required="required" value="{{ old('nombre_plan') }}"/>
                                            @error('nombre_plan')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                    </div>

                                        <div class="col-12 col-md-2" align="right"> <br>
                                            <button  type="submit" name="action" value="Enregistrer_categorie_plan" class="btn btn-sm btn-primary me-sm-3 me-1">Ajouter</button>
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

                            <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>
                            <?php if (count($categorieplans)>=1){ ?>


                            <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>


                            <?php } ?>

                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                Retour</a>
                        </div>
                      </div>
                      <div class="tab-pane fade <?php if($idetape==3){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-actionformation" role="tabpanel">

                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <div class="alert-body" style="text-align:center">
                                <strong>Les enregistrements sont fait par ordre de saisie.</strong>
                            </div>
                            <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
                        </div>

                      <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                      <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(3)]) }}" enctype="multipart/form-data" id="actionformationForm">
                                @csrf
                                @method('put')
                            <div>
                                <div class="col-md-12" align="right">


                                    <?php if ($actifsoumission == true){ ?>
                                        <?php if (count($actionplanformations)>=1){ ?>
                                            <!--<button type="button" id="SoummissionplanformationLuApprouve"
											class="btn btn-icon btn-succes waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#SoummissionplanformationLuApprouve" href="#myModal1" data-url="http://example.com">
                                            Soumettre le plan de formation
                                        </button>-->

                                    <button
                                    type="button"
                                    class="btn btn-outline-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#SoummissionplanformationLuApprouve1">
                                    Soumettre le plan de formation
                                  </button>
                                        <?php } ?>
                                    <?php } ?>


                                </div>
                            <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="nombre_stagiaire_action_formati"><strong style="color:green;">Budget crédit</strong></label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{ number_format(@$planformation->montant_financement_budget) }}"
                                    disabled="disabled"/>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="nombre_stagiaire_action_formati"><strong style="color:red;">Budget crédit restant</strong></label>
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
                                class="form-control form-control-sm @error('intitule_action_formation_plan')
                                error
                                @enderror"
                                value="{{ old('intitule_action_formation_plan') }}"
                                 />
                                 @error('intitule_action_formation_plan')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>


                            <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupes <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="nombre_groupe_action_formation_"
                                name="nombre_groupe_action_formation_"
                                class="form-control form-control-sm @error('nombre_groupe_action_formation_')
                                error
                                @enderror"
                                value="{{ old('nombre_groupe_action_formation_') }}"
                                 />
                                 @error('nombre_groupe_action_formation_')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="nombre_heure_action_formation_p"
                                name="nombre_heure_action_formation_p"
                                class="form-control form-control-sm @error('nombre_heure_action_formation_p')
                                error
                                @enderror"
                                value="{{ old('nombre_heure_action_formation_p') }}"
                                 />
                                 @error('nombre_heure_action_formation_p')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="cout_action_formation_plan">Coût de la formation <strong style="color:red;">*</strong></label>
                            <input
                                type="text"
                                id="cout_action_formation_plan"
                                name="cout_action_formation_plan"
                                class="form-control form-control-sm number @error('cout_action_formation_plan')
                                error
                                @enderror"
                                value="{{ old('cout_action_formation_plan') }}"
                                 />
                                 @error('cout_action_formation_plan')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>
                            <select
                                id="id_type_formation"
                                name="id_type_formation"
                                class="select2 form-select-sm input-group @error('id_type_formation')
                                error
                                @enderror"
                                aria-label="Default select example"
                                onchange="changeFunction();">
                                <?= $typeformation; ?>
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
                                    <option value='0'></option>
                                </select>
                                @error('id_caracteristique_type_formation')
                                <div class=""><label class="error">{{ $message }}</label></div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12 col-md-10">
                                        <label class="form-label" for="structure_etablissement_action_">Structure ou établissement de formation <strong style="color:red;">*</strong></label>

                                        <select class="select2 form-select-sm input-group @error('id_entreprise_structure_formation_plan_formation')
                                        error
                                        @enderror" name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation" onchange="changeFunction1();">
                                            <option value='0'></option>
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

                            <div class="col-md-4 col-12" id="id_domaine_formation_div">
                                <label>Domaine de formation <strong style="color:red;">*</strong></label>
                                <select class="select2 form-select @error('id_domaine_formation')
                                error
                                @enderror"
                                                data-allow-clear="true" name="id_domaine_formation"
                                                id="id_domaine_formation">
<option value='0'></option>
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
                                    value="{{ old('lieu_formation_fiche_agrement') }}"
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
                                value="{{ old('date_debut_fiche_agrement') }}"
                               />
                            </div>
                            <div class="col-12 col-md-2">
                            <label class="form-label" for="date_fin_fiche_agrement">Date fin de réalisation </label>
                            <input
                                type="date"
                                id="date_fin_fiche_agrement"
                                name="date_fin_fiche_agrement"
                                class="form-control form-control-sm"
                                value="{{ old('date_fin_fiche_agrement') }}"
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


                            <div class="col-12 col-md-4">
                            <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="cadre_fiche_demande_agrement"
                                name="cadre_fiche_demande_agrement"
                                class="form-control form-control-sm @error('cadre_fiche_demande_agrement')
                                error
                                @enderror"
                                min="0"
                                value="{{ old('cadre_fiche_demande_agrement') }}"
                                 />
                                 @error('cadre_fiche_demande_agrement')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="agent_maitrise_fiche_demande_ag"
                                name="agent_maitrise_fiche_demande_ag"
                                class="form-control form-control-sm @error('agent_maitrise_fiche_demande_ag')
                                error
                                @enderror"
                                min="0"
                                value="{{ old('agent_maitrise_fiche_demande_ag') }}"
                                 />
                                 @error('agent_maitrise_fiche_demande_ag')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers <strong style="color:red;">*</strong></label>
                            <input
                                type="number"
                                id="employe_fiche_demande_agrement"
                                name="employe_fiche_demande_agrement"
                                class="form-control form-control-sm @error('employe_fiche_demande_agrement')
                                error
                                @enderror"
                                min="0"
                                value="{{ old('employe_fiche_demande_agrement') }}"
                                 />
                                 @error('employe_fiche_demande_agrement')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong> <span style="color: blue">(Vous pouvez sélectionner plusieurs)</span></label>
                                <select
                                    id="id_but_formation"
                                    name="id_but_formation[]"
                                    class="select2 form-select input-group @error('id_but_formation')
                                    error
                                    @enderror"
                                    aria-label="Default select example" multiple>
                                    <?= $butformation; ?>
                                </select>
                                @error('id_but_formation')
                                <div class=""><label class="error">{{ $message }}</label></div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4">
                            <label class="form-label" for="file_beneficiare">Charger les bénéficiaires de la formation (Excel) <strong style="color:red;">*</strong></label>
                            <input
                                type="file"
                                id="file_beneficiare"
                                name="file_beneficiare"
                                class="form-control form-control-sm @error('file_beneficiare')
                                error
                                @enderror"
                                />
                                @error('file_beneficiare')
                                <div class=""><label class="error">{{ $message }}</label></div>
                                @enderror
                                <div id="defaultFormControlHelp" class="form-text ">
                                    <em> Fichiers autorisés : Excel <br></em>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                            <label class="form-label" for="facture_proforma_action_formati">Joindre la facture proforma <strong style="color:red;">*</strong></label>
                            <input
                                type="file"
                                id="facture_proforma_action_formati"
                                name="facture_proforma_action_formati"
                                class="form-control form-control-sm @error('facture_proforma_action_formati')
                                error
                                @enderror"
                                 />
                                 @error('facture_proforma_action_formati')
                                 <div class=""><label class="error">{{ $message }}</label></div>
                                 @enderror
                                 <div id="defaultFormControlHelp" class="form-text ">
                                    <em> Fichiers autorisés : PDF <br>Taille
                                        maxi : 5Mo</em>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12 mb-5">
                                <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>
                                <input class="form-control @error('objectif_pedagogique_fiche_agre') error @enderror" type="text" id="objectif_pedagogique_fiche_agre_val" name="objectif_pedagogique_fiche_agre"/>
                                <div id="objectif_pedagogique_fiche_agre" class="rounded-1">{{ old('objectif_pedagogique_fiche_agre') }}</div>
                               @error('objectif_pedagogique_fiche_agre')
                                <div class=""><label class="error">{{ $message }}</label></div>
                                @enderror
                            </div>
                        </div>
                                </div>
<hr>

                            <div class="col-md-12" align="right">

                                <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>

                                <a href="/modelfichebeneficiaire/beneficiaire.xlsx" class="btn btn-sm btn-secondary me-sm-3 me-1"  target="_blank"> Modèle de la liste des bénéficiaires à télécharger</a>

                                <?php $budget = $planformation->montant_financement_budget - $montantactionplanformation; if($budget > 0){?>

                                    <button onclick='javascript:if (!confirm("Voulez-vous Ajouter cette action de plan de formation  ?")) return false;'  type="submit" name="action" value="Enregistrer_action_formation" class="btn btn-sm btn-primary me-sm-3 me-1">Ajouter l’action de formation</button>

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
                                <th>Intitulé de l'action de formation </th>
                                <th>Structure ou établissement de formation</th>
                                <th>Nombre de stagiaires</th>
                                <th>Nombre de groupes</th>
                                <th>Nombre d'heures par groupe</th>
                                <th>Cout de l'action</th>
                                <th>Changer la priorité</th>
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
                                                <td align="rigth">{{ number_format($actionplanformation->cout_action_formation_plan, 0, ',', ' ') }}</td>
                                                <td>
                                                        <?php if ($planformation->flag_soumis_plan_formation != true){ ?>
                                                    @isset($actionplanformations)
                                                        @if($actionplanformation->pirorite_action_formation>1)
                                                            <a href="{{ route($lien.'.upapf',\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}"
                                                               class="btn btn-icon btn-xs btn-success" onclick='javascript:if (!confirm("Voulez-vous faire monter cette action de formation ?")) return false;'
                                                               title="Faire monter"> <span><i class="ti ti-caret-up"></i></span> </a>
                                                        @endif
                                                        @if($actionplanformation->pirorite_action_formation<count($actionplanformations))

                                                            <a href="{{ route($lien.'.downapf',\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}"
                                                               class="btn btn-icon btn-xs btn-dark" onclick='javascript:if (!confirm("Voulez-vous faire descendre cette action de formation ?")) return false;'
                                                               title="Faire descendre"> <span><i class="ti ti-caret-down"></i></span> </a>
                                                        @endif

                                                    @endisset

                                                    <?php } ?>
                                                </td>
                                                <td>
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


                <div
                class="modal fade"
                id="SoummissionplanformationLuApprouve1"
                tabindex="-1"
                aria-labelledby="SoummissionplanformationLuApprouve"
                aria-hidden="true"
              >
				<div class="modal-dialog modal-dialog-scrollable">
                  <div class="modal-content">
                    <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation),\App\Helpers\Crypt::UrlCrypt(3)]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                    <div class="modal-header">
                      <h5 class="modal-title" id="SoummissionplanformationLuApprouve">Soumission du plan de formation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p>
                                                    <?php
                                                    $message = "Je soussigné(e) <strong>$infoentreprise->nom_prenom_dirigeant</strong>, Directeur général, atteste l'exactitude des informations contenue dans ce document.

                                                    En cochant sur la mention <strong>Lu et approuvé</strong> ci-dessous, j'atteste cela.";
                                                    ?>
                                                    <?php echo wordwrap($message,144,"<br>\n"); ?>


                      </p>

                    </div>
                    <div class="modal-footer">



					                                                    <input type="checkbox" class="form-check-input" name="is_valide" id="colorCheck1" onclick="myFunctionMAJ()">
													<label>Lu et approuvé </label>
					  <button class="btn btn-success me-sm-3 me-1 btn-submit" type="submit" name="action" value="Enregistrer_soumettre_plan_formation" id="Enregistrer_soumettre_plan_formation" disabled>Valider le plan de formation</button>

                    </div>
                    </form>
                  </div>
                </div>
				</div>





                @endsection

                @section('js_perso')

                <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
                <script src="{{asset('assets/js/additional-methods.js')}}"></script>

            <script src="{{asset('assets/js/planformation/pages-soumission-plan-formation.js')}}"></script>

        {{-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
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


                var objectif_pedagogique_fiche_agre = new Quill('#objectif_pedagogique_fiche_agre', {
                    theme: 'snow'
                });

                $("#objectif_pedagogique_fiche_agre_val").hide();

                actionformationForm.onsubmit = function(){
                    //alert(objectif_pedagogique_fiche_agre.root.innerHTML);
                    $("#objectif_pedagogique_fiche_agre_val").val(objectif_pedagogique_fiche_agre.root.innerHTML);
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
                    function FuncCalculPartENtre(valeurpart) {
                        var ValueMS = document.getElementById("masse_salariale").value.replaceAll(' ','');
                        var partEntreprise = ValueMS*valeurpart;
                        document.getElementById('part_entreprise').setAttribute('value', partEntreprise.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, " "));
                    }
                </script>
       @endsection
    @else
       <script type="text/javascript">
           window.location = "{{ url('/403') }}";//here double curly bracket
       </script>
   @endif
