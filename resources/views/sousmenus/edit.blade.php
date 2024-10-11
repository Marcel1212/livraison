@if(auth()->user()->can('sous-module-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Liste des sous modules')
    @php($soustitre='Modifier un sous module')
    @php($lien='sousmenus')


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



        <!-- Basic Layout & Basic with Icons -->
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
                        <!--begin: Datatable-->

                        <form method="POST" class="form"
                              action="{{ route($lien.'.update', $sousmenus->id_sousmenu) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-8 col-12">
                                    <div class="mb-1">
                                        <label>Libellé </label>
                                        <input type="text" name="libelle" id="libelle"
                                               value="{{$sousmenus->libelle}}"
                                               class="form-control form-control-sm"
                                               placeholder="Libellé" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Module </label>
                                        <select class="select2 select2-size-sm form-select" data-allow-clear="true" name="menus" id="menus" required>
                                                <?php echo $menus; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Lien </label>
                                        <input type="text" name="sousmenu" id="sousmenu"
                                               value="{{$sousmenus->sousmenu}}"
                                               class="form-control form-control-sm"
                                               placeholder="Lien">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">

                                        <label>Priorité </label>
                                        <input type="text" name="priorite_sousmenu" id="priorite_sousmenu"
                                               value="{{$sousmenus->priorite_sousmenu}}"
                                               class="form-control form-control-sm" min="0"
                                               placeholder="Priorité" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label>Statut </label><br>
                                        <input type="checkbox" class="form-check-input" name="is_valide"
                                               id="colorCheck1" {{  ($sousmenus->is_valide == true ? ' checked' : '') }}>
                                    </div>
                                </div>
                                <div class="col-12" align="right">
                                    <hr>
                                    <button type="submit"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Enregistrer
                                    </button>
                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                                        Retour</a>
                                </div>
                            </div>
                        </form>
                        <!--end: Datatable-->
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
