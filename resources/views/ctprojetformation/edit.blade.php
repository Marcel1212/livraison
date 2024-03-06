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

if (isset($anneexercice->id_periode_exercice)) {
    $actifsoumission = true;
} else {
    $actifsoumission = false;
}

if (!empty($anneexercice->date_prolongation_periode_exercice)) {
    $dateexercice = $anneexercice->date_prolongation_periode_exercice;
    if ($dateday <= $dateexercice) {
        $actifsoumission = true;
    } else {
        $actifsoumission = false;
    }
}

?>
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module = 'Projet de formation')
    @php($titre = 'Liste des comites plénières')
    @php($soustitre = 'Tenue de comite plénière')
    @php($lien = 'ctprojetformation')


    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / {{ $titre }} /
        </span> {{ $soustitre }}
    </h5>




    <div class="content-body">
        @if (!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{ $anneexercice }}
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
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-planformation" aria-controls="navs-top-planformation"
                            aria-selected="true">
                            Comite plénière
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if (count($comitepleniereparticipant) < 1 and $comitepleniere->flag_statut_comite_pleniere == false) {
                            echo 'active';
                        } //dd($activetab); echo $activetab; ?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-categorieplan" aria-controls="navs-top-categorieplan"
                            aria-selected="false">
                            Liste de presence
                        </button>
                    </li>
                    <?php //if($flag_statut_comite_pleniere = false) {
                    ?>
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if (/*count($planformations) > 0 and */ count($comitepleniereparticipant) >= 1 and $comitepleniere->flag_statut_comite_pleniere == false) {
                            echo 'active';
                        } ?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-actionformation" aria-controls="navs-top-actionformation"
                            aria-selected="false">
                            Liste des projets de formations
                        </button>
                    </li>
                    <?php //}
                    ?>
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if (count($cahiers) >= 1 and count($comitepleniereparticipant) >= 1 and $comitepleniere->flag_statut_comite_pleniere == true) {
                            echo 'active';
                        } ?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-cahieraprescomite" aria-controls="navs-top-cahieraprescomite"
                            aria-selected="false">
                            Cahier
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade" id="navs-top-planformation" role="tabpanel">
                        <form method="POST" class="form"
                            action="{{ route($lien . '.update', \App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere)) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Date de debut <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_debut_comite_pleniere"
                                            class="form-control form-control-sm"
                                            value="{{ $comitepleniere->date_debut_comite_pleniere }}" />
                                    </div>
                                </div>

                                {{-- <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Date de fin <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_fin_comite_pleniere"
                                            class="form-control form-control-sm"
                                            value="{{ $comitepleniere->date_fin_comite_pleniere }}" />
                                    </div>
                                </div> --}}

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire <strong style="color:red;">*</strong></label>
                                        <textarea class="form-control form-control-sm" name="commentaire_comite_pleniere" id="commentaire_comite_pleniere"
                                            rows="6">{{ $comitepleniere->commentaire_comite_pleniere }}</textarea>

                                    </div>
                                </div>


                                <div class="col-12" align="right">
                                    <hr>
                                    <?php if($comitepleniere->flag_statut_comite_pleniere == false){?>
                                    <button type="submit" name="action" value="Modifier"
                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Modifier
                                    </button>
                                    <?php } ?>
                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                        Retour</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade <?php if (count($comitepleniereparticipant) < 1 and count($comitepleniereparticipant) == 0 and $comitepleniere->flag_statut_comite_pleniere == false) {
                        echo 'show active';
                    } //dd($activetab); echo $activetab; ?>" id="navs-top-categorieplan" role="tabpanel">

                        <?php if ($comitepleniere->flag_statut_comite_pleniere != true){ ?>
                        <form method="POST" class="form"
                            action="{{ route($lien . '.update', \App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere)) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12 col-md-10">
                                    <label class="form-label" for="id_user_comite_pleniere_participant">Conseiller <strong
                                            style="color:red;">*</strong></label>
                                    <select id="id_user_comite_pleniere_participant"
                                        name="id_user_comite_pleniere_participant"
                                        class="select2 form-select-sm input-group" aria-label="Default select example"
                                        required="required">
                                        <?= $conseiller ?>
                                    </select>
                                </div>



                                <div class="col-12 col-md-2" align="right"> <br>
                                    <button type="submit" name="action" value="Enregistrer_conseil_poour_comite"
                                        class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>
                                </div>

                            </div>

                        </form>

                        <hr>
                        <?php } ?>
                        <table class="table table-bordered table-striped table-hover table-sm" id=""
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($comitepleniereparticipant as $key => $comitepleniereparticipan)
                                    <?php $i += 1; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $comitepleniereparticipan->user->name }}</td>
                                        <td>{{ $comitepleniereparticipan->user->prenom_users }}</td>
                                        <td>
                                            <?php if ($comitepleniere->flag_statut_comite_pleniere != true){ ?>
                                            <a href="{{ route($lien . '.delete', \App\Helpers\Crypt::UrlCrypt($comitepleniereparticipan->id_comite_pleniere_participant)) }}"
                                                class=""
                                                onclick='javascript:if (!confirm("Voulez-vous supprimer cet conseiller de cette commission ?")) return false;'
                                                title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade  <?php if (/*count($planformations) > 0 and */ count($comitepleniereparticipant) >= 1 and $comitepleniere->flag_statut_comite_pleniere == false) {
                        echo 'show active';
                    } ?>" id="navs-top-actionformation" role="tabpanel">

                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Entreprise </th>
                                    <th>Titre du projet </th>
                                    <th>Code </th>
                                    <th>Cout entreprise </th>
                                    <th>Proposition financiere du conseiller </th>
                                    <th>Date soumis</th>
                                    {{-- <th>Statut</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php //dd($planformations);
                                $i = 0; ?>
                                @foreach ($planformations as $key => $planformation)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ @$planformation->entreprise->ncc_entreprises }} /
                                            {{ @$planformation->entreprise->raison_social_entreprises }}</td>
                                        <td>{{ $planformation->titre_projet_etude }}</td>
                                        <td>{{ $planformation->code_projet_formation }}</td>
                                        <td>{{ $planformation->cout_projet_formation }}</td>
                                        <td>{{ $planformation->cout_projet_instruction }}</td>
                                        <td>{{ $planformation->date_soumis }}</td>

                                        <td align="center">
                                            <?php if($comitepleniere->flag_statut_comite_pleniere == false){?>


                                            <a type="button" class="" data-bs-toggle="modal"
                                                data-bs-target="#traiterActionProjetFormation<?php echo $planformation->id_projet_formation; ?>"
                                                href="#myModal1" data-url="http://example.com">
                                                <img src='/assets/img/editing.png'>
                                            </a>

                                            <?php } ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane fade<?php if (count($cahiers) >= 1 and count($comitepleniereparticipant) >= 1 and $comitepleniere->flag_statut_comite_pleniere == true) {
                        echo 'show active';
                    } ?>" id="navs-top-cahieraprescomite" role="tabpanel">

                        <?php  if(count($cahiers)>=1 and $comitepleniere->flag_statut_comite_pleniere == false){?>
                        <div class="col-12" align="right">
                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', \App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere)) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <button type="submit" name="action" value="Traiter_cahier_plan"
                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                    Valider le cahier du comité
                                </button>
                            </form>
                        </div>
                        <?php } ?>
                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Entreprise </th>
                                    <th>Conseiller </th>
                                    <th>Titre du projet </th>
                                    <th>Code </th>
                                    <th>Cout entreprise </th>
                                    <th>Proposition financiere du conseiller </th>
                                    <th>Date soumis</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php //dd($planformations);
                                $i = 0; ?>
                                @foreach ($cahiers as $key => $planformation)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ @$planformation->ncc_entreprises }} /
                                            {{ @$planformation->raison_social_entreprises }}</td>
                                        <td>{{ @$planformation->name }} {{ @$planformation->prenom_users }}</td>
                                        <td>{{ $planformation->titre_projet_etude }}</td>
                                        <td>{{ $planformation->code_projet_formation }}</td>
                                        <td>{{ $planformation->cout_projet_formation }}</td>
                                        <td>{{ $planformation->cout_projet_instruction }}</td>
                                        <td>{{ $planformation->date_soumis }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Modal des projets de formations --}}

    @foreach ($planformations as $infosactionplanformation)
        <div class="modal fade" id="traiterActionProjetFormation<?php echo $infosactionplanformation->id_projet_formation; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="mb-2">Traitement d'une projet de formation</h3>
                            <p class="text-muted"></p>
                        </div>
                        <form id="editUserForm" class="row g-3" method="POST"
                            action="{{ route($lien . '.cahierupdate', [\App\Helpers\Crypt::UrlCrypt($infosactionplanformation->id_projet_formation), \App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere)]) }}">
                            @csrf
                            @method('post')

                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionTwo" aria-expanded="false"
                                        aria-controls="accordionTwo">
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
                                                        placeholder="ex : Perfectionnement .." disabled="disabled"
                                                        value="{{ $infosactionplanformation->titre_projet_etude }}">
                                                </div>
                                                <div class="mb-1">
                                                    <label>Operateur <span style="color:red;">*</span>
                                                    </label>
                                                    <input type="text" name="operateur" required="required"
                                                        id="operateur" class="form-control form-control-sm"
                                                        placeholder="ex : Perfectionnement .." disabled="disabled"
                                                        value="{{ $infosactionplanformation->operateur }}">
                                                </div>
                                                <div class="mb-1">
                                                    <label>Promoteur <span style="color:red;">*</span>
                                                    </label>
                                                    <input type="text" name="promoteur" required="required"
                                                        id="promoteur" class="form-control form-control-sm"
                                                        placeholder="ex : Perfectionnement .." disabled="disabled"
                                                        value="{{ $infosactionplanformation->promoteur }}">
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-6
                                                        col-12">
                                                <div class="mb-1">
                                                    <label>Beneficiaire / Cible <span style="color:red;">*</span></label>
                                                    <textarea class="form-control" required="required" rows="3" id="exampleFormControlTextarea"
                                                        name="beneficiaire_cible" style="height: 121px;" disabled="disabled"><?php echo $infosactionplanformation->beneficiaires_cible; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Zone du projet <span style="color:red;">*</span>
                                                    </label>
                                                    <textarea required="required" class="form-control" rows="3" id="exampleFormControlTextarea"
                                                        name="zone_projey" style="height: 121px;" disabled="disabled"><?php echo $infosactionplanformation->zone_projet; ?></textarea>

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
                                                        placeholder="ex : Koa Augustin .." disabled="disabled"
                                                        value="{{ $infosactionplanformation->nom_prenoms }}">
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
                                                        placeholder="ex : Charge d'etude .." disabled="disabled"
                                                        value="{{ $infosactionplanformation->fonction }}">
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
                                                        placeholder="ex : 02014575777" disabled="disabled"
                                                        value="{{ $infosactionplanformation->telephone }}">
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
                                                        name="environnement_contexte" style="height: 150px;" disabled="disabled"><?php echo $infosactionplanformation->environnement_contexte; ?></textarea>
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
                                                                style="height: 150px;"disabled="disabled"><?php echo $infosactionplanformation->roles_beneficiaire; ?></textarea>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                for="formtabs-last-name">Responsabilités</label>
                                                            <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_beneficiaires"
                                                                style="height: 150px;"disabled="disabled"><?php echo $infosactionplanformation->responsabilites_beneficiaires; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="form-tabs-account" role="tabpanel">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                for="formtabs-first-name">Roles</label>
                                                            <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_promoteur"
                                                                style="height: 150px;"disabled="disabled"><?php echo $infosactionplanformation->roles_promoteur; ?></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                for="formtabs-last-name">Responsabilités</label>
                                                            <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_promoteur"
                                                                style="height: 150px;"disabled="disabled"><?php echo $infosactionplanformation->responsabilites_promoteur; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="form-tabs-social" role="tabpanel">
                                                    <div class="row g-3">

                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                for="formtabs-first-name">Roles</label>
                                                            <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_partenaires"
                                                                style="height: 150px;"disabled="disabled"><?php echo $infosactionplanformation->roles_partenaires; ?></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                for="formtabs-last-name">Responsabilités</label>
                                                            <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_partenaires"
                                                                style="height: 150px;"disabled="disabled"><?php echo $infosactionplanformation->responsabilites_partenaires; ?></textarea>
                                                        </div>


                                                    </div>


                                                </div>
                                                <div class="tab-pane fade" id="form-tabs-autres" role="tabpanel">
                                                    <div class="row g-3">
                                                        <div class="mb-1">
                                                            <label>Precisez
                                                            </label>
                                                            <input type="text" name="autre_acteur" id="autre_acteur"
                                                                class="form-control form-control-sm" disabled="disabled"
                                                                value="{{ $infosactionplanformation->autre_acteur }} "
                                                                placeholder="ex : Panelistes">
                                                        </div>
                                                    </div> <br>
                                                    <div class="row g-3">

                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                for="formtabs-first-name">Roles</label>
                                                            <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="roles_autres"
                                                                style="height: 150px;" disabled="disabled"><?php echo $infosactionplanformation->roles_autres; ?></textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                for="formtabs-last-name">Responsabilités</label>
                                                            <textarea class="form-control" rows="4" id="exampleFormControlTextarea" name="responsabilites_autres"
                                                                style="height: 150px;" disabled="disabled"><?php echo $infosactionplanformation->responsabilites_autres; ?></textarea>
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
                                        data-bs-target="#accordionPOD" aria-expanded="false"
                                        aria-controls="accordionTwo">
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
                                                        style="height: 121px;" disabled="disabled"><?php echo $infosactionplanformation->problemes; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6  col-12">
                                                <div class="mb-1">
                                                    <label>Manifestations
                                                        /
                                                        Impacts / Effet
                                                    </label>
                                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="manifestation_impacts_odf"
                                                        style="height: 121px;" disabled="disabled"><?php echo $infosactionplanformation->manifestation_impact_effet; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label> Moyens
                                                        probables
                                                        de résolution
                                                    </label>
                                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="moyens_problemes_odf"
                                                        style="height: 121px;" disabled="disabled"><?php echo $infosactionplanformation->moyens_probables; ?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionACD" aria-expanded="false"
                                        aria-controls="accordionTwo">
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
                                                        style="height: 121px;" disabled="disabled"><?php echo $infosactionplanformation->competences; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label> Evaluation
                                                        des
                                                        compétences
                                                    </label>
                                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"
                                                        style="height: 121px;" disabled="disabled"><?php echo $infosactionplanformation->evaluation_contexte; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label> Sources de
                                                        verification</label>
                                                    <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="sources_verification_odf"
                                                        style="height: 121px;" disabled="disabled"><?php echo $infosactionplanformation->source_verification; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <br>

                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <label class="form-label" for="billings-country">Motif de validation <strong
                                            style="color:red;">(obligatoire si action a corrigé)</strong></label>

                                    <select class="form-select form-select-sm" data-allow-clear="true" name="id_motif"
                                        required="required" id="id_motif">
                                        <?= $motif ?>
                                    </select>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire <strong style="color:red;">*</strong>: </label>
                                        <textarea class="form-control form-control-sm" name="commentaire" id="commentaire" required="required"
                                            rows="6"></textarea>
                                    </div>
                                </div>

                                <div class="col-4 text-left">

                                    <button
                                        onclick='javascript:if (!confirm("Voulez-vous valider ce projet de formation ?")) return false;'
                                        type="submit" name="action" value="Traiter_action_proj_formation_valider"
                                        class="btn btn-success me-sm-3 me-1">Valider</button>

                                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
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
    @endforeach


@endsection
