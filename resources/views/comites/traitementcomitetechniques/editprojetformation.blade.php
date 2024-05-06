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
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-actionformation" aria-controls="navs-top-actionformation"
                            aria-selected="false">
                            Actions du projet de formation
                        </button>
                    </li>
                    {{-- <li class="nav-item">
                        <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-recevabilite" aria-controls="navs-top-recevabilite"
                            aria-selected="false">
                            Cahier
                        </button>
                    </li> --}}
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

                                        <div class="col-md-8">
                                            <label class="form-label">Fax </label>
                                            <input type="number" name="fax_entreprises" id="fax_entreprises"
                                                class="form-control form-control-sm"
                                                value="{{ @$infoentreprise->fax_entreprises }}" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="col-12" align="right">
                                <hr>


                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                    Retour</a>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade show active" id="navs-top-actionformation" role="tabpanel">

                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    {{-- <th>No</th> --}}
                                    <th>Intituleé du projet de formation </th>
                                    {{-- <th>Structure ou établissement de formation</th> --}}
                                    <th>Coût de formation entreprise</th>
                                    <th>Coût de de formation a l'instruction</th>
                                    {{-- <th>Coût de l'action accordée</th> --}}
                                    <th>Statut traitement</th>
                                    @if ($idcategoriecomite == 1)
                                        <th>Commentaire</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //$i = 0;
                                ?>
                                {{-- @foreach ($actionplanformations as $key => $actionplanformation) --}}
                                <?php //$i += 1;
                                ?>
                                <tr>
                                    {{-- <td>{{ $i }}</td> --}}
                                    <td>{{ $planformation->titre_projet_etude }}</td>
                                    {{-- <td>{{ $planformation->structure_etablissement_action_ }}</td> --}}
                                    <td>{{ number_format($planformation->cout_projet_formation, 0, ',', ' ') }}
                                    </td>
                                    <td>{{ number_format($planformation->cout_projet_instruction, 0, ',', ' ') }}
                                    </td>
                                    {{-- <td>{{ number_format($planformation->cout_accorde_action_formation, 0, ',', ' ') }}
                                    </td> --}}
                                    <td align="center">
                                        <?php
                                        $idcategoriecomite;
                                        if ($idcategoriecomite == 2) {
                                            $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf_coord(Auth::user()->id, $planformation->id_projet_formation);
                                        } else {
                                            $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf(Auth::user()->id, $planformation->id_projet_formation);
                                        }
                                        
                                        ?>
                                        @if ($idcategoriecomite == 1)
                                            @if ($planformation->id_conseiller_formation == Auth::user()->id)
                                                @if ($planformation->id_conseiller_formation == true)
                                                    <span class="badge bg-success">Valider</span>
                                                @else
                                                    <span class="badge bg-warning">Non traité</span>
                                                @endif
                                            @else
                                                @if (count($resultatTCPCU) > 0)
                                                    <span class="badge bg-success">Traité</span>
                                                @else
                                                    <span class="badge bg-warning">Non traité</span>
                                                @endif
                                            @endif
                                        @else
                                            @if ($planformation->flag_coordination == true)
                                                <span class="badge bg-success">Valider</span>
                                            @else
                                                <span class="badge bg-warning">Non traité</span>
                                            @endif
                                        @endif



                                    </td>
                                    @if ($idcategoriecomite == 1)
                                        <td align="center" nowrap>


                                            @if ($planformation->id_conseiller_formation == Auth::user()->id)
                                                <button type="button"
                                                    class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalToggleConseil<?php echo $planformation->id_projet_formation; ?>">
                                                    Voir commentaire
                                                </button>
                                            @else
                                                <button type="button"
                                                    class="btn rounded-pill btn-outline-primary btn-sm waves-effect waves-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalToggle<?php echo $planformation->id_projet_formation; ?>">
                                                    Voir commentaire
                                                </button>
                                            @endif

                                        </td>
                                    @endif

                                    <td align="center" nowrap>
                                        @can($lien . '-edit')
                                            @if ($idcategoriecomite == 1)
                                                @if ($planformation->id_conseiller_formation == Auth::user()->id)
                                                    <a type="button" class="" data-bs-toggle="modal"
                                                        data-bs-target="#traiterActionFomationProjetFormation<?php echo $planformation->id_projet_formation; ?>"
                                                        href="#myModal1" data-url="http://example.com">
                                                        <img src='/assets/img/editing.png'>
                                                    </a>
                                                @else
                                                    <a type="button" class="" data-bs-toggle="modal"
                                                        data-bs-target="#traiterActionFomationPlanConseil<?php echo $planformation->id_projet_formation; ?>"
                                                        href="#myModal1" data-url="http://example.com">
                                                        <img src='/assets/img/editing.png'>
                                                    </a>
                                                @endif
                                            @else
                                                <a type="button" class="" data-bs-toggle="modal"
                                                    data-bs-target="#traiterActionFomationProjetFormationCC<?php echo $planformation->id_projet_formation; ?>"
                                                    href="#myModal1" data-url="http://example.com">
                                                    <img src='/assets/img/editing.png'>
                                                </a>
                                            @endif
                                        @endcan

                                    </td>
                                </tr>
                                {{-- @endforeach --}}

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

                </div>
            </div>
        </div>
    </div>



    <!-- Edit User Modal -->



    <div class="modal fade" id="traiterActionFomationPlanConseil<?php echo $planformation->id_projet_formation; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Traitement d'un projet de formation</h3>
                        <p class="text-muted"></p>
                    </div>
                    <form id="editUserForm" class="row g-3" method="POST"
                        action="{{ route($lien . '.cahierupdate', [\App\Helpers\Crypt::UrlCrypt($planformation->id_projet_formation), \App\Helpers\Crypt::UrlCrypt($idcomite), \App\Helpers\Crypt::UrlCrypt($idetape)]) }}">
                        @csrf
                        @method('put')
                        <div class="col-md mb-md-0 mb-2">
                            <div class="form-check custom-option custom-option-icon">
                                <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                    <span class="custom-option-body">
                                        <i class="ti ti-briefcase"></i>
                                        <span class="custom-option-title"> {{ $typeproj->libelle }}
                                            <?php ?> </span>
                                        <small> {{ $typeproj->description }} </small>
                                    </span>

                                </label>
                            </div>
                        </div>


                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>FICHE PROMOTEUR </strong>
                                </button>
                            </h2>
                            <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-12 col-10" align="left">
                                            <div class="mb-1">
                                                <label>Titre du projet <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="titre_projet" required="required"
                                                    id="titre_projet" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->titre_projet_etude }}">
                                            </div>
                                            <div class="mb-1">
                                                <label>Operateur <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="operateur" required="required"
                                                    id="operateur" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->operateur }}">
                                            </div>
                                            <div class="mb-1">
                                                <label>Promoteur <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="promoteur" required="required"
                                                    id="promoteur" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->promoteur }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                    col-12">
                                            <div class="mb-1">
                                                <label>Beneficiaire / Cible <span style="color:red;">*</span></label>
                                                <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                    name="beneficiaire_cible" style="height: 121px;"disabled><?php echo $planformation->beneficiaires_cible; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Zone du projet <span style="color:red;">*</span>
                                                </label>
                                                <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                                    name="zone_projey" style="height: 121px;"disabled><?php echo $planformation->zone_projet; ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionPC" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>PERSONNE A CONTACTER</strong>
                                </button>
                            </h2>
                            <div id="accordionPC" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Nom et prenoms
                                                </label>
                                                <input type="text" name="nom_prenoms" id="titre_projet"
                                                    class="form-control form-control-sm"
                                                    placeholder="ex : Koa Augustin .." disabled
                                                    value="{{ $planformation->nom_prenoms }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                    col-12">
                                            <div class="mb-1">
                                                <label>Fonction
                                                </label>
                                                <input type="text" name="fonction" id="fonction"
                                                    class="form-control form-control-sm"
                                                    placeholder="ex : Charge d'etude .." disabled
                                                    value="{{ $planformation->fonction }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                        col-12">
                                            <div class="mb-1">
                                                <label>Téléphone
                                                </label>
                                                <input type="number" name="telephone" minlength="9" maxlength="10"
                                                    id="telephone" class="form-control form-control-sm"
                                                    placeholder="ex : 02014575777" disabled
                                                    value="{{ $planformation->telephone }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card
                                                                                                            accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionDP" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>DESCRIPTION DU PROJET</strong>
                                </button>
                            </h2>
                            <div id="accordionDP" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-12">

                                        <div class="col-md-12 col-12">
                                            <div class="mb-4">
                                                <label>Environnement /
                                                    contexte <span style="color:red;">*</span></label>
                                                <textarea class="form-control" required="required" rows="4" id="exampleFormControlTextarea"
                                                    name="environnement_contexte" style="height: 150px;" disabled><?php echo $planformation->environnement_contexte; ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionAC" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>ACTEURS</strong>
                                </button>
                            </h2>
                            <div id="accordionAC" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="card mb-3">
                                        <div class="card-header pt-2">
                                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link active" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-personal" role="tab"
                                                        aria-selected="true">
                                                        Les beneficiaires
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-account" role="tab"
                                                        tabindex="-1">
                                                        Le promoteur
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-social" role="tab"
                                                        aria-selected="false" tabindex="-1">
                                                        Les partenaires
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-autres" role="tab"
                                                        aria-selected="false" tabindex="-1">
                                                        Autres acteurs
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="form-tabs-personal"
                                                role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_beneficiaire"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_beneficiaire; ?></textarea>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_beneficiaires"
                                                            style="height: 150px;" disabled><?php echo $planformation->responsabilites_beneficiaires; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-account" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_promoteur"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_promoteur; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_promoteur"
                                                            style="height: 150px;" disabled><?php echo $planformation->responsabilites_promoteur; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-social" role="tabpanel">
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_partenaires"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_partenaires; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_partenaires"
                                                            style="height: 150px;" disabled><?php echo $planformation->responsabilites_partenaires; ?></textarea>
                                                    </div>


                                                </div>


                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-autres" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="mb-1">
                                                        <label>Precisez
                                                        </label>
                                                        <input type="text" name="autre_acteur" id="autre_acteur"
                                                            class="form-control form-control-sm" disabled
                                                            value="{{ $planformation->autre_acteur }} "
                                                            placeholder="ex : Panelistes">
                                                    </div>
                                                </div> <br>
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_autres"
                                                            style="height: 150px;"disabled><?php echo $planformation->roles_autres; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_autres"
                                                            style="height: 150px;"disabled><?php echo $planformation->responsabilites_autres; ?></textarea>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionPOD" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>PROBLEMES OBSERVES, OBJET DE LA DEMANDE DE
                                        FINANCEMENT</strong>
                                </button>
                            </h2>
                            <div id="accordionPOD" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Problèmes
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="problemes_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->problemes; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6  col-12">
                                            <div class="mb-1">
                                                <label>Manifestations
                                                    /
                                                    Impacts / Effet
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="manifestation_impacts_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->manifestation_impact_effet; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Moyens
                                                    probables
                                                    de résolution
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="moyens_problemes_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->moyens_probables; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label>Cout de la formation <span style="color:red;">*</span>
                                            </label>
                                            <input type="number" name="cout_projet_formation" required="required"
                                                id="cout_projet_formation" class="form-control form-control-sm"
                                                placeholder="ex : 2000000" disabled value=<?php echo $planformation->cout_projet_formation; ?>>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionACD" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>ANALYSE DES COMPETENCES DES BENEFICIAIRES</strong>
                                </button>
                            </h2>
                            <div id="accordionACD" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>
                                                    Compétences</label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="competences_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->competences; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Evaluation
                                                    des
                                                    compétences
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->evaluation_contexte; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Sources de
                                                    verification</label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="sources_verification_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->source_verification; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionThree" aria-expanded="false"
                                    aria-controls="accordionThree">
                                    <strong>PIECES JUSTIFICATIVES</strong>
                                </button>
                            </h2>
                            <div id="accordionThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">

                                        <div class="col-md-4">
                                            <label class="form-label">Lettre
                                                de demande de
                                                financement</label>
                                            <br>
                                            <?php if ($piecesetude1 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/lettre_demande_fin/' . $piecesetude1) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Lettre
                                                d’engagement </label>
                                            <br>
                                            <?php if ($piecesetude2 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/lettre_engagement/' . $piecesetude2) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Liste
                                                des
                                                bénéficiairesselon le
                                                type de
                                                projet </label>
                                            <br>
                                            <?php if ($piecesetude3 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/liste_beneficiaires/' . $piecesetude3) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Liste
                                                de supports
                                                pédagogiques
                                                nécessaires </label>
                                            <br>
                                            <?php if ($piecesetude4 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/liste_de_supports/' . $piecesetude4) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Preuve legale </label>
                                            <br>
                                            <?php if ($piecesetude5 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/preuv_legales/' . $piecesetude5) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Autre
                                                document </label>
                                            <br>
                                            <?php if ($piecesetude6 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/autres_docs/' . $piecesetude6) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>

                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>


                        <div class="row">

                            <div class="accordion mt-3" id="accordionExample">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="card accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button type="button" class="accordion-button collapsed"
                                                    data-bs-toggle="collapse" data-bs-target="#accordionTwo22"
                                                    aria-expanded="true" aria-controls="accordionTwo22">
                                                    <strong>ELABORATION DU PROJET DE FORMATION
                                                    </strong>
                                                </button>
                                            </h2>
                                            <div id="accordionTwo22" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                style="">
                                                <div class="accordion-body">
                                                    <div class="row gy-3">
                                                        <div class="col-md-12 col-10" align="left">
                                                            <div class="mb-1">
                                                                <label>Titre du projet <span style="color:red;">*</span>
                                                                </label>
                                                                <input type="text" name="titre_projet_instruction"
                                                                    required="required" id="titre_projet_instruction"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="ex : Perfectionnement .." disabled
                                                                    value="{{ $planformation->titre_projet_instruction }}">
                                                            </div>
                                                            <br>

                                                            <div class="col-md-12">
                                                                <label class="form-label">Piece
                                                                    jointe instruction
                                                                    (PDF,
                                                                    WORD,
                                                                    JPG)
                                                                    5M</label> <br>


                                                                <span class="badge bg-secondary"><a target="_blank"
                                                                        onclick="NewWindow('{{ asset('/pieces_projet_formation/autre_doc_instruction/' . $piecesetude7) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                        Voir la pièce </a> </span>
                                                                <br>

                                                                <label>Cout du projet <span style="color:red;">*</span>
                                                                </label>
                                                                <input name="cout_projet_instruction" required="required"
                                                                    type="number" id="cout_projet_instruction"
                                                                    class="form-control form-control-sm" disabled
                                                                    value="{{ $planformation->cout_projet_instruction }}"
                                                                    placeholder="200000">

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>


                                </div>
                            </div>

                        </div>
                </div>


                <br>

                <?php
                //$resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf(Auth::user()->id, $planformation->id_projet_formation);
                if ($idcategoriecomite == 2) {
                    $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf_coord(Auth::user()->id, $planformation->id_projet_formation);
                } else {
                    $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf(Auth::user()->id, $planformation->id_projet_formation);
                }
                
                ?>

                @if (count($resultatTCPCU) < 1)
                    <h2>Critères évaluations</h2>

                    <div class="card card-custom" style="width: 100%">
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-checkable"
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Critère</th>
                                        <th>Statut</th>
                                        <th>Commentaire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                $i=0;
                                    foreach ($criteres as $key => $res):
                                ?>
                                    <tr>
                                        <td>
                                            {{ ++$i }}
                                            <input type="hidden" class="form-control"
                                                name="id_critere_evaluation/{{ $res->id_critere_evaluation }}"
                                                value="{{ $res->id_critere_evaluation }}" />
                                        </td>
                                        <td>{{ $res->libelle_critere_evaluation }}</td>
                                        <td align="center">
                                            <select class="select form-select" data-allow-clear="true"
                                                name="flag_traitement_par_critere_commentaire/{{ $res->id_critere_evaluation }}"
                                                id="flag_traitement_par_critere_commentaire/{{ $res->id_critere_evaluation }}">
                                                <option value="">-----------</option>
                                                <option value="true">D'accord</option>
                                                <option value="false">Pas d'accord</option>
                                            </select>
                                        </td>
                                        <td align="center">
                                            <textarea class="form-control form-control-sm" name="commentaire_critere/{{ $res->id_critere_evaluation }}"
                                                id="commentaire_critere/{{ $res->id_critere_evaluation }}" rows="6"></textarea>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <div class="col-12 text-center">

                                @if (@$planformation->user_conseiller != Auth::user()->id)
                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;'
                                        type="submit" name="action"
                                        value="Traiter_action_formation_valider_critere_prf"
                                        class="btn btn-success me-sm-3 me-1">Valider</button>
                                @else
                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous Traiter cette action ?")) return false;'
                                        type="submit" name="action" value="Traiter_action_formation_valider_prf"
                                        class="btn btn-success me-sm-3 me-1">Valider</button>
                                @endif
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="traiterActionFomationProjetFormation<?php echo $planformation->id_projet_formation; ?>" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Traitement d'un projet de formation / Comité technique</h3>
                        <p class="text-muted"></p>
                    </div>
                    <form id="editUserForm" class="row g-3" method="POST"
                        action="{{ route($lien . '.cahierupdate', [\App\Helpers\Crypt::UrlCrypt($planformation->id_projet_formation), \App\Helpers\Crypt::UrlCrypt($idcomite), \App\Helpers\Crypt::UrlCrypt($idetape)]) }}">
                        @csrf
                        @method('put')
                        <div class="col-md mb-md-0 mb-2">
                            <div class="form-check custom-option custom-option-icon">
                                <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                    <span class="custom-option-body">
                                        <i class="ti ti-briefcase"></i>
                                        <span class="custom-option-title"> {{ $typeproj->libelle }}
                                            <?php ?> </span>
                                        <small> {{ $typeproj->description }} </small>
                                    </span>

                                </label>
                            </div>
                        </div>


                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>FICHE PROMOTEUR </strong>
                                </button>
                            </h2>
                            <div id="accordionTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-12 col-10" align="left">
                                            <div class="mb-1">
                                                <label>Titre du projet <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="titre_projet" required="required"
                                                    id="titre_projet" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->titre_projet_etude }}">
                                            </div>
                                            <div class="mb-1">
                                                <label>Operateur <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="operateur" required="required"
                                                    id="operateur" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->operateur }}">
                                            </div>
                                            <div class="mb-1">
                                                <label>Promoteur <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="promoteur" required="required"
                                                    id="promoteur" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->promoteur }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                    col-12">
                                            <div class="mb-1">
                                                <label>Beneficiaire / Cible <span style="color:red;">*</span></label>
                                                <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                    name="beneficiaire_cible" style="height: 121px;"disabled><?php echo $planformation->beneficiaires_cible; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Zone du projet <span style="color:red;">*</span>
                                                </label>
                                                <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                                    name="zone_projey" style="height: 121px;"disabled><?php echo $planformation->zone_projet; ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionPC" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>PERSONNE A CONTACTER</strong>
                                </button>
                            </h2>
                            <div id="accordionPC" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Nom et prenoms
                                                </label>
                                                <input type="text" name="nom_prenoms" id="titre_projet"
                                                    class="form-control form-control-sm"
                                                    placeholder="ex : Koa Augustin .." disabled
                                                    value="{{ $planformation->nom_prenoms }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                    col-12">
                                            <div class="mb-1">
                                                <label>Fonction
                                                </label>
                                                <input type="text" name="fonction" id="fonction"
                                                    class="form-control form-control-sm"
                                                    placeholder="ex : Charge d'etude .." disabled
                                                    value="{{ $planformation->fonction }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                        col-12">
                                            <div class="mb-1">
                                                <label>Téléphone
                                                </label>
                                                <input type="number" name="telephone" minlength="9" maxlength="10"
                                                    id="telephone" class="form-control form-control-sm"
                                                    placeholder="ex : 02014575777" disabled
                                                    value="{{ $planformation->telephone }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card
                                                                                                            accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionDP" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>DESCRIPTION DU PROJET</strong>
                                </button>
                            </h2>
                            <div id="accordionDP" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-12">

                                        <div class="col-md-12 col-12">
                                            <div class="mb-4">
                                                <label>Environnement /
                                                    contexte <span style="color:red;">*</span></label>
                                                <textarea class="form-control" required="required" rows="4" id="exampleFormControlTextarea"
                                                    name="environnement_contexte" style="height: 150px;" disabled><?php echo $planformation->environnement_contexte; ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionAC" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>ACTEURS</strong>
                                </button>
                            </h2>
                            <div id="accordionAC" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="card mb-3">
                                        <div class="card-header pt-2">
                                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link active" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-personal" role="tab"
                                                        aria-selected="true">
                                                        Les beneficiaires
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-account" role="tab"
                                                        tabindex="-1">
                                                        Le promoteur
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-social" role="tab"
                                                        aria-selected="false" tabindex="-1">
                                                        Les partenaires
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-autres" role="tab"
                                                        aria-selected="false" tabindex="-1">
                                                        Autres acteurs
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="form-tabs-personal"
                                                role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_beneficiaire"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_beneficiaire; ?></textarea>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_beneficiaires"
                                                            style="height: 150px;" disabled><?php echo $planformation->responsabilites_beneficiaires; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-account" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_promoteur"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_promoteur; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_promoteur"
                                                            style="height: 150px;" disabled><?php echo $planformation->responsabilites_promoteur; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-social" role="tabpanel">
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_partenaires"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_partenaires; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_partenaires"
                                                            style="height: 150px;" disabled><?php echo $planformation->responsabilites_partenaires; ?></textarea>
                                                    </div>


                                                </div>


                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-autres" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="mb-1">
                                                        <label>Precisez
                                                        </label>
                                                        <input type="text" name="autre_acteur" id="autre_acteur"
                                                            class="form-control form-control-sm" disabled
                                                            value="{{ $planformation->autre_acteur }} "
                                                            placeholder="ex : Panelistes">
                                                    </div>
                                                </div> <br>
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label" for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_autres"
                                                            style="height: 150px;"disabled><?php echo $planformation->roles_autres; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_autres"
                                                            style="height: 150px;"disabled><?php echo $planformation->responsabilites_autres; ?></textarea>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionPOD" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>PROBLEMES OBSERVES, OBJET DE LA DEMANDE DE
                                        FINANCEMENT</strong>
                                </button>
                            </h2>
                            <div id="accordionPOD" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Problèmes
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="problemes_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->problemes; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6  col-12">
                                            <div class="mb-1">
                                                <label>Manifestations
                                                    /
                                                    Impacts / Effet
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="manifestation_impacts_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->manifestation_impact_effet; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Moyens
                                                    probables
                                                    de résolution
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="moyens_problemes_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->moyens_probables; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label>Cout de la formation <span style="color:red;">*</span>
                                            </label>
                                            <input type="number" name="cout_projet_formation" required="required"
                                                id="cout_projet_formation" class="form-control form-control-sm"
                                                placeholder="ex : 2000000" disabled value=<?php echo $planformation->cout_projet_formation; ?>>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionACD" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>ANALYSE DES COMPETENCES DES BENEFICIAIRES</strong>
                                </button>
                            </h2>
                            <div id="accordionACD" class="accordion-collapse collapse show"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>
                                                    Compétences</label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="competences_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->competences; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Evaluation
                                                    des
                                                    compétences
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->evaluation_contexte; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Sources de
                                                    verification</label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="sources_verification_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->source_verification; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionThree" aria-expanded="false"
                                    aria-controls="accordionThree">
                                    <strong>PIECES JUSTIFICATIVES</strong>
                                </button>
                            </h2>
                            <div id="accordionThree" class="accordion-collapse collapse show"
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">

                                        <div class="col-md-4">
                                            <label class="form-label">Lettre
                                                de demande de
                                                financement</label>
                                            <br>
                                            <?php if ($piecesetude1 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/lettre_demande_fin/' . $piecesetude1) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Lettre
                                                d’engagement </label>
                                            <br>
                                            <?php if ($piecesetude2 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/lettre_engagement/' . $piecesetude2) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Liste
                                                des
                                                bénéficiairesselon le
                                                type de
                                                projet </label>
                                            <br>
                                            <?php if ($piecesetude3 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/liste_beneficiaires/' . $piecesetude3) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Liste
                                                de supports
                                                pédagogiques
                                                nécessaires </label>
                                            <br>
                                            <?php if ($piecesetude4 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/liste_de_supports/' . $piecesetude4) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Preuve legale </label>
                                            <br>
                                            <?php if ($piecesetude5 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/preuv_legales/' . $piecesetude5) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Autre
                                                document </label>
                                            <br>
                                            <?php if ($piecesetude6 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/autres_docs/' . $piecesetude6) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>

                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>



                        <div class="card accordion-item" id="accordionExample">

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#accordionTwo22"
                                        aria-expanded="true" aria-controls="accordionTwo22">
                                        <strong>ELABORATION DU PROJET DE FORMATION
                                        </strong>
                                    </button>
                                </h2>
                                <div id="accordionTwo22" class="accordion-collapse collapse show"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <div class="row gy-3">
                                            <div class="col-md-12 col-10" align="left">
                                                <div class="mb-1">
                                                    <label>Titre du projet <span style="color:red;">*</span>
                                                    </label>
                                                    <input type="text" name="titre_projet_instruction"
                                                        required="required" id="titre_projet_instruction"
                                                        class="form-control form-control-sm"
                                                        placeholder="ex : Perfectionnement .." disabled
                                                        value="{{ $planformation->titre_projet_instruction }}">
                                                </div>
                                                <br>

                                                <div class="col-md-12">
                                                    <label class="form-label">Piece
                                                        jointe instruction
                                                        (PDF,
                                                        WORD,
                                                        JPG)
                                                        5M</label> <br>


                                                    <span class="badge bg-secondary"><a target="_blank"
                                                            onclick="NewWindow('{{ asset('/pieces_projet_formation/autre_doc_instruction/' . $piecesetude7) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce </a> </span>
                                                    <br>

                                                    <label>Cout du projet <span style="color:red;">*</span>
                                                    </label>
                                                    <input name="cout_projet_instruction" required="required"
                                                        type="number" id="cout_projet_instruction"
                                                        class="form-control form-control-sm" disabled
                                                        value="{{ $planformation->cout_projet_instruction }}"
                                                        placeholder="200000">

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                </div>


                            </div>
                        </div>


                </div>


                <br>

                <?php
                //$resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf(Auth::user()->id, $planformation->id_projet_formation);
                if ($idcategoriecomite == 2) {
                    $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf_coord(Auth::user()->id, $planformation->id_projet_formation);
                } else {
                    $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf(Auth::user()->id, $planformation->id_projet_formation);
                }
                
                ?>

                @if (count($resultatTCPCU) < 1)
                    <div class="" style="width: 100%">
                        <div class="card-body">

                            <br>

                            <div class="col-12 text-center">

                                @if (@$planformation->user_conseiller != Auth::user()->id && @$planformation->flag_processus_etape == false)
                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous valider ce projet de formation ?")) return false;'
                                        type="submit" name="action"
                                        value="Traiter_action_formation_valider_critere_prf_valider"
                                        class="btn btn-success me-sm-3 me-1">Valider</button>

                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous rejeter cette action ?")) return false;'
                                        type="submit" name="action"
                                        value="Traiter_action_formation_valider_prf_rejete"
                                        class="btn btn-warning me-sm-3 me-1">Rejeter</button>
                                @endif
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="traiterActionFomationProjetFormationCC<?php echo $planformation->id_projet_formation; ?>" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="mb-2">Traitement du projet de formation / Comité de coordination </h3>
                        <p class="text-muted"></p>
                    </div>
                    <form id="editUserForm" class="row g-3" method="POST"
                        action="{{ route($lien . '.cahierupdate', [\App\Helpers\Crypt::UrlCrypt($planformation->id_projet_formation), \App\Helpers\Crypt::UrlCrypt($idcomite), \App\Helpers\Crypt::UrlCrypt($idetape)]) }}">
                        @csrf
                        @method('put')
                        <div class="col-md mb-md-0 mb-2">
                            <div class="form-check custom-option custom-option-icon">
                                <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                    <span class="custom-option-body">
                                        <i class="ti ti-briefcase"></i>
                                        <span class="custom-option-title"> {{ $typeproj->libelle }}
                                            <?php ?> </span>
                                        <small> {{ $typeproj->description }} </small>
                                    </span>

                                </label>
                            </div>
                        </div>


                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>FICHE PROMOTEUR </strong>
                                </button>
                            </h2>
                            <div id="accordionTwo" class="accordion-collapse collapse show"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-12 col-10" align="left">
                                            <div class="mb-1">
                                                <label>Titre du projet <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="titre_projet" required="required"
                                                    id="titre_projet" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->titre_projet_etude }}">
                                            </div>
                                            <div class="mb-1">
                                                <label>Operateur <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="operateur" required="required"
                                                    id="operateur" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->operateur }}">
                                            </div>
                                            <div class="mb-1">
                                                <label>Promoteur <span style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="promoteur" required="required"
                                                    id="promoteur" class="form-control form-control-sm"
                                                    placeholder="ex : Perfectionnement .." disabled
                                                    value="{{ $planformation->promoteur }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                    col-12">
                                            <div class="mb-1">
                                                <label>Beneficiaire / Cible <span style="color:red;">*</span></label>
                                                <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                    name="beneficiaire_cible" style="height: 121px;"disabled><?php echo $planformation->beneficiaires_cible; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Zone du projet <span style="color:red;">*</span>
                                                </label>
                                                <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                                    name="zone_projey" style="height: 121px;"disabled><?php echo $planformation->zone_projet; ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionPC" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>PERSONNE A CONTACTER</strong>
                                </button>
                            </h2>
                            <div id="accordionPC" class="accordion-collapse collapse show"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Nom et prenoms
                                                </label>
                                                <input type="text" name="nom_prenoms" id="titre_projet"
                                                    class="form-control form-control-sm"
                                                    placeholder="ex : Koa Augustin .." disabled
                                                    value="{{ $planformation->nom_prenoms }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                    col-12">
                                            <div class="mb-1">
                                                <label>Fonction
                                                </label>
                                                <input type="text" name="fonction" id="fonction"
                                                    class="form-control form-control-sm"
                                                    placeholder="ex : Charge d'etude .." disabled
                                                    value="{{ $planformation->fonction }}">
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6
                                                                                                        col-12">
                                            <div class="mb-1">
                                                <label>Téléphone
                                                </label>
                                                <input type="number" name="telephone" minlength="9" maxlength="10"
                                                    id="telephone" class="form-control form-control-sm"
                                                    placeholder="ex : 02014575777" disabled
                                                    value="{{ $planformation->telephone }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card
                                                                                                            accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionDP" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>DESCRIPTION DU PROJET</strong>
                                </button>
                            </h2>
                            <div id="accordionDP" class="accordion-collapse collapse show"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-12">

                                        <div class="col-md-12 col-12">
                                            <div class="mb-4">
                                                <label>Environnement /
                                                    contexte <span style="color:red;">*</span></label>
                                                <textarea class="form-control" required="required" rows="4" id="exampleFormControlTextarea"
                                                    name="environnement_contexte" style="height: 150px;" disabled><?php echo $planformation->environnement_contexte; ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionAC" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>ACTEURS</strong>
                                </button>
                            </h2>
                            <div id="accordionAC" class="accordion-collapse collapse show"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="card mb-3">
                                        <div class="card-header pt-2">
                                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link active"
                                                        data-bs-toggle="tab" data-bs-target="#form-tabs-personal"
                                                        role="tab" aria-selected="true">
                                                        Les beneficiaires
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-account" role="tab"
                                                        tabindex="-1">
                                                        Le promoteur
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-social" role="tab"
                                                        aria-selected="false" tabindex="-1">
                                                        Les partenaires
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <div type="button" class="nav-link" data-bs-toggle="tab"
                                                        data-bs-target="#form-tabs-autres" role="tab"
                                                        aria-selected="false" tabindex="-1">
                                                        Autres acteurs
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="form-tabs-personal"
                                                role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_beneficiaire"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_beneficiaire; ?></textarea>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea"
                                                            name="responsabilites_beneficiaires" style="height: 150px;" disabled><?php echo $planformation->responsabilites_beneficiaires; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-account" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_promoteur"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_promoteur; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_promoteur"
                                                            style="height: 150px;" disabled><?php echo $planformation->responsabilites_promoteur; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-social" role="tabpanel">
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_partenaires"
                                                            style="height: 150px;" disabled><?php echo $planformation->roles_partenaires; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_partenaires"
                                                            style="height: 150px;" disabled><?php echo $planformation->responsabilites_partenaires; ?></textarea>
                                                    </div>


                                                </div>


                                            </div>
                                            <div class="tab-pane fade" id="form-tabs-autres" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="mb-1">
                                                        <label>Precisez
                                                        </label>
                                                        <input type="text" name="autre_acteur" id="autre_acteur"
                                                            class="form-control form-control-sm" disabled
                                                            value="{{ $planformation->autre_acteur }} "
                                                            placeholder="ex : Panelistes">
                                                    </div>
                                                </div> <br>
                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-first-name">Roles</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_autres"
                                                            style="height: 150px;"disabled><?php echo $planformation->roles_autres; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label"
                                                            for="formtabs-last-name">Responsabilités</label>
                                                        <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_autres"
                                                            style="height: 150px;"disabled><?php echo $planformation->responsabilites_autres; ?></textarea>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionPOD" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>PROBLEMES OBSERVES, OBJET DE LA DEMANDE DE
                                        FINANCEMENT</strong>
                                </button>
                            </h2>
                            <div id="accordionPOD" class="accordion-collapse collapse show"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Problèmes
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="problemes_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->problemes; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6  col-12">
                                            <div class="mb-1">
                                                <label>Manifestations
                                                    /
                                                    Impacts / Effet
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="manifestation_impacts_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->manifestation_impact_effet; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Moyens
                                                    probables
                                                    de résolution
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="moyens_problemes_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->moyens_probables; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label>Cout de la formation <span style="color:red;">*</span>
                                            </label>
                                            <input type="number" name="cout_projet_formation" required="required"
                                                id="cout_projet_formation" class="form-control form-control-sm"
                                                placeholder="ex : 2000000" disabled value=<?php echo $planformation->cout_projet_formation; ?>>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionACD" aria-expanded="false" aria-controls="accordionTwo">
                                    <strong>ANALYSE DES COMPETENCES DES BENEFICIAIRES</strong>
                                </button>
                            </h2>
                            <div id="accordionACD" class="accordion-collapse collapse show"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>
                                                    Compétences</label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="competences_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->competences; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Evaluation
                                                    des
                                                    compétences
                                                </label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                    style="height: 121px;" disabled><?php echo $planformation->evaluation_contexte; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label> Sources de
                                                    verification</label>
                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="sources_verification_odf"
                                                    style="height: 121px;"disabled><?php echo $planformation->source_verification; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionThree" aria-expanded="false"
                                    aria-controls="accordionThree">
                                    <strong>PIECES JUSTIFICATIVES</strong>
                                </button>
                            </h2>
                            <div id="accordionThree" class="accordion-collapse collapse show"
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="row gy-3">

                                        <div class="col-md-4">
                                            <label class="form-label">Lettre
                                                de demande de
                                                financement</label>
                                            <br>
                                            <?php if ($piecesetude1 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/lettre_demande_fin/' . $piecesetude1) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Lettre
                                                d’engagement </label>
                                            <br>
                                            <?php if ($piecesetude2 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/lettre_engagement/' . $piecesetude2) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Liste
                                                des
                                                bénéficiairesselon le
                                                type de
                                                projet </label>
                                            <br>
                                            <?php if ($piecesetude3 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/liste_beneficiaires/' . $piecesetude3) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Liste
                                                de supports
                                                pédagogiques
                                                nécessaires </label>
                                            <br>
                                            <?php if ($piecesetude4 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/liste_de_supports/' . $piecesetude4) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Preuve legale </label>
                                            <br>
                                            <?php if ($piecesetude5 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/preuv_legales/' . $piecesetude5) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>
                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Autre
                                                document </label>
                                            <br>
                                            <?php if ($piecesetude6 != '') { ?>
                                            <span class="badge bg-secondary"><a target="_blank"
                                                    onclick="NewWindow('{{ asset('/pieces_projet_formation/autres_docs/' . $piecesetude6) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce </a> </span>
                                            <?php } ?>

                                            <div id="defaultFormControlHelp" class="form-text">
                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG
                                                    <br>Taille
                                                    maxi : 5Mo</em>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>



                        <div class="card accordion-item" id="accordionExample">

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#accordionTwo22"
                                        aria-expanded="true" aria-controls="accordionTwo22">
                                        <strong>ELABORATION DU PROJET DE FORMATION
                                        </strong>
                                    </button>
                                </h2>
                                <div id="accordionTwo22" class="accordion-collapse collapse show"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <div class="row gy-3">
                                            <div class="col-md-12 col-10" align="left">
                                                <div class="mb-1">
                                                    <label>Titre du projet <span style="color:red;">*</span>
                                                    </label>
                                                    <input type="text" name="titre_projet_instruction"
                                                        required="required" id="titre_projet_instruction"
                                                        class="form-control form-control-sm"
                                                        placeholder="ex : Perfectionnement .." disabled
                                                        value="{{ $planformation->titre_projet_instruction }}">
                                                </div>
                                                <br>

                                                <div class="col-md-12">
                                                    <label class="form-label">Piece
                                                        jointe instruction
                                                        (PDF,
                                                        WORD,
                                                        JPG)
                                                        5M</label> <br>


                                                    <span class="badge bg-secondary"><a target="_blank"
                                                            onclick="NewWindow('{{ asset('/pieces_projet_formation/autre_doc_instruction/' . $piecesetude7) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce </a> </span>
                                                    <br>

                                                    <label>Cout du projet <span style="color:red;">*</span>
                                                    </label>
                                                    <input name="cout_projet_instruction" required="required"
                                                        type="number" id="cout_projet_instruction"
                                                        class="form-control form-control-sm" disabled
                                                        value="{{ $planformation->cout_projet_instruction }}"
                                                        placeholder="200000">

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                </div>


                            </div>
                        </div>


                </div>


                <br>

                <?php
                //$resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf(Auth::user()->id, $planformation->id_projet_formation);
                if ($idcategoriecomite == 2) {
                    $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf_coord(Auth::user()->id, $planformation->id_projet_formation);
                } else {
                    $resultatTCPCU = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf(Auth::user()->id, $planformation->id_projet_formation);
                }
                
                ?>

                @if (count($resultatTCPCU) < 1)
                    <div class="" style="width: 100%">
                        <div class="card-body">

                            <br>

                            <div class="col-12 text-center">

                                @if (@$planformation->flag_coordination == false)
                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous valider ce projet de formation ?")) return false;'
                                        type="submit" name="action"
                                        value="Traiter_action_formation_valider_critere_prf_valider_cc"
                                        class="btn btn-success me-sm-3 me-1">Valider</button>

                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous rejeter cette action ?")) return false;'
                                        type="submit" name="action"
                                        value="Traiter_action_formation_valider_prf_rejete_cc"
                                        class="btn btn-warning me-sm-3 me-1">Rejeter</button>
                                @endif
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                </form>
            </div>
        </div>
    </div>


    <div class="col-md-4 col-12">
        <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggle<?php echo $planformation->id_projet_formation; ?>"
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
                                <?php if ($idcategoriecomite == 1) {
                                    $ResultatTraitement = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf(Auth::user()->id, $planformation->id_projet_formation);
                                } else {
                                    $ResultatTraitement = ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user_prf_coord(Auth::user()->id, $planformation->id_projet_formation);
                                } //ListeTraitementCritereParUser::get_traitement_crietere_par_commentaire_user(Auth::user()->id,$infosactionplanformation->id_action_formation_plan); ?>
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
                                                    ({{ $res->profil }})
                                                </h6>
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
                                                                <span>Traité le {{ $res->created_at }}</span>
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
                                                                    {{ $res->created_at }}</span>
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
        <div class="modal animate_animated animate_fadeInDownBig fade" id="modalToggleConseil<?php echo $planformation->id_projet_formation; ?>"
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
                                <?php
                                $idcategoriecomite;
                                if ($idcategoriecomite == 2) {
                                    $ResultatTraitement = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user_prf_coord($planformation->id_projet_formation);
                                } else {
                                    $ResultatTraitement = ListeTraitementCritereParUser::get_traitement_crietere_tout_commentaire_user_prf($planformation->id_projet_formation);
                                }
                                
                                ?>
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
                                                    ({{ $res->profil }})
                                                </h6>
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
                                                                <span>Traité le {{ $res->created_at }}</span>
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
                                                                    {{ $res->created_at }}</span>
                                                            </div> <br /><br /><br />

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
                                @endforeach
                        </div>

                    </div>
                </div>
                </li>

                </ul>
            </div>
        </div>

    </div>





@endsection
