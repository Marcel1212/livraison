@if(auth()->user()->can('typecomites-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Paramétrage')
    @php($titre='Liste des types de comités')
    @php($soustitre='Modifier  un type de comité')
    @php($lien='typecomites')


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


                    <div class="row">
                        <!-- Basic Layout -->
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">{{$titre}}</h5>
                                    <small class="text-muted float-end">

                                    </small>
                                </div>
                                <div class="card-body">
                                    <form method="POST" class="form" action="{{ route($lien.'.update',\App\Helpers\Crypt::UrlCrypt($typecomite->id_type_comite)) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">


                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Libellé</label>
                                                    <select class="select2 form-select" name="libelle_type_comite" id="libelle_type_comite" required>
                                                            <option value="<?php if($typecomite->libelle_type_comite=="Comité plénière"){
                                                                echo "Comité plénière";
                                                            }elseif ($typecomite->libelle_type_comite=="Comité de gestion") {
                                                                echo "Comité de gestion";
                                                            }elseif ($typecomite->libelle_type_comite=="Commission permanente") {
                                                                echo "Commission permanente";
                                                            }else {
                                                                echo "";
                                                            }?>"><?php if($typecomite->libelle_type_comite=="Comité plénière"){
                                                                echo "Comite pléniere";
                                                            }elseif ($typecomite->libelle_type_comite=="Comité de gestion") {
                                                                echo "Comite de gestion";
                                                            }elseif ($typecomite->libelle_type_comite=="Commission permanente") {
                                                                echo "Commission permanente";
                                                            }else {
                                                                echo "----Selectionnez le comiten----";
                                                            }?></option>
                                                            <option value="Comité plénière">Comité plénière</option>
                                                            <option value="Comité de gestion">Comité de gestion</option>
                                                            <option value="Commission permanente">Commission permanente</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Valeur min </label>
                                                    <input type="text" name="valeur_min_type_comite" id="valeur_min_type_comite"
                                                           class="form-control form-control-sm" value="{{$typecomite->valeur_min_type_comite}}" min="0">
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Valeur max </label>
                                                    <input type="text" name="valeur_max_type_comite" id="valeur_max_type_comite"
                                                           class="form-control form-control-sm" value="{{$typecomite->valeur_max_type_comite}}" min="0">
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Type prestation</label>
                                                    <select class="select2 form-select" name="code_type_comite" id="code_type_comite">
                                                            <option value="<?php if($typecomite->code_type_comite=="PF"){
                                                                                echo "PF";
                                                                            }elseif ($typecomite->code_type_comite=="PRF") {
                                                                                echo "PRF";
                                                                            }elseif ($typecomite->code_type_comite=="PE") {
                                                                                echo "PE";
                                                                            }else {
                                                                                echo "";
                                                                            }?>"><?php if($typecomite->code_type_comite=="PF"){
                                                                                echo "Plan de formation";
                                                                            }elseif ($typecomite->code_type_comite=="PRF") {
                                                                                echo "Projet de formation";
                                                                            }elseif ($typecomite->code_type_comite=="PE") {
                                                                                echo "Projet etude";
                                                                            }else {
                                                                                echo "----Selectionnez un type de prestation---";
                                                                            }?></option>
                                                            <option value="PF">Plan de formation</option>
                                                            <option value="PRF">Projet de formation</option>
                                                            <option value="PE">Projet étude</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Actif </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_actif_type_comite" {{  ($typecomite->flag_actif_type_comite == true ? ' checked' : '') }}
                                                           id="colorCheck1">
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
    <!-- END: Content-->

@endsection
@else
 <script type="text/javascript">
    window.location = "{{ url('/403') }}";//here double curly bracket
</script>
@endif
