<?php
/*$activetab = "disabled";
if(count($categorieplans)>=4){
    $activetabpane = "show active";
    $activetab = "active";
}else{

}*/
?>
<?php

use App\Helpers\AnneeExercice;
use Carbon\Carbon;
$anneexercice = AnneeExercice::get_annee_exercice();
$dateday = Carbon::now()->format('d-m-Y');
$actifsoumission = false;

if(isset($anneexercice->id_periode_exercice)){
    $actifsoumission = true;
}else{
    $actifsoumission = false;
}

if(!empty($anneexercice->date_prolongation_periode_exercice)){
    $dateexercice = $anneexercice->date_prolongation_periode_exercice;
    if($dateday <= $dateexercice){
        $actifsoumission = true;
    }else{
        $actifsoumission = false;
    }
}



?>
@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module='Agreement')
    @php($titre='Liste des agreements pour les plans de formations')
    @php($soustitre='Consulter un agreement pour le plans de formation')
    @php($lien='traitementdemandesubstitutionplan')
    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
    </h5>


    <div class="content-body">
        @if(!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{$anneexercice}}
                </div>
                <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div align="right" class=" mb-3">
            <button type="button"
                    class="btn rounded-pill btn-outline-primary waves-effect waves-light"
                    data-bs-toggle="modal" data-bs-target="#modalToggle">
                Voir le parcours de validation
            </button>
        </div>
        <div class="nav-align-top nav-tabs-shadow ">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($etape==1) active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-planformation"
                        aria-controls="navs-top-planformation"
                        aria-selected="true">
                        Informations sur l'entreprise
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($etape==2) active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-categorieplan"
                        aria-controls="navs-top-categorieplan"
                        aria-selected="false">
                        Nombre de salariés déclarés à la CNPS
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($etape==3) active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-substitution"
                        aria-controls="navs-top-substitution"
                        aria-selected="false">
                        Demande de substitution
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @if($etape==4) active @endif"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-top-traitersub"
                        aria-controls="navs-top-traitersub"
                        aria-selected="true">
                        Traitement
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade @if($etape==1) show active @endif" id="navs-top-planformation" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>N° de compte contribuable </label>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       value="{{@$infoentreprise->ncc_entreprises}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Secteur activité <strong style="color:red;">*</strong></label>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       value="{{@$infoentreprise->secteurActivite->libelle_secteur_activite}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Localisation géographique </label>
                                <input type="text" name="localisation_geographique_entreprise" id="localisation_geographique_entreprise"
                                       class="form-control form-control-sm"
                                       value="{{@$infoentreprise->localisation_geographique_entreprise}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Repère d'accès </label>
                                <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                       class="form-control form-control-sm"
                                       value="{{@$infoentreprise->repere_acces_entreprises}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Adresse postale </label>
                                <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                       class="form-control form-control-sm"
                                       value="{{@$infoentreprise->adresse_postal_entreprises}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="billings-country">Indicatif</label>
                                        <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                            <?= $pay; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Téléphone  </label>
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               value="{{@$infoentreprise->tel_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="billings-country">Indicatif</label>
                                        <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                            <?= $pay; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Cellulaire Professionnelle  </label>
                                        <input type="number" name="cellulaire_professionnel_entreprises" id="cellulaire_professionnel_entreprises"
                                               class="form-control form-control-sm"
                                               value="{{@$infoentreprise->cellulaire_professionnel_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="billings-country">Indicatif</label>
                                        <select class="select2 form-select-sm input-group" data-allow-clear="true" disabled="disabled">
                                            <?= $pay; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Fax  </label>
                                        <input type="number" name="fax_entreprises" id="fax_entreprises"
                                               class="form-control form-control-sm"
                                               value="{{@$infoentreprise->fax_entreprises}}" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Type entreprises </label>
                                <select class="select2 form-select-sm input-group" name="id_type_entreprise" id="id_type_entreprise" disabled="disabled">
                                    <?php echo $typeentreprise; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Nom et prénoms du responsable formation </label>
                                <input type="text" name="nom_prenoms_charge_plan_formati" id="nom_prenoms_charge_plan_formati"
                                       class="form-control form-control-sm" value="{{@$planformation->nom_prenoms_charge_plan_formati}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Fonction du responsable formation </label>
                                <input type="text" name="fonction_charge_plan_formation" id="fonction_charge_plan_formation"
                                       class="form-control form-control-sm" value="{{@$planformation->fonction_charge_plan_formation}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Email professionnel du responsable formation </label>
                                <input type="email" name="email_professionnel_charge_plan_formation" id="email_professionnel_charge_plan_formation"
                                       class="form-control form-control-sm" value="{{@$planformation->email_professionnel_charge_plan_formation}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">
                                <label>Nombre de salariés déclarés à la CNPS </label>
                                <input type="number" name="nombre_salarie_plan_formation" id="nombre_salarie_plan_formation"
                                       class="form-control form-control-sm" value="{{@$planformation->nombre_salarie_plan_formation}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">

                                <label>Masse salariale brute annuelle prévisionnelle </label>
                                <input type="text" name="masse_salariale" id="masse_salariale"
                                       onkeyup="FuncCalculPartENtre(<?php echo $planformation->valeur_part_entreprise; ?>);"
                                       class="form-control form-control-sm" value="{{number_format(@$planformation->masse_salariale, 0, ',', ' ')}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mb-1">

                                <label>Part entreprise ({{ @$planformation->partEntreprise->valeur_part_entreprise }})</label>
                                <input type="text" name="part_entreprise" id="part_entreprise"
                                       class="form-control form-control-sm" value="{{number_format(@$planformation->part_entreprise, 0, ',', ' ')}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="mb-1">

                                <label>Part entreprise determinée</label>
                                <input type="text" name="part_entreprise_previsionnel" id="part_entreprise_previsionnel"
                                       class="form-control form-control-sm" value="{{number_format(@$planformation->part_entreprise_previsionnel, 0, ',', ' ')}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-1">

                                <label>Budget de financement </label>
                                <input type="text" name="montant_financement_budget" id="montant_financement_budget"
                                       class="form-control form-control-sm" value="{{number_format(@$planformation->montant_financement_budget, 0, ',', ' ')}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-1">

                                <label>Le coût demandé </label>
                                <input type="text" name="cout_total_demande_plan_formation" id="cout_total_demande_plan_formation"
                                       class="form-control form-control-sm" value="{{number_format(@$planformation->cout_total_demande_plan_formation, 0, ',', ' ')}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-1">

                                <label>Le coût accordé </label>
                                <input type="text" name="cout_total_accorder_plan_formation" id="cout_total_accorder_plan_formation"
                                       class="form-control form-control-sm" value="{{number_format(@$planformation->cout_total_accorder_plan_formation, 0, ',', ' ')}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-1">

                                <label>Code plan </label>
                                <input type="text" name="code_plan_formation" id="code_plan_formation"
                                       class="form-control form-control-sm" value="{{@$planformation->code_plan_formation}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-12" align="right">
                            <hr>
                            <a class="btn btn-sm btn-primary waves-effect me-2" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),
