<section id="dashboard-ecommerce">
    <div class="row match-height">
        <!-- Medal Card -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card card-developer-meetup">
                <div class="bg-light-primary rounded-top "  align="right"><img
                        src="/app-assets/images/illustration/email.svg"
                        alt="Meeting Pic" height="170"></div>
                <div class="card-body">
                    <div class="meetup-header d-flex align-items-center">
                        <div class="meetup-day"><h6 class="mb-0"><?= date('m') ?></h6>
                            <h3 class="mb-0"><?= date('d') ?></h3></div>
                        <div class="my-auto"><h4 class="card-title mb-25">Bonjour {{Auth::user()->name}}</h4>
                            <p class="card-text mb-0">Bienvenue dans votre espace de travail</p></div>
                    </div>


                </div>
            </div>
        </div>


    </div>




</section>
