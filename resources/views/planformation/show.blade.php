<?php
use App\Helpers\Menu;
$logo = Menu::get_logo();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Action de plan et fiche agrement A</title>
    <link media="all" href="/assets/css/style_etat.css" type="text/css" rel="stylesheet"/>
    <style type="text/css" media="print">
        @page { size: landscape; }
    </style>
</head>

<body>
<table width="100%" align="center" cellpadding="2" cellspacing="0">
        <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="texte1">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td valign="top">
                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                            <tr>
                                                <td width="16%" valign="top" nowrap="nowrap">
                                                <?php if (isset($logo->logo_logo)){ ?>
                                                    <img
                                                        src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}"
                                                        width="95" height="43"
                                                        alt="{{@$logo->mot_cle}}"/>
                                                <?php } ?>


                                                        <br/>
                                                        {{@$logo->mot_cle}}<br/>
                                                </td>
                                                <td width="42%" align="left" valign="middle">&nbsp;</td>
                                                <td width="42%" align="right" valign="top"><input name="Submit1"
                                                                                                  type="button"
                                                                                                  class="ecran visuel_bouton"
                                                                                                  id="Submit1"
                                                                                                  onclick="self.close();"
                                                                                                  value="Fermer"/>
                                                    &nbsp;
                                                    <input type="button" name="Submit" value="Imprimer"
                                                           class="ecran visuel_bouton" onclick="window.print();"/>
                                                    <BR/><span class="">
                                            <?php echo date('d-m-y'); ?>
                                            </span></td>
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    <table border="0" align="left" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td height="73" valign="middle">
                                                                <table width="100%" border="0" align="left"
                                                                       cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <table border="0" align="left"
                                                                                   cellpadding="2" cellspacing="1">
                                                                                <tr>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td align="left" class="entete2">&nbsp;

                                                                                    </td>
                                                                                    <td valign="middle" class="">&nbsp;

                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td align="left" class="">&nbsp;
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <div align="left"><span
                                                                                                class=""><strong
                                                                                                    class="">Intitule de la formation</strong></span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td align="left" class="entete2">
                                                                                        <span class="">: </span></td>
                                                                                    <td valign="middle" class=""><span
                                                                                            class="entete2"><span
                                                                                                class="">{{$actionplan->intitule_action_formation_plan }} </span></span>
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class=""><span
                                                                                            class=""><strong>Structure/etablissement de formation</strong></span>
                                                                                    </td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class=""> {{$actionplan->structure_etablissement_action_ }} </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <div align="left"><span
                                                                                                class=""><strong
                                                                                                    class="">Nombre de bénéficiaires <br/> de l’action de formation</strong></span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td width="5" align="left"
                                                                                        class="entete2"><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" class=""><span
                                                                                            class="entete2"><span
                                                                                                class="">{{$actionplan->nombre_stagiaire_action_formati }}  </span></span>
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class=""><span
                                                                                            class=""><strong>Nombre de groupes</strong></span>
                                                                                    </td>
                                                                                    <td width="5" align="left" class="">
                                                                                        <span class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class=""> {{$actionplan->nombre_groupe_action_formation_ }}   </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Nombre d'heures par groupe</strong></td>
                                                                                    <td width="5" align="left" class="">
                                                                                        <span class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">  {{$actionplan->nombre_heure_action_formation_p }}  </span>
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class=""><span
                                                                                            class=""><strong>Cout de l'action</strong></span>
                                                                                    </td>
                                                                                    <td width="5" align="left" class="">
                                                                                        <span class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">  {{$actionplan->cout_action_formation_plan }}  </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Type de formation</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->typeFormation->type_formation }}  </span>
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>But de la formation</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->butFormation->but_formation }}  </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Date debut</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->date_debut_fiche_agrement }}  </span>
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Date fin</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->date_fin_fiche_agrement }}  </span>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Lieu de la formation</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->lieu_formation_fiche_agrement }}  </span>
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Cout de la formation</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->cout_total_fiche_agrement }}  </span>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Objectif de la formation</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->objectif_pedagogique_fiche_agre }}  </span>
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Nombre de cadre</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->cadre_fiche_demande_agrement }}  </span>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Nombre d'agent</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->agent_maitrise_fiche_demande_ag }}  </span>
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Nombre d'employé</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->employe_fiche_demande_agrement }}  </span>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">
                                                                                        <strong>Total beneficiaire</strong></td>
                                                                                    <td align="left" class=""><span
                                                                                            class="">: </span></td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class=""><span
                                                                                            class="">{{$ficheagrement->total_beneficiaire_fiche_demand }}  </span>
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">&nbsp;
                                                                                    </td>
                                                                                    <td height="22" valign="middle"
                                                                                        nowrap="nowrap" class="">Secteur d'activité
                                                                                    </td>
                                                                                    <td align="left" class="">:
                                                                                    </td>
                                                                                    <td valign="middle" nowrap="nowrap"
                                                                                        class="">{{$actionplan->secteurActivite->libelle_secteur_activite }}
                                                                                    </td>
                                                                                </tr>


                                                                            </table>
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </td>

                                                        </tr>
                                                    </table>
                                                    <td valign="top">&nbsp;</td>

                                                </td>
                                              <td valign="top">&nbsp;</td>
                                                <td align="right" valign="top"></td>
                                            </tr>
                                        </table>
                                        <span class="letitre"><strong><u><center>
                </center>
                </u></strong></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr valign="baseline">
            <td align="center" valign="top" nowrap="nowrap" class="Grand"><strong><u>Liste des beneficiares   </u></strong></td>
        </tr>
        <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="texte1">
                <table width="100%" border="0" cellpadding="2" cellspacing="0" class="encadre">
                    <tr>
                        <td align="center" class="droite"><strong>N&deg;</strong></td>
                        <td align="center" class="droite"><strong>Nom et prenom</strong></td>
                        <td align="center" class="droite"><strong>Genre</strong></td>
                        <td align="left" class="droite"><strong>Annee de naissance</strong></td>
                        <td align="left" class="droite"><strong>Nationnalite</strong></td>
                        <td align="left" class="droite"><strong>Fonction</strong></td>
                        <td align="left" class="droite"><strong>Categorie</strong></td>
                        <td align="left" class="droite"><strong>Annee d'embauche</strong></td>
                        <td align="left" class="droite"><strong> Matricule CNPS</strong></td>
                    </tr>
                    <?php $i = 0; ?>
                    @foreach ($beneficiaires as $key => $res)
                            <?php $i += 1;?>
                        <tr>
                            <td align="center" nowrap="nowrap" class="encadrecmpl"><?php echo $i; ?></td>
                            <td align="center" nowrap="nowrap" class="encadrecmpl">
                                &nbsp;<?php echo $res->nom_prenoms; ?></td>
                            <td align="center" nowrap="nowrap" class="encadrecmpl">
                                &nbsp;<?php echo $res->genre; ?></td>
                            <td align="center" nowrap="nowrap" class="encadrecmpl">
                                &nbsp;<?php echo $res->annee_naissance; ?></td>
                            <td align="center" nowrap="nowrap" class="encadrehautligne">
                                &nbsp;<?php echo $res->nationalite; ?></td>
                            <td align="center" nowrap="nowrap" class="encadrehautligne">
                                &nbsp;<?php echo $res->fonction; ?></td>
                            <td align="center" nowrap="nowrap" class="encadrehautligne">
                                &nbsp;<?php echo $res->categorie; ?></td>
                            <td align="center" nowrap="nowrap" class="encadrehautligne">
                                &nbsp;<?php echo $res->annee_embauche; ?></td>
                            <td align="center" nowrap="nowrap" class="encadrehautligne">
                                &nbsp;<?php echo $res->matricule_cnps; ?></td>
                        </tr>

                    @endforeach
                    <tr>
                        <td colspan="12" align="left" nowrap="nowrap" class="encadrecmpl">&nbsp;</td>

                    </tr>


                </table>

            </td>
        </tr>
    </table>
</body>

</html>