\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                                Suivant</a>
                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                Retour</a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if($etape==2) show active @endif" id="navs-top-categorieplan" role="tabpanel">
                    <table class="table table-bordered table-striped table-hover table-sm"
                           id=""
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Categorie </th>
                            <th>Genre</th>
                            <th>Nombre</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                        @foreach ($categorieplans as $key => $categorieplan)
                                <?php $i += 1;?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $categorieplan->categorieProfessionelle->categorie_profeessionnelle }}</td>
                                <td>{{ $categorieplan->genre_plan }}</td>
                                <td>{{ $categorieplan->nombre_plan }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <div class="col-12" align="right">
                        <hr>
                        <a class="btn btn-sm btn-secondary waves-effect me-2" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),
\App\Helpers\Crypt::UrlCrypt(1)]) }}">
                            Précédent</a>
                        <a class="btn btn-sm btn-primary waves-effect" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),
\App\Helpers\Crypt::UrlCrypt(3)]) }}">
                            Suivant</a>
                    </div>
                </div>
                <div class="tab-pane fade @if($etape==3) show active @endif" id="navs-top-substitution" role="tabpanel">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label> Motif de la demande de substitution du plan d'action</label>
                                            <select disabled class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_plan_substi" id="id_motif_demande_plan_substi" >
                                                @foreach($motifs as $motif)
                                                    <option value="{{$motif->id_motif}}" >{{$motif->libelle_motif}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Pièce justificatif de la demande de substitution</label>
                                        <div class="mt-2">
                                            @isset($demande_substitution->piece_demande_plan_substi)
                                                <span class="badge bg-secondary">
                                                            <a target="_blank" onclick="NewWindow('{{ asset("/pieces/piece_demande_substi/". $demande_substitution->piece_demande_plan_substi)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce
                                                            </a>
                                                        </span>
                                                <div id="defaultFormControlHelp" class="form-text ">
                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                        maxi : 5Mo</em>
                                                </div>
                                            @endisset
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label>Commentaire de la demande de substitution <strong
                                            style="color:red;">*</strong></label>
                                    <textarea disabled class="form-control form-control-sm"  name="commentaire_demande_plan_substi" id="commentaire_demande_plan_substi" rows="6"> @isset($demande_substitution->commentaire_demande_plan_substi){{$demande_substitution->commentaire_demande_plan_substi}}@endisset</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" align="right">
                        <hr>
                        <a class="btn btn-sm btn-secondary waves-effect me-2" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),
