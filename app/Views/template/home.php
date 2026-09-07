<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Utama Service Station</title>
  <link rel="shortcut icon" href="<?= base_url('assets/dist/img/logouss.png') ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/assets/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="/assets/https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet"
    href="/assets/https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="/Dashboard/dashboard" role="button"><i
              class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/Dashboard/dashboard" class="nav-link">Home</a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link d-flex align-items-center">
        <img src="/assets/dist/img/logouss.png" alt="Logo" class="brand-image img-circle elevation-3 me-2"
          style="opacity: .9; width: 40px; height: 40px; object-fit: cover;">
        <span class="brand-text fw-light" style="font-size: 1rem;">Utama Service Station</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom">
          <div class="info ps-2">
            <a href="#" class="d-block" style="font-weight: 500; font-size: 0.95rem;">
              <?= esc(session()->get('nama')) ?>
            </a>
          </div>
        </div>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class=" nav-item">
              <a href="<?= base_url('Dashboard/dashboard') ?>" class="nav-link text-blue">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  dashboard
                  <i class="right badge badge-danger"></i>
                </p>
              </a>
            </li>

            <?php if (session()->get('level') == 'admin'): ?>
              <!-- MENU MASTER - HANYA UNTUK ADMIN -->
              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Master
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('Admin/index') ?>" class="nav-link active">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Admin</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('Pelanggan/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Pelanggan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('Mekanik/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Mekanik</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('Servis/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Jenis Servis</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('Sparepart/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Sparepart</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('Pemasok/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Pemasok</p>
                    </a>
                  </li>
                </ul>
              </li>

              <!-- MENU TRANSAKSI - HANYA UNTUK ADMIN -->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Transaksi
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('Pemesanan/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pemesanan</p>
                    </a>
                  </li>
                </ul>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('TransaksiServis/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Transaksi Servis</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('Pembayaran/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pembayaran</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('Pembeliansparepart/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pembelian Sparepart</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('Penjualansparepart/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Penjualan Sparepart</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('Uangkeluar/index') ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Uang Keluar</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif; ?>

            <!-- MENU LAPORAN - UNTUK ADMIN DAN PIMPINAN (SATU TOMBOL PUSAT LAPORAN) -->
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Laporan
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('Laporan/index') ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Laporan
                    </p>
                  </a>
              </ul>
            </li>

            <li class=" nav-item">
              <a href="<?= base_url('Login/logout') ?>" class="nav-link text-red">
                <i class="nav-icon fas fa-power-off"></i>
                <p>
                  logout
                </p>
              </a>
            </li>
        </nav>
        <?php
        //  if($_SESSION['adminlevel'] == 1){
        //   include ('menu/level1.php');
        //  }else{
        //   include ('menu/level2.php');
        //  }
        ?>
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
              <!-- <h1 class="m-0 text-dark">Dashboard</h1> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/Dashboard/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Utama Service Station</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <?= $this->renderSection('isi') ?>
      <!-- Main content -->
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2025-2026 <a href="/assets/http://adminlte.io"></a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 0.0.1
      </div>
    </footer>

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/assets/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <!-- <script src="/assets/plugins/sparklines/sparkline.js"></script> -->
    <!-- JQVMap -->
    <script src="/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/assets/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/assets/dist/js/demo.js"></script>
    <!-- DataTables -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Include scripts -->
    <script src="/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
      $(function () {
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
        });
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
      $(document).ready(function () {
        setInterval(function () {
          $('#reportmobil').load("banner.php")

        });
      });
    </script>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
</body>

</html>