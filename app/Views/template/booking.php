<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Utama Service Station</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
  <!-- Favicon -->
  <link href="/theme/img/favicon.ico" rel="icon">
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="/theme/https://fonts.googleapis.com">
  <link rel="preconnect" href="/theme/https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
    rel="stylesheet">
  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Libraries Stylesheet -->
  <link href="/theme/lib/animate/animate.min.css" rel="stylesheet">
  <link href="/theme/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="/theme/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
  <!-- Customized Bootstrap Stylesheet -->
  <link href="/theme/css/bootstrap.min.css" rel="stylesheet">
  <!-- Template Stylesheet -->
  <link href="/theme/css/style.css" rel="stylesheet">
</head>

<body>
  <!-- Spinner Start -->
  <div id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <!-- Spinner End -->
  <!-- Topbar Start -->
  <div class="container-fluid bg-light p-0">
    <div class="row gx-0 d-none d-lg-flex">
      <div class="col-lg-7 px-5 text-start">
        <div class="h-100 d-inline-flex align-items-center py-3 me-4">
          <small class="fa fa-map-marker-alt text-primary me-2"></small>
          <small>Jl. S Parman No. 156 - 164 Padang</small>
        </div>
        <div class="h-100 d-inline-flex align-items-center py-3">
          <small class="far fa-clock text-primary me-2"></small>
          <small>Senin – Kamis : 08.00 AM – 17.00 PM & Sabtu – Minggu : 08.00 AM – 17.00 PM</small>
        </div>
      </div>
      <div class="col-lg-5 px-5 text-end">
        <div class="h-100 d-inline-flex align-items-center py-3 me-4">
          <small class="fa fa-phone-alt text-primary me-2"></small>
          <small>(0751) 7054654</small>
        </div>
        <div class="h-100 d-inline-flex align-items-center">
          <a class="btn btn-sm-square bg-white text-primary me-1" href="https://www.facebook.com/share/16Vd6P3VMo/"><i
              class="fab fa-facebook-f"></i></a>
          <a class="btn btn-sm-square bg-white text-primary me-0"
            href="https://www.instagram.com/utamaservice_padang?igsh=MTB4eG5ya3doOTZ6cQ=="><i
              class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Topbar End -->
  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="/theme/index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
      <h2 class="m-0 text-primary"><i class="fa fa-car me-3"></i>Utama Service Station</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="<?= site_url('/') ?>" class="nav-item nav-link">Beranda</a>
        <a href="<?= site_url('/Home/tentang') ?>" class="nav-item nav-link">Tentang Kami</a>
        <!-- <a href="<?= site_url('/Home/sparepart') ?>" class="nav-item nav-link">Sparepart</a> -->
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Servis</a>
          <div class="dropdown-menu fade-down m-0">
            <a href="<?= site_url('/Booking') ?>" class="dropdown-item active">Booking Servis</a>
            <a href="<?= site_url('/Home/status') ?>" class="dropdown-item">Status Servis</a>
            <a href="<?= site_url('/Home/layanan') ?>" class="dropdown-item">Jenis Servis</a>
          </div>
        </div>
        <?php if (session()->get('loggedin')): ?>
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <i class="fa fa-user me-2"></i><?= session()->get('nama') ?>
            </a>
            <div class="dropdown-menu fade-down m-0">
              <a href="<?= site_url('/Mobil') ?>" class="dropdown-item">Mobil Saya</a>
              <a href="<?= site_url('/Home/profil') ?>" class="dropdown-item">Setting</a>
              <a href="<?= site_url('/login/logout') ?>" class="dropdown-item">Logout</a>
            </div>
          </div>
        <?php else: ?>
          <a href="#" class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#modalLogin">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->
  <!-- Booking Start -->
  <div class="container-fluid bg-light py-5">
    <div class="container">
      <div class="row gx-5 align-items-center">

        <!-- Kiri: Deskripsi -->
        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="wow fadeInLeft" data-wow-delay="0.2s">
            <h6 class="text-primary text-uppercase">// Booking Servis //</h6>
            <h1 class="mb-4 fw-bold text-dark">
              Servis Mobil Mudah & Cepat Bersama <span class="text-primary">Utama Service Station</span>
            </h1>
            <p class="text-muted mb-4">
              Kami menghadirkan kemudahan dalam melakukan pemesanan jadwal servis kendaraan.
              Dengan tim teknisi berpengalaman dan fasilitas modern, kami memastikan kendaraan Anda
              mendapat perawatan terbaik, tepat waktu, dan sesuai kebutuhan.
            </p>
            <ul class="list-unstyled text-secondary">
              <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Teknisi Profesional & Bersertifikat
              </li>
              <li class="mb-2"><i class="fa fa-check-circle text-primary me-2"></i>Peralatan Modern & Lengkap</li>
              <li><i class="fa fa-check-circle text-primary me-2"></i>Layanan Cepat & Transparan</li>
            </ul>
          </div>
        </div>

        <!-- Kanan: Form Booking -->
        <div class="col-lg-6">
          <div class="card shadow-lg border-0 wow fadeInRight" data-wow-delay="0.3s">
            <div class="card-header bg-primary text-white text-center py-3">
              <h4 class="mb-0">Form Pemesanan Servis</h4>
            </div>

            <div class="card-body bg-white p-4">
              <form id="formBooking">
                <div class="row g-3">

                  <!-- Kendaraan -->
                  <div class="col-12">
                    <label class="form-label fw-semibold">Pilih Mobil Anda</label>
                    <select class="form-select border-secondary" id="id_mobil" name="id_mobil" required>
                      <option value="">-- Pilih Mobil --</option>
                      <?php if (isset($mobil) && !empty($mobil)): ?>
                        <?php foreach ($mobil as $m): ?>
                          <option value="<?= $m['id_mobil'] ?>"><?= $m['no_polisi'] ?> - <?= $m['merk'] ?>     <?= $m['tipe'] ?>
                            (<?= $m['warna'] ?> - <?= $m['jenis'] ?>)</option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                    <div class="mt-2">
                      <small class="text-muted">Mobil Anda tidak ada di daftar?
                        <?php if (session()->get('loggedin')): ?>
                          <a href="<?= site_url('/Mobil') ?>"
                            class="text-primary fw-bold text-decoration-underline">Tambah Mobil Baru</a>
                        <?php else: ?>
                          <a href="<?= site_url('/?showLogin=true') ?>"
                            class="text-primary fw-bold text-decoration-underline">Tambah Mobil Baru</a>
                        <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <!-- Tanggal Servis -->
                  <div class="col-12 col-sm-6">
                    <label class="form-label fw-semibold">Tanggal Servis</label>
                    <input type="date" class="form-control border-secondary" id="tanggal_servis" name="tanggal_servis"
                      min="<?= date('Y-m-d') ?>" required>
                  </div>

                  <!-- Jam Servis -->
                  <div class="col-12 col-sm-6">
                    <label class="form-label fw-semibold">Jam Servis</label>
                    <select class="form-select border-secondary" id="jam_servis" name="jam_servis" required>
                      <option value=""></option>
                      <option value="08:00">08:00</option>
                      <option value="09:00">09:00</option>
                      <option value="10:00">10:00</option>
                      <option value="11:00">11:00</option>
                      <option value="12:00">12:00</option>
                      <option value="13:00">13:00</option>
                      <option value="14:00">14:00</option>
                      <option value="15:00">15:00</option>
                      <option value="16:00">16:00</option>
                    </select>
                  </div>

                  <!-- Keluhan -->
                  <div class="col-12">
                    <label class="form-label fw-semibold">Keluhan atau Permintaan Khusus</label>
                    <textarea class="form-control border-secondary" id="keluhan" name="keluhan"
                      placeholder="Tulis keluhan atau permintaan servis Anda..." rows="3"></textarea>
                  </div>

                  <!-- Tombol Submit -->
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                      Pesan Sekarang
                    </button>
                  </div>
                </div>
              </form>
            </div>

            <div class="card-footer text-center text-muted small bg-light py-2">
              Kami akan menghubungi Anda untuk konfirmasi jadwal servis.
            </div>
          </div>
        </div>
      </div> <!-- row -->
    </div> <!-- container -->
  </div> <!-- container-fluid -->



  <!-- Footer Start -->
  <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <div class="row g-5">
        <!-- Alamat -->
        <div class="col-lg-3 col-md-6">
          <h4 class="text-light mb-4">Alamat</h4>
          <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. S Parman No. 156 - 164 Padang</p>
          <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>(0751) 7054654</p>
          <div class="d-flex pt-2">
            <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/share/16Vd6P3VMo/"><i
                class="fab fa-facebook-f"></i></a>
            <a class="btn btn-outline-light btn-social"
              href="https://www.instagram.com/utamaservice_padang?igsh=MTB4eG5ya3doOTZ6cQ=="><i
                class="fab fa-instagram"></i></a>
          </div>
        </div>

        <!-- Jam Buka -->
        <div class="col-lg-3 col-md-6">
          <h4 class="text-light mb-4">Buka</h4>
          <h6 class="text-light">Senin – Kamis :</h6>
          <p class="mb-4">08.00 AM – 17.00 PM</p>
          <h6 class="text-light">Sabtu – Minggu :</h6>
          <p class="mb-0">08.00 AM – 17.00 PM</p>
        </div>

        <!-- Servis -->
        <div class="col-lg-3 col-md-6">
          <h4 class="text-light mb-4">Servis</h4>
          <a class="btn btn-link" href="/Home/layanan">Tes Diagnostik</a>
          <a class="btn btn-link" href="/Home/layanan">Servis Mesin</a>
          <a class="btn btn-link" href="/Home/layanan">Penggantian Ban</a>
          <a class="btn btn-link" href="/Home/layanan">Penggantian Oli</a>
          <a class="btn btn-link" href="/Home/layanan">Pembersihan Vakum</a>
        </div>

        <!-- Kolom Baru: Dukungan -->
        <div class="col-lg-3 col-md-6">
          <h4 class="text-light mb-4">Dukungan & Bantuan</h4>
          <a class="btn btn-link" href="/Home/tentang">Tentang Kami</a>
          <a class="btn btn-link" href="/Home/faq">FAQ</a>
          <a class="btn btn-link" href="/Booking">Booking Servis</a>
        </div>
      </div>

    </div>
    <div class="container">
      <div class="copyright">
        <div class="row">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            &copy; <a class="border-bottom" href="/">2025 Utama Service Station</a></div>
          <div class="col-md-6 text-center text-md-end">
            <div class="footer-menu">
              <a href="/">Beranda</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer End -->
  <!-- Back to Top -->
  <a href="/theme/#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/theme/lib/wow/wow.min.js"></script>
  <script src="/theme/lib/easing/easing.min.js"></script>
  <script src="/theme/lib/waypoints/waypoints.min.js"></script>
  <script src="/theme/lib/counterup/counterup.min.js"></script>
  <script src="/theme/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="/theme/lib/tempusdominus/js/moment.min.js"></script>
  <script src="/theme/lib/tempusdominus/js/moment-timezone.min.js"></script>
  <script src="/theme/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

  <!-- Template Javascript -->
  <script src="/theme/js/main.js"></script>

  <?= $this->include('template/modal_login'); ?>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function () {
      $('#formBooking').submit(function (e) {
        e.preventDefault(); 

        $.ajax({
          url: "<?= site_url('/Booking/simpan') ?>",
          type: "POST",
          data: $(this).serialize(),
          dataType: "json",
          success: function (res) {
            if (res.success) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message
              });
              $('#formBooking')[0].reset();
            } else if (res.redirect) {
              Swal.fire({
                icon: 'warning',
                title: 'Login Diperlukan',
                text: res.message,
                confirmButtonText: 'Login Sekarang'
              }).then(() => {
                var modalLogin = new bootstrap.Modal(document.getElementById('modalLogin'));
                modalLogin.show();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: res.message || 'Terjadi kesalahan saat menyimpan data.'
              });
            }
          },
          error: function (xhr, status, error) {
            console.error(error);
            Swal.fire({
              icon: 'error',
              title: 'Kesalahan Server',
              text: 'Terjadi kesalahan pada server.'
            });
          }
        });
      });

      // Validasi Hari Jumat
      $('#tanggal_servis').on('change', function () {
        let dateVal = $(this).val();
        if (dateVal) {
          let date = new Date(dateVal);
          if (date.getDay() === 5) { // 5 adalah hari Jumat
            Swal.fire({
              icon: 'warning',
              title: 'Hari Libur',
              text: 'Maaf, hari Jumat bengkel kami libur. Silakan pilih hari lain.'
            });
            $(this).val('');
          }
        }
      });


    });
  </script>

</body>

</html>