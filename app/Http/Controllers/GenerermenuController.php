<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Role;
use App\Models\Sousmenus;
use App\Models\RoleSousmenu;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Spatie\Permission\Models\Permission;
//for test
ini_set('max_execution_time', 0);

class GenerermenuController extends Controller
{
    public function index(Request $request)
        {

    //dd(pathinfo('designadmin'));
    //dd(__DIR__);
            //dd('test');

            //creation de fichier

            //$view = view('layouts/backLayout/'.$groupe.".blade.php");
            //$dir = "/resources/views/layouts/backLayout/";

            $dir = __DIR__.'/../../../resources/views/layouts/backLayout/';

            //$dir = $view;

            $groupe="designadmin";

            $filename = $groupe.".blade.php";

            //$filename = "../../../resources/views/layouts/backLayout/designadmin.blade.php";

            $pagemenu = " <?php ?>";

            $pagemenu.='<!DOCTYPE html>
    					<html dir="ltr" lang="en">

    					<head>
    				    <meta charset="utf-8">
    				    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    				    <!-- Tell the browser to be responsive to screen width -->
    				    <meta name="viewport" content="width=device-width, initial-scale=1">
    				    <meta name="description" content="">
    				    <meta name="author" content="">
    				    <!-- Favicon icon -->
    				    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("backend/assets/images/favicon.png") }}">
    				    <title>gestion des utilisateurs</title>
    				    <!-- Custom CSS -->
    				    <link href="{{ asset("backend/assets/libs/flot/css/float-chart.css") }}" rel="stylesheet">
    				    <!-- Custom CSS -->
    				    <link href="{{ asset("backend/dist/css/style.min.css") }}" rel="stylesheet">
    				     <link rel="stylesheet" type="text/css" href="{{ asset("backend/assets/extra-libs/multicheck/multicheck.css") }}">
    				    <link href="{{ asset("backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css") }}" rel="stylesheet">
    				    <link href="{{ asset("backend/dist/css/style.min.css") }}" rel="stylesheet">
    				    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    				    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    				    <!--[if lt IE 9]>
    				    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    				    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    				<![endif]-->
    				</head>

    <body>

    <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
      @include("layouts.backLayout.headeradmin")';


            $resulat = DB::table('menu')->join('sousmenu','menu.id_menu','sousmenu.menu_id_menu')->get();

            $tabl = [];

            foreach ($resulat as $ligne) {

                $tabl[$ligne->id_menu][] = $ligne;
            }

            $pagemenu.='<!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <aside class="left-sidebar" data-sidebarbg="skin5">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav" class="p-t-30">';

            $pagemenu.='<?php $i=0; foreach ($tabl as $key => $tablvue) { $i++;?>
                               <li class="sidebar-item">
                               <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)<?php echo $key; ?>" aria-expanded="false"><i class="mdi mdi-receipt"></i>
                               <span class="hide-menu">{{ $tablvue[0]->menu }} </span></a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <?php foreach ( $tablvue as $key => $vue) { ?>
                                       <li class="sidebar-item"><a href="{{ url("/".$vue->sousmenu)}}"" class="sidebar-link">
                                       <i class="mdi mdi-note-outline"></i>
                                       <span class="hide-menu"><?php echo    $vue->libelle; ?> </span></a></li>
                                  <?php  } ?>


                                </ul>
                            </li>
                           <?php  } ?>';

            $pagemenu.='</ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->';

            $pagemenu.='@yield("content")

    @include("layouts.backLayout.footer")

     </div>
            <!-- ============================================================== -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================ -->
        <!-- ============================================================== -->

     <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="{{ asset("backend/assets/libs/jquery/dist/jquery.min.js") }}"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="{{ asset("backend/assets/libs/popper.js/dist/umd/popper.min.js") }}"></script>
        <script src="{{ asset("backend/assets/libs/bootstrap/dist/js/bootstrap.min.js") }}"></script>
        <script src="{{ asset("backend/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js") }}"></script>
        <script src="{{ asset("backend/assets/extra-libs/sparkline/sparkline.js") }}"></script>
        <!--Wave Effects -->
        <script src="{{ asset("backend/dist/js/waves.js") }}"></script>
        <!--Menu sidebar -->
        <script src="{{ asset("backend/dist/js/sidebarmenu.js") }}"></script>
        <!--Custom JavaScript -->
        <script src="{{ asset("backend/dist/js/custom.min.js") }}"></script>
        <!--This page JavaScript -->
        <!-- <script src="../../dist/js/pages/dashboards/dashboard1.js"></script> -->
        <!-- Charts js Files -->
        <script src="{{ asset("backend/assets/libs/flot/excanvas.js") }}"></script>
        <script src="{{ asset("backend/assets/libs/flot/jquery.flot.js") }}"></script>
        <script src="{{ asset("backend/assets/libs/flot/jquery.flot.pie.js") }}"></script>
        <script src="{{ asset("backend/assets/libs/flot/jquery.flot.time.js") }}"></script>
        <script src="{{ asset("backend/assets/libs/flot/jquery.flot.stack.js") }}"></script>
        <script src="{{ asset("backend/assets/libs/flot/jquery.flot.crosshair.js") }}"></script>
        <script src="{{ asset("backend/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js") }}"></script>
        <script src="{{ asset("backend/dist/js/pages/chart/chart-page-init.js") }}"></script>
        <script src="{{ asset("backend/assets/extra-libs/multicheck/datatable-checkbox-init.js") }}"></script>
        <script src="{{ asset("backend/assets/extra-libs/multicheck/jquery.multicheck.js") }}"></script>
        <script src="{{ asset("backend/assets/extra-libs/DataTables/datatables.min.js") }}"></script>
        <script>
            /****************************************
             *       Basic Table                   *
             ****************************************/
            $("#zero_config").DataTable();
        </script>

    </body>

    </html>';


            //SAUVEGARDE DU REPERTOIRE
            //$sauvegarde = "/resources/views/layouts/backLayout/tmp/";
            // $sauvegarde = "../../../resources/views/layouts/backLayout/tmp/";

            $sauvegarde = __DIR__.'/../../../resources/views/layouts/backLayout/tmp/';
            rename($dir.$filename, $sauvegarde.$filename.date('Ymd_His'));
            //GENERATION DU FICHIER

            $monfichier = fopen($dir.$filename, 'w');
            fwrite($monfichier, $pagemenu); // On �crit le nouveau nombre de pages vues
            fclose($monfichier);
            // Redirect to list
            return redirect('/sousmenus');
            return view('generer.generer');
        }



        public function parametragemenu(Request $request)
        {




            /*$resulat = DB::table('menu')->join('sousmenu','menu.id_menu','sousmenu.menu_id_menu')->get();*/


            $idutil=Auth::user()->id;
            // dd($idutil);

            $roles = DB::table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->where([['users.id','=',$idutil]])
                ->first();
            $idroles = $roles->role_id;
            //dd($idroles);

            $naroles = $roles->name;

            $resulat = DB::table('role_has_sousmenus')
                ->join('sousmenu','role_has_sousmenus.sousmenus_id_sousmenu','sousmenu.id_sousmenu')
                ->join('roles','role_has_sousmenus.role_id','roles.id')
                ->join('menu','sousmenu.menu_id_menu','menu.id_menu')
                ->where([['roles.id','=',$idroles]])
                ->get();


            $tabl = [];

            foreach ($resulat as $ligne) {

                $tabl[$ligne->id_menu][] = $ligne;
            }

            $roles = Role::all();
            return view('generer.generer',compact('tabl','roles','naroles'));
        }

        public function menuprofillayout(Request $request, $id)
        {
          /*  $resulat2 = DB::table('sousmenu')->get();
            $tablmenu = [];
            foreach ($resulat2 as $ligne) {
                $tablmenu[$ligne->id_sousmenu][]  = $ligne;
            }*/

            $role = \App\Models\Role::find($id);
            if ($request->isMethod('post')) {
                $role->sousmenus()->sync($request->route, true);

                $roles = \Spatie\Permission\Models\Role::find($id);
                $roles->syncPermissions($request->permission);
                return redirect('/menuprofil')->with('success','Attribution effectuée avec succès');
            }

            $resulatsm = DB::table('menu')
                ->select('sousmenu.*','sousmenu.id_sousmenu as id_sous_menu','menu.*','permissions.*')
                ->join('sousmenu','menu.id_menu','sousmenu.menu_id_menu')
                ->leftjoin('permissions','sousmenu.id_sousmenu','permissions.id_sousmenu')
                ->where('sousmenu.is_valide',true)
                ->where('menu.is_valide',true)
                ->get();

            $tablsm = [];

            foreach ($resulatsm as $lignesm) {
                $tablsm[$lignesm->id_menu][$lignesm->menu][$lignesm->libelle][] = $lignesm;
            }
            $nomprof = $role->name;
            $sousmenu = Sousmenus::get();

            $roleSousmenus = DB::table("role_has_sousmenus")->where("role_has_sousmenus.role_id",$id)
                ->pluck('role_has_sousmenus.sousmenus_id_sousmenu','role_has_sousmenus.sousmenus_id_sousmenu')
                ->all();
            $role_permission = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();

            return view('generer.menuprofillayout',compact('role_permission','role','sousmenu','id', 'tablsm','roleSousmenus','nomprof'));
        }

}
