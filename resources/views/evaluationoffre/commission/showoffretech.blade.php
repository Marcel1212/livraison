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
    @isset($cahier)
        <h3>NOTATION DES OFFRES TECHNIQUES</h3>
        <p><strong>CODE : {{@$cahier->commission_evaluation->code_commission_evaluation_offre}} </strong> | <strong> NOMBRE DE MEMBRE  : {{@$commissioneparticipants->count()}} </strong> </p>
    @endisset
    <table border="1" width="100%" cellspacing="0" cellpadding="0" class="encadre" style="margin-top: 13px !important">
        <tbody>
    <tr>
        <td colspan="2" style="font-size: 14px"><strong>OPERATEURS</strong></td>
        @isset($cahier)
            @isset($cahier->projet_etude)
                @isset($cahier->projet_etude->operateurs)
                    @foreach($cahier->projet_etude->operateurs as $key=>$operateur)
                        <td colspan="{{@$commissioneparticipants->count()}}" style="font-size: 14px">
                            Opérateur {{$key+1}}
                            : <span>{{$operateur->raison_social_entreprises}}</span></td>
                    @endforeach
                @endisset
            @endisset
        @endisset
    </tr>

    <tr>
        <td colspan="2" style="font-size: 14px">CONSEILLERS</td>
        @isset($cahier)
            @isset($cahier->projet_etude)
                @isset($cahier->projet_etude->operateurs)
                    @foreach($cahier->projet_etude->operateurs as $key=>$operateur)
                        @isset($commissioneparticipants)
                            @foreach($commissioneparticipants as $key=>$commissioneparticipant)
                                <td style="font-size: 14px">{{mb_substr(@$commissioneparticipant->name,0, 1)}}{{mb_substr(@$commissioneparticipant->prenom_users,0, 1)}}</td>
                            @endforeach
                        @endisset
                    @endforeach
                @endisset
            @endisset
        @endisset
    </tr>


    @isset($offretechcommissionevals)
        @foreach($offretechcommissionevals as $libelle=>$offretechcommissioneval_f)
            <tr>
                <td style="font-size: 14px" rowspan="{{$offretechcommissioneval_f->count()+1}}">{{@$libelle}}
                    ({{@$offretechcommissioneval_f->sum('note_offre_tech_commission_evaluation_offre')}} pts)
                </td>
            </tr>
            @isset($offretechcommissioneval_f)
                @foreach($offretechcommissioneval_f as $offretechcommissioneval)
                    <tr>
                        <td style="font-size: 14px">
                            {{@$offretechcommissioneval->souscritereevaluationoffretech->libelle_sous_critere_evaluation_offre_tech}}
                            ({{@$offretechcommissioneval->note_offre_tech_commission_evaluation_offre}}
                            pts)
                        </td>
                        @isset($cahier)
                            @isset($cahier->projet_etude)
                                @isset($cahier->projet_etude->operateurs)
                                    @foreach($cahier->projet_etude->operateurs as $key=>$operateur)
                                        @isset($commissioneparticipants)
                                            @foreach($commissioneparticipants as $key=>$commissioneparticipant)
                                                <td>
                                                    {{@$offretechcommissioneval->noteEvaluationOffre($operateur->id_entreprises,$commissioneparticipant->id_user_commission_evaluation_offre_participant)->note_notation_commission_evaluation_offre_tech}}
                                                </td>
                                            @endforeach
                                        @endisset
                                    @endforeach
                                @endisset
                            @endisset
                        @endisset
                    </tr>
                @endforeach
            @endisset
        @endforeach
    @endisset
    {{--                                <tr>--}}
    {{--                                    <td rowspan="5">Expérience du personnel clé Proposé (30 points)</td>--}}
    {{--                                </tr>--}}
    {{--                                @isset($offretechcommissionevals)--}}
    {{--                                    @foreach($offretechcommissionevals as $offretechcommissioneval)--}}
    {{--                                        <tr>--}}
    {{--                                            <td>{{@$offretechcommissioneval->souscritereevaluationoffretech->libelle_sous_critere_evaluation_offre_tech}} ({{@$offretechcommissioneval->note_offre_tech_commission_evaluation_offre}} pts)</td>--}}
    {{--                                        </tr>--}}
    {{--                                    @endforeach--}}
    {{--                                @endisset--}}

    {{--                                <tr>--}}
    {{--                                    <td>Réalisation de missions Similaires : (dates et références) (10 pts)</td>--}}
    {{--                                </tr>--}}

    {{--                                <tr>--}}
    {{--                                    <td>Total 1</td>--}}
    {{--                                </tr>--}}

    {{--                                <tr>--}}
    {{--                                    <td>Moyenne</td>--}}
    {{--                                </tr>--}}





    {{--                                    <?php $i=0 ?>--}}
    {{--                                                                    @foreach ($demandes as $key => $demande)--}}
    {{--                                                                        <tr>--}}
    {{--                                                                            <td>--}}
    {{--                                                                                <input type="checkbox"--}}
    {{--                                                                                       value="<?php echo $demande->id_demande;?>"--}}
    {{--                                                                                       name="demande[<?php echo $demande->id_demande;?>]"--}}
    {{--                                                                                       id="demande<?php echo $demande->id_demande;?>"/>--}}
    {{--                                                                            </td>--}}
    {{--                                                                            <td>--}}
    {{--                                                                                @if ($demande->code_processus =='PF')--}}
    {{--                                                                                    PLAN DE FORMATION--}}
    {{--                                                                                @endif--}}
    {{--                                                                                @if ($demande->code_processus =='PE')--}}
    {{--                                                                                    PROJET ETUDE--}}
    {{--                                                                                @endif--}}
    {{--                                                                                @if ($demande->code_processus =='PRF')--}}
    {{--                                                                                    PROJET DE FORMATION--}}
    {{--                                                                                @endif--}}
    {{--                                                                            </td>--}}
    {{--                                                                            <td>{{ @$demande->raison_sociale  }}</td>--}}
    {{--                                                                            <td>{{ @$demande->nom_conseiller }}</td>--}}
    {{--                                                                            <td>{{ @$demande->code }}</td>--}}
    {{--                                                                            <td>{{ $demande->date_demande }}</td>--}}
    {{--                                                                            <td>{{ $demande->date_soumis }}</td>--}}
    {{--                                                                            <td align="rigth">{{ number_format($demande->montant_total, 0, ',', ' ') }}</td>--}}
    {{--                                                                            <td align="center" nowrap="nowrap"></td>--}}
    {{--                                                                        </tr>--}}
    {{--                                                                    @endforeach--}}
    </tbody>
</table>
</div>
</body>
</html>
