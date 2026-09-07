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
        <a href="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-car me-3"></i>Utama Service Station</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="<?= site_url('/') ?>" class="nav-item nav-link active">Beranda</a>
                <a href="<?= site_url('/Home/tentang') ?>" class="nav-item nav-link">Tentang Kami</a>
                <!-- <a href="<?= site_url('/Home/sparepart') ?>" class="nav-item nav-link">Sparepart</a> -->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Servis</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="<?= site_url('/Booking') ?>" class="dropdown-item">Booking Servis</a>
                        <a href="<?= site_url('/Home/status') ?>" class="dropdown-item">Status Servis</a>
                        <!-- <a href="<?= site_url('/Home/riwayat') ?>" class="dropdown-item">Riwayat Servis</a> -->
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
    <!-- Navbar End -->
    <!-- FAQ Section Start -->
    <div class="container-xxl py-5">
        <div class="container">

            <h6 class="text-primary text-uppercase">// FAQ //</h6>
            <h1 class="mb-4">Pertanyaan yang Sering Diajukan</h1>

            <div class="accordion" id="faqAccordion">

                <!-- FAQ 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            1. Apakah saya perlu membuat janji sebelum datang ke bengkel?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Tidak wajib, namun sangat disarankan agar Anda tidak menunggu terlalu lama.
                            Anda dapat melakukan booking servis melalui halaman Booking atau menghubungi kami langsung.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq2">
                            2. Apa saja jenis servis yang tersedia?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Kami menyediakan layanan diagnostik, servis mesin, tune-up, ganti oli, ganti ban,
                            servis rem, dan perawatan kendaraan lainnya.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq3">
                            3. Berapa lama waktu pengerjaan servis?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Waktu pengerjaan tergantung jenis servis. Ganti oli ± 30 menit, ganti ban ± 20–30 menit,
                            servis ringan ± 1–2 jam, dan servis besar ± 3–5 jam.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq4">
                            4. Apakah bengkel menerima semua jenis mobil?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami melayani mobil manual dan matic dari berbagai merek seperti Toyota, Honda,
                            Daihatsu, Suzuki, Nissan, Mitsubishi, dan lainnya.
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq5">
                            5. Bagaimana cara mengetahui biaya servis?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Anda dapat melihat Jenis Servis pada halaman Servis atau bertanya langsung ke admin.
                            Estimasi biaya akan disampaikan sebelum pengerjaan.
                        </div>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq6">
                            6. Apakah ada garansi untuk servis?
                        </button>
                    </h2>
                    <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami memberikan garansi untuk jasa servis tertentu serta sparepart resmi sesuai
                            ketentuan
                            pabrik.
                        </div>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <!-- <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq7">
                            7. Apakah menerima pembayaran non-tunai?
                        </button>
                    </h2>
                    <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami menerima pembayaran melalui transfer bank dan QRIS.
                        </div>
                    </div>
                </div> -->

                <!-- FAQ 8 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq8">
                            7. Apakah bisa menunggu di tempat selama servis berlangsung?
                        </button>
                    </h2>
                    <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Bisa, kami menyediakan ruang tunggu ber-AC, WiFi, dan fasilitas nyaman lainnya.
                        </div>
                    </div>
                </div>

                <!-- FAQ 9 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq9">
                            8. Apakah buka pada hari Minggu?
                        </button>
                    </h2>
                    <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami buka setiap hari dari pukul 08.00 – 17.00, kecuali hari jumat ataupun hari libur
                            nasional tertentu.
                        </div>
                    </div>
                </div>

                <!-- FAQ 10 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq10">
                            9. Apakah menyediakan layanan towing jika mobil mogok?
                        </button>
                    </h2>
                    <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami menyediakan layanan evakuasi kendaraan melalui rekanan towing. Hubungi kami jika
                            membutuhkan bantuan.
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- FAQ Section End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#formBooking').submit(function (e) {
                e.preventDefault(); // penting banget!

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
        });
    </script>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->include('template/modal_login'); ?>
    <script>
        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('showLogin') === 'true') {
                var modalLogin = new bootstrap.Modal(document.getElementById('modalLogin'));
                modalLogin.show();
            }
        });
    </script>

</body>

</html>