@if(auth()->user()->can('clederepartitionfinancement-edit'))

@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Parametrage')
    @php($titre='Liste des clés de répartitions de financement')
    @php($soustitre='Modifier une cle de répartition de financement')
    @php($lien='clederepartitionfinancement')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">

                            <div class="breadcrumb-wrapper">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$soustitre}} </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" class="form" action="{{ route($lien.'.update',\App\Helpers\Crypt::UrlCrypt($cle->id_cle_de_repartition_financement)) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Marge inférieure</label>
                                                    <input type="number" min="0" name="marge_inferieur" id="marge_inferieur"
                                                    class="form-control form-control-sm" value="{{$cle->marge_inferieur}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Marge supérieure</label>
                                                    <input type="number" min="0" name="marge_superieur" id="marge_superieur"
                                                    class="form-control form-control-sm" value="{{$cle->marge_superieur}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Montant FC</label>
                                                    <input type="number" min="0" name="montant_fc" id="montant_fc"
                                                    class="form-control form-control-sm" value="{{$cle->montant_fc}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Coefficient</label>
                                                    <input type="number" step="0.001" min="0" name="coefficient" id="coefficient"
                                                    class="form-control form-control-sm" value="{{$cle->coefficient}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Signe</label>
                                                    <select class="select2 form-select" data-allow-clear="true" name="signe_montant_fc" id="signe_montant_fc">
                                                        <option value="<?php if($cle->signe_montant_fc == "+"){
                                                            echo "+";
                                                        }else{
                                                            echo "-";
                                                        } ?>"><?php if($cle->signe_montant_fc == "+"){
                                                            echo "Positif";
                                                        }else{
                                                            echo "Negatif";
                                                        } ?></option>
                                                        <option value="+">Positif</option>
                                                        <option value="-">Negatif</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Observation</label>
                                                    <textarea name="observation" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$cle->observation}}</textarea>
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
@else
       <script type="text/javascript">
           window.location = "{{ url('/403') }}";//here double curly bracket
       </script>
   @endif
