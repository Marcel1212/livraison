<?php
use App\Helpers\Menu;
$imagedashboard = Menu::get_info_acceuil();
$imagedashboard = Menu::get_info_image_dashboard();
?>


    <!-- Hour chart  -->
<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
            <h3 class="text text-dark"> Bonjour {{Auth::user()->name .' '.Auth::user()->prenom_users}}</strong>, 👋🏻</h3>
            <div class="col-12 col-lg-7">
                <p>Bienvenue sur notre application web ! Nous sommes ravis de vous avoir parmi nous. Nous espérons que
                    vous apprécierez votre expérience avec nous !</p>
            </div>

        </div>
        @include('dashboard.annee')
    </div>
</div>
<!-- Hour chart End  -->

<!-- Topic and Instructors -->
<div class="row mb-4 g-4">
    <div class="col-12 col-xl-12">
        <div class="card h-100">
            <div align="center" >
                <img  src="{{ asset('/frontend/logo/'. $imagedashboard->logo_logo)}}" alt="">
            </div>
        </div>
    </div>
</div>
<!--  Topic and Instructors  End-->



