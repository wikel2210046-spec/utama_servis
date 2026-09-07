<?php

namespace App\Controllers;

use App\Models\Mpemesanan;
use App\Models\Mpelanggan;
use App\Models\Mmobil;
use CodeIgniter\Controller;

class Pemesanan extends BaseController
{
    protected $pemesananModel;
    protected $pelangganModel;
    protected $mobilModel;

    public function __construct()
    {
        $this->pemesananModel = new Mpemesanan();
        $this->pelangganModel = new Mpelanggan();
        $this->mobilModel = new Mmobil();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Ambil data dari form pencarian
        $tombolCari = $this->request->getPost('tombolPemesanan');

        if (isset($tombolCari)) {
            $cari = $this->request->getPost('caripemesanan');
            session()->set('caripemesanan', $cari);
            return redirect()->to('/Pemesanan/index');
        } else {
            $cari = session()->get('caripemesanan');
        }

        // Ambil data pemesanan berdasarkan pencarian
        if ($cari) {
            $Pemesanan = $this->pemesananModel
                ->select('pemesanan.*, pelanggan.nama_pelanggan, pelanggan.no_hp, mobil.no_polisi, mobil.merk, mobil.tipe, mobil.warna')
                ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan')
                ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
                ->groupStart()
                    ->like('pelanggan.nama_pelanggan', $cari)
                    ->orLike('pemesanan.kode_pemesanan', $cari)
                    ->orLike('mobil.no_polisi', $cari)
                ->groupEnd()
                ->orderBy('pemesanan.id_pemesanan', 'DESC');
        } else {
            $Pemesanan = $this->pemesananModel
                ->select('pemesanan.*, pelanggan.nama_pelanggan, pelanggan.no_hp, mobil.no_polisi, mobil.merk, mobil.tipe, mobil.warna')
                ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan')
                ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
                ->orderBy('pemesanan.id_pemesanan', 'DESC');
        }

        $noHalaman = $this->request->getVar('page_pemesanan') ? $this->request->getVar('page_pemesanan') : 1;

        // Kirimkan data ke view
        $data = [
            'pemesanan' => $Pemesanan->paginate(10, 'pemesanan'),
            'pager' => $this->pemesananModel->pager,
            'cari' => $cari,
            'noHalaman' => $noHalaman
        ];

        return view('Pemesanan/Vpemesanan', $data);
    }

    public function formTambah()
    {
        $data = [
            'title' => 'Tambah Data Pemesanan',
            'pelanggan' => $this->pelangganModel->findAll()
        ];

        return $this->response->setJSON([
            'data' => view('Pemesanan/VtambahPemesanan', $data)
        ]);
    }

    // AJAX: ambil daftar mobil milik pelanggan tertentu
    public function getMobilPelanggan()
    {
        $id_pelanggan = $this->request->getGet('id_pelanggan');
        if (!$id_pelanggan) {
            return $this->response->setJSON([]);
        }
        $data = $this->mobilModel->where('id_pelanggan', $id_pelanggan)->findAll();
        return $this->response->setJSON($data);
    }
    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $tanggal_servis = $this->request->getPost('tanggal_servis');
            $jam_servis = $this->request->getPost('jam_servis');
            $id_mobil = $this->request->getPost('id_mobil');
            $keluhan = $this->request->getPost('keluhan');
            $id_pelanggan = $this->request->getPost('id_pelanggan');

