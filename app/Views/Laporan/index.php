<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark fw-bold">
                    <i class="fas fa-book-open text-primary me-2"></i> Pusat Laporan
                </h1>
                <p class="text-muted small mb-0">Pilih jenis laporan yang ingin Anda lihat atau cetak</p>
            </div>
            <div class="col-sm-6">
                <div class="search-box float-sm-right mt-2 mt-sm-0">
                    <div class="input-group input-group-sm" style="width: 300px;">
                        <input type="text" id="searchReport" class="form-control form-control-lg shadow-sm" placeholder="Cari laporan...">
                        <div class="input-group-append">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- KATEGORI: LAPORAN MASTER DATA -->
        <div class="report-section mb-4">
            <div class="section-title mb-3 pb-2 border-bottom d-flex align-items-center">
                <h5 class="mb-0 font-weight-bold text-secondary">Laporan Master Data</h5>
            </div>
            <div class="row">
                <!-- Data Pelanggan -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-primary text-primary rounded-circle me-3">
                                    <i class="fas fa-address-card fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Data Pelanggan</h5>
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Rekapitulasi seluruh data pelanggan yang terdaftar pada sistem bengkel.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Pelanggan/laporan') ?>" class="btn btn-outline-primary btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Data Mekanik -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-info text-info rounded-circle me-3">
                                    <i class="fas fa-user-gear fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Data Mekanik</h5>
                                   
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Daftar informasi teknisi/mekanik dan keahlian operasional servis.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Mekanik/laporan') ?>" class="btn btn-outline-info btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Data Jenis Servis -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-warning text-warning rounded-circle me-3">
                                    <i class="fas fa-wrench fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Data Jenis Servis</h5>
                                    
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Katalog kategori layanan perbaikan kendaraan beserta standar estimasi biaya.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Servis/laporan') ?>" class="btn btn-outline-warning text-dark btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Data Sparepart -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-success text-success rounded-circle me-3">
                                    <i class="fas fa-cubes fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Data Sparepart</h5>
                                   
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Rekap persediaan suku cadang, jumlah stok barang, dan daftar harga sparepart.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Sparepart/laporan') ?>" class="btn btn-outline-success btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Data Pemasok -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-secondary text-secondary rounded-circle me-3">
                                    <i class="fas fa-truck fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Data Pemasok</h5>
                                    
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Daftar supplier/distributor mitra penyedia suku cadang bengkel.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Pemasok/laporan') ?>" class="btn btn-outline-secondary btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KATEGORI: LAPORAN TRANSAKSI -->
        <div class="report-section mb-4">
            <div class="section-title mb-3 pb-2 border-bottom d-flex align-items-center">
              
                <h5 class="mb-0 font-weight-bold text-secondary">Laporan Transaksi Operasional</h5>
            </div>
            <div class="row">
                <!-- Data Booking -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-indigo text-indigo rounded-circle me-3">
                                    <i class="fas fa-calendar-check fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Data Booking</h5>
                                   
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Rekap pemesanan jadwal servis pelanggan online maupun langsung.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Pemesanan/laporan') ?>" class="btn btn-outline-indigo btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Data Servis -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-teal text-teal rounded-circle me-3">
                                    <i class="fas fa-car-side fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Data Servis</h5>
                                    
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Laporan riwayat pengerjaan & pelunasan pembayaran transaksi servis.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Pembayaran/laporan') ?>" class="btn btn-outline-teal btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pembelian Sparepart -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-purple text-purple rounded-circle me-3">
                                    <i class="fas fa-cart-shopping fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Pembelian Sparepart</h5>
                                    
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Rekap pengadaan & restok barang dari supplier ke bengkel.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Pembeliansparepart/laporan') ?>" class="btn btn-outline-purple btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Penjualan Sparepart -->
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-orange text-orange rounded-circle me-3">
                                    <i class="fas fa-cash-register fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Penjualan Sparepart</h5>
                                    
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Laporan transaksi penjualan suku cadang langsung kepada pelanggan.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Penjualansparepart/laporan') ?>" class="btn btn-outline-orange btn-block rounded-pill">
                                <i class="fas fa-arrow-right me-1"></i> Buka Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KATEGORI: LAPORAN KEUANGAN -->
        <div class="report-section mb-4">
            <div class="section-title mb-3 pb-2 border-bottom d-flex align-items-center">
                <h5 class="mb-0 font-weight-bold text-secondary">Laporan Arus Kas & Keuangan</h5>
            </div>
            <div class="row">
                <!-- Laporan Uang Masuk -->
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg border-left-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-success text-success rounded-circle me-3">
                                    <i class="fas fa-arrow-trend-up fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Laporan Uang Masuk</h5>
                                    
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Rekapitulasi penerimaan uang dari pembayaran servis kendaraan dan penjualan sparepart.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Laporanuangmasuk/index') ?>" class="btn btn-success btn-block rounded-pill shadow-sm">
                                <i class="fas fa-file-invoice-dollar me-1"></i> Buka Laporan Uang Masuk
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Laporan Uang Keluar -->
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4 report-card-item">
                    <div class="card h-100 card-report shadow-sm border-0 rounded-lg border-left-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-light-danger text-danger rounded-circle me-3">
                                    <i class="fas fa-arrow-trend-down fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold mb-1">Laporan Uang Keluar</h5>
                                   
                                </div>
                            </div>
                            <p class="card-text text-muted small">
                                Rekapitulasi pengeluaran kas bengkel untuk operasional dan belanja suku cadang.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                            <a href="<?= base_url('Laporanuangkeluar/index') ?>" class="btn btn-danger btn-block rounded-pill shadow-sm">
                                <i class="fas fa-file-invoice-dollar me-1"></i> Buka Laporan Uang Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Custom Styling for Report Dashboard Cards -->
