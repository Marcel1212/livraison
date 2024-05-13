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
    </script>

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
                                            <button type="button"
                                                    class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalToggleConseil<?php echo $actionplanformation->id_action_formation_plan; ?>">
                                                Voir commentaire
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalToggle<?php echo $actionplanformation->id_action_formation_plan; ?>">
                                                Voir commentaire
                                            </button>
                                        @endif

                                    </td>
                                    <td align="center" nowrap>
                                        @can($lien . '-edit')
                                            @if ($planformation->user_conseiller == Auth::user()->id)
                                                <a type="button" class="" data-bs-toggle="modal"
                                                   data-bs-target="#traiterActionFomationPlanConseil<?php echo $actionplanformation->id_action_formation_plan; ?>"
                                                   href="#myModal1" data-url="http://example.com">
                                                    <img src='/assets/img/editing.png'>
                                                </a>
                                            @else
                                                <a type="button" class="" data-bs-toggle="modal"
                                                   data-bs-target="#traiterActionFomationPlan<?php echo $actionplanformation->id_action_formation_plan; ?>"
                                                   href="#myModal1" data-url="http://example.com">
                                                    <img src='/assets/img/editing.png'>
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


    <!-- Edit User Modal -->

    {{--    @foreach ($infosactionplanformations as $infosactionplanformation)--}}
    {{--        <div class="modal fade" id="traiterActionFomationPlan<?php echo $infosactionplanformation->id_action_formation_plan; ?>" tabindex="-1" aria-hidden="true">--}}
    {{--            <div class="modal-dialog modal-xl modal-simple modal-edit-user">--}}
    {{--                <div class="modal-content p-3 p-md-5">--}}
    {{--                    <div class="modal-body">--}}
    {{--                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
    {{--                        <div class="text-center mb-4">--}}
    {{--                            <h3 class="mb-2">Traitement d'une action de plan de formation</h3>--}}
    {{--                            <p class="text-muted"></p>--}}
    {{--                        </div>--}}
    {{--                        <form id="editUserForm" class="row g-3" method="POST"--}}
    {{--                            action="{{ route($lien . '.cahierupdate', [\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan), \App\Helpers\Crypt::UrlCrypt($idcomite), \App\Helpers\Crypt::UrlCrypt($idetape)]) }}">--}}
    {{--                            @csrf--}}
    {{--                            @method('put')--}}
    {{--                            <div class="col-12 col-md-12">--}}
    {{--                                <label class="form-label" for="masse_salariale">Entreprise</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->raison_social_entreprises }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}


    {{--                            <div class="col-12 col-md-12">--}}
    {{--                                <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de--}}
    {{--                                    formation</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->intitule_action_formation_plan }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-12">--}}
    {{--                                <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif--}}
    {{--                                    pédagogique</label>--}}
    {{--                                <textarea class="form-control form-control-sm" name="objectif_pedagogique_fiche_agre"--}}
    {{--                                    id="objectif_pedagogique_fiche_agre" rows="6" disabled="disabled"><?php echo @$infosactionplanformation->objectif_pedagogique_fiche_agre; ?></textarea>--}}

    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="masse_salariale">Masse salariale</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ number_format(@$infosactionplanformation->masse_salariale, 0, ',', ' ') }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="part_entreprise">Part entreprise</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ number_format(@$infosactionplanformation->part_entreprise, 0, ',', ' ') }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="structure_etablissement_action_">Structure ou établissement--}}
    {{--                                    de formation</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->structure_etablissement_action_ }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de--}}
    {{--                                    stagiaires</label>--}}
    {{--                                <input type="number" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->nombre_stagiaire_action_formati }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupes</label>--}}
    {{--                                <input type="number" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->nombre_groupe_action_formation_ }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par--}}
    {{--                                    groupes</label>--}}
    {{--                                <input type="number" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->nombre_heure_action_formation_p }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="nombre_jour_action_formation">Nombre de jours</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->nombre_jour_action_formation }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label">Coût de la formation</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ number_format(@$infosactionplanformation->cout_action_formation_plan, 0, ',', ' ') }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label">Type de formation</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->type_formation }}" disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label">Caractéristique type de formation</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->caracteristiqueTypeFormation->libelle_ctf }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-3 col-12" id="id_domaine_formation_div">--}}
    {{--                                <label>Domaine de formation <strong style="color:red;">*</strong></label>--}}
    {{--                                <select class="select2 form-select-sm input-group @error('id_domaine_formation')--}}
    {{--                                error--}}
    {{--                                @enderror"--}}
    {{--                                                data-allow-clear="true" name="id_domaine_formation"--}}
    {{--                                                id="id_domaine_formation" disabled="disabled">--}}
    {{--                                <option value='{{@$infosactionplanformation->id_domaine_formation}}'>{{@$infosactionplanformation->libelle_domaine_formation}}</option>--}}
    {{--                                </select>--}}
    {{--                                @error('id_domaine_formation')--}}
    {{--                                <div class=""><label class="error">{{ $message }}</label></div>--}}
    {{--                                @enderror--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="date_debut_fiche_agrement">Date début de--}}
    {{--                                    réalisation</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->date_debut_fiche_agrement }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="date_fin_fiche_agrement">Date fin de réalisation</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->date_fin_fiche_agrement }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->lieu_formation_fiche_agrement }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}

    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres</label>--}}
    {{--                                <input type="number" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->cadre_fiche_demande_agrement }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de--}}
    {{--                                    maitrise</label>--}}
    {{--                                <input type="number" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->agent_maitrise_fiche_demande_ag }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés /--}}
    {{--                                    ouvriers</label>--}}
    {{--                                <input type="number" class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->employe_fiche_demande_agrement }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="cout_total_fiche_agrement">Coût de financement</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ number_format(@$infosactionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <label class="form-label" for="cout_accorde_action_formation">Montant accordée</label>--}}
    {{--                                <input type="text" class="form-control form-control-sm"--}}
    {{--                                    value="{{ number_format(@$infosactionplanformation->cout_accorde_action_formation, 0, ',', ' ') }}"--}}
    {{--                                    disabled="disabled" />--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-3">--}}
    {{--                                <div class="mb-1">--}}
    {{--                                    <label>Facture proforma </label> <br>--}}
    {{--                                    <span class="badge bg-secondary"><a target="_blank"--}}
    {{--                                            onclick="NewWindow('{{ asset('/pieces/facture_proforma_action_formation/' . $infosactionplanformation->facture_proforma_action_formati) }}','',screen.width/2,screen.height,'yes','center',1);">--}}
    {{--                                            Voir la pièce </a> </span>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-4">--}}
    {{--                                <div class="mb-1">--}}
    {{--                                    <label class="form-label" for="">But de la formation </label>--}}

    {{--                                    <?php--}}
    {{--                                        $butformationsenres =    ListePlanFormationSoumis::get_liste_but_formations(@$infosactionplanformation->id_fiche_agrement);--}}
    {{--                                    ?>--}}
    {{--                                    @foreach ($butformationsenres as $pc)--}}
    {{--                                    <input type="text" name="" class="form-control form-control-sm"--}}
    {{--                                        value="{{ $pc->butFormation->but_formation }}"--}}
    {{--                                        disabled />--}}
    {{--                                    @endforeach--}}
    {{--                                    </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-12 col-md-12">--}}
    {{--                                <label class="form-label" for="cout_accorde_action_formation">Commentaire</label>--}}
    {{--                                <!--<input--}}
    {{--                                    type="number"--}}
    {{--                                    class="form-control form-control-sm"--}}
    {{--                                    value="{{ @$infosactionplanformation->cout_accorde_action_formation }}"--}}
    {{--                                    disabled="disabled" />-->--}}
    {{--                                <textarea class="form-control form-control-sm" name="commentaire_action_formation" id="commentaire_action_formation"--}}
    {{--                                    rows="6" disabled="disabled">{{ @$infosactionplanformation->commentaire_action_formation }}</textarea>--}}
    {{--                            </div>--}}


    {{--                            @if (@$planformation->user_conseiller != Auth::user()->id)--}}
    {{--                                <?php--}}
    {{--                                $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user(Auth::user()->id, $infosactionplanformation->id_action_formation_plan);--}}

    {{--                                //echo $resultatT;--}}

    {{--                                ?>--}}
    {{--                                <hr />--}}

    {{--                                @if (count($resultatTCPCU) < 1)--}}
    {{--                                    <h2>Critères évaluations</h2>--}}

    {{--                                    <div class="card card-custom" style="width: 100%">--}}
    {{--                                        <div class="card-body">--}}
    {{--                                            <table class="table table-bordered table-hover table-checkable"--}}
    {{--                                                style="margin-top: 13px !important">--}}
    {{--                                                <thead>--}}
    {{--                                                    <tr>--}}
    {{--                                                        <th>N°</th>--}}
    {{--                                                        <th>Critère</th>--}}
    {{--                                                        <th>status</th>--}}
    {{--                                                        <th>commentaire</th>--}}
    {{--                                                    </tr>--}}
    {{--                                                </thead>--}}
    {{--                                                <tbody>--}}
    {{--                                                    <?php--}}
    {{--                                                $i=0;--}}
    {{--                                                    foreach ($criteres as $key => $res):--}}
    {{--                                                ?>--}}
    {{--                                                    <tr>--}}
    {{--                                                        <td>--}}
    {{--                                                            {{ ++$i }}--}}
    {{--                                                            <input type="hidden" class="form-control"--}}
    {{--                                                                name="id_critere_evaluation/{{ $res->id_critere_evaluation }}"--}}
    {{--                                                                value="{{ $res->id_critere_evaluation }}" />--}}
    {{--                                                        </td>--}}
    {{--                                                        <td>{{ $res->libelle_critere_evaluation }}</td>--}}
    {{--                                                        <td align="center">--}}
    {{--                                                            <select class="select2 form-select" data-allow-clear="true"--}}
    {{--                                                                name="flag_traitement_par_critere_commentaire/{{ $res->id_critere_evaluation }}"--}}
    {{--                                                                id="flag_traitement_par_critere_commentaire/{{ $res->id_critere_evaluation }}">--}}
    {{--                                                                <option value="">-----------</option>--}}
    {{--                                                                <option value="true">D'accord</option>--}}
    {{--                                                                <option value="false">Pas d'accord</option>--}}
    {{--                                                            </select>--}}
    {{--                                                        </td>--}}
    {{--                                                        <td align="center">--}}
    {{--                                                            <textarea class="form-control form-control-sm" name="commentaire_critere/{{ $res->id_critere_evaluation }}"--}}
    {{--                                                                id="commentaire_critere/{{ $res->id_critere_evaluation }}" rows="6"></textarea>--}}
    {{--                                                        </td>--}}

    {{--                                                    </tr>--}}
    {{--                                                    <?php endforeach; ?>--}}
    {{--                                                    </tr>--}}
    {{--                                                </tbody>--}}
    {{--                                            </table>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                @endif--}}
    {{--                            @else--}}
    {{--                                <hr />--}}
    {{--                                <div class="col-md-4 col-12">--}}
    {{--                                    <div class="mb-1">--}}
    {{--                                        <label>Montant accordée <strong style="color:red;">*</strong>: </label>--}}
    {{--                                        <input type="number" name="cout_accorde_action_formation"--}}
    {{--                                            id="cout_accorde_action_formation" class="form-control form-control-sm"--}}
    {{--                                            value="{{ @$infosactionplanformation->cout_accorde_action_formation }}">--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-md-4 col-12">--}}
    {{--                                    <label class="form-label" for="billings-country">Motif de validation <strong--}}
    {{--                                            style="color:red;">(obligatoire si action a corrigé)</strong></label>--}}

    {{--                                    <select class="form-select form-select-sm" data-allow-clear="true" name="id_motif"--}}
    {{--                                        id="id_motif">--}}
    {{--                                        <?= $motif ?>--}}
    {{--                                    </select>--}}
    {{--                                </div>--}}
    {{--                                <div class="col-md-4 col-12">--}}
    {{--                                    <div class="mb-1">--}}
    {{--                                        <label>Commentaire <strong style="color:red;">*</strong>: </label>--}}
    {{--                                        <textarea class="form-control form-control-sm" name="commentaire" id="commentaire" rows="6"></textarea>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            @endif--}}



    {{--                            <div class="col-12 text-center">--}}

    {{--                                @if (@$planformation->user_conseiller != Auth::user()->id)--}}
    {{--                                    @if (count($resultatTCPCU) < 1)--}}
    {{--                                        <button--}}
    {{--                                            onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;'--}}
    {{--                                            type="submit" name="action"--}}
    {{--                                            value="Traiter_action_formation_valider_critere"--}}
    {{--                                            class="btn btn-success me-sm-3 me-1">Valider</button>--}}
    {{--                                    @endif--}}
    {{--                                @else--}}
    {{--                                    <button--}}
    {{--                                        onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;'--}}
    {{--                                        type="submit" name="action" value="Traiter_action_formation_valider"--}}
    {{--                                        class="btn btn-success me-sm-3 me-1">Valider</button>--}}
    {{--                                @endif--}}
    {{--                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"--}}
    {{--                                    aria-label="Close">--}}
    {{--                                    Annuler--}}
    {{--                                </button>--}}
    {{--                            </div>--}}
    {{--                        </form>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    @endforeach--}}

{{--        @foreach ($infosactionplanformations as $infosactionplanformation)--}}
{{--            <div class="modal fade" id="traiterActionFomationPlanConseil<?php echo $infosactionplanformation->id_action_formation_plan; ?>" tabindex="-1"--}}
{{--                aria-hidden="true">--}}
{{--                <div class="modal-dialog modal-xl modal-simple modal-edit-user">--}}
{{--                    <div class="modal-content p-3 p-md-5">--}}
{{--                        <div class="modal-body">--}}
{{--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                            <div class="text-center mb-4">--}}
{{--                                <h3 class="mb-2">Traitement d'une action de plan de formation</h3>--}}
{{--                                <p class="text-muted"></p>--}}
{{--                            </div>--}}
{{--                            <form id="editUserForm" class="row g-3" method="POST"--}}
{{--                                action="{{ route($lien . '.cahierupdate', [\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan), \App\Helpers\Crypt::UrlCrypt($idcomite), \App\Helpers\Crypt::UrlCrypt($idetape)]) }}">--}}
{{--                                @csrf--}}
{{--                                @method('put')--}}
{{--                                <div class="col-12 col-md-12">--}}
{{--                                    <label class="form-label" for="masse_salariale">Entreprise</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm"--}}
{{--                                        value="{{ @$infosactionplanformation->raison_social_entreprises }}"--}}
{{--                                        disabled="disabled" />--}}
{{--                                </div>--}}


{{--                                <div class="col-12 col-md-12">--}}
{{--                                    <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de--}}
{{--                                        formation</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm"--}}
{{--                                        value="{{ @$infosactionplanformation->intitule_action_formation_plan }}"--}}
{{--                                        name="intitule_action_formation_plan" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-12">--}}
{{--                                    <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif--}}
{{--                                        pédagogique</label>--}}
{{--                                    <textarea class="form-control form-control-sm" name="objectif_pedagogique_fiche_agre"--}}
{{--                                        id="objectif_pedagogique_fiche_agre" rows="6"><?php echo @$infosactionplanformation->objectif_pedagogique_fiche_agre; ?></textarea>--}}

{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par--}}
{{--                                        groupes</label>--}}
{{--                                    <input type="number" class="form-control form-control-sm"--}}
{{--                                        name="nombre_heure_action_formation_p"--}}
{{--                                        value="{{ @$infosactionplanformation->nombre_heure_action_formation_p }}" />--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupes</label>--}}
{{--                                    <input type="number" class="form-control form-control-sm"--}}
{{--                                        name="nombre_groupe_action_formation_"--}}
{{--                                        value="{{ @$infosactionplanformation->nombre_groupe_action_formation_ }}" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par--}}
{{--                                        groupes</label>--}}
{{--                                    <input type="number" class="form-control form-control-sm"--}}
{{--                                        name="nombre_heure_action_formation_p"--}}
{{--                                        value="{{ @$infosactionplanformation->nombre_heure_action_formation_p }}" />--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres</label>--}}
{{--                                    <input type="number" class="form-control form-control-sm"--}}
{{--                                        name="cadre_fiche_demande_agrement"--}}
{{--                                        value="{{ @$infosactionplanformation->cadre_fiche_demande_agrement }}" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de--}}
{{--                                        maîtrise</label>--}}
{{--                                    <input type="number" class="form-control form-control-sm"--}}
{{--                                        name="agent_maitrise_fiche_demande_ag"--}}
{{--                                        value="{{ @$infosactionplanformation->agent_maitrise_fiche_demande_ag }}" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés /--}}
{{--                                        ouvriers</label>--}}
{{--                                    <input type="number" class="form-control form-control-sm"--}}
{{--                                        name="employe_fiche_demande_agrement"--}}
{{--                                        value="{{ @$infosactionplanformation->employe_fiche_demande_agrement }}" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="id_type_formation">Type de formation <strong--}}
{{--                                            style="color:red;">*</strong></label>--}}
{{--                                    <select id="id_type_formation" name="id_type_formation"--}}
{{--                                        class="select2 form-select-sm input-group @error('id_type_formation')--}}
{{--                                        error--}}
{{--                                        @enderror"--}}
{{--                                        aria-label="Default select example" onchange="changeFunction();">--}}
{{--                                        <option value="{{ @$infosactionplanformation->id_type_formation }}">--}}
{{--                                            {{ @$infosactionplanformation->type_formation }} </option>--}}
{{--                                        @foreach ($typeformationss as $typeformation)--}}
{{--                                            <option value="{{ $typeformation->id_type_formation }}">--}}
{{--                                                {{ mb_strtoupper($typeformation->type_formation) }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    @error('id_type_formation')--}}
{{--                                        <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="id_caracteristique_type_formation">Caractéristique type de--}}
{{--                                        formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <select id="id_caracteristique_type_formation" name="id_caracteristique_type_formation"--}}
{{--                                        class="select2 form-select-sm input-group @error('id_caracteristique_type_formation')--}}
{{--                                        error--}}
{{--                                        @enderror">--}}
{{--                                        <option--}}
{{--                                            value='{{ @$infosactionplanformation->caracteristiqueTypeFormation->id_caracteristique_type_formation }}'>--}}
{{--                                            {{ @$infosactionplanformation->caracteristiqueTypeFormation->libelle_ctf }}--}}
{{--                                        </option>--}}
{{--                                    </select>--}}
{{--                                    @error('id_caracteristique_type_formation')--}}
{{--                                        <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-12 col-md-10">--}}
{{--                                            <label class="form-label" for="structure_etablissement_action_">Établissement de--}}
{{--                                                formation <strong style="color:red;">*</strong></label>--}}

{{--                                            <select--}}
{{--                                                class="select2 form-select-sm input-group @error('id_entreprise_structure_formation_plan_formation')--}}
{{--                                                error--}}
{{--                                                @enderror"--}}
{{--                                                name="id_entreprise_structure_formation_plan_formation"--}}
{{--                                                id="id_entreprise_structure_formation_plan_formation">--}}
{{--                                                <option--}}
{{--                                                    value='{{ @$infosactionplanformation->id_entreprise_structure_formation_action }}'>--}}
{{--                                                    {{ @$infosactionplanformation->structure_etablissement_action_ }}</option>--}}
{{--                                                <?php //echo $structureformation;--}}
{{--                                                ?>--}}
{{--                                            </select>--}}
{{--                                            @error('id_entreprise_structure_formation_plan_formation')--}}
{{--                                                <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-2">--}}
{{--                                            <br>--}}
{{--                                            <button type="button" id="Activeajoutercabinetformation"--}}
{{--                                                class="btn btn-icon btn-primary waves-effect waves-light Activeajoutercabinetformation"--}}
{{--                                                data-bs-toggle="modal" data-bs-target="#Ajoutercabinetformation"--}}
{{--                                                href="#myModal1" data-url="http://example.com">--}}
{{--                                                <span class="ti ti-plus"></span>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="col-md-4 col-12" id="id_domaine_formation_div">--}}
{{--                                    <label>Domaine de formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <select class="select2 form-select-sm input-group @error('id_domaine_formation')--}}
{{--                                    error--}}
{{--                                    @enderror"--}}
{{--                                                    data-allow-clear="true" name="id_domaine_formation"--}}
{{--                                                    id="id_domaine_formation">--}}
{{--                                    <option value='{{@$infosactionplanformation->id_domaine_formation}}'>{{@$infosactionplanformation->libelle_domaine_formation}}</option>--}}
{{--                                    </select>--}}
{{--                                    @error('id_domaine_formation')--}}
{{--                                    <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong--}}
{{--                                            style="color:red;">*</strong></label>--}}
{{--                                    <input type="text" id="lieu_formation_fiche_agrement"--}}
{{--                                        name="lieu_formation_fiche_agrement"--}}
{{--                                        class="form-control form-control-sm @error('lieu_formation_fiche_agrement')--}}
{{--                                            error--}}
{{--                                            @enderror"--}}
{{--                                        value="{{ @$infosactionplanformation->lieu_formation_fiche_agrement }}" />--}}
{{--                                    @error('lieu_formation_fiche_agrement')--}}
{{--                                        <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-2">--}}
{{--                                    <label class="form-label" for="date_debut_fiche_agrement">Date début de réalisation--}}
{{--                                    </label>--}}
{{--                                    <input type="date" id="date_debut_fiche_agrement" name="date_debut_fiche_agrement"--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        value="{{ @$infosactionplanformation->date_debut_fiche_agrement }}" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-2">--}}
{{--                                    <label class="form-label" for="date_fin_fiche_agrement">Date fin de réalisation </label>--}}
{{--                                    <input type="date" id="date_fin_fiche_agrement" name="date_fin_fiche_agrement"--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        value="{{ @$infosactionplanformation->date_fin_fiche_agrement }}" />--}}
{{--                                </div>--}}


{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="id_but_formation">But de la formation (Vous pouvez sélectionner plusieurs)</span></label>--}}
{{--                                    <select--}}
{{--                                        id="id_but_formation"--}}
{{--                                        name="id_but_formation[]"--}}
{{--                                        class="select2 form-select-sm input-group @error('id_but_formation')--}}
{{--                                        error--}}
{{--                                        @enderror"--}}
{{--                                        aria-label="Default select example" multiple>--}}
{{--                                        <?= $butformation; ?>--}}
{{--                                    </select>--}}
{{--                                    @error('id_but_formation')--}}
{{--                                    <div class=""><label class="error">{{ $message }}</label></div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="masse_salariale">Masse salariale</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm"--}}
{{--                                        value="{{ number_format(@$infosactionplanformation->masse_salariale, 0, ',', ' ') }}"--}}
{{--                                        disabled="disabled" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="part_entreprise">Part entreprise</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm"--}}
{{--                                        value="{{ number_format(@$infosactionplanformation->part_entreprise, 0, ',', ' ') }}"--}}
{{--                                        disabled="disabled" />--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de bénéficiaires de--}}
{{--                                        l’action de formation</label>--}}
{{--                                    <input type="number" class="form-control form-control-sm"--}}
{{--                                        value="{{ @$infosactionplanformation->nombre_stagiaire_action_formati }}"--}}
{{--                                        disabled="disabled" />--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label">Coût de la formation</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm"--}}
{{--                                        value="{{ number_format(@$infosactionplanformation->cout_action_formation_plan, 0, ',', ' ') }}"--}}
{{--                                        disabled="disabled" />--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="nombre_jour_action_formation">Nombre de jours</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm"--}}
{{--                                        value="{{ @$infosactionplanformation->nombre_jour_action_formation }}"--}}
{{--                                        disabled="disabled" />--}}
{{--                                </div>--}}

{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="cout_total_fiche_agrement">Coût de financement</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm"--}}
{{--                                        value="{{ number_format(@$infosactionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}"--}}
{{--                                        disabled="disabled" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="cout_accorde_action_formation">Montant accordée</label>--}}
{{--                                    <input type="text" class="form-control form-control-sm"--}}
{{--                                        value="{{ number_format(@$infosactionplanformation->cout_accorde_action_formation, 0, ',', ' ') }}"--}}
{{--                                        disabled="disabled" />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label>Facture proforma </label> <br>--}}
{{--                                        <span class="badge bg-secondary"><a target="_blank"--}}
{{--                                                onclick="NewWindow('{{ asset('/pieces/facture_proforma_action_formation/' . $infosactionplanformation->facture_proforma_action_formati) }}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                Voir la pièce </a> </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label class="form-label" for="">But de la formation </label>--}}

{{--                                        <?php--}}
{{--                                            $butformationsenres =    ListePlanFormationSoumis::get_liste_but_formations(@$infosactionplanformation->id_fiche_agrement);--}}
{{--                                            //dd($butformationsenres);--}}
{{--                                        ?>--}}
{{--                                        @foreach ($butformationsenres as $pc)--}}
{{--                                        <input type="text" name="" class="form-control form-control-sm"--}}
{{--                                            value="{{ $pc->butFormation->but_formation }}"--}}
{{--                                            disabled />--}}
{{--                                        @endforeach--}}
{{--                                        </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-12">--}}
{{--                                    <label class="form-label" for="cout_accorde_action_formation">Commentaire</label>--}}
{{--                                    <!--<input--}}
{{--                                        type="number"--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        value="{{ @$infosactionplanformation->cout_accorde_action_formation }}"--}}
{{--                                        disabled="disabled" />-->--}}
{{--                                    <textarea class="form-control form-control-sm" name="commentaire_action_formation" id="commentaire_action_formation"--}}
{{--                                        rows="6" disabled="disabled">{{ @$infosactionplanformation->commentaire_action_formation }}</textarea>--}}
{{--                                </div>--}}




{{--                                <div class="col-md-4 col-12">--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label>Montant accordée <strong style="color:red;">*</strong>: </label>--}}
{{--                                        <input type="text" name="cout_accorde_action_formation"--}}
{{--                                            id="cout_accorde_action_formation" class="form-control form-control-sm number"--}}
{{--                                            value="@if ($infosactionplanformation->cout_action_formation_plan < $infosactionplanformation->montant_attribuable_fdfp) {{ number_format($infosactionplanformation->cout_action_formation_plan, 0, ',', ' ') }}@elseif($infosactionplanformation->cout_action_formation_plan > $infosactionplanformation->montant_attribuable_fdfp){{ number_format($infosactionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }}@else{{ number_format($infosactionplanformation->montant_attribuable_fdfp, 0, ',', ' ') }} @endif">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4 col-12">--}}
{{--                                    <label class="form-label" for="billings-country">Motif de validation <strong--}}
{{--                                            style="color:red;">(obligatoire si action a corrigé)</strong></label>--}}

{{--                                    <select class="form-select form-select-sm" data-allow-clear="true" name="id_motif"--}}
{{--                                        id="id_motif">--}}
{{--                                        <?= $motif ?>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4 col-12">--}}
{{--                                    <div class="mb-1">--}}
{{--                                        <label>Commentaire <strong style="color:red;">*</strong>: </label>--}}
{{--                                        <textarea class="form-control form-control-sm" name="commentaire_comite_technique" id="commentaire_comite_technique"--}}
{{--                                            rows="6">{{ @$infosactionplanformation->commentaire_comite_technique }}</textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}





{{--                                <div class="col-12 text-center">--}}


{{--                                    @if ($infosactionplanformation->flag_action_formation_traiter_comite_technique != true)--}}
{{--                                        <button--}}
{{--                                            onclick='javascript:if (!confirm("Voulez-vous corrigé cette action ?")) return false;'--}}
{{--                                            type="submit" name="action" value="Traiter_action_formation_valider_correction"--}}
{{--                                            class="btn btn-warning me-sm-3 me-1">A corriger</button>--}}


{{--                                        <button--}}
{{--                                            onclick='javascript:if (!confirm("Voulez-vous Traité cette action ?")) return false;'--}}
{{--                                            type="submit" name="action" value="Traiter_action_formation_valider"--}}
{{--                                            class="btn btn-success me-sm-3 me-1">Valider</button>--}}
{{--                                    @endif--}}
{{--                                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"--}}
{{--                                        aria-label="Close">--}}
{{--                                        Annuler--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}

        @foreach ($infosactionplanformations as $infosactionplanformation)
            @if(Auth->user()->id!=$planformation->user_conseiller)
                <div class="col-md-4 col-12">
                <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggle<?php echo $infosactionplanformation->id_action_formation_plan; ?>"
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
                                <div class="card-body pb-2">
                                    <ul class="timeline pt-3">
                                        <?php $ResultatTraitement = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user($infosactionplanformation->id_action_formation_plan); //ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user(Auth::user()->id,$infosactionplanformation->id_action_formation_plan); ?>
                                        @foreach ($ResultatTraitement as $res)
                                            <li
                                                class="timeline-item pb-4 timeline-item-<?php if($res->flag_traitement_par_critere_commentaire == true){ ?>success<?php }else if($res->flag_traitement_par_critere_commentaire == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                                                <span
                                                    class="timeline-indicator-advanced timeline-indicator-<?php if($res->flag_traitement_par_critere_commentaire == true){ ?>success<?php }else if($res->flag_traitement_par_critere_commentaire == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                                                    <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                </span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header border-bottom mb-3">
                                                        <h6 class="mb-0">{{ $res->name }} {{ $res->prenom_users }}
                                                            ({{ $res->profil }})</h6>
                                                        <span class="text-muted"><strong>Critère :
                                                                {{ $res->libelle_critere_evaluation }}</strong></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-wrap mb-2">
                                                        <div class="d-flex align-items-center">
                                                            @if ($res->flag_traitement_par_critere_commentaire == true)
                                                                <div class="row ">
                                                                    <div>
                                                                        <span>Observation :
                                                                            {{ $res->commentaire_critere }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span>Traité le {{ $res->datej }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if ($res->flag_traitement_par_critere_commentaire === false)
                                                                <div class="row">
                                                                    <div>
                                                                        <span>Observation :
                                                                            {{ $res->commentaire_critere }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="badge bg-label-danger">Traité le
                                                                            {{ $res->datej }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <br/><br/><br/>
                                                            @if ($res->flag_traite_par_user_conserne == true)
                                                            <div class="row">
                                                                <span>
                                                                    Statut : @if (@$res->flag_traitement_par_critere_commentaire_traiter == true)
                                                                        Prise en compte
                                                                    @else
                                                                        Pas prise en compte
                                                                    @endif
                                                                </span>


                                                            <div>
                                                                <span>Reponse :
                                                                    {{ @$res->commentaire_reponse }}</span>
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
            @else
{{--        @endforeach--}}
{{--        @foreach ($infosactionplanformations as $infosactionplanformation)--}}
                <div class="col-md-4 col-12">
                    <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggleConseil<?php echo $infosactionplanformation->id_action_formation_plan; ?>"
                        aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalToggleLabel">Commentaires </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="card">
                                    <h5 class="card-header">Recommandation</h5>
                                    <div class="card-body pb-2">
                                        <ul class="timeline pt-3">
                                            <?php $ResultatTraitement = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user($infosactionplanformation->id_action_formation_plan); ?>
                                            @foreach ($ResultatTraitement as $res)
                                                <li
                                                    class="timeline-item pb-4 timeline-item-<?php if($res->flag_traitement_par_critere_commentaire == true){ ?>success<?php }else if($res->flag_traitement_par_critere_commentaire == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                                                    <span
                                                        class="timeline-indicator-advanced timeline-indicator-<?php if($res->flag_traitement_par_critere_commentaire == true){ ?>success<?php }else if($res->flag_traitement_par_critere_commentaire == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                                                        <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                                                    </span>
                                                    <div class="timeline-event">
                                                        <div class="timeline-header border-bottom mb-3">
                                                            <h6 class="mb-0">{{ $res->name }} {{ $res->prenom_users }}
                                                                ({{ $res->profil }})</h6>
                                                            <span class="text-muted"><strong>Critère :
                                                                    {{ $res->libelle_critere_evaluation }}</strong></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between flex-wrap mb-2">
                                                            <div class="d-flex align-items-center">
                                                                @if ($res->flag_traitement_par_critere_commentaire == true)
                                                                    <div class="row ">
                                                                        <div>
                                                                            <span>Observation :
                                                                                {{ $res->commentaire_critere }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <span>Traité le {{ $res->datej }}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if ($res->flag_traitement_par_critere_commentaire === false)
                                                                    <div class="row">
                                                                        <div>
                                                                            <span>Observation :
                                                                                {{ $res->commentaire_critere }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <span class="badge bg-label-danger">Traité le
                                                                                {{ $res->datej }}</span>
                                                                        </div> <br /><br /><br />
                                                                        @if ($res->flag_traite_par_user_conserne != true)
                                                                            <div>
                                                                                <form id="editUserFormMessage" class="row g-3"
                                                                                    method="POST"
                                                                                    action="{{ route($lien . '.cahierupdate', [\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan), \App\Helpers\Crypt::UrlCrypt($idcomite), \App\Helpers\Crypt::UrlCrypt($idetape)]) }}">
                                                                                    @csrf
                                                                                    @method('put')
                                                                                    <input type="hidden"
                                                                                        name="id_traitement_par_critere_commentaire"
                                                                                        value="{{ $res->id_traitement_par_critere_commentaire }}" />
                                                                                    <div class="row">
                                                                                        <div class="col-md-4 col-12">
                                                                                            <label class="form-label"
                                                                                                for="">Statut </label>
                                                                                            <select class="select2 form-select"
                                                                                                data-allow-clear="true"
                                                                                                name="flag_traitement_par_critere_commentaire_traiter"
                                                                                                id="flag_traitement_par_critere_commentaire_traiter">
                                                                                                <option value="">-----------
                                                                                                </option>
                                                                                                <option value="true">Prise en
                                                                                                    compte</option>
                                                                                                <option value="false">Pas prise en
                                                                                                    compte</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-6 col-12">
                                                                                            <label class="form-label"
                                                                                                for="">Reponse </label>
                                                                                            <textarea class="form-control form-control-sm" name="commentaire_reponse" id="commentaire_reponse" rows="6"></textarea>
                                                                                        </div>
                                                                                        <div class="col-md-2 col-12">
                                                                                            <br />
                                                                                            <button
                                                                                                onclick='javascript:if (!confirm("Voulez-vous traité cette action ?")) return false;'
                                                                                                type="submit" name="action"
                                                                                                value="Traiter_action_formation_valider_reponse"
                                                                                                class="btn btn-warning btn-sm me-sm-3 me-1">Traité</button>

                                                                                        </div>
                                                                                    </div>
                                                                                </form>
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
                                                                                <span>Reponse :
                                                                                    {{ $res->commentaire_reponse }}</span>
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
            @endif
        @endforeach


@endsection
