<section id="dashboard-ecommerce">
    <div class="row match-height">
        <!-- Medal Card -->
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card card-developer-meetup">
                <div class="bg-light-primary rounded-top text-center"><img
                        src="/app-assets/images/illustration/email.svg"
                        alt="Meeting Pic" height="170"></div>
                <div class="card-body">
                    <div class="meetup-header d-flex align-items-center">
                        <div class="meetup-day"><h6 class="mb-0"><?= date('m') ?></h6>
                            <h3 class="mb-0"><?= date('d') ?></h3></div>
                        <div class="my-auto"><h4 class="card-title mb-25">Bonjour {{Auth::user()->name}}</h4>
                            <p class="card-text mb-0">Bienvenue dans votre espace de travail</p></div>
                    </div>
                    <div align="center"><img width="80" src="/app-assets/images/logo/logoRAG.jpg"></div>


                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!--/ Medal Card -->

        <!-- Statistics Card -->
        <div class="col-xl-6 col-md-6 col-12">
            <div class="col-lg-12 col-12">
                <div class="row">

                    <div class=" col-lg-12  ">
                        <div align="center">
                            <canvas id="myChart"></canvas>
                            Etats des factures client
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--/ Statistics Card -->
    </div>


    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [<?php $numbtotal = count($dataFactClient); $l2 = 0; if ($dataFactClient != null) foreach ($dataFactClient as $resultat2) :$l2++; ?><?php echo("'" . $resultat2->lib_assureur . "'");
                    if ($l2 != $numbtotal) {
                        echo ',';
                    } ?><?php endforeach; ?>],
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# F CFA ',
                    data: [<?php  $l = 0; if ($dataFactClient != null) foreach ($dataFactClient as $resultat) :$l++; ?><?php echo round(($resultat->mtt), 0);
                        if ($l != $numbtotal) {
                            echo ',';
                        } ?><?php endforeach; ?>],

                    //data: [12, 19, 3, 5, 2, 3],
                    // borderWidth: 1
                }],
                // hoverOffset: 4
            },
            /* options: {
                 scales: {
                     y: {
                         beginAtZero: true
                     }
                 }
             }*/
        });
    </script>
</section>