<style>
    .icon-box {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-report {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        background: #ffffff;
    }

    .card-report:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12) !important;
    }

    /* Custom Colors */
    .bg-light-primary { background-color: #e8f1ff !important; }
    .bg-light-info { background-color: #e3f7fc !important; }
    .bg-light-warning { background-color: #fff9e6 !important; }
    .bg-light-success { background-color: #e6f9ed !important; }
    .bg-light-danger { background-color: #ffebe9 !important; }
    .bg-light-secondary { background-color: #f0f1f3 !important; }
    .bg-light-indigo { background-color: #eef2ff !important; }
    .bg-light-teal { background-color: #e6fffa !important; }
    .bg-light-purple { background-color: #f3e8ff !important; }
    .bg-light-orange { background-color: #fff3e0 !important; }

    .text-indigo { color: #4f46e5 !important; }
    .bg-indigo { background-color: #4f46e5 !important; }
    .btn-outline-indigo { color: #4f46e5; border-color: #4f46e5; }
    .btn-outline-indigo:hover { background-color: #4f46e5; color: #fff; }

    .text-teal { color: #0d9488 !important; }
    .bg-teal { background-color: #0d9488 !important; }
    .btn-outline-teal { color: #0d9488; border-color: #0d9488; }
    .btn-outline-teal:hover { background-color: #0d9488; color: #fff; }

    .text-purple { color: #9333ea !important; }
    .bg-purple { background-color: #9333ea !important; }
    .btn-outline-purple { color: #9333ea; border-color: #9333ea; }
    .btn-outline-purple:hover { background-color: #9333ea; color: #fff; }

    .text-orange { color: #ea580c !important; }
    .bg-orange { background-color: #ea580c !important; }
    .btn-outline-orange { color: #ea580c; border-color: #ea580c; }
    .btn-outline-orange:hover { background-color: #ea580c; color: #fff; }

    .border-left-success {
        border-left: 5px solid #28a745 !important;
    }

    .border-left-danger {
        border-left: 5px solid #dc3545 !important;
    }
</style>

<!-- Live Search JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchReport');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                const cardItems = document.querySelectorAll('.report-card-item');

                cardItems.forEach(item => {
                    const title = item.querySelector('.card-title')?.textContent.toLowerCase() || '';
                    const text = item.querySelector('.card-text')?.textContent.toLowerCase() || '';
                    const badge = item.querySelector('.badge')?.textContent.toLowerCase() || '';

                    if (title.includes(query) || text.includes(query) || badge.includes(query)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>

<?= $this->endSection() ?>
