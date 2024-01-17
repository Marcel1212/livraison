@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'Projet d\'etudes')
    @php($titre = 'Information du projet d\'etude')
    @php($soustitre = 'Ajouter un projet etude ')
    @php($lien = 'selectionoperateurprojetetude')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <h5 class="py-2 mb-1">
                <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
                {{ $titre }}
            </h5>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($message = Session::get('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        {{ $message }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                                            <div class="card accordion-item active">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button type="button" class="accordion-button"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionOne"
                                                            aria-expanded="true" aria-controls="accordionOne">
                                                        Details de l'entreprise
                                                    </button>
                                                </h2>

                                                <div id="accordionOne" class="accordion-collapse collapse show"
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
                                            <div class="card accordion-item">
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
                                    <div class="row">

                                        <div class="card-body mt-3">
                                            @isset($projet_etude_valide->flag_soumis_selection_operateur)
                                                @if($projet_etude_valide->flag_soumis_selection_operateur==true && $projet_etude_valide->flag_selection_operateur_valider_par_processus==true)
                                                    <form action="{{route($lien.'.mark',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude_valide->id_projet_etude)])}}" method="post">
                                                        @method('put')
                                                        @csrf
                                                        @else
                                                            <form action="{{route($lien.'.update',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude_valide->id_projet_etude)])}}" method="post">
                                                                @csrf
                                                @endif
                                            @else
                                                    <form action="{{route($lien.'.update',['id_projet_etude'=>\App\Helpers\Crypt::UrlCrypt($projet_etude_valide->id_projet_etude)])}}" method="post">
                                                                @csrf
                                            @endisset
                                                                <h5 class="card-title" align="center"> Sélection des opérateurs pour le projet d'étude</h5>
                                                                <br>
                                                                <div class="row">
                                                                    <label class="form-label">Opérateurs  <strong style="color:red;">*</strong></label>
                                                                    @isset($projet_etude_valide->flag_soumis_selection_operateur)
                                                                        @if($projet_etude_valide->flag_soumis_selection_operateur==true &&
                                                                            $projet_etude_valide->flag_selection_operateur_valider_par_processus==true)
                                                                            @isset($projet_etude_valide->operateurs)


                                                                                <table class="table table-bordered table-striped  table-sm" style="margin-top: 13px !important">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>No</th>
                                                                                        <th>Localité </th>
                                                                                        <th>NCC </th>
                                                                                        <th>Raison sociale </th>
                                                                                        <th>Action </th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach ($projet_etude_valide->operateurs as $key => $operateur)
                                                                                        <tr class="@isset($projet_etude_valide->id_operateur_selection)
                                                                                                @if($projet_etude_valide->id_operateur_selection==$operateur->id_entreprises)
                                                                                                    bg-success text-white
                                                                                            @endif
                                                                                            @endisset">
                                                                                            <td>{{ $key+1 }}</td>
                                                                                            <td>@isset($operateur->localite) {{ $operateur->localite->libelle_localite }} @endisset</td>
                                                                                            <td>{{ $operateur->ncc_entreprises }}</td>
                                                                                            <td>{{ $operateur->raison_social_entreprises }}</td>
                                                                                            <td>
                                                                                                <input type="radio" id="operateur" name="operateur" value="{{$operateur->id_entreprises}}"
                                                                                                    @isset($projet_etude_valide->id_operateur_selection)
                                                                                                        disabled
                                                                                                            @if($projet_etude_valide->id_operateur_selection==$operateur->id_entreprises)
                                                                                                                checked
                                                                                                            @endif
                                                                                                        @endisset


                                                                                                    />
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    </tbody></table>
                                                                            @endisset
                                                                        @elseif($projet_etude_valide->flag_soumis_selection_operateur==false && $projet_etude_valide->flag_selection_operateur_valider_par_processus==false)
                                                                            @isset($operateurs)
                                                                                <select class="select2 form-select-sm input-group" name="operateurs[]"
                                                                                        data-maximum-selection-length="5" data-allow-clear="true" multiple>
                                                                                    @foreach($operateurs as $operateur)
                                                                                        <option value="{{$operateur->id_entreprises}}"
                                                                                                @isset($projet_etude_valide->operateurs)
                                                                                                    @foreach($projet_etude_valide->operateurs as $operateur_projet)
                                                                                                        @if($operateur_projet->id_entreprises == $operateur->id_entreprises)
                                                                                                            selected
                                                                                            @endif
                                                                                            @endforeach
                                                                                            @endisset

                                                                                        >{{$operateur->raison_social_entreprises}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            @endisset
                                                                        @elseif($projet_etude_valide->flag_soumis_selection_operateur==true && $projet_etude_valide->flag_selection_operateur_valider_par_processus==false)
                                                                            <select class="select2 form-select-sm input-group" disabled name="operateurs[]"
                                                                                    data-maximum-selection-length="5" data-allow-clear="true" multiple>
                                                                                @foreach($operateurs as $operateur)
                                                                                    <option value="{{$operateur->id_entreprises}}"
                                                                                            @isset($projet_etude_valide->operateurs)
                                                                                                @foreach($projet_etude_valide->operateurs as $operateur_projet)
                                                                                                    @if($operateur_projet->id_entreprises == $operateur->id_entreprises)
                                                                                                        selected
                                                                                        @endif
                                                                                        @endforeach
                                                                                        @endisset

                                                                                    >{{$operateur->raison_social_entreprises}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        @endif

                                                                    @else
                                                                        @isset($operateurs)
                                                                            <select class="select2 form-select-sm input-group" name="operateurs[]"
                                                                                    data-maximum-selection-length="5" data-allow-clear="true" multiple>
                                                                                @foreach($operateurs as $operateur)
                                                                                    <option value="{{$operateur->id_entreprises}}"
                                                                                            @isset($projet_etude_valide->operateurs)
                                                                                                @foreach($projet_etude_valide->operateurs as $operateur_projet)
                                                                                                    @if($operateur_projet->id_entreprises == $operateur->id_entreprises)
                                                                                                        selected
                                                                                        @endif
                                                                                        @endforeach
                                                                                        @endisset

                                                                                    >{{$operateur->raison_social_entreprises}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        @endisset
                                                                    @endif

                                                                </div>
                                                                <div class="col-12" align="left">
                                                                    <br>
                                                                    <div class="col-12" align="right">
                                                                        @isset($projet_etude_valide->flag_soumis_selection_operateur)
                                                                            @if($projet_etude_valide->flag_soumis_selection_operateur==false && $projet_etude_valide->flag_selection_operateur_valider_par_processus==false)
                                                                                <button
                                                                                    onclick='javascript:if (!confirm("Voulez-vous soumettre la sélection de ces opérateurs au chef de service ? . Cette action est irreversible")) return false;'
                                                                                    type="submit" name="action" value="Enregistrer_soumettre_selection"
                                                                                    class="btn btn-sm btn-success me-sm-3 me-1">Soumettre la sélection
                                                                                </button>
                                                                                <button type="submit"
                                                                                        name="action" value="Enregistrer_selection"
                                                                                        class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">
                                                                                    Modifier
                                                                                </button>
                                                                            @elseif($projet_etude_valide->flag_soumis_selection_operateur==true && $projet_etude_valide->flag_selection_operateur_valider_par_processus==true)
                                                                               @if(!isset($projet_etude_valide->id_operateur_selection))
                                                                                    <button
                                                                                        onclick='javascript:if (!confirm("Voulez-vous selectionner cet opérateur comme opérateur final pour ce projet ? . Cette action est irreversible")) return false;'
                                                                                        type="submit" name="action" value="Enregistrer_soumettre_selection"
                                                                                        class="btn btn-sm btn-success me-sm-3 me-1">Sélection opérateur
                                                                                    </button>
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            <button type="submit"
                                                                                    name="action" value="Enregistrer_selection"
                                                                                    class="btn btn-sm btn-primary me-sm-3 me-1 waves-effect waves-float waves-light">
                                                                                Enregistrer
                                                                            </button>
                                                                        @endisset

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
        </div>
    </div>
    <!-- END: Content-->
@endsection


