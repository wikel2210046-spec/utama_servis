<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Mpembayaran;
use App\Models\Mpemesanan;
use App\Models\MTransaksiServis;

class Pembayaran extends BaseController
{
    protected $pembayaranModel;
    protected $transaksiModel;

    protected $db;

    public function __construct()
    {
        $this->pembayaranModel = new Mpembayaran();
        $this->transaksiModel = new MTransaksiServis();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tombolCari = $this->request->getPost('tombolcari');
        $keyword = '';

        // 🔍 Tangani pencarian
        if (isset($tombolCari)) {
            $keyword = $this->request->getPost('caripembayaran');
            session()->set('caripembayaran', $keyword);
            return redirect()->to('/Pembayaran');
        } else {
            $keyword = session()->get('caripembayaran');
        }

        // 🔹 Query utama pembayaran
        $builder = $this->pembayaranModel
            ->select('
            pembayaran.*,
            transaksi_servis.tanggal_servis,
            pelanggan.nama_pelanggan,
            mobil.no_polisi,
            mobil.tipe,
            mobil.merk
        ')
            ->join('transaksi_servis', 'transaksi_servis.id_transaksi = pembayaran.id_transaksi', 'left')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->orderBy('pembayaran.tanggal_diambil', 'DESC');

        // 🔍 Filter pencarian
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('pelanggan.nama_pelanggan', $keyword)
                ->orLike('mobil.no_polisi', $keyword)
                ->orLike('mobil.tipe', $keyword)
                ->orLike('pembayaran.tanggal_diambil', $keyword)
                ->groupEnd();
        }

        // 📄 Pagination
        $noHalaman = $this->request->getVar('page_pembayaran') ? $this->request->getVar('page_pembayaran') : 1;

        // 🔹 Siapkan data ke view
        $data = [
            'judul' => 'Data Pembayaran',
            'pembayaran' => $builder->paginate(10, 'pembayaran'),
            'pager' => $this->pembayaranModel->pager,
            'keyword' => $keyword,
            'noHalaman' => $noHalaman
        ];

        return view('Pembayaran/Vpembayaran', $data);
    }

    public function formtambah()
    {
        // Ambil semua transaksi yang belum ada di tabel pembayaran
        $transaksiBelumDibayar = $this->transaksiModel
            ->select('
            transaksi_servis.id_transaksi,
            transaksi_servis.tanggal_servis,
            pemesanan.kode_pemesanan,
            mobil.no_polisi,
            mobil.tipe,
            pelanggan.nama_pelanggan,
            transaksi_servis.total_biaya
        ')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->whereNotIn('transaksi_servis.id_transaksi', function ($builder) {
                return $builder->select('id_transaksi')->from('pembayaran');
            })
            ->findAll();

        $data = [
            'judul' => 'Tambah Pembayaran',
            'transaksi' => $transaksiBelumDibayar
        ];

        // Kirimkan modal sebagai respon JSON
        $msg = [
            'data' => view('Pembayaran/formtambah', $data)
        ];

