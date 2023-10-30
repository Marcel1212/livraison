<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                            href="{{ url('/menuadmin')}}" aria-expanded="false"><i
                            class="mdi mdi-view-dashboard"></i><span class="hide-menu">Tableau de bord</span></a></li>
                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                            href="javascript:void(0)" aria-expanded="false"><i
                            class="mdi mdi-receipt"></i><span class="hide-menu">Utilisateurs </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ url('/users')}}" class="sidebar-link"><i
                                    class="mdi mdi-note-outline"></i><span
                                    class="hide-menu"> Liste des utlisateurs </span></a></li>

                    </ul>
                </li>
                @can('role-list')
                    <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-receipt"></i><span class="hide-menu">Roles </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{ url('/roles')}}" class="sidebar-link"><i
                                        class="mdi mdi-note-outline"></i><span
                                        class="hide-menu"> Liste des roles </span></a></li>

                        </ul>
                    </li>
                @endcan

                @can('product-list')
                    <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-receipt"></i><span class="hide-menu">Products </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{ url('/products')}}" class="sidebar-link"><i
                                        class="mdi mdi-note-outline"></i><span
                                        class="hide-menu"> Liste des Products </span></a></li>

                        </ul>
                    </li>
                @endcan

                @can('role-list')
                    <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-receipt"></i><span class="hide-menu">Permission </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{ url('/permissions')}}" class="sidebar-link"><i
                                        class="mdi mdi-note-outline"></i><span
                                        class="hide-menu"> Liste des permission </span></a></li>

                        </ul>
                    </li>
                @endcan

                @can('role-list')
                    <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-receipt"></i><span class="hide-menu">Menu </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{ url('/menus')}}" class="sidebar-link"><i
                                        class="mdi mdi-note-outline"></i><span
                                        class="hide-menu"> Liste des Menus </span></a></li>

                        </ul>
                    </li>
                @endcan


                @can('role-list')
                    <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                href="javascript:void(0)" aria-expanded="false"><i
                                class="mdi mdi-receipt"></i><span class="hide-menu">Sous Menu</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{ url('/sousmenus')}}" class="sidebar-link"><i
                                        class="mdi mdi-note-outline"></i><span
                                        class="hide-menu"> Liste des Sous  Menus</span></a></li>

                        </ul>
                    </li>
                @endcan

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
