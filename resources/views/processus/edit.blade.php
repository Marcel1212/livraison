@if(auth()->user()->can('processus-edit'))

@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
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
                                    <h5 class="mb-0">{{$titre}}</h5>
                                    <small class="text-muted float-end">

                                    </small>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $libPro = $ResPro->lib_processus;
                                    $IsValid = $ResPro->is_valide;
                                    ?>
                                    <form method="POST" class="form" action="{{ route($lien.'edit',\App\Helpers\Crypt::UrlCrypt($ResPro->id_processus)) }}">
                                        @csrf
                                        @method('POST')

                                    <input type="hidden" name="IdProc" value="<?= $ResPro->id_processus; ?>">

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Libellé </label>
                                                <input type="text" name="lib_processus" id="lib_processus"
                                                           class="form-control form-control-sm" value="{{$libPro}}"
                                                           required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label>Statut </label><br>
                                                <input type="checkbox" class="form-check-input" name="is_valide"
                                                       id="colorCheck1" {{  ($IsValid== true ? ' checked' : '') }}>

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
                                                    <th>Rôles</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $ResRole = DB::table('roles as r')
                                                    ->select('r.name', 'r.id', 'cp.id_combi_proc', 'cp.id_cont_agce', 'cp.is_valide', 'cp.priorite_combi_proc')
                                                    ->LeftJoin('combinaison_processus as cp', 'cp.id_roles', '=', 'r.id')
                                                    ->where('cp.id_processus', '=', $ResPro->id_processus)
                                                    ->get();

                                                ?>
                                                @foreach ($ResRole as $k => $res1)
                                                    <tr>
                                                        <td>

                                                            <input type="checkbox"
                                                                   class="form-check-input"
                                                                   name="is_valide_agce_role[{{$k+1}}]"
                                                                   id="is_valide_agce_role{{$k+1}}"
                                                            <?php if(isset($ResPro)) { ?>
                                                                {{ $res1->is_valide ==true ? 'checked':''}}
                                                            <?php } ?>
                                                            >
                                                        </td>
                                                        <td><input type="number"
                                                                   class="form-control col-md-1 "
                                                                   value="{{$res1->priorite_combi_proc}}"
                                                                   name="priorite[{{$k+1}}]"
                                                                   id="priorite{{$k+1}}"

                                                            >
                                                        </td>
                                                        <td><input type="hidden"
                                                                   name="IdRole[{{$k+1}}]"
                                                                   value="{{$res1->id_combi_proc}}">
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


