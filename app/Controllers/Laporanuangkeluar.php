<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Mpembeliansparepart;
use App\Models\Mpemasok;
use App\Models\Muangkeluar;

class Laporanuangkeluar extends BaseController
{
    protected $pembelianModel;
    protected $pemasokModel;
    protected $uangKeluarModel;

    public function __construct()
    {
        $this->pembelianModel = new Mpembeliansparepart();
        $this->pemasokModel = new Mpemasok();
        $this->uangKeluarModel = new Muangkeluar();
    }

    public function index()
    {
        $dataUangKeluar = $this->getDataUangKeluar();
        
        $data = [
            'title' => 'Laporan Uang Keluar',
            'username' => session()->get('nama'),
            'dataUangKeluar' => $dataUangKeluar,
            'total_uang_keluar' => array_sum(array_column($dataUangKeluar, 'jumlah')),
            'tanggal_mulai' => '',
            'tanggal_akhir' => '',
            'sumber_terpilih' => '',
            'periode' => '',
            'bulan' => date('m'),
            'tahun' => date('Y')
        ];

        return view('LaporanKeuangan/laporanuangkeluar', $data);
    }

    public function filter()
    {
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $sumber = $this->request->getGet('sumber');
        $periode = $this->request->getGet('periode');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $dataUangKeluar = $this->getDataUangKeluar($tanggal_mulai, $tanggal_akhir, $sumber, $periode, $bulan, $tahun);

        $total_uang_keluar = 0;
        if ($periode == 'tahun' || $periode == 'bulan') {
             $total_uang_keluar = array_sum(array_column($dataUangKeluar, 'total_pengeluaran'));
        } else {
             $total_uang_keluar = array_sum(array_column($dataUangKeluar, 'jumlah'));
        }

        $data = [
            'title' => 'Laporan Uang Keluar',
            'username' => session()->get('nama'),
            'dataUangKeluar' => $dataUangKeluar,
            'total_uang_keluar' => $total_uang_keluar,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'sumber_terpilih' => $sumber,
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        return view('LaporanKeuangan/laporanuangkeluar', $data);
    }

    private function getDataUangKeluar($tanggal_mulai = null, $tanggal_akhir = null, $sumber = null, $periode = null, $bulan = null, $tahun = null)
    {
        // 1. Ambil data Pembelian Sparepart (jika sumber kosong atau 'pembelian')
        $dataPembelian = [];
        if (empty($sumber) || $sumber == 'pembelian') {
            $builderPembelian = $this->pembelianModel
                ->select('pembelian.*, pemasok.nama_pemasok, (SELECT SUM(jumlah_beli * harga_beli) FROM detail_pembelian WHERE detail_pembelian.id_pembelian = pembelian.id_pembelian) as total_pengeluaran')
                ->join('pemasok', 'pemasok.id_pemasok = pembelian.id_pemasok');

            if ($periode == 'hari') {
                if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                    $builderPembelian->where('pembelian.tanggal_pembelian >=', $tanggal_mulai)
                            ->where('pembelian.tanggal_pembelian <=', $tanggal_akhir);
                } elseif (!empty($tanggal_mulai)) {
                    $builderPembelian->where('pembelian.tanggal_pembelian >=', $tanggal_mulai);
                } elseif (!empty($tanggal_akhir)) {
                    $builderPembelian->where('pembelian.tanggal_pembelian <=', $tanggal_akhir);
                }
            } elseif ($periode == 'bulan') {
                if (!empty($bulan)) {
                    $builderPembelian->where('MONTH(pembelian.tanggal_pembelian)', (int)$bulan);
                }
                if (!empty($tahun)) {
                    $builderPembelian->where('YEAR(pembelian.tanggal_pembelian)', (int)$tahun);
                }
            } elseif ($periode == 'tahun') {
                if (!empty($tahun)) {
                    $builderPembelian->where('YEAR(pembelian.tanggal_pembelian)', (int)$tahun);
                }
            }

            $dataPembelian = $builderPembelian->findAll();
        }

        // 2. Ambil data Uang Keluar Lainnya (jika sumber kosong atau 'lainnya')
        $dataUangKeluarLain = [];
        if (empty($sumber) || $sumber == 'lainnya') {
            $builderUK = $this->uangKeluarModel->select('*');
            if ($periode == 'hari') {
                if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                    $builderUK->where('tanggal >=', $tanggal_mulai)
                              ->where('tanggal <=', $tanggal_akhir);
                } elseif (!empty($tanggal_mulai)) {
                    $builderUK->where('tanggal >=', $tanggal_mulai);
                } elseif (!empty($tanggal_akhir)) {
                    $builderUK->where('tanggal <=', $tanggal_akhir);
                }
            } elseif ($periode == 'bulan') {
                if (!empty($bulan)) {
                    $builderUK->where('MONTH(tanggal)', (int)$bulan);
                }
                if (!empty($tahun)) {
                    $builderUK->where('YEAR(tanggal)', (int)$tahun);
                }
            } elseif ($periode == 'tahun') {
                if (!empty($tahun)) {
                    $builderUK->where('YEAR(tanggal)', (int)$tahun);
                }
            }
            $dataUangKeluarLain = $builderUK->findAll();
        }