\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                            Précédent</a>
                        <a class="btn btn-sm btn-primary waves-effect" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),
\App\Helpers\Crypt::UrlCrypt(4)]) }}">
                            Suivant</a>
                    </div>

                </div>
                <div class="tab-pane fade @if($etape==4) show active @endif" id="navs-top-traitersub" role="tabpanel">
                    @if(@$ResultCptVal->priorite_combi_proc==1 && $parcoursexist->count()<=0)
                        <form  method="POST" id="planForm" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi)) }}">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="masse_salariale">Entreprise</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->raison_social_entreprises}}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="masse_salariale">Masse salariale</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{number_format(@$actionplanformation->masse_salariale,0,',',' ')}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de formation</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="intitule_action_formation_plan"
                                        value="{{@$actionplanformation->intitule_action_formation_plan}}" />
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupe</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_groupe_action_formation_}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_heure_action_formation_p}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label">Coût accordé <strong style="color:red;">*</strong>: </label>
                                        <input type="text" disabled
                                               value="{{number_format($actionplanformation->cout_total_accorder_plan_formation, 0, ',', ' ') }}"
                                               name="cout_accorde_action_formation" id="cout_accorde_action_formation" class="form-control form-control-sm" value="{{@$actionplanformation->cout_accorde_action_formation}}">                            </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>
                                    <select
                                        id="id_type_formation"
                                        name="id_type_formation"
                                        onchange="changeFunction();"
                                        class="select2 form-select-sm input-group @error('id_type_formation')
                                error
                                @enderror"
                                        aria-label="Default select example">
                                        @foreach ($typeformations as $typeformation)
                                            <option @if($actionplanformation->id_type_formation==$typeformation->id_type_formation) selected @endif value="{{ $typeformation->id_type_formation }}">{{ mb_strtoupper($typeformation->type_formation) }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_type_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="id_caracteristique_type_formation">Caractéristique type de formation <strong style="color:red;">*</strong></label>
                                    <select id="id_caracteristique_type_formation" name="id_caracteristique_type_formation" class="select2 form-select-sm input-group @error('id_caracteristique_type_formation')
                                error
                                @enderror">
                                        <option value='{{@$actionplanformation->caracteristiqueTypeFormation->id_caracteristique_type_formation}}'>{{@$actionplanformation->caracteristiqueTypeFormation->libelle_ctf}}</option>
                                    </select>
                                    @error('id_caracteristique_type_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="col-12 col-md-10">
                                            <label class="form-label" for="structure_etablissement_action_">Structure ou établissement de formation <strong style="color:red;">*</strong></label>
                                            <select class="select2 form-select-sm input-group @error('id_entreprise_structure_formation_plan_formation')
                                        error
                                        @enderror" name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation">
                                                <option value='{{@$actionplanformation->id_entreprise_structure_formation_action}}'>{{@$actionplanformation->structure_etablissement_action_}}</option>
                                            </select>
                                            @error('id_entreprise_structure_formation_plan_formation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <br>
                                            <button type="button" id="Activeajoutercabinetformation"
                                                    class="btn btn-icon btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#Ajoutercabinetformation" href="#myModal1" data-url="http://example.com">
                                                <span class="ti ti-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12" id="id_domaine_formation_div">
                                    <label>Domaine de formation <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select @error('id_domaine_formation')
                                error
                                @enderror"
                                            data-allow-clear="true" name="id_domaine_formation"
                                            id="id_domaine_formation">
                                        <option value='{{@$actionplanformation->id_domaine_formation}}' selected>{{@$actionplanformation->libelle_domaine_formation}}</option>
                                    </select>
                                    @error('id_domaine_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation</label>
                                    <input
                                        type="text" name="lieu_formation_fiche_agrement"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->lieu_formation_fiche_agrement}}"
                                    />
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->date_debut_fiche_agrement}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->date_fin_fiche_agrement}}"
                                        disabled="disabled"/>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadre</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->cadre_fiche_demande_agrement}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agent de maitrise</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->agent_maitrise_fiche_demande_ag}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employe / ouvriers</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->employe_fiche_demande_agrement}}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong> <span style="color: blue">(Vous pouvez sélectionner plusieurs)</span></label>
                                    <select
                                        id="id_but_formation" disabled
                                        name="id_but_formation[]" multiple
                                        class="select2 form-select input-group @error('id_but_formation')
                                error
                                @enderror"
                                        aria-label="Default select example" >
                                        @foreach ($butformations as $butformation)
                                            <option
                                                @foreach($butformationsficheademandeagrements as $butformationsficheademandeagrement)
                                                    @if($butformationsficheademandeagrement->id_but_formation==$butformation->id_but_formation) selected @endif
                                                @endforeach
                                                value="{{ $butformation->id_but_formation }}">{{ mb_strtoupper($butformation->but_formation) }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_but_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de stagiaires</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_stagiaire_action_formati}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupe</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_groupe_action_formation_}}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3 mb-4 ">
                                    <div class="mb-1 ">
                                        <label>Facture proforma </label> <br>
                                        <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $actionplanformation->facture_proforma_action_formati)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pedagogique</label>
                                    <div id="objectif_pedagogique_fiche_agre" class="rounded-1">{!!@$actionplanformation->objectif_pedagogique_fiche_agre!!}</div>
                                    <input class="form-control" type="hidden" id="objectif_pedagogique_fiche_agre_val" name="objectif_pedagogique_fiche_agre_val"/>
                                </div>
                            </div>

                            <div class="row">
                                <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id2) }}"/>
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
                                    <?php } else{ ?>
                                    <div class="col-12" align="right">
                                        <a class="btn btn-sm btn-secondary waves-effect me-2" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),
