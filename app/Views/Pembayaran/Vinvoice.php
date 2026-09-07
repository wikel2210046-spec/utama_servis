<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice Servis - Utama Service Station</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 30px 50px;
        }

        h2,
        h4 {
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

        td,
        th {
            padding: 6px;
            vertical-align: top;
        }

        .border th,
        .border td {
            border: 1px solid #000;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .note {
            margin-top: 15px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
        <div style="flex: 1;">
            <img src="<?= base_url('assets/dist/img/logouss.png') ?>" alt="Logo" style="width: 50px; height: auto;">
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
            <th><strong>Tanggal Servis</strong></th>
            <td>: <?= date('d-m-Y', strtotime($transaksi['tanggal_servis'])) ?></td>
            <th>Pelanggan</th>
            <td>: <?= esc($transaksi['nama_pelanggan']) ?></td>
        </tr>
        <tr>
            <th>Kode Pemesanan</th>
            <td>: <?= esc($transaksi['kode_pemesanan']) ?></td>
            <th>Mekanik</th>
            <td>: <?= esc($transaksi['nama_mekanik']) ?></td>
        </tr>
        <tr>
            <th>Tipe</th>
            <td>: <?= esc($transaksi['tipe']) ?></td>
            <th>Tanggal Diambil</th>
            <td>: <?= esc($transaksi['tanggal_diambil']) ?></td>
        </tr>
        <tr>
            <th>No Polisi</th>
            <td>: <?= esc($transaksi['no_polisi']) ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <table class="border" style="margin-top:20px;">
        <thead>
            <tr class="center bold">
                <th>No</th>
                <th>Jasa / Sparepart</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $spareparts = [];
            $services = [];
            $total = 0;
            $no = 1;

            // pisahkan data berdasarkan jenis
            foreach ($detail as $row) {
                if (!empty($row['nama_sparepart'])) {
                    $spareparts[] = $row;
                }
                if (!empty($row['nama_servis'])) {
                    $services[] = $row;
                }
            }

            // tampilkan sparepart lebih dulu
            foreach ($spareparts as $sp): ?>
                <tr>
                    <td class="center"><?= $no++ ?></td>
                    <td><?= esc($sp['nama_sparepart']) ?></td>
                    <td class="center"><?= esc($sp['jumlah']) ?></td>
                    <td class="right">Rp <?= number_format($sp['harga_jual'], 0, ',', '.') ?></td>
                    <td class="right">Rp <?= number_format($sp['subtotal'], 0, ',', '.') ?></td>
                </tr>
                <?php $total += $sp['subtotal']; ?>
            <?php endforeach; ?>

            <!-- tampilkan jasa servis setelah sparepart -->
            <?php foreach ($services as $sv): ?>
                <tr>
                    <td class="center"><?= $no++ ?></td>
                    <td>Jasa / <?= esc($sv['nama_servis']) ?></td>
                    <td class="center">1</td>
                    <td class="right">Rp <?= number_format($sv['harga_servis'], 0, ',', '.') ?></td>
                    <td class="right">Rp <?= number_format($sv['harga_servis'], 0, ',', '.') ?></td>
                </tr>
                <?php $total += $sv['harga_servis']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="right bold">Diskon</td>
                <td class="right">Rp <?= number_format($transaksi['diskon'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="4" class="right bold">TOTAL</td>
                <td class="right bold">
                    Rp <?= number_format(($total - ($transaksi['diskon'] ?? 0)), 0, ',', '.') ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="note">
        <p><strong>Catatan :</strong></p>
        <ul>
            <li>Harap periksa kembali barang & kendaraan Anda sebelum meninggalkan bengkel.</li>
            <li>Bengkel tidak bertanggung jawab atas kerusakan/kehilangan setelah kendaraan keluar.</li>
            <li>Terima kasih atas kepercayaan Anda kepada <strong>Utama Service Station</strong>!</li>
        </ul>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>