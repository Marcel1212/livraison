<!doctype html>
<?php

use App\Helpers\Menu;
use Carbon\Carbon;

$logo = Menu::get_logo();
$imagedashboard = Menu::get_info_image_dashboard();
$datedays = Carbon::now();
$datefin = Menu::dateEnFrancais(@$datefin);
$dateday = Menu::dateEnFrancais(@$datedays);
?>
<html lang="en">
  <head>
    <title><?php if (isset($logo->mot_cle)) {
        echo @$logo->mot_cle;
    } else {
        echo 'Application de gestion du FDFP';
    } ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        @media print {
            .visuel_bouton {
                display: none;
            }

            @page {
                margin-top: 0.3in !important;
                margin-bottom: 0.3in !important;
            }
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .section {
            margin: 20px 0;
        }
        .highlight {
            color: red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .chart {
            text-align: center;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
  </head>
  <body>

    <div class="container p-5">
        <table width="100%" border="1" cellpadding="5" cellspacing="0">
            <tbody>
              <tr>
                <td width="25%">
                    <?php if (isset($logo->logo_logo)){ ?>
                        <img alt="Logo" src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}" height="35"
                         style="margin:5px; padding: 5px"/>
                    <?php } ?>
                </td>
                <td width="50%" align="center" valign="middle"><p><strong>Cahier d'Habilitation 2024 </strong></p>
                <p> Code du cahier:  <strong>{{ $cahier->code_cahier_plans_projets }}</strong></p></td>
                <td width="25%">Date : {{ $cahier->date_soumis_cahier_plans_projets }}</td>
              </tr>
            </tbody>
        </table> <br/>
        <div align="right"><input type="button" name="Submit" value="Imprimer"
        class="ecran visuel_bouton" onclick="window.print();"/></div>

        <h2>COMMENTAIRE DU CAHIER D’HABILITATION </h2>

        <div class="section">
            <p>Le département chargé de l’habilitation, du contrôle liquidation et du suivi-évaluation soumet à l’agrément de la Commission Permanente <span class="highlight">{{ count($contenantCahiers) }}</span> demandes d’habilitation de cabinets privés de formation.</p>

            <p>Ces cabinets de formation bénéficieront d’une habilitation couvrant la période allant du <span class="highlight">{{ $dateday }}</span> au <span class="highlight">{{ $datefin }}</span>.</p>

            <p>Les principales données enregistrées pour cette session sont les suivantes :</p>
        </div>

        <div class="section">
            <h3>A. CLASSIFICATION DES DOMAINES</h3>
            <p>{{ $texte }}.</p>

            <table>
                <thead>
                    <tr>
                        <th>Classification des Domaines</th>
                        <th>Effectif</th>
                        <th>Pourcentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totdomaine = 0;
                        $totpourcentage = 0;
                    ?>
                    @foreach($classifications as $classification)
                        <?php
                            $totdomaine += $classification->domaine_count;
                            $totpourcentage += $classification->pourcentage;
                         ?>
                        <tr>
                            <td>{{ $classification->libelle_domaine_formation }}</td>
                            <td>{{ $classification->domaine_count }}</td>
                            <td>{{ round($classification->pourcentage, 1) }} %</td>
                        </tr>
                    @endforeach

                    {{-- <tr>
                        <td>Domaines Technico Professionnels de la Production</td>
                        <td>30</td>
                        <td>24 %</td>
                    </tr>
                    <tr>
                        <td>Domaines Technico Professionnels des Services</td>
                        <td>86</td>
                        <td>67 %</td>
                    </tr>
                    <tr>
                        <td>Domaines du Développement Personnel</td>
                        <td>0</td>
                        <td>0 %</td>
                    </tr> --}}
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>{{ $totdomaine }}</strong></td>
                        <td><strong>{{ $totpourcentage }} %</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section chart">
            <h3>Répartition par Domaines</h3>
            <div id="piechart" style="width: 900px; height: 300px;"></div>
        </div>


        <div class="section">
            <h3>B. REPARTITION PAR ZONE GEOGRAPHIQUE (ABIDJAN/TERRITOIRE)</h3>
            <p>Sur les <span class="highlight">{{ count($contenantCahiers) }}</span> opérateurs de formation sollicitant l’habilitation, <span class="highlight">31</span> sont situés dans le Grand-Abidjan et <span class="highlight">05</span> en territoire.</p>

            <table>
                <thead>
                    <tr>
                        <th>Zone Géographique</th>
                        <th>Effectif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $tot=0; ?>
                    @foreach($vue_zones as $vue_zone)
                    <?php $tot +=$vue_zone->total_localite; ?>
                        <tr>
                            <td>{{ $vue_zone->libelle_departement_localite }}</td>
                            <td>{{ $vue_zone->total_localite }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>{{ $tot }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section chart">
            <h3>Répartition Géographique</h3>
            <div id="piechart2" style="width: 900px; height: 300px;"></div>

        </div>


    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Domaine', 'Effectif'],

                @php
                foreach($classifications as $d) {
                    echo "['".$d->libelle_domaine_formation."', ".$d->domaine_count."],";
                }
                @endphp
        ]);

          var options = {
            title: 'REPARTITION PAR DOMAINES',
            is3D: true,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart'));

          chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Zone geographique', 'Effectif'],

                @php
                foreach($vue_zones as $d) {
                    echo "['".$d->libelle_departement_localite."', ".$d->total_localite."],";
                }
                @endphp
        ]);

          var options = {
            title: 'Répartition Géographique',
            is3D: true,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

          chart.draw(data, options);
        }
    </script>

</body>
</html>
