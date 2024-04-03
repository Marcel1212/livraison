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
                <td width="50%" align="center" valign="middle"><p><strong>Statistique du cahier de projet de formation </strong></p>
                <p> Code du cahier:  <strong>{{ $cahier->code_cahier_plans_projets }}</strong></p></td>
                <td width="25%">Date : {{ $cahier->date_soumis_cahier_plans_projets }}</td>
              </tr>
            </tbody>
        </table> <br/>
        <div align="right"><input type="button" name="Submit" value="Imprimer"
        class="ecran visuel_bouton" onclick="window.print();"/></div>


    </div>



</body>
</html>
