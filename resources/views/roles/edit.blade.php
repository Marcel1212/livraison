@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Parametre')
    @php($titre='Liste des profils')
    @php($soustitre='Modifier un profil et ses permissions')
    @php($lien='/roles')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{$soustitre}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{$Module}}</a></li>
                                    <li class="breadcrumb-item"><a href="{{$lien}}">{{$titre}}</a></li>
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
                                    <form action="{{ route('roles.update',\App\Helpers\Crypt::UrlCrypt($role->id)) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="mb-1">
                                                    <label>Libellé du profil</label>
                                                    <input type="text" name="name" id="name" value="{{$role->name }}"
                                                           class="form-control form-control-sm" placeholder="Libellé du profil">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                @foreach($permission as $value)
                                                    <label>

                                                        <input type="checkbox" class="form-check-input"
                                                               value="<?php echo $value->id;?>"
                                                               <?php if (in_array($value->id, $rolePermissions)) {
                                                                   echo 'checked';
                                                               } ?> name="permission[<?php echo $value->id;?>]"
                                                               id="permission<?php echo $value->id;?>"/>{{ $value->name }}
                                                    </label>
                                                    <br/>
                                                @endforeach
                                            </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect" href="{{$lien }}">
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











