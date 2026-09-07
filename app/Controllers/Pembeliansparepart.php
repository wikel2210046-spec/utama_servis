<?php

namespace App\Controllers;

use App\Models\Mpembeliansparepart;
use App\Models\Mpemasok;
use App\Models\Msparepart;
use App\Models\Mdetailpembelian;
use CodeIgniter\Controller;

class Pembeliansparepart extends Controller
{
    protected $pembelianModel;
    protected $pemasokModel;
    protected $sparepartModel;
    protected $detailModel;
    protected $db;

    public function __construct()
    {
        $this->pembelianModel = new Mpembeliansparepart();
        $this->pemasokModel = new Mpemasok();
        $this->sparepartModel = new Msparepart();
        $this->detailModel = new Mdetailpembelian();
        $this->db = \Config\Database::connect();
        helper(['form', 'url']);
    }
    public function index()
    {
        $tombolCari = $this->request->getPost('tombolcari');
        $keyword = '';

        // Tangani pencarian
        if (isset($tombolCari)) {
            $keyword = $this->request->getPost('caripembelian');
            session()->set('caripembelian', $keyword);
            return redirect()->to('/Pembeliansparepart');
        } else {
            $keyword = session()->get('caripembelian');
        }

        // Ambil data pembelian dengan join ke tabel lain
        $builder = $this->pembelianModel
            ->select('
            pembelian.id_pembelian,
            pembelian.kode_pembelian,
            pembelian.tanggal_pembelian,
            pemasok.nama_pemasok,
            (SELECT SUM(jumlah_beli * harga_beli) FROM detail_pembelian WHERE detail_pembelian.id_pembelian = pembelian.id_pembelian) as total_pembelian
        ')
            ->join('pemasok', 'pemasok.id_pemasok = pembelian.id_pemasok', 'left')
            ->orderBy('pembelian.id_pembelian', 'DESC');

        // Filter berdasarkan keyword (nama pemasok, tanggal)
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('pemasok.nama_pemasok', $keyword)
                ->orLike('pembelian.tanggal_pembelian', $keyword)
                ->groupEnd();
        }

        // Pagination
        $noHalaman = $this->request->getVar('page_pembelian') ? $this->request->getVar('page_pembelian') : 1;

        $data = [
            'title' => 'Data Pembelian Sparepart',
            'dataPembelian' => $builder->paginate(10, 'pembelian'),
            'pager' => $this->pembelianModel->pager,
            'keyword' => $keyword,
            'noHalaman' => $noHalaman
        ];

        return view('Pembelian/vpembelian', $data);
    }

    public function formtambah()
    {
        $data = [
            'pemasok' => $this->pemasokModel->findAll(),
            'sparepart' => $this->sparepartModel->findAll(),
        ];

        $response = [
            'data' => view('Pembelian/vtambahpembelian', $data)
        ];
        return $this->response->setJSON($response);
    }
    public function simpan()
    {
        $db = \Config\Database::connect();
        $db->transStart(); // Mulai transaksi database

        // Simpan data utama pembelian
        $dataPembelian = [
            'kode_pembelian' => $this->request->getPost('kode_pembelian'),
            'tanggal_pembelian' => $this->request->getPost('tanggal_pembelian'),
            'id_pemasok' => $this->request->getPost('id_pemasok'),
        ];
        if (empty($dataPembelian['kode_pembelian']) || empty($dataPembelian['tanggal_pembelian']) || empty($dataPembelian['id_pemasok'])) {
            return $this->response->setJSON(['error' => '❌ Semua field wajib diisi.']);
        }

        $this->pembelianModel->insert($dataPembelian);
        $id_pembelian = $this->pembelianModel->getInsertID();

        // Ambil array detail dari form
        $id_sparepart = $this->request->getPost('id_sparepart');
        $jumlah_beli = $this->request->getPost('jumlah_beli');
        $harga_beli = $this->request->getPost('harga_beli');

        // Loop setiap item pembelian
        foreach ($id_sparepart as $i => $id) {
            // Simpan ke tabel detail_pembelian
            $db->table('detail_pembelian')->insert([
                'id_pembelian' => $id_pembelian,
                'id_sparepart' => $id,
                'jumlah_beli' => $jumlah_beli[$i],
                'harga_beli' => $harga_beli[$i]
            ]);

            // 🔹 Update stok (bertambah)
            $db->table('sparepart')
                ->where('id_sparepart', $id)
                ->set('stok', 'stok + ' . (int) $jumlah_beli[$i], false)
                ->update();

            // 🔹 Update harga beli sparepart ke harga terbaru
            $db->table('sparepart')
                ->where('id_sparepart', $id)
                ->set('harga_beli', $harga_beli[$i])
                ->update();

            $margin = 0.2; // 20%
            $harga_jual_baru = $harga_beli[$i] + ($harga_beli[$i] * $margin);
            $db->table('sparepart')
                ->where('id_sparepart', $id)
                ->set('harga_jual', $harga_jual_baru)
                ->update();

        }

        $db->transComplete(); // Selesaikan transaksi

        // Cek status transaksi
        if ($db->transStatus() === false) {
            $response = ['error' => '❌ Gagal menyimpan data pembelian.'];
        } else {
            $response = ['sukses' => '✅ Data pembelian berhasil disimpan, stok & harga diperbarui.'];
        }

        return $this->response->setJSON($response);
    }

