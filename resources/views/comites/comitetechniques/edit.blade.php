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
@if (auth()->user()->can('comitetechniques-edit'))
    @extends('layouts.backLayout.designadmin')

    @section('content')
        @php($Module = 'Comites')
        @php($titre = 'Liste des comités techniques')
        @php($soustitre = 'Tenue de comité technique')
        @php($lien = 'comitetechniques')
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
                                Liste des plans/projets
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
                                        <label>Liste des processus choisis</label>
                                        <select
                                            class="select2 form-select @error('id_processus_comite')
                                        error
                                        @enderror"
                                            data-allow-clear="true" name="id_processus_comite" id="id_processus_comite">
                                            <?php echo $processuscomitesListe; ?>
                                        </select>
                                        @error('id_processus_comite')
                                            <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Date de début <strong style="color:red;">*</strong></label>
                                            <input type="date" name="date_debut_comite"
                                                class="form-control form-control-sm"
                                                value="{{ $comite->date_debut_comite }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Date de fin <strong style="color:red;">*</strong></label>
                                            <input type="date" name="date_fin_comite"
                                                class="form-control form-control-sm"
                                                value="{{ $comite->date_fin_comite }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label" for="state">Direction </label> <strong
                                            style="color: red">*</strong>
                                        <select class="select2 form-select" id="direction" name="id_direction" />
                                        <option value='{{ @$directionselection->id_direction }}'>
                                            {{ @$directionselection->libelle_direction }}</option>
                                        @foreach ($directions as $direction)
                                            <option value='{{ $direction->id_direction }}'>
                                                {{ $direction->libelle_direction }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="state">Département</label>
                                        <select class="select2 form-select" id='departement' name='id_departement'
                                            class="form-control">
                                            <option value='{{ @$comite->departement->id_departement }}'>
                                                {{ @$comite->departement->libelle_departement }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-12">
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
                                            class="btn btn-sm btn-primary">Suivant</button>

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
                                <?php if ($comite->flag_statut_comite != true){ ?>
                                <div class="col-12" align="right">
                                    <button type="submit" name="action" value="creer_cahier_plans_projets"
                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                        Ajouter au cahier
                                    </button>
                                </div>
                                <?php } ?>

                                <table class="table table-bordered table-striped table-hover table-sm allcbtable" id="exampleData"
                                    style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th><label>Cocher tout</label><br /><input type="checkbox" id="allcb"
                                                    name="allcb" /></th>
                                            <th>Type processus </th>
                                            <th>Entreprise </th>
                                            <th>Conseiller </th>
                                            <th>Code </th>
                                            <th>Date soumise au FDFP</th>
                                            <th>Date fin instruction</th>
                                            <th>Coût accordé</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php //dd($planformations);
                                        $i = 0; ?>
                                        @foreach ($demandes as $key => $demande)
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                        value="<?php echo $demande->id_demande; ?>/<?php echo $demande->code_processus; ?>"
                                                        name="demande[<?php echo $demande->id_demande; ?>]"
                                                        id="demande<?php echo $demande->id_demande; ?>" />
                                                </td>
                                                <td>
                                                    @if ($demande->code_processus == 'PF')
                                                        PLAN DE FORMATION
                                                    @endif
                                                    @if ($demande->code_processus == 'PE')
                                                        PROJET ETUDE
                                                    @endif
                                                    @if ($demande->code_processus == 'PRF')
                                                        PROJET DE FORMATION
                                                    @endif
                                                    @if ($demande->code_processus == 'HAB')
                                                        HABILITATION
                                                    @endif
                                                </td>
                                                <td>{{ @$demande->raison_sociale }}</td>
                                                <td>{{ @$demande->nom_conseiller }}</td>
                                                <td>{{ @$demande->code }}</td>
                                                <td>{{ $demande->date_demande }}</td>
                                                <td>{{ $demande->date_soumis }}</td>
                                                <td align="rigth">
                                                    {{ number_format($demande->montant_total, 0, ',', ' ') }}</td>
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

                            <?php if ($comite->flag_statut_comite != true ){ ?>
                            <form method="POST" class="form"
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
                                            onclick='javascript:if (!confirm("Voulez-vous ajouter ces personnes a cet CT ?")) return false;'>Ajouter</button>
                                        @if (count($comiteparticipants) >= 1)
                                            <button type="submit" name="action" value="Invitation_personne_ressouce"
                                                class="btn btn-sm btn-success me-sm-3 me-1"
                                                onclick='javascript:if (!confirm("Voulez-vous envoyer les invitations a ces personnes pour cet Ct ?")) return false;'>Envoyer
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
                            <?php if ($comite->flag_statut_comite != true and count($cahiers)>=1){ ?>
                            <form method="POST" class="form"
                            action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt(4)]) }}"
                            enctype="multipart/form-data">

                                @csrf
                                @method('put')

                                    @if(count($listedemandesss) == count($listeavisgoblals))
                                        <div class="row">
                                            <div class="col-12 col-md-10">
                                            </div>
                                            <div class="col-12 col-md-2" align="right"> <br>
                                                <button type="submit" name="action" value="valider_comite_technique"
                                                    class="btn btn-sm btn-success"
                                                    onclick='javascript:if (!confirm("Voulez-vous valider le comité ?")) return false;'>Valider
                                                    le comité</button>

                                            </div>

                                        </div>
                                    @endif


                            <table class="table table-bordered table-striped table-hover table-sm allcttable" id="exampleData"
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Type processus </th>
                                        <th>Entreprise </th>
                                        <th>Conseiller </th>
                                        <th>Code </th>
                                        <th>Date soumise au FDFP</th>
                                        <th>Date fin instruction</th>
                                        <th>Coût accordé</th>
                                        <th>Statut</th>
                                        <th>Avis</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php //dd($planformations);
                                    $i = 0; ?>
                                    @foreach ($listedemandesss as $key => $demande)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($demande->code_processus == 'PF')
                                                    PLAN DE FORMATION
                                                @endif
                                                @if ($demande->code_processus == 'PE')
                                                    PROJET ETUDE
                                                @endif
                                                @if ($demande->code_processus == 'PRF')
                                                    PROJET DE FORMATION
                                                @endif
                                                @if ($demande->code_processus == 'HAB')
                                                    HABILITATION
                                                @endif
                                            </td>
                                            <td>{{ @$demande->raison_sociale }}</td>
                                            <td>{{ @$demande->nom_conseiller }}</td>
                                            <td>{{ @$demande->code }}</td>
                                            <td>{{ $demande->date_demande }}</td>
                                            <td>{{ $demande->date_soumis }}</td>
                                            <td align="rigth">{{ number_format($demande->montant_total, 0, ',', ' ') }}
                                            </td>
                                            <td align="center" nowrap="nowrap">
                                                @if ($comite->flag_statut_comite == true)
                                                    <span class="badge bg-success">Traité</span>
                                                @else
                                                    <span class="badge bg-warning">En cours</span>
                                                @endif
                                            </td>
                                            <td align="center" nowrap="nowrap">
                                                @if (isset($demande->libelle_statut_operation))
                                                    @if ($demande->libelle_statut_operation == "Favorable")
                                                        <span class="badge bg-info">{{ $demande->libelle_statut_operation }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $demande->libelle_statut_operation }}</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-warning">Non traité</span>
                                                @endif
                                            </td>
                                            <td align="center" nowrap="nowrap">
                                                @can($lien . '-edit')
                                                    @if ($demande->code_processus == 'PF')
                                                        <a href="{{ route($lien . '.edit.planformation', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt($demande->id_demande), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                            class=" " title="Modifier"><img
                                                                src='/assets/img/editing.png'></a>
                                                    @endif
                                                    @if($demande->code_processus =='HAB')
                                                        <a onclick="NewWindow('{{ route($lien.".show.ficheanalyse",[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt($demande->id_demande),\App\Helpers\Crypt::UrlCrypt(1)]) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                                            class=" "
                                                            title="Voir la fiche analyse"><img src='/assets/img/eye-solid.png'></a>
                                                        <a href="{{ route($lien.'.edit.habilitation',[\App\Helpers\Crypt::UrlCrypt($comite->id_comite),\App\Helpers\Crypt::UrlCrypt($demande->id_demande),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                            class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                                        <a type="button" class=" aviscomiteHabilitation"
                                                            data-bs-toggle="modal"
                                                            data-id="{{\App\Helpers\Crypt::UrlCrypt($comite->id_comite)}}"
                                                            data-id1="{{\App\Helpers\Crypt::UrlCrypt($demande->id_demande)}}"
                                                            data-id2="{{\App\Helpers\Crypt::UrlCrypt(4)}}"
                                                            href="#"
                                                            title="Avis du comite">
                                                                <img src='/assets/img/pen-to-square-solid.png'>
                                                        </a>
                                                    @endif
                                                    @if ($demande->code_processus == 'PE')
                                                        <a href="{{ route($lien . '.edit.projetetude', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt($demande->id_demande), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                            class=" " title="Modifier"><img
                                                                src='/assets/img/editing.png'></a>
                                                    @endif
                                                    @if ($demande->code_processus == 'PRF')
                                                        <a href="{{ route($lien . '.edit.projetformation', [\App\Helpers\Crypt::UrlCrypt($comite->id_comite), \App\Helpers\Crypt::UrlCrypt($demande->id_demande), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                                            class=" " title="Modifier"><img
                                                                src='/assets/img/editing.png'></a>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </form>
                        <?php }else{ ?>

                            <div class="row">
                                <div class="col-12 col-md-8">
                                </div>
                                <div class="col-12 col-md-4" align="right"> <br>
                                    <a onclick="NewWindow('{{ route($lien.".rapport",\App\Helpers\Crypt::UrlCrypt($comite->id_comite)) }}','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                        class="btn btn-sm btn-success"
                                        title="Rapport validé">Raport du comite pour valider</a>
                                    {{-- <a onclick="NewWindow('','',screen.width*2,screen.height,'yes','center',1);" target="_blank"
                                        class="btn btn-sm btn-danger"
                                        title="Rapport rejeter">Raport du comite pour rejet</a> --}}

                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-hover table-sm allcttable" id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Type processus </th>
                                    <th>Entreprise </th>
                                    <th>Conseiller </th>
                                    <th>Code </th>
                                    <th>Date soumise au FDFP</th>
                                    <th>Date fin instruction</th>
                                    <th>Coût accordé</th>
                                    <th>Statut</th>
                                    <th>Avis</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($listedemandetraiter as $key => $demande)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($demande->code_processus == 'PF')
                                                PLAN DE FORMATION
                                            @endif
                                            @if ($demande->code_processus == 'PE')
                                                PROJET ETUDE
                                            @endif
                                            @if ($demande->code_processus == 'PRF')
                                                PROJET DE FORMATION
                                            @endif
                                            @if ($demande->code_processus == 'HAB')
                                                HABILITATION
                                            @endif
                                        </td>
                                        <td>{{ @$demande->raison_sociale }}</td>
                                        <td>{{ @$demande->nom_conseiller }}</td>
                                        <td>{{ @$demande->code }}</td>
                                        <td>{{ $demande->date_demande }}</td>
                                        <td>{{ $demande->date_soumis }}</td>
                                        <td align="rigth">{{ number_format($demande->montant_total, 0, ',', ' ') }}
                                        </td>
                                        <td align="center" nowrap="nowrap">
                                            @if ($comite->flag_statut_comite == true)
                                                <span class="badge bg-success">Traité</span>
                                            @else
                                                <span class="badge bg-warning">En cours</span>
                                            @endif
                                        </td>
                                        <td align="center" nowrap="nowrap">
                                            @if (isset($demande->libelle_statut_operation))
                                                @if ($demande->libelle_statut_operation == "Favorable")
                                                    <span class="badge bg-info">{{ $demande->libelle_statut_operation }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $demande->libelle_statut_operation }}</span>
                                                @endif
                                            @else
                                                <span class="badge bg-warning">Non traité</span>
                                            @endif
                                        </td>
                                        <td align="center" nowrap="nowrap">

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <?php } ?>

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



            {{-- <div class="modal fade" id="avisGlobalModal" tabindex="-1" role="dialog" aria-labelledby="avisGlobalModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="avisGlobalModalLabel">Avis du Comité</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="avisgobalehabilitation">
                      <!-- Les données seront insérées ici -->
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                  </div>
                </div>
              </div> --}}

        </div>

        <div class="modal fade" id="avisGlobalModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-simple modal-edit-user">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Avis du Comité</h3>
                    <p class="text-muted"></p>
                </div>
                <div class="modal-body" id="avisgobalehabilitation">
                    <!-- Les données seront insérées ici -->
                  </div>
                </div>
            </div>
            </div>
        </div>
    @endsection

    @section('js_perso')
        <script type="text/javascript">
            $('#allcb').change(function() {
                //alert('testdem')
                if ($(this).prop('checked')) {
                    $('.allcbtable > tbody > tr > td > input[type="checkbox"]').each(function() {
                        $(this).prop('checked', true);
                    });
                } else {
                    $('.allcbtable > tbody >  tr > td > input[type="checkbox"]').each(function() {
                        $(this).prop('checked', false);
                    });
                }
            });
        </script>

        <script type="text/javascript">
        $('#allct').change(function() {
            //alert('testct')
            if ($(this).prop('checked')) {
                $('.allcttable > tbody > tr > td > input[type="checkbox"]').each(function() {
                    $(this).prop('checked', true);
                });
            } else {
                $('.allcttable > tbody > tr > td > input[type="checkbox"]').each(function() {
                    $(this).prop('checked', false);
                });
            }
        });


        $(document).on('click', '.aviscomiteHabilitation', function () {
                //alert('alluser')
                var id = $(this).data('id');      // Récupère data-id
                var id1 = $(this).data('id1');    // Récupère data-id1
                var id2 = $(this).data('id2');    // Récupère data-id2
                $.get("{{ url('/') }}/avisglobalcomitetechniquehabilitation/" + id +"/"+ id1 +"/"+ id2, function (data) {
                    $('#avisgobalehabilitation').html(data); // Insère les données dans le corps de la modale
                    $('#avisGlobalModal').modal('show');
                });
            });

        </script>

    @endsection
@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}"; //here double curly bracket
    </script>
@endif
