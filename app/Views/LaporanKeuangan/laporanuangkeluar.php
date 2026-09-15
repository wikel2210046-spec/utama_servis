<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="container">

    <!-- HEADER -->
    <div class="header mb-4 position-relative">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="logo-container">
                <img src="<?= base_url('assets/dist/img/logouss.png') ?>" alt="Logo" style="width: 70px; height: auto;">
            </div>
            <div class="text-center flex-grow-1">
                <h3 class="fw-bold mb-1 text-uppercase">UTAMA SERVICE STATION</h3>
                <p style="font-size: 14px; margin-bottom: 0;">Jl. S. Parman No.156 Padang</p>
                <p style="font-size: 13px; margin-bottom: 0;">Telp: (0751) 7054654 / 7052123</p>
                <h4 class="fw-bold text-decoration-underline mt-3" style="font-size: 16px;">
                    LAPORAN UANG KELUAR
                </h4>
            </div>
        </div>
    </div>

    <!-- INFORMASI TANGGAL DAN PENCETAK -->
    <div class="d-flex justify-content-between align-items-end mb-2">
        <div>
            <p style="font-size: 13px; margin-bottom: 0;">
                <strong>Tanggal Cetak:</strong> <?= date('d-m-Y') ?>
            </p>
            <?php
            $filterTeks = [];

            if (!empty($sumber_terpilih)) {
                $filterTeks[] = "Sumber: " . ($sumber_terpilih == 'pembelian' ? 'Pembelian Sparepart' : 'Uang Keluar Lainnya');
            } else {
                $filterTeks[] = "Sumber: Semua";
            }

            if ($periode == 'hari') {
                if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                    $filterTeks[] = "Periode: " . date('d-m-Y', strtotime($tanggal_mulai)) . " s/d " . date('d-m-Y', strtotime($tanggal_akhir));
                } elseif (!empty($tanggal_mulai)) {
                    $filterTeks[] = "Periode: Mulai " . date('d-m-Y', strtotime($tanggal_mulai));
                } elseif (!empty($tanggal_akhir)) {
                    $filterTeks[] = "Periode: Sampai " . date('d-m-Y', strtotime($tanggal_akhir));
                } else {
                    $filterTeks[] = "Periode: Hari Ini";
                }
            } elseif ($periode == 'bulan') {
                $namaBulanFilter = [
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                ];
                $b = sprintf('%02d', (int)($bulan ?? date('m')));
                $t = $tahun ?? date('Y');
                $filterTeks[] = "Periode: Bulan " . ($namaBulanFilter[$b] ?? '') . " " . $t;
            } elseif ($periode == 'tahun') {
                $t = $tahun ?? date('Y');
                $filterTeks[] = "Periode: Tahun " . $t;
            } else {
                $filterTeks[] = "Periode: Semua Transaksi";
            }

            $teksFilterTampil = implode(" | ", $filterTeks);
            ?>
            <p style="font-size: 13px; margin-bottom: 0; margin-top: 5px;">
                <strong>Filter Diterapkan:</strong> <?= esc($teksFilterTampil) ?>
            </p>
        </div>
        <div class="text-right">
            <p style="font-size: 13px; margin-bottom: 2px;"><strong>Dicetak oleh:</strong></p>
            <p style="font-size: 13px; margin-bottom: 0;"><?= esc($username) ?></p>
        </div>
    </div>

    <!-- FILTER UANG KELUAR -->
    <form action="<?= base_url('Laporanuangkeluar/filter') ?>" method="get" class="filter-bar bg-light p-3 rounded shadow-sm mb-4">
        <div class="row align-items-end g-2">
            <div class="col-md-3 col-sm-6 mb-2 mb-md-0" id="slot-1">
                <div id="wrapper-tgl-mulai" class="filter-group">
                    <label class="form-label fw-semibold small text-secondary mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="<?= esc($tanggal_mulai ?? '') ?>">
                </div>
                <div id="wrapper-bulan" class="filter-group" style="display: none;">
                    <label class="form-label fw-semibold small text-secondary mb-1">Pilih Bulan</label>
                    <select name="bulan" class="form-control form-control-sm">
                        <?php
                        $months = [
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ];
                        $selectedBulan = sprintf('%02d', (int)($bulan ?? date('m')));
                        foreach ($months as $key => $val): ?>
                            <option value="<?= $key ?>" <?= ($selectedBulan == $key) ? 'selected' : '' ?>><?= $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-2 mb-md-0" id="slot-2">
                <div id="wrapper-tgl-akhir" class="filter-group">
                    <label class="form-label fw-semibold small text-secondary mb-1">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control form-control-sm" value="<?= esc($tanggal_akhir ?? '') ?>">
                </div>
                <div id="wrapper-tahun" class="filter-group" style="display: none;">
                    <label class="form-label fw-semibold small text-secondary mb-1">Pilih Tahun</label>
                    <select name="tahun" class="form-control form-control-sm">
                        <?php
                        $currentYear = (int)date('Y');
                        $selectedTahun = (int)($tahun ?? $currentYear);
                        for ($y = $currentYear - 5; $y <= $currentYear + 2; $y++): ?>
                            <option value="<?= $y ?>" <?= ($selectedTahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 mb-2 mb-md-0">
                <label class="form-label fw-semibold small text-secondary mb-1">Sumber</label>
                <select name="sumber" class="form-control form-control-sm">
                    <option value="">Semua Sumber</option>
                    <option value="pembelian" <?= (isset($sumber_terpilih) && $sumber_terpilih == 'pembelian') ? 'selected' : '' ?>>Pembelian Sparepart</option>
                    <option value="lainnya" <?= (isset($sumber_terpilih) && $sumber_terpilih == 'lainnya') ? 'selected' : '' ?>>Uang Keluar Lainnya</option>
                </select>
            </div>

            <div class="col-md-2 col-sm-4 mb-2 mb-md-0">
                <label class="form-label fw-semibold small text-secondary mb-1">Periode</label>
                <select name="periode" id="select-periode" class="form-control form-control-sm" onchange="toggleFilterFields()">
                    <option value="">Pilih Periode</option>
                    <option value="hari" <?= ($periode ?? '') == 'hari' ? 'selected' : '' ?>>Per Tanggal</option>
                    <option value="bulan" <?= ($periode ?? '') == 'bulan' ? 'selected' : '' ?>>Per Bulan</option>
                    <option value="tahun" <?= ($periode ?? '') == 'tahun' ? 'selected' : '' ?>>Per Tahun</option>
                </select>
            </div>

            <div class="col-md-2 col-sm-4 d-flex justify-content-end align-items-center mb-2 mb-md-0" style="gap: 4px;">
                <button type="submit" class="btn btn-primary btn-sm shadow-sm" title="Filter Data"><i class="fa-solid fa-filter"></i></button>
                <button type="button" class="btn btn-success btn-sm shadow-sm" onclick="window.print()" title="Cetak Laporan"><i class="fa-solid fa-print"></i></button>
                <a href="<?= base_url('Laporanuangkeluar/index') ?>" class="btn btn-secondary btn-sm shadow-sm" title="Reset Filter"><i class="fa-solid fa-arrows-rotate"></i></a>
            </div>
        </div>
    </form>

<script>
function toggleFilterFields() {
    const selectPeriode = document.getElementById('select-periode');
    if (!selectPeriode) return;
    const periode = selectPeriode.value;
    const wrapperTglMulai = document.getElementById('wrapper-tgl-mulai');
    const wrapperTglAkhir = document.getElementById('wrapper-tgl-akhir');
    const wrapperBulan = document.getElementById('wrapper-bulan');
    const wrapperTahun = document.getElementById('wrapper-tahun');
    const slot1 = document.getElementById('slot-1');
    const slot2 = document.getElementById('slot-2');

    if (periode === 'bulan') {
        slot1.style.display = 'block';
        slot2.style.display = 'block';
        wrapperTglMulai.style.display = 'none';
        wrapperBulan.style.display = 'block';
        wrapperTglAkhir.style.display = 'none';
        wrapperTahun.style.display = 'block';
    } else if (periode === 'tahun') {
        slot1.style.display = 'none';
        slot2.style.display = 'block';
        wrapperTglMulai.style.display = 'none';
        wrapperBulan.style.display = 'none';
        wrapperTglAkhir.style.display = 'none';
        wrapperTahun.style.display = 'block';
    } else if (periode === 'hari') {
        slot1.style.display = 'block';
        slot2.style.display = 'block';
        wrapperTglMulai.style.display = 'block';
        wrapperBulan.style.display = 'none';
        wrapperTglAkhir.style.display = 'block';
        wrapperTahun.style.display = 'none';
    } else {
        slot1.style.display = 'none';
        slot2.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', function() { toggleFilterFields(); });
</script>

    <!-- TABEL DATA UANG KELUAR -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <?php if (($periode ?? '') == 'tahun'): ?>
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Jumlah Transaksi</th>
                        <th>Total Pengeluaran (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $months = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                    $dataBulan = [];
                    if (!empty($dataUangKeluar)) {
                        foreach ($dataUangKeluar as $row) {
                            $dataBulan[(int)$row['bulan']] = [
                                'jumlah_transaksi' => $row['jumlah_transaksi'],
                                'total_pengeluaran' => $row['total_pengeluaran']
                            ];
                        }
                    }
                    foreach ($months as $num => $namaBulan): 
                        $dt = $dataBulan[$num] ?? ['jumlah_transaksi' => 0, 'total_pengeluaran' => 0];
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= esc($namaBulan) ?></td>
                            <td class="text-center"><?= esc($dt['jumlah_transaksi']) ?></td>
                            <td class="text-end"><?= number_format($dt['total_pengeluaran'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-danger">
                        <td colspan="3" class="text-end"><strong>Total Uang Keluar</strong></td>
                        <td class="text-end"><strong>Rp <?= number_format($total_uang_keluar, 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            <?php elseif (($periode ?? '') == 'bulan'): ?>
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah Transaksi</th>
                        <th>Total Pengeluaran (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataUangKeluar)): ?>
                        <?php 
                        $no = 1;
                        foreach ($dataUangKeluar as $row): 
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                <td class="text-center"><?= esc($row['jumlah_transaksi']) ?></td>
                                <td class="text-end"><?= number_format($row['total_pengeluaran'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-danger">
                            <td colspan="3" class="text-end"><strong>Total Uang Keluar</strong></td>
                            <td class="text-end"><strong>Rp <?= number_format($total_uang_keluar, 0, ',', '.') ?></strong></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data uang keluar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            <?php else: ?>
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Pengeluaran</th>
                        <th>Pemasok</th>
                        <th>Keterangan</th>
                        <th>Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataUangKeluar)): ?>
                        <?php $no = 1; foreach ($dataUangKeluar as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                <td><?= esc($row['jenis']) ?></td>
                                <td><?= esc($row['pemasok']) ?></td>
                                <td><?= esc($row['keterangan'] ?? '-') ?></td>
                                <td class="text-end"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-danger">
                            <td colspan="5" class="text-end"><strong>Total Uang Keluar</strong></td>
                            <td class="text-end"><strong>Rp <?= number_format($total_uang_keluar, 0, ',', '.') ?></strong></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data uang keluar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            <?php endif; ?>
        </table>
    </div>

    <!-- BAGIAN TANDA TANGAN -->
    <div class="mt-5" style="width: 40%; margin-left: auto; text-align: center;">
        <p>Padang, <?= date('d-m-Y') ?></p>
        <p><strong>Pimpinan</strong></p>
        <br><br><br>
        <p>(................................................)</p>
    </div>

</div>

<style>
    @media print {
        .print-btn, form, header, footer, .sidebar, .main-footer, .main-header { display: none !important; }
        .content-wrapper { margin: 0 !important; padding: 0 !important; }
        table { font-size: 13px; page-break-inside: auto; color: black !important; }
        .table-bordered th, .table-bordered td { border: 1px solid black !important; }
        .table thead th, .bg-dark { background-color: transparent !important; color: black !important; }
        tr { page-break-inside: avoid; }
    }
    th, td { vertical-align: middle !important; }
    .filter-bar { border: 1px solid #dee2e6; }
    .text-end { text-align: right !important; }
    .filter-bar .form-control-sm, .filter-bar select {
        height: 35px !important; padding: 4px 8px !important; font-size: 13px !important;
        width: 100% !important; display: block !important;
    }
    .filter-bar label { margin-bottom: 4px; font-size: 13px; font-weight: 600; color: #555; }
    .filter-bar .btn { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; }
    .filter-bar .btn i { font-size: 14px; }
</style>

<?= $this->endSection() ?>
