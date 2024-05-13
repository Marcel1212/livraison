<?php
use App\Helpers\Menu;
$logo = Menu::get_logo();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>AGREMENT{{$agreement->code_projet_etude}}</title>
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
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        .tableagrement table,.tableagrement table th,.tableagrement table td {
            border: 1px solid black;
            border-collapse: collapse;
        }

    </style>

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
                            <div style="text-align: center">
                                <p  style="margin: 0px !important;padding: 0px;">Monsieur le Directeur Général</p>
                                <p style="margin: 0px !important;padding: 0px;font-weight: bold">{{ $infosentreprise->nom_prenom_dirigeant }}</p>
                                <p  style="margin: 0px !important;padding: 0px;font-weight: bold">{{ $infosentreprise->adresse_postal_entreprises }}</p>
                                <h2 style="text-decoration: underline;font-size: 18px">ABIDJAN 01</h2>
                            </div>
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
                            J'ai l'honneur de vous informer que le Fonds de
                            Développement de la formation Professionnelle (FDFP) a agréé le projet d'étude
                             votre entreprise, au cours de sa réunion du
                            <b>
                                {{ date('d/m/Y h:i:s',strtotime(@$agreement->date_fiche_agrement ))}}
                            </b>. Les conditions d'agrément sont indiquées sur la fiche ci-jointe
                        </p>

                        <p>
                            Votre chargé d'étude reste disponible pour toutes informations
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
    </div>
    <div style="margin-top: 2px">

    </div>
    <div  class="tableagrement">
    <table>
        <tbody>
            <tr>
                <td><span style="font-weight: bold;">Titre du projet</span></td>
                <td><span style="font-weight: bold">{{@$agreement->titre_projet_instruction}}</span></td>
                <td><span style="font-weight: bold">
                    @isset($agreement->op_raison_social_entreprises)
                            {!!\SimpleSoftwareIO\QrCode\Facades\QrCode::size(75)->generate("Titre du projet: ".$agreement->titre_projet_instruction."\n\nCode du projet : ".$agreement->code_projet_etude
                            ."\nPromoteur : ".$agreement->raison_social_entreprises."\nOpérateur : ".$agreement->op_raison_social_entreprises
                            ."\nDate prévisionnnelle de démarrage : ".date('d/m/Y',strtotime(@$agreement->date_previsionnelle_demarrage_projet))
                            ."\nLigne Budgetaire de financement : Taxe de formation professionnelle continue"
                             ."\nFinancement sollicité FDFP : ".number_format(@$agreement->montant_projet_instruction, 0, ',', ' ')
                            )  !!}
                   @else
                           {!!\SimpleSoftwareIO\QrCode\Facades\QrCode::size(75)->generate("Titre du projet: ".$agreement->titre_projet_instruction."\n\nCode du projet : ".$agreement->code_projet_etude
                           ."\nPromoteur : ".$agreement->raison_social_entreprises."\nOpérateur : EN APPEL D'OFFRE"
                           ."\nDate prévisionnnelle de démarrage : ".date('d/m/Y',strtotime(@$agreement->date_previsionnelle_demarrage_projet))
                           ."\nLigne Budgetaire de financement : Taxe de formation professionnelle continue"
                           ."\nFinancement sollicité FDFP : ".number_format(@$agreement->montant_projet_instruction, 0, ',', ' ')
                           ) !!}
                    @endisset


                    </span></td>
            </tr>
            <tr>
                <td><span style="font-weight: bold">Code du projet</span></td>
                <td colspan="2"><span>{{@$agreement->code_projet_etude}}</span></td>
            </tr>
            <tr>
                <td><span style="font-weight: bold">Lieu de réalisation</span></td>
                <td colspan="2"><span>{{@$agreement->lieu_realisation_projet_instruction}}</span></td>
            </tr>
            <tr>
                <td><span style="font-weight: bold">Promoteur</span></td>
                <td colspan="2"><span>{{@$agreement->raison_social_entreprises}}</span></td>
            </tr>
            <tr>
                <td><span style="font-weight: bold">Opérateur </span></td>
                <td colspan="2">
                    @isset($agreement->op_raison_social_entreprises)
                        <span>{{@$agreement->op_raison_social_entreprises}}</span>
                    @else
                        <span>EN APPEL D'OFFRE</span>
                    @endisset
                </td>
            </tr>
            <tr>
                <td><span style="font-weight: bold">Objectif général </span></td>
                <td colspan="2">{!!@$agreement->objectif_general_instruction!!}</td>
            </tr>
            <tr>
                <td><span style="font-weight: bold">Objectifs spécifiques </span></td>
                <td colspan="2">{!!@$agreement->objectif_specifique_instruction!!}</td>
            </tr>
            <tr>
                <td><span style="font-weight: bold">Champs de l’étude</span></td>
                <td colspan="2">{!!@$agreement->champ_etude_instruction!!}</td>
            </tr>
            <tr>
                <td><span style="font-weight: bold">Méthodologie</span></td>
                <td colspan="2">{!!@$agreement->methodologie_instruction!!}</td>
            </tr>

            <tr>
                <td><span style="font-weight: bold">Date prévisionnelle de démarrage</span></td>
                <td colspan="2">{{ date('d/m/Y',strtotime(@$agreement->date_previsionnelle_demarrage_projet ))}}</td>

            </tr>

            <tr>
                <td><span style="font-weight: bold">Durée et étalement</span></td>
                <td colspan="2"></td>
            </tr>

            <tr>
                <td><span style="font-weight: bold">Ligne budgétaire de financement FDFP</span></td>
                <td colspan="2">Taxe de formation professionnelle continue</td>
            </tr>

            <tr>
                <td><span style="font-weight: bold">Financement sollicité FDFP</span></td>
                <td colspan="2"><span style="font-weight: bold">{{number_format(@$agreement->montant_projet_instruction, 0, ',', ' ')}} FCFA TTC</span></td>
            </tr>

            <tr>
                <td><span style="font-weight: bold">Avis de la Commission Technique</span></td>
                <td colspan="2">
                    <span>
                        Cette étude permettra au FDFP d’optimiser ses actions auprès des TPE, en étant efficient dans le financement de formations adaptées aux besoins des entreprises. Aussi, pour les Branches professionnelles, elle permettra de contribuer au développement des compétences de leurs membres pour renforcer leur secteur respectif et voire participer à une économie plus forte.
                        <br><br>
                        <span style="font-weight: bold">Le Comité Technique émet ainsi un avis favorable pour l’exécution de l’étude</span>.
                    </span>
                </td>
            </tr>
        </tbody>
    </table></div>
</body>
</html>
