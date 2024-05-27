<?php
/*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{

	}*/

$idconnect = Auth::user()->id;
$NumAgce = Auth::user()->num_agce;
$Iddepartement = Auth::user()->id_departement;
use App\Helpers\ConseillerParAgence;
use App\Helpers\ListeTraitementCritereParUser;
use App\Helpers\NombreActionValiderParLeConseiller;
use App\Helpers\ListePlanFormationSoumis;
$conseilleragence = ConseillerParAgence::get_conseiller_par_agence($NumAgce, $Iddepartement);
$conseillerplan = NombreActionValiderParLeConseiller::get_conseiller_valider_plan($planformation->id_plan_de_formation, Auth::user()->id);
$nombre = count($conseilleragence);
//dd($conseillerplan);
?>

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module = ' Comités')
    @php($titre = 'Liste des comites plénières')
    @php($soustitre = 'Tenue de comite plénière')
    @php($lien = 'traitementcomitetechniques')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
{{--
    <script type="text/javascript">
        document.getElementsByClassName("Activeajoutercabinetformation")[0].disabled = true;

        function changeFunction() {
            //alert('code');exit;

            var selectBox = document.getElementById("id_type_formation");
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;

            // alert(selectedValue);

            $.get('/caracteristiqueTypeFormationlist/' + selectedValue, function(data) {
                //alert(data); //exit;
                $('#id_caracteristique_type_formation').empty();
                $.each(data, function(index, tels) {
                    $('#id_caracteristique_type_formation').append($('<option>', {
                        value: tels.id_caracteristique_type_formation,
                        text: tels.libelle_ctf,
                    }));
                });
            });

            if (selectedValue == 3) {

                //function telUpdate() {
                //alert('testanc'); //exit;

                document.getElementById("Activeajoutercabinetformation").disabled = true;

                $.get('/entrepriseinterneplan', function(data) {
                    //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function(index, tels) {
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

            if (selectedValue == 1 || selectedValue == 2 || selectedValue == 5) {

                document.getElementById("Activeajoutercabinetformation").disabled = true;

                $.get('/entreprisecabinetformation', function(data) {
                    //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function(index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));

                        $.get('/domaineformation/'+tels.id_entreprises, function (data) {
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


            if (selectedValue == 4) {

                document.getElementById("Activeajoutercabinetformation").disabled = false;

                $.get('/entreprisecabinetetrangerformation', function(data) {
                    //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function(index, tels) {
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




        };
    </script> --}}

    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / {{ $titre }} /
        </span> {{ $soustitre }}
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

        @if ($errors->any())
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
                        <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-planformation" aria-controls="navs-top-planformation"
                                aria-selected="true">
                            Informations sur l'entreprise
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-categorieplan" aria-controls="navs-top-categorieplan"
                                aria-selected="false">
                            Nombre de salariés déclarés à la CNPS
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-actionformation" aria-controls="navs-top-actionformation"
                                aria-selected="false">
                            Actions du plan de formation
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-recevabilite" aria-controls="navs-top-recevabilite"
                                aria-selected="false">
                            Cahier
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade" id="navs-top-planformation" role="tabpanel">

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>N° de compte contribuable </label>
                                    <input type="text" class="form-control form-control-sm"
                                           value="{{ @$infoentreprise->ncc_entreprises }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Secteur activité <strong style="color:red;">*</strong></label>
                                    <input type="text" class="form-control form-control-sm"
                                           value="{{ @$infoentreprise->secteurActivite->libelle_secteur_activite }}"
                                           disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Localisation géographique </label>
                                    <input type="text" name="localisation_geographique_entreprise"
                                           id="localisation_geographique_entreprise" class="form-control form-control-sm"
                                           value="{{ @$infoentreprise->localisation_geographique_entreprise }}"
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Repère d'accès </label>
                                    <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                           class="form-control form-control-sm"
                                           value="{{ @$infoentreprise->repere_acces_entreprises }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Adresse postale </label>
                                    <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                           class="form-control form-control-sm"
                                           value="{{ @$infoentreprise->adresse_postal_entreprises }}" disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="billings-country">Indicatif</label>
                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                    disabled="disabled">
                                                <?= $pay ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Téléphone </label>
                                            <input type="text" class="form-control form-control-sm"
                                                   value="{{ @$infoentreprise->tel_entreprises }}" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="billings-country">Indicatif</label>
                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                    disabled="disabled">
                                                <?= $pay ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Cellulaire Professionnelle </label>
                                            <input type="number" name="cellulaire_professionnel_entreprises"
                                                   id="cellulaire_professionnel_entreprises"
                                                   class="form-control form-control-sm"
                                                   value="{{ @$infoentreprise->cellulaire_professionnel_entreprises }}"
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
                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                    disabled="disabled">
                                                <?= $pay ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Fax </label>
                                            <input type="number" name="fax_entreprises" id="fax_entreprises"
                                                   class="form-control form-control-sm"
                                                   value="{{ @$infoentreprise->fax_entreprises }}" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Type entreprise </label>
                                    <select class="select2 form-select-sm input-group" name="id_type_entreprise"
                                            id="id_type_entreprise" disabled="disabled">
                                        <?php echo $typeentreprise; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Nom et prénoms du responsable formation </label>
                                    <input type="text" name="nom_prenoms_charge_plan_formati"
                                           id="nom_prenoms_charge_plan_formati" class="form-control form-control-sm"
                                           value="{{ @$planformation->nom_prenoms_charge_plan_formati }}"
                                           disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Fonction du responsable formation </label>
                                    <input type="text" name="fonction_charge_plan_formation"
                                           id="fonction_charge_plan_formation" class="form-control form-control-sm"
                                           value="{{ @$planformation->fonction_charge_plan_formation }}"
                                           disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Email professionnel du responsable formation </label>
                                    <input type="email" name="email_professionnel_charge_plan_formation"
                                           id="email_professionnel_charge_plan_formation"
                                           class="form-control form-control-sm"
                                           value="{{ @$planformation->email_professionnel_charge_plan_formation }}"
                                           disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Nombre de salariés déclarés à la CNPS </label>
                                    <input type="number" name="nombre_salarie_plan_formation"
                                           id="nombre_salarie_plan_formation" class="form-control form-control-sm"
                                           value="{{ @$planformation->nombre_salarie_plan_formation }}" disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">

                                    <label>Masse salariale brute annuelle prévisionnelle </label>
                                    <input type="text" name="masse_salariale" id="masse_salariale"
                                           class="form-control form-control-sm"
                                           value="{{ number_format(@$planformation->masse_salariale, 0, ',', ' ') }}"
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="mb-1">

                                    <label>Part entreprise
                                        ({{ @$planformation->partEntreprise->valeur_part_entreprise }})</label>
                                    <input type="text" name="part_entreprise" id="part_entreprise"
                                           class="form-control form-control-sm"
                                           value="{{ number_format(@$planformation->part_entreprise, 0, ',', ' ') }}"
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="mb-1">

                                    <label>Part entreprise déterminé</label>
                                    <input type="text" name="part_entreprise_previsionnel"
                                           id="part_entreprise_previsionnel" class="form-control form-control-sm"
                                           value="{{ number_format(@$planformation->part_entreprise_previsionnel, 0, ',', ' ') }}"
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">

                                    <label>Budget de financement </label>
                                    <input type="text" name="montant_financement_budget"
                                           id="montant_financement_budget" class="form-control form-control-sm"
                                           value="{{ number_format(@$planformation->montant_financement_budget, 0, ',', ' ') }}"
                                           disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <div class="mb-1">

                                    <label>Le coût demandé </label>
                                    <input type="text" name="cout_total_demande_plan_formation"
                                           id="cout_total_demande_plan_formation" class="form-control form-control-sm"
                                           value="{{ number_format(@$planformation->cout_total_demande_plan_formation, 0, ',', ' ') }}"
                                           disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <div class="mb-1">

                                    <label>Le coût accordé </label>
                                    <input type="text" name="cout_total_accorder_plan_formation"
                                           id="cout_total_accorder_plan_formation" class="form-control form-control-sm"
                                           value="{{ number_format(@$planformation->cout_total_accorder_plan_formation, 0, ',', ' ') }}"
                                           disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">

                                    <label>Code plan </label>
                                    <input type="text" name="code_plan_formation" id="code_plan_formation"
                                           class="form-control form-control-sm"
                                           value="{{ @$planformation->code_plan_formation }}" disabled="disabled">
                                </div>
                            </div>

                            <div class="col-12" align="right">
                                <hr>


                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                    Retour</a>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="navs-top-categorieplan" role="tabpanel">

                        <table class="table table-bordered table-striped table-hover table-sm" id=""
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
                                    <?php $i += 1; ?>
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


                    <div class="tab-pane fade show active" id="navs-top-actionformation" role="tabpanel">

                        <div class="col-12" align="right">

                            <div class="row">


                                <div class="col-7">
                                </div>
                                <div class="col-4">

                                </div>
                                <div class="col-1">
                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                       href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($idcomite), \App\Helpers\Crypt::UrlCrypt(1)]) }}">
                                        Retour</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Intitulé de l'action de formation </th>
                                <th>Structure ou établissement de formation</th>
                                <th>Coût de l'action</th>
                                <th>Coût de financement</th>
                                <th>Coût de l'action accordée</th>
                                <th>Statut traitement</th>
                                <th>Statut critère</th>
                                <th>Commentaire</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @foreach ($actionplanformations as $key => $actionplanformation)
                                    <?php $i += 1; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $actionplanformation->intitule_action_formation_plan }}</td>
                                    <td>{{ $actionplanformation->structure_etablissement_action_ }}</td>
                                    <td>{{ number_format($actionplanformation->cout_action_formation_plan, 0, ',', ' ') }}
                                    </td>
                                    <td>{{ number_format($actionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}
                                    </td>
                                    <td>{{ number_format($actionplanformation->cout_accorde_action_formation, 0, ',', ' ') }}
                                    </td>
                                    <td align="center">
                                        @if (@$planformation->user_conseiller == Auth::user()->id)
                                            @if ($actionplanformation->flag_action_formation_traiter_comite_technique == true)
                                                <span class="badge bg-success">Traité</span>
                                            @else
                                                <span class="badge bg-warning">Non traité</span>
                                            @endif
                                        @else
                                                <?php
                                                $value = ListeTraitementCritereParUser::get_traitement_crietere_par_user(Auth::user()->id, $actionplanformation->id_action_formation_plan);

                                                echo $value;
                                                ?>
                                        @endif
                                    </td>
                                    <td align="center">
                                            <?php
                                            $statuttotal = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user_statut_total($actionplanformation->id_action_formation_plan);
                                            $statuttraitesucces = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user_statut_success($actionplanformation->id_action_formation_plan);
                                            $statuttraiteechec = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user_statut_echec($actionplanformation->id_action_formation_plan);
                                            $statuttraiteechecreponse = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user_statut_echec_traiter($actionplanformation->id_action_formation_plan);

                                            //dd(count($statuttotal),count($statuttraitesucces),count($statuttraiteechec),count($statuttraiteechecreponse));
                                            ?>
                                        @if(count($statuttraiteechec) != 0 and count($statuttraiteechecreponse) !=0)
                                                <?php $res = count($statuttraiteechec) - count($statuttraiteechecreponse); //echo $res;?>
                                            @if ($res != 0)
                                                <span class="badge bg-danger">avis non traité <strong style="">(<?php echo $res;?>)</strong></span>
                                            @else
                                                <span class="badge bg-success">avis traité</span>
                                            @endif
                                        @endif

                                        @if(count($statuttraiteechec) == 0 and count($statuttraiteechecreponse) !=0)
                                            <span class="badge bg-danger">avis non traité </span>
                                        @endif

                                        @if(count($statuttraiteechec) != 0 and count($statuttraiteechecreponse) ==0)
                                            <span class="badge bg-danger">avis non traité <strong style="">(<?php echo count($statuttraiteechec);?>)</strong></span>
                                        @endif

                                        @if(count($statuttraiteechec) == 0 and count($statuttraiteechecreponse) ==0 and count($statuttotal)==0 and count($statuttraitesucces)==0)
                                            <span class="badge bg-warning">avis non traité</span>
                                        @endif

                                        @if(count($statuttotal) == count($statuttraitesucces) and count($statuttotal)>0 and count($statuttraitesucces)>0)
                                            <span class="badge bg-success">avis traité</span>
                                        @endif

                                    </td>
                                    <td align="center" nowrap>


                                        @if ($planformation->user_conseiller == Auth::user()->id)
{{--                                             <button type="button"
                                                    class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalToggleConseil<?php echo $actionplanformation->id_action_formation_plan; ?>">
                                                Voir commentaire
                                            </button> --}}
                                            <button type="button" class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light Consultercommentairereponse" data-bs-toggle="modal"
                                                data-id="{{\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)}}"
                                                data-bs-target="#Consultercommentairereponse" href="#">
                                                Voir commentaire
                                            </button>
                                        @else
                                            <button type="button" class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light Consultercommentaire" data-bs-toggle="modal"
                                                data-id="{{\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)}}"
                                                data-bs-target="#Consultercommentaire" href="#">
                                                Voir commentaire
                                            </button>
                                        @endif

                                    </td>
                                    <td align="center" nowrap>
                                        @can($lien . '-edit')
                                            @if ($planformation->user_conseiller == Auth::user()->id)
                                                <a type="button" class="traiterActionFomationPlan" data-bs-toggle="modal"
                                                data-id="{{\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)}}"
                                                data-bs-target="#traiterActionFomationPlan" href="#"> <img src='/assets/img/editing.png'>
                                            </a>
                                            @else
                                                <a type="button" class="traiterActionFomationPlan" data-bs-toggle="modal"
                                                    data-id="{{\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)}}"
                                                    data-bs-target="#traiterActionFomationPlan" href="#"> <img src='/assets/img/editing.png'>
                                                </a>
                                            @endif
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="navs-top-recevabilite" role="tabpanel">



                    </div>
                    <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="traiterActionFomationPlan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Traitement d'une action de plan de formation</h3>
                        <p class="text-muted"></p>
                    </div>
                        {{-- <form id="editUserForm" class="row g-3" method="POST" action="{{ route($lien . '.cahierupdate', [\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan), \App\Helpers\Crypt::UrlCrypt($idcomite), \App\Helpers\Crypt::UrlCrypt($idetape)]) }}"> --}}
                        @if($planformation->user_conseiller == Auth::user()->id)
                            <form id="ajax_taitement_par_action_conseiller" class="row g-3 actionformationConseillerForm">
                                @csrf
                                @method('post')


                                <div class="col-12 col-md-9">
                                <label class="form-label" for="raison_social_entreprises">Entreprise</label>
                                <input
                                    type="text" id="raison_social_entreprises"
                                    class="form-control form-control-sm"
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
                                    <input class="form-control  @error('objectif_pedagogique_fiche_agre') error @enderror" type="text" id="objectif_pedagogique_fiche_agre_val" name="objectif_pedagogique_fiche_agre"/>
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
                                            <select class="select2 form-select form-select-sm" multiple data-allow-clear="true" name="id_but_formation[]" id="but_formation">
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
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire instruction : </label>
                                        <textarea class="form-control form-control-sm"  name="commentaire_action_formation" id="commentaire_action_formation" rows="6" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire comité technique: </label>
                                        <textarea class="form-control form-control-sm"  name="commentaire_comite_technique" id="commentaire_comite_technique" rows="6" required></textarea>
                                    </div>
                                </div>

                                <div class="col-12 text-center" id="valide_comite_technique_action_formation">
                                    <div class="mb-1" style="text-align: center">
                                        <input type="checkbox" class="form-check-input" name="is_valide" id="colorCheck1" onclick="myFunctionMAJ()">
                                        <label><strong class="bg-label-info">Validé le traitement apres modification</strong> </label>
                                    </div>
                                    <br/>
                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous corrigé cette action ?")) return false;'
                                        type="submit" name="action" value="Traiter_action_formation_valider_correction"
                                        class="btn btn-warning me-sm-3 me-1 btn-submit" id="Traiter_action_formation_valider_correction">A corriger</button>


                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous Traité cette action ?")) return false;'
                                        type="submit" name="action" value="Traiter_action_formation_valider"
                                        class="btn btn-success me-sm-3 me-1 btn-submit" id="Traiter_action_formation_valider" disabled>Valider</button>

                                    <button
                                        type="reset"
                                        class="btn btn-label-secondary"
                                        data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Annuler
                                    </button>
                                </div>
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="valide_comite_technique_action_formation_success">
                                    <div class="alert-body" style="text-align: center;">
                                        Vous avez déjà traité cette action
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </form>
                        @else
                            <form id="ajax_taitement_par_action" class="row g-3 actionformationForm">
                                @csrf
                                @method('post')
                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="masse_salariale">Entreprise</label>
                                    <input
                                    type="text" id="raison_social_entreprises"
                                    class="form-control form-control-sm"
                                    disabled="disabled" />
                                </div>


                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de
                                        formation</label>
                                        <input
                                        type="text" id="intitule_action_formation_plan"
                                        class="form-control form-control-sm"
                                        name="intitule_action_formation_plan" disabled="disabled"
                                    />
                                </div>
                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>
                                    <input class="form-control  @error('objectif_pedagogique_fiche_agre') error @enderror" type="text" id="objectif_pedagogique_fiche_agre_val" name="objectif_pedagogique_fiche_agre" disabled="disabled"/>
                                    <div id="objectif_pedagogique_fiche_agre" class="rounded-1 objectif_pedagogique_fiche_agre"></div>
                                @error('objectif_pedagogique_fiche_agre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="masse_salariale">Masse salariale</label>
                                    <input
                                    type="text" id="masse_salariale_ins"
                                    class="form-control form-control-sm number"
                                    disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="part_entreprise">Part entreprise</label>
                                    <input type="text" name="part_entreprise" id="part_entreprise"
                                    class="form-control form-control-sm" value="{{number_format(@$planformation->part_entreprise, 0, ',', ' ')}}" disabled="disabled">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="structure_etablissement_action_">Etablissement de formation</label>
                                    <select class="select2 form-select-sm input-group @error('id_entreprise_structure_formation_plan_formation')
                                    error
                                    @enderror" name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation" disabled="disabled">
                                    </select>
                                    @error('id_entreprise_structure_formation_plan_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de bénéficiaires de l’action de formation</label>
                                        <input
                                        type="number" id="nombre_stagiaire_action_formati"
                                        class="form-control form-control-sm"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupes</label>
                                    <input
                                    type="number" id="nombre_groupe_action_formation_"
                                    class="form-control form-control-sm"
                                    name="nombre_groupe_action_formation_" disabled="disabled"
                                />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par
                                        groupes</label>
                                        <input
                                        type="number" id="nombre_heure_action_formation_p"
                                        class="form-control form-control-sm"
                                        name="nombre_heure_action_formation_p" disabled="disabled"
                                    />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="nombre_jour_action_formation">Nombre de jours</label>
                                    <input
                                    type="text" id="nombre_jour_action_formation"
                                    class="form-control form-control-sm"
                                    disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Coût de la formation</label>
                                    <input
                                    type="text" id="cout_action_formation_plan"
                                    class="form-control form-control-sm number"
                                    disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Type de formation</label>
                                        <select
                                        id="id_type_formation"
                                        name="id_type_formation"
                                        class="select2 form-select-sm input-group @error('id_type_formation')
                                        error
                                        @enderror"

                                        aria-label="Default select example" disabled="disabled">
                                        @foreach ($typeformationss as $typeformation)
                                            <option value="{{$typeformation->id_type_formation}}">{{mb_strtoupper($typeformation->type_formation)}}</option>
                                        @endforeach

                                    </select>
                                    @error('id_type_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Caractéristique type de formation</label>

                                <select id="id_caracteristique_type_formation" name="id_caracteristique_type_formation" class="select2 form-select-sm input-group @error('id_caracteristique_type_formation')
                                        error
                                        @enderror" disabled="disabled">
                                        </select>
                                        @error('id_caracteristique_type_formation')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                </div>
                                <div class="col-md-3 col-12" id="id_domaine_formation_div">
                                    <label>Domaine de formation <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select-sm input-group @error('id_domaine_formation')
                                    error
                                    @enderror"
                                                    data-allow-clear="true" name="id_domaine_formation"
                                                    id="id_domaine_formation" disabled="disabled">
                                    </select>
                                    @error('id_domaine_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="date_debut_fiche_agrement">Date début de
                                        réalisation</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ @$infosactionplanformation->date_debut_fiche_agrement }}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="date_fin_fiche_agrement">Date fin de réalisation</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ @$infosactionplanformation->date_fin_fiche_agrement }}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation</label>
                                    <input
                                        type="text"
                                        id="lieu_formation_fiche_agrement"
                                        name="lieu_formation_fiche_agrement"
                                        class="form-control form-control-sm @error('lieu_formation_fiche_agrement')
                                        error
                                        @enderror"
                                        disabled="disabled"/>
                                        @error('lieu_formation_fiche_agrement')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres</label>
                                    <input
                                    type="number" id="cadre_fiche_demande_agrement"
                                    class="form-control form-control-sm"
                                    name="cadre_fiche_demande_agrement" disabled="disabled"
                                    />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de
                                        maitrise</label>
                                        <input
                                        type="number" id="agent_maitrise_fiche_demande_ag"
                                        class="form-control form-control-sm"
                                        name="agent_maitrise_fiche_demande_ag" disabled="disabled"
                                    />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés /
                                        ouvriers</label>
                                        <input
                                        type="number" id="employe_fiche_demande_agrement"
                                        class="form-control form-control-sm"
                                        name="employe_fiche_demande_agrement"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="cout_total_fiche_agrement">Coût de financement</label>
                                    <input
                                    type="text" id="montant_attribuable_fdfp"
                                    class="form-control form-control-sm number"
                                    disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="cout_accorde_action_formation">Montant accordée</label>
                                    <input type="text" name="cout_accorde_action_formation" id="cout_accorde_action_formation" class="number form-control form-control-sm number" disabled="disabled">
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="mb-1">
                                        <label>Facture proforma </label> <br>
                                        <span class="badge bg-secondary"><a target="_blank"
                                                onclick="NewWindow('{{ asset('/pieces/facture_proforma_action_formation/' . @$infosactionplanformation->facture_proforma_action_formati) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                Voir la pièce </a> </span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-1">
                                        <label class="form-label" for="">But de la formation </label>

                                        <select class="select2 form-select form-select-sm" multiple data-allow-clear="true" name="id_but_formation[]" id="but_formation" disabled="disabled">
                                            @foreach ($butformations as $pc)
                                                <option value="{{ $pc->id_but_formation }}">
                                                    {{$pc->but_formation}}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="cout_accorde_action_formation">Commentaire</label>

                                        <textarea class="form-control form-control-sm"  name="commentaire_action_formation" id="commentaire_action_formation" rows="6" disabled="disabled"></textarea>
                                </div>

                                <hr />

                                <div class="card card-custom" style="width: 100%" id="divcritere">
                                    <h2>Critères évaluations</h2>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover table-checkable"
                                            style="margin-top: 13px !important">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Critère</th>
                                                    <th>status</th>
                                                    <th>commentaire</th>
                                                </tr>
                                            </thead>
                                            <tbody id="critere">

                                            </tbody>
                                        </table>
                                    </div>
                                    <button
                                    onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;'
                                    type="submit" name="action"
                                    value="Traiter_action_formation_valider_critere"
                                    class="btn btn-success me-sm-3 me-1 btn-submit">Valider</button>
                                </div>



                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="divcriteresuccess">
                                    <div class="alert-body" style="text-align: center;">
                                        Vous avez déjà traité ce dossier
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>


                            </form>
                        @endif

                </div>
            </div>
        </div>
    </div>

    <div class="modal animate_animated animate_fadeInDownBig fade" id="Consultercommentaire"
        aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">Commentaires </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="card">
                    <h5 class="card-header">Mes appréciations</h5>
                    <div class="card-body pb-2" id="">
                        <ul class="timeline pt-3" id="commentaireappreciation">
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal animate_animated animate_fadeInDownBig fade" id="Consultercommentairereponse"
        aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">Commentaires </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="card">
                    <h5 class="card-header">Mes appréciations</h5>
                    <div class="card-body pb-2" id="">
                        <ul class="timeline pt-3" id="commentaireappreciationresponse">
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>


        <div class="modal fade" id="traiterActionFomationPlanConseiller" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Traitement d'une action de plan de formation</h3>
                    <p class="text-muted"></p>
                </div>

                </div>
            </div>
            </div>
        </div>
    @endsection


    <!-- Edit User Modal -->
    @section('js_perso')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/additional-methods.js')}}"></script>
    <script type="text/javascript">
        var id_type_formation_val;
        $("#id_type_formation").on("change", function() {
            id_type_formation_val = $(this).val();
            caracteristiqueTypeFormation(id_type_formation_val);

            //Pas de problème à ce niveau
            if(id_type_formation_val==3){
                $("#Activeajoutercabinetformation").prop( "disabled", true );
                //Recupération de l'entreprise ayant soumit le plan de formation
                $.get('{{url('/')}}/entrepriseinterneplanGeneral/{{$infoentreprise->id_entreprises}}', function (data) {
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                    });
                    domaineformations();
                });
            }

            //Pas de problème à ce niveau
            if(id_type_formation_val == 1 || id_type_formation_val ==2 || id_type_formation_val == 5){
                $("#Activeajoutercabinetformation").prop( "disabled", true );
                $.get('{{url('/')}}/entreprisecabinetformation', function (data) {
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                    });
                });
                domaineformation($("#id_entreprise_structure_formation_plan_formation").val());
            }

            //Pas de problème à ce niveau
            if(id_type_formation_val == 4){
                $('#Activeajoutercabinetformation').prop( 'disabled', false );
                //Recupération des cabinet etranger
                $.get('{{url('/')}}/entreprisecabinetetrangerformation', function (data) {
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, val) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: val.id_entreprises,
                            text: val.raison_social_entreprises,
                        }));
                    });
                });
                //Recupérer tous les domaines de formation dans le cas où l'entreprise est etrangère
                domaineformations();
            }
        });

        //Recuperation des domaine de formation en fonction des entreprises selectionnée
        $("#id_entreprise_structure_formation_plan_formation").on("change", function() {
            if(id_type_formation_val == 1 || id_type_formation_val ==2 || id_type_formation_val == 5){
                domaineformation($(this).val());
            }
        })

        function caracteristiqueTypeFormation(id_type_formation_val){
            $.get('{{url('/')}}/caracteristiqueTypeFormationlist/'+id_type_formation_val, function (data) {
                $('#id_caracteristique_type_formation').empty();
                $.each(data, function (index, val) {
                    $('#id_caracteristique_type_formation').append($('<option>', {
                        value: val.id_caracteristique_type_formation,
                        text: val.libelle_ctf,
                    }));
                });
            });
        }

        function domaineformations(){
            $.get('{{url('/')}}/domaineformations', function (data) {
                $('#id_domaine_formation').empty();
                $.each(data, function (index, val) {
                    $('#id_domaine_formation').append($('<option>', {
                        value: val.id_domaine_formation,
                        text: val.libelle_domaine_formation,
                    }));
                });
            });
        }

        function domaineformation(id_entreprises){
            $.get('{{url('/')}}/domaineformation/'+id_entreprises+'/listformation', function (data) {
                $('#id_domaine_formation').empty();
                $.each(data, function (index, tels) {
                    $('#id_domaine_formation').append($('<option>', {
                        value: tels.id_domaine_formation,
                        text: tels.libelle_domaine_formation,
                    }));
                });
            });
        }



            //Traitement Action formation
        //Initialisation des variables
        var id;
        var traiterActionFomationModal = $("#traiterActionFomationPlan");
        var traiterActionFomationPlanConseillerModal = $("#traiterActionFomationPlanConseiller");
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
        var commentaire_comite_technique = $("#commentaire_comite_technique");
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

        $(document).on('click', '.traiterActionFomationPlanConseiller', function () {
            id = $(this).data('id');
            traiterActionFomationPlanConseillerModal.modal('show');
            $.get("{{url('/')}}/traitementcomitetechniques/"+id+"/"+{{ $idconnect }}+"/informationaction",
                function (data) {
                    //console.log(id);
                   // console.log(data);
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
                    commentaire_comite_technique.val(data.information.commentaire_comite_technique);
                    if(data.information.date_debut_fiche_agrement!=null){
                        date_debut_fiche_agrement.val(data.information.date_debut_fiche_agrement.split(' ')[0]);
                    }

                    if(data.information.date_fin_fiche_agrement!=null){
                        date_fin_fiche_agrement.val(data.information.date_fin_fiche_agrement.split(' ')[0]);
                    }
                    nombre_stagiaire_action_formati.val(data.information.nombre_stagiaire_action_formati);
                    if(data.information.cout_accorde_action_formation<data.information.montant_attribuable_fdfp){
                        cout_accorde_action_formation.val(data.information.cout_action_formation_plan);
                    }else if(data.information.cout_action_formation_plan>data.information.montant_attribuable_fdfp){
                        cout_accorde_action_formation.val(data.information.montant_attribuable_fdfp);
                    }else{
                        cout_accorde_action_formation.val(data.information.montant_attribuable_fdfp);
                    }

                    const but = [];
                    $.each(data.butformations, function(key,val) {
                        but.push(val.id_but_formation);
                    });
                    but_formation.val(but).trigger('change');
                    objectif_pedagogique_fiche_agre.root.innerHTML = data.information.objectif_pedagogique_fiche_agre;
                    id_domaine_formation.append("<option selected value="+data.information.id_domaine_formation+">"+data.information.libelle_domaine_formation+"</option>");
                    id_entreprise_structure_formation_plan_formation.append("<option selected value="+data.information.id_entreprise_structure_formation_action+">"+data.information.structure_etablissement_action_+"</option>");
                    id_caracteristique_type_formation.append("<option selected value="+data.information.id_caracteristique_type_formation+">"+data.information.libelle_ctf+"</option>");
                   // console.log(data.traitement);


                }
            );
        });

        $(document).on('click', '.traiterActionFomationPlan', function () {
            id = $(this).data('id');
            traiterActionFomationModal.modal('show');
            $.get("{{url('/')}}/traitementcomitetechniques/"+id+"/"+{{ $idconnect }}+"/informationaction",
                function (data) {
                    //alert(id);
                    //console.log(data);
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
                    commentaire_comite_technique.val(data.information.commentaire_comite_technique);
                    if(data.information.date_debut_fiche_agrement!=null){
                        date_debut_fiche_agrement.val(data.information.date_debut_fiche_agrement.split(' ')[0]);
                    }

                    if(data.information.date_fin_fiche_agrement!=null){
                        date_fin_fiche_agrement.val(data.information.date_fin_fiche_agrement.split(' ')[0]);
                    }
                    nombre_stagiaire_action_formati.val(data.information.nombre_stagiaire_action_formati);
                    if(data.information.cout_accorde_action_formation<data.information.montant_attribuable_fdfp){
                        cout_accorde_action_formation.val(data.information.cout_action_formation_plan);
                    }else if(data.information.cout_action_formation_plan>data.information.montant_attribuable_fdfp){
                        cout_accorde_action_formation.val(data.information.montant_attribuable_fdfp);
                    }else{
                        cout_accorde_action_formation.val(data.information.montant_attribuable_fdfp);
                    }

                    const but = [];
                    $.each(data.butformations, function(key,val) {
                        but.push(val.id_but_formation);
                    });
                    but_formation.val(but).trigger('change');
                    objectif_pedagogique_fiche_agre.root.innerHTML = data.information.objectif_pedagogique_fiche_agre;
                    id_domaine_formation.append("<option selected value="+data.information.id_domaine_formation+">"+data.information.libelle_domaine_formation+"</option>");
                    id_entreprise_structure_formation_plan_formation.append("<option selected value="+data.information.id_entreprise_structure_formation_action+">"+data.information.structure_etablissement_action_+"</option>");
                    id_caracteristique_type_formation.append("<option selected value="+data.information.id_caracteristique_type_formation+">"+data.information.libelle_ctf+"</option>");
                   // console.log(data.traitement);
                    const nbretraitement = data.traitement;
                    if (nbretraitement == 0){
                        $("#divcritere").show();
                        $("#critere").empty();
                        $("#divcriteresuccess").hide();
                        $.each(data.criteres, function(key,val) {
                            $("#critere").append("<tr>"+
                                        "<td>"+parseInt(key+1)+"<input type=\"hidden\" class=\"form-control form-control-sm\" name=\"id_critere_evaluation/"+val.id_critere_evaluation+"\" value="+val.id_critere_evaluation+">"+
                                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.libelle_critere_evaluation+"\" disabled=\"disabled\" name=\"libelle_critere_evaluation/"+val.id_critere_evaluation+"\">"+
                                                "<td><select class=\"select2 form-select\" data-allow-clear=\"true\" name=\"flag_traitement_par_critere_commentaire/"+val.id_critere_evaluation+"\" id=\"flag_traitement_par_critere_commentaire/"+val.id_critere_evaluation+"\">"+
                                                    "<option value=\"\">-----------</option>"+
                                                    "<option value=\"true\">D'accord</option\>"+
                                                        "<option value=\"false\">Pas d'accord</option\>"+
                                                    "</select>"+
                                            "<td><textarea class=\"form-control form-control-sm\" name=\"commentaire_critere/"+val.id_critere_evaluation+"\" id=\"commentaire_critere/"+val.id_critere_evaluation+"\" rows=\"6\"></textarea>"
                                            +"</td></tr>")

                        });
                    }else{
                        $("#divcritere").hide();
                        $("#divcriteresuccess").show();
                    }

                    if (data.information.flag_action_formation_traiter_comite_technique == true){
                        $("#valide_comite_technique_action_formation").hide();
                        $("#valide_comite_technique_action_formation_success").show();
                    }else{
                        $("#valide_comite_technique_action_formation_success").hide();
                        $("#valide_comite_technique_action_formation").show();
                    }

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
            commentaire_comite_technique.empty();
            date_debut_fiche_agrement.empty();
            date_fin_fiche_agrement.empty();
            nombre_stagiaire_action_formati.empty();
            id_domaine_formation.empty();
            id_entreprise_structure_formation_plan_formation.empty();
            objectif_pedagogique_fiche_agre.root.innerHTML = '';
        }

        $(document).ready(function () {
                        $('#ajax_taitement_par_action').submit(function (e) {
                            e.preventDefault();

                            var formData = new FormData(this);

                            //console.log(formData);
                            //formData.append('_token','{!! csrf_token() !!}'),
                             $.ajax({
                                url: "{{url('/')}}/traitementcomitetechniques/"+id+"/update/action/formation",
                                type: 'post',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    //console(response);
                                    alert('Traitement effectué avec succès.');
                                    location.reload();
                                },
                                error: function(response){
                                    $('#ajax_taitement_par_action').find(".print-error-msg").find("ul").html('');
                                    $('#ajax_taitement_par_action').find(".print-error-msg").css('display','block');
                                    $.each( response.responseJSON.errors, function( key, value ) {
                                        $('#ajax_taitement_par_action').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                                    });
                                }
                            });
                        });
                    });

                    // choix du bouton
                    function myFunctionMAJ() {
                    // Get the checkbox
                    var checkBox = document.getElementById("colorCheck1");

                    // If the checkbox is checked, display the output text
                    if (checkBox.checked == true){
                        $("#Traiter_action_formation_valider").prop( "disabled", false );
                        $("#Traiter_action_formation_valider_correction").prop( "disabled", true );
                        //$("#Traiter_action_formation_valider_correction").hide();
                    } else {
                        $("#Traiter_action_formation_valider").prop( "disabled", true );
                        //$("#Traiter_action_formation_valider").hide();
                        $("#Traiter_action_formation_valider_correction").prop( "disabled", false );
                    }
                    }
                    // apport des coorection lors des comité technique

                    $(document).ready(function () {
                        $('#ajax_taitement_par_action_conseiller').submit(function (e) {
                            e.preventDefault();
                            var formData = new FormData(this);
                            //console.log(formData);

                             $.ajax({
                                url: "{{url('/')}}/traitementcomitetechniques/"+id+"/update/action/formation/corriger",
                                type: 'post',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    //console(response);
                                    alert('Traitement effectué avec succès.');
                                    location.reload();
                                },
                                error: function(response){
                                    $('#ajax_taitement_par_action_conseiller').find(".print-error-msg").find("ul").html('');
                                    $('#ajax_taitement_par_action_conseiller').find(".print-error-msg").css('display','block');
                                    $.each( response.responseJSON.errors, function( key, value ) {
                                        $('#ajax_taitement_par_action_conseiller').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                                    });
                                }
                            });
                        });
                    });

        //Commentaire autre personne

            var ConsultercommentaireModal = $("#Consultercommentaire");
            $(document).on('click', '.Consultercommentaire', function () {
                id = $(this).data('id');
                ConsultercommentaireModal.modal('show');
                $.get("{{url('/')}}/traitementcomitetechniques/"+id+"/commentairetoutuser",
                    function (data) {
                        $("#commentaireappreciation").empty();
                        //console.log(data);
                        //initvalue();
                        $.each(data.information, function(key,res) {
                            $("#commentaireappreciation").append("<li class=\"timeline-item pb-4 timeline-item-"+((res.flag_traitement_par_critere_commentaire==true)?"success ":((res.flag_traitement_par_critere_commentaire==false)?"primary ":"danger "))+"border-left-dashed\">"+
                                                "<span "+
                                                    "class=\"timeline-indicator-advanced timeline-indicator-"+((res.flag_traitement_par_critere_commentaire==true)?"success ":((res.flag_traitement_par_critere_commentaire==false)?"primary ":"danger "))+"\">"+
                                                    "<i class=\"ti ti-send rounded-circle scaleX-n1-rtl\"></i>"+
                                                "</span>"+
                                                "<div class=\"timeline-event\">"+
                                                    "<div class=\"timeline-header border-bottom mb-3\">"+
                                                        "<h6 class=\"mb-0\">" +res.name+""+ res.prenom_users +"( "+res.profil+" )</h6>"+
                                                        "<span class=\"text-muted\"><strong>Critère :"+
                                                                ""+ res.libelle_critere_evaluation+" </strong></span>"+
                                                    "</div>"+
                                                    "<div class=\"d-flex justify-content-between flex-wrap mb-2\">"+
                                                        "<div class=\"d-flex align-items-center\">"+

                                                                "<div class=\"row\">"+
                                                                    "<div>"+
                                                                        "<span>Observation :"+
                                                                            ""+res.commentaire_critere+" </span>"+
                                                                    "</div>"+
                                                                    "<div>"+
                                                                        "<span class=\""+((res.flag_traitement_par_critere_commentaire==false)?+"badge bg-label-danger" : "")+"\">Traité le  "+res.datej+" </span>"+
                                                                    "</div>"+
                                                                "</div>"+


                                                        "</div>"+

                                                    "</div>"+
                                                "</div>"+
                                            "</li>")

                        });

                    }
                );
            });

            //Commentaire response par personne

            var ConsultercommentaireReponseModal = $("#Consultercommentairereponse");
            $(document).on('click', '.Consultercommentairereponse', function () {
                id = $(this).data('id');
                ConsultercommentaireReponseModal.modal('show');
                $.get("{{url('/')}}/traitementcomitetechniques/"+id+"/commentairetoutuser",
                    function (data) {
                        $("#commentaireappreciationresponse").empty();
                        //console.log(data);
                        //initvalue();
                        $.each(data.information, function(key,res) {
                            //console.log(res)
                            $("#commentaireappreciationresponse").append("<li class=\"timeline-item pb-4 timeline-item-"+((res.flag_traitement_par_critere_commentaire==true)?"success ":((res.flag_traitement_par_critere_commentaire==false)?"primary ":"danger "))+"border-left-dashed\">"+
                                                "<span "+
                                                    "class=\"timeline-indicator-advanced timeline-indicator-"+((res.flag_traitement_par_critere_commentaire==true)?"success ":((res.flag_traitement_par_critere_commentaire==false)?"primary ":"danger "))+"\">"+
                                                    "<i class=\"ti ti-send rounded-circle scaleX-n1-rtl\"></i>"+
                                                "</span>"+
                                                "<div class=\"timeline-event\">"+
                                                    "<div class=\"timeline-header border-bottom mb-3\">"+
                                                        "<h6 class=\"mb-0\">" +res.name+""+ res.prenom_users +"( "+res.profil+" )</h6>"+
                                                        "<span class=\"text-muted\"><strong>Critère :"+
                                                                ""+ res.libelle_critere_evaluation+" </strong></span>"+
                                                    "</div>"+
                                                    "<div class=\"d-flex justify-content-between flex-wrap mb-2\">"+
                                                        "<div class=\"d-flex align-items-center\">"+
                                                                "<div class=\"row\">"+
                                                                    "<div>"+
                                                                        "<span>Observation :"+
                                                                            ""+res.commentaire_critere+" </span>"+
                                                                    "</div>"+
                                                                    "<div>"+
                                                                        "<span class=\""+((res.flag_traitement_par_critere_commentaire==false)?"badge bg-label-danger" : "")+"\">Traité le  "+res.datej+" </span>"+
                                                                    "</div>"+
                                                                "</div>"+
                                                                "<div>"+
                                                                    ((res.flag_traitement_par_critere_commentaire==false)?
                                                                    (res.flag_traite_par_user_conserne!=true?

                                                                   "<form id=\"editUserFormMessage\" class=\"row g-3\""+
                                                                                    "method=\"POST\""+
                                                                                    "action=\"{{url('/')}}/traitementcomitetechniques/"+id+"/{{\App\Helpers\Crypt::UrlCrypt($idcomite) }}/{{\App\Helpers\Crypt::UrlCrypt($idetape)}}/cahierupdate\">"+
                                                                                   "<input type=\"hidden\" name=\"_method\" value=\"PUT\">"+
                                                                                    "<input type=\"hidden\" name=\"_token\" value=\"{{csrf_token()}}\">"+
                                                                                    "<input type=\"hidden\""+
                                                                                        "name=\"id_traitement_par_critere_commentaire\""+
                                                                                        "value=\""+res.id_traitement_par_critere_commentaire+"\"/>"+
                                                                                    "<div class=\"row\">"+
                                                                                        "<div class=\"col-md-4 col-12\">"+
                                                                                            "<label class=\"form-label\" >Statut </label>"+
                                                                                            "<select class=\"select2 form-select\""+
                                                                                                "data-allow-clear=\"true\""+
                                                                                                "name=\"flag_traitement_par_critere_commentaire_traiter\""+
                                                                                                "id=\"flag_traitement_par_critere_commentaire_traiter\">"+
                                                                                                "<option value=\"\">-----------</option>"+
                                                                                                "<option value=\"true\">Prise en compte</option>"+
                                                                                                "<option value=\"false\">Pas prise en compte</option>"+
                                                                                            "</select>"+
                                                                                        "</div>"+
                                                                                        "<div class=\"col-md-6 col-12\">"+
                                                                                            "<label class=\"form-label\" >Reponse </label>"+
                                                                                            "<textarea class=\"form-control form-control-sm\" name=\"commentaire_reponse\" id=\"commentaire_reponse\" rows=\"6\"></textarea>"+
                                                                                        "</div>"+
                                                                                        "<div class=\"col-md-2 col-12\">"+
                                                                                            "<br />"+
                                                                                            "<button"+
                                                                                                " onclick=\'javascript:if (!confirm(\"Voulez-vous traité cette action ?\")) return false;'\""+
                                                                                                " type=\"submit\" name=\"action\""+
                                                                                                " value=\"Traiter_action_formation_valider_reponse\""+
                                                                                                " class=\"btn btn-warning btn-sm me-sm-3 me-1\">Traité</button>"+

                                                                                        "</div>"+
                                                                                    "</div>"+
                                                                                "</form>":"<div>"+
                                                                                "<span>Statut: "+((res.flag_traitement_par_critere_commentaire_traiter==true)? "Prise en compte":"Pas prise en compte")+
                                                                                "</span>"+
                                                                            "</div>"+
                                                                            "<div><span>Reponse :"+res.commentaire_reponse+
                                                                            "</span></div>"+
                                                                            "</div>"):"")+


                                                                            "</div>"+

                                                    "</div>"+
                                                "</div>"+
                                            "</li>")

                        });

                    }
                );
            });

        //Initialisation des variables
/*         var idbene;
        var traiterBeneficiaireModal = $("#traiterBeneficiaire");


        $(document).on('click', '.traiterBeneficiaire', function () {
            idbene = $(this).data('id');
            traiterBeneficiaireModal.modal('show');
            $("#beneficiaire").empty();
            $.get("{{url('/')}}/traitementplanformation/"+idbene+"/informationbeneficiaireaction",
            function (data) {
                $.each(data.information, function(key,val) {
                    $("#beneficiaire").append("<tr>"+
                        "<td><input type=\"hidden\" class=\"form-control form-control-sm\" name=\"id_beneficiaire_formation/"+val.id_beneficiaire_formation+"\" value="+val.id_beneficiaire_formation+">"+
                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.nom_prenoms+"\" name=\"nom_prenoms/"+val.id_beneficiaire_formation+"\">"+
                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.genre+"\" name=\"genre/"+val.id_beneficiaire_formation+"\">"+
                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.annee_naissance+"\" name=\"annee_naissance/"+val.id_beneficiaire_formation+"\">"+
                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.nationalite+"\" name=\"nationalite/"+val.id_beneficiaire_formation+"\">"+
                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.fonction+"\" name=\"fonction/"+val.id_beneficiaire_formation+"\">"+
                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.categorie+"\" name=\"categorie/"+val.id_beneficiaire_formation+"\">"+
                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.annee_embauche+"\" name=\"annee_embauche/"+val.id_beneficiaire_formation+"\">"+
                            "<td><input type=\"text\" class=\"form-control form-control-sm\" value=\""+val.matricule_cnps+"\" name=\"matricule_cnps/"+val.id_beneficiaire_formation+"\">"
                            +"</td></tr>")
                });
                    console.log(data);
                }
            );
        }); */

    </script>



@endsection
