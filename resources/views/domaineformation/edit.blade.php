@if(auth()->user()->can('domaineformation-edit'))

@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Paramétrage')
    @php($titre='Liste des domaines formations')
    @php($soustitre='Modifier une domaine formation')
    @php($lien='domaineformation')
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
                                    <form action="{{ route($lien.'.update',\App\Helpers\Crypt::UrlCrypt($domaine->id_domaine_formation)) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Libellé domaine de formation  </label>
                                                    <input type="text" name="libelle_domaine_formation" id="libelle_domaine_formation"
                                                           value="{{$domaine->libelle_domaine_formation }}"
                                                           class="form-control form-control-sm" placeholder="Code">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Code </label>
                                                    <input type="number" name="code_domaine_formation" id="code_domaine_formation"
                                                           value="{{$domaine->code_domaine_formation }}"
                                                           class="form-control form-control-sm" placeholder="Code">
                                                </div>
                                            </div>


                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Actif </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_domaine_formation"
                                                           id="colorCheck1" {{  ($domaine->flag_domaine_formation == true ? ' checked' : '') }}>
                                                </div>
                                            </div>

                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit" name="action" value="Modifier"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>

                                    <hr/>

                                    <form action="{{ route($lien.'.update',\App\Helpers\Crypt::UrlCrypt($domaine->id_domaine_formation)) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">

                                            <div class="col-md-12">
                                                <label class="form-label" for="state">Cabinet de fomation<strong style="color:red;">*</strong></label>

                                                <select class="select2 form-select
                                                        @error('id_entreprises')
                                                            error
                                                       @enderror"
                                                        data-allow-clear="true" name="id_entreprises">
                                                    <option value="">-- Selectionnez le cabinet --
                                                    </option>
                                                    @foreach(@$cabinets as $cabinet)
                                                        <option value="{{$cabinet->id_entreprises}}"
                                                            {{(old('id_entreprises')==$cabinet->id_entreprises)? 'selected':''}}
                                                        >
                                                            {{mb_strtoupper($cabinet->ncc_entreprises)}} / {{mb_strtoupper($cabinet->raison_social_entreprises)}}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('id_entreprises')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror

                                            </div>

                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit" name="action" value="AjouterCabinet"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Ajouter
                                                </button>

                                            </div>
                                        </div>
                                    </form>

                                    <hr/>

                                    <table class="table table-bordered table-striped table-hover table-sm"
                                    id="exampleData" >
                                 <thead>
                                 <tr>
                                     <th>No</th>
                                     <th>Cabinet de fomation</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 <?php $i = 0; ?>
                                 @foreach ($domaineformationentreprises as $dfc)
                                     <tr>
                                     <td>{{ ++$i }}</td>
                                     <td>{{ @$dfc->entreprise->raison_social_entreprises }}</td>

                                     </tr>
                                 @endforeach

                                 </tbody>
                             </table>
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