\App\Helpers\Crypt::UrlCrypt(3)]) }}">
                                            Précédent</a>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                    @else
                        <form  method="POST" id="planForm" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi)) }}">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="masse_salariale">Entreprise</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->raison_social_entreprises}}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="masse_salariale">Masse salariale</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{number_format(@$actionplanformation->masse_salariale,0,',',' ')}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="intitule_action_formation_plan">Intitulé de l'action de formation</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="intitule_action_formation_plan" disabled
                                        value="{{@$demande_substitution->intitule_action_formation_plan_substi}}" />
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupe</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_groupe_action_formation_}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_heure_action_formation_p}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label">Coût accordé <strong style="color:red;">*</strong>: </label>
                                        <input type="text" disabled
                                               value="{{number_format($actionplanformation->cout_total_accorder_plan_formation, 0, ',', ' ') }}"
                                               name="cout_accorde_action_formation" id="cout_accorde_action_formation" class="form-control form-control-sm" value="{{@$actionplanformation->cout_accorde_action_formation}}">                            </div>
                                </div>


                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>
                                    <select
                                        id="id_type_formation"
                                        name="id_type_formation" disabled
                                        onchange="changeFunction();"
                                        class="select2 form-select-sm input-group @error('id_type_formation')
                                error
                                @enderror"
                                        aria-label="Default select example">
                                        @foreach ($typeformations as $typeformation)
                                            <option @if($demande_substitution->id_type_formation_substi==$typeformation->id_type_formation) selected @endif value="{{ $typeformation->id_type_formation }}">{{ mb_strtoupper($typeformation->type_formation) }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_type_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="id_caracteristique_type_formation">Caractéristique type de formation <strong style="color:red;">*</strong></label>
                                    <select id="id_caracteristique_type_formation" disabled name="id_caracteristique_type_formation" class="select2 form-select-sm input-group @error('id_caracteristique_type_formation')
                                error
                                @enderror">
                                        <option value='{{@$demande_substitution->id_caracteristique_type_formation_substi}}'>{{@$demande_substitution->caracteristiqueTypeFormation->libelle_ctf}}</option>
                                    </select>
                                    @error('id_caracteristique_type_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="col-12 col-md-10">
                                            <label class="form-label" for="structure_etablissement_action_">Structure ou établissement de formation <strong style="color:red;">*</strong></label>
                                            <select class="select2 form-select-sm input-group @error('id_entreprise_structure_formation_plan_formation')
                                        error
                                        @enderror" disabled name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation">
                                                <option value="{{@$demande_substitution->id_entreprise_structure_formation_action_substi}}" selected>{{@$demande_substitution->structure_etablissement_action_substi}}</option>
                                            </select>
                                            @error('id_entreprise_structure_formation_plan_formation')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <br>
                                            <button type="button" id="Activeajoutercabinetformation"
                                                    class="btn btn-icon btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#Ajoutercabinetformation" href="#myModal1" data-url="http://example.com">
                                                <span class="ti ti-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" id="id_domaine_formation_div">
                                    <label>Domaine de formation <strong style="color:red;">*</strong></label>
                                    <select class="select2 form-select @error('id_domaine_formation')
                                error
                                @enderror" disabled
                                            data-allow-clear="true" name="id_domaine_formation"
                                            id="id_domaine_formation">
                                        <option value='{{@$demande_substitution->id_domaine_formation_substi}}' selected>{{@$demande_substitution->domaineFormation->libelle_domaine_formation}}</option>
                                    </select>
                                    @error('id_domaine_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>


                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation</label>
                                    <input
                                        type="text" name="lieu_formation_fiche_agrement"
                                        class="form-control form-control-sm" disabled
                                        value="{{@$demande_substitution->lieu_formation_fiche_agrement_substi}}"
                                    />
                                </div>

                                <div class="col-12 col-md-2">
                                    <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->date_debut_fiche_agrement}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->date_fin_fiche_agrement}}"
                                        disabled="disabled"/>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadre</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->cadre_fiche_demande_agrement}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agent de maitrise</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->agent_maitrise_fiche_demande_ag}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employe / ouvriers</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->employe_fiche_demande_agrement}}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong> <span style="color: blue">(Vous pouvez sélectionner plusieurs)</span></label>
                                    <select
                                        id="id_but_formation" disabled
                                        name="id_but_formation[]" multiple
                                        class="select2 form-select input-group @error('id_but_formation')
                                error
                                @enderror"
                                        aria-label="Default select example" >
                                        @foreach ($butformations as $butformation)
                                            <option
                                                @foreach($butformationsficheademandeagrements as $butformationsficheademandeagrement)
                                                    @if($butformationsficheademandeagrement->id_but_formation==$butformation->id_but_formation) selected @endif
                                                @endforeach
                                                value="{{ $butformation->id_but_formation }}">{{ mb_strtoupper($butformation->but_formation) }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_but_formation')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>



                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de stagiaires</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_stagiaire_action_formati}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupe</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_groupe_action_formation_}}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3 mb-4 ">
                                    <div class="mb-1 ">
                                        <label>Facture proforma </label> <br>
                                        <span class="badge bg-secondary"><a target="_blank"
                                                                            onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $actionplanformation->facture_proforma_action_formati)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pedagogique</label>
                                    <div id="objectif_pedagogique_fiche_agre_sup" class="rounded-1">{!!@$demande_substitution->objectif_pedagogique_fiche_agre_substi!!}</div>
                                    <input class="form-control" type="hidden" id="objectif_pedagogique_fiche_agre_sup" name="objectif_pedagogique_fiche_agre_substi"/>
                                </div>
                            </div>

                            <div class="row">
                                <input type="hidden" name="id_combi_proc" value="{{ \App\Helpers\Crypt::UrlCrypt($id2) }}"/>
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
                                    <?php } else{ ?>
                                    <div class="col-12" align="right">
                                        <a class="btn btn-sm btn-secondary waves-effect me-2" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),
