<?php
use App\Helpers\ListeDemandeHabilitationSoumis;
use App\Helpers\Fonction;
$nbresollicite = ListeDemandeHabilitationSoumis::get_vue_nombre_de_domaine_sollicite($demandehabilitation->id_demande_habilitation);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $infoentreprise->raison_social_entreprises }} ({{ $infoentreprise->sigl_entreprises }}) Fiche d'analyse</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header, .section {
            background-color: #e6e6e6;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>{{ $infoentreprise->raison_social_entreprises }} ({{ $infoentreprise->sigl_entreprises }})</h2>

<table>
    <tr>
        <td colspan="2" class="header">NOM DU CABINET:</td>
        <td colspan="4">{{ $infoentreprise->raison_social_entreprises }} ({{ $infoentreprise->sigl_entreprises }})</td>
    </tr>
    <tr>
        <td class="header">DATE DE RECEPTION:</td>
        <td>{{ $demandehabilitation->date_reception_demande_habilitation }}</td>
        <td class="header">DATE DE VISITE:</td>
        <td>{{ $visite->date_visite }}</td>
        <td class="header">DATE C. TECHNIQUE:</td>
        <td></td>
    </tr>
    <tr>
        <td class="header">PERSONNE AYANT VISITE LE CABINET:</td>
        <td colspan="5">{{ $visite->userchargerhabilitationvisite->name }} {{ $visite->userchargerhabilitationvisite->prenom_users }}</td>
    </tr>
    <tr>
        <td class="header">NOM DU RESPONSABLE:</td>
        <td colspan="5">{{ $demandehabilitation->nom_responsable_demande_habilitation }}</td>
    </tr>
    <tr>
        <td class="header">DATE DE CREATION:</td>
        <td>29 décembre 2023</td>
        <td class="header">N° DU REGISTRE DU COMMERCE:</td>
        <td colspan="3">{{ $infoentreprise->rccm_entreprises }}</td>
    </tr>
    <tr>
        <td class="header">N° DU COMPTE CONTRIBUABLE:</td>
        <td colspan="5">{{ $infoentreprise->ncc_entreprises }}</td>
    </tr>
    <tr>
        <td class="header">STATUT:</td>
        <td>{{ $infoentreprise->formeJuridique->libelle_forme_juridique }}</td>
        <td class="header">LOCALISATION ET BOITE POSTALE:</td>
        <td colspan="3">{{ $infoentreprise->repere_acces_entreprises }}</td>
    </tr>
    <tr>
        <td class="header">CONTACT:</td>
        <td colspan="5">{{ $infoentreprise->tel_entreprises }}, {{ $infoentreprise->email_entreprises }}</td>
    </tr>
    <tr>
        <td colspan="6" class="header section">DOMAINES D'INTERVENTION</td>
    </tr>
    <tr>
        @foreach ($nbresollicite as $domaine)
            <td colspan="3">{{ $loop->iteration }}. {{ $domaine->libelle_domaine_formation }}</td>
        @endforeach

    </tr>
    <tr>
        <td colspan="6" class="header section">FORMATEURS</td>
    </tr>
    <tr>
        @foreach ($formateurs as $formateur)
            <td colspan="3">{{ $formateur->nom_formateurs }} {{ $formateur->nom_formateurs }}</td>
        @endforeach
    </tr>
    <tr>
        @foreach ($formateurs as $formateur)
            <td colspan="3">{{ $formateur->fonction_formateurs }} / {{ Fonction::calculerAnneesExperience($formateur->id_formateurs) }} ans d’expérience</td>
        @endforeach

    </tr>
    <tr>
        <td colspan="6" class="header section">SITUATION DU DOSSIER</td>
    </tr>
    <tr>
        <td>Registre de commerce</td>
        <td>OUI</td>
        <td>Mise à jour ITS</td>
        <td>OUI</td>
        <td>Mise à jour CNPS</td>
        <td>OUI</td>
    </tr>
    <tr>
        <td>Relevé identité bancaire</td>
        <td>OUI</td>
        <td>Matériels pédagogiques</td>
        <td>OUI</td>
        <td>Salle de formation</td>
        <td>OUI</td>
    </tr>
    <tr>
        <td>CV des formateurs</td>
        <td>OUI</td>
        <td>Lettres d'engagement</td>
        <td>OUI</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="6" class="header section">OBSERVATIONS</td>
    </tr>
    <tr>
        <td colspan="6">
            <b>Etat des locaux:</b> {{  @$rapport->etat_locaux_rapport }}
            <br><br>
            <b>Equipements:</b> {{  @$rapport->equipement_rapport }}
            <br><br>
            <b>Salubrité/Sécurité:</b> {{  @$rapport->salubrite_rapport }}
            <br><br>
            <b>Suite équipements:</b>{{  @$rapport->contenu }}
        </td>
    </tr>
    {{-- <tr>
        <td colspan="6" class="header">AVIS DE LA COMMISSION TECHNIQUE:</td>
    </tr>
    <tr>
        <td colspan="6">Le cabinet AAV est proposé à l'habilitation dans le(s) domaine(s) de formation identifié(s) ci-dessus.</td>
    </tr> --}}
</table>

</body>
</html>
