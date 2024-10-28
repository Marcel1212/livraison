<?php
use App\Helpers\Menu;
use Carbon\Carbon;
use App\Helpers\ListeDemandeHabilitationSoumis;
$nbresollicite = ListeDemandeHabilitationSoumis::get_vue_nombre_de_domaine_sollicite($demandehabilitation->id_demande_habilitation);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document d'Habilitation</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: right;
        }
        .section {
            margin-bottom: 0px;
        }
        .list-item::before {
            content: "❖ ";
            color: #000;
            margin-right: 1px;
        }
        .signature {
            text-align: right;
            margin-top: 0px;
        }
        .footer {
            margin-top: 0px;
            text-align: center;
        }
    </style>
</head>
<body class="container-fluid px-0">

    <div class="row">
        <div class="col-6"></div>
        <div class="col-6">
            <p class="text-end">Abidjan, le {{ Menu::dateEnFrancais(@$demandehabilitation->date_agrement_demande_habilitation) }}</p>
        </div>
    </div>

    <div class="section">
        <strong>LE SECRETAIRE GENERAL</strong>
    </div>

    <div class="row mb-4">
        <div class="col-6"></div>
        <div class="col-6">

            <p>
                A<br>
                Madame/Monsieur le Directeur<br>
                <strong>{{ $demandehabilitation->entreprise->raison_social_entreprises }} ({{ $demandehabilitation->entreprise->sigl_entreprises }})</strong><br>
                {{ $demandehabilitation->entreprise->adresse_postal_entreprises }}<br>

            </p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <p><strong>N/Réf:</strong> {{ @$demandehabilitation->reference_agrement }}</p>
            <p><strong>Objet :</strong> Habilitation</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <p><strong>Madame/Monsieur le Directeur,</strong></p>
            <p>
                J’ai l’honneur de vous informer que la Commission Permanente du Fonds de Développement de la Formation
                Professionnelle (FDFP) a examiné votre demande d’habilitation au cours de sa réunion du <strong>{{ Menu::dateEnFrancais(@$demandehabilitation->date_agrement_demande_habilitation) }}</strong>,
                et donné un avis favorable pour le(s) domaine(s) suivant(s) :
            </p>

            <ul class="list-unstyled">
                @foreach ($nbresollicite as $domaine)
                    <li class="list-item">{{ $domaine->libelle_domaine_formation }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <p>
                Cette habilitation vous autorise à réaliser toute action de formation ou toute étude financée par le FDFP.
                Elle est accordée pour une période allant du <strong>{{ Menu::dateEnFrancais(@$demandehabilitation->date_debut_validite) }}</strong> au <strong>{{ Menu::dateEnFrancais(@$demandehabilitation->date_fin_validite) }}</strong> et peut être suspendue
                ou annulée si les conditions de son octroi ne sont plus réunies.
            </p>
            <p>
                Votre dossier de renouvellement de l’habilitation devra être soumis au FDFP au plus tard le <strong><?php
                    $dateFinValidite = $demandehabilitation->date_fin_validite;
                    $date = Carbon::parse($dateFinValidite);
                    $datededuire = $date->subMonths(4);
                    $dateres = $datededuire->setDate($date->year, 9, 30);
                     ?>
                    {{  Menu::dateEnFrancais(@$dateres->format('Y-m-d')) }}</strong>.
            </p>
            <p>Veuillez agréer, Madame/Monsieur le Directeur, mes salutations distinguées.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12 signature">
            <p>Le Secrétaire Général</p>
            <p><strong>Philippe N'DRI</strong></p>
            {{\SimpleSoftwareIO\QrCode\Facades\QrCode::size(130)->generate(
                'Code agrement : '.@$demandehabilitation->reference_agrement.'
                Date debut : '.Menu::dateEnFrancais(@$demandehabilitation->date_debut_validite).'
                Date de fin : '.Menu::dateEnFrancais(@$demandehabilitation->date_fin_validite).'
                Periode de renouvellement : '.Menu::dateEnFrancais(@$dateres->format('Y-m-d')))}}
        </div>
    </div>

    <div class="row">
        <div class="col-12 footer">
            <p><strong>SIEGE ABIDJAN</strong></p>
            <p>20 B.P. 1068 Abidjan 20 - Maison de la Formation, Bd Giscard d'Estaing</p>
        </div>
    </div>

    <!-- Inclusion de Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
