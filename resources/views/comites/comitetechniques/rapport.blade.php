<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilan et Décisions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h1>1. Bilan</h1>
    <table>
        <tr>
            <th>Point des avis favorables</th>
            <th>Point des avis défavorables</th>
        </tr>
        <tr>
            <td>{{ $nombre_de_demande_valide }}/{{ $nombre_de_demande }} soit <?php $res = round(($nombre_de_demande_valide*100)/$nombre_de_demande, 2); ?>  {{ $res }} %</td>
            <td>{{ $nombre_de_demande_rejeter }}/{{ $nombre_de_demande }} soit <?php $res1 = round(($nombre_de_demande_rejeter*100)/$nombre_de_demande, 2); ?>  {{ $res1 }} %</td>
        </tr>
    </table>

    <h2>2. Décisions</h2>
    <ul>
        <li>&#10003; Les {{ $nombre_de_demande_valide }} demandes  avec des avis favorables du comité technique seront proposées à la prochaine Commission Permanente.</li>
        <li>&#10003; Les {{ $nombre_de_demande_rejeter }} demandes  avec des avis défavorables du comité technique seront contactés par mail pour une mise en conformité.</li>
    </ul>

</body>
</html>
