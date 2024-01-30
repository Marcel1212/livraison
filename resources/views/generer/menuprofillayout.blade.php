@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Attribution')
    @php($lien='menus')

    <!-- BEGIN: Content-->
    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / </span> {{$titre}}
    </h5>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-body">
                {{ $message }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('menuprofillayout',$role->id) }}" method="POST">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="card mb-4">

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Profil : {{$role->name}}</h5>
                        <small class="text-muted float-end">
{{--                            @can('role-create')--}}
                                <button type="submit"
                                        class="btn btn-primary btn-sm waves-effect waves-float waves-light"><i
                                        class="la la-plus"></i>Attribuer
                                </button>
{{--                            @endcan--}}
                        </small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                        <?php
                                            $i=0;
                                        ?>

                            @foreach($tablsm as $key=>$tablvue)
                                            @foreach($tablvue as $key_vue=>$vue)
                                                    <?php
                                                    $i++;
                                                    ?>
                                        <div class="accordion mt-3 accordion-bordered" id="accordionStyle1">
                                            <div class="accordion-item card">

                                                <h2 class="accordion-header"
                                                    id="headingMarginOne{{$i}}">
                                                    <button class="accordion-button collapsed"
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#accordionMarginOne{{$i}}"
                                                            aria-expanded="false"
                                                            aria-controls="accordionMarginOne{{$i}}">
                                                        {{$key_vue}}
                                                    </button>
                                                </h2>
                                                <div id="accordionMarginOne{{$i}}"
                                                     class="accordion-collapse collapse"
                                                     aria-labelledby="headingMarginOne"
                                                     data-bs-parent="#accordionMargin">
                                                    @foreach($vue as $key_new_vue=>$new_vue)
                                                        <div class="accordion-body">
                                                            <div class="checkbox-list">
                                                                <label class="checkbox">
                                                                    <input type="checkbox"
                                                                        @foreach($new_vue as $permission_key=>$permission)
                                                                            value="{{$permission->id_sous_menu}}"
                                                                               <?php if (in_array($permission->id_sous_menu, $roleSousmenus)) {
                                                                                   echo 'checked';
                                                                               } ?>
                                                                           name="route[{{$permission->id_sous_menu}}]"
                                                                           id="route{{$permission->id_sous_menu}}"
                                                                        @endforeach
                                                                    />
                                                                    <span class="h5 mb-0">{{$key_new_vue}}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-2">
                                                            </div>

                                                            @foreach($new_vue as $permission_key=>$permission)
                                                                @isset($permission->lib_permission)

                                                                    <div class="col-2">
                                                                        <input
                                                                            type="checkbox"
                                                                            <?php if (in_array($permission->id, $role_permission)) {
                                                                                echo 'checked';
                                                                            } ?>

                                                                            value="<?php echo $permission->id;?>"
                                                                            name="permission[<?php echo $permission->id;?>]"
                                                                            id="permission<?php echo $permission->id;?>">
                                                                        <span class="custom-option-header">
                                                                            <span class="h6 mb-0">{{$permission->lib_permission}}</span> |
                                                                        </span>
                                                                    </div>
                                                                @endisset
                                                            @endforeach
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                            @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Accordion with margin end -->
            </div>
        </div>
    </form>
    <!-- END: Content-->

@endsection

