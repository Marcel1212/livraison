<?php
use App\Helpers\Menu;
$logo = Menu::get_logo();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>AGREMENT D'HABILITATION</title>
    <link media="all" href="/assets/css/style_etat.css" type="text/css" rel="stylesheet" />
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

            @page {
                margin-top: 0.3in !important;
                margin-bottom: 0.3in !important;
            }
        }

        @media print {
            .visuel_bouton {
                display: none;
            }

            @page {
                margin-top: 0.3in !important;
                margin-bottom: 0.3in !important;
            }
        }
    </style>
    @isset($plan_de_formation)
        @if ($plan_de_formation->flag_annulation_plan)
            <style>
                .content {
                    position: relative;
                }

                .content:before {
                    content: 'Annulé';
                    position: fixed;
                    inset: 0;
                    z-index: -1 !important;
                    font-size: 160px;
                    font-weight: bold;
                    display: grid;
                    justify-content: center;
                    align-content: center;
                    opacity: 0.1;
                    transform: rotate(-45deg) scale(1);
                    ;
                }
            </style>
        @endif
    @endisset
</head>

<body>
    <div style="margin-bottom: 25px;" id="">
        <div>
            <div align="right">
                <input name="Submit1" type="button" class="ecran visuel_bouton" id="Submit1" onclick="self.close();"
                    value="Fermer" />
                <input type="button" name="Submit" value="Imprimer" class="ecran visuel_bouton"
                    onclick="window.print();" />
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
                        <img src="{{ asset('/frontend/logo/' . @$logo->logo_logo) }}" width="95" height="43"
                            alt="{{ @$logo->mot_cle }}" />
                        <?php } ?>
                        <br />
                        {{ @$logo->mot_cle }}<br />
                    </td>
                </tr>
                <tr>
                    <td width="40%" style="float: right;margin-top: 2px">
                        <div style="text-align: center">
                            Abidjan, le 13 décembre 2023
                        </div>
                        <br />
                    </td>
                </tr>
                <tr>
                    <td width="100%" style="float: left;margin-top: 2px">
                        <div>
                            <h2 style="text-decoration: underline;font-size: 18px">LE SECRETAIRE GENERAL</h2>
                        </div>
                        <br />
                    </td>
                </tr>
                <tr>
                    <td width="40%" style="float: right;margin-top: 2px">
                        <div style="text-align: center">
                            <p style="margin: 0px !important;padding: 0px;">Monsieur le Directeur Général</p>
                            <p style="margin: 0px !important;padding: 0px;font-weight: bold">
                                Mr/Mde/Mlle {{ $entreprise->nom_prenom_dirigeant }}</p>
                            <p style="margin: 0px !important;padding: 0px;font-weight: bold">
                                de {{ $entreprise->raison_social_entreprises }} ( {{ $entreprise->sigl_entreprises }})
                            </p>
                            <h2 style="text-decoration: underline;font-size: 18px">ABIDJAN 01</h2>
                        </div>

                    </td>
                </tr>
                <tr>
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
                            J'ai l'honneur de vous informer que votre entrprise a eu l'agrement de l'habilitation
                            demandé sous la responsablilité de Mr/Mlle
                            {{ $demandehabilitation->nom_responsable_demande_habilitation }} le
                            {{ $demandehabilitation->date_soumis_demande_habilitation }} a été validé
                        <div class=""></div>
                        </p>

                        <p>
                            LE FDFP reste disponible pour toutes informations
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
        <br>
        <br>
        <div style="margin-top: 2px">
            {{ \SimpleSoftwareIO\QrCode\Facades\QrCode::size(130)->generate('Code agrement : AGREMENT HABILITATION ') }}
        </div>


    </div>


</body>

</html>
