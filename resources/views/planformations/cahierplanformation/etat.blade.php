<!doctype html>
<?php

use App\Helpers\Menu;

$logo = Menu::get_logo();
$imagedashboard = Menu::get_info_image_dashboard();
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
                <td width="50%" align="center" valign="middle"><p><strong>Statistique du cahier de plan de formation </strong></p>
                <p> Code du cahier:  <strong>{{ $cahier->code_cahier_plan_formation }}</strong></p></td>
                <td width="25%">Date : {{ $cahier->date_soumis_cahier_plan_formation }}</td>
              </tr>
            </tbody>
        </table> <br/>
        <div align="right"><input type="button" name="Submit" value="Imprimer"
        class="ecran visuel_bouton" onclick="window.print();"/></div> <br/>
        <table width="100%" border="1" cellpadding="5" cellspacing="0">
            <tbody>
              <tr>
                <td><strong>Nombre de plan de formation </strong></td>
                <td><span class="align-content-start">
                  <label> </label>
                              {{ count($etatplanf) }}</span></td>
                <td><span  > <strong>Nombre d'actions de plan de formation</strong></span></td>
                <td><span  >{{ count($etatactionplan) }} </span></td>
              </tr>
              <tr>
                <td colspan="4" align="center"><label>Nombre d'actions par type de formation </label></td>
              </tr>
              <tr>
                <td colspan="4" align="center">
                  <div id="piechart" style="width: 900px; height: 300px;"></div>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td colspan="4" align="center"><label>Nombre d'actions par but de formation</label></td>
              </tr>
              <tr>
                <td colspan="4" align="center"><span  >

                </span>
                  <div id="piechart1" style="width: 900px; height: 300px;"></div></td>
              </tr>
              <tr>
                <td colspan="4" align="center"><label>Nombre d'action par secteur activite</label></td>
              </tr>
              <tr>
                <td colspan="4" align="center"><span >

                </span>
                  <div id="piechart2" style="width: 900px; height: 300px;"></div></td>
              </tr>
            </tbody>
          </table>
          <h5>&nbsp;</h5>
          <h5>&nbsp; </h5>


    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Type de formation', 'Nombre'],

                @php
                foreach($etattypeformation as $d) {
                    echo "['".$d->type_formation."', ".$d->nombre."],";
                }
                @endphp
        ]);

          var options = {
            title: 'Type de formation',
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
            ['But de formation', 'Nombre'],

                @php
                foreach($etatbutformation as $d) {
                    echo "['".$d->but_formation."', ".$d->nombre."],";
                }
                @endphp
        ]);

          var options = {
            title: 'But de formation',
            is3D: true,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

          chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Secteur activite', 'Nombre'],

                @foreach ($etatsecteuractivite as $category) // On parcourt les catégories
                [ "{{ $category->secteur_activite }}", {{ $category->nombre }} ], // Proportion des produits de la catégorie
                @endforeach
        ]);

          var options = {
            title: 'Secteur activite',
            is3D: true,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

          chart.draw(data, options);
        }
    </script>

</body>
</html>
