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

    @php($Module='Projet d\'étude')
    @php($titre='Liste des cahiers de projet d\'étude')
    @php($soustitre='Creer un cahier de projet d\'étude')
    @php($lien='cahierprojetetude')


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
                          data-bs-target="#navs-top-projetetude"
                          aria-controls="navs-top-projetetude"
                          aria-selected="true">
                          Cahier de projet d'étude
                        </button>
                      </li>

                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?php if($idetape==2){ echo "active";}  ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-actionformation"
                          aria-controls="navs-top-actionformation"
                          aria-selected="false">
                          Liste des projets d'étude
                        </button>
                      </li>

                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link @if(count($cahierprojetetudes)<1) disabled @else @if($idetape==3) active  @endif @endif "
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-cahieraprescomite"
                          aria-controls="navs-top-cahieraprescomite"
                          aria-selected="false">
                          Cahier de projet d'étude à soumettre pour le comité
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if($idetape==1){ echo "show active";} //if(count($comitegestionparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-projetetude" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude),\App\Helpers\Crypt::UrlCrypt(1)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Code <strong style="color:red;">*</strong></label>
                                            <input type="text" class="form-control form-control-sm" value="{{ @$cahier->code_cahier_projet_etude }}" disabled="disabled"/>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <label>Type entreprise <strong style="color:red;">*</strong></label>
                                        <select
                                                id="code_pieces_cahier_projet_etude"
                                                name="code_pieces_cahier_projet_etude"
                                                class="select2 form-select-sm input-group"
                                                aria-label="Default select example" required="required">
                                            <option value="{{ $cahier->code_pieces_cahier_projet_etude }}"><?php if($cahier->code_pieces_cahier_projet_etude == 'PME'){
                                                echo 'PETITE MOYENNE ENTREPRISES';
                                            }elseif ($cahier->code_pieces_cahier_projet_etude == 'GE') {
                                                echo 'GRANDE ENTREPRISE';
                                            }else{
                                                echo 'ANTENNE';
                                            } ?></option>
                                            <option value="PME">PETITE MOYENNE ENTREPRISES</option>
                                            <option value="GE">GRANDE ENTREPRISE</option>
                                            <option value="ANT">ANTENNE</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control form-control-sm"  name="commentaire_cahier_projet_etude" id="commentaire_cahier_projet_etude" rows="6">{{ $cahier->commentaire_cahier_projet_etude }}</textarea>

                                        </div>
                                    </div>

                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if($cahier->flag_statut_cahier_projet_etude == false){?>
                                            <button type="submit" name="action" value="Modifier"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Modifier
                                            </button>
                                        <?php } ?>
                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">Retour</a>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade <?php if($idetape==2){ echo "show active";} ?>" id="navs-top-actionformation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <?php if(count($projetetudes)>0){ ?>
                                    <div class="col-12" align="right">
                                        <button type="submit" name="action" value="Traiter_cahier_projet"
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
                                            <th></th>
                                            <th>Titre du projet </th>
                                            <th>Code</th>
                                            <th>Entreprise</th>
                                            <th>Chargé d'étude</th>
                                            <th>Financement sollicité</th>
                                            <th>Financement à accorder</th>
                                            <th>Date de création</th>
                                            <th>Date de soumission</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php //dd($projetetudes);
                                    $i=0 ?>
                                    @foreach ($projetetudes as $key => $projet_etude)
                                        <tr>
                                            <td>
                                                <input type="checkbox"
                                                value="<?php echo $projet_etude->id_projet_etude;?>"
                                                name="projetetude[<?php echo $projet_etude->id_projet_etude;?>]"
                                                id="projetetude<?php echo $projet_etude->id_projet_etude;?>"/>
                                            </td>

                                            <td>{{ Str::title(Str::limit($projet_etude->titre_projet_etude, 40,'...')) }}</td>
                                            <td>{{ @$projet_etude->code_projet_etude}}</td>
                                            <td>{{ @$projet_etude->entreprise->ncc_entreprises }} / {{ @$projet_etude->entreprise->raison_social_entreprises}}</td>
                                            <td>{{ @$projet_etude->chargedetude->name }} {{ @$projet_etude->chargedetude->prenom_users }}</td>

                                            <td>{{ number_format(@$projet_etude->montant_demande_projet_etude, 0, ',', ' ') }}</td>
                                            <td>{{ number_format(@$projet_etude->montant_projet_instruction, 0, ',', ' ') }}</td>

                                            <td>{{ date('d/m/Y h:i:s',strtotime($projet_etude->created_at ))}}</td>
                                            <td>{{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_soumis ))}}</td>

                                            <td align="center" nowrap="nowrap">
                                                <?php if($cahier->flag_statut_comite == false){?>
{{--                                                @can($lien.'-edit')--}}
                                                    <a href="{{ route($lien.'.editer',[\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"
                                                        class=" "
                                                        title="Afficher"><img
                                                            src='/assets/img/eye-solid.png'></a>

{{--                                                @endcan--}}
                                                <?php } ?>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
                            <div class="col-12" align="right">
                                <hr>


                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude),\App\Helpers\Crypt::UrlCrypt(1)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</a>
                                @if(count($cahierprojetetudes)>=1)

                                    <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}"  class="btn btn-sm btn-primary me-sm-3 me-1">Suivant</a>
                                @endif

                            </div>
                        </div>
                        @if(count($cahierprojetetudes)>=1)
                            <div class="tab-pane fade @if($idetape==3) show active  @endif" id="navs-top-cahieraprescomite" role="tabpanel">

                                <div class="col-12" align="right">
                                    <?php  if(count($cahierprojetetudes)>=1 and $cahier->flag_statut_cahier_projet_etude == false){?>

                                    <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude),\App\Helpers\Crypt::UrlCrypt(3)]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <button type="submit" name="action" value="Traiter_cahier_projet_soumis"
                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                            Soumettre le cahier à la commission
                                        </button>
                                    </form>

                                    <?php }else{ ?>
{{--                                        <a onclick="NewWindow('{{ route($lien.".etat",\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude)) }}','',screen.width*1,screen.height,'yes','center',1);" target="_blank" class=" " title="Modifier"><img src='/assets/img/eye-solid.png'></a>--}}
                                    <?php } ?>
                                </div>
                                <table class="table table-bordered table-striped table-hover table-sm"
                                id="exampleData"
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Titre du projet </th>
                                        <th>Code</th>
                                        <th>Entreprise</th>
                                        <th>Chargé d'étude</th>
                                        <th>Financement sollicité</th>
                                        <th>Financement à accorder</th>
                                        <th>Date de création</th>
                                        <th>Date de soumission</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php $i=0 ?>
                                @foreach ($cahierprojetetudes as $key => $projetetude)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{ Str::title(Str::limit($projet_etude->titre_projet_etude, 40,'...')) }}</td>
                                        <td>{{ @$projet_etude->code_projet_etude}}</td>
                                        <td>{{ @$projet_etude->entreprise->ncc_entreprises }} / {{ @$projet_etude->entreprise->raison_social_entreprises}}</td>
                                        <td>{{ @$projet_etude->chargedetude->name }} {{ @$projet_etude->chargedetude->prenom_users }}</td>
                                        <td>{{ number_format(@$projet_etude->montant_demande_projet_etude, 0, ',', ' ') }}</td>
                                        <td>{{ number_format(@$projet_etude->montant_projet_instruction, 0, ',', ' ') }}</td>
                                        <td>{{ date('d/m/Y h:i:s',strtotime($projet_etude->created_at ))}}</td>
                                        <td>{{ date('d/m/Y h:i:s',strtotime(@$projet_etude->date_soumis ))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="col-12" align="right">
                                <hr>

                                <?php if (count($cahierprojetetudes)>=1){ ?>
                                        <a  href="{{ route($lien.'.edit',[\App\Helpers\Crypt::UrlCrypt($cahier->id_cahier_projet_etude),\App\Helpers\Crypt::UrlCrypt(2)]) }}"  class="btn btn-sm btn-secondary me-sm-3 me-1">Précédant</button>
                                <?php } ?>

                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                    Retour</a>
                            </div>
                        </div>
                            @endif
                    </div>
                  </div>
                </div>
    </div>


        @endsection

