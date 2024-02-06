@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Projet d\'étude')
    @php($titre='Liste des comités plénières')
    @php($soustitre='Tenue de comité plénière')
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
                          <button type="button" class="nav-link @if($idetape==1) active @endif" role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-pleniere"
                          aria-controls="navs-top-pleniere"
                          aria-selected="true">
                          Comité plénière
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link  @if($idetape==2) active @endif?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-personne"
                          aria-controls="navs-top-personne"
                          aria-selected="false">
                            Personnes ressources
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link  @if($idetape==3) active @endif"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-top-liste"
                          aria-controls="navs-top-liste"
                          aria-selected="false">
                          Liste des projets d'études
                        </button>
                      </li>
                        <li class="nav-item">



                            <button type="button" class="nav-link @if(count($cahiers)<1 ) disabled @else
                             @if($idetape==4) active @endif
                            @endif"
                                    role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-top-cahieraprescomite" aria-controls="navs-top-cahieraprescomite"
                                    aria-selected="false">
                                Cahier
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade @if($idetape==1) show active @endif" id="navs-top-pleniere" role="tabpanel">
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere), \App\Helpers\Crypt::UrlCrypt(2)]) }}" enctype="multipart/form-data">
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
                        <div class="tab-pane fade @if($idetape==2) show active @endif" id="navs-top-personne" role="tabpanel">

                            @if($comitepleniere->flag_statut_comite_pleniere != true)
                            <form  method="POST" class="form" action="{{ route($lien.'.update', [\App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere), \App\Helpers\Crypt::UrlCrypt(2)]) }}" enctype="multipart/form-data">
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
                        <div class="tab-pane fade @if($idetape==3) show active @endif" id="navs-top-liste" role="tabpanel">
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
                                    <th>Date soumis</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($projet_etudes as $key => $projet_etude)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{ @$projet_etude->code_projet_etude }}</td>
                                        <td>{{ @$projet_etude->titre_projet_etude }}</td>
                                        <td>{{ Str::substr($projet_etude->contexte_probleme_projet_etude, 0, 30) }}</td>
                                        <td>{{ Str::substr($projet_etude->cible_projet_etude, 0, 40) }}</td>
                                        <td>{{ @$projet_etude->date_soumis }}</td>
                                        <td align="center">
                                            @if($comitepleniere->flag_statut_comite_pleniere == false)
                                                <a href="{{ route($lien.'.editer',[\App\Helpers\Crypt::UrlCrypt($projet_etude->id_projet_etude),\App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere),\App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                                   class=" "
                                                   title="Modifier"><img
                                                        src='/assets/img/editing.png'></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(count($cahiers)>=1)
                        <div class="tab-pane fade @if($idetape==4) show active @endif" id="navs-top-cahieraprescomite" role="tabpanel">
                            <?php  if(count($cahiers)>=1 and $comitepleniere->flag_statut_comite_pleniere == false){?>
                            <div class="col-12" align="right">
                                <form method="POST" class="form"
                                      action="{{ route($lien . '.update', [\App\Helpers\Crypt::UrlCrypt($comitepleniere->id_comite_pleniere),\App\Helpers\Crypt::UrlCrypt(4)]) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <button type="submit" name="action" value="Traiter_cahier_projet"
                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                        Valider le cahier
                                    </button>
                                </form>
                            </div>
                            <?php } ?>
                            <table class="table table-bordered table-striped table-hover table-sm" id="exampleData"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code </th>
                                    <th>Titre du projet </th>
                                    <th>Contexte </th>
                                    <th>Cible </th>
                                    <th>Date soumis</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($cahiers as $key => $projet_etude)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{ @$projet_etude->code_projet_etude }}</td>
                                        <td>{{ @$projet_etude->titre_projet_etude }}</td>
                                        <td>{{ Str::substr($projet_etude->contexte_probleme_projet_etude, 0, 30) }}</td>
                                        <td>{{ Str::substr($projet_etude->cible_projet_etude, 0, 40) }}</td>
                                        <td>{{ @$projet_etude->date_soumis }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                  </div>
                </div>
    </div>


        @endsection