\App\Helpers\Crypt::UrlCrypt(3)]) }}">
                                            Précédent</a>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="modal animate__animated animate__fadeInDownBig fade" id="modalToggle"
                 aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalToggleLabel">Etapes </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="card">
                            <h5 class="card-header">Parcours de la demande de substitution de l'action du plan de formation</h5>
                            <div class="card-body pb-2">
                                <ul class="timeline pt-3">
                                    @foreach ($ResultProssesList as $res)
                                        <li class="timeline-item pb-4 timeline-item-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?> border-left-dashed">
                            <span class="timeline-indicator-advanced timeline-indicator-<?php if($res->is_valide == true){ ?>success<?php }else if($res->is_valide == false){ ?>primary<?php } else{ ?>danger<?php } ?>">
                              <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                            </span>
                                            <div class="timeline-event">
                                                <div class="timeline-header border-bottom mb-3">
                                                    <h6 class="mb-0">{{ $res->priorite_combi_proc }}</h6>
                                                    <span class="text-muted"><strong>{{ $res->name }}</strong></span>
                                                </div>
                                                <div class="d-flex justify-content-between flex-wrap mb-2">
                                                    <div class="d-flex align-items-center">
                                                        @if($res->is_valide==true)
                                                            <div class="row ">
                                                                <div>
                                                                    <span>Observation : {{ $res->comment_parcours }}</span>
                                                                </div>
                                                                <div>
                                                                    <span>Validé le  {{ $res->date_valide }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($res->is_valide===false)
                                                            <div class="row">
                                                                <div>
                                                                    <span>Observation : {{ $res->comment_parcours }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="badge bg-label-danger">Validé le {{ $res->date_valide }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_perso')
    <script type="text/javascript">
        // document.getElementById("Activeajoutercabinetformation").disabled = true;
        function changeFunction() {
            var selectBox = document.getElementById("id_type_formation");
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;
            $.get('/caracteristiqueTypeFormationlist/'+selectedValue, function (data) {
                $('#id_caracteristique_type_formation').empty();
                $.each(data, function (index, tels) {
                    $('#id_caracteristique_type_formation').append($('<option>', {
                        value: tels.id_caracteristique_type_formation,
                        text: tels.libelle_ctf,
                    }));
                });
            });
            if(selectedValue == 1 || selectedValue ==2 || selectedValue == 5){
                document.getElementById("Activeajoutercabinetformation").disabled = true;
                $.get('/entreprisecabinetformation', function (data) {
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                        $.get('/domaineformation/'+tels.id_entreprises, function (data) {
                            $('#id_domaine_formation').empty();
                            $.each(data, function (index, tels) {
                                $('#id_domaine_formation').append($('<option>', {
                                    value: tels.id_domaine_formation,
                                    text: tels.libelle_domaine_formation,
                                }));
                            });
                        });
                    });
                });
            }
            if(selectedValue == 3){
                document.getElementById("Activeajoutercabinetformation").disabled = true;
                $.get('/entrepriseinterneplanGeneral/{{$infoentreprise->id_entreprises}}', function (data) {
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                        $.get('/domaineformations', function (data) {
                            $('#id_domaine_formation').empty();
                            $.each(data, function (index, tels) {
                                $('#id_domaine_formation').append($('<option>', {
                                    value: tels.id_domaine_formation,
                                    text: tels.libelle_domaine_formation,
                                }));
                            });
                        });
                    });
                });
            }
            if(selectedValue == 4){
                document.getElementById("Activeajoutercabinetformation").disabled = false;
                $.get('/entreprisecabinetetrangerformation', function (data) {
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                        $.get('/domaineformations', function (data) {
                            //alert(tels.id_entreprises); //exit;
                            $('#id_domaine_formation').empty();
                            $.each(data, function (index, tels) {
                                $('#id_domaine_formation').append($('<option>', {
                                    value: tels.id_domaine_formation,
                                    text: tels.libelle_domaine_formation,
                                }));
                            });
                        });
                    });
                });
            }
        }
        function changeFunction1(){
            var SelectEntreprise = document.getElementById("id_entreprise_structure_formation_plan_formation");
            let SelectedEntrepriseValue = SelectEntreprise.options[SelectEntreprise.selectedIndex].value;
            $.get('/domaineformation/'+SelectedEntrepriseValue, function (data) {
                $('#id_domaine_formation').empty();
                $.each(data, function (index, tels) {
                    $('#id_domaine_formation').append($('<option>', {
                        value: tels.id_domaine_formation,
                        text: tels.libelle_domaine_formation,
                    }));
                });
            });
        }

        @if(@$ResultCptVal->priorite_combi_proc==1 && $parcoursexist->count()<=0)
        $("#objectif_pedagogique_fiche_agre_val").hide();
        document.getElementById('planForm').onsubmit = function(){
            $("#objectif_pedagogique_fiche_agre_val").val(objectif_pedagogique_fiche_agre.root.innerHTML);
        }
        var objectif_pedagogique_fiche_agre = new Quill('#objectif_pedagogique_fiche_agre',{theme: 'snow'});
        @else
        var objectif_pedagogique_fiche_agre_sup = new Quill('#objectif_pedagogique_fiche_agre_sup',{theme: 'snow'});
        objectif_pedagogique_fiche_agre_sup.disable();

        @endif
    </script>
@endsection

