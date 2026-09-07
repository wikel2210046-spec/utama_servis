<?php

namespace App\Controllers;

use App\Models\Mpenjualansparepart;
use App\Models\Mpelanggan;
use App\Models\Msparepart;
use App\Models\Mdetailpenjualan;
use CodeIgniter\Controller;

class Penjualansparepart extends Controller
{
    protected $penjualanModel;
    protected $pelangganModel;
    protected $sparepartModel;
    protected $detailModel;
    protected $db;

    public function __construct()
    {
        $this->penjualanModel = new Mpenjualansparepart();
        $this->pelangganModel = new Mpelanggan();
        $this->sparepartModel = new Msparepart();
        $this->detailModel = new Mdetailpenjualan();
        $this->db = \Config\Database::connect();
        helper(['form', 'url']);
    }

    public function index()
    {
        $tombolCari = $this->request->getPost('tombolcari');
        $keyword = '';

        if (isset($tombolCari)) {
            $keyword = $this->request->getPost('caripenjualan');
            session()->set('caripenjualan', $keyword);
            return redirect()->to('/Penjualansparepart');
        } else {
            $keyword = session()->get('caripenjualan');
        }

        $builder = $this->penjualanModel
            ->select('
                penjualan.id_penjualan,
                penjualan.kode_penjualan,
                penjualan.tanggal_penjualan,
                pelanggan.nama_pelanggan,
                (SELECT SUM(jumlah_jual * harga_jual) FROM detail_penjualan WHERE detail_penjualan.id_penjualan = penjualan.id_penjualan) as total_penjualan
            ')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left')
            ->orderBy('penjualan.id_penjualan', 'DESC');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('pelanggan.nama_pelanggan', $keyword)
                ->orLike('penjualan.kode_penjualan', $keyword)
                ->groupEnd();
        }

        $noHalaman = $this->request->getVar('page_penjualan') ? $this->request->getVar('page_penjualan') : 1;

        $data = [
            'title' => 'Data Penjualan Sparepart',
            'dataPenjualan' => $builder->paginate(10, 'penjualan'),
            'pager' => $this->penjualanModel->pager,
            'keyword' => $keyword,
            'noHalaman' => $noHalaman
        ];

