<?php
use App\Helpers\Menu;
$logo = Menu::get_logo();
?>

    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Action de plan et fiche agrement A</title>
    <link media="all" href="/assets/css/style_etat.css" type="text/css" rel="stylesheet"/>
    <style>
        /*!* Ajoutez votre propre style ici *!*/
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        @media print {
            .visuel_bouton {
                display: none;
            }
        }

    </style>
    @isset($plan_de_formation)
        @if($plan_de_formation->flag_annulation_plan)
            <style>
            .content {
            position: relative;
            }

            .content:before {
            content: 'Annulé';
            position: fixed;
            inset: 0;
            z-index:-1 !important;
            font-size: 160px;
            font-weight: bold;
            display: grid;
            justify-content: center;
            align-content: center;
            opacity: 0.1;
            transform: rotate(-45deg) scale(1);;
            }
            </style>
        @endif
    @endisset
</head>
<body >
<div style="margin-bottom: 25px;" id="">
    <div>
        <div align="right" >
            <input name="Submit1"
                   type="button"
                   class="ecran visuel_bouton"
                   id="Submit1"
                   onclick="self.close();"
                   value="Fermer"/>
            <input type="button" name="Submit" value="Imprimer" class="ecran visuel_bouton" onclick="window.print();" />
        </div>
        <br />
    </div>
</div>
<div class=" content" style="margin-top: 25px">
    <table width="100%" cellspacing="0" cellpadding="0" class="encadre">
        <tbody>
        <tr>
            <td width="50%" style="float: left;margin-top: 2px">
                <?php if (isset($logo->logo_logo)){ ?>
                <img
                    src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}"
                    width="95" height="43"
                    alt="{{@$logo->mot_cle}}"/>
                <?php } ?>
                <br/>
                {{@$logo->mot_cle}}<br/>
            </td>
        </tr>
        <tr>
            <td width="40%" style="float: right;margin-top: 2px">
                <div style="text-align: center">
                    Abidjan, le 13 décembre 2023
                </div>
                <br/>
            </td>
        </tr>
        <tr>
            <td width="100%" style="float: left;margin-top: 2px">
                <div>
                    <h2 style="text-decoration: underline;font-size: 18px" >LE SECRETAIRE GENERAL</h2>
                </div>
                <br/>
            </td>
        </tr>
        <tr >
            <td width="40%" style="float: right;margin-top: 2px">
                <div style="text-align: center">
                    <p  style="margin: 0px !important;padding: 0px;">Monsieur le Directeur Général</p>
                    <p style="margin: 0px !important;padding: 0px;font-weight: bold">XXXXXXXXXXXX</p>
                    <p  style="margin: 0px !important;padding: 0px;font-weight: bold">XX BP XXX</p>
                    <h2 style="text-decoration: underline;font-size: 18px">ABIDJAN 01</h2>
                </div>

            </td>
        </tr>
        <tr >
            <td width="100%" style="float: left;margin-top: 2px">
                <div>
                    <p class=""><b>N/Réf.</b>: FDFP/SG-DACD/PME/0019-2023/NKP/LKR</p>
                </div>
            </td>
        </tr>

        <tr>
            <td width="100%" style="float: left;margin-top: 2px">
                <h2 class="" style="font-size: 18px">Monsieur le Directeur Général,</h2>
                <p>
                    J'ai l'honneur de vous informer que la commission permanente du Fonds de
                    Développement de la formation Professionnelle (FDFP) a agréé le plan de formation
                    2023 de votre entreprise, au cours de sa réunion du
                    <b>12/12/2023</b>. Les conditions d'agrément sont indiquées sur la fiche ci-jointe
                </p>
                <p>
                Vous êtes invités à réaliser toutes les actions de formation agréées et à déposer les
                dossiers de demande de remboussement au plus tard le
                <b>31/07/2024</b>. Toutefois, ces
                dossiers devront nous être transmis au fur et à mesurede la réalisation des actions.
                </p>
                <p>
                Votre conseiller en formation reste disponible pour toutes informations
                complémentaire que vous voudriez bien avoir.
                </p>
                <p>

                Je vous prie d'agréer, Monsieur le Directeur Général l'expression de ma
                considération distinguée.
                </p>
                <span class="souligner"><b>P.J.</b></span> : 1 fiche d'agrément</b>
            </td>
        </tr>
        <tr>
            <td width="100%" style="float: right;margin-top: 2px">

            </td>
        </tr>
        <tr>
            <td width="40%" style="float: right;margin-top: 2px">
                <p><b>Philippe N'DRI</b></p>
                <p><b>P/O Rachel LIABRA</b></p>
            </td>
        </tr>

        </tbody>
    </table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div style="margin-top: 2px">
    {{\SimpleSoftwareIO\QrCode\Facades\QrCode::size(130)->generate(
                                                    'Code agrement : AGREMENT
                                                    Date : 04/01/2024' )}}
</div>
                <div class="col-xl-12">
                    <h2 class="" style="font-size: 18px">Liste des actions de formation à mener</h2>
                </div>
                    <table>
                        <tbody>
                        <tr>
                            <td rowspan="2" style="width: 56.3pt;border: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>N&deg; ACTION</p>
                            </td>
                            <td rowspan="2" style="width: 118.55pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>INTITULE DE L4ACTION</p>
                            </td>
                            <td colspan="4" style="width: 133.25pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>PERSONNES CONCERNER</p>
                            </td>
                            <td rowspan="2" style="width: 42.45pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>DUREE</p>
                            </td>
                            <td rowspan="2" style="width: 98.55pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>INTERVENANT</p>
                            </td>
                            <td rowspan="2" style="width: 70.05pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>COUT INITIAL</p>
                            </td>
                            <td colspan="3" style="width: 105.6pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>CONTRIBUTION FDFP</p>
                            </td>
                            <td rowspan="2" style="width: 90.85pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>TYPE ACTION</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 31.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>C</p>
                            </td>
                            <td style="width: 31.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>AM</p>
                            </td>
                            <td style="width: 31.65pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>EO</p>
                            </td>
                            <td style="width: 38.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>TOTAL</p>
                            </td>
                            <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>TOTAL ACCODEE</p>
                            </td>
                            <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>UTILISATION DIRECT</p>
                            </td>
                            <td style="width: 35.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>FINAN COMPLEMENTAIRE</p>
                            </td>
                        </tr>
                        <?php $i=000; $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; $total7=0; $total8=0; $total9=0; ?>
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
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>TOTAL</p>
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
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>&nbsp;</p>
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
                                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;line-height:normal;'>&nbsp;</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>


</body>
</html>
