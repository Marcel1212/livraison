<div class="card bg-transparent shadow-none my-4 border-0">
    <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
            <h3 class="text text-dark"> Bonjour {{Auth::user()->name .' '.Auth::user()->prenom_users}}</strong>, 👋🏻</h3>
            <div class="col-12 col-lg-12">
                <p>Bienvenue sur notre application web ! Nous sommes ravis de vous avoir parmi nous. Nous espérons que
                    vous apprécierez votre expérience avec nous !</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap gap-3 me-5">

            </div>
        </div>
        <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div>
                        <h5 class="mb-2">Time Spendings</h5>
                        <p class="mb-5">Weekly report</p>
                    </div>
                    <div class="time-spending-chart">
                        <h3 class="mb-2">231<span class="text-muted">h</span> 14<span
                                class="text-muted">m</span></h3>
                        <span class="badge bg-label-success">+18.4%</span>
                    </div>
                </div>
                <div id="leadsReportChart"></div>
            </div>
        </div>
    </div>
</div>
