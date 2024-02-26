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

    @php($Module='Agrément')
    @php($titre='Liste des plans de formations agrées')
    @php($soustitre='Consulter un agrément')
    @php($lien='agreement')

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i
                class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
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
                        class="nav-link @if($id_etape==1) active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-agreement"
                        aria-controls="navs-top-agreement"
                        aria-selected="true">
                        Agréement
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($id_etape==2) active @endif"
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
                        class="nav-link @if($id_etape==3) active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-categorieplan"
                        aria-controls="navs-top-categorieplan"
                        aria-selected="false">
                        Effectif de l'entreprise
                    </button>
                </li>

                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($id_etape==4) active @endif"
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
                        class="nav-link @if($id_etape==5) active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-annulation"
                        aria-controls="navs-top-annulation"
                        aria-selected="true">
                        Demande d'annulation
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($id_etape==6) active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-histortiqueactionformation"
                        aria-controls="navs-top-histortiqueactionformation"
                        aria-selected="false">
                        Historiques des actions du plan de formation
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade @if($id_etape==1) show active @endif" id="navs-top-agreement" role="tabpanel">
                    <div class="col-xl-12">
                        <h6 class="text-muted"></h6>
                        <table width="100%" style="border-collapse:collapse;border:none;">
                            <tbody>
                            <tr>
                                <td rowspan="2"
                                    style="width: 56.3pt;border: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        N&deg; ACTION</p>
                                </td>
                                <td rowspan="2"
                                    style="width: 118.55pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        INTITULE DE L'ACTION</p>
                                </td>
                                <td colspan="4"
                                    style="width: 133.25pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        PERSONNES CONCERNER</p>
                                </td>
                                <td rowspan="2"
                                    style="width: 42.45pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        DUREE</p>
                                </td>
                                <td rowspan="2"
                                    style="width: 98.55pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        INTERVENANT</p>
                                </td>
                                <td rowspan="2"
                                    style="width: 70.05pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        COUT INITIAL</p>
                                </td>
                                <td colspan="3"
                                    style="width: 105.6pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        CONTRIBUTION FDFP</p>
                                </td>
                                <td rowspan="2"
                                    style="width: 90.85pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        TYPE ACTION</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 31.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        C</p>
                                </td>
                                <td style="width: 31.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        AM</p>
                                </td>
                                <td style="width: 31.65pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        EO</p>
                                </td>
                                <td style="width: 38.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        TOTAL</p>
                                </td>
                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        TOTAL ACCODEE</p>
                                </td>
                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        UTILISATION DIRECT</p>
                                </td>
                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        FINAN COMPLEMENTAIRE</p>
                                </td>
                            </tr>
                            <?php $i = 000; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0; $total7 = 0; $total8 = 0; $total9 = 0; ?>
                            @foreach ($actionformations as $actionformation)
                                    <?php
                                    $total1 += $actionformation->cadre_fiche_demande_agrement;
                                    $total2 += $actionformation->agent_maitrise_fiche_demande_ag;
                                    $total3 += $actionformation->employe_fiche_demande_agrement;
                                    $total4 += $actionformation->cadre_fiche_demande_agrement + $actionformation->employe_fiche_demande_agrement + $actionformation->agent_maitrise_fiche_demande_ag;
                                    $total5 += $actionformation->nombre_heure_action_formation_p;
                                    $total6 += $actionformation->cout_action_formation_plan;
                                    $total7 += $actionformation->cout_accorde_action_formation;
                                    $total8 += $actionformation->cout_accorde_action_formation;
                                    $total9 += 0;
                                    ?>
                                <tr>
                                    <td style="width: 56.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ ++$i }}</p>
                                    </td>
                                    <td style="width: 118.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $actionformation->intitule_action_formation_plan }}</p>
                                    </td>
                                    <td style="width: 31.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $actionformation->cadre_fiche_demande_agrement }}</p>
                                    </td>
                                    <td style="width: 31.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $actionformation->agent_maitrise_fiche_demande_ag }}</p>
                                    </td>
                                    <td style="width: 31.65pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $actionformation->employe_fiche_demande_agrement }}</p>
                                    </td>
                                    <td style="width: 38.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $actionformation->cadre_fiche_demande_agrement + $actionformation->agent_maitrise_fiche_demande_ag + $actionformation->employe_fiche_demande_agrement}}</p>
                                    </td>
                                    <td style="width: 42.45pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $actionformation->nombre_heure_action_formation_p }}</p>
                                    </td>
                                    <td style="width: 98.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $actionformation->raison_social_entreprises }}</p>
                                    </td>
                                    <td style="width: 70.05pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ number_format($actionformation->cout_action_formation_plan) }}</p>
                                    </td>
                                    <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ number_format($actionformation->cout_accorde_action_formation) }}</p>
                                    </td>
                                    <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ number_format($actionformation->cout_accorde_action_formation) }}</p>
                                    </td>
                                    <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ 0 }}</p>
                                    </td>
                                    <td style="width: 90.85pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $actionformation->type_formation }}</p>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="width: 56.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">

                                </td>
                                <td style="width: 118.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        TOTAL</p>
                                </td>
                                <td style="width: 31.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total1 }}</p>
                                </td>
                                <td style="width: 31.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total2 }}</p>
                                </td>
                                <td style="width: 31.65pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total3 }}</p>
                                </td>
                                <td style="width: 38.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total4 }}</p>
                                </td>
                                <td style="width: 42.45pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total5 }}</p>
                                </td>
                                <td style="width: 98.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        &nbsp;</p>
                                </td>
                                <td style="width: 70.05pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total6 }}</p>
                                </td>
                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total7 }}</p>
                                </td>
                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total8 }}</p>
                                </td>
                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total9 }}</p>
                                </td>
                                <td style="width: 90.85pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>
                                        &nbsp;</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;'>
                            &nbsp;</p>
                    </div>
                    <div class="col-12" align="right">
                        <hr>
                        <a class="btn btn-sm btn-primary me-sm-3 me-1"
                           href="{{ route($lien.'.edit',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(2)])}}">Suivant</a>
                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                            Retour</a>
                    </div>
                </div>
                <div class="tab-pane fade @if($id_etape==2) show active @endif" id="navs-top-planformation"
                     role="tabpanel">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>N° de compte contribuable </label>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       value="{{$infoentreprise->ncc_entreprises}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Secteur activité <strong style="color:red;">*</strong></label>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       value="{{@$infoentreprise->secteurActivite->libelle_secteur_activite}}"
                                       disabled="disabled">
                            </div>
                        </div>
                        {{--                        <div class="col-md-4 col-12">--}}
                        {{--                            <div class="mb-1">--}}
                        {{--                                <label>Activité </label>--}}
                        {{--                                <input type="text"--}}
                        {{--                                       class="form-control form-control-sm"--}}
                        {{--                                       value="{{$infoentreprise->activite->libelle_activites}}" disabled="disabled">--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Localisation géographique </label>
                                <input type="text" name="localisation_geographique_entreprise"
                                       id="localisation_geographique_entreprise"
                                       class="form-control form-control-sm"
                                       value="{{$infoentreprise->localisation_geographique_entreprise}}"
                                       disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Repère d'accès </label>
                                <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                       class="form-control form-control-sm"
                                       value="{{$infoentreprise->repere_acces_entreprises}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Adresse postale </label>
                                <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                       class="form-control form-control-sm"
                                       value="{{$infoentreprise->adresse_postal_entreprises}}"
                                       disabled="disabled">
                            </div>
                        </div>


                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="billings-country">Indicatif</label>
                                        <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                disabled="disabled">
                                            @foreach($pays as $pay)
                                                <option value="{{$pay->id_pays}}"
                                                        @if($infoentreprise->id_pays==$pay->id_pays) selected @endif>
                                                    {{$pay->indicatif}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Telephone </label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               value="{{$infoentreprise->tel_entreprises}}"
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
                                            @foreach($pays as $pay)
                                                <option value="{{$pay->id_pays}}"
                                                        @if($infoentreprise->id_pays==$pay->id_pays) selected @endif>
                                                    {{$pay->indicatif}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Cellulaire Professionnelle </label>
                                        <input type="number" name="cellulaire_professionnel_entreprises"
                                               id="cellulaire_professionnel_entreprises"
                                               class="form-control form-control-sm"
                                               value="{{$infoentreprise->cellulaire_professionnel_entreprises}}"
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
                                            @foreach($pays as $pay)
                                                <option value="{{$pay->id_pays}}"
                                                        @if($infoentreprise->id_pays==$pay->id_pays) selected @endif>
                                                    {{$pay->indicatif}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Fax </label>
                                        <input type="number" name="fax_entreprises" id="fax_entreprises"
                                               class="form-control form-control-sm"
                                               value="{{$infoentreprise->fax_entreprises}}"
                                               disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="col-md-4 col-12">--}}
                        {{--                            <div class="mb-1">--}}
                        {{--                                <label>Secteur d'activité du plan <strong style="color:red;">*</strong></label>--}}
                        {{--                                <select class="select2 form-select"--}}
                        {{--                                        data-allow-clear="true" name="id_secteur_activite"--}}
                        {{--                                        id="id_secteur_activite" disabled="disabled">--}}
                        {{--                                    <option--}}
                        {{--                                        value="{{$plan_de_formation->secteurActivite->id_secteur_activite}}">{{$plan_de_formation->secteurActivite->libelle_secteur_activite}}</option>--}}

                        {{--                                </select>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Nom et prenoms du responsable formation </label>
                                <input type="text" name="nom_prenoms_charge_plan_formati"
                                       id="nom_prenoms_charge_plan_formati"
                                       class="form-control form-control-sm"
                                       value="{{$plan_de_formation->nom_prenoms_charge_plan_formati}}"
                                       disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Fonction du responsable formation </label>
                                <input type="text" name="fonction_charge_plan_formation"
                                       id="fonction_charge_plan_formation"
                                       class="form-control form-control-sm"
                                       value="{{$plan_de_formation->fonction_charge_plan_formation}}"
                                       disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Email professsionel du responsable formation </label>
                                <input type="email" name="email_professionnel_charge_plan_formation"
                                       id="email_professionnel_charge_plan_formation"
                                       class="form-control form-control-sm"
                                       value="{{$plan_de_formation->email_professionnel_charge_plan_formation}}"
                                       disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Nombre total de salariés déclarés à la CNPS </label>
                                <input type="number" name="nombre_salarie_plan_formation"
                                       id="nombre_salarie_plan_formation"
                                       class="form-control form-control-sm"
                                       value="{{$plan_de_formation->nombre_salarie_plan_formation}}"
                                       disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Type entreprises </label>
                                <select class="select2 form-select-sm input-group" name="id_type_entreprise"
                                        id="id_type_entreprise" disabled="disabled">
                                    @foreach($type_entreprises as $type_entreprise)
                                        <option value="{{$type_entreprise->id_type_entreprise}}"
                                                @if($plan_de_formation->id_type_entreprise==$type_entreprise->id_type_entreprise) selected @endif>
                                            {{$type_entreprise->lielle_type_entrepise}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">

                                <label>Masse salariale </label>
                                <input type="number" name="masse_salariale" id="masse_salariale"
                                       class="form-control form-control-sm"
                                       value="{{$plan_de_formation->masse_salariale}}"
                                       disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">

                                <label>Part entreprise </label>
                                <input type="text" name="part_entreprise" id="part_entreprise"
                                       class="form-control form-control-sm"
                                       value="{{$plan_de_formation->part_entreprise}}"
                                       disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">

                                <label>Code plan </label>
                                <input type="text" name="code_plan_formation" id="code_plan_formation"
                                       class="form-control form-control-sm"
                                       value="{{$plan_de_formation->code_plan_formation}}"
                                       disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mb-1">

                                <label>Le coût demandé </label>
                                <input type="text" name="cout_total_demande_plan_formation"
                                       id="cout_total_demande_plan_formation"
                                       class="form-control form-control-sm"
                                       value="{{@$plan_de_formation->cout_total_demande_plan_formation}}"
                                       disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-1">

                                <label>Le coût accordé </label>
                                <input type="text" name="cout_total_accorder_plan_formation"
                                       id="cout_total_accorder_plan_formation"
                                       class="form-control form-control-sm"
                                       value="{{@$plan_de_formation->cout_total_accorder_plan_formation}}"
                                       disabled="disabled">
                            </div>
                        </div>
                        <div class="col-12" align="right">
                            <hr>
                            <a class="btn btn-sm btn-primary me-sm-3 me-1"
                               href="{{ route($lien.'.edit',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(3)])}}">Suivant</a>
                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                Retour</a>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade @if($id_etape==3) show active @endif" id="navs-top-categorieplan"
                     role="tabpanel">
                    <table class="table table-bordered table-striped table-hover table-sm"
                           id=""
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Categorie</th>
                            <th>Genre</th>
                            <th>Nombre</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categorieplans as $key => $categorieplan)
                            <tr>
                                <td>{{ $key+1}}</td>
                                <td>{{ $categorieplan->categorieProfessionelle->categorie_profeessionnelle }}</td>
                                <td>{{ $categorieplan->genre_plan }}</td>
                                <td>{{ $categorieplan->nombre_plan }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-12" align="right">
                        <hr>
                        <a class="btn btn-sm btn-primary me-sm-3 me-1"
                           href="{{ route($lien.'.edit',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(4)])}}">Suivant</a>
                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                            Retour</a>
                    </div>
                </div>
                <div class="tab-pane fade @if($id_etape==4) show active @endif" id="navs-top-actionformation"
                     role="tabpanel">
                    <table class="table table-bordered table-striped table-hover table-sm"
                           id="exampleData"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Intitluer de l'action de formation</th>
                            <th>Structure ou etablissemnt de formation</th>
                            <th>Nombre de bénéficiaire de l'action de formation</th>
                            <th>Nombre de groupe</th>
                            <th>Nombre d'heures par groupe</th>
                            <th>Coût de l'action</th>
                            <th>Coût de l'action accordée</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($actionplanformations as $key => $actionplanformation)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $actionplanformation->intitule_action_formation_plan }}</td>
                                <td>{{ $actionplanformation->structure_etablissement_action_ }}</td>
                                <td>{{ $actionplanformation->nombre_stagiaire_action_formati }}</td>
                                <td>{{ $actionplanformation->nombre_groupe_action_formation_ }}</td>
                                <td>{{ $actionplanformation->nombre_heure_action_formation_p }}</td>
                                <td>{{ $actionplanformation->cout_action_formation_plan }}</td>
                                <td>{{ $actionplanformation->cout_accorde_action_formation }}</td>
                                <td align="center">
                                    {{--                                        @can($lien.'-edit')--}}
                                    <a onclick="NewWindow('{{ route("planformation.show",\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}','',screen.width*2,screen.height,'yes','center',1);"
                                       target="_blank"
                                       class=" "
                                       title="Modifier"><img src='/assets/img/eye-solid.png'></a>

                                    {{--                                        @if()--}}
                                    @if(@$agreement->flag_annulation_plan!=true)
                                        <a href="{{route("agreement.substitution",['id_plan'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation),'id_action'=>\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)])}}"
                                           class=" "
                                           title="Modifier"><img src='/assets/img/editing.png'></a>
                                    @endif


                                    {{--                                        @endcan--}}

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-12" align="right">
                        <hr>
                        <a class="btn btn-sm btn-primary me-sm-3 me-1"
                           href="{{ route($lien.'.edit',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(5)])}}">Suivant</a>
                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                            Retour</a>
                    </div>
                </div>
                <div class="tab-pane fade @if($id_etape==5) show active @endif" id="navs-top-annulation"
                     role="tabpanel">
                    @if($demande_annulation_plan)
                        @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true)
                            <div class="col-md-12">
                                <h5 class="card-title mb-3" align="center"> Détail de la demande d'annulation</h5>
                            </div>
                            @if($demande_annulation_plan->flag_validation_demande_annulation_plan==true)
                                <div class="row">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            Demande d'annulation validée
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($demande_annulation_plan->flag_rejeter_demande_annulation_plan==true)
                                <div class="row">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            Demande d'annulation rejetée
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <form method="POST" class="form"
                                  action="{{route($lien.'.cancel',['id_etape'=>\App\Helpers\Crypt::UrlCrypt(5),'id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)])}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @endif
                                @else
                                    <form method="POST" class="form"
                                          action="{{route($lien.'.cancel',['id_etape'=>\App\Helpers\Crypt::UrlCrypt(5),'id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)])}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @endif

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-1">
                                                            <label> Motif de la demande d'annulation du plan</label>
                                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                                    name="id_motif_demande_annulation_plan"
                                                                    id="id_motif_demande_annulation_plan"
                                                                    @isset($demande_annulation_plan)
                                                                        @if($demande_annulation_plan->flag_soumis_demande_annulation_plan)
                                                                            disabled
                                                                @endif
                                                                @endisset
                                                            >
                                                                @foreach($motifs as $motif)
                                                                    <option value="{{$motif->id_motif}}"
                                                                            @isset($demande_annulation_plan)
                                                                                @if($motif->id_motif==$demande_annulation_plan->id_motif_demande_annulation_plan) selected @endif
                                                                        @endisset>{{$motif->libelle_motif}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    @isset($demande_annulation_plan)
                                                        @if($demande_annulation_plan->flag_soumis_demande_annulation_plan)
                                                            <div class="col-md-12 mt-2">
                                                                Pièce justificatif de la demande d'annulation<br>
                                                                <span class="badge bg-secondary">
                                                <a target="_blank" onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                    Voir la pièce
                                                </a>
                                            </span>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-label">Pièce justificatif de la demande d'annulation <strong
                                                                        style="color:red;"></strong></label>
                                                                <input type="file" name="piece_demande_annulation_plan"
                                                                       class="form-control form-control-sm" placeholder=""
                                                                       @isset($demande_annulation_plan->piece_demande_annulation_plan)value="{{$demande_annulation_plan->piece_demande_annulation_plan}}"@endisset/>
                                                                <div id="defaultFormControlHelp" class="form-text ">
                                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                        maxi : 5Mo</em>
                                                                </div>
                                                                <span class="badge bg-secondary"> <a target="_blank"
                                                                                                     onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);
                                                                                        ">
                                          Voir la pièce précédemment enregistrée  </a></span>
                                                            </div>

                                                        @endif
                                                    @else
                                                        <div class="col-md-12 mt-2">
                                                            <label class="form-label">Pièce justificatif de la demande d'annulation <strong
                                                                    style="color:red;"></strong></label>
                                                            <input type="file" name="piece_demande_annulation_plan"
                                                                   class="form-control form-control-sm" placeholder=""/>
                                                            <div id="defaultFormControlHelp" class="form-text ">
                                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                    maxi : 5Mo</em>
                                                            </div>
                                                        </div>
                                                    @endisset
                                                </div>

                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire de la demande d'annuation <strong
                                                            style="color:red;">*</strong></label>
                                                    <textarea class="form-control form-control-sm"
                                                              name="commentaire_demande_annulation_plan"
                                                              @isset($demande_annulation_plan)
                                                                  @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true)
                                                                      disabled
                                                              @endif
                                                              @endisset
                                                              id="commentaire_demande_annulation_plan" rows="6">@isset($demande_annulation_plan->commentaire_demande_annulation_plan){{$demande_annulation_plan->commentaire_demande_annulation_plan}}@endisset</textarea>
                                                </div>
                                            </div>

                                            @if($demande_annulation_plan)

                                                @if($demande_annulation_plan->flag_rejeter_demande_annulation_plan==true)
                                                    <div class="col-md-12 col-12 mt-3">
                                                        <div class="mb-1">
                                                            <label>Motif du rejet</label>
                                                            <textarea class="form-control form-control-sm"
                                                                      name="commentaire_final_demande_annulation_plan_formation"
                                                                      @isset($demande_annulation_plan)
                                                                          @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true)
                                                                              disabled
                                                                      @endif
                                                                      @endisset
                                                                      id="commentaire_final_demande_annulation_plan_formation" rows="6">@isset($demande_annulation_plan->commentaire_final_demande_annulation_plan_formation){{$demande_annulation_plan->commentaire_final_demande_annulation_plan_formation}}@endisset</textarea>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif



                                            <div class="col-12" align="right">
                                                <hr>
                                                @isset($demande_annulation_plan)
                                                    @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true)
                                                        <a class="btn btn-sm btn-primary me-sm-3 me-1"
                                                           href="{{ route($lien.'.edit',['id_plan_de_formation'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation),'id_etape'=>\App\Helpers\Crypt::UrlCrypt(6)])}}">Suivant</a>
                                                    @else
                                                        <button
                                                            onclick='javascript:if (!confirm("Voulez-vous soumettre la demande d annulation de ce plan de formation à un conseiller ? . Cette action est irreversible")) return false;'
                                                            type="submit" name="action" value="Enregistrer_soumettre_demande_annulation"
                                                            class="btn btn-sm btn-success me-sm-3 me-1">Soumettre la demande d'annulation
                                                        </button>
                                                        <button type="submit"
                                                                class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">
                                                            Modifier
                                                        </button>
                                                    @endif
                                                @else
                                                    <button type="submit"
                                                            class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">
                                                        Enregistrer
                                                    </button>
                                                @endisset


                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>

                                        </div>

                                        {{--                                @if($demande_annulation_plan->flag_rejeter_demande_annulation_plan==true)--}}
                                        {{--                                    <div class="row">--}}
                                        {{--                                        <li class="mb-4 pb-1 d-flex justify-content-between  align-items-center"--}}
                                        {{--                                            align="center">--}}
                                        {{--                                            <div class="badge bg-label-danger rounded p-2"><i--}}
                                        {{--                                                    class="ti ti-ban ti-sm"></i>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            <div class="d-flex justify-content-between w-100 flex-wrap">--}}
                                        {{--                                                <h6 class="mb-0 ms-3">Demande d'annulation rejetée</h6>--}}
                                        {{--                                            </div>--}}

                                        {{--                                        </li>--}}
                                        {{--                                    </div>--}}
                                        {{--                                @endif--}}

                                        {{--                    @if(!$demande_annulation_plan)--}}
                                        {{--                        @if(!$demande_annulation_plan->flag_soumis_demande_annulation_plan)--}}
                                    </form>
                            {{--                        @endif--}}
                            {{--                    @endif--}}
                </div>
            </div>
        </div>


    </div>

@endsection