            if (empty($id_pelanggan) || empty($tanggal_servis) || empty($jam_servis) || empty($id_mobil) || empty($keluhan)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Semua Field wajib diisi!'
                ]);
            }

            if ($id_mobil === 'baru') {
                $no_polisi = trim($this->request->getPost('no_polisi'));
                $merk = trim($this->request->getPost('merk'));
                $tipe = trim($this->request->getPost('tipe'));
                $jenis = trim($this->request->getPost('jenis'));
                $warna = trim($this->request->getPost('warna'));

                if (empty($no_polisi) || empty($jenis) || empty($warna)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No Polisi, Jenis Mobil dan Warna wajib diisi untuk mobil baru!'
                    ]);
                }

                // Cek apakah No Polisi mobil ini sudah terdaftar
                $mobilExisting = $this->mobilModel->where('no_polisi', $no_polisi)->first();
                if ($mobilExisting) {
                    if ($mobilExisting['id_pelanggan'] == $id_pelanggan) {
                        $id_mobil = $mobilExisting['id_mobil'];
                    } else {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Nomor Polisi ' . $no_polisi . ' sudah terdaftar untuk pelanggan lain!'
                        ]);
                    }
                } else {
                    $this->mobilModel->insert([
                        'id_pelanggan' => $id_pelanggan,
                        'no_polisi'    => $no_polisi,
                        'merk'         => $merk,
                        'tipe'         => $tipe,
                        'jenis'        => $jenis,
                        'warna'        => $warna
                    ]);
                    $id_mobil = $this->mobilModel->getInsertID();
                }
            }

            $last = $this->pemesananModel
                ->like('kode_pemesanan', 'USSP-' . date('Ymd'), 'after')
                ->orderBy('kode_pemesanan', 'DESC')
                ->first();

            $no = $last ? (int) substr($last['kode_pemesanan'], -3) + 1 : 1;
            $kodePemesanan = 'USSP-' . date('Ymd') . '-' . str_pad($no, 3, '0', STR_PAD_LEFT);

            // Kapasitas teknisi (misal 3 mobil per slot)
            $kapasitasTeknisi = 3;

            // Hitung jumlah pemesanan di slot tanggal + jam
            $jumlahSlot = $this->pemesananModel
                ->where('tanggal_servis', $tanggal_servis)
                ->where('jam_servis', $jam_servis)
                ->countAllResults();

            // Admin bebas bypass limit, selain admin dibatasi
            if (session()->get('level') !== 'admin' && $jumlahSlot >= $kapasitasTeknisi) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Slot waktu ini sudah penuh. Silakan pilih waktu lain.'
                ]);
            }


            // Cek mobil sama tidak double booking di jam yang sama
            $mobilDouble = $this->pemesananModel
                ->where('id_mobil', $id_mobil)
                ->where('tanggal_servis', $tanggal_servis)
                ->where('jam_servis', $jam_servis)
                ->first();

            if ($mobilDouble) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Mobil dengan nomor polisi ini sudah dipesan pada waktu yang sama.'
                ]);
            }

            // Cek mobil masih dalam pengerjaan (status pesan atau proses)
            $mobilSedangDikerjakan = $this->pemesananModel
                ->where('id_mobil', $id_mobil)
                ->whereIn('status', ['pesan', 'proses'])
                ->first();

            if ($mobilSedangDikerjakan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Mobil ini masih dalam pengerjaan di bengkel. Tidak bisa melakukan pemesanan baru sebelum selesai.'
                ]);
            }

            // Simpan pemesanan
            $this->pemesananModel->insert([
                'id_pelanggan' => $id_pelanggan,
                'tanggal_servis' => $tanggal_servis,
                'jam_servis' => $jam_servis,
                'id_mobil' => $id_mobil,
                'keluhan' => $keluhan,
                'status' => 'pesan',
                'kode_pemesanan' => $kodePemesanan
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data pemesanan berhasil disimpan!',
                'kode_pemesanan' => $kodePemesanan
            ]);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_pemesanan = $this->request->getVar('id_pemesanan');

            if (!$id_pemesanan) {
                return $this->response->setJSON(['error' => 'ID pemesanan tidak ditemukan.']);
            }

            try {
                // Cek status dulu
                $pemesanan = $this->pemesananModel->find($id_pemesanan);
                if (!$pemesanan) {
                    return $this->response->setJSON(['error' => 'Data pemesanan tidak ditemukan.']);
                }

                if ($pemesanan['status'] !== 'pesan') {
                    return $this->response->setJSON(['error' => 'Data tidak bisa dihapus karena status sudah ' . $pemesanan['status'] . '.']);
                }

                $db = \Config\Database::connect();
                $db->transStart();

                // Lepas kaitan di transaksi_servis jika ada (sebagai jaga-jaga)
                $db->table('transaksi_servis')
                    ->where('id_pemesanan', $id_pemesanan)
                    ->update(['id_pemesanan' => null]);

                // Hapus data pemesanan
                $this->pemesananModel->delete($id_pemesanan);

                $db->transComplete();

                if ($db->transStatus() === false) {
                    return $this->response->setJSON(['error' => 'Gagal menghapus data di database.']);
                }

                return $this->response->setJSON(['sukses' => 'Data Pemesanan berhasil dihapus!']);

            } catch (\Exception $e) {
                return $this->response->setJSON(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        }
    }


    public function ubahStatus($id_pemesanan, $status)
    {
        if (in_array($status, ['pesan', 'proses', 'selesai'])) {
            $this->pemesananModel->updateStatus($id_pemesanan, $status);

            session()->setFlashdata('success', 'Status berhasil diubah menjadi ' . ucfirst($status));
        } else {
            session()->setFlashdata('error', 'Status tidak valid');
        }

        return redirect()->to(base_url('Pemesanan'));
    }

    public function laporan()
    {
        $data = [
            'title' => 'Laporan Data Pemesanan',
            'pemesanan' => $this->pemesananModel->getAllPemesanan(),
            'username' => session()->get('nama'),
            'tanggal_mulai' => '',
            'tanggal_akhir' => '',
            'periode' => '',
            'bulan' => date('m'),
            'tahun' => date('Y'),
            'total_booking' => count($this->pemesananModel->getAllPemesanan())
        ];

        return view('Pemesanan/laporanbooking', $data);
    }

    public function filterLaporan()
    {
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $periode = $this->request->getGet('periode');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $this->pemesananModel->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');

        if ($periode == 'tahun') {
            $builder->select('MONTH(pemesanan.tanggal_servis) as bulan, COUNT(pemesanan.id_pemesanan) as jumlah_booking');
            $builder->groupBy('MONTH(pemesanan.tanggal_servis)');
        } elseif ($periode == 'bulan') {
            $builder->select('DATE(pemesanan.tanggal_servis) as tanggal, COUNT(pemesanan.id_pemesanan) as jumlah_booking');
            $builder->groupBy('DATE(pemesanan.tanggal_servis)');
        } else {
            $builder->select('pemesanan.*, pelanggan.nama_pelanggan, pelanggan.no_hp, mobil.no_polisi, mobil.merk, mobil.tipe, mobil.warna');
        }

        if ($periode == 'hari') {
            if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                $builder->where('pemesanan.tanggal_servis >=', $tanggal_mulai);
                $builder->where('pemesanan.tanggal_servis <=', $tanggal_akhir);
            } elseif (!empty($tanggal_mulai)) {
                $builder->where('pemesanan.tanggal_servis >=', $tanggal_mulai);
            } elseif (!empty($tanggal_akhir)) {
                $builder->where('pemesanan.tanggal_servis <=', $tanggal_akhir);
            }
        } elseif ($periode == 'bulan') {
            if (!empty($bulan)) {
                $builder->where('MONTH(pemesanan.tanggal_servis)', (int)$bulan);
            }
            if (!empty($tahun)) {
                $builder->where('YEAR(pemesanan.tanggal_servis)', (int)$tahun);
            }
        } elseif ($periode == 'tahun') {
            if (!empty($tahun)) {
                $builder->where('YEAR(pemesanan.tanggal_servis)', (int)$tahun);
            }
        }

        $pemesanan = $builder->get()->getResultArray();

        $total_booking = 0;
        if ($periode == 'tahun' || $periode == 'bulan') {
            $total_booking = array_sum(array_column($pemesanan, 'jumlah_booking'));
        } else {
            $total_booking = count($pemesanan);
        }

        $data = [
            'title' => 'Laporan Data Pemesanan',
            'username' => session()->get('nama'),
            'pemesanan' => $pemesanan,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'total_booking' => $total_booking
        ];

        return view('Pemesanan/laporanbooking', $data);
    }
}
