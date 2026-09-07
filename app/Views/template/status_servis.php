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
                    <a class="btn btn-sm-square bg-white text-primary me-1"
                        href="https://www.facebook.com/share/16Vd6P3VMo/"><i class="fab fa-facebook-f"></i></a>
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
                        <a href="<?= site_url('/Booking') ?>" class="dropdown-item">Booking Servis</a>
                        <a href="<?= site_url('/Home/status') ?>" class="dropdown-item active">Status Servis</a>
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
    </nav>

    <!-- Status Servis Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center fs-5">
                    <i class="fa fa-times-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <!-- Judul Halaman -->
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">// Status Servis //</h6>
                <h1 class="mb-5">Cek Status Servis Kendaraan Anda</h1>
            </div>

            <?php if (isset($is_detail) && $is_detail): ?>
                <!-- Menampilkan Detail Servis -->
                <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="col-lg-8">
                        <div class="card shadow border-0 p-4">
                            <h4 class="fw-bold mb-4 text-primary">Detail Pemesanan</h4>
                            <table class="table table-striped">
                                <tr>
                                    <th>Kode Pemesanan</th>
                                    <td><?= $servis['kode_pemesanan'] ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <td><?= $servis['nama_pelanggan'] ?></td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td><?= $servis['no_hp'] ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Servis</th>
                                    <td><?= date('d-m-Y', strtotime($servis['tanggal_servis'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Jam Servis</th>
                                    <td><?= $servis['jam_servis'] ?></td>
                                </tr>
                                <tr>
                                    <th>Tipe</th>
                                    <td><?= $servis['tipe'] ?></td>
                                </tr>
                                <tr>
                                    <th>No Polisi</th>
                                    <td><?= $servis['no_polisi'] ?></td>
                                </tr>
                                <tr>
                                    <th>Keluhan</th>
                                    <td><?= $servis['keluhan'] ?></td>
                                </tr>
                            </table>

                            <hr>

                            <h4 class="fw-bold mb-3 text-primary">Status Servis</h4>
                            <?php if ($servis['status'] == 'selesai servis'): ?>
                                <div class="alert alert-success fs-5">
                                    <i class="fa fa-check-circle me-2"></i> Servis sudah selesai dilakukan oleh mekanik <strong><?= isset($transaksi['nama_mekanik']) ? $transaksi['nama_mekanik'] : '-' ?></strong>
                                    <br>
                                    <i class="fa fa-money-bill-wave me-2 mt-2"></i> Kendaraan sudah bisa dijemput dengan jumlah pembayaran <br> <strong>Rp <?= isset($transaksi['total_biaya']) ? number_format($transaksi['total_biaya'], 0, ',', '.') : '0' ?></strong>
                                </div>
                            <?php elseif ($servis['status'] == 'selesai'): ?>
                                <div class="alert alert-success fs-5">
                                    <i class="fa fa-check-circle me-2"></i> Selesai
                                </div>
                            <?php elseif ($servis['status'] == 'proses'): ?>
                                <div class="alert alert-warning fs-5">
                                    <i class="fa fa-spinner me-2"></i> Dalam Proses Servis
                                </div>
                            <?php else: ?>
                                <div class="alert alert-secondary fs-5">
                                    <i class="fa fa-clock me-2"></i> Booking
                                </div>
                            <?php endif; ?>

                            <a href="<?= site_url('/Home/status') ?>" class="btn btn-secondary mt-3"><i
                                    class="fa fa-arrow-left me-2"></i>Kembali</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Menampilkan Daftar Booking -->
                <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="col-lg-10">
                        <div class="card shadow border-0 p-4">
                            <h4 class="fw-bold mb-4 text-primary">Daftar Pemesanan Servis Anda</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-primary text-white text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Pemesanan</th>
                                            <th>Tanggal Servis</th>
                                            <th>Mobil</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($pemesanan)): ?>
                                            <?php $no = 1;
                                            foreach ($pemesanan as $p): ?>
                                                <tr class="align-middle">
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><?= $p['kode_pemesanan'] ?></td>
                                                    <td><?= date('d-m-Y', strtotime($p['tanggal_servis'])) ?>
                                                        <?= substr($p['jam_servis'], 0, 5) ?></td>
                                                    <td><?= $p['tipe'] ?> (<?= $p['no_polisi'] ?>)</td>
                                                    <td class="text-center">
                                                        <?php if ($p['status'] == 'selesai servis'): ?>
                                                            <span class="badge bg-success">Selesai Servis</span>
                                                        <?php elseif ($p['status'] == 'selesai'): ?>
                                                            <span class="badge bg-success">Selesai</span>
                                                        <?php elseif ($p['status'] == 'proses'): ?>
                                                            <span class="badge bg-warning text-dark">Proses</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Booking</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?= site_url('/Home/status/' . $p['kode_pemesanan']) ?>"
                                                            class="btn btn-sm btn-info text-white">
                                                            <i class="fa fa-eye"></i> Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4">Belum ada data pemesanan servis.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <!-- Status Servis End -->

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
                        &copy; <a class="border-bottom" href="index.php">2025 Utama Service Station</a></div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="index.php">Beranda</a>
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
</body>

</html>