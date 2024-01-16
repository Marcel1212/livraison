<!doctype html>
<html lang="en">
  <head>
    <title>Laravel 10 Google Pie Chart - Tutsmake.com</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  </head>
  <body>

    <div class="container p-5">
        <h5>Statistique du cahier de plan de formation : {{ $cahier->code_cahier_plan_formation }}</h5>

        <div class="row">
            <div class="col-xl-6">
                <label> <strong> Nombre de plan de formation :</strong> </label> {{ count($etatplanf) }}
            </div>
            <div class="col-xl-6">
                <label> <strong>Nombre d'actions de plan de formation :</strong>  </label> {{ count($etatactionplan) }}
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <label>Nombre d'actions par type de formation </label>
                <div id="piechart" style="width: 900px; height: 500px;"></div>
            </div>
            <div class="col-xl-12">
                <label>Nombre d'actions par but de formation</label>
                <div id="piechart1" style="width: 900px; height: 500px;"></div>
            </div>
            <div class="col-xl-6">
                <label>Nombre d'action par secteur activite</label>
                <div id="piechart2" style="width: 900px; height: 500px;"></div>
            </div>
        </div>

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
            ['Secteur activite', 'Nombre'],

                @php
                foreach($etatsecteuractivite as $d) {
                    echo "['".$d->secteur_activite."', ".$d->nombre."],";
                }
                @endphp
        ]);

          var options = {
            title: 'Secteur activite',
            is3D: true,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

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
            is3D: false,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

          chart.draw(data, options);
        }
    </script>


</body>
</html>
