{{--@if(auth()->user()->can('critereevaluationoffretech-create'))--}}
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Paramétrage')
    @php($titre='Liste des critères d\'évaluations d\'une offre technique')
    @php($soustitre='Ajouter un critère d\'évaluation d\'une offre technique')
    @php($lien='critereevaluationoffretech')


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
                                    <form method="POST" class="form" action="{{ route($lien.'.store') }}">
                                        @csrf
                                        <div class="row">

                                              <div class="col-md-10 col-12">
                                                <div class="mb-1">
                                                    <label>Critère d'évaluation offre technique</label>
                                                    <input type="text" name="libelle_critere_evaluation_offre_tech" id="libelle_critere_evaluation_offre_tech"
                                                           class="form-control form-control-sm"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Actif </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_critere_evaluation_offre_tech"
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
{{--@else--}}
{{-- <script type="text/javascript">--}}
{{--    window.location = "{{ url('/403') }}";//here double curly bracket--}}
{{--</script>--}}
{{--@endif--}}














