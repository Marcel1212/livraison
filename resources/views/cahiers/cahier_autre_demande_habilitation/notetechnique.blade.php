<?php
use App\Helpers\Menu;
$logo = Menu::get_logo();
?>

    <!DOCTYPE html>
<html >
<head>
    <meta charset="utf-8">
    <link media="all" href="/assets/css/style_etat.css" type="text/css" rel="stylesheet"/>
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

        #table_avis>th>td {
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
        <tr>
            <td width="40%" style="float: right;margin-top: 2px">
                <div style="text-align: center">
                    Abidjan, {{ date('d F Y',strtotime(@$cahier->date_soumis_cahier_autre_demande_habilitations))}}
                </div>
                <br/>
            </td>
        </tr>
        <tr>
            <td  style="margin-top: 2px; text-align: left !important;font-weight:bold;">
                @isset($cahierautredemandehabilitations[0])
                    <div style="font-size:10px;width:40%;text-align: left;font-weight:bold;margin-top: 10px">
                        {{$cahierautredemandehabilitations[0]->libelle_direction}}
                        <h2 style="font-size:10px;text-align: center;margin-top: 0px;font-weight:bold; margin-bottom: 0px;padding-bottom: 0px; padding-top: 0px" class="mt-0 mb-0 text-center w-100">----------</h2>
                        {{$cahierautredemandehabilitations[0]->libelle_departement}}
                    </div>
                @endisset
            </td>
        </tr>

        <tr>
            <td width="100%" style="text-align: center;margin-top: 2px">
                <div>
                    <h2 style="font-size: 20px;text-decoration: underline;" > NOTE TECHNIQUE</h2>
                </div>
                <br/>
            </td>
        </tr>
        <tr>
            <td width="100%" style="float: left;margin-top: 2px">
                <div>
                    <h2 style="font-size: 18px" ><span style="font-size: 18px;text-decoration: underline;">Objet:</span> Extension d'habilitation {{date('Y')}}</h2>
                </div>
                <br/>
            </td>
        </tr>
        <tr >
            <td width="100%" style="float: left;margin-top: 2px">
                <div>
                    @isset($cahierautredemandehabilitations[0])
                        <p  style="margin: 0px !important;padding: 0px;">Le département {{$cahierautredemandehabilitations[0]->libelle_departement}} a reçu {{$cahierautredemandehabilitations->count()}} demande d'extension de domaine de
                            formation de cabinets privés de formation qui ont fait l'objet dun traitement conformément à la procédure en vigueur.
                            Les cabinets concernés sont régulièrement habilités pour l'année 2024.</p>
                        <br>
                        <p  style="margin: 0px !important;padding: 0px;">Nous venons par la présente note solliciter votre autorisation pour
                            l'extension des domaines de formation de ces cabinets.</p>
                    @endisset
                </div>

            </td>
        </tr>

        <tr>
            <td width="50%" style="float: left;margin-top: 2px">
                <h2 class="" style="font-size: 18px">
                    @isset($ResultProssesList)
                        @foreach($ResultProssesList as $res)
                            @if($res->priorite_combi_proc==1)
                                {{$res->name}}<br>
                                @if(isset($res->nom) && isset($res->prenom_users))
                                    {{$res->nom}} {{$res->prenom_users}}
                                @endisset
                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                    <div class="d-flex align-items-center">
                                        @if($res->is_valide==true)
                                            <div class="row ">
                                                <div>
                                                    <span>Validé le  {{ $res->date_valide }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if($res->is_valide===false)
                                            <div class="row">
                                                <div>
                                                    <span class="badge bg-label-danger">Rejeté le {{ $res->date_valide }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            @endif
                        @endforeach
                    @endif
                </h2>
                <p>

                </p>
            </td>
            <td width="50%" style="float: left;margin-top: 2px">
                <h2 class="" style="font-size: 18px">
                    @isset($ResultProssesList)
                        @foreach($ResultProssesList as $res)
                            @if($res->priorite_combi_proc==2)
                                 {{$res->name}}<br>
                                @if(isset($res->nom) && isset($res->prenom_users))
                                    {{$res->nom}} {{$res->prenom_users}}
                                @endisset
                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                    <div class="d-flex align-items-center">
                                        @if($res->is_valide==true)
                                            <div class="row ">
                                                <div>
                                                    <span>Validé le  {{ $res->date_valide }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if($res->is_valide===false)
                                            <div class="row">
                                                <div>
                                                    <span class="badge bg-label-danger">Rejeté le {{ $res->date_valide }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif
                </h2>
                <p>

                </p>
            </td>
        </tr>

        </tbody>
    </table>
    <br>
    <br>
    <br>
    <table width="100%" cellspacing="0" cellpadding="0" id="table_avis">
        <tbody >
        @if($ResultProssesList!=null)

        <tr style="height:50px !important;background: #bebebe !important;">
            <td style="text-align:center;font-weight:bold;width: 50%;border-top: 1pt solid windowtext;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                    @foreach($ResultProssesList as $res)
                        @if($res->priorite_combi_proc==3)
                            AVIS {{$res->name}}<br>
                            @if(isset($res->nom) && isset($res->prenom_users))
                                {{$res->nom}} {{$res->prenom_users}}
                            @endisset
                                    <div class="d-flex justify-content-between flex-wrap mb-2">
                                        <div class="d-flex align-items-center">
                                            @if($res->is_valide==true)
                                                <div class="row ">
                                                    <div>
                                                        <span>Validé le  {{ $res->date_valide }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($res->is_valide===false)
                                                <div class="row">
                                                    <div>
                                                        <span class="badge bg-label-danger">Rejeté le {{ $res->date_valide }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                </div>
                        @endif

                    @endforeach
                    <br>
            </td>
            <td style="text-align:center;font-weight:bold;width: 50%;border-top: 1pt solid windowtext;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                    @foreach($ResultProssesList as $res)
                        @if($res->priorite_combi_proc==4)
                            DECISION {{$res->name}}<br>
                            @if(isset($res->nom) && isset($res->prenom_users))
                                {{$res->nom}} {{$res->prenom_users}}
                            @endisset
                            <div class="d-flex justify-content-between flex-wrap mb-2">
                                <div class="d-flex align-items-center">
                                    @if($res->is_valide==true)
                                        <div class="row ">
                                            <div>
                                                <span>Validé le  {{ $res->date_valide }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if($res->is_valide===false)
                                        <div class="row">
                                            <div>
                                                <span class="badge bg-label-danger">Rejeté le {{ $res->date_valide }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endif
                    @endforeach
            </td>
        </tr>
        @endif

        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="col-xl-12">
        <h2 class="" style="font-size: 18px;text-align: center;text-decoration: underline">LISTE DES DEMANDES D'EXTENSION</h2>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" id="table_avis">
        <tbody>
        <tr style="height:50px !important;">
            <td style="width: 10%">

            </td>
            <td style="text-align:center;font-weight:bold;width: 20%;border-top: 1pt solid windowtext;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: 0pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                DENOMINATION
            </td>
            <td style="text-align:center;font-weight:bold;width: 20%;border-top: 1pt solid windowtext;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: 0pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                VALIDITE DE L'HABILITATION
            </td>
            <td style="text-align:center;font-weight:bold;width: 50%;border-top: 1pt solid windowtext;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                OBSERVATIONS
            </td>
        </tr>
        <?php $i=0; ?>
        @isset($cahierautredemandehabilitations)
            @foreach($cahierautredemandehabilitations as $cahierautredemandehabilitation)
                <tr style="height:50px !important;">
                    <td style="text-align:center;font-weight:bold;width: 10%;border-top: 1pt solid windowtext;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                        {{$i+1}}
                    </td>
                    <td style="text-align:center;font-weight:bold;width: 20%;border-top: 0pt solid windowtext;border-left: 0pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                        {{@$cahierautredemandehabilitation->raison_sociale}}
                    </td>
                    <td style="text-align:center;font-weight:bold;width: 20%;border-top: 0pt solid windowtext;border-left: 0pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: 0pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                        {{Menu::dateEnFrancais(@$cahierautredemandehabilitation->date_fin_validite)}}
                    </td>
                    <td style="text-align:center;font-weight:bold;width: 50%;border-top: 1pt solid windowtext;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 13.5pt;vertical-align: top;">
                        {{@$cahierautredemandehabilitation->observation_instruction}}
                    </td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
</div>


</body>
</html>
