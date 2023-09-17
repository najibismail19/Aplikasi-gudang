
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3 | Dashboard</title>

<!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url("/assets/plugins/fontawesome-free/css/all.min.css") }}">
<!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ url("/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">
<!-- iCheck -->
  <link rel="stylesheet" href="{{ url("/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
<!-- JQVMap -->
  <link rel="stylesheet" href="{{ url("/assets/plugins/jqvmap/jqvmap.min.css") }}">
<!-- Theme style -->
  <link rel="stylesheet" href="{{ url("/assets/dist/css/adminlte.min.css") }}">
<!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url("/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
<!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url("/assets/plugins/daterangepicker/daterangepicker.css") }}">
<!-- summernote -->
  <link rel="stylesheet" href="{{ url("/assets/plugins/summernote/summernote-bs4.min.css") }}">

{{-- Data Table --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
{{-- End Data Table --}}


{{-- Sweet Alert --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Feater Icons --}}
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-solid fa-bars"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="/users/profile" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ url("/users/logout") }}" class="dropdown-item">
                <i class="fas fa-sharp fa-solid fa-arrow-right mr-2"></i> Logout
            </a>
          </div>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 d-flex">
        <div class="image">
          <img src="{{ url("/assets/dist/img/user2-160x160.jpg") }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-header">Profie</li>
               <li class="nav-item">
                   <a href="{{ url("/users/profile") }}" class="nav-link {{ Request::is("users/profile") ? 'active' : ''}}">
                    <i class="fas fa-user mr-2"></i>
                    <p>
                      Profile
                    </p>
                  </a>
               </li>
            <li class="nav-header">Menu</li>
          <li class="nav-item {{ Request::is("users/log-authentication") || Request::is("users/users-activity") ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::is("users/log-authentication") || Request::is("users/users-activity") ? 'active' : ''}}">
              <i class="fas fa-users mr-2"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{ url("/users/log-authentication") }}" class="nav-link {{ Request::is("users/log-authentication") ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon mr-2"></i>
                  <p>Log Authentication</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url("/users/users-activity") }}" class="nav-link {{ Request::is("users/users-activity") ? 'active' : ''}}">
                    <i class="far fa-circle nav-icon mr-2"></i>
                    <p>User Activity</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{  (request()->is("produk") || request()->is("produk/*")) ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ (request()->is("produk") || request()->is("produk/*")) ? 'active' : ''}}">
                <i data-feather="inbox"></i>&nbsp;
              <p>
                Master Produk
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{ url("/produk") }}" class="nav-link {{ (request()->is("produk") || request()->is("produk/*")) ? 'active' : ''}}">
                    <i class="far fa-circle nav-icon mr-2"></i>
                    <p>Produk</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ (request()->is("pembelian") || request()->is("pembelian/*")) ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ (request()->is("pembelian") || request()->is("pembelian/*")) ? 'active' : ''}}">
                <i data-feather="archive"></i>&nbsp;
              <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{ url("/pembelian") }}" class="nav-link {{ (request()->is("pembelian") || request()->is("pembelian/*")) ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon mr-2"></i>
                  <p>Pembelian</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{ url("/penerimaan") }}" class="nav-link {{ Request::is("penerimaan/*") ? 'active' : ''}}">
                    <i class="far fa-circle nav-icon mr-2"></i>
                    <p>Penerimaan</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{ url("/penjualan") }}" class="nav-link {{ Request::is("penjualan/*") ? 'active' : ''}}">
                    <i class="far fa-circle nav-icon mr-2"></i>
                    <p>Penjualan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Request::is("perakitan/*") ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::is("perakitan/*") ? 'active' : ''}}">
              <i class="fas fa-solid fa-sitemap mr-2"></i>
              <p>
                Perakitan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{ url("/perakitan/master-prakitan") }}" class="nav-link {{ Request::is("perakitan/master-prakitan/*") ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon mr-2"></i>
                  <p>Master Perakitan</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{ url("/perakitan") }}" class="nav-link {{ Request::is("perakitan/*") ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon mr-2"></i>
                  <p>Perakitan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Request::is("stock/*") ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::is("stock/*") ? 'active' : ''}}">
                <i data-feather="check-square"></i>&nbsp;
              <p>
                Master Stock
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{ url("/stock/barang-jadi") }}" class="nav-link {{ Request::is("stock/barang-jadi/*") ? 'active' : ''}}">
                    <i class="far fa-circle nav-icon mr-2"></i>
                    <p>Stcok Barang Jadi</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{ url("/stock/barang-mentah") }}" class="nav-link {{ Request::is("stock/barang-mentah/*") ? 'active' : ''}}">
                    <i class="far fa-circle nav-icon mr-2"></i>
                    <p>Stock Barang Mentah</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{ url("/kartu-stock") }}" class="nav-link {{ Request::is("kartu-stock/*") ? 'active' : ''}}">
                    <i class="far fa-circle nav-icon mr-2"></i>
                    <p>Kartu Stock</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ (request()->is("supplier") || request()->is("supplier/*")) ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ (request()->is("supplier") || request()->is("supplier/*")) ? 'active' : ''}}">
                <i data-feather="truck"></i>&nbsp;
              <p>
                Supplier
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{ url("/supplier") }}" class="nav-link {{ (request()->is("supplier") || request()->is("supplier/*")) ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon mr-2"></i>
                  <p>Supplier</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('title')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         @yield('content')
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">

  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@stack('script')

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url("/assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- ChartJS -->
<script src="{{ url("/assets/plugins/chart.js/Chart.min.js") }}"></script>
<!-- Sparkline -->
<script src="{{ url("/assets/plugins/sparklines/sparkline.js") }}"></script>
<!-- JQVMap -->
<script src="{{ url("/assets/plugins/jqvmap/jquery.vmap.min.js") }}"></script>
<script src="{{ url("/assets/plugins/jqvmap/maps/jquery.vmap.usa.js") }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url("/assets/plugins/jquery-knob/jquery.knob.min.js") }}"></script>
<!-- daterangepicker -->
<script src="{{ url("/assets/plugins/moment/moment.min.js") }}"></script>
<script src="{{ url("/assets/plugins/daterangepicker/daterangepicker.js") }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url("/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
<!-- Summernote -->
<script src="{{ url("/assets/plugins/summernote/summernote-bs4.min.js") }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url("/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ url("/assets/dist/js/adminlte.js")}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url("/assets/dist/js/demo.js") }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url("/assets/dist/js/pages/dashboard.js")}} "></script>
</body>
</html>
