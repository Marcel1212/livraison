@if(auth()->user()->can('caracteristiquetypeformation-create'))



@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Parametrage')
    @php($titre='Liste des caractéristiques de type de formation')
    @php($soustitre='Ajouter une caractéristique de type de formation')
    @php($lien='caracteristiquetypeformation')

    <script type="text/javascript">

        function changeFunc() {
            //alert('text');exit;
            var selectBox = document.getElementById("code_ctf");
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;
            //alert(selectedValue);
            if(selectedValue === 'CCEF'){
                document.getElementById("cout_herbement_formateur_ctf").disabled = false;
            }else{
                document.getElementById("cout_herbement_formateur_ctf").disabled = true;
            }

        };

    </script>

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

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Type de formation </label>
                                                    <select class="select2 form-select"
                                                           data-allow-clear="true" name="id_type_formation"
                                                           required="required">
                                                       <option value="">-- Type de formation --</option>
                                                       @foreach ($typeformations as $typeformation)
                                                            <option value="{{$typeformation->id_type_formation}}">{{$typeformation->type_formation}}</option>
                                                       @endforeach
                                                   </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Libelle </label>
                                                    <input type="text" name="libelle_ctf" id="libelle_ctf"
                                                           class="form-control form-control-sm"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Montant </label>
                                                    <input type="number" min="0" name="montant_ctf" id="montant_ctf"
                                                           class="form-control form-control-sm"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Code </label>
                                                    <select class="select2 form-select"  data-allow-clear="true" name="code_ctf" id="code_ctf" onchange="changeFunc();" required="required">
                                                        <option value="">---Selectionnez un code---</option>
                                                        <option value="CGF">Cout par groupe de formation</option>
                                                        <option value="CSF">Cout par stagiaire de formation</option>
                                                        <option value="CFD">Cout formation diplômante</option>
                                                        <option value="CCEF">Cout par cabinet étranger de formation</option>
                                                        <option value="CSEF">Cout par stagiaire étranger de formation</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Montant hébergement </label>
                                                    <input type="number" min="0" name="cout_herbement_formateur_ctf" id="cout_herbement_formateur_ctf"
                                                           class="form-control form-control-sm"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Statut </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_ctf"
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














