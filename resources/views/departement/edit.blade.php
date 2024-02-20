@if(auth()->user()->can('departement-edit'))
@extends('layouts.backLayout.designadmin')
@section('content')
    @php($Module='Paramétrage')
    @php($titre='Liste des departements')
    @php($soustitre='Modifier une departement')
    @php($lien='departement')
    @php($lien1='caracteristiquemargedepartement')
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
                                    <form action="{{ route($lien.'.update',$departement->id_departement) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                    <label>Direction </label>
                                                    <select class="form-select" data-allow-clear="true" name="id_direction">
                                                        <?= $direction; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                    <label>Libelle direction </label>
                                                    <input type="text" name="libelle_departement" id="libelle_departement"
                                                           value="{{$departement->libelle_departement }}"
                                                           class="form-control form-control-sm" >
                                                </div>
                                            </div>


                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Statut </label><br>
                                                    <input type="checkbox" class="form-check-input" name="flag_departement"
                                                           id="colorCheck1" {{  ($departement->flag_departement == true ? ' checked' : '') }}>
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

                                    @can($lien1.'-index')
                                    <hr>
                                    <form action="{{ route($lien1.'.store') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="row">

                                            <input type="hidden" name="id_departement" value="{{ $departement->id_departement }}" />

                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Marge inférieure</label>
                                                    <input type="number" min="0" name="marge_inferieur_cmd" id="marge_inferieur_cmd"
                                                    class="form-control form-control-sm" >
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="mb-1">
                                                    <label>Marge supérieure</label>
                                                    <input type="number" min="0" name="marge_superieur_cmd" id="marge_superieur_cmd"
                                                    class="form-control form-control-sm" >
                                                </div>
                                            </div>

                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Ajouter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>

                                        <table class="table table-bordered table-striped table-hover table-sm" id="exampleData" >
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Marge inférieure</th>
                                                <th>Marge supérieure</th>
                                                <th>Statut</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; ?>
                                            @foreach ($carateristiquedepartements as $key => $res)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ number_format($res->marge_inferieur_cmd) }}</td>
                                                    <td>{{ number_format($res->marge_superieur_cmd) }}</td>
                                                    <td align="center">
                                                        <?php if($res->flag_cmd == true){ ?>
                                                            <span class="badge bg-success">Actif</span>
                                                        <?php  }else{?>
                                                            <span class="badge bg-danger">Inactif</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td align="center">
                                                        @can($lien1.'-delete')

                                                            <a href="{{ route($lien1.'.delete',$res->id_caracteristique_marge_departement) }}"
                                                            class="" onclick='javascript:if (!confirm("Voulez-vous supprimer cette ligne ?")) return false;'
                                                            title="Suprimer"> <img src='/assets/img/trash-can-solid.png'> </a>

                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @endcan
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


