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

    @php($Module = 'Plan de formation')
    @php($titre = 'Liste des comites plénières')
    @php($soustitre = 'Tenue de comite plénière')
    @php($lien = 'comitepleniere')


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
                        <button type="button" class="nav-link <?php if (count($comitepleniereparticipant) < 1) {
                            echo 'active';
                        } //dd($activetab); echo $activetab; ?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-categorieplan" aria-controls="navs-top-categorieplan"
                            aria-selected="false">
                            Liste de presence
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if (count($planformations) > 0 and count($comitepleniereparticipant) >= 1) {
                            echo 'active';
                        } ?>" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-actionformation" aria-controls="navs-top-actionformation"
                            aria-selected="false">
                            Liste des plans de formations
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link <?php if (count($cahiers) >= 1 and count($comitepleniereparticipant) >= 1) {
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

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Date de fin <strong style="color:red;">*</strong></label>
                                        <input type="date" name="date_fin_comite_pleniere"
                                            class="form-control form-control-sm"
                                            value="{{ $comitepleniere->date_fin_comite_pleniere }}" />
                                    </div>
                                </div>

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
                    <div class="tab-pane fade <?php if (count($comitepleniereparticipant) < 1) {
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
                    <div class="tab-pane fade <?php if (count($planformations) > 0 and count($comitepleniereparticipant) >= 1) {
                        echo 'active';
                    } ?>" id="navs-top-actionformation" role="tabpanel">

                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Entreprise </th>
                                    <th>Conseiller </th>
                                    <th>Code </th>
                                    <th>Date soumis</th>
                                    <th>Statut</th>
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
                                        <td>{{ @$planformation->userconseilplanformation->name }}
                                            {{ @$planformation->userconseilplanformation->prenom_users }}</td>
                                        <td>{{ @$planformation->code_plan_formation }}</td>
                                        <td>{{ $planformation->date_soumis_plan_formation }}</td>
                                        <td align="center">
                                            <?php if ($planformation->flag_soumis_plan_formation == true and
                                                $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == true
                                                and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==false){ ?>
                                            <span class="badge bg-success">Valider</span>
                                            <?php } elseif ($planformation->flag_soumis_plan_formation == true and
                                                $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false
                                                and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==false){ ?>
                                            <span class="badge bg-warning">En cours de traitement</span>
                                            <?php } elseif ($planformation->flag_soumis_plan_formation == true and
                                                $planformation->flag_recevablite_plan_formation == false and $planformation->flag_valide_plan_formation == false
                                                and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==false) { ?>
                                            <span class="badge bg-secondary">Soumis</span>
                                            <?php } elseif ($planformation->flag_soumis_plan_formation == false and
                                                $planformation->flag_recevablite_plan_formation == false and $planformation->flag_valide_plan_formation == false
                                                and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==false) { ?>
                                            <span class="badge bg-primary">Non Soumis</span>
                                            <?php } elseif ($planformation->flag_soumis_plan_formation == true and
                                                $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false
                                                and $planformation->flag_rejeter_plan_formation == true and $planformation->flag_soumis_ct_plan_formation==false) { ?>
                                            <span class="badge bg-danger">Rejeter</span>
                                            <?php } elseif ($planformation->flag_soumis_plan_formation == true and
                                                $planformation->flag_recevablite_plan_formation == true and $planformation->flag_valide_plan_formation == false
                                                and $planformation->flag_rejeter_plan_formation == false and $planformation->flag_soumis_ct_plan_formation==true) { ?>
                                            <span class="badge bg-warning">Soumis au ct</span>
                                            <?php } else { ?>
                                            <span class="badge bg-secondary">Soumis</span>
                                            <?php } ?>
                                        </td>
                                        <td align="center">
                                            <?php if($comitepleniere->flag_statut_comite_pleniere == false){?>
                                            @can($lien . '-edit')
                                                <a href="{{ route($lien . '.editer', [\App\Helpers\Crypt::UrlCrypt($planformation->id_plan_de_formation), \App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere)]) }}"
                                                    class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                            @endcan
                                            <?php } ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane fade<?php if (count($cahiers) >= 1 and count($comitepleniereparticipant) >= 1) {
                        echo 'active';
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
                                    Valider le cahier de plan
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
                                    <th>Code </th>
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
                                        <td>{{ @$planformation->code_plan_formation }}</td>
                                        <td>{{ $planformation->date_soumis_plan_formation }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
