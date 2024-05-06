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
                <td>Point /{{@$commissionevaluationoffre->pourcentage_offre_fin_commission_evaluation_offre}}</td>

                @foreach(@$classement_offre_techs as $key=>$classement_offre_tech)
                    @if(round($classement_offre_tech->note,2)>$commissionevaluationoffre->note_eliminatoire_offre_tech_commission_evaluation_offre)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$classement_offre_tech->entreprise}}</td>
                            <td>{{number_format($commissionevaluationoffre->montantfinanciere($classement_offre_tech->entreprise)->montant_notation_commission_evaluation_offre_fin, 0, ',', ' ')}}</td>
                            <td>
                                <?php
                                    $montant_inf = intval($commissionevaluationoffre->cahiercommission->projet_etude->montant_projet_instruction) - (intval($commissionevaluationoffre->cahiercommission->projet_etude->montant_projet_instruction)*($commissionevaluationoffre->marge_inf_offre_fin_commission_evaluation_offre/100));
                                    $montant_sup = intval($commissionevaluationoffre->cahiercommission->projet_etude->montant_projet_instruction) + (intval($commissionevaluationoffre->cahiercommission->projet_etude->montant_projet_instruction)*($commissionevaluationoffre->marge_sup_offre_fin_commission_evaluation_offre/100));
                                ?>
                                @if(intval($commissionevaluationoffre->montantfinanciere($classement_offre_tech->entreprise)->montant_notation_commission_evaluation_offre_fin)<$montant_inf)
                                    <?php
                                        $note = (intval($commissionevaluationoffre->montantfinanciere($classement_offre_tech->entreprise)->montant_notation_commission_evaluation_offre_fin)
                                                /@$commissionevaluationoffre->cahiercommission->projet_etude->montant_projet_instruction)*20
                                    ?>
                                    @if($note<0)
                                        0
                                    @else
                                        {{round(@$note,2)}}
                                    @endif
                                @elseif($montant_inf <= intval($commissionevaluationoffre->montantfinanciere($classement_offre_tech->entreprise)->montant_notation_commission_evaluation_offre_fin
                                    ) && $montant_sup >= intval($commissionevaluationoffre->montantfinanciere($classement_offre_tech->entreprise)->montant_notation_commission_evaluation_offre_fin)
                                   )
                                    <?php
                                        $note = $commissionevaluationoffre->pourcentage_offre_fin_commission_evaluation_offre;
                                    ?>
                                    {{round(@$note,2)}}
                                @elseif(intval($commissionevaluationoffre->montantfinanciere($classement_offre_tech->entreprise)->montant_notation_commission_evaluation_offre_fin)>$montant_sup)
                                        <?php
                                            $note = ((intval($commissionevaluationoffre->montantfinanciere($classement_offre_tech->entreprise)->montant_notation_commission_evaluation_offre_fin)
                                                    /@$commissionevaluationoffre->cahiercommission->projet_etude->montant_projet_instruction)*20)-
                                                    (((intval($commissionevaluationoffre->montantfinanciere($classement_offre_tech->entreprise)->montant_notation_commission_evaluation_offre_fin)
                                                        -@$commissionevaluationoffre->cahiercommission->projet_etude->montant_projet_instruction)/@$commissionevaluationoffre->cahiercommission->projet_etude->montant_projet_instruction)*20*2)
                                        ?>
                                    @if($note<0)
                                        0
                                    @else
                                        {{round(@$note,2)}}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
    </tbody>
</table>
</div>
</body>
</html>
