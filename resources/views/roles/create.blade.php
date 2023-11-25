@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Liste des profils')
    @php($soustitre='Ajouter un profil')
    @php($lien='roles')


    <!-- BEGIN: Content-->

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i
                class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
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
        <!-- Basic Layout & Basic with Icons -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$soustitre}} </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-1">
                                        <label>Libellé du profil</label>
                                        <input type="text" name="name" id="name"
                                               class="form-control form-control-sm"
                                               placeholder="Libellé " required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    @foreach($permission as $value)
                                        <label>
                                            <input type="checkbox" class="form-check-input"
                                                   value="<?php echo $value->id;?>"
                                                   name="permission[<?php echo $value->id;?>]"
                                                   id="permission<?php echo $value->id;?>"/>

                                            {{ $value->name }}</label>
                                        <br/>
                                    @endforeach
                                </div>
                                <div class="col-12" align="right">
                                    <hr>
                                    <button type="submit"
                                            class="btn  btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Enregistrer
                                    </button>
                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                       href="{{route('roles.index')}}">
                                        Retour</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- END: Content-->
    </div>

    <!-- END: Content-->

@endsection