        // 3. Gabungkan dan format data
        $mergedData = [];
        
        foreach ($dataPembelian as $row) {
            $mergedData[] = [
                'id_ref' => 'PB-' . $row['id_pembelian'],
                'tanggal' => date('Y-m-d', strtotime($row['tanggal_pembelian'])),
                'jenis' => 'Pembelian Sparepart',
                'pemasok' => $row['nama_pemasok'],
                'keterangan' => (!empty($row['keterangan'])) ? $row['keterangan'] : '-',
                'jumlah' => $row['total_pengeluaran'] ?? 0
            ];
        }

        foreach ($dataUangKeluarLain as $row) {
            $mergedData[] = [
                'id_ref' => 'UK-' . $row['id_uang_keluar'],
                'tanggal' => date('Y-m-d', strtotime($row['tanggal'])),
                'jenis' => $row['jenis_pengeluaran'],
                'pemasok' => '-',
                'keterangan' => (!empty($row['keterangan'])) ? $row['keterangan'] : '-',
                'jumlah' => $row['jumlah']
            ];
        }

        // Aggregate if periode == 'tahun' or 'bulan'
        if ($periode == 'tahun') {
            $aggregated = [];
            foreach ($mergedData as $item) {
                $b = (int)date('m', strtotime($item['tanggal']));
                if (!isset($aggregated[$b])) {
                    $aggregated[$b] = ['bulan' => $b, 'jumlah_transaksi' => 0, 'total_pengeluaran' => 0];
                }
                $aggregated[$b]['jumlah_transaksi']++;
                $aggregated[$b]['total_pengeluaran'] += $item['jumlah'];
            }
            return array_values($aggregated);
        } elseif ($periode == 'bulan') {
            $aggregated = [];
            foreach ($mergedData as $item) {
                $t = $item['tanggal'];
                if (!isset($aggregated[$t])) {
                    $aggregated[$t] = ['tanggal' => $t, 'jumlah_transaksi' => 0, 'total_pengeluaran' => 0];
                }
                $aggregated[$t]['jumlah_transaksi']++;
                $aggregated[$t]['total_pengeluaran'] += $item['jumlah'];
            }
            usort($aggregated, function($a, $b) {
                return strtotime($b['tanggal']) - strtotime($a['tanggal']);
            });
            return array_values($aggregated);
        } else {
            // Sort by tanggal descending
            usort($mergedData, function($a, $b) {
                return strtotime($b['tanggal']) - strtotime($a['tanggal']);
            });
            return $mergedData;
        }
    }
}
