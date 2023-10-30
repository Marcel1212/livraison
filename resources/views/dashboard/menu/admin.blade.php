<?php

use App\Helpers\Menu;

$imagedashboard = Menu::get_info_image_dashboard();
?>

<section id="dashboard-ecommerce">
    <div class="alert alert-info" role="alert">
        <div class="alert-body text-center"><strong>
                Bonjour {{Auth::user()->name .' '.Auth::user()->prenom_users}}</strong>, Bienvenue dans votre espace de
            travail.

        </div>
    </div>
    <div class="my-auto"><h4 class="card-title mb-25"></h4>
        <p class="card-text mb-0"></p></div>
    <div class="row match-height">
        <!-- Medal Card -->
        <div class="col-xl-4 col-md-6 col-12">
            <div class="card card-congratulation-medal">
                <div class="card">
                    <!--<img class="card-img-top" src="/app-assets/images/body.png" alt="Card image cap">-->
                    <?php if(isset($imagedashboard->logo_logo)){?>
                        <img class="card-img-top" src="{{ asset('/frontend/logo/'. @$imagedashboard->logo_logo)}}" height="180" style="margin:5px; padding: 5px"/>
                    <?php } ?>
                    <!--<img class="card-img-top" src="/app-assets/images/body.png" alt="Card image cap">-->
                </div>
            </div>
        </div>
        <!--/ Medal Card -->

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Statistics Card -->
        <div class="col-xl-8 col-md-6 col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">Statistiques</h4>
                    <div class="d-flex align-items-center">
                    </div>
                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-trending-up avatar-icon">
                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                            <polyline points="17 6 23 6 23 12"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0"></h4>
                                    <p class="card-text font-small-3 mb-0">Commande(s) journalière</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-success me-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-dollar-sign avatar-icon">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0"></h4>
                                    <p class="card-text font-small-3 mb-0">Revenus journalier</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-info me-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-user avatar-icon">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0"></h4>
                                    <p class="card-text font-small-3 mb-0">Clients</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-danger me-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-box avatar-icon">
                                            <path
                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                        </svg>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0"> </h4>
                                    <p class="card-text font-small-3 mb-0">Produits</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--/ Statistics Card -->
    </div>

    <div class="row match-height">
        <div class="col-lg-4 col-12">
            <div class="row match-height">
                <!-- Bar Chart - Orders -->
                <div class="col-lg-6 col-md-3 col-6">
                    <div class="card">
                        <div class="card-body pb-50" style="position: relative;">
                            <h6>Nombre d'utilisateur</h6>
                            <h2 class="fw-bolder mb-1">{{number_format($dataUser->nb_user,0,' ',' ')}}
                                utilisateur(s)</h2>
                            <div id="statistics-order-chart" style="min-height: 85px;">
                                <div id="apexchartssyclkfk3"
                                     class="apexcharts-canvas apexchartssyclkfk3 apexcharts-theme-light"
                                     style="width: 243px; height: 70px;">
                                    <svg id="SvgjsSvg1387" width="243" height="70" xmlns="http://www.w3.org/2000/svg"
                                         version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg apexcharts-zoomable"
                                         xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                         style="background: transparent;">
                                        <g id="SvgjsG1389" class="apexcharts-inner apexcharts-graphical"
                                           transform="translate(17.1, 15)">
                                            <defs id="SvgjsDefs1388">
                                                <linearGradient id="SvgjsLinearGradient1392" x1="0" y1="0" x2="0"
                                                                y2="1">
                                                    <stop id="SvgjsStop1393" stop-opacity="0.4"
                                                          stop-color="rgba(216,227,240,0.4)" offset="0"></stop>
                                                    <stop id="SvgjsStop1394" stop-opacity="0.5"
                                                          stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                                    <stop id="SvgjsStop1395" stop-opacity="0.5"
                                                          stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                                </linearGradient>
                                                <clipPath id="gridRectMasksyclkfk3">
                                                    <rect id="SvgjsRect1397" width="247" height="55" x="-15.1" y="0"
                                                          rx="0" ry="0" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                                <clipPath id="gridRectMarkerMasksyclkfk3">
                                                    <rect id="SvgjsRect1398" width="220.8" height="59" x="-2" y="-2"
                                                          rx="0" ry="0" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                            </defs>
                                            <rect id="SvgjsRect1396" width="10.84" height="55" x="0" y="0" rx="0" ry="0"
                                                  opacity="1" stroke-width="0" stroke-dasharray="3"
                                                  fill="url(#SvgjsLinearGradient1392)" class="apexcharts-xcrosshairs"
                                                  y2="55" filter="none" fill-opacity="0.9"></rect>
                                            <g id="SvgjsG1412" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                <g id="SvgjsG1413" class="apexcharts-xaxis-texts-g"
                                                   transform="translate(0, -4)"></g>
                                            </g>
                                            <g id="SvgjsG1415" class="apexcharts-grid">
                                                <g id="SvgjsG1416" class="apexcharts-gridlines-horizontal"
                                                   style="display: none;">
                                                    <line id="SvgjsLine1418" x1="-13.1" y1="0" x2="229.9" y2="0"
                                                          stroke="#e0e0e0" stroke-dasharray="0"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1419" x1="-13.1" y1="11" x2="229.9" y2="11"
                                                          stroke="#e0e0e0" stroke-dasharray="0"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1420" x1="-13.1" y1="22" x2="229.9" y2="22"
                                                          stroke="#e0e0e0" stroke-dasharray="0"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1421" x1="-13.1" y1="33" x2="229.9" y2="33"
                                                          stroke="#e0e0e0" stroke-dasharray="0"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1422" x1="-13.1" y1="44" x2="229.9" y2="44"
                                                          stroke="#e0e0e0" stroke-dasharray="0"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1423" x1="-13.1" y1="55" x2="229.9" y2="55"
                                                          stroke="#e0e0e0" stroke-dasharray="0"
                                                          class="apexcharts-gridline"></line>
                                                </g>
                                                <g id="SvgjsG1417" class="apexcharts-gridlines-vertical"
                                                   style="display: none;"></g>
                                                <line id="SvgjsLine1425" x1="0" y1="55" x2="216.8" y2="55"
                                                      stroke="transparent" stroke-dasharray="0"></line>
                                                <line id="SvgjsLine1424" x1="0" y1="1" x2="0" y2="55"
                                                      stroke="transparent" stroke-dasharray="0"></line>
                                            </g>
                                            <g id="SvgjsG1399" class="apexcharts-bar-series apexcharts-plot-series">
                                                <g id="SvgjsG1400" class="apexcharts-series" seriesName="2020" rel="1"
                                                   data:realIndex="0">
                                                    <rect id="SvgjsRect1402" width="10.84" height="55" x="-5.42" y="0"
                                                          rx="5" ry="5" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0" fill="#f3f3f3"
                                                          class="apexcharts-backgroundBar"></rect>
                                                    <path id="SvgjsPath1403"
                                                          d="M -5.42 52.29L -5.42 30.25L 5.42 30.25L 5.42 30.25L 5.42 52.29Q 0 57.71 -5.42 52.29z"
                                                          fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                          stroke-opacity="1" stroke-linecap="square" stroke-width="0"
                                                          stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                          clip-path="url(#gridRectMasksyclkfk3)"
                                                          pathTo="M -5.42 52.29L -5.42 30.25L 5.42 30.25L 5.42 30.25L 5.42 52.29Q 0 57.71 -5.42 52.29z"
                                                          pathFrom="M -5.42 52.29L -5.42 55L 5.42 55L 5.42 55L 5.42 55L -5.42 55"
                                                          cy="30.25" cx="5.419999999999998" j="0" val="45"
                                                          barHeight="24.75" barWidth="10.84"></path>
                                                    <rect id="SvgjsRect1404" width="10.84" height="55" x="48.78" y="0"
                                                          rx="5" ry="5" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0" fill="#f3f3f3"
                                                          class="apexcharts-backgroundBar"></rect>
                                                    <path id="SvgjsPath1405"
                                                          d="M 48.78 52.29L 48.78 8.25L 59.620000000000005 8.25L 59.620000000000005 8.25L 59.620000000000005 52.29Q 54.2 57.71 48.78 52.29z"
                                                          fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                          stroke-opacity="1" stroke-linecap="square" stroke-width="0"
                                                          stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                          clip-path="url(#gridRectMasksyclkfk3)"
                                                          pathTo="M 48.78 52.29L 48.78 8.25L 59.620000000000005 8.25L 59.620000000000005 8.25L 59.620000000000005 52.29Q 54.2 57.71 48.78 52.29z"
                                                          pathFrom="M 48.78 52.29L 48.78 55L 59.620000000000005 55L 59.620000000000005 55L 59.620000000000005 55L 48.78 55"
                                                          cy="8.25" cx="59.620000000000005" j="1" val="85"
                                                          barHeight="46.75" barWidth="10.84"></path>
                                                    <rect id="SvgjsRect1406" width="10.84" height="55" x="102.98" y="0"
                                                          rx="5" ry="5" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0" fill="#f3f3f3"
                                                          class="apexcharts-backgroundBar"></rect>
                                                    <path id="SvgjsPath1407"
                                                          d="M 102.98 52.29L 102.98 19.25L 113.82000000000001 19.25L 113.82000000000001 19.25L 113.82000000000001 52.29Q 108.4 57.71 102.98 52.29z"
                                                          fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                          stroke-opacity="1" stroke-linecap="square" stroke-width="0"
                                                          stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                          clip-path="url(#gridRectMasksyclkfk3)"
                                                          pathTo="M 102.98 52.29L 102.98 19.25L 113.82000000000001 19.25L 113.82000000000001 19.25L 113.82000000000001 52.29Q 108.4 57.71 102.98 52.29z"
                                                          pathFrom="M 102.98 52.29L 102.98 55L 113.82000000000001 55L 113.82000000000001 55L 113.82000000000001 55L 102.98 55"
                                                          cy="19.25" cx="113.82000000000001" j="2" val="65"
                                                          barHeight="35.75" barWidth="10.84"></path>
                                                    <rect id="SvgjsRect1408" width="10.84" height="55" x="157.18" y="0"
                                                          rx="5" ry="5" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0" fill="#f3f3f3"
                                                          class="apexcharts-backgroundBar"></rect>
                                                    <path id="SvgjsPath1409"
                                                          d="M 157.18 52.29L 157.18 30.25L 168.02 30.25L 168.02 30.25L 168.02 52.29Q 162.6 57.71 157.18 52.29z"
                                                          fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                          stroke-opacity="1" stroke-linecap="square" stroke-width="0"
                                                          stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                          clip-path="url(#gridRectMasksyclkfk3)"
                                                          pathTo="M 157.18 52.29L 157.18 30.25L 168.02 30.25L 168.02 30.25L 168.02 52.29Q 162.6 57.71 157.18 52.29z"
                                                          pathFrom="M 157.18 52.29L 157.18 55L 168.02 55L 168.02 55L 168.02 55L 157.18 55"
                                                          cy="30.25" cx="168.02" j="3" val="45" barHeight="24.75"
                                                          barWidth="10.84"></path>
                                                    <rect id="SvgjsRect1410" width="10.84" height="55"
                                                          x="211.38000000000002" y="0" rx="5" ry="5" opacity="1"
                                                          stroke-width="0" stroke="none" stroke-dasharray="0"
                                                          fill="#f3f3f3" class="apexcharts-backgroundBar"></rect>
                                                    <path id="SvgjsPath1411"
                                                          d="M 211.38000000000002 52.29L 211.38000000000002 19.25L 222.22000000000003 19.25L 222.22000000000003 19.25L 222.22000000000003 52.29Q 216.8 57.71 211.38000000000002 52.29z"
                                                          fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                          stroke-opacity="1" stroke-linecap="square" stroke-width="0"
                                                          stroke-dasharray="0" class="apexcharts-bar-area" index="0"
                                                          clip-path="url(#gridRectMasksyclkfk3)"
                                                          pathTo="M 211.38000000000002 52.29L 211.38000000000002 19.25L 222.22000000000003 19.25L 222.22000000000003 19.25L 222.22000000000003 52.29Q 216.8 57.71 211.38000000000002 52.29z"
                                                          pathFrom="M 211.38000000000002 52.29L 211.38000000000002 55L 222.22000000000003 55L 222.22000000000003 55L 222.22000000000003 55L 211.38000000000002 55"
                                                          cy="19.25" cx="222.22000000000006" j="4" val="65"
                                                          barHeight="35.75" barWidth="10.84"></path>
                                                </g>
                                                <g id="SvgjsG1401" class="apexcharts-datalabels" data:realIndex="0"></g>
                                            </g>
                                            <line id="SvgjsLine1426" x1="-13.1" y1="0" x2="229.9" y2="0"
                                                  stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                  class="apexcharts-ycrosshairs"></line>
                                            <line id="SvgjsLine1427" x1="-13.1" y1="0" x2="229.9" y2="0"
                                                  stroke-dasharray="0" stroke-width="0"
                                                  class="apexcharts-ycrosshairs-hidden"></line>
                                            <g id="SvgjsG1428" class="apexcharts-yaxis-annotations"></g>
                                            <g id="SvgjsG1429" class="apexcharts-xaxis-annotations"></g>
                                            <g id="SvgjsG1430" class="apexcharts-point-annotations"></g>
                                            <rect id="SvgjsRect1431" width="0" height="0" x="0" y="0" rx="0" ry="0"
                                                  opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                                  fill="#fefefe" class="apexcharts-zoom-rect"></rect>
                                            <rect id="SvgjsRect1432" width="0" height="0" x="0" y="0" rx="0" ry="0"
                                                  opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                                  fill="#fefefe" class="apexcharts-selection-rect"></rect>
                                        </g>
                                        <g id="SvgjsG1414" class="apexcharts-yaxis" rel="0"
                                           transform="translate(-18, 0)"></g>
                                        <g id="SvgjsG1390" class="apexcharts-annotations"></g>
                                    </svg>
                                    <div class="apexcharts-legend" style="max-height: 35px;"></div>
                                    <div class="apexcharts-tooltip apexcharts-theme-light">
                                        <div class="apexcharts-tooltip-series-group" style="order: 1;"><span
                                                class="apexcharts-tooltip-marker"
                                                style="background-color: rgb(255, 159, 67);"></span>
                                            <div class="apexcharts-tooltip-text"
                                                 style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                <div class="apexcharts-tooltip-y-group"><span
                                                        class="apexcharts-tooltip-text-label"></span><span
                                                        class="apexcharts-tooltip-text-value"></span></div>
                                                <div class="apexcharts-tooltip-z-group"><span
                                                        class="apexcharts-tooltip-text-z-label"></span><span
                                                        class="apexcharts-tooltip-text-z-value"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                        <div class="apexcharts-yaxistooltip-text"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="resize-triggers">
                                <div class="expand-trigger">
                                    <div style="width: 286px; height: 181px;"></div>
                                </div>
                                <div class="contract-trigger"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Bar Chart - Orders -->

                <!-- Line Chart - Profit -->
                <div class="col-lg-6 col-md-3 col-6">
                    <div class="card card-tiny-line-stats">
                        <div class="card-body pb-50" style="position: relative;">
                            <h6>Meilleur produit vendu</h6>
                            <h2 class="fw-bolder mb-1">6,24k</h2>
                            <div id="statistics-profit-chart" style="min-height: 85px;">
                                <div id="apexchartsnkgrtff3"
                                     class="apexcharts-canvas apexchartsnkgrtff3 apexcharts-theme-light"
                                     style="width: 243px; height: 70px;">
                                    <svg id="SvgjsSvg1433" width="243" height="70" xmlns="http://www.w3.org/2000/svg"
                                         version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                         xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                         style="background: transparent;">
                                        <g id="SvgjsG1435" class="apexcharts-inner apexcharts-graphical"
                                           transform="translate(12, 0)">
                                            <defs id="SvgjsDefs1434">
                                                <clipPath id="gridRectMasknkgrtff3">
                                                    <rect id="SvgjsRect1440" width="228" height="68" x="-3.5" y="-1.5"
                                                          rx="0" ry="0" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                                <clipPath id="gridRectMarkerMasknkgrtff3">
                                                    <rect id="SvgjsRect1441" width="233" height="77" x="-6" y="-6"
                                                          rx="0" ry="0" opacity="1" stroke-width="0" stroke="none"
                                                          stroke-dasharray="0" fill="#fff"></rect>
                                                </clipPath>
                                            </defs>
                                            <line id="SvgjsLine1439" x1="220.5" y1="0" x2="220.5" y2="65"
                                                  stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs"
                                                  x="220.5" y="0" width="1" height="65" fill="#b1b9c4" filter="none"
                                                  fill-opacity="0.9" stroke-width="1"></line>
                                            <g id="SvgjsG1458" class="apexcharts-xaxis" transform="translate(0, 0)">
                                                <g id="SvgjsG1459" class="apexcharts-xaxis-texts-g"
                                                   transform="translate(0, -4)">
                                                    <text id="SvgjsText1461" font-family="Helvetica, Arial, sans-serif"
                                                          x="0" y="94" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="0px" font-weight="400" fill="#373d3f"
                                                          class="apexcharts-text apexcharts-xaxis-label "
                                                          style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1462">1</tspan>
                                                        <title>1</title></text>
                                                    <text id="SvgjsText1464" font-family="Helvetica, Arial, sans-serif"
                                                          x="44.20000000000001" y="94" text-anchor="middle"
                                                          dominant-baseline="auto" font-size="0px" font-weight="400"
                                                          fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                          style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1465">2</tspan>
                                                        <title>2</title></text>
                                                    <text id="SvgjsText1467" font-family="Helvetica, Arial, sans-serif"
                                                          x="88.4" y="94" text-anchor="middle" dominant-baseline="auto"
                                                          font-size="0px" font-weight="400" fill="#373d3f"
                                                          class="apexcharts-text apexcharts-xaxis-label "
                                                          style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1468">3</tspan>
                                                        <title>3</title></text>
                                                    <text id="SvgjsText1470" font-family="Helvetica, Arial, sans-serif"
                                                          x="132.60000000000002" y="94" text-anchor="middle"
                                                          dominant-baseline="auto" font-size="0px" font-weight="400"
                                                          fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                          style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1471">4</tspan>
                                                        <title>4</title></text>
                                                    <text id="SvgjsText1473" font-family="Helvetica, Arial, sans-serif"
                                                          x="176.80000000000004" y="94" text-anchor="middle"
                                                          dominant-baseline="auto" font-size="0px" font-weight="400"
                                                          fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                          style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1474">5</tspan>
                                                        <title>5</title></text>
                                                    <text id="SvgjsText1476" font-family="Helvetica, Arial, sans-serif"
                                                          x="221.00000000000003" y="94" text-anchor="middle"
                                                          dominant-baseline="auto" font-size="0px" font-weight="400"
                                                          fill="#373d3f" class="apexcharts-text apexcharts-xaxis-label "
                                                          style="font-family: Helvetica, Arial, sans-serif;">
                                                        <tspan id="SvgjsTspan1477">6</tspan>
                                                        <title>6</title></text>
                                                </g>
                                            </g>
                                            <g id="SvgjsG1479" class="apexcharts-grid">
                                                <g id="SvgjsG1480" class="apexcharts-gridlines-horizontal"></g>
                                                <g id="SvgjsG1481" class="apexcharts-gridlines-vertical">
                                                    <line id="SvgjsLine1482" x1="0" y1="0" x2="0" y2="65"
                                                          stroke="#ebebeb" stroke-dasharray="5"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1483" x1="44.2" y1="0" x2="44.2" y2="65"
                                                          stroke="#ebebeb" stroke-dasharray="5"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1484" x1="88.4" y1="0" x2="88.4" y2="65"
                                                          stroke="#ebebeb" stroke-dasharray="5"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1485" x1="132.60000000000002" y1="0"
                                                          x2="132.60000000000002" y2="65" stroke="#ebebeb"
                                                          stroke-dasharray="5" class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1486" x1="176.8" y1="0" x2="176.8" y2="65"
                                                          stroke="#ebebeb" stroke-dasharray="5"
                                                          class="apexcharts-gridline"></line>
                                                    <line id="SvgjsLine1487" x1="221" y1="0" x2="221" y2="65"
                                                          stroke="#ebebeb" stroke-dasharray="5"
                                                          class="apexcharts-gridline"></line>
                                                </g>
                                                <line id="SvgjsLine1489" x1="0" y1="65" x2="221" y2="65"
                                                      stroke="transparent" stroke-dasharray="0"></line>
                                                <line id="SvgjsLine1488" x1="0" y1="1" x2="0" y2="65"
                                                      stroke="transparent" stroke-dasharray="0"></line>
                                            </g>
                                            <g id="SvgjsG1442" class="apexcharts-line-series apexcharts-plot-series">
                                                <g id="SvgjsG1443" class="apexcharts-series" seriesName="seriesx1"
                                                   data:longestSeries="true" rel="1" data:realIndex="0">
                                                    <path id="SvgjsPath1457"
                                                          d="M 0 65L 44.2 39L 88.4 58.5L 132.6 26L 176.8 45.5L 221 6.5"
                                                          fill="none" fill-opacity="1" stroke="rgba(0,207,232,0.85)"
                                                          stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                          stroke-dasharray="0" class="apexcharts-line" index="0"
                                                          clip-path="url(#gridRectMasknkgrtff3)"
                                                          pathTo="M 0 65L 44.2 39L 88.4 58.5L 132.6 26L 176.8 45.5L 221 6.5"
                                                          pathFrom="M -1 65L -1 65L 44.2 65L 88.4 65L 132.6 65L 176.8 65L 221 65"></path>
                                                    <g id="SvgjsG1444" class="apexcharts-series-markers-wrap"
                                                       data:realIndex="0">
                                                        <g id="SvgjsG1446" class="apexcharts-series-markers"
                                                           clip-path="url(#gridRectMarkerMasknkgrtff3)">
                                                            <circle id="SvgjsCircle1447" r="2" cx="0" cy="65"
                                                                    class="apexcharts-marker no-pointer-events w53jbx2nv"
                                                                    stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                    stroke-width="2" stroke-opacity="1" rel="0" j="0"
                                                                    index="0" default-marker-size="2"></circle>
                                                            <circle id="SvgjsCircle1448" r="2" cx="44.2" cy="39"
                                                                    class="apexcharts-marker no-pointer-events wsj546bhr"
                                                                    stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                    stroke-width="2" stroke-opacity="1" rel="1" j="1"
                                                                    index="0" default-marker-size="2"></circle>
                                                        </g>
                                                        <g id="SvgjsG1449" class="apexcharts-series-markers"
                                                           clip-path="url(#gridRectMarkerMasknkgrtff3)">
                                                            <circle id="SvgjsCircle1450" r="2" cx="88.4" cy="58.5"
                                                                    class="apexcharts-marker no-pointer-events wsygzwy7n"
                                                                    stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                    stroke-width="2" stroke-opacity="1" rel="2" j="2"
                                                                    index="0" default-marker-size="2"></circle>
                                                        </g>
                                                        <g id="SvgjsG1451" class="apexcharts-series-markers"
                                                           clip-path="url(#gridRectMarkerMasknkgrtff3)">
                                                            <circle id="SvgjsCircle1452" r="2" cx="132.6" cy="26"
                                                                    class="apexcharts-marker no-pointer-events wtcd9oodg"
                                                                    stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                    stroke-width="2" stroke-opacity="1" rel="3" j="3"
                                                                    index="0" default-marker-size="2"></circle>
                                                        </g>
                                                        <g id="SvgjsG1453" class="apexcharts-series-markers"
                                                           clip-path="url(#gridRectMarkerMasknkgrtff3)">
                                                            <circle id="SvgjsCircle1454" r="2" cx="176.8" cy="45.5"
                                                                    class="apexcharts-marker no-pointer-events wlot12wgz"
                                                                    stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                    stroke-width="2" stroke-opacity="1" rel="4" j="4"
                                                                    index="0" default-marker-size="2"></circle>
                                                        </g>
                                                        <g id="SvgjsG1455" class="apexcharts-series-markers"
                                                           clip-path="url(#gridRectMarkerMasknkgrtff3)">
                                                            <circle id="SvgjsCircle1456" r="5" cx="221" cy="6.5"
                                                                    class="apexcharts-marker no-pointer-events wq6fajfr"
                                                                    stroke="#00cfe8" fill="#ffffff" fill-opacity="1"
                                                                    stroke-width="2" stroke-opacity="1" rel="5" j="5"
                                                                    index="0" default-marker-size="5"></circle>
                                                        </g>
                                                    </g>
                                                </g>
                                                <g id="SvgjsG1445" class="apexcharts-datalabels" data:realIndex="0"></g>
                                            </g>
                                            <line id="SvgjsLine1490" x1="0" y1="0" x2="221" y2="0" stroke="#b6b6b6"
                                                  stroke-dasharray="0" stroke-width="1"
                                                  class="apexcharts-ycrosshairs"></line>
                                            <line id="SvgjsLine1491" x1="0" y1="0" x2="221" y2="0" stroke-dasharray="0"
                                                  stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line>
                                            <g id="SvgjsG1492" class="apexcharts-yaxis-annotations"></g>
                                            <g id="SvgjsG1493" class="apexcharts-xaxis-annotations"></g>
                                            <g id="SvgjsG1494" class="apexcharts-point-annotations"></g>
                                        </g>
                                        <rect id="SvgjsRect1438" width="0" height="0" x="0" y="0" rx="0" ry="0"
                                              opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                              fill="#fefefe"></rect>
                                        <g id="SvgjsG1478" class="apexcharts-yaxis" rel="0"
                                           transform="translate(-18, 0)"></g>
                                        <g id="SvgjsG1436" class="apexcharts-annotations"></g>
                                    </svg>
                                    <div class="apexcharts-legend" style="max-height: 35px;"></div>
                                    <div class="apexcharts-tooltip apexcharts-theme-light"
                                         style="left: 108.609px; top: 8px;">
                                        <div class="apexcharts-tooltip-series-group apexcharts-active"
                                             style="order: 1; display: flex;"><span class="apexcharts-tooltip-marker"
                                                                                    style="background-color: rgb(0, 207, 232);"></span>
                                            <div class="apexcharts-tooltip-text"
                                                 style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                <div class="apexcharts-tooltip-y-group"><span
                                                        class="apexcharts-tooltip-text-label">series-1: </span><span
                                                        class="apexcharts-tooltip-text-value">45</span></div>
                                                <div class="apexcharts-tooltip-z-group"><span
                                                        class="apexcharts-tooltip-text-z-label"></span><span
                                                        class="apexcharts-tooltip-text-z-value"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light"
                                        style="left: 217.461px; top: 67px;">
                                        <div class="apexcharts-xaxistooltip-text"
                                             style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; min-width: 9px;">
                                            6
                                        </div>
                                    </div>
                                    <div
                                        class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                        <div class="apexcharts-yaxistooltip-text"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="resize-triggers">
                                <div class="expand-trigger">
                                    <div style="width: 286px; height: 181px;"></div>
                                </div>
                                <div class="contract-trigger"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Line Chart - Profit -->

                <!-- Earnings Card -->
                <div class="col-lg-12 col-md-6 col-12">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title mb-1">Meilleure prestation de l'année</h4>
                                    <div class="font-small-2"></div>
                                    <h4 class="mb-1"></h4>
                                    <h5 class="mb-1"></h5>

                                </div>
                                <div class="col-6" style="position: relative;">
                                    <div id="earnings-chart" style="min-height: 126.8px;">
                                        <div id="apexchartswp9a8a9oh"
                                             class="apexcharts-canvas apexchartswp9a8a9oh apexcharts-theme-light"
                                             style="width: 264px; height: 126.8px;">
                                            <svg id="SvgjsSvg1495" width="264" height="126.8"
                                                 xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                 xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                 style="background: transparent;">
                                                <g id="SvgjsG1497" class="apexcharts-inner apexcharts-graphical"
                                                   transform="translate(52, 0)">
                                                    <defs id="SvgjsDefs1496">
                                                        <clipPath id="gridRectMaskwp9a8a9oh">
                                                            <rect id="SvgjsRect1499" width="164" height="128" x="-2"
                                                                  y="0" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                  stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                        </clipPath>
                                                        <clipPath id="gridRectMarkerMaskwp9a8a9oh">
                                                            <rect id="SvgjsRect1500" width="164" height="132" x="-2"
                                                                  y="-2" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                  stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                                        </clipPath>
                                                    </defs>
                                                    <g id="SvgjsG1501" class="apexcharts-pie">
                                                        <g id="SvgjsG1502" transform="translate(0, 0) scale(1)">
                                                            <circle id="SvgjsCircle1503" r="37.98536585365854" cx="80"
                                                                    cy="64" fill="transparent"></circle>
                                                            <g id="SvgjsG1504" class="apexcharts-slices">
                                                                <g id="SvgjsG1505"
                                                                   class="apexcharts-series apexcharts-pie-series"
                                                                   seriesName="App" rel="1" data:realIndex="0">
                                                                    <path id="SvgjsPath1506"
                                                                          d="M 69.85216991000085 6.448795702018273 A 58.43902439024391 58.43902439024391 0 1 1 79.1840638026197 122.43332798844617 L 79.46964147170281 101.98166319249002 A 37.98536585365854 37.98536585365854 0 1 0 73.40391044150056 26.591717206311877 L 69.85216991000085 6.448795702018273 z"
                                                                          fill="#28c76f66" fill-opacity="1"
                                                                          stroke-opacity="1" stroke-linecap="butt"
                                                                          stroke-width="0" stroke-dasharray="0"
                                                                          class="apexcharts-pie-area apexcharts-donut-slice-0"
                                                                          index="0" j="0" data:angle="190.8"
                                                                          data:startAngle="-10" data:strokeWidth="0"
                                                                          data:value="53"
                                                                          data:pathOrig="M 69.85216991000085 6.448795702018273 A 58.43902439024391 58.43902439024391 0 1 1 79.1840638026197 122.43332798844617 L 79.46964147170281 101.98166319249002 A 37.98536585365854 37.98536585365854 0 1 0 73.40391044150056 26.591717206311877 L 69.85216991000085 6.448795702018273 z"></path>
                                                                </g>
                                                                <g id="SvgjsG1507"
                                                                   class="apexcharts-series apexcharts-pie-series"
                                                                   seriesName="Service" rel="2" data:realIndex="1">
                                                                    <path id="SvgjsPath1508"
                                                                          d="M 79.1840638026197 122.43332798844617 A 58.43902439024391 58.43902439024391 0 0 1 30.22590892178677 94.6212251391295 L 47.646840799161396 83.90379634043418 A 37.98536585365854 37.98536585365854 0 0 0 79.46964147170281 101.98166319249002 L 79.1840638026197 122.43332798844617 z"
                                                                          fill="#28c76f33" fill-opacity="1"
                                                                          stroke-opacity="1" stroke-linecap="butt"
                                                                          stroke-width="0" stroke-dasharray="0"
                                                                          class="apexcharts-pie-area apexcharts-donut-slice-1"
                                                                          index="0" j="1"
                                                                          data:angle="57.599999999999994"
                                                                          data:startAngle="180.8" data:strokeWidth="0"
                                                                          data:value="16"
                                                                          data:pathOrig="M 79.1840638026197 122.43332798844617 A 58.43902439024391 58.43902439024391 0 0 1 30.22590892178677 94.6212251391295 L 47.646840799161396 83.90379634043418 A 37.98536585365854 37.98536585365854 0 0 0 79.46964147170281 101.98166319249002 L 79.1840638026197 122.43332798844617 z"></path>
                                                                </g>
                                                                <g id="SvgjsG1509"
                                                                   class="apexcharts-series apexcharts-pie-series"
                                                                   seriesName="Product" rel="3" data:realIndex="2">
                                                                    <path id="SvgjsPath1510"
                                                                          d="M 30.22590892178677 94.6212251391295 A 58.43902439024391 58.43902439024391 0 0 1 69.84212548457727 6.4505677090342814 L 73.39738156497522 26.592869010872285 A 37.98536585365854 37.98536585365854 0 0 0 47.646840799161396 83.90379634043418 L 30.22590892178677 94.6212251391295 z"
                                                                          fill="rgba(40,199,111,1)" fill-opacity="1"
                                                                          stroke-opacity="1" stroke-linecap="butt"
                                                                          stroke-width="0" stroke-dasharray="0"
                                                                          class="apexcharts-pie-area apexcharts-donut-slice-2"
                                                                          index="0" j="2" data:angle="111.6"
                                                                          data:startAngle="238.4" data:strokeWidth="0"
                                                                          data:value="31"
                                                                          data:pathOrig="M 30.22590892178677 94.6212251391295 A 58.43902439024391 58.43902439024391 0 0 1 69.84212548457727 6.4505677090342814 L 73.39738156497522 26.592869010872285 A 37.98536585365854 37.98536585365854 0 0 0 47.646840799161396 83.90379634043418 L 30.22590892178677 94.6212251391295 z"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="SvgjsG1511" class="apexcharts-datalabels-group"
                                                           transform="translate(0, 0) scale(1)">
                                                            <text id="SvgjsText1512"
                                                                  font-family="Helvetica, Arial, sans-serif" x="80"
                                                                  y="79" text-anchor="middle" dominant-baseline="auto"
                                                                  font-size="16px" font-weight="400" fill="#373d3f"
                                                                  class="apexcharts-text apexcharts-datalabel-label"
                                                                  style="font-family: Helvetica, Arial, sans-serif;">
                                                            </text>
                                                            <text id="SvgjsText1513"
                                                                  font-family="Helvetica, Arial, sans-serif" x="80"
                                                                  y="65" text-anchor="middle" dominant-baseline="auto"
                                                                  font-size="20px" font-weight="400" fill="#373d3f"
                                                                  class="apexcharts-text apexcharts-datalabel-value"
                                                                  style="font-family: Helvetica, Arial, sans-serif;">
                                                            </text>
                                                        </g>
                                                    </g>
                                                    <line id="SvgjsLine1514" x1="0" y1="0" x2="160" y2="0"
                                                          stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                          class="apexcharts-ycrosshairs"></line>
                                                    <line id="SvgjsLine1515" x1="0" y1="0" x2="160" y2="0"
                                                          stroke-dasharray="0" stroke-width="0"
                                                          class="apexcharts-ycrosshairs-hidden"></line>
                                                </g>
                                                <g id="SvgjsG1498" class="apexcharts-annotations"></g>
                                            </svg>
                                            <div class="apexcharts-legend"></div>
                                            <div class="apexcharts-tooltip apexcharts-theme-dark">
                                                <div class="apexcharts-tooltip-series-group" style="order: 1;"><span
                                                        class="apexcharts-tooltip-marker"
                                                        style="background-color: rgba(40, 199, 111, 0.4);"></span>
                                                    <div class="apexcharts-tooltip-text"
                                                         style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                        <div class="apexcharts-tooltip-y-group"><span
                                                                class="apexcharts-tooltip-text-label"></span><span
                                                                class="apexcharts-tooltip-text-value"></span></div>
                                                        <div class="apexcharts-tooltip-z-group"><span
                                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                                    </div>
                                                </div>
                                                <div class="apexcharts-tooltip-series-group" style="order: 2;"><span
                                                        class="apexcharts-tooltip-marker"
                                                        style="background-color: rgba(40, 199, 111, 0.2);"></span>
                                                    <div class="apexcharts-tooltip-text"
                                                         style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                        <div class="apexcharts-tooltip-y-group"><span
                                                                class="apexcharts-tooltip-text-label"></span><span
                                                                class="apexcharts-tooltip-text-value"></span></div>
                                                        <div class="apexcharts-tooltip-z-group"><span
                                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                                    </div>
                                                </div>
                                                <div class="apexcharts-tooltip-series-group" style="order: 3;"><span
                                                        class="apexcharts-tooltip-marker"
                                                        style="background-color: rgb(40, 199, 111);"></span>
                                                    <div class="apexcharts-tooltip-text"
                                                         style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                        <div class="apexcharts-tooltip-y-group"><span
                                                                class="apexcharts-tooltip-text-label"></span><span
                                                                class="apexcharts-tooltip-text-value"></span></div>
                                                        <div class="apexcharts-tooltip-z-group"><span
                                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="resize-triggers">
                                        <div class="expand-trigger">
                                            <div style="width: 293px; height: 128px;"></div>
                                        </div>
                                        <div class="contract-trigger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Earnings Card -->
            </div>
        </div>

        <!-- Revenue Report Card -->
        <div class="col-lg-5 col-12">
            <div class="card card-revenue-budget">
                <div class="row mx-0">
                    <div class="col-md-12 col-6 revenue-report-wrapper" style="position: relative;">
                        <div id="revenue-report-chart" style="min-height: 245px;">
                            <div align="center">
                                <canvas id="myChart"></canvas>
                                Chiffre d'affaire par année
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- Revenue Report Card -->
        <div class="col-lg-3 col-12">
            <div class="card card-revenue-budget">
                <div class="row mx-0">
                    <div class="col-md-12 col-6 revenue-report-wrapper" style="position: relative;">
                        <div id="revenue-report-chart" style="min-height: 245px;">
                            <div align="center">
                                <canvas id="myChartPie"></canvas>
                                Commande journalière par produit
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!--/ Revenue Report Card -->
    </div>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                
            },

        });
    </script>
    <script>
        const ctx2 = document.getElementById('myChartPie');

        new Chart(ctx2, {
            type: 'pie',
            data: {
            },

        });
    </script>
</section>
