<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Mpembayaran;
use App\Models\Mpenjualansparepart;

class Laporanuangmasuk extends BaseController
{
    protected $pembayaranModel;
    protected $penjualanModel;

    public function __construct()
    {
        $this->pembayaranModel = new Mpembayaran();
        $this->penjualanModel = new Mpenjualansparepart();
    }

    public function index()
    {
        $dataUangMasuk = $this->getDataUangMasuk();
        
        $data = [
            'title' => 'Laporan Uang Masuk',
            'username' => session()->get('nama'),
            'dataUangMasuk' => $dataUangMasuk,
            'total_uang_masuk' => array_sum(array_column($dataUangMasuk, 'jumlah')),
            'tanggal_mulai' => '',
            'tanggal_akhir' => '',
            'sumber_terpilih' => '',
            'periode' => '',
            'bulan' => date('m'),
            'tahun' => date('Y')
        ];

        return view('LaporanKeuangan/laporanuangmasuk', $data);
    }

    public function filter()
    {
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $sumber = $this->request->getGet('sumber');
        $periode = $this->request->getGet('periode');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $dataUangMasuk = $this->getDataUangMasuk($tanggal_mulai, $tanggal_akhir, $sumber, $periode, $bulan, $tahun);

        $total_uang_masuk = 0;
        if ($periode == 'tahun' || $periode == 'bulan') {
             $total_uang_masuk = array_sum(array_column($dataUangMasuk, 'total_pemasukan'));
        } else {
             $total_uang_masuk = array_sum(array_column($dataUangMasuk, 'jumlah'));
        }

        $data = [
            'title' => 'Laporan Uang Masuk',
            'username' => session()->get('nama'),
            'dataUangMasuk' => $dataUangMasuk,
            'total_uang_masuk' => $total_uang_masuk,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'sumber_terpilih' => $sumber,
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        return view('LaporanKeuangan/laporanuangmasuk', $data);
    }

    private function getDataUangMasuk($tanggal_mulai = null, $tanggal_akhir = null, $sumber = null, $periode = null, $bulan = null, $tahun = null)
    {
        $dataUangMasuk = [];

        // Data dari pembayaran servis
        if (empty($sumber) || $sumber == 'pembayaran') {
            $pembayaranBuilder = $this->pembayaranModel
                ->select('pembayaran.*, transaksi_servis.id_transaksi, pelanggan.nama_pelanggan, pemesanan.kode_pemesanan')
                ->join('transaksi_servis', 'transaksi_servis.id_transaksi = pembayaran.id_transaksi')
                ->join('pemesanan','pemesanan.id_pemesanan = transaksi_servis.id_pemesanan')
                ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan');

            if ($periode == 'hari') {
                if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                    $pembayaranBuilder->where('pembayaran.tanggal_diambil >=', $tanggal_mulai)
                                      ->where('pembayaran.tanggal_diambil <=', $tanggal_akhir);
                } elseif (!empty($tanggal_mulai)) {
                    $pembayaranBuilder->where('pembayaran.tanggal_diambil >=', $tanggal_mulai);
                } elseif (!empty($tanggal_akhir)) {
                    $pembayaranBuilder->where('pembayaran.tanggal_diambil <=', $tanggal_akhir);
                }
            } elseif ($periode == 'bulan') {
                if (!empty($bulan)) {
                    $pembayaranBuilder->where('MONTH(pembayaran.tanggal_diambil)', (int)$bulan);
                }
                if (!empty($tahun)) {
                    $pembayaranBuilder->where('YEAR(pembayaran.tanggal_diambil)', (int)$tahun);
                }
            } elseif ($periode == 'tahun') {
                if (!empty($tahun)) {
                    $pembayaranBuilder->where('YEAR(pembayaran.tanggal_diambil)', (int)$tahun);
                }
            }

            $pembayaranData = $pembayaranBuilder->findAll();

            foreach ($pembayaranData as $row) {
                $dataUangMasuk[] = [
                    'tanggal' => $row['tanggal_diambil'],
                    'sumber' => 'Pembayaran Servis',
                    'keterangan' => 'Pembayaran dari ' . $row['nama_pelanggan'] . ' (' . $row['kode_pemesanan'].')',
                    'jumlah' => $row['total_bayar']
                ];
            }
        }

        // Data dari penjualan sparepart
        if (empty($sumber) || $sumber == 'penjualan') {
            $penjualanBuilder = $this->penjualanModel
                ->select('penjualan.*, pelanggan.nama_pelanggan, (SELECT SUM(jumlah_jual * harga_jual) FROM detail_penjualan WHERE detail_penjualan.id_penjualan = penjualan.id_penjualan) as total_pemasukan')
                ->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left');

            if ($periode == 'hari') {
                if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                    $penjualanBuilder->where('penjualan.tanggal_penjualan >=', $tanggal_mulai)
                                     ->where('penjualan.tanggal_penjualan <=', $tanggal_akhir);
                } elseif (!empty($tanggal_mulai)) {
                    $penjualanBuilder->where('penjualan.tanggal_penjualan >=', $tanggal_mulai);
                } elseif (!empty($tanggal_akhir)) {
                    $penjualanBuilder->where('penjualan.tanggal_penjualan <=', $tanggal_akhir);
                }
            } elseif ($periode == 'bulan') {
                if (!empty($bulan)) {
                    $penjualanBuilder->where('MONTH(penjualan.tanggal_penjualan)', (int)$bulan);
                }
                if (!empty($tahun)) {
                    $penjualanBuilder->where('YEAR(penjualan.tanggal_penjualan)', (int)$tahun);
                }
            } elseif ($periode == 'tahun') {
                if (!empty($tahun)) {
                    $penjualanBuilder->where('YEAR(penjualan.tanggal_penjualan)', (int)$tahun);
                }
            }

            $penjualanData = $penjualanBuilder->findAll();

            foreach ($penjualanData as $row) {
                $namaPelanggan = $row['nama_pelanggan'] ?? 'Umum';
                $dataUangMasuk[] = [
                    'tanggal' => date('Y-m-d', strtotime($row['tanggal_penjualan'])),
                    'sumber' => 'Penjualan Sparepart',
                    'keterangan' => 'Penjualan ke ' . $namaPelanggan . ' (' . ($row['kode_penjualan'] ?? 'PNJ-' . $row['id_penjualan']) . ')',
                    'jumlah' => $row['total_pemasukan'] ?? 0
                ];
            }
        }