        return view('Penjualan/vpenjualan', $data);
    }

    public function formtambah()
    {
        // Generate kode penjualan otomatis: PJN-YYYYMMDD-XXXX
        $tgl = date('Ymd');
        $query = $this->db->table('penjualan')
            ->select('RIGHT(kode_penjualan, 4) as kode', false)
            ->like('kode_penjualan', 'PJN-' . $tgl)
            ->orderBy('id_penjualan', 'DESC')
            ->limit(1)
            ->get();
        if ($query->getRowArray()) {
            $row = $query->getRow();
            $n = ((int) $row->kode) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "0001";
        }
        $kode_penjualan = "PJN-" . $tgl . "-" . $no;

        $data = [
            'pelanggan' => $this->pelangganModel->findAll(),
            'sparepart' => $this->sparepartModel->where('stok >', 0)->findAll(),
            'kode_penjualan' => $kode_penjualan
        ];

        $response = [
            'data' => view('Penjualan/vtambahpenjualan', $data)
        ];
        return $this->response->setJSON($response);
    }

    public function simpan()
    {
        $this->db->transStart();

        $dataPenjualan = [
            'kode_penjualan' => $this->request->getPost('kode_penjualan'),
            'tanggal_penjualan' => $this->request->getPost('tanggal_penjualan'),
            'id_pelanggan' => $this->request->getPost('id_pelanggan'),
            'diskon' => $this->request->getPost('diskon') ?? 0,
        ];

        if (empty($dataPenjualan['tanggal_penjualan']) || empty($dataPenjualan['id_pelanggan'])) {
            return $this->response->setJSON(['error' => '❌ Semua field wajib diisi.']);
        }

        $this->penjualanModel->insert($dataPenjualan);
        $id_penjualan = $this->penjualanModel->getInsertID();

        $id_sparepart = $this->request->getPost('id_sparepart');
        $jumlah_jual = $this->request->getPost('jumlah_jual');
        $harga_jual = $this->request->getPost('harga_jual');

        foreach ($id_sparepart as $i => $id) {
            $this->db->table('detail_penjualan')->insert([
                'id_penjualan' => $id_penjualan,
                'id_sparepart' => $id,
                'jumlah_jual' => $jumlah_jual[$i],
                'harga_jual' => $harga_jual[$i]
            ]);

            // 🔹 Update stok (berkurang)
            $this->db->table('sparepart')
                ->where('id_sparepart', $id)
                ->set('stok', 'stok - ' . (int) $jumlah_jual[$i], false)
                ->update();
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            $response = ['error' => '❌ Gagal menyimpan data penjualan.'];
        } else {
            $response = ['sukses' => '✅ Data penjualan berhasil disimpan, stok diperbarui.'];
        }

        return $this->response->setJSON($response);
    }

    public function detail($id_penjualan = null)
    {
        if (!$id_penjualan) {
            return redirect()->to(base_url('penjualansparepart'))->with('error', 'ID penjualan tidak ditemukan.');
        }

        $penjualan = $this->penjualanModel->getDetailPenjualan($id_penjualan);
        $detail = $this->penjualanModel->getDetailItems($id_penjualan);

        if (!$penjualan) {
            return redirect()->to(base_url('penjualansparepart'))->with('error', 'Data penjualan tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Penjualan Sparepart',
            'penjualan' => $penjualan,
            'detail' => $detail,
        ];

        return view('Penjualan/vdetailpenjualan', $data);
    }

    public function invoice($id_penjualan = null)
    {
        if (!$id_penjualan) {
            return redirect()->to(base_url('penjualansparepart'))->with('error', 'ID penjualan tidak ditemukan.');
        }

        $penjualan = $this->penjualanModel->getDetailPenjualan($id_penjualan);
        $detail = $this->penjualanModel->getDetailItems($id_penjualan);

        if (!$penjualan) {
            return redirect()->to(base_url('penjualansparepart'))->with('error', 'Data penjualan tidak ditemukan.');
        }

        $data = [
            'title' => 'Invoice Penjualan Sparepart',
            'penjualan' => $penjualan,
            'detail' => $detail,
        ];

        return view('Penjualan/Vinvoice', $data);
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_penjualan');

            if (!$id) {
                return $this->response->setJSON(['error' => 'ID penjualan tidak ditemukan.']);
            }

            try {
                $this->db->transStart();

                // 1. Ambil detail untuk mengembalikan stok
                $items = $this->db->table('detail_penjualan')->where('id_penjualan', $id)->get()->getResultArray();
                foreach ($items as $item) {
                    if (!empty($item['id_sparepart'])) {
                        $this->db->table('sparepart')
                            ->where('id_sparepart', $item['id_sparepart'])
                            ->set('stok', 'stok + ' . (int) $item['jumlah_jual'], false)
                            ->update();
                    }
                }

                // 2. Hapus detail
                $this->db->table('detail_penjualan')->where('id_penjualan', $id)->delete();

                // 3. Hapus data utama penjualan
                $this->penjualanModel->delete($id);

                $this->db->transComplete();

                if ($this->db->transStatus() === false) {
                    return $this->response->setJSON(['error' => 'Gagal menghapus data di database.']);
                }

                return $this->response->setJSON(['sukses' => 'Data penjualan berhasil dihapus dan stok telah dikembalikan.']);

            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        }
    }


    public function laporan()
    {
        $dataPenjualan = $this->penjualanModel->getLaporanPenjualanLengkap();
        $total_keseluruhan = 0;

        if (!empty($dataPenjualan)) {
            foreach ($dataPenjualan as $row) {
                $total_keseluruhan += $row['subtotal'];
            }
        }

        $pelanggan = $this->pelangganModel->findAll();

        $data = [
            'title' => 'Laporan Penjualan Sparepart',
            'username' => session()->get('nama'),
            'dataPenjualan' => $dataPenjualan ?? [],
            'total_keseluruhan' => $total_keseluruhan,
            'pelanggan' => $pelanggan,
            'tanggal_mulai' => '',
            'tanggal_akhir' => '',
            'pelanggan_terpilih' => '',
            'periode' => '',
            'bulan' => date('m'),
            'tahun' => date('Y'),
        ];

        return view('Penjualan/laporan_penjualan', $data);
    }

    public function filterPenjualan()
    {
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $pelanggan_terpilih = $this->request->getGet('pelanggan');
        $periode = $this->request->getGet('periode');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $this->penjualanModel->join('detail_penjualan', 'detail_penjualan.id_penjualan = penjualan.id_penjualan')
            ->join('sparepart', 'sparepart.id_sparepart = detail_penjualan.id_sparepart')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left');

        if ($periode == 'tahun') {
            $builder->select('MONTH(penjualan.tanggal_penjualan) as bulan, SUM(detail_penjualan.harga_jual * detail_penjualan.jumlah_jual) as subtotal');
            $builder->groupBy('MONTH(penjualan.tanggal_penjualan)');
        } elseif ($periode == 'bulan') {
            $builder->select('DATE(penjualan.tanggal_penjualan) as tanggal, COUNT(DISTINCT penjualan.id_penjualan) as jumlah_transaksi, SUM(detail_penjualan.jumlah_jual) as total_barang, SUM(detail_penjualan.harga_jual * detail_penjualan.jumlah_jual) as subtotal');
            $builder->groupBy('DATE(penjualan.tanggal_penjualan)');
        } else {
            $builder->select('penjualan.*, pelanggan.nama_pelanggan, sparepart.nama_sparepart, detail_penjualan.harga_jual, detail_penjualan.jumlah_jual, (detail_penjualan.harga_jual * detail_penjualan.jumlah_jual) as subtotal');
        }

        if (!empty($pelanggan_terpilih)) {
            $builder->where('penjualan.id_pelanggan', $pelanggan_terpilih);
        }

        if ($periode == 'hari') {
            if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                $builder->where('penjualan.tanggal_penjualan >=', $tanggal_mulai);
                $builder->where('penjualan.tanggal_penjualan <=', $tanggal_akhir);
            } elseif (!empty($tanggal_mulai)) {
                $builder->where('penjualan.tanggal_penjualan >=', $tanggal_mulai);
            } elseif (!empty($tanggal_akhir)) {
                $builder->where('penjualan.tanggal_penjualan <=', $tanggal_akhir);
            }
        } elseif ($periode == 'bulan') {
            if (!empty($bulan)) {
                $builder->where('MONTH(penjualan.tanggal_penjualan)', (int)$bulan);
            }
            if (!empty($tahun)) {
                $builder->where('YEAR(penjualan.tanggal_penjualan)', (int)$tahun);
            }
        } elseif ($periode == 'tahun') {
            if (!empty($tahun)) {
                $builder->where('YEAR(penjualan.tanggal_penjualan)', (int)$tahun);
            }
        }

        $dataPenjualan = $builder->get()->getResultArray();
        $total_keseluruhan = array_sum(array_column($dataPenjualan, 'subtotal'));

        $data = [
            'title' => 'Laporan Penjualan Sparepart',
            'username' => session()->get('nama'),
            'dataPenjualan' => $dataPenjualan,
            'total_keseluruhan' => $total_keseluruhan,
            'pelanggan' => $this->pelangganModel->findAll(),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'pelanggan_terpilih' => $pelanggan_terpilih,
            'periode' => $periode,
        ];

        return view('Penjualan/laporan_penjualan', $data);
    }
}
