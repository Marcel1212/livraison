@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Attribution')
    @php($lien='menus')

    <!-- BEGIN: Content-->
                <h5 class="py-2 mb-1">
                    <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}}  </span> 
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


                <form action="{{ route('menuprofillayout',$role->id) }}" method="POST">
                    @csrf
                
                    <section id="multiple-column-form">
                        <div class="row">

                            <div class="col-12">
                                <div class="card mb-4">

                                    <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">{{$titre}} / Profil : {{$role->name}}</h5>
                                    <small class="text-muted float-end">
                                            @can('role-create')
                                                <button type="submit"
                                                        class="btn btn-primary btn-sm waves-effect waves-float waves-light"><i
                                                        class="la la-plus"></i>Attribuer</button>
                                            @endcan
                                    </small>
                                    </div>
                                    <!-- Accordion with margin start -->
                                    <section id="accordion-with-margin">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                            <?php $i = 0; foreach ($tablsm as $key => $tablvue) {
                                                            $i++; ?>
                                                        <div class="accordion accordion-margin" id="accordionMargin">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header"
                                                                    id="headingMarginOne<?php echo $key; ?>">
                                                                    <button class="accordion-button collapsed"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#accordionMarginOne<?php echo $key; ?>"
                                                                            aria-expanded="false"
                                                                            aria-controls="accordionMarginOne<?php echo $key; ?>">
                                                                            <?php //dd($tablvue); ?>
                                                                        {{  $tablvue[0]->menu }}
                                                                    </button>
                                                                </h2>
                                                                <div id="accordionMarginOne<?php echo $key; ?>"
                                                                     class="accordion-collapse collapse"
                                                                     aria-labelledby="headingMarginOne"
                                                                     data-bs-parent="#accordionMargin">

                                                                        <?php foreach ($tablvue as $key => $vue) { ?>
                                                                    <div class="accordion-body">
                                                                        <div class="checkbox-list">

                                                                            <label class="checkbox">
                                                                                <input type="checkbox"
                                                                                       value="<?php echo $vue->id_sousmenu;?>"
                                                                                       <?php if (in_array($vue->id_sousmenu, $roleSousmenus)) {
                                                                                           echo 'checked';
                                                                                       } ?> name="route[<?php echo $vue->id_sousmenu;?>]"
                                                                                       id="route<?php echo $vue->id_sousmenu;?>"/>
                                                                                <span></span><?php echo $vue->libelle; ?>
                                                                                                 <?php //echo $vue->lib_permission; ?>
                                                                            </label>

                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- Accordion with margin end -->
                                </div>
                            </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>


        </div>
    </div>
    <!-- END: Content-->

@endsection








