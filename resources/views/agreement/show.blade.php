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
        /* Ajoutez votre propre style ici */
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                }
                .right-align {
                    text-align: right;
                }
                .bold-underline {
                    font-weight: bold;
                    text-decoration: underline;
                }
                .bold-underline1 {
                    font-weight: bold;
                }
                div{
                    margin: 70px;
                }
                .centrer{
                    margin: 70px;
                }
                .centre1{
            text-align: initial;
            margin: 70px;
            font-family: arial;
        }
        .noir{
            text-align: right;
            margin: 70px;
            font-family: arial;
            font-size: 25px;
        }
    </style>
</head>

<body>
<table width="100%" align="center" cellpadding="2" cellspacing="0">
        <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="texte1">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td valign="top">
                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                            <tr>
                                                <td width="16%" valign="top" nowrap="nowrap">
                                                <?php if (isset($logo->logo_logo)){ ?>
                                                    <img
                                                        src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}"
                                                        width="95" height="43"
                                                        alt="{{@$logo->mot_cle}}"/>
                                                <?php } ?>


                                                        <br/>
                                                        {{@$logo->mot_cle}}<br/>
                                                </td>
                                                <td width="42%" align="left" valign="middle">&nbsp;</td>
                                                <td width="42%" align="right" valign="top"><input name="Submit1"
                                                                                                  type="button"
                                                                                                  class="ecran visuel_bouton"
                                                                                                  id="Submit1"
                                                                                                  onclick="self.close();"
                                                                                                  value="Fermer"/>
                                                    &nbsp;
                                                    <input type="button" name="Submit" value="Imprimer"
                                                           class="ecran visuel_bouton" onclick="window.print();"/>
                                                    <BR/><span class="">
                                            <?php echo date('d-m-y'); ?>
                                            </span></td>
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    <table border="0" align="left" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td height="73" valign="middle">
                                                                <table width="100%" border="0" align="left"
                                                                       cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table border="0" align="left"
                                                                                   cellpadding="2" cellspacing="1">
                                                                                <tr>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td align="left" class="entete2">&nbsp;

                                                                                    </td>
                                                                                    <td valign="middle" class="">&nbsp;

                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td align="left" class="">&nbsp;
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                </tr>



                                                                            </table>
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </td>

                                                        </tr>
                                                    </table>

                                            </tr>
                                        </table>
                                        <span class="letitre"><strong><u><center>
                </center>
                </u></strong></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr valign="baseline">
            <td align="center" valign="top" nowrap="nowrap" class="Grand"><strong><u>   </u></strong></td>
        </tr>
        <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="texte1">

                <p class="right-align centrer">Abidjan, 13 décembre 2023</p>
                <h1 class="bold-underline centrer">le secrétaire général</h1>
                <div>
                <p class="right-align">Monsieur le Directeur Général</p>
                <p class="right-align bold-underline1">XXXXXXXXXXXX</p>
                <p class="right-align bold-underline1">XX BP XXX</p>
                <h2 class="right-align bold-underline">ABIDJAN 01</h2>
                </div>
                <p class="centrer"><b>N/Réf.</b>: FDFP/SG-DACD/PME/0019-2023/NKP/LKR</p>
                <h2 class="centrer">Monsieur le Directeur Général,</h2>
                <table class="centre1">
                    <tr>
                        <td>
                J'ai l'honneur de vous informer que la commission permanente du Fonds de
                Développement de la formation Professionnelle (FDFP) a agréé le plan de formation
                2023 de votre entreprise, <br/> au cours de sa réunion du
                <b>12/12/2023</b>. Les conditions d'agrément sont indiquées sur la fiche ci-jointe <br/><br/><br/>
                Vous êtes invités à réaliser toutes les actions de formation agréées et à déposer les
                dossiers de demande de remboussement au plus tard le
                <b>31/07/2024</b>. <br/> Toutefois, ces
                dossiers devront nous être transmis au fur et à mesurede la réalisation des actions.  <br/><br/><br/>
                Votre conseiller en formation reste disponible pour toutes informations
                complémentaire que vous voudriez bien avoir.  <br/><br/><br/>
                Je vous prie d'agréer, Monsieur le Directeur Général l'expression de ma
                considération distinguée. <br/><br/><br/>
                <span class="souligner"><b>P.J.</span> : 1 fiche d'agrément</b>
                </td>
                </tr>
                </table>
                <div class="noir">
                    <p><b>Philippe N'DRI</b></p>
                    <p ><b>P/O Rachel LIABRA</b></p>
                </div>

            </td>
        </tr>

        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>


        <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="texte1">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td valign="top">
                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">

                                            <tr>
                                                <td valign="top">
                                                    <table border="0" align="left" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td height="73" valign="middle">
                                                                <table width="100%" border="0" align="left"
                                                                       cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table border="0" align="left"
                                                                                   cellpadding="2" cellspacing="1">
                                                                                <tr>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td align="left" class="entete2">&nbsp;

                                                                                    </td>
                                                                                    <td valign="middle" class="">&nbsp;

                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td align="left" class="">&nbsp;
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                </tr>



                                                                            </table>
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </td>

                                                        </tr>
                                                    </table>
                                                    <td valign="top">&nbsp;</td>
                                                <td align="right" valign="top">{{\SimpleSoftwareIO\QrCode\Facades\QrCode::size(130)->generate(
                                                    'Code agrement : AGREMENT
                                                    Date : 04/01/2024' )}}</td>
                                                </td>
                                              <td valign="top">&nbsp;</td>
                                                <td align="right" valign="top"></td>
                                            </tr>
                                        </table>
                                        <span class="letitre"><strong><u><center>
                </center>
                </u></strong></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="texte1">

                <div class="col-xl-12">
                    <h1 class="text-muted">Liste des actions de formation à mener</h1>
                    <table style="width:715.6pt;border-collapse:collapse;border:none;">
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
                      <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;'>&nbsp;</p>
                  </div>

            </td>
        </tr>
    </table>
</body>

</html>
