
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
    @php($titre='Liste des demandes de substitution')
    @php($soustitre='Consulter un agreement pour le plans de formation')
    @php($lien='traitementsubstitution')

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
{{--                                <a class="btn btn-sm btn-primary waves-effect me-2" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),--}}
{{--\App\Helpers\Crypt::UrlCrypt(2)]) }}">--}}
{{--                                    Suivant</a>--}}
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
{{--                        <a class="btn btn-sm btn-secondary waves-effect me-2" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),--}}
{{--\App\Helpers\Crypt::UrlCrypt(1)]) }}">--}}
{{--                            Précédent</a>--}}
{{--                        <a class="btn btn-sm btn-primary waves-effect" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),--}}
{{--\App\Helpers\Crypt::UrlCrypt(3)]) }}">--}}
{{--                            Suivant</a>--}}
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
{{--                        <a class="btn btn-sm btn-secondary waves-effect me-2" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),--}}
{{--\App\Helpers\Crypt::UrlCrypt(2)]) }}">--}}
{{--                            Précédent</a>--}}
{{--                        <a class="btn btn-sm btn-primary waves-effect" href="{{route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($demande_substitution->id_action_formation_plan_substi),'id2'=>\App\Helpers\Crypt::UrlCrypt($id2),--}}
{{--\App\Helpers\Crypt::UrlCrypt(4)]) }}">--}}
{{--                            Suivant</a>--}}
                    </div>

                    {{--                    @isset($demande_annulation_plan)--}}
                    {{--                            @if($demande_annulation_plan->flag_soumis_demande_annulation_plan==true)--}}
                    {{--                                <div class="col-md-12">--}}
                    {{--                                    <div class="col-md-12">--}}
                    {{--                                        <h5 class="card-title mb-3" align="center"> Détail de la demande d'annulation</h5>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="row">--}}
                    {{--                                        <div class="col-md-6">--}}
                    {{--                                            <div class="row">--}}
                    {{--                                                <div class="col-md-12 mb-3">--}}
                    {{--                                                    <div class="mb-1">--}}
                    {{--                                                        <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                        <select class="select2 form-select-sm input-group" disabled data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">--}}
                    {{--                                                            @foreach($motifs as $motif)--}}
                    {{--                                                                <option value="{{$motif->id_motif}}">{{$motif->libelle_motif}}</option>--}}
                    {{--                                                            @endforeach--}}
                    {{--                                                        </select>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-3">--}}
                    {{--                                                    <label class="form-label">Pièce justificatif--}}
                    {{--                                                        de la demande d'annulation</label>--}}
                    {{--                                                    <br>--}}
                    {{--                                                    @isset($demande_annulation_plan->piece_demande_annulation_plan)--}}
                    {{--                                                        <span class="badge bg-secondary"> <a target="_blank"--}}
                    {{--                                                                                             onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);--}}
                    {{--                                                                                        ">--}}
                    {{--                                          Voir la pièce  </a></span>--}}
                    {{--                                                    @endisset--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}

                    {{--                                        </div>--}}
                    {{--                                        <div class="col-md-6">--}}
                    {{--                                            <div class="mb-1">--}}
                    {{--                                                <label> Commentaire de la demande d'annulation du plan</label>--}}
                    {{--                                                <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="evaluation_competences_odf"--}}
                    {{--                                                          style="height: 121px;" disabled>@isset($demande_annulation_plan->commentaire_demande_annulation_plan) {{$demande_annulation_plan->commentaire_demande_annulation_plan}} @endisset</textarea>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                    <div class="col-12" align="right">--}}
                    {{--                                        <hr>--}}
                    {{--                                        <a class="btn btn-sm btn-outline-secondary float-end waves-effect"--}}
                    {{--                                           href="/{{$lien }}">--}}
                    {{--                                            Retour</a>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            @else--}}
                    {{--                                <form method="POST" class="form"--}}
                    {{--                                      action="{{route($lien.'.cancel.update',['id_demande'=>\App\Helpers\Crypt::UrlCrypt($demande_annulation_plan->id_demande_annulation_plan), 'id_plan'=>\App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)])}}" enctype="multipart/form-data">--}}
                    {{--                                    @csrf--}}
                    {{--                                    @method('put')--}}
                    {{--                                    <div class="row">--}}
                    {{--                                        <div class="col-md-6 col-12">--}}
                    {{--                                            <div class="row">--}}
                    {{--                                                <div class="col-md-12">--}}
                    {{--                                                    <div class="mb-1">--}}
                    {{--                                                        <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                        <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >--}}
                    {{--                                                            @foreach($motifs as $motif)--}}
                    {{--                                                                <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>--}}
                    {{--                                                            @endforeach--}}
                    {{--                                                        </select>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-2">--}}
                    {{--                                                    <label class="form-label">Pièce justificatif de la demande d'annulation <strong--}}
                    {{--                                                            style="color:red;"></strong></label>--}}
                    {{--                                                    <input type="file" name="piece_demande_annulation_plan"--}}
                    {{--                                                           class="form-control form-control-sm" placeholder=""--}}
                    {{--                                                           @isset($demande_annulation_plan->piece_demande_annulation_plan)value="{{$demande_annulation_plan->piece_demande_annulation_plan}}"@endisset/>--}}
                    {{--                                                    <div id="defaultFormControlHelp" class="form-text ">--}}
                    {{--                                                        <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
                    {{--                                                            maxi : 5Mo</em>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-md-12 mt-2">--}}
                    {{--                                                    @isset($demande_annulation_plan->piece_demande_annulation_plan)--}}
                    {{--                                                        <span class="badge bg-secondary"> <a target="_blank"--}}
                    {{--                                                                                             onclick="NewWindow('{{ asset("/pieces/piece_justificatif_demande_annulation/". $demande_annulation_plan->piece_demande_annulation_plan)}}','',screen.width/2,screen.height,'yes','center',1);--}}
                    {{--                                                                                        ">--}}
                    {{--                                          Voir la pièce précédemment enregistrée  </a></span>--}}
                    {{--                                                    @endisset--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}

                    {{--                                        </div>--}}
                    {{--                                        <div class="col-md-6 col-12">--}}
                    {{--                                            <div class="mb-1">--}}
                    {{--                                                <label>Commentaire de la demande d'annuation <strong--}}
                    {{--                                                        style="color:red;">*</strong></label>--}}
                    {{--                                                <textarea class="form-control form-control-sm"  name="commentaire_demande_annulation_plan" id="commentaire_demande_annulation_plan" rows="6">@isset($demande_annulation_plan->commentaire_demande_annulation_plan){{$demande_annulation_plan->commentaire_demande_annulation_plan}}@endisset</textarea>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}


                    {{--                                        <div class="col-12" align="right">--}}
                    {{--                                            <hr>--}}
                    {{--                                            <button onclick='javascript:if (!confirm("Voulez-vous soumettre la demande d annulation de ce plan de formation à un conseiller ? . Cette action est irreversible")) return false;'  type="submit" name="action" value="Enregistrer_soumettre_plan_formation" class="btn btn-sm btn-success me-sm-3 me-1">Soumettre la demande d'annulation</button>--}}

                    {{--                                            <button type="submit"--}}
                    {{--                                                    class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">--}}
                    {{--                                                Modifier--}}
                    {{--                                            </button>--}}
                    {{--                                            <a class="btn btn-sm btn-outline-secondary waves-effect"--}}
                    {{--                                               href="/{{$lien }}">--}}
                    {{--                                                Retour</a>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                </form>--}}
                    {{--                            @endif--}}
                    {{--                        @else--}}
                    {{--                            <form method="POST" class="form"--}}
                    {{--                                  action="{{ route($lien.'.cancel.store', \App\Helpers\Crypt::UrlCrypt($plan_de_formation->id_plan_de_formation)) }}" enctype="multipart/form-data">--}}
                    {{--                                @csrf--}}
                    {{--                                <div class="row">--}}
                    {{--                                    <div class="col-md-6 col-12">--}}
                    {{--                                        <div class="row">--}}
                    {{--                                            <div class="col-md-12">--}}
                    {{--                                                <div class="mb-1">--}}
                    {{--                                                    <label> Motif de la demande d'annulation du plan</label>--}}
                    {{--                                                    <select  class="select2 form-select-sm input-group"  data-allow-clear="true" name="id_motif_demande_annulation_plan" id="id_motif_demande_annulation_plan" >--}}
                    {{--                                                        @foreach($motifs as $motif)--}}
                    {{--                                                            <option value="{{$motif->id_motif}}" @if($motif->id_motif==$motif->id_motif_demande_annulation_plan) selected @endif>{{$motif->libelle_motif}}</option>--}}
                    {{--                                                        @endforeach--}}
                    {{--                                                    </select>--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}
                    {{--                                            <div class="col-md-12 mt-2">--}}
                    {{--                                                <label class="form-label">Pièce justificatif de la demande d'annulation <strong--}}
                    {{--                                                        style="color:red;">*</strong></label>--}}
                    {{--                                                <input type="file" name="piece_demande_annulation_plan"--}}
                    {{--                                                       class="form-control form-control-sm" placeholder=""--}}
                    {{--                                                       required="required"--}}
                    {{--                                                       value="{{ old('piece_demande_annulation_plan') }}"/>--}}
                    {{--                                                <div id="defaultFormControlHelp" class="form-text ">--}}
                    {{--                                                    <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille--}}
                    {{--                                                        maxi : 5Mo</em>--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}

                    {{--                                    </div>--}}
                    {{--                                    <div class="col-md-6 col-12">--}}
                    {{--                                        <div class="mb-1">--}}
                    {{--                                            <label>Commentaire de la demande d'annuation <strong--}}
                    {{--                                                    style="color:red;">*</strong></label>--}}
                    {{--                                            <textarea class="form-control form-control-sm"  name="commentaire_demande_annulation_plan" id="commentaire_demande_annulation_plan" rows="6">{{ old('commentaire_demande_annulation_plan') }}</textarea>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}


                    {{--                                    <div class="col-12" align="right">--}}
                    {{--                                        <hr>--}}

                    {{--                                        <button type="submit"--}}
                    {{--                                                class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">--}}
                    {{--                                            Enregistrer--}}
                    {{--                                        </button>--}}
                    {{--                                        <a class="btn btn-sm btn-outline-secondary waves-effect"--}}
                    {{--                                           href="/{{$lien }}">--}}
                    {{--                                            Retour</a>--}}
                    {{--                                    </div>--}}

                    {{--                                </div>--}}
                    {{--                            </form>--}}
                    {{--                        @endisset--}}
                </div>
                <div class="tab-pane fade @if($etape==4) show active @endif" id="navs-top-traitersub" role="tabpanel">
                    <form  method="POST" id="planForm" class="form" action="{{route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($actionplanformation->id_action_formation_plan))}}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                                <div class="col-12 col-md-9">
                                    <label class="form-label" for="masse_salariale">Entreprise</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->raison_social_entreprises}}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="masse_salariale">Masse salariale</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->masse_salariale}}"
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
                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="objectif_pedagogique_fiche_agre">Objectif pedagogique</label>
                                    <div id="objectif_pedagogique_fiche_agre" class="rounded-1">{!!@$actionplanformation->objectif_pedagogique_fiche_agre!!}</div>
                                    <input class="form-control" type="hidden" id="objectif_pedagogique_fiche_agre" name="objectif_pedagogique_fiche_agre_val"/>
                                </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="id_but_formation">But de la formation <strong style="color:red;">*</strong></label>
                                <select
                                    id="id_but_formation"
                                    name="id_but_formation"
                                    class="select2 form-select input-group @error('id_but_formation')
                                error
                                @enderror"
                                    aria-label="Default select example" >
                                    @foreach ($butformations as $butformation)
                                        <option @if($actionplanformation->id_but_formation==$butformation->id_but_formation) selected @endif value="{{ $butformation->id_but_formation }}">{{ mb_strtoupper($butformation->but_formation) }}</option>
                                    @endforeach
                                </select>
                                @error('id_but_formation')
                                <div class=""><label class="error">{{ $message }}</label></div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="id_type_formation">Type de formation <strong style="color:red;">*</strong></label>
                                <select
                                    id="id_type_formation_{{$key}}"
                                    name="id_type_formation"
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
                            <div class="col-12 col-md-3">
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
                            <div class="col-12 col-md-3">
                                <div class="row">
                                    <div class="col-12 col-md-10">
                                        <label class="form-label" for="structure_etablissement_action_">Structure ou établissement de formation <strong style="color:red;">*</strong></label>
                                        <select class="select2 form-select-sm input-group @error('id_entreprise_structure_formation_plan_formation')
                                        error
                                        @enderror" name="id_entreprise_structure_formation_plan_formation" id="id_entreprise_structure_formation_plan_formation_{{$key}}">
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
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="lieu_formation_fiche_agrement">Lieu de formation</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    value="{{@$actionplanformation->lieu_formation_fiche_agrement}}"
                                    />
                            </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="nombre_stagiaire_action_formati">Nombre de stagiaires</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_stagiaire_action_formati}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="nombre_groupe_action_formation_">Nombre de groupe</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_groupe_action_formation_}}"
                                        disabled="disabled" />
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="nombre_heure_action_formation_p">Nombre d'heures par groupes</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->nombre_heure_action_formation_p}}"
                                        disabled="disabled" />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="date_debut_fiche_agrement">Date debut de realisation</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->date_debut_fiche_agrement}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="date_fin_fiche_agrement">Date fin de realisation</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->date_fin_fiche_agrement}}"
                                        disabled="disabled"/>
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="cadre_fiche_demande_agrement">Nombre de cadre</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->cadre_fiche_demande_agrement}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="agent_maitrise_fiche_demande_ag">Nombre d'agent de maitrise</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->agent_maitrise_fiche_demande_ag}}"
                                        disabled="disabled"/>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="employe_fiche_demande_agrement">Nombre d'employe / ouvriers</label>
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        value="{{@$actionplanformation->employe_fiche_demande_agrement}}"
                                        disabled="disabled" />
                                </div>


                                <div class="col-md-3 col-12">
                                    <div class="mb-1">
                                        <label>Montant accordé <strong style="color:red;">*</strong>: </label>
                                        <input type="text" disabled
                                               value="{{number_format($actionplanformation->cout_action_formation_plan, 0, ',', ' ') }}"
                                               name="cout_accorde_action_formation" id="cout_accorde_action_formation" class="form-control form-control-sm" value="{{@$actionplanformation->cout_accorde_action_formation}}">                            </div>
                                </div>


                            <div class="col-12 col-md-3 mb-4 ">
                                <div class="mb-1 ">
                                    <label>Facture proforma </label> <br>
                                    <span class="badge bg-secondary"><a target="_blank"
                                                                        onclick="NewWindow('{{ asset("/pieces/facture_proforma_action_formation/". $actionplanformation->facture_proforma_action_formati)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                </div>
                            </div>
                            <hr>
                                                                        <div class="col-12" align="right">

                            <button
                                onclick='javascript:if (!confirm("Voulez-vous soumettre la demande d annulation de cette action de formation à un conseiller ? . Cette action est irreversible")) return false;'
                                type="submit" name="action" value="Enregistrer_soumettre_demande_annulation"
                                class="btn btn-sm btn-success me-sm-3 me-1">Valider le traitement
                            </button>
                            <a href="/{{$lien}}" class="btn btn-sm btn-outline-secondary me-sm-3 me-1">Retour</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="Ajoutercabinetformation" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-simple modal-edit-user">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="text-center mb-4">
                                <h3 class="mb-2">Saisie les informations du cabinet étranger</h3>
                                <p class="text-muted"></p>
                            </div>
                            <div class="modal-body">
                                <form class="mt-3" id="ajax-form" action="{{ route('ajoutcabinetetrangere') }}">
                                    @csrf
                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <label class="form-label" for="fullname">Raison sociale
                                                <strong style="color:red;">*</strong></label>
                                            <input type="text" id="raison_social_entreprises"
                                                   name="raison_social_entreprises"
                                                   class="form-control form-control-sm"
                                                   placeholder="Raison sociale"
                                                   required="required"
                                            />
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label" for="email">Email <strong style="color:red;">*</strong></label>
                                            <div class="input-group input-group-merge">
                                                <input
                                                    class="form-control form-control-sm"
                                                    type="email"
                                                    id="email"
                                                    name="email_entreprises"
                                                    placeholder="Email"
                                                    aria-label=""
                                                    aria-describedby="email3" required="required"/>
                                                <span class="input-group-text" id="email"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <!--<label class="form-label" for="phone-number-mask">Téléphone du représentant</label>-->

                                            <label class="form-label"
                                                   for="billings-country">Indicatif <strong style="color:red;">*</strong> </label>
                                            <select class="select2 form-select-sm input-group" readonly=""
                                                    name="indicatif_entreprises" required="required">
                                                    <?php echo "+" .$paysc; ?>

                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Téléphone <strong
                                                    style="color:red;">*</strong></label>
                                            <input type="number" min="0"
                                                   name="tel_entreprises"
                                                   class="form-control form-control-sm"
                                                   placeholder="Téléphone"
                                                   required="required"/>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label>Localisation géographique <strong style="color:red;">*</strong></label>
                                                <input type="text" name="localisation_geographique_entreprise"
                                                       id="localisation_geographique_entreprise"
                                                       class="form-control form-control-sm"
                                                       placeholder="Localisation géographique"
                                                       required="required">
                                            </div>
                                        </div>

                                        <div class="col-12 text-center">

                                            <button class="btn btn-primary me-sm-3 me-1 btn-submit" id="create_new">Enregistrer</button>

                                            <button
                                                type="reset"
                                                class="btn btn-label-secondary"
                                                data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Annuler
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
        //Initialisation des variable Quill
        var objectif_pedagogique_fiche_agre = new Quill('#objectif_pedagogique_fiche_agre',{theme: 'snow'});

        //Hide All fields
        $("#objectif_pedagogique_fiche_agre_val").hide();

        var planForm = $("#planForm");
        function changeFunction() {
            var selectBox = document.getElementById("id_type_formation");
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;

            $.get('/caracteristiqueTypeFormationlist/'+selectedValue, function (data) {
                //alert(data); //exit;
                $('#id_caracteristique_type_formation').empty();
                $.each(data, function (index, tels) {
                    $('#id_caracteristique_type_formation').append($('<option>', {
                        value: tels.id_caracteristique_type_formation,
                        text: tels.libelle_ctf,
                    }));
                });
            });

            if(selectedValue == 3){
                document.getElementById("Activeajoutercabinetformation").disabled = true;
                $.get('/entrepriseinterneplan', function (data) {
                    //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
                    });
                });
            }

            if(selectedValue == 1 || selectedValue ==2 || selectedValue == 5){
                document.getElementById("Activeajoutercabinetformation").disabled = true;
                $.get('/entreprisecabinetformation', function (data) {
                    //alert(data); //exit;
                    $('#id_entreprise_structure_formation_plan_formation').empty();
                    $.each(data, function (index, tels) {
                        $('#id_entreprise_structure_formation_plan_formation').append($('<option>', {
                            value: tels.id_entreprises,
                            text: tels.raison_social_entreprises,
                        }));
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
                    });
                });
            }
        }

        planForm.onsubmit = function(){
            $("#objectif_pedagogique_fiche_agre_val").val(objectif_pedagogique_fiche_agre.root.innerHTML);
        }
    </script>

@endsection

