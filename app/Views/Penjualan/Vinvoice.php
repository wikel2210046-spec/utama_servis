<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Penjualan - Utama Service Station</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 30px 50px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
            padding: 0;
        }
        hr {
            border: 1px solid #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 6px;
            vertical-align: top;
        }
        .border th, .border td {
            border: 1px solid #000;
        }
        .right { text-align: right; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .note {
            margin-top: 15px;
            font-size: 12px;
        }
    </style>
</head>
<body>
   <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
    <div style="flex: 1;">
        <img src="<?= base_url('assets/dist/img/logouss.png') ?>" 
             alt="Logo" 
             style="width: 50px; height: auto;">
    </div>
    <div style="flex: 3; text-align: center;">
        <h2 style="margin: 0;">UTAMA SERVICE STATION</h2>
        <h4 style="margin: 0;">Jl. Letjend S. Parman No.156 Padang<br>
            Telp: (0751) 7054654 / 7052123</h4>
    </div>
    <div style="flex: 1;"></div>
</div>
<hr>
<table>
    <tr>
        <th width="20%" class="left">Kode Penjualan</th>
        <td width="30%">: <?= esc($penjualan['kode_penjualan']) ?></td>
        <th width="20%" class="left">Pelanggan</th>
        <td>: <?= esc($penjualan['nama_pelanggan']) ?></td>
    </tr>
    <tr>
        <th class="left">Tanggal</th>
        <td>: <?= date('d-m-Y', strtotime($penjualan['tanggal_penjualan'])) ?></td>
        <th class="left">No HP</th>
        <td>: <?= esc($penjualan['no_hp'] ?? '-') ?></td>
    </tr>
</table>

    <table class="border" style="margin-top:20px;">
        <thead>
            <tr class="center bold">
                <th width="5%">No</th>
                <th>Nama Sparepart</th>
                <th width="10%">Qty</th>
                <th width="20%">Harga (Rp)</th>
                <th width="20%">Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total = 0;
            ?>
            <?php foreach ($detail as $row) : ?>
                <tr>
                    <td class="center"><?= $no++ ?></td>
                    <td><?= esc($row['nama_sparepart']) ?></td>
                    <td class="center"><?= esc($row['jumlah_jual']) ?></td>
                    <td class="right"><?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                    <td class="right"><?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                </tr>
                <?php $total += $row['subtotal']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="right bold">TOTAL AKHIR</td>
                <td class="right bold">
                    Rp <?= number_format($total, 0, ',', '.') ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="note">
        <p><strong>Catatan :</strong></p>
        <ul>
            <li>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan, kecuali ada perjanjian khusus.</li>
            <li>Terima kasih atas kunjungan Anda di <strong>Utama Service Station</strong>!</li>
        </ul>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
