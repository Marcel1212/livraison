<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;
use App\Helpers\Menu;

$codeRoles = Menu::get_code_menu_profil(Auth::user()->id);

//dd($codeRoles);
//dd($habilitation->flag_reception_demande_habilitation);

?>

@if(auth()->user()->can('traitementautredemandehabilitation-edit'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Habilitation')
    @php($titre='Liste des demandes habilitation')
    @php($soustitre='Demande d\'habilitation')
    @php($lien='traitementautredemandehabilitation')

    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
    </h5>




    <div class="content-body">
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


                        <div class="col-xl-12">
                        <h6 class="text-muted"></h6>
                        <div class="nav-align-top nav-tabs-shadow mb-4">
                            <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link <?php if($idetape==1){ echo "active";} ?>"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-informationentreprise"
                                aria-controls="navs-top-informationentreprise"
                                aria-selected="true">
                                Informations sur l'entreprise
                                </button>
                            </li>
                                @if ($codeRoles == 'CHEFSERVICE'

                                )
                                <li class="nav-item">
                                    <button
                                    type="button"
                                    class="nav-link"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-top-demande"
                                    aria-controls="navs-top-demande"
                                    aria-selected="false">
                                    Information sur la demande
                                    </button>
                                </li>
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#navs-top-traitement"
                                            aria-controls="navs-top-traitement"
                                            aria-selected="false">
                                            Imputation
                                        </button>
                                    </li>
                            @endif

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade <?php if($idetape==1){ echo "show active";}  ?>" id="navs-top-informationentreprise" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>N° de compte contribuable (NCC) </label>
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                            value="{{@$infoentreprise->ncc_entreprises}}" disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Secteur activité </label>
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
                                                    <label>Adresse postal </label>
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
                                                            value="{{@$infoentreprise->tel_entreprises}}" name="tel_entreprises" disabled="disabled">
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

                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Latitude </label> <br>
                                                    <input type="text" name="latitude_entreprises" id="latitude_entreprises"
                                                    class="form-control form-control-sm"
                                                        value="{{@$infoentreprise->latitude_entreprises}}" disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Longitude </label> <br>
                                                    <input type="text" name="longitude_entreprises" id="longitude_entreprises"
                                                    class="form-control form-control-sm"
                                                        value="{{@$infoentreprise->longitude_entreprises}}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Nom et prénoms du responsable <strong style="color:red;">*</strong> </label>
                                                    <input disabled type="text" name="nom_responsable_demande_habilitation" id="nom_responsable_demande_habilitation"
                                                        class="form-control form-control-sm"  value="{{ $habilitation->nom_responsable_demande_habilitation }}">
                                                </div>
                                                @error('nom_responsable_demande_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Fonction du responsable  <strong style="color:red;">*</strong> </label>
                                                    <input disabled type="text" name="fonction_demande_habilitation" id="fonction_demande_habilitation"
                                                        class="form-control form-control-sm"  value="{{ $habilitation->fonction_demande_habilitation }}">
                                                </div>
                                                @error('fonction_demande_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Email professionnel du responsable  <strong style="color:red;">*</strong> </label>
                                                    <input disabled type="text" name="email_responsable_habilitation" id="email_responsable_habilitation"
                                                        class="form-control form-control-sm"  value="{{ $habilitation->email_responsable_habilitation }}">
                                                </div>
                                                @error('email_responsable_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Contact du responsable  <strong style="color:red;">*</strong> </label>
                                                    <input disabled type="text" name="contact_responsable_habilitation" id="contact_responsable_habilitation"
                                                        class="form-control form-control-sm"  value="{{ $habilitation->contact_responsable_habilitation }}">
                                                </div>
                                                @error('contact_responsable_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <label class="form-label" for="billings-country">Titre ou Contrat de bail <strong style="color:red;">*</strong></label>
                                                <br>
                                                <span class="badge bg-secondary">
                                                        <a target="_blank"
                                                           onclick="NewWindow('{{ asset("/pieces/titre_propriete_contrat_bail/". $habilitation->titre_propriete_contrat_bail)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce
                                                        </a>
                                                    </span>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Maison mere ou tutelle <strong style="color:red;">(s'il y a lieu)</strong> </label>
                                                    <input  disabled type="text" name="maison_mere_demande_habilitation" id="maison_mere_demande_habilitation"
                                                        class="form-control form-control-sm" value="{{ $habilitation->maison_mere_demande_habilitation }}"/>
                                                </div>
                                                @error('maison_mere_demande_habilitation')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label"  for="billings-country">Agence domiciliation <strong style="color:red;">*</strong></label>
                                                <select disabled class="select2 form-select-sm input-group @error('id_banque')
                                                    error
                                                    @enderror" data-allow-clear="true" name="id_banque">
                                                    <?= $banque; ?>
                                                </select>
                                                @error('id_banque')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <label class="form-label" for="billings-country">Type entreprise <strong style="color:red;">*</strong></label>
                                                <select disabled class="select2 form-select-sm input-group @error('flag_ecole_autre_entreprise')
                                                    error
                                                    @enderror" data-allow-clear="true" name="flag_ecole_autre_entreprise" id="flag_ecole_autre_entreprise">
                                                    <option value="">---Choix du type entreprise--</option>
                                                    <option value="true" @if($habilitation->flag_ecole_autre_entreprise == true ) selected @endif>Ecoles</option>
                                                    <option value="false" @if($habilitation->flag_ecole_autre_entreprise == false ) selected @endif>Autres</option>
                                                </select>
                                            </div>

                                        </div>

                                </div>

                                @if ($codeRoles == 'CHEFSERVICE'

                                )

                                    <div class="tab-pane fade" id="navs-top-demande" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-1">
                                                                <label> Type de demande <strong
                                                                        style="color:red;">*</strong></label>
                                                                <input class="form-control" type="text" disabled
                                                                    @if(@$autre_demande_habilitation_formation->type_autre_demande=='demande_suppression')
                                                                       value=" Demande de suppression"
                                                                    @elseif(@$autre_demande_habilitation_formation->type_autre_demande=='demande_extension')
                                                                           value=" Demande d'extension"

                                                                    @endif >
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="mb-1">
                                                                <label> Domaines de formation <strong
                                                                        style="color:red;">*</strong></label>
                                                                <select
                                                                    class="select2 form-control form-select-sm input-group"
                                                                    disabled
                                                                    required multiple  data-allow-clear="true" name="id_domaine_demande_habilitation[]" id="id_domaine_demande_habilitation" >
                                                                    @foreach($domaineDemandeHabilitations as $domaineDemandeHabilitation)
                                                                        <option value="{{$domaineDemandeHabilitation->id_domaine_demande_habilitation}}"

                                                                                @foreach($autre_demande_habilitation_formation->domaineAutreDemandeHabilitationFormations as $domaine)
                                                                                    @if($domaine->id_domaine_demande_habilitation == $domaineDemandeHabilitation->id_domaine_demande_habilitation)
                                                                                        selected
                                                                            @endif
                                                                            @endforeach
                                                                        >{{$domaineDemandeHabilitation->typeDomaineDemandeHabilitation->libelle_type_domaine_demande_habilitation}} /
                                                                            {{ $domaineDemandeHabilitation->typeDomaineDemandeHabilitationPublic->libelle_type_domaine_demande_habilitation_public }} /
                                                                            {{ $domaineDemandeHabilitation->domaineFormation->libelle_domaine_formation }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-1">
                                                                <label> Motif <strong
                                                                        style="color:red;">*</strong></label>
                                                                <select
                                                                    class="select2 form-select-sm input-group" required  data-allow-clear="true"
                                                                    disabled

                                                                    name="id_motif_autre_demande_habilitation_formation" id="id_motif_autre_demande_habilitation_formation" >
                                                                    <option value="">Selectionner un motif</option>
                                                                    @foreach($motifs as $motif)

                                                                        <option value="{{$motif->id_motif}}"
                                                                                @if(@$autre_demande_habilitation_formation->id_motif_autre_demande_habilitation_formation==@$motif->id_motif)
                                                                                    selected
                                                                            @endif >{{$motif->libelle_motif}}</option>

                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 ">
                                                            <label class="form-label">Pièce justificative <strong
                                                                    style="color:red;">*</strong></label>
                                                            <div>
                                                    <span class="badge bg-secondary mt-2">
                                                                <a target="_blank"
                                                                   onclick="NewWindow('{{ asset("pieces/demande_suppression_domaine/". $autre_demande_habilitation_formation->piece_autre_demande_habilitation_formation)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                                    Voir la pièce
                                                                </a>
                                                            </span>
                                                            </div>

                                                            <div id="defaultFormControlHelp" class="form-text ">
                                                                <em> Fichiers autorisés : PDF, JPG, JPEG, PNG <br>Taille
                                                                    maxi : 5Mo</em>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-12 col-12">
                                                            <div class="mb-1">
                                                                <label>Commentaire de la demande de suppression <strong
                                                                        style="color:red;">*</strong></label>
                                                                <textarea class="form-control form-control-sm" disabled required

                                                                          name="commentaire_autre_demande_habilitation_formation"
                                                                          id="commentaire_autre_demande_habilitation_formation" rows="7">{{@$autre_demande_habilitation_formation->commentaire_autre_demande_habilitation_formation}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                    </div>
                                    <div class="tab-pane fade show active" id="navs-top-traitement" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <form method="POST" class="form" action="{{ route($lien.'.updateaffectation', [\App\Helpers\Crypt::UrlCrypt($autre_demande_habilitation_formation->id_autre_demande_habilitation_formation)]) }}">
                                                        @csrf
                                                        @method('put')
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-12">
                                                                        <label class="form-label" for="billings-country">Charge d'habilitation <strong style="color:red;">*</strong></label>
                                                                        <select @if($autre_demande_habilitation_formation->flag_soumis_cs==true)
                                                                                    disabled
                                                                                @endif class="select2 form-select-sm input-group @error('id_charge_habilitation')
                                                                                    error
                                                                                    @enderror" @if($autre_demande_habilitation_formation->flag_soumis_cs==true)
                                                                                    disabed
                                                                                @endif data-allow-clear="true" name="id_charge_habilitation">

                                                                                <?= $chargerHabilitationsList; ?>
                                                                        </select>
                                                                        @error('id_charge_habilitation')
                                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-12 col-12">
                                                                        <div class="mb-1">
                                                                            <label>Commentaire  <strong style="color:red;">*</strong></label>
                                                                            <textarea

                                                                                @if($autre_demande_habilitation_formation->flag_soumis_cs==true)
                                                                                    disabled
                                                                                @endif

                                                                                rows="3" class="form-control @error('commentaire_cs') error @enderror" name="commentaire_cs">{{@$autre_demande_habilitation_formation->commentaire_cs}}</textarea>
                                                                        </div>
                                                                        @error('commantaire_cs')
                                                                        <div class=""><label class="error">{{ $message }}</label></div>
                                                                        @enderror
                                                                    </div>

                                                                </div>
                                                            </div>


                                                            <div class="col-12" align="right">
                                                                <hr>

                                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                                    Retour</a>

                                                                @if($autre_demande_habilitation_formation->flag_soumis_cs==false)
                                                                    <button type="submit" name="action" value="imputer"
                                                                            onclick='javascript:if (!confirm("Voulez-vous imputer cette demande de suppression ?")) return false;'
                                                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                                        Imputer
                                                                    </button>
                                                                @endif



                                                            </div>
                                                        </div>
                                                        <br/>
                                                    </form>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <table class="table table-bordered table-striped table-hover table-sm"
                                                       id=""
                                                       style="margin-top: 13px !important">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Chargés habilitations </th>
                                                        <th>Dossiers en cours</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php $i=0; ?>
                                                    @foreach ($NombreDemandeHabilitation as $key => $nbre)
                                                        <tr>
                                                            <td>{{ ++$i }}</td>
                                                            <td>{{  @$nbre->name }} {{  @$nbre->prenom_users }}</td>
                                                            <td>{{  @$nbre->nbre_dossier_en_cours }} </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                    </div>
                                        <?php //} ?>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>


        <!-- END: Content-->

        @endsection

        @section('js_perso')

            <script>
                                        $("#dernier_catalogue_demande_habilitation_div").show();

                                        $("#autre_activite_demande_habilitation_div").show();

                $('#information_catalogue_demande_habilitation').on('change', function (e) {
                    if(e.target.value=='true'){
                        $("#dernier_catalogue_demande_habilitation_div").show();
                    }
                    if(e.target.value=='false'){
                        $("#dernier_catalogue_demande_habilitation_div").hide();
                    }
                });

                $('#information_seul_activite_demande_habilitation').on('change', function (e) {
                    if(e.target.value=='false'){
                        $("#autre_activite_demande_habilitation_div").show();
                    }
                    if(e.target.value=='true'){
                        $("#autre_activite_demande_habilitation_div").hide();
                    }
                });

                //Select2 banque
                $("#id_banque").select2().val({{old('id_banque')}});

                var experience_formateur = new Quill('#experience_formateur', {
                    theme: 'snow'
                });

                $("#experience_formateur_val").hide();

                var formformateur = document.getElementById("formformateur");


                formformateur.onsubmit = function(){
                    $("#experience_formateur_val").val(experience_formateur.root.innerHTML);
                 }


                var materiel_didactique_demande_habilitation = new Quill('#materiel_didactique_demande_habilitation', {
                    theme: 'snow'
                });

                $("#materiel_didactique_demande_habilitation_val").hide();

                var reference_ci_demande_habilitation = new Quill('#reference_ci_demande_habilitation', {
                    theme: 'snow'
                });

                $("#reference_ci_demande_habilitation_val").hide();

                var autre_activite_demande_habilitation = new Quill('#autre_activite_demande_habilitation', {
                    theme: 'snow'
                });

                $("#autre_activite_demande_habilitation_val").hide();

                var formdivers = document.getElementById("Diversformateur");

                formdivers.onsubmit = function(){
                    $("#materiel_didactique_demande_habilitation_val").val(materiel_didactique_demande_habilitation.root.innerHTML);
                    $("#reference_ci_demande_habilitation_val").val(reference_ci_demande_habilitation.root.innerHTML);
                    $("#autre_activite_demande_habilitation_val").val(autre_activite_demande_habilitation.root.innerHTML);
                 }


                var quel_financement_intervention_hors_ci = new Quill('#quel_financement_intervention_hors_ci', {
                    theme: 'snow'
                });

                $("#quel_financement_intervention_hors_ci_val").hide();

                var formInterventionHorsCi = document.getElementById("formInterventionHorsCi");


                formInterventionHorsCi.onsubmit = function(){
                    $("#quel_financement_intervention_hors_ci_val").val(quel_financement_intervention_hors_ci.root.innerHTML);
                 }

                 var commantaire_cs = new Quill('#commantaire_cs', {
                    theme: 'snow'
                });

                $("#commantaire_cs_val").hide();

                var formAttribution = document.getElementById("formAttribution");


                formAttribution.onsubmit = function(){
                    $("#commantaire_cs_val").val(commantaire_cs.root.innerHTML);
                 }

                 var idactivesmoussion = $('#colorCheck1').prop('checked', false);


                function myFunctionMAJ() {
                    // Get the checkbox
                    var checkBox = document.getElementById("colorCheck1");

                    // If the checkbox is checked, display the output text
                    if (checkBox.checked == true){
                        $("#Enregistrer_soumettre_demande_habilitation").prop( "disabled", false );
                    } else {
                        $("#Enregistrer_soumettre_demande_habilitation").prop( "disabled", true );
                    }
                }


            </script>


        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
