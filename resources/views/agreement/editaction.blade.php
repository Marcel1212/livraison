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

    @php($Module='Agrément')
    @php($titre='Liste des agréments pour les plans de formations')
    @php($soustitre='Consulter un agrément pour le plan de formation')
    @php($lien='agreement')
    <!-- BEGIN: Content-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript">
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
        <div class="nav-align-top nav-tabs-shadow mb-4">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($id_etape==1)  active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-action"
                        aria-controls="navs-top-action"
                        aria-selected="true">
                        Action de formation
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($id_etape==2)  active @endif"
                        role="tab"
{{--                        @if($demande_annulation_action)--}}
{{--                            @if($demande_annulation_action->flag_soumis_demande_annulation_plan==true || $demande_annulation_action->flag_validation_demande_annulation_plan==true)--}}
{{--                                disabled--}}
{{--                            @endif--}}
{{--                        @endif--}}
                        @if($anneexercice->date_fin_periode_exercice<now())
                            disabled
                        @endif
{{--                        @if($demande_annulation_plan)--}}
{{--                            @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true || $demande_annulation_plan->flag_validation_demande_annulation_plan==true)--}}
{{--                                disabled--}}
{{--                           @endif--}}
{{--                        @endif--}}

                            data-bs-toggle="tab"
                        data-bs-target="#navs-top-substitution"
                        aria-controls="navs-top-substitution"
                        aria-selected="false">
                        Demande de substitution
                    </button>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <button--}}
{{--                        type="button"--}}
{{--                        class="nav-link @if($id_etape==3)  active @endif"--}}
{{--                        role="tab"--}}
{{--                        data-bs-toggle="tab"--}}
{{--                        @if($demande_annulation_plan)--}}
{{--                            @if(isset($actionplanformation->demandeSubstitution) || $demande_annulation_plan->flag_soumis_demande_annulation_plan==true || $demande_annulation_plan->flag_validation_demande_annulation_plan==true)--}}
{{--                                disabled--}}
{{--                           @endif--}}
{{--                        @endif--}}
{{--                               @isset($infosactionplanformation->demandeSubstitution)--}}
{{--                                   disabled--}}
{{--                               @endisset--}}
{{--                        data-bs-target="#navs-top-annulation"--}}
{{--                        aria-controls="navs-top-annulation"--}}
{{--                        aria-selected="false">--}}
{{--                        Demande d'annulation d'action--}}
{{--                    </button>--}}
{{--                </li>--}}
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade @if($id_etape==1) show active @endif" id="navs-top-action" role="tabpanel">
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
                        <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de formation</label>
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
                        <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise <strong style="color:red;">*</strong></label>
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
                <div class="tab-pane fade @if($id_etape==2) show active @endif" id="navs-top-planformation" role="tabpanel">
{{--                    <div class="row">--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>N° de compte contribuable </label>--}}
{{--                                <input type="text"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$infoentreprise->ncc_entreprises}}" disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Secteur activité <strong style="color:red;">*</strong></label>--}}
{{--                                <input type="text"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{@$infoentreprise->secteurActivite->libelle_secteur_activite}}" disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Activité </label>--}}
{{--                                <input type="text"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$infoentreprise->activite->libelle_activites}}" disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Localisation geaographique </label>--}}
{{--                                <input type="text" name="localisation_geographique_entreprise" id="localisation_geographique_entreprise"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$infoentreprise->localisation_geographique_entreprise}}" disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Repère d'accès </label>--}}
{{--                                <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$infoentreprise->repere_acces_entreprises}}" disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Adresse postal </label>--}}
{{--                                <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$infoentreprise->adresse_postal_entreprises}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Adresse postal </label>--}}
{{--                                <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$infoentreprise->adresse_postal_entreprises}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <label class="form-label" for="billings-country">Indicatif</label>--}}
{{--                                        <select class="select form-select-sm input-group" data-allow-clear="true" disabled="disabled">--}}
{{--                                            @foreach($pays as $pay)--}}
{{--                                                <option value="{{$pay->id}}" @if($infoentreprise->pay->indicatif==$pay->indicatif) selected @endif>--}}
{{--                                                    {{$pay->indicatif}}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <label class="form-label">Telephone  </label>--}}
{{--                                        <input type="text"--}}
{{--                                               class="form-control form-control-sm"--}}
{{--                                               value="{{$infoentreprise->tel_entreprises}}"--}}
{{--                                               disabled="disabled">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <label class="form-label" for="billings-country">Indicatif</label>--}}
{{--                                        <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">--}}
{{--                                            @foreach($pays as $pay)--}}
{{--                                                <option value="{{$pay->id}}" @if($infoentreprise->pay->indicatif==$pay->indicatif) selected @endif>--}}
{{--                                                    {{$pay->indicatif}}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <label class="form-label">Cellulaire Professionnelle  </label>--}}
{{--                                        <input type="number" name="cellulaire_professionnel_entreprises" id="cellulaire_professionnel_entreprises"--}}
{{--                                               class="form-control form-control-sm"--}}
{{--                                               value="{{$infoentreprise->cellulaire_professionnel_entreprises}}"--}}
{{--                                               disabled="disabled">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-4">--}}
{{--                                        <label class="form-label" for="billings-country">Indicatif</label>--}}
{{--                                        <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">--}}
{{--                                            @foreach($pays as $pay)--}}
{{--                                                <option value="{{$pay->id_pays}}" @if($infoentreprise->id_pays==$pay->id_pays) selected @endif>--}}
{{--                                                    {{$pay->indicatif}}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <label class="form-label">Fax  </label>--}}
{{--                                        <input type="number" name="fax_entreprises" id="fax_entreprises"--}}
{{--                                               class="form-control form-control-sm"--}}
{{--                                               value="{{$infoentreprise->fax_entreprises}}"--}}
{{--                                               disabled="disabled">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Nom et prenom du responsable formation </label>--}}
{{--                                <input type="text" name="nom_prenoms_charge_plan_formati" id="nom_prenoms_charge_plan_formati"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$plan_de_formation->nom_prenoms_charge_plan_formati}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Fonction du responsable formation </label>--}}
{{--                                <input type="text" name="fonction_charge_plan_formation" id="fonction_charge_plan_formation"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$plan_de_formation->fonction_charge_plan_formation}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Email professsionel du responsable formation </label>--}}
{{--                                <input type="email" name="email_professionnel_charge_plan_formation" id="email_professionnel_charge_plan_formation"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$plan_de_formation->email_professionnel_charge_plan_formation}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Nombre total de salarié </label>--}}
{{--                                <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$plan_de_formation->nombre_salarie_plan_formation}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}
{{--                                <label>Type entreprises </label>--}}
{{--                                <select class="select2 form-select-sm input-group" name="id_type_entreprise" id="id_type_entreprise" disabled="disabled">--}}
{{--                                    @foreach($type_entreprises as $type_entreprise)--}}
{{--                                        <option value="{{$type_entreprise->id_type_entreprise}}" @if($plan_de_formation->id_type_entreprise==$type_entreprise->id_type_entreprise) selected @endif>--}}
{{--                                            {{$type_entreprise->lielle_type_entrepise}}--}}
{{--                                        </option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}

{{--                                <label>Masse salariale </label>--}}
{{--                                <input type="number" name="masse_salariale" id="masse_salariale"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$plan_de_formation->masse_salariale}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}

{{--                                <label>Part entreprise </label>--}}
{{--                                <input type="text" name="part_entreprise" id="part_entreprise"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$plan_de_formation->part_entreprise}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12">--}}
{{--                            <div class="mb-1">--}}

{{--                                <label>Code plan </label>--}}
{{--                                <input type="text" name="code_plan_formation" id="code_plan_formation"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       value="{{$plan_de_formation->code_plan_formation}}"--}}
{{--                                       disabled="disabled">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-12" align="right">--}}
{{--                            <hr>--}}


{{--                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">--}}
{{--                                Retour</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="tab-pane fade" id="navs-top-categorieplan" role="tabpanel">
{{--                    <table class="table table-bordered table-striped table-hover table-sm"--}}
{{--                           id=""--}}
{{--                           style="margin-top: 13px !important">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>No</th>--}}
{{--                            <th>Categorie </th>--}}
{{--                            <th>Genre</th>--}}
{{--                            <th>Nombre</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @foreach ($categorieplans as $key => $categorieplan)--}}
{{--                            <tr>--}}
{{--                                <td>{{ $key+1}}</td>--}}
{{--                                <td>{{ $categorieplan->categorieProfessionelle->categorie_profeessionnelle }}</td>--}}
{{--                                <td>{{ $categorieplan->genre_plan }}</td>--}}
{{--                                <td>{{ $categorieplan->nombre_plan }}</td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
                </div>
{{--                @if(!$demande_annulation_action)--}}
{{--                    @if($demande_annulation_action->flag_soumis_demande_annulation_plan==true || $demande_annulation_action->flag_validation_demande_annulation_plan==true)--}}
                        <div class="tab-pane fade @if($id_etape==2)  show active @endif" id="navs-top-substitution"  role="tabpanel">
                            @isset($demande_substitution)
                                @if($demande_substitution->flag_soumis_demande_substitution_action_plan==true)
                                    <div class="row">
{{--                                        <h6>Nouvelle action de formation</h6>--}}
{{--                                        <div class="col-12 col-md-12">--}}
{{--                                            <label class="form-label" for="intitule_action_formation_plan_substi">Inititulé de l'action de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="text"--}}
{{--                                                id="intitule_action_formation_plan_substi"--}}
{{--                                                name="intitule_action_formation_plan_substi"--}}
{{--                                                class="form-control form-control-sm" disabled--}}
{{--                                                @isset($demande_substitution->intitule_action_formation_plan_substi)--}}
{{--                                                    value="{{$demande_substitution->intitule_action_formation_plan_substi}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="nombre_groupe_action_formation_substi">Nombre de groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="nombre_groupe_action_formation_substi"--}}
{{--                                                name="nombre_groupe_action_formation_substi"--}}
{{--                                                class="form-control form-control-sm" disabled--}}
{{--                                                @isset($demande_substitution->nombre_groupe_action_formation_substi)--}}
{{--                                                    value="{{$demande_substitution->nombre_groupe_action_formation_substi}}"--}}
{{--                                                @endisset                                                />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="nombre_heure_action_formation_p_substi"--}}
{{--                                                name="nombre_heure_action_formation_p_substi" disabled--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                @isset($demande_substitution->nombre_heure_action_formation_p_substi)--}}
{{--                                                    value="{{$demande_substitution->nombre_heure_action_formation_p_substi}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" >Coût de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="text"--}}
{{--                                                name="cout_action_formation_plan_substi"--}}
{{--                                                class="form-control form-control-sm" disabled--}}
{{--                                                @isset($demande_substitution->cout_action_formation_plan_substi)--}}
{{--                                                    value="{{$demande_substitution->cout_action_formation_plan_substi}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <select--}}
{{--                                                id="id_type_formation" disabled--}}
{{--                                                name="id_type_formation"--}}
{{--                                                class="select2 form-select-sm input-group"--}}
{{--                                                aria-label="Default select example" onchange="changeFunction();">--}}
{{--                                                <option></option>--}}
{{--                                                @foreach($typeformations as $typeformation)--}}
{{--                                                    <option value="{{$typeformation->id_type_formation}}"--}}
{{--                                                            @isset($fiche_a_demande_agrement->id_type_formation)--}}
{{--                                                                @if($fiche_a_demande_agrement->id_type_formation==$typeformation->id_type_formation)--}}
{{--                                                                    selected--}}
{{--                                                        @endif--}}

{{--                                                        @endisset--}}
{{--                                                    >{{mb_strtoupper($typeformation->type_formation)}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="id_caracteristique_type_formation_substi">Caractéristique type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <select id="id_caracteristique_type_formation" disabled name="id_caracteristique_type_formation_substi" class="select2 form-select-sm input-group">--}}
{{--                                                <option value='0'></option>--}}
{{--                                                @foreach($caracteristiques as $caracteristique)--}}
{{--                                                    <option value="{{$caracteristique->id_caracteristique_type_formation}}"--}}

{{--                                                            @isset($demande_substitution->id_caracteristique_type_formation_substi)--}}
{{--                                                                @if($demande_substitution->id_caracteristique_type_formation_substi==$caracteristique->id_caracteristique_type_formation)--}}
{{--                                                                    selected--}}
{{--                                                        @endif--}}

{{--                                                        @endisset--}}
{{--                                                    >{{mb_strtoupper($caracteristique->libelle_ctf)}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                                    <label class="form-label" for="id_entreprise_structure_formation_action_substi">Structure ou etablissement de formation <strong style="color:red;">*</strong></label>--}}
{{--                                                    <select disabled class="select2 form-select-sm input-group" name="id_entreprise_structure_formation_plan_formation_substi" id="id_entreprise_structure_formation_plan_formation_substi"--}}
{{--                                                    >--}}
{{--                                                        @foreach($structureformations as $structureformation)--}}
{{--                                                            <option value="{{$structureformation->id_entreprises}}"--}}

{{--                                                                    @isset($demande_substitution->id_entreprise_structure_formation_plan_formation_substi)--}}
{{--                                                                        @if($demande_substitution->id_entreprise_structure_formation_plan_formation_substi==$structureformation->id_entreprises)--}}
{{--                                                                            selected--}}
{{--                                                                @endif--}}

{{--                                                                @endisset--}}
{{--                                                            >{{mb_strtoupper($structureformation->raison_social_entreprises)}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <select--}}
{{--                                                id="id_but_formation"--}}
{{--                                                name="id_but_formation"--}}
{{--                                                class="select2 form-select-sm input-group"--}}
{{--                                                aria-label="Default select example" disabled>--}}
{{--                                                <option></option>--}}
{{--                                                @foreach($butformations as $butformation)--}}
{{--                                                    <option value="{{$butformation->id_but_formation}}"--}}
{{--                                                            @isset($fiche_a_demande_agrement->id_but_formation)--}}
{{--                                                                @if($fiche_a_demande_agrement->id_but_formation==$butformation->id_but_formation)--}}
{{--                                                                    selected--}}
{{--                                                        @endif--}}

{{--                                                        @endisset--}}
{{--                                                    >{{mb_strtoupper($butformation->but_formation)}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-2">--}}
{{--                                            <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="date" disabled--}}
{{--                                                id="date_debut_fiche_agrement"--}}
{{--                                                name="date_debut_fiche_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                @isset($fiche_a_demande_agrement->date_debut_fiche_agrement)--}}
{{--                                                    value="{{date('Y-m-d', strtotime($fiche_a_demande_agrement->date_debut_fiche_agrement))}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-2">--}}
{{--                                            <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="date"--}}
{{--                                                id="date_fin_fiche_agrement"--}}
{{--                                                name="date_fin_fiche_agrement" disabled--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                @isset($fiche_a_demande_agrement->date_fin_fiche_agrement)--}}
{{--                                                    value="{{date('Y-m-d', strtotime($fiche_a_demande_agrement->date_fin_fiche_agrement))}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="text" disabled--}}
{{--                                                id="lieu_formation_fiche_agrement"--}}
{{--                                                name="lieu_formation_fiche_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                @isset($fiche_a_demande_agrement->lieu_formation_fiche_agrement)--}}
{{--                                                    value="{{$fiche_a_demande_agrement->lieu_formation_fiche_agrement}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-4 col-12">--}}
{{--                                            <label>Secteur d'activité <strong style="color:red;">*</strong></label>--}}
{{--                                            <select class="select2 form-select" disabled--}}
{{--                                                    data-allow-clear="true" name="id_secteur_activite_substi"--}}
{{--                                                    id="id_secteur_activite_substi">--}}
{{--                                                <option value="">-- Sélectionnez un secteur d'activité--- </option>--}}
{{--                                                @foreach ($secteuractivites as $activite)--}}
{{--                                                    <option value="{{ $activite->id_secteur_activite }}"--}}
{{--                                                            @isset($demande_substitution->id_secteur_activite_substi)--}}
{{--                                                                @if($demande_substitution->id_secteur_activite_substi==$activite->id_secteur_activite)--}}
{{--                                                                    selected--}}
{{--                                                        @endif--}}
{{--                                                        @endisset--}}
{{--                                                    >{{ mb_strtoupper($activite->libelle_secteur_activite) }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres </label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="cadre_fiche_demande_agrement"--}}
{{--                                                name="cadre_fiche_demande_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                disabled--}}
{{--                                                @isset($fiche_a_demande_agrement->cadre_fiche_demande_agrement)--}}
{{--                                                    value="{{$fiche_a_demande_agrement->cadre_fiche_demande_agrement}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="agent_maitrise_fiche_demande_ag"--}}
{{--                                                name="agent_maitrise_fiche_demande_ag"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                disabled--}}
{{--                                                @isset($fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag)--}}
{{--                                                    value="{{$fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers </label>--}}
{{--                                            <input--}}
{{--                                                type="number" disabled--}}
{{--                                                id="employe_fiche_demande_agrement"--}}
{{--                                                name="employe_fiche_demande_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                @isset($fiche_a_demande_agrement->employe_fiche_demande_agrement)--}}
{{--                                                    value="{{$fiche_a_demande_agrement->employe_fiche_demande_agrement}}"--}}
{{--                                                @endisset--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="file_beneficiare_substi">Charger les beneficiaires de la formation (Excel)</label>--}}
{{--                                            <div class="col-md-12 mt-2">--}}
{{--                                                @isset($fiche_a_demande_agrement->file_beneficiare_fiche_agrement)--}}
{{--                                                    <span class="badge bg-secondary"> <a target="_blank"--}}
{{--                                                                                         onclick="NewWindow('{{ asset("/pieces/fichier_beneficiaire_lie_aux_action_plan_formation/". $fiche_a_demande_agrement->file_beneficiare_fiche_agrement)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                          Voir la pièce  </a></span>--}}
{{--                                                @endisset--}}
{{--                                            </div>--}}
{{--                                            <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                                    maxi : 5Mo</em>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="facture_proforma_action_formati_substi">Joindre les factures proforma (PDF) </label>--}}
{{--                                            <div class="col-md-12 mt-2">--}}
{{--                                                @isset($demande_substitution->facture_proforma_action_formati_substi)--}}
{{--                                                    <span class="badge bg-secondary"> <a target="_blank"--}}
{{--                                                                                         onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $demande_substitution->facture_proforma_action_formati_substi)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                                        Voir la pièce </a></span>--}}
{{--                                                @endisset--}}
{{--                                            </div>--}}
{{--                                            <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                                    maxi : 5Mo</em>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-12">--}}
{{--                                            <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>--}}
{{--                                            <textarea class="form-control form-control-sm" disabled  name="objectif_pedagogique_fiche_agre" id="objectif_pedagogique_fiche_agre" rows="6">@isset($fiche_a_demande_agrement->employe_fiche_demande_agrement){{$fiche_a_demande_agrement->objectif_pedagogique_fiche_agre}}@endisset</textarea>--}}
{{--                                        </div>--}}


                                        <h6 class="mt-3 mb-3">Information sur la demande de substitution</h6>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-1">
                                                            <label> Motif de la demande de substitution du plan d'action <strong
                                                                    style="color:red;">*</strong></label>
                                                            <select disabled class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_plan_substi" id="id_motif_demande_plan_substi" >
                                                                @foreach($motif_substitutions as $motif_substitution)
                                                                    <option value="{{$motif_substitution->id_motif}}"
                                                                            @isset($demande_substitution->id_motif)
                                                                                @if($demande_substitution->id_motif==$motif_substitution->id_motif)
                                                                                    selected
                                                                        @endif
                                                                        @endisset
                                                                    >{{$motif_substitution->libelle_motif}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <label class="form-label">Pièce justificative de la demande de substitution <strong
                                                                style="color:red;">*</strong></label>
                                                        @isset($demande_substitution->piece_demande_plan_substi)
                                                            <div>
                                                            <span class="badge bg-secondary"> <a target="_blank"
                                                                                                 onclick="NewWindow('{{ asset("pieces/piece_demande_substi/". $demande_substitution->piece_demande_plan_substi)}}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                          Voir la pièce   </a></span></div>
                                                        @endisset
                                                        <div id="defaultFormControlHelp" class="form-text ">
                                                            <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                maxi : 5Mo</em>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire de la demande de substitution <strong
                                                            style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm" disabled name="commentaire_demande_plan_substi" id="commentaire_demande_plan_substi" rows="6">@isset($demande_substitution->commentaire_demande_plan_substi){{$demande_substitution->commentaire_demande_plan_substi}}@endisset</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12" align="right">
                                            <br/>
                                            <a class="btn btn-sm btn-outline-secondary waves-effect"
                                               href="/{{$lien }}">
                                                Retour</a>
                                        </div>
                                    </div>
                                @else
                                    <form  method="POST" class="form"
                                           action="{{ route($lien.'.substitution', ['id_plan'=>\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_plan_de_formation),'id_action'=>\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan)]) }}"
                                           enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
{{--                                            <h6>Nouvelle action de formation</h6>--}}
{{--                                            <div class="col-12 col-md-12">--}}
{{--                                                <label class="form-label" for="intitule_action_formation_plan_substi">Inititulé de l'action de formation <strong style="color:red;">*</strong></label>--}}
{{--                                                <input--}}
{{--                                                    type="text"--}}
{{--                                                    id="intitule_action_formation_plan_substi"--}}
{{--                                                    name="intitule_action_formation_plan_substi"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($demande_substitution->intitule_action_formation_plan_substi)--}}
{{--                                                        value="{{$demande_substitution->intitule_action_formation_plan_substi}}"--}}
{{--                                                    @endisset--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                    <label class="form-label" for="nombre_groupe_action_formation_substi">Nombre de groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                                <input--}}
{{--                                                    type="number"--}}
{{--                                                    id="nombre_groupe_action_formation_substi"--}}
{{--                                                    name="nombre_groupe_action_formation_substi"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($demande_substitution->nombre_groupe_action_formation_substi)--}}
{{--                                                        value="{{$demande_substitution->nombre_groupe_action_formation_substi}}"--}}
{{--                                                    @endisset                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                                <input--}}
{{--                                                    type="number"--}}
{{--                                                    id="nombre_heure_action_formation_p_substi"--}}
{{--                                                    name="nombre_heure_action_formation_p_substi"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($demande_substitution->nombre_heure_action_formation_p_substi)--}}
{{--                                                        value="{{$demande_substitution->nombre_heure_action_formation_p_substi}}"--}}
{{--                                                    @endisset--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" >Coût de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                                  <input--}}
{{--                                                    type="text"--}}
{{--                                                    name="cout_action_formation_plan_substi"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($demande_substitution->cout_action_formation_plan_substi)--}}
{{--                                                        value="{{$demande_substitution->cout_action_formation_plan_substi}}"--}}
{{--                                                      @endisset--}}
{{--                                                  />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                                <select--}}
{{--                                                    id="id_type_formation"--}}
{{--                                                    name="id_type_formation"--}}
{{--                                                    class="select2 form-select-sm input-group"--}}
{{--                                                    aria-label="Default select example" onchange="changeFunction();">--}}
{{--                                                    <option></option>--}}
{{--                                                    @foreach($typeformations as $typeformation)--}}
{{--                                                        <option value="{{$typeformation->id_type_formation}}"--}}
{{--                                                                @isset($fiche_a_demande_agrement->id_type_formation)--}}
{{--                                                                    @if($fiche_a_demande_agrement->id_type_formation==$typeformation->id_type_formation)--}}
{{--                                                                        selected--}}
{{--                                                            @endif--}}

{{--                                                            @endisset--}}
{{--                                                        >{{mb_strtoupper($typeformation->type_formation)}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="id_caracteristique_type_formation_substi">Caractéristique type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                                <select id="id_caracteristique_type_formation" name="id_caracteristique_type_formation_substi" class="select2 form-select-sm input-group">--}}
{{--                                                    <option value='0'></option>--}}
{{--                                                    @foreach($caracteristiques as $caracteristique)--}}
{{--                                                        <option value="{{$caracteristique->id_caracteristique_type_formation}}"--}}

{{--                                                                @isset($demande_substitution->id_caracteristique_type_formation_substi)--}}
{{--                                                                    @if($demande_substitution->id_caracteristique_type_formation_substi==$caracteristique->id_caracteristique_type_formation)--}}
{{--                                                                        selected--}}
{{--                                                            @endif--}}

{{--                                                            @endisset--}}
{{--                                                        >{{mb_strtoupper($caracteristique->libelle_ctf)}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-12 col-md-10">--}}
{{--                                                        <label class="form-label" for="id_entreprise_structure_formation_action_substi">Structure ou etablissement de formation <strong style="color:red;">*</strong></label>--}}
{{--                                                        <select class="select2 form-select-sm input-group" name="id_entreprise_structure_formation_plan_formation_substi" id="id_entreprise_structure_formation_plan_formation_substi"--}}
{{--                                                        >--}}
{{--                                                            @foreach($structureformations as $structureformation)--}}
{{--                                                                <option value="{{$structureformation->id_entreprises}}"--}}

{{--                                                                        @isset($demande_substitution->id_entreprise_structure_formation_plan_formation_substi)--}}
{{--                                                                            @if($demande_substitution->id_entreprise_structure_formation_plan_formation_substi==$structureformation->id_entreprises)--}}
{{--                                                                                selected--}}
{{--                                                                    @endif--}}

{{--                                                                    @endisset--}}
{{--                                                                >{{mb_strtoupper($structureformation->raison_social_entreprises)}}</option>--}}
{{--                                                            @endforeach--}}
{{--                                                        </select>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-12 col-md-2">--}}
{{--                                                        <br>--}}
{{--                                                        <button type="button" id="Activeajoutercabinetformation"--}}
{{--                                                                class="btn btn-icon btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#Ajoutercabinetformation" href="#myModal1" data-url="http://example.com">--}}
{{--                                                            <span class="ti ti-plus"></span>--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                                <select--}}
{{--                                                    id="id_but_formation"--}}
{{--                                                    name="id_but_formation"--}}
{{--                                                    class="select2 form-select-sm input-group"--}}
{{--                                                    aria-label="Default select example" >--}}
{{--                                                    <option></option>--}}
{{--                                                    @foreach($butformations as $butformation)--}}
{{--                                                        <option value="{{$butformation->id_but_formation}}"--}}
{{--                                                                @isset($fiche_a_demande_agrement->id_but_formation)--}}
{{--                                                                    @if($fiche_a_demande_agrement->id_but_formation==$butformation->id_but_formation)--}}
{{--                                                                        selected--}}
{{--                                                            @endif--}}

{{--                                                            @endisset--}}
{{--                                                        >{{mb_strtoupper($butformation->but_formation)}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-2">--}}
{{--                                                <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                                <input--}}
{{--                                                    type="date"--}}
{{--                                                    id="date_debut_fiche_agrement"--}}
{{--                                                    name="date_debut_fiche_agrement"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($fiche_a_demande_agrement->date_debut_fiche_agrement)--}}
{{--                                                        value="{{date('Y-m-d', strtotime($fiche_a_demande_agrement->date_debut_fiche_agrement))}}"--}}
{{--                                                    @endisset--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-2">--}}
{{--                                                <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                                <input--}}
{{--                                                    type="date"--}}
{{--                                                    id="date_fin_fiche_agrement"--}}
{{--                                                    name="date_fin_fiche_agrement"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($fiche_a_demande_agrement->date_fin_fiche_agrement)--}}
{{--                                                        value="{{date('Y-m-d', strtotime($fiche_a_demande_agrement->date_fin_fiche_agrement))}}"--}}
{{--                                                    @endisset--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>--}}
{{--                                                <input--}}
{{--                                                    type="text"--}}
{{--                                                    id="lieu_formation_fiche_agrement"--}}
{{--                                                    name="lieu_formation_fiche_agrement"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($fiche_a_demande_agrement->lieu_formation_fiche_agrement)--}}
{{--                                                        value="{{$fiche_a_demande_agrement->lieu_formation_fiche_agrement}}"--}}
{{--                                                    @endisset--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-4 col-12">--}}
{{--                                                <label>Secteur d'activité <strong style="color:red;">*</strong></label>--}}
{{--                                                <select class="select2 form-select"--}}
{{--                                                        data-allow-clear="true" name="id_secteur_activite_substi"--}}
{{--                                                        id="id_secteur_activite_substi">--}}
{{--                                                    <option value="">-- Sélectionnez un secteur d'activité--- </option>--}}
{{--                                                    @foreach ($secteuractivites as $activite)--}}
{{--                                                        <option value="{{ $activite->id_secteur_activite }}"--}}
{{--                                                                @isset($demande_substitution->id_secteur_activite_substi)--}}
{{--                                                                    @if($demande_substitution->id_secteur_activite_substi==$activite->id_secteur_activite)--}}
{{--                                                                        selected--}}
{{--                                                                     @endif--}}
{{--                                                            @endisset--}}
{{--                                                        >{{ mb_strtoupper($activite->libelle_secteur_activite) }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres </label>--}}
{{--                                                <input--}}
{{--                                                    type="number"--}}
{{--                                                    id="cadre_fiche_demande_agrement"--}}
{{--                                                    name="cadre_fiche_demande_agrement"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($fiche_a_demande_agrement->cadre_fiche_demande_agrement)--}}
{{--                                                        value="{{$fiche_a_demande_agrement->cadre_fiche_demande_agrement}}"--}}
{{--                                                    @endisset--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise <strong style="color:red;">*</strong></label>--}}
{{--                                                <input--}}
{{--                                                    type="number"--}}
{{--                                                    id="agent_maitrise_fiche_demande_ag"--}}
{{--                                                    name="agent_maitrise_fiche_demande_ag"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag)--}}
{{--                                                        value="{{$fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag}}"--}}
{{--                                                    @endisset--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers </label>--}}
{{--                                                <input--}}
{{--                                                    type="number"--}}
{{--                                                    id="employe_fiche_demande_agrement"--}}
{{--                                                    name="employe_fiche_demande_agrement"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                    @isset($fiche_a_demande_agrement->employe_fiche_demande_agrement)--}}
{{--                                                        value="{{$fiche_a_demande_agrement->employe_fiche_demande_agrement}}"--}}
{{--                                                    @endisset--}}
{{--                                                />--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="file_beneficiare_substi">Charger les beneficiaires de la formation (Excel)</label>--}}
{{--                                                <input--}}
{{--                                                    type="file"--}}
{{--                                                    id="file_beneficiare_substi"--}}
{{--                                                    name="file_beneficiare_substi"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                />--}}
{{--                                                <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                                        maxi : 5Mo</em>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-12 mt-2">--}}
{{--                                                    @isset($fiche_a_demande_agrement->file_beneficiare_fiche_agrement)--}}
{{--                                                        <span class="badge bg-secondary"> <a target="_blank"--}}
{{--                                                                                             onclick="NewWindow('{{ asset("/pieces/fichier_beneficiaire_lie_aux_action_plan_formation/". $fiche_a_demande_agrement->file_beneficiare_fiche_agrement)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                          Voir la pièce précédemment enregistrée  </a></span>--}}
{{--                                                    @endisset--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-4">--}}
{{--                                                <label class="form-label" for="facture_proforma_action_formati_substi">Joindre les factures proforma (PDF) </label>--}}
{{--                                                <input--}}
{{--                                                    type="file"--}}
{{--                                                    id="facture_proforma_action_formati_substi"--}}
{{--                                                    name="facture_proforma_action_formati_substi"--}}
{{--                                                    class="form-control form-control-sm"--}}
{{--                                                />--}}
{{--                                                <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                                        maxi : 5Mo</em>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-12 mt-2">--}}
{{--                                                    @isset($demande_substitution->facture_proforma_action_formati_substi)--}}
{{--                                                        <span class="badge bg-secondary"> <a target="_blank"--}}
{{--                                                                                             onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $demande_substitution->facture_proforma_action_formati_substi)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                                        Voir la pièce précédemment enregistrée  </a></span>--}}
{{--                                                    @endisset--}}
{{--                                                </div>--}}

{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-12">--}}
{{--                                                <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>--}}
{{--                                                <textarea class="form-control form-control-sm"  name="objectif_pedagogique_fiche_agre" id="objectif_pedagogique_fiche_agre" rows="6">@isset($fiche_a_demande_agrement->employe_fiche_demande_agrement){{$fiche_a_demande_agrement->objectif_pedagogique_fiche_agre}}@endisset</textarea>--}}
{{--                                            </div>--}}


                                            <h6 class="mt-3 mb-3">Information sur la demande de substitution</h6>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-1">
                                                                <label> Motif de la demande de substitution du plan d'action <strong
                                                                        style="color:red;">*</strong></label>
                                                                <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_plan_substi" id="id_motif_demande_plan_substi" >
                                                                    @foreach($motif_substitutions as $motif_substitution)
                                                                        <option value="{{$motif_substitution->id_motif}}"
                                                                                @isset($demande_substitution->id_motif)
                                                                                    @if($demande_substitution->id_motif==$motif_substitution->id_motif)
                                                                                        selected
                                                                                    @endif
                                                                               @endisset
                                                                            >{{$motif_substitution->libelle_motif}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-2">
                                                            <label class="form-label">Pièce justificative de la demande de substitution <strong
                                                                    style="color:red;">*</strong></label>
                                                            <input type="file" name="piece_demande_plan_substi"
                                                                   class="form-control form-control-sm" placeholder=""

                                                                   value="{{ old('piece_demande_plan_substi') }}"/>
                                                            <div id="defaultFormControlHelp" class="form-text ">
                                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                    maxi : 5Mo</em>
                                                            </div>

                                                            @isset($demande_substitution->piece_demande_plan_substi)
                                                                <span class="badge bg-secondary"> <a target="_blank"
                                                                                                     onclick="NewWindow('{{ asset("pieces/piece_demande_substi/". $demande_substitution->piece_demande_plan_substi)}}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                          Voir la pièce précédemment enregistrée  </a></span>
                                                            @endisset
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire de la demande de substitution <strong
                                                                style="color:red;">*</strong></label>
                                                        <textarea class="form-control form-control-sm"  name="commentaire_demande_plan_substi" id="commentaire_demande_plan_substi" rows="6">@isset($demande_substitution->commentaire_demande_plan_substi){{$demande_substitution->commentaire_demande_plan_substi}}@endisset</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12" align="right">


                                                <br/>
{{--                                                <a href="/modelfichebeneficiaire/beneficiaire.xlsx" class="btn btn-sm btn-secondary me-sm-3 me-1"  target="_blank"> Model de la liste des beneficaires a telecharger</a>--}}
                                                <button onclick='javascript:if (!confirm("Voulez-vous soumettre la demande de substitution de cette action de formation à un conseiller ? . Cette action est irreversible")) return false;'
                                                    type="submit" name="action" value="Enregistrer_soumettre_demande_substitution"
                                                    class="btn btn-sm btn-success me-sm-3 me-1">Soumettre la demande de substitution
                                                </button>
                                                <button type="submit"
                                                        class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">
                                                    Modifier
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            @else
                                <form  method="POST" class="form"
                                       action="{{ route($lien.'.substitution', ['id_plan'=>\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_plan_de_formation),'id_action'=>\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan)]) }}"
                                       enctype="multipart/form-data">
                                    @csrf
{{--                                    <div class="row">--}}
{{--                                        <h6>Nouvelle action de formation</h6>--}}
{{--                                        <div class="col-12 col-md-12">--}}
{{--                                            <label class="form-label" for="intitule_action_formation_plan_substi">Inititulé de l'action de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="text"--}}
{{--                                                id="intitule_action_formation_plan_substi"--}}
{{--                                                name="intitule_action_formation_plan_substi"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('intitule_action_formation_plan_substi') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="nombre_groupe_action_formation_substi">Nombre de groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="nombre_groupe_action_formation_substi"--}}
{{--                                                name="nombre_groupe_action_formation_substi"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('nombre_groupe_action_formation_substi') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="nombre_heure_action_formation_p_substi"--}}
{{--                                                name="nombre_heure_action_formation_p_substi"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('nombre_heure_action_formation_p_substi') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="cout_action_formation_plan_substi">Coût de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="text"--}}
{{--                                                name="cout_action_formation_plan_substi"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('cout_action_formation_plan_substi') }}"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <select--}}
{{--                                                id="id_type_formation"--}}
{{--                                                name="id_type_formation"--}}
{{--                                                class="select2 form-select-sm input-group"--}}
{{--                                                aria-label="Default select example" onchange="changeFunction();">--}}
{{--                                                <option></option>--}}
{{--                                                @foreach($typeformations as $typeformation)--}}
{{--                                                    <option value="{{$typeformation->id_type_formation}}">{{mb_strtoupper($typeformation->type_formation)}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="id_caracteristique_type_formation">Caractéristique type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <select id="id_caracteristique_type_formation" name="id_caracteristique_type_formation_substi" class="select2 form-select-sm input-group">--}}
{{--                                                <option value='0'></option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <div class="row">--}}
{{--                                            <div class="col-12 col-md-10">--}}
{{--                                                <label class="form-label" for="structure_etablissement_action_substi">Structure ou établissement de formation <strong style="color:red;">*</strong></label>--}}
{{--                                                <select class="select2 form-select-sm input-group" name="id_entreprise_structure_formation_plan_formation_substi" id="structure_etablissement_action_substi">--}}
{{--                                                    <option></option>--}}
{{--                                                    @foreach($structureformations as $structureformation)--}}
{{--                                                        <option value="{{$structureformation->id_entreprises}}">{{mb_strtoupper($structureformation->ncc_entreprises)}} / {{mb_strtoupper($structureformation->raison_social_entreprises)}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-12 col-md-2">--}}
{{--                                                <br>--}}
{{--                                                <button type="button" id="Activeajoutercabinetformation"--}}
{{--                                                        class="btn btn-icon btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#Ajoutercabinetformation" href="#myModal1" data-url="http://example.com">--}}
{{--                                                    <span class="ti ti-plus"></span>--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <select--}}
{{--                                                id="id_but_formation"--}}
{{--                                                name="id_but_formation"--}}
{{--                                                class="select2 form-select-sm input-group"--}}
{{--                                                aria-label="Default select example" >--}}
{{--                                                <option></option>--}}
{{--                                            @foreach($butformations as $butformation)--}}
{{--                                                    <option value="{{$butformation->id_but_formation}}">{{mb_strtoupper($butformation->but_formation)}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-2">--}}
{{--                                            <label class="form-label" for="date_debut_fiche_agrement">Date début de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="date"--}}
{{--                                                id="date_debut_fiche_agrement"--}}
{{--                                                name="date_debut_fiche_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('date_debut_fiche_agrement') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-2">--}}
{{--                                            <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="date"--}}
{{--                                                id="date_fin_fiche_agrement"--}}
{{--                                                name="date_fin_fiche_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('date_fin_fiche_agrement') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="text"--}}
{{--                                                id="lieu_formation_fiche_agrement"--}}
{{--                                                name="lieu_formation_fiche_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('lieu_formation_fiche_agrement') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-4 col-12">--}}
{{--                                            <label>Secteur d'activité <strong style="color:red;">*</strong></label>--}}
{{--                                            <select class="select2 form-select"--}}
{{--                                                    data-allow-clear="true" name="id_secteur_activite_substi"--}}
{{--                                                    id="id_secteur_activite_substi">--}}
{{--                                                <option value="">-- Sélectionnez un secteur d'activité--- </option>--}}
{{--                                                @foreach ($secteuractivites as $activite)--}}
{{--                                                    <option value="{{ $activite->id_secteur_activite }}">{{ mb_strtoupper($activite->libelle_secteur_activite) }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="cadre_fiche_demande_agrement"--}}
{{--                                                name="cadre_fiche_demande_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('cadre_fiche_demande_agrement') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise <strong style="color:red;">*</strong></label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="agent_maitrise_fiche_demande_ag"--}}
{{--                                                name="agent_maitrise_fiche_demande_ag"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('agent_maitrise_fiche_demande_ag') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers </label>--}}
{{--                                            <input--}}
{{--                                                type="number"--}}
{{--                                                id="employe_fiche_demande_agrement"--}}
{{--                                                name="employe_fiche_demande_agrement"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                                value="{{ old('employe_fiche_demande_agrement') }}"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="file_beneficiare_substi">Charger les beneficiaires de la formation (Excel)</label>--}}
{{--                                            <input--}}
{{--                                                type="file"--}}
{{--                                                id="file_beneficiare_substi"--}}
{{--                                                name="file_beneficiare_substi"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-4">--}}
{{--                                            <label class="form-label" for="facture_proforma_action_formati_substi">Jointre les factures proforma (PDF) </label>--}}
{{--                                            <input--}}
{{--                                                type="file"--}}
{{--                                                id="facture_proforma_action_formati_substi"--}}
{{--                                                name="facture_proforma_action_formati_substi"--}}
{{--                                                class="form-control form-control-sm"--}}
{{--                                            />--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-12">--}}
{{--                                            <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>--}}
{{--                                            <textarea class="form-control form-control-sm"  name="objectif_pedagogique_fiche_agre" id="objectif_pedagogique_fiche_agre" rows="6">{{ old('objectif_pedagogique_fiche_agre') }}</textarea>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <h6 class="mt-3 mb-3">Information sur la demande de substitution</h6>--}}
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-1">
                                                        <label> Motif de la demande de substitution du plan d'action <strong
                                                                style="color:red;">*</strong></label>
                                                        <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_plan_substi" id="id_motif_demande_plan_substi" >
                                                            @foreach($motif_substitutions as $motif_substitution)
                                                                <option value="{{$motif_substitution->id_motif}}">{{$motif_substitution->libelle_motif}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <label class="form-label">Pièce justificative de la demande de substitution <strong
                                                            style="color:red;">*</strong></label>
                                                    <input type="file" name="piece_demande_plan_substi"
                                                           class="form-control form-control-sm" placeholder=""
                                                           required="required"
                                                           value="{{ old('piece_demande_plan_substi') }}"/>
                                                    <div id="defaultFormControlHelp" class="form-text ">
                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                            maxi : 5Mo</em>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Commentaire de la demande de substitution <strong
                                                        style="color:red;">*</strong></label>
                                                <textarea class="form-control form-control-sm"  name="commentaire_demande_plan_substi" id="commentaire_demande_plan_substi" rows="6">{{ old('commentaire_demande_annulation_plan') }}</textarea>
                                            </div>
                                        </div>


                                        <div class="col-12" align="right">
                                            <hr>
{{--                                            <a href="/modelfichebeneficiaire/beneficiaire.xlsx" class="btn btn-sm btn-secondary me-sm-3 me-1"  target="_blank"> Model de la liste des beneficaires a telecharger</a>--}}
                                            <button type="submit"
                                                    class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">
                                                Enregistrer
                                            </button>
                                            <a class="btn btn-sm btn-outline-secondary waves-effect"
                                               href="/{{$lien }}">
                                                Retour</a>
                                        </div>

                                    </div>
                                </form>
                            @endisset
                        </div>

{{--                    @endif--}}
{{--                @endif--}}
{{--                <div class="tab-pane fade @if($id_etape==3) show active @endif" id="navs-top-annulation"--}}
{{--                     role="tabpanel">--}}
{{--                    @if($demande_annulation_action)--}}
{{--                        @if($demande_annulation_action->flag_soumis_demande_annulation_plan==true)--}}
{{--                            @if($demande_annulation_action->flag_validation_demande_annulation_plan==true)--}}
{{--                                <div class="row">--}}
{{--                                    <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--                                        <div class="alert-body">--}}
{{--                                            Demande d'annulation validée--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            @if($demande_annulation_action->flag_rejeter_demande_annulation_plan==true)--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
{{--                                            <div class="alert-body">--}}
{{--                                                Demande d'annulation rejetée--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            <form method="POST" class="form"--}}
{{--                                  action="{{route($lien.'.editactioncancel',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_plan_de_formation),'id_action'=>\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)])}}"--}}
{{--                                  enctype="multipart/form-data">--}}
{{--                                @csrf--}}
{{--                                @endif--}}
{{--                                @else--}}
{{--                                    <form method="POST" class="form"--}}
{{--                                          action="{{route($lien.'.editactioncancel',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_plan_de_formation),'id_action'=>\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_action_formation_plan),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)])}}"--}}
{{--                                          enctype="multipart/form-data">--}}
{{--                                        @csrf--}}
{{--                                        @endif--}}


{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-6 col-12">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-md-12">--}}
{{--                                                        <div class="mb-1">--}}
{{--                                                            <label> Motif de la demande d'annulation de l'action de formation</label>--}}
{{--                                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"--}}
{{--                                                                    name="id_motif_demande_annulation_plan"--}}
{{--                                                                    id="id_motif_demande_annulation_plan"--}}
{{--                                                                    @isset($demande_annulation_action)--}}
{{--                                                                        @if($demande_annulation_action->flag_soumis_demande_annulation_plan)--}}
{{--                                                                            disabled--}}
{{--                                                                @endif--}}
{{--                                                                @endisset--}}
{{--                                                            >--}}
{{--                                                                @foreach($motif_annulations as $motif_annulation)--}}
{{--                                                                    <option value="{{$motif_annulation->id_motif}}"--}}
{{--                                                                            @isset($demande_annulation_action)--}}
{{--                                                                                @if($motif_annulation->id_motif==$demande_annulation_action->id_motif_demande_annulation_plan) selected @endif--}}
{{--                                                                        @endisset>{{$motif_annulation->libelle_motif}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    @isset($demande_annulation_action)--}}
{{--                                                        @if($demande_annulation_action->flag_soumis_demande_annulation_plan)--}}
{{--                                                            <div class="col-md-12 mt-2">--}}
{{--                                                                Pièce justificative de la demande d'annulation de l'action de formation<br>--}}
{{--                                                                <span class="badge bg-secondary">--}}
{{--                                                <a target="_blank" onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_action->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);">--}}
{{--                                                    Voir la pièce--}}
{{--                                                </a>--}}


{{--                                            </span>--}}
{{--                                                                <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                                                        maxi : 5Mo</em>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        @else--}}
{{--                                                            <div class="col-md-12 mt-2">--}}
{{--                                                                <label class="form-label">Pièce justificative de la demande d'annulation de l'action de formation <strong--}}
{{--                                                                        style="color:red;"></strong></label>--}}
{{--                                                                <input type="file" name="piece_demande_annulation_plan"--}}
{{--                                                                       class="form-control form-control-sm" placeholder=""--}}
{{--                                                                       @isset($demande_annulation_action->piece_demande_annulation_plan)value="{{$demande_annulation_action->piece_demande_annulation_plan}}"@endisset/>--}}
{{--                                                                <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                                                        maxi : 5Mo</em>--}}
{{--                                                                </div>--}}
{{--                                                                <span class="badge bg-secondary"> <a target="_blank"--}}
{{--                                                                                                     onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_action->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                          Voir la pièce précédemment enregistrée  </a></span>--}}
{{--                                                            </div>--}}

{{--                                                        @endif--}}
{{--                                                    @else--}}
{{--                                                        <div class="col-md-12 mt-2">--}}
{{--                                                            <label class="form-label">Pièce justificative de la demande d'annulation <strong--}}
{{--                                                                    style="color:red;"></strong></label>--}}
{{--                                                            <input type="file" name="piece_demande_annulation_plan"--}}
{{--                                                                   class="form-control form-control-sm" placeholder=""/>--}}
{{--                                                            <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                                                    maxi : 5Mo</em>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    @endisset--}}
{{--                                                </div>--}}

{{--                                            </div>--}}
{{--                                            <div class="col-md-6 col-12">--}}
{{--                                                <div class="mb-1">--}}
{{--                                                    <label>Commentaire de la demande d'annuation <strong--}}
{{--                                                            style="color:red;">*</strong></label>--}}
{{--                                                    <textarea class="form-control form-control-sm"--}}
{{--                                                              name="commentaire_demande_annulation_plan"--}}
{{--                                                              @isset($demande_annulation_action)--}}
{{--                                                                  @if($demande_annulation_action->flag_soumis_demande_annulation_plan==true)--}}
{{--                                                                      disabled--}}
{{--                                                              @endif--}}
{{--                                                              @endisset--}}
{{--                                                              id="commentaire_demande_annulation_plan" rows="6">@isset($demande_annulation_action->commentaire_demande_annulation_plan){{$demande_annulation_action->commentaire_demande_annulation_plan}}@endisset</textarea>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            @if($demande_annulation_action)--}}

{{--                                                @if($demande_annulation_action->flag_rejeter_demande_annulation_plan==true)--}}
{{--                                                    <div class="col-md-12 col-12 mt-3">--}}
{{--                                                        <div class="mb-1">--}}
{{--                                                            <label>Motif du rejet</label>--}}
{{--                                                            <textarea class="form-control form-control-sm"--}}
{{--                                                                      name="commentaire_final_demande_annulation_plan_formation"--}}
{{--                                                                      @isset($demande_annulation_action)--}}
{{--                                                                          @if($demande_annulation_action->flag_soumis_demande_annulation_plan==true)--}}
{{--                                                                              disabled--}}
{{--                                                                      @endif--}}
{{--                                                                      @endisset--}}
{{--                                                                      id="commentaire_final_demande_annulation_plan_formation" rows="6">@isset($demande_annulation_action->commentaire_final_demande_annulation_plan_formation){{$demande_annulation_action->commentaire_final_demande_annulation_plan_formation}}@endisset</textarea>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            @endif--}}



{{--                                            <div class="col-12" align="right">--}}
{{--                                                <hr>--}}
{{--                                                @isset($demande_annulation_action)--}}
{{--                                                    @if($demande_annulation_action->flag_soumis_demande_annulation_plan==true)--}}

{{--                                                    @else--}}
{{--                                                        <button--}}
{{--                                                            onclick='javascript:if (!confirm("Voulez-vous soumettre la demande d annulation de cette action de formation à un conseiller ? . Cette action est irreversible")) return false;'--}}
{{--                                                            type="submit" name="action" value="Enregistrer_soumettre_demande_annulation"--}}
{{--                                                            class="btn btn-sm btn-success me-sm-3 me-1">Soumettre la demande d'annulation--}}
{{--                                                        </button>--}}
{{--                                                        <button type="submit"--}}
{{--                                                                class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">--}}
{{--                                                            Modifier--}}
{{--                                                        </button>--}}
{{--                                                    @endif--}}
{{--                                                @else--}}
{{--                                                    <button type="submit"--}}
{{--                                                            class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">--}}
{{--                                                        Enregistrer--}}
{{--                                                    </button>--}}
{{--                                                @endisset--}}


{{--                                                <a class="btn btn-sm btn-outline-secondary waves-effect"--}}
{{--                                                   href="/{{$lien }}">--}}
{{--                                                    Retour</a>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}

{{--                                        --}}{{--                                @if($demande_annulation_plan->flag_rejeter_demande_annulation_plan==true)--}}
{{--                                        --}}{{--                                    <div class="row">--}}
{{--                                        --}}{{--                                        <li class="mb-4 pb-1 d-flex justify-content-between  align-items-center"--}}
{{--                                        --}}{{--                                            align="center">--}}
{{--                                        --}}{{--                                            <div class="badge bg-label-danger rounded p-2"><i--}}
{{--                                        --}}{{--                                                    class="ti ti-ban ti-sm"></i>--}}
{{--                                        --}}{{--                                            </div>--}}
{{--                                        --}}{{--                                            <div class="d-flex justify-content-between w-100 flex-wrap">--}}
{{--                                        --}}{{--                                                <h6 class="mb-0 ms-3">Demande d'annulation rejetée</h6>--}}
{{--                                        --}}{{--                                            </div>--}}

{{--                                        --}}{{--                                        </li>--}}
{{--                                        --}}{{--                                    </div>--}}
{{--                                        --}}{{--                                @endif--}}

{{--                                        --}}{{--                    @if(!$demande_annulation_plan)--}}
{{--                                        --}}{{--                        @if(!$demande_annulation_plan->flag_soumis_demande_annulation_plan)--}}
{{--                                    </form>--}}
{{--                            --}}{{--                        @endif--}}
{{--                            --}}{{--                    @endif--}}
{{--                </div>--}}

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
                                        @foreach($pays as $pay)
                                            <option value="{{$pay->id_pays}}">{{$pay->indicatif}}</option>
                                        @endforeach
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

