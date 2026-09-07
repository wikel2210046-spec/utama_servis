<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Detail Pembelian Sparepart</h3>
        </div>

        <!-- Informasi Utama Pembelian -->
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 35%;">ID Pembelian</th>
                        <td>: <?= esc($pembelian['id_pembelian']) ?></td>
                    </tr>
                    <tr>
                        <th>Kode Pembelian</th>
                        <td>: <?= esc($pembelian['kode_pembelian']) ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: <?= date('d-m-Y', strtotime($pembelian['tanggal_pembelian'])) ?></td>
                    </tr>
                    <tr>
                        <th>Pemasok</th>
                        <td>: <?= esc($pembelian['nama_pemasok']) ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th>Total Item</th>
                        <td>: <?= count($detail) ?> Jenis Sparepart</td>
                    </tr>
                    <tr>
                        <th>Total Pembelian</th>
                        <td>: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <!-- Detail Sparepart yang Dibeli -->
        <h5 class="mb-3">Daftar Sparepart yang Dibeli</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Sparepart</th>
                        <th>Jumlah Beli</th>
                        <th>Harga Beli (Rp)</th>
                        <th>Subtotal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($detail)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($detail as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= esc($row['nama_sparepart']) ?></td>
                                <td class="text-center"><?= esc($row['jumlah_beli']) ?></td>
                                <td class="text-end"><?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($row['jumlah_beli'] * $row['harga_beli'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada detail pembelian.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-light fw-bold">
                        <td colspan="4" class="text-end">Total</td>
                        <td class="text-end">Rp <?= number_format($total, 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Tombol Cetak & Kembali -->
        <div class="text-end mt-3">
            <!-- <button class="btn btn-primary me-2" onclick="window.print()">
                <i class="fa fa-print"></i> 
            </button> -->
            <a href="<?= base_url('pembeliansparepart') ?>" class="btn btn-secondary">
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