        return $this->response->setJSON($msg);
    }
    public function simpan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $post = $this->request->getPost();

        $data = [
            'id_transaksi' => $post['id_transaksi'] ?? null,
            'tanggal_diambil' => $post['tanggal_diambil'] ?? date('Y-m-d'),
            'total_bayar' => is_numeric($post['total_bayar'] ?? null) ? (float) $post['total_bayar'] : 0,
            'diskon' => is_numeric($post['diskon'] ?? null) ? (float) $post['diskon'] : 0,
        ];

        // validasi sederhana
        $errors = [];
        if (empty($data['id_transaksi'])) {
            $errors[] = 'ID transaksi wajib dipilih.';
        }
        if (empty($data['tanggal_diambil'])) {
            $errors[] = 'Tanggal bayar wajib diisi.';
        }
        if ($data['total_bayar'] <= 0) {
            $errors[] = 'Total bayar harus lebih dari 0.';
        }

        if (!empty($errors)) {
            return $this->response->setJSON(['error' => $errors]);
        }

        try {
            $inserted = $this->pembayaranModel->insert($data);
            if ($inserted === false) {
                $modelErrors = $this->pembayaranModel->errors();
                return $this->response->setJSON(['error' => $modelErrors ?: 'Gagal menyimpan data.']);
            }

            // =====================================================
            // UPDATE STATUS PEMESANAN MENJADI 'selesai'
            // =====================================================
            $transaksi = $this->transaksiModel->find($data['id_transaksi']);
            if ($transaksi && !empty($transaksi['id_pemesanan'])) {
                $this->db->table('pemesanan')
                    ->where('id_pemesanan', $transaksi['id_pemesanan'])
                    ->update(['status' => 'selesai']);
            }
            // =====================================================

            return $this->response->setJSON(['sukses' => 'Data pembayaran berhasil disimpan!']);
        } catch (\Exception $e) {
            log_message('error', 'Error simpan pembayaran: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Terjadi kesalahan pada server.']);
        }
    }


    public function getTransaksiData($id_transaksi)
    {
        $data = $this->transaksiModel
            ->select('
            transaksi_servis.id_transaksi,
            transaksi_servis.tanggal_servis,
            transaksi_servis.keluhan,
            transaksi_servis.total_biaya,
            pelanggan.nama_pelanggan,
            pelanggan.no_hp,
            mekanik.nama_mekanik,
            mobil.tipe,
            mobil.merk as merk,
            mobil.no_polisi,
            pemesanan.keluhan AS keluhan_pesan
        ')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->where('transaksi_servis.id_transaksi', $id_transaksi)
            ->first();

        return $this->response->setJSON($data);
    }
    public function getDetailServis($id_transaksi)
    {
        $jasa = $this->db->table('detail_jasa dj')
            ->select('
            dj.id_detail,
            js.nama_servis,
            js.harga_servis,
            NULL as nama_sparepart,
            NULL as harga_jual,
            1 as jumlah,
            dj.harga_js as subtotal
        ')
            ->join('jenis_servis js', 'js.id_servis = dj.id_servis', 'left')
            ->where('dj.id_transaksi', $id_transaksi)
            ->get()
            ->getResultArray();

        $sparepart = $this->db->table('detail_sparepart_servis dss')
            ->select('
            dss.id_detail,
            NULL as nama_servis,
            NULL as harga_servis,
            sp.nama_sparepart,
            sp.harga_jual,
            dss.jumlah_sp as jumlah,
            (dss.jumlah_sp * dss.harga_sp) as subtotal
        ')
            ->join('sparepart sp', 'sp.id_sparepart = dss.id_sparepart', 'left')
            ->where('dss.id_transaksi', $id_transaksi)
            ->get()
            ->getResultArray();

        return $this->response->setJSON(array_merge($jasa, $sparepart));
    }
    public function invoice($id_pembayaran)
    {
        // Ambil data pembayaran utama
        $pembayaran = $this->pembayaranModel
            ->select('
            pembayaran.*, 
            transaksi_servis.tanggal_servis,
            pelanggan.nama_pelanggan,
            pelanggan.no_hp,
            mekanik.nama_mekanik,
            mobil.tipe,
            pemesanan.kode_pemesanan,
            mobil.no_polisi
        ')
            ->join('transaksi_servis', 'transaksi_servis.id_transaksi = pembayaran.id_transaksi', 'left')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->where('pembayaran.id_pembayaran', $id_pembayaran)
            ->first();

        if (!$pembayaran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data pembayaran tidak ditemukan");
        }

        // Ambil detail jasa
        $jasa = $this->db->table('detail_jasa dj')
            ->select('dj.*, js.nama_servis, js.harga_servis')
            ->join('jenis_servis js', 'js.id_servis = dj.id_servis', 'left')
            ->where('dj.id_transaksi', $pembayaran['id_transaksi'])
            ->get()
            ->getResultArray();

        // Ambil detail sparepart
        $sparepart = $this->db->table('detail_sparepart_servis dss')
            ->select('dss.*, sp.nama_sparepart, sp.harga_jual')
            ->join('sparepart sp', 'sp.id_sparepart = dss.id_sparepart', 'left')
            ->where('dss.id_transaksi', $pembayaran['id_transaksi'])
            ->get()
            ->getResultArray();

        // Gabungkan untuk kemudahan looping di view
        $detail = [];
        foreach ($jasa as $j) {
            $detail[] = [
                'nama_servis' => $j['nama_servis'],
                'harga_servis' => $j['harga_servis'],
                'nama_sparepart' => null,
                'harga_jual' => null,
                'jumlah' => 1,
                'subtotal' => $j['harga_js']
            ];
        }
        foreach ($sparepart as $s) {
            $detail[] = [
                'nama_servis' => null,
                'harga_servis' => null,
                'nama_sparepart' => $s['nama_sparepart'],
                'harga_jual' => $s['harga_jual'],
                'jumlah' => $s['jumlah_sp'],
                'subtotal' => ($s['jumlah_sp'] * $s['harga_sp'])
            ];
        }

        $detailServis = [];
        $detailSparepart = [];

        foreach ($detail as $d) {
            if (!empty($d['nama_servis'])) {
                $detailServis[] = [
                    'nama_item' => $d['nama_servis'],
                    'jumlah' => 1,
                    'harga' => $d['harga_servis'],
                    'subtotal' => $d['harga_servis']
                ];
            }

            if (!empty($d['nama_sparepart'])) {
                $detailSparepart[] = [
                    'nama_item' => $d['nama_sparepart'],
                    'jumlah' => $d['jumlah'] ?? 1,
                    'harga' => $d['harga_jual'],
                    'subtotal' => ($d['harga_jual'] * ($d['jumlah'] ?? 1))
                ];
            }
        }


        $data = [
            'judul' => 'Invoice Servis',
            'transaksi' => [
                'tanggal_servis' => $pembayaran['tanggal_servis'],
                'tanggal_diambil' => $pembayaran['tanggal_diambil'],
                'nama_mekanik' => $pembayaran['nama_mekanik'],
                'nama_pelanggan' => $pembayaran['nama_pelanggan'],
                'tipe' => $pembayaran['tipe'],
                'kode_pemesanan' => $pembayaran['kode_pemesanan'],
                'no_polisi' => $pembayaran['no_polisi'],
                'diskon' => $pembayaran['diskon'],
                'total_bayar' => $pembayaran['total_bayar'],
            ],
            'detail' => $detail
        ];

        return view('Pembayaran/Vinvoice', $data);
    }

    public function laporan()
    {
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $periode = $this->request->getGet('periode');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $this->pembayaranModel
            ->join('transaksi_servis', 'transaksi_servis.id_transaksi = pembayaran.id_transaksi', 'left')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left');

        if ($periode == 'tahun') {
            $builder->select('MONTH(pembayaran.tanggal_diambil) as bulan, COUNT(pembayaran.id_pembayaran) as jumlah_transaksi, SUM(pembayaran.total_bayar) as total_bayar');
            $builder->groupBy('MONTH(pembayaran.tanggal_diambil)');
        } elseif ($periode == 'bulan') {
            $builder->select('DATE(pembayaran.tanggal_diambil) as tanggal, COUNT(pembayaran.id_pembayaran) as jumlah_transaksi, SUM(pembayaran.total_bayar) as total_bayar');
            $builder->groupBy('DATE(pembayaran.tanggal_diambil)');
        } else {
            $builder->select('pembayaran.*, transaksi_servis.tanggal_servis, transaksi_servis.total_biaya, pelanggan.nama_pelanggan, mobil.no_polisi, mobil.tipe, pemesanan.kode_pemesanan, mekanik.nama_mekanik');
        }

        if ($periode == 'hari') {
            if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                $builder->where('pembayaran.tanggal_diambil >=', $tanggal_mulai);
                $builder->where('pembayaran.tanggal_diambil <=', $tanggal_akhir);
            } elseif (!empty($tanggal_mulai)) {
                $builder->where('pembayaran.tanggal_diambil >=', $tanggal_mulai);
            } elseif (!empty($tanggal_akhir)) {
                $builder->where('pembayaran.tanggal_diambil <=', $tanggal_akhir);
            }
        } elseif ($periode == 'bulan') {
            if (!empty($bulan)) {
                $builder->where('MONTH(pembayaran.tanggal_diambil)', (int)$bulan);
            }
            if (!empty($tahun)) {
                $builder->where('YEAR(pembayaran.tanggal_diambil)', (int)$tahun);
            }
        } elseif ($periode == 'tahun') {
            if (!empty($tahun)) {
                $builder->where('YEAR(pembayaran.tanggal_diambil)', (int)$tahun);
            }
        }

        if ($periode !== 'tahun' && $periode !== 'bulan') {
            $builder->orderBy('pembayaran.tanggal_diambil', 'DESC');
        }

        $laporan = $builder->get()->getResultArray();

        $total_keseluruhan = 0;
        if ($periode == 'tahun' || $periode == 'bulan') {
            $total_keseluruhan = array_sum(array_column($laporan, 'total_bayar'));
        } else {
            $total_keseluruhan = array_sum(array_column($laporan, 'total_bayar'));
        }

        $data = [
            'judul' => 'Laporan Pembayaran Servis',
            'laporan' => $laporan,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'total_keseluruhan' => $total_keseluruhan,
            'username' => session()->get('nama'),
        ];

        return view('Pembayaran/Vlaporan_dataservis', $data);
    }
}
