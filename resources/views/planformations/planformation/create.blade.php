<?php

use App\Helpers\AnneeExercice;
use App\Helpers\MoyenCotisation;
use App\Helpers\InfosEntreprise;
use App\Helpers\PartEntreprisesHelper;

$anneexercice = AnneeExercice::get_annee_exercice();

$infoentrprise = InfosEntreprise::get_infos_entreprise(Auth::user()->login_users);

//$mttprevisionnelcotisation = MoyenCotisation::get_calcul_moyen_cotisation($infoentrprise->id_entreprises);

$mttprevisionnelcotisation = MoyenCotisation::get_verif_cotisation($infoentrprise->id_entreprises);

//dd($mttprevisionnelcotisation);

$part = PartEntreprisesHelper::get_part_entreprise();
//dd($part->valeur_part_entreprise);
?>

@if(auth()->user()->can('planformation-create'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Demandes')
    @php($titre='Liste des plans de formations')
    @php($soustitre='Demande de plan de formation')
    @php($lien='planformation')

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
        @if(!isset($anneexercice->id_periode_exercice))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body" style="text-align:center">
                    {{$anneexercice}}
                </div>
                <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
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

                    @if($mttprevisionnelcotisation==0)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="alert-body" style="text-align:center">
                              <stong>Attention : </stong>  Pour pouvoir bénéficier de nos services, nous vous prions de bien vouloir vous mettre à jour.
                            </div>
                            <!--<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
                        </div>
                    @else

                    <script type="text/javascript">
                        function FuncCalculPartENtre(valeurpart) {
                            var ValueMS = document.getElementById("masse_salariale").value.replaceAll(' ','');
                            var partEntreprise = ValueMS*valeurpart;
                            document.getElementById('part_entreprise').setAttribute('value', partEntreprise.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, " "));
                        }
                    </script>


                        <div class="col-xl-12">
                        <h6 class="text-muted"></h6>
                        <div class="nav-align-top nav-tabs-shadow mb-4">
                            <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link active"
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
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-actionformation"
                                aria-controls="navs-top-actionformation"
                                aria-selected="false">
                                Nombre de salariés déclarés à la CNPS
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-categoriesprofessionel"
                                aria-controls="navs-top-categoriesprofessionel"
                                aria-selected="false">
                                Actions du plan de formation
                                </button>
                            </li>
                            <!--<li class="nav-item">
                                <button
                                type="button"
                                class="nav-link disabled"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-top-Soumettre"
                                aria-controls="navs-top-Soumettre"
                                aria-selected="false">
                                Soumisssion du plan de formation
                                </button>
                            </li>-->
                            </ul>
                            <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-top-planformation" role="tabpanel">

                                <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                                    @csrf
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

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Type entreprises <strong style="color:red;">*</strong></label> <br>
                                                <select class="select2 form-select-sm form-select" name="id_type_entreprise" id="id_type_entreprise" required="required">
                                                    <?php echo $typeentreprise; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Nom et prénoms du responsable formation <strong style="color:red;">*</strong> </label>
                                                <input type="text" name="nom_prenoms_charge_plan_formati" id="nom_prenoms_charge_plan_formati"
                                                    class="form-control form-control-sm" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Fonction du responsable formation <strong style="color:red;">*</strong> </label>
                                                <input type="text" name="fonction_charge_plan_formation" id="fonction_charge_plan_formation"
                                                    class="form-control form-control-sm" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Email professionnel du responsable formation <strong style="color:red;">*</strong> </label>
                                                <input type="email" name="email_professionnel_charge_plan_formation" id="email_professionnel_charge_plan_formation"
                                                    class="form-control form-control-sm" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Contact du responsable formation <strong style="color:red;">*</strong> </label>
                                                <input type="text" name="contact_professionnel_charge_plan_formation" id="contact_professionnel_charge_plan_formation"
                                                    class="form-control form-control-sm" required="required">
                                            </div>
                                        </div>




                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">

                                                <label>Masse salariale brute annuelle prévisionnelle <strong style="color:red;">*</strong></label>
                                                <input type="text" name="masse_salariale" id="masse_salariale" onkeyup="FuncCalculPartENtre(<?php echo $part->valeur_part_entreprise; ?>);"
                                                    class="form-control form-control-sm number" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Part entreprise ({{ @$planformation->partEntreprise->valeur_part_entreprise }})</label>
                                                <input type="text" name="part_entreprise" id="part_entreprise"
                                                       class="form-control form-control-sm number"
                                                         disabled="disabled">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="mb-1">
                                                <label>Nombre de salariés déclarés à la CNPS <strong style="color:red;">*</strong></label>
                                                <input type="number" class="form-control form-control-sm"  disabled="disabled">
                                            </div>
                                        </div>

                                        <div class="col-12" align="right">
                                            <hr>
                                            <button type="submit" name="action" value="Enregister"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Enregister
                                            </button>
                                            <button type="submit" name="action" value="Enregistrer_suivant"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Suivant
                                            </button>
                                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                Retour</a>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane fade" id="navs-top-actionformation" role="tabpanel">

                            </div>
                            <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">

                            </div>
                            </div>
                        </div>
                        </div>
                    @endif
    </div>

        <!-- END: Content-->

        @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
