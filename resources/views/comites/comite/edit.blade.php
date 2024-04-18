<?php

?>
<?php

use App\Helpers\AnneeExercice;
use Carbon\Carbon;
$anneexercice = AnneeExercice::get_annee_exercice();
$dateday = Carbon::now()->format('d-m-Y');
$actifsoumission = false;

if (isset($anneexercice->id_periode_exercice)) {
    $actifsoumission = true;
} else {
    $actifsoumission = false;
}

if (!empty($anneexercice->date_prolongation_periode_exercice)) {
    $dateexercice = $anneexercice->date_prolongation_periode_exercice;
    if ($dateday <= $dateexercice) {
        $actifsoumission = true;
    } else {
        $actifsoumission = false;
    }
}

?>
@if (auth()->user()->can('comites-edit'))
    @extends('layouts.backLayout.designadmin')

    @section('content')
        @php($Module = 'Comités')
        @php($titre = 'Liste des comités')
        @php($soustitre = 'Tenue de comité')
        @php($lien = 'comites')
        @php($lienacceuil = 'dashboard')


        <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light"> <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i> Accueil
                </a> / {{ $Module }} / <a href="/{{ $lien }}"> {{ $titre }}</a> / </span>
            {{ $soustitre }}
        </h5>




        <div class="content-body">
            @if (!isset($anneexercice->id_periode_exercice))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <div class="alert-body" style="text-align:center">
                        {{ $anneexercice }}
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

            @if ($errors->any())
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
            <div class="col-xl-12">
                <h6 class="text-muted"></h6>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 1) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-planformation" aria-controls="navs-top-planformation"
                                aria-selected="true">
                                Comité
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 2) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-categorieplan" aria-controls="navs-top-categorieplan"
                                aria-selected="false">
                                Liste des cahiers
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 3) {
                                echo 'active';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-actionformation" aria-controls="navs-top-actionformation"
                                aria-selected="false">
                                Liste des participants
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link <?php if ($idetape == 4) {
                                echo 'active';
                            } else {
                                echo 'disabled';
                            } ?>" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-cahieraprescomite" aria-controls="navs-top-cahieraprescomite"
                                aria-selected="false">
                                Valider le comité
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if ($idetape == 1) {
                            echo 'show active';
                        } //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-planformation" role="tabpanel">
                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <label>Type de comité <strong style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select @error('id_categorie_comite')
                                        error
                                        @enderror"
                                            data-allow-clear="true" name="id_categorie_comite" id="id_categorie_comite" />
                                        <?php echo $typecomitesListe; ?>
                                        </select>
                                        @error('id_categorie_comite')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <label>Liste des processus <strong style="color:red;">*</strong></label>
                                        <select
                                            class="select2 form-select @error('id_processus_comite')
                                        error
                                        @enderror"
                                            data-allow-clear="true" name="id_processus_comite[]" id="id_processus_comite"
                                            multiple>
                                            <?php echo $processuscomitesListe; ?>
                                        </select>
                                        @error('id_processus_comite')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="mb-1">
                                            <label>Liste des processus <strong style="color:red;">*</strong></label>
                                            @foreach ($processuscomite as $pc)
                                                <input type="text" name="" class="form-control form-control-sm"
                                                    value="{{ $pc->processusComite->libelle_processus_comite }}"
                                                    disabled />
                                            @endforeach

                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="mb-1">
                                            <label>Date de debut <strong style="color:red;">*</strong></label>
                                            <input type="date" name="date_debut_comite"
                                                class="form-control form-control-sm"
                                                value="{{ $comite->date_debut_comite }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="mb-1">
                                            <label>Date de fin </label>
                                            <input type="date" name="date_fin_comite"
                                                class="form-control form-control-sm"
                                                value="{{ $comite->date_fin_comite }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control form-control-sm" name="commentaire_comite" id="commentaire_comite" rows="6">{{ $comite->commentaire_comite }}</textarea>

                                        </div>
                                    </div>


                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if($comite->flag_statut_comite == false){?>
                                        <button type="submit" name="action" value="Modifier"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Modifier
                                        </button>
                                        <?php } ?>
                                        <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                            class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>

                                            <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                href="/{{ $lien }}">
                                                Retour</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade <?php if ($idetape == 2) {
                            echo 'show active';
                        } //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-categorieplan" role="tabpanel">
                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <?php if(count($demandes)>0){ ?>
                                <div class="col-12" align="right">
                                    <button type="submit" name="action" value="creer_cahier_plans_projets"
                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                        Ajouter au cahier
                                    </button>
                                </div>
                                <?php } ?>

                                <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                                    style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th><label>Cocher tout</label><br /><input type="checkbox" id="allcb"
                                                    name="allcb" /></th>
                                            <th>Type processus </th>
                                            <th>Code du cahier </th>
                                            <th>Date creation </th>
                                            <th>Date de soumission a la commission</th>
                                            <th>Commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php //dd($planformations);
                                        $i = 0; ?>
                                        @foreach ($demandes as $key => $demande)
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                        value="<?php echo $demande->id_cahier_plans_projets; ?>/<?php echo $demande->code_pieces_cahier_plans_projets; ?>"
                                                        name="demande[<?php echo $demande->id_cahier_plans_projets; ?>]"
                                                        id="demande<?php echo $demande->id_cahier_plans_projets; ?>" />
                                                </td>
                                                <td>
                                                    @if ($demande->code_pieces_cahier_plans_projets == 'PF')
                                                        PLAN DE FORMATION
                                                    @endif
                                                    @if ($demande->code_pieces_cahier_plans_projets == 'PE')
                                                        PROJET ETUDE
                                                    @endif
                                                    @if ($demande->code_pieces_cahier_plans_projets == 'PRF')
                                                        PROJET DE FORMATION
                                                    @endif
                                                </td>
                                                <td>{{ @$demande->code_cahier_plans_projets }}</td>
                                                <td>{{ @$demande->date_creer_cahier_plans_projets }}</td>
                                                <td>{{ @$demande->date_soumis_cahier_plans_projets }}</td>
                                                <td>{{ $demande->commentaire_cahier_plans_projets }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                            <div class="col-12" align="right">
                                <hr>

                                <?php //if (count($comitegestionparticipant)>=1){
                                ?>


                                <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                    class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>
                                    <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                        class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


                                        <?php //}
                                        ?>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                            </div>
                        </div>
                        <div class="tab-pane fade <?php if ($idetape == 3) {
                            echo 'show active';
                        } ?>" id="navs-top-actionformation" role="tabpanel">

                            <?php if ($comite->flag_statut_comite != true and count($cahiers)>=1){ ?>
                            <form method="post" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <label class="form-label" for="id_user_comite_participant">Personnes ressources
                                            <strong style="color:red;">*</strong></label>
                                        <select id="id_user_comite_participant" name="id_user_comite_participant[]"
                                            class="select2 form-select-sm input-group" aria-label="Default select example"
                                            multiple>
                                            <?= $personneressource ?>
                                        </select>
                                    </div>



                                    <div class="col-12 col-md-4" align="right"> <br>
                                        <button type="submit" name="action"
                                            value="Enregistrer_persone_ressource_pour_comite"
                                            class="btn btn-sm btn-primary me-sm-3 me-1"
                                            onclick='javascript:if (!confirm("Voulez-vous ajouter ces personnes à la commission ?")) return false;'>Ajouter</button>

                                        @if (count($comiteparticipants) >= 1)
                                            <button type="submit" name="action" value="Invitation_personne_ressouce"
                                                class="btn btn-sm btn-success me-sm-3 me-1"
                                                onclick='javascript:if (!confirm("Voulez-vous envoyer les invitations a ces personnes pour cette commission ?")) return false;'>Envoyer
                                                les invitations</button>
                                        @endif
                                    </div>

                                </div>

                            </form>

                            <hr>
                            <?php } ?>

                            <table class="table table-bordered table-striped table-hover table-sm" id=""
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Profil</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($comiteparticipants as $key => $comiteparticipant)
                                        <?php $i += 1; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $comiteparticipant->name }}</td>
                                            <td>{{ $comiteparticipant->prenom_users }}</td>
                                            <td>{{ $comiteparticipant->profile }}</td>
                                            <td>
                                                <?php if ($comite->flag_statut_comite != true){ ?>
                                                <a href="{{ route($lien . '.delete', \App\Helpers\Crypt::UrlCrypt($comiteparticipant->id_comite_participant)) }}"
                                                    class=""
                                                    onclick='javascript:if (!confirm("Voulez-vous supprimer cette personne de cette commission ?")) return false;'
                                                    title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <div class="col-12" align="right">

                                <hr>

                                <?php //if (count($comitegestionparticipant)>=1){
                                ?>


                                <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                    class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>
                                    <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                        class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</button>


                                        <?php //}
                                        ?>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                            href="/{{ $lien }}">
                                            Retour</a>
                            </div>

                        </div>

                        <div class="tab-pane fade<?php if ($idetape == 4) {
                            echo 'show active';
                        } //if(count($ficheagrements)>=1 and count($comitegestionparticipant)>=1){ echo "active";} ?>" id="navs-top-cahieraprescomite" role="tabpanel">


                            <?php if ($comite->flag_statut_comite != true and count($cahiers)>=1 and count($comiteparticipants)>=1){ ?>
                            <form method="POST" class="form"
                                action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-12 col-md-10">
                                    </div>
                                    <div class="col-12 col-md-2" align="right"> <br>
                                        <button type="submit" name="action" value="valider_comite_technique"
                                            class="btn btn-sm btn-success me-sm-3 me-1"
                                            onclick='javascript:if (!confirm("Voulez-vous valider le comité ?")) return false;'>Valider
                                            le comité</button>

                                    </div>

                                </div>

                            </form>
                            <?php } ?>

                            <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Type processus </th>
                                        <th>Code du cahier </th>
                                        <th>Date creation </th>
                                        <th>Date de soumission a la commission</th>
                                        <th>Commentaire</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php //dd($planformations);
                                    $i = 0; ?>
                                    @foreach ($listedemandesss as $key => $demande)
                                        <tr>
                                            <td> {{ ++$i }} </td>
                                            <td>
                                                @if ($demande->code_pieces_cahier_plans_projets == 'PF')
                                                    PLAN DE FORMATION
                                                @endif
                                                @if ($demande->code_pieces_cahier_plans_projets == 'PE')
                                                    PROJET ETUDE
                                                @endif
                                                @if ($demande->code_pieces_cahier_plans_projets == 'PRF')
                                                    PROJET DE FORMATION
                                                @endif
                                            </td>
                                            <td>{{ @$demande->code_cahier_plans_projets }}</td>
                                            <td>{{ @$demande->date_creer_cahier_plans_projets }}</td>
                                            <td>{{ @$demande->date_soumis_cahier_plans_projets }}</td>
                                            <td>{{ $demande->commentaire_cahier_plans_projets }}</td>
                                            <td align="center" nowrap="nowrap">
                                                @if ($comite->flag_statut_comite == true)
                                                    <span class="badge bg-success">Traité</span>
                                                @else
                                                    <span class="badge bg-warning">En cours</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="col-12" align="right">

                                <hr>

                                <?php //if (count($comitegestionparticipant)>=1){
                                ?>


                                <a href="{{ route($lien . '.edit', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                    class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>


                                    <?php //}
                                    ?>

                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{ $lien }}">
                                        Retour</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('js_perso')
        <script type="text/javascript">
            $('#allcb').change(function() {
                if ($(this).prop('checked')) {
                    $('tbody tr td input[type="checkbox"]').each(function() {
                        $(this).prop('checked', true);
                    });
                } else {
                    $('tbody tr td input[type="checkbox"]').each(function() {
                        $(this).prop('checked', false);
                    });
                }
            });
        </script>

        <script language="javascript">
            function bloquerFormulaire(form) {
                // On verrouille les éléments
                var els = form.getElementsByTagName('*');
                for (i = 0; i < els.length; i++) {
                    els[i].disabled = 'disabled';
                }

                // On ajoute un message
                var msg = document.createElement('span');
                msg.innerText = 'Envoi en cours, veuillez patienter ...';
                form.appendChild(msg);

                // On verrouille le formulaire lui même
                form.onsubmit = function() {
                    return false;
                }

                // On envoie le formulaire
                return true;
            }
        </script>
    @endsection
@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}"; //here double curly bracket
    </script>
@endif
