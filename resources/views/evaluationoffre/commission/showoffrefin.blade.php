<?php
use App\Helpers\Menu;
$logo = Menu::get_logo();
@ini_set('max_execution_time',0)
?>

    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link media="all" href="/assets/css/style_etat.css" type="text/css" rel="stylesheet"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        @media print {
            .visuel_bouton {
                display: none;
            }
            @page { size: landscape; }
            @page {
                margin-top: 0.3in !important;
                margin-bottom: 0.3in !important;
            }
        }
        .encadre table,.encadre table th,.encadre table td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body >
<div style="margin-bottom: 25px;" id="">
    <div>
        <div align="right" >
            <input name="Submit1"
                   type="button"
                   class="ecran visuel_bouton"
                   id="Submit1"
                   onclick="self.close();"
                   value="Fermer"/>
            <input type="button" name="Submit" value="Imprimer" class="ecran visuel_bouton" onclick="window.print();" />
        </div>
        <br />
    </div>
</div>
<div class=" content" style="margin-top: 25px">
    <table width="100%" cellspacing="0" cellpadding="0" class="encadre">
        <tbody>
        <tr>
            <td width="50%" style="float: left;margin-top: 2px">
                <?php if (isset($logo->logo_logo)){ ?>
                <img
                    src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}"
                    width="95" height="43"
                    alt="{{@$logo->mot_cle}}"/>
                <?php } ?>
                <br/>
                {{@$logo->mot_cle}}<br/>
            </td>
        </tr>
        </tbody>
    </table>
    @isset($commissionevaluationoffre)
        <h3>NOTATION DES OFFRES FINANCIERES</h3>
        <p><strong>CODE : {{@$commissionevaluationoffre->code_commission_evaluation_offre}} </strong> </p>
    @endisset
    <table border="1" width="100%" cellspacing="0" cellpadding="0" class="encadre" style="margin-top: 13px !important">
        <tbody>
            <tr>
                <td>Rang</td>
                <td>Entreprise</td>
                <td>Budget proposé</td>
                <td>Point / {{@$commissionevaluationoffre->pourcentage_offre_fin_commission_evaluation_offre}}</td>
            </tr>

            <?php
                if(isset($combinedArray)){
                    $data_sorteds = collect($combinedArray)->sortByDesc('note')->toArray();
                }
            ?>
            <?php
                $i=1;
            ?>
            @isset($data_sorteds)
                @foreach(@$data_sorteds as $key=>$data)
                <tr>
                    <td>{{$i++}}</td>
                    <td>
                        @isset($data['entreprise'])
                            {{$data['entreprise']}}
                        @endisset
                    </td>
                    <td>{{number_format($commissionevaluationoffre->montantfinanciere($data['entreprise'])->montant_notation_commission_evaluation_offre_fin, 0, ',', ' ')}}</td>
                    <td>
                        @isset($data['note'])
                            {{$data['note']}}
                        @endisset
                    </td>
                </tr>
            @endforeach
            @endisset
    </tbody>
</table>
</div>
</body>
</html>
