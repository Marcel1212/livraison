<?php
<<<<<<< HEAD
use App\Helpers\Menu;
$logo = Menu::get_logo();
?>
=======
 use App\Helpers\Fonction;
 ?>
>>>>>>> dev

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>AGREMENT D'HABILITATION</title>
    <?php if (isset($logo->mot_cle)) {
        echo @$logo->mot_cle;
    } else {
        echo 'Application de gestion du FDFP';
    } ?>
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
    @isset($plan_de_formation)
        @if ($plan_de_formation->flag_annulation_plan)
            <style>
                .content {
                    position: relative;
                }

                .content:before {
                    content: 'Annulé';
                    position: fixed;
                    inset: 0;
                    z-index: -1 !important;
                    font-size: 160px;
                    font-weight: bold;
                    display: grid;
                    justify-content: center;
                    align-content: center;
                    opacity: 0.1;
                    transform: rotate(-45deg) scale(1);
                    ;
                }
            </style>
        @endif
    @endisset
</head>

<body>
<<<<<<< HEAD
    <div style="margin-bottom: 25px;" id="">
        <div>
            <div align="right">
                <input name="Submit1" type="button" class="ecran visuel_bouton" id="Submit1" onclick="self.close();"
                    value="Fermer" />
                <input type="button" name="Submit" value="Imprimer" class="ecran visuel_bouton"
                    onclick="window.print();" />
            </div>
            <br />
=======
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
>>>>>>> dev
        </div>
    </div>
    {{-- <div class=" content" style="margin-top: 25px">
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
                            <p style="margin: 0px !important;padding: 0px;font-weight: bold">
                                Mr/Mde/Mlle {{ $entreprise->nom_prenom_dirigeant }}</p>
                            <p style="margin: 0px !important;padding: 0px;font-weight: bold">
                                de {{ $entreprise->raison_social_entreprises }} ( {{ $entreprise->sigl_entreprises }})
                            </p>
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
                            J'ai l'honneur de vous informer que votre entrprise a eu l'agrement de l'habilitation
                            demandé sous la responsablilité de Mr/Mlle
                            {{ $demandehabilitation->nom_responsable_demande_habilitation }} le
                            {{ $demandehabilitation->date_soumis_demande_habilitation }} a été validé
                        <div class=""></div>
                        </p>

                        <p>
                            LE FDFP reste disponible pour toutes informations
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
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div style="margin-top: 2px">
            {{ \SimpleSoftwareIO\QrCode\Facades\QrCode::size(130)->generate('Code agrement : AGREMENT HABILITATION ') }}
        </div>


    </div> --}}


    <div class="modal-body">
        <h4 class="modal-title" align="center"> <strong> <u>AGREMENT D'HABILITATION</u></strong></h4>
        <br>
        <p> <br>
        <div class="header" align="right">
            <p>Abidjan, le <?php echo $demandehabilitation->date_valide_demande_habilitation; ?> </p>
        </div>
        <div class="main" align="left">
            <p> <strong><u>LE SECRETAIRE GENERAL </u></strong></p>

            <div align="right">
                <p><strong>A</strong></p>
                <p> <strong>Monsieur le Président<br>
                        <?php echo $entreprise->nom_prenom_dirigeant; ?><br>
                        <?php echo $entreprise->adresse_postal_entreprises; ?><br>
                        <?php echo $entreprise->localisation_geographique_entreprise; ?> </strong></p>
            </div>


            <br>

            <p><strong>N/Réf. : FDFP-SG/D2EQPC/N<sup>o</sup><s>180</s>-2023/NKP/AD/fcd</p> </strong>
            <p><strong>Objet : V/Demande d’habilitation</p> </strong>

            <br>

            <strong>
                <p>Monsieur le Président , </p>
            </strong>
            <p>Par courrier en date du 19 octobre 2023, vous avez bien voulu solliciter
                l’habilitation du Fonds de Développement de la Formation Professionnelle (FDFP) pour
                mener des actions de formation continue auprès des entreprises.</p>

            <p>Par la présente, j’ai l’honneur de vous faire connaître qu’au regard du décret
                <strong>N°2021-278 du 09 juin 2021</strong> portant création, attributions, organisation et
                fonctionnement , <strong> <?php echo $entreprise->raison_social_entreprises . ' (' . $entreprise->sigl_entreprises . ')'; ?> </strong> est autorisé à mener des actions
                de formation continue au profit des entreprises dans les domaines
                ci-après :
            </p>


            <table class="table table-bordered table-striped table-hover table-sm" id=""
                style="margin-top: 13px !important">
                <thead>
                    <tr>

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
            <br>

            <p>Je vous prie d’agréer, <strong> Monsieur le Président </strong>, l’expression de ma considération
                distinguée.</p>

        </div>
        </p>
        <br>
        <br>


</body>

</html>
