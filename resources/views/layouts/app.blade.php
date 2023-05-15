<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>DBI Research Private Ltd.</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  
    {{-- googleChart --}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    
    <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
          integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" 
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" 
          integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
          crossorigin="anonymous"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
  
  
  <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
          crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    

       <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    {{-- admin templete --}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://localhost:8000/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    {{-- <link rel="stylesheet" href="http://localhost:8000/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> --}}
    <!-- iCheck -->
    {{-- <link rel="stylesheet" href="http://localhost:8000/plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}
    <!-- JQVMap -->
    <!-- <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css"> -->
    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="http://localhost:8000/dist/css/adminlte.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    {{-- <link rel="stylesheet" href="http://localhost:8000/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> --}}
    <!-- Daterange picker -->
    <!-- <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css"> -->
    <!-- summernote -->
    {{-- <link rel="stylesheet" href="http://localhost:8000/plugins/summernote/summernote-bs4.min.css"> --}}
<style>
  .date{ z-index:99999 !important; }
</style>
    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed" onload="activeMenu()">
{{-- <body> --}}
  <div class="wrapper">
  
    <!-- Preloader -->
    {{-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div> --}}
  
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
          {{-- <a class="nav-link" data-toggle="collapse" role="button"><i class="fas fa-bars"></i></a> --}}
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{url('home')}}" class="nav-link">Home</a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li> --}}
        
      </ul>
  
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
              @if (Route::has('login'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
              @endif

              @if (Route::has('register'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
              @endif
          @else
              <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }}
                  </a>

                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('change_password_index') }}"> {{ __('Change Password') }} </a>
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </div>
              </li>
          @endguest
        <li class="nav-item">
          <a class="nav-link" id="fullscreen" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li> --}}
      </ul>
    </nav>
    <!-- /.navbar -->
  
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-secondary elevation-4">
      <!-- Brand Logo -->
      <!--<a href="../../../../www.dbibd.com" class="brand-link">-->
      <a href="" class="brand-link">
        <img src="http://localhost:8000/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-square elevation-3" style="width: 30px;margin-top:5px">
        <span class="brand-text font-weight-light">DBI Research Pvt Ltd.</span>
      </a>
  
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
          </div>
        </div> -->
  
        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div> -->
  
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item" id="project-info-list">
              <a href="{{url('/project/' . $project->id . '/info')}}" class="nav-link" id="project-info-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Project Info
                </p>
              </a>
            </li>
            @if($activity->A11==1 || $activity->A12==1 || $activity->A13==1 || $activity->A14==1 || $activity->A15==1)
              <li class="nav-item" id="data-analysis-list">
                <a href="#" class="nav-link" id="data-analysis-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Data Analysis
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @if($activity->A11==1)
                    <li class="nav-item">
                      <a href="{{ url('/data_analysis/' . $project->id . '/survey_data') }}" class="nav-link" id="survey-data-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Survey Data</p>
                      </a>
                    </li>
                  @endif
                  @if($activity->A12==1)
                    <li class="nav-item">
                      <a href="{{ url('/data_analysis/' . $project->id . '/frequency_table') }}" class="nav-link" id="frequency-table-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Frequency Table</p>
                      </a>
                    </li>
                  @endif
                  @if($activity->A13==1)
                    <li class="nav-item">
                      <a href="{{ url('/data_analysis/' . $project->id . '/cross_table') }}" class="nav-link" id="cross-table-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cross Table</p>
                      </a>
                    </li>
                  @endif
                  @if($activity->A14==1)
                    <li class="nav-item">
                      <a href="{{ url('/data_analysis/' . $project->id . '/advanced_analysis') }}" class="nav-link" id="advanced-analysis-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Advance Analysis</p>
                      </a>
                    </li>
                  @endif
                  @if($activity->A15==1)
                    <li class="nav-item">
                      <a href="{{ url('/data_analysis/' . $project->id . '/dashboard') }}" class="nav-link" id="dashboard-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                      </a>
                    </li>
                  @endif
                  @if($activity->A16==1)
                    <li class="nav-item">
                      <a href="{{ url('/data_analysis/' . $project->id . '/search_operation') }}" class="nav-link" id="search-operation-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Search Operation</p>
                      </a>
                    </li>
                  @endif
                </ul>
              </li>
            @endif

            @if ($activity->A31==1 || $activity->A32==1)
              <li class="nav-item" id="resp_panel_list">
                <a href="#" class="nav-link" id="resp_panel_link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    Respondents Panel
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @if ($activity->A31==1)
                    <li class="nav-item">
                      <a href="{{ url('/resp_panel/'.$project->id.'/panel_selection') }}" class="nav-link" id="panel_selection_link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Panel Selection</p>
                      </a>
                    </li>
                  @endif
                  @if ($activity->A32==1)
                    <li class="nav-item">
                      <a href="{{ url('/resp_panel/'.$project->id.'/panel_setting') }}" class="nav-link" id="panel_setting_link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Panel Setting</p>
                      </a>
                    </li>
                  @endif
                </ul>
              </li>
            @endif
















            @if($activity->A21==1 || $activity->A22==1 || $activity->A23==1 || $activity->A24==1)
              <li class="nav-item" id="settings-list">
                <a href="#" class="nav-link" id="settings-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Settings
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @if($activity->A21==1)
                    <li class="nav-item">
                      <a href="{{url('/settings/' . $project->id . '/survey_filters/index')}}" class="nav-link" id="survey-finters-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Survey Filters</p>
                      </a>
                    </li>
                  @endif
                  @if($activity->A22==1)
                    <li class="nav-item">
                      <a href="{{url('/settings/' . $project->id . '/filter_parameters/index')}}" class="nav-link" id="filter-parameters-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Filter Parameters</p>
                      </a>
                    </li>
                  @endif
                  @if($activity->A23==1)
                    <li class="nav-item">
                      <a href="{{url('/settings/' . $project->id . '/set_variables/index')}}" class="nav-link" id="showing-varibles-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Set View Variables</p>
                      </a>
                    </li>
                  @endif
                  @if($activity->A24==1)
                    <li class="nav-item">
                      <a href="{{url('/settings/' . $project->id . '/project_users/index')}}" class="nav-link" id="project-users-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Project User</p>
                      </a>
                    </li>
                  @endif
                </ul>
              </li>
            @endif
            {{-- <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Charts
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/charts/chartjs.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ChartJS</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/charts/flot.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Flot</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/charts/inline.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inline</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/charts/uplot.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>uPlot</p>
                  </a>
                </li>
              </ul>
            </li> --}}
            {{-- <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  UI Elements
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/UI/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>General</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/icons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Icons</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/buttons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Buttons</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/sliders.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sliders</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/modals.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Modals & Alerts</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/navbar.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Navbar & Tabs</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/timeline.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Timeline</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/UI/ribbons.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ribbons</p>
                  </a>
                </li>
              </ul>
            </li> --}}
            {{-- <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Forms
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/forms/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>General Elements</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/forms/advanced.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Advanced Elements</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/forms/editors.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Editors</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/forms/validation.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Validation</p>
                  </a>
                </li>
              </ul>
            </li> --}}
            
            
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper"  id="app">
      <main class="py-3">
        @yield('content')
      </main>
    </div>

    <!-- /.content-wrapper -->
    {{-- <footer class="main-footer">
      <strong>Copyright &copy; 2021-2023 <a href="https://dbibd.com">DBI Research Private Ltd.</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.1
      </div>
    </footer> --}}
  
    <!-- Control Sidebar -->
    <!-- <aside class="control-sidebar control-sidebar-dark"> -->
      <!-- Control sidebar content goes here -->
    <!-- </aside> -->
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- jQuery for left manu-->
  <script src="http://localhost:8000/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  {{-- <script src="http://localhost:8000/plugins/jquery-ui/jquery-ui.min.js"></script> --}}
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  {{-- <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script> --}}
  <!-- Bootstrap 4 -->
  {{-- <script src="http://localhost:8000/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
  <!-- ChartJS -->
  <!-- <script src="plugins/chart.js/Chart.min.js"></script> -->
  <!-- Sparkline -->
  <!-- <script src="plugins/sparklines/sparkline.js"></script> -->
  <!-- JQVMap -->
  <!-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
  <!-- jQuery Knob Chart -->
  <!-- <script src="plugins/jquery-knob/jquery.knob.min.js"></script> -->
  <!-- daterangepicker -->
  <!-- <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script> -->
  <!-- Tempusdominus Bootstrap 4 -->
  {{-- <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> --}}
  <!-- Summernote -->
  <!-- <script src="plugins/summernote/summernote-bs4.min.js"></script> -->
  <!-- overlayScrollbars sidebar-->
  {{-- <script src="http://localhost:8000/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> --}}
  
  

  <!-- AdminLTE App -->
  {{-- <script src="http://localhost:8000/dist/js/adminlte.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="dist/js/demo.js"></script> -->
  <!-- AdminLTE data_analysis demo (This is only for demo purposes) -->
  <!-- <script src="dist/js/pages/data_analysis.js"></script> -->



    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.date').datepicker({  
           format: 'dd-mm-yyyy',
           autoclose:true
         });  
        });

        // $("body").delegate(".date", "focusin", function () {
            
        //     $(this).datepicker({  
        //    format: 'dd-mm-yyyy',
        //    autoclose:true
        //  });
        // });
    </script> 

  @yield('script')


  <script>
    $(document).ready(function(){
      $("body").addClass("sidebar-collapse");
     });
    </script>

  </body>
</html>

