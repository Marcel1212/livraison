@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Projet d\'étude')
    @php($titre='Liste des comites plénières')
    @php($soustitre='Tenue de comite plénière')
    @php($lien='comitepleniereprojetetude')


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
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-planformation"
                          aria-controls="navs-top-planformation"
                          aria-selected="true">
                          Comite plénière
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?php if(count($comitepleniereparticipant)<1){ echo "active";} //dd($activetab); echo $activetab; ?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-categorieplan"
                          aria-controls="navs-top-categorieplan"
                          aria-selected="false">
                          Liste de presence
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link @if(count($projet_etudes)>0 and count($comitepleniereparticipant)>=1) active @endif"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-projetetude"
                          aria-controls="navs-top-projetetude"
                          aria-selected="false">
                          Liste des projets d'études
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="navs-top-planformation" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere)) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Date de debut <strong style="color:red;">*</strong></label>
                                            <input type="date" name="date_debut_comite_pleniere"
                                                class="form-control form-control-sm" value="{{ $comitepleniere->date_debut_comite_pleniere }}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Date de fin <strong style="color:red;">*</strong></label>
                                            <input type="date" name="date_fin_comite_pleniere"
                                                class="form-control form-control-sm" value="{{ $comitepleniere->date_fin_comite_pleniere }}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="mb-1">
                                            <label>Commentaire <strong style="color:red;">*</strong></label>
                                            <textarea class="form-control form-control-sm"  name="commentaire_comite_pleniere" id="commentaire_comite_pleniere" rows="6">{{ $comitepleniere->commentaire_comite_pleniere }}</textarea>

                                        </div>
                                    </div>


                                    <div class="col-12" align="right">
                                        <hr>
                                        <?php if($comitepleniere->flag_statut_comite_pleniere == false){?>
                                            <button type="submit" name="action" value="Modifier"
                                                    class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                Modifier
                                            </button>
                                        <?php } ?>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade <?php if(count($comitepleniereparticipant)<1){ echo "show active";} //dd($activetab); echo $activetab; ?>" id="navs-top-categorieplan" role="tabpanel">

                            @if($comitepleniere->flag_statut_comite_pleniere != true)
                            <form  method="POST" class="form" action="{{ route($lien.'.update', \App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere)) }}" enctype="multipart/form-data">
                                @csrf
                                      @method('put')
                                      <div class="row">
                                          <div class="col-12 col-md-10">
                                              <label class="form-label" for="id_user_comite_pleniere_participant">Charger d'étude <strong style="color:red;">*</strong></label>
                                              <select
                                                  id="id_user_comite_pleniere_participant"
                                                  name="id_user_comite_pleniere_participant"
                                                  class="select2 form-select-sm input-group"
                                                  aria-label="Default select example" required="required">
                                                  <?= $charger_etude; ?>
                                              </select>
                                          </div>

                                              <div class="col-12 col-md-2" align="right"> <br>
                                                  <button  type="submit" name="action" value="Enregistrer_charger_etude_pour_comite" class="btn btn-sm btn-primary me-sm-3 me-1">Enregistrer</button>
                                              </div>

                                      </div>

                              </form>

                              <hr>
                              @endif
                              <table class="table table-bordered table-striped table-hover table-sm"
                                  id=""
                                  style="margin-top: 13px !important">
                                  <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Nom</th>
                                      <th>Prenom</th>
                                      <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php $i = 0; ?>
                                      @foreach ($comitepleniereparticipant as $key => $comitepleniereparticipan)
                                      <?php $i += 1;?>
                                                  <tr>
                                                      <td>{{ $i }}</td>
                                                      <td>{{ $comitepleniereparticipan->user->name }}</td>
                                                      <td>{{ $comitepleniereparticipan->user->prenom_users }}</td>
                                                      <td>
                                                      <?php if ($comitepleniere->flag_statut_comite_pleniere != true){ ?>
                                                     <a href="{{ route($lien.'.delete',\App\Helpers\Crypt::UrlCrypt($comitepleniereparticipan->id_comite_pleniere_participant)) }}"
                                                     class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cet conseiller de cette commission ?")) return false;'
                                                     title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>
                                                     <?php } ?>
                                                  </td>
                                                  </tr>
                                      @endforeach

                                  </tbody>
                              </table>
                        </div>
                        <div class="tab-pane fade @if(count($projet_etudes)>0 and count($comitepleniereparticipant)>=1) show active @endif>" id="navs-top-projetetude" role="tabpanel">
                            <form  method="POST" class="form" action="{{route('comitepleniereprojetetude.update',\App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere))}}" enctype="multipart/form-data">
                                @if($comitepleniere->flag_statut_comite_pleniere != true)

                                <div class="col-12 mb-2" align="right">
                                    @csrf
                                    @method('put')
                                <button
                                    onclick='javascript:if (!confirm("Voulez-vous que ces projet ont été traité lors de la tenu du comité plénière ?  cette action est irréversible")) return false;'
                                    type="submit" name="action" value="Traiter_comite_pleniere"
                                    class="btn btn-success btn-sm">
                                    Valider le comité plénière
                                </button>
                            </div>
                                @endif
                            <table class="table table-bordered table-striped table-hover table-sm"
                                id="exampleData"
                                style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Code</th>
                                    <th>Titre du projet </th>
                                    <th>Contexte</th>
                                    <th>Cible</th>
                                    <th>Date de soumis</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($projet_etudes as $key => $projet_etude)
                                    <tr>
                                        @if($comitepleniere->flag_statut_comite_pleniere == false)
                                            <td>
                                                <input type="checkbox"
                                                       value="<?php echo $projet_etude->id_projet_etude;?>"
                                                       name="projetetude[<?php echo $projet_etude->id_projet_etude;?>]"
                                                       id="projetetude<?php echo $projet_etude->id_projet_etude;?>"

                                                />
                                            </td>
                                        @else
                                            <td>{{$key+1}}</td>
                                        @endif
                                        <td>{{ @$projet_etude->code_projet_etude }}</td>
                                        <td>{{ @$projet_etude->titre_projet_etude }}</td>
                                        <td>{{ Str::substr($projet_etude->contexte_probleme_projet_etude, 0, 30) }}</td>
                                        <td>{{ Str::substr($projet_etude->cible_projet_etude, 0, 40) }}</td>
                                        <td>{{ @$projet_etude->date_soumis }}</td>
                                        @if($projet_etude->flag_valider_ct_pleniere_projet_etude==true)
                                            <td>
                                                <span class="badge bg-success">Validé</span>
                                            </td>
                                        @else
                                            <td>{{ @$projet_etude->date_soumis }}</td>
                                        @endif
                                        <td align="center">
                                            @if($comitepleniere->flag_statut_comite_pleniere == false)
                                                <a href="{{ route($lien.'.editer',[\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere)]) }}"
                                                    class=" "
                                                    title="Modifier"><img
                                                        src='/assets/img/editing.png'></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </form>

                        </div>
                    </div>
                  </div>
                </div>
    </div>


        @endsection

