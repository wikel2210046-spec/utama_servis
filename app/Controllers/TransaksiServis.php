<?php

namespace App\Controllers;

use App\Models\MTransaksiServis;
use App\Models\MDetailJasa;
use App\Models\MDetailSparepartServis;
use App\Models\Mpelanggan;
use App\Models\Mmekanik;
use App\Models\Mservis;
use App\Models\Msparepart;
use App\Models\Mpemesanan;
use CodeIgniter\Controller;

class TransaksiServis extends BaseController
{
    protected $transaksiModel;
    protected $detailJasaModel;
    protected $detailSparepartModel;
    protected $pelangganModel;
    protected $mekanikModel;
    protected $servisModel;
    protected $sparepartModel;
    protected $pemesananModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->transaksiModel = new MTransaksiServis();
        $this->detailJasaModel = new MDetailJasa();
        $this->detailSparepartModel = new MDetailSparepartServis();
        $this->pelangganModel = new Mpelanggan();
        $this->mekanikModel = new Mmekanik();
        $this->servisModel = new Mservis();
        $this->sparepartModel = new Msparepart();
        $this->pemesananModel = new Mpemesanan();

        helper(['form', 'url']);
    }
    public function index()
    {
        $tombolCari = $this->request->getPost('tombolcari');
        $keyword = '';

        // 🔍 Tangani pencarian
        if (isset($tombolCari)) {
            $keyword = $this->request->getPost('caritransaksi');
            session()->set('caritransaksi', $keyword);
            return redirect()->to('/TransaksiServis');
        } else {
            $keyword = session()->get('caritransaksi');
        }

        // 🔹 Bangun query utama transaksi
        $builder = $this->transaksiModel
            ->select('
            transaksi_servis.*, 
            pelanggan.nama_pelanggan, 
            mekanik.nama_mekanik, 
            mobil.no_polisi, 
            mobil.tipe,
            pemesanan.kode_pemesanan,
            pemesanan.status as status_pemesanan
        ')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->orderBy('transaksi_servis.id_transaksi', 'DESC');

        // 🔍 Filter berdasarkan kata kunci
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('pelanggan.nama_pelanggan', $keyword)
                ->orLike('mekanik.nama_mekanik', $keyword)
                ->orLike('mobil.no_polisi', $keyword)
                ->orLike('mobil.tipe', $keyword)
                ->orLike('transaksi_servis.tanggal_servis', $keyword)
                ->groupEnd();
        }

        // Pagination
        $noHalaman = $this->request->getVar('page_transaksi') ? $this->request->getVar('page_transaksi') : 1;

        // 🔹 Siapkan data untuk dikirim ke view
        $data = [
            'transaksi' => $builder->paginate(10, 'transaksi'),
            'pager' => $this->transaksiModel->pager,
            'keyword' => $keyword,
            'noHalaman' => $noHalaman,

            // Data lain tetap seperti semula
            'pemesanan' => $this->pemesananModel->where('status', 'pesan')->findAll(),
            'mekanik' => $this->mekanikModel->findAll(),
            'servis' => $this->servisModel->findAll(),
            'sparepart' => $this->sparepartModel->findAll(),
            'pelanggan' => $this->pelangganModel->findAll()
        ];

        return view('TransaksiServis/Vtransaksi', $data);
    }


    public function formtambah()
    {
        $data = [
            'pelanggan' => $this->pelangganModel->findAll(),
            'mekanik' => $this->mekanikModel->findAll(),
            'servis' => $this->servisModel->findAll(),
            'sparepart' => $this->sparepartModel->findAll(),
            'pemesanan' => $this->pemesananModel->where('status', 'pesan')->findAll()
        ];

        $msg = [
            'data' => view('TransaksiServis/tambahtransaksi', $data)
        ];
        echo json_encode($msg);
    }
    public function simpan()
    {
        $db = \Config\Database::connect();
        // Model sudah diinisialisasi di constructor, gunakan $this->...

        // Debug: log data POST yang diterima
        $post = $this->request->getPost();
        log_message('debug', 'TransaksiServis::simpan POST => ' . json_encode($post));

        // --- VALIDASI MANUAL ---
        $idPelanggan = $this->request->getPost('id_pelanggan');
        $idMekanik = $this->request->getPost('id_mekanik');
        $idServisList = $this->request->getPost('id_servis') ?? [];

        if (empty($idPelanggan)) {
            return redirect()->back()->withInput()->with('error', 'Data pelanggan wajib diisi.');
        }
        if (empty($idMekanik)) {
            return redirect()->back()->withInput()->with('error', 'Data mekanik wajib diisi.');
        }

        $hasServis = false;
        if (!empty($idServisList)) {
            foreach ($idServisList as $id_servis) {
                if (!empty($id_servis)) {
                    $hasServis = true;
                    break;
                }
            }
        }
        if (!$hasServis) {
            return redirect()->back()->withInput()->with('error', 'Jasa servis wajib diisi minimal satu.');
        }
        // --- END VALIDASI ---

        // Mulai transaksi DB
        $db->transStart();


        try {
            // Simpan data utama
            $dataTransaksi = [
                'id_pelanggan' => $this->request->getPost('id_pelanggan'),
                'id_mekanik' => $this->request->getPost('id_mekanik'),
                'id_pemesanan' => $this->request->getPost('id_pemesanan') ?: null,
                'tanggal_servis' => $this->request->getPost('tanggal_servis'),
                'keluhan' => $this->request->getPost('keluhan'),
                'total_biaya' => $this->request->getPost('total_biaya'),
            ];

            $ok = $this->transaksiModel->insert($dataTransaksi);
            if ($ok === false) {
                // Model validation/allowedFields error
                log_message('error', 'Insert transaksi error: ' . json_encode($this->transaksiModel->errors()));
                throw new \Exception('Gagal insert transaksi (model error).');
            }

            $idTransaksi = $this->transaksiModel->getInsertID();
            if (empty($idTransaksi)) {
                log_message('error', 'Insert transaksi returned empty insertID.');
                throw new \Exception('Gagal mendapatkan ID transaksi.');
            }

            // Update status pemesanan bila ada
            $idPemesanan = $this->request->getPost('id_pemesanan');
            if (!empty($idPemesanan)) {
                $this->pemesananModel->update($idPemesanan, ['status' => 'proses']);
            }

            // Ambil arrays detail
            $idServisList = $this->request->getPost('id_servis') ?? [];
            $hargaServisList = $this->request->getPost('harga_servis') ?? [];
            $idSparepartList = $this->request->getPost('id_sparepart') ?? [];
            $jumlahList = $this->request->getPost('jumlah') ?? [];
            $hargaList = $this->request->getPost('harga') ?? [];
            $subtotalList = $this->request->getPost('subtotal') ?? [];

            // Simpan semua servis (jika ada)
            if (!empty($idServisList)) {
                foreach ($idServisList as $i => $id_servis) {
                    if (empty($id_servis))
                        continue;

                    $harga = isset($hargaServisList[$i]) ? (float) $hargaServisList[$i] : 0;

                    $ok = $this->detailJasaModel->insert([
                        'id_transaksi' => $idTransaksi,
                        'id_servis' => $id_servis,
                        'harga_js' => $harga
                    ]);
                    if ($ok === false) {
                        log_message('error', 'Insert detail(jasa) error: ' . json_encode($this->detailJasaModel->errors()));
                        throw new \Exception('Gagal insert detail jasa.');
                    }
                }
            }

            // Simpan semua sparepart (jika ada)
            if (!empty($idSparepartList)) {
                foreach ($idSparepartList as $j => $id_sparepart) {
                    if (empty($id_sparepart))
                        continue;

                    $jumlah = isset($jumlahList[$j]) ? (int) $jumlahList[$j] : 1;
                    $harga = isset($hargaList[$j]) ? (float) $hargaList[$j] : 0;

                    $ok = $this->detailSparepartModel->insert([
                        'id_transaksi' => $idTransaksi,
                        'id_sparepart' => $id_sparepart,
                        'jumlah_sp' => $jumlah,
                        'harga_sp' => $harga
                    ]);
                    if ($ok === false) {
                        log_message('error', 'Insert detail(sparepart) error: ' . json_encode($this->detailSparepartModel->errors()));
                        throw new \Exception('Gagal insert detail sparepart.');
                    }

                    // Kurangi stok sparepart sesuai jumlah yang dipakai
                    $db->table('sparepart')
                        ->where('id_sparepart', $id_sparepart)
                        ->set('stok', 'stok - ' . (int) $jumlah, false)
                        ->update();
                }
            }


            // Commit transaksi
            $db->transComplete();

            if ($db->transStatus() === false) {
                // Tulis log DB error
                $dberr = $db->error();
                log_message('error', 'DB transaction failed: ' . json_encode($dberr));
                throw new \Exception('Transaksi DB gagal: ' . ($dberr['message'] ?? 'unknown'));
            }

            return redirect()->to(base_url('TransaksiServis'))->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Throwable $e) {
            // Rollback & log
            $db->transRollback();
            log_message('error', 'TransaksiServis::simpan exception => ' . $e->getMessage());
            // Untuk debugging development, tampilkan pesan (atau gunakan with() untuk user)
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function formedit()
    {
        $id = $this->request->getPost('id_transaksi');
        // Ambil data utama
        $transaksi = $this->transaksiModel
            ->select('
                transaksi_servis.*, 
                pelanggan.nama_pelanggan, pelanggan.no_hp,
                mekanik.nama_mekanik,
                mobil.no_polisi, mobil.tipe, mobil.warna, mobil.jenis as jenis_mobil, mobil.merk as merk_mobil,
                pemesanan.keluhan, pemesanan.kode_pemesanan
            ')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->where('transaksi_servis.id_transaksi', $id)
            ->first();

        // Ambil baris detail yang merupakan JASA SERVIS
        $servisDetail = $this->db->table('detail_jasa dj')
            ->select('dj.*, js.nama_servis, js.harga_servis')
            ->join('jenis_servis js', 'js.id_servis = dj.id_servis', 'left')
            ->where('dj.id_transaksi', $id)
            ->get()
            ->getResultArray();

        // Ambil baris detail yang merupakan SPAREPART
        $sparepartDetail = $this->db->table('detail_sparepart_servis dss')
            ->select('dss.*, sp.nama_sparepart, sp.harga_jual')
            ->join('sparepart sp', 'sp.id_sparepart = dss.id_sparepart', 'left')
            ->where('dss.id_transaksi', $id)
            ->get()
            ->getResultArray();

        $data = [
            'transaksi' => $transaksi,
            'servisDetail' => $servisDetail,
            'sparepartDetail' => $sparepartDetail,
            'pelanggan' => $this->pelangganModel->findAll(),
            'mekanik' => $this->mekanikModel->findAll(),
            'servis' => $this->servisModel->findAll(),
            'sparepart' => $this->sparepartModel->findAll(),
            'pemesanan' => $this->pemesananModel->where('status', 'pesan')->findAll()
        ];

        $msg = [
            'data' => view('TransaksiServis/VeditTransaksi', $data)
        ];
        return $this->response->setJSON($msg);
    }

    public function update()
    {
        $db = \Config\Database::connect();
        $idTransaksi = $this->request->getPost('id_transaksi');

        // --- VALIDASI MANUAL ---
        $idPelanggan = $this->request->getPost('id_pelanggan');
        $idMekanik = $this->request->getPost('id_mekanik');
        $idServisList = $this->request->getPost('id_servis') ?? [];

        if (empty($idPelanggan)) {
            return redirect()->back()->with('error', 'Data pelanggan wajib diisi.');
        }
        if (empty($idMekanik)) {
            return redirect()->back()->with('error', 'Data mekanik wajib diisi.');
        }

        $hasServis = false;
        if (!empty($idServisList)) {
            foreach ($idServisList as $id_servis) {
                if (!empty($id_servis)) {
                    $hasServis = true;
                    break;
                }
            }
        }
        if (!$hasServis) {
            return redirect()->back()->with('error', 'Jasa servis wajib diisi minimal satu.');
        }
        // --- END VALIDASI ---

        $db->transStart();

        try {
            // Update data utama
            $dataTransaksi = [
                'id_pelanggan' => $this->request->getPost('id_pelanggan'),
                'id_mekanik' => $this->request->getPost('id_mekanik'),
                'tanggal_servis' => $this->request->getPost('tanggal_servis'),
                'keluhan' => $this->request->getPost('keluhan'),
                'total_biaya' => $this->request->getPost('total_biaya'),
            ];

            $this->transaksiModel->update($idTransaksi, $dataTransaksi);

            // ================== RESTORE STOK SPAREPART LAMA ==================
            // Ambil semua sparepart lama
            $oldSpareparts = $this->db->table('detail_sparepart_servis')
                ->where('id_transaksi', $idTransaksi)
                ->get()
                ->getResultArray();

            foreach ($oldSpareparts as $old) {
                // Kembalikan stok lama
                $db->table('sparepart')
                    ->where('id_sparepart', $old['id_sparepart'])
                    ->set('stok', 'stok + ' . (int) $old['jumlah_sp'], false)
                    ->update();
            }

            // Hapus detail lama
            $this->db->table('detail_jasa')->where('id_transaksi', $idTransaksi)->delete();
            $this->db->table('detail_sparepart_servis')->where('id_transaksi', $idTransaksi)->delete();

            // ================== INSERT DETAIL BARU & POTONG STOK ==================
            // Ambil arrays detail baru
            $idServisList = $this->request->getPost('id_servis') ?? [];
            $hargaServisList = $this->request->getPost('harga_servis') ?? [];
            $idSparepartList = $this->request->getPost('id_sparepart') ?? [];
            $jumlahList = $this->request->getPost('jumlah') ?? [];
            $hargaList = $this->request->getPost('harga') ?? [];

            // Simpan semua servis (jika ada)
            if (!empty($idServisList)) {
                foreach ($idServisList as $i => $id_servis) {
                    if (empty($id_servis))
                        continue;
                    $harga = isset($hargaServisList[$i]) ? (float) $hargaServisList[$i] : 0;
                    $this->detailJasaModel->insert([
                        'id_transaksi' => $idTransaksi,
                        'id_servis' => $id_servis,
                        'harga_js' => $harga
                    ]);
                }
            }

            // Simpan semua sparepart (jika ada) dan potong stok
            if (!empty($idSparepartList)) {
                foreach ($idSparepartList as $j => $id_sparepart) {
                    if (empty($id_sparepart))
                        continue;
                    $jumlah = isset($jumlahList[$j]) ? (int) $jumlahList[$j] : 1;
                    $harga = isset($hargaList[$j]) ? (float) $hargaList[$j] : 0;

                    $this->detailSparepartModel->insert([
                        'id_transaksi' => $idTransaksi,
                        'id_sparepart' => $id_sparepart,
                        'jumlah_sp' => $jumlah,
                        'harga_sp' => $harga
                    ]);

                    // Kurangi stok sparepart sesuai jumlah yang dipakai
                    $db->table('sparepart')
                        ->where('id_sparepart', $id_sparepart)
                        ->set('stok', 'stok - ' . (int) $jumlah, false)
                        ->update();
                }
            }

            // Commit transaksi
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaksi DB gagal');
            }

            return redirect()->to(base_url('TransaksiServis'))->with('success', 'Transaksi berhasil diupdate!');

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal update transaksi: ' . $e->getMessage());
        }
    }


    public function getPemesananByPelanggan($id_pelanggan)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pemesanan p');
        $builder->select('p.*, pl.no_hp, k.no_polisi, k.merk, k.tipe, k.jenis as jenis_mobil, k.warna');
        $builder->join('pelanggan pl', 'pl.id_pelanggan = p.id_pelanggan', 'left');
        $builder->join('mobil k', 'k.id_mobil = p.id_mobil', 'left');
        $builder->where('p.id_pelanggan', $id_pelanggan);
        $builder->orderBy('p.id_pemesanan', 'DESC');
        $builder->limit(1);
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $this->response->setJSON([
                'ada_pemesanan' => true,
                'data' => $query->getRowArray()
            ]);
        } else {
            return $this->response->setJSON(['ada_pemesanan' => false]);
        }
    }
    public function getPelangganById($id_pelanggan)
    {
        // Cek apakah parameter ID dikirim
        if (!$id_pelanggan) {
            return $this->response->setJSON(['error' => 'ID pelanggan tidak ditemukan']);
        }

        // Ambil data pelanggan dari model
        $pelanggan = $this->pelangganModel->find($id_pelanggan);

        if ($pelanggan) {
            return $this->response->setJSON([
                'id_pelanggan' => $pelanggan['id_pelanggan'],
                'nama_pelanggan' => $pelanggan['nama_pelanggan'],
                'no_hp' => $pelanggan['no_hp'],
                'alamat' => $pelanggan['alamat'] ?? ''
            ]);
        } else {
            return $this->response->setJSON([
                'error' => 'Data pelanggan tidak ditemukan'
            ]);
        }
    }
    public function getPelangganDenganPemesanan()
    {
        $db = \Config\Database::connect();
        $q = $this->request->getGet('q');

        $builder = $db->table('pemesanan p');
        $builder->select('
        p.id_pemesanan,
        p.kode_pemesanan,
        p.id_pelanggan,
        pl.nama_pelanggan,
        pl.no_hp,
        k.no_polisi,
        k.merk,
        k.tipe,
        k.jenis as jenis_mobil,
        k.warna,
        p.tanggal_servis,
        p.keluhan
    ');
        $builder->join('pelanggan pl', 'pl.id_pelanggan = p.id_pelanggan', 'left');
        $builder->join('mobil k', 'k.id_mobil = p.id_mobil', 'left');
        $builder->where('p.status', 'pesan');
        // ❗ Kecualikan pemesanan yang sudah ada di transaksi_servis
        $builder->whereNotIn('p.id_pemesanan', function ($subQuery) {
            return $subQuery->select('id_pemesanan')
                ->from('transaksi_servis')
                ->where('id_pemesanan IS NOT NULL');
        });

        if ($q) {
            $builder->groupStart()
                ->like('pl.nama_pelanggan', $q)
                ->orLike('pl.no_hp', $q)
                ->orLike('k.no_polisi', $q)
                ->orLike('k.jenis', $q)
                ->groupEnd();
        }

        $builder->orderBy('p.id_pemesanan', 'DESC');
        $data = $builder->get()->getResultArray();

        return $this->response->setJSON($data);
    }

    // Method untuk modal cari mekanik
    public function getMekanik()
    {
        $q = $this->request->getGet('q');

        $builder = $this->mekanikModel;

        if ($q) {
            $builder = $builder->like('nama_mekanik', $q);
        }

        $data = $builder->findAll();
        return $this->response->setJSON($data);
    }

    // Method untuk modal cari servis
    public function getServis()
    {
        $q = $this->request->getGet('q');

        $builder = $this->servisModel;

        if ($q) {
            $builder = $builder->like('nama_servis', $q);
        }

        $data = $builder->findAll();
        return $this->response->setJSON($data);
    }

    // Method untuk modal cari sparepart
    public function getSparepart()
    {
        $q = $this->request->getGet('q');

        $builder = $this->sparepartModel;

        if ($q) {
            $builder = $builder->like('nama_sparepart', $q);
        }

        $data = $builder->findAll();
        return $this->response->setJSON($data);
    }


    public function detail($id)
    {
        // Ambil data transaksi + pelanggan + pemesanan + mekanik
        $transaksi = $this->transaksiModel
            ->select('
            transaksi_servis.*, 
            pelanggan.nama_pelanggan, pelanggan.no_hp, pelanggan.alamat,
            mobil.no_polisi, mobil.tipe, mobil.warna as warna_mobil, pemesanan.keluhan,
            mekanik.nama_mekanik
        ')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->where('transaksi_servis.id_transaksi', $id)
            ->first();

        if (!$transaksi) {
            // Jika tidak ditemukan, redirect atau tampilkan pesan
            return redirect()->to(base_url('TransaksiServis'))->with('error', 'Data transaksi tidak ditemukan.');
        }

        // Ambil baris detail yang merupakan JASA SERVIS
        $servis = $this->db->table('detail_jasa dj')
            ->select('dj.*, js.nama_servis, js.harga_servis')
            ->join('jenis_servis js', 'js.id_servis = dj.id_servis', 'left')
            ->where('dj.id_transaksi', $id)
            ->get()
            ->getResultArray();

        // Ambil baris detail yang merupakan SPAREPART
        $sparepart = $this->db->table('detail_sparepart_servis dss')
            ->select('dss.*, sp.nama_sparepart, sp.harga_jual')
            ->join('sparepart sp', 'sp.id_sparepart = dss.id_sparepart', 'left')
            ->where('dss.id_transaksi', $id)
            ->get()
            ->getResultArray();

        $data = [
            'transaksi' => $transaksi,
            'servis' => $servis,
            'sparepart' => $sparepart
        ];

        return view('TransaksiServis/Vdetailtransaksi', $data);
    }

    public function cetakSpk($id)
    {
        // Ambil data transaksi + pelanggan + pemesanan + mekanik
        $transaksi = $this->transaksiModel
            ->select('
            transaksi_servis.*, 
            pelanggan.nama_pelanggan, pelanggan.no_hp, pelanggan.alamat,
            mobil.no_polisi, mobil.tipe, mobil.warna as warna_mobil, pemesanan.keluhan,
            mekanik.nama_mekanik
        ')
            ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan', 'left')
            ->join('pemesanan', 'pemesanan.id_pemesanan = transaksi_servis.id_pemesanan', 'left')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->where('transaksi_servis.id_transaksi', $id)
            ->first();

        if (!$transaksi) {
            return redirect()->to(base_url('TransaksiServis'))->with('error', 'Data transaksi tidak ditemukan.');
        }

        // Ambil baris detail yang merupakan JASA SERVIS
        $servis = $this->db->table('detail_jasa dj')
            ->select('dj.*, js.nama_servis, js.harga_servis')
            ->join('jenis_servis js', 'js.id_servis = dj.id_servis', 'left')
            ->where('dj.id_transaksi', $id)
            ->get()
            ->getResultArray();

        // Ambil baris detail yang merupakan SPAREPART
        $sparepart = $this->db->table('detail_sparepart_servis dss')
            ->select('dss.*, sp.nama_sparepart, sp.harga_jual')
            ->join('sparepart sp', 'sp.id_sparepart = dss.id_sparepart', 'left')
            ->where('dss.id_transaksi', $id)
            ->get()
            ->getResultArray();

        $data = [
            'transaksi' => $transaksi,
            'servis' => $servis,
            'sparepart' => $sparepart
        ];

        return view('TransaksiServis/Vcetakspk', $data);
    }

    public function selesaiServis()
    {
        if ($this->request->isAJAX()) {
            $idTransaksi = $this->request->getPost('id_transaksi');

            // Ambil data transaksi untuk mendapatkan id_pemesanan
            $transaksi = $this->transaksiModel->find($idTransaksi);

            if (!$transaksi) {
                return $this->response->setJSON(['error' => 'Data transaksi tidak ditemukan.']);
            }

            $idPemesanan = $transaksi['id_pemesanan'];

            if (empty($idPemesanan)) {
                return $this->response->setJSON(['error' => 'Transaksi ini tidak memiliki data pemesanan.']);
            }

            // Update status pemesanan menjadi 'selesai servis'
            $this->pemesananModel->update($idPemesanan, ['status' => 'selesai servis']);

            return $this->response->setJSON(['sukses' => 'Status servis berhasil diubah menjadi Selesai Servis.']);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Data transaksi yang sudah masuk tidak dapat dihapus.']);
        }
    }

    private function hitungTotal($dataTransaksi)
    {
        $total = 0;
        foreach ($dataTransaksi as $row) {
            $total += $row['subtotal'];
        }
        return $total;
    }
}
