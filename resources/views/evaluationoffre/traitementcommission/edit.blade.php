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
@if(auth()->user()->can('traitementcomitetechniques-edit'))
    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Comites')
        @php($titre='Liste des commissions')
        @php($soustitre='Traitement des commissions')
        @php($lien='traitementcommissionevaluationoffres')
        @php($lienacceuil='dashboard')


        <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light"> <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i>  Accueil </a> / {{$Module}} / <a
                    href="/{{ $lien }}"> {{$titre}}</a> / </span> {{$soustitre}}
        </h5>
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
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
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
                        <button
                            type="button"
                            class="nav-link @if($idetape==1) active @endif"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-entreprise"
                            aria-controls="navs-top-entreprise"
                            aria-selected="true">
                            Détails de l'entreprise
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link @if($idetape==2) active @endif"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-infoprojetetude"
                            aria-controls="navs-top-infoprojetetude"
                            aria-selected="false">
                            Informations du projet d'étude
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link  @if($idetape==3) active   @endif"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-piecesprojetetude"
                            aria-controls="navs-top-piecesprojetetude"
                            aria-selected="false">
                            Pièces jointes du projet
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link  @if($idetape==4) active @endif"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-notataionevaluation"
                            aria-controls="navs-top-notataionevaluation"
                            aria-selected="false">
                            Traitement

                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade @if($idetape==1) show active @endif" id="navs-top-entreprise"
                         role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>N° de compte contribuable (NCC) <strong style="color:red;">*</strong></label>
                                    <input type="text"
                                           class="form-control form-control-sm"
                                           value="{{@$cahier->projet_etude->entreprise->ncc_entreprises}}"
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Secteur activité <strong style="color:red;">*</strong></label>
                                    <input type="text"
                                           class="form-control form-control-sm"
                                           value="{{@$cahier->projet_etude->entreprise->secteurActivite->libelle_secteur_activite}}"
                                           disabled="disabled">
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Localisation géographique <strong style="color:red;">*</strong></label>
                                    <input type="text" name="localisation_geographique_entreprise"
                                           id="localisation_geographique_entreprise"
                                           class="form-control form-control-sm"
                                           value="{{@$cahier->projet_etude->entreprise->localisation_geographique_entreprise}}"
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Repère d'accès <strong style="color:red;">*</strong></label>
                                    <input type="text" name="repere_acces_entreprises" id="repere_acces_entreprises"
                                           class="form-control form-control-sm"
                                           value="{{@$cahier->projet_etude->entreprise->repere_acces_entreprises}}"
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label>Adresse postal <strong style="color:red;">*</strong></label>
                                    <input type="text" name="adresse_postal_entreprises" id="adresse_postal_entreprises"
                                           class="form-control form-control-sm"
                                           value="{{@$cahier->projet_etude->entreprise->adresse_postal_entreprises}}"
                                           disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Type de forme juridique </label>
                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                    disabled="disabled">
                                                    <?= $formjuridique; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="billings-country">Indicatif</label>
                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                    disabled="disabled">
                                                    <?= $pay; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Téléphone <strong style="color:red;">*</strong>
                                            </label>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   value="{{@@$cahier->projet_etude->entreprise->tel_entreprises}}"
                                                   name="tel_entreprises" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="billings-country">Indicatif</label>
                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                    disabled="disabled">
                                                    <?= $pay; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Cellulaire Professionnelle <strong
                                                    style="color:red;">*</strong> </label>
                                            <input type="number" name="cellulaire_professionnel_entreprises"
                                                   id="cellulaire_professionnel_entreprises"
                                                   class="form-control form-control-sm"
                                                   value="{{@$cahier->projet_etude->entreprise->cellulaire_professionnel_entreprises}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="billings-country">Indicatif</label>
                                            <select class="select2 form-select-sm input-group" data-allow-clear="true"
                                                    disabled="disabled">
                                                    <?= $pay; ?>

                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Fax </label>
                                            <input type="number" name="fax_entreprises" id="fax_entreprises"
                                                   class="form-control form-control-sm"
                                                   value="{{@$cahier->projet_etude->entreprise->fax_entreprises}}"
                                                   disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" align="right">
                                <hr>
                                <a class="btn btn-sm btn-outline-secondary waves-effect  me-sm-3 me-1"
                                   href="/{{$lien }}">Retour</a>
                                <a href="{{ route($lien.'.edit',['id'=>\App\Helpers\Crypt::UrlCrypt($cahier->projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                   class="btn btn-sm btn-primary">Suivant</a>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade @if($idetape==2) show active @endif" id="navs-top-infoprojetetude" role="tabpanel">

                    </div>
                    <div class="tab-pane fade @if($idetape==3) show active @endif" id="navs-top-piecesprojetetude"
                         role="tabpanel">
                        <table class="table table-bordered table-striped table-hover table-sm"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>N°</th>
                                <th>Type de pièce</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pieces_projets as $key => $piece)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        @if($piece->code_pieces=='avant_projet_tdr')
                                            Avant-projet TDR
                                        @endif
                                        @if($piece->code_pieces=='courier_demande_fin')
                                            Courrier de demande de financement
                                        @endif
                                        @if($piece->code_pieces=='offre_technique')
                                            Offre technique
                                        @endif
                                        @if($piece->code_pieces=='offre_financiere')
                                            Offre financière
                                        @endif
                                        @if($piece->code_pieces=='autres_piece')
                                            {{@$piece->intitule_piece}}
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if($piece->code_pieces=='avant_projet_tdr')
                                            <a href="#"
                                               onclick="NewWindow('{{ asset("pieces_projet/avant_projet_tdr/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                               title="Afficher">Aperçu du ficher</a>
                                        @endif
                                        @if($piece->code_pieces=='courier_demande_fin')
                                            <a href="#"
                                               onclick="NewWindow('{{ asset("pieces_projet/courier_demande_fin/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                               title="Afficher">Aperçu du ficher</a>
                                        @endif
                                        @if($piece->code_pieces=='offre_technique')
                                            <a href="#"
                                               onclick="NewWindow('{{ asset("pieces_projet/offre_technique/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                               title="Afficher">Aperçu du ficher</a>
                                        @endif
                                        @if($piece->code_pieces=='offre_financiere')
                                            <a href="#"
                                               onclick="NewWindow('{{ asset("pieces_projet/offre_financiere/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                               title="Afficher">Aperçu du ficher</a>
                                        @endif
                                        @if($piece->code_pieces=='autres_piece')
                                            <a href="#"
                                               onclick="NewWindow('{{ asset("pieces_projet/autres_piece/". $piece->libelle_pieces)}}','',screen.width/2,screen.height,'yes','center',1);"
                                               title="Afficher">Aperçu du ficher</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade @if($idetape==4) show active @endif" id="navs-top-notataionevaluation"
                         role="tabpanel">
                        <?php
                            $values = $cahier->projet_etude->operateurs->count()*$offretechcommissionevalsouscriteres;
                        ?>
                        @if($values==$note_commissions)
                            <form method="post" action="{{route('traitementcommissionevaluationoffres.notation'
                                            ,['id'=>\App\Helpers\Crypt::UrlCrypt($cahier->id_commission_evaluation_offre)])}}">
                                @csrf
                                <div align="right">
                                    <button type="submit" name="action" value="Valider"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                        Valider
                                    </button>
                                  </div>
                            </form>
                        @endif
                        <form action="{{route('traitementcommissionevaluationoffres.notation',['id'=>\App\Helpers\Crypt::UrlCrypt($cahier->id_commission_evaluation_offre)])}}"
                              method="post">
                            @csrf
                            <table class="table table-bordered  table-sm"
                                   style="margin-top: 13px !important">
                                <tbody>
                                    <tr>
                                        <td colspan="2">OPERATEURS</td>
                                        @isset($cahier)
                                            @isset($cahier->projet_etude)
                                                @isset($cahier->projet_etude->operateurs)
                                                    @foreach($cahier->projet_etude->operateurs as $key=>$operateur)
                                                        <td>
                                                            Opérateur {{$key+1}}
                                                            : {{$operateur->raison_social_entreprises}}
                                                        </td>
                                                    @endforeach
                                                @endisset
                                            @endisset
                                        @endisset
                                    </tr>
                                    @isset($offretechcommissionevals)
                                        @foreach($offretechcommissionevals as $libelle=>$offretechcommissioneval_f)
                                            <tr>
                                                <td rowspan="{{@$offretechcommissioneval_f->count()+1}}">{{@$libelle}}
                                                    ( {{@$offretechcommissioneval_f->sum('note_offre_tech_commission_evaluation_offre') }}
                                                    pts)
                                                </td>
                                            </tr>
                                            @isset($offretechcommissioneval_f)
                                                @foreach($offretechcommissioneval_f as $offretechcommissioneval)
                                                    <tr>
                                                        <td>
                                                            {{@$offretechcommissioneval->souscritereevaluationoffretech->libelle_sous_critere_evaluation_offre_tech}}
                                                            ({{@$offretechcommissioneval->note_offre_tech_commission_evaluation_offre}}
                                                            pts)
                                                        </td>
                                                        @isset($cahier)
                                                            @isset($cahier->projet_etude)
                                                                @isset($cahier->projet_etude->operateurs)
                                                                    @foreach($cahier->projet_etude->operateurs as $key=>$operateur)
                                                                        @isset($commissioneparticipant)
                                                                            <td>
                                                                                <input name="note_operations[{{$operateur->id_entreprises}}][{{$offretechcommissioneval->souscritereevaluationoffretech->id_sous_critere_evaluation_offre_tech}}][]" type="number"
                                                                                       min="0"
                                                                                                value="{{@$offretechcommissioneval->noteEvaluationOffre($operateur->id_entreprises,$commissioneparticipant->id_user_commission_evaluation_offre_participant)->note_notation_commission_evaluation_offre_tech}}"
                                                                                       class="form-control form-control-sm"
                                                                                       max="{{$offretechcommissioneval->note_offre_tech_commission_evaluation_offre}}"/>
                                                                            </td>
                                                                         @endisset
                                                                        @endforeach
                                                                @endisset
                                                            @endisset
                                                        @endisset
                                                    </tr>
                                                @endforeach
                                           @endisset
                                        @endforeach
                                   @endisset
                                </tbody>
                            </table>
                        <div class="col-12" align="right">
                            <hr>
                            <button type="submit" name="action" value="Enregistrer"
                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                Enregistrer
                            </button>
                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                Retour</a>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection

@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}";//here double curly bracket
    </script>
@endif
@section('js_perso')
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/additional-methods.js')}}"></script>
    <script type="text/javascript">
        var contexte_probleme_instruction = new Quill('#contexte_probleme_instruction', {
            theme: 'snow'
        });
        var objectif_general_instruction = new Quill('#objectif_general_instruction', {
            theme: 'snow'
        });
        var objectif_specifique_instruction = new Quill('#objectif_specifique_instruction', {
            theme: 'snow'
        });
        var resultat_attendu_instruction = new Quill('#resultat_attendu_instruction', {
            theme: 'snow'
        });
        var champ_etude_instruction = new Quill('#champ_etude_instruction', {
            theme: 'snow'
        });
        var cible_instruction = new Quill('#cible_instruction', {
            theme: 'snow'
        });
        var methodologie_instruction = new Quill('#methodologie_instruction', {
            theme: 'snow'
        });

        contexte_probleme_instruction.disable();
        objectif_general_instruction.disable();
        objectif_specifique_instruction.disable();
        resultat_attendu_instruction.disable();
        champ_etude_instruction.disable();
        cible_instruction.disable();
        methodologie_instruction.disable();
    </script>

@endsection
