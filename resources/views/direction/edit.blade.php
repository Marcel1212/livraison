@if(auth()->user()->can('direction-edit'))

@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Paramétrage')
    @php($titre='Liste des directions')
    @php($soustitre='Modifier une direction')
    @php($lien='direction')
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
                                    <form action="{{ route($lien.'.update',$direction->id_direction) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">

                                            <div class="col-md-10 col-12">
                                                <div class="mb-1">
                                                    <label>Libellé direction </label>
                                                    <input type="text" name="libelle_direction" id="libelle_direction"
                                                           value="{{$direction->libelle_direction }}"
                                                           class="form-control form-control-sm" placeholder="Code">
                                                </div>
                                            </div>


                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Actif </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_direction"
                                                           id="colorCheck1" {{  ($direction->flag_direction == true ? ' checked' : '') }}>
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

                                    <table class="table table-bordered table-striped table-hover table-sm"
                                    id="exampleData" >
                                 <thead>
                                 <tr>
                                     <th>No</th>
                                     <th>Departement</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 <?php $i = 0; ?>
                                 @foreach ($departementss as $departement)
                                     <tr>
                                     <td>{{ ++$i }}</td>
                                     <td>{{ @$departement->libelle_departement }}</td>

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


