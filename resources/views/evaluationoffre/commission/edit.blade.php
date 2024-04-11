<?php

use App\Helpers\AnneeExercice;
use Carbon\Carbon;
ini_set('max_execution_time', '0');
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
{{--@if(auth()->user()->can('commissionevaluationoffres-edit'))--}}
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Comités')
    @php($titre='Liste des commissions d\'évaluation')
    @php($soustitre='Tenue de la commission d\'évaluation')
    @php($lien='commissionevaluationoffres')
    @php($lienacceuil='dashboard')


    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i>  Accueil </a> / {{$Module}} / <a
                href="/{{ $lien }}"> {{$titre}}</a> / </span> {{$soustitre}}
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
                            data-bs-target="#navs-top-commission"
                            aria-controls="navs-top-commission"
                            aria-selected="true">
                            Commission
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link <?php if($idetape==2){ echo "active";}  ?>"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-projet"
                            aria-controls="navs-top-projet"
                            aria-selected="true">
                            Liste des projets
                        </button>
                    </li>

                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link @if(isset($cahier)) @if($idetape==3) active @endif @else disabled @endif"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-offretechnique"
                            aria-controls="navs-top-offretechnique"
                            aria-selected="false">
                            Offre Technique
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link  @if(isset($cahier) && $offretechcommissioneval_sums==100) @if($idetape==4) active @endif @else disabled @endif"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-participant"
                            aria-controls="navs-top-participant"
                            aria-selected="false">
                            Liste des participants
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link @if(isset($cahier) && count($commissioneparticipants)>0) @if($idetape==5 ) active @endif @else disabled @endif"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-classementoffretech"
                            aria-controls="navs-top-classementoffretech"
                            aria-selected="false">
                            Classement Offre technique
                        </button>
                    </li>

                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link @if(isset($cahier) && $commissionevaluationoffre->flag_valider_offre_tech_commission_evaluation_tech==true) @if($idetape==6 ) active @endif @else disabled @endif"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-top-offrefinanciere"
                            aria-controls="navs-top-offrefinanciere"
                            aria-selected="false">
                            Offre Financière
                        </button>
                    </li>
                    {{--                    <li class="nav-item">--}}
                    {{--                        <button--}}
                    {{--                            type="button"--}}
                    {{--                            class="nav-link @if(isset($cahier) && count($commissioneparticipants)>0) @if($idetape==4 ) active @endif @else disabled @endif"--}}
                    {{--                            role="tab"--}}
                    {{--                            data-bs-toggle="tab"--}}
                    {{--                            data-bs-target="#navs-top-offretechnique"--}}
                    {{--                            aria-controls="navs-top-offretechnique"--}}
                    {{--                            aria-selected="false">--}}
                    {{--                            Classement--}}
                    {{--                        </button>--}}
                    {{--                    </li>--}}


                    {{--                    <li class="nav-item">--}}
                    {{--                        <button--}}
                    {{--                            type="button"--}}
                    {{--                            class="nav-link @if(isset($cahier)) @if($idetape==6) active @endif @else disabled @endif  ?>"--}}
                    {{--                            role="tab"--}}
                    {{--                            data-bs-toggle="tab"--}}
                    {{--                            data-bs-target="#navs-top-cahieraprescomite"--}}
                    {{--                            aria-controls="navs-top-cahieraprescomite"--}}
                    {{--                            aria-selected="false">--}}
                    {{--                            Valider le comite--}}
                    {{--                        </button>--}}
                    {{--                    </li>--}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade @if($idetape==1)show active @endif" id="navs-top-commission"
                         role="tabpanel">
                        <form method="POST" class="form"
                              action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(1)]) }}">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <label>Nombre d'évaluateur</label>
                                    <input type="number" name="nombre_evaluateur_commission_evaluation_offre"
                                           class="form-control form-control-sm" required min="0" disabled
                                           value="{{ $commissionevaluationoffre->nombre_evaluateur_commission_evaluation_offre }}"
                                    />
                                    @error('nombre_evaluateur_commission_evaluation_offre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-12">
                                    <label>Numéro de la Commission <strong style="color:red;">*</strong></label>
                                    <input type="number" name="numero_commission_evaluation_offre"
                                           class="form-control form-control-sm" required min="0"
                                           value="{{ $commissionevaluationoffre->numero_commission_evaluation_offre }}"
                                    />
                                    @error('numero_commission_evaluation_offre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-12">
                                    <label>Région </label>
                                    <input type="text" name="region_commission_evaluation_offre"
                                           class="form-control form-control-sm" min="0"
                                           value="{{ $commissionevaluationoffre->region_commission_evaluation_offre }}"
                                    />
                                    @error('region_commission_evaluation_offre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-12">
                                    <label>Spéculation</label>
                                    <input type="text" name="speculation_commission_evaluation_offre"
                                           class="form-control form-control-sm" min="0"
                                           value="{{ $commissionevaluationoffre->speculation_commission_evaluation_offre }}"
                                    />
                                    @error('speculation_commission_evaluation_offre')
                                    <div class=""><label class="error">{{ $message }}</label></div>
                                    @enderror
                                </div>
                                <div class="row">
                                    {{--                                    <div class="col-md-6">--}}
                                    {{--                                        <div class="row">--}}
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Date de début <strong style="color:red;">*</strong></label>
                                            <input type="date" name="date_debut_commission_evaluation_offre"
                                                   class="form-control form-control-sm" required
                                                   value="{{ $commissionevaluationoffre->date_debut_commission_evaluation_offre }}"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Date de fin </label>
                                            <input type="date" name="date_fin_commission_evaluation_offre"
                                                   class="form-control form-control-sm"
                                                   value="{{ $commissionevaluationoffre->date_fin_commission_evaluation_offre }}"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Pourcentage offre technique <strong
                                                    style="color:red;">*</strong></label>
                                            <input type="number"
                                                   id="pourcentage_offre_tech_commission_evaluation_offre"
                                                   name="pourcentage_offre_tech_commission_evaluation_offre"
                                                   min="0"
                                                   class="form-control form-control-sm" required
                                                   value="{{ $commissionevaluationoffre->pourcentage_offre_tech_commission_evaluation_offre }}"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Pourcentage offre financière <strong style="color:red;">*</strong></label>
                                            <input type="number"
                                                   id="pourcentage_offre_fin_commission_evaluation_offre"
                                                   name="pourcentage_offre_fin_commission_evaluation_offre"
                                                   min="0" readonly
                                                   class="form-control form-control-sm"
                                                   value="{{$commissionevaluationoffre->pourcentage_offre_fin_commission_evaluation_offre }}"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Note éliminatoire offre technique (/100) <strong style="color:red;">*</strong></label>
                                            <input type="number" id="note_eliminatoire_offre_tech_commission_evaluation_offre" name="note_eliminatoire_offre_tech_commission_evaluation_offre"  min="0"
                                                   class="form-control form-control-sm"  value="{{$commissionevaluationoffre->note_eliminatoire_offre_tech_commission_evaluation_offre }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Marge inférieure offre financière (%) <strong style="color:red;">*</strong></label>
                                            <input type="number" id="marge_inf_offre_fin_commission_evaluation_offre" name="marge_inf_offre_fin_commission_evaluation_offre"  min="0"
                                                   class="form-control form-control-sm" value="{{$commissionevaluationoffre->marge_inf_offre_fin_commission_evaluation_offre }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Marge supérieure offre financière (%) <strong style="color:red;">*</strong></label>
                                            <input type="number" id="marge_sup_offre_fin_commission_evaluation_offre" name="marge_sup_offre_fin_commission_evaluation_offre"  min="0"
                                                   class="form-control form-control-sm"  value="{{$commissionevaluationoffre->marge_sup_offre_fin_commission_evaluation_offre }}" />
                                        </div>
                                    </div>


                                    {{--                                        </div>--}}

                                    {{--                                    </div>--}}


                                    <div class="col-md-3 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire </label>
                                            <textarea class="form-control form-control-sm"
                                                      name="commentaire_commission_evaluation_offre"
                                                      id="commentaire_commission_evaluation_offre"
                                                      rows="6">{{$commissionevaluationoffre->commentaire_commission_evaluation_offre}}</textarea>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" align="right">
                                    <hr>
                                    @if($commissionevaluationoffre->flag_statut_commission_evaluation_offre == false)
                                        <button type="submit" name="action" value="Modifier"
                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Modifier
                                        </button>
                                    @endif
                                    <button name="action" value="Modifier_Suivant"
                                            class="btn btn-sm btn-primary me-sm-3 me-1">Suivant
                                    </button>
                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                        Retour</a>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade @if($idetape==2) show active @endif" id="navs-top-projet" role="tabpanel">
                        <form method="POST" class="form"
                              action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                            @csrf
                            @method('put')
                                <?php if (!isset($cahier)){ ?>
                            <div class="col-12" align="right">
                                <button type="submit" name="action" value="creer_cahier_offre_projets"
                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                    Ajouter à la commission
                                </button>
                            </div>
                            <?php } ?>

                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id="exampleData"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    @if (!isset($cahier))
                                        <th></th>
                                    @else
                                        <th>N°</th>
                                    @endif
                                    <th>Code</th>
                                    <th>Entreprise</th>
                                    <th>Chargé d'étude</th>
                                    <th>Titre du projet</th>
                                    <th>Date soumis au FDFP</th>
                                    <th>Date fin instruction</th>
                                    <th>Cout accordé</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($projet_etudes as $key => $projet_etude)
                                    <tr>
                                        @if (!isset($cahier))
                                            <td>
                                                <input type="radio"
                                                       value="<?php echo $projet_etude->id_projet_etude;?>"
                                                       name="demande"
                                                       id="demande<?php echo $projet_etude->id_projet_etude;?>"/>
                                            </td>
                                        @else
                                            <td>
                                                {{$key+1}}
                                            </td>
                                        @endif

                                        <td>{{ @$projet_etude->code_projet_etude}}</td>
                                        <td>{{ @$projet_etude->entreprise->ncc_entreprises }}
                                            / {{ @$projet_etude->entreprise->raison_social_entreprises}}</td>
                                        <td>{{ @$projet_etude->chargedetude->name  }}
                                            / {{ @$projet_etude->chargedetude->prenom_users  }}</td>
                                        <td>{{ Str::title(Str::limit($projet_etude->titre_projet_etude, 40,'...')) }}</td>
                                        <td>{{ date('d/m/Y h:i:s',strtotime(@$projet_etude->created_at ))}}</td>
                                        <td>{{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_instruction ))}}</td>
                                        <td align="rigth">{{ number_format($projet_etude->montant_projet_instruction, 0, ',', ' ') }}</td>
                                        <td align="center">
                                            <a onclick="NewWindow('{{ route('agreementprojetetude' . '.show', \App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude)) }}','',screen.width*2,screen.height,'yes','center',1);"
                                               target="_blank" class=" " title="Afficher"><img
                                                    src='/assets/img/eye-solid.png'></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                        @if(isset($cahier))
                            <div class="col-12" align="right">
                                <hr>
                                <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                   class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>
                                <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                   class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade @if($idetape==3 && isset($cahier)) show active @else disabled @endif" id="navs-top-offretechnique" role="tabpanel">
                        @if($beginvalidebyoneuser->count()==0 && $offretechcommissioneval_sums!=100)
                            <form method="POST" class="form"
                                  action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(2)]) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <label class="form-label" for="id_user_comite_participant">Critère d'évaluation
                                            offre technique <strong
                                                style="color:red;">*</strong></label>
                                        <select id="id_critere_evaluation_offre_tech"
                                                class="select2 form-select-sm input-group" data-allow-clear="true"
                                                name="id_critere_evaluation_offre_tech"
                                                required="required">
                                            <option value="">-----------------------</option>
                                            @isset($critereevaluationoffretechs)
                                                @foreach($critereevaluationoffretechs as $critereevaluationoffretech)
                                                    <option
                                                        value="{{@$critereevaluationoffretech->id_critere_evaluation_offre_tech}}">{{@$critereevaluationoffretech->libelle_critere_evaluation_offre_tech}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-5">
                                        <label class="form-label" for="id_sous_critere_evaluation_offre_tech">Sous-critère
                                            d'évaluation offre technique <strong
                                                style="color:red;">*</strong></label>
                                        <select id="id_sous_critere_evaluation_offre_tech"
                                                name="id_sous_critere_evaluation_offre_tech"
                                                class="select2 form-select-sm input-group"
                                                aria-label="Default select example"
                                        >
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-5">
                                        <label class="form-label" for="note_offre_tech_commission_evaluation_offre">Note
                                            <strong style="color:red;">*</strong></label>
                                        <input type="number" style="line-height:1.5rem" class="form-control form-control-sm"
                                               name="note_offre_tech_commission_evaluation_offre"
                                               aria-label="Default select example"/>
                                    </div>

                                    <div class="col-12 col-md-2" align="right"><br>
                                        <button type="submit" name="action" value="Enregistrer_Offre_Tech"
                                                class="btn btn-sm btn-primary me-sm-3 me-1">Ajouter
                                        </button>
                                    </div>



                                </div>
                            </form>
                        @endif
                        <table class="table table-bordered table-striped table-hover table-sm"
                               id="exampleData"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>N°</th>
                                <th>Critère</th>
                                <th>Sous-critère</th>
                                <th>Note</th>
                                @if($beginvalidebyoneuser->count()==0)
                                    <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @isset($offretechcommissioneval_tabs)
                                @foreach($offretechcommissioneval_tabs as $key=>$offretechcommissioneval_tab)
                                    <tr>
                                        <td>
                                            {{$key+1}}
                                        </td>
                                        <td>
                                            {{@$offretechcommissioneval_tab->critereevaluationoffretech->libelle_critere_evaluation_offre_tech}}
                                        </td>
                                        <td>
                                            {{@$offretechcommissioneval_tab->souscritereevaluationoffretech->libelle_sous_critere_evaluation_offre_tech}}
                                        </td>
                                        <td>
                                            {{@$offretechcommissioneval_tab->note_offre_tech_commission_evaluation_offre}}
                                        </td>
                                        @if($beginvalidebyoneuser->count()==0)

                                            <td>
                                                <a href="{{ route($lien . '.delete', [\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt($offretechcommissioneval_tab->id_sous_critere_evaluation_offre_tech)])}}"
                                                   class=""
                                                   onclick='javascript:if (!confirm("Voulez-vous supprimer ce sous-critère de cette commission ?")) return false;'
                                                   title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            @endisset

                            <tr>
                                <td colspan="3">
                                    <span class="fw-bold">Total</span>
                                </td>
                                <td colspan="2">
                                    <span class="fw-bold"> {{$offretechcommissioneval_tabs->sum('note_offre_tech_commission_evaluation_offre')}}/ 100</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        @if($offretechcommissioneval_sums==100)
                            <div class="col-12" align="right">
                                <hr>
                                <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                   class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>
                                <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                   class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade @if($idetape==4 && isset($cahier)  && $offretechcommissioneval_sums==100) show active @else disabled @endif"
                         id="navs-top-participant" role="tabpanel">
                        @if ($commissionevaluationoffre->flag_statut_commission_evaluation_offre != true and $commissionevaluationoffre->flag_valider_offre_tech_commission_evaluation_tech==false and isset($cahier))
                            <form method="POST" class="form"
                                  action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(3)]) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-12 col-md-9">
                                        <label class="form-label" for="id_user_commission_evaluation_offre_participant">Personnes
                                            ressources <strong
                                                style="color:red;">*</strong></label>
                                        <select id="id_user_commission_evaluation_offre_participant"
                                                name="id_user_commission_evaluation_offre_participant[]"
                                                class="select2 form-select-sm input-group"
                                                aria-label="Default select example"
                                                multiple>
                                                <?= $personneressource ?>
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-3" align="right"><br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button type="submit" name="action"
                                                        value="Enregistrer_personne_ressource_pour_commission"
                                                        class="btn btn-sm btn-primary me-sm-3 me-1"
                                                        onclick='javascript:if (!confirm("Voulez-vous ajouter ces personnes a cette commission ?")) return false;'>
                                                    Ajouter
                                                </button>

                                            </div>
                                            <div class="col-md-8">

                                                @if(count($commissioneparticipants)>=1)
                                                    <button type="submit" name="action" value="Invitation_personne_ressouce"
                                                            class="btn w-100 btn-sm btn-success me-sm-3 me-1"
                                                            onclick='javascript:if (!confirm("Voulez-vous envoyer les invitations a ces personnes pour cette commission ?")) return false;'>
                                                        Envoyer les invitations
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </form>

                            <hr>
                        @endif
                        <table class="table table-bordered table-striped table-hover table-sm" id=""
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Profil</th>
                                @if ($commissionevaluationoffre->flag_statut_commission_evaluation_offre != true and $commissionevaluationoffre->flag_valider_offre_tech_commission_evaluation_tech==false and isset($cahier))
                                    <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($commissioneparticipants as $key => $commissioneparticipant)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $commissioneparticipant->name }}</td>
                                    <td>{{ $commissioneparticipant->prenom_users }}</td>
                                    <td>{{ $commissioneparticipant->profile }}</td>
                                    @if ($commissionevaluationoffre->flag_statut_commission_evaluation_offre != true and $commissionevaluationoffre->flag_valider_offre_tech_commission_evaluation_tech==false and isset($cahier))
                                        <td>
                                            <a href="{{ route($lien . '.delete.personne', \App\Helpers\Crypt::UrlCrypt($commissioneparticipant->id_commission_participant)) }}"
                                               class=""
                                               onclick='javascript:if (!confirm("Voulez-vous supprimer cette personne de cette commission ?")) return false;'
                                               title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="col-12" align="right">
                            <hr>
                            <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(2)]) }}"
                               class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>
                            <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(5)]) }}"
                               class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                Retour</a>
                        </div>
                    </div>
                    <div class="tab-pane fade @if($idetape==5 && isset($cahier) && count($commissioneparticipants)>0) show active @else disabled @endif" id="navs-top-classementoffretech" role="tabpanel">
                        <div>
                            @if($commissionevaluationoffre->flag_valider_offre_tech_commission_evaluation_tech==false && $beginvalidebyoneuser->count()!=0 && $beginvalidebyoneuser->count()==$commissioneparticipants->count())
                                <form method="POST" class="form d-inline-block"
                                      action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(5)]) }}"
                                >
                                    @method('put')
                                    @csrf
                                    <button type="submit" align="left" name="action" value="valider_offre_technique"
                                            class="btn btn-success btn-sm waves-effect waves-light me-sm-3 me-1 mb-2"
                                            onclick='javascript:if (!confirm("Voulez-vous mettre fin à la notation ?")) return false;'>Clôturer l'offre technique</button>
                                </form>
                            @endif
                            <a href="#"
                               class="btn float-end btn-sm rounded-pill btn-outline-primary waves-effect waves-light mb-2"
                               onclick="NewWindow('{{route("commissionevaluationoffres.offretech.show",[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre)])}}','',screen.width/2,screen.height,'yes','center',1);">
                                Afficher la grille de notation
                            </a>
                        </div>
                        <table class="table table-bordered table-sm" id=""
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>Rang</th>
                                <th>Entreprise</th>
                                <th>Moyenne Générale</th>
                                <th>Statut</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($classement_offre_techs as $key => $classement_offre_tech)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $classement_offre_tech->entreprise }}</td>
                                    <td>{{ round($classement_offre_tech->note,2) }} / 100</td>
                                    <td>

                                        @if(round($classement_offre_tech->note,2)<$commissionevaluationoffre->note_eliminatoire_offre_tech_commission_evaluation_offre)
                                            <span class="badge bg-danger">Eliminée</span>
                                        @else
                                            <span class="badge bg-success">Retenue</span>
                                            <span></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-12" align="right">
                            <hr>
                            <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(2)]) }}"
                               class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>
                            @if(isset($cahier) && $commissionevaluationoffre->flag_valider_offre_tech_commission_evaluation_tech==true)
                                <a href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(6)]) }}"
                                   class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                            @endif
                            <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                Retour</a>
                        </div>
                    </div>

                    <div class="tab-pane fade @if(isset($cahier) && $commissionevaluationoffre->flag_valider_offre_tech_commission_evaluation_tech==true && $idetape==6) show active @endif" id="navs-top-offrefinanciere" role="tabpanel">
                                                @if($commissionevaluationoffre->flag_statut_commission_evaluation_offre == true)
                                                    <form method="POST" class="form"
                                                          action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(6)]) }}"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        @method('put')
                                                        <div class="row">
                                                            <div class="col-12 col-md-10">
                                                            </div>
                                                            <div class="col-12 col-md-2" align="right"> <br>
                                                                <button type="submit" name="action" value="valider_offre_fin"
                                                                        class="btn btn-sm btn-success me-sm-3 me-1"
                                                                        onclick='javascript:if (!confirm("Voulez-vous valider la commission ?")) return false;'>Valider la commission</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endif
                        <form method="POST" action="{{route($lien.'.updateNotationOffreFin',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(6)])}}">
                            @csrf
                            @method('put')
                            <table class="table table-bordered table-striped table-hover table-sm"
                                   id="exampleData"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Entreprise</th>
                                    <th>Montant</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($classement_offre_techs as $key => $classement_offre_tech)
                                    @if(round($classement_offre_tech->note,2)>$commissionevaluationoffre->note_eliminatoire_offre_tech_commission_evaluation_offre)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $classement_offre_tech->entreprise }}</td>
                                            <td><input type="text" class="form-control number" min="0" name="note_offre_fins[{{ $classement_offre_tech->entreprise}}][]"/></td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            <div class="col-12" align="right">
                                <hr>
                                <button type="submit" name="action" value="Enregistrer_offre_Fin"
                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                    Enregistrer
                                </button>
                                <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>
                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </form>

                    </div>


                    {{--                    <div class="tab-pane fade @if(isset($cahier) && $commissionevaluationoffre->flag_valider_offre_tech_commission_evaluation_tech==true && $idetape==6) show active @endif" id="navs-top-offrefinanciere" role="tabpanel">--}}
                    {{--                                               @if($commissionevaluationoffre->flag_statut_commission_evaluation_offre != true and isset($cahier))--}}
                    {{--                                                <form method="POST" class="form"--}}
                    {{--                                                      action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(6)]) }}"--}}
                    {{--                                                      enctype="multipart/form-data">--}}
                    {{--                                                    @csrf--}}
                    {{--                                                    @method('put')--}}
                    {{--                                                    <div class="row">--}}
                    {{--                                                        <div class="col-12 col-md-10">--}}
                    {{--                                                        </div>--}}
                    {{--                                                        <div class="col-12 col-md-2" align="right"> <br>--}}
                    {{--                                                            <button type="submit" name="action" value="valider_comite_technique"--}}
                    {{--                                                                    class="btn btn-sm btn-success me-sm-3 me-1"--}}
                    {{--                                                                    onclick='javascript:if (!confirm("Voulez-vous valider la commission ?")) return false;'>Valider le comité</button>--}}
                    {{--                                                        </div>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </form>--}}
                    {{--                                                @endif--}}
                    {{--                                                <table class="table table-bordered table-striped table-hover table-sm"--}}
                    {{--                                                id="exampleData"--}}
                    {{--                                                style="margin-top: 13px !important">--}}
                    {{--                                                    <thead>--}}
                    {{--                                                        <tr>--}}
                    {{--                                                            <th>N°</th>--}}
                    {{--                                                            <th>Code</th>--}}
                    {{--                                                            <th>Entreprise</th>--}}
                    {{--                                                            <th>Chargé d'étude</th>--}}
                    {{--                                                            <th>Titre du projet</th>--}}
                    {{--                                                            <th>Date soumis au FDFP</th>--}}
                    {{--                                                            <th>Date fin instruction</th>--}}
                    {{--                                                            <th>Cout accordé</th>--}}
                    {{--                                                        </tr>--}}
                    {{--                                                    </thead>--}}
                    {{--                                                    <tbody>--}}
                    {{--                                                    @foreach ($listedemandes as $key => $demande)--}}
                    {{--                                                        <tr>--}}
                    {{--                                                            <td>{{ $key+1 }}</td>--}}
                    {{--                                                            <td>{{ @$demande->code_projet_etude}}</td>--}}
                    {{--                                                            <td>{{ @$demande->entreprise->ncc_entreprises }}--}}
                    {{--                                                                / {{ @$demande->entreprise->raison_social_entreprises}}</td>--}}
                    {{--                                                            <td>{{ @$demande->chargedetude->name  }}--}}
                    {{--                                                                / {{ @$demande->chargedetude->prenom_users  }}</td>--}}
                    {{--                                                            <td>{{ Str::title(Str::limit($demande->titre_projet_etude, 40,'...')) }}</td>--}}
                    {{--                                                            <td>{{ date('d/m/Y h:i:s',strtotime(@$demande->created_at ))}}</td>--}}
                    {{--                                                            <td>{{ date('d/m/Y h:i:s',strtotime(@$demande->date_instruction ))}}</td>--}}
                    {{--                                                            <td align="rigth">{{ number_format($demande->montant_projet_instruction, 0, ',', ' ') }}</td>--}}
                    {{--                                                        </tr>--}}
                    {{--                                                    @endforeach--}}
                    {{--                                                    </tbody>--}}
                    {{--                                                </table>--}}

                    {{--                                                <div class="col-12" align="right">--}}
                    {{--                                                    <hr>--}}
                    {{--                                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($commissionevaluationoffre->id_commission_evaluation_offre),\App\Helpers\Crypt::UrlCrypt(5)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>--}}
                    {{--                                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">--}}
                    {{--                                                        Retour</a>--}}
                    {{--                                                </div>--}}
                    {{--                                            </div>--}}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js_perso')
    <script>
        $("#pourcentage_offre_tech_commission_evaluation_offre").on("keyup", function () {
            $("#pourcentage_offre_fin_commission_evaluation_offre").val(100 - $("#pourcentage_offre_tech_commission_evaluation_offre").val())
        });

        $('#id_critere_evaluation_offre_tech').on('change', function (e) {
            var id_critere_evaluation_offre_tech_val = e.target.value;
            $.get('{{url('/')}}/souscritereevaluationoffretech/' + id_critere_evaluation_offre_tech_val + '/critere/json', function (data) {
                $('#id_sous_critere_evaluation_offre_tech').empty();
                $('#id_sous_critere_evaluation_offre_tech').select2({
                    data: data
                });
            });
        });
    </script>
@endsection
{{--        @else--}}
{{--        <script type="text/javascript">--}}
{{--            window.location = "{{ url('/403') }}";//here double curly bracket--}}
{{--        </script>--}}
{{--    @endif--}}
