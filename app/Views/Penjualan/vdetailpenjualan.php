<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Detail Penjualan Sparepart</h3>
        </div>

        <!-- Informasi Utama Penjualan -->
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 35%;">Kode Penjualan</th>
                        <td>: <span class="badge badge-info"><?= esc($penjualan['kode_penjualan']) ?></span></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: <?= esc(date('d-m-Y', strtotime($penjualan['tanggal_penjualan']))) ?></td>
                    </tr>
                    <tr>
                        <th>Pelanggan</th>
                        <td>: <strong><?= esc($penjualan['nama_pelanggan']) ?></strong></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 35%;">No. HP</th>
                        <td>: <?= esc($penjualan['no_hp'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: <?= esc($penjualan['alamat'] ?? '-') ?></td>
                    </tr>
                    <!-- Keterangan dihapus karena tidak ada di DB baru -->
                </table>
            </div>
        </div>

        <hr>

        <!-- Detail Sparepart yang Dijual -->
        <h5 class="mb-3">Daftar Item Sparepart</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Sparepart</th>
                        <th>Harga (Rp)</th>
                        <th>Jumlah</th>
                        <th>Subtotal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($detail)): ?>
                        <?php $no = 1; $total = 0; ?>
                        <?php foreach ($detail as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($row['nama_sparepart']) ?></td>
                                <td class="text-end"><?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                                <td class="text-center"><?= esc($row['jumlah_jual']) ?></td>
                                <td class="text-end"><?= number_format($row['jumlah_jual'] * $row['harga_jual'], 0, ',', '.') ?></td>
                            </tr>
                            <?php $total += ($row['jumlah_jual'] * $row['harga_jual']); ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada detail penjualan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-light fw-bold">
                        <td colspan="4" class="text-end">Total Akhir</td>
                        <td class="text-end">Rp <?= number_format($total ?? 0, 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Tombol Cetak & Kembali -->
        <div class="text-end mt-3">
            <button class="btn btn-primary me-2" onclick="window.print()">
                <i class="fa fa-print"></i> 
            </button>
            <a href="<?= base_url('penjualansparepart') ?>" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> 
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .navbar, .sidebar, header, footer {
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
    th, td {
        vertical-align: middle !important;
    }
</style>

<?= $this->endSection() ?>
