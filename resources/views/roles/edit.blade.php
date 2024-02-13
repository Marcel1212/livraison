@if(auth()->user()->can('role-edit'))
@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Liste des profils')
    @php($soustitre='Modifier un profil')
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
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{$titre}}</h5>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <form action="{{ route('roles.update',\App\Helpers\Crypt::UrlCrypt($role->id)) }}"
                              method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="mb-1">
                                        <label>Libellé du profil</label>
                                        <input type="text" name="name" id="name" value="{{$role->name }}"
                                               class="form-control form-control-sm" placeholder="Libellé du profil">
                                    </div>
                                </div>
                                <div class="col-12" align="right">
                                    <hr>
                                    <button type="submit"
                                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                        Enregistrer
                                    </button>
                                    <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien}}">
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









