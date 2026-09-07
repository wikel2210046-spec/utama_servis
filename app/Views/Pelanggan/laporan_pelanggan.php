<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="container">
     <!-- HEADER -->
<div class="header mb-4 position-relative">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <!-- LOGO KIRI -->
        <div class="logo-container">
            <img src="<?= base_url('assets/dist/img/logouss.png') ?>" 
                 alt="Logo" 
                 style="width: 70px; height: auto;">
        </div>

        <!-- TEKS HEADER (TENGAH) -->
        <div class="text-center flex-grow-1">
            <h3 class="fw-bold mb-1 text-uppercase">UTAMA SERVICE STATION</h3>
            <p style="font-size: 14px; margin-bottom: 0;">
                Jl. S. Parman No.156 Padang
            </p>
            <p style="font-size: 13px; margin-bottom: 0;">
                Telp: (0751) 7054654 / 7052123
            </p>

            <!-- Jarak tambahan antara telepon dan judul laporan -->
            <h4 class="fw-bold text-decoration-underline mt-3" style="font-size: 16px;">
                LAPORAN DATA PELANGGAN
            </h4>
        </div>
    </div>
</div>

    <!-- Baris info tanggal dan dicetak oleh -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <p style="font-size: 13px; margin-bottom: 0;">
                <strong>Tanggal:</strong> <?= date('d-m-Y') ?>
            </p>
        </div>
        <div class="text-right">
            <p style="font-size: 13px; margin-bottom: 2px;">
                <strong>Dicetak oleh:</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 0;">
                <?= esc($username) ?>
            </p>
        </div>
    </div>

    <!-- Tombol Cetak -->
    <button class="print-btn btn btn-primary mb-3" onclick="window.print()">
        <i class="fa fa-print"></i> Cetak Laporan
    </button>

    <!-- Tabel Data Pelanggan -->
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center bg-dark text-white">
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>No HP</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dataPelanggan)): ?>
                <?php $no = 1; ?>
                <?php foreach ($dataPelanggan as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($row['nama_pelanggan']) ?></td>
                        <td><?= esc($row['email']) ?></td>
                        <td><?= esc($row['alamat']) ?></td>
                        <td><?= esc($row['no_hp']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data pelanggan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
     <!-- TANDA TANGAN -->
    <div class="mt-5" style="width: 40%; margin-left: auto; text-align: center;">
        <p>Padang, <?= date('d-m-Y') ?></p>
        <p><strong>Pimpinan</strong></p>
        <br><br><br>
         <p>(................................................)</p>
    </div>

</div>

<style>
    @media print {
        .print-btn,
        header,
        .sidebar,
          footer,            
    .main-footer, 
        .main-header {
            display: none !important;
        }

        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
        }
    }

    .header h2, .header h3, .header h5 {
        margin: 0;
    }
</style>

<?= $this->endSection() ?>
