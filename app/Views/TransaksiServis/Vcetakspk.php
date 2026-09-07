<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak SPK - <?= esc($transaksi['id_transaksi']) ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
        }
        .kop-surat {
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .tabel-spk {
            table-layout: fixed;
            width: 100%;
        }
        .tabel-spk th, .tabel-spk td {
            padding: 5px;
            border: 1px solid #000;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .tabel-spk th {
            background-color: #f2f2f2 !important;
            text-align: center;
        }
        .tanda-tangan {
            margin-top: 50px;
            text-align: center;
        }
        .tanda-tangan p {
            margin-bottom: 70px;
        }
        @media print {
            .btn-print {
                display: none;
            }
            @page {
                size: A4 portrait;
                margin: 20mm;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container-fluid mt-4" style="max-width: 210mm; margin: 0 auto;">
        <button class="btn btn-primary btn-print mb-3" onclick="window.print()">Cetak Ulang</button>
        
        <div class="kop-surat text-center">
            <h2 class="mb-1"><strong>SURAT PERINTAH KERJA (SPK)</strong></h2>
            <p class="mb-0">UTAMA SERVICE STATION</p>
            <p class="mb-0">No. Transaksi: <?= esc($transaksi['id_transaksi']) ?> | Tanggal: <?= date('d-m-Y', strtotime($transaksi['tanggal_servis'])) ?></p>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="30%"><strong>Pelanggan</strong></td>
                        <td width="5%">:</td>
                        <td><?= esc($transaksi['nama_pelanggan']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>No. HP</strong></td>
                        <td>:</td>
                        <td><?= esc($transaksi['no_hp'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Keluhan</strong></td>
                        <td>:</td>
                        <td><?= esc($transaksi['keluhan'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="30%"><strong>No. Polisi</strong></td>
                        <td width="5%">:</td>
                        <td><?= esc($transaksi['no_polisi'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tipe / Warna</strong></td>
                        <td>:</td>
                        <td><?= esc($transaksi['tipe'] ?? '-') ?> / <?= esc($transaksi['warna_mobil'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Mekanik</strong></td>
                        <td>:</td>
                        <td><?= esc($transaksi['nama_mekanik'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <h5 class="mb-2"><strong>Daftar Pekerjaan (Jasa)</strong></h5>
        <table class="table tabel-spk w-100 mb-4">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Pekerjaan / Servis</th>
                    <th width="20%">Status (Centang)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($servis)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($servis as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($row['nama_servis']) ?></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data jasa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h5 class="mb-2"><strong>Daftar Sparepart yang Dibutuhkan</strong></h5>
        <table class="table tabel-spk w-100 mb-4">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Sparepart</th>
                    <th width="15%">Jumlah</th>
                    <th width="20%">Status Pasang (Centang)</th>
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
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada sparepart tambahan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="row tanda-tangan mt-5">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p><strong>Mekanik</strong></p>
                <br>
                <p>( <?= esc($transaksi['nama_mekanik'] ?? '........................') ?> )</p>
            </div>
        </div>
    </div>
</body>
</html>
