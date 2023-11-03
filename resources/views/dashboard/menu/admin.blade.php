<?php

use App\Helpers\Menu;

$imagedashboard = Menu::get_info_image_dashboard();
?>



    <!-- Hour chart  -->
    <div class="card bg-transparent shadow-none my-4 border-0">
        <div class="card-body row p-0 pb-3">
            <div class="col-12 col-md-8 card-separator">
                <h3 class="text text-dark"> Bonjour {{Auth::user()->name .' '.Auth::user()->prenom_users}}</strong>,  👋🏻</h3>
                <div class="col-12 col-lg-7">
                    <p>Bienvenue sur notre application web ! Nous sommes ravis de vous avoir parmi nous. Nous espérons que vous apprécierez votre expérience avec nous !</p>
                </div>
                <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                    <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                        <span class="bg-label-primary p-2 rounded">
                          <i class="ti ti-device-laptop ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Hours Spent</p>
                            <h4 class="text-primary mb-0">34h</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-info p-2 rounded">
                          <i class="ti ti-bulb ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Test Results</p>
                            <h4 class="text-info mb-0">82%</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-warning p-2 rounded">
                          <i class="ti ti-discount-check ti-xl"></i>
                        </span>
                        <div class="content-right">
                            <p class="mb-0">Course Completed</p>
                            <h4 class="text-warning mb-0">14</h4>
                        </div>
                    </div>
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
    <!-- Hour chart End  -->

    <!-- Topic and Instructors -->
    <div class="row mb-4 g-4">
        <div class="col-12 col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Topic you are interested in</h5>
                    <div class="dropdown">
                        <button
                            class="btn p-0"
                            type="button"
                            id="topic"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topic">
                            <a class="dropdown-item" href="javascript:void(0);">Highest Views</a>
                            <a class="dropdown-item" href="javascript:void(0);">See All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <div id="horizontalBarChart"></div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-around align-items-center">
                        <div>
                            <div class="d-flex align-items-baseline">
                                <span class="text-primary me-2"><i class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">UI Design</p>
                                    <h5>35%</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline my-3">
                                <span class="text-success me-2"><i class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">Music</p>
                                    <h5>14%</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <span class="text-danger me-2"><i class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">React</p>
                                    <h5>10%</h5>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-baseline">
                                                <span class="text-info me-2"><i
                                                        class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">UX Design</p>
                                    <h5>20%</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline my-3">
                                                <span class="text-secondary me-2"><i
                                                        class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">Animation</p>
                                    <h5>12%</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <span class="text-warning me-2"><i class="ti ti-circle-filled fs-6"></i></span>
                                <div>
                                    <p class="mb-2">SEO</p>
                                    <h5>9%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Popular Instructors</h5>
                    </div>
                    <div class="dropdown">
                        <button
                            class="btn p-0"
                            type="button"
                            id="popularInstructors"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"
                             aria-labelledby="popularInstructors">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless border-top">
                        <thead class="border-bottom">
                        <tr>
                            <th>Instructors</th>
                            <th class="text-end">courses</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="pt-2">
                                <div class="d-flex justify-content-start align-items-center mt-lg-4">
                                    <div class="avatar me-3 avatar-sm">
                                        <img src="/assets/img/avatars/1.png" alt="Avatar"
                                             class="rounded-circle"/>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Maven Analytics</h6>
                                        <small class="text-truncate text-muted">Business
                                            Intelligence</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end pt-2">
                                <div class="user-progress mt-lg-4">
                                    <p class="mb-0 fw-medium">33</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3 avatar-sm">
                                        <img src="/assets/img/avatars/2.png" alt="Avatar"
                                             class="rounded-circle"/>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Zsazsa McCleverty</h6>
                                        <small class="text-truncate text-muted">Digital
                                            Marketing</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">52</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3 avatar-sm">
                                        <img src="/assets/img/avatars/3.png" alt="Avatar"
                                             class="rounded-circle"/>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Nathan Wagner</h6>
                                        <small class="text-truncate text-muted">UI/UX Design</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">12</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3 avatar-sm">
                                        <img src="/assets/img/avatars/4.png" alt="Avatar"
                                             class="rounded-circle"/>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">Emma Bowen</h6>
                                        <small class="text-truncate text-muted">React Native</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="user-progress">
                                    <p class="mb-0 fw-medium">8</p>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!--  Topic and Instructors  End-->



