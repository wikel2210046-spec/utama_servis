<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Utama Service Station - Mobil Saya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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
    <!-- Topbar Start -->
    <div class="container-fluid bg-light p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>Jl. S Parman No. 156 - 164 Padang</small>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>(0751) 7054654</small>
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
                            <a href="<?= site_url('/Mobil') ?>" class="dropdown-item active">Mobil Saya</a>
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

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(/theme/img/carousel-bg-1.jpg);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Mobil Saya</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Kendaraan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Content Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-10">
                    <div class="bg-light p-5 rounded">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Daftar Mobil</h2>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalTambahKendaraan">
                                <i class="fa fa-plus me-2"></i> Tambah Mobil
                            </button>
                        </div>

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

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover bg-white">
                                <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>No Polisi</th>
                                        <th>Merk</th>
                                        <th>Tipe</th>
                                        <th>Jenis</th>
                                        <th>Warna</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($mobil)): ?>
                                        <?php $no = 1;
                                        foreach ($mobil as $m): ?>
                                            <tr class="align-middle text-center">
                                                <td><?= $no++ ?></td>
                                                <td class="fw-bold"><?= $m['no_polisi'] ?></td>
                                                <td><?= $m['merk'] ?: '-' ?></td>
                                                <td><?= $m['tipe'] ?: '-' ?></td>
                                                <td><?= $m['jenis'] ?: '-' ?></td>
                                                <td><?= $m['warna'] ?: '-' ?></td>
                                                <td>
                                                    <a href="<?= site_url('/Mobil/hapus/' . $m['id_mobil']) ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini?');">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4">Belum ada mobil yang ditambahkan.
                                                Silakan tambah mobil.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content End -->

    <!-- Modal Tambah Mobil -->
    <div class="modal fade" id="modalTambahKendaraan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= site_url('/Mobil/tambah') ?>" method="post">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white">Tambah Mobil Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">No Polisi (Plat Nomor) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_polisi" placeholder="Contoh: BA 1234 XY"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Merk Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select" name="merk" id="merk" required>
                                <option value="">-- Pilih Merk --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select" name="tipe" id="tipe" required>
                                <option value="">-- Pilih Tipe --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" name="jenis" id="jenis" readonly required
                                placeholder="Jenis akan terisi otomatis">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Warna <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="warna" placeholder="Contoh: Hitam" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Mobil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Utama Service Station</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. S Parman No. 156 - 164 Padang</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>(0751) 7054654</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="index.php">2025 Utama Service Station</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/theme/lib/wow/wow.min.js"></script>
    <script src="/theme/js/main.js"></script>
    <script>
        const dataMobil = {
            "Toyota": {
                "Avanza": "Minibus", "Innova": "Minibus", "Alphard": "Minibus", "Rush": "SUV", "Fortuner": "SUV", "Yaris": "Hatchback", "Agya": "Hatchback", "Calya": "Minibus", "Vios": "Sedan", "Camry": "Sedan", "Hilux": "Pick Up"
            },
            "Honda": {
                "Brio": "Hatchback", "Jazz": "Hatchback", "HR-V": "SUV", "CR-V": "SUV", "BR-V": "SUV", "Mobilio": "Minibus", "Civic": "Sedan", "City": "Sedan", "Accord": "Sedan"
            },
            "Daihatsu": {
                "Xenia": "Minibus", "Terios": "SUV", "Ayla": "Hatchback", "Sigra": "Minibus", "Sirion": "Hatchback", "Rocky": "SUV", "Gran Max": "Pick Up", "Luxio": "Minibus"
            },
            "Suzuki": {
                "Ertiga": "Minibus", "XL7": "SUV", "Ignis": "Hatchback", "Baleno": "Hatchback", "Carry": "Pick Up", "APV": "Minibus"
            },
            "Mitsubishi": {
                "Xpander": "Minibus", "Xpander Cross": "SUV", "Pajero Sport": "SUV", "Outlander": "SUV", "Mirage": "Hatchback", "L300": "Pick Up", "Triton": "Pick Up"
            },
            "Nissan": {
                "Livina": "Minibus", "X-Trail": "SUV", "Kicks": "SUV", "Magnite": "SUV", "Serena": "Minibus", "March": "Hatchback"
            },
            "Lainnya": {
                "Lainnya": "Lainnya"
            }
        };

        $(document).ready(function () {
            // Populate Merk
            $.each(dataMobil, function (merk, types) {
                $('#merk').append(new Option(merk, merk));
            });

            // On Merk Change
            $('#merk').change(function () {
                let selectedMerk = $(this).val();
                let tipeSelect = $('#tipe');
                let jenisInput = $('#jenis');

                tipeSelect.empty().append(new Option("-- Pilih Tipe --", ""));
                jenisInput.val('');

                if (selectedMerk && dataMobil[selectedMerk]) {
                    $.each(dataMobil[selectedMerk], function (tipe, jenis) {
                        tipeSelect.append(new Option(tipe, tipe));
                    });
                }
            });

            // On Tipe Change
            $('#tipe').change(function () {
                let selectedMerk = $('#merk').val();
                let selectedTipe = $(this).val();

                if (selectedMerk && selectedTipe && dataMobil[selectedMerk][selectedTipe]) {
                    $('#jenis').val(dataMobil[selectedMerk][selectedTipe]);
                } else {
                    $('#jenis').val('');
                }
            });
        });
    </script>
</body>

</html>