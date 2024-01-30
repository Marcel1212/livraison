<?php
    /*$activetab = "disabled";
	if(count($categorieplans)>=4){
		$activetabpane = "show active";
		$activetab = "active";
	}else{

	}*/
    $NumAgce = Auth::user()->num_agce;
    use App\Helpers\ConseillerParAgence;
    use App\Helpers\NombreActionValiderParLeConseiller;
    $conseilleragence = ConseillerParAgence::get_conseiller_par_agence($NumAgce);
    $conseillerplan = NombreActionValiderParLeConseiller::get_conseiller_valider_plan($planformation->id_plan_de_formation , Auth::user()->id);
    $nombre = count($conseilleragence);
    //dd($nombre);
?>

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Projet d\'étude')
    @php($titre='Liste des projets d\'étude')
    @php($soustitre='Comite technique à valider')
    @php($lien='ctprojetetudevalider')


    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
    </h5>

    <div class="content-body">

        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title" align="center"> Details du projet d'etude</h5>


                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="accordion mt-3" id="accordionExample">
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button type="button" class="accordion-button"
                                                    data-bs-toggle="collapse" data-bs-target="#accordionOne"
                                                    aria-expanded="true" aria-controls="accordionOne">
                                                Details de l'entreprise
                                            </button>
                                        </h2>

                                        <div id="accordionOne" class="accordion-collapse collapse"
                                             data-bs-parent="#accordionExample" style="">
                                            <div class="accordion-body">
                                                <div class="row gy-3">
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label> <b class="term">Numero de compte
                                                                    contribuable: </b> </label> <br>
                                                            <label> <?php echo $entreprise->ncc_entreprises; ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label> <b class="term">Raison sociale: </b>
                                                            </label> <br>
                                                            <label> <?php echo $entreprise->raison_social_entreprises; ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label> <b class="term">Numéro de téléphone: </b>
                                                            </label> <br>
                                                            <label> <?php echo $entreprise->tel_entreprises; ?></label>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label> <b class="term">Email: </b>
                                                            </label> <br>
                                                            <label> <?php echo $entreprise_mail;
                                                                    ?></label>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label> <b class="term">Situation géographique:
                                                                </b>
                                                            </label> <br>
                                                            <label> <?php echo $entreprise->localisation_geographique_entreprise; ?></label>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label> <b class="term">Numéro CNPS:
                                                                </b>
                                                            </label> <br>
                                                            <label> <?php echo $entreprise->numero_cnps_entreprises; ?></label>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card accordion-item active">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button type="button" class="accordion-button collapsed"
                                                    data-bs-toggle="collapse" data-bs-target="#accordionTwo"
                                                    aria-expanded="false" aria-controls="accordionTwo">
                                                Informations du projet d'etude
                                            </button>
                                        </h2>
                                        <div id="accordionTwo" class="accordion-collapse collapse"
                                             aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                             style="">
                                            <div class="accordion-body">
                                                <div class="row gy-3">
                                                    <div class="col-md-12 col-10" align="center">
                                                        <div class="mb-1">
                                                            <label>Titre du projet </label>
                                                            <input type="text" name="titre_projet"
                                                                   id="titre_projet"
                                                                   class="form-control form-control-sm"
                                                                   disabled
                                                                   value="{{ $projet_etude_valide->titre_projet_etude }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label>Contexte ou Problèmes constatés</label>

                                                            <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="contexte_probleme"
                                                                      style="height: 121px;" disabled><?php echo $projet_etude_valide->contexte_probleme_projet_etude; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label>Objectif Général </label>

                                                            <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_general"
                                                                      style="height: 121px;" disabled><?php echo $projet_etude_valide->objectif_general_projet_etude; ?></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label>Objectifs spécifiques </label>

                                                            <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_specifique"
                                                                      style="height: 121px;" disabled><?php echo $projet_etude_valide->objectif_specifique_projet_etud; ?></textarea>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label>Résultats attendus </label>

                                                            <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="resultat_attendu"
                                                                      style="height: 121px;" disabled><?php echo $projet_etude_valide->resultat_attendu_projet_etude; ?></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label>Champ de l’étude </label>

                                                            <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="champ_etude"
                                                                      style="height: 121px;" disabled><?php echo $projet_etude_valide->champ_etude_projet_etude; ?></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="mb-1">
                                                            <label>Cible </label>

                                                            <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="cible" style="height: 121px;"
                                                                      disabled><?php echo $projet_etude_valide->cible_projet_etude; ?></textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button type="button" class="accordion-button collapsed"
                                                    data-bs-toggle="collapse" data-bs-target="#accordionThree"
                                                    aria-expanded="false" aria-controls="accordionThree">
                                                Pieces jointes du projet
                                            </button>
                                        </h2>
                                        <div id="accordionThree" class="accordion-collapse collapse"
                                             aria-labelledby="headingThree" data-bs-parent="#accordionExample"
                                             style="">
                                            <div class="accordion-body">
                                                <div class="row gy-3">

                                                    <div class="col-md-4">
                                                        <label class="form-label">Avant-projet TDR</label> <br>
                                                        <span class="badge bg-secondary"><a target="_blank"
                                                                                            onclick="NewWindow('{{ asset('/pieces_projet/avant_projet_tdr/' . $piecesetude1) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Courrier de demande de
                                                            financement</label> <br>
                                                        <span class="badge bg-secondary"><a target="_blank"
                                                                                            onclick="NewWindow('{{ asset('/pieces_projet/courier_demande_fin/' . $piecesetude2) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Dossier d’intention </label>
                                                        <br>
                                                        <span class="badge bg-secondary"><a target="_blank"
                                                                                            onclick="NewWindow('{{ asset('/pieces_projet/dossier_intention/' . $piecesetude3) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Lettre d’engagement</label>
                                                        <br>
                                                        <span class="badge bg-secondary"><a target="_blank"
                                                                                            onclick="NewWindow('{{ asset('/pieces_projet/lettre_engagement/' . $piecesetude4) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Offre technique</label> <br>
                                                        <span class="badge bg-secondary"><a target="_blank"
                                                                                            onclick="NewWindow('{{ asset('/pieces_projet/offre_technique/' . $piecesetude5) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Offre financière</label> <br>
                                                        <span class="badge bg-secondary"><a target="_blank"
                                                                                            onclick="NewWindow('{{ asset('/pieces_projet/offre_financiere/' . $piecesetude6) }}','',screen.width/2,screen.height,'yes','center',1);">
                                                                            Voir la pièce </a> </span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div> <br>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card-body mt-3">
                                <div class="col-12" align="left">
                                    <br>
                                    <div class="col-md-12">
                                        <h5 class="card-title mt-3" align="center"> Traitement</h5>
                                    </div>
                                    <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($projet_etude_valide->id_projet_etude)) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id_combi_proc) }}"/>
                                            <div class="col-md-12 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire <strong style="color:red;">(obligatoire si rejeté)*</strong>: </label>
                                                    @if($parcoursexist->count()<1)
                                                        <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6"></textarea>
                                                    @else
                                                        <textarea class="form-control form-control-sm"  name="comment_parcours" id="comment_parcours" rows="6">{{ $parcoursexist[0]->comment_parcours }}</textarea>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                <?php if(count($parcoursexist)<1){?>
                                                <button type="submit" name="action" value="Valider"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                                    Valider
                                                </button>
                                                <button type="submit" name="action" value="Rejeter"
                                                        class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                                    Rejeter
                                                </button>
                                                <?php } ?>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