        // Aggregate if periode == 'tahun' or 'bulan'
        if ($periode == 'tahun') {
            $aggregated = [];
            foreach ($dataUangMasuk as $item) {
                $b = (int)date('m', strtotime($item['tanggal']));
                if (!isset($aggregated[$b])) {
                    $aggregated[$b] = ['bulan' => $b, 'jumlah_transaksi' => 0, 'total_pemasukan' => 0];
                }
                $aggregated[$b]['jumlah_transaksi']++;
                $aggregated[$b]['total_pemasukan'] += $item['jumlah'];
            }
            return array_values($aggregated);
        } elseif ($periode == 'bulan') {
            $aggregated = [];
            foreach ($dataUangMasuk as $item) {
                $t = date('Y-m-d', strtotime($item['tanggal']));
                if (!isset($aggregated[$t])) {
                    $aggregated[$t] = ['tanggal' => $t, 'jumlah_transaksi' => 0, 'total_pemasukan' => 0];
                }
                $aggregated[$t]['jumlah_transaksi']++;
                $aggregated[$t]['total_pemasukan'] += $item['jumlah'];
            }
            usort($aggregated, function($a, $b) {
                return strtotime($b['tanggal']) - strtotime($a['tanggal']);
            });
            return array_values($aggregated);
        } else {
            // Sort by tanggal descending
            usort($dataUangMasuk, function($a, $b) {
                return strtotime($b['tanggal']) - strtotime($a['tanggal']);
            });
            return $dataUangMasuk;
        }
    }
}
