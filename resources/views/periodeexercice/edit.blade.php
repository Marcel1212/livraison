@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Parametrage')
    @php($titre='Liste des periodes d\'excercices')
    @php($soustitre='Modifier une periode d\'excercice')
    @php($lien='periodeexercice')


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
                                    <form method="POST" class="form" action="{{ route($lien.'.update',\App\Helpers\Crypt::UrlCrypt($periodeexercice->id_periode_exercice)) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Date de debut </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$periodeexercice->date_debut_periode_exercice}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                             
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Date de fin </label>
                                                    <input type="date" 
                                                           class="form-control form-control-sm" value="{{$periodeexercice->date_fin_periode_exercice}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Date de prolongation </label>
                                                    <input type="date" name="date_prolongation_periode_exercice" id="date_prolongation_periode_exercice"
                                                           class="form-control form-control-sm" value="{{$periodeexercice->date_prolongation_periode_exercice}}"
                                                           required>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire </label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" disabled="disabled">{{$periodeexercice->commentaire_periode_exercice}}</textarea>
                                                </div>
                                            </div>                                           
                                             <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Motif de prolongation </label>
                                                    <textarea name="motif_prolongation_periode_exercice" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$periodeexercice->motif_prolongation_periode_exercice}}</textarea>
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
