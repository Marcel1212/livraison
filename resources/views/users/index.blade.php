@if (auth()->user()->can('users-index'))

    @extends('layouts.backLayout.designadmin')
    @section('content')
        @php($Module = 'Paramétrage')
        @php($titre = 'Liste des utilisateurs')
        @php($lien = 'users')
        <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light"> <i class="ti ti-home"></i> Accueil / {{ $Module }} / </span>
            {{ $titre }}
        </h5>

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
                        <h5 class="mb-0">{{ $titre }}</h5>
                        <small class="text-muted float-end">
                            @can($lien . '-create')
                                <a href="{{ route($lien . '.create') }}" class="btn btn-sm btn-primary waves-effect waves-light">
                                    <i class="menu-icon tf-icons ti ti-plus"></i> Ajouter </a>
                            @endcan
                        </small>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-striped table-hover table-sm " id="exampleData"
                            style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Noms et prénoms</th>
                                    <th>Email</th>
                                    <th>Profil</th>
                                    {{-- <th>Antenne</th> --}}
                                    <th>Actif</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name . '  ' . $user->prenom_users }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <span class="badge  bg-primary">{{ $v }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        {{-- <td>{{ @$user->agence->lib_agce }}</td> --}}
                                        <td align="center">
                                            <?php if ($user->flag_actif_users == true ){?>
                                            <span class="badge bg-success">Actif</span>
                                            <?php } else {?>
                                            <span class="badge bg-danger">Inactif</span>
                                            <?php }  ?>
                                        </td>
                                        <td align="center">
                                            @can($lien . '-edit')
                                                <a href="{{ route($lien . '.edit', \App\Helpers\Crypt::UrlCrypt($user->id)) }}"
                                                    class="text-warning" title="Modifier"><img
                                                        src='/assets/img/editing.png'></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    @endsection
@else
    <script type="text/javascript">
        window.location = "{{ url('/403') }}"; //here double curly bracket
    </script>
@endif
