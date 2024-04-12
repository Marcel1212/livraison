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

    @php($Module='Agreement')
    @php($titre='Liste des agreements pour les plans de formations')
    @php($soustitre='Consulter un agreement pour le plans de formation')
    @php($lien='traitementdemandesubstitutionplan')
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
            <div align="right" class=" mb-3">
                <button type="button"
                        class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                        data-bs-toggle="modal" data-bs-target="#modalToggle">
                    Voir le parcours de validation
                </button>
            </div>
        <div class="nav-align-top nav-tabs-shadow ">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link"
                        role="tab" disabled
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
                        class="nav-link"
                        role="tab" disabled
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
                        class="nav-link"
                        role="tab" disabled
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-categorieplan"
                        aria-controls="navs-top-categorieplan"
                        aria-selected="false">
                        Effectif de l'entreprise
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        disabled
                        type="button"
                        class="nav-link active"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-substitution"
                        aria-controls="navs-top-substitution"
                        aria-selected="false">
                        Demande de substitution d'une action de formation
                    </button>
                </li>

                {{--                    <li class="nav-item">--}}
                {{--                        <button--}}
                {{--                            type="button"--}}
                {{--                            class="nav-link"--}}
                {{--                            role="tab"--}}
                {{--                            data-bs-toggle="tab"--}}
                {{--                            data-bs-target="#navs-top-annulation"--}}
                {{--                            aria-controls="navs-top-annulation"--}}
                {{--                            aria-selected="true">--}}
                {{--                            Demande d'annulation--}}
                {{--                        </button>--}}
                {{--                    </li>--}}
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade " id="navs-top-agreement" role="tabpanel">
                    <div class="col-xl-12">
                        {{--                        <table width="100%" style="border-collapse:collapse;border:none;">--}}
                        {{--                            <tbody>--}}
                        {{--                            <tr>--}}
                        {{--                                <td rowspan="2" style="width: 56.3pt;border: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>N&deg; ACTION</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td rowspan="2" style="width: 118.55pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>INTITULE DE L'ACTION</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td colspan="4" style="width: 133.25pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>PERSONNES CONCERNER</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td rowspan="2" style="width: 42.45pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>DUREE</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td rowspan="2" style="width: 98.55pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>INTERVENANT</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td rowspan="2" style="width: 70.05pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>COUT INITIAL</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td colspan="3" style="width: 105.6pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>CONTRIBUTION FDFP</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td rowspan="2" style="width: 90.85pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>TYPE ACTION</p>--}}
                        {{--                                </td>--}}
                        {{--                            </tr>--}}
                        {{--                            <tr>--}}
                        {{--                                <td style="width: 31.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>C</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 31.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>AM</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 31.65pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>EO</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 38.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>TOTAL</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>TOTAL ACCODEE</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>UTILISATION DIRECT</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>FINAN COMPLEMENTAIRE</p>--}}
                        {{--                                </td>--}}
                        {{--                            </tr>--}}
                        {{--                            <?php $i=000; $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; $total7=0; $total8=0; $total9=0; ?>--}}
                        {{--                            @foreach ($substitutions as $substitution)--}}
                        {{--                                    <?php--}}
                        {{--                                    $total1 += $substitution->cadre_fiche_demande_agrement;--}}
                        {{--                                    $total2 += $substitution->agent_maitrise_fiche_demande_ag;--}}
                        {{--                                    $total3 += $substitution->employe_fiche_demande_agrement;--}}
                        {{--                                    $total4 += $substitution->cadre_fiche_demande_agrement + $substitution->employe_fiche_demande_agrement + $substitution->agent_maitrise_fiche_demande_ag;--}}
                        {{--                                    $total5 += $substitution->nombre_heure_action_formation_p;--}}
                        {{--                                    $total6 += $substitution->cout_action_formation_plan;--}}
                        {{--                                    $total7 += $substitution->cout_accorde_action_formation;--}}
                        {{--                                    $total8 += $substitution->cout_accorde_action_formation;--}}
                        {{--                                    $total9 += 0;--}}
                        {{--                                    ?>--}}
                        {{--                                <tr>--}}
                        {{--                                    <td style="width: 56.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ ++$i }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 118.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $substitution->intitule_action_formation_plan }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 31.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $substitution->cadre_fiche_demande_agrement }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 31.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $substitution->agent_maitrise_fiche_demande_ag }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 31.65pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $substitution->employe_fiche_demande_agrement }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 38.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $substitution->cadre_fiche_demande_agrement + $substitution->agent_maitrise_fiche_demande_ag + $substitution->employe_fiche_demande_agrement}}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 42.45pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $substitution->nombre_heure_action_formation_p }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 98.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $substitution->raison_social_entreprises }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 70.05pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ number_format($substitution->cout_action_formation_plan) }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ number_format($substitution->cout_accorde_action_formation) }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ number_format($substitution->cout_accorde_action_formation) }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ 0 }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td style="width: 90.85pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $substitution->type_formation }}</p>--}}
                        {{--                                    </td>--}}
                        {{--                                </tr>--}}
                        {{--                            @endforeach--}}
                        {{--                            <tr>--}}
                        {{--                                <td style="width: 56.3pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">--}}

                        {{--                                </td>--}}
                        {{--                                <td style="width: 118.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>TOTAL</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 31.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total1 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 31.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total2 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 31.65pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total3 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 38.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total4 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 42.45pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total5 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 98.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>&nbsp;</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 70.05pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total6 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total7 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total8 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>{{ $total9 }}</p>--}}
                        {{--                                </td>--}}
                        {{--                                <td style="width: 90.85pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">--}}
                        {{--                                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>&nbsp;</p>--}}
                        {{--                                </td>--}}
                        {{--                            </tr>--}}
                        {{--                            </tbody>--}}
                        {{--                        </table>--}}
                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                    </div>

                </div>
                <div class="tab-pane fade" id="navs-top-planformation" role="tabpanel">
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
                <div class="tab-pane fade active show" id="navs-top-substitution" role="tabpanel">

                    {{--                   <table class="table table-bordered table-striped table-hover table-sm"--}}
                    {{--                           id="exampleData"--}}
                    {{--                           style="margin-top: 13px !important">--}}
                    {{--                        <thead>--}}
                    {{--                        <tr>--}}
                    {{--                            <th>No</th>--}}
                    {{--                            <th>Intitluer de l'action de formation </th>--}}
                    {{--                            <th>Structure ou etablissemnt de formation</th>--}}
                    {{--                            <th>Nombre de stagiaires</th>--}}
                    {{--                            <th>Nombre de groupe</th>--}}
                    {{--                            <th>Nombre d'heures par groupe</th>--}}
                    {{--                            <th>Cout de l'action</th>--}}
                    {{--                            <th>Cout de l'action accordée</th>--}}
                    {{--                            <th>Action</th>--}}
                    {{--                        </tr>--}}
                    {{--                        </thead>--}}
                    {{--                        <tbody>--}}
                    {{--                        @foreach ($actionplanformations as $key => $actionplanformation)--}}
                    {{--                            <tr>--}}
                    {{--                                <td>{{ $key+1 }}</td>--}}
                    {{--                                <td>{{ $actionplanformation->intitule_action_formation_plan }}</td>--}}
                    {{--                                <td>{{ $actionplanformation->structure_etablissement_action_ }}</td>--}}
                    {{--                                <td>{{ $actionplanformation->nombre_stagiaire_action_formati }}</td>--}}
                    {{--                                <td>{{ $actionplanformation->nombre_groupe_action_formation_ }}</td>--}}
                    {{--                                <td>{{ $actionplanformation->nombre_heure_action_formation_p }}</td>--}}
                    {{--                                <td>{{ $actionplanformation->cout_action_formation_plan }}</td>--}}
                    {{--                                <td>{{ $actionplanformation->cout_accorde_action_formation }}</td>--}}
                    {{--                                <td align="center">--}}
                    {{--                                    --}}{{--                                        @can($lien.'-edit')--}}
                    {{--                                    <a onclick="NewWindow('{{ route("planformation.show",\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"--}}
                    {{--                                       class=" "--}}
                    {{--                                       title="Modifier"><img src='/assets/img/eye-solid.png'></a>--}}

                    {{--                                    <a href="{{route("agreement.substitution",['id_plan'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation),'id_action'=>\App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan)])}}"--}}
                    {{--                                       class=" "--}}
                    {{--                                       title="Modifier"><img src='/assets/img/editing.png'></a>--}}

                    {{--                                    --}}{{--                                        @endcan--}}

                    {{--                                </td>--}}
                    {{--                            </tr>--}}
                    {{--                        @endforeach--}}
                    {{--                        </tbody>--}}
                    {{--                    </table>--}}


                    <div class="col-md-12">
                        <h6 class="card-title" align="center"> Détail de la demande de substitution</h6>
                    </div>
                    <div class="row">
                        <h6 class="card-title mt-3 mb-2"> Ancienne action de formation </h6>
{{--                        <div class="row">--}}
{{--                            <div class="col-12 col-md-12">--}}
{{--                                <label class="form-label" for="intitule_action_formation_plan_substi">Inititulé de l'action de formation <strong style="color:red;">*</strong></label>--}}
{{--                                <input--}}
{{--                                    type="text"--}}
{{--                                    id="intitule_action_formation_plan"--}}
{{--                                    name="intitule_action_formation_plan"--}}
{{--                                    class="form-control form-control-sm" disabled--}}
{{--                                    @isset($action_formation->intitule_action_formation_plan)--}}
{{--                                        value="{{$action_formation->intitule_action_formation_plan}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="nombre_groupe_action_formation_substi">Nombre de groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                <input--}}
{{--                                    type="number"--}}
{{--                                    id="nombre_groupe_action_formation_"--}}
{{--                                    name="nombre_groupe_action_formation_"--}}
{{--                                    class="form-control form-control-sm" disabled--}}
{{--                                    @isset($action_formation->nombre_groupe_action_formation_)--}}
{{--                                        value="{{$action_formation->nombre_groupe_action_formation_}}"--}}
{{--                                    @endisset                                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                <input--}}
{{--                                    type="number"--}}
{{--                                    id="nombre_heure_action_formation_p_substi"--}}
{{--                                    name="nombre_heure_action_formation_p_substi" disabled--}}
{{--                                    class="form-control form-control-sm"--}}
{{--                                    @isset($action_formation->nombre_heure_action_formation_p)--}}
{{--                                        value="{{$action_formation->nombre_heure_action_formation_p}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" >Coût de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                <input--}}
{{--                                    type="text"--}}
{{--                                    name="cout_action_formation_plan"--}}
{{--                                    class="form-control form-control-sm" disabled--}}
{{--                                    @isset($action_formation->cout_action_formation_plan)--}}
{{--                                        value="{{$action_formation->cout_action_formation_plan}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                <select--}}
{{--                                    id="id_type_formation" disabled--}}
{{--                                    name="id_type_formation"--}}
{{--                                    class="select2 form-select-sm input-group"--}}
{{--                                    aria-label="Default select example" onchange="changeFunction();">--}}
{{--                                    <option></option>--}}
{{--                                    @foreach($typeformations as $typeformation)--}}
{{--                                        <option value="{{$typeformation->id_type_formation}}"--}}
{{--                                                @isset($fiche_a_demande_agrement_acien->id_type_formation)--}}
{{--                                                    @if($fiche_a_demande_agrement_acien->id_type_formation==$typeformation->id_type_formation)--}}
{{--                                                        selected--}}
{{--                                            @endif--}}

{{--                                            @endisset--}}
{{--                                        >{{mb_strtoupper($typeformation->type_formation)}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="id_caracteristique_type_formation_substi">Caractéristique type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                <select id="id_caracteristique_type_formation" disabled name="id_caracteristique_type_formation_substi" class="select2 form-select-sm input-group">--}}
{{--                                    <option value='0'></option>--}}
{{--                                    @foreach($caracteristiques as $caracteristique)--}}

{{--                                        <option value="{{$caracteristique->id_caracteristique_type_formation}}"--}}


{{--                                                @isset($action_formation->id_caracteristique_type_formation)--}}
{{--                                                    @if($action_formation->id_caracteristique_type_formation==$caracteristique->id_caracteristique_type_formation)--}}
{{--                                                        selected--}}
{{--                                            @endif--}}

{{--                                            @endisset--}}
{{--                                        >{{mb_strtoupper($caracteristique->libelle_ctf)}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="id_entreprise_structure_formation_action_substi">Structure ou etablissement de formation <strong style="color:red;">*</strong></label>--}}
{{--                                <select disabled class="select2 form-select-sm input-group" name="id_entreprise_structure_formation_plan_formation_substi" id="id_entreprise_structure_formation_plan_formation_substi"--}}
{{--                                >--}}
{{--                                    @foreach($structureformations as $structureformation)--}}
{{--                                        <option value="{{$structureformation->id_entreprises}}"--}}

{{--                                                @isset($action_formation->id_entreprise_structure_formation_plan_formation)--}}
{{--                                                    @if($action_formation->id_entreprise_structure_formation_plan_formation==$structureformation->id_entreprises)--}}
{{--                                                        selected--}}
{{--                                            @endif--}}

{{--                                            @endisset--}}
{{--                                        >{{mb_strtoupper($structureformation->raison_social_entreprises)}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                <select--}}
{{--                                    id="id_but_formation"--}}
{{--                                    name="id_but_formation"--}}
{{--                                    class="select2 form-select-sm input-group"--}}
{{--                                    aria-label="Default select example" disabled>--}}
{{--                                    <option></option>--}}
{{--                                    @foreach($butformations as $butformation)--}}
{{--                                        <option value="{{$butformation->id_but_formation}}"--}}
{{--                                                @isset($fiche_a_demande_agrement_acien->id_but_formation)--}}
{{--                                                    @if($fiche_a_demande_agrement_acien->id_but_formation==$butformation->id_but_formation)--}}
{{--                                                        selected--}}
{{--                                            @endif--}}

{{--                                            @endisset--}}
{{--                                        >{{mb_strtoupper($butformation->but_formation)}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-2">--}}
{{--                                <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                <input--}}
{{--                                    type="date" disabled--}}
{{--                                    id="date_debut_fiche_agrement"--}}
{{--                                    name="date_debut_fiche_agrement"--}}
{{--                                    class="form-control form-control-sm"--}}
{{--                                    @isset($fiche_a_demande_agrement_acien->date_debut_fiche_agrement)--}}
{{--                                        value="{{date('Y-m-d', strtotime($fiche_a_demande_agrement_acien->date_debut_fiche_agrement))}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-2">--}}
{{--                                <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                <input--}}
{{--                                    type="date"--}}
{{--                                    id="date_fin_fiche_agrement"--}}
{{--                                    name="date_fin_fiche_agrement" disabled--}}
{{--                                    class="form-control form-control-sm"--}}
{{--                                    @isset($fiche_a_demande_agrement_acien->date_fin_fiche_agrement)--}}
{{--                                        value="{{date('Y-m-d', strtotime($fiche_a_demande_agrement_acien->date_fin_fiche_agrement))}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>--}}
{{--                                <input--}}
{{--                                    type="text" disabled--}}
{{--                                    id="lieu_formation_fiche_agrement"--}}
{{--                                    name="lieu_formation_fiche_agrement"--}}
{{--                                    class="form-control form-control-sm"--}}
{{--                                    @isset($fiche_a_demande_agrement_acien->lieu_formation_fiche_agrement)--}}
{{--                                        value="{{$fiche_a_demande_agrement_acien->lieu_formation_fiche_agrement}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 col-12">--}}
{{--                                <label>Secteur d'activité <strong style="color:red;">*</strong></label>--}}
{{--                                <select class="select2 form-select" disabled--}}
{{--                                        data-allow-clear="true" name="id_secteur_activite_substi"--}}
{{--                                        id="id_secteur_activite_substi">--}}
{{--                                    <option value="">-- Sélectionnez un secteur d'activité--- </option>--}}
{{--                                    @foreach ($secteuractivites as $activite)--}}
{{--                                        <option value="{{ $activite->id_secteur_activite }}"--}}
{{--                                                @isset($action_formation->id_secteur_activite_substi)--}}
{{--                                                    @if($action_formation->id_secteur_activite_substi==$activite->id_secteur_activite)--}}
{{--                                                        selected--}}
{{--                                            @endif--}}
{{--                                            @endisset--}}
{{--                                        >{{ mb_strtoupper($activite->libelle_secteur_activite) }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres </label>--}}
{{--                                <input--}}
{{--                                    type="number"--}}
{{--                                    id="cadre_fiche_demande_agrement"--}}
{{--                                    name="cadre_fiche_demande_agrement"--}}
{{--                                    class="form-control form-control-sm"--}}
{{--                                    disabled--}}
{{--                                    @isset($fiche_a_demande_agrement_acien->cadre_fiche_demande_agrement)--}}
{{--                                        value="{{$fiche_a_demande_agrement_acien->cadre_fiche_demande_agrement}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise <strong style="color:red;">*</strong></label>--}}
{{--                                <input--}}
{{--                                    type="number"--}}
{{--                                    id="agent_maitrise_fiche_demande_ag"--}}
{{--                                    name="agent_maitrise_fiche_demande_ag"--}}
{{--                                    class="form-control form-control-sm"--}}
{{--                                    disabled--}}
{{--                                    @isset($fiche_a_demande_agrement_acien->agent_maitrise_fiche_demande_ag)--}}
{{--                                        value="{{$fiche_a_demande_agrement_acien->agent_maitrise_fiche_demande_ag}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers </label>--}}
{{--                                <input--}}
{{--                                    type="number" disabled--}}
{{--                                    id="employe_fiche_demande_agrement"--}}
{{--                                    name="employe_fiche_demande_agrement"--}}
{{--                                    class="form-control form-control-sm"--}}
{{--                                    @isset($fiche_a_demande_agrement_acien->employe_fiche_demande_agrement)--}}
{{--                                        value="{{$fiche_a_demande_agrement_acien->employe_fiche_demande_agrement}}"--}}
{{--                                    @endisset--}}
{{--                                />--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="file_beneficiare_substi">Charger les beneficiaires de la formation (Excel)</label>--}}
{{--                                <div class="col-md-12 mt-2">--}}
{{--                                    @isset($fiche_a_demande_agrement_acien->file_beneficiare_fiche_agrement)--}}
{{--                                        <span class="badge bg-secondary"> <a target="_blank"--}}
{{--                                                                             onclick="NewWindow('{{ asset("/pieces/fichier_beneficiaire_lie_aux_action_plan_formation/". $fiche_a_demande_agrement_acien->file_beneficiare_fiche_agrement)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                          Voir la pièce  </a></span>--}}
{{--                                    @endisset--}}
{{--                                </div>--}}
{{--                                <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                        maxi : 5Mo</em>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-4">--}}
{{--                                <label class="form-label" for="facture_proforma_action_formati_substi">Joindre les factures proforma (PDF) </label>--}}
{{--                                <div class="col-md-12 mt-2">--}}
{{--                                    @isset($action_formation->facture_proforma_action_formati)--}}
{{--                                        <span class="badge bg-secondary">--}}
{{--                                            <a target="_blank" onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $action_formation->facture_proforma_action_formati)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                                        Voir la pièce </a></span>--}}
{{--                                    @endisset--}}
{{--                                </div>--}}
{{--                                <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                        maxi : 5Mo</em>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-12">--}}
{{--                                <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>--}}
{{--                                <textarea class="form-control form-control-sm" disabled  name="objectif_pedagogique_fiche_agre" id="objectif_pedagogique_fiche_agre" rows="6">@isset($fiche_a_demande_agrement_acien->employe_fiche_demande_agrement){{$fiche_a_demande_agrement_acien->objectif_pedagogique_fiche_agre}}@endisset</textarea>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mt-3">--}}
{{--                            <h6>Nouvelle action de formation émise</h6>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-12 col-md-12">--}}
{{--                                    <label class="form-label" for="intitule_action_formation_plan_substi">Inititulé de l'action de formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <input--}}
{{--                                        type="text"--}}
{{--                                        id="intitule_action_formation_plan_substi"--}}
{{--                                        name="intitule_action_formation_plan_substi"--}}
{{--                                        class="form-control form-control-sm" disabled--}}
{{--                                        @isset($demande_substitution->intitule_action_formation_plan_substi)--}}
{{--                                            value="{{$demande_substitution->intitule_action_formation_plan_substi}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="nombre_groupe_action_formation_substi">Nombre de groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                    <input--}}
{{--                                        type="number"--}}
{{--                                        id="nombre_groupe_action_formation_substi"--}}
{{--                                        name="nombre_groupe_action_formation_substi"--}}
{{--                                        class="form-control form-control-sm" disabled--}}
{{--                                        @isset($demande_substitution->nombre_groupe_action_formation_substi)--}}
{{--                                            value="{{$demande_substitution->nombre_groupe_action_formation_substi}}"--}}
{{--                                        @endisset                                                />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes  <strong style="color:red;">*</strong></label>--}}
{{--                                    <input--}}
{{--                                        type="number"--}}
{{--                                        id="nombre_heure_action_formation_p_substi"--}}
{{--                                        name="nombre_heure_action_formation_p_substi" disabled--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        @isset($demande_substitution->nombre_heure_action_formation_p_substi)--}}
{{--                                            value="{{$demande_substitution->nombre_heure_action_formation_p_substi}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" >Coût de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <input--}}
{{--                                        type="text"--}}
{{--                                        name="cout_action_formation_plan_substi"--}}
{{--                                        class="form-control form-control-sm" disabled--}}
{{--                                        @isset($demande_substitution->cout_action_formation_plan_substi)--}}
{{--                                            value="{{$demande_substitution->cout_action_formation_plan_substi}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <select--}}
{{--                                        id="id_type_formation" disabled--}}
{{--                                        name="id_type_formation"--}}
{{--                                        class="select2 form-select-sm input-group"--}}
{{--                                        aria-label="Default select example" onchange="changeFunction();">--}}
{{--                                        <option></option>--}}
{{--                                        @foreach($typeformations as $typeformation)--}}
{{--                                            <option value="{{$typeformation->id_type_formation}}"--}}
{{--                                                    @isset($fiche_a_demande_agrement->id_type_formation)--}}
{{--                                                        @if($fiche_a_demande_agrement->id_type_formation==$typeformation->id_type_formation)--}}
{{--                                                            selected--}}
{{--                                                @endif--}}

{{--                                                @endisset--}}
{{--                                            >{{mb_strtoupper($typeformation->type_formation)}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="id_caracteristique_type_formation_substi">Caractéristique type de formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <select id="id_caracteristique_type_formation" disabled name="id_caracteristique_type_formation_substi" class="select2 form-select-sm input-group">--}}
{{--                                        <option value='0'></option>--}}
{{--                                        @foreach($caracteristiques as $caracteristique)--}}
{{--                                            <option value="{{$caracteristique->id_caracteristique_type_formation}}"--}}

{{--                                                    @isset($demande_substitution->id_caracteristique_type_formation_substi)--}}
{{--                                                        @if($demande_substitution->id_caracteristique_type_formation_substi==$caracteristique->id_caracteristique_type_formation)--}}
{{--                                                            selected--}}
{{--                                                @endif--}}

{{--                                                @endisset--}}
{{--                                            >{{mb_strtoupper($caracteristique->libelle_ctf)}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="id_entreprise_structure_formation_action_substi">Structure ou etablissement de formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <select disabled class="select2 form-select-sm input-group" name="id_entreprise_structure_formation_plan_formation_substi" id="id_entreprise_structure_formation_plan_formation_substi"--}}
{{--                                    >--}}
{{--                                        @foreach($structureformations as $structureformation)--}}
{{--                                            <option value="{{$structureformation->id_entreprises}}"--}}

{{--                                                    @isset($demande_substitution->id_entreprise_structure_formation_plan_formation_substi)--}}
{{--                                                        @if($demande_substitution->id_entreprise_structure_formation_plan_formation_substi==$structureformation->id_entreprises)--}}
{{--                                                            selected--}}
{{--                                                @endif--}}

{{--                                                @endisset--}}
{{--                                            >{{mb_strtoupper($structureformation->raison_social_entreprises)}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <select--}}
{{--                                        id="id_but_formation"--}}
{{--                                        name="id_but_formation"--}}
{{--                                        class="select2 form-select-sm input-group"--}}
{{--                                        aria-label="Default select example" disabled>--}}
{{--                                        <option></option>--}}
{{--                                        @foreach($butformations as $butformation)--}}
{{--                                            <option value="{{$butformation->id_but_formation}}"--}}
{{--                                                    @isset($fiche_a_demande_agrement->id_but_formation)--}}
{{--                                                        @if($fiche_a_demande_agrement->id_but_formation==$butformation->id_but_formation)--}}
{{--                                                            selected--}}
{{--                                                @endif--}}

{{--                                                @endisset--}}
{{--                                            >{{mb_strtoupper($butformation->but_formation)}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-2">--}}
{{--                                    <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                    <input--}}
{{--                                        type="date" disabled--}}
{{--                                        id="date_debut_fiche_agrement"--}}
{{--                                        name="date_debut_fiche_agrement"--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        @isset($fiche_a_demande_agrement->date_debut_fiche_agrement)--}}
{{--                                            value="{{date('Y-m-d', strtotime($fiche_a_demande_agrement->date_debut_fiche_agrement))}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-2">--}}
{{--                                    <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation <strong style="color:red;">*</strong></label>--}}
{{--                                    <input--}}
{{--                                        type="date"--}}
{{--                                        id="date_fin_fiche_agrement"--}}
{{--                                        name="date_fin_fiche_agrement" disabled--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        @isset($fiche_a_demande_agrement->date_fin_fiche_agrement)--}}
{{--                                            value="{{date('Y-m-d', strtotime($fiche_a_demande_agrement->date_fin_fiche_agrement))}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation <strong style="color:red;">*</strong></label>--}}
{{--                                    <input--}}
{{--                                        type="text" disabled--}}
{{--                                        id="lieu_formation_fiche_agrement"--}}
{{--                                        name="lieu_formation_fiche_agrement"--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        @isset($fiche_a_demande_agrement->lieu_formation_fiche_agrement)--}}
{{--                                            value="{{$fiche_a_demande_agrement->lieu_formation_fiche_agrement}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4 col-12">--}}
{{--                                    <label>Secteur d'activité <strong style="color:red;">*</strong></label>--}}

{{--                                    <select class="select2 form-select" disabled--}}
{{--                                            data-allow-clear="true" name="id_secteur_activite_substi"--}}
{{--                                            id="id_secteur_activite_substi">--}}
{{--                                        <option value="">-- Sélectionnez un secteur d'activité--- </option>--}}
{{--                                        @foreach ($secteuractivites as $activite)--}}
{{--                                            <option value="{{ $activite->id_secteur_activite }}"--}}
{{--                                                    @isset($demande_substitution->id_secteur_activite_substi)--}}
{{--                                                        @if($demande_substitution->id_secteur_activite_substi==$activite->id_secteur_activite)--}}
{{--                                                            selected--}}
{{--                                                @endif--}}
{{--                                                @endisset--}}
{{--                                            >{{ mb_strtoupper($activite->libelle_secteur_activite) }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadres </label>--}}
{{--                                    <input--}}
{{--                                        type="number"--}}
{{--                                        id="cadre_fiche_demande_agrement"--}}
{{--                                        name="cadre_fiche_demande_agrement"--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        disabled--}}
{{--                                        @isset($fiche_a_demande_agrement->cadre_fiche_demande_agrement)--}}
{{--                                            value="{{$fiche_a_demande_agrement->cadre_fiche_demande_agrement}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agents de maitrise <strong style="color:red;">*</strong></label>--}}
{{--                                    <input--}}
{{--                                        type="number"--}}
{{--                                        id="agent_maitrise_fiche_demande_ag"--}}
{{--                                        name="agent_maitrise_fiche_demande_ag"--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        disabled--}}
{{--                                        @isset($fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag)--}}
{{--                                            value="{{$fiche_a_demande_agrement->agent_maitrise_fiche_demande_ag}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employés / ouvriers </label>--}}
{{--                                    <input--}}
{{--                                        type="number" disabled--}}
{{--                                        id="employe_fiche_demande_agrement"--}}
{{--                                        name="employe_fiche_demande_agrement"--}}
{{--                                        class="form-control form-control-sm"--}}
{{--                                        @isset($fiche_a_demande_agrement->employe_fiche_demande_agrement)--}}
{{--                                            value="{{$fiche_a_demande_agrement->employe_fiche_demande_agrement}}"--}}
{{--                                        @endisset--}}
{{--                                    />--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="file_beneficiare_substi">Charger les beneficiaires de la formation (Excel)</label>--}}
{{--                                    <div class="col-md-12 mt-2">--}}
{{--                                        @isset($fiche_a_demande_agrement->file_beneficiare_fiche_agrement)--}}
{{--                                            <span class="badge bg-secondary"> <a target="_blank"--}}
{{--                                                                                 onclick="NewWindow('{{ asset("/pieces/fichier_beneficiaire_lie_aux_action_plan_formation/". $fiche_a_demande_agrement->file_beneficiare_fiche_agrement)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                          Voir la pièce  </a></span>--}}
{{--                                        @endisset--}}
{{--                                    </div>--}}
{{--                                    <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                            maxi : 5Mo</em>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-md-4">--}}
{{--                                    <label class="form-label" for="facture_proforma_action_formati_substi">Joindre les factures proforma (PDF) </label>--}}
{{--                                    <div class="col-md-12 mt-2">--}}
{{--                                        @isset($demande_substitution->facture_proforma_action_formati_substi)--}}
{{--                                            <span class="badge bg-secondary"> <a target="_blank"--}}
{{--                                                                                 onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $demande_substitution->facture_proforma_action_formati_substi)}}','',screen.width/2,screen.height,'yes','center',1);--}}
{{--                                                                                        ">--}}
{{--                                                        Voir la pièce </a></span>--}}
{{--                                        @endisset--}}
{{--                                    </div>--}}
{{--                                    <div id="defaultFormControlHelp" class="form-text ">--}}
{{--                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
{{--                                            maxi : 5Mo</em>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                                <div class="col-12 col-md-12">--}}
{{--                                    <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pédagogique <strong style="color:red;">*</strong></label>--}}
{{--                                    <textarea class="form-control form-control-sm" disabled  name="objectif_pedagogique_fiche_agre" id="objectif_pedagogique_fiche_agre" rows="6">@isset($fiche_a_demande_agrement->employe_fiche_demande_agrement){{$fiche_a_demande_agrement->objectif_pedagogique_fiche_agre}}@endisset</textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <h6 class="card-title mt-5 mb-2">Information sur la demande  de substitution</h6>--}}

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label> Motif de la demande de substitution du plan d'action</label>
                                                <select disabled class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_plan_substi" id="id_motif_demande_plan_substi" >
                                                    @foreach($motifs as $motif)
                                                        <option value="{{$motif->id_motif}}" >{{$motif->libelle_motif}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Pièce justificatif de la demande de substitution</label>
                                            <div class="mt-2">
                                                @isset($demande_substitution->piece_demande_plan_substi)
                                                    <span class="badge bg-secondary">
                                                            <a target="_blank" onclick="NewWindow('{{ asset("/pieces/piece_demande_substi/". $demande_substitution->piece_demande_plan_substi)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce
                                                            </a>
                                                        </span>
                                                @endisset
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label>Commentaire de la demande de substitution <strong
                                                style="color:red;">*</strong></label>
                                        <textarea disabled class="form-control form-control-sm"  name="commentaire_demande_plan_substi" id="commentaire_demande_plan_substi" rows="6"> @isset($demande_substitution->commentaire_demande_plan_substi){{$demande_substitution->commentaire_demande_plan_substi}}@endisset</textarea>
                                    </div>
                                </div>

                            <div class="col-md-12">
                                <h6 class="card-title mt-3" align="center"> Traitement de la demande de substitution</h6>
                            </div>
                            <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi)) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id2) }}"/>
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>
                                            @if($parcoursexist->count()<1)
                                                <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                            @else
                                                <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if(count($parcoursexist)<1){?>
                                        <button type="submit" name="action" value="Valider"
                                                class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                            Valider
                                        </button>
                                        <button type="submit" name="action" value="Rejeter"
                                                class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                            Rejeter
                                        </button>
                                        <?php } ?>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                           href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                            </div>


                    {{--                    @isset($demande_annulation_plan)--}}
                    {{--                            @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true)--}}
                    {{--                                <div class="col-md-12">--}}
                    {{--                                    <div class="col-md-12">--}}
                    {{--                                        <h5 class="card-title mb-3" align="center"> Détail de la demande d'annulation</h5>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="row">--}}
                    {{--                                        <div class="col-md-6">--}}
                    {{--                                            <div class="row">--}}
                    {{--                                                <div class="col-md-12 mb-3">--}}
                    {{--                                                    <div class="mb-1">--}}
                    {{--                                                        <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                        <select class="select2 form-select-sm input-group" disabled data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">--}}
                    {{--                                                            @foreach($motifs as $motif)--}}
                    {{--                                                                <option value="{{$motif->id_motif}}">{{$motif->libelle_motif}}</option>--}}
                    {{--                                                            @endforeach--}}
                    {{--                                                        </select>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-3">--}}
                    {{--                                                    <label class="form-label">Pièce justificatif--}}
                    {{--                                                        de la demande d'annulation</label>--}}
                    {{--                                                    <br>--}}
                    {{--                                                    @isset($demande_annulation_plan->piece_demande_annulation_plan)--}}
                    {{--                                                        <span class="badge bg-secondary"> <a target="_blank"--}}
                    {{--                                                                                             onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);--}}
                    {{--                                                                                        ">--}}
                    {{--                                          Voir la pièce  </a></span>--}}
                    {{--                                                    @endisset--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}

                    {{--                                        </div>--}}
                    {{--                                        <div class="col-md-6">--}}
                    {{--                                            <div class="mb-1">--}}
                    {{--                                                <label> Commentaire de la demande d'annulation du plan</label>--}}
                    {{--                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"--}}
                    {{--                                                          style="height: 121px;" disabled>@isset($demande_annulation_plan->commentaire_demande_annulation_plan) {{$demande_annulation_plan->commentaire_demande_annulation_plan}} @endisset</textarea>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                    <div class="col-12" align="right">--}}
                    {{--                                        <hr>--}}
                    {{--                                        <a class="btn btn-sm btn-outline-secondary float-end waves-effect"--}}
                    {{--                                           href="/{{$lien }}">--}}
                    {{--                                            Retour</a>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            @else--}}
                    {{--                                <form method="POST" class="form"--}}
                    {{--                                      action="{{route($lien.'.cancel.update',['id_demande'=>\App\Helpers\Crypt::UrlCrypt($demande_annulation_plan->id_demande_annulation_plan), 'id_plan'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)])}}" enctype="multipart/form-data">--}}
                    {{--                                    @csrf--}}
                    {{--                                    @method('put')--}}
                    {{--                                    <div class="row">--}}
                    {{--                                        <div class="col-md-6 col-12">--}}
                    {{--                                            <div class="row">--}}
                    {{--                                                <div class="col-md-12">--}}
                    {{--                                                    <div class="mb-1">--}}
                    {{--                                                        <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                        <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >--}}
                    {{--                                                            @foreach($motifs as $motif)--}}
                    {{--                                                                <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>--}}
                    {{--                                                            @endforeach--}}
                    {{--                                                        </select>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-2">--}}
                    {{--                                                    <label class="form-label">Pièce justificatif de la demande d'annulation <strong--}}
                    {{--                                                            style="color:red;"></strong></label>--}}
                    {{--                                                    <input type="file" name="piece_demande_annulation_plan"--}}
                    {{--                                                           class="form-control form-control-sm" placeholder=""--}}
                    {{--                                                           @isset($demande_annulation_plan->piece_demande_annulation_plan)value="{{$demande_annulation_plan->piece_demande_annulation_plan}}"@endisset/>--}}
                    {{--                                                    <div id="defaultFormControlHelp" class="form-text ">--}}
                    {{--                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
                    {{--                                                            maxi : 5Mo</em>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-2">--}}
                    {{--                                                    @isset($demande_annulation_plan->piece_demande_annulation_plan)--}}
                    {{--                                                        <span class="badge bg-secondary"> <a target="_blank"--}}
                    {{--                                                                                             onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);--}}
                    {{--                                                                                        ">--}}
                    {{--                                          Voir la pièce précédemment enregistrée  </a></span>--}}
                    {{--                                                    @endisset--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}

                    {{--                                        </div>--}}
                    {{--                                        <div class="col-md-6 col-12">--}}
                    {{--                                            <div class="mb-1">--}}
                    {{--                                                <label>Commentaire de la demande d'annuation <strong--}}
                    {{--                                                        style="color:red;">*</strong></label>--}}
                    {{--                                                <textarea class="form-control form-control-sm"  name="commentaire_demande_annulation_plan" id="commentaire_demande_annulation_plan" rows="6">@isset($demande_annulation_plan->commentaire_demande_annulation_plan){{$demande_annulation_plan->commentaire_demande_annulation_plan}}@endisset</textarea>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}


                    {{--                                        <div class="col-12" align="right">--}}
                    {{--                                            <hr>--}}
                    {{--                                            <button onclick='javascript:if (!confirm("Voulez-vous soumettre la demande d annulation de ce plan de formation à un conseiller ? . Cette action est irreversible")) return false;'  type="submit" name="action" value="Enregistrer_soumettre_plan_formation" class="btn btn-sm btn-success me-sm-3 me-1">Soumettre la demande d'annulation</button>--}}

                    {{--                                            <button type="submit"--}}
                    {{--                                                    class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">--}}
                    {{--                                                Modifier--}}
                    {{--                                            </button>--}}
                    {{--                                            <a class="btn btn-sm btn-outline-secondary waves-effect"--}}
                    {{--                                               href="/{{$lien }}">--}}
                    {{--                                                Retour</a>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                </form>--}}
                    {{--                            @endif--}}
                    {{--                        @else--}}
                    {{--                            <form method="POST" class="form"--}}
                    {{--                                  action="{{ route($lien.'.cancel.store', \App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)) }}" enctype="multipart/form-data">--}}
                    {{--                                @csrf--}}
                    {{--                                <div class="row">--}}
                    {{--                                    <div class="col-md-6 col-12">--}}
                    {{--                                        <div class="row">--}}
                    {{--                                            <div class="col-md-12">--}}
                    {{--                                                <div class="mb-1">--}}
                    {{--                                                    <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                    <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >--}}
                    {{--                                                        @foreach($motifs as $motif)--}}
                    {{--                                                            <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>--}}
                    {{--                                                        @endforeach--}}
                    {{--                                                    </select>--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}
                    {{--                                            <div class="col-md-12 mt-2">--}}
                    {{--                                                <label class="form-label">Pièce justificatif de la demande d'annulation <strong--}}
                    {{--                                                        style="color:red;">*</strong></label>--}}
                    {{--                                                <input type="file" name="piece_demande_annulation_plan"--}}
                    {{--                                                       class="form-control form-control-sm" placeholder=""--}}
                    {{--                                                       required="required"--}}
                    {{--                                                       value="{{ old('piece_demande_annulation_plan') }}"/>--}}
                    {{--                                                <div id="defaultFormControlHelp" class="form-text ">--}}
                    {{--                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
                    {{--                                                        maxi : 5Mo</em>--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                    <div class="col-md-6 col-12">--}}
                    {{--                                        <div class="mb-1">--}}
                    {{--                                            <label>Commentaire de la demande d'annuation <strong--}}
                    {{--                                                    style="color:red;">*</strong></label>--}}
                    {{--                                            <textarea class="form-control form-control-sm"  name="commentaire_demande_annulation_plan" id="commentaire_demande_annulation_plan" rows="6">{{ old('commentaire_demande_annulation_plan') }}</textarea>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}


                    {{--                                    <div class="col-12" align="right">--}}
                    {{--                                        <hr>--}}

                    {{--                                        <button type="submit"--}}
                    {{--                                                class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">--}}
                    {{--                                            Enregistrer--}}
                    {{--                                        </button>--}}
                    {{--                                        <a class="btn btn-sm btn-outline-secondary waves-effect"--}}
                    {{--                                           href="/{{$lien }}">--}}
                    {{--                                            Retour</a>--}}
                    {{--                                    </div>--}}

                    {{--                                </div>--}}
                    {{--                            </form>--}}
                    {{--                        @endisset--}}
                </div>
                <div class="tab-pane fade " id="navs-top-annulation" role="tabpanel">
                    {{--                        @isset($demande_annulation_plan)--}}
                    {{--                            @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true)--}}
                    {{--                                <div class="col-md-12">--}}
                    {{--                                    <div class="col-md-12">--}}
                    {{--                                        <h5 class="card-title mb-3" align="center"> Détail de la demande d'annulation</h5>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="row">--}}
                    {{--                                        <div class="col-md-6">--}}
                    {{--                                            <div class="row">--}}
                    {{--                                                <div class="col-md-12 mb-3">--}}
                    {{--                                                    <div class="mb-1">--}}
                    {{--                                                        <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                        <select class="select2 form-select-sm input-group" disabled data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">--}}
                    {{--                                                            @foreach($motifs as $motif)--}}
                    {{--                                                                <option value="{{$motif->id_motif}}">{{$motif->libelle_motif}}</option>--}}
                    {{--                                                            @endforeach--}}
                    {{--                                                        </select>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-3">--}}
                    {{--                                                    <label class="form-label">Pièce justificatif--}}
                    {{--                                                        de la demande d'annulation</label>--}}
                    {{--                                                    <br>--}}
                    {{--                                                    @isset($demande_annulation_plan->piece_demande_annulation_plan)--}}
                    {{--                                                        <span class="badge bg-secondary"> <a target="_blank"--}}
                    {{--                                                                                             onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);--}}
                    {{--                                                                                        ">--}}
                    {{--                                          Voir la pièce  </a></span>--}}
                    {{--                                                    @endisset--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}

                    {{--                                        </div>--}}
                    {{--                                        <div class="col-md-6">--}}
                    {{--                                            <div class="mb-1">--}}
                    {{--                                                <label> Commentaire de la demande d'annulation du plan</label>--}}
                    {{--                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"--}}
                    {{--                                                          style="height: 121px;" disabled>@isset($demande_annulation_plan->commentaire_demande_annulation_plan) {{$demande_annulation_plan->commentaire_demande_annulation_plan}} @endisset</textarea>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                    <div class="col-12" align="right">--}}
                    {{--                                        <hr>--}}
                    {{--                                        <a class="btn btn-sm btn-outline-secondary float-end waves-effect"--}}
                    {{--                                           href="/{{$lien }}">--}}
                    {{--                                            Retour</a>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            @else--}}
                    {{--                                <form method="POST" class="form"--}}
                    {{--                                      action="{{route($lien.'.cancel.update',['id_demande'=>\App\Helpers\Crypt::UrlCrypt($demande_annulation_plan->id_demande_annulation_plan), 'id_plan'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)])}}" enctype="multipart/form-data">--}}
                    {{--                                    @csrf--}}
                    {{--                                    @method('put')--}}
                    {{--                                    <div class="row">--}}
                    {{--                                        <div class="col-md-6 col-12">--}}
                    {{--                                            <div class="row">--}}
                    {{--                                                <div class="col-md-12">--}}
                    {{--                                                    <div class="mb-1">--}}
                    {{--                                                        <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                        <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >--}}
                    {{--                                                            @foreach($motifs as $motif)--}}
                    {{--                                                                <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>--}}
                    {{--                                                            @endforeach--}}
                    {{--                                                        </select>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-2">--}}
                    {{--                                                    <label class="form-label">Pièce justificatif de la demande d'annulation <strong--}}
                    {{--                                                            style="color:red;"></strong></label>--}}
                    {{--                                                    <input type="file" name="piece_demande_annulation_plan"--}}
                    {{--                                                           class="form-control form-control-sm" placeholder=""--}}
                    {{--                                                           @isset($demande_annulation_plan->piece_demande_annulation_plan)value="{{$demande_annulation_plan->piece_demande_annulation_plan}}"@endisset/>--}}
                    {{--                                                    <div id="defaultFormControlHelp" class="form-text ">--}}
                    {{--                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
                    {{--                                                            maxi : 5Mo</em>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-2">--}}
                    {{--                                                    @isset($demande_annulation_plan->piece_demande_annulation_plan)--}}
                    {{--                                                        <span class="badge bg-secondary"> <a target="_blank"--}}
                    {{--                                                                                             onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);--}}
                    {{--                                                                                        ">--}}
                    {{--                                          Voir la pièce précédemment enregistrée  </a></span>--}}
                    {{--                                                    @endisset--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}

                    {{--                                        </div>--}}
                    {{--                                        <div class="col-md-6 col-12">--}}
                    {{--                                            <div class="mb-1">--}}
                    {{--                                                <label>Commentaire de la demande d'annuation <strong--}}
                    {{--                                                        style="color:red;">*</strong></label>--}}
                    {{--                                                <textarea class="form-control form-control-sm"  name="commentaire_demande_annulation_plan" id="commentaire_demande_annulation_plan" rows="6">@isset($demande_annulation_plan->commentaire_demande_annulation_plan){{$demande_annulation_plan->commentaire_demande_annulation_plan}}@endisset</textarea>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}


                    {{--                                        <div class="col-12" align="right">--}}
                    {{--                                            <hr>--}}
                    {{--                                            <button onclick='javascript:if (!confirm("Voulez-vous soumettre la demande d annulation de ce plan de formation à un conseiller ? . Cette action est irreversible")) return false;'  type="submit" name="action" value="Enregistrer_soumettre_plan_formation" class="btn btn-sm btn-success me-sm-3 me-1">Soumettre la demande d'annulation</button>--}}

                    {{--                                            <button type="submit"--}}
                    {{--                                                    class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">--}}
                    {{--                                                Modifier--}}
                    {{--                                            </button>--}}
                    {{--                                            <a class="btn btn-sm btn-outline-secondary waves-effect"--}}
                    {{--                                               href="/{{$lien }}">--}}
                    {{--                                                Retour</a>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                </form>--}}
                    {{--                            @endif--}}
                    {{--                        @else--}}
                    {{--                            <form method="POST" class="form"--}}
                    {{--                                  action="{{ route($lien.'.cancel.store', \App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)) }}" enctype="multipart/form-data">--}}
                    {{--                                @csrf--}}
                    {{--                                <div class="row">--}}
                    {{--                                    <div class="col-md-6 col-12">--}}
                    {{--                                        <div class="row">--}}
                    {{--                                            <div class="col-md-12">--}}
                    {{--                                                <div class="mb-1">--}}
                    {{--                                                    <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                    <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >--}}
                    {{--                                                        @foreach($motifs as $motif)--}}
                    {{--                                                            <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>--}}
                    {{--                                                        @endforeach--}}
                    {{--                                                    </select>--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}
                    {{--                                            <div class="col-md-12 mt-2">--}}
                    {{--                                                <label class="form-label">Pièce justificatif de la demande d'annulation <strong--}}
                    {{--                                                        style="color:red;">*</strong></label>--}}
                    {{--                                                <input type="file" name="piece_demande_annulation_plan"--}}
                    {{--                                                       class="form-control form-control-sm" placeholder=""--}}
                    {{--                                                       required="required"--}}
                    {{--                                                       value="{{ old('piece_demande_annulation_plan') }}"/>--}}
                    {{--                                                <div id="defaultFormControlHelp" class="form-text ">--}}
                    {{--                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
                    {{--                                                        maxi : 5Mo</em>--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                    <div class="col-md-6 col-12">--}}
                    {{--                                        <div class="mb-1">--}}
                    {{--                                            <label>Commentaire de la demande d'annuation <strong--}}
                    {{--                                                    style="color:red;">*</strong></label>--}}
                    {{--                                            <textarea class="form-control form-control-sm"  name="commentaire_demande_annulation_plan" id="commentaire_demande_annulation_plan" rows="6">{{ old('commentaire_demande_annulation_plan') }}</textarea>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}


                    {{--                                    <div class="col-12" align="right">--}}
                    {{--                                        <hr>--}}

                    {{--                                        <button type="submit"--}}
                    {{--                                                class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">--}}
                    {{--                                            Enregistrer--}}
                    {{--                                        </button>--}}
                    {{--                                        <a class="btn btn-sm btn-outline-secondary waves-effect"--}}
                    {{--                                           href="/{{$lien }}">--}}
                    {{--                                            Retour</a>--}}
                    {{--                                    </div>--}}

                    {{--                                </div>--}}
                    {{--                            </form>--}}
                    {{--                        @endisset--}}
                </div>

            </div>
        </div>
            <div class="col-md-4 col-12">
                <div class="modal animate__animated animate__fadeInDownBig fade" id="modalToggle"
                     aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalToggleLabel">Etapes </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="card">
                                <h5 class="card-header">Parcours de la demande de substitution de l'action du plan de formation</h5>
                                <div class="card-body pb-2">
                                    <ul class="timeline pt-3">
                                        @foreach ($ResultProssesList as $res)
                                            <li class="timeline-item pb-4 timeline-item-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                            <span class="timeline-indicator-advanced timeline-indicator-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                              <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                            </span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header border-bottom mb-3">
                                                        <h6 class="mb-0">{{ $res->priorite_combi_proc }}</h6>
                                                        <span class="text-muted"><strong>{{ $res->name }}</strong></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-wrap mb-2">
                                                        <div class="d-flex align-items-center">
                                                            @if($res->is_valide==true)
                                                                <div class="row ">
                                                                    <div>
                                                                        <span>Observation : {{ $res->comment_parcours }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span>Validé le  {{ $res->date_valide }}</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($res->is_valide===false)
                                                                <div class="row">
                                                                    <div>
                                                                        <span>Observation : {{ $res->comment_parcours }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="badge bg-label-danger">Validé le {{ $res->date_valide }}</span>
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


    </div>

@endsection

