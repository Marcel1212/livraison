@if(auth()->user()->can('processus-create'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Parametrage')
    @php($titre='Liste des processus')
    @php($soustitre='Enregistrer un processus')
    @php($lien='processus')


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
                                    <h5 class="mb-0">{{$soustitre}}</h5>
                                    <small class="text-muted float-end">

                                    </small>
                                </div>
                                <div class="card-body">
                                    <form method="POST" class="form" action="{{ route($lien.'add') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Libellé </label>
                                                <input type="text" name="lib_processus" id="lib_processus"
                                                           class="form-control form-control-sm"
                                                           required>

                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Statut </label><br>
                                                <input type="checkbox" class="form-check-input" name="is_valide"
                                                       id="colorCheck1">

                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">

                                            <table
                                                class="table table-bordered table-striped table-hover table-sm "
                                            >
                                                <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Priorité</th>
                                                    <th>Roles</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach ($ResRole as $k => $res1)
                                                    <tr>
                                                        <td>

                                                            <input type="checkbox"
                                                                   class="form-check-input"
                                                                   name="is_valide_agce_role[{{$k+1}}]"
                                                                   id="is_valide_agce_role[{{$k+1}}]"

                                                            >
                                                        </td>
                                                        <td><input type="number"
                                                                   class="form-control col-md-1 "

                                                                   name="priorite[{{$k+1}}]"
                                                                   id="priorite{{$k+1}}"

                                                            >
                                                        </td>
                                                        <td><input type="hidden"
                                                                   name="IdRole[{{$k+1}}]"
                                                                   value="{{$res1->id}}">
                                                            {{strtoupper($res1->name)}} </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>



                                        </div>
                                        <div class="col-12" align="right">
                                            <hr>
                                            <button type="submit" name="BtnEnregistrer" value="BtnEnregistrer"
                                                    class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                Enregistrer
                                            </button>
                                            <a class="btn btn-outline-secondary waves-effect" href="/{{$lien }}">
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


