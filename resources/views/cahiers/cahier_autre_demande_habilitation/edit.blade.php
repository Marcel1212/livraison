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

{{--@if(auth()->user()->can('cahierplansprojets-edit'))--}}
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Cahiers')
    @php($titre='Liste des cahiers des demandes extension / substitution')
    @php($soustitre='Modifier le cahier')
    @php($lien='cahierautredemandehabilitations')
    @php($lienacceuil='dashboard')


    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <a class="active" href="/{{ $lienacceuil }}"> <i class="ti ti-home"></i>  Accueil </a> / {{$Module}} / <a href="/{{ $lien }}"> {{$titre}}</a> / </span> {{$soustitre}}
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
                          class="nav-link <?php if($idetape==1){ echo "active";}  ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-autre_demande_habilitation"
                          aria-controls="navs-top-autre_demande_habilitation"
                          aria-selected="true">
                            Cahier des demandes d'extension / de substitution
                        </button>
                      </li>

                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?php if($idetape==2){ echo "active";}  ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-liste_autre_demande_habilitation"
                          aria-controls="navs-top-liste_autre_demande_habilitation"
                          aria-selected="false">
                            Liste des demandes d'extension / de substitution
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"

                          class="nav-link @if(count($cahierautredemandehabilitations)>=1) @if($idetape==3) active @endif @else disabled @endif"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-cahieraprescomite"
                          aria-controls="navs-top-cahieraprescomite"
                          aria-selected="false">
                          Cahier à soumettre
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-autre_demande_habilitation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations),\App\Helpers\Crypt::UrlCrypt(1)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Code <strong style="color:red;">*</strong></label>
                                            <input type="text" class="form-control form-control-sm" value="{{ @$cahier->code_cahier_autre_demande_habilitations }}" disabled="disabled"/>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <label>Liste des demandes <strong style="color:red;">*</strong></label>
                                        <select class="select2 form-select @error('id_processus_autre_demande')
                                    error
                                    @enderror"
                                                data-allow-clear="true" name="id_processus_autre_demande"
                                                id="id_processus_autre_demande" >
                                                <?php echo $processusAutreDemandesListe ?>
                                        </select>
                                        @error('id_processus_autre_demande')
                                        <div class=""><label class="error">{{ $message }}</label></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control form-control-sm"  name="commentaire_cahier_autre_demande_habilitations" id="commentaire_cahier_autre_demande_habilitations" rows="6">{{ $cahier->commentaire_cahier_autre_demande_habilitations }}</textarea>

                                        </div>
                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if($cahier->flag_statut_cahier_autre_demande_habilitations == false){?>
                                            <button type="submit" name="action" value="Modifier"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Modifier
                                            </button>
                                        <?php } ?>
                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>

                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">Retour</a>

                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} ?>" id="navs-top-liste_autre_demande_habilitation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations),\App\Helpers\Crypt::UrlCrypt(2)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')


                            <?php if(count($demandes)>0){ ?>
                                <div class="col-12" align="right">
                                    <button type="submit" name="action" value="Ajouter_cahier_autre_demande_habilitation"
                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                    Ajouter au cahier
                                    </button>
                                </div>
                            <?php } ?>

                            <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th><label>Cocher tout</label><br/><input type="checkbox" id="allcb" name="allcb"/></th>
                                        <th>Type processus </th>
                                        <th>Entreprise </th>
                                        <th>Chargé d'habilitation </th>
                                        <th>Code </th>
                                        <th>Date soumise au FDFP</th>
                                        <th>Date fin instruction</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i=0 ?>
                                @foreach ($demandes as $key => $demande)
                                    <tr>
                                        <td>
                                            <input type="checkbox"
                                            value="<?php echo $demande->id_demande;?>"
                                            name="demande[]"
                                            id="demande<?php echo $demande->id_demande;?>"/>
                                        </td>
                                        <td>
                                                @if(@$cahier->code_pieces_cahier_autre_demande_habilitations=='DED')
                                                    DEMANDE D'EXTENSION
                                                @elseif(@$cahier->code_pieces_cahier_autre_demande_habilitations=='demande_extension')
                                                    DEMANDE DE SUBSTITUTION
                                                @endif
                                        </td>
                                        <td>{{ @$demande->raison_sociale  }}</td>
                                        <td>{{ @$demande->nom_conseiller }}</td>
                                        <td>{{ @$demande->code }}</td>
                                        <td>{{ date('d/m/Y H:i:s',strtotime(@$demande->date_demande))}}</td>
                                        <td>{{ date('d/m/Y H:i:s',strtotime(@$demande->date_soumis))}}</td>
                                        <td>
                                            <a target="_blank" href="{{ route($lien . '.show', [\App\Helpers\Crypt::UrlCrypt($demande->id_demande), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                               class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </form>
                            <div class="col-12" align="right">
                                <hr>

                                <?php //if (count($comitegestionparticipant)>=1){ ?>


                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédent</a>

                                    <?php if (count($cahierautredemandehabilitations)>=1){ ?>
                                <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                <?php } ?>


                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>

                        <div class="tab-pane fade<?php if($idetape==3){ echo "show active";} //if(count($ficheagrements)>=1 and count($comitegestionparticipant)>=1){ echo "active";} ?>" id="navs-top-cahieraprescomite" role="tabpanel">

                            <div class="col-12" align="right">
                                <?php  if(count($cahierautredemandehabilitations)>=1 and $cahier->flag_statut_cahier_autre_demande_habilitations == false){?>

                                <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations),\App\Helpers\Crypt::UrlCrypt(3)]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <button onclick='javascript:if (!confirm("Vous allez soumettre ce cahier pour validation  ? . Cette action est irréversible.")) return false;' type="submit" name="action" value="Traiter_cahier_autre_demande_habilitation"
                                    class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                        Génerer la note technique pour validation
                                    </button>
                                </form>

                                <?php } ?>
{{--                                else{ ?>--}}
{{--                                    @if ($cahier->processusComite->code_processus_comite =='PF')--}}

{{--                                    <a onclick="NewWindow('{{ route($lien.".etatpf",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitation)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>--}}

{{--                                    @endif--}}
{{--                                    @if ($cahier->processusComite->code_processus_comite =='PE')--}}

{{--                                    <a onclick="NewWindow('{{ route($lien.".etatpe",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitation)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>--}}

{{--                                    @endif--}}
{{--                                    @if ($cahier->processusComite->code_processus_comite =='PRF')--}}

{{--                                    <a onclick="NewWindow('{{ route($lien.".etatprf",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitation)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>--}}

{{--                                    @endif--}}
{{--                                <?php } ?>--}}
                            </div>

                            <table class="table table-bordered table-striped table-hover table-sm"
                            id="exampleData"
                            style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Type processus </th>
                                        <th>Entreprise </th>
                                        <th>Chargé d'habilitation </th>
                                        <th>Code </th>
                                        <th>Date soumise au FDFP</th>
                                        <th>Date fin instruction</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                $i=0 ?>
                                @foreach ($cahierautredemandehabilitations as $key => $demande)
                                    <tr>
                                        <td> {{ ++$i }} </td>
                                        <td>
                                            @if(@$demande->code_processus=='DED')
                                                DEMANDE D'EXTENSION
                                            @elseif(@$demande->code_processus=='demande_extension')
                                                DEMANDE DE SUBSTITUTION
                                            @endif

                                        </td>
                                        <td>{{ @$demande->raison_sociale  }}</td>
                                        <td>{{ @$demande->nom_conseiller }}</td>
                                        <td>{{ @$demande->code }}</td>
                                        <td>{{date('d/m/Y H:i:s',strtotime(@$demande->date_demande))}}</td>
                                        <td>{{ date('d/m/Y H:i:s',strtotime(@$demande->date_soumis))}}</td>
                                        <td>
                                            <a target="_blank" href="{{ route($lien . '.show', [\App\Helpers\Crypt::UrlCrypt($demande->id_demande), \App\Helpers\Crypt::UrlCrypt(1)]) }}"
                                               class=" " title="Modifier"><img src='/assets/img/editing.png'></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="col-12" align="right">
                                <hr>

                                <?php if (count($cahierautredemandehabilitations)>=1){ ?>
                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_autre_demande_habilitations),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédent</a>
                                <?php } ?>

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
    </div>


        @endsection
        @section('js_perso')
        <script  type="text/javascript">
            $('#allcb').change(function(){
                if($(this).prop('checked')){
                    $('tbody tr td input[type="checkbox"]').each(function(){
                        $(this).prop('checked', true);
                    });
                }else{
                    $('tbody tr td input[type="checkbox"]').each(function(){
                        $(this).prop('checked', false);
                    });
                }
            });

        </script>
        <!-- BEGIN: Content-->
        @endsection

{{--        @else--}}
{{--        <script type="text/javascript">--}}
{{--            window.location = "{{ url('/403') }}";//here double curly bracket--}}
{{--        </script>--}}
{{--    @endif--}}
