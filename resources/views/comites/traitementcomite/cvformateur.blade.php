<?php
 use App\Helpers\Fonction;
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Formateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h1, h2, h3 {
            color: #333;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
        }
        .experience, .formation {
            margin-bottom: 15px;
        }
        .competences, .langues {
            list-style-type: none;
            padding: 0;
        }
        .competences li, .langues li {
            background-color: #ecf0f1;
            padding: 10px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Informations du formateur -->
        <h1>{{ $formateur->nom_formateurs }} {{ $formateur->prenom_formateurs }}</h1>
        <p><strong>Email :</strong> {{ $formateur->email_formateurs }}</p>
        <p><strong>Téléphone :</strong> {{ $formateur->contact_formateurs }}</p>

        <!-- Qualifications principales -->
        <div class="section">
            <h2 class="section-title">Qualification Principale</h2>
            <p> {{ $qualification->principale_qualification_libelle }}</p>
        </div>

        <!-- Formations -->
        <div class="section">
            <h2 class="section-title">Formations</h2>
            @foreach($formations as $formation)
                <div class="formation">
                    <h3>Etabillssement : {{ $formation->ecole_formation_educ }} - Diplome obtenu : {{ $formation->diplome_formation_educ }}</h3>
                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($formation->date_de_debut_formations_educ)->format('d/m/Y') }} - {{ $formation->date_de_fin_formations_educ ? \Carbon\Carbon::parse($formation->date_fin)->format('d/m/Y') : 'En cours' }}</p>
                    <p>{{ $formation->description_formations_educ }}</p>
                </div>
            @endforeach
        </div>

        <!-- Expériences professionnelles -->
        <div class="section">
            <h2 class="section-title">Expériences professionnelles</h2>
            @foreach($experiences as $experience)
                <div class="experience">
                    <h3>{{ $experience->intitule_de_poste }} - {{ $experience->nom_entreprise }}</h3>
                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($experience->date_de_debut)->format('d/m/Y') }} - {{ $experience->date_de_fin ? \Carbon\Carbon::parse($experience->date_de_fin)->format('d/m/Y') : 'Présent' }}</p>
                    <p><strong>Durée :</strong>
                        <?php $res = Fonction::calculerDureeExperience($experience->date_de_debut,@$experience->date_de_fin);?>
                        @if ($res->y > 0)
                            {{ $res->y }} ans
                        @endif
                        @if ($res->m > 0)
                            {{ $res->m }} mois
                        @endif
                    </p>
                    <p>{{ $experience->description_experience }}</p>
                </div>
            @endforeach
        </div>

        <!-- Compétences -->
        <div class="section">
            <h2 class="section-title">Compétences</h2>
            <ul class="competences">
                @foreach($competences as $competence)
                    <li>{{ $competence->competences_libelle }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Langues -->
        <div class="section">
            <h2 class="section-title">Langues </h2>
            <ul class="langues">
                @foreach($languesformateurs as $langue)
                    <li>{{ $langue->langues->libelle_langues }} - Aptitude : {{ $langue->aptitude->libelle_aptitude }} - Mention : {{ $langue->mention->libelle_mention }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>
