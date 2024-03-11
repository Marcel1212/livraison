<?php
use App\Helpers\Menu;
$logo = Menu::get_logo();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Action de plan et fiche agrement A</title>
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
                            <p style="margin: 0px !important;padding: 0px;">Monsieur le Directeur Général</p>
                            <p style="margin: 0px !important;padding: 0px;font-weight: bold">XXXXXXXXXXXX</p>
                            <p style="margin: 0px !important;padding: 0px;font-weight: bold">XX BP XXX</p>
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
                            J'ai l'honneur de vous informer que le Fonds de
                            Développement de la formation Professionnelle (FDFP) a agréé le projet d'étude
                             votre entreprise, au cours de sa réunion du
                            <b>
                                {{@$agreement->date_fiche_agrement}}
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

    <div class="col-xl-12">
        <h1 class="" style="font-size: 18px">RÉSUMÉ DU PROJET</h1>
    </div>
    <div class="col-xl-12">
        <h3>Titre du projet: {{@$agreement->titre_projet_instruction}}</h3>
        <p class="text-danger" style="color:red; font-weight: bold">Montant Alloué au projet : {{ number_format(@$projet_etude->montant_projet_instruction, 0, ',', ' ') }} XOF</p>
    </div>

    <div class="col-xl-12">
        <h4>1. Contexte ou Problèmes constatés </h4>
        <p>
            {!!@$agreement->contexte_probleme_instruction!!}
        </p>
    </div>

    <div class="col-xl-12">
        <h4>2. Objectif général </h4>
        <p>
            {!!@$agreement->objectif_general_instruction!!}
        </p>
    </div>

    <div class="col-xl-12">
        <h4>3. Objectif spécific </h4>
        <p>
            {!! @$agreement->objectif_specifique_instruction!!}
        </p>
    </div>

    <div class="col-xl-12">
        <h4>4. Résultat attendu </h4>
        <p>
            {!!@$agreement->resultat_attendus_instruction!!}
        </p>
    </div>

    <div class="col-xl-12">
        <h4>5. Champ de l'étude </h4>
        <p>
            {!!@$agreement->champ_etude_instruction!!}
        </p>
    </div>

    <div class="col-xl-12">
        <h4>6. Cible </h4>
        <p>
            {!!@$agreement->cible_instruction!!}
        </p>
    </div>

    <div class="col-xl-12">
        <h4>7. Méthodologie </h4>
        <p>
            {!!@$agreement->methodologie_instruction!!}
        </p>
    </div>
</body>
</html>