    public function detail($id_pembelian = null)
    {
        if (!$id_pembelian) {
            return redirect()->to(base_url('pembeliansparepart'))->with('error', 'ID pembelian tidak ditemukan.');
        }

        $pembelian = $this->pembelianModel->getDetailPembelian($id_pembelian);
        $detail = $this->pembelianModel->getDetailItems($id_pembelian);
        $total = $this->pembelianModel->hitungTotal($id_pembelian);

        if (!$pembelian) {
            return redirect()->to(base_url('pembeliansparepart'))->with('error', 'Data pembelian tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Pembelian Sparepart',
            'pembelian' => $pembelian,
            'detail' => $detail,
            'total' => $total,
        ];

        return view('Pembelian/vdetailpembelian', $data);
    }

    public function hapus()
    {
        $id = $this->request->getPost('id_pembelian');

        if (!$id) {
            return $this->response->setJSON(['error' => 'ID pembelian tidak ditemukan.']);
        }

        // 🔧 Hapus dulu data detail agar tidak melanggar foreign key constraint
        $this->detailModel->where('id_pembelian', $id)->delete();

        // 🔧 Hapus data pembelian utama
        $hapus = $this->pembelianModel->delete($id);

        if ($hapus) {
            return $this->response->setJSON(['sukses' => 'Data pembelian berhasil dihapus.']);
        } else {
            return $this->response->setJSON(['error' => 'Gagal menghapus data pembelian.']);
        }
    }
    public function laporan()
    {
        $session = session();
        $username = $session->get('username') ?? 'Admin';

        try {
            // ambil semua data pembelian dengan join detail dan sparepart
            $dataPembelian = $this->pembelianModel->getLaporanPembelianLengkap();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data pembelian: ' . $e->getMessage());
        }

        // hitung total per pembelian dan keseluruhan
        $total_pembelian = 0;
        $total_keseluruhan = 0;

        if (!empty($dataPembelian)) {
            // total keseluruhan dari semua subtotal
            foreach ($dataPembelian as $row) {
                $total_keseluruhan += $row['subtotal'];
            }
        }

        // ambil daftar pemasok untuk filter dropdown
        $pemasokModel = new \App\Models\Mpemasok();
        $pemasok = $pemasokModel->findAll();

        $data = [
            'title' => 'Laporan Pembelian Sparepart',
            'username' => session()->get('nama') ?? $username,
            'dataPembelian' => $dataPembelian ?? [],
            'total_keseluruhan' => $total_keseluruhan,
            'pemasok' => $pemasok,
            'tanggal_mulai' => '',
            'tanggal_akhir' => '',
            'pemasok_terpilih' => '',
            'periode' => '',
            'bulan' => date('m'),
            'tahun' => date('Y'),
        ];

        return view('Pembelian/laporan_pembelian', $data);
    }
    public function filterPembelian()
    {
        $session = session();
        $username = $session->get('username') ?? 'Admin';

        // Ambil input dari form GET
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $pemasok_terpilih = $this->request->getGet('pemasok');
        $periode = $this->request->getGet('periode');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        // Model
        $pemasokModel = new \App\Models\Mpemasok();
        $pembelianModel = $this->pembelianModel;
        $pemasok = $pemasokModel->findAll();

        // Mulai query
        $builder = $pembelianModel->join('detail_pembelian', 'detail_pembelian.id_pembelian = pembelian.id_pembelian')
            ->join('sparepart', 'sparepart.id_sparepart = detail_pembelian.id_sparepart')
            ->join('pemasok', 'pemasok.id_pemasok = pembelian.id_pemasok', 'left');

        if ($periode == 'tahun') {
            $builder->select('MONTH(pembelian.tanggal_pembelian) as bulan, SUM(detail_pembelian.harga_beli * detail_pembelian.jumlah_beli) as subtotal');
            $builder->groupBy('MONTH(pembelian.tanggal_pembelian)');
        } elseif ($periode == 'bulan') {
            $builder->select('DATE(pembelian.tanggal_pembelian) as tanggal, COUNT(DISTINCT pembelian.id_pembelian) as jumlah_transaksi, SUM(detail_pembelian.jumlah_beli) as total_barang, SUM(detail_pembelian.harga_beli * detail_pembelian.jumlah_beli) as subtotal');
            $builder->groupBy('DATE(pembelian.tanggal_pembelian)');
        } else {
            $builder->select('pembelian.*, pemasok.nama_pemasok, sparepart.nama_sparepart, detail_pembelian.harga_beli, detail_pembelian.jumlah_beli, (detail_pembelian.harga_beli * detail_pembelian.jumlah_beli) as subtotal');
        }

        // Filter pemasok jika dipilih
        if (!empty($pemasok_terpilih)) {
            $builder->where('pembelian.id_pemasok', $pemasok_terpilih);
        }

        // Filter berdasarkan periode
        if ($periode == 'hari') {
            if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                $builder->where('pembelian.tanggal_pembelian >=', $tanggal_mulai);
                $builder->where('pembelian.tanggal_pembelian <=', $tanggal_akhir);
            } elseif (!empty($tanggal_mulai)) {
                $builder->where('pembelian.tanggal_pembelian >=', $tanggal_mulai);
            } elseif (!empty($tanggal_akhir)) {
                $builder->where('pembelian.tanggal_pembelian <=', $tanggal_akhir);
            }
        } elseif ($periode == 'bulan') {
            if (!empty($bulan)) {
                $builder->where('MONTH(pembelian.tanggal_pembelian)', (int)$bulan);
            }
            if (!empty($tahun)) {
                $builder->where('YEAR(pembelian.tanggal_pembelian)', (int)$tahun);
            }
        } elseif ($periode == 'tahun') {
            if (!empty($tahun)) {
                $builder->where('YEAR(pembelian.tanggal_pembelian)', (int)$tahun);
            }
        }

        // Ambil data hasil filter
        $dataPembelian = $builder->get()->getResultArray();

        // Hitung total
        $total_keseluruhan = array_sum(array_column($dataPembelian, 'subtotal'));
        $total_pembelian = $total_keseluruhan;

        // Kirim data ke view
        $data = [
            'title' => 'Laporan Pembelian Sparepart',
            'username' => session()->get('nama') ?? $username,
            'dataPembelian' => $dataPembelian,
            'total_pembelian' => $total_pembelian,
            'total_keseluruhan' => $total_keseluruhan,
            'pemasok' => $pemasok,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'pemasok_terpilih' => $pemasok_terpilih,
            'periode' => $periode,
            'bulan' => $bulan ?? date('m'),
            'tahun' => $tahun ?? date('Y'),
        ];

        return view('Pembelian/laporan_pembelian', $data);
    }


}
