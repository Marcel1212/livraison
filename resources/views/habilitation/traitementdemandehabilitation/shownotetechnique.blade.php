<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Note Technique</title>
</head>
<style>
    .header,
    .footer {
        text-align: right;
    }

    .main {
        text-align: left;
    }

    .subject {
        text-align: center;
        font-weight: bold;
    }

    .signature {
        text-align: right;
        margin-top: 50px;
    }

    ul {
        list-style-type: none;
        padding-left: 0;
    }

    .observation {
        width: 90%;
        margin: 10px auto;
        border: 1px solid #000;
        height: 60px;
    }

    .signaturetable {
        border-top: 1px solid #000;
        height: 40px;
        margin-top: 10px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        border: 1px solid black;
        padding: 10px;
        text-align: center;
    }
</style>

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
    <div class="modal-body">

        <h6 class="modal-title" align="center"> <strong>NOTE TECHNIQUE</strong></h6>
        <br>
        <p> <br>

        <div class="header">
            <p>Abidjan, le 27 octobre 2023</p>
        </div>

        <div class="main">
            <p><strong>Direction des Etudes, de l’Evaluation,</strong><br>
                <strong>de la Qualité, de la Prospective et de la Communication</strong><br>
                --------------<br>
                <strong>Département Habilitation, Contrôle-Liquidation et du Suivi-Evaluation</strong>
            </p>

            <br><br>

            <p class="subject">NOTE TECHNIQUE</p>

            <p><strong>Objet :</strong> Demande d’habilitation <?php echo $entreprise->raison_social_entreprises . ' (' . $entreprise->sigl_entreprises . ')'; ?> </p>

            <p>Le Département chargé de l’Habilitation, du Contrôle-Liquidation et du Suivi-Evaluation a
                reçu la demande d’habilitation du <strong> <?php echo $entreprise->raison_social_entreprises . ' (' . $entreprise->sigl_entreprises . ')'; ?> </strong>.</p>

            <p>Les établissements publics n’étant pas assujetti à la procédure d’habilitation, <strong>
                    nous
                    sollicitons par la présente note, votre accord pour son enregistrement dans la base
                    de
                    données du FDFP </strong> comme organisme public de formation autorisé à mener des
                actions de
                formation continue au profit des entreprises dans les domaines de compétences conférés à
                l’Université de San Pedro par son décret de création.</p>
            <br>
            <p class="signature">Le Chef de Département</p>

            <br>
            <table class="table">
                <tr>
                    <th>AVIS DE LA DIRECTRICE</th>
                    <th>DECISION DU SECRETAIRE GENERAL</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>



            <h5 align="center"> <strong> DOMAINES D'INTERVENTIONS</strong></h5>

            <table class="table table-bordered table-striped table-hover table-sm" id=""
                style="margin-top: 13px !important">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Finalité </th>
                        <th>Public </th>
                        <th>Domaine de formation </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>

                    @foreach ($domaineDemandeHabilitations as $key => $domaineDemandeHabilitation)
                        <?php $i += 1; ?>
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation }}
                            </td>
                            <td>{{ @$domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }}
                            </td>
                            <td>{{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>



            {{-- <table class="table">
                                    <tr>
                                        <th>AVIS DE LA DIRECTRICE</th>
                                        <th>DECISION DU SECRETAIRE GENERAL</th>
                                    </tr>
                                    <tr>
                                        <td style="height: 100px;"></td>
                                        <td></td>
                                    </tr>
                                </table> --}}

            {{-- <p>PJ : Domaines de formation du CFC-USP</p> --}}

        </div>
        </p>
    </div>

</body>

</html>
