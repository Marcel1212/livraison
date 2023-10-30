@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Paramétrage')
    @php($titre='Liste des utilisateurs')
    @php($soustitre='Modifier un utilisateur')
    @php($lien='users')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{$soustitre}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{$Module}}</a></li>
                                    <li class="breadcrumb-item"><a href="/{{$lien}}">{{$titre}}</a></li>
                                    <li class="breadcrumb-item active">{{$soustitre}}  </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="content-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$soustitre}} </h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('users.update',$user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-8 col-12">
                                                <div class="mb-1">
                                                    <label>Profil utilisateur</label>
                                                    <select class="select2 select2-size-sm form-select" name="roles" id="roles" >
                                                      <?php echo $Roless; ?>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Identifiant</label>
                                                    <input type="text" name="login_users" id="login_users"
                                                           value="{{$user->login_users }}"
                                                           class="form-control form-control-sm"
                                                           placeholder="Identifiant"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Nom </label>
                                                    <input type="text" name="name" id="name" value="{{$user->name }}"
                                                           class="form-control form-control-sm" placeholder="Nom"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Prénoms</label>
                                                    <input type="text" name="prenom_users" id="prenom_users"
                                                           value="{{$user->prenom_users }}"
                                                           class="form-control form-control-sm" placeholder="Prénoms">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Mot de passe</label>
                                                    <input type="password" name="password" id="password"
                                                           class="form-control form-control-sm"
                                                           placeholder="Mot de passe">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Genre :</label>
                                                    <select name="genre_users" id="genre_users"
                                                            class="select2 select2-size-sm form-select">
                                                        <option
                                                            <?php if ($user->genre_users == "Feminin") echo "selected" ?> value="Feminin">
                                                            Feminin
                                                        </option>
                                                        <option
                                                            <?php if ($user->genre_users == "Masculin") echo "selected" ?> value="Masculin">
                                                            Masculin
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Email :</label>
                                                    <input type="email" name="email" id="email"
                                                           value="{{$user->email }}"
                                                           class="form-control form-control-sm" placeholder="Prénoms">
                                                </div>
                                            </div>


                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Adresse :</label>
                                                    <input type="text" name="adresse_users" id="adresse_users"
                                                           value="{{$user->adresse_users }}"
                                                           class="form-control form-control-sm" placeholder="Adresse">
                                                </div>
                                            </div>


                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Cel. :</label>
                                                    <input type="number" name="cel_users" id="cel_users"
                                                           class="form-control form-control-sm"
                                                           value="{{$user->cel_users }}"
                                                           placeholder="Ex:  0102030405">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Tel. :</label>
                                                    <input type="number" name="tel_users" id="tel_users"
                                                           class="form-control form-control-sm"
                                                           value="{{$user->tel_users }}"
                                                           placeholder="Ex:  0102030405">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Agence :</label>
                                                    <select class="select2 select2-size-sm form-select" name="num_agce"
                                                            id="num_agce">
                                                        <?php echo $Entite; ?>
                                                    </select></div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Statut </label>
                                                    <select name="flag_actif_users"
                                                            class="form-control form-control-sm ">
                                                        <option value=true
                                                                @if($user->flag_actif_users == true ) selected @endif>
                                                            Actif
                                                        </option>
                                                        <option value=false
                                                                @if($user->flag_actif_users == false) selected @endif>
                                                            Inactif
                                                        </option>
                                                    </select>


                                                </div>
                                            </div>

                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection










