<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Utama Service Station - Profile</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/theme/img/logouss.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <a href="<?= site_url('/') ?>" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-car me-3"></i>Utama Service Station</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="<?= site_url('/') ?>" class="nav-item nav-link">Beranda</a>
                <a href="<?= site_url('/Home/tentang') ?>" class="nav-item nav-link">Tentang Kami</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Servis</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="<?= site_url('/Booking') ?>" class="dropdown-item">Booking Servis</a>
                        <a href="<?= site_url('/Home/status') ?>" class="dropdown-item">Status Servis</a>
                        <a href="<?= site_url('/Home/layanan') ?>" class="dropdown-item">Jenis Servis</a>
                    </div>
                </div>
                <?php if (session()->get('loggedin')): ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">
                            <i class="fa fa-user me-2"></i><?= session()->get('nama') ?>
                        </a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="<?= site_url('/Mobil') ?>" class="dropdown-item">Mobil Saya</a>
                            <a href="<?= site_url('/Home/profil') ?>" class="dropdown-item active">Setting</a>
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

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(/theme/img/carousel-bg-1.jpg);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Profile Saya</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Profile Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-light p-5 rounded">
                        <h2 class="mb-4">Edit Informasi Akun</h2>
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('Home/updateProfil') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nama_pelanggan"
                                            name="nama_pelanggan" placeholder="Nama Lengkap"
                                            value="<?= esc($pelanggan['nama_pelanggan']) ?>" required>
                                        <label for="nama_pelanggan">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" value="<?= esc($pelanggan['email']) ?>" required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                                            placeholder="Nomor HP" value="<?= esc($pelanggan['no_hp']) ?>" required>
                                        <label for="no_hp">Nomor HP</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Alamat" id="alamat" name="alamat"
                                            style="height: 100px" required><?= esc($pelanggan['alamat']) ?></textarea>
                                        <label for="alamat">Alamat</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <h5 class="mb-3 border-bottom pb-2 text-secondary">Ubah Password (Kosongkan jika
                                        tidak ingin diubah)</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Password Baru">
                                        <label for="password">Password Baru</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" placeholder="Konfirmasi Password Baru">
                                        <label for="confirm_password">Konfirmasi Password Baru</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 text-end">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
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
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Buka</h4>
                    <h6 class="text-light">Senin – Kamis :</h6>
                    <p class="mb-4">08.00 AM – 17.00 PM</p>
                    <h6 class="text-light">Sabtu – Minggu :</h6>
                    <p class="mb-0">08.00 AM – 17.00 PM</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Servis</h4>
                    <a class="btn btn-link" href="/Home/layanan">Tes Diagnostik</a>
                    <a class="btn btn-link" href="/Home/layanan">Servis Mesin</a>
                    <a class="btn btn-link" href="/Home/layanan">Penggantian Ban</a>
                    <a class="btn btn-link" href="/Home/layanan">Penggantian Oli</a>
                    <a class="btn btn-link" href="/Home/layanan">Pembersihan Vakum</a>
                </div>
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
                        &copy; <a class="border-bottom" href="index.php">2025 Utama Service Station</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="<?= site_url('/') ?>">Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

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