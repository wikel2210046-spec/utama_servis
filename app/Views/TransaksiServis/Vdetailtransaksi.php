<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Detail Transaksi Servis</h3>
        </div>

        <!-- Informasi Utama Servis -->
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 35%;">ID Transaksi</th>
                        <td>: <?= esc($transaksi['id_transaksi']) ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Servis</th>
                        <td>: <?= date('d-m-Y', strtotime($transaksi['tanggal_servis'])) ?></td>
                    </tr>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td>: <?= esc($transaksi['nama_pelanggan']) ?></td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>: <?= esc($transaksi['no_hp'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Keluhan</th>
                         <td>: <?= esc($transaksi['keluhan'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th>Tipe </th>
                        <td>: <?= esc($transaksi['tipe'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Warna </th>
                        <td>: <?= esc($transaksi['warna_mobil'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>No. Polisi</th>
                        <td>: <?= esc($transaksi['no_polisi'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Mekanik</th>
                        <td>: <?= esc($transaksi['nama_mekanik'] ?? '-') ?></td>
                    </tr>
                    <!-- <tr>
                        <th>Total Biaya</th>
                        <td>: <strong>Rp <?= number_format($transaksi['total_biaya'], 0, ',', '.') ?></strong></td>
                    </tr> -->
                </table>
            </div>
        </div>

        <hr>

        <!-- Detail Servis -->
        <h5 class="mb-3">Daftar Pekerjaan Servis</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped align-middle">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Servis</th>
                        <th>Biaya Servis (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($servis)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($servis as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($row['nama_servis']) ?></td>
                                <td class="text-end"><?= number_format($row['harga_js'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data servis.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Detail Sparepart -->
        <h5 class="mb-3">Daftar Sparepart yang Digunakan</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Sparepart</th>
                        <th>Jumlah</th>
                        <th>Harga (Rp)</th>
                        <th>Subtotal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sparepart)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($sparepart as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($row['nama_sparepart']) ?></td>
                                <td class="text-center"><?= esc($row['jumlah_sp']) ?></td>
                                <td class="text-end"><?= number_format($row['harga_sp'], 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($row['jumlah_sp'] * $row['harga_sp'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada sparepart digunakan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-light fw-bold">
                        <td colspan="4" class="text-end">Total Biaya</td>
                        <td class="text-end">Rp <?= number_format($transaksi['total_biaya'], 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Tombol -->
        <div class="text-end mt-3 d-print-none">
            <a href="<?= base_url('TransaksiServis/cetakSpk/' . $transaksi['id_transaksi']) ?>" target="_blank" class="btn btn-warning me-2">
                <i class="fa fa-file-text"></i> Cetak SPK
            </a>
            <!-- <button class="btn btn-primary me-2" onclick="window.print()">
                <i class="fa fa-print"></i> Cetak Struk
            </button> -->
            <a href="<?= base_url('TransaksiServis') ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<style>
    @media print {

        .btn,
        .navbar,
        .sidebar,
        header,
        footer {
            display: none !important;
        }

        body {
            background: white;
        }

        .card {
            box-shadow: none;
            border: none;
        }

        table {
            font-size: 13px;
        }
    }

    th,
    td {
        vertical-align: middle !important;
    }
</style>

<?= $this->endSection() ?>